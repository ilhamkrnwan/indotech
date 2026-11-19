<?php get_header(); ?>

<main id="main-content">
    <section class="ch-404-section">
        <div class="container">
            <div class="ch-404-card">
                <span class="section-tag">Error 404</span>
                <div class="ch-404-code" aria-hidden="true">404</div>
                <h1 class="ch-404-title">Halaman Tidak Ditemukan</h1>
                <p class="ch-404-desc">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan ke alamat lain.</p>
                <div class="ch-404-actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
                    <a href="<?php echo esc_url( home_url( '/produk/' ) ); ?>" class="btn btn-outline btn-lg">Lihat Katalog</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
