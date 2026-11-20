<?php
/**
 * Template Name: Brand Archive
 * Template Post Type: page, brand
 *
 * Direktori Ekosistem Brand PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 */

$brands_static = [
    [
        'name'    => 'Cleanique Academy',
        'tagline' => 'Pelatihan formulasi kimia pembersih & pendampingan kewirausahaan.',
        'logo'    => get_template_directory_uri() . '/assets/images/cleaniqueacademy.webp',
    ],
    [
        'name'    => 'Cleanique Lab',
        'tagline' => 'Riset formulasi R&D dan layanan maklon private label berizin resmi.',
        'logo'    => get_template_directory_uri() . '/assets/images/cleaniquelab.webp',
    ],
    [
        'name'    => 'Cleanique Mart',
        'tagline' => 'Kemitraan toko perlengkapan kebersihan modern dan ritel terpadu.',
        'logo'    => get_template_directory_uri() . '/assets/images/cleaniquemart.webp',
    ],
    [
        'name'    => 'Depo Cleanique',
        'tagline' => 'Distribusi curah serta sistem depo isi ulang sabun ramah kemasan.',
        'logo'    => get_template_directory_uri() . '/assets/images/depocleanique.webp',
    ],
    [
        'name'    => 'Malabeez',
        'tagline' => 'Pewangi sajadah, mukena, linen, dan tekstil berstandar halal.',
        'logo'    => get_template_directory_uri() . '/assets/images/malabeez.webp',
    ],
    [
        'name'    => 'Orchid Care',
        'tagline' => 'Deterjen, pelembut, konsentrat, dan pewangi laundry komersial.',
        'logo'    => get_template_directory_uri() . '/assets/images/orchidcare.webp',
    ],
    [
        'name'    => 'Prokopi',
        'tagline' => 'Pembersih mesin espresso dan perangkat seduh kafe food-grade.',
        'logo'    => get_template_directory_uri() . '/assets/images/prokopi.webp',
    ],
];

$brand_query = new WP_Query( [
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="brands-hero" aria-labelledby="cs-brands-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Brand</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Setiap brand di bawah naungan PT Indotech Berkah Abadi menangani segmen produk kimia pembersih, jasa maklon, ritel, maupun pelatihan B2B.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/produk/' ) ); ?>">
                            <span>Lihat katalog semua SKU</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-brands-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Ekosistem</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Portofolio</span>
                            <span class="ch-h1-secondary">Brand Kami</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">PT Indotech<br>Berkah Abadi</p>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Daftar Brand Indotech">
            <div class="cs-editorial-grid">
                <?php
                if ( $brand_query->have_posts() ) :
                    while ( $brand_query->have_posts() ) :
                        $brand_query->the_post();
                        $b_id       = get_the_ID();
                        $post_title = get_the_title();
                        if ( strtolower( trim( $post_title ) ) === 'cokusi' ) {
                            continue;
                        }

                        $fallback_item = $brands_static[0];
                        foreach ( $brands_static as $st ) {
                            if ( strcasecmp( $st['name'], $post_title ) === 0 ) {
                                $fallback_item = $st;
                                break;
                            }
                        }

                        $tl      = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $b_id, 'brand_tagline' ) : '';
                        $excerpt = wp_strip_all_tags( get_the_excerpt() );
                        $desc    = $excerpt ? wp_trim_words( $excerpt, 16, '...' ) : ( $tl ?: $fallback_item['tagline'] );

                        $local_logo = function_exists( 'indotech_get_brand_logo_url' ) ? indotech_get_brand_logo_url( $post_title ) : '';
                        if ( has_post_thumbnail() ) {
                            $img_html = get_the_post_thumbnail( $b_id, 'large', [ 'loading' => 'lazy', 'decoding' => 'async' ] );
                        } elseif ( ! empty( $local_logo ) ) {
                            $img_html = '<img src="' . esc_url( $local_logo ) . '" alt="' . esc_attr( $post_title ) . ' logo" loading="lazy" decoding="async">';
                        } elseif ( ! empty( $fallback_item['logo'] ) ) {
                            $img_html = '<img src="' . esc_url( $fallback_item['logo'] ) . '" alt="' . esc_attr( $post_title ) . ' logo" loading="lazy" decoding="async">';
                        } else {
                            $img_html = '';
                        }

                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $b_id ),
                            'title'          => $post_title,
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => $post_title,
                            'media_variant'  => 'logo',
                            'heading_tag'    => 'h2',
                            'post_id'        => $b_id,
                        ] );
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="cs-empty-panel">
                        <h2>Belum ada data brand korporat terdaftar</h2>
                        <p>Direktori brand Indotech sedang dalam pembaruan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
