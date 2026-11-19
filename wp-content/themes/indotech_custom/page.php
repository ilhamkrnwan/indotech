<?php get_header(); ?>

<main id="main-content">
    <section class="inner-page-hero inner-page-hero--sm" id="page-hero">
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>
            <h1 class="inner-page-title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="legal-section section-padding">
        <div class="container">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'ch-page-article post-body' ); ?>>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
