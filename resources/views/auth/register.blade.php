<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - HikeGear</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height: 100vh;">

        <div class="col-md-5">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Buat Akun
                        </h2>

                        <p class="text-muted">
                            Bergabung dengan HikeGear
                        </p>

                    </div>

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        action="{{ route('register.process') }}"
                        method="POST"
                    >

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Minimal 8 karakter"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-dark w-100"
                        >
                            Daftar
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Sudah punya akun?
                        </span>

                        <a href="{{ route('login') }}">
                            Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>