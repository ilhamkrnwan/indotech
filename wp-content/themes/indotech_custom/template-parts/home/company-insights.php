<?php
/** Editorial links and the existing help page. */
$articles = new WP_Query( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'category__not_in'    => [ (int) get_option( 'default_category' ) ],
] );
$faq = get_page_by_path( 'faq' );
?>

<section class="company-insights" aria-labelledby="company-insights-title">
    <div class="company-wrap company-insight-grid">
        <div>
            <h2 id="company-insights-title">Wawasan & bantuan.</h2>
            <p>Ikuti artikel industri atau cari jawaban tentang produk, maklon, dan kemitraan.</p>
            <div class="company-inline-links">
                <a class="company-text-link" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Lihat semua artikel <?php get_template_part( 'template-parts/home/company-arrow' ); ?></a>
                <?php if ( $faq && $faq->post_status === 'publish' ) : ?>
                    <a class="company-text-link" href="<?php echo esc_url( get_permalink( $faq ) ); ?>">Baca FAQ <?php get_template_part( 'template-parts/home/company-arrow' ); ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php if ( $articles->have_posts() ) : ?>
            <ul class="company-article-list">
                <?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
                    <li>
                        <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
</section>
