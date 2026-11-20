<?php
/**
 * Template Name: Single Industry
 * Template Post Type: industry
 *
 * Halaman Detail Solusi Sektor Industri — Arsitektur Manufy Daylight.
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
            $industry_id = get_the_ID();
            $tagline     = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $industry_id, 'industry_tagline' ) : '';

            global $wpdb;
            $product_ids = $wpdb->get_col( $wpdb->prepare( "
                SELECT post_id
                FROM {$wpdb->postmeta}
                WHERE (meta_key = '_product_industries' AND meta_value = %s)
                   OR (meta_key = '_product_industries|||0|id' AND meta_value = %s)
            ", 'post:industry:' . $industry_id, $industry_id ) );

            $product_query = new WP_Query( [
                'post_type'      => 'product',
                'posts_per_page' => 12,
                'post_status'    => 'publish',
                'post__in'       => ! empty( $product_ids ) ? $product_ids : [ 0 ],
            ] );
            ?>

            <section class="cs-hero cs-hero--compact ch-wrap" id="industry-single-hero" aria-labelledby="cs-industry-single-title">
                <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'industry' ) ?: home_url( '/industries/' ) ); ?>">Industri</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?php the_title(); ?></span>
                </nav>

                <span class="cs-pill-tag">Solusi Sektor Industri</span>
                <h1 id="cs-industry-single-title" class="cs-single-h1"><?php the_title(); ?></h1>
                <?php if ( $tagline ) : ?>
                    <p class="cs-muted-note" style="max-width: 62ch; margin: 14px 0 0; line-height: 1.6;"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>
            </section>

            <section class="cs-band cs-band--tight ch-wrap" aria-label="Deskripsi solusi industri">
                <div class="cs-product-layout">
                    <div>
                        <div class="cs-product-section" style="margin-top: 0; padding-top: 0; border-top: 0;">
                            <h2>Deskripsi Solusi B2B</h2>
                            <div class="product-description">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>

                    <aside>
                        <div class="cs-faq-concierge">
                            <span class="cs-pill-tag cs-pill-tag--lime">Konsultasi B2B</span>
                            <h2>Butuh Solusi Kustom?</h2>
                            <p>PT Indotech Berkah Abadi menyediakan formulasi kimia, pasokan curah, serta layanan maklon untuk spesifikasi industri Anda.</p>
                            <a href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>" class="ch-pill-cta">
                                <span>Hubungi Tim Indotech</span>
                                <span class="ch-pill-cta-icon" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                        </div>
                    </aside>
                </div>
            </section>

            <?php if ( $product_query->have_posts() ) : ?>
                <section class="cs-band ch-wrap" aria-labelledby="cs-industry-products-title">
                    <header class="ch-section-head">
                        <div>
                            <span class="cs-pill-tag">Rekomendasi SKU</span>
                            <h2 id="cs-industry-products-title" class="ch-section-h2 ch-section-h2--sm">Produk yang <span>Direkomendasikan</span></h2>
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

<?php get_footer(); ?>
