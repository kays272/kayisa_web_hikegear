<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang - HikeGear</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f5f7f6;
            color: #26352d;
        }

        .navbar {
            background: #173d2d;
        }

        .navbar-brand {
            font-weight: 800;
            color: white !important;
        }

        .page-title {
            font-weight: 800;
            color: #173d2d;
        }

        .cart-card {
            border: none;
            border-radius: 18px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .product-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 14px;
            background: #edf2ee;
        }

        .product-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 14px;
            background: #edf2ee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            color: #527564;
        }

        .product-name {
            font-weight: 700;
            color: #173d2d;
        }

        .category-name {
            font-size: 14px;
            color: #718078;
        }

        .price {
            font-weight: 700;
            color: #26734d;
        }

        .quantity-input {
            width: 75px;
            text-align: center;
        }

        .btn-hike {
            background: #26734d;
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 18px;
        }

        .btn-hike:hover {
            background: #1d5c3d;
            color: white;
        }

        .btn-outline-hike {
            border: 1px solid #26734d;
            color: #26734d;
            border-radius: 10px;
        }

        .btn-outline-hike:hover {
            background: #26734d;
            color: white;
        }

        .summary-card {
            border: none;
            border-radius: 18px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            position: sticky;
            top: 90px;
        }

        .summary-title {
            font-weight: 800;
            color: #173d2d;
        }

        .total-price {
            font-size: 24px;
            font-weight: 800;
            color: #26734d;
        }

        .empty-cart {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-icon {
            font-size: 70px;
            color: #8aa798;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a
            class="navbar-brand"
            href="{{ route('home') }}"
        >
            <i class="bi bi-backpack2"></i>
            HikeGear
        </a>

        <div class="d-flex align-items-center gap-2">

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-light btn-sm"
            >
                <i class="bi bi-shop"></i>
                Belanja
            </a>

            <a
                href="{{ route('cart.index') }}"
                class="btn btn-light btn-sm"
            >
                <i class="bi bi-cart3"></i>
                Keranjang
            </a>

        </div>
    </div>
</nav>


<div class="container py-5">

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    {{-- Pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    <div class="mb-4">

        <h1 class="page-title">
            <i class="bi bi-cart3"></i>
            Keranjang Saya
        </h1>

        <p class="text-muted">
            Periksa kembali produk sebelum melanjutkan ke checkout.
        </p>

    </div>


    @if($cart->items->count() > 0)

        <div class="row g-4">

            {{-- DAFTAR PRODUK --}}
            <div class="col-lg-8">

                <div class="cart-card p-4">

                    @foreach($cart->items as $item)

                        @php
                            $product = $item->product;
                            $itemSubtotal = $item->quantity * $product->price;
                        @endphp

                        <div class="row align-items-center g-3
                            {{ !$loop->last ? 'border-bottom pb-4 mb-4' : '' }}">

                            {{-- GAMBAR --}}
                            <div class="col-auto">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                    >

                                @else

                                    <div class="product-placeholder">
                                        <i class="bi bi-backpack2"></i>
                                    </div>

                                @endif

                            </div>


                            {{-- NAMA PRODUK --}}
                            <div class="col">

                                <div class="product-name">
                                    {{ $product->name }}
                                </div>

                                <div class="category-name mb-1">
                                    {{ $product->category->name }}
                                </div>

                                <div class="price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                            </div>


                            {{-- UPDATE JUMLAH --}}
                            <div class="col-md-auto">

                                <form
                                    action="{{ route('cart.update', $item->id) }}"
                                    method="POST"
                                    class="d-flex align-items-center gap-2"
                                >

                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $item->quantity }}"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="form-control quantity-input"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-outline-hike"
                                        title="Perbarui jumlah"
                                    >
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>

                                </form>

                            </div>


                            {{-- SUBTOTAL --}}
                            <div class="col-md-auto text-md-end">

                                <div class="small text-muted">
                                    Subtotal
                                </div>

                                <div class="price">
                                    Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                </div>

                            </div>


                            {{-- HAPUS --}}
                            <div class="col-auto">

                                <form
                                    action="{{ route('cart.remove', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus produk ini dari keranjang?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger"
                                        title="Hapus"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- RINGKASAN --}}
            <div class="col-lg-4">

                <div class="summary-card p-4">

                    <h4 class="summary-title mb-4">
                        Ringkasan Belanja
                    </h4>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Total Produk
                        </span>

                        <strong>
                            {{ $cart->items->sum('quantity') }} item
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <span class="fw-bold">
                            Total
                        </span>

                        <span class="total-price">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>

                    </div>


                    <a
                        href="{{ route('checkout.index') }}"
                        class="btn btn-hike w-100"
                    >
                        <i class="bi bi-credit-card"></i>
                        Lanjut ke Checkout
                    </a>


                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-outline-hike w-100 mt-2"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Lanjut Belanja
                    </a>

                </div>

            </div>

        </div>

    @else

        {{-- KERANJANG KOSONG --}}
        <div class="cart-card empty-cart">

            <div class="empty-icon mb-3">
                <i class="bi bi-cart-x"></i>
            </div>

            <h3 class="fw-bold">
                Keranjang masih kosong
            </h3>

            <p class="text-muted mb-4">
                Yuk cari perlengkapan hiking yang kamu butuhkan.
            </p>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-hike"
            >
                <i class="bi bi-shop"></i>
                Mulai Belanja
            </a>

        </div>

    @endif

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>