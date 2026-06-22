<?php get_header(); ?>

<div class="page-hero">
    <div class="container">
        <h1>Hasil Pencarian: "<?php echo esc_html(get_search_query()); ?>"</h1>
    </div>
</div>

<main id="main-content" class="page-content">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="blog-grid">
                <?php while (have_posts()): the_post(); ?>
                <article <?php post_class('blog-card'); ?>>
                    <div class="blog-body" style="padding:24px;">
                        <h2 class="blog-title" style="font-size:18px;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="blog-excerpt"><?php the_excerpt(); ?></p>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(['mid_size' => 2]); ?>
        <?php else: ?>
            <p style="text-align:center; color:var(--text-secondary); padding:60px 0; font-size:18px;">
                Tidak ada hasil untuk "<strong><?php echo esc_html(get_search_query()); ?></strong>"
            </p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
