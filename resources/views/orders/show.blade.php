
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - HikeGear</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7f2;
            font-family: Arial, sans-serif;
        }

        .navbar { background: #173b2c; }

        .navbar-brand, .nav-link { color: white !important; }

        .page-title, .section-title {
            color: #173b2c;
            font-weight: 700;
        }

        .order-number {
            color: #198754;
            font-size: 20px;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
        }

        .product-item {
            border-bottom: 1px solid #eee;
            padding: 18px 0;
        }

        .product-item:last-child { border-bottom: none; }

        .product-image, .placeholder-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .product-image { object-fit: cover; }

        .placeholder-image {
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
        }

        .total-box, .address-box {
            background: #f8faf8;
            border-radius: 12px;
            padding: 18px;
        }

        .total-price {
            color: #198754;
            font-size: 22px;
            font-weight: 700;
        }

        .info-label {
            color: #777;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .status-badge {
            border-radius: 20px;
            padding: 8px 13px;
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

        .btn-cancel {
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
            <i class="bi bi-tree-fill"></i> HikeGear
        </a>

        <div class="d-flex gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                <i class="bi bi-shop"></i> Belanja
            </a>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                <i class="bi bi-cart"></i> Keranjang
            </a>
        </div>
    </div>
</nav>

<div class="container pb-5">

    {{-- HEADER --}}
    <div class="mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Pesanan
        </a>

        <h2 class="page-title">
            <i class="bi bi-receipt"></i> Detail Pesanan
        </h2>

        <p class="text-muted mb-0">Informasi lengkap pesanan kamu.</p>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STATUS PENGAJUAN PEMBATALAN --}}
    @if($order->cancellation_status === 'pending')
        <div class="alert alert-warning">
            <h6 class="fw-bold">
                <i class="bi bi-hourglass-split"></i>
                Pengajuan Pembatalan Sedang Ditinjau
            </h6>
            <p class="mb-1">
                Pengajuan kamu sedang menunggu keputusan admin.
                Pesanan belum resmi dibatalkan.
            </p>
            <div>
                <strong>Alasan:</strong>
                {{ $order->cancellation_reason }}
            </div>
        </div>

    @elseif($order->cancellation_status === 'approved')
        <div class="alert alert-success">
            <h6 class="fw-bold">
                <i class="bi bi-check-circle-fill"></i>
                Pembatalan Disetujui
            </h6>
            Pesanan kamu telah disetujui untuk dibatalkan oleh admin.

            @if($order->payment_status === 'verified')
                <div class="mt-2">
                    Pengembalian dana ditangani secara manual oleh admin.
                    Hubungi admin untuk informasi proses refund.
                </div>
            @endif
        </div>

    @elseif($order->cancellation_status === 'rejected')
        <div class="alert alert-danger">
            <h6 class="fw-bold">
                <i class="bi bi-x-circle-fill"></i>
                Pengajuan Pembatalan Ditolak
            </h6>
            <div>
                <strong>Alasan pengajuan sebelumnya:</strong>
                {{ $order->cancellation_reason }}
            </div>
            <div class="small mt-2">
                Jika pesanan masih memenuhi syarat, kamu dapat mengajukan kembali.
            </div>
        </div>
    @endif

    {{-- INFORMASI PESANAN --}}
    <div class="card p-4 mb-4">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="info-label">Nomor Pesanan</div>
                <div class="order-number">{{ $order->order_number }}</div>

                <div class="small text-muted mt-2">
                    <i class="bi bi-calendar3"></i>
                    {{ $order->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="info-label">Status Pembayaran</div>

                @if($order->payment_status === 'pending')
                    <span class="badge bg-warning text-dark status-badge">
                        Menunggu Pembayaran
                    </span>
                @elseif($order->payment_status === 'waiting_verification')
                    <span class="badge bg-info text-dark status-badge">
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

            <div class="col-md-3">
                <div class="info-label">Status Pesanan</div>

                @switch($order->order_status)
                    @case('pending_payment')
                        <span class="badge bg-warning text-dark status-badge">Menunggu Pembayaran</span>
                        @break
                    @case('waiting_verification')
                        <span class="badge bg-info text-dark status-badge">Menunggu Verifikasi</span>
                        @break
                    @case('payment_verified')
                        <span class="badge bg-primary status-badge">Pembayaran Terverifikasi</span>
                        @break
                    @case('processing')
                        <span class="badge bg-secondary status-badge">Sedang Diproses</span>
                        @break
                    @case('shipped')
                        <span class="badge bg-primary status-badge">Dikirim</span>
                        @break
                    @case('completed')
                        <span class="badge bg-success status-badge">Selesai</span>
                        @break
                    @case('cancelled')
                        <span class="badge bg-danger status-badge">Dibatalkan</span>
                        @break
                @endswitch
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- KOLOM KIRI --}}
        <div class="col-lg-8">

            {{-- PRODUK --}}
            <div class="card p-4 mb-4">
                <h5 class="section-title mb-3">
                    <i class="bi bi-bag-fill"></i> Produk Pesanan
                </h5>

                @foreach($order->items as $item)
                    <div class="product-item d-flex gap-3">
                        @if($item->product && $item->product->image)
                            <img
                                src="{{ asset('storage/' . $item->product->image) }}"
                                class="product-image"
                                alt="{{ $item->product_name }}"
                            >
                        @else
                            <div class="placeholder-image">
                                <i class="bi bi-image fs-4"></i>
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            <div class="text-muted small">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                × {{ $item->quantity }}
                            </div>
                        </div>

                        <div class="fw-bold text-nowrap">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ALAMAT --}}
            <div class="card p-4 mb-4">
                <h5 class="section-title mb-3">
                    <i class="bi bi-geo-alt-fill"></i> Alamat Pengiriman
                </h5>

                <div class="address-box">
                    <h6 class="fw-bold">{{ $order->recipient_name }}</h6>

                    <div class="text-muted mb-2">
                        <i class="bi bi-telephone"></i> {{ $order->phone }}
                    </div>

                    <div class="text-muted">
                        {{ $order->address }},
                        {{ $order->district }},
                        {{ $order->city }},
                        {{ $order->province }}
                        {{ $order->postal_code }}
                    </div>
                </div>
            </div>

            {{-- PENGIRIMAN --}}
            <div class="card p-4 mb-4">
                <h5 class="section-title mb-3">
                    <i class="bi bi-truck"></i> Pengiriman
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label">Kurir</div>
                        <strong>{{ $order->shipping_courier }}</strong>
                    </div>

                    <div class="col-md-6">
                        <div class="info-label">Layanan</div>
                        <strong>{{ $order->shipping_service }}</strong>
                    </div>
                </div>

                @if($order->shipment && $order->shipment->tracking_number)
                    <hr>
                    <div class="info-label">Nomor Resi</div>
                    <strong>{{ $order->shipment->tracking_number }}</strong>
                @endif
            </div>

            {{-- AJUKAN PEMBATALAN --}}
            @php
                $cancellationAllowed = in_array($order->order_status, [
                    'pending_payment',
                    'waiting_verification',
                    'payment_verified',
                    'processing',
                ], true);

                $cancellationAlreadyRequested = in_array(
                    $order->cancellation_status,
                    ['pending', 'approved'],
                    true
                );
            @endphp

            @if($cancellationAllowed && !$cancellationAlreadyRequested)
                <div class="card p-4 mb-4">
                    <h5 class="section-title mb-2">
                        <i class="bi bi-x-octagon"></i>
                        Ajukan Pembatalan Pesanan
                    </h5>

                    <p class="text-muted small">
                        Pengajuan akan ditinjau oleh admin. Pesanan tidak langsung
                        dibatalkan setelah tombol ini ditekan.
                    </p>

                    @if($order->payment_status === 'verified')
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Pembayaran sudah terverifikasi. Jika pembatalan disetujui,
                            pengembalian dana ditangani secara manual oleh admin.
                        </div>
                    @endif

                    <form
                        action="{{ route('orders.cancel', $order->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin mengajukan pembatalan pesanan ini?')"
                    >
                        @csrf

                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label fw-semibold">
                                Alasan Pembatalan
                            </label>

                            <textarea
                                name="cancellation_reason"
                                id="cancellation_reason"
                                class="form-control @error('cancellation_reason') is-invalid @enderror"
                                rows="3"
                                maxlength="1000"
                                placeholder="Tuliskan alasan kamu ingin membatalkan pesanan..."
                                required
                            >{{ old('cancellation_reason') }}</textarea>

                            @error('cancellation_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger btn-cancel">
                            <i class="bi bi-x-circle"></i>
                            Ajukan Pembatalan
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-4">

            {{-- RINGKASAN --}}
            <div class="card p-4 mb-4">
                <h5 class="section-title mb-4">Ringkasan Pembayaran</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <hr>

                <div class="total-box">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <span class="fw-bold">Total</span>
                        <span class="total-price text-end">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- PEMBAYARAN --}}
            <div class="card p-4">
                <h5 class="section-title mb-3">
                    <i class="bi bi-wallet2"></i> Pembayaran
                </h5>

                <div class="info-label">Metode Pembayaran</div>

                <strong>
                    @if($order->payment_method === 'bank_transfer')
                        <i class="bi bi-bank"></i> Bank Transfer
                    @elseif($order->payment_method === 'qris')
                        <i class="bi bi-qr-code"></i> QRIS
                    @else
                        <i class="bi bi-cash-stack"></i> COD
                    @endif
                </strong>

                <div class="mt-3">
                    <div class="info-label">Status Pembayaran</div>

                    @if($order->payment_status === 'verified')
                        <span class="badge bg-success status-badge">Terverifikasi</span>
                    @elseif($order->payment_status === 'waiting_verification')
                        <span class="badge bg-info text-dark status-badge">Menunggu Verifikasi</span>
                    @elseif($order->payment_status === 'rejected')
                        <span class="badge bg-danger status-badge">Pembayaran Ditolak</span>
                    @else
                        <span class="badge bg-warning text-dark status-badge">Menunggu Pembayaran</span>
                    @endif
                </div>

                {{-- COD --}}
                @if($order->payment_method === 'cod')
                    <div class="alert alert-success mt-3 mb-0">
                        <i class="bi bi-cash-stack"></i>
                        <strong>Pembayaran COD</strong>
                        <div class="small mt-1">
                            Kamu tidak perlu mengupload bukti pembayaran.
                            Pembayaran dilakukan saat pesanan diterima.
                        </div>
                    </div>

                {{-- BANK TRANSFER / QRIS --}}
                @elseif(
                    $order->payment_status !== 'verified'
                    && $order->order_status !== 'cancelled'
                    && $order->cancellation_status !== 'pending'
                    && $order->cancellation_status !== 'approved'
                )
                    <hr class="my-4">

                    <h6 class="fw-bold">Upload Bukti Pembayaran</h6>

                    <p class="small text-muted">
                        Upload foto atau screenshot bukti pembayaran.
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @if($order->payment_status === 'rejected')
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Bukti pembayaran sebelumnya ditolak oleh admin.
                            Silakan upload bukti yang benar.
                        </div>
                    @endif

                    <form
                        action="{{ route('payments.upload', $order->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="mb-3">
                            <label for="proof" class="form-label fw-semibold">
                                Bukti Pembayaran
                            </label>

                            <input
                                type="file"
                                name="proof"
                                id="proof"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                                required
                            >

                            @error('proof')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-hike w-100">
                            <i class="bi bi-cloud-arrow-up"></i>
                            Upload Bukti Pembayaran
                        </button>
                    </form>

                @elseif($order->payment_status === 'verified')
                    <div class="alert alert-success mt-3 mb-0">
                        <i class="bi bi-check-circle-fill"></i>
                        Bukti pembayaran sudah diverifikasi oleh admin.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

</body>
</html>
