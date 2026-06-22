<?php get_header(); ?>

<div class="page-hero">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<main id="main-content" class="page-content">
    <div class="container">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
