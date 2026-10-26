<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $product->name }} - HikeGear
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7f5;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #173f2a;
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: rgba(255,255,255,.85) !important;
        }

        .nav-link:hover {
            color: white !important;
        }

        .breadcrumb-section {
            background: #edf3ee;
            padding: 20px 0;
        }

        .breadcrumb a {
            color: #28613e;
            text-decoration: none;
        }

        .detail-card {
            background: white;
            border: none;
            border-radius: 22px;
            box-shadow: 0 10px 35px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .product-image {
            min-height: 500px;
            background: #edf3ee;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .product-image img {
            width: 100%;
            height: 440px;
            object-fit: cover;
            border-radius: 15px;
        }

        .product-placeholder {
            width: 100%;
            height: 440px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-placeholder i {
            font-size: 150px;
            color: #2f6b46;
        }

        .detail-content {
            padding: 45px;
        }

        .category-badge {
            display: inline-block;
            background: #e5f0e8;
            color: #28613e;
            border-radius: 50px;
            padding: 8px 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .product-title {
            font-size: 36px;
            font-weight: 800;
            color: #173f2a;
            margin-top: 18px;
        }

        .product-price {
            font-size: 30px;
            font-weight: 800;
            color: #173f2a;
            margin: 20px 0;
        }

        .description {
            color: #666;
            line-height: 1.8;
        }

        .info-box {
            background: #f7f9f7;
            border-radius: 14px;
            padding: 18px;
        }

        .info-box i {
            color: #28613e;
            font-size: 22px;
        }

        .stock-available {
            color: #198754;
            font-weight: 700;
        }

        .stock-empty {
            color: #dc3545;
            font-weight: 700;
        }

        .btn-hike {
            background: #173f2a;
            color: white;
            border-radius: 10px;
            border: none;
            padding: 12px 22px;
            font-weight: 600;
        }

        .btn-hike:hover {
            background: #2f6b46;
            color: white;
        }

        .btn-outline-hike {
            border: 2px solid #173f2a;
            color: #173f2a;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
        }

        .btn-outline-hike:hover {
            background: #173f2a;
            color: white;
        }

        .quantity-input {
            width: 90px;
            text-align: center;
            border-radius: 10px;
        }

        footer {
            background: #173f2a;
            color: white;
            margin-top: 70px;
            padding: 35px 0;
        }

        @media (max-width: 768px) {

            .product-title {
                font-size: 28px;
            }

            .product-price {
                font-size: 25px;
            }

            .detail-content {
                padding: 25px;
            }

            .product-image {
                min-height: 350px;
            }

            .product-image img,
            .product-placeholder {
                height: 300px;
            }

        }

    </style>

</head>


<body>


<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a
            class="navbar-brand"
            href="{{ route('home') }}"
        >
            <i class="bi bi-backpack2"></i>
            HikeGear
        </a>


        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="navbarMenu"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('home') }}"
                    >
                        Home
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('products.index') }}"
                    >
                        Produk
                    </a>

                </li>


                @guest

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('login') }}"
                        >
                            Login
                        </a>

                    </li>


                    <li class="nav-item ms-lg-2">

                        <a
                            class="btn btn-light btn-sm px-3"
                            href="{{ route('register') }}"
                        >
                            Daftar
                        </a>

                    </li>

                @else

                    <li class="nav-item">

                        <span class="nav-link">

                            <i class="bi bi-person-circle"></i>

                            {{ auth()->user()->name }}

                        </span>

                    </li>

                @endguest

            </ul>

        </div>

    </div>

</nav>



<!-- BREADCRUMB -->

<section class="breadcrumb-section">

    <div class="container">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb mb-0">

                <li class="breadcrumb-item">

                    <a href="{{ route('home') }}">
                        Home
                    </a>

                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('products.index') }}">
                        Produk
                    </a>

                </li>

                <li
                    class="breadcrumb-item active"
                    aria-current="page"
                >
                    {{ $product->name }}
                </li>

            </ol>

        </nav>

    </div>

</section>



<!-- DETAIL PRODUK -->

