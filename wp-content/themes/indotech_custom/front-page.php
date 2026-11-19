<?php
/** Company profile homepage. */

get_header();

$media = get_theme_file_uri( 'assets/images/company-profile' );
$contact_url = home_url( '/kontak/#form-kontak' );
$solutions = [
    [
        'title' => 'Pasokan & distribusi',
        'copy'  => 'Produk homecare, bahan kimia laundry, pewangi, dan car care untuk pengadaan, grosir, dan penjualan kembali.',
        'label' => 'Lihat katalog produk',
        'url'   => home_url( '/produk/' ),
    ],
    [
        'title' => 'Maklon & formulasi',
        'copy'  => 'Pengembangan dan produksi sabun serta produk pembersih dengan merek Anda melalui Cleanique Lab.',
        'label' => 'Pelajari layanan maklon',
        'url'   => 'https://cleaniquelab.com/',
    ],
    [
        'title' => 'Kemitraan usaha',
        'copy'  => 'Program untuk distributor, agen, dan reseller, termasuk kemitraan toko kebersihan serta depo isi ulang.',
        'label' => 'Lihat program kemitraan',
        'url'   => home_url( '/kemitraan/' ),
    ],
    [
        'title' => 'Pelatihan & edukasi',
        'copy'  => 'Pelatihan pembuatan produk kebersihan dan pengembangan usaha bersama Cleanique Academy.',
        'label' => 'Lihat program pelatihan',
        'url'   => 'https://cleaniqueacademy.com/',
    ],
];
?>

<main id="main-content" class="company-home" tabindex="-1">
    <section class="company-hero company-wrap" aria-labelledby="company-title">
        <div class="company-hero-intro">
            <h1 id="company-title">Solusi kebersihan<br class="company-title-break"> <span>untuk bisnis.</span></h1>
            <div class="company-hero-summary">
                <p>PT Indotech Berkah Abadi menyediakan pasokan produk, maklon, kemitraan distribusi, dan pelatihan.</p>
                <a class="company-button" href="<?php echo esc_url( $contact_url ); ?>">
                    Diskusikan Kebutuhan B2B
                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                </a>
            </div>
        </div>

        <div class="company-hero-media">
            <div class="company-hero-products">
                <img src="<?php echo esc_url( $media . '/laundry-souring.webp' ); ?>" width="218" height="510" alt="Souring untuk laundry" decoding="async">
                <img src="<?php echo esc_url( $media . '/sabun-cuci-piring.webp' ); ?>" width="329" height="620" alt="Sabun cuci piring kemasan 5 liter" fetchpriority="high" decoding="async">
                <img src="<?php echo esc_url( $media . '/pembersih-lantai.webp' ); ?>" width="218" height="510" alt="Pembersih lantai Pelmos" decoding="async">
            </div>
            <a class="company-image-link" href="<?php echo esc_url( home_url( '/produk/' ) ); ?>">
                <span><strong>Produk kebersihan</strong>Lihat katalog Indotech</span>
                <span class="company-arrow-box"><?php get_template_part( 'template-parts/home/company-arrow' ); ?></span>
            </a>
        </div>
    </section>

    <section class="company-intro company-wrap" aria-labelledby="company-profile-title">
        <div class="company-intro-copy">
            <h2 id="company-profile-title">Kenali Indotech.</h2>
            <p>Berbasis di Sleman, Yogyakarta, PT Indotech Berkah Abadi mengembangkan dan memasok produk kebersihan, laundry, serta pewangi. Ekosistem kami melayani kebutuhan pelaku usaha, distributor, dan institusi.</p>
            <a class="company-text-link" href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>">
                Baca profil perusahaan
                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
            </a>
        </div>
        <figure class="company-profile-poster">
            <img src="<?php echo esc_url( $media . '/ilustrasi-formulasi.webp' ); ?>" width="960" height="540" alt="" loading="lazy" decoding="async">
            <figcaption>Ilustrasi formulasi dari publikasi Indotech</figcaption>
        </figure>
    </section>

    <section class="company-solutions company-wrap" id="solusi-b2b" aria-labelledby="company-solutions-title">
        <div class="company-solutions-grid">
            <div>
                <h2 id="company-solutions-title">Apa kebutuhan bisnis Anda?</h2>
                <p>Dari pengadaan produk hingga pengembangan merek dan usaha, temukan jalur yang sesuai.</p>
            </div>
            <ul class="company-solution-list">
                <?php foreach ( $solutions as $solution ) : ?>
                    <li class="company-solution">
                        <h3><?php echo esc_html( $solution['title'] ); ?></h3>
                        <p><?php echo esc_html( $solution['copy'] ); ?></p>
                        <a class="company-text-link" href="<?php echo esc_url( $solution['url'] ); ?>">
                            <?php echo esc_html( $solution['label'] ); ?>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php get_template_part( 'template-parts/home/company-brands' ); ?>
    <?php get_template_part( 'template-parts/home/company-partners' ); ?>
    <?php get_template_part( 'template-parts/home/company-insights' ); ?>

    <section class="company-wrap company-contact" aria-labelledby="company-contact-title">
        <div class="company-contact-panel">
            <picture>
                <source media="(max-width: 640px)" srcset="<?php echo esc_url( $media . '/hero-mobile.webp' ); ?>">
                <img src="<?php echo esc_url( $media . '/hero-1024.webp' ); ?>" width="1024" height="683" alt="" loading="lazy" decoding="async">
            </picture>
            <div>
                <h2 id="company-contact-title">Mari bahas kebutuhan Anda.</h2>
                <p>Ceritakan kebutuhan pengadaan, maklon, kemitraan, atau pelatihan kepada tim Indotech.</p>
                <a class="company-button" href="<?php echo esc_url( $contact_url ); ?>">
                    Diskusikan Kebutuhan B2B
                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
