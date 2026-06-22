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
        'name'     => 'Orchid Care',
        'tagline'  => 'Bibit Kimia Laundry & Rumahan',
        'desc'     => 'Produk bibit kimia laundry dan kebutuhan rumahan berkualitas tinggi. Formulasi terpercaya untuk usaha laundry profesional maupun rumah tangga.',
        'initials' => 'OC',
        /*
         * TODO: Ganti nilai 'logo' dengan path gambar logo Orchid Care ketika sudah tersedia.
         * Contoh: get_template_directory_uri() . '/assets/images/brands/orchid-care.png'
         * Ukuran disarankan: 112×112 px, PNG transparan.
         */
        'logo'     => null,
        'accent'   => '#0057FF',
        'bg'       => '#EEF3FF',
        'tag'      => 'Laundry & Rumahan',
        'url'      => '#',
    ],
    [
        'name'     => 'Depo Cleanique',
        'tagline'  => 'Depot Sabun & Pewangi Laundry',
        'desc'     => 'Solusi depot sabun dan pewangi laundry dengan aroma premium tahan lama. Pilihan utama usaha laundry kiloan dan hotel di seluruh Indonesia.',
        'initials' => 'DC',
        /*
         * TODO: Ganti nilai 'logo' dengan path gambar logo Depo Cleanique ketika sudah tersedia.
         * Contoh: get_template_directory_uri() . '/assets/images/brands/depo-cleanique.png'
         */
        'logo'     => null,
        'accent'   => '#0057FF',
        'bg'       => '#F5F7FB',
        'tag'      => 'Sabun & Pewangi',
        'url'      => '#',
    ],
    [
        'name'     => 'Malabeez',
        'tagline'  => 'Parfume Khusus Interior & Linen',
        'desc'     => 'Pengharum interior dan linen eksklusif dengan wewangian premium. Cocok untuk hotel, restoran, spa, dan hunian yang menginginkan aroma mewah.',
        'initials' => 'MB',
        /*
         * TODO: Ganti nilai 'logo' dengan path gambar logo Malabeez ketika sudah tersedia.
         * Contoh: get_template_directory_uri() . '/assets/images/brands/malabeez.png'
         */
        'logo'     => null,
        'accent'   => '#111827',
        'bg'       => '#F5F7FB',
        'tag'      => 'Interior & Linen',
        'url'      => '#',
    ],
    [
        'name'     => 'Cokusi',
        'tagline'  => 'Cokelat Kurma Isi',
        'desc'     => 'Produk makanan cokelat kurma isi dengan cita rasa premium. Oleh-oleh dan snack sehat berbasis kurma berkualitas pilihan untuk pasar modern.',
        'initials' => 'CK',
        /*
         * TODO: Ganti nilai 'logo' dengan path gambar logo Cokusi ketika sudah tersedia.
         * Contoh: get_template_directory_uri() . '/assets/images/brands/cokusi.png'
         */
        'logo'     => null,
        'accent'   => '#0057FF',
        'bg'       => '#EEF3FF',
        'tag'      => 'Food & Snack',
        'url'      => '#',
    ],
];

/* Cek apakah ada Brand CPT yang dipublikasikan */
$brand_query = new WP_Query([
    'post_type'      => 'brand',
    'posts_per_page' => 4,
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
            <h2 class="section-title">Empat Brand, <em>Satu Ekosistem</em></h2>
            <p class="section-desc">Setiap brand dirancang untuk segmen pasar spesifik dengan standar kualitas dan formulasi terbaik dari PT Indotech Berkah Abadi.</p>
        </div>

        <div class="brands-grid">

            <?php if ( $use_cpt ):
                while ( $brand_query->have_posts() ): $brand_query->the_post();
                    $i  = $brand_query->current_post;
                    $b  = $brands[ $i ] ?? $brands[0];
                    $tl = get_post_meta( get_the_ID(), 'tagline', true ) ?: $b['tagline'];
            ?>

            <div class="brand-card" style="--ba: <?php echo esc_attr( $b['accent'] ); ?>">

                <div class="brand-card-top">
                    <!-- Rounded-square logo area -->
                    <div class="brand-icon-wrap" style="background: <?php echo esc_attr( $b['bg'] ); ?>; color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php if ( has_post_thumbnail() ):
                            /*
                             * TODO: Pastikan ukuran thumbnail 'brand-logo' sudah terdaftar di functions.php
                             *       (misal: add_image_size('brand-logo', 112, 112, true))
                             */
                            the_post_thumbnail( 'thumbnail', [ 'class' => 'brand-thumb-img' ] );
                        else:
                            /* PLACEHOLDER: Tampilkan inisial brand jika logo belum di-upload */
                            echo esc_html( $b['initials'] );
                        endif; ?>
                    </div>

                    <!-- Pill-shaped category badge -->
                    <span class="brand-tag" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php echo esc_html( $b['tag'] ); ?>
                    </span>
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

                    <!-- Pill-shaped category badge -->
                    <span class="brand-tag" style="color: <?php echo esc_attr( $b['accent'] ); ?>">
                        <?php echo esc_html( $b['tag'] ); ?>
                    </span>
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
