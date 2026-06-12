<?php
/**
 * Custom 404 template.
 *
 * @package Depocleanique_Custom
 */

get_header();
get_template_part( 'template-parts/layout/site-header' );

$catalog_url = function_exists( 'wc_get_page_permalink' )
    ? wc_get_page_permalink( 'shop' )
    : home_url( '/katalog/' );

if ( empty( $catalog_url ) ) {
    $catalog_url = home_url( '/katalog/' );
}
?>

<main id="main-content" class="dc-not-found-page">
    <section class="dc-not-found-section">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="dc-not-found-content">
                <p class="dc-not-found-code"><?php esc_html_e( '404', 'depocleanique-custom' ); ?></p>
                <h1><?php esc_html_e( 'Halaman tidak ditemukan', 'depocleanique-custom' ); ?></h1>
                <p><?php esc_html_e( 'Maaf, halaman yang Anda buka mungkin sudah dipindahkan, dihapus, atau alamatnya tidak lengkap.', 'depocleanique-custom' ); ?></p>

                <div class="dc-not-found-actions">
                    <a class="dc-wc-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <span class="material-symbols-outlined" aria-hidden="true">home</span>
                        <span><?php esc_html_e( 'Kembali ke Beranda', 'depocleanique-custom' ); ?></span>
                    </a>
                    <a class="dc-wc-button dc-wc-button-secondary" href="<?php echo esc_url( $catalog_url ); ?>">
                        <span class="material-symbols-outlined" aria-hidden="true">inventory_2</span>
                        <span><?php esc_html_e( 'Lihat Katalog', 'depocleanique-custom' ); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
