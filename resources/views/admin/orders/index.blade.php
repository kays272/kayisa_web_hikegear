
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pesanan | HikeGear Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f2; color: #28372c; }
        .navbar { background: #304d38; }
        .panel { background: white; border: 0; border-radius: 16px; box-shadow: 0 4px 18px #203b2710; }
        .btn-green { background: #304d38; color: white; }
        .btn-green:hover { background: #243b2b; color: white; }
        .table th { background: #edf2eb; white-space: nowrap; }
        .table td { vertical-align: middle; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark mb-4">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-tree-fill me-2"></i>HikeGear Admin
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-light btn-sm">Pembayaran</a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 pb-5">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Kelola Pesanan</h2>
        <p class="text-secondary mb-0">Pantau pesanan pelanggan hingga proses pengiriman.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel p-3 p-md-4 mb-4">
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Cari nomor pesanan, nama, atau email pelanggan...">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua status pesanan</option>
                        @foreach([
                            'pending_payment' => 'Menunggu Pembayaran',
                            'waiting_verification' => 'Menunggu Verifikasi',
                            'payment_verified' => 'Pembayaran Terverifikasi',
                            'processing' => 'Sedang Diproses',
                            'shipped' => 'Sedang Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan'
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-green" type="submit">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </div>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-link mt-2 px-0">
                    Reset pencarian
                </a>
            @endif
        </form>
    </div>

    <div class="panel p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Transaksi</h5>
            <span class="text-secondary small">{{ $orders->total() }} pesanan</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="fw-semibold">{{ $order->order_number }}</span>
                            <div class="small text-secondary">
                                {{ $order->shipping_courier }} - {{ $order->shipping_service }}
                            </div>
                        </td>
                        <td>
                            {{ $order->recipient_name ?? $order->user?->name ?? 'Pelanggan' }}
                            <div class="small text-secondary">{{ $order->user?->email }}</div>
                        </td>
                        <td class="fw-semibold">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td>
                            @php
                                $paymentLabels = [
                                    'pending' => 'Belum Dibayar',
                                    'waiting_verification' => 'Menunggu Verifikasi',
                                    'verified' => 'Terverifikasi',
                                    'rejected' => 'Ditolak',
                                ];
                                $paymentStatus = $order->payment?->status ?? $order->payment_status;
                            @endphp
                            <span class="badge text-bg-light border">
                                {{ $paymentLabels[$paymentStatus] ?? ucfirst(str_replace('_', ' ', $paymentStatus ?? '-')) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusLabels = [
                                    'pending_payment' => 'Menunggu Pembayaran',
                                    'waiting_verification' => 'Menunggu Verifikasi',
                                    'payment_verified' => 'Pembayaran Terverifikasi',
                                    'processing' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                $statusColors = [
                                    'pending_payment' => 'secondary',
                                    'waiting_verification' => 'warning',
                                    'payment_verified' => 'success',
                                    'processing' => 'primary',
                                    'shipped' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            <span class="badge text-bg-{{ $statusColors[$order->order_status] ?? 'secondary' }}">
                                {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            {{ $order->created_at?->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-sm btn-green text-nowrap">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-secondary">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada pesanan yang cocok dengan pencarian.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
