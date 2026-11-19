<?php
/**
 * Ekosistem 7 Brand Portofolio PT Indotech Berkah Abadi.
 */

$portfolio = [
    'orchid-care'       => [ 'Orchid Care', 'Pembersih, deterjen, konsentrat & pewangi laundry', 'Produk & Laundry', 'https://orchidbrand.id/' ],
    'cleanique-lab'     => [ 'Cleanique Lab', 'Produksi & maklon produk kebersihan berizin resmi', 'Maklon & R&D', 'https://cleaniquelab.com/' ],
    'cleanique-mart'    => [ 'Cleanique Mart', 'Kemitraan toko kebersihan modern & ritel terpadu', 'Kemitraan Toko', 'https://cleaniquemart.com/' ],
    'depo-cleanique'    => [ 'Depo Cleanique', 'Distribusi curah & sistem depo isi ulang sabun', 'Depo Isi Ulang', 'https://depocleanique.co.id/' ],
    'cleanique-academy' => [ 'Cleanique Academy', 'Pelatihan formulasi kimia pembersih & kewirausahaan', 'Pelatihan', 'https://cleaniqueacademy.com/' ],
    'malabeez'          => [ 'Malabeez', 'Pewangi sajadah, mukena, linen & tekstil', 'Pewangi Tekstil', 'https://malabeez.co.id/' ],
    'prokopi'           => [ 'Prokopi', 'Pembersih mesin kopi profesional berstandar food-grade', 'Horeca & Kopi', home_url( '/produk/' ) ],
];

$published_brands = [];
if ( post_type_exists( 'brand' ) ) {
    foreach ( get_posts( [
        'post_type'      => 'brand',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
    ] ) as $brand ) {
        if ( strtolower( trim( $brand->post_title ) ) === 'cokusi' ) {
            continue;
        }
        $published_brands[ $brand->post_name ] = $brand;
        if ( ! isset( $portfolio[ $brand->post_name ] ) ) {
            $portfolio[ $brand->post_name ] = [
                get_the_title( $brand ),
                wp_trim_words( get_the_excerpt( $brand ), 12 ),
                'Portofolio',
                get_permalink( $brand ),
            ];
        }
    }
}
?>

<section class="ch-brands ch-wrap" id="ekosistem-brand" aria-labelledby="ch-brands-title">
    <header class="ch-section-head">
        <h2 id="ch-brands-title" class="ch-section-h2">Ekosistem <span>7 Brand</span></h2>
        <p class="ch-section-sub">Setiap brand menangani segmen produk, jasa maklon, kemitraan ritel, atau pelatihan di bawah naungan PT Indotech Berkah Abadi.</p>
    </header>

    <ul class="ch-brand-grid">
        <?php foreach ( $portfolio as $slug => [ $name, $description, $role_tag, $fallback_url ] ) :
            $brand = $published_brands[ $slug ] ?? null;
            $url   = $brand ? get_permalink( $brand ) : $fallback_url;
            $logo  = function_exists( 'indotech_get_brand_logo_url' ) ? indotech_get_brand_logo_url( $name ) : '';
            ?>
            <li>
                <a class="ch-brand-row" href="<?php echo esc_url( $url ); ?>">
                    <div class="ch-brand-logo-box">
                        <?php if ( $logo ) : ?>
                            <img class="ch-brand-logo" src="<?php echo esc_url( $logo ); ?>" alt="" width="88" height="44" loading="lazy" decoding="async">
                        <?php elseif ( $brand && has_post_thumbnail( $brand ) ) : ?>
                            <?php echo get_the_post_thumbnail( $brand, 'medium', [ 'class' => 'ch-brand-logo', 'alt' => '', 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <span class="ch-brand-initial"><?php echo esc_html( substr( $name, 0, 2 ) ); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="ch-brand-info">
                        <div class="ch-brand-meta">
                            <h3><?php echo esc_html( $name ); ?></h3>
                            <span class="ch-brand-tag"><?php echo esc_html( $role_tag ); ?></span>
                        </div>
                        <?php if ( $description ) : ?>
                            <p><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    </div>

                    <span class="ch-brand-arrow" aria-hidden="true">
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
