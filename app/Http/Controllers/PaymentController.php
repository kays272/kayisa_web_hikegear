<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function uploadProof(Request $request, Order $order)
    {
        // Pastikan pesanan milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
        }

        // COD tidak membutuhkan bukti pembayaran
        if ($order->payment_method === 'cod') {
            return back()->with(
                'error',
                'Pesanan COD tidak membutuhkan bukti pembayaran.'
            );
        }

        // Jika sudah diverifikasi, tidak boleh upload lagi
        if ($order->payment_status === 'verified') {
            return back()->with(
                'error',
                'Pembayaran pesanan ini sudah diverifikasi.'
            );
        }

        // Validasi file
        $validated = $request->validate([
            'proof' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'proof.required' => 'Bukti pembayaran wajib diupload.',
            'proof.image' => 'File bukti pembayaran harus berupa gambar.',
            'proof.mimes' => 'Format yang diperbolehkan: JPG, JPEG, PNG, atau WEBP.',
            'proof.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
        ]);

        // Ambil data payment
        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'Data pembayaran tidak ditemukan.'
            );
        }

        // Hapus bukti lama jika ada
        if ($payment->proof) {
            Storage::disk('public')->delete($payment->proof);
        }

        // Simpan bukti pembayaran baru
        $path = $request->file('proof')->store(
            'payment-proofs',
            'public'
        );

        // Update payment
        $payment->update([
            'proof' => $path,
            'status' => 'pending',
            'verified_at' => null,
            'verified_by' => null,
        ]);

        // Update status pesanan
        $order->update([
            'payment_status' => 'waiting_verification',
            'order_status' => 'waiting_verification',
        ]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with(
                'success',
                'Bukti pembayaran berhasil diupload dan sedang menunggu verifikasi admin.'
            );
    }
}