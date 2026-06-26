<?php
/**
 * Template Name: Brand Archive
 * Template Post Type: page, brand
 */

get_header();
?>

<section class="inner-page-hero" id="brands-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Brand</span>
        </nav>
        <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Portofolio Brand</span>
        <h1 class="inner-page-title">Portofolio <em>Brand Kami</em></h1>
        <p class="inner-page-subtitle">Menghadirkan formulasi terbaik dan kualitas B2B berstandar tinggi untuk memenuhi segmen industri laundry, pembersih rumahan, hingga makanan premium.</p>
    </div>
</section>

<div class="brand-archive-wrapper" style="background: var(--surface); min-height: 100vh;">

    <!-- ── Brands Grid ── -->
    <section class="brand-archive-grid-section" style="padding: 80px 0;">
        <div class="container">
            <div class="brands-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 30px;">
                
                <?php
                $brand_query = new WP_Query([
                    'post_type'      => 'brand',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC'
                ]);

                if ($brand_query->have_posts()) :
                    while ($brand_query->have_posts()) : $brand_query->the_post();
                        if (strtolower(trim(get_the_title())) === 'cokusi') {
                            continue;
                        }
                        $brand_id = get_the_ID();
                        $accent = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
                        $tagline = carbon_get_post_meta($brand_id, 'brand_tagline');
                        
                        // Extract initials
                        $title = get_the_title();
                        $words = explode(' ', $title);
                        $initials = '';
                        foreach ($words as $w) {
                            $initials .= strtoupper(substr($w, 0, 1));
                        }
                        $initials = substr($initials, 0, 2);
                ?>

                <article class="brand-card" style="--ba: <?php echo esc_attr($accent); ?>; background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 36px 32px; display: flex; flex-direction: column; transition: all var(--trans); position: relative; box-shadow: var(--shadow-sm); overflow: hidden;">
                    <!-- Cobalt top accent bar -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--ba);"></div>
                    
                    <div class="brand-card-top" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; width: 100%;">
                        <!-- Logo / Initials Container -->
                        <div class="brand-icon-wrap" style="width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; border: 1px solid var(--border); background: var(--surface); color: var(--ba);">
                            <?php 
                            $local_logo = indotech_get_brand_logo_url(get_the_title());
                            if (has_post_thumbnail()) : 
                                the_post_thumbnail('thumbnail', ['style' => 'width:100%;height:100%;object-fit:cover;border-radius:10px;']);
                            elseif (!empty($local_logo)) : 
                                echo '<img src="' . esc_url($local_logo) . '" alt="' . esc_attr(get_the_title()) . ' logo" style="width:100%;height:100%;object-fit:contain;border-radius:10px;padding:4px;">';
                            else : 
                                echo esc_html($initials); 
                            endif; 
                            ?>
                        </div>
                    </div>

                    <div class="brand-card-body" style="flex: 1; margin-bottom: 24px;">
                        <h3 class="brand-name" style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 6px; letter-spacing: -0.02em;"><?php the_title(); ?></h3>
                        <?php if ($tagline) : ?>
                            <span class="brand-tagline" style="font-size: 12px; font-weight: 600; margin-bottom: 12px; display: block; color: var(--ba); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html($tagline); ?></span>
                        <?php endif; ?>
                        <p class="brand-desc" style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.6;"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="brand-cta" style="color: var(--ba); font-weight: 700; font-family: 'Space Grotesk', sans-serif; display: inline-flex; align-items: center; gap: 6px; font-size: 14px; margin-top: auto;">
                        Lihat Produk &rarr;
                    </a>
                </article>

                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                ?>
                    <div style="grid-column: 1 / -1; background: var(--white); padding: 40px; border-radius: 16px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                        Belum ada data brand korporat terdaftar.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

</div>

<?php
get_footer();
