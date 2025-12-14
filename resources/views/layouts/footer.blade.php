<footer class="bg-dark text-light py-5 mt-auto">
    <div class="container">
        <div class="row">
            {{-- Kolom 1: Brand --}}
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase fw-bold">TokoSaya</h5>
                <p class="small text-secondary">
                    Platform belanja online terpercaya dengan berbagai produk berkualitas dan harga terbaik untuk Anda.
                </p>
            </div>

            {{-- Kolom 2: Menu Belanja --}}
            <div class="col-md-2 mb-3">
                <h6 class="text-uppercase fw-bold">Belanja</h6>
                <ul class="list-unstyled small">
                    <li><a href="/products" class="text-decoration-none text-secondary">Produk Baru</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">Promo</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">Kategori</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Bantuan --}}
            <div class="col-md-2 mb-3">
                <h6 class="text-uppercase fw-bold">Bantuan</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-secondary">Cara Pesan</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">Konfirmasi Pembayaran</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Kolom 4: Social Media (DIPERBARUI) --}}
            <div class="col-md-4 mb-3">
                <h6 class="text-uppercase fw-bold">Hubungi Saya</h6>
                <div class="d-flex gap-3">
                    {{-- Instagram --}}
                    <a href="https://instagram.com/lesmana.ak" target="_blank" class="text-white text-decoration-none" title="Instagram">
                        <i class="fa-brands fa-instagram fa-lg"></i>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://linkedin.com/in/lesmana-adhi-kusuma" target="_blank" class="text-white text-decoration-none" title="LinkedIn">
                        <i class="fa-brands fa-linkedin fa-lg"></i>
                    </a>

                    {{-- GitHub --}}
                    <a href="https://github.com/Lesmana24" target="_blank" class="text-white text-decoration-none" title="GitHub">
                        <i class="fa-brands fa-github fa-lg"></i>
                    </a>

                    {{-- Link Tambahan (Website/Portfolio) --}}
                    <a href="https://portofolio-lesmana.netlify.app" target="_blank" class="text-white text-decoration-none" title="Website Lainnya">
                        <i class="fa-solid fa-link fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="text-center small text-secondary">
            &copy; {{ date('Y') }} TokoSaya. All rights reserved. Dibuat dengan &hearts; oleh Lesmana Adhi Kusuma.
        </div>
    </div>
</footer>
