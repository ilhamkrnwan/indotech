<?php
/**
 * Template Name: Blog
 *
 * Halaman arsip Wawasan & Artikel B2B PT Indotech Berkah Abadi — Arsitektur Manufy.
 * Preserves AJAX category/search/sort/pagination contracts with functions.php (`indotech_filter_posts`).
 */

$media_cp = get_theme_file_uri( 'assets/images/company-profile' );

if ( isset( $_GET['paged'] ) && absint( $_GET['paged'] ) > 0 ) {
    $paged = absint( $_GET['paged'] );
} elseif ( isset( $_GET['page'] ) && absint( $_GET['page'] ) > 0 ) {
    $paged = absint( $_GET['page'] );
} elseif ( get_query_var( 'paged' ) ) {
    $paged = absint( get_query_var( 'paged' ) );
} elseif ( get_query_var( 'page' ) ) {
    $paged = absint( get_query_var( 'page' ) );
} else {
    $paged = 1;
}
$per_page = 6;

$categories = get_categories( [
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
    'exclude'    => [ 1, 20 ],
] );
if ( ! empty( $categories ) ) {
    $categories = array_filter( $categories, function ( $cat ) {
        return ! is_numeric( $cat->name ) && ! in_array( strtolower( $cat->slug ), [ 'uncategorized', 'tak-berkategori' ], true );
    } );
}

$active_cat  = isset( $_GET['kategori'] ) ? sanitize_text_field( $_GET['kategori'] ) : ( isset( $_GET['cat'] ) ? sanitize_text_field( $_GET['cat'] ) : '' );
$search_init = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$sort_init   = isset( $_GET['sort_by'] ) ? sanitize_text_field( $_GET['sort_by'] ) : 'newest';

$default_cat_id = (int) get_option( 'default_category' );
$blog_args = [
    'post_type'      => 'post',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
];
if ( $active_cat ) {
    $blog_args['category_name'] = $active_cat;
} elseif ( $default_cat_id > 0 ) {
    $blog_args['category__not_in'] = [ $default_cat_id ];
}
if ( $search_init ) {
    $blog_args['s'] = $search_init;
}
switch ( $sort_init ) {
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

$featured_args = [
    'post_type'        => 'post',
    'posts_per_page'   => 1,
    'post_status'      => 'publish',
    'post__in'         => get_option( 'sticky_posts' ) ?: [],
    'category__not_in' => $default_cat_id > 0 ? [ $default_cat_id ] : [],
];
if ( empty( get_option( 'sticky_posts' ) ) ) {
    $featured_args = [
        'post_type'        => 'post',
        'posts_per_page'   => 1,
        'post_status'      => 'publish',
        'category__not_in' => $default_cat_id > 0 ? [ $default_cat_id ] : [],
    ];
}
$featured_query = new WP_Query( $featured_args );
$featured_id    = 0;
if ( $featured_query->have_posts() ) {
    $featured_query->the_post();
    $featured_id = get_the_ID();
    wp_reset_postdata();
}

if ( $featured_id && $paged === 1 && ! $active_cat && ! $search_init && $sort_init === 'newest' ) {
    $blog_args['post__not_in'] = [ $featured_id ];
}

$blog_query = new WP_Query( $blog_args );
$blog_wa    = preg_replace( '/[^0-9]/', '', function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088' );

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 1: Manufy Editorial Masthead -->
        <section class="cs-hero cs-hero--compact ch-wrap" id="blog-hero" aria-labelledby="cs-blog-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Blog</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Panduan formulasi, wawasan industri pembersih komersial, strategi operasional laundry, dan kabar kemitraan Indotech.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="#blog-grid">
                            <span>Jelajahi semua artikel</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-blog-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Wawasan</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Jurnal B2B</span>
                            <span class="ch-h1-secondary">Indotech</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Edukasi Formulasi<br>&amp; Bisnis Kebersihan</p>
                </div>
            </div>
        </section>

        <!-- Band 2: Borderless Editorial Featured Lead -->
        <?php if ( $featured_id && ! $active_cat ) :
            $feat_cats    = get_the_category( $featured_id );
            $feat_cat_lbl = $feat_cats ? esc_html( $feat_cats[0]->name ) : 'Artikel';
            $feat_date    = get_the_date( 'd M Y', $featured_id );
            $feat_author  = get_the_author_meta( 'display_name', get_post_field( 'post_author', $featured_id ) );
            $feat_excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $featured_id ) ), 24, '...' );
            $feat_url     = get_permalink( $featured_id );
            $feat_title   = get_the_title( $featured_id );
            ?>
            <section class="cs-band cs-band--tight ch-wrap" id="blog-featured" aria-label="Artikel pilihan">
                <article class="cs-featured-lead">
                    <a href="<?php echo esc_url( $feat_url ); ?>" class="cs-featured-lead-media" tabindex="-1" aria-hidden="true">
                        <?php if ( has_post_thumbnail( $featured_id ) ) : ?>
                            <?php echo wp_get_attachment_image( get_post_thumbnail_id( $featured_id ), 'large', false, [
                                'loading'       => 'eager',
                                'fetchpriority' => 'high',
                                'decoding'      => 'async',
                                'sizes'         => '(max-width: 960px) 100vw, 720px',
                            ] ); ?>
                        <?php else : ?>
                            <img
                                src="<?php echo esc_url( $media_cp . '/ilustrasi-formulasi.webp' ); ?>"
                                width="1376"
                                height="768"
                                alt="Laboratorium formulasi kimia pembersih dan riset aplikasi PT Indotech Berkah Abadi"
                                fetchpriority="high"
                                decoding="async"
                            >
                        <?php endif; ?>
                    </a>

                    <div class="cs-featured-lead-body">
                        <span class="cs-featured-lead-kicker">Artikel Pilihan · <?php echo $feat_cat_lbl; ?></span>
                        <h2 class="cs-featured-title">
                            <a href="<?php echo esc_url( $feat_url ); ?>"><?php echo esc_html( $feat_title ); ?></a>
                        </h2>
                        <p class="cs-featured-excerpt"><?php echo esc_html( $feat_excerpt ); ?></p>
                        <a href="<?php echo esc_url( $feat_url ); ?>" class="ch-inline-link">
                            <span>Baca artikel lengkap</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </article>
            </section>
        <?php endif; ?>

        <!-- Band 3: Full-Width Horizontal Filter Toolbar + 3-Column Editorial Grid -->
        <section class="cs-band ch-wrap" id="blog-grid" aria-labelledby="cs-articles-title">
            <header class="ch-section-head">
                <div>
                    <span class="cs-pill-tag">Semua Artikel</span>
                    <h2 id="cs-articles-title" class="ch-section-h2 ch-section-h2--sm">Arsip <span>Tulisan Terbaru</span></h2>
                </div>
            </header>

            <div class="filter-panel cs-blog-toolbar">
                <?php if ( $categories ) : ?>
                    <ul class="cs-cat-pills" aria-label="Filter kategori artikel">
                        <li>
                            <button type="button" class="filter-btn <?php echo empty( $active_cat ) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="">
                                <span>Semua</span>
                            </button>
                        </li>
                        <?php foreach ( $categories as $cat ) : ?>
                            <li>
                                <button type="button" class="filter-btn <?php echo ( $active_cat === $cat->slug ) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="<?php echo esc_attr( $cat->slug ); ?>">
                                    <span><?php echo esc_html( $cat->name ); ?></span>
                                    <span class="filter-count"><?php echo (int) $cat->count; ?></span>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="cs-blog-controls">
                    <div class="cs-blog-search-wrap">
                        <label class="ch-sr-only" for="blog-search">Cari Artikel</label>
                        <input type="text" id="blog-search" class="cs-toolbar-input" placeholder="Cari topik artikel..." value="<?php echo esc_attr( $search_init ); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>

                    <div class="cs-blog-sort-wrap">
                        <label class="ch-sr-only" for="blog-sort">Urutkan Artikel</label>
                        <select id="blog-sort" class="cs-toolbar-select">
                            <option value="newest" <?php selected( $sort_init, 'newest' ); ?>>Terbaru</option>
                            <option value="oldest" <?php selected( $sort_init, 'oldest' ); ?>>Terlama</option>
                            <option value="title_asc" <?php selected( $sort_init, 'title_asc' ); ?>>Judul (A–Z)</option>
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div id="blog-posts-grid" class="cs-editorial-grid" role="list">
                <?php if ( $blog_query->have_posts() ) : ?>
                    <?php while ( $blog_query->have_posts() ) :
                        $blog_query->the_post();
                        $p_id     = get_the_ID();
                        $img_html = has_post_thumbnail()
                            ? wp_get_attachment_image( get_post_thumbnail_id(), 'indotech-card', false, [
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'sizes'    => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 410px',
                            ] )
                            : '';
                        $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );
                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $p_id ),
                            'title'          => get_the_title( $p_id ),
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => 'Indotech Journal',
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h3',
                            'post_id'        => $p_id,
                            'role_listitem'  => true,
                        ] );
                    endwhile;
                    wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="blog-empty cs-empty-panel">
                        <h3>Belum ada artikel pada filter ini</h3>
                        <p>Coba kata kunci lain atau tampilkan kembali seluruh kategori artikel Indotech.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="blog-pagination-wrap">
                <?php
                $total_pages  = $blog_query->max_num_pages;
                $base_url     = strtok( get_permalink(), '?' );
                $query_params = [];
                if ( ! empty( $active_cat ) ) {
                    $query_params['kategori'] = $active_cat;
                }
                if ( ! empty( $search_init ) ) {
                    $query_params['s'] = $search_init;
                }
                if ( ! empty( $sort_init ) && $sort_init !== 'newest' ) {
                    $query_params['sort_by'] = $sort_init;
                }

                if ( function_exists( 'indotech_get_pagination_html' ) ) {
                    echo indotech_get_pagination_html( $paged, $total_pages, $base_url, $query_params, 'Navigasi halaman blog' );
                }
                ?>
            </div>
        </section>

        <!-- Band 4: Dark Obsidian-Navy Formulasi Consultation Strip -->
        <section class="cs-band cs-band--tight ch-wrap" aria-label="Konsultasi formulasi dan bahan baku">
            <div class="cs-blog-cta-strip">
                <div>
                    <span class="cs-pill-tag cs-pill-tag--lime">Konsultasi B2B</span>
                    <h2>Butuh Rekomendasi Formulasi atau Sampel Produk?</h2>
                    <p>Tim R&amp;D dan konsultan Indotech siap membantu pemilihan bahan baku kimia, paket usaha, hingga jasa maklon berizin resmi.</p>
                </div>
                <a
                    href="https://wa.me/<?php echo esc_attr( $blog_wa ); ?>?text=<?php echo rawurlencode( 'Halo Indotech, saya membaca blog Indotech dan ingin berkonsultasi seputar bahan baku kimia dan formulasi.' ); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="ch-pill-cta"
                >
                    <span>Chat Tim Teknis WhatsApp</span>
                    <span class="ch-pill-cta-icon" aria-hidden="true">
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </span>
                </a>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns      = document.querySelectorAll('.filter-panel .filter-btn');
        const grid            = document.getElementById('blog-posts-grid');
        const paginWrap       = document.getElementById('blog-pagination-wrap');
        const searchInput     = document.getElementById('blog-search');
        const sortSelect      = document.getElementById('blog-sort');
        const featuredSection = document.getElementById('blog-featured');
        if (!grid) return;

        let activeCat     = "<?php echo esc_js( $active_cat ); ?>";
        let activePage    = <?php echo (int) $paged; ?>;
        let activeSort    = sortSelect ? sortSelect.value : "<?php echo esc_js( $sort_init ); ?>";
        let searchQuery   = searchInput ? searchInput.value : "<?php echo esc_js( $search_init ); ?>";
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
                    activePage = parseInt(this.dataset.page, 10) || 1;
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
                        btn.classList.toggle('active', btn.dataset.filterVal === '');
                    });

                    doFetch(true);
                });
            }
        }

        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            activePage  = parseInt(urlParams.get('paged'), 10) || 1;
            activeCat   = urlParams.get('kategori') || urlParams.get('cat') || '';
            searchQuery = urlParams.get('s') || '';
            activeSort  = urlParams.get('sort_by') || 'newest';

            if (searchInput) searchInput.value = searchQuery;
            if (sortSelect) sortSelect.value = activeSort;

            filterBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.filterVal === activeCat);
            });

            doFetch(false);
        });

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchQuery = this.value;
                activePage = 1;
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => doFetch(true), 400);
            });
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                activeSort = this.value;
                activePage = 1;
                doFetch(true);
            });
        }

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
</main>

<?php get_footer(); ?>
