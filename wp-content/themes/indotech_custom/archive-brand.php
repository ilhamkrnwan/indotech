<?php
/**
 * Template Name: Brand Archive
 * Template Post Type: page, brand
 */

get_header();
echo '<main id="main-content">';
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
    <section class="brand-archive-grid-section" style="padding: 80px 0; background: var(--white);">
        <div class="container">
            <div class="brands-grid">
                
                <?php
                $brands_static = [
                    [
                        'name'     => 'Cleanique Academy',
                        'tagline'  => 'Pelatihan & Edukasi Laundry',
                        'initials' => 'CA',
                        'logo'     => get_template_directory_uri() . '/assets/images/cleaniqueacademy.webp',
                        'accent'   => '#0057FF',
                        'bg'       => '#EEF3FF',
                    ],
                    [
                        'name'     => 'Cleanique Lab',
                        'tagline'  => 'Produsen Bahan Kimia Laundry',
                        'initials' => 'CL',
                        'logo'     => get_template_directory_uri() . '/assets/images/cleaniquelab.webp',
                        'accent'   => '#0057FF',
                        'bg'       => '#F5F7FB',
                    ],
                    [
                        'name'     => 'Cleanique Mart',
                        'tagline'  => 'Kemitraan Toko Kebersihan Modern',
                        'initials' => 'CM',
                        'logo'     => get_template_directory_uri() . '/assets/images/cleaniquemart.webp',
                        'accent'   => '#0057FF',
                        'bg'       => '#EEF3FF',
                    ],
                    [
                        'name'     => 'Depo Cleanique',
                        'tagline'  => 'Depot Sabun Isi Ulang',
                        'initials' => 'DC',
                        'logo'     => get_template_directory_uri() . '/assets/images/depocleanique.webp',
                        'accent'   => '#0057FF',
                        'bg'       => '#F5F7FB',
                    ],
                    [
                        'name'     => 'Malabeez',
                        'tagline'  => 'Parfum Interior & Linen Premium',
                        'initials' => 'MB',
                        'logo'     => get_template_directory_uri() . '/assets/images/malabeez.png',
                        'accent'   => '#111827',
                        'bg'       => '#F5F7FB',
                    ],
                    [
                        'name'     => 'Orchid Care',
                        'tagline'  => 'Pembersih & Pewangi Laundry',
                        'initials' => 'OC',
                        'logo'     => get_template_directory_uri() . '/assets/images/orchidcare.png',
                        'accent'   => '#0057FF',
                        'bg'       => '#EEF3FF',
                    ],
                    [
                        'name'     => 'Prokopi',
                        'tagline'  => 'Pembersih Mesin Kopi Espresso',
                        'initials' => 'PK',
                        'logo'     => get_template_directory_uri() . '/assets/images/prokopi-lurus.png',
                        'accent'   => '#0057FF',
                        'bg'       => '#F5F7FB',
                    ],
                ];

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
                        $post_title = get_the_title();
                        $b = null;
                        foreach ($brands_static as $item) {
                            if (strcasecmp($item['name'], $post_title) === 0) {
                                $b = $item;
                                break;
                            }
                        }
                        if (!$b) {
                            $i = $brand_query->current_post;
                            $b = $brands_static[$i] ?? $brands_static[0];
                        }
                        $tl = carbon_get_post_meta(get_the_ID(), 'brand_tagline') ?: $b['tagline'];
                ?>

                <div class="brand-card" style="--ba: <?php echo esc_attr($b['accent']); ?>">

                    <div class="brand-card-top">
                        <!-- Rounded-square logo area -->
                        <div class="brand-icon-wrap" style="background: <?php echo esc_attr($b['bg']); ?>; color: <?php echo esc_attr($b['accent']); ?>">
                            <?php 
                            $local_logo = indotech_get_brand_logo_url(get_the_title());
                            if (has_post_thumbnail()) : 
                                the_post_thumbnail('large', ['class' => 'brand-thumb-img']);
                            elseif (!empty($local_logo)) : ?>
                                <img src="<?php echo esc_url($local_logo); ?>" alt="<?php echo esc_attr(get_the_title()); ?> logo" class="brand-thumb-img" loading="lazy">
                            <?php elseif (!empty($b['logo'])) : ?>
                                <img src="<?php echo esc_url($b['logo']); ?>" alt="<?php echo esc_attr($b['name']); ?> logo" class="brand-thumb-img" loading="lazy">
                            <?php else : 
                                echo esc_html($b['initials']); 
                            endif; 
                            ?>
                        </div>
                    </div>

                    <div class="brand-card-body">
                        <h3 class="brand-name"><?php the_title(); ?></h3>
                        <span class="brand-tagline"><?php echo esc_html($tl); ?></span>
                        <p class="brand-desc"><?php the_excerpt(); ?></p>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="brand-cta">
                        Lihat Produk &rarr;
                    </a>
                </div>

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
echo '</main>';
get_footer();
