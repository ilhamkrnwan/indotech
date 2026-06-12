<?php
/**
 * Custom product card for WooCommerce loops.
 *
 * @package Depocleanique_Custom
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id        = $product->get_id();
$product_link      = get_permalink( $product_id );
$category_list     = wc_get_product_category_list( $product_id, ', ' );
$short_description = wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 18, '...' );
$price_html        = $product->get_price_html();
$availability      = $product->get_availability();
$stock_label       = ! empty( $availability['availability'] )
    ? $availability['availability']
    : ( $product->is_in_stock() ? __( 'Tersedia', 'depocleanique-custom' ) : __( 'Stok habis', 'depocleanique-custom' ) );
$stock_class       = $product->is_in_stock() ? 'is-in-stock' : 'is-out-of-stock';
?>

<li <?php wc_product_class( 'dc-product-card', $product ); ?>>
    <a class="dc-product-card-media" href="<?php echo esc_url( $product_link ); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
        <?php if ( $product->is_on_sale() ) : ?>
            <span class="dc-product-sale-badge"><?php esc_html_e( 'Promo', 'depocleanique-custom' ); ?></span>
        <?php endif; ?>

        <?php
        echo $product->get_image(
            'woocommerce_thumbnail',
            [
                'class'   => 'dc-product-card-image',
                'loading' => 'lazy',
            ]
        );
        ?>
    </a>

    <div class="dc-product-card-body">
        <?php if ( $category_list ) : ?>
            <div class="dc-product-card-category">
                <?php echo wp_kses_post( $category_list ); ?>
            </div>
        <?php endif; ?>

        <h2 class="woocommerce-loop-product__title dc-product-card-title">
            <a href="<?php echo esc_url( $product_link ); ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
        </h2>

        <?php if ( $short_description ) : ?>
            <p class="dc-product-card-description">
                <?php echo esc_html( $short_description ); ?>
            </p>
        <?php endif; ?>

        <div class="dc-product-card-meta">
            <div class="dc-product-card-price<?php echo $price_html ? '' : ' is-empty-price'; ?>">
                <?php
                if ( $price_html ) {
                    echo wp_kses_post( $price_html );
                } else {
                    esc_html_e( 'Hubungi kami untuk harga', 'depocleanique-custom' );
                }
                ?>
            </div>

            <span class="dc-product-stock <?php echo esc_attr( $stock_class ); ?>">
                <?php echo esc_html( $stock_label ); ?>
            </span>
        </div>

        <a class="dc-product-card-link" href="<?php echo esc_url( $product_link ); ?>">
            <span><?php esc_html_e( 'Lihat Detail', 'depocleanique-custom' ); ?></span>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
        </a>
    </div>
</li>
