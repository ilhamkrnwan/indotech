<?php
/**
 * Custom single product content.
 *
 * @package Depocleanique_Custom
 */

defined( 'ABSPATH' ) || exit;

global $product;

$product = wc_get_product( get_the_ID() );

if ( ! $product ) {
    return;
}

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    return;
}

$product_name      = $product->get_name();
$price_html        = $product->get_price_html();
$whatsapp_message  = sprintf(
    /* translators: %s: product name */
    __( 'Halo Depo Cleanique! Saya tertarik dengan produk %s. Bisa dibantu informasinya?', 'depocleanique-custom' ),
    $product_name
);
$whatsapp_url      = function_exists( 'dc_get_wa_url' ) ? dc_get_wa_url( 'product', $whatsapp_message ) : home_url( '/kontak/' );
$category_list     = wc_get_product_category_list( $product->get_id(), ', ' );
$availability      = $product->get_availability();
$stock_label       = ! empty( $availability['availability'] )
    ? $availability['availability']
    : ( $product->is_in_stock() ? __( 'Tersedia', 'depocleanique-custom' ) : __( 'Stok habis', 'depocleanique-custom' ) );
$stock_class       = $product->is_in_stock() ? 'is-in-stock' : 'is-out-of-stock';
?>

<section class="dc-single-product-hero">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
            <div class="dc-wc-breadcrumb">
                <?php woocommerce_breadcrumb(); ?>
            </div>
        <?php endif; ?>

        <article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'dc-single-product-layout', $product ); ?>>
            <div class="dc-single-gallery">
                <?php woocommerce_show_product_images(); ?>
            </div>

            <div class="dc-single-summary">
                <?php if ( $product->is_on_sale() ) : ?>
                    <span class="dc-single-sale-badge"><?php esc_html_e( 'Promo', 'depocleanique-custom' ); ?></span>
                <?php endif; ?>

                <h1 class="product_title entry-title dc-single-title">
                    <?php echo esc_html( $product_name ); ?>
                </h1>

                <div class="dc-single-price<?php echo $price_html ? '' : ' is-empty-price'; ?>">
                    <?php
                    if ( $price_html ) {
                        echo wp_kses_post( $price_html );
                    } else {
                        esc_html_e( 'Hubungi kami untuk harga', 'depocleanique-custom' );
                    }
                    ?>
                </div>

                <div class="dc-single-stock <?php echo esc_attr( $stock_class ); ?>">
                    <span class="material-symbols-outlined" aria-hidden="true">
                        <?php echo $product->is_in_stock() ? 'check_circle' : 'cancel'; ?>
                    </span>
                    <span><?php echo esc_html( $stock_label ); ?></span>
                </div>

                <?php if ( $product->get_short_description() ) : ?>
                    <div class="dc-single-excerpt">
                        <?php woocommerce_template_single_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <div class="dc-single-purchase">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>

                <?php if ( ! $product->is_in_stock() ) : ?>
                    <p class="dc-single-unavailable">
                        <?php esc_html_e( 'Produk ini sedang tidak tersedia. Hubungi tim kami untuk estimasi stok atau rekomendasi produk pengganti.', 'depocleanique-custom' ); ?>
                    </p>
                <?php endif; ?>

                <a class="dc-single-whatsapp" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">
                    <span class="material-symbols-outlined" aria-hidden="true">chat</span>
                    <span><?php esc_html_e( 'Tanya via WhatsApp', 'depocleanique-custom' ); ?></span>
                </a>

                <?php if ( $category_list ) : ?>
                    <div class="dc-single-meta">
                        <span><?php esc_html_e( 'Kategori', 'depocleanique-custom' ); ?></span>
                        <div><?php echo wp_kses_post( $category_list ); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    </div>
</section>

<section class="dc-single-detail-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="dc-single-detail-panel">
            <?php woocommerce_output_product_data_tabs(); ?>
        </div>
    </div>
</section>

<section class="dc-single-related-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <?php woocommerce_output_related_products(); ?>
    </div>
</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>
