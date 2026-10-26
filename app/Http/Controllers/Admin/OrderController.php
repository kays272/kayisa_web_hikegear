<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shipment']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter khusus untuk pengajuan pembatalan.
        if ($request->filled('cancellation_status')) {
            $query->where(
                'cancellation_status',
                $request->cancellation_status
            );
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment', 'shipment']);

        return view('admin.orders.show', compact('order'));
    }

    public function process(Order $order)
    {
        $updated = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->cancellation_status === 'pending') {
                return false;
            }

            if ($lockedOrder->order_status !== 'payment_verified') {
                return false;
            }

            $lockedOrder->update([
                'order_status' => 'processing',
            ]);

            return true;
        });

        if (!$updated) {
            return back()->with(
                'error',
                'Pesanan tidak dapat diproses. Periksa status pesanan dan pengajuan pembatalannya.'
            );
        }

        return back()->with('success', 'Pesanan berhasil diproses.');
    }

    public function ship(Request $request, Order $order)
    {
        $validated = $request->validate([
            'tracking_number' => ['required', 'string', 'max:100'],
        ]);

        $updated = DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $lockedOrder->cancellation_status === 'pending'
                || $lockedOrder->order_status !== 'processing'
            ) {
                return false;
            }

            $shipment = $lockedOrder->shipment;

            if (!$shipment) {
                abort(422, 'Data pengiriman tidak ditemukan.');
            }

            $shipment->update([
                'tracking_number' => $validated['tracking_number'],
                'status' => 'shipped',
                'shipped_at' => now(),
            ]);

            $lockedOrder->update([
                'order_status' => 'shipped',
            ]);

            return true;
        });

        if (!$updated) {
            return back()->with(
                'error',
                'Pesanan tidak dapat dikirim. Periksa status pesanan dan pengajuan pembatalannya.'
            );
        }

        return back()->with('success', 'Pesanan berhasil dikirim.');
    }

    public function complete(Order $order)
    {
        $updated = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $lockedOrder->cancellation_status === 'pending'
                || $lockedOrder->order_status !== 'shipped'
            ) {
                return false;
            }

            $shipment = $lockedOrder->shipment;

            if (!$shipment || $shipment->status !== 'shipped') {
                abort(422, 'Status pengiriman tidak sesuai.');
            }

            $shipment->update([
                'status' => 'delivered',
                'delivered_at' => now(),
            ]);

            $lockedOrder->update([
                'order_status' => 'completed',
            ]);

            return true;
        });

        if (!$updated) {
            return back()->with(
                'error',
                'Pesanan tidak dapat diselesaikan. Periksa status pesanan dan pengajuan pembatalannya.'
            );
        }

        return back()->with('success', 'Pesanan berhasil diselesaikan.');
    }

    /**
     * Menyetujui pengajuan pembatalan pesanan.
     */
    public function approveCancellation(Order $order)
    {
        $result = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->cancellation_status !== 'pending') {
                return 'invalid_request';
            }

            $allowedStatuses = [
                'pending_payment',
                'waiting_verification',
                'payment_verified',
                'processing',
            ];

            if (!in_array($lockedOrder->order_status, $allowedStatuses, true)) {
                return 'invalid_order_status';
            }

            // Kunci item pesanan agar stok tidak dikembalikan dua kali.
            $items = $lockedOrder->items()
                ->lockForUpdate()
                ->get();

            foreach ($items as $item) {
                $product = \App\Models\Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \RuntimeException(
                        'Produk pesanan tidak ditemukan. Pembatalan dibatalkan.'
                    );
                }

                $product->increment('stock', $item->quantity);
            }

            $lockedOrder->update([
                'order_status' => 'cancelled',
                'cancellation_status' => 'approved',
                'cancelled_at' => now(),
            ]);

            return 'approved';
        });

        if ($result === 'invalid_request') {
            return back()->with(
                'error',
                'Pengajuan ini tidak ada atau sudah diproses sebelumnya.'
            );
        }

        if ($result === 'invalid_order_status') {
            return back()->with(
                'error',
                'Pesanan sudah tidak memenuhi syarat untuk dibatalkan.'
            );
        }

        $message = 'Pembatalan disetujui dan stok produk berhasil dikembalikan.';

        if ($order->payment_status === 'verified') {
            $message .= ' Pembayaran sudah terverifikasi; refund perlu ditangani secara manual.';
        }

        return back()->with('success', $message);
    }

    /**
     * Menolak pengajuan pembatalan pesanan.
     */
    public function rejectCancellation(Request $request, Order $order)
    {
        $validated = $request->validate([
            'admin_cancellation_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $updated = DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->cancellation_status !== 'pending') {
                return false;
            }

            $reason = $lockedOrder->cancellation_reason ?? '';

            if (!empty($validated['admin_cancellation_note'])) {
                $reason .= "\n\nCatatan admin: "
                    . $validated['admin_cancellation_note'];
            }

            $lockedOrder->update([
                'cancellation_status' => 'rejected',
                'cancellation_reason' => $reason,
            ]);

            return true;
        });

        if (!$updated) {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }

        return back()->with(
            'success',
            'Pengajuan pembatalan ditolak. Status pesanan dan stok tidak diubah.'
        );
    }
}
