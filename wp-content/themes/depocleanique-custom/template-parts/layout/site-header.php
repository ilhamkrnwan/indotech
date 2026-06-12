<?php
/**
 * Template Part: Site Header
 * Navigasi utama (pill nav) — tampil di semua halaman.
 * Desain mengikuti _landing-source.html dengan palet brand biru + aksen hijau.
 *
 * Link aman WordPress + helper dc_get_*() untuk WhatsApp.
 * JS mobile menu ada di assets/js/main.js (ID dipertahankan agar kompatibel).
 *
 * Ubah nomor WA: Appearance → Customize → Depo Cleanique → WhatsApp & Kontak
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Anchor homepage yang aman: di front page cukup #id (smooth-scroll via main.js),
 * di halaman lain pakai URL absolut ke homepage + hash.
 */
$dc_anchor = static function ( $id ) {
    return is_front_page() ? '#' . $id : esc_url( home_url( '/#' . $id ) );
};

// Daftar link navigasi — label => href
$dc_nav_links = [
    [ 'label' => __( 'Beranda', 'depocleanique-custom' ),      'href' => esc_url( home_url( '/' ) ),              'active' => is_front_page() ],
    [ 'label' => __( 'Tentang Kami', 'depocleanique-custom' ), 'href' => esc_url( home_url( '/tentang-kami/' ) ), 'active' => is_page( 'tentang-kami' ) ],
    [ 'label' => __( 'Produk', 'depocleanique-custom' ),       'href' => $dc_anchor( 'katalog' ),                 'active' => false ],
    [ 'label' => __( 'Paket', 'depocleanique-custom' ),        'href' => $dc_anchor( 'paket' ),                   'active' => false ],
    [ 'label' => __( 'Kemitraan', 'depocleanique-custom' ),    'href' => $dc_anchor( 'alur-kemitraan' ),          'active' => false ],
    [ 'label' => __( 'FAQ', 'depocleanique-custom' ),          'href' => $dc_anchor( 'faq' ),                     'active' => false ],
    [ 'label' => __( 'Kontak', 'depocleanique-custom' ),       'href' => esc_url( home_url( '/kontak/' ) ),       'active' => is_page( 'kontak' ) ],
];

// Logo: custom logo WP → file webp di assets (jika ada) → wordmark teks.
$dc_logo_path = get_template_directory() . '/assets/images/depocleanique.webp';
$dc_logo_uri  = get_template_directory_uri() . '/assets/images/depocleanique.webp';
?>

<header id="site-header" class="fixed top-3 sm:top-5 left-1/2 -translate-x-1/2 w-[94%] max-w-6xl z-50">
    <div class="nav-pill flex items-center justify-between px-4 sm:px-5 py-3 rounded-2xl">

        <!-- ① Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
           class="flex items-center no-underline flex-shrink-0"
           aria-label="<?php esc_attr_e( 'Depo Cleanique — Kembali ke beranda', 'depocleanique-custom' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php elseif ( file_exists( $dc_logo_path ) ) : ?>
                <img src="<?php echo esc_url( $dc_logo_uri ); ?>"
                     alt="<?php bloginfo( 'name' ); ?>"
                     class="h-9 sm:h-10 w-auto object-contain block">
            <?php else : ?>
                <span class="font-extrabold text-lg leading-none tracking-tight">
                    <span style="color:var(--color-primary);">Depo</span><span style="color:var(--color-navy);">Cleanique</span>
                </span>
            <?php endif; ?>
        </a>

        <!-- ② Nav links — pill group (desktop) -->
        <nav class="site-nav hidden md:flex items-center gap-0.5 rounded-full px-1.5 py-1"
             style="background:var(--color-surface-soft);"
             aria-label="<?php esc_attr_e( 'Navigasi utama', 'depocleanique-custom' ); ?>">
            <?php foreach ( $dc_nav_links as $link ) : ?>
                <a class="nav-link<?php echo $link['active'] ? ' active' : ''; ?>"
                   href="<?php echo $link['href']; // already escaped ?>"
                   <?php echo $link['active'] ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $link['label'] ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- ③ CTA (desktop) -->
        <div class="header-actions hidden md:flex items-center">
            <a href="<?php echo esc_url( dc_get_wa_url( 'header' ) ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="nav-cta nav-cta-solid"
               title="<?php esc_attr_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?>"
               aria-label="<?php esc_attr_e( 'Konsultasi gratis via WhatsApp', 'depocleanique-custom' ); ?>">
                <span class="material-symbols-outlined nav-cta-icon" aria-hidden="true">forum</span>
                <span class="nav-cta-label"><?php esc_html_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?></span>
                <span class="material-symbols-outlined nav-cta-arrow" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <!-- ④ Mobile hamburger -->
        <button id="mobile-menu-toggle"
                type="button"
                class="site-menu-toggle md:hidden p-2 rounded-xl"
                style="background:var(--color-surface-soft); border:1px solid var(--color-border);"
                aria-label="<?php esc_attr_e( 'Buka menu navigasi', 'depocleanique-custom' ); ?>"
                aria-expanded="false"
                aria-controls="mobile-menu">
            <span id="icon-hamburger" class="material-symbols-outlined align-middle" style="font-size:22px;color:var(--color-navy);">menu</span>
            <span id="icon-close" class="material-symbols-outlined align-middle hidden" style="font-size:22px;color:var(--color-navy);">close</span>
        </button>
    </div>

    <!-- ── Mobile Menu Drawer ─────────────────────────── -->
    <div id="mobile-menu"
         class="site-mobile-menu hidden nav-pill mt-2 rounded-2xl px-3 py-3"
         role="navigation"
         aria-label="<?php esc_attr_e( 'Menu navigasi mobile', 'depocleanique-custom' ); ?>">
        <div class="flex flex-col gap-0.5">
            <?php foreach ( $dc_nav_links as $link ) : ?>
                <a class="nav-link-mobile<?php echo $link['active'] ? ' active' : ''; ?>"
                   href="<?php echo $link['href']; // already escaped ?>"
                   <?php echo $link['active'] ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $link['label'] ); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo esc_url( dc_get_wa_url( 'header' ) ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="nav-cta-solid mt-2 justify-center"
               style="width:100%;"
               aria-label="<?php esc_attr_e( 'Konsultasi gratis via WhatsApp', 'depocleanique-custom' ); ?>">
                <span class="material-symbols-outlined" style="font-size:18px;" aria-hidden="true">forum</span>
                <?php esc_html_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?>
            </a>
        </div>
    </div>
</header>

<?php if ( ! is_front_page() ) : ?>
    <!-- Spacer untuk pill nav fixed (halaman non-homepage). Hero homepage punya padding sendiri. -->
    <div class="h-24" aria-hidden="true"></div>
<?php endif; ?>
