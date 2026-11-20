<?php get_header(); ?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="page-hero" aria-labelledby="cs-page-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>

            <div class="cs-hero-head cs-hero-head--legal">
                <div class="cs-hero-copy">
                    <p>Informasi resmi dari PT Indotech Berkah Abadi untuk mendukung kemitraan bisnis, pengadaan B2B, dan layanan pelanggan.</p>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-page-title" class="cs-hero-h1">
                        <span class="cs-h1-row">
                            <span class="ch-tilt-badge">PT Indotech</span>
                        </span>
                        <span class="cs-h1-block"><?php the_title(); ?></span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band ch-wrap">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-body cs-page-article' ); ?>>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
