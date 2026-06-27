<?php
/**
 * Template Name: Application Archive
 * Template Post Type: page, application
 */

get_header();
?>

    <section class="inner-page-hero" id="applications-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Aplikasi Layanan</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Aplikasi Sektor Layanan</span>
            <h1 class="inner-page-title">Solusi Aplikasi <em>Layanan B2B</em></h1>
            <p class="inner-page-subtitle">PT Indotech Berkah Abadi menghadirkan formula pembersih andalan dan solusi maklon terintegrasi untuk berbagai kebutuhan operasional bisnis Anda.</p>
        </div>
    </section>

<div class="application-archive-wrapper" style="background: var(--surface); min-height: 50vh; padding-top: 60px; padding-bottom: 80px;">
    <div class="container">

    <style>
    .premium-app-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .premium-app-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-color, var(--cobalt));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .premium-app-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent-color, var(--cobalt));
        box-shadow: 0 20px 40px rgba(0, 87, 255, 0.08);
    }
    .premium-app-card:hover::before {
        opacity: 1;
    }
    .premium-app-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 28px;
        transition: transform 0.3s ease;
    }
    .premium-app-card:hover .premium-app-icon-wrap {
        transform: scale(1.1) rotate(5deg);
    }
    .premium-app-tag {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 8px;
        display: inline-block;
    }
    .premium-app-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 12px;
        letter-spacing: -0.02em;
        line-height: 1.3;
        transition: color 0.3s ease;
    }
    .premium-app-card:hover .premium-app-title {
        color: var(--accent-color, var(--cobalt));
    }
    .premium-app-desc {
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 28px;
    }
    .premium-app-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: var(--accent-color, var(--cobalt));
        text-decoration: none;
        transition: gap 0.3s ease;
    }
    .premium-app-btn svg {
        transition: transform 0.3s ease;
    }
    .premium-app-card:hover .premium-app-btn svg {
        transform: translateX(4px);
    }
    </style>

        <!-- Applications Grid -->
        <div class="applications-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-top: 48px;">
            <?php
            $app_query = new WP_Query([
                'post_type'      => 'application',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            if ($app_query->have_posts()) :
                while ($app_query->have_posts()) : $app_query->the_post();
                    $app_id = get_the_ID();
                    $tagline = carbon_get_post_meta($app_id, 'app_tagline');
                    
                    // Customize icon & color based on title keyword
                    $title_lower = strtolower(get_the_title());
                    $accent_color = 'var(--cobalt)';
                    $bg_color = 'var(--cobalt-pale)';
                    $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'; // default
                    
                    if (strpos($title_lower, 'laundry') !== false) {
                        $accent_color = '#0057ff'; // Cobalt Blue
                        $bg_color = '#ebf2ff';
                        $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="12" cy="13" r="5"/><path d="M12 10a3 3 0 0 1 0 6"/><circle cx="8" cy="6" r="1"/></svg>';
                    } elseif (strpos($title_lower, 'detail') !== false || strpos($title_lower, 'car') !== false || strpos($title_lower, 'auto') !== false) {
                        $accent_color = '#0d9488'; // Teal
                        $bg_color = '#f0fdfa';
                        $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>';
                    }
            ?>
                <article class="premium-app-card reveal" style="--accent-color: <?php echo esc_attr($accent_color); ?>;">
                    <div class="premium-app-icon-wrap" style="background: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($accent_color); ?>;">
                        <?php echo $svg_icon; ?>
                    </div>
                    
                    <div style="flex: 1; display: flex; flex-direction: column;">
                        <span class="premium-app-tag">Aplikasi B2B</span>
                        <h3 class="premium-app-title"><?php the_title(); ?></h3>
                        <?php if ($tagline) : ?>
                            <p class="premium-app-desc"><?php echo esc_html($tagline); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="premium-app-btn">
                        <span>Pelajari Selengkapnya</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </article>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : 
            ?>
                <div style="grid-column: 1 / -1; background: var(--white); padding: 40px; border-radius: 20px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                    Belum ada data aplikasi layanan terdaftar.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
get_footer();
