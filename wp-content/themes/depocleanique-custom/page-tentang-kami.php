<?php
/**
 * Template Name: Tentang Kami
 * Template: page-tentang-kami
 */

get_header();
get_template_part( 'template-parts/layout/site-header' );
?>

<main id="main-content">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>

            <?php
            get_template_part(
                'template-parts/page-hero',
                null,
                [
                    'page_type'    => 'about',
                    'post_id'      => get_the_ID(),
                    'eyebrow'      => __( 'Tentang Depo Cleanique', 'depocleanique-custom' ),
                    'title_line_1' => __( 'Peluang Usaha yang', 'depocleanique-custom' ),
                    'title_line_2' => __( 'Tumbuh Bersama.', 'depocleanique-custom' ),
                    'description'  => __( 'Lebih dari sekadar kemitraan, kami membangun ekosistem usaha yang didukung produk berkualitas, strategi pemasaran, dan pendampingan berkelanjutan.', 'depocleanique-custom' ),
                    'button_label' => __( 'Konsultasi Kemitraan', 'depocleanique-custom' ),
                    'button_url'   => home_url( '/kontak/' ),
                    'meta_items'   => [
                        [
                            'icon'  => 'calendar_month',
                            'label' => __( 'Mulai', 'depocleanique-custom' ),
                            'value' => __( 'Sejak 2011', 'depocleanique-custom' ),
                        ],
                        [
                            'icon'  => 'verified',
                            'label' => __( 'Fokus', 'depocleanique-custom' ),
                            'value' => __( 'Produk Harian', 'depocleanique-custom' ),
                        ],
                        [
                            'icon'  => 'handshake',
                            'label' => __( 'Model', 'depocleanique-custom' ),
                            'value' => __( 'Kemitraan', 'depocleanique-custom' ),
                        ],
                    ],
                ]
            );
            ?>

            <section class="internal-page-content-section internal-page-content-section--about">
                <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
                    <article class="internal-page-content-card dc-page-content">
                        <?php the_content(); ?>
                    </article>
                </div>
            </section>

        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
