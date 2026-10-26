<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pembayaran - HikeGear Admin</title>

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

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .07);
        }

        .section-title {
            color: #173b2c;
            font-weight: 700;
        }

        .info-label {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: 600;
            margin-bottom: 16px;
        }

        .total-price {
            color: #198754;
            font-size: 24px;
            font-weight: 700;
        }

        .proof-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .proof-image {
            max-width: 100%;
            max-height: 600px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .btn-hike {
            background: #198754;
            color: white;
            border: none;
            border-radius: 9px;
            font-weight: 600;
        }

        .btn-hike:hover {
            background: #146c43;
            color: white;
        }

        .btn-danger-custom {
            border-radius: 9px;
            font-weight: 600;
        }

        .status-badge {
            border-radius: 20px;
            padding: 8px 12px;
            font-size: 12px;
        }

        .order-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .order-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>

<nav class="navbar mb-4">
    <div class="container">

        <a
            href="{{ route('admin.dashboard') }}"
            class="navbar-brand fw-bold"
        >
            <i class="bi bi-tree-fill"></i>
            HikeGear Admin
        </a>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.payments.index') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

            <a
                href="{{ route('admin.dashboard') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

        </div>

    </div>
</nav>


<div class="container pb-5">

    {{-- JUDUL --}}
    <div class="mb-4">

        <h2 class="page-title">

            <i class="bi bi-receipt"></i>

            Detail Pembayaran

        </h2>

        <p class="text-muted mb-0">

            Periksa detail pesanan dan bukti pembayaran pelanggan.

        </p>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle-fill"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-triangle-fill"></i>

            {{ session('error') }}

        </div>

    @endif


    <div class="row g-4">


        {{-- INFORMASI PEMBAYARAN --}}
        <div class="col-lg-5">

            <div class="card p-4 mb-4">

                <h5 class="section-title mb-4">

                    <i class="bi bi-credit-card"></i>

                    Informasi Pembayaran

                </h5>


                <div class="info-label">
                    Nomor Pesanan
                </div>

                <div class="info-value">

                    {{ $payment->order->order_number }}

                </div>


                <div class="info-label">
                    Pelanggan
                </div>

                <div class="info-value">

                    {{ $payment->order->user->name ?? '-' }}

                    <br>

                    <small class="text-muted">

                        {{ $payment->order->user->email ?? '-' }}

                    </small>

                </div>


                <div class="info-label">
                    Metode Pembayaran
                </div>

                <div class="info-value">

                    @if($payment->method === 'bank_transfer')

                        <i class="bi bi-bank text-success"></i>

                        Bank Transfer

                    @elseif($payment->method === 'qris')

                        <i class="bi bi-qr-code text-success"></i>

                        QRIS

                    @else

                        <i class="bi bi-cash-stack text-success"></i>

                        COD

                    @endif

                </div>


                <div class="info-label">
                    Total Pembayaran
                </div>

                <div class="total-price mb-4">

                    Rp {{ number_format($payment->amount, 0, ',', '.') }}

                </div>


                <div class="info-label">
                    Status Pembayaran
                </div>

                <div class="mb-3">

                    @if($payment->status === 'verified')

                        <span class="badge bg-success status-badge">

                            <i class="bi bi-check-circle"></i>

                            Terverifikasi

                        </span>

                    @elseif($payment->status === 'rejected')

                        <span class="badge bg-danger status-badge">

                            <i class="bi bi-x-circle"></i>

                            Ditolak

                        </span>

                    @elseif($payment->proof)

                        <span class="badge bg-info status-badge">

                            <i class="bi bi-hourglass-split"></i>

                            Menunggu Verifikasi

                        </span>

                    @else

                        <span class="badge bg-warning text-dark status-badge">

                            <i class="bi bi-clock"></i>

                            Menunggu Pembayaran

                        </span>

                    @endif

                </div>


                {{-- TOMBOL VERIFIKASI --}}
                @if(
                    $payment->method !== 'cod' &&
                    $payment->status !== 'verified' &&
                    $payment->proof
                )

                    <div class="d-grid gap-2">

                        <form
                            action="{{ route('admin.payments.verify', $payment->id) }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-hike w-100"
                                onclick="return confirm('Yakin ingin memverifikasi pembayaran ini?')"
                            >

                                <i class="bi bi-check-circle"></i>

                                Verifikasi Pembayaran

                            </button>

                        </form>


                        <form
                            action="{{ route('admin.payments.reject', $payment->id) }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-danger btn-danger-custom w-100"
                                onclick="return confirm('Yakin ingin menolak pembayaran ini?')"
                            >

                                <i class="bi bi-x-circle"></i>

                                Tolak Pembayaran

                            </button>

                        </form>

                    </div>

                @elseif($payment->status === 'verified')

                    <div class="alert alert-success mb-0">

                        <i class="bi bi-check-circle-fill"></i>

                        Pembayaran ini sudah diverifikasi.

                    </div>

                @elseif($payment->status === 'rejected')

                    <div class="alert alert-danger mb-0">

                        <i class="bi bi-x-circle-fill"></i>

                        Pembayaran ini ditolak.

                    </div>

                @elseif($payment->method === 'cod')

                    <div class="alert alert-success mb-0">

                        <i class="bi bi-cash-stack"></i>

                        Pembayaran COD tidak membutuhkan verifikasi.

                    </div>

                @endif

            </div>


            {{-- ALAMAT PENGIRIMAN --}}
            <div class="card p-4">

                <h5 class="section-title mb-4">

                    <i class="bi bi-geo-alt"></i>

                    Alamat Pengiriman

                </h5>


                @if($payment->order->address)

                    <div class="info-label">
                        Nama Penerima
                    </div>

                    <div class="info-value">
                        {{ $payment->order->recipient_name }}
                    </div>


                    <div class="info-label">
                        Nomor HP
                    </div>

                    <div class="info-value">
                        {{ $payment->order->phone }}
                    </div>


                    <div class="info-label">
                        Alamat
                    </div>

                    <div class="info-value">

                        {{ $payment->order->address }}

                        <br>

                        {{ $payment->order->district }},
                        {{ $payment->order->city }},
                        {{ $payment->order->province }}

                        <br>

                        {{ $payment->order->postal_code }}

                    </div>

                @else

                    <p class="text-muted mb-0">
                        Data alamat tidak tersedia.
                    </p>

                @endif

            </div>

        </div>


        {{-- BUKTI PEMBAYARAN --}}
        <div class="col-lg-7">

            <div class="card p-4 mb-4">

                <h5 class="section-title mb-4">

                    <i class="bi bi-image"></i>

                    Bukti Pembayaran

                </h5>


                @if($payment->proof)

                    <div class="proof-box">

                        <img
                            src="{{ asset('storage/' . $payment->proof) }}"
                            alt="Bukti Pembayaran"
                            class="proof-image"
                        >

                        <div class="mt-3">

                            <a
                                href="{{ asset('storage/' . $payment->proof) }}"
                                target="_blank"
                                class="btn btn-outline-success"
                            >

                                <i class="bi bi-arrows-fullscreen"></i>

                                Buka Gambar Penuh

                            </a>

                        </div>

                    </div>

                @else

                    <div class="text-center py-5">

                        <i
                            class="bi bi-image"
                            style="font-size: 60px; color: #adb5bd;"
                        ></i>

                        <h5 class="mt-3">
                            Belum Ada Bukti Pembayaran
                        </h5>

                        <p class="text-muted mb-0">

                            Pelanggan belum mengupload bukti pembayaran.

                        </p>

                    </div>

                @endif

            </div>


            {{-- DETAIL PRODUK --}}
            <div class="card p-4">

                <h5 class="section-title mb-3">

                    <i class="bi bi-box-seam"></i>

                    Produk Pesanan

                </h5>


                @foreach($payment->order->items as $item)

                    <div class="order-item">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <strong>
                                    {{ $item->product_name }}
                                </strong>

                                <div class="small text-muted mt-1">

                                    {{ $item->quantity }}
                                    ×
                                    Rp {{ number_format($item->price, 0, ',', '.') }}

                                </div>

                            </div>


                            <strong class="text-success">

                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                            </strong>

                        </div>

                    </div>

                @endforeach


                <div class="border-top mt-3 pt-3">

                    <div class="d-flex justify-content-between">

                        <span>
                            Subtotal
                        </span>

                        <strong>

                            Rp {{ number_format($payment->order->subtotal, 0, ',', '.') }}

                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mt-2">

                        <span>
                            Ongkir
                        </span>

                        <strong>

                            Rp {{ number_format($payment->order->shipping_cost, 0, ',', '.') }}

                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mt-3 fs-5">

                        <strong>
                            Total
                        </strong>

                        <strong class="text-success">

                            Rp {{ number_format($payment->order->total, 0, ',', '.') }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>