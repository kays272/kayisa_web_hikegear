<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan | HikeGear Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f2;
            color: #28372c;
        }

        .navbar {
            background: #304d38;
        }

        .panel {
            background: white;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 4px 18px #203b2710;
        }

        .btn-green {
            background: #304d38;
            color: white;
        }

        .btn-green:hover {
            background: #243b2b;
            color: white;
        }

        .label {
            color: #738075;
            font-size: .85rem;
            margin-bottom: 4px;
        }

        .value {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .table th {
            background: #edf2eb;
        }

        .cancellation-panel {
            border-left: 5px solid #d39e00;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container px-3">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            HikeGear Admin
        </a>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesanan
        </a>
    </div>
</nav>

<div class="container pb-5">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Detail Pesanan</h2>
        <p class="text-secondary mb-0">{{ $order->order_number }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $statusLabels = [
            'pending_payment' => 'Menunggu Pembayaran',
            'waiting_verification' => 'Menunggu Verifikasi',
            'payment_verified' => 'Pembayaran Terverifikasi',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Sedang Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $paymentLabels = [
            'pending' => 'Belum Dibayar',
            'waiting_verification' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
        ];

        $cancellationLabels = [
            'pending' => 'Menunggu Keputusan Admin',
            'approved' => 'Pembatalan Disetujui',
            'rejected' => 'Pembatalan Ditolak',
        ];

        $paymentStatus = $order->payment?->status ?? $order->payment_status;

        $canManageCancellation =
            $order->cancellation_status === 'pending';

        $isCancellationPendingOrApproved =
            in_array($order->cancellation_status, ['pending', 'approved'], true);
    @endphp

    {{-- INFORMASI PERMINTAAN PEMBATALAN --}}
    @if($order->cancellation_status)
        <div class="panel cancellation-panel p-4 mb-4">

            <div class="d-flex align-items-start gap-3">
                <div class="fs-3 text-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-2">Permintaan Pembatalan Pesanan</h5>

                    <p class="mb-2">
                        Status:
                        <span class="badge
                            @if($order->cancellation_status === 'pending')
                                text-bg-warning
                            @elseif($order->cancellation_status === 'approved')
                                text-bg-success
                            @else
                                text-bg-danger
                            @endif">
                            {{ $cancellationLabels[$order->cancellation_status] ?? $order->cancellation_status }}
                        </span>
                    </p>

                    <div class="label">Alasan dari Pembeli</div>

                    <div class="p-3 rounded bg-light mb-3"
                         style="white-space: pre-line; overflow-wrap: anywhere;">{{ $order->cancellation_reason ?: 'Pembeli tidak memberikan alasan.' }}</div>

                    @if($order->cancellation_status === 'pending')
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle me-1"></i>
                            Pembeli meminta pembatalan. Periksa alasan sebelum mengambil keputusan.
                        </div>

                        @if($paymentStatus === 'verified')
                            <div class="alert alert-info">
                                <i class="bi bi-cash-coin me-1"></i>
                                Pembayaran sudah terverifikasi. Jika pembatalan disetujui,
                                pengembalian dana harus dilakukan secara manual oleh admin.
                            </div>
                        @endif

                        <div class="row g-3">

                            {{-- SETUJUI PEMBATALAN --}}
                            <div class="col-md-6">
                                <form
                                    action="{{ route('admin.orders.cancel.approve', $order) }}"
                                    method="POST"
                                    onsubmit="return confirm('Setujui pembatalan pesanan ini? Stok produk akan dikembalikan.')">
                                    @csrf

                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Setujui Pembatalan
                                    </button>
                                </form>
                            </div>

                            {{-- TOLAK PEMBATALAN --}}
                            <div class="col-md-6">
                                <form
                                    action="{{ route('admin.orders.cancel.reject', $order) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tolak permintaan pembatalan ini?')">
                                    @csrf

                                    <label for="admin_cancellation_note" class="form-label fw-semibold">
                                        Catatan Admin (Opsional)
                                    </label>

                                    <textarea
                                        name="admin_cancellation_note"
                                        id="admin_cancellation_note"
                                        class="form-control mb-2"
                                        rows="3"
                                        maxlength="1000"
                                        placeholder="Tuliskan alasan penolakan jika diperlukan">{{ old('admin_cancellation_note') }}</textarea>

                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Tolak Pembatalan
                                    </button>
                                </form>
                            </div>

                        </div>

                    @elseif($order->cancellation_status === 'approved')
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-1"></i>
                            Pembatalan sudah disetujui. Stok produk telah dikembalikan melalui proses persetujuan.
                        </div>

                        @if($paymentStatus === 'verified')
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="bi bi-cash-coin me-1"></i>
                                Pastikan pengembalian dana kepada pembeli sudah ditangani secara manual.
                            </div>
                        @endif

                    @elseif($order->cancellation_status === 'rejected')
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle me-1"></i>
                            Permintaan pembatalan ditolak. Pesanan tidak dibatalkan oleh keputusan ini.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-8">

            {{-- INFORMASI PESANAN --}}
            <div class="panel p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-receipt me-2"></i>Informasi Pesanan
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="label">Nomor Pesanan</div>
                        <div class="value">{{ $order->order_number }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Tanggal Pesanan</div>
                        <div class="value">{{ $order->created_at?->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Status Pesanan</div>
                        <div class="value">
                            {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Status Pembayaran</div>
                        <div class="value">
                            {{ $paymentLabels[$paymentStatus] ?? ucfirst(str_replace('_', ' ', $paymentStatus ?? '-')) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Metode Pembayaran</div>
                        <div class="value">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Kurir / Layanan</div>
                        <div class="value">
                            {{ $order->shipping_courier ?? '-' }} - {{ $order->shipping_service ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- PRODUK PESANAN --}}
            <div class="panel p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-bag me-2"></i>Produk yang Dipesan
                </h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product_name ?? $item->product?->name ?? 'Produk' }}
                                    </td>

                                    <td>
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </td>

                                    <td>{{ $item->quantity }}</td>

                                    <td>
                                        Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary">
                                        Detail produk tidak tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="ms-auto" style="max-width: 350px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal Produk</span>
                        <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim</span>
                        <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- ALAMAT PENERIMA --}}
            <div class="panel p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Alamat Penerima
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="label">Nama Penerima</div>
                        <div class="value">{{ $order->recipient_name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="label">Nomor Telepon</div>
                        <div class="value">{{ $order->recipient_phone ?? '-' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="label">Alamat Lengkap</div>
                        <div class="value">
                            {{ $order->shipping_address ?? $order->address?->address ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- INFORMASI PENGIRIMAN --}}
            <div class="panel p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-truck me-2"></i>Informasi Pengiriman
                </h5>

                @if($order->shipment)
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="label">Kurir</div>
                            <div class="value">{{ $order->shipment->courier ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="label">Layanan</div>
                            <div class="value">{{ $order->shipment->service ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="label">Nomor Resi</div>
                            <div class="value">
                                {{ $order->shipment->tracking_number ?: 'Belum ada resi' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="label">Status Pengiriman</div>
                            <div class="value">
                                {{ ucfirst($order->shipment->status ?? '-') }}
                            </div>
                        </div>

                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        Data pengiriman belum tersedia untuk pesanan ini.
                    </div>
                @endif
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            {{-- DATA PELANGGAN --}}
            <div class="panel p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-person me-2"></i>Data Pelanggan
                </h5>

                <div class="mb-3">
                    <div class="label">Nama Akun</div>
                    <div class="value">{{ $order->user?->name ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <div class="label">Email</div>
                    <div class="value">{{ $order->user?->email ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Total Pesanan</div>
                    <div class="value fs-4">
                        Rp{{ number_format($order->total, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- TINDAKAN ADMIN --}}
            <div class="panel p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-gear me-2"></i>Tindakan Admin
                </h5>

                @if($order->order_status === 'cancelled')
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-x-circle me-1"></i>
                        Pesanan telah dibatalkan.
                    </div>

                @elseif($canManageCancellation)
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Selesaikan permintaan pembatalan terlebih dahulu sebelum mengubah status pesanan.
                    </div>

                @elseif($order->cancellation_status === 'approved')
                    <div class="alert alert-success mb-0">
                        Pembatalan telah disetujui. Tidak ada tindakan pemrosesan atau pengiriman lanjutan.
                    </div>

                @elseif($order->order_status === 'payment_verified')
                    <p class="small text-secondary">
                        Pembayaran telah terverifikasi. Pesanan dapat mulai diproses.
                    </p>

                    <form
                        action="{{ route('admin.orders.process', $order) }}"
                        method="POST"
                        onsubmit="return confirm('Mulai proses pesanan ini?')">
                        @csrf

                        <button class="btn btn-green w-100" type="submit">
                            <i class="bi bi-box-seam me-1"></i> Proses Pesanan
                        </button>
                    </form>

                @elseif($order->order_status === 'processing')
                    <p class="small text-secondary">
                        Pesanan siap dikirim. Masukkan nomor resi dari pihak kurir.
                    </p>

                    <form
                        action="{{ route('admin.orders.ship', $order) }}"
                        method="POST"
                        onsubmit="return confirm('Tandai pesanan sebagai dikirim?')">
                        @csrf

                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Nomor Resi</label>

                            <input
                                type="text"
                                id="tracking_number"
                                name="tracking_number"
                                class="form-control"
                                value="{{ old('tracking_number', $order->shipment?->tracking_number) }}"
                                maxlength="100"
                                required>
                        </div>

                        <button class="btn btn-green w-100" type="submit">
                            <i class="bi bi-truck me-1"></i> Tandai Dikirim
                        </button>
                    </form>

                @elseif($order->order_status === 'shipped')
                    <p class="small text-secondary">
                        Pesanan sudah dikirim. Tandai selesai setelah barang diterima pelanggan.
                    </p>

                    <form
                        action="{{ route('admin.orders.complete', $order) }}"
                        method="POST"
                        onsubmit="return confirm('Pastikan barang telah diterima pelanggan. Selesaikan pesanan ini?')">
                        @csrf

                        <button class="btn btn-success w-100" type="submit">
                            <i class="bi bi-check-circle me-1"></i> Selesaikan Pesanan
                        </button>
                    </form>

                @elseif($order->order_status === 'completed')
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-1"></i>
                        Pesanan sudah selesai.
                    </div>

                @else
                    <div class="alert alert-warning mb-0">
                        Pesanan belum dapat diproses. Pastikan pembayaran telah diverifikasi terlebih dahulu.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>