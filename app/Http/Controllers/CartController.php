<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan keranjang
     */
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cart->load([
            'items.product.category'
        ]);

        $subtotal = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart.index', compact(
            'cart',
            'subtotal'
        ));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ], [
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
        ]);

        $quantity = $validated['quantity'];

        if (!$product->status) {
            return back()->with(
                'error',
                'Produk tersebut sudah tidak tersedia.'
            );
        }

        if ($product->stock < $quantity) {
            return back()->with(
                'error',
                'Jumlah yang dipilih melebihi stok produk.'
            );
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {

            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'Jumlah produk di keranjang melebihi stok yang tersedia.'
                );
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);

        } else {

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                $product->name . ' berhasil ditambahkan ke keranjang.'
            );
    }

    /**
     * Mengubah jumlah produk di keranjang
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ], [
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
        ]);

        // Pastikan cart item milik user yang sedang login
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $product = $cartItem->product;

        if (!$product->status) {
            return back()->with(
                'error',
                'Produk tersebut sudah tidak tersedia.'
            );
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->with(
                'error',
                'Jumlah melebihi stok produk yang tersedia.'
            );
        }

        $cartItem->update([
            'quantity' => $validated['quantity']
        ]);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }

    /**
     * Menghapus produk dari keranjang
     */
    public function remove(CartItem $cartItem)
    {
        // Pastikan cart item milik user yang sedang login
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $productName = $cartItem->product->name;

        $cartItem->delete();

        return back()->with(
            'success',
            $productName . ' berhasil dihapus dari keranjang.'
        );
    }

    
    /**
     * Membeli satu produk secara langsung.
     */
    public function buyNow(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
        ]);

        $quantity = (int) $validated['quantity'];

        // Pastikan produk masih tersedia.
        $product->refresh();

        if (!$product->status) {
            return back()->with(
                'error',
                'Produk tersebut sudah tidak tersedia.'
            );
        }

        if ($quantity > $product->stock) {
            return back()->with(
                'error',
                'Jumlah yang dipilih melebihi stok produk.'
            );
        }

        // Simpan pilihan pembelian langsung di session,
        // terpisah dari keranjang biasa.
        session([
            'buy_now' => [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ],
        ]);

        return redirect()->route('checkout.index');
    }

}