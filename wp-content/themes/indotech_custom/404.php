<?php get_header(); ?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-404-band ch-wrap" aria-labelledby="cs-404-title">
            <div class="cs-404-split">
                <div class="cs-404-main">
                    <div class="cs-404-eyebrow">
                        <span class="ch-tilt-badge">Error 404</span>
                        <span class="cs-404-code" aria-hidden="true">404</span>
                    </div>
                    <h1 id="cs-404-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Halaman Tidak</span>
                        <span class="ch-h1-secondary">Ditemukan</span>
                    </h1>
                    <p class="cs-404-lead">Alamat URL yang Anda tuju tidak tersedia, telah dipindahkan, atau sudah diperbarui dalam arsitektur situs Indotech.</p>

                    <div class="cs-hero-actions">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ch-pill-cta">
                            <span>Kembali ke Beranda</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>" class="ch-inline-link">
                            <span>Hubungi tim B2B</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <aside class="cs-404-directory" aria-label="Rute tujuan populer Indotech">
                    <span class="cs-pill-tag cs-pill-tag--lime">Rute Cepat B2B</span>
                    <h2>Lanjutkan Menuju Layanan Utama</h2>
                    <ul class="cs-route-list">
                        <li>
                            <a href="<?php echo esc_url( home_url( '/produk/' ) ); ?>">
                                <span>Katalog Produk Indotech</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>">
                                <span>Profil &amp; Legalitas Perusahaan</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/kemitraan/' ) ); ?>">
                                <span>Skema Distributor &amp; Kemitraan</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                                <span>Wawasan &amp; Jurnal B2B</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
