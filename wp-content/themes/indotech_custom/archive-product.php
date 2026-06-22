<?php
/**
 * Template Name: Product Archive
 * Template Post Type: page, product
 */

get_header();

// Fetch all available brands for the filter (cached using Transient API)
$brands = get_transient('indotech_filter_brands');
if ($brands === false) {
    $brands = get_posts([
        'post_type'      => 'brand',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    ]);
    set_transient('indotech_filter_brands', $brands, DAY_IN_SECONDS);
}

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

<div class="product-archive-wrapper" style="background: var(--surface); min-height: 100vh; padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
        
        <!-- Header -->
        <header style="margin-bottom: 40px;">
            <div class="section-tag" style="margin-bottom: 12px;">B2B Catalog</div>
            <h1 style="font-size: clamp(32px, 5vw, 44px); font-weight: 700; letter-spacing: -0.03em; margin-bottom: 8px;">Katalog Produk Kami</h1>
            <p style="color: var(--text-secondary); font-size: 15px;">Temukan spesifikasi teknis dan formulasi bahan kimia pembersih, sabun laundry, serta pangan olahan premium.</p>
        </header>

        <!-- ── Layout Grid: Filters on Left (or Top) & Products on Right ── -->
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start;">
            
            <!-- Filter Panel -->
            <aside style="background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-xs);">
                <h3 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px; text-transform: uppercase; letter-spacing: 0.05em;">Filter Katalog</h3>

                <!-- Filter: Brands -->
                <div style="margin-bottom: 24px;">
                    <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 10px;">Brand Ekosistem</span>
                    <ul class="filter-group" style="display: flex; flex-direction: column; gap: 6px; list-style: none; padding: 0;">
                        <li>
                            <button class="filter-btn active" data-filter-type="brand" data-filter-val="" style="text-align: left; font-size: 13.5px; font-weight: 600; color: var(--cobalt); width: 100%; padding: 6px 10px; border-radius: 6px; background: var(--cobalt-pale); border: none;">
                                Semua Brand
                            </button>
                        </li>
                        <?php foreach ($brands as $b) : ?>
                            <li>
                                <button class="filter-btn" data-filter-type="brand" data-filter-val="<?php echo esc_attr($b->ID); ?>" style="text-align: left; font-size: 13.5px; font-weight: 500; color: var(--text-secondary); width: 100%; padding: 6px 10px; border-radius: 6px; background: transparent; border: none; cursor: pointer;">
                                    <?php echo esc_html($b->post_title); ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Filter: Categories -->
                <div>
                    <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 10px;">Kategori Produk</span>
                    <ul class="filter-group" style="display: flex; flex-direction: column; gap: 6px; list-style: none; padding: 0;">
                        <li>
                            <button class="filter-btn active" data-filter-type="cat" data-filter-val="" style="text-align: left; font-size: 13.5px; font-weight: 600; color: var(--cobalt); width: 100%; padding: 6px 10px; border-radius: 6px; background: var(--cobalt-pale); border: none;">
                                Semua Kategori
                            </button>
                        </li>
                        <?php foreach ($categories as $cat) : ?>
                            <li>
                                <button class="filter-btn" data-filter-type="cat" data-filter-val="<?php echo esc_attr($cat->slug); ?>" style="text-align: left; font-size: 13.5px; font-weight: 500; color: var(--text-secondary); width: 100%; padding: 6px 10px; border-radius: 6px; background: transparent; border: none; cursor: pointer;">
                                    <?php echo esc_html($cat->name); ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Products View Grid -->
            <div>
                <div id="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">
                    
                    <?php
                    $product_query = new WP_Query([
                        'post_type'      => 'product',
                        'posts_per_page' => 12,
                        'post_status'    => 'publish'
                    ]);

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
                        <article class="brand-product-card" style="background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 24px; display: flex; flex-direction: column; transition: all var(--trans); position: relative;">
                            <div style="margin-bottom: 16px; border-radius: 8px; overflow: hidden; background: var(--surface); height: 180px; display: flex; align-items: center; justify-content: center;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                <?php else : ?>
                                    <span style="font-weight:700; color: var(--text-muted); font-size: 14px;">NO IMAGE</span>
                                <?php endif; ?>
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <?php if ($sku) : ?>
                                    <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: <?php echo esc_attr($b_accent); ?>; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; justify-content: space-between;">
                                        <span><?php echo esc_html($sku); ?></span>
                                        <?php if ($b_title) : ?>
                                            <span style="opacity: 0.7; font-weight: 600; text-transform: none;"><?php echo esc_html($b_title); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                                <h3 style="font-size: 17px; margin-bottom: 8px; line-height: 1.3; font-weight: 700; letter-spacing: -0.01em;"><?php the_title(); ?></h3>
                                <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top: auto; font-size: 12px; text-align: center; display: block; border-color: <?php echo esc_attr($b_accent); ?>; color: <?php echo esc_attr($b_accent); ?>;">
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
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
