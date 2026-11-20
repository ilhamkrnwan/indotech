<?php
/**
 * Company Profile Homepage — PT Indotech Berkah Abadi.
 */

get_header();

$media       = get_theme_file_uri( 'assets/images/company-profile' );
$contact_url = home_url( '/kontak/#form-kontak' );

$hero_stages = [
    [
        'num'    => '01',
        'tab'    => 'Pasokan & Grosir',
        'title'  => 'Suplai curah & kemasan B2B dengan ribuan varian siap kirim.',
        'cta'    => 'Lihat Katalog Produk',
        'url'    => home_url( '/produk/' ),
        'img'    => $media . '/cta-logistics-b2b.webp',
        'width'  => 1376,
        'height' => 768,
        'alt'    => 'Stok kemasan jeriken industri HDPE dan logistik pengiriman kargo PT Indotech Berkah Abadi',
    ],
    [
        'num'    => '02',
        'tab'    => 'Maklon & R&D',
        'title'  => 'Formulasi R&D dan produksi private label berizin Kemenkes PKRT serta Halal.',
        'cta'    => 'Pelajari Maklon Cleanique Lab',
        'url'    => 'https://cleaniquelab.com/',
        'img'    => $media . '/hero-manufy-stage.webp',
        'width'  => 1376,
        'height' => 768,
        'alt'    => 'Fasilitas manufaktur dan reaktor pencampuran kimia modern berstandar Kemenkes PKRT PT Indotech Berkah Abadi',
    ],
    [
        'num'    => '03',
        'tab'    => 'Kemitraan Usaha',
        'title'  => 'Program agen, distributor daerah, toko modern, dan depo isi ulang.',
        'cta'    => 'Lihat Program Kemitraan',
        'url'    => home_url( '/kemitraan/' ),
        'img'    => $media . '/cta-collab-b2b.webp',
        'width'  => 1376,
        'height' => 768,
        'alt'    => 'Stasiun isi ulang modern Depo Cleanique dan kemitraan produk kebersihan PT Indotech Berkah Abadi',
    ],
    [
        'num'    => '04',
        'tab'    => 'Pelatihan Akademi',
        'title'  => 'Kelas praktik formulasi kimia pembersih dan pendampingan bisnis.',
        'cta'    => 'Lihat Program Cleanique Academy',
        'url'    => 'https://cleaniqueacademy.com/',
        'img'    => $media . '/ilustrasi-formulasi.webp',
        'width'  => 1376,
        'height' => 768,
        'alt'    => 'Meja praktik formulasi kimia pembersih Cleanique Academy PT Indotech Berkah Abadi',
    ],
];
$default_stage = $hero_stages[1];
?>

<main id="main-content" class="ch-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="ch-hero ch-wrap" aria-labelledby="ch-hero-title">
            <div class="ch-hero-head">
                <div class="ch-hero-copy">
                    <p>Solusi manufaktur, pasokan grosir, maklon merek, dan kemitraan produk kebersihan B2B yang saling terintegrasi.</p>
                    <a class="ch-pill-cta" href="<?php echo esc_url( $contact_url ); ?>">
                        <span>Konsultasi B2B</span>
                        <span class="ch-pill-cta-icon" aria-hidden="true">
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </span>
                    </a>
                </div>

                <div class="ch-hero-title-group">
                    <h1 id="ch-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Formulasi</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">PT Indotech</span>
                            <span class="ch-h1-secondary">Masa Depan</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Solusi Kebersihan &amp; Industri B2B<br>Sejak 2011</p>
                </div>
            </div>

            <div class="ch-hero-stage" data-hero-stage aria-roledescription="carousel" aria-label="Pilar Layanan B2B Indotech">
                <div class="ch-hero-slides" aria-hidden="true">
                    <?php foreach ( $hero_stages as $index => $stage ) :
                        $is_active = ( 1 === $index );
                        ?>
                        <div class="ch-hero-slide<?php echo $is_active ? ' is-active' : ''; ?>" data-hero-slide="<?php echo (int) $index; ?>">
                            <img
                                class="ch-hero-stage-img"
                                src="<?php echo esc_url( $stage['img'] ); ?>"
                                width="<?php echo (int) $stage['width']; ?>"
                                height="<?php echo (int) $stage['height']; ?>"
                                alt="<?php echo esc_attr( $stage['alt'] ); ?>"
                                <?php echo $is_active ? 'fetchpriority="high" ' : ''; ?>decoding="async"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="ch-stage-scrim" aria-hidden="true"></div>

                <div class="ch-stage-overlay">
                    <div class="ch-stage-tabs" role="tablist" aria-label="Empat Pilar Layanan B2B Indotech">
                        <?php foreach ( $hero_stages as $index => $stage ) :
                            $is_active = ( 1 === $index );
                            ?>
                            <button
                                type="button"
                                role="tab"
                                id="ch-tab-<?php echo esc_attr( $stage['num'] ); ?>"
                                class="ch-stage-tab<?php echo $is_active ? ' is-active' : ''; ?>"
                                aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                                aria-controls="ch-stage-card"
                                data-stage-index="<?php echo (int) $index; ?>"
                                data-stage-title="<?php echo esc_attr( $stage['title'] ); ?>"
                                data-stage-cta="<?php echo esc_attr( $stage['cta'] ); ?>"
                                data-stage-url="<?php echo esc_url( $stage['url'] ); ?>"
                            >
                                <span class="ch-tab-num"><?php echo esc_html( $stage['num'] ); ?></span>
                                <span class="ch-tab-label"><?php echo esc_html( $stage['tab'] ); ?></span>
                                <span class="ch-tab-progress" aria-hidden="true"></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div id="ch-stage-card" class="ch-stage-card" role="tabpanel" aria-labelledby="ch-tab-02">
                        <div class="ch-stage-card-top">
                            <p id="ch-stage-card-title" class="ch-stage-card-title"><?php echo esc_html( $default_stage['title'] ); ?></p>
                        </div>
                        <div class="ch-stage-card-bottom">
                            <a id="ch-stage-card-link" class="ch-stage-card-link" href="<?php echo esc_url( $default_stage['url'] ); ?>">
                                <span id="ch-stage-card-cta"><?php echo esc_html( $default_stage['cta'] ); ?></span>
                                <span class="ch-stage-card-arrow" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-about-video' ); ?>
    </div>

    <?php get_template_part( 'template-parts/home/company-solutions' ); ?>

    <div class="ch-canvas-band">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <?php get_template_part( 'template-parts/home/company-brands' ); ?>
        <?php get_template_part( 'template-parts/home/company-partners' ); ?>
        <?php get_template_part( 'template-parts/home/company-insights' ); ?>
        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
