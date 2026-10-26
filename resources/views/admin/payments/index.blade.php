<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Pembayaran - HikeGear</title>

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
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
        }

        .table-card {
            overflow: hidden;
        }

        .table thead th {
            background: #173b2c;
            color: white;
            border: none;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .order-number {
            color: #173b2c;
            font-weight: 700;
        }

        .total-price {
            color: #198754;
            font-weight: 700;
        }

        .status-badge {
            border-radius: 20px;
            padding: 7px 11px;
            font-size: 12px;
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

        .empty-box {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 60px;
            color: #198754;
        }

        .payment-icon {
            font-size: 20px;
            color: #198754;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg mb-4">

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
                href="{{ route('admin.dashboard') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a
                href="{{ route('user.home') }}"
                class="btn btn-outline-light"
            >
                <i class="bi bi-house"></i>
                Website
            </a>

        </div>

    </div>

</nav>


<div class="container pb-5">

    {{-- HEADER --}}

    <div class="mb-4">

        <h2 class="page-title">
            <i class="bi bi-credit-card"></i>
            Verifikasi Pembayaran
        </h2>

        <p class="text-muted mb-0">
            Periksa pembayaran pelanggan dan lakukan verifikasi pesanan.
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


    {{-- DAFTAR PEMBAYARAN --}}

    <div class="card table-card">

        @if($payments->count() === 0)

            <div class="empty-box">

                <div class="empty-icon mb-3">
                    <i class="bi bi-receipt"></i>
                </div>

                <h4 class="fw-bold">
                    Belum Ada Pembayaran
                </h4>

                <p class="text-muted">
                    Belum ada data pembayaran yang masuk.
                </p>

            </div>

        @else

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th class="px-4">
                                No
                            </th>

                            <th>
                                Pesanan
                            </th>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Pembayaran
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Bukti
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($payments as $payment)

                            <tr>

                                {{-- NO --}}

                                <td class="px-4">

                                    {{ $payments->firstItem() + $loop->index }}

                                </td>


                                {{-- PESANAN --}}

                                <td>

                                    <div class="order-number">

                                        {{ $payment->order->order_number }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $payment->created_at->format('d M Y H:i') }}

                                    </small>

                                </td>


                                {{-- USER --}}

                                <td>

                                    @if($payment->order->user)

                                        <strong>
                                            {{ $payment->order->user->name }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $payment->order->user->email }}
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            User tidak ditemukan
                                        </span>

                                    @endif

                                </td>


                                {{-- METODE --}}

                                <td>

                                    @if($payment->method === 'bank_transfer')

                                        <span>
                                            <i class="bi bi-bank payment-icon"></i>
                                            Bank Transfer
                                        </span>

                                    @elseif($payment->method === 'qris')

                                        <span>
                                            <i class="bi bi-qr-code payment-icon"></i>
                                            QRIS
                                        </span>

                                    @else

                                        <span>
                                            <i class="bi bi-cash-stack payment-icon"></i>
                                            COD
                                        </span>

                                    @endif

                                </td>


                                {{-- TOTAL --}}

                                <td>

                                    <span class="total-price">

                                        Rp
                                        {{ number_format($payment->amount, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($payment->status === 'pending')

                                        <span class="badge bg-warning text-dark status-badge">
                                            Menunggu Pembayaran
                                        </span>

                                    @elseif($payment->status === 'verified')

                                        <span class="badge bg-success status-badge">
                                            Terverifikasi
                                        </span>

                                    @elseif($payment->status === 'rejected')

                                        <span class="badge bg-danger status-badge">
                                            Ditolak
                                        </span>

                                    @endif

                                </td>


                                {{-- BUKTI --}}

                                <td>

                                    @if($payment->proof)

                                        <span class="badge bg-success status-badge">
                                            <i class="bi bi-check"></i>
                                            Ada
                                        </span>

                                    @else

                                        <span class="badge bg-secondary status-badge">
                                            Tidak Ada
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <a
                                        href="{{ route('admin.payments.show', $payment->id) }}"
                                        class="btn btn-hike btn-sm"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            <div class="p-4">

                {{ $payments->links() }}

            </div>

        @endif

    </div>

</div>

</body>
</html>