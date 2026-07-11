<?php
/**
 * Template Name: Blog
 *
 * Halaman arsip Blog PT Indotech Berkah Abadi.
 * Sections: Hero · Featured Post · Filter Tab Kategori · Grid Artikel · Pagination
 */

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
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
                                <input type="text" id="blog-search" placeholder="Masukkan kata kunci..." value=""
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
                                    <option value="newest">Terbaru (Default)</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="title_asc">Judul (A-Z)</option>
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
                                <button class="filter-btn active" data-filter-type="cat" data-filter-val="">
                                    Semua Kategori
                                </button>
                            </li>
                            <?php foreach ($categories as $cat) : ?>
                                <li>
                                    <button class="filter-btn" data-filter-type="cat" data-filter-val="<?php echo esc_attr($cat->slug); ?>">
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
                        $total_pages = $blog_query->max_num_pages;
                        $base_url    = get_permalink();
                        if ($total_pages > 1) :
                        ?>
                            <nav class="product-pagination" aria-label="Navigasi halaman blog">
                                 <?php if ($paged > 1) : ?>
                                     <a href="#" class="page-btn ajax-page-btn" data-page="<?php echo $paged - 1; ?>" aria-label="Halaman sebelumnya">
                                         &lsaquo; Sebelumnya
                                     </a>
                                 <?php endif; ?>
          
                                 <?php
                                 $start = max(1, $paged - 2);
                                 $end   = min($total_pages, $paged + 2);
                                 if ($start > 1) :
                                 ?>
                                     <a href="#" class="page-btn ajax-page-btn" data-page="1">1</a>
                                     <?php if ($start > 2) : ?><span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span><?php endif; ?>
                                 <?php endif; ?>
          
                                 <?php for ($i = $start; $i <= $end; $i++) : ?>
                                     <a
                                         href="#"
                                         class="page-btn ajax-page-btn <?php echo $i === $paged ? 'active' : ''; ?>"
                                         data-page="<?php echo $i; ?>"
                                         <?php echo $i === $paged ? 'aria-current="page"' : ''; ?>
                                     >
                                         <?php echo $i; ?>
                                     </a>
                                 <?php endfor; ?>
          
                                 <?php if ($end < $total_pages) : ?>
                                     <?php if ($end < $total_pages - 1) : ?><span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span><?php endif; ?>
                                     <a href="#" class="page-btn ajax-page-btn" data-page="<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
                                 <?php endif; ?>
          
                                 <?php if ($paged < $total_pages) : ?>
                                     <a href="#" class="page-btn ajax-page-btn" data-page="<?php echo $paged + 1; ?>" aria-label="Halaman berikutnya">
                                         Berikutnya &rsaquo;
                                     </a>
                                 <?php endif; ?>
                             </nav>
                             <p class="product-pagination-info">Halaman <?php echo $paged; ?> dari <?php echo $total_pages; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Client Script for AJAX Blog Filtering -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-panel .filter-btn');
        const grid       = document.getElementById('blog-posts-grid');
        const paginWrap  = document.getElementById('blog-pagination-wrap');
        const searchInput = document.getElementById('blog-search');
        const sortSelect  = document.getElementById('blog-sort');
        const featuredSection = document.getElementById('blog-featured');
        if (!grid) return;

        let activeCat     = '';
        let activePage    = 1;
        let activeSort    = sortSelect ? sortSelect.value : 'newest';
        let searchQuery   = searchInput ? searchInput.value : '';
        let searchTimeout = null;

        function doFetch() {
            grid.classList.add('products-loading');

            // Hide/Show Featured section based on state
            if (featuredSection) {
                if (activeCat !== '' || searchQuery !== '' || activeSort !== 'newest' || activePage > 1) {
                    featuredSection.style.display = 'none';
                } else {
                    featuredSection.style.display = '';
                }
            }

            const formData = new FormData();
            formData.append('action',   'indotech_filter_posts');
            formData.append('cat_slug', activeCat);
            formData.append('search',   searchQuery);
            formData.append('sort_by',  activeSort);
            formData.append('page',     activePage);
            formData.append('nonce',    indotechData.nonce);

            fetch(indotechData.ajaxUrl, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    grid.classList.remove('products-loading');
                    if (data.success && data.data) {
                        if (data.data.html !== undefined) {
                            grid.innerHTML = data.data.html;
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
                    e.preventDefault();
                    activePage = parseInt(this.dataset.page);
                    doFetch();
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

                    doFetch();
                });
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchQuery = this.value;
                activePage = 1;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    doFetch();
                }, 400);
            });
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                activeSort = this.value;
                activePage = 1;
                doFetch();
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const val  = this.dataset.filterVal;

                const siblings = this.closest('ul').querySelectorAll('.filter-btn');
                siblings.forEach(s => s.classList.remove('active'));
                this.classList.add('active');

                activeCat = val;
                activePage = 1;
                doFetch();
            });
        });

        bindPaginationClicks();
        bindResetButton();
    });
    </script>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         CTA BANNER
    ════════════════════════════════════════════════════════ -->
    <?php get_template_part( 'template-parts/home/cta-banner' ); ?>

</main>

<?php get_footer(); ?>
