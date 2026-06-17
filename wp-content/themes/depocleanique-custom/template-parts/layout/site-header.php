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

/* ── Katalog: WooCommerce shop bila ada, fallback ke page /katalog/ ── */
$dc_catalog_url = function_exists( 'wc_get_page_permalink' )
    ? wc_get_page_permalink( 'shop' )
    : home_url( '/katalog/' );

if ( empty( $dc_catalog_url ) ) {
    $dc_catalog_url = home_url( '/katalog/' );
}

$dc_catalog_active = is_page( 'katalog' );

if ( function_exists( 'is_shop' ) ) {
    $dc_catalog_active = $dc_catalog_active
        || is_shop()
        || is_product_category()
        || is_product_tag()
        || is_product()
        || ( is_search() && 'product' === get_query_var( 'post_type' ) );
}

/* ── Artikel/Blog: aktif untuk arsip & single post ── */
$dc_blog_active = ( is_home() && ! is_front_page() )
    || is_category()
    || is_tag()
    || is_author()
    || is_date()
    || is_singular( 'post' )
    || ( is_search() && 'product' !== get_query_var( 'post_type' ) );

$dc_partnership_active = is_post_type_archive( 'partnership' )
    || is_singular( 'partnership' )
    || is_tax( 'partnership_type' )
    || is_page( [ 'kemitraan', 'mitra' ] );

// Daftar link navigasi — label => href, active berdasarkan URL/konteks WP saat ini.
$dc_nav_links = [
    [ 'label' => __( 'Beranda', 'depocleanique-custom' ),      'href' => esc_url( home_url( '/' ) ),              'active' => ( is_front_page() && ! $dc_blog_active && ! $dc_catalog_active && ! $dc_partnership_active ) ],
    [ 'label' => __( 'Tentang Kami', 'depocleanique-custom' ), 'href' => esc_url( home_url( '/tentang-kami/' ) ), 'active' => is_page( 'tentang-kami' ) ],
    [ 'label' => __( 'Katalog', 'depocleanique-custom' ),      'href' => esc_url( $dc_catalog_url ),              'active' => (bool) $dc_catalog_active ],
    [ 'label' => __( 'Artikel', 'depocleanique-custom' ),      'href' => esc_url( home_url( '/artikel/' ) ),      'active' => (bool) $dc_blog_active ],
    [ 'label' => __( 'Kemitraan', 'depocleanique-custom' ),    'href' => esc_url( home_url( '/kemitraan/' ) ),    'active' => (bool) $dc_partnership_active ],
    [ 'label' => __( 'Kontak', 'depocleanique-custom' ),       'href' => esc_url( home_url( '/kontak/' ) ),       'active' => is_page( 'kontak' ) ],
];

// Logo: custom logo WP → file webp di assets (jika ada) → wordmark teks.
$dc_logo_path = get_template_directory() . '/assets/images/depocleanique.webp';
$dc_logo_uri  = get_template_directory_uri() . '/assets/images/depocleanique.webp';
?>

