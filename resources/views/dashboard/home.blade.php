@extends('layouts.main')

{{-- Judul Halaman --}}
@section('title', 'Home - TokoOnline')

@section('content')
    {{-- 1. HERO SECTION (Ucapan Selamat Datang) --}}
    <section class="container mb-5">
        <div class="p-5 p-lg-5 bg-light rounded-3 text-center shadow-sm">
            <div class="m-4 m-lg-5">
                <h1 class="display-4 fw-bold">Selamat Datang di TokoOnline!</h1>
                <p class="fs-4 text-muted">Solusi belanja hemat, cepat, dan terpercaya untuk segala kebutuhan Anda.</p>
                <hr class="my-4 mx-auto" style="width: 100px; height: 3px; background-color: #0d6efd; opacity: 1;">
                <p>Dapatkan diskon hingga 50% untuk pengguna baru hari ini.</p>
                <a class="btn btn-primary btn-lg px-4 gap-3" href="{{ url('/products') }}" role="button">
                    <i class="fa-solid fa-bag-shopping me-2"></i>Belanja Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- 2. PRODUK TERKINI SECTION --}}
    <section class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold border-start border-4 border-primary ps-3">Produk Terkini</h3>
            <a href="{{ url('/products') }}" class="text-decoration-none">Lihat Semua &rarr;</a>
        </div>

        {{-- Grid Produk --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            {{-- Looping Produk --}}
            @foreach($products as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    {{-- Badge "New" --}}
                    
                    <img src="{{ $item['img'] }}" class="card-img-top" alt="{{ $item['name'] }}">
                    
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $item['name'] }}</h5>
                        <p class="card-text text-muted small">Kualitas terbaik dengan garansi resmi 1 tahun.</p>
                        <h6 class="text-primary fw-bold mb-3">Rp {{ number_format($item['price'], 0, ',', '.') }}</h6>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 d-grid gap-2 mb-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-cart-plus"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>
@endsection