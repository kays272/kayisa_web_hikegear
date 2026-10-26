<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['payment', 'shipment'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
        }

        $order->load([
            'items.product',
            'payment',
            'shipment',
            'address',
        ]);

        return view('orders.show', compact('order'));
    }

    
    public function requestCancellation(\Illuminate\Http\Request $request, \App\Models\Order $order)
    {
        // Pastikan pesanan milik pengguna yang sedang login.
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ], [
            'cancellation_reason.required' => 'Alasan pembatalan wajib diisi.',
            'cancellation_reason.max' => 'Alasan maksimal 1000 karakter.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $validated) {
            $lockedOrder = \App\Models\Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->user_id !== auth()->id()) {
                abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
            }

            $allowedStatuses = [
                'pending_payment',
                'waiting_verification',
                'payment_verified',
                'processing',
            ];

            if (!in_array($lockedOrder->order_status, $allowedStatuses, true)) {
                abort(422, 'Pesanan ini sudah tidak dapat diajukan untuk pembatalan.');
            }

            if (in_array($lockedOrder->cancellation_status, ['pending', 'approved'], true)) {
                abort(422, 'Pengajuan pembatalan sudah dikirim atau disetujui.');
            }

            $lockedOrder->update([
                'cancellation_reason' => $validated['cancellation_reason'],
                'cancellation_status' => 'pending',
            ]);
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pengajuan pembatalan berhasil dikirim. Silakan tunggu keputusan admin.');
    }

}