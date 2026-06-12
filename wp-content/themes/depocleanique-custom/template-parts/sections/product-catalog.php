<?php
/**
 * Section: Product Catalog
 * Diport dari _landing-source.html (id="katalog").
 * Visual produk memakai icon Material Symbols (sesuai sumber) — tidak ada gambar raster,
 * sehingga tidak ada asset gambar yang perlu dipindahkan untuk section ini.
 *
 * TODO: Convert product catalog to editable fields in a later phase.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Data produk — hardcode sementara (lihat TODO di atas).
$products = [
    [ 'icon' => 'water_drop',  'size' => '25L Bulk Jerigen', 'rating' => '4.8', 'name' => 'Deterjen Cair Premium', 'desc' => 'Formula pembersih noda membandel dengan teknologi anti-redeposisi.', 'badge' => 'BEST SELLER' ],
    [ 'icon' => 'sanitizer',   'size' => '25L Bulk Jerigen', 'rating' => '4.7', 'name' => 'Sabun Cuci Piring',     'desc' => 'Extra Lime Power yang efektif mengangkat lemak membandel.',          'badge' => null ],
    [ 'icon' => 'eco',         'size' => '25L Bulk Jerigen', 'rating' => '4.9', 'name' => 'Pewangi Pakaian',       'desc' => 'Teknologi micro-capsule untuk keharuman hingga 14 hari.',            'badge' => null ],
    [ 'icon' => 'clean_hands', 'size' => '25L Bulk Jerigen', 'rating' => '4.6', 'name' => 'Pembersih Lantai',      'desc' => 'Membunuh 99.9% kuman dengan aroma menyegarkan.',                     'badge' => null ],
];
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
            <?php foreach ( $products as $product ) : ?>
            <div class="bg-white p-6 rounded-xl border border-outline-variant/30 hover:border-secondary transition-all group">
                <div class="aspect-square bg-surface-container-low rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <span class="material-symbols-outlined text-7xl text-secondary/30"><?php echo esc_html( $product['icon'] ); ?></span>
                    <?php if ( $product['badge'] ) : ?>
                        <div class="absolute top-2 right-2 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full">
                            <?php echo esc_html( $product['badge'] ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-on-surface-variant"><?php echo esc_html( $product['size'] ); ?></span>
                        <div class="flex items-center text-primary gap-1">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="text-xs font-bold"><?php echo esc_html( $product['rating'] ); ?></span>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold"><?php echo esc_html( $product['name'] ); ?></h4>
                    <p class="text-sm text-on-surface-variant line-clamp-2"><?php echo esc_html( $product['desc'] ); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
