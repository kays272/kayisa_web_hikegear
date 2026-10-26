<?php

use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ========================================
// LANDING PAGE
// ========================================

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');

Route::get('/produk', [
    ProductController::class,
    'index'
])->name('products.index');

Route::get('/produk/{slug}', [
    ProductController::class,
    'show'
])->name('products.show');

// ========================================
// AUTH
// ========================================

Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', [
        AuthController::class,
        'showRegister'
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register'
    ])->name('register.process');

    // Login
    Route::get('/login', [
        AuthController::class,
        'showLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->name('login.process');
});


// ========================================
// USER
// ========================================

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $cart = \App\Models\Cart::with('items')
            ->where('user_id', auth()->id())
            ->first();

        $cartCount = $cart
            ? $cart->items->sum('quantity')
            : 0;

        return view('user.home', compact(
            'orders',
            'cartCount'
        ));
    })->name('user.home');

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');

    Route::get('/keranjang', [
        CartController::class,
        'index'
    ])->name('cart.index');

    Route::post('/keranjang/tambah/{product}', [
        CartController::class,
        'add'
    ])->name('cart.add');

    Route::post('/beli-sekarang/{product}', [
        CartController::class,
        'buyNow'
    ])->name('products.buyNow');

    Route::put('/keranjang/update/{cartItem}', [
        CartController::class,
        'update'
    ])->name('cart.update');

    Route::delete('/keranjang/hapus/{cartItem}', [
        CartController::class,
        'remove'
    ])->name('cart.remove');
    
    Route::post('/pesanan/{order}/batalkan', [
        \App\Http\Controllers\OrderController::class,
        'requestCancellation'
    ])->name('orders.cancel');

    Route::get('/alamat', [
        AddressController::class,
        'index'
    ])->name('addresses.index');

    Route::get('/alamat/tambah', [
        AddressController::class,
        'create'
    ])->name('addresses.create');

    Route::post('/alamat', [
        AddressController::class,
        'store'
    ])->name('addresses.store');

    Route::get('/alamat/{address}/edit', [
        AddressController::class,
        'edit'
    ])->name('addresses.edit');

    Route::put('/alamat/{address}', [
        AddressController::class,
        'update'
    ])->name('addresses.update');

    Route::delete('/alamat/{address}', [
        AddressController::class,
        'destroy'
    ])->name('addresses.destroy');

    Route::get('/checkout', [
        CheckoutController::class,
        'index'
    ])->name('checkout.index');

    Route::post('/checkout', [
        CheckoutController::class,
        'store'
    ])->name('checkout.store');

    Route::get('/pesanan', [
        OrderController::class,
        'index'
    ])->name('orders.index');

    Route::get('/pesanan/{order}', [
        OrderController::class,
        'show'
    ])->name('orders.show');

    Route::post('/pesanan/{order}/pembayaran',[
        PaymentController::class, 
        'uploadProof'
    ])->name('payments.upload');
});


// ========================================
// ADMIN
// ========================================

Route::middleware([
    'auth',
    'admin'
])->prefix('admin')->group(function () {

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('admin.dashboard');

    Route::get('/pembayaran', [
        AdminPaymentController::class, 
        'index'
    ])->name('admin.payments.index');

    Route::get('/pembayaran/{payment}', [
        AdminPaymentController::class, 
        'show'
    ])->name('admin.payments.show');

    Route::post('/pembayaran/{payment}/verifikasi', [
        AdminPaymentController::class, 
        'verify'
    ])->name('admin.payments.verify');

    Route::post('/pembayaran/{payment}/tolak', [
        AdminPaymentController::class, 
        'reject'
    ])->name('admin.payments.reject');

    Route::get('/pesanan', [
        AdminOrderController::class,
        'index'
    ])->name('admin.orders.index');

    Route::get('/pesanan/{order}', [
        AdminOrderController::class,
        'show'
    ])->name('admin.orders.show');

    Route::post(
        '/pesanan/{order}/setujui-pembatalan',
        [\App\Http\Controllers\Admin\OrderController::class, 'approveCancellation']
    )->name('admin.orders.cancel.approve');

    Route::post(
        '/pesanan/{order}/tolak-pembatalan',
        [\App\Http\Controllers\Admin\OrderController::class, 'rejectCancellation']
    )->name('admin.orders.cancel.reject');

    Route::post('/pesanan/{order}/proses', [
        AdminOrderController::class,
        'process'
    ])->name('admin.orders.process');

    Route::post('/pesanan/{order}/kirim', [
        AdminOrderController::class,
        'ship'
    ])->name('admin.orders.ship');

    Route::post('/pesanan/{order}/selesai', [
        AdminOrderController::class,
        'complete'
    ])->name('admin.orders.complete');

    Route::resource('produk', \App\Http\Controllers\Admin\ProductController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ])
    ->parameters(['produk' => 'product']);

});