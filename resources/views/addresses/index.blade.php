<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alamat Saya - HikeGear</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f5f7f6;
            color: #26352d;
        }

        .navbar {
            background: #173d2d;
        }

        .navbar-brand {
            font-weight: 800;
            color: white !important;
        }

        .page-title {
            font-weight: 800;
            color: #173d2d;
        }

        .address-card {
            background: white;
            border: none;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .address-card.default {
            border: 2px solid #26734d;
        }

        .recipient {
            font-weight: 700;
            color: #173d2d;
            font-size: 18px;
        }

        .phone {
            color: #68776e;
        }

        .address-text {
            line-height: 1.7;
            color: #4d5c53;
        }

        .badge-default {
            background: #26734d;
            color: white;
        }

        .btn-hike {
            background: #26734d;
            color: white;
            border: none;
            border-radius: 10px;
        }

        .btn-hike:hover {
            background: #1d5c3d;
            color: white;
        }

        .btn-outline-hike {
            border: 1px solid #26734d;
            color: #26734d;
            border-radius: 10px;
        }

        .btn-outline-hike:hover {
            background: #26734d;
            color: white;
        }

        .empty-box {
            background: white;
            border-radius: 18px;
            padding: 70px 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .empty-icon {
            font-size: 65px;
            color: #8aa798;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container">

        <a
            href="{{ route('home') }}"
            class="navbar-brand"
        >
            <i class="bi bi-backpack2"></i>
            HikeGear
        </a>

        <div class="d-flex gap-2">

            <a
                href="{{ route('cart.index') }}"
                class="btn btn-outline-light btn-sm"
            >
                <i class="bi bi-cart3"></i>
                Keranjang
            </a>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-light btn-sm"
            >
                <i class="bi bi-shop"></i>
                Belanja
            </a>

        </div>

    </div>
</nav>


<div class="container py-5">

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>
    @endif


    {{-- PESAN ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>
    @endif


    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="page-title mb-1">
                <i class="bi bi-geo-alt"></i>
                Alamat Saya
            </h1>

            <p class="text-muted mb-0">
                Kelola alamat pengiriman untuk pesananmu.
            </p>

        </div>


        <a
            href="{{ route('addresses.create') }}"
            class="btn btn-hike"
        >
            <i class="bi bi-plus-circle"></i>
            Tambah Alamat
        </a>

    </div>


    {{-- DAFTAR ALAMAT --}}
    @if($addresses->count() > 0)

        <div class="row g-4">

            @foreach($addresses as $address)

                <div class="col-md-6">

                    <div
                        class="address-card p-4 h-100
                        {{ $address->is_default ? 'default' : '' }}"
                    >

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>

                                <div class="recipient">
                                    {{ $address->recipient_name }}
                                </div>

                                <div class="phone">
                                    {{ $address->phone }}
                                </div>

                            </div>


                            @if($address->is_default)

                                <span class="badge badge-default">
                                    <i class="bi bi-check-circle"></i>
                                    Alamat Utama
                                </span>

                            @endif

                        </div>


                        <div class="address-text mb-4">

                            {{ $address->address }}

                            <br>

                            Kecamatan {{ $address->district }},
                            {{ $address->city }},

                            <br>

                            {{ $address->province }}
                            {{ $address->postal_code }}

                        </div>


                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('addresses.edit', $address->id) }}"
                                class="btn btn-outline-hike btn-sm"
                            >
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>


                            <form
                                action="{{ route('addresses.destroy', $address->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus alamat ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                >
                                    <i class="bi bi-trash"></i>
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- BELUM ADA ALAMAT --}}
        <div class="empty-box">

            <div class="empty-icon mb-3">
                <i class="bi bi-geo-alt"></i>
            </div>

            <h3 class="fw-bold">
                Belum Ada Alamat
            </h3>

            <p class="text-muted mb-4">
                Tambahkan alamat pengiriman terlebih dahulu
                sebelum melakukan checkout.
            </p>

            <a
                href="{{ route('addresses.create') }}"
                class="btn btn-hike"
            >
                <i class="bi bi-plus-circle"></i>
                Tambah Alamat
            </a>

        </div>

    @endif

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>