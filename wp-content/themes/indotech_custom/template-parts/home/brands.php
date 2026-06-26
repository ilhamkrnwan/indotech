<?php
/**
 * Brand Section — "Empat Brand, Satu Ekosistem"
 *
 * Layout: 4-kolom grid dengan kartu bersudut tumpul.
 * Setiap kartu memiliki:
 *   - Rounded-square logo area (placeholder jika logo belum ada)
 *   - Pill-shaped category badge
 *   - Nama, tagline, deskripsi
 *   - CTA teks "Lihat Produk →"
 */

$brands = [
    [
        'name'     => 'Cleanique Academy',
        'tagline'  => 'Pelatihan & Edukasi Laundry',
        'desc'     => 'Program edukasi dan pelatihan profesional pembuatan produk kebersihan bagi pemula dan pelaku usaha laundry.',
        'initials' => 'CA',
        'logo'     => get_template_directory_uri() . '/assets/images/cleaniqueacademy.webp',
        'accent'   => '#0057FF',
        'bg'       => '#EEF3FF',
        'tag'      => 'Edukasi & Pelatihan',
        'url'      => '#',
    ],
    [
        'name'     => 'Cleanique Lab',
        'tagline'  => 'Produsen Bahan Kimia Laundry',
        'desc'     => 'Bahan kimia laundry dan produk kebersihan rumah tangga bersertifikasi resmi dan halal.',
        'initials' => 'CL',
        'logo'     => get_template_directory_uri() . '/assets/images/cleaniquelab.webp',
        'accent'   => '#0057FF',
        'bg'       => '#F5F7FB',
        'tag'      => 'Manufaktur & Lab',
        'url'      => '#',
    ],
    [
        'name'     => 'Cleanique Mart',
        'tagline'  => 'Kemitraan Toko Kebersihan Modern',
        'desc'     => 'Konsep toko produk kebersihan lengkap dan ramah lingkungan dengan kemitraan terintegrasi.',
        'initials' => 'CM',
        'logo'     => get_template_directory_uri() . '/assets/images/cleaniquemart.webp',
        'accent'   => '#0057FF',
        'bg'       => '#EEF3FF',
        'tag'      => 'Kemitraan Toko',
        'url'      => '#',
    ],
    [
        'name'     => 'Depo Cleanique',
        'tagline'  => 'Depot Sabun Isi Ulang',
        'desc'     => 'Solusi depo pengisian ulang sabun laundry dan rumah tangga untuk mengurangi sampah plastik.',
        'initials' => 'DC',
        'logo'     => get_template_directory_uri() . '/assets/images/depocleanique.webp',
        'accent'   => '#0057FF',
        'bg'       => '#F5F7FB',
        'tag'      => 'Depot Isi Ulang',
        'url'      => '#',
    ],
    [
        'name'     => 'Malabeez',
        'tagline'  => 'Parfum Interior & Linen Premium',
        'desc'     => 'Pengharum interior dan linen eksklusif dengan wewangian mewah tahan lama untuk hunian dan bisnis.',
        'initials' => 'MB',
        'logo'     => get_template_directory_uri() . '/assets/images/malabeez.png',
        'accent'   => '#111827',
        'bg'       => '#F5F7FB',
        'tag'      => 'Pengharum Premium',
        'url'      => '#',
    ],
    [
        'name'     => 'Orchid Care',
        'tagline'  => 'Pembersih & Pewangi Laundry',
        'desc'     => 'Formula pembersih dan pewangi laundry kualitas profesional untuk hasil laundry terbaik.',
        'initials' => 'OC',
        'logo'     => get_template_directory_uri() . '/assets/images/orchidcare.png',
        'accent'   => '#0057FF',
        'bg'       => '#EEF3FF',
        'tag'      => 'Chemical Laundry',
        'url'      => '#',
    ],
    [
        'name'     => 'Prokopi',
        'tagline'  => 'Pembersih Mesin Kopi Espresso',
        'desc'     => 'Pembersih khusus mesin kopi profesional berstandar food grade untuk menjaga rasa dan kebersihan.',
        'initials' => 'PK',
        'logo'     => get_template_directory_uri() . '/assets/images/prokopi.png',
        'accent'   => '#0057FF',
        'bg'       => '#F5F7FB',
        'tag'      => 'Coffee Maintenance',
        'url'      => '#',
    ],
];

