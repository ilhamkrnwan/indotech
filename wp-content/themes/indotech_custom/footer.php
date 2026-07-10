<?php
/**
 * Footer
 *
 * Grid 4-kolom: Brand | Navigasi | Brand Kami | Hubungi Kami
 * Desain: tipografi bold, palet cobalt/ink/white, tanpa ikon sistem.
 * Social links menggunakan inisial teks (IG / FB / WA).
 */

$phone    = indotech_opt( 'phone',    '+62 856-0006-1005' );
$email    = indotech_opt( 'email',    'indotechberkahabadi@gmail.com' );
$address  = indotech_opt( 'address',  'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285' );
$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya mengenai produk dan kemitraan.' );
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
                    $logo_path = get_template_directory() . '/assets/images/logo-indotech-baru.avif';
                    if ( file_exists( $logo_path ) ):
                    ?>
                        <!--
                            Logo footer — dimuat dengan filter brightness(0) invert(1)
                            agar tampil putih di atas background gelap.
                        -->
                        <img
                            src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotech-baru.avif' ); ?>"
                            alt="PT Indotech Berkah Abadi"
                            class="footer-logo-img"
                            width="160"
                            height="51"
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

                <!-- Social links — menggunakan ikon SVG -->
                <div class="footer-social">
                    <!--
                        TODO: Ganti href="#" dengan URL halaman akun Instagram resmi Indotech.
                        Contoh: href="https://www.instagram.com/indotech.id/"
                    -->
                    <a href="https://www.instagram.com/orchidcareofficial" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram Indotech">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>

                    <!--
                        TODO: Ganti href="#" dengan URL halaman Facebook resmi Indotech.
                        Contoh: href="https://www.facebook.com/indotech.id"
                    -->
                    <a href="https://www.facebook.com/indotechgroup/" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook Indotech">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>

                    <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                       class="social-link"
                       aria-label="WhatsApp Indotech"
                       target="_blank"
                       rel="noopener">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                        </svg>
                    </a>
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
                    <?php
                    $brands_query = new WP_Query([
                        'post_type'      => 'brand',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC'
                    ]);
                    if ($brands_query->have_posts()) :
                        while ($brands_query->have_posts()) : $brands_query->the_post();
                            $b_url = carbon_get_post_meta(get_the_ID(), 'brand_website_url');
                            if (empty($b_url)) {
                                $b_url = get_permalink();
                            }
                            if (strtolower(trim(get_the_title())) === 'cokusi') {
                                continue;
                            }
                            ?>
                            <li><a href="<?php echo esc_url($b_url); ?>" target="_blank" rel="noopener"><?php the_title(); ?></a></li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <li><a href="https://orchidbrand.id/" target="_blank" rel="noopener">Orchid Care</a></li>
                        <li><a href="https://cleaniquelab.com/" target="_blank" rel="noopener">Cleanique Lab</a></li>
                        <li><a href="https://depocleanique.co.id/" target="_blank" rel="noopener">Depo Cleanique</a></li>
                        <li><a href="https://cleaniqueacademy.com/" target="_blank" rel="noopener">Cleanique Academy</a></li>
                        <li><a href="https://cleaniquemart.com/" target="_blank" rel="noopener">Cleanique Mart</a></li>
                        <li><a href="https://malabeez.co.id/" target="_blank" rel="noopener">Malabeez</a></li>
                        <?php
                    endif;
                    ?>
                </ul>
            </div>

            <!-- ── Kolom Kontak ──────────────────────────────── -->
            <div class="footer-col">
                <h4 class="footer-heading">Hubungi Kami</h4>
                <ul class="footer-contact-list">

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
                        <div class="footer-wa-links" style="display: flex; flex-direction: column; gap: 8px; margin-top: 4px;">
                            <a href="https://wa.me/6282215840088?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai program Pelatihan.'); ?>" target="_blank" rel="noopener">
                                +62 822-1584-0088 ( CS Pelatihan )
                            </a>
                            <a href="https://wa.me/6287885590088?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai program Keagenan.'); ?>" target="_blank" rel="noopener">
                                +62 878-8559-0088 ( CS Keagenan )
                            </a>
                            <a href="https://wa.me/6285559474797?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai Retail Produk.'); ?>" target="_blank" rel="noopener">
                                +62 855-5947-4797 ( CS Retail Produk )
                            </a>
                        </div>
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
                &copy; <?php echo esc_html( date('Y') ); ?> PT Indotech Berkah Abadi. Hak cipta dilindungi undang-undang.
            </p>
            <div class="footer-legal">
                <a href="<?php echo esc_url( home_url('/privacy-policy') ); ?>">Kebijakan Privasi</a>
                <a href="<?php echo esc_url( home_url('/syarat-ketentuan') ); ?>">Syarat & Ketentuan</a>
                <a href="<?php echo esc_url( home_url('/cookie-policy') ); ?>">Kebijakan Cookie</a>
            </div>
        </div>
    </div>

</footer>

