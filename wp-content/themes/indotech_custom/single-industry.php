<?php
/**
 * Template Name: Single Industry
 * Template Post Type: industry
 */

get_header();

while (have_posts()) : the_post();
    $industry_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $tagline = carbon_get_post_meta($industry_id, 'industry_tagline');
    $icon = carbon_get_post_meta($industry_id, 'industry_icon');

    // Query products related to this industry
    $product_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => '_product_industries',
                'value'   => 'post:industry:' . $industry_id,
                'compare' => '='
            ]
        ]
    ]);
?>

<div class="industry-detail-wrapper" style="background: var(--surface); min-height: 100vh; padding-bottom: 80px;">
    
    <!-- ── Hero Banner ── -->
    <header class="industry-hero" style="background: var(--ink); color: var(--white); padding: 80px 0; border-bottom: 3px solid var(--cobalt); position: relative; overflow: hidden;">
        <div class="container" style="position: relative; z-index: 2; max-width: 900px; text-align: center;">
            <span class="section-tag section-tag--white" style="margin-bottom: 16px;">Solusi Sektor Industri</span>
            <h1 style="font-size: clamp(32px, 5vw, 46px); margin-bottom: 12px; letter-spacing: -0.03em; line-height: 1.1;"><?php the_title(); ?></h1>
            <?php if ($tagline) : ?>
                <p style="font-size: 18px; color: var(--cobalt-light); font-weight: 500; font-family: 'Space Grotesk', sans-serif;"><?php echo esc_html($tagline); ?></p>
            <?php endif; ?>
        </div>
        <div style="position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(0,87,255,0.18), transparent 70%); right: -100px; top: -100px; pointer-events: none; z-index: 1;"></div>
    </header>

    <!-- ── Content Area ── -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 48px; align-items: start;">
                
                <!-- Left: Description & Recomended Products -->
                <div>
                    <!-- Detail Text -->
                    <div style="background: var(--white); padding: 40px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 40px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 22px; margin-bottom: 16px; letter-spacing: -0.02em;">Deskripsi Solusi</h2>
                        <div style="color: var(--text-secondary); line-height: 1.75; font-size: 15px;">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Associated Products Grid -->
                    <div>
                        <h2 style="font-size: 26px; margin-bottom: 24px; letter-spacing: -0.03em;">Produk Yang Direkomendasikan</h2>
                        <?php if ($product_query->have_posts()) : ?>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                                <?php while ($product_query->have_posts()) : $product_query->the_post(); 
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
                                    <article style="background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 24px; display: flex; flex-direction: column; position: relative;">
                                        <div style="margin-bottom: 16px; border-radius: 8px; overflow: hidden; background: var(--surface); height: 180px; display: flex; align-items: center; justify-content: center;">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                            <?php else : ?>
                                                <span style="font-weight:700; color: var(--text-muted); font-size: 14px;">TIDAK ADA GAMBAR</span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="flex: 1; display: flex; flex-direction: column;">
                                            <?php if ($sku) : ?>
                                                <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: <?php echo esc_attr($b_accent); ?>; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; justify-content: space-between;">
                                                    <span><?php echo esc_html($sku); ?></span>
                                                    <span><?php echo esc_html($b_title); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <h3 style="font-size: 17px; margin-bottom: 8px; font-weight: 700;"><?php the_title(); ?></h3>
                                            <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top: auto; font-size: 12px; text-align: center; border-color: <?php echo esc_attr($b_accent); ?>; color: <?php echo esc_attr($b_accent); ?>;">
                                                Lihat Detail &rarr;
                                            </a>
                                        </div>
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        <?php else : ?>
                            <div style="background: var(--white); padding: 30px; border-radius: 12px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                                Belum ada rekomendasi produk khusus untuk industri ini.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Sticky Corporate Info & CTA -->
                <aside style="position: sticky; top: calc(var(--header-h) + 20px); z-index: 10;">
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-sm); text-align: center;">
                        <div style="width: 50px; height: 50px; background: var(--cobalt-pale); border-radius: 50%; color: var(--cobalt); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 20px; font-weight: 700;">?</div>
                        <h3 style="font-size: 18px; margin-bottom: 8px; letter-spacing: -0.01em;">Butuh Solusi Kustom?</h3>
                        <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 24px;">PT Indotech Berkah Abadi menyediakan konsultasi formula kimia, sabun laundry, dan maklon kustom untuk memenuhi spesifikasi industri Anda.</p>
                        <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            Hubungi Kami
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

</div>

<?php
endwhile;

get_footer();
