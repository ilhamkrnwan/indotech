<?php
/**
 * Template Name: Single Product
 * Template Post Type: product
 */

get_header();
?>

<style>
.product-detail-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: start;
}
.product-header-block {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 32px;
    align-items: start;
}
.product-main-image-wrap {
    width: 100%;
    height: 320px;
    border-radius: 12px;
    background: var(--white);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    cursor: zoom-in;
    transition: all var(--trans);
}
.product-main-image-wrap:hover {
    border-color: var(--brand-accent);
    box-shadow: var(--shadow-sm);
}
.product-main-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 12px;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.product-main-image-wrap:hover img {
    transform: scale(1.05);
}
.product-thumbnails-grid {
    display: flex;
    gap: 10px;
    margin-top: 12px;
    flex-wrap: wrap;
}
.product-thumb-item {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid var(--border);
    background: var(--white);
    cursor: pointer;
    transition: all var(--trans);
}
.product-thumb-item:hover, .product-thumb-item.active {
    border-color: var(--brand-accent);
}
.product-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Lightbox Modal */
.gallery-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.95);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.gallery-lightbox.active {
    opacity: 1;
    pointer-events: auto;
}
.lightbox-content {
    max-width: 85%;
    max-height: 85%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.95);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.gallery-lightbox.active .lightbox-content {
    transform: scale(1);
}
.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}
.lightbox-close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    color: var(--white);
    font-size: 40px;
    line-height: 1;
    cursor: pointer;
    opacity: 0.7;
    transition: all var(--trans);
    z-index: 2;
}
.lightbox-close:hover {
    opacity: 1;
    transform: rotate(90deg);
}
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: var(--white);
    font-size: 32px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.6;
    transition: all var(--trans);
    user-select: none;
    z-index: 2;
}
.lightbox-prev:hover, .lightbox-next:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.2);
}
.lightbox-prev {
    left: 24px;
}
.lightbox-next {
    right: 24px;
}
.lightbox-counter {
    position: absolute;
    bottom: 24px;
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.05em;
}

/* Related Product Cards */
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

@media (max-width: 991px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
@media (max-width: 768px) {
    .product-header-block {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .product-main-image-wrap {
        height: 280px;
    }
    .lightbox-prev { left: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-next { right: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-close { top: 12px; right: 12px; font-size: 32px; }
}

.products-grid-catalog {
    display: grid;
    gap: 24px;
}

@media (max-width: 767px) {
    .product-detail-wrapper {
        padding-top: 80px !important;
        padding-bottom: 40px !important;
    }
    .product-detail-grid {
        gap: 20px !important;
    }
    /* Reduce lateral padding on mobile container so it doesn't waste space */
    .product-detail-wrapper .container {
        padding: 0 12px !important;
    }
    
    /* Header card content padding */
    .product-detail-grid > div > div {
        padding: 20px 12px !important;
        border-radius: 8px !important;
    }
    
    .product-header-block {
        gap: 16px !important;
    }
    .product-main-image-wrap {
        height: 220px !important;
        border-radius: 6px !important;
    }
    
    /* Related products grid */
    .products-grid-catalog {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
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
        min-height: auto !important;
    }
    .brand-product-card-excerpt {
        font-size: 11px !important;
        margin-bottom: 12px !important;
        line-height: 1.4 !important;
    }
    .brand-product-card .btn-outline {
        padding: 6px 10px !important;
        font-size: 11px !important;
        border-radius: 4px !important;
    }
    
    /* Inquiry form container card */
    .product-inquiry-box {
        padding: 24px 16px !important;
        border-radius: 8px !important;
    }
}

/* Product Description List Styling */
.product-description ol,
.product-description ul {
    padding-left: 24px;
    margin-top: 10px;
    margin-bottom: 20px;
}
.product-description ol {
    list-style-type: decimal;
}
.product-description ul {
    list-style-type: disc;
}
.product-description li {
    margin-bottom: 8px;
}
</style>

<?php

while (have_posts()) : the_post();
    $product_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $sku = carbon_get_post_meta($product_id, 'product_sku');
    $brand_relation = carbon_get_post_meta($product_id, 'product_brand');
    $downloads = carbon_get_post_meta($product_id, 'product_downloads');
    $specs = carbon_get_post_meta($product_id, 'product_specifications');

    // Retrieve associated brand info
    $brand_id = 0;
    $brand_title = '';
    $brand_accent = '#0057FF';
    $brand_url = '#';
    if (!empty($brand_relation) && isset($brand_relation[0]['id'])) {
        $brand_id = $brand_relation[0]['id'];
        $brand_title = get_the_title($brand_id);
        $brand_accent = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
        $brand_url = get_permalink($brand_id);
    }
?>

<!-- JSON-LD B2B Product Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php echo esc_js(get_the_title()); ?>",
  "sku": "<?php echo esc_js($sku); ?>",
  "image": "<?php echo esc_js(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>",
  "description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt())); ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?php echo esc_js($brand_title); ?>"
  },
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "IDR",
    "lowPrice": "0",
    "highPrice": "0",
    "offerCount": "1",
    "url": "<?php echo esc_js(get_permalink()); ?>",
    "availability": "https://schema.org/InStock"
  },
  "manufacturer": {
    "@type": "Organization",
    "name": "PT Indotech Berkah Abadi",
    "url": "https://indotech.id"
  }
}
</script>

<div class="product-detail-wrapper" style="--brand-accent: <?php echo esc_attr($brand_accent); ?>; background: var(--surface); min-height: 100vh; padding-top: 120px; padding-bottom: 80px;">
    <div class="container">
        
        <!-- Breadcrumbs / Navigation Back -->
        <nav class="product-breadcrumbs" style="margin-bottom: 24px; font-size: 13.5px; color: var(--text-secondary);">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--text-muted);">Beranda</a> &nbsp;/&nbsp; 
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" style="color: var(--text-muted);">Produk</a> &nbsp;/&nbsp; 
            <span style="color: var(--ink); font-weight: 500;"><?php the_title(); ?></span>
        </nav>

        <div class="product-detail-grid">
            
            <!-- ── LEFT COLUMN: Product Info, Specs, & Downloads ── -->
            <div>
                <!-- Main Header Info Card -->
                <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: var(--shadow-xs);">
                    
                    <div class="product-header-block">
                        
                        <!-- Visual Gallery (Large view + Thumbs) -->
                        <div>
                            <div class="product-main-image-wrap">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else : ?>
                                    <span style="font-weight:700; color:var(--text-muted); font-size:16px;">TIDAK ADA GAMBAR</span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Gallery Thumbs Grid -->
                            <?php 
                            $prod_gallery = carbon_get_post_meta($product_id, 'product_gallery');
                            
                            // Collect all images starting with featured image
                            $all_images = [];
                            $featured_url = get_the_post_thumbnail_url($product_id, 'large');
                            if ($featured_url) {
                                $all_images[] = $featured_url;
                            }
                            if (!empty($prod_gallery)) {
                                foreach ($prod_gallery as $img_id) {
                                    $g_url = wp_get_attachment_image_url($img_id, 'large');
                                    if ($g_url && !in_array($g_url, $all_images)) {
                                        $all_images[] = $g_url;
                                    }
                                }
                            }
                            
                            if (count($all_images) > 1) : 
                            ?>
                                <div class="product-thumbnails-grid">
                                    <?php foreach ($all_images as $idx => $img_url) : ?>
                                        <div class="product-thumb-item <?php echo $idx === 0 ? 'active' : ''; ?>" data-index="<?php echo $idx; ?>">
                                            <img src="<?php echo esc_url($img_url); ?>" alt="Gallery Image <?php echo $idx + 1; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- JSON-encoded data for JS Lightbox -->
                            <script id="product-gallery-data" type="application/json">
                            <?php echo json_encode($all_images); ?>
                            </script>
                        </div>

                        <!-- Brand & Title metadata -->
                        <div>
                            <?php if ($sku) : ?>
                                <span style="display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 4px 10px; background: var(--surface); border-radius: 4px; border: 1px solid var(--border); margin-bottom: 12px; color: var(--text-secondary);">
                                    SKU: <?php echo esc_html($sku); ?>
                                </span>
                            <?php endif; ?>
                            
                            <h1 style="font-size: clamp(24px, 4vw, 36px); margin-bottom: 12px; letter-spacing: -0.03em; line-height: 1.2; font-weight: 700; color: var(--ink);"><?php the_title(); ?></h1>
                            
                            <?php if ($brand_id) : ?>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 14px;">
                                    <span style="font-size: 14px; color: var(--text-secondary);">Brand:</span>
                                    <a href="<?php echo esc_url($brand_url); ?>" style="color: var(--brand-accent); font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 1px solid transparent; transition: border var(--trans);" onmouseover="this.style.borderBottomColor='var(--brand-accent)'" onmouseout="this.style.borderBottomColor='transparent'">
                                        <?php echo esc_html($brand_title); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">

                    <!-- Product Description Content -->
                    <div class="product-description" style="color: var(--text-secondary); line-height: 1.8; font-size: 15px;">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Technical Specifications Card -->
                <?php if (!empty($specs)) : ?>
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 24px; letter-spacing: -0.02em; border-bottom: 1px solid var(--border); padding-bottom: 12px;">Spesifikasi Teknis</h2>
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14.5px;">
                            <tbody>
                                <?php foreach ($specs as $spec) : 
                                    if (empty($spec['spec_name'])) continue;
                                ?>
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 14px 10px 14px 0; font-weight: 600; color: var(--ink); width: 35%;"><?php echo esc_html($spec['spec_name']); ?></td>
                                        <td style="padding: 14px 10px; color: var(--text-secondary);"><?php echo esc_html($spec['spec_value']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Related Downloads Card -->
                <?php if (!empty($downloads)) : ?>
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 20px; letter-spacing: -0.02em; border-bottom: 1px solid var(--border); padding-bottom: 12px;">Brosur & Dokumen Teknis</h2>
                        <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 20px;">Silakan unduh dokumen panduan keselamatan (SDS) atau katalog teknis berikut:</p>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <?php 
                            foreach ($downloads as $dl) : 
                                $dl_id = $dl['id'];
                                $dl_url = wp_get_attachment_url($dl_id);
                                $dl_title = get_the_title($dl_id);
                                $is_gated = carbon_get_post_meta($dl_id, 'download_gate_active') === 'yes';
                            ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 16px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <!-- PDF Icon representation -->
                                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(255,0,0,0.1); color: red; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">PDF</div>
                                        <div>
                                            <span style="font-size: 14px; font-weight: 600; color: var(--ink); display: block;"><?php echo esc_html($dl_title); ?></span>
                                            <?php if ($is_gated) : ?>
                                                <span style="font-size: 10px; color: var(--brand-accent); font-weight: 600; text-transform: uppercase;">Wajib Isi Form Prospek</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a href="<?php echo esc_url($dl_url); ?>" <?php echo !$is_gated ? 'download' : ''; ?> class="btn btn-outline" style="font-size: 12px; padding: 8px 16px; border-color: var(--brand-accent); color: var(--brand-accent);">
                                        Unduh File
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Related Products (Produk Serupa) -->
                <?php
                $terms = get_the_terms($product_id, 'product_cat');
                $term_ids = [];
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $term_ids[] = $term->term_id;
                    }
                }

                $related_posts = [];
                if (!empty($term_ids)) {
                    $related_query = new WP_Query([
                        'post_type'      => 'product',
                        'posts_per_page' => 3,
                        'post__not_in'   => [$product_id],
                        'post_status'    => 'publish',
                        'tax_query'      => [
                            [
                                'taxonomy' => 'product_cat',
                                'field'    => 'term_id',
                                'terms'    => $term_ids,
                            ]
                        ]
                    ]);
                    if ($related_query->have_posts()) {
                        $related_posts = $related_query->posts;
                    }
                }

                $posts_found = count($related_posts);
                if ($posts_found < 3) {
                    $exclude_ids = array_merge([$product_id], wp_list_pluck($related_posts, 'ID'));
                    $fallback_query = new WP_Query([
                        'post_type'      => 'product',
                        'posts_per_page' => 3 - $posts_found,
                        'post__not_in'   => $exclude_ids,
                        'post_status'    => 'publish',
                    ]);
                    if ($fallback_query->have_posts()) {
                        $related_posts = array_merge($related_posts, $fallback_query->posts);
                    }
                }

                if (!empty($related_posts)) :
                ?>
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; margin-top: 30px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 24px; letter-spacing: -0.02em; border-bottom: 1px solid var(--border); padding-bottom: 12px; font-weight: 700; color: var(--ink);">Produk Serupa</h2>
                        
                        <div class="products-grid-catalog" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                            <?php 
                            foreach ($related_posts as $post_item) :
                                $rp_id = $post_item->ID;
                                $rp_sku = carbon_get_post_meta($rp_id, 'product_sku');
                                $rp_brand = carbon_get_post_meta($rp_id, 'product_brand');
                                
                                $rp_b_title = '';
                                $rp_b_accent = '#0057FF';
                                if (!empty($rp_brand) && isset($rp_brand[0]['id'])) {
                                    $rp_b_id = $rp_brand[0]['id'];
                                    $rp_b_title = get_the_title($rp_b_id);
                                    $rp_b_accent = carbon_get_post_meta($rp_b_id, 'brand_accent_color') ?: '#0057FF';
                                }
                            ?>
                                <article class="brand-product-card" style="--brand-accent: <?php echo esc_attr($rp_b_accent); ?>; padding: 20px; border-radius: 14px;">
                                    <div class="brand-product-card-img-wrap" style="height: 160px; margin-bottom: 16px; border-radius: 8px;">
                                        <?php if (has_post_thumbnail($rp_id)) : ?>
                                            <?php echo get_the_post_thumbnail($rp_id, 'indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                        <?php else : ?>
                                            <span style="font-weight:700; color: var(--text-muted); font-size: 13px;">TIDAK ADA GAMBAR</span>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex: 1; display: flex; flex-direction: column;">
                                        <?php if ($rp_sku) : ?>
                                            <div class="brand-product-card-sku-wrap" style="font-size: 10px; margin-bottom: 8px;">
                                                <span><?php echo esc_html($rp_sku); ?></span>
                                                <?php if ($rp_b_title) : ?>
                                                    <span style="opacity: 0.7; font-weight: 600; text-transform: none;"><?php echo esc_html($rp_b_title); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <h4 class="brand-product-card-title" style="font-size: 16px; margin-bottom: 8px; min-height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo esc_html(get_the_title($rp_id)); ?></h4>
                                        <p class="brand-product-card-excerpt" style="font-size: 12.5px; margin-bottom: 20px; line-height: 1.5; color: var(--text-secondary); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo wp_strip_all_tags(get_the_excerpt($rp_id)); ?></p>
                                        <a href="<?php echo esc_url(get_permalink($rp_id)); ?>" class="btn btn-outline" style="padding: 10px 16px; font-size: 12px; margin-top: auto;">
                                            Lihat Produk &rarr;
                                        </a>
                                    </div>
                                </article>
                            <?php 
                            endforeach;
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- ── RIGHT COLUMN: STICKY B2B INQUIRY FORM ── -->
            <aside style="position: sticky; top: calc(var(--header-h) + 20px); z-index: 10;">
                <div class="product-inquiry-box" style="background: var(--white); border: 1px solid var(--brand-accent); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-md);">
                    <h3 style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 8px; letter-spacing: -0.02em;">Permintaan Penawaran B2B</h3>
                    <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 24px;">Hubungi tim penjualan B2B kami untuk konsultasi formula, harga grosir, atau kemitraan maklon.</p>

                    <!-- Inquiry Form -->
                    <form id="indotech-inquiry-form" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
                        <!-- Hidden inputs -->
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                        <input type="hidden" name="product_title" value="<?php echo esc_attr(get_the_title($product_id)); ?>">
                        <input type="text" name="website_url" value="" style="display: none;" tabindex="-1" autocomplete="off"> <!-- Honeypot -->

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nama Lengkap *</label>
                            <input type="text" name="full_name" placeholder="Masukkan nama Anda" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Email Bisnis *</label>
                            <input type="email" name="email" placeholder="nama@perusahaan.com" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Pesan Kustom / Spesifikasi</label>
                            <textarea name="message" placeholder="Tuliskan spesifikasi khusus, aroma, atau detail kemasan yang diinginkan..." rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--brand-accent); border-color: var(--brand-accent); padding: 14px;">
                            Kirim Penawaran &rarr;
                        </button>
                    </form>

                    <!-- Alert Feedback Box -->
                    <div id="indotech-inquiry-response" style="display: none; margin-top: 16px; padding: 14px 18px; border-radius: 8px; font-size: 13.5px; line-height: 1.45; font-weight: 500;"></div>
                </div>
            </aside>

        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="gallery-lightbox" class="gallery-lightbox">
    <button class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Tampilan Produk">
    </div>
    <button class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesEl = document.getElementById('product-gallery-data');
    if (!imagesEl) return;
    
    const images = JSON.parse(imagesEl.textContent);
    if (!images || !images.length) return;

    let currentIndex = 0;

    const mainImgWrap = document.querySelector('.product-main-image-wrap');
    const mainImg = mainImgWrap ? mainImgWrap.querySelector('img') : null;
    const thumbs = document.querySelectorAll('.product-thumb-item');

    // Thumbnail swapping
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            currentIndex = index;

            // Update main image src and clear responsive attributes to force override
            if (mainImg) {
                mainImg.src = images[currentIndex];
                if (mainImg.hasAttribute('srcset')) mainImg.removeAttribute('srcset');
                if (mainImg.hasAttribute('sizes')) mainImg.removeAttribute('sizes');
            }

            // Update active state in UI
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Lightbox Modal selectors
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;
    const lightboxPrev = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
    const lightboxNext = lightbox ? lightbox.querySelector('.lightbox-next') : null;
    const lightboxCurrent = document.getElementById('lightbox-current');
    const lightboxTotal = document.getElementById('lightbox-total');

    if (lightboxTotal) {
        lightboxTotal.textContent = images.length;
    }

    function updateLightboxImage() {
        if (lightboxImg) {
            lightboxImg.src = images[currentIndex];
        }
        if (lightboxCurrent) {
            lightboxCurrent.textContent = currentIndex + 1;
        }
    }

    function openLightbox() {
        if (!lightbox) return;
        updateLightboxImage();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightboxImage();
        
        // Also update main page active states for consistency
        if (mainImg) {
            mainImg.src = images[currentIndex];
            if (mainImg.hasAttribute('srcset')) mainImg.removeAttribute('srcset');
            if (mainImg.hasAttribute('sizes')) mainImg.removeAttribute('sizes');
        }
        thumbs.forEach((t, i) => {
            t.classList.toggle('active', i === currentIndex);
        });
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightboxImage();

        // Also update main page active states for consistency
        if (mainImg) {
            mainImg.src = images[currentIndex];
            if (mainImg.hasAttribute('srcset')) mainImg.removeAttribute('srcset');
            if (mainImg.hasAttribute('sizes')) mainImg.removeAttribute('sizes');
        }
        thumbs.forEach((t, i) => {
            t.classList.toggle('active', i === currentIndex);
        });
    }

    if (mainImgWrap) {
        mainImgWrap.addEventListener('click', openLightbox);
    }

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            showPrev();
        });
    }

    if (lightboxNext) {
        lightboxNext.addEventListener('click', function(e) {
            e.stopPropagation();
            showNext();
        });
    }

    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox || !lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            showNext();
        } else if (e.key === 'ArrowLeft') {
            showPrev();
        }
    });
});
</script>

<?php
endwhile;

get_footer();

