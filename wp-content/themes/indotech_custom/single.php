<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
<div class="page-hero">
    <div class="container">
        <div class="post-meta-top">
            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d M Y'); ?></time>
            <span>·</span>
            <span><?php the_author(); ?></span>
        </div>
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<main id="main-content" class="page-content">
    <div class="container" style="max-width:760px;">
        <?php if (has_post_thumbnail()): ?>
            <figure class="post-featured-img" style="margin-bottom:40px;border-radius:12px;overflow:hidden;">
                <?php the_post_thumbnail('indotech-card', ['style' => 'width:100%;height:auto;']); ?>
            </figure>
        <?php endif; ?>
        <div class="post-body">
            <?php the_content(); ?>
        </div>
    </div>
</main>
<?php endwhile; ?>

<?php get_footer(); ?>
