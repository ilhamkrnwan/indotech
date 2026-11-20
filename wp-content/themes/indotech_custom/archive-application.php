<?php
/**
 * Template Name: Application Archive
 * Template Post Type: page, application
 *
 * Arsitektur Manufy Daylight — Aplikasi Sektor Layanan B2B.
 */

$media_cp  = get_theme_file_uri( 'assets/images/company-profile' );
$app_query = new WP_Query( [
    'post_type'      => 'application',
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

        <section class="cs-hero cs-hero--compact ch-wrap" id="applications-hero" aria-labelledby="cs-apps-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Aplikasi Layanan</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>PT Indotech Berkah Abadi menghadirkan formula kimia pembersih terstandar dan solusi maklon yang disesuaikan bagi kebutuhan operasional bisnis Anda.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>">
                            <span>Konsultasikan kebutuhan bisnis</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-apps-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Solusi</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Sektor B2B</span>
                            <span class="ch-h1-secondary">Aplikasi Layanan</span>
                        </span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Daftar aplikasi layanan">
            <div class="cs-editorial-grid">
                <?php
                if ( $app_query->have_posts() ) :
                    while ( $app_query->have_posts() ) :
                        $app_query->the_post();
                        $app_id      = get_the_ID();
                        $title       = get_the_title();
                        $title_lower = strtolower( $title );
                        $tagline     = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $app_id, 'app_tagline' ) : '';
                        $desc        = $tagline ? wp_trim_words( wp_strip_all_tags( $tagline ), 16, '...' ) : wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );

                        if ( has_post_thumbnail() ) {
                            $img_html = get_the_post_thumbnail( $app_id, 'indotech-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] );
                        } else {
                            $fallback_img = $media_cp . '/ilustrasi-formulasi.webp';
                            if ( strpos( $title_lower, 'laundry' ) !== false ) {
                                $fallback_img = $media_cp . '/hero-manufy-stage.webp';
                            } elseif ( strpos( $title_lower, 'detail' ) !== false || strpos( $title_lower, 'car' ) !== false || strpos( $title_lower, 'auto' ) !== false ) {
                                $fallback_img = $media_cp . '/cta-logistics-b2b.webp';
                            }
                            $img_html = '<img src="' . esc_url( $fallback_img ) . '" width="1376" height="768" alt="' . esc_attr( $title ) . '" loading="lazy" decoding="async">';
                        }

                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $app_id ),
                            'title'          => $title,
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => $title,
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h2',
                            'post_id'        => $app_id,
                        ] );
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="cs-empty-panel">
                        <h2>Belum ada data aplikasi layanan terdaftar</h2>
                        <p>Hubungi tim B2B Indotech untuk informasi penerapan formulasi khusus sektor Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
