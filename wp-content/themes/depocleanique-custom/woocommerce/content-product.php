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
$short_description = wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 18, '...' );
if ( ! $short_description ) {
    $short_description = wp_trim_words( wp_strip_all_tags( $product->get_description() ), 18, '...' );
}

$price_html        = $product->get_price_html();
$rating            = $product->get_average_rating();
if ( ! $rating ) {
    $rating = '4.8';
}

$badge = '';
if ( $product->is_featured() ) {
    $badge = 'BEST SELLER';
} elseif ( $product->is_on_sale() ) {
    $badge = 'PROMO';
}

$size = '25L Bulk Jerigen';
$size_attr = $product->get_attribute( 'size' );
if ( $size_attr ) {
    $size = $size_attr;
}
?>

<li <?php wc_product_class( '', $product ); ?>>
    <a href="<?php echo esc_url( $product_link ); ?>" class="bg-white p-3 md:p-6 dc-card-custom border border-outline-variant/30 hover:border-secondary transition-all group block h-full">
        <div class="aspect-square bg-surface-container-low dc-card-media-custom mb-3 md:mb-4 flex items-center justify-center relative overflow-hidden">
            <?php if ( has_post_thumbnail( $product_id ) ) : ?>
                <?php echo get_the_post_thumbnail( $product_id, 'medium', [ 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ] ); ?>
            <?php else : ?>
                <?php
                // Smart fallback icon selection based on title keywords
                $title_lower = strtolower( $product->get_name() );
                $icon = 'water_drop';
                if ( strpos( $title_lower, 'deterjen' ) !== false || strpos( $title_lower, 'cuci' ) !== false ) {
                    $icon = 'water_drop';
                } elseif ( strpos( $title_lower, 'piring' ) !== false || strpos( $title_lower, 'dishwash' ) !== false ) {
                    $icon = 'sanitizer';
                } elseif ( strpos( $title_lower, 'pewangi' ) !== false || strpos( $title_lower, 'parfum' ) !== false || strpos( $title_lower, 'softener' ) !== false ) {
                    $icon = 'eco';
                } elseif ( strpos( $title_lower, 'lantai' ) !== false || strpos( $title_lower, 'floor' ) !== false ) {
                    $icon = 'clean_hands';
                }
                ?>
                <span class="material-symbols-outlined text-5xl md:text-7xl text-secondary/30"><?php echo esc_html( $icon ); ?></span>
            <?php endif; ?>
            <?php if ( $badge ) : ?>
                <div class="absolute top-2 right-2 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full">
                    <?php echo esc_html( $badge ); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="space-y-1.5 md:space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-[11px] md:text-xs font-bold text-on-surface-variant">
                    <?php if ( ! empty( $price_html ) ) : ?>
                        <span class="text-secondary font-extrabold"><?php echo wp_kses_post( $price_html ); ?></span>
                    <?php else : ?>
                        <?php echo esc_html( $size ); ?>
                    <?php endif; ?>
                </span>
                <div class="flex items-center text-primary gap-1">
                    <?php echo dc_icon( 'star', 'dc-icon-sm dc-product-rating-star' ); ?>
                    <span class="text-[11px] md:text-xs font-bold"><?php echo esc_html( $rating ); ?></span>
                </div>
            </div>
            <h4 class="text-sm md:text-lg font-bold text-on-surface group-hover:text-secondary transition-colors line-clamp-1"><?php echo esc_html( $product->get_name() ); ?></h4>
            <p class="text-xs md:text-sm text-on-surface-variant line-clamp-2"><?php echo esc_html( $short_description ); ?></p>
        </div>
    </a>
</li>
