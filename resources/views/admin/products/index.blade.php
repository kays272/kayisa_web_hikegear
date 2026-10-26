<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Produk | HikeGear Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --green: #304d38;
            --green-light: #6c8b57;
            --bg: #f5f7f2;
            --text: #29372c;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--green);
            color: white;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 25px 17px;
            z-index: 1000;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 35px;
            padding-left: 12px;
        }

        .brand span {
            color: #a9c58b;
        }

        .menu-label {
            color: #b9c9b5;
            font-size: 11px;
            letter-spacing: 1.5px;
            margin: 22px 12px 10px;
        }

        .sidebar a {
            display: block;
            color: #e4ebe0;
            text-decoration: none;
            padding: 12px 13px;
            border-radius: 10px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #49684b;
            color: white;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .muted {
            color: #7c897d;
            font-size: 13px;
        }

        .panel {
            background: white;
            border: 1px solid #e7ece4;
            border-radius: 16px;
            padding: 23px;
            box-shadow: 0 5px 20px rgba(35, 65, 39, .035);
        }

        .btn-green {
            background: var(--green);
            color: white;
            border: 0;
            border-radius: 9px;
            padding: 11px 16px;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #243d2b;
            color: white;
        }

        .form-control,
        .form-select {
            border-color: #e1e7df;
            border-radius: 9px;
            padding: 10px 12px;
        }

        .table thead th {
            background: #f5f8f2;
            color: #718071;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 15px 12px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 15px 12px;
            vertical-align: middle;
            border-color: #edf0ea;
        }

        .product-img {
            width: 53px;
            height: 53px;
            object-fit: cover;
            border-radius: 10px;
            background: #edf1e9;
        }

        .no-image {
            width: 53px;
            height: 53px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #edf1e9;
            color: #80917b;
            font-size: 21px;
        }

        .badge-active {
            background: #e1f4e5;
            color: #28733c;
        }

        .badge-inactive {
            background: #fbe9e7;
            color: #b44339;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e4e9e1;
            background: white;
            color: #526b51;
            border-radius: 8px;
            text-decoration: none;
        }

        .action-btn:hover {
            background: #edf4e8;
        }

        .action-delete {
            color: #c34d43;
        }

        .pagination {
            margin-bottom: 0;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 72px;
                padding: 20px 8px;
            }

            .brand {
                font-size: 0;
                padding: 0;
                text-align: center;
            }

            .brand i {
                font-size: 26px;
            }

            .brand span,
            .sidebar .menu-label,
            .sidebar .menu-text {
                display: none;
            }

            .sidebar a {
                text-align: center;
                padding: 13px 5px;
            }

            .sidebar a i {
                margin: 0;
                font-size: 19px;
            }

            .main {
                margin-left: 72px;
                padding: 20px 14px;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 23px;
            }

            .panel {
                padding: 15px;
            }
        }

        .product-pagination .pagination {
            margin-bottom: 0;
            gap: 5px;
            flex-wrap: wrap;
        }

        .product-pagination .page-link {
            border: 1px solid #e1e8dd;
            border-radius: 8px !important;
            color: #304d38;
            padding: 8px 13px;
            background: #fff;
            text-decoration: none;
            box-shadow: none;
        }

        .product-pagination .page-link:hover {
            background: #edf4e8;
            color: #304d38;
        }

        .product-pagination .page-item.active .page-link {
            background: #304d38;
            border-color: #304d38;
            color: #fff;
        }

        .product-pagination .page-item.disabled .page-link {
            color: #a6afa3;
            background: #f7f8f5;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        <i class="bi bi-tree-fill"></i>
        Hike<span>Gear</span>
    </div>

    <div class="menu-label">MENU UTAMA</div>

    <a href="{{ route('admin.dashboard') }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span class="menu-text">Dashboard</span>
    </a>

    <a href="{{ route('admin.products.index') }}" class="active">
        <i class="bi bi-box-seam-fill"></i>
        <span class="menu-text">Kelola Produk</span>
    </a>

    <a href="{{ route('admin.orders.index') }}">
        <i class="bi bi-receipt"></i>
        <span class="menu-text">Kelola Pesanan</span>
    </a>

    <a href="{{ route('admin.payments.index') }}">
        <i class="bi bi-credit-card-2-front"></i>
        <span class="menu-text">Pembayaran</span>
    </a>

    <div class="menu-label">AKUN</div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="btn w-100 text-start text-white"
                style="padding:12px 13px">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span class="menu-text">Keluar</span>
        </button>
    </form>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Kelola Produk</h1>
            <div class="muted">Atur katalog, harga, dan stok perlengkapan outdoor.</div>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn btn-green">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="panel">
        <form method="GET" action="{{ route('admin.products.index') }}"
              class="row g-3 mb-4">

            <div class="col-lg-5 col-md-12">
                <label class="form-label small fw-semibold">Cari Produk</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Nama produk..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-lg-3 col-md-5">
                <label class="form-label small fw-semibold">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected((string) request('category_id') === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" @selected(request('status') === '1')>Aktif</option>
                    <option value="0" @selected(request('status') === '0')>Nonaktif</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-green flex-grow-1">
                    Cari
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1">Daftar Produk</h5>
                <div class="muted">Total {{ $products->total() }} produk ditemukan</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($product->image)
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="product-img">
                                    @else
                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $product->name }}
                                        </div>
                                        <div class="muted">
                                            {{ $product->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $product->category->name ?? '-' }}</td>

                            <td class="fw-semibold">
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($product->stock <= 5)
                                    <span class="text-danger fw-semibold">
                                        {{ $product->stock }} tersisa
                                    </span>
                                @else
                                    {{ $product->stock }} unit
                                @endif
                            </td>

                            <td>
                                @if($product->status)
                                    <span class="badge badge-active rounded-pill px-3 py-2">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge badge-inactive rounded-pill px-3 py-2">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="action-btn" title="Edit produk">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn action-delete"
                                                title="Hapus produk">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-box-seam fs-1 text-secondary"></i>
                                <p class="fw-semibold mt-3 mb-1">Produk tidak ditemukan</p>
                                <div class="muted">
                                    Coba ubah kata pencarian atau filter kategori.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-4">
            <div class="text-muted small">
                Menampilkan {{ $products->firstItem() ?? 0 }}
                sampai {{ $products->lastItem() ?? 0 }}
                dari {{ $products->total() }} produk
            </div>

            <div class="product-pagination">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>