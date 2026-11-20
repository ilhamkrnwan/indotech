<?php
/**
 * Template Name: Industry Archive
 * Template Post Type: page, industry
 *
 * Arsitektur Manufy Daylight — Solusi Sektor Industri B2B.
 */

$media_cp       = get_theme_file_uri( 'assets/images/company-profile' );
$industry_query = new WP_Query( [
    'post_type'      => 'industry',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
] );

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="industries-hero" aria-labelledby="cs-industries-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Solusi Industri</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Pasokan bahan kimia kebersihan dan formula khusus yang dirancang untuk standar kebersihan industri komersial, perhotelan, serta fasilitas pelayanan publik.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>">
                            <span>Ajukan penawaran industri</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-industries-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Solusi</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Sektor Industri</span>
                            <span class="ch-h1-secondary">B2B Terukur</span>
                        </span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Daftar solusi industri">
            <div class="cs-editorial-grid">
                <?php
                if ( $industry_query->have_posts() ) :
                    $fallback_pool = [
                        $media_cp . '/cta-collab-b2b.webp',
                        $media_cp . '/ilustrasi-formulasi.webp',
                        $media_cp . '/cta-logistics-b2b.webp',
                    ];
                    $idx = 0;
                    while ( $industry_query->have_posts() ) :
                        $industry_query->the_post();
                        $ind_id  = get_the_ID();
                        $title   = get_the_title();
                        $tagline = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $ind_id, 'industry_tagline' ) : '';
                        $desc    = $tagline ? wp_trim_words( wp_strip_all_tags( $tagline ), 16, '...' ) : wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );

                        if ( has_post_thumbnail() ) {
                            $img_html = get_the_post_thumbnail( $ind_id, 'indotech-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] );
                        } else {
                            $t_low = strtolower( $title );
                            if ( strpos( $t_low, 'hotel' ) !== false || strpos( $t_low, 'resort' ) !== false || strpos( $t_low, 'hospitality' ) !== false ) {
                                $fallback_img = $media_cp . '/industry-hospitality.webp';
                            } elseif ( strpos( $t_low, 'laundry' ) !== false || strpos( $t_low, 'binatu' ) !== false ) {
                                $fallback_img = $media_cp . '/industry-laundry.webp';
                            } else {
                                $fallback_img = $fallback_pool[ $idx % count( $fallback_pool ) ];
                            }
                            $img_html = '<img src="' . esc_url( $fallback_img ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" decoding="async">';
                        }
                        $idx++;

                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $ind_id ),
                            'title'          => $title,
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => $title,
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h2',
                            'post_id'        => $ind_id,
                        ] );
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="cs-empty-panel">
                        <h2>Belum ada data solusi industri terdaftar</h2>
                        <p>Silakan hubungi tim teknis B2B Indotech untuk informasi suplai industri Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
