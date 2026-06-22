<?php
/**
 * Template Name: Single Brand
 * Template Post Type: brand
 */

get_header();

while (have_posts()) : the_post();
    $brand_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $tagline = carbon_get_post_meta($brand_id, 'brand_tagline');
    $accent_color = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
    $website_url = carbon_get_post_meta($brand_id, 'brand_website_url');
    $gallery = carbon_get_post_meta($brand_id, 'brand_gallery');

    // Query all products belonging to this brand
    $product_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => '_product_brand',
                'value'   => 'post:brand:' . $brand_id,
                'compare' => '='
            ]
        ]
    ]);
?>

<div class="brand-detail-wrapper" style="--brand-color: <?php echo esc_attr($accent_color); ?>;">
    
    <!-- ── Brand Hero Header ── -->
    <header class="brand-single-hero" style="background: var(--ink); color: var(--white); padding: 80px 0 60px; border-bottom: 4px solid var(--brand-color); position: relative; overflow: hidden;">
        <div class="container" style="position: relative; z-index: 2;">
            <div class="brand-hero-meta" style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="brand-hero-logo" style="width: 80px; height: 80px; background: var(--white); padding: 10px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <?php the_post_thumbnail('thumbnail', ['style' => 'max-width:100%;height:auto;object-fit:contain;']); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <h1 style="font-size: clamp(32px, 5vw, 48px); margin-bottom: 8px; letter-spacing: -0.03em;"><?php the_title(); ?></h1>
                    <?php if ($tagline) : ?>
                        <p class="brand-hero-tagline" style="font-size: 18px; color: var(--brand-color); font-weight: 600; font-family: 'Space Grotesk', sans-serif;"><?php echo esc_html($tagline); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Decorative Glow -->
        <div style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, <?php echo esc_attr($accent_color); ?>40, transparent 70%); right: -100px; top: -100px; pointer-events: none; z-index: 1;"></div>
    </header>

    <!-- ── Brand Content Section ── -->
    <section class="brand-body-section" style="padding: 60px 0; background: var(--surface);">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 48px; align-items: start;">
                
                <!-- Left Column: Description & Products -->
                <div>
                    <div class="brand-description-box" style="background: var(--white); padding: 40px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 40px;">
                        <h2 style="font-size: 24px; margin-bottom: 20px; letter-spacing: -0.02em;">Tentang Brand</h2>
                        <div class="brand-content-text" style="color: var(--text-secondary); line-height: 1.75;">
                            <?php the_content(); ?>
                        </div>
                        <?php if ($website_url) : ?>
                            <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="margin-top: 30px; background: var(--brand-color); border-color: var(--brand-color);">
                                Kunjungi Website Resmi &rarr;
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Products Loop -->
                    <div class="brand-products-section">
                        <h2 style="font-size: 28px; margin-bottom: 30px; letter-spacing: -0.03em;">Katalog Produk <em><?php the_title(); ?></em></h2>
                        
                        <?php if ($product_query->have_posts()) : ?>
                            <div class="brand-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                                <?php while ($product_query->have_posts()) : $product_query->the_post(); 
                                    $sku = carbon_get_post_meta(get_the_ID(), 'product_sku');
                                ?>
                                    <article class="brand-product-card" style="background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 24px; display: flex; flex-direction: column; transition: all var(--trans); position: relative;">
                                        <div style="margin-bottom: 16px; border-radius: 8px; overflow: hidden; background: var(--surface); height: 200px; display: flex; align-items: center; justify-content: center;">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                            <?php else : ?>
                                                <span style="font-weight:700; color: var(--text-muted); font-size: 14px;">NO IMAGE</span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="flex: 1; display: flex; flex-direction: column;">
                                            <?php if ($sku) : ?>
                                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--brand-color); letter-spacing: 0.05em; margin-bottom: 6px;"><?php echo esc_html($sku); ?></span>
                                            <?php endif; ?>
                                            <h3 style="font-size: 18px; margin-bottom: 12px; line-height: 1.3; font-weight: 700; letter-spacing: -0.01em;"><?php the_title(); ?></h3>
                                            <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top: auto; font-size: 13px; text-align: center; display: block; border-color: var(--brand-color); color: var(--brand-color);">
                                                Lihat Produk &rarr;
                                            </a>
                                        </div>
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        <?php else : ?>
                            <div style="background: var(--white); padding: 30px; border-radius: 12px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                                Belum ada produk terdaftar untuk brand ini.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Sidebar (Gallery & Info) -->
                <aside>
                    <?php if (!empty($gallery)) : ?>
                        <div class="brand-gallery-box" style="background: var(--white); padding: 30px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 30px;">
                            <h3 style="font-size: 18px; margin-bottom: 20px; letter-spacing: -0.01em;">Galeri Brand</h3>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                <?php foreach ($gallery as $img_id) : ?>
                                    <div style="border-radius: 8px; overflow: hidden; height: 100px;">
                                        <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="brand-info-box" style="background: var(--white); padding: 30px; border-radius: 16px; border: 1px solid var(--border);">
                        <h3 style="font-size: 18px; margin-bottom: 20px; letter-spacing: -0.01em;">Holding Corporate</h3>
                        <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 15px;">
                            Setiap produk di bawah brand <strong><?php the_title(); ?></strong> diproduksi dengan standar mutu tinggi dan formula khusus dari PT Indotech Berkah Abadi.
                        </p>
                        <hr style="border: 0; border-top: 1px solid var(--border); margin: 15px 0;">
                        <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Sertifikasi</span>
                        <div style="display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;">
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">BPOM</span>
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">Halal MUI</span>
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">ISO 9001</span>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

</div>

<?php
endwhile;

get_footer();
