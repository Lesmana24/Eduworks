@extends('layouts.main')

@section('title', 'Katalog Produk')

@section('content')
<div class="container mb-5">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Semua Produk</li>
        </ol>
    </nav>

    <div class="row">
        {{-- SIDEBAR FILTER (Kiri) --}}
<div class="col-lg-3 mb-4">
    
    {{-- Tombol Filter Mobile --}}
    <button class="btn btn-primary d-lg-none w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
        <i class="fa-solid fa-filter me-2"></i> Filter Produk
    </button>

    {{-- Isi Sidebar --}}
    <div class="collapse d-lg-block" id="filterCollapse">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                
                {{-- PENTING: Bungkus SEMUA filter dalam SATU form agar dikirim bersamaan --}}
                <form action="{{ url('/products') }}" method="GET">
                    
                    {{-- 1. PENCARIAN --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Cari Produk</h6>
                        <div class="input-group">
                            {{-- Tambahkan name="search" dan value agar teks tidak hilang saat reload --}}
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Nama barang..." 
                                   value="{{ request('search') }}">
                            
                            {{-- Ubah type jadi "submit" --}}
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                    <hr>

                    {{-- 2. KATEGORI --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Kategori</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach($categories as $cat)
                            <div class="form-check">
                                {{-- 
                                    1. Tambahkan name="category[]" (pakai kurung siku agar bisa pilih banyak) 
                                    2. Isi value dengan ID kategori
                                    3. Cek apakah sedang dicentang (checked)
                                --}}
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="category[]" 
                                       value="{{ $cat->id }}" 
                                       id="cat-{{ $loop->index }}"
                                       {{ in_array($cat->id, request('category', [])) ? 'checked' : '' }}>
                                
                                <label class="form-check-label" for="cat-{{ $loop->index }}">
                                    {{ $cat->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    {{-- 3. RENTANG HARGA --}}
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3">Rentang Harga</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                {{-- Tambahkan name="min" --}}
                                <input type="number" 
                                       name="min_price" 
                                       class="form-control form-control-sm" 
                                       placeholder="Min"
                                       value="{{ request('min_price') }}">
                            </div>
                            <div class="col-6">
                                {{-- Tambahkan name="max" --}}
                                <input type="number" 
                                       name="max_price" 
                                       class="form-control form-control-sm" 
                                       placeholder="Max"
                                       value="{{ request('max_price') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">Terapkan Filter</button>
                            </div>
                        </div>
                    </div>

                    {{-- (Opsional) Simpan status sorting saat filter dijalankan --}}
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                </form> {{-- Tutup Form di sini --}}

            </div>
        </div>
    </div>
</div>

        {{-- MAIN CONTENT (Kanan) --}}
        <div class="col-lg-9">
            
            {{-- Header Bar: Sort & Info --}}
            {{-- Header Bar: Sort & Info --}}
<div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded shadow-sm">
    
    {{-- BAGIAN 1: INFO JUMLAH DATA --}}
    <span class="text-muted small">
        @if($products->total() > 0)
            Menampilkan <strong>{{ $products->firstItem() }}</strong> 
            sampai <strong>{{ $products->lastItem() }}</strong> 
            dari <strong>{{ $products->total() }}</strong> produk
        @else
            Tidak ada produk ditemukan
        @endif
    </span>
    
    {{-- BAGIAN 2: SORTING / URUTKAN --}}
    <div class="d-flex align-items-center">
        <label for="sort" class="me-2 small fw-bold text-nowrap">Urutkan:</label>
        
        {{-- Menggunakan onchange JavaScript sederhana untuk reload halaman saat opsi dipilih --}}
        <select class="form-select form-select-sm border-0 shadow-none" id="sort" style="width: 150px;" 
                onchange="window.location.href = this.value">
            
            {{-- Opsi 1: Default --}}
            <option value="{{ request()->fullUrlWithQuery(['sort' => '']) }}" 
                {{ request('sort') == '' ? 'selected' : '' }}>
                Paling Sesuai
            </option>

            {{-- Opsi 2: Harga Terendah --}}
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" 
                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                Harga Terendah
            </option>

            {{-- Opsi 3: Harga Tertinggi --}}
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" 
                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                Harga Tertinggi
            </option>

            {{-- Opsi 4: Terbaru --}}
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" 
                {{ request('sort') == 'newest' ? 'selected' : '' }}>
                Terbaru
            </option>
        </select>
    </div>
</div>

            {{-- Grid Produk --}}
            {{-- Grid System: row-cols-2 (Mobile), row-cols-md-3 (Tablet), row-cols-lg-4 (Desktop) --}}
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
    
    @foreach($products as $item)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm hover-up">
            
            {{-- Gambar & Badge --}}
            <div class="position-relative">
                {{-- Badge Kategori (Ukuran font diperkecil sedikit untuk mobile) --}}
                <span class="position-absolute top-0 start-0 bg-white text-dark border badge m-2 rounded-pill opacity-75" style="font-size: 0.7rem;">
                    {{-- Pastikan menggunakan syntax panah (->) jika data dari Database --}}
                    {{ $item->category->name ?? 'Umum' }}
                </span>
                
                {{-- Gambar --}}
                <img src="https://via.placeholder.com/300x300?text={{ substr($item->name, 0, 5) }}" class="card-img-top" alt="{{ $item->name }}">
            </div>
            
            {{-- Body Card (Padding diperkecil di mobile biar muat) --}}
            <div class="card-body p-2 p-md-3">
                {{-- Judul Produk (Font size disesuaikan) --}}
                <h6 class="card-title fw-bold text-truncate mb-1">
                    <a href="#" class="text-decoration-none text-dark">{{ $item->name }}</a>
                </h6>
                
                {{-- Harga --}}
                <p class="text-primary fw-bold mb-0 small">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </p>
            </div>
            
            {{-- Tombol Keranjang --}}
            <div class="card-footer bg-transparent border-top-0 p-2 pb-3">
                <div class="d-grid">
                    {{-- Di Mobile text tombol disembunyikan, cuma ikon (biar muat) --}}
                    <button class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="fa-solid fa-cart-plus"></i> 
                        <span class="d-none d-md-inline ms-1">+ Keranjang</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
    @endforeach

</div>
            {{-- Pagination Dinamis --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Efek hover naik sedikit agar interaktif */
    .hover-up {
        transition: transform 0.2s ease-in-out;
    }
    .hover-up:hover {
        transform: translateY(-5px);
    }
</style>
@endsection