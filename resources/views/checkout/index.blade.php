<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - HikeGear</title>

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

        .checkout-title {
            color: #173b2c;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
        }

        .section-title {
            color: #173b2c;
            font-weight: 700;
        }

        .address-option,
        .shipping-option,
        .payment-option {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .address-option:hover,
        .shipping-option:hover,
        .payment-option:hover {
            border-color: #198754;
            background: #f1f8f4;
        }

        .address-option input,
        .shipping-option input,
        .payment-option input {
            margin-right: 10px;
        }

        .product-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 10px;
            background: #e9ecef;
        }

        .placeholder-image {
            width: 75px;
            height: 75px;
            border-radius: 10px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
        }

        .total-box {
            background: #f8faf8;
            border-radius: 12px;
            padding: 20px;
        }

        .total-price {
            color: #198754;
            font-size: 24px;
            font-weight: 700;
        }

        .btn-hike {
            background: #198754;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-hike:hover {
            background: #146c43;
            color: white;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
            <i class="bi bi-tree-fill"></i>
            HikeGear
        </a>

        <div>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                <i class="bi bi-cart"></i>
                Keranjang
            </a>
        </div>
    </div>
</nav>

<div class="container pb-5">

    <div class="mb-4">
        <h2 class="checkout-title">
            <i class="bi bi-credit-card"></i>
            Checkout
        </h2>

        <p class="text-muted mb-0">
            Periksa pesanan, alamat, pengiriman, dan pembayaran sebelum membuat pesanan.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data checkout:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('checkout.store') }}"
        method="POST"
    >
        @csrf

        <div class="row g-4">

            {{-- KOLOM KIRI --}}
            <div class="col-lg-8">

                {{-- ALAMAT --}}
                <div class="card p-4 mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-geo-alt-fill"></i>
                            Alamat Pengiriman
                        </h5>

                        <a
                            href="{{ route('addresses.create') }}"
                            class="btn btn-sm btn-outline-success"
                        >
                            <i class="bi bi-plus"></i>
                            Tambah Alamat
                        </a>
                    </div>

                    @foreach($addresses as $address)

                        <label class="address-option d-block">

                            <input
                                type="radio"
                                name="address_id"
                                value="{{ $address->id }}"
                                {{ old('address_id', $address->is_default ? $address->id : null) == $address->id ? 'checked' : '' }}
                                required
                            >

                            <strong>
                                {{ $address->recipient_name }}
                            </strong>

                            @if($address->is_default)
                                <span class="badge bg-success ms-2">
                                    Alamat Utama
                                </span>
                            @endif

                            <div class="small text-muted mt-2">
                                <i class="bi bi-telephone"></i>
                                {{ $address->phone }}
                            </div>

                            <div class="small text-muted">
                                {{ $address->address }},
                                {{ $address->district }},
                                {{ $address->city }},
                                {{ $address->province }}
                                {{ $address->postal_code }}
                            </div>

                        </label>

                    @endforeach

                </div>


                {{-- PRODUK --}}
                <div class="card p-4 mb-4">

                    <h5 class="section-title mb-3">
                        <i class="bi bi-bag-fill"></i>
                        Produk yang Dibeli
                    </h5>

                    @foreach($cart->items as $item)

                        <div class="product-item d-flex gap-3">

                            @if($item->product->image)
                                <img
                                    src="{{ asset('storage/' . $item->product->image) }}"
                                    class="product-image"
                                    alt="{{ $item->product->name }}"
                                >
                            @else
                                <div class="placeholder-image">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @endif

                            <div class="flex-grow-1">

                                <h6 class="mb-1">
                                    {{ $item->product->name }}
                                </h6>

                                <div class="small text-muted">
                                    {{ $item->product->category->name }}
                                </div>

                                <div class="mt-2">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    × {{ $item->quantity }}
                                </div>

                            </div>

                            <div class="fw-bold">
                                Rp
                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- PENGIRIMAN --}}
                <div class="card p-4 mb-4">

                    <h5 class="section-title mb-3">
                        <i class="bi bi-truck"></i>
                        Pilih Pengiriman
                    </h5>

                    @foreach($shippingOptions as $index => $shipping)

                        <label class="shipping-option d-block">

                            <input
                                type="radio"
                                name="shipping_option"
                                value="{{ $shipping['courier'] }}|{{ $shipping['service'] }}|{{ $shipping['cost'] }}"
                                data-courier="{{ $shipping['courier'] }}"
                                data-service="{{ $shipping['service'] }}"
                                data-cost="{{ $shipping['cost'] }}"
                                {{ $index === 0 ? 'checked' : '' }}
                                required
                            >

                            <strong>
                                {{ $shipping['courier'] }}
                            </strong>

                            <span class="text-muted">
                                {{ $shipping['service'] }}
                            </span>

                            <span class="float-end fw-bold">
                                Rp {{ number_format($shipping['cost'], 0, ',', '.') }}
                            </span>

                        </label>

                    @endforeach

                    {{-- hidden field yang dikirim ke controller --}}
                    <input
                        type="hidden"
                        name="courier"
                        id="courier"
                        value="{{ $shippingOptions[0]['courier'] }}"
                    >

                    <input
                        type="hidden"
                        name="service"
                        id="service"
                        value="{{ $shippingOptions[0]['service'] }}"
                    >

                </div>


                {{-- PEMBAYARAN --}}
                <div class="card p-4 mb-4">

                    <h5 class="section-title mb-3">
                        <i class="bi bi-wallet2"></i>
                        Metode Pembayaran
                    </h5>

                    <label class="payment-option d-block">

                        <input
                            type="radio"
                            name="payment_method"
                            value="bank_transfer"
                            {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                            required
                        >

                        <strong>
                            <i class="bi bi-bank"></i>
                            Bank Transfer
                        </strong>

                        <div class="small text-muted ms-4 mt-1">
                            Pembayaran akan diverifikasi oleh admin.
                        </div>

                    </label>


                    <label class="payment-option d-block">

                        <input
                            type="radio"
                            name="payment_method"
                            value="qris"
                            {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                        >

                        <strong>
                            <i class="bi bi-qr-code"></i>
                            QRIS
                        </strong>

                        <div class="small text-muted ms-4 mt-1">
                            Upload bukti pembayaran setelah pesanan dibuat.
                        </div>

                    </label>


                    <label class="payment-option d-block">

                        <input
                            type="radio"
                            name="payment_method"
                            value="cod"
                            {{ old('payment_method') === 'cod' ? 'checked' : '' }}
                        >

                        <strong>
                            <i class="bi bi-cash-stack"></i>
                            COD
                        </strong>

                        <div class="small text-muted ms-4 mt-1">
                            Bayar saat pesanan diterima.
                        </div>

                    </label>

                </div>

            </div>


            {{-- KOLOM KANAN --}}
            <div class="col-lg-4">

                <div class="card p-4 sticky-lg-top" style="top: 20px;">

                    <h5 class="section-title mb-4">
                        Ringkasan Pesanan
                    </h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">
                            Subtotal
                        </span>

                        <span>
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Ongkos Kirim
                        </span>

                        <span id="shippingCostText">
                            Rp {{ number_format($shippingCost, 0, ',', '.') }}
                        </span>

                    </div>

                    <hr>

                    <div class="total-box">

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-bold">
                                Total
                            </span>

                            <span
                                class="total-price"
                                id="totalPrice"
                            >
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-hike w-100 mt-4"
                    >
                        <i class="bi bi-check-circle"></i>
                        Buat Pesanan
                    </button>

                    <a
                        href="{{ route('cart.index') }}"
                        class="btn btn-outline-secondary w-100 mt-2"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Keranjang
                    </a>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

    const shippingOptions =
        document.querySelectorAll(
            'input[name="shipping_option"]'
        );

    const courierInput =
        document.getElementById('courier');

    const serviceInput =
        document.getElementById('service');

    const shippingCostText =
        document.getElementById('shippingCostText');

    const totalPrice =
        document.getElementById('totalPrice');

    const subtotal =
        {{ $subtotal }};


    function updateShipping() {

        const selected =
            document.querySelector(
                'input[name="shipping_option"]:checked'
            );

        if (!selected) {
            return;
        }

        const courier =
            selected.dataset.courier;

        const service =
            selected.dataset.service;

        const cost =
            Number(selected.dataset.cost);


        courierInput.value =
            courier;

        serviceInput.value =
            service;


        shippingCostText.innerText =
            'Rp ' +
            cost.toLocaleString(
                'id-ID'
            );


        const total =
            subtotal + cost;


        totalPrice.innerText =
            'Rp ' +
            total.toLocaleString(
                'id-ID'
            );
    }


    shippingOptions.forEach(
        function (option) {

            option.addEventListener(
                'change',
                updateShipping
            );

        }
    );


    updateShipping();

</script>
</body>
</html>