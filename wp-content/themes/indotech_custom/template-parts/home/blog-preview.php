<?php
/**
 * Blog Preview Section — "Artikel & Tips Bisnis"
 *
 * Menampilkan 3 artikel terbaru dalam grid 3-kolom.
 * Tanpa ikon sistem — teks & tipografi saja.
 * Thumbnail menggunakan placeholder bergaya jika gambar belum tersedia.
 */

$posts = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
]);

if ( ! $posts->have_posts() ) return;
?>

<section class="blog-section section-padding" id="blog">
    <div class="container">

        <!-- Header split: judul besar kiri, CTA kanan -->
        <div class="blog-section-header">
            <div class="blog-section-left">
                <div class="section-tag">Blog &amp; Insight</div>
                <h2 class="section-title">Artikel &amp; <em>Tips Bisnis</em></h2>
            </div>
            <a href="<?php echo esc_url( home_url('/blog') ); ?>" class="btn btn-outline blog-section-cta">
                Semua Artikel &rarr;
            </a>
        </div>

        <div class="blog-grid">
            <?php while ( $posts->have_posts() ): $posts->the_post(); ?>

            <article class="blog-card">

                <!-- Thumbnail -->
                <a href="<?php the_permalink(); ?>" class="blog-thumb" tabindex="-1" aria-hidden="true">
                    <?php if ( has_post_thumbnail() ): ?>
                        <?php the_post_thumbnail( 'indotech-card', [
                            'class'   => 'blog-img',
                            'loading' => 'lazy',
                            'alt'     => get_the_title(),
                        ] ); ?>
                    <?php else: ?>
                        <!--
                            PLACEHOLDER: Gambar featured post belum di-set.
                            Ganti dengan thumbnail sesungguhnya di WordPress admin:
                            Posts → Edit → Set Featured Image.
                        -->
                        <div class="blog-img-placeholder">
                            <span class="blog-placeholder-label">No Image</span>
                        </div>
                    <?php endif; ?>

                    <!-- Pill category badge -->
                    <?php
                    $cats = get_the_category();
                    if ( $cats ):
                    ?>
                    <span class="blog-category"><?php echo esc_html( $cats[0]->name ); ?></span>
                    <?php endif; ?>
                </a>

                <!-- Body -->
                <div class="blog-body">
                    <div class="blog-meta">
                        <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>">
                            <?php echo esc_html( get_the_date('d M Y') ); ?>
                        </time>
                        <span class="blog-meta-sep">&middot;</span>
                        <span><?php echo esc_html( get_the_author() ); ?></span>
                    </div>

                    <h3 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <p class="blog-excerpt"><?php the_excerpt(); ?></p>

                    <a href="<?php the_permalink(); ?>" class="blog-read-more">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>

            </article>

            <?php endwhile; wp_reset_postdata(); ?>
        </div><!-- /blog-grid -->

    </div>
</section>
