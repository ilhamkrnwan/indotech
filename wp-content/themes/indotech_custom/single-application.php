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

/* Lightbox Modal Style */
.gallery-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.95);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.gallery-lightbox.active {
    opacity: 1;
    pointer-events: auto;
}
.lightbox-content {
    max-width: 85%;
    max-height: 85%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.95);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.gallery-lightbox.active .lightbox-content {
    transform: scale(1);
}
.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}
.lightbox-close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    color: var(--white);
    font-size: 40px;
    line-height: 1;
    cursor: pointer;
    opacity: 0.7;
    transition: all var(--trans);
    z-index: 2;
}
.lightbox-close:hover {
    opacity: 1;
}
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: var(--white);
    font-size: 32px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.6;
    transition: all var(--trans);
    user-select: none;
    z-index: 2;
}
.lightbox-prev:hover, .lightbox-next:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.2);
}
.lightbox-prev {
    left: 24px;
}
.lightbox-next {
    right: 24px;
}
.lightbox-counter {
    position: absolute;
    bottom: 24px;
    color: var(--white);
    font-size: 14px;
    font-weight: 600;
    opacity: 0.8;
}
@media (max-width: 767px) {
    .lightbox-prev { left: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-next { right: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-close { top: 12px; right: 12px; font-size: 32px; }
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
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="app-featured-image-wrap app-gallery-link" data-index="0" style="width: 100%; height: 380px; border-radius: 12px; overflow: hidden; margin-bottom: 32px; border: 1px solid var(--border); background: var(--surface); cursor: zoom-in; transition: border var(--trans);" onmouseover="this.style.borderColor='var(--brand-accent)';" onmouseout="this.style.borderColor='var(--border)';">
                                <?php the_post_thumbnail('large', array('style' => 'width:100%; height:100%; object-fit:cover; display:block;')); ?>
                            </div>
                        <?php endif; ?>

                        <h2 style="font-size: 22px; margin-bottom: 16px; letter-spacing: -0.02em;">Deskripsi Layanan &amp; Formula B2B</h2>
                        <div style="color: var(--text-secondary); line-height: 1.75; font-size: 15px; margin-bottom: 24px;">
                            <?php the_content(); ?>
                        </div>

                        <?php 
                        $app_gallery = carbon_get_post_meta($application_id, 'app_gallery');
                        if (!empty($app_gallery)) : 
                            $all_app_images = [];
                            if (has_post_thumbnail()) {
                                $all_app_images[] = get_the_post_thumbnail_url($application_id, 'large');
                            }
                            foreach ($app_gallery as $img_id) {
                                $img_url = wp_get_attachment_image_url($img_id, 'large');
                                if ($img_url && !in_array($img_url, $all_app_images)) {
                                    $all_app_images[] = $img_url;
                                }
                            }
                        ?>
                            <script id="app-gallery-data" type="application/json">
                                <?php echo json_encode($all_app_images); ?>
                            </script>

                            <div class="app-gallery-block" style="margin-top: 40px; border-top: 1px solid var(--border); padding-top: 32px;">
                                <h3 style="font-size: 18px; margin-bottom: 20px; font-weight: 700; color: var(--ink);">Galeri Visual &amp; Dokumentasi Sektor</h3>
                                <div class="app-gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 16px;">
                                    <?php 
                                    $idx = has_post_thumbnail() ? 1 : 0;
                                    foreach ($app_gallery as $img_id) : 
                                        $img_url = wp_get_attachment_image_url($img_id, 'large');
                                        $thumb_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                        if ($img_url) :
                                    ?>
                                        <div class="app-gallery-item" style="border-radius: 8px; overflow: hidden; border: 1px solid var(--border); height: 110px; cursor: pointer; transition: all var(--trans); background: var(--surface);" onmouseover="this.style.borderColor='var(--brand-accent)'; this.style.transform='scale(1.02)';" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='scale(1)';">
                                            <a href="<?php echo esc_url($img_url); ?>" class="app-gallery-link" data-index="<?php echo $idx; ?>" style="display:block; width:100%; height:100%;">
                                                <img src="<?php echo esc_url($thumb_url); ?>" alt="Gallery Image" style="width: 100%; height: 100%; object-fit: cover; display:block;">
                                            </a>
                                        </div>
                                    <?php 
                                            $idx++;
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if (has_post_thumbnail()) : ?>
                                <script id="app-gallery-data" type="application/json">
                                    <?php echo json_encode([get_the_post_thumbnail_url($application_id, 'large')]); ?>
                                </script>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>          </div>

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
?>

<!-- Lightbox Modal -->
<div id="gallery-lightbox" class="gallery-lightbox">
    <button class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Galeri Aplikasi">
    </div>
    <button class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesEl = document.getElementById('app-gallery-data');
    if (!imagesEl) return;
    
    const images = JSON.parse(imagesEl.textContent);
    if (!images || !images.length) return;

    let currentIndex = 0;

    // Lightbox Modal selectors
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;
    const lightboxPrev = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
    const lightboxNext = lightbox ? lightbox.querySelector('.lightbox-next') : null;
    const lightboxCurrent = document.getElementById('lightbox-current');
    const lightboxTotal = document.getElementById('lightbox-total');

    if (lightboxTotal) {
        lightboxTotal.textContent = images.length;
    }

    function updateLightboxImage() {
        if (lightboxImg) {
            lightboxImg.src = images[currentIndex];
        }
        if (lightboxCurrent) {
            lightboxCurrent.textContent = currentIndex + 1;
        }
    }

    function openLightbox(index) {
        if (!lightbox) return;
        currentIndex = index;
        updateLightboxImage();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightboxImage();
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightboxImage();
    }

    // Attach click events to gallery links
    const galleryLinks = document.querySelectorAll('.app-gallery-link');
    galleryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const index = parseInt(this.dataset.index) || 0;
            openLightbox(index);
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            showPrev();
        });
    }
    if (lightboxNext) {
        lightboxNext.addEventListener('click', function(e) {
            e.stopPropagation();
            showNext();
        });
    }

    // Close on clicking overlay (outside content image)
    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox || !lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') showNext();
        if (e.key === 'ArrowLeft') showPrev();
    });
});
</script>

<?php
get_footer();
