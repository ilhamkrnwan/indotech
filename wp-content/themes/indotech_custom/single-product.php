<?php
/**
 * Template Name: Single Product
 * Template Post Type: product
 *
 * Halaman Detail Produk B2B — Arsitektur Manufy Daylight.
 * Mempertahankan schema Product JSON-LD, galeri + lightbox, spesifikasi Carbon Fields, & inquiry-ajax.js form.
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
            $product_id     = get_the_ID();
            $sku            = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $product_id, 'product_sku' ) : '';
            $brand_relation = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $product_id, 'product_brand' ) : [];
            $downloads      = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $product_id, 'product_downloads' ) : [];
            $specs          = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $product_id, 'product_specifications' ) : [];

            $brand_id    = 0;
            $brand_title = '';
            $brand_url   = '#';
            if ( ! empty( $brand_relation ) && isset( $brand_relation[0]['id'] ) ) {
                $brand_id    = $brand_relation[0]['id'];
                $brand_title = get_the_title( $brand_id );
                $brand_url   = get_permalink( $brand_id );
            }

            $product_terms    = get_the_terms( $product_id, 'product_cat' );
            $product_category = ( ! empty( $product_terms ) && ! is_wp_error( $product_terms ) ) ? $product_terms[0]->name : '';
            $product_image    = get_the_post_thumbnail_url( $product_id, 'large' );

            $product_schema = [
                '@context'     => 'https://schema.org',
                '@type'        => 'Product',
                'name'         => wp_strip_all_tags( get_the_title() ),
                'description'  => wp_strip_all_tags( get_the_excerpt() ),
                'url'          => get_permalink(),
                'manufacturer' => [ '@id' => home_url( '/#organization' ) ],
            ];
            if ( $sku ) {
                $product_schema['sku'] = $sku;
            }
            if ( $product_image ) {
                $product_schema['image'] = $product_image;
            }
            if ( $brand_title ) {
                $product_schema['brand'] = [ '@type' => 'Brand', 'name' => $brand_title ];
            }
            if ( $product_category ) {
                $product_schema['category'] = $product_category;
            }
            if ( function_exists( 'indotech_print_jsonld' ) ) {
                indotech_print_jsonld( $product_schema );
            }
            ?>

            <section class="cs-hero cs-hero--compact ch-wrap" aria-labelledby="cs-product-title">
                <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/produk/' ) ); ?>">Produk</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?php the_title(); ?></span>
                </nav>

                <div class="cs-product-headline-row">
                    <div>
                        <?php if ( $brand_id ) : ?>
                            <a href="<?php echo esc_url( $brand_url ); ?>" class="cs-pill-tag" style="margin-bottom: 12px;">
                                <?php echo esc_html( $brand_title ); ?>
                            </a>
                        <?php elseif ( $product_category ) : ?>
                            <span class="cs-pill-tag" style="margin-bottom: 12px;"><?php echo esc_html( $product_category ); ?></span>
                        <?php endif; ?>
                        <h1 id="cs-product-title" class="cs-single-h1"><?php the_title(); ?></h1>
                    </div>

                    <div class="cs-share-icons" aria-label="Bagikan produk">
                        <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Bagikan via WhatsApp">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Bagikan via LinkedIn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.262-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <button type="button" id="copy-product-link" class="share-btn" aria-label="Salin Tautan Produk">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                    </div>
                </div>

                <div class="cs-product-layout">
                    <div>
                        <div class="product-main-image-wrap">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large', [ 'fetchpriority' => 'high', 'decoding' => 'async' ] ); ?>
                            <?php else : ?>
                                <span class="cs-item-placeholder"><?php echo esc_html( $brand_title ?: 'Produk Indotech' ); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php
                        $prod_gallery = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $product_id, 'product_gallery' ) : [];
                        $all_images   = [];
                        $featured_url = get_the_post_thumbnail_url( $product_id, 'large' );
                        if ( $featured_url ) {
                            $all_images[] = $featured_url;
                        }
                        if ( ! empty( $prod_gallery ) ) {
                            foreach ( $prod_gallery as $img_id ) {
                                $g_url = wp_get_attachment_image_url( $img_id, 'large' );
                                if ( $g_url && ! in_array( $g_url, $all_images, true ) ) {
                                    $all_images[] = $g_url;
                                }
                            }
                        }
                        if ( count( $all_images ) > 1 ) :
                            ?>
                            <div class="product-thumbnails-grid">
                                <?php foreach ( $all_images as $idx => $img_url ) : ?>
                                    <button type="button" class="product-thumb-item <?php echo $idx === 0 ? 'active' : ''; ?>" data-index="<?php echo (int) $idx; ?>" aria-label="Pilih gambar <?php echo (int) ( $idx + 1 ); ?>">
                                        <img src="<?php echo esc_url( $img_url ); ?>" alt="Galeri <?php echo (int) ( $idx + 1 ); ?>">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <script id="product-gallery-data" type="application/json"><?php echo wp_json_encode( $all_images ); ?></script>

                        <div class="cs-product-section">
                            <h2>Deskripsi &amp; Kegunaan Produk</h2>
                            <div class="product-description">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php if ( ! empty( $specs ) ) : ?>
                            <div class="cs-product-section">
                                <h2>Spesifikasi Teknis</h2>
                                <table class="cs-specs-table">
                                    <tbody>
                                        <?php
                                        foreach ( $specs as $spec ) :
                                            if ( empty( $spec['spec_name'] ) ) {
                                                continue;
                                            }
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo esc_html( $spec['spec_name'] ); ?></th>
                                                <td><?php echo esc_html( $spec['spec_value'] ); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $downloads ) ) : ?>
                            <div class="cs-product-section">
                                <h2>Brosur &amp; Dokumen Teknis</h2>
                                <div class="cs-doc-list">
                                    <?php
                                    foreach ( $downloads as $dl ) :
                                        $dl_id    = $dl['id'];
                                        $dl_url   = wp_get_attachment_url( $dl_id );
                                        $dl_title = get_the_title( $dl_id );
                                        $is_gated = function_exists( 'carbon_get_post_meta' ) && carbon_get_post_meta( $dl_id, 'download_gate_active' ) === 'yes';
                                        ?>
                                        <div class="cs-doc-row">
                                            <div class="cs-doc-row-info">
                                                <div class="pdf-icon-wrapper" aria-hidden="true">PDF</div>
                                                <div>
                                                    <span class="cs-doc-row-title"><?php echo esc_html( $dl_title ); ?></span>
                                                    <?php if ( $is_gated ) : ?>
                                                        <span class="cs-dl-status">Wajib Isi Form Prospek</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <a href="<?php echo esc_url( $dl_url ); ?>" <?php echo ! $is_gated ? 'download' : ''; ?> class="cs-dl-btn cs-dl-btn--outline" style="flex: 0 0 auto;">
                                                Unduh File
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="cs-inquiry-panel" aria-label="Formulir permintaan produk">
                        <h2>Tanya Detail Produk</h2>
                        <p>Pilih spesifikasi ukuran atau varian yang diinginkan untuk terhubung langsung dengan tim B2B kami via WhatsApp.</p>

                        <form id="indotech-inquiry-form" method="POST" class="cs-form">
                            <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
                            <input type="hidden" name="product_title" value="<?php echo esc_attr( get_the_title( $product_id ) ); ?>">
                            <input type="hidden" name="whatsapp_number" value="6287885590088">
                            <input type="text" name="website_url" value="" style="display: none;" tabindex="-1" autocomplete="off">

                            <div class="cs-form-group">
                                <label class="cs-form-label" for="prod-full-name">Nama Lengkap <span class="form-required">*</span></label>
                                <input id="prod-full-name" type="text" name="full_name" class="cs-form-input" placeholder="Masukkan nama Anda" required>
                            </div>

                            <?php
                            $sizes       = [];
                            $aromas      = [];
                            $aroma_label = 'Pilih Varian';
                            if ( is_array( $specs ) ) {
                                foreach ( $specs as $spec ) {
                                    if ( empty( $spec['spec_name'] ) ) {
                                        continue;
                                    }
                                    $name_lower = strtolower( trim( $spec['spec_name'] ) );
                                    if ( $name_lower === 'ukuran tersedia' || $name_lower === 'ukuran' ) {
                                        $sizes = array_map( 'trim', explode( ',', $spec['spec_value'] ) );
                                    } elseif ( $name_lower === 'aroma tersedia' || $name_lower === 'aroma' || $name_lower === 'varian' || $name_lower === 'varian tersedia' ) {
                                        $aromas = array_map( 'trim', explode( ',', $spec['spec_value'] ) );
                                    }
                                }
                            }
                            ?>

                            <?php if ( ! empty( $sizes ) ) : ?>
                                <div class="cs-form-group">
                                    <span class="cs-form-label">Pilih Ukuran <span class="form-required">*</span></span>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        <?php foreach ( $sizes as $idx => $size ) : ?>
                                            <label class="badge-radio-label">
                                                <input type="radio" name="product_size" value="<?php echo esc_attr( $size ); ?>" <?php echo $idx === 0 ? 'checked' : ''; ?>>
                                                <span class="badge-radio-span"><?php echo esc_html( $size ); ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $aromas ) ) : ?>
                                <div class="cs-form-group">
                                    <span class="cs-form-label"><?php echo esc_html( $aroma_label ); ?> <span class="form-required">*</span></span>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        <?php foreach ( $aromas as $idx => $aroma ) : ?>
                                            <label class="badge-radio-label">
                                                <input type="radio" name="product_aroma" data-label="<?php echo esc_attr( $aroma_label ); ?>" value="<?php echo esc_attr( $aroma ); ?>" <?php echo $idx === 0 ? 'checked' : ''; ?>>
                                                <span class="badge-radio-span"><?php echo esc_html( $aroma ); ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="cs-form-group">
                                <label class="cs-form-label" for="prod-address">Alamat Lengkap <span class="form-required">*</span></label>
                                <textarea id="prod-address" name="address" class="cs-form-input cs-form-textarea" placeholder="Tuliskan kota/alamat pengiriman lengkap Anda..." rows="3" required></textarea>
                            </div>

                            <button type="submit" class="ch-pill-cta cs-form-submit">
                                <span>Tanya via WhatsApp</span>
                                <span class="ch-pill-cta-icon" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </button>
                        </form>

                        <div id="indotech-inquiry-response" class="form-response" style="display: none; margin-top: 14px;"></div>
                    </aside>
                </div>
            </section>

            <?php
            $terms    = get_the_terms( $product_id, 'product_cat' );
            $term_ids = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'term_id' ) : [];
            $related_posts = [];

            if ( ! empty( $term_ids ) ) {
                $related_query = new WP_Query( [
                    'post_type'      => 'product',
                    'posts_per_page' => 3,
                    'post__not_in'   => [ $product_id ],
                    'post_status'    => 'publish',
                    'tax_query'      => [
                        [
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $term_ids,
                        ],
                    ],
                ] );
                if ( $related_query->have_posts() ) {
                    $related_posts = $related_query->posts;
                }
            }

            if ( count( $related_posts ) < 3 ) {
                $exclude_ids    = array_merge( [ $product_id ], wp_list_pluck( $related_posts, 'ID' ) );
                $fallback_query = new WP_Query( [
                    'post_type'      => 'product',
                    'posts_per_page' => 3 - count( $related_posts ),
                    'post__not_in'   => $exclude_ids,
                    'post_status'    => 'publish',
                ] );
                if ( $fallback_query->have_posts() ) {
                    $related_posts = array_merge( $related_posts, $fallback_query->posts );
                }
            }
            ?>

            <?php if ( ! empty( $related_posts ) ) : ?>
                <section class="cs-band ch-wrap" aria-labelledby="cs-related-products-title">
                    <header class="ch-section-head">
                        <div>
                            <span class="cs-pill-tag">Rekomendasi</span>
                            <h2 id="cs-related-products-title" class="ch-section-h2 ch-section-h2--sm">Produk <span>Serupa</span></h2>
                        </div>
                        <a href="<?php echo esc_url( home_url( '/produk/' ) ); ?>" class="ch-inline-link">
                            <span>Semua produk</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </header>

                    <div class="cs-editorial-grid">
                        <?php
                        foreach ( $related_posts as $rp_post ) :
                            $rp_id          = $rp_post->ID;
                            $rp_brand       = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $rp_id, 'product_brand' ) : [];
                            $brand_fallback = ( ! empty( $rp_brand ) && isset( $rp_brand[0]['id'] ) ) ? get_the_title( $rp_brand[0]['id'] ) : 'Indotech';
                            $img_html       = has_post_thumbnail( $rp_id )
                                ? get_the_post_thumbnail( $rp_id, 'indotech-thumb', [ 'loading' => 'lazy', 'decoding' => 'async' ] )
                                : '';
                            $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $rp_id ) ), 14, '...' );
                            get_template_part( 'template-parts/archive/editorial-item', null, [
                                'url'            => get_permalink( $rp_id ),
                                'title'          => get_the_title( $rp_id ),
                                'desc'           => $desc,
                                'image_html'     => $img_html,
                                'fallback_label' => $brand_fallback,
                                'media_variant'  => 'product',
                                'heading_tag'    => 'h3',
                                'post_id'        => $rp_id,
                            ] );
                        endforeach;
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php get_template_part( 'template-parts/home/company-cta' ); ?>

        <?php endwhile; ?>
    </div>
</main>

<div id="gallery-lightbox" class="gallery-lightbox" role="dialog" aria-modal="true" aria-label="Tampilan Produk">
    <button type="button" class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button type="button" class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Tampilan Produk">
    </div>
    <button type="button" class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesEl = document.getElementById('product-gallery-data');
    if (imagesEl) {
        const images       = JSON.parse(imagesEl.textContent || '[]');
        let currentIndex   = 0;
        const mainImgWrap  = document.querySelector('.product-main-image-wrap');
        const mainImg      = mainImgWrap ? mainImgWrap.querySelector('img') : null;
        const thumbs       = document.querySelectorAll('.product-thumb-item');
        const lightbox     = document.getElementById('gallery-lightbox');
        const lightboxImg  = document.getElementById('lightbox-img');
        const lbClose      = lightbox ? lightbox.querySelector('.lightbox-close') : null;
        const lbPrev       = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
        const lbNext       = lightbox ? lightbox.querySelector('.lightbox-next') : null;
        const lbCurrent    = document.getElementById('lightbox-current');
        const lbTotal      = document.getElementById('lightbox-total');

        if (images.length) {
            if (lbTotal) lbTotal.textContent = images.length;
            if (images.length <= 1) {
                if (lbPrev) lbPrev.style.display = 'none';
                if (lbNext) lbNext.style.display = 'none';
            }

            const syncImage = () => {
                if (mainImg && images[currentIndex]) {
                    mainImg.src = images[currentIndex];
                    mainImg.removeAttribute('srcset');
                    mainImg.removeAttribute('sizes');
                }
                if (lightboxImg && images[currentIndex]) lightboxImg.src = images[currentIndex];
                if (lbCurrent) lbCurrent.textContent = currentIndex + 1;
                thumbs.forEach((t, i) => t.classList.toggle('active', i === currentIndex));
            };

            thumbs.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    currentIndex = parseInt(this.dataset.index, 10) || 0;
                    syncImage();
                });
            });

            if (mainImgWrap) {
                mainImgWrap.addEventListener('click', () => {
                    if (!lightbox) return;
                    syncImage();
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            const closeLb = () => {
                if (!lightbox) return;
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            };

            if (lbClose) lbClose.addEventListener('click', closeLb);
            if (lbPrev) lbPrev.addEventListener('click', e => {
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                syncImage();
            });
            if (lbNext) lbNext.addEventListener('click', e => {
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % images.length;
                syncImage();
            });
            if (lightbox) {
                lightbox.addEventListener('click', e => {
                    if (e.target === lightbox || e.target.classList.contains('lightbox-content')) closeLb();
                });
            }
            document.addEventListener('keydown', e => {
                if (!lightbox || !lightbox.classList.contains('active')) return;
                if (e.key === 'Escape') closeLb();
                if (images.length > 1) {
                    if (e.key === 'ArrowRight') {
                        currentIndex = (currentIndex + 1) % images.length;
                        syncImage();
                    }
                    if (e.key === 'ArrowLeft') {
                        currentIndex = (currentIndex - 1 + images.length) % images.length;
                        syncImage();
                    }
                }
            });
        }
    }

    const copyProdBtn = document.getElementById('copy-product-link');
    if (copyProdBtn) {
        copyProdBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                copyProdBtn.style.borderColor = '#10b981';
                copyProdBtn.style.color       = '#10b981';
                setTimeout(() => {
                    copyProdBtn.style.borderColor = '';
                    copyProdBtn.style.color       = '';
                }, 2000);
            }).catch(() => {});
        });
    }
});
</script>

<?php get_footer(); ?>