<!-- Floating Buttons: WhatsApp & Scroll Up -->
<div class="indotech-floating-actions" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
    <!-- Scroll Up Floating Button -->
    <a href="#" 
       id="indotech-scroll-up" 
       class="floating-btn scroll-btn" 
       aria-label="Kembali ke atas"
       style="width: 50px; height: 50px; background-color: #0057FF; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.15); transition: opacity 0.3s ease, transform 0.3s ease, background-color 0.3s ease; text-decoration: none; opacity: 0; pointer-events: none; transform: translateY(10px); margin-bottom: 8px;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </a>

    <!-- WhatsApp Floating Actions Row (Horizontal row: trigger on the right, CS buttons slide out to the left) -->
    <div class="wa-floating-row">
        <!-- WhatsApp Floating Action Trigger Button -->
        <a href="#" 
           id="indotech-wa-trigger" 
           class="floating-btn wa-btn" 
           aria-label="Hubungi kami melalui WhatsApp"
           style="width: 50px; height: 50px; background-color: #25D366; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.15); transition: transform 0.3s ease, background-color 0.3s ease; text-decoration: none; z-index: 10000; position: relative; flex-shrink: 0;">
            <!-- Inactive icon -->
            <svg id="wa-icon-msg" width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
            <!-- Active close icon -->
            <svg id="wa-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </a>

        <!-- CS Keagenan -->
        <a href="https://wa.me/6287885590088?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai program Keagenan.'); ?>" 
           class="wa-floating-card card-keagenan" 
           target="_blank" 
           rel="noopener"
           aria-label="Hubungi CS Keagenan via WhatsApp">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
            <span>Keagenan</span>
        </a>

        <!-- CS Retail -->
        <a href="https://wa.me/6285559474797?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai Retail Produk.'); ?>" 
           class="wa-floating-card card-retail" 
           target="_blank" 
           rel="noopener"
           aria-label="Hubungi CS Retail via WhatsApp">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
            <span>Retail</span>
        </a>

        <!-- CS Pelatihan -->
        <a href="https://wa.me/6282215840088?text=<?php echo rawurlencode('Halo Indotech, saya ingin bertanya mengenai program Pelatihan.'); ?>" 
           class="wa-floating-card card-pelatihan" 
           target="_blank" 
           rel="noopener"
           aria-label="Hubungi CS Pelatihan via WhatsApp">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
            <span>Pelatihan</span>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollBtn = document.getElementById('indotech-scroll-up');
    if (scrollBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollBtn.style.opacity = '1';
                scrollBtn.style.pointerEvents = 'auto';
                scrollBtn.style.transform = 'translateY(0)';
            } else {
                scrollBtn.style.opacity = '0';
                scrollBtn.style.pointerEvents = 'none';
                scrollBtn.style.transform = 'translateY(10px)';
            }
        });
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Toggle WhatsApp Cards
    const waTrigger = document.getElementById('indotech-wa-trigger');
    const waCards = document.querySelectorAll('.wa-floating-card');
    const waIconMsg = document.getElementById('wa-icon-msg');
    const waIconClose = document.getElementById('wa-icon-close');

    if (waTrigger) {
        waTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isClosed = waIconMsg.style.display !== 'none';
            if (isClosed) {
                // Show cards
                waIconMsg.style.display = 'none';
                waIconClose.style.display = 'block';
                waTrigger.style.backgroundColor = '#ef4444'; // turn red on active
                waCards.forEach((card, idx) => {
                    setTimeout(() => {
                        card.classList.add('active');
                    }, idx * 80);
                });
            } else {
                // Hide cards
                waIconMsg.style.display = 'block';
                waIconClose.style.display = 'none';
                waTrigger.style.backgroundColor = '#25D366';
                waCards.forEach((card, idx) => {
                    setTimeout(() => {
                        card.classList.remove('active');
                    }, (waCards.length - 1 - idx) * 80);
                });
            }
        });

        // Close on clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.indotech-floating-actions')) {
                if (waIconMsg.style.display === 'none') {
                    waIconMsg.style.display = 'block';
                    waIconClose.style.display = 'none';
                    waTrigger.style.backgroundColor = '#25D366';
                    waCards.forEach(card => card.classList.remove('active'));
                }
            }
        });
    }
});
</script>

<style>
.wa-floating-row {
    display: flex;
    flex-direction: row-reverse; /* Trigger on the right, cards to the left */
    align-items: center;
    gap: 10px;
}
.wa-floating-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 30px; /* Sleek capsule pill shape */
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transform: translateX(15px) scale(0.9);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
}
.wa-floating-card.active {
    opacity: 1;
    pointer-events: auto;
    transform: translateX(0) scale(1);
}
.wa-floating-card:hover {
    transform: translateY(-3px) scale(1.05) !important;
}
.card-keagenan {
    background-color: #0f172a;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
}
.card-keagenan:hover {
    background-color: #1e293b !important;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.45) !important;
}
.card-retail {
    background-color: #25D366;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
}
.card-retail:hover {
    background-color: #1ebea5 !important;
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.45) !important;
}
.card-pelatihan {
    background-color: #0057FF;
    box-shadow: 0 4px 12px rgba(0, 87, 255, 0.25);
}
.card-pelatihan:hover {
    background-color: #0046cc !important;
    box-shadow: 0 8px 20px rgba(0, 87, 255, 0.45) !important;
}
.floating-btn:hover {
    transform: scale(1.1) !important;
}
.scroll-btn:hover {
    background-color: #0046cc !important;
}
@media (max-width: 768px) {
    .indotech-floating-actions {
        bottom: 20px !important;
        right: 20px !important;
        gap: 12px !important;
    }
    .wa-floating-row {
        flex-direction: column-reverse; /* Stack vertically above trigger on mobile */
        align-items: flex-end;
        gap: 10px;
    }
    .wa-floating-card {
        padding: 8px 14px !important;
        font-size: 12px !important;
        transform: translateY(15px) scale(0.9);
    }
    .wa-floating-card.active {
        transform: translateY(0) scale(1);
    }
}
</style>

<?php wp_footer(); ?>
</body>
</html>
