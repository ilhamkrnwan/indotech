<?php
/**
 * Wawasan Industri & FAQ B2B — Mempertahankan SEO Blog + Schema FAQPage.
 */

$articles = new WP_Query( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'category__not_in'    => [ (int) get_option( 'default_category' ) ],
] );

$home_faqs = [
    [
        'q' => 'Bagaimana cara memulai kerja sama pengadaan atau kemitraan dengan Indotech?',
        'a' => 'Anda dapat mengirimkan kebutuhan melalui formulir Konsultasi B2B di halaman Kontak, halaman Kemitraan, atau langsung menghubungi tim WhatsApp Keagenan, Pelatihan, maupun Retail sesuai kebutuhan bisnis Anda.',
    ],
    [
        'q' => 'Apakah produk dari brand Indotech memiliki izin edar Kemenkes RI dan sertifikasi Halal?',
        'a' => 'Produk kebersihan rumah tangga dan laundry kami diproduksi dengan standar mutu terkendali serta didukung izin edar Kementerian Kesehatan RI (PKRT/PKD) dan sertifikasi Halal untuk SKU terkait.',
    ],
    [
        'q' => 'Bagaimana alur layanan maklon (Private Label) di Cleanique Lab?',
        'a' => 'Cleanique Lab mendampingi proses pembuatan produk dengan merek Anda sendiri, mulai dari penentuan formulasi dan sampel di laboratorium R&D, pendampingan legalitas PKRT/Halal, hingga pengemasan siap jual.',
    ],
    [
        'q' => 'Apakah PT Indotech melayani pengiriman produk curah dan karton ke luar Pulau Jawa?',
        'a' => 'Ya. Kami bekerja sama dengan jaringan kargo darat, laut, dan udara untuk melayani pengiriman aman ke ratusan mitra bisnis di 34 provinsi di seluruh Indonesia.',
    ],
    [
        'q' => 'Siapa yang dapat mengikuti pelatihan formulasi di Cleanique Academy?',
        'a' => 'Pelatihan Cleanique Academy terbuka bagi pelaku usaha pemula, pemilik usaha laundry, pengelola toko kebersihan, hingga tim teknis yang ingin mempelajari praktik formulasi dan pengelolaan bisnis.',
    ],
];

if ( function_exists( 'indotech_render_faq_schema' ) ) {
    indotech_render_faq_schema( $home_faqs );
}
?>

<section class="ch-insights ch-wrap" id="wawasan" aria-labelledby="ch-insights-title">
    <div class="ch-insights-grid">
        <div class="ch-articles-col">
            <header class="ch-articles-head">
                <h2 id="ch-insights-title" class="ch-section-h2 ch-section-h2--sm">Wawasan <span>Industri</span></h2>
                <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                    <span>Semua artikel</span>
                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                </a>
            </header>

            <?php if ( $articles->have_posts() ) : ?>
                <ul class="ch-article-list">
                    <?php while ( $articles->have_posts() ) : $articles->the_post();
                        $cats = get_the_category();
                        $cat_name = ! empty( $cats ) ? $cats[0]->name : 'Artikel';
                        ?>
                        <li>
                            <a class="ch-article-item" href="<?php the_permalink(); ?>">
                                <div class="ch-article-meta">
                                    <span class="ch-article-cat"><?php echo esc_html( $cat_name ); ?></span>
                                    <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time>
                                </div>
                                <h3><?php the_title(); ?></h3>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="ch-empty-note">Belum ada artikel industri yang dipublikasikan.</p>
            <?php endif; ?>
        </div>

        <div class="ch-faq-col" id="home-faq">
            <header class="ch-articles-head">
                <h2 class="ch-section-h2 ch-section-h2--sm">Pertanyaan <span>B2B</span></h2>
                <?php
                $faq_page = get_page_by_path( 'faq' );
                if ( $faq_page && $faq_page->post_status === 'publish' ) : ?>
                    <a class="ch-inline-link" href="<?php echo esc_url( get_permalink( $faq_page ) ); ?>">
                        <span>Halaman FAQ</span>
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </a>
                <?php endif; ?>
            </header>

            <div class="ch-faq-list">
                <?php foreach ( $home_faqs as $i => $faq ) : ?>
                    <details class="ch-faq-item" id="ch-faq-<?php echo (int) ( $i + 1 ); ?>">
                        <summary class="ch-faq-q">
                            <span><?php echo esc_html( $faq['q'] ); ?></span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p><?php echo esc_html( $faq['a'] ); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
