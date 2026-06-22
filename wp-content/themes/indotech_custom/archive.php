<?php get_header(); ?>

<div class="page-hero">
    <div class="container">
        <h1><?php the_archive_title(); ?></h1>
        <?php the_archive_description('<p>', '</p>'); ?>
    </div>
</div>

<main id="main-content" class="page-content">
    <div class="container">
        <div class="blog-grid">
            <?php while (have_posts()): the_post(); ?>
            <article <?php post_class('blog-card'); ?>>
                <a href="<?php the_permalink(); ?>" class="blog-thumb">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('indotech-card', ['class' => 'blog-img']); ?>
                    <?php else: ?>
                        <div class="blog-img-placeholder">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="blog-body">
                    <div class="blog-meta">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d M Y'); ?></time>
                    </div>
                    <h2 class="blog-title" style="font-size:18px;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="blog-excerpt"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="blog-read-more">
                        Baca Selengkapnya
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div style="margin-top:48px; text-align:center;">
            <?php the_posts_pagination(['mid_size' => 2]); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
