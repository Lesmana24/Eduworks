<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="fa-solid fa-store me-2"></i>TokoSaya
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- 1. SEARCH BAR GLOBAL --}}
            {{-- Mengarah ke route products.index dengan method GET --}}
            <form action="{{ route('products.index') }}" method="GET" class="d-flex mx-auto my-2 my-lg-0 w-50" role="search">
                <input class="form-control me-2"
                       type="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari produk..."
                       aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </form>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    {{-- Link ke semua produk --}}
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
                </li>

                {{-- 2. KERANJANG BELANJA --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="{{ route('cart') }}">
    <i class="fa-solid fa-cart-shopping fa-lg"></i>

    {{-- Tambahkan id="cart-badge" di sini --}}
    <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ session('cart') && count(session('cart')) > 0 ? '' : 'd-none' }}">
        {{ session('cart') ? count(session('cart')) : 0 }}
        <span class="visually-hidden">items in cart</span>
    </span>
</a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            {{-- Tampilkan Avatar Dummy atau Nama --}}
                            <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            {{-- Menu Tambahan untuk Admin --}}
                            {{-- Sesuaikan kondisi 'usertype' dengan database Anda (misal: 'admin' atau '1') --}}
                            @if(Auth::user()->usertype === 'admin')
                                <li><a class="dropdown-item fw-bold text-primary" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-regular fa-user me-2"></i>Profile</a></li>

                            {{-- Pesanan Saya (Logic belum ada, sementara arahkan ke Cart atau Home) --}}
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-box-open me-2"></i>Pesanan Saya</a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('login') }}">Login</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2 px-3 rounded-pill" href="{{ route('register') }}">Daftar</a>
                    </li> --}}
                @endauth
            </ul>
        </div>
    </div>
</nav>
