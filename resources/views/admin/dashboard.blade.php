
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin | HikeGear</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --forest: #304d38;
            --forest-dark: #223a29;
            --sage: #6c8b57;
            --cream: #f6f8f4;
            --muted: #7b857b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--cream);
            color: #28372c;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 255px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--forest-dark);
            padding: 26px 18px;
            color: white;
            z-index: 1000;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .brand span { color: #a9c68e; }

        .sidebar-subtitle {
            font-size: 12px;
            color: #c3d0c0;
            margin-bottom: 35px;
        }

        .menu-label {
            font-size: 11px;
            color: #a8b9a5;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 24px 12px 10px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #dce5d9;
            text-decoration: none;
            padding: 12px 14px;
            margin-bottom: 7px;
            border-radius: 10px;
            transition: .2s;
        }

        .side-link:hover, .side-link.active {
            background: #456347;
            color: white;
        }

        .side-link i { font-size: 18px; }

        .main {
            margin-left: 255px;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .subtext { color: var(--muted); font-size: 14px; }

        .admin-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 1px solid #e7ebe4;
            padding: 9px 14px;
            border-radius: 13px;
        }

        .admin-avatar {
            background: #e5eee0;
            color: var(--forest);
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 20px;
        }

        .welcome {
            background: linear-gradient(120deg, #304d38, #58764a);
            color: white;
            padding: 28px;
            border-radius: 20px;
            margin-bottom: 26px;
            position: relative;
            overflow: hidden;
        }

        .welcome h2 {
            font-weight: 800;
            font-size: 25px;
            margin-bottom: 9px;
        }

        .welcome p {
            color: #e0e9db;
            max-width: 570px;
            margin-bottom: 20px;
        }

        .welcome-icon {
            position: absolute;
            right: 35px;
            top: 5px;
            font-size: 125px;
            opacity: .13;
        }

        .welcome .btn {
            background: #f4f7ef;
            color: var(--forest);
            font-weight: 700;
            border: none;
            padding: 10px 17px;
        }

        .stat-card {
            background: white;
            padding: 21px;
            border-radius: 17px;
            border: 1px solid #e9ede6;
            height: 100%;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px #263d2810;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 47px;
            height: 47px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            font-size: 22px;
        }

        .green { background: #e4efdf; color: #42683a; }
        .blue { background: #e4effb; color: #3268a2; }
        .orange { background: #fff0dc; color: #aa6b1d; }
        .purple { background: #eee8fc; color: #7054a8; }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .stat-label {
            font-size: 13px;
            color: var(--muted);
            margin-top: 8px;
        }

        .section-heading {
            font-size: 19px;
            font-weight: 800;
            margin: 0;
        }

        .panel {
            background: white;
            border: 1px solid #e9ede6;
            border-radius: 17px;
            padding: 23px;
            margin-top: 27px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 15px;
            border: 1px solid #e9ede6;
            border-radius: 13px;
            text-decoration: none;
            color: #28372c;
            height: 100%;
            transition: .2s;
        }

        .quick-link:hover {
            border-color: #91aa81;
            background: #f8faf6;
            color: var(--forest);
        }

        .quick-icon {
            min-width: 44px;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #e5eee0;
            color: var(--forest);
            font-size: 21px;
        }

        .quick-link small {
            display: block;
            color: var(--muted);
            margin-top: 4px;
        }

        .table th {
            background: #f1f5ee;
            color: #5b695b;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 13px;
        }

        .table td {
            padding: 15px 13px;
            vertical-align: middle;
            font-size: 13px;
        }

        .order-number {
            font-weight: 700;
            color: var(--forest);
        }

        .amount { font-weight: 800; white-space: nowrap; }

        .btn-view {
            border: 1px solid #dce6d6;
            color: var(--forest);
            background: white;
            border-radius: 8px;
            padding: 6px 10px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-view:hover {
            background: var(--forest);
            color: white;
        }

        .logout-btn {
            border: 1px solid #6e8770;
            color: #f1f5ee;
            background: transparent;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            margin-top: 30px;
        }

        .logout-btn:hover {
            background: #456347;
            color: white;
        }

        .mobile-menu {
            display: none;
            background: var(--forest);
            color: white;
            border: 0;
            border-radius: 9px;
            padding: 8px 12px;
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s;
            }

            .sidebar.open { transform: translateX(0); }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-menu { display: inline-block; }
            .welcome-icon { right: 10px; font-size: 90px; }
        }

        @media (max-width: 575px) {
            .main { padding: 15px; }
            .page-title { font-size: 23px; }
            .topbar { align-items: flex-start; }
            .admin-chip { padding: 7px; }
            .admin-info { display: none; }
            .welcome { padding: 22px; }
            .welcome h2 { font-size: 22px; }
            .welcome-icon { display: none; }
            .stat-number { font-size: 25px; }
            .panel { padding: 15px; }
        }
    </style>
</head>

<body>

<aside class="sidebar" id="sidebar">
    <div class="brand">Hike<span>Gear</span></div>
    <div class="sidebar-subtitle">Outdoor Equipment Store</div>

    <div class="menu-label">Menu Utama</div>

    <a href="{{ route('admin.dashboard') }}" class="side-link active">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>

    <a href="{{ route('admin.orders.index') }}" class="side-link">
        <i class="bi bi-bag-check"></i> Kelola Pesanan
    </a>

    <a href="{{ route('admin.payments.index') }}" class="side-link">
        <i class="bi bi-credit-card"></i> Pembayaran
    </a>

    <div class="menu-label">Ringkasan</div>

    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="side-link">
        <i class="bi bi-box-seam"></i> Pesanan Diproses
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="side-link">
        <i class="bi bi-truck"></i> Pesanan Dikirim
    </a>

    <form action="{{ route('logout') }}" method="POST"
          onsubmit="return confirm('Yakin ingin keluar dari akun admin?')">
        @csrf
        <button class="logout-btn" type="submit">
            <i class="bi bi-box-arrow-left me-2"></i> Keluar
        </button>
    </form>
</aside>

<main class="main">
    <div class="topbar">
        <div class="d-flex align-items-start gap-3">
            <button class="mobile-menu" type="button" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <h1 class="page-title">Dashboard Admin</h1>
                <div class="subtext">Pantau aktivitas toko HikeGear hari ini.</div>
            </div>
        </div>

        <div class="admin-chip">
            <div class="admin-avatar"><i class="bi bi-person-fill-gear"></i></div>
            <div class="admin-info">
                <div class="fw-bold small">{{ auth()->user()->name }}</div>
                <div class="subtext" style="font-size: 12px;">Administrator</div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <section class="welcome">
        <i class="bi bi-mountain welcome-icon"></i>
        <h2>Selamat datang, {{ auth()->user()->name }}! 👋</h2>
        <p>
            Kelola produk, pantau pembayaran, dan pastikan setiap pesanan
            perlengkapan outdoor pelanggan diproses dengan baik.
        </p>
        <a href="{{ route('admin.orders.index') }}" class="btn">
            <i class="bi bi-arrow-right-circle me-2"></i>Lihat Pesanan
        </a>
    </section>

    <section class="row g-3">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon green"><i class="bi bi-box-seam"></i></div>
                    <span class="subtext">Katalog</span>
                </div>
                <div class="stat-number">{{ number_format($totalProduk, 0, ',', '.') }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon blue"><i class="bi bi-tags"></i></div>
                    <span class="subtext">Kategori</span>
                </div>
                <div class="stat-number">{{ number_format($totalKategori, 0, ',', '.') }}</div>
                <div class="stat-label">Kategori Produk</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon purple"><i class="bi bi-people"></i></div>
                    <span class="subtext">Akun</span>
                </div>
                <div class="stat-number">{{ number_format($totalPelanggan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon orange"><i class="bi bi-receipt"></i></div>
                    <span class="subtext">Transaksi</span>
                </div>
                <div class="stat-number">{{ number_format($totalPesanan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-6">
            <div class="stat-card">
                <div class="stat-top mb-3">
                    <div>
                        <div class="stat-label mt-0">Total Pendapatan Terverifikasi</div>
                        <div class="stat-number mt-2" style="font-size: 25px;">
                            Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="stat-icon green"><i class="bi bi-cash-stack"></i></div>
                </div>
                <div class="subtext">Berdasarkan pesanan terverifikasi, diproses, dikirim, dan selesai.</div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="stat-card">
                <div class="stat-top mb-3">
                    <div>
                        <div class="stat-label mt-0">Pesanan Perlu Perhatian</div>
                        <div class="stat-number mt-2">{{ number_format($pesananBaru, 0, ',', '.') }}</div>
                    </div>
                    <div class="stat-icon orange"><i class="bi bi-clock-history"></i></div>
                </div>
                <div class="subtext">Pesanan menunggu pembayaran atau verifikasi.</div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success mt-3">
                    Periksa pesanan
                </a>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-heading">Status Pesanan</h2>
                <div class="subtext mt-1">Ringkasan tahapan transaksi saat ini</div>
            </div>
            <i class="bi bi-bar-chart-line fs-3" style="color: var(--sage);"></i>
        </div>

        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="p-3 rounded-3" style="background:#f0f5ed;">
                    <div class="subtext mb-2">Terverifikasi</div>
                    <div class="fs-3 fw-bold">{{ $ordersVerified = \App\Models\Order::where('order_status', 'payment_verified')->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 rounded-3" style="background:#eaf1fb;">
                    <div class="subtext mb-2">Diproses</div>
                    <div class="fs-3 fw-bold">{{ $pesananDiproses }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 rounded-3" style="background:#e5f5f5;">
                    <div class="subtext mb-2">Dikirim</div>
                    <div class="fs-3 fw-bold">{{ $pesananDikirim }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 rounded-3" style="background:#e4f2e4;">
                    <div class="subtext mb-2">Selesai</div>
                    <div class="fs-3 fw-bold">{{ $pesananSelesai }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-heading">Akses Cepat</h2>
                <div class="subtext mt-1">Menu yang sering digunakan admin</div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <a href="{{ route('admin.orders.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-bag-check"></i></div>
                    <div>
                        <strong>Kelola Pesanan</strong>
                        <small>Periksa transaksi dan proses pengiriman</small>
                    </div>
                    <i class="bi bi-arrow-up-right ms-auto"></i>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="{{ route('admin.payments.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-credit-card"></i></div>
                    <div>
                        <strong>Kelola Pembayaran</strong>
                        <small>Verifikasi atau tolak bukti pembayaran</small>
                    </div>
                    <i class="bi bi-arrow-up-right ms-auto"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-heading">Pesanan Terbaru</h2>
                <div class="subtext mt-1">Lima transaksi terakhir di toko</div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success">
                Lihat semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pesananTerbaru as $order)
                    @php
                        $labels = [
                            'pending_payment' => 'Menunggu Pembayaran',
                            'waiting_verification' => 'Menunggu Verifikasi',
                            'payment_verified' => 'Terverifikasi',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];

                        $colors = [
                            'pending_payment' => 'secondary',
                            'waiting_verification' => 'warning',
                            'payment_verified' => 'success',
                            'processing' => 'primary',
                            'shipped' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp
                    <tr>
                        <td><span class="order-number">{{ $order->order_number }}</span></td>
                        <td>{{ $order->recipient_name ?? $order->user?->name ?? 'Pelanggan' }}</td>
                        <td class="amount">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge text-bg-{{ $colors[$order->order_status] ?? 'secondary' }}">
                                {{ $labels[$order->order_status] ?? $order->order_status }}
                            </span>
                        </td>
                        <td class="text-nowrap">{{ $order->created_at?->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-view">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <footer class="text-center subtext py-4">
        © {{ date('Y') }} HikeGear. Admin Panel · Explore More, Worry Less.
    </footer>
</main>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
</script>
</body>
</html>
