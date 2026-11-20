<?php
/**
 * Template Name: Single Application
 * Template Post Type: application
 *
 * Halaman Detail Aplikasi Layanan B2B — Arsitektur Manufy Daylight.
 */

$whatsapp = function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088';
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );

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
            $application_id   = get_the_ID();
            $tagline          = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $application_id, 'app_tagline' ) : '';
            $related_products = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $application_id, 'app_related_products' ) : [];
            $app_gallery      = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $application_id, 'app_gallery' ) : [];

            $product_ids = [];
            if ( ! empty( $related_products ) ) {
                foreach ( $related_products as $item ) {
                    if ( isset( $item['id'] ) ) {
                        $product_ids[] = intval( $item['id'] );
                    }
                }
            }

            $product_query = null;
            if ( ! empty( $product_ids ) ) {
                $product_query = new WP_Query( [
                    'post_type'      => 'product',
                    'post__in'       => $product_ids,
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'post__in',
                ] );
            }
            ?>

            <section class="cs-hero cs-hero--compact ch-wrap" id="application-single-hero" aria-labelledby="cs-app-single-title">
                <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'application' ) ?: home_url( '/applications/' ) ); ?>">Aplikasi Layanan</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?php the_title(); ?></span>
                </nav>

                <span class="cs-pill-tag">Aplikasi Sektor B2B</span>
                <h1 id="cs-app-single-title" class="cs-single-h1"><?php the_title(); ?></h1>
                <?php if ( $tagline ) : ?>
                    <p class="cs-muted-note" style="max-width: 62ch; margin: 14px 0 0; line-height: 1.6;"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="cs-single-figure app-gallery-link" data-index="0">
                        <?php the_post_thumbnail( 'large', [ 'fetchpriority' => 'high', 'decoding' => 'async' ] ); ?>
                    </figure>
                <?php endif; ?>
            </section>

            <section class="cs-band cs-band--tight ch-wrap" aria-label="Deskripsi aplikasi layanan">
                <div class="cs-product-layout">
                    <div>
                        <div class="cs-product-section" style="margin-top: 0; padding-top: 0; border-top: 0;">
                            <h2>Deskripsi Layanan &amp; Formula B2B</h2>
                            <div class="product-description">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php
                        $all_app_images = [];
                        if ( has_post_thumbnail() ) {
                            $all_app_images[] = get_the_post_thumbnail_url( $application_id, 'large' );
                        }
                        if ( ! empty( $app_gallery ) ) :
                            foreach ( $app_gallery as $img_id ) {
                                $img_url = wp_get_attachment_image_url( $img_id, 'large' );
                                if ( $img_url && ! in_array( $img_url, $all_app_images, true ) ) {
                                    $all_app_images[] = $img_url;
                                }
                            }
                            ?>
                            <script id="app-gallery-data" type="application/json"><?php echo wp_json_encode( $all_app_images ); ?></script>

                            <div class="cs-product-section">
                                <h2>Dokumentasi Sektor</h2>
                                <div class="app-gallery-grid">
                                    <?php
                                    $idx = has_post_thumbnail() ? 1 : 0;
                                    foreach ( $app_gallery as $img_id ) :
                                        $img_url   = wp_get_attachment_image_url( $img_id, 'large' );
                                        $thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
                                        if ( $img_url ) :
                                            ?>
                                            <div class="app-gallery-item">
                                                <a href="<?php echo esc_url( $img_url ); ?>" class="app-gallery-link" data-index="<?php echo (int) $idx; ?>" style="display:block;width:100%;height:100%;">
                                                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="Dokumentasi sektor">
                                                </a>
                                            </div>
                                            <?php
                                            $idx++;
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <script id="app-gallery-data" type="application/json"><?php echo wp_json_encode( $all_app_images ); ?></script>
                        <?php endif; ?>
                    </div>

                    <aside>
                        <div class="cs-faq-concierge">
                            <span class="cs-pill-tag cs-pill-tag--lime">Konsultasi B2B</span>
                            <h2>Butuh Solusi Sektor Ini?</h2>
                            <p>PT Indotech Berkah Abadi menyediakan konsultasi formula kimia, sabun laundry, dan jasa maklon kustom sesuai standar operasional usaha Anda.</p>
                            <a
                                href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Halo indotech.id, saya tertarik dengan layanan formula/maklon untuk sektor ' . get_the_title() . '.' ); ?>"
                                class="ch-pill-cta"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <span>Hubungi via WhatsApp</span>
                                <span class="ch-pill-cta-icon" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                        </div>
                    </aside>
                </div>
            </section>

            <?php if ( $product_query && $product_query->have_posts() ) : ?>
                <section class="cs-band ch-wrap" aria-labelledby="cs-app-products-title">
                    <header class="ch-section-head">
                        <div>
                            <span class="cs-pill-tag">Rekomendasi SKU</span>
                            <h2 id="cs-app-products-title" class="ch-section-h2 ch-section-h2--sm">Produk <span>Pilihan</span></h2>
                        </div>
                    </header>

                    <div class="cs-editorial-grid">
                        <?php
                        while ( $product_query->have_posts() ) :
                            $product_query->the_post();
                            $p_id           = get_the_ID();
                            $brand_relation = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $p_id, 'product_brand' ) : [];
                            $brand_fallback = ( ! empty( $brand_relation ) && isset( $brand_relation[0]['id'] ) ) ? get_the_title( $brand_relation[0]['id'] ) : 'Indotech';
                            $img_html       = has_post_thumbnail()
                                ? get_the_post_thumbnail( $p_id, 'indotech-thumb', [ 'loading' => 'lazy', 'decoding' => 'async' ] )
                                : '';
                            $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 14, '...' );
                            get_template_part( 'template-parts/archive/editorial-item', null, [
                                'url'            => get_permalink( $p_id ),
                                'title'          => get_the_title( $p_id ),
                                'desc'           => $desc,
                                'image_html'     => $img_html,
                                'fallback_label' => $brand_fallback,
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

<div id="gallery-lightbox" class="gallery-lightbox" role="dialog" aria-modal="true" aria-label="Galeri Aplikasi">
    <button type="button" class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button type="button" class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Galeri Aplikasi">
    </div>
    <button type="button" class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesEl = document.getElementById('app-gallery-data');
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
    if (images.length <= 1) {
        if (lightboxPrev) lightboxPrev.style.display = 'none';
        if (lightboxNext) lightboxNext.style.display = 'none';
    }

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

    document.querySelectorAll('.app-gallery-link').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            openLb(parseInt(el.dataset.index, 10) || 0);
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
