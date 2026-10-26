<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     * Mendukung checkout keranjang dan Beli Sekarang.
     */
    public function index()
    {
        $buyNow = session('buy_now');

        if ($buyNow) {
            $product = Product::with('category')
                ->find($buyNow['product_id']);

            if (
                !$product ||
                !$product->status ||
                (int) $buyNow['quantity'] < 1 ||
                (int) $buyNow['quantity'] > $product->stock
            ) {
                session()->forget('buy_now');

                return redirect()
                    ->route('products.index')
                    ->with(
                        'error',
                        'Produk tidak tersedia atau stok tidak mencukupi.'
                    );
            }

            // Membuat item sementara untuk tampilan checkout.
            // Tidak menyimpan item ini ke keranjang database.
            $item = new CartItem();
            $item->quantity = (int) $buyNow['quantity'];
            $item->setRelation('product', $product);

            $cart = new Cart();
            $cart->setRelation('items', collect([$item]));
        } else {
            $cart = Cart::where('user_id', auth()->id())
                ->with('items.product.category')
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Keranjang masih kosong. Silakan pilih produk terlebih dahulu.'
                    );
            }
        }

        $addresses = Address::where('user_id', auth()->id())
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        if ($addresses->isEmpty()) {
            return redirect()
                ->route('addresses.create')
                ->with(
                    'error',
                    'Silakan tambahkan alamat pengiriman terlebih dahulu.'
                );
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $shippingOptions = [
            ['courier' => 'JNE', 'service' => 'REG', 'cost' => 15000],
            ['courier' => 'J&T', 'service' => 'EZ', 'cost' => 14000],
            ['courier' => 'SiCepat', 'service' => 'REG', 'cost' => 13000],
        ];

        $shippingCost = $shippingOptions[0]['cost'];
        $total = $subtotal + $shippingCost;

        return view('checkout.index', compact(
            'cart',
            'addresses',
            'subtotal',
            'shippingOptions',
            'shippingCost',
            'total'
        ));
    }

    /**
     * Membuat pesanan dari keranjang atau Beli Sekarang.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'courier' => ['required', 'string', 'in:JNE,J&T,SiCepat'],
            'service' => ['required', 'string'],
            'payment_method' => [
                'required',
                'in:bank_transfer,qris,cod',
            ],
        ], [
            'address_id.required' => 'Alamat pengiriman wajib dipilih.',
            'address_id.exists' => 'Alamat pengiriman tidak ditemukan.',
            'courier.required' => 'Kurir pengiriman wajib dipilih.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $allowedServices = [
            'JNE' => ['REG'],
            'J&T' => ['EZ'],
            'SiCepat' => ['REG'],
        ];

        if (!in_array(
            $validated['service'],
            $allowedServices[$validated['courier']] ?? [],
            true
        )) {
            return back()->withInput()->withErrors([
                'service' =>
                    'Layanan pengiriman tidak sesuai dengan kurir yang dipilih.',
            ]);
        }

        $address = Address::where('id', $validated['address_id'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$address) {
            abort(403, 'Alamat bukan milik akun ini.');
        }

        $shippingCosts = [
            'JNE' => 15000,
            'J&T' => 14000,
            'SiCepat' => 13000,
        ];

        $shippingCost = $shippingCosts[$validated['courier']];
        $userId = auth()->id();

        // Simpan pilihan mode sebelum transaksi dimulai.
        $buyNow = session('buy_now');

        try {
            $order = DB::transaction(function () use (
                $validated,
                $address,
                $shippingCost,
                $userId,
                $buyNow
            ) {
                $lines = [];
                $cart = null;

                if ($buyNow) {
                    // Mode Beli Sekarang: hanya satu produk terpilih.
                    $quantity = (int) ($buyNow['quantity'] ?? 0);

                    if ($quantity < 1) {
                        throw new \RuntimeException(
                            'Jumlah produk tidak valid.'
                        );
                    }

                    $product = Product::where(
                        'id',
                        $buyNow['product_id'] ?? 0
                    )->lockForUpdate()->first();

                    if (!$product || !$product->status) {
                        throw new \RuntimeException(
                            'Produk sudah tidak tersedia.'
                        );
                    }

                    if ($quantity > $product->stock) {
                        throw new \RuntimeException(
                            'Stok produk "' . $product->name .
                            '" tidak mencukupi.'
                        );
                    }

                    $lines[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                } else {
                    // Mode checkout biasa: ambil keranjang milik user.
                    $cart = Cart::where('user_id', $userId)
                        ->lockForUpdate()
                        ->first();

                    if (!$cart) {
                        throw new \RuntimeException(
                            'Keranjang masih kosong.'
                        );
                    }

                    $cartItems = $cart->items()->get();

                    if ($cartItems->isEmpty()) {
                        throw new \RuntimeException(
                            'Keranjang masih kosong.'
                        );
                    }

                    foreach ($cartItems as $cartItem) {
                        $product = Product::where(
                            'id',
                            $cartItem->product_id
                        )->lockForUpdate()->first();

                        if (!$product || !$product->status) {
                            throw new \RuntimeException(
                                'Salah satu produk sudah tidak tersedia.'
                            );
                        }

                        if (
                            $cartItem->quantity < 1 ||
                            $cartItem->quantity > $product->stock
                        ) {
                            throw new \RuntimeException(
                                'Stok produk "' . $product->name .
                                '" tidak mencukupi.'
                            );
                        }

                        $lines[] = [
                            'product' => $product,
                            'quantity' => (int) $cartItem->quantity,
                        ];
                    }
                }

                $subtotal = 0;

                foreach ($lines as $line) {
                    $subtotal +=
                        $line['quantity'] * $line['product']->price;
                }

                $total = $subtotal + $shippingCost;

                $orderNumber = 'HG-' .
                    now()->format('YmdHis') . '-' .
                    strtoupper(Str::random(5));

                if ($validated['payment_method'] === 'cod') {
                    $paymentStatus = 'verified';
                    $orderStatus = 'payment_verified';
                } else {
                    $paymentStatus = 'pending';
                    $orderStatus = 'pending_payment';
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'address_id' => $address->id,
                    'order_number' => $orderNumber,

                    'recipient_name' => $address->recipient_name,
                    'phone' => $address->phone,
                    'province' => $address->province,
                    'city' => $address->city,
                    'district' => $address->district,
                    'address' => $address->address,
                    'postal_code' => $address->postal_code,

                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,

                    'shipping_courier' => $validated['courier'],
                    'shipping_service' => $validated['service'],

                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $paymentStatus,
                    'order_status' => $orderStatus,
                ]);

                foreach ($lines as $line) {
                    $product = $line['product'];
                    $quantity = $line['quantity'];
                    $itemSubtotal = $quantity * $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                    ]);

                    $product->decrement('stock', $quantity);
                }

                Payment::create([
                    'order_id' => $order->id,
                    'method' => $validated['payment_method'],
                    'amount' => $total,
                    'status' => $paymentStatus,
                ]);

                Shipment::create([
                    'order_id' => $order->id,
                    'courier' => $validated['courier'],
                    'service' => $validated['service'],
                    'shipping_cost' => $shippingCost,
                    'status' => 'pending',
                ]);

                // Keranjang hanya dikosongkan untuk checkout keranjang.
                if (!$buyNow && $cart) {
                    $cart->items()->delete();
                }

                return $order;
            });

            // Hapus penanda Beli Sekarang setelah transaksi berhasil.
            if ($buyNow) {
                session()->forget('buy_now');
            }

            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\RuntimeException $e) {
            // Pesan validasi bisnis yang sudah kita tentukan sendiri.
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            // Jangan tampilkan detail error database kepada pengguna.
            Log::error('Checkout gagal.', [
                'user_id' => $userId,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pesanan gagal dibuat. Silakan coba lagi.'
                );
        }
    }
}
