@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mb-5">
    
    {{-- Breadcrumb (Navigasi Kecil) --}}
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
        </ol>
    </nav>

    {{-- SIMULASI DATA (Data Dummy untuk Tampilan) --}}
    @php
        // Ceritanya ini data dari Controller / Session
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Kamera DSLR Canon',
                'price' => 5500000,
                'qty' => 1,
                'image' => 'https://via.placeholder.com/150?text=Kamera'
            ],
            [
                'id' => 2,
                'name' => 'Sepatu Running Nike',
                'price' => 1250000,
                'qty' => 2,
                'image' => 'https://via.placeholder.com/150?text=Sepatu'
            ]
        ];

        // Hitung Total Belanja Manual untuk Tampilan
        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $tax;
    @endphp

    @if(count($cartItems) > 0)
        <div class="row">
            {{-- KOLOM KIRI: Daftar Item --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold">Item Belanja ({{ count($cartItems) }})</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="row align-items-center mb-4 pb-4 border-bottom last-no-border">
                            <div class="col-3 col-md-2">
                                <img src="{{ $item['image'] }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                            </div>
                            
                            <div class="col-9 col-md-4">
                                <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                <p class="text-muted small mb-0">Warna: Hitam | Ukuran: M</p>
                                <div class="d-md-none mt-2 fw-bold text-primary">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" type="button">-</button>
                                            <input type="text" class="form-control text-center" value="{{ $item['qty'] }}">
                                            <button class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-5 text-end d-none d-md-block">
                                        <span class="fw-bold text-dark">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                                        <br>
                                        <small class="text-muted">@ Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                                    </div>

                                    <div class="col-2 text-end">
                                        <button class="btn btn-link text-danger p-0">
                                            <i class="fa-solid fa-trash-can fa-lg"></i>
                                        </button>
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

            {{-- KOLOM KANAN: Ringkasan Belanja (Sticky) --}}
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
                        
                        <button class="btn btn-primary w-100 btn-lg py-2 fw-bold shadow-sm">
                            Checkout Sekarang
                        </button>

                        {{-- Info Keamanan --}}
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

{{-- CSS Tambahan Khusus Halaman Ini --}}
<style>
    /* Hilangkan border item terakhir agar rapi */
    .last-no-border:last-child {
        border-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
@endsection