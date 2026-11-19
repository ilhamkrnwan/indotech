<?php
/** Business lines in the Indotech brand portfolio. */
$portfolio = [
    'orchid-care'       => [ 'Orchid Care', 'Pembersih dan pewangi laundry', 'https://orchidbrand.id/' ],
    'cleanique-lab'     => [ 'Cleanique Lab', 'Produksi dan maklon produk kebersihan', 'https://cleaniquelab.com/' ],
    'cleanique-academy' => [ 'Cleanique Academy', 'Pelatihan formulasi dan kewirausahaan', 'https://cleaniqueacademy.com/' ],
    'cleanique-mart'    => [ 'Cleanique Mart', 'Toko dan distribusi produk kebersihan', 'https://cleaniquemart.com/' ],
    'depo-cleanique'    => [ 'Depo Cleanique', 'Kemitraan depo produk isi ulang', 'https://depocleanique.co.id/' ],
    'malabeez'          => [ 'Malabeez', 'Pewangi sajadah dan tekstil', 'https://malabeez.co.id/' ],
    'prokopi'           => [ 'Prokopi', 'Pembersih mesin kopi profesional', home_url( '/produk/' ) ],
];

// Use the published WordPress profiles when they are available.
$published_brands = [];
if ( post_type_exists( 'brand' ) ) {
    foreach ( get_posts( [
        'post_type'      => 'brand',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'       => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
    ] ) as $brand ) {
        if ( strtolower( trim( $brand->post_title ) ) === 'cokusi' ) {
            continue;
        }
        $published_brands[ $brand->post_name ] = $brand;
        if ( ! isset( $portfolio[ $brand->post_name ] ) ) {
            $portfolio[ $brand->post_name ] = [
                get_the_title( $brand ),
                wp_trim_words( get_the_excerpt( $brand ), 12 ),
                get_permalink( $brand ),
            ];
        }
    }
}
?>

<section class="company-brands company-wrap" id="ekosistem-brand" aria-labelledby="company-brands-title">
    <header class="company-section-heading">
        <h2 id="company-brands-title">Ekosistem brand.</h2>
        <p>Kenali brand yang menangani kebutuhan produk, distribusi, dan pengembangan usaha.</p>
    </header>
    <ul class="company-brand-list">
        <?php foreach ( $portfolio as $slug => [ $name, $description, $fallback_url ] ) :
            $brand = $published_brands[ $slug ] ?? null;
            $url = $brand ? get_permalink( $brand ) : $fallback_url;
            $logo = indotech_get_brand_logo_url( $name );
            ?>
            <li>
                <a class="company-brand" href="<?php echo esc_url( $url ); ?>">
                    <?php if ( $logo ) : ?>
                        <img class="company-brand-logo" src="<?php echo esc_url( $logo ); ?>" alt="" width="90" height="48" loading="lazy" decoding="async">
                    <?php elseif ( $brand && has_post_thumbnail( $brand ) ) : ?>
                        <?php echo get_the_post_thumbnail( $brand, 'medium', [ 'class' => 'company-brand-logo', 'alt' => '', 'loading' => 'lazy' ] ); ?>
                    <?php endif; ?>
                    <div class="company-brand-name">
                        <h3><?php echo esc_html( $name ); ?></h3>
                        <?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
                    </div>
                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
