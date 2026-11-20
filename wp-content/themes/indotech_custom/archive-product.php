<?php
/**
 * Template Name: Product Archive
 * Template Post Type: page, product
 *
 * Katalog Produk B2B PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 * Mempertahankan AJAX filtering (`indotech_filter_products`) & URL state.
 */

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

$per_page    = 9;
$search_init = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$cat_init    = isset( $_GET['kategori'] ) ? sanitize_text_field( $_GET['kategori'] ) : ( isset( $_GET['cat'] ) ? sanitize_text_field( $_GET['cat'] ) : '' );
if ( empty( $cat_init ) && is_tax( 'product_cat' ) ) {
    $queried_term = get_queried_object();
    if ( $queried_term && isset( $queried_term->slug ) ) {
        $cat_init = $queried_term->slug;
    }
}

$categories = get_transient( 'indotech_filter_categories' );
if ( $categories === false ) {
    $categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ] );
    set_transient( 'indotech_filter_categories', $categories, DAY_IN_SECONDS );
}

$query_args = [
    'post_type'      => 'product',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
];
if ( ! empty( $search_init ) ) {
    $query_args['s'] = $search_init;
}
if ( ! empty( $cat_init ) ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $cat_init,
        ],
    ];
}
$product_query = new WP_Query( $query_args );

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="product-hero" aria-labelledby="cs-product-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Produk</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Temukan spesifikasi teknis, formulasi bahan kimia pembersih, deterjen laundry komersial, hingga paket bahan curah siap kirim.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/brands/' ) ); ?>">
                            <span>Telusuri 7 brand ekosistem</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-product-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Katalog</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">1.000+ SKU</span>
                            <span class="ch-h1-secondary">Produk B2B</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Izin Edar Kemenkes PKRT<br>&amp; Sertifikasi Halal</p>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Daftar Katalog Produk">
            <div class="filter-panel cs-catalog-toolbar">
                <div class="cs-catalog-top-row">
                    <div class="cs-catalog-search">
                        <label class="ch-sr-only" for="product-search">Cari Produk</label>
                        <input type="text" id="product-search" placeholder="Cari produk, paket bahan, atau parfum..." value="<?php echo esc_attr( $search_init ); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <p class="cs-catalog-count">Menampilkan <?php echo (int) $product_query->found_posts; ?> produk B2B Indotech</p>
                </div>

                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <ul class="filter-list cs-filter-list" aria-label="Filter kategori produk">
                        <li>
                            <button type="button" class="filter-btn <?php echo empty( $cat_init ) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="">
                                Semua Kategori
                            </button>
                        </li>
                        <?php foreach ( $categories as $cat ) : ?>
                            <li>
                                <button type="button" class="filter-btn <?php echo ( $cat_init === $cat->slug ) ? 'active' : ''; ?>" data-filter-type="cat" data-filter-val="<?php echo esc_attr( $cat->slug ); ?>">
                                    <?php echo esc_html( $cat->name ); ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div id="products-grid" class="cs-editorial-grid">
                <?php
                if ( $product_query->have_posts() ) :
                    while ( $product_query->have_posts() ) :
                        $product_query->the_post();
                        $p_id           = get_the_ID();
                        $brand_relation = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $p_id, 'product_brand' ) : [];
                        $brand_fallback = ( ! empty( $brand_relation ) && isset( $brand_relation[0]['id'] ) ) ? get_the_title( $brand_relation[0]['id'] ) : 'Indotech';
                        $img_html       = has_post_thumbnail()
                            ? get_the_post_thumbnail( $p_id, 'indotech-thumb', [
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'sizes'    => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 410px',
                            ] )
                            : '';
                        $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 14, '...' );
                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $p_id ),
                            'title'          => get_the_title( $p_id ),
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => $brand_fallback,
                            'media_variant'  => 'product',
                            'heading_tag'    => 'h2',
                            'post_id'        => $p_id,
                        ] );
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="cs-empty-panel">
                        <h2>Belum ada produk terdaftar</h2>
                        <p>Coba kata kunci pencarian lain atau tampilkan kembali seluruh kategori produk.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            $total_pages  = $product_query->max_num_pages;
            $base_url     = is_post_type_archive( 'product' )
                ? get_post_type_archive_link( 'product' )
                : strtok( get_permalink() ?: home_url( '/produk/' ), '?' );
            $query_params = [];
            if ( ! empty( $cat_init ) ) {
                $query_params['kategori'] = $cat_init;
            }
            if ( ! empty( $search_init ) ) {
                $query_params['s'] = $search_init;
            }
            ?>
            <div id="product-pagination-wrap">
                <?php
                if ( function_exists( 'indotech_get_pagination_html' ) ) {
                    echo indotech_get_pagination_html( $paged, $total_pages, $base_url, $query_params, 'Navigasi halaman produk' );
                }
                ?>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns  = document.querySelectorAll('.filter-panel .filter-btn');
    const grid        = document.getElementById('products-grid');
    const paginWrap   = document.getElementById('product-pagination-wrap');
    const searchInput = document.getElementById('product-search');
    if (!grid) return;

    let activeBrand   = '';
    let activeCat     = "<?php echo esc_js( $cat_init ); ?>";
    let activePage    = <?php echo (int) $paged; ?>;
    let searchQuery   = searchInput ? searchInput.value : '';
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

        history.pushState({
            page: activePage,
            cat: activeCat,
            search: searchQuery
        }, '', url.toString());
    }

    function doFetch(pushUrl = true) {
        grid.classList.add('products-loading');

        if (pushUrl) {
            updateURL();
        }

        const formData = new FormData();
        formData.append('action',      'indotech_filter_products');
        formData.append('brand_id',    activeBrand);
        formData.append('cat_slug',    activeCat);
        formData.append('search',      searchQuery);
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

    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        activePage  = parseInt(urlParams.get('paged'), 10) || 1;
        activeCat   = urlParams.get('kategori') || urlParams.get('cat') || '';
        searchQuery = urlParams.get('s') || '';

        if (searchInput) searchInput.value = searchQuery;

        filterBtns.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filterVal === activeCat);
        });

        doFetch(false);
    });

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchQuery = this.value;
            activePage  = 1;

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => doFetch(true), 400);
        });
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const type     = this.dataset.filterType;
            const val      = this.dataset.filterVal;
            const siblings = this.closest('ul').querySelectorAll('.filter-btn');
            siblings.forEach(s => s.classList.remove('active'));
            this.classList.add('active');

            if (type === 'brand') activeBrand = val;
            else if (type === 'cat') activeCat = val;

            activePage = 1;
            doFetch(true);
        });
    });

    bindPaginationClicks();
});
</script>

<?php get_footer(); ?>
