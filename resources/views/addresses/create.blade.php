<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Alamat - HikeGear</title>

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
        }

        .navbar {
            background: #173d2d;
        }

        .navbar-brand {
            font-weight: 800;
            color: white !important;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .page-title {
            color: #173d2d;
            font-weight: 800;
        }

        .form-label {
            font-weight: 600;
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

        .btn-back {
            border: 1px solid #26734d;
            color: #26734d;
            border-radius: 10px;
        }

        .btn-back:hover {
            background: #26734d;
            color: white;
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

    </div>
</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="form-card p-4 p-md-5">

                <h1 class="page-title mb-2">
                    <i class="bi bi-geo-alt"></i>
                    Tambah Alamat
                </h1>

                <p class="text-muted mb-4">
                    Isi data alamat pengiriman dengan benar.
                </p>


                @if($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Periksa kembali data berikut:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route('addresses.store') }}"
                    method="POST"
                >

                    @csrf


                    {{-- NAMA --}}
                    <div class="mb-3">

                        <label
                            for="recipient_name"
                            class="form-label"
                        >
                            Nama Penerima
                        </label>

                        <input
                            type="text"
                            name="recipient_name"
                            id="recipient_name"
                            class="form-control"
                            value="{{ old('recipient_name') }}"
                            placeholder="Contoh: Utiya"
                            required
                        >

                    </div>


                    {{-- PHONE --}}
                    <div class="mb-3">

                        <label
                            for="phone"
                            class="form-label"
                        >
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            required
                        >

                    </div>


                    <div class="row">

                        {{-- PROVINSI --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="province"
                                class="form-label"
                            >
                                Provinsi
                            </label>

                            <input
                                type="text"
                                name="province"
                                id="province"
                                class="form-control"
                                value="{{ old('province') }}"
                                placeholder="Contoh: Jawa Tengah"
                                required
                            >

                        </div>


                        {{-- KOTA --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="city"
                                class="form-label"
                            >
                                Kota / Kabupaten
                            </label>

                            <input
                                type="text"
                                name="city"
                                id="city"
                                class="form-control"
                                value="{{ old('city') }}"
                                placeholder="Contoh: Klaten"
                                required
                            >

                        </div>

                    </div>


                    <div class="row">

                        {{-- KECAMATAN --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="district"
                                class="form-label"
                            >
                                Kecamatan
                            </label>

                            <input
                                type="text"
                                name="district"
                                id="district"
                                class="form-control"
                                value="{{ old('district') }}"
                                placeholder="Contoh: Ceper"
                                required
                            >

                        </div>


                        {{-- KODE POS --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="postal_code"
                                class="form-label"
                            >
                                Kode Pos
                            </label>

                            <input
                                type="text"
                                name="postal_code"
                                id="postal_code"
                                class="form-control"
                                value="{{ old('postal_code') }}"
                                placeholder="Contoh: 57465"
                                required
                            >

                        </div>

                    </div>


                    {{-- ALAMAT LENGKAP --}}
                    <div class="mb-3">

                        <label
                            for="address"
                            class="form-label"
                        >
                            Alamat Lengkap
                        </label>

                        <textarea
                            name="address"
                            id="address"
                            class="form-control"
                            rows="4"
                            placeholder="Nama jalan, nomor rumah, RT/RW, desa, patokan, dan sebagainya."
                            required
                        >{{ old('address') }}</textarea>

                    </div>


                    {{-- ALAMAT UTAMA --}}
                    <div class="form-check mb-4">

                        <input
                            type="checkbox"
                            name="is_default"
                            value="1"
                            id="is_default"
                            class="form-check-input"
                        >

                        <label
                            for="is_default"
                            class="form-check-label"
                        >
                            Jadikan sebagai alamat utama
                        </label>

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('addresses.index') }}"
                            class="btn btn-back"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-hike"
                        >
                            <i class="bi bi-check-circle"></i>
                            Simpan Alamat
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>