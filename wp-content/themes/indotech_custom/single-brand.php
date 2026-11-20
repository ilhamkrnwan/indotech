<?php
/**
 * Template Name: Single Brand
 * Template Post Type: brand
 *
 * Halaman Detail Brand Ekosistem PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 */

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <?php
        while ( have_posts() ) :
            the_post();
            $brand_id     = get_the_ID();
            $brand_title  = get_the_title();
            $tagline      = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $brand_id, 'brand_tagline' ) : '';
            $website_url  = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $brand_id, 'brand_website_url' ) : '';
            $gallery      = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $brand_id, 'brand_gallery' ) : [];
            $local_logo   = function_exists( 'indotech_get_brand_logo_url' ) ? indotech_get_brand_logo_url( $brand_title ) : '';

            global $wpdb;
            $product_ids = $wpdb->get_col( $wpdb->prepare( "
                SELECT post_id
                FROM {$wpdb->postmeta}
                WHERE (meta_key = '_product_brand' AND meta_value = %s)
                   OR (meta_key = '_product_brand|||0|id' AND meta_value = %s)
            ", 'post:brand:' . $brand_id, $brand_id ) );

            $product_query = new WP_Query( [
                'post_type'      => 'product',
                'posts_per_page' => 9,
                'post_status'    => 'publish',
                'post__in'       => ! empty( $product_ids ) ? $product_ids : [ 0 ],
            ] );

            $brand_usps = [];
            switch ( strtolower( trim( $brand_title ) ) ) {
                case 'cleanique academy':
                    $brand_usps = [
                        [ 'title' => 'Kurikulum Praktis & Teruji', 'desc' => 'Diajarkan langsung oleh praktisi berpengalaman di industri laundry komersial dengan modul terstruktur.' ],
                        [ 'title' => 'Konsultasi & Mentoring Bisnis', 'desc' => 'Setiap alumni memperoleh pendampingan pasca-pelatihan untuk memulai maupun memperluas usaha.' ],
                        [ 'title' => 'Workshop Formulasi Mandiri', 'desc' => 'Pelajari teknik meracik deterjen, softener, dan parfum laundry secara terukur serta higienis.' ],
                        [ 'title' => 'Dukungan Jaringan Nasional', 'desc' => 'Terhubung dengan komunitas pengusaha laundry dan pasokan bahan baku Indotech di 34 provinsi.' ],
                    ];
                    break;
                case 'cleanique lab':
                    $brand_usps = [
                        [ 'title' => 'Tim R&D Ahli & Berpengalaman', 'desc' => 'Pengembangan formulasi kimia didukung tenaga analis berpengalaman untuk performa bersih optimal.' ],
                        [ 'title' => 'Layanan Maklon Private Label', 'desc' => 'Solusi produksi terpadu bagi pelaku usaha yang ingin meluncurkan merek produk kebersihan sendiri.' ],
                        [ 'title' => 'Fasilitas Produksi Terukur', 'desc' => 'Diproduksi menggunakan peralatan industri terkontrol demi memastikan konsistensi mutu antar batch.' ],
                        [ 'title' => 'Legalitas & Pengujian Mutu', 'desc' => 'Didukung pendampingan izin edar Kemenkes RI (PKRT), Sertifikasi Halal, dan standar mutu laboratorium internal.' ],
                    ];
                    break;
                case 'cleanique mart':
                    $brand_usps = [
                        [ 'title' => 'One-Stop Cleaning Supplies', 'desc' => 'Menyediakan stok produk kebersihan lengkap mulai dari kimia laundry hingga perlengkapan ritel.' ],
                        [ 'title' => 'Kemitraan Toko Kebersihan Modern', 'desc' => 'Konsep gerai ritel dengan suplai stabil dari pabrik serta materi pendampingan operasional.' ],
                        [ 'title' => 'Konsep Minim Kemasan Sekali Pakai', 'desc' => 'Menghadirkan opsi pengisian ulang sabun untuk menekan biaya kemasan konsumen akhir.' ],
                        [ 'title' => 'Stabilitas Stok Pabrik', 'desc' => 'Didukung rantai pasok langsung PT Indotech Berkah Abadi demi ketersediaan barang berkelanjutan.' ],
                    ];
                    break;
                case 'depo cleanique':
                    $brand_usps = [
                        [ 'title' => 'Kualitas Stabil Langsung Pabrik', 'desc' => 'Menjaga mutu kimia pembersih dari pabrik ke depo isi ulang dengan margin usaha mitra tetap sehat.' ],
                        [ 'title' => 'Efisiensi Kemasan Ritel', 'desc' => 'Pelanggan fokus membeli isi produk sehingga pengeluaran plastik sekali pakai berkurang drastis.' ],
                        [ 'title' => 'Pendampingan Kesiapan Usaha', 'desc' => 'Mitra didampingi dari perencanaan tata letak depo hingga manajemen pasokan awal.' ],
                        [ 'title' => 'Suplai Grosir Tangan Pertama', 'desc' => 'Harga langsung produsen untuk menjangkau segmen rumah tangga maupun usaha laundry lokal.' ],
                    ];
                    break;
                case 'malabeez':
                    $brand_usps = [
                        [ 'title' => 'Karakter Aroma Khas Timur Tengah', 'desc' => 'Hadir dalam varian aroma elegan untuk sajadah, mukena, linen kamar, dan ruang ibadah.' ],
                        [ 'title' => 'Formulasi Antibakteri', 'desc' => 'Diformulasikan untuk menjaga kesegaran kain dan menghindari bau lembap pada tekstil.' ],
                        [ 'title' => 'Nyaman untuk Pemakaian Harian', 'desc' => 'Formula water-based bebas alkohol agar aman dan nyaman digunakan di area ibadah.' ],
                        [ 'title' => 'Wangi Tahan Lama di Serat', 'desc' => 'Bibit parfum pilihan yang menyatu baik pada serat kain serta bertahan lama.' ],
                    ];
                    break;
                case 'orchid care':
                    $brand_usps = [
                        [ 'title' => 'Andalan Laundry Komersial', 'desc' => 'Digunakan oleh ratusan usaha laundry kiloan maupun hotel untuk pengangkatan noda secara efektif.' ],
                        [ 'title' => 'Proteksi Serat & Warna Pakaian', 'desc' => 'Menjaga kelembutan kain serta membantu mempertahankan kecerahan warna pakaian.' ],
                        [ 'title' => 'Formula Low-Suds Efisien', 'desc' => 'Aman bagi mesin cuci front-loading dan membantu menghemat penggunaan air saat pembilasan.' ],
                        [ 'title' => 'Izin Edar Kemenkes RI & Halal', 'desc' => 'Produk terdaftar di Kemenkes RI (PKRT) serta mengantongi Sertifikasi Halal.' ],
                    ];
                    break;
                case 'prokopi':
                    $brand_usps = [
                        [ 'title' => 'Formula Food-Grade', 'desc' => 'Dirancang aman untuk perangkat penyeduh minuman dan tidak merusak komponen mesin kopi.' ],
                        [ 'title' => 'Menjaga Kemurnian Rasa Espresso', 'desc' => 'Membersihkan residu minyak kopi dan kerak pada group head agar hasil ekstraksi konsisten.' ],
                        [ 'title' => 'Pembersihan Kerak Boiler', 'desc' => 'Efektif melarutkan penumpukan mineral di jalur pemanas mesin espresso komersial.' ],
                        [ 'title' => 'Kompatibel Multi-Perangkat', 'desc' => 'Sesuai bagi mesin espresso kafe, semi-otomatis, hingga perawatan grinder kopi.' ],
                    ];
                    break;
                default:
                    $brand_usps = [
                        [ 'title' => 'Formulasi Khusus B2B', 'desc' => 'Dirancang dengan konsentrasi bahan aktif terukur untuk hasil kebersihan skala industri.' ],
                        [ 'title' => 'Performa & Aroma Terstandar', 'desc' => 'Dikembangkan bersama tim R&D PT Indotech Berkah Abadi demi kepuasan pengguna akhir.' ],
                        [ 'title' => 'Efisiensi Biaya Operasional', 'desc' => 'Skema pasokan langsung pabrik menjaga struktur biaya usaha tetap kompetitif.' ],
                        [ 'title' => 'Kepatuhan Legalitas Resmi', 'desc' => 'Didukung izin edar Kemenkes RI (PKRT) dan Sertifikasi Halal untuk varian terkait.' ],
                    ];
                    break;
            }
            ?>

            <section class="cs-hero cs-hero--compact ch-wrap" id="brand-hero" aria-labelledby="cs-brand-title">
                <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'brand' ) ?: home_url( '/brands/' ) ); ?>">Brand</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?php the_title(); ?></span>
                </nav>

                <div class="cs-brand-head">
                    <?php if ( has_post_thumbnail() || ! empty( $local_logo ) ) : ?>
                        <div class="cs-brand-logo-frame">
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large' );
                            } else {
                                echo '<img src="' . esc_url( $local_logo ) . '" alt="' . esc_attr( $brand_title ) . ' logo">';
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <div style="flex: 1 1 320px;">
                        <?php if ( $tagline ) : ?>
                            <span class="cs-pill-tag"><?php echo esc_html( $tagline ); ?></span>
                        <?php endif; ?>
                        <h1 id="cs-brand-title" class="cs-single-h1"><?php the_title(); ?></h1>
                        <?php if ( has_excerpt() ) : ?>
                            <p class="cs-muted-note" style="max-width: 60ch; margin: 12px 0 0; line-height: 1.6;"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
                        <?php endif; ?>
                        <?php if ( $website_url ) : ?>
                            <div style="margin-top: 18px;">
                                <a href="<?php echo esc_url( $website_url ); ?>" target="_blank" rel="noopener noreferrer" class="ch-pill-cta">
                                    <span>Kunjungi Website Resmi</span>
                                    <span class="ch-pill-cta-icon" aria-hidden="true">
                                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section class="cs-band cs-band--tight ch-wrap" aria-label="Informasi dan formulir brand">
                <div class="cs-product-layout">
                    <div>
                        <div class="cs-product-section" style="margin-top: 0; padding-top: 0; border-top: 0;">
                            <h2>Tentang <?php the_title(); ?></h2>
                            <div class="product-description">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php if ( ! empty( $gallery ) ) :
                            $gallery_urls = [];
                            foreach ( $gallery as $img_id ) {
                                $u = wp_get_attachment_image_url( $img_id, 'large' );
                                if ( $u ) {
                                    $gallery_urls[] = $u;
                                }
                            }
                            ?>
                            <script id="brand-gallery-data" type="application/json"><?php echo wp_json_encode( $gallery_urls ); ?></script>

                            <div class="brand-bento-gallery">
                                <?php
                                $idx = 0;
                                foreach ( $gallery as $img_id ) :
                                    $img_url = wp_get_attachment_image_url( $img_id, 'large' );
                                    if ( ! $img_url ) {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $img_url ); ?>" class="brand-bento-item brand-gallery-link" data-index="<?php echo (int) $idx; ?>">
                                        <?php echo wp_get_attachment_image( $img_id, 'large', false ); ?>
                                    </a>
                                    <?php
                                    $idx++;
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="cs-product-section">
                            <h2>Mengapa Memilih <?php the_title(); ?>?</h2>
                            <div class="cs-usp-ledger">
                                <?php foreach ( $brand_usps as $usp ) : ?>
                                    <article class="cs-usp-cell">
                                        <h3><?php echo esc_html( $usp['title'] ); ?></h3>
                                        <p><?php echo esc_html( $usp['desc'] ); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <aside>
                        <div class="cs-inquiry-panel">
                            <h2>Kemitraan &amp; Maklon</h2>
                            <p>Hubungi tim B2B kami untuk meminta katalog harga grosir maupun konsultasi kemitraan brand <strong><?php the_title(); ?></strong>.</p>

                            <?php
                            $first_product_id = $product_query->have_posts() ? $product_query->posts[0]->ID : 0;
                            if ( empty( $first_product_id ) ) {
                                $fallback_posts   = get_posts( [ 'post_type' => 'product', 'posts_per_page' => 1 ] );
                                $first_product_id = ! empty( $fallback_posts ) ? $fallback_posts[0]->ID : 0;
                            }
                            ?>
                            <form id="indotech-inquiry-form" method="POST" class="cs-form">
                                <input type="hidden" name="product_id" value="<?php echo esc_attr( $first_product_id ); ?>">
                                <input type="hidden" name="brand_title" value="<?php echo esc_attr( $brand_title ); ?>">
                                <input type="hidden" name="whatsapp_number" value="6287885590088">
                                <input type="text" name="website_url" value="" style="display: none;" tabindex="-1" autocomplete="off">

                                <div class="cs-form-group">
                                    <label class="cs-form-label" for="brand-full-name">Nama Lengkap</label>
                                    <input id="brand-full-name" type="text" name="full_name" class="cs-form-input" placeholder="Masukkan nama Anda">
                                </div>

                                <div class="cs-form-group">
                                    <label class="cs-form-label" for="brand-email">Email Bisnis</label>
                                    <input id="brand-email" type="email" name="email" class="cs-form-input" placeholder="nama@perusahaan.com">
                                </div>

                                <div class="cs-form-group">
                                    <label class="cs-form-label" for="brand-message">Pesan Kebutuhan</label>
                                    <textarea id="brand-message" name="message" rows="3" class="cs-form-input cs-form-textarea">Halo, saya tertarik untuk meminta katalog produk dan harga grosir untuk brand <?php the_title(); ?>.</textarea>
                                </div>

                                <button type="submit" class="ch-pill-cta cs-form-submit">
                                    <span>Kirim Permintaan</span>
                                    <span class="ch-pill-cta-icon" aria-hidden="true">
                                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                    </span>
                                </button>
                            </form>

                            <div id="indotech-inquiry-response" class="form-response" style="display: none; margin-top: 14px;"></div>
                        </div>

                        <div class="cs-holding-note">
                            <h2>Holding Korporat</h2>
                            <p>Diproduksi dan didistribusikan oleh PT Indotech Berkah Abadi dengan pengawasan mutu laboratorium terstandar sejak 2011.</p>
                            <div class="ch-legal-badges">
                                <span class="ch-legal-pill">Izin Edar Kemenkes RI (PKRT)</span>
                                <span class="ch-legal-pill">Sertifikasi Halal</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <?php if ( $product_query->have_posts() ) : ?>
                <section class="cs-band ch-wrap" aria-labelledby="cs-brand-products-title">
                    <header class="ch-section-head">
                        <div>
                            <span class="cs-pill-tag">Katalog Brand</span>
                            <h2 id="cs-brand-products-title" class="ch-section-h2 ch-section-h2--sm">Produk <span><?php the_title(); ?></span></h2>
                        </div>
                        <a href="<?php echo esc_url( home_url( '/produk/' ) ); ?>" class="ch-inline-link">
                            <span>Lihat semua produk</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </header>

                    <div class="cs-editorial-grid">
                        <?php
                        while ( $product_query->have_posts() ) :
                            $product_query->the_post();
                            $p_id     = get_the_ID();
                            $img_html = has_post_thumbnail()
                                ? get_the_post_thumbnail( $p_id, 'indotech-thumb', [ 'loading' => 'lazy', 'decoding' => 'async' ] )
                                : '';
                            $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 14, '...' );
                            get_template_part( 'template-parts/archive/editorial-item', null, [
                                'url'            => get_permalink( $p_id ),
                                'title'          => get_the_title( $p_id ),
                                'desc'           => $desc,
                                'image_html'     => $img_html,
                                'fallback_label' => $brand_title ?: 'Indotech',
                                'media_variant'  => 'product',
                                'heading_tag'    => 'h3',
                                'post_id'        => $p_id,
                            ] );
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php get_template_part( 'template-parts/home/company-cta' ); ?>

        <?php endwhile; ?>
    </div>
