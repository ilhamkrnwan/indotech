<?php
/**
 * WooCommerce product archive template.
 *
 * @package Depocleanique_Custom
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/layout/site-header' );

$archive_title       = woocommerce_page_title( false );
$archive_description = '';

if ( is_shop() && function_exists( 'wc_get_page_id' ) ) {
    $shop_page_id = wc_get_page_id( 'shop' );

    if ( $shop_page_id > 0 ) {
        $archive_description = get_post_field( 'post_excerpt', $shop_page_id );
    }
} elseif ( is_product_taxonomy() ) {
    $archive_description = term_description();
}

if ( '' === trim( wp_strip_all_tags( $archive_description ) ) ) {
    $archive_description = __(
        'Temukan produk homecare Depo Cleanique untuk kebutuhan refill, laundry, kebersihan rumah, dan peluang usaha harian.',
        'depocleanique-custom'
    );
}
?>

<main id="main-content" class="dc-wc-page dc-wc-archive">
    <section class="dc-wc-hero">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
                <div class="dc-wc-breadcrumb">
                    <?php woocommerce_breadcrumb(); ?>
                </div>
            <?php endif; ?>

            <div class="dc-wc-hero-copy">
                <p class="dc-wc-eyebrow">
                    <span aria-hidden="true"></span>
                    <?php esc_html_e( 'Katalog Produk', 'depocleanique-custom' ); ?>
                </p>
                <h1><?php echo esc_html( $archive_title ); ?></h1>
                <div class="dc-wc-hero-description">
                    <?php echo wp_kses_post( wpautop( $archive_description ) ); ?>
                </div>
            </div>

            <form class="dc-wc-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label class="screen-reader-text" for="dc-wc-search-field"><?php esc_html_e( 'Cari produk', 'depocleanique-custom' ); ?></label>
                <span aria-hidden="true"><?php echo dc_icon( 'search' ); ?></span>
                <input id="dc-wc-search-field" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Cari produk Depo Cleanique', 'depocleanique-custom' ); ?>">
                <input type="hidden" name="post_type" value="product">
                <button type="submit"><?php esc_html_e( 'Cari', 'depocleanique-custom' ); ?></button>
            </form>
        </div>
    </section>

    <section class="dc-wc-catalog">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <?php if ( function_exists( 'woocommerce_output_all_notices' ) ) : ?>
                <?php woocommerce_output_all_notices(); ?>
            <?php endif; ?>

            <?php if ( woocommerce_product_loop() ) : ?>
                <?php wc_set_loop_prop( 'columns', 4 ); ?>

                <div class="dc-wc-toolbar">
                    <div class="dc-wc-count">
                        <?php woocommerce_result_count(); ?>
                    </div>
                    <div class="dc-wc-ordering">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <div class="dc-wc-products">
                    <?php woocommerce_product_loop_start(); ?>

                    <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                        <?php while ( have_posts() ) : ?>
                            <?php the_post(); ?>
                            <?php wc_get_template_part( 'content', 'product' ); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php woocommerce_product_loop_end(); ?>
                </div>

                <?php woocommerce_pagination(); ?>
            <?php else : ?>
                <div class="dc-wc-empty-state">
                    <?php echo dc_icon( 'package', 'dc-icon-lg' ); ?>
                    <h2><?php esc_html_e( 'Produk belum ditemukan', 'depocleanique-custom' ); ?></h2>
                    <p><?php esc_html_e( 'Coba gunakan kata kunci lain atau kembali ke katalog utama untuk melihat pilihan produk yang tersedia.', 'depocleanique-custom' ); ?></p>
                    <a class="dc-wc-button" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/katalog/' ) ); ?>">
                        <?php esc_html_e( 'Kembali ke Katalog', 'depocleanique-custom' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
