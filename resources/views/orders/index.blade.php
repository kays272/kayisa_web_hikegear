<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Saya - HikeGear</title>

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
            background: #f5f7f2;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #173b2c;
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .page-title {
            color: #173b2c;
            font-weight: 700;
        }

        .order-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
            transition: .2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
        }

        .order-number {
            color: #173b2c;
            font-weight: 700;
        }

        .total-price {
            color: #198754;
            font-size: 18px;
            font-weight: 700;
        }

        .status-badge {
            border-radius: 20px;
            padding: 7px 12px;
            font-size: 12px;
        }

        .empty-box {
            background: white;
            border-radius: 16px;
            padding: 60px 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
        }

        .empty-icon {
            font-size: 60px;
            color: #198754;
        }

        .btn-hike {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
        }

        .btn-hike:hover {
            background: #146c43;
            color: white;
        }

        .info-label {
            color: #777;
            font-size: 13px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="{{ route('user.home') }}"
        >
            <i class="bi bi-tree-fill"></i>
            HikeGear
        </a>

        <div class="d-flex gap-2">

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-shop"></i>
                Belanja
            </a>

            <a
                href="{{ route('cart.index') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-cart"></i>
                Keranjang
            </a>

        </div>

    </div>
</nav>


<div class="container pb-5">

    {{-- HEADER --}}
    <div class="mb-4">

        <h2 class="page-title">
            <i class="bi bi-receipt"></i>
            Pesanan Saya
        </h2>

        <p class="text-muted mb-0">
            Lihat riwayat dan status pesanan kamu di HikeGear.
        </p>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>

    @endif


    {{-- JIKA BELUM ADA PESANAN --}}
    @if($orders->count() === 0)

        <div class="empty-box">

            <div class="empty-icon mb-3">
                <i class="bi bi-bag-x"></i>
            </div>

            <h4 class="fw-bold">
                Belum Ada Pesanan
            </h4>

            <p class="text-muted">
                Kamu belum melakukan pembelian di HikeGear.
            </p>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-hike"
            >
                <i class="bi bi-shop"></i>
                Mulai Belanja
            </a>

        </div>

    @else

        {{-- DAFTAR PESANAN --}}
        @foreach($orders as $order)

            <div class="card order-card mb-3">

                <div class="card-body p-4">

                    <div class="row align-items-center">

                        {{-- NOMOR PESANAN --}}
                        <div class="col-lg-3 mb-3 mb-lg-0">

                            <div class="info-label">
                                Nomor Pesanan
                            </div>

                            <div class="order-number">
                                {{ $order->order_number }}
                            </div>

                            <div class="small text-muted mt-1">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>

                        </div>


                        {{-- PEMBAYARAN --}}
                        <div class="col-lg-2 mb-3 mb-lg-0">

                            <div class="info-label">
                                Pembayaran
                            </div>

                            @if($order->payment_method === 'bank_transfer')

                                <strong>
                                    Bank Transfer
                                </strong>

                            @elseif($order->payment_method === 'qris')

                                <strong>
                                    QRIS
                                </strong>

                            @else

                                <strong>
                                    COD
                                </strong>

                            @endif

                            <div class="small mt-1">

                                @if($order->payment_status === 'pending')

                                    <span class="badge bg-warning text-dark status-badge">
                                        Menunggu Pembayaran
                                    </span>

                                @elseif($order->payment_status === 'waiting_verification')

                                    <span class="badge bg-info status-badge">
                                        Menunggu Verifikasi
                                    </span>

                                @elseif($order->payment_status === 'verified')

                                    <span class="badge bg-success status-badge">
                                        Terverifikasi
                                    </span>

                                @elseif($order->payment_status === 'rejected')

                                    <span class="badge bg-danger status-badge">
                                        Ditolak
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- STATUS PESANAN --}}
                        <div class="col-lg-2 mb-3 mb-lg-0">

                            <div class="info-label">
                                Status Pesanan
                            </div>

                            @switch($order->order_status)

                                @case('pending_payment')

                                    <span class="badge bg-warning text-dark status-badge">
                                        Menunggu Pembayaran
                                    </span>

                                    @break

                                @case('waiting_verification')

                                    <span class="badge bg-info status-badge">
                                        Menunggu Verifikasi
                                    </span>

                                    @break

                                @case('payment_verified')

                                    <span class="badge bg-primary status-badge">
                                        Pembayaran Terverifikasi
                                    </span>

                                    @break

                                @case('processing')

                                    <span class="badge bg-secondary status-badge">
                                        Sedang Diproses
                                    </span>

                                    @break

                                @case('shipped')

                                    <span class="badge bg-primary status-badge">
                                        Dikirim
                                    </span>

                                    @break

                                @case('completed')

                                    <span class="badge bg-success status-badge">
                                        Selesai
                                    </span>

                                    @break

                                @case('cancelled')

                                    <span class="badge bg-danger status-badge">
                                        Dibatalkan
                                    </span>

                                    @break

                            @endswitch

                        </div>


                        {{-- TOTAL --}}
                        <div class="col-lg-3 mb-3 mb-lg-0">

                            <div class="info-label">
                                Total Pesanan
                            </div>

                            <div class="total-price">

                                Rp
                                {{ number_format($order->total, 0, ',', '.') }}

                            </div>

                            <div class="small text-muted mt-1">

                                {{ $order->items->count() }}
                                jenis produk

                            </div>

                        </div>


                        {{-- DETAIL --}}
                        <div class="col-lg-2 text-lg-end">

                            <a
                                href="{{ route('orders.show', $order->id) }}"
                                class="btn btn-hike"
                            >
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach


        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $orders->links() }}

        </div>

    @endif

</div>

</body>
</html>