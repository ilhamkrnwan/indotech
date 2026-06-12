<?php
/**
 * Template Part: Site Footer
 * Footer global dengan latar gelap netral dan aksen brand.
 *
 * Semua data global via helper dc_get_*() — tidak ada hardcode.
 * Tahun copyright dinamis.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$dc_anchor = static function ( $id ) {
    return is_front_page() ? '#' . $id : esc_url( home_url( '/#' . $id ) );
};

$dc_catalog_url = function_exists( 'wc_get_page_permalink' )
    ? wc_get_page_permalink( 'shop' )
    : home_url( '/katalog/' );

if ( empty( $dc_catalog_url ) ) {
    $dc_catalog_url = home_url( '/katalog/' );
}

$dc_year = date( 'Y' );

// Kolom navigasi — label => href
$dc_foot_company = [
    [ 'label' => __( 'Tentang Kami', 'depocleanique-custom' ), 'href' => esc_url( home_url( '/tentang-kami/' ) ) ],
    [ 'label' => __( 'Kontak', 'depocleanique-custom' ),       'href' => esc_url( home_url( '/kontak/' ) ) ],
    [ 'label' => __( 'FAQ', 'depocleanique-custom' ),          'href' => $dc_anchor( 'faq' ) ],
];
$dc_foot_service = [
    [ 'label' => __( 'Paket Kemitraan', 'depocleanique-custom' ),  'href' => $dc_anchor( 'paket' ) ],
    [ 'label' => __( 'Katalog Produk', 'depocleanique-custom' ),   'href' => esc_url( $dc_catalog_url ) ],
    [ 'label' => __( 'Alur Kemitraan', 'depocleanique-custom' ),   'href' => $dc_anchor( 'alur-kemitraan' ) ],
];

// Social — platform => [label, url, svg path]
$dc_socials = [
    'instagram' => [
        'label' => __( 'Instagram', 'depocleanique-custom' ),
        'svg'   => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z',
    ],
    'facebook'  => [
        'label' => __( 'Facebook', 'depocleanique-custom' ),
        'svg'   => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
    ],
    'tiktok'    => [
        'label' => __( 'TikTok', 'depocleanique-custom' ),
        'svg'   => 'M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64c.298 0 .595.042.88.123V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z',
    ],
];

// Logo footer (versi sama, kontras di background gelap)
$dc_logo_path = get_template_directory() . '/assets/images/depocleanique.webp';
$dc_logo_uri  = get_template_directory_uri() . '/assets/images/depocleanique.webp';
?>

<footer class="footer-new">
    <!-- Top gradient accent line -->
    <div class="footer-top-bar"></div>

    <div class="container mx-auto px-margin-mobile md:px-margin-desktop pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">

            <!-- ─ Brand Column ─ -->
            <div class="md:col-span-4 space-y-6">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                   class="inline-block no-underline"
                   aria-label="<?php esc_attr_e( 'Depo Cleanique — Kembali ke beranda', 'depocleanique-custom' ); ?>">
                    <?php if ( file_exists( $dc_logo_path ) ) : ?>
                        <img src="<?php echo esc_url( $dc_logo_uri ); ?>"
                             alt="<?php bloginfo( 'name' ); ?>"
                             style="height:52px;width:auto;object-fit:contain;display:block;">
                    <?php else : ?>
                        <span class="font-extrabold text-xl tracking-tight" style="color:#fff;">
                            <span style="color:#1E5FA8;">Depo</span>Cleanique
                        </span>
                    <?php endif; ?>
                </a>

                <p style="font-size:14px;line-height:1.75;color:rgba(255,255,255,0.38);max-width:280px;">
                    <?php esc_html_e( 'Pionir refill station berbasis AI di Indonesia sejak 2011. Membantu UMKM tumbuh lewat bisnis homecare terjangkau.', 'depocleanique-custom' ); ?>
                </p>

                <!-- Certification badges -->
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="footer-badge">🏆 Kemenkes RI</span>
                    <span class="footer-badge">✅ Halal MUI</span>
                    <span class="footer-badge">⚖️ DIRJEN HAKI</span>
                </div>

                <!-- Social -->
                <div style="display:flex;gap:8px;" aria-label="<?php esc_attr_e( 'Media sosial', 'depocleanique-custom' ); ?>">
                    <?php foreach ( $dc_socials as $key => $s ) : ?>
                        <a href="<?php echo esc_url( dc_get_social_url( $key ) ); ?>"
                           class="footer-social"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr( sprintf( /* translators: %s: nama platform */ __( '%s Depo Cleanique', 'depocleanique-custom' ), $s['label'] ) ); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="<?php echo esc_attr( $s['svg'] ); ?>"/>
                            </svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ─ Nav Col: Perusahaan ─ -->
            <div class="md:col-span-2">
                <span class="footer-col-label"><?php esc_html_e( 'Perusahaan', 'depocleanique-custom' ); ?></span>
                <ul class="space-y-3.5">
                    <?php foreach ( $dc_foot_company as $link ) : ?>
                        <li><a class="footer-link" href="<?php echo $link['href']; // escaped ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- ─ Nav Col: Layanan ─ -->
            <div class="md:col-span-2">
                <span class="footer-col-label"><?php esc_html_e( 'Layanan', 'depocleanique-custom' ); ?></span>
                <ul class="space-y-3.5">
                    <?php foreach ( $dc_foot_service as $link ) : ?>
                        <li><a class="footer-link" href="<?php echo $link['href']; // escaped ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- ─ Kontak (helper data global) ─ -->
            <div class="md:col-span-4">
                <span class="footer-col-label"><?php esc_html_e( 'Kontak', 'depocleanique-custom' ); ?></span>
                <ul class="space-y-3.5">
                    <li>
                        <a class="footer-link" style="display:inline-flex;align-items:center;gap:6px;"
                           href="<?php echo esc_url( dc_get_wa_url( 'footer' ) ); ?>"
                           target="_blank" rel="noopener noreferrer">
                            <span class="material-symbols-outlined" style="font-size:15px;">chat</span>
                            <?php echo esc_html( dc_get_wa_label() ); ?>
                        </a>
                    </li>
                    <li>
                        <a class="footer-link" style="display:inline-flex;align-items:center;gap:6px;"
                           href="<?php echo esc_url( 'mailto:' . dc_get_email() ); ?>">
                            <span class="material-symbols-outlined" style="font-size:15px;">mail</span>
                            <?php echo esc_html( dc_get_email() ); ?>
                        </a>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:6px;color:rgba(255,255,255,0.4);font-size:14px;">
                        <span class="material-symbols-outlined" style="font-size:15px;line-height:1.4;">location_on</span>
                        <address class="not-italic" style="line-height:1.6;"><?php echo dc_get_address_html(); // sudah di-escape di helper ?></address>
                    </li>
                    <li style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.4);font-size:14px;">
                        <span class="material-symbols-outlined" style="font-size:15px;">schedule</span>
                        <?php echo esc_html( dc_get_business_hours() ); ?>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-divider"></div>
        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:12px;margin-top:24px;">
            <p style="font-size:12px;color:rgba(255,255,255,0.2);">
                &copy; <?php echo esc_html( $dc_year ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'depocleanique-custom' ); ?>
            </p>
            <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:center;">
                <a class="footer-link" href="<?php echo esc_url( home_url( '/kebijakan-privasi/' ) ); ?>" style="font-size:12px;"><?php esc_html_e( 'Kebijakan Privasi', 'depocleanique-custom' ); ?></a>
                <a class="footer-link" href="<?php echo esc_url( home_url( '/syarat-ketentuan/' ) ); ?>" style="font-size:12px;"><?php esc_html_e( 'Syarat & Ketentuan', 'depocleanique-custom' ); ?></a>
                <a href="<?php echo esc_url( dc_get_wa_url( 'footer' ) ); ?>"
                   target="_blank" rel="noopener noreferrer"
                   style="font-size:12px;color:rgba(79,179,255,0.8);text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                    <span class="material-symbols-outlined" style="font-size:13px;">chat</span>
                    <?php echo esc_html( dc_get_wa_label() ); ?>
                </a>
            </div>
        </div>
    </div>
</footer>
