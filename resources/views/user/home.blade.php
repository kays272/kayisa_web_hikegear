
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pembeli - HikeGear</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --green: #304d38;
            --light-green: #6c8b57;
            --background: #f5f7f2;
        }

        body {
            margin: 0;
            background: var(--background);
            color: #25382a;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: var(--green);
        }

        .navbar-brand {
            color: white !important;
            font-size: 24px;
            font-weight: 800;
        }

        .hero {
            margin-top: 30px;
            padding: 35px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg, #203c2a, #628657);
        }

        .hero h1 {
            font-weight: 800;
        }

        .hero p {
            color: #edf4e9;
            line-height: 1.7;
        }

        .stat-card, .content-card, .quick-card {
            background: white;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,.045);
        }

        .stat-card {
            padding: 22px;
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #eaf1e5;
            color: var(--green);
            font-size: 23px;
            margin-bottom: 14px;
        }

        .stat-number {
            font-size: 27px;
            font-weight: 800;
        }

        .muted {
            color: #758075;
            font-size: 13px;
        }

        .quick-card {
            display: block;
            height: 100%;
            padding: 22px;
            text-decoration: none;
            color: #25382a;
            transition: .2s;
        }

        .quick-card:hover {
            transform: translateY(-4px);
            color: var(--light-green);
        }

        .quick-card i {
            font-size: 29px;
            color: var(--light-green);
        }

        .quick-card h6 {
            font-weight: 700;
            margin-top: 14px;
        }

        .content-card {
            overflow: hidden;
        }

        .card-heading {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0e9;
        }

        .order-row {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0e9;
        }

        .order-row:last-child {
            border-bottom: 0;
        }

        .order-number {
            color: var(--green);
            font-weight: 800;
        }

        .price {
            color: #507548;
            font-weight: 800;
        }

        .btn-hike {
            background: var(--green);
            color: white;
            border: 1px solid var(--green);
        }

        .btn-hike:hover {
            background: #203c2a;
            color: white;
        }

        .empty-state {
            padding: 35px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 45px;
            color: var(--light-green);
        }

        footer {
            padding: 28px 0;
            text-align: center;
            color: #758075;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a href="{{ route('user.home') }}" class="navbar-brand">
            <i class="bi bi-tree-fill"></i> HikeGear
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a href="{{ route('user.home') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">Pesanan Saya</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('addresses.index') }}" class="nav-link">Alamat</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3 py-2">
                <span class="text-white">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container pb-4">
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <section class="hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="mb-3">
                    <i class="bi bi-compass"></i>
                    RUANG PETUALANGANMU
                </div>

                <h1>Halo, {{ auth()->user()->name }}! 👋</h1>

                <p class="mb-0">
                    Siap untuk petualangan berikutnya?
                    Temukan perlengkapan hiking dan camping favoritmu
                    di HikeGear.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-bag"></i> Mulai Belanja
                </a>
            </div>
        </div>
    </section>

    <section class="row g-4 mt-1">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                <div class="stat-number">{{ $orders->count() }}</div>
                <div class="muted">Pesanan terbaru yang ditampilkan</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-cart3"></i></div>
                <div class="stat-number">{{ $cartCount }}</div>
                <div class="muted">Jumlah barang di keranjang</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                <div class="stat-number">Aktif</div>
                <div class="muted">Akun pembeli HikeGear</div>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <h4 class="fw-bold mb-3">Menu Cepat</h4>

        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index') }}" class="quick-card">
                    <i class="bi bi-box-seam"></i>
                    <h6>Jelajahi Produk</h6>
                    <div class="muted">Cari perlengkapan outdoor.</div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('cart.index') }}" class="quick-card">
                    <i class="bi bi-cart3"></i>
                    <h6>Keranjang</h6>
                    <div class="muted">Kelola barang pilihanmu.</div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('orders.index') }}" class="quick-card">
                    <i class="bi bi-receipt"></i>
                    <h6>Pesanan Saya</h6>
                    <div class="muted">Periksa status pesanan.</div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('addresses.index') }}" class="quick-card">
                    <i class="bi bi-geo-alt"></i>
                    <h6>Alamat</h6>
                    <div class="muted">Atur alamat pengiriman.</div>
                </a>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="content-card">
            <div class="card-heading d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history"></i> Pesanan Terbaru
                </h5>

                <a href="{{ route('orders.index') }}"
                   class="btn btn-sm btn-outline-success">
                    Lihat Semua
                </a>
            </div>

            @forelse($orders as $order)
                <div class="order-row">
                    <div class="row align-items-center g-3">
                        <div class="col-md-4">
                            <div class="order-number">{{ $order->order_number }}</div>
                            <small class="muted">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <div class="col-md-3">
                            <div class="price">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </div>
                            <small class="muted">
                                {{ $order->payment_method === 'cod' ? 'COD' : ($order->payment_method === 'qris' ? 'QRIS' : 'Bank Transfer') }}
                            </small>
                        </div>

                        <div class="col-md-3">
                            @if($order->order_status === 'cancelled')
                                <span class="badge bg-secondary">Dibatalkan</span>
                            @elseif($order->payment_status === 'verified')
                                <span class="badge bg-success">Pembayaran Terverifikasi</span>
                            @elseif($order->payment_status === 'waiting_verification')
                                <span class="badge bg-info text-dark">Menunggu Verifikasi</span>
                            @elseif($order->payment_status === 'rejected')
                                <span class="badge bg-danger">Pembayaran Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                            @endif
                        </div>

                        <div class="col-md-2 text-md-end">
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="btn btn-hike btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-receipt"></i>
                    <h5 class="mt-3 fw-bold">Belum Ada Pesanan</h5>
                    <p class="text-muted">
                        Pesanan yang kamu buat akan muncul di sini.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-hike">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>
    </section>
</main>

<footer>
    <div class="container">
        © {{ date('Y') }} HikeGear · Teman Petualanganmu
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
