<?php
/**
 * Template Name: Blog
 *
 * Halaman arsip Blog PT Indotech Berkah Abadi.
 * Sections: Hero · Featured Post · Filter Tab Kategori · Grid Artikel · Pagination
 */

if ( isset($_GET['paged']) && absint($_GET['paged']) > 0 ) {
    $paged = absint($_GET['paged']);
} elseif ( isset($_GET['page']) && absint($_GET['page']) > 0 ) {
    $paged = absint($_GET['page']);
} elseif ( get_query_var('paged') ) {
    $paged = absint(get_query_var('paged'));
} elseif ( get_query_var('page') ) {
    $paged = absint(get_query_var('page'));
} else {
    $paged = 1;
}
$per_page = 6;

// Ambil semua kategori yang digunakan di posts
$categories = get_categories( [
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
] );

// Aktif filter dari query string
$active_cat  = isset( $_GET['kategori'] ) ? sanitize_text_field( $_GET['kategori'] ) : (isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '');
$search_init = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$sort_init   = isset( $_GET['sort_by'] ) ? sanitize_text_field( $_GET['sort_by'] ) : 'newest';

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
if ( $search_init ) {
    $blog_args['s'] = $search_init;
}
switch ($sort_init) {
    case 'oldest':
        $blog_args['orderby'] = 'date';
        $blog_args['order']   = 'ASC';
        break;
    case 'title_asc':
        $blog_args['orderby'] = 'title';
        $blog_args['order']   = 'ASC';
        break;
    case 'newest':
    default:
        $blog_args['orderby'] = 'date';
        $blog_args['order']   = 'DESC';
        break;
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

// Exclude featured dari grid jika di halaman 1 tanpa filter
if ( $featured_id && $paged === 1 && ! $active_cat && ! $search_init && $sort_init === 'newest' ) {
    $blog_args['post__not_in'] = [ $featured_id ];
}

$blog_query = new WP_Query( $blog_args );

get_header();
?>

<style>
.blog-archive-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 40px;
    align-items: start;
}
.blog-archive-container .filter-panel {
    background: var(--white, #ffffff);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 16px;
    padding: 24px;
    box-shadow: var(--shadow-sm, 0 1px 3px rgba(0,0,0,0.05));
    position: sticky;
    top: calc(var(--header-h, 80px) + 24px);
    z-index: 10;
}
.blog-archive-container .filter-panel-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--ink, #111827);
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border, #e5e7eb);
    padding-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.blog-archive-container .filter-group-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted, #6b7280);
    display: block;
    margin-bottom: 10px;
    letter-spacing: 0.05em;
}
.blog-archive-container .filter-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.blog-archive-container .filter-btn {
    text-align: left;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary, #4b5563);
    width: 100%;
    padding: 8px 12px;
    border-radius: var(--radius-sm, 8px);
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all var(--trans, 0.2s ease);
}
.blog-archive-container .filter-btn:hover {
    background: var(--surface, #f9fafb);
    color: var(--ink, #111827);
}
.blog-archive-container .filter-btn.active {
    font-weight: 700;
    color: var(--cobalt, #0057ff);
    background: var(--cobalt-pale, #eef3ff);
}

/* Articles Grid inside 1fr container */
#blog-posts-grid.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    background: transparent;
    border: none;
    border-radius: 0;
    overflow: visible;
}

#blog-posts-grid .blog-card {
    background: var(--white, #ffffff);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform var(--trans, 0.25s ease), box-shadow var(--trans, 0.25s ease), border-color var(--trans, 0.25s ease);
    box-shadow: var(--shadow-xs, 0 1px 2px rgba(0,0,0,0.05));
    min-height: 380px;
}
#blog-posts-grid .blog-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md, 0 10px 25px -5px rgba(0,0,0,0.1));
    border-color: rgba(0, 87, 255, 0.2);
    background: var(--white, #ffffff);
}

#blog-posts-grid .blog-thumb {
    width: 100%;
    height: 180px;
    position: relative;
    overflow: hidden;
    background: var(--surface-2, #f3f4f6);
    display: block;
    flex-shrink: 0;
}
#blog-posts-grid .blog-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
#blog-posts-grid .blog-card:hover .blog-img {
    transform: scale(1.05);
}

#blog-posts-grid .blog-category {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--cobalt, #0057ff);
    color: var(--white, #ffffff);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.05em;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

#blog-posts-grid .blog-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

#blog-posts-grid .blog-meta {
    font-size: 12px;
    color: var(--text-muted, #6b7280);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

#blog-posts-grid .blog-title {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.35;
    margin-bottom: 8px;
    color: var(--ink, #111827);
    letter-spacing: -0.01em;
}
#blog-posts-grid .blog-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}
#blog-posts-grid .blog-card:hover .blog-title a {
    color: var(--cobalt, #0057ff);
}

#blog-posts-grid .blog-excerpt {
    font-size: 13px;
    color: var(--text-secondary, #4b5563);
    line-height: 1.55;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

#blog-posts-grid .blog-read-more {
    margin-top: auto;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--cobalt, #0057ff);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s ease;
}
#blog-posts-grid .blog-card:hover .blog-read-more {
    gap: 10px;
}

/* Responsive adjustment */
@media (max-width: 991px) {
    .blog-archive-container {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .blog-archive-container .filter-panel {
        position: relative;
        top: 0 !important;
        padding: 16px;
        border-radius: 12px;
    }
    .blog-search-sort-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .blog-archive-container .filter-list {
        flex-direction: row;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        gap: 8px;
        padding-bottom: 6px;
        scrollbar-width: none;
    }
    .blog-archive-container .filter-list::-webkit-scrollbar {
        display: none;
    }
    .blog-archive-container .filter-list li {
        flex: 0 0 auto;
    }
    .blog-archive-container .filter-btn {
        width: auto;
        white-space: nowrap;
        padding: 6px 14px;
        font-size: 12px;
        background: var(--surface, #f9fafb);
        border: 1px solid var(--border, #e5e7eb);
        border-radius: 20px;
    }
    .blog-archive-container .filter-btn.active {
        background: var(--cobalt, #0057ff);
        color: var(--white, #ffffff);
        border-color: var(--cobalt, #0057ff);
    }
}
@media (max-width: 575px) {
    .blog-search-sort-row {
        grid-template-columns: 1fr;
    }
    #blog-posts-grid.blog-grid {
        grid-template-columns: 1fr;
    }
}

/* Loading state */
.products-loading {
    opacity: 0.4;
    pointer-events: none;
    transition: opacity 0.25s ease;
}
</style>

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
         FILTER KATEGORI, SORTING, SEARCH + GRID ARTIKEL
    ════════════════════════════════════════════════════════ -->
    <section class="blog-section section-padding" id="blog-grid">
        <div class="container">

            <div class="blog-section-header" style="margin-bottom: 40px;">
                <div class="blog-section-left">
                    <span class="section-tag section-tag--dark">Semua Artikel</span>
                    <h2 class="section-title" style="margin-top:12px;">Artikel Terbaru</h2>
                </div>
            </div>

            <!-- ── Layout Grid: Filters on Left (or Top) & Blog Grid on Right ── -->
            <div class="blog-archive-container">
                
                <!-- Filter Panel -->
                <aside class="filter-panel">
                    <h3 class="filter-panel-title">Filter Artikel</h3>
                    <!-- Search & Sort Row -->
                    <div class="blog-search-sort-row">
                        <!-- Search Input -->
                        <div class="blog-search-group" style="margin-bottom: 24px;">
                            <span class="filter-group-title">Cari Artikel</span>
                            <div style="position: relative; display: flex; align-items: center;">
                                <input type="text" id="blog-search" placeholder="Masukkan kata kunci..." value="<?php echo esc_attr($search_init); ?>"
                                       style="width: 100%; padding: 10px 36px 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: inherit; transition: border-color var(--trans);" />
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                     style="position: absolute; right: 12px; color: var(--text-muted); pointer-events: none;">
                                    <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                        </div>

                        <!-- Sorting Dropdown -->
                        <div class="blog-sort-group" style="margin-bottom: 24px;">
                            <span class="filter-group-title">Urutkan Artikel</span>
                            <div style="position: relative; display: flex; align-items: center;">
                                <select id="blog-sort" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: inherit; transition: border-color var(--trans); background: var(--white); cursor: pointer; -webkit-appearance: none; -moz-appearance: none; appearance: none;">
                                    <option value="newest" <?php selected($sort_init, 'newest'); ?>>Terbaru (Default)</option>
                                    <option value="oldest" <?php selected($sort_init, 'oldest'); ?>>Terlama</option>
                                    <option value="title_asc" <?php selected($sort_init, 'title_asc'); ?>>Judul (A-Z)</option>
                                </select>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" 
                                     style="position: absolute; right: 12px; color: var(--text-muted); pointer-events: none;">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Filter: Categories -->
                    <?php if ( $categories ) : ?>
                    <div>
                        <span class="filter-group-title">Kategori Artikel</span>
                        <ul class="filter-list">
                            <li>
                                <button class="filter-btn <?php echo empty($active_cat) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="">
                                    Semua Kategori
                                </button>
                            </li>
                            <?php foreach ($categories as $cat) : ?>
                                <li>
                                    <button class="filter-btn <?php echo ($active_cat === $cat->slug) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="<?php echo esc_attr($cat->slug); ?>">
                                        <?php echo esc_html($cat->name); ?>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </aside>

                <!-- Articles View Grid -->
                <div>
                    <div id="blog-posts-grid" class="blog-grid" role="list">
                        
                        <?php if ( $blog_query->have_posts() ) : ?>
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
                        <?php else : ?>
                            <div class="blog-empty reveal" style="text-align:center;padding:80px 0;grid-column:1/-1;">
                                <div class="blog-empty-icon" aria-hidden="true">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:var(--border-dark);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                </div>
                                <h3 style="font-size:20px;margin:20px 0 8px;">Belum ada artikel</h3>
                                <p style="color:var(--text-secondary);margin-bottom:28px;">
                                    Belum ada artikel yang diterbitkan.
                                </p>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Pagination -->
                    <div id="blog-pagination-wrap">
                        <?php
                        $total_pages  = $blog_query->max_num_pages;
                        $base_url     = strtok(get_permalink(), '?');
                        $query_params = [];
                        if (!empty($active_cat))                    $query_params['kategori'] = $active_cat;
                        if (!empty($search_init))                   $query_params['s'] = $search_init;
                        if (!empty($sort_init) && $sort_init !== 'newest') $query_params['sort_by'] = $sort_init;

                        echo indotech_get_pagination_html($paged, $total_pages, $base_url, $query_params, 'Navigasi halaman blog');
                        ?>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Client Script for AJAX Blog Filtering -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns  = document.querySelectorAll('.filter-panel .filter-btn');
        const grid        = document.getElementById('blog-posts-grid');
        const paginWrap   = document.getElementById('blog-pagination-wrap');
        const searchInput = document.getElementById('blog-search');
        const sortSelect  = document.getElementById('blog-sort');
        const featuredSection = document.getElementById('blog-featured');
        if (!grid) return;

        let activeCat     = "<?php echo esc_js($active_cat); ?>";
        let activePage    = <?php echo (int)$paged; ?>;
        let activeSort    = sortSelect ? sortSelect.value : "<?php echo esc_js($sort_init); ?>";
        let searchQuery   = searchInput ? searchInput.value : "<?php echo esc_js($search_init); ?>";
        let searchTimeout = null;

        function updateURL() {
            const url = new URL(window.location.href);
            
            if (activePage > 1) {
                url.searchParams.set('paged', activePage);
            } else {
                url.searchParams.delete('paged');
            }
            
            if (activeCat) {
                url.searchParams.set('kategori', activeCat);
            } else {
                url.searchParams.delete('kategori');
                url.searchParams.delete('cat');
            }
            
            if (searchQuery) {
                url.searchParams.set('s', searchQuery);
            } else {
                url.searchParams.delete('s');
            }

            if (activeSort && activeSort !== 'newest') {
                url.searchParams.set('sort_by', activeSort);
            } else {
                url.searchParams.delete('sort_by');
            }
            
            history.pushState({
                page: activePage,
                cat: activeCat,
                search: searchQuery,
                sort: activeSort
            }, '', url.toString());
        }

        function doFetch(pushUrl = true) {
            grid.classList.add('products-loading');

            if (pushUrl) {
                updateURL();
            }

            // Hide/Show Featured section based on state
            if (featuredSection) {
                if (activeCat !== '' || searchQuery !== '' || activeSort !== 'newest' || activePage > 1) {
                    featuredSection.style.display = 'none';
                } else {
                    featuredSection.style.display = '';
                }
            }

            const formData = new FormData();
            formData.append('action',      'indotech_filter_posts');
            formData.append('cat_slug',    activeCat);
            formData.append('search',      searchQuery);
            formData.append('sort_by',     activeSort);
            formData.append('page',        activePage);
            formData.append('current_url', window.location.href);
            formData.append('nonce',       indotechData.nonce);

            fetch(indotechData.ajaxUrl, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    grid.classList.remove('products-loading');
                    if (data.success && data.data) {
                        if (data.data.html !== undefined) {
                            grid.innerHTML = data.data.html;
                            grid.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
                            bindResetButton();
                        }
                        if (data.data.pagination !== undefined && paginWrap) {
                            paginWrap.innerHTML = data.data.pagination;
                            bindPaginationClicks();
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    grid.classList.remove('products-loading');
                });
        }

        function bindPaginationClicks() {
            if (!paginWrap) return;
            paginWrap.querySelectorAll('.ajax-page-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (e.metaKey || e.ctrlKey || e.shiftKey) return;
                    e.preventDefault();
                    activePage = parseInt(this.dataset.page) || 1;
                    doFetch(true);
                    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        }

        function bindResetButton() {
            const resetBtn = grid.querySelector('.reset-filters-btn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) searchInput.value = '';
                    if (sortSelect) sortSelect.value = 'newest';
                    
                    searchQuery = '';
                    activeSort = 'newest';
                    activeCat = '';
                    activePage = 1;

                    filterBtns.forEach(btn => {
                        if (btn.dataset.filterVal === '') {
                            btn.classList.add('active');
                        } else {
                            btn.classList.remove('active');
                        }
                    });

                    doFetch(true);
                });
            }
        }

        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            activePage  = parseInt(urlParams.get('paged')) || 1;
            activeCat   = urlParams.get('kategori') || urlParams.get('cat') || '';
            searchQuery = urlParams.get('s') || '';
            activeSort  = urlParams.get('sort_by') || 'newest';

            if (searchInput) searchInput.value = searchQuery;
            if (sortSelect) sortSelect.value = activeSort;

            filterBtns.forEach(btn => {
                const val = btn.dataset.filterVal;
                if (val === activeCat) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            doFetch(false);
        });

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchQuery = this.value;
                activePage = 1;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    doFetch(true);
                }, 400);
            });
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                activeSort = this.value;
                activePage = 1;
                doFetch(true);
            });
        }

        // ── Filter Category Buttons ──────────────────────────────────
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const val = this.dataset.filterVal;

                const siblings = this.closest('ul').querySelectorAll('.filter-btn');
                siblings.forEach(s => s.classList.remove('active'));
                this.classList.add('active');

                activeCat  = val;
                activePage = 1;
                doFetch(true);
            });
        });

        bindPaginationClicks();
        bindResetButton();
    });
    </script>

    <!-- ════════════════════════════════════════════════════════
         CTA BANNER
    ════════════════════════════════════════════════════════ -->
    <?php get_template_part( 'template-parts/home/cta-banner' ); ?>

</main>

<?php get_footer(); ?>
