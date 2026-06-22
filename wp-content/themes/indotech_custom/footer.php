<?php
/**
 * Footer
 *
 * Grid 4-kolom: Brand | Navigasi | Brand Kami | Hubungi Kami
 * Desain: tipografi bold, palet cobalt/ink/white, tanpa ikon sistem.
 * Social links menggunakan inisial teks (IG / FB / WA).
 */

$phone    = indotech_opt( 'phone',    '+62 812-3456-7890' );
$email    = indotech_opt( 'email',    'info@indotech.id' );
$address  = indotech_opt( 'address',  'Jakarta, Indonesia' );
$whatsapp = indotech_opt( 'whatsapp', '6281234567890' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
?>

<footer class="site-footer" id="site-footer">

    <!-- ══════════════════════════════════════════════════════════
         FOOTER TOP
    ══════════════════════════════════════════════════════════ -->
    <div class="footer-top">
        <div class="container footer-grid">

            <!-- ── Kolom Brand ──────────────────────────────── -->
            <div class="footer-brand">

                <a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-logo-wrap" aria-label="PT Indotech Berkah Abadi — Beranda">
                    <?php
                    $logo_path = get_template_directory() . '/assets/images/logo.png';
                    if ( file_exists( $logo_path ) ):
                    ?>
                        <!--
                            Logo footer — dimuat dengan filter brightness(0) invert(1)
                            agar tampil putih di atas background gelap.
                        -->
                        <img
                            src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>"
                            alt="PT Indotech Berkah Abadi"
                            class="footer-logo-img"
                            width="160"
                            height="46"
                            loading="lazy"
                            style="filter: brightness(0) invert(1);"
                        >
                    <?php else: ?>
                        <!--
                            PLACEHOLDER: Logo footer belum tersedia.
                            Sediakan file di /assets/images/logo.png (PNG transparan,
                            ukuran 180×52 px) — filter CSS akan otomatis membuatnya putih.
                        -->
                        <span class="footer-logo-text" aria-label="PT Indotech Berkah Abadi">
                            <span class="footer-logo-indo">Indo</span><span class="footer-logo-tech">tech</span>
                        </span>
                    <?php endif; ?>
                </a>

                <p class="footer-company">PT Indotech Berkah Abadi</p>
                <p class="footer-desc">
                    Supplier produk homecare, laundry, dan pewangi B2B terpercaya.
                    Melayani mitra bisnis di seluruh Indonesia sejak 2011.
                </p>

                <!-- Pill-shaped certification badges -->
                <div class="footer-certs">
                    <span class="cert-badge">BPOM</span>
                    <span class="cert-badge">Halal MUI</span>
                    <span class="cert-badge">ISO 9001</span>
                </div>

                <!-- Social links — teks inisial, tanpa ikon sistem -->
                <div class="footer-social">
                    <!--
                        TODO: Ganti href="#" dengan URL akun Instagram resmi Indotech.
                        Contoh: href="https://www.instagram.com/indotech.id/"
                    -->
                    <a href="#" class="social-link" aria-label="Instagram Indotech">IG</a>

                    <!--
                        TODO: Ganti href="#" dengan URL halaman Facebook resmi Indotech.
                        Contoh: href="https://www.facebook.com/indotech.id"
                    -->
                    <a href="#" class="social-link" aria-label="Facebook Indotech">FB</a>

                    <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>"
                       class="social-link"
                       aria-label="WhatsApp Indotech"
                       target="_blank"
                       rel="noopener">WA</a>
                </div>

            </div><!-- /footer-brand -->

            <!-- ── Kolom Navigasi ────────────────────────────── -->
            <div class="footer-col">
                <h4 class="footer-heading">Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a></li>
                    <li><a href="<?php echo esc_url( home_url('/tentang-kami') ); ?>">Tentang Kami</a></li>
                    <li><a href="<?php echo esc_url( home_url('/produk') ); ?>">Produk</a></li>
                    <li><a href="<?php echo esc_url( home_url('/kemitraan') ); ?>">Kemitraan</a></li>
                    <li><a href="<?php echo esc_url( home_url('/blog') ); ?>">Blog</a></li>
                    <li><a href="<?php echo esc_url( home_url('/kontak') ); ?>">Kontak</a></li>
                </ul>
            </div>

            <!-- ── Kolom Brand Kami ──────────────────────────── -->
            <div class="footer-col">
                <h4 class="footer-heading">Brand Kami</h4>
                <ul class="footer-links footer-brand-list">
                    <!--
                        TODO: Ganti href="#" dengan URL halaman produk masing-masing brand
                        ketika halaman tersebut sudah dibuat.
                    -->
                    <li><a href="#">Orchid Care</a></li>
                    <li><a href="#">Depo Cleanique</a></li>
                    <li><a href="#">Malabeez</a></li>
                    <li><a href="#">Cokusi</a></li>
                </ul>
            </div>

            <!-- ── Kolom Kontak ──────────────────────────────── -->
            <div class="footer-col">
                <h4 class="footer-heading">Hubungi Kami</h4>
                <ul class="footer-contact-list">

                    <li class="footer-contact-item">
                        <span class="footer-contact-label">Telepon</span>
                        <a href="tel:<?php echo esc_attr( preg_replace('/[\s\-]/', '', $phone) ); ?>">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </li>

                    <li class="footer-contact-item">
                        <span class="footer-contact-label">Email</span>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </li>

                    <li class="footer-contact-item">
                        <span class="footer-contact-label">Alamat</span>
                        <span><?php echo esc_html( $address ); ?></span>
                    </li>

                    <li class="footer-contact-item">
                        <span class="footer-contact-label">WhatsApp</span>
                        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>" target="_blank" rel="noopener">
                            <?php echo esc_html( $whatsapp ); ?>
                        </a>
                    </li>

                </ul>
            </div>

        </div><!-- /footer-grid -->
    </div><!-- /footer-top -->

    <!-- ══════════════════════════════════════════════════════════
         FOOTER BOTTOM — copyright & legal links
    ══════════════════════════════════════════════════════════ -->
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p class="copyright">
                &copy; <?php echo esc_html( date('Y') ); ?> PT Indotech Berkah Abadi. All rights reserved.
            </p>
            <div class="footer-legal">
                <a href="<?php echo esc_url( home_url('/privacy-policy') ); ?>">Privacy Policy</a>
                <a href="<?php echo esc_url( home_url('/syarat-ketentuan') ); ?>">Term of Use</a>
                <a href="<?php echo esc_url( home_url('/cookie-policy') ); ?>">Cookie Policy</a>
            </div>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
