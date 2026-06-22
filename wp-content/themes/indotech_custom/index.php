<?php get_header(); ?>

<main id="main-content" class="page-content">
    <div class="container">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </article>
        <?php endwhile; else: ?>
            <p><?php esc_html_e('Tidak ada konten ditemukan.', 'indotech'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
