<?php
/**
 * Section: Product Catalog
 * Diport dari _landing-source.html (id="katalog").
 * Visual produk memakai thumbnail gambar riil dari WooCommerce, dengan fallback icon.
 * Menampilkan limit 8 produk.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$products_list = [];

if ( class_exists( 'WooCommerce' ) ) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    );
    $products_query = new WP_Query( $args );

    if ( $products_query->have_posts() ) {
        while ( $products_query->have_posts() ) {
            $products_query->the_post();
            $product_id = get_the_ID();
            $product_obj = wc_get_product( $product_id );

            if ( $product_obj ) {
                $title = get_the_title();
                $title_lower = strtolower( $title );

                // Smart fallback icon selection based on title keywords
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

                $badge = '';
                if ( $product_obj->is_featured() ) {
                    $badge = 'BEST SELLER';
                } elseif ( $product_obj->is_on_sale() ) {
                    $badge = 'PROMO';
                }

                $size = '25L Bulk Jerigen';
                $size_attr = $product_obj->get_attribute( 'size' );
                if ( $size_attr ) {
                    $size = $size_attr;
                }

                $rating = $product_obj->get_average_rating();
                if ( ! $rating ) {
                    $rating = '4.8';
                }

                $price_html = $product_obj->get_price_html();

                $products_list[] = [
                    'id'         => $product_id,
                    'permalink'  => get_permalink(),
                    'name'       => $title,
                    'desc'       => wp_strip_all_tags( get_post_field( 'post_content', $product_id ) ),
                    'icon'       => $icon,
                    'badge'      => $badge,
                    'size'       => $size,
                    'rating'     => $rating,
                    'price_html' => $price_html,
                    'has_thumb'  => has_post_thumbnail( $product_id ),
                ];
            }
        }
        wp_reset_postdata();
    }
}

// Fallback to static catalog data if WooCommerce is not active or has 0 products
if ( empty( $products_list ) ) {
    $fallback_products = [
        [ 'icon' => 'water_drop',  'size' => '25L Bulk Jerigen', 'rating' => '4.8', 'name' => 'Deterjen Cair Premium', 'desc' => 'Formula pembersih noda membandel dengan teknologi anti-redeposisi.', 'badge' => 'BEST SELLER' ],
        [ 'icon' => 'sanitizer',   'size' => '25L Bulk Jerigen', 'rating' => '4.7', 'name' => 'Sabun Cuci Piring',     'desc' => 'Extra Lime Power yang efektif mengangkat lemak membandel.',          'badge' => null ],
        [ 'icon' => 'eco',         'size' => '25L Bulk Jerigen', 'rating' => '4.9', 'name' => 'Pewangi Pakaian',       'desc' => 'Teknologi micro-capsule untuk keharuman hingga 14 hari.',            'badge' => null ],
        [ 'icon' => 'clean_hands', 'size' => '25L Bulk Jerigen', 'rating' => '4.6', 'name' => 'Pembersih Lantai',      'desc' => 'Membunuh 99.9% kuman dengan aroma menyegarkan.',                     'badge' => null ],
        [ 'icon' => 'water_drop',  'size' => '20L Bulk Jerigen', 'rating' => '4.8', 'name' => 'Softener Ultra Soft',   'desc' => 'Konsentrat pelembut pakaian mewah dengan keharuman tahan lama.',    'badge' => null ],
        [ 'icon' => 'clean_hands', 'size' => '20L Bulk Jerigen', 'rating' => '4.7', 'name' => 'Karbol Sereh Wangi',    'desc' => 'Formula alami pengusir serangga dan pembersih lantai menyeluruh.',   'badge' => 'BARU' ],
        [ 'icon' => 'sanitizer',   'size' => '25L Bulk Jerigen', 'rating' => '4.9', 'name' => 'Hand Soap Antiseptik',  'desc' => 'Sabun cuci tangan lembut di kulit dengan perlindungan antibakteri.', 'badge' => null ],
        [ 'icon' => 'eco',         'size' => '25L Bulk Jerigen', 'rating' => '4.6', 'name' => 'Pelicin Pakaian',       'desc' => 'Membantu menyetrika lebih cepat, rapi, dan harum seharian.',        'badge' => null ],
    ];

    foreach ( $fallback_products as $product ) {
        $products_list[] = [
            'id'         => 0,
            'permalink'  => home_url( '/katalog/' ),
            'name'       => $product['name'],
            'desc'       => $product['desc'],
            'icon'       => $product['icon'],
            'badge'      => $product['badge'],
            'size'       => $product['size'],
            'rating'     => $product['rating'],
            'price_html' => '',
            'has_thumb'  => false,
        ];
    }
}
?>

<section class="py-24 bg-surface-container-lowest" id="katalog">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="space-y-4">
                <h2 class="font-headline-lg text-headline-lg text-on-surface"><?php esc_html_e( 'Katalog Produk Unggulan', 'depocleanique-custom' ); ?></h2>
                <p class="text-on-surface-variant max-w-xl">
                    <?php esc_html_e( 'Produk homecare premium dengan formulasi ramah lingkungan dan konsumsi berulang yang tinggi.', 'depocleanique-custom' ); ?>
                </p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 border border-outline rounded-full hover:bg-secondary/5" aria-label="<?php esc_attr_e( 'Produk sebelumnya', 'depocleanique-custom' ); ?>">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="p-2 border border-outline rounded-full hover:bg-secondary/5" aria-label="<?php esc_attr_e( 'Produk berikutnya', 'depocleanique-custom' ); ?>">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
            <?php foreach ( $products_list as $product ) : ?>
            <a href="<?php echo esc_url( $product['permalink'] ); ?>" class="bg-white p-3 md:p-6 dc-card-custom border border-outline-variant/30 hover:border-secondary transition-all group block h-full">
                <div class="aspect-square bg-surface-container-low dc-card-media-custom mb-3 md:mb-4 flex items-center justify-center relative overflow-hidden">
                    <?php if ( $product['has_thumb'] ) : ?>
                        <?php echo get_the_post_thumbnail( $product['id'], 'medium', [ 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ] ); ?>
                    <?php else : ?>
                        <span class="material-symbols-outlined text-5xl md:text-7xl text-secondary/30"><?php echo esc_html( $product['icon'] ); ?></span>
                    <?php endif; ?>
                    <?php if ( $product['badge'] ) : ?>
                        <div class="absolute top-2 right-2 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full">
                            <?php echo esc_html( $product['badge'] ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="space-y-1.5 md:space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[11px] md:text-xs font-bold text-on-surface-variant">
                            <?php if ( ! empty( $product['price_html'] ) ) : ?>
                                <span class="text-secondary font-extrabold"><?php echo wp_kses_post( $product['price_html'] ); ?></span>
                            <?php else : ?>
                                <?php echo esc_html( $product['size'] ); ?>
                            <?php endif; ?>
                        </span>
                        <div class="flex items-center text-primary gap-1">
                            <?php echo dc_icon( 'star', 'dc-icon-sm dc-product-rating-star' ); ?>
                            <span class="text-[11px] md:text-xs font-bold"><?php echo esc_html( $product['rating'] ); ?></span>
                        </div>
                    </div>
                    <h4 class="text-sm md:text-lg font-bold text-on-surface group-hover:text-secondary transition-colors line-clamp-1"><?php echo esc_html( $product['name'] ); ?></h4>
                    <p class="text-xs md:text-sm text-on-surface-variant line-clamp-2"><?php echo esc_html( $product['desc'] ); ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
