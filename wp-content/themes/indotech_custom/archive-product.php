<?php
/**
 * Template Name: Product Archive
 * Template Post Type: page, product
 */

get_header();

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$per_page    = 9;
$search_init = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

// Fetch all product categories for the filter (cached using Transient API)
$categories = get_transient('indotech_filter_categories');
if ($categories === false) {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false
    ]);
    set_transient('indotech_filter_categories', $categories, DAY_IN_SECONDS);
}
?>

<style>
.product-archive-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 40px;
    align-items: start;
}
.filter-panel {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px 24px;
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: calc(var(--header-h) + 24px);
    z-index: 10;
}
.filter-panel-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
#product-search:focus {
    outline: none;
    border-color: var(--cobalt) !important;
    box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.08);
}
.filter-group-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    display: block;
    margin-bottom: 12px;
    letter-spacing: 0.05em;
}
.filter-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.filter-btn {
    text-align: left;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary);
    width: 100%;
    padding: 8px 12px;
    border-radius: var(--radius-sm);
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all var(--trans);
}
.filter-btn:hover {
    background: var(--surface);
    color: var(--ink);
}
.filter-btn.active {
    font-weight: 700;
    color: var(--cobalt);
    background: var(--cobalt-pale);
}
.brand-product-card {
    --brand-accent: var(--cobalt);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    transition: all var(--trans);
    position: relative;
    box-shadow: var(--shadow-xs);
}
.brand-product-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: rgba(0, 87, 255, 0.15);
}
.brand-product-card-img-wrap {
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    background: var(--surface);
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
    transition: border-color var(--trans);
}
.brand-product-card:hover .brand-product-card-img-wrap {
    border-color: rgba(0, 87, 255, 0.15);
}
.brand-product-card-sku-wrap {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--brand-accent);
    letter-spacing: 0.06em;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}
.brand-product-card-title {
    font-size: 18px;
    margin-bottom: 10px;
    line-height: 1.3;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: var(--ink);
    transition: color var(--trans);
}
.brand-product-card:hover .brand-product-card-title {
    color: var(--brand-accent);
}
.brand-product-card-excerpt {
    font-size: 13.5px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 24px;
}
.brand-product-card .btn-outline {
    margin-top: auto;
    font-size: 12px;
    text-align: center;
    display: block;
    border-color: var(--brand-accent) !important;
    color: var(--brand-accent) !important;
    background: transparent;
    padding: 10px 16px;
    transition: all var(--trans);
}
.brand-product-card:hover .btn-outline {
    background: var(--brand-accent) !important;
    color: var(--white) !important;
    border-color: var(--brand-accent) !important;
    box-shadow: 0 4px 12px rgba(0, 87, 255, 0.15);
}

/* Responsive & Loading Styles */
@media (max-width: 991px) {
    .product-archive-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .filter-panel {
        position: relative;
        top: 0 !important;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .filter-list {
        flex-direction: row;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        gap: 8px;
        padding-bottom: 8px;
        scrollbar-width: none;
    }
    .filter-list::-webkit-scrollbar {
        display: none;
    }
    .filter-btn {
        width: auto;
        white-space: nowrap;
        flex-shrink: 0;
        display: inline-block;
        padding: 8px 16px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 13px;
    }
    .filter-btn.active {
        border-color: var(--cobalt-pale);
    }
}
.product-archive-wrapper {
    background: var(--surface);
    min-height: 100vh;
    padding: 80px 0;
}
#products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
    transition: opacity 0.25s ease;
}
.products-loading {
    opacity: 0.4;
    pointer-events: none;
}
.product-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 48px;
    padding-top: 40px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
}
.product-pagination .page-btn {
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 8px;
    border: 1.5px solid var(--border);
    background: var(--white);
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--trans);
    text-decoration: none;
}
.product-pagination .page-btn:hover {
    border-color: var(--cobalt);
    color: var(--cobalt);
    background: var(--cobalt-pale);
}
.product-pagination .page-btn.active {
    background: var(--cobalt);
    border-color: var(--cobalt);
    color: var(--white);
}
.product-pagination .page-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
    pointer-events: none;
}
.product-pagination-info {
    font-size: 13px;
    color: var(--text-muted);
    text-align: center;
    margin-top: 12px;
}

