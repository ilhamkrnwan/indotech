<?php
/**
 * Default Index / Fallback Archive — Arsitektur Manufy Daylight
 */

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" aria-labelledby="cs-index-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Direktori Konten</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Eksplorasi informasi terbaru, layanan manufaktur, dan katalog produk PT Indotech Berkah Abadi.</p>
                </div>
                <div class="cs-hero-title-group">
                    <h1 id="cs-index-title" class="ch-hero-h1">
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Indotech</span>
                            <span class="ch-h1-secondary">Direktori</span>
                        </span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap">
            <?php if ( have_posts() ) : ?>
                <div class="cs-editorial-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        $p_id     = get_the_ID();
                        $img_html = has_post_thumbnail()
                            ? get_the_post_thumbnail( $p_id, 'indotech-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] )
                            : '';
                        $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );
                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $p_id ),
                            'title'          => get_the_title( $p_id ),
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => 'Indotech',
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h2',
                            'post_id'        => $p_id,
                        ] );
                    endwhile;
                    ?>
                </div>
                <?php the_posts_pagination( [ 'mid_size' => 2 ] ); ?>
            <?php else : ?>
                <div class="cs-empty-panel">
                    <h2>Tidak ada konten ditemukan</h2>
                    <p><?php esc_html_e( 'Belum ada konten yang dipublikasikan pada bagian ini.', 'indotech' ); ?></p>
                </div>
            <?php endif; ?>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
