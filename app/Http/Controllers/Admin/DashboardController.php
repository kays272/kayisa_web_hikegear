<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();

        $totalKategori = Category::count();

        $totalPelanggan = User::where('role', 'user')->count();

        $totalPesanan = Order::count();

        $pesananBaru = Order::whereIn('order_status', [
            'pending_payment',
            'waiting_verification',
        ])->count();

        $pesananDiproses = Order::where(
            'order_status',
            'processing'
        )->count();

        $pesananDikirim = Order::where(
            'order_status',
            'shipped'
        )->count();

        $pesananSelesai = Order::where(
            'order_status',
            'completed'
        )->count();

        $totalPendapatan = Order::whereIn('order_status', [
            'payment_verified',
            'processing',
            'shipped',
            'completed',
        ])->sum('total');

        $pesananTerbaru = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'totalPesanan',
            'pesananBaru',
            'pesananDiproses',
            'pesananDikirim',
            'pesananSelesai',
            'totalPendapatan',
            'pesananTerbaru'
        ));
    }
}
