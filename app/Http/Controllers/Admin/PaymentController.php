<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran.
     */
    public function index()
    {
        $payments = Payment::with(['order.user'])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Menampilkan detail pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'order.user',
            'order.items',
            'order.address',
        ]);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Verifikasi pembayaran.
     */
    public function verify(Payment $payment)
    {
        $result = DB::transaction(function () use ($payment) {
            $lockedPayment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $order = Order::whereKey($lockedPayment->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status === 'verified') {
                return 'already_verified';
            }

            if ($lockedPayment->method === 'cod') {
                return 'cod';
            }

            if (!$lockedPayment->proof) {
                return 'no_proof';
            }

            if (
                $lockedPayment->status !== 'pending' ||
                $order->order_status !== 'waiting_verification' ||
                $order->payment_status !== 'waiting_verification'
            ) {
                return 'invalid_status';
            }

            $lockedPayment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            $order->update([
                'payment_status' => 'verified',
                'order_status' => 'payment_verified',
            ]);

            return 'success';
        });

        $messages = [
            'already_verified' => [
                'error',
                'Pembayaran ini sudah diverifikasi.',
            ],
            'cod' => [
                'error',
                'Pembayaran COD tidak perlu diverifikasi.',
            ],
            'no_proof' => [
                'error',
                'Bukti pembayaran belum diupload.',
            ],
            'invalid_status' => [
                'error',
                'Status pembayaran atau pesanan tidak sesuai.',
            ],
            'success' => [
                'success',
                'Pembayaran berhasil diverifikasi.',
            ],
        ];

        [$type, $message] = $messages[$result];

        return back()->with($type, $message);
    }

    /**
     * Menolak pembayaran.
     */
    public function reject(Request $request, Payment $payment)
    {
        $result = DB::transaction(function () use ($payment) {
            $lockedPayment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $order = Order::whereKey($lockedPayment->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status === 'verified') {
                return 'already_verified';
            }

            if ($lockedPayment->method === 'cod') {
                return 'cod';
            }

            if ($lockedPayment->status !== 'pending') {
                return 'invalid_payment_status';
            }

            if (
                $order->order_status !== 'waiting_verification' ||
                $order->payment_status !== 'waiting_verification'
            ) {
                return 'invalid_order_status';
            }

            $lockedPayment->update([
                'status' => 'rejected',
                'verified_at' => null,
                'verified_by' => auth()->id(),
            ]);

            $order->update([
                'payment_status' => 'rejected',
                'order_status' => 'pending_payment',
            ]);

            return 'success';
        });

        $messages = [
            'already_verified' => [
                'error',
                'Pembayaran yang sudah diverifikasi tidak dapat ditolak.',
            ],
            'cod' => [
                'error',
                'Pembayaran COD tidak perlu diverifikasi.',
            ],
            'invalid_payment_status' => [
                'error',
                'Pembayaran tidak berada dalam status yang dapat ditolak.',
            ],
            'invalid_order_status' => [
                'error',
                'Status pesanan tidak sesuai untuk penolakan pembayaran.',
            ],
            'success' => [
                'success',
                'Pembayaran berhasil ditolak.',
            ],
        ];

        [$type, $message] = $messages[$result];

        return back()->with($type, $message);
    }
}
