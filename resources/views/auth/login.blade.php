<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - HikeGear</title>

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
                            HikeGear
                        </h2>

                        <p class="text-muted mb-0">
                            Hiking & Camping Gear
                        </p>

                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
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

                    <form
                        action="{{ route('login.process') }}"
                        method="POST"
                    >

                        @csrf

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
                                placeholder="Masukkan password"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-dark w-100"
                        >
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Belum punya akun?
                        </span>

                        <a href="{{ route('register') }}">
                            Daftar sekarang
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

</body>
</html>