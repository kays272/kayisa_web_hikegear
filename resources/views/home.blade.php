
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HikeGear - Hiking & Camping Gear</title>
    <meta name="description" content="Temukan perlengkapan hiking dan camping berkualitas di HikeGear. Siap menemani petualanganmu di alam terbuka.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --green: #304d38;
            --green-light: #6c8b57;
            --cream: #f7f8f5;
            --text: #26352a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--text);
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
        }

        .navbar-brand {
            color: var(--green) !important;
            font-size: 25px;
            font-weight: 800;
        }

        .navbar-brand span {
            color: var(--green-light);
        }

        .nav-link {
            color: #39483b;
            font-weight: 600;
        }

        .nav-link:hover {
            color: var(--green-light);
        }

        .btn-hike {
            background: var(--green);
            border: 1px solid var(--green);
            color: white;
            border-radius: 9px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-hike:hover {
            background: #243c2b;
            color: white;
        }

        .btn-outline-hike {
            border: 1px solid var(--green);
            color: var(--green);
            border-radius: 9px;
            padding: 9px 18px;
            font-weight: 600;
        }

        .btn-outline-hike:hover {
            background: var(--green);
            color: white;
        }

        .hero {
            background: linear-gradient(120deg, #203c2a, #55764e);
            color: white;
            padding: 85px 0;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.25);
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(36px, 5vw, 62px);
            font-weight: 800;
            line-height: 1.12;
            margin-bottom: 20px;
        }

        .hero p {
            max-width: 550px;
            line-height: 1.8;
            color: #edf3eb;
        }

        .hero-art {
            min-height: 270px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 150px;
            color: #dce9d4;
        }

        .section-space {
            padding: 65px 0;
        }

        .section-title {
            color: var(--green);
            font-weight: 800;
        }

        .section-subtitle {
            color: #738075;
        }

        .category-card {
            display: block;
            height: 100%;
            background: white;
            padding: 25px 12px;
            text-align: center;
            border-radius: 15px;
            text-decoration: none;
            color: var(--text);
            box-shadow: 0 4px 16px rgba(0,0,0,.04);
            transition: .2s;
        }

        .category-card:hover {
            transform: translateY(-5px);
            color: var(--green-light);
            box-shadow: 0 9px 22px rgba(0,0,0,.08);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: #eaf0e5;
            color: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .category-name {
            font-size: 14px;
            font-weight: 700;
        }

        .product-card {
            height: 100%;
            background: white;
            border: 1px solid #edf0e9;
            border-radius: 15px;
            overflow: hidden;
            transition: .2s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 9px 24px rgba(0,0,0,.08);
        }

        .product-image {
            height: 210px;
            background: #edf1e9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-placeholder {
            font-size: 55px;
            color: #71866a;
        }

        .product-info {
            padding: 18px;
        }

        .product-category {
            color: #71816f;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--green);
            min-height: 40px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 800;
            color: #507548;
            margin: 12px 0;
        }

        .stock-text {
            font-size: 12px;
            color: #6c757d;
        }

        .promo {
            background: #e7eddf;
            border-radius: 20px;
            padding: 35px;
        }

        .footer {
            background: #203c2a;
            color: #e7eee5;
            padding: 35px 0;
        }

        .footer a {
            color: #e7eee5;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 767px) {
            .hero {
                padding: 55px 0;
            }

            .hero-art {
                min-height: 150px;
                font-size: 100px;
            }

            .section-space {
                padding: 45px 0;
            }

            .product-image {
                height: 170px;
            }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-tree-fill"></i>
            Hike<span>Gear</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false"
                aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kategori">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                </li>
            </ul>

            <div class="d-flex flex-wrap align-items-center gap-2 pb-2 pb-lg-0">
                @auth
                    <span class="small me-1">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                    </span>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="btn btn-outline-hike btn-sm">
                            Admin
                        </a>
                    @else
                        <a href="{{ route('user.home') }}"
                           class="btn btn-outline-hike btn-sm">
                            Akun Saya
                        </a>

                        <a href="{{ route('cart.index') }}"
                           class="btn btn-outline-hike btn-sm">
                            <i class="bi bi-cart3"></i> Keranjang
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-hike btn-sm" type="submit">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="btn btn-outline-hike btn-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn btn-hike btn-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- NOTIFIKASI --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
</div>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge">
                    <i class="bi bi-compass"></i>
                    Gear up for your next adventure
                </span>

                <h1>EXPLORE THE<br>OUTDOORS.</h1>

                <p>
                    Siapkan petualanganmu bersama perlengkapan hiking
                    dan camping pilihan. Temukan perlengkapan yang
                    menemani setiap langkah perjalananmu.
                </p>

                <a href="{{ route('products.index') }}"
                   class="btn btn-light btn-lg mt-3">
                    <i class="bi bi-bag"></i>
                    Belanja Sekarang
                </a>

                <a href="#kategori"
                   class="btn btn-outline-light btn-lg mt-3 ms-1">
                    Jelajahi Kategori
                </a>
            </div>

            <div class="col-lg-5">
                <div class="hero-art">
                    <i class="bi bi-tree-fill"></i>
                    <i class="bi bi-mountain"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI --}}
<section class="section-space" id="kategori">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Jelajahi Kategori</h2>
            <p class="section-subtitle">
                Pilih perlengkapan sesuai kebutuhan petualanganmu.
            </p>
        </div>

        <div class="row g-3">
            @forelse($categories as $category)
                @php
                    $categoryIcons = [
                        'tenda' => 'bi-house',
                        'carrier' => 'bi-backpack',
                        'sleeping-bag' => 'bi-moon-stars',
                        'matras' => 'bi-layers',
                        'trekking-pole' => 'bi-signpost',
                        'headlamp' => 'bi-lightbulb',
                        'kompor-camping' => 'bi-fire',
                        'sepatu-hiking' => 'bi-person-walking',
                        'jaket-outdoor' => 'bi-wind',
                        'peralatan-masak-camping' => 'bi-cup-hot',
                    ];

                    $icon = $categoryIcons[$category->slug] ?? 'bi-box-seam';
                @endphp

                <div class="col-6 col-md-4 col-lg-3">
                    <a class="category-card"
                       href="{{ route('products.index', ['category' => $category->id]) }}">
                        <div class="category-icon">
                            <i class="bi {{ $icon }}"></i>
                        </div>

                        <div class="category-name">
                            {{ $category->name }}
                        </div>

                        <small class="text-muted">
                            {{ $category->products_count }} produk
                        </small>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    Belum ada kategori produk.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- PRODUK TERBARU --}}
<section class="section-space pt-0" id="produk">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-3 mb-4">
            <div>
                <h2 class="section-title mb-1">Pilihan Perlengkapan</h2>
                <p class="section-subtitle mb-0">
                    Perlengkapan untuk perjalanan berikutnya.
                </p>
            </div>

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-hike">
                Lihat Semua Produk
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >
                            @else
                                <i class="bi bi-backpack product-placeholder"></i>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->category->name ?? 'Perlengkapan Outdoor' }}
                            </div>

                            <div class="product-name">
                                {{ $product->name }}
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="stock-text mb-3">
                                @if($product->stock > 0)
                                    <i class="bi bi-check-circle text-success"></i>
                                    Stok {{ $product->stock }}
                                @else
                                    <i class="bi bi-x-circle text-danger"></i>
                                    Stok habis
                                @endif
                            </div>

                            <a href="{{ route('products.show', $product->slug) }}"
                               class="btn btn-hike w-100">
                                <i class="bi bi-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center">
                        Belum ada produk yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- PROMO --}}
<section class="container mb-5">
    <div class="promo">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <h3 class="section-title fw-bold">
                    Siap untuk petualangan berikutnya?
                </h3>
                <p class="mb-0">
                    Temukan perlengkapan yang kamu butuhkan di HikeGear.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('products.index') }}"
                   class="btn btn-hike">
                    Mulai Belanja
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-7">
                <h4 class="fw-bold">
                    <i class="bi bi-tree-fill"></i> HikeGear
                </h4>
                <p class="mb-0">
                    Perlengkapan hiking dan camping untuk menemani
                    petualanganmu di alam terbuka.
                </p>
            </div>

            <div class="col-md-5 text-md-end">
                <a href="{{ route('home') }}" class="me-3">Beranda</a>
                <a href="{{ route('products.index') }}">Produk</a>
                <p class="mt-3 mb-0 small">
                    &copy; {{ date('Y') }} HikeGear.
                    All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