/* Cek apakah ada Brand CPT yang dipublikasikan */
$brand_query = new WP_Query([
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
$use_cpt = $brand_query->have_posts();
?>

<section class="brands-section section-padding" id="brand">
    <div class="container">

        <!-- Section header -->
        <div class="section-header">
            <div class="section-tag">Brand Unggulan</div>
            <h2 class="section-title">Satu Ekosistem, <em>Berbagai Solusi</em></h2>
            <p class="section-desc">Setiap brand dirancang untuk segmen pasar spesifik dengan standar kualitas dan formulasi terbaik dari PT Indotech Berkah Abadi.</p>
        </div>

        <div class="brands-grid">

             <?php if ( $use_cpt ):
                while ( $brand_query->have_posts() ): $brand_query->the_post();
                    $post_title = get_the_title();
                    if ( strtolower( trim( $post_title ) ) === 'cokusi' ) {
                        continue;
                    }
                    $b = null;
                    foreach ( $brands as $item ) {
                        if ( strcasecmp( $item['name'], $post_title ) === 0 ) {
                            $b = $item;
                            break;
                        }
                    }
                    if ( ! $b ) {
                        $i  = $brand_query->current_post;
                        $b  = $brands[ $i ] ?? $brands[0];
                    }
                    $tl = carbon_get_post_meta( get_the_ID(), 'brand_tagline' ) ?: $b['tagline'];
            ?>

            <div class="brand-card" style="--ba: <?php echo esc_attr( $b['accent'] ); ?>">

                <div class="brand-card-top">
                    <!-- Rounded-square logo area -->
                    <div class="brand-icon-wrap" style="background: <?php echo esc_attr( $b['bg'] ); ?>; color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php 
                        $local_logo = indotech_get_brand_logo_url(get_the_title());
                        if ( has_post_thumbnail() ):
                            the_post_thumbnail( 'thumbnail', [ 'class' => 'brand-thumb-img' ] );
                        elseif ( !empty( $local_logo) ): ?>
                            <img src="<?php echo esc_url( $local_logo ); ?>"
                                 alt="<?php echo esc_attr( get_the_title() ); ?> logo"
                                 class="brand-thumb-img"
                                 loading="lazy">
                        <?php elseif ( !empty( $b['logo'] ) ): ?>
                            <img src="<?php echo esc_url( $b['logo'] ); ?>"
                                 alt="<?php echo esc_attr( $b['name'] ); ?> logo"
                                 class="brand-thumb-img"
                                 loading="lazy">
                        <?php else:
                            /* PLACEHOLDER: Tampilkan inisial brand jika logo belum di-upload */
                            echo esc_html( $b['initials'] );
                        endif; ?>
                    </div>
                </div>

                <div class="brand-card-body">
                    <h3 class="brand-name"><?php the_title(); ?></h3>
                    <span class="brand-tagline" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php echo esc_html( $tl ); ?>
                    </span>
                    <p class="brand-desc"><?php the_excerpt(); ?></p>
                </div>

                <a href="<?php the_permalink(); ?>" class="brand-cta" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                    Lihat Produk &rarr;
                </a>
            </div>

            <?php endwhile; wp_reset_postdata();
            else:
                /* Fallback: tampilkan data statis jika CPT kosong */
                foreach ( $brands as $b ):
            ?>

            <div class="brand-card" style="--ba: <?php echo esc_attr( $b['accent'] ); ?>">

                <div class="brand-card-top">
                    <!-- Rounded-square logo area -->
                    <div class="brand-icon-wrap" style="background: <?php echo esc_attr( $b['bg'] ); ?>; color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php if ( $b['logo'] ):
                            /*
                             * TODO: Render logo image ketika path sudah diisi di array $brands di atas.
                             */
                        ?>
                            <img src="<?php echo esc_url( $b['logo'] ); ?>"
                                 alt="<?php echo esc_attr( $b['name'] ); ?> logo"
                                 class="brand-thumb-img"
                                 loading="lazy">
                        <?php else: ?>
                            <!-- PLACEHOLDER: Inisial brand — ganti dengan logo resmi -->
                            <?php echo esc_html( $b['initials'] ); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="brand-card-body">
                    <h3 class="brand-name"><?php echo esc_html( $b['name'] ); ?></h3>
                    <span class="brand-tagline" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php echo esc_html( $b['tagline'] ); ?>
                    </span>
                    <p class="brand-desc"><?php echo esc_html( $b['desc'] ); ?></p>
                </div>

                <a href="<?php echo esc_url( $b['url'] ); ?>" class="brand-cta" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                    Lihat Produk &rarr;
                </a>
            </div>

            <?php endforeach; endif; ?>

        </div><!-- /brands-grid -->

    </div>
</section>
