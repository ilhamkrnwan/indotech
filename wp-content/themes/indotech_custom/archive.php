<?php
/**
 * Archive Template (Categories, Tags, Date Archives)
 *
 * Arsitektur Manufy Daylight dengan item editorial minimalis.
 */

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="archive-hero" aria-labelledby="cs-archive-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p><?php echo get_the_archive_description() ? esc_html( wp_strip_all_tags( get_the_archive_description() ) ) : 'Kumpulan artikel, panduan teknis formulasi, dan wawasan operasional kebersihan B2B Indotech.'; ?></p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                            <span>Lihat semua kategori blog</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-archive-title" class="ch-hero-h1">
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Arsip Blog</span>
                        </span>
                        <span class="ch-h1-primary"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Daftar artikel arsip">
            <?php if ( have_posts() ) : ?>
                <div class="cs-editorial-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        $p_id     = get_the_ID();
                        $img_html = has_post_thumbnail()
                            ? wp_get_attachment_image( get_post_thumbnail_id(), 'indotech-card', false, [
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'sizes'    => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 410px',
                            ] )
                            : '';
                        $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );
                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $p_id ),
                            'title'          => get_the_title( $p_id ),
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => 'Indotech Journal',
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h2',
                            'post_id'        => $p_id,
                        ] );
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&lsaquo; Sebelumnya',
                    'next_text' => 'Selanjutnya &rsaquo;',
                ] );
                ?>
            <?php else : ?>
                <div class="cs-empty-panel">
                    <h2>Belum ada artikel ditemukan</h2>
                    <p>Belum ada artikel yang dipublikasikan dalam kategori atau arsip ini.</p>
                    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="ch-pill-cta">
                        <span>Kembali ke Semua Artikel</span>
                        <span class="ch-pill-cta-icon" aria-hidden="true">
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
