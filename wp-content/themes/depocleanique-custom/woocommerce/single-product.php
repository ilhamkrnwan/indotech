<?php
/**
 * WooCommerce single product template.
 *
 * @package Depocleanique_Custom
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/layout/site-header' );
?>

<main id="main-content" class="dc-wc-page dc-single-product">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <section class="dc-wc-catalog">
            <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="dc-wc-empty-state">
                    <?php echo dc_icon( 'package', 'dc-icon-lg' ); ?>
                    <h1><?php esc_html_e( 'Produk tidak tersedia', 'depocleanique-custom' ); ?></h1>
                    <p><?php esc_html_e( 'Produk yang Anda cari belum tersedia atau sudah dipindahkan.', 'depocleanique-custom' ); ?></p>
                    <a class="dc-wc-button" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/katalog/' ) ); ?>">
                        <?php esc_html_e( 'Buka Katalog', 'depocleanique-custom' ); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