</main>

<div id="gallery-lightbox" class="gallery-lightbox" role="dialog" aria-modal="true" aria-label="Galeri Brand">
    <button type="button" class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button type="button" class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Galeri Brand">
    </div>
    <button type="button" class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesEl = document.getElementById('brand-gallery-data');
    if (!imagesEl) return;
    const images = JSON.parse(imagesEl.textContent || '[]');
    if (!images.length) return;

    let currentIndex     = 0;
    const lightbox       = document.getElementById('gallery-lightbox');
    const lightboxImg    = document.getElementById('lightbox-img');
    const lightboxClose  = lightbox ? lightbox.querySelector('.lightbox-close') : null;
    const lightboxPrev   = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
    const lightboxNext   = lightbox ? lightbox.querySelector('.lightbox-next') : null;
    const lightboxCurr   = document.getElementById('lightbox-current');
    const lightboxTotal  = document.getElementById('lightbox-total');

    if (lightboxTotal) lightboxTotal.textContent = images.length;

    const updateImg = () => {
        if (lightboxImg) lightboxImg.src = images[currentIndex];
        if (lightboxCurr) lightboxCurr.textContent = currentIndex + 1;
    };
    const openLb = idx => {
        if (!lightbox) return;
        currentIndex = idx;
        updateImg();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    const closeLb = () => {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.brand-gallery-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            openLb(parseInt(link.dataset.index, 10) || 0);
        });
    });
    if (lightboxClose) lightboxClose.addEventListener('click', closeLb);
    if (lightboxPrev) lightboxPrev.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateImg();
    });
    if (lightboxNext) lightboxNext.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateImg();
    });
    if (lightbox) {
        lightbox.addEventListener('click', e => {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) closeLb();
        });
    }
    document.addEventListener('keydown', e => {
        if (!lightbox || !lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLb();
        if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % images.length;
            updateImg();
        }
        if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateImg();
        }
    });
});
</script>

<?php get_footer(); ?>
