<?php
/**
 * Template Name: Brand Archive
 * Template Post Type: page, brand
 */

get_header();
?>

<div class="brand-archive-wrapper" style="background: var(--surface); min-height: 100vh;">
    
    <!-- ── Hero Section ── -->
    <section class="brand-archive-hero" style="background: var(--ink); color: var(--white); padding: 90px 0; border-bottom: 1px solid var(--border); text-align: center; position: relative; overflow: hidden;">
        <div class="container" style="position: relative; z-index: 2;">
            <div class="section-tag section-tag--white" style="margin-bottom: 16px;">Brand Portfolio</div>
            <h1 style="font-size: clamp(36px, 6vw, 56px); font-weight: 700; letter-spacing: -0.04em; margin-bottom: 16px; line-height: 1.05;">
                Portofolio <em>Brand Kami</em>
            </h1>
            <p style="font-size: 17px; font-weight: 300; color: rgba(255,255,255,.55); max-width: 600px; margin: 0 auto; line-height: 1.75;">
                Menghadirkan formulasi terbaik dan kualitas berstandar tinggi untuk memenuhi beragam segmen industri laundry, pembersih rumahan, hingga makanan premium.
            </p>
        </div>
        <div style="position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(0,87,255,.15), transparent 70%); top: -300px; left: 50%; transform: translateX(-50%); pointer-events: none; z-index: 1;"></div>
    </section>

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
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['style' => 'width:100%;height:100%;object-fit:cover;border-radius:10px;']); ?>
                            <?php else : ?>
                                <?php echo esc_html($initials); ?>
                            <?php endif; ?>
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