<?php
/* Snippet logo reusable (header utama + drawer). */
$dc_logo_markup = static function () use ( $dc_logo_path, $dc_logo_uri ) {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } elseif ( file_exists( $dc_logo_path ) ) {
        printf(
            '<img src="%s" alt="%s">',
            esc_url( $dc_logo_uri ),
            esc_attr( get_bloginfo( 'name' ) )
        );
    } else {
        echo '<span class="site-logo-wordmark font-extrabold text-lg leading-none tracking-tight">'
            . '<span style="color:var(--color-primary);">Depo</span><span style="color:var(--color-navy);">Cleanique</span>'
            . '</span>';
    }
};
?>
<header id="site-header" class="site-header z-50">
    <div class="site-header-inner nav-pill flex items-center justify-between">

        <!-- ① Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
           class="site-logo flex items-center no-underline flex-shrink-0"
           aria-label="<?php esc_attr_e( 'Depo Cleanique — Kembali ke beranda', 'depocleanique-custom' ); ?>">
            <?php $dc_logo_markup(); ?>
        </a>

        <!-- ② Nav links — desktop (≥1024px) -->
        <nav class="site-nav items-center gap-1.5"
             aria-label="<?php esc_attr_e( 'Navigasi utama', 'depocleanique-custom' ); ?>">
            <?php foreach ( $dc_nav_links as $link ) : ?>
                <a class="nav-link<?php echo $link['active'] ? ' active' : ''; ?>"
                   href="<?php echo $link['href']; // already escaped ?>"
                   <?php echo $link['active'] ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $link['label'] ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- ③ CTA (desktop ≥1024px) -->
        <div class="header-actions items-center">
            <a href="<?php echo esc_url( dc_get_wa_url( 'header' ) ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="nav-cta nav-cta-solid"
               title="<?php esc_attr_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?>"
               aria-label="<?php esc_attr_e( 'Konsultasi gratis via WhatsApp', 'depocleanique-custom' ); ?>">
                <?php echo dc_icon( 'message-circle', 'nav-cta-icon dc-icon-sm' ); ?>
                <span class="nav-cta-label"><?php esc_html_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?></span>
                <?php echo dc_icon( 'arrow-right', 'nav-cta-arrow dc-icon-sm' ); ?>
            </a>
        </div>

        <!-- ④ Mobile hamburger (<1024px) -->
        <button id="mobile-menu-toggle"
                type="button"
                class="mobile-menu-toggle site-menu-toggle p-2 rounded-xl flex items-center justify-center"
                style="background:var(--color-surface-soft); border:1px solid var(--color-border); width:40px; height:40px;"
                aria-label="<?php esc_attr_e( 'Buka menu navigasi', 'depocleanique-custom' ); ?>"
                aria-expanded="false"
                aria-controls="mobile-menu">
            <span id="icon-hamburger" class="flex items-center justify-center" style="color:var(--color-navy);"><?php echo dc_icon( 'menu', 'dc-icon-md' ); ?></span>
            <span id="icon-close" class="flex items-center justify-center hidden" style="color:var(--color-navy);"><?php echo dc_icon( 'x', 'dc-icon-md' ); ?></span>
        </button>
    </div>

    <!-- ── Backdrop overlay (klik untuk menutup) ─────────── -->
    <div class="mobile-menu-backdrop" data-mobile-menu-close aria-hidden="true"></div>

    <!-- ── Mobile Menu Drawer (satu card vertikal) ───────── -->
    <aside id="mobile-menu"
           class="mobile-menu-drawer"
           aria-hidden="true"
           aria-label="<?php esc_attr_e( 'Menu navigasi mobile', 'depocleanique-custom' ); ?>">

        <!-- List menu satu kolom penuh -->
        <nav class="mobile-menu-nav" aria-label="<?php esc_attr_e( 'Navigasi utama', 'depocleanique-custom' ); ?>">
            <?php foreach ( $dc_nav_links as $link ) : ?>
                <a class="mobile-menu-link<?php echo $link['active'] ? ' is-active' : ''; ?>"
                   href="<?php echo $link['href']; // already escaped ?>"
                   <?php echo $link['active'] ? 'aria-current="page"' : ''; ?>>
                    <span><?php echo esc_html( $link['label'] ); ?></span>
                    <?php echo dc_icon( 'arrow-right', 'dc-icon-sm opacity-55' ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- CTA full width di bawah -->
        <a href="<?php echo esc_url( dc_get_wa_url( 'header' ) ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           class="mobile-menu-cta"
           aria-label="<?php esc_attr_e( 'Konsultasi gratis via WhatsApp', 'depocleanique-custom' ); ?>">
            <?php echo dc_icon( 'message-circle', 'dc-icon-md' ); ?>
            <?php esc_html_e( 'Konsultasi Gratis', 'depocleanique-custom' ); ?>
        </a>
    </aside>
</header>

<?php if ( ! is_front_page() ) : ?>
    <?php
    $dc_spacer_classes = 'internal-page-spacer h-24';

    if ( is_page( [ 'kontak', 'tentang-kami' ] ) ) {
        $dc_spacer_classes .= ' internal-page-spacer--hero';
    } elseif ( $dc_blog_active ) {
        $dc_spacer_classes .= ' internal-page-spacer--article';
    }
    ?>
    <!-- Spacer untuk pill nav fixed (halaman non-homepage). Hero homepage punya padding sendiri. -->
    <div class="<?php echo esc_attr( $dc_spacer_classes ); ?>" aria-hidden="true"></div>
<?php endif; ?>
