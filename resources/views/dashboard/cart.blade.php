@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mb-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
        </ol>
    </nav>

    {{-- LOGIKA HITUNG TOTAL DARI SESSION --}}
    @php
        $subtotal = 0;
        // Cek apakah ada session cart
        if(session('cart')) {
            foreach(session('cart') as $id => $details) {
                $subtotal += $details['price'] * $details['quantity'];
            }
        }
        $tax = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $tax;
    @endphp

    {{-- Tampilkan Alert Sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            {{-- KOLOM KIRI: Daftar Item --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold">Item Belanja ({{ count(session('cart')) }})</h5>
                    </div>
                    <div class="card-body">
                        @foreach(session('cart') as $id => $details)
                        {{-- Tambahkan attribut data-id untuk keperluan JS --}}
                        <div class="row cart-detail align-items-center mb-4 pb-4 border-bottom last-no-border" data-id="{{ $id }}">

                            {{-- Gambar Produk --}}
                            <div class="col-3 col-md-2">
                                {{-- Pastikan path image sesuai penyimpanan (storage atau url luar) --}}
                                @if(isset($details['image']) && $details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="img-fluid rounded" alt="{{ $details['name'] }}">
                                @else
                                    <img src="https://via.placeholder.com/150" class="img-fluid rounded">
                                @endif
                            </div>

                            {{-- Info Produk --}}
                            <div class="col-9 col-md-4">
                                <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                <p class="text-muted small mb-0">ID Produk: {{ $id }}</p>
                                <div class="d-md-none mt-2 fw-bold text-primary">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </div>
                            </div>

                            {{-- Qty & Aksi --}}
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            {{-- Tombol Kurang --}}
                                            <button class="btn btn-outline-secondary btn-update-qty" data-action="decrease" type="button">-</button>

                                            {{-- Input Quantity --}}
                                            <input type="number" class="form-control text-center quantity-input" value="{{ $details['quantity'] }}" min="1">

                                            {{-- Tombol Tambah --}}
                                            <button class="btn btn-outline-secondary btn-update-qty" data-action="increase" type="button">+</button>
                                        </div>
                                    </div>

                                    {{-- Subtotal per Item --}}
                                    <div class="col-5 text-end d-none d-md-block">
                                        <span class="fw-bold text-dark">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                        <br>
                                        <small class="text-muted">@ Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <div class="col-2 text-end">
                                        {{-- Gunakan Form DELETE khusus untuk ID ini --}}
                                        <form action="{{ route('remove.from.cart') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus produk ini?')">
                                                <i class="fa-solid fa-trash-can fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('/products') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            {{-- KOLOM KANAN: Ringkasan Belanja --}}
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm position-sticky" style="top: 2rem;">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 fw-bold">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                Subtotal
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                PPN (11%)
                                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 fw-bold fs-5 border-top pt-3">
                                Total
                                <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </li>
                        </ul>

                        {{-- Tombol Checkout (Sementara ke home atau halaman checkout nanti) --}}
                        {{-- Tombol Checkout --}}
<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary w-100 btn-lg py-2 fw-bold shadow-sm" onclick="return confirm('Apakah Anda yakin ingin memproses pesanan ini?')">
        Checkout Sekarang
    </button>
</form>

                        <div class="mt-3 text-center small text-muted">
                            <i class="fa-solid fa-shield-halved me-1"></i> Transaksi Aman & Terenkripsi
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- TAMPILAN JIKA KERANJANG KOSONG --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fa-solid fa-cart-shopping fa-4x text-muted opacity-50"></i>
            </div>
            <h3 class="fw-bold">Keranjang Belanja Kosong</h3>
            <p class="text-muted">Sepertinya Anda belum menambahkan produk apapun.</p>
            <a href="{{ url('/products') }}" class="btn btn-primary mt-3">
                Mulai Belanja
            </a>
        </div>
    @endif

</div>

{{-- JAVASCRIPT UNTUK UPDATE QUANTITY OTOMATIS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">

    // Logika tombol +/-
    $(".btn-update-qty").click(function (e) {
        e.preventDefault();

        var ele = $(this);
        var input = ele.siblings('.quantity-input');
        var currentVal = parseInt(input.val());
        var action = ele.data('action');
        var tr = ele.closest(".cart-detail");

        // Hitung nilai baru
        var newVal = currentVal;
        if(action == 'increase') {
            newVal = currentVal + 1;
        } else if(action == 'decrease') {
            if(currentVal > 1) {
                newVal = currentVal - 1;
            } else {
                return; // Jangan lakukan apa-apa jika nilai sudah 1
            }
        }

        // Update tampilan input
        input.val(newVal);

        // Kirim AJAX ke server untuk update session
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "PATCH",
            data: {
                _token: '{{ csrf_token() }}',
                id: tr.attr("data-id"),
                quantity: newVal
            },
            success: function (response) {
                // Reload halaman agar perhitungan Subtotal & Total diperbarui
                window.location.reload();
            }
        });
    });

    // Jika user mengetik manual angka di input dan tekan enter/blur
    $(".quantity-input").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        var tr = ele.closest(".cart-detail");

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "PATCH",
            data: {
                _token: '{{ csrf_token() }}',
                id: tr.attr("data-id"),
                quantity: ele.val()
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });

</script>

<style>
    .last-no-border:last-child {
        border-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    /* Sembunyikan panah di input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection
