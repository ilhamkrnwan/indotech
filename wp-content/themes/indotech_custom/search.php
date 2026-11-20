<?php
/**
 * Search Results Template — Arsitektur Manufy Daylight
 */

$search_query = get_search_query();

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="search-hero" aria-labelledby="cs-search-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Pencarian</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Cari produk kebersihan B2B, formulasi, atau artikel wawasan industri di PT Indotech Berkah Abadi.</p>
                    <form role="search" method="get" class="cs-search-hero-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label class="ch-sr-only" for="cs-site-search-input">Cari di Indotech</label>
                        <input id="cs-site-search-input" type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari kata kunci produk atau artikel...">
                        <button type="submit" class="ch-pill-cta">
                            <span>Cari</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-search-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Hasil Cari</span>
                        </span>
                        <span class="ch-h1-primary"><?php echo $search_query ? esc_html( '"' . $search_query . '"' ) : 'Semua Pencarian'; ?></span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Hasil pencarian">
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

                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&lsaquo; Sebelumnya',
                    'next_text' => 'Selanjutnya &rsaquo;',
                ] );
                ?>
            <?php else : ?>
                <div class="cs-empty-panel">
                    <h2>Tidak ada hasil ditemukan</h2>
                    <p>Tidak ditemukan halaman, produk, atau artikel yang cocok dengan kata kunci "<?php echo esc_html( $search_query ); ?>".</p>
                    <a href="<?php echo esc_url( home_url( '/produk/' ) ); ?>" class="ch-pill-cta">
                        <span>Jelajahi Katalog Produk</span>
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
