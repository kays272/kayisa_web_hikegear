<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk | HikeGear Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --green: #304d38;
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

        .brand span { color: #a9c58b; }

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

        .sidebar a i { margin-right: 10px; }

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
            margin-bottom: 25px;
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
            padding: 28px;
            box-shadow: 0 5px 20px rgba(35, 65, 39, .035);
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .section-subtitle {
            font-size: 13px;
            color: #7c897d;
            margin-bottom: 22px;
        }

        .form-label {
            color: #354738;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-color: #e1e7df;
            border-radius: 9px;
            padding: 11px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6c8b57;
            box-shadow: 0 0 0 .2rem rgba(108, 139, 87, .13);
        }

        textarea.form-control {
            min-height: 125px;
            resize: vertical;
        }

        .btn-green {
            background: var(--green);
            color: white;
            border: 0;
            border-radius: 9px;
            padding: 11px 18px;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #243d2b;
            color: white;
        }

        .current-image {
            width: 150px;
            height: 150px;
            object-fit: contain;
            background: #f5f7f2;
            border: 1px solid #e5eadf;
            border-radius: 12px;
            padding: 5px;
        }

        .upload-box {
            border: 2px dashed #d9e2d4;
            background: #f9fbf7;
            border-radius: 12px;
            padding: 24px;
        }

        #imagePreview {
            display: none;
            max-width: 180px;
            max-height: 180px;
            object-fit: contain;
            margin-top: 15px;
            border-radius: 10px;
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

            .brand i { font-size: 26px; }

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

            .panel { padding: 20px; }
        }

        @media (max-width: 576px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 { font-size: 23px; }
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
        <button type="submit" class="btn w-100 text-start text-white"
                style="padding:12px 13px">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span class="menu-text">Keluar</span>
        </button>
    </form>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Edit Produk</h1>
            <div class="muted">
                Perbarui informasi produk di katalog HikeGear.
            </div>
        </div>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-outline-secondary rounded-3 px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-2">Periksa kembali data berikut:</div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="panel mb-4">
            <div class="section-title">
                <i class="bi bi-info-circle me-2"></i>Informasi Produk
            </div>
            <div class="section-subtitle">
                Data produk saat ini ditampilkan otomatis.
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name) }}"
                           maxlength="255" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required>
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi Produk</label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="panel mb-4">
            <div class="section-title">
                <i class="bi bi-currency-dollar me-2"></i>Harga dan Persediaan
            </div>
            <div class="section-subtitle">
                Perbarui harga, stok, dan berat produk.
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label">Harga (Rp) *</label>
                    <input type="number" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price) }}"
                           min="0" step="0.01" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Stok Produk *</label>
                    <input type="number" name="stock"
                           class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', $product->stock) }}"
                           min="0" step="1" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Berat (gram) *</label>
                    <input type="number" name="weight"
                           class="form-control @error('weight') is-invalid @enderror"
                           value="{{ old('weight', $product->weight) }}"
                           min="1" step="1" required>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="panel mb-4">
            <div class="section-title">
                <i class="bi bi-image me-2"></i>Foto Produk
            </div>
            <div class="section-subtitle">
                Foto lama tetap digunakan jika kamu tidak memilih foto baru.
            </div>

            @if($product->image)
                <div class="mb-4">
                    <div class="form-label">Foto saat ini</div>
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->image) }}"
                        alt="{{ $product->name }}"
                        class="current-image">
                </div>
            @endif

            <div class="upload-box">
                <label for="imageInput" class="form-label">
                    Pilih foto baru (opsional)
                </label>

                <input type="file" name="image" id="imageInput"
                       class="form-control @error('image') is-invalid @enderror"
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                <div class="muted mt-2">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </div>

                @error('image')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <img id="imagePreview" alt="Pratinjau foto baru">
            </div>
        </div>

        <div class="panel mb-4">
            <div class="section-title">
                <i class="bi bi-toggle-on me-2"></i>Status Produk
            </div>
            <div class="section-subtitle">
                Produk nonaktif tidak ditawarkan kepada pelanggan.
            </div>

            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="1"
                    @selected((string) old('status', (int) $product->status) === '1')>
                    Aktif — tampilkan di katalog
                </option>
                <option value="0"
                    @selected((string) old('status', (int) $product->status) === '0')>
                    Nonaktif — sembunyikan dari katalog
                </option>
            </select>
        </div>

        <div class="d-flex flex-wrap justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.products.index') }}"
               class="btn btn-light border rounded-3 px-4 py-2">
                Batal
            </a>

            <button type="submit" class="btn btn-green">
                <i class="bi bi-check-circle me-1"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</main>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            imagePreview.style.display = 'none';
            imagePreview.removeAttribute('src');
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Pilih file gambar yang valid.');
            this.value = '';
            imagePreview.style.display = 'none';
            return;
        }

        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    });
</script>

</body>
</html>