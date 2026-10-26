<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produk - HikeGear</title>

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

        .page-header {
            background: linear-gradient(
                135deg,
                #173f2a,
                #2f6b46
            );
            color: white;
            padding: 55px 0;
        }

        .page-header h1 {
            font-weight: 800;
        }

        .filter-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0,0,0,.07);
        }

        .product-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: white;
            box-shadow: 0 8px 25px rgba(0,0,0,.07);
            transition: .25s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,.12);
        }

        .product-image {
            height: 210px;
            background: #edf3ee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image i {
            font-size: 75px;
            color: #2f6b46;
        }

        .product-body {
            padding: 20px;
        }

        .category-badge {
            background: #e5f0e8;
            color: #28613e;
            border-radius: 50px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .product-name {
            font-weight: 700;
            margin-top: 14px;
            min-height: 48px;
        }

        .price {
            color: #173f2a;
            font-size: 20px;
            font-weight: 800;
        }

        .stock {
            font-size: 13px;
            color: #777;
        }

        .btn-hike {
            background: #173f2a;
            color: white;
            border-radius: 10px;
            border: none;
        }

        .btn-hike:hover {
            background: #2f6b46;
            color: white;
        }

        
        .pagination {
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            min-height: 40px;
            padding: 8px 12px;
            border: 1px solid #e1e8dd;
            border-radius: 8px;
            color: #304d38;
            background: #fff;
            text-decoration: none;
        }

        .pagination .page-link:hover {
            color: #304d38;
            background: #edf4e8;
            border-color: #6c8b57;
        }

        .pagination .page-item.active .page-link {
            color: #fff;
            background: #304d38;
            border-color: #304d38;
        }

        .pagination .page-item.disabled .page-link {
            color: #a6afa3;
            background: #f7f8f5;
        }

        /* Mencegah SVG panah pagination membesar */
        .pagination svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px;
            max-height: 16px;
            display: inline-block;
        }


        footer {
            background: #173f2a;
            color: white;
            margin-top: 60px;
            padding: 35px 0;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
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
                        class="nav-link active"
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


<!-- HEADER -->
<section class="page-header">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <p class="mb-2">
                    HIKEGEAR STORE
                </p>

                <h1>
                    Produk Hiking & Camping
                </h1>

                <p class="mb-0">
                    Temukan perlengkapan outdoor yang kamu butuhkan
                    untuk menemani perjalananmu.
                </p>

            </div>

        </div>

    </div>
</section>


<!-- CONTENT -->
<div class="container py-5">

    <div class="row g-4">

        <!-- FILTER -->
        <div class="col-lg-3">

            <div class="card filter-card p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-funnel"></i>
                    Filter Produk
                </h5>

                <form
                    action="{{ route('products.index') }}"
                    method="GET"
                >

                    <!-- SEARCH -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Cari Produk
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Nama produk..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    <!-- CATEGORY -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Kategori
                        </label>

                        <select
                            name="category"
                            class="form-select"
                        >

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- MIN PRICE -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Harga Minimum
                        </label>

                        <input
                            type="number"
                            name="min_price"
                            class="form-control"
                            placeholder="Rp 0"
                            value="{{ request('min_price') }}"
                            min="0"
                        >

                    </div>


                    <!-- MAX PRICE -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Harga Maksimum
                        </label>

                        <input
                            type="number"
                            name="max_price"
                            class="form-control"
                            placeholder="Rp 1.000.000"
                            value="{{ request('max_price') }}"
                            min="0"
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn btn-hike w-100"
                    >
                        <i class="bi bi-search"></i>
                        Terapkan Filter
                    </button>


                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-outline-secondary w-100 mt-2"
                    >
                        Reset Filter
                    </a>

                </form>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h4 class="fw-bold mb-1">
                        Semua Produk
                    </h4>

                    <small class="text-muted">
                        Menampilkan
                        {{ $products->total() }}
                        produk
                    </small>
                </div>

            </div>


            @if($products->count() > 0)

                <div class="row g-4">

                    @foreach($products as $product)

                        <div class="col-md-6 col-xl-4">

                            <div class="product-card">

                                <!-- IMAGE -->
                                <div class="product-image">

                                    @if($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            style="
                                                width:100%;
                                                height:100%;
                                                object-fit:cover;
                                            "
                                        >

                                    @else

                                        <i class="bi bi-backpack2"></i>

                                    @endif

                                </div>


                                <!-- BODY -->
                                <div class="product-body">

                                    <span class="category-badge">
                                        {{ $product->category->name }}
                                    </span>

                                    <h5 class="product-name">
                                        {{ $product->name }}
                                    </h5>

                                    <div class="price mb-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>

                                    <div class="stock mb-3">
                                        <i class="bi bi-box-seam"></i>
                                        Stok:
                                        {{ $product->stock }}
                                    </div>

                                    <a
                                        href="{{ route('products.show', $product->slug) }}"
                                        class="btn btn-hike w-100"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Lihat Detail
                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                <!-- PAGINATION -->
                <div class="mt-5">

                    {{ $products->links('pagination::bootstrap-5') }}

                </div>

            @else

                <div class="text-center py-5">

                    <i
                        class="bi bi-search"
                        style="
                            font-size:60px;
                            color:#aaa;
                        "
                    ></i>

                    <h4 class="mt-3">
                        Produk tidak ditemukan
                    </h4>

                    <p class="text-muted">
                        Coba gunakan kata pencarian atau filter
                        yang berbeda.
                    </p>

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-hike"
                    >
                        Lihat Semua Produk
                    </a>

                </div>

            @endif

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
            Perlengkapan hiking & camping untuk petualanganmu.
        </p>

        <small class="d-block mt-3 opacity-75">
            © {{ date('Y') }} HikeGear. All rights reserved.
        </small>

    </div>

</footer>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>