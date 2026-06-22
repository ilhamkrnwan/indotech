<?php
/**
 * Template Name: Blog
 *
 * Halaman arsip Blog PT Indotech Berkah Abadi.
 * Sections: Hero · Featured Post · Filter Tab Kategori · Grid Artikel · Pagination
 */

$paged    = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$per_page = 6;

// Ambil semua kategori yang digunakan di posts
$categories = get_categories( [
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
] );

// Aktif kategori dari query string
$active_cat = isset( $_GET['kategori'] ) ? sanitize_text_field( $_GET['kategori'] ) : '';

// Query args
$blog_args = [
    'post_type'      => 'post',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
];
if ( $active_cat ) {
    $blog_args['category_name'] = $active_cat;
}

// Featured post — sticky atau post terbaru
$featured_args = [
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'post__in'       => get_option( 'sticky_posts' ) ?: [],
];
if ( empty( get_option( 'sticky_posts' ) ) ) {
    $featured_args = [
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ];
}
$featured_query = new WP_Query( $featured_args );
$featured_id    = 0;
if ( $featured_query->have_posts() ) {
    $featured_query->the_post();
    $featured_id = get_the_ID();
    wp_reset_postdata();
}

// Exclude featured dari grid
if ( $featured_id && $paged === 1 && ! $active_cat ) {
    $blog_args['post__not_in'] = [ $featured_id ];
}

$blog_query = new WP_Query( $blog_args );

