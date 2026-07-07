<?php get_header(); ?>

<style>
.post-body ol,
.post-body ul {
    padding-left: 24px;
    margin-top: 10px;
    margin-bottom: 20px;
}
.post-body ol {
    list-style-type: decimal;
}
.post-body ul {
    list-style-type: disc;
}
.post-body li {
    margin-bottom: 8px;
}
</style>

<?php while (have_posts()): the_post(); ?>
<section class="inner-page-hero" id="single-post-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="<?php echo esc_url( home_url('/blog') ); ?>">Blog</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?php the_title(); ?></span>
        </nav>
        <div class="blog-meta" style="color:rgba(255,255,255,.7); margin-bottom:12px; display:flex; align-items:center; gap:8px; font-size:12px;">
            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
            <span class="blog-meta-sep" aria-hidden="true">·</span>
            <span><?php the_author(); ?></span>
        </div>
        <h1 class="inner-page-title" style="font-size: clamp(24px, 3.5vw, 44px); line-height: 1.25;"><?php the_title(); ?></h1>
    </div>
</section>

<main id="main-content" class="page-content" style="padding: 60px 0;">
    <div class="container" style="max-width:760px; padding: 0 16px;">
        <?php if (has_post_thumbnail()): ?>
            <figure class="post-featured-img" style="margin-bottom:40px;border-radius:12px;overflow:hidden;">
                <?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto;object-fit:cover;']); ?>
            </figure>
        <?php endif; ?>
        <div class="post-body" style="color: var(--text-secondary); line-height: 1.8; font-size: 15px;">
            <?php the_content(); ?>
        </div>
    </div>
</main>

<?php
// Related Blog Query
$categories = get_the_category();
$cat_ids = [];
if ($categories) {
    foreach ($categories as $cat) {
        $cat_ids[] = $cat->term_id;
    }
}

$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'post_status'    => 'publish',
    'category__in'   => !empty($cat_ids) ? $cat_ids : [],
    'orderby'        => 'rand'
];

$related_query = new WP_Query($related_args);
// Fallback if not enough related posts in same categories
if ($related_query->post_count < 3) {
    $exclude = array_merge([get_the_ID()], wp_list_pluck($related_query->posts, 'ID'));
    $fallback_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3 - $related_query->post_count,
        'post__not_in'   => $exclude,
        'post_status'    => 'publish'
    ]);
    $related_posts = array_merge($related_query->posts, $fallback_query->posts);
} else {
    $related_posts = $related_query->posts;
}
?>

<?php if (!empty($related_posts)) : ?>
    <section style="background: var(--surface); padding: 60px 0; border-top: 1px solid var(--border); margin-top: 60px;">
        <div class="container" style="max-width: 1000px; padding: 0 16px;">
            <h2 style="font-size: 20px; margin-bottom: 28px; letter-spacing: -0.02em; font-weight: 700; color: var(--ink);">Artikel Terkait</h2>
            
            <div class="blog-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                <?php 
                foreach ($related_posts as $rp) : 
                    $rp_thumb = get_the_post_thumbnail_url($rp->ID, 'medium_large');
                    $rp_cats  = get_the_category($rp->ID);
                    $rp_cat   = $rp_cats ? esc_html($rp_cats[0]->name) : '';
                ?>
                    <article class="blog-card" style="border: 1px solid var(--border); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; background: var(--white); transition: transform var(--trans), box-shadow var(--trans);">
                        <a href="<?php echo get_permalink($rp->ID); ?>" class="blog-thumb" style="aspect-ratio: 16/10; position: relative; display: block; overflow: hidden;">
                            <?php if ($rp_thumb) : ?>
                                <img src="<?php echo esc_url($rp_thumb); ?>" alt="<?php echo esc_attr($rp->post_title); ?>" class="blog-img" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else : ?>
                                <div class="blog-img-placeholder" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--surface-2);"><span class="blog-placeholder-label">Indotech</span></div>
                            <?php endif; ?>
                            <?php if ($rp_cat) : ?>
                                <span class="blog-category" style="position: absolute; top: 12px; left: 12px; background: var(--cobalt); color: var(--white); font-size: 10px; font-weight: 700; padding: 4px 11px; border-radius: 99px; text-transform: uppercase;"><?php echo $rp_cat; ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="blog-body" style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                            <div class="blog-meta" style="font-size: 11.5px; color: var(--text-muted); margin-bottom: 8px;">
                                <time datetime="<?php echo get_the_date('Y-m-d', $rp->ID); ?>"><?php echo get_the_date('d M Y', $rp->ID); ?></time>
                            </div>
                            <h3 class="blog-title" style="font-size: 16px; font-weight: 700; margin-bottom: 12px; line-height: 1.3;"><a href="<?php echo get_permalink($rp->ID); ?>"><?php echo esc_html($rp->post_title); ?></a></h3>
                            <a href="<?php echo get_permalink($rp->ID); ?>" class="blog-read-more" style="font-size: 12px; font-weight: 700; color: var(--cobalt); margin-top: auto;">Baca Selengkapnya &rarr;</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
