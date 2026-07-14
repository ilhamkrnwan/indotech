<?php
/**
 * Template Name: Industry Archive
 * Template Post Type: page, industry
 */

get_header();
echo '<main id="main-content">';
?>

    <section class="inner-page-hero" id="industries-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Industri</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Solusi B2B</span>
            <h1 class="inner-page-title">Solusi Sektor <em>Industri</em></h1>
            <p class="inner-page-subtitle">PT Indotech Berkah Abadi menyediakan formula pembersih khusus dan pasokan kimia terstandarisasi untuk berbagai kebutuhan industri.</p>
        </div>
    </section>

<div class="industry-archive-wrapper" style="background: var(--surface); min-height: 50vh; padding-top: 60px; padding-bottom: 80px;">
    <div class="container">

        <!-- Industries Grid -->
        <div class="industries-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
            <?php
            $industry_query = new WP_Query([
                'post_type'      => 'industry',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            if ($industry_query->have_posts()) :
                while ($industry_query->have_posts()) : $industry_query->the_post();
                    $ind_id = get_the_ID();
                    $tagline = carbon_get_post_meta($ind_id, 'industry_tagline');
                    $icon = carbon_get_post_meta($ind_id, 'industry_icon') ?: 'networking';
            ?>
                <article class="brand-product-card" style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; display: flex; flex-direction: column; transition: all var(--trans); position: relative; box-shadow: var(--shadow-sm);">
                    <!-- Icon placeholder representation -->
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--cobalt-pale); color: var(--cobalt); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; margin-bottom: 24px;">i</div>
                    
                    <div style="flex: 1; display: flex; flex-direction: column; margin-bottom: 20px;">
                        <h3 style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 8px; letter-spacing: -0.02em;"><?php the_title(); ?></h3>
                        <?php if ($tagline) : ?>
                            <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.6;"><?php echo esc_html($tagline); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top: auto; justify-content: center; font-size: 13px;">
                        Lihat Solusi &rarr;
                    </a>
                </article>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : 
            ?>
                <div style="grid-column: 1 / -1; background: var(--white); padding: 40px; border-radius: 16px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                    Belum ada data solusi industri terdaftar.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
echo '</main>';
get_footer();