get_header();
?>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         PAGE HERO
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero" id="blog-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.35;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Blog</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Insight & Update</span>
            <h1 class="inner-page-title">Blog <em>Indotech</em></h1>
            <p class="inner-page-subtitle">Tips bisnis, update produk, edukasi industri B2B, dan berita terbaru dari PT Indotech Berkah Abadi.</p>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         FEATURED POST
    ════════════════════════════════════════════════════════ -->
    <?php if ( $featured_id && ! $active_cat ) :
        $feat_thumb   = get_the_post_thumbnail_url( $featured_id, 'large' );
        $feat_cats    = get_the_category( $featured_id );
        $feat_cat_lbl = $feat_cats ? esc_html( $feat_cats[0]->name ) : 'Artikel';
        $feat_date    = get_the_date( 'd M Y', $featured_id );
        $feat_author  = get_the_author_meta( 'display_name', get_post_field( 'post_author', $featured_id ) );
        $feat_excerpt = get_the_excerpt( $featured_id );
        $feat_url     = get_permalink( $featured_id );
        $feat_title   = get_the_title( $featured_id );
    ?>
    <section class="blog-featured-section section-padding" id="blog-featured" style="background:var(--surface);">
        <div class="container">
            <div class="blog-section-header" style="margin-bottom:40px;">
                <div class="blog-section-left">
                    <span class="section-tag section-tag--dark">Artikel Pilihan</span>
                </div>
            </div>

            <article class="blog-featured-card reveal">
                <a href="<?php echo esc_url( $feat_url ); ?>" class="blog-featured-thumb" aria-hidden="true" tabindex="-1">
                    <?php if ( $feat_thumb ) : ?>
                        <img src="<?php echo esc_url( $feat_thumb ); ?>" alt="<?php echo esc_attr( $feat_title ); ?>" class="blog-featured-img" loading="lazy">
                    <?php else : ?>
                        <div class="blog-img-placeholder">
                            <span class="blog-placeholder-label">Indotech Blog</span>
                        </div>
                    <?php endif; ?>
                    <span class="blog-category"><?php echo $feat_cat_lbl; ?></span>
                </a>

                <div class="blog-featured-body">
                    <div class="blog-meta">
                        <span><?php echo esc_html( $feat_date ); ?></span>
                        <span class="blog-meta-sep" aria-hidden="true">·</span>
                        <span><?php echo esc_html( $feat_author ); ?></span>
                    </div>
                    <h2 class="blog-featured-title">
                        <a href="<?php echo esc_url( $feat_url ); ?>"><?php echo esc_html( $feat_title ); ?></a>
                    </h2>
                    <p class="blog-featured-excerpt"><?php echo esc_html( wp_trim_words( $feat_excerpt, 30, '...' ) ); ?></p>
                    <a href="<?php echo esc_url( $feat_url ); ?>" class="btn btn-primary">
                        Baca Artikel
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════════════════════════════════════════════════
         FILTER KATEGORI + GRID ARTIKEL
    ════════════════════════════════════════════════════════ -->
    <section class="blog-section section-padding" id="blog-grid">
        <div class="container">

            <div class="blog-section-header">
                <div class="blog-section-left">
                    <span class="section-tag section-tag--dark">Semua Artikel</span>
                    <h2 class="section-title" style="margin-top:12px;">
                        <?php echo $active_cat
                            ? 'Kategori: <em>' . esc_html( $active_cat ) . '</em>'
                            : 'Artikel Terbaru'; ?>
                    </h2>
                </div>
            </div>

            <!-- Filter Kategori -->
            <?php if ( $categories ) : ?>
            <div class="blog-filter-tabs" role="tablist" aria-label="Filter kategori blog">
                <a
                    href="<?php echo esc_url( home_url('/blog') ); ?>"
                    class="filter-btn btn <?php echo ! $active_cat ? 'active btn-primary' : 'btn-outline'; ?>"
                    role="tab"
                    aria-selected="<?php echo ! $active_cat ? 'true' : 'false'; ?>"
                    id="tab-semua"
                >
                    Semua
                </a>
                <?php foreach ( $categories as $cat ) : ?>
                <a
                    href="<?php echo esc_url( add_query_arg( 'kategori', $cat->slug, home_url('/blog') ) ); ?>"
                    class="filter-btn btn <?php echo $active_cat === $cat->slug ? 'active btn-primary' : 'btn-outline'; ?>"
                    role="tab"
                    aria-selected="<?php echo $active_cat === $cat->slug ? 'true' : 'false'; ?>"
                    id="tab-<?php echo esc_attr( $cat->slug ); ?>"
                >
                    <?php echo esc_html( $cat->name ); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Grid Artikel -->
            <?php if ( $blog_query->have_posts() ) : ?>
            <div class="blog-grid" style="margin-top:40px;" role="list">
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    $thumb     = get_the_post_thumbnail_url( null, 'medium_large' );
                    $post_cats = get_the_category();
                    $cat_lbl   = $post_cats ? esc_html( $post_cats[0]->name ) : '';
                ?>
                <article class="blog-card reveal" role="listitem" id="post-<?php the_ID(); ?>">
                    <a href="<?php the_permalink(); ?>" class="blog-thumb" aria-label="Baca: <?php the_title_attribute(); ?>">
                        <?php if ( $thumb ) : ?>
                            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="blog-img" loading="lazy">
                        <?php else : ?>
                            <div class="blog-img-placeholder"><span class="blog-placeholder-label">Indotech</span></div>
                        <?php endif; ?>
                        <?php if ( $cat_lbl ) : ?>
                            <span class="blog-category"><?php echo $cat_lbl; ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="blog-body">
                        <div class="blog-meta">
                            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
                            <span class="blog-meta-sep" aria-hidden="true">·</span>
                            <span><?php the_author(); ?></span>
                        </div>
                        <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="blog-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '...' ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="blog-read-more" aria-label="Baca selengkapnya: <?php the_title_attribute(); ?>">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <!-- Pagination -->
            <?php if ( $blog_query->max_num_pages > 1 ) :
                $base_url = $active_cat
                    ? add_query_arg( 'kategori', $active_cat, home_url('/blog') )
                    : home_url('/blog');
            ?>
            <nav class="blog-pagination" aria-label="Navigasi halaman blog">
                <?php if ( $paged > 1 ) : ?>
                <a href="<?php echo esc_url( add_query_arg( 'paged', $paged - 1, $base_url ) ); ?>"
                   class="btn btn-outline"
                   aria-label="Halaman sebelumnya">
                    ← Sebelumnya
                </a>
                <?php endif; ?>

                <span class="blog-pagination-info">
                    Halaman <?php echo $paged; ?> dari <?php echo $blog_query->max_num_pages; ?>
                </span>

                <?php if ( $paged < $blog_query->max_num_pages ) : ?>
                <a href="<?php echo esc_url( add_query_arg( 'paged', $paged + 1, $base_url ) ); ?>"
                   class="btn btn-outline"
                   aria-label="Halaman berikutnya">
                    Berikutnya →
                </a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>

            <?php else : ?>
            <!-- Empty State -->
            <div class="blog-empty reveal" style="text-align:center;padding:80px 0;">
                <div class="blog-empty-icon" aria-hidden="true">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:var(--border-dark);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <h3 style="font-size:20px;margin:20px 0 8px;">Belum ada artikel</h3>
                <p style="color:var(--text-secondary);margin-bottom:28px;">
                    <?php echo $active_cat
                        ? 'Belum ada artikel di kategori ini. Coba kategori lain.'
                        : 'Belum ada artikel yang diterbitkan.'; ?>
                </p>
                <a href="<?php echo esc_url( home_url('/blog') ); ?>" class="btn btn-outline">Lihat Semua Artikel</a>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         CTA BANNER
    ════════════════════════════════════════════════════════ -->
    <?php get_template_part( 'template-parts/home/cta-banner' ); ?>

</main>

<?php get_footer(); ?>