<div class="container py-5">

    <div class="detail-card">

        <div class="row g-0">


            <!-- GAMBAR -->

            <div class="col-lg-6">

                <div class="product-image">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                        >

                    @else

                        <div class="product-placeholder">

                            <i class="bi bi-backpack2"></i>

                        </div>

                    @endif

                </div>

            </div>



            <!-- INFORMASI -->

            <div class="col-lg-6">

                <div class="detail-content">


                    <!-- KATEGORI -->

                    <span class="category-badge">

                        <i class="bi bi-tag"></i>

                        {{ $product->category->name }}

                    </span>



                    <!-- NAMA -->

                    <h1 class="product-title">

                        {{ $product->name }}

                    </h1>



                    <!-- HARGA -->

                    <div class="product-price">

                        Rp {{ number_format($product->price, 0, ',', '.') }}

                    </div>



                    <!-- STOK -->

                    <div class="info-box mb-4">

                        <div class="d-flex align-items-center gap-3">

                            <i class="bi bi-box-seam"></i>

                            <div>

                                <small class="text-muted d-block">
                                    Ketersediaan
                                </small>

                                @if($product->stock > 0)

                                    <span class="stock-available">

                                        Stok tersedia:
                                        {{ $product->stock }}

                                    </span>

                                @else

                                    <span class="stock-empty">

                                        Stok habis

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>



                    <!-- DESKRIPSI -->

                    <h5 class="fw-bold">
                        Deskripsi Produk
                    </h5>

                    <div class="description mb-4">

                        @if($product->description)

                            {!! nl2br(e($product->description)) !!}

                        @else

                            <span class="text-muted">
                                Belum ada deskripsi produk.
                            </span>

                        @endif

                    </div>



                    <!-- BERAT -->

                    <div class="info-box mb-4">

                        <div class="d-flex align-items-center gap-3">

                            <i class="bi bi-box"></i>

                            <div>

                                <small class="text-muted d-block">
                                    Berat Produk
                                </small>

                                <strong>
                                    {{ number_format($product->weight) }} gram
                                </strong>

                            </div>

                        </div>

                    </div>



                   
                    <!-- QUANTITY DAN TOMBOL PEMBELIAN -->

                    @if($product->status && $product->stock > 0)

                        <form id="purchaseForm" class="mb-4">
                            <label for="quantity" class="form-label fw-semibold">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                class="form-control quantity-input"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                required
                            >
                        </form>

                        <div class="d-flex gap-2 flex-wrap mb-3">

                            <!-- TAMBAH KE KERANJANG -->
                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST"
                                class="flex-grow-1"
                                onsubmit="return setPurchaseQuantity(this)"
                            >
                                @csrf

                                <input
                                    type="hidden"
                                    name="quantity"
                                    class="purchase-quantity"
                                    value="1"
                                >

                                <button type="submit" class="btn btn-outline-hike w-100">
                                    <i class="bi bi-cart-plus"></i>
                                    Tambah ke Keranjang
                                </button>
                            </form>

                            <!-- BELI SEKARANG -->
                            <form
                                action="{{ route('products.buyNow', $product->id) }}"
                                method="POST"
                                class="flex-grow-1"
                                onsubmit="return setPurchaseQuantity(this)"
                            >
                                @csrf

                                <input
                                    type="hidden"
                                    name="quantity"
                                    class="purchase-quantity"
                                    value="1"
                                >

                                <button type="submit" class="btn btn-hike w-100">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    Beli Sekarang
                                </button>
                            </form>

                        </div>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-hike"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>

                    @else

                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            Produk sedang tidak tersedia.
                        </div>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-hike"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Produk
                        </a>

                    @endif
                </div>

            </div>

        </div>

    </div>

</div>



<!-- FOOTER -->

<footer>

    <div class="container text-center">

        <h5 class="fw-bold">

            <i class="bi bi-backpack2"></i>

            HikeGear

        </h5>

        <p class="mb-0">

            Perlengkapan hiking & camping
            untuk petualanganmu.

        </p>

        <small class="d-block mt-3 opacity-75">

            © {{ date('Y') }} HikeGear.
            All rights reserved.

        </small>

    </div>

</footer>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<script>
    function setPurchaseQuantity(form) {
        const quantityInput = document.getElementById('quantity');
        const quantity = Number(quantityInput.value);
        const maxStock = Number(quantityInput.max);

        if (
            !Number.isInteger(quantity) ||
            quantity < 1 ||
            quantity > maxStock
        ) {
            alert('Jumlah harus berupa bilangan bulat dan tidak melebihi stok.');
            quantityInput.focus();
            return false;
        }

        form.querySelector('.purchase-quantity').value = quantity;
        return true;
    }
</script>

</body>

</html>