<?php
/**
 * Template Name: Single Application
 * Template Post Type: application
 */

get_header();

while (have_posts()) : the_post();
    $application_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $tagline = carbon_get_post_meta($application_id, 'app_tagline');
    $related_products = carbon_get_post_meta($application_id, 'app_related_products');

    // Fetch products based on association IDs
    $product_ids = [];
    if (!empty($related_products)) {
        foreach ($related_products as $item) {
            if (isset($item['id'])) {
                $product_ids[] = intval($item['id']);
            }
        }
    }

    $product_query = null;
    if (!empty($product_ids)) {
        $product_query = new WP_Query([
            'post_type'      => 'product',
            'post__in'       => $product_ids,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'post__in'
        ]);
    }
?>

<style>
.app-grid-container {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: start;
}
.app-description-card {
    background: var(--white);
    padding: 40px;
    border-radius: 16px;
    border: 1px solid var(--border);
    margin-bottom: 40px;
    box-shadow: var(--shadow-xs);
}
.app-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}
.app-cta-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 40px;
    box-shadow: var(--shadow-sm);
    text-align: center;
}

/* App Description List Styling */
.app-description-card ol,
.app-description-card ul {
    padding-left: 24px;
    margin-top: 10px;
    margin-bottom: 20px;
}
.app-description-card ol {
    list-style-type: decimal;
}
.app-description-card ul {
    list-style-type: disc;
}
.app-description-card li {
    margin-bottom: 8px;
}

@media (max-width: 991px) {
    .app-grid-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

@media (max-width: 767px) {
    .application-detail-wrapper {
        padding-bottom: 40px !important;
    }
    .application-detail-wrapper .container {
        padding: 0 12px !important;
    }
    .app-description-card {
        padding: 24px 16px !important;
        border-radius: 8px !important;
        margin-bottom: 24px !important;
    }
    .app-products-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
    .app-products-grid article {
        padding: 10px !important;
        border-radius: 6px !important;
    }
    .app-products-grid article > div:first-child {
        height: 120px !important;
        margin-bottom: 8px !important;
        border-radius: 4px !important;
    }
    .app-products-grid h3 {
        font-size: 13px !important;
        margin-bottom: 4px !important;
        line-height: 1.25 !important;
    }
    .app-products-grid p {
        font-size: 11px !important;
        margin-bottom: 12px !important;
        line-height: 1.4 !important;
    }
    .app-products-grid .btn-outline {
        padding: 6px 10px !important;
        font-size: 11px !important;
        border-radius: 4px !important;
    }
    .app-cta-card {
        padding: 24px 16px !important;
        border-radius: 8px !important;
    }
}
</style>

<div class="application-detail-wrapper" style="background: var(--surface); min-height: 100vh; padding-bottom: 80px;">
    
    <!-- ── Hero Banner ── -->
    <section class="inner-page-hero" id="application-single-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="<?php echo esc_url( get_post_type_archive_link('application') ); ?>">Aplikasi Layanan</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Aplikasi Sektor Layanan</span>
            <h1 class="inner-page-title"><?php the_title(); ?></h1>
            <?php if ($tagline) : ?>
                <p class="inner-page-subtitle"><?php echo esc_html($tagline); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ── Content Area ── -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="app-grid-container">
                
                <!-- Left: Description & Recomended Products -->
                <div>
                    <!-- Detail Text -->
                    <div class="app-description-card">
                        <h2 style="font-size: 22px; margin-bottom: 16px; letter-spacing: -0.02em;">Deskripsi Layanan & Formula B2B</h2>
                        <div style="color: var(--text-secondary); line-height: 1.75; font-size: 15px;">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Associated Products Grid -->
                    <div>
                        <h2 style="font-size: 26px; margin-bottom: 24px; letter-spacing: -0.03em;">Rekomendasi Produk Pilihan</h2>
                        <?php if ($product_query && $product_query->have_posts()) : ?>
                            <div class="app-products-grid">
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
                                Belum ada rekomendasi produk khusus untuk aplikasi layanan ini.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Sticky Corporate Info & CTA -->
                <aside style="position: sticky; top: calc(var(--header-h) + 20px); z-index: 10;">
                    <div class="app-cta-card">
                        <div style="width: 50px; height: 50px; background: var(--cobalt-pale); border-radius: 50%; color: var(--cobalt); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 20px; font-weight: 700;">?</div>
                        <h3 style="font-size: 18px; margin-bottom: 8px; letter-spacing: -0.01em;">Butuh Solusi Maklon?</h3>
                        <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 24px;">PT Indotech Berkah Abadi menyediakan konsultasi formula kimia, sabun laundry, dan maklon kustom untuk memenuhi spesifikasi industri Anda.</p>
                        <?php
                        $whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
                        $wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
                        $wa_msg   = rawurlencode( 'Halo indotech.id, saya tertarik dengan layanan formula/maklon untuk sektor ' . get_the_title() . '.' );
                        ?>
                        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" class="btn btn-primary" style="width: 100%; justify-content: center;" target="_blank" rel="noopener">
                            Hubungi via WhatsApp
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