/* Mobile responsive enhancements */
@media (max-width: 767px) {
    .product-archive-wrapper {
        padding: 30px 0 !important;
    }
    .product-archive-container {
        gap: 20px !important;
    }
    /* Reduce lateral padding on mobile container so it doesn't waste space */
    .product-archive-wrapper .container {
        padding: 0 12px !important;
    }
    
    #products-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
    
    /* Reduced padding and smaller rounded cards */
    .brand-product-card {
        padding: 10px !important;
        border-radius: 6px !important;
    }
    .brand-product-card-img-wrap {
        height: 120px !important;
        margin-bottom: 8px !important;
        border-radius: 4px !important;
    }
    .brand-product-card-sku-wrap {
        font-size: 8px !important;
        margin-bottom: 4px !important;
    }
    .brand-product-card-title {
        font-size: 13px !important;
        margin-bottom: 4px !important;
        line-height: 1.25 !important;
    }
    .brand-product-card-excerpt {
        font-size: 11px !important;
        margin-bottom: 12px !important;
        line-height: 1.4 !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .brand-product-card .btn-outline {
        padding: 6px 10px !important;
        font-size: 11px !important;
        border-radius: 4px !important;
        margin-top: auto !important;
    }
    
    /* Horizontal scrolling category filter */
    .filter-panel {
        padding: 16px 16px !important;
        border-radius: 8px !important;
    }
    .filter-btn {
        padding: 6px 12px !important;
        font-size: 12px !important;
        border-radius: 4px !important;
    }
}
</style>

<section class="inner-page-hero" id="product-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Produk</span>
        </nav>
        <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Katalog B2B</span>
        <h1 class="inner-page-title">Katalog <em>Produk Kami</em></h1>
        <p class="inner-page-subtitle">Temukan spesifikasi teknis dan formulasi bahan kimia pembersih, sabun laundry, serta pangan olahan premium.</p>
    </div>
</section>

<div class="product-archive-wrapper">
    <div class="container">

        <!-- ── Layout Grid: Filters on Left (or Top) & Products on Right ── -->
        <div class="product-archive-container">
            
            <!-- Filter Panel -->
            <aside class="filter-panel">
                <h3 class="filter-panel-title">Filter Katalog</h3>

                <!-- Search Input -->
                <div style="margin-bottom: 24px;">
                    <span class="filter-group-title">Cari Produk</span>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="text" id="product-search" placeholder="Masukkan kata kunci..." value="<?php echo esc_attr($search_init); ?>"
                               style="width: 100%; padding: 10px 36px 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: inherit; transition: border-color var(--trans);" />
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                             style="position: absolute; right: 12px; color: var(--text-muted); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>

                <!-- Filter: Categories -->
                <div>
                    <span class="filter-group-title">Kategori Produk</span>
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
            </aside>

            <!-- Products View Grid -->
            <div>
                <div id="products-grid">
                    
                    <?php
                    $query_args = [
                        'post_type'      => 'product',
                        'posts_per_page' => $per_page,
                        'paged'          => $paged,
                        'post_status'    => 'publish'
                    ];
                    if (!empty($search_init)) {
                        $query_args['s'] = $search_init;
                    }
                    $product_query = new WP_Query($query_args);

                    if ($product_query->have_posts()) :
                        while ($product_query->have_posts()) : $product_query->the_post();
                            $p_id = get_the_ID();
                            $sku = carbon_get_post_meta($p_id, 'product_sku');
                            $brand_relation = carbon_get_post_meta($p_id, 'product_brand');
                            
                            $b_title = '';
                            $b_accent = '#0057FF';
                            if (!empty($brand_relation) && isset($brand_relation[0]['id'])) {
                                $b_id = $brand_relation[0]['id'];
                                $b_title = get_the_title($b_id);
                                $b_accent = carbon_get_post_meta($b_id, 'brand_accent_color') ?: '#0057FF';
                            }
                    ?>
                        <article class="brand-product-card" style="--brand-accent: <?php echo esc_attr($b_accent); ?>;">
                            <div class="brand-product-card-img-wrap">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                <?php else : ?>
                                    <span style="font-weight:700; color: var(--text-muted); font-size: 14px;">TIDAK ADA GAMBAR</span>
                                <?php endif; ?>
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <?php if ($sku) : ?>
                                    <div class="brand-product-card-sku-wrap">
                                        <span><?php echo esc_html($sku); ?></span>
                                        <?php if ($b_title) : ?>
                                            <span style="opacity: 0.7; font-weight: 600; text-transform: none;"><?php echo esc_html($b_title); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="brand-product-card-title"><?php the_title(); ?></h3>
                                <p class="brand-product-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                    Lihat Produk &rarr;
                                </a>
                            </div>
                        </article>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else : 
                    ?>
                        <div style="grid-column: 1 / -1; background: var(--white); padding: 40px; border-radius: 12px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                            Belum ada produk terdaftar.
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Pagination -->
                <?php
                $total_pages = $product_query->max_num_pages;
                $base_url    = get_permalink();
                ?>
                <div id="product-pagination-wrap">
                <?php if ($total_pages > 1) : ?>
                    <nav class="product-pagination" aria-label="Navigasi halaman produk">
                         <?php if ($paged > 1) : ?>
                             <a href="<?php echo esc_url(add_query_arg('paged', $paged - 1, $base_url)); ?>" class="page-btn ajax-page-btn" data-page="<?php echo $paged - 1; ?>" aria-label="Halaman sebelumnya">
                                 &lsaquo; Sebelumnya
                             </a>
                         <?php endif; ?>
 
                         <?php
                         // Show numbered pages — max 5 window
                         $start = max(1, $paged - 2);
                         $end   = min($total_pages, $paged + 2);
                         if ($start > 1) :
                         ?>
                             <a href="<?php echo esc_url(add_query_arg('paged', 1, $base_url)); ?>" class="page-btn ajax-page-btn" data-page="1">1</a>
                             <?php if ($start > 2) : ?><span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span><?php endif; ?>
                         <?php endif; ?>
 
                         <?php for ($i = $start; $i <= $end; $i++) : ?>
                             <a
                                 href="<?php echo esc_url(add_query_arg('paged', $i, $base_url)); ?>"
                                 class="page-btn ajax-page-btn <?php echo $i === $paged ? 'active' : ''; ?>"
                                 data-page="<?php echo $i; ?>"
                                 <?php echo $i === $paged ? 'aria-current="page"' : ''; ?>
                             >
                                 <?php echo $i; ?>
                             </a>
                         <?php endfor; ?>
 
                         <?php if ($end < $total_pages) : ?>
                             <?php if ($end < $total_pages - 1) : ?><span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span><?php endif; ?>
                             <a href="<?php echo esc_url(add_query_arg('paged', $total_pages, $base_url)); ?>" class="page-btn ajax-page-btn" data-page="<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
                         <?php endif; ?>
 
                         <?php if ($paged < $total_pages) : ?>
                             <a href="<?php echo esc_url(add_query_arg('paged', $paged + 1, $base_url)); ?>" class="page-btn ajax-page-btn" data-page="<?php echo $paged + 1; ?>" aria-label="Halaman berikutnya">
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-panel .filter-btn');
    const grid       = document.getElementById('products-grid');
    const paginWrap  = document.getElementById('product-pagination-wrap');
    const searchInput = document.getElementById('product-search');
    if (!grid || !filterBtns.length) return;

    let activeBrand   = '';
    let activeCat     = '';
    let activePage    = 1;
    let searchQuery   = searchInput ? searchInput.value : '';
    let searchTimeout = null;

    function doFetch() {
        grid.classList.add('products-loading');

        const formData = new FormData();
        formData.append('action',   'indotech_filter_products');
        formData.append('brand_id', activeBrand);
        formData.append('cat_slug', activeCat);
        formData.append('search',   searchQuery);
        formData.append('page',     activePage);
        formData.append('nonce',    indotechData.nonce);

        fetch(indotechData.ajaxUrl, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                grid.classList.remove('products-loading');
                if (data.success && data.data) {
                    if (data.data.html !== undefined)  grid.innerHTML = data.data.html;
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

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const type = this.dataset.filterType;
            const val  = this.dataset.filterVal;

            const siblings = this.closest('ul').querySelectorAll('.filter-btn');
            siblings.forEach(s => s.classList.remove('active'));
            this.classList.add('active');

            if (type === 'brand') activeBrand = val;
            else if (type === 'cat') activeCat = val;

            activePage = 1; // reset to first page on filter change
            doFetch();
        });
    });

    bindPaginationClicks();
});
</script>

<?php
get_footer();

