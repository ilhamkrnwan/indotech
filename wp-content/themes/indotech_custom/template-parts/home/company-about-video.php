<?php
/**
 * Tentang Kami, Video Profil Modal & KPI Utama — PT Indotech Berkah Abadi.
 */

$media_cp  = get_theme_file_uri( 'assets/images/company-profile' );
$media_img = get_theme_file_uri( 'assets/images' );

$video_duration = indotech_opt( 'video_duration', '01:05' );

$capabilities = [
    [
        'id'       => 'rnd',
        'label'    => 'R&D & Formulasi',
        'note'     => 'Riset dan pengembangan formulasi produk kebersihan dengan uji stabilitas dan mutu.',
        'img'      => $media_cp . '/ilustrasi-formulasi.webp',
        'poster'   => $media_cp . '/about-lab-video.webp',
        'pWidth'   => 800,
        'pHeight'  => 1000,
        'duration' => $video_duration,
        'alt'      => 'Meja formulasi kimia pembersih Cleanique Academy PT Indotech Berkah Abadi',
        'pAlt'     => 'Laboratorium pengujian mutu dan formulasi R&D PT Indotech Berkah Abadi',
    ],
    [
        'id'       => 'facility',
        'label'    => 'Manufaktur Terstandar',
        'note'     => 'Produksi terukur dengan pendampingan izin edar Kemenkes RI PKRT serta sertifikasi Halal.',
        'img'      => $media_cp . '/hero-manufy-stage.webp',
        'poster'   => $media_cp . '/hero-manufy-stage.webp',
        'pWidth'   => 1376,
        'pHeight'  => 768,
        'duration' => '00:48',
        'alt'      => 'Fasilitas reaktor manufaktur dan produksi kimia berstandar Kemenkes PT Indotech Berkah Abadi',
        'pAlt'     => 'Fasilitas reaktor manufaktur dan produksi kimia berstandar Kemenkes PT Indotech Berkah Abadi',
    ],
    [
        'id'       => 'logistics',
        'label'    => 'Distribusi Nasional',
        'note'     => 'Pengiriman aman kemasan curah 5L–20L hingga karton ritel ke 34 provinsi Indonesia.',
        'img'      => $media_cp . '/cta-logistics-b2b.webp',
        'poster'   => $media_cp . '/cta-logistics-b2b.webp',
        'pWidth'   => 1376,
        'pHeight'  => 768,
        'duration' => '00:52',
        'alt'      => 'Stok kemasan jeriken industri HDPE dan logistik pengiriman kargo PT Indotech Berkah Abadi',
        'pAlt'     => 'Gudang distribusi dan palet jeriken produk kebersihan B2B PT Indotech Berkah Abadi',
    ],
    [
        'id'       => 'ecosystem',
        'label'    => 'Kemitraan & Akademi',
        'note'     => 'Mendukung pertumbuhan toko Cleanique Mart, Depo Cleanique, dan pelatihan wirausaha.',
        'img'      => $media_img . '/mitra-jambi.webp',
        'poster'   => $media_img . '/mitra-jambi.webp',
        'pWidth'   => 400,
        'pHeight'  => 300,
        'duration' => '01:10',
        'alt'      => 'Gerai kemitraan toko kebersihan Cleanique Mart',
        'pAlt'     => 'Gerai toko kebersihan Cleanique Mart dalam jaringan kemitraan Indotech',
    ],
];

$kpis = [
    [ 'val' => '15', 'accent' => '+', 'label' => 'Tahun pengalaman manufaktur & pasokan sejak 2011' ],
    [ 'val' => '500', 'accent' => '+', 'label' => 'Mitra B2B, agen, toko & institusi aktif' ],
    [ 'val' => '1.000', 'accent' => '+', 'label' => 'Varian SKU homecare, laundry & pewangi' ],
    [ 'val' => '34', 'accent' => '', 'label' => 'Provinsi dijangkau jaringan logistik kami' ],
];
?>

<section class="ch-about ch-wrap" id="tentang-kami" aria-labelledby="ch-about-title">
    <div class="ch-about-header">
        <h2 id="ch-about-title" class="ch-section-h2">
            Mitra manufaktur &amp; pasokan <span>lebih dari 15 tahun</span>
        </h2>

        <div class="ch-cap-strip">
            <div class="ch-cap-thumbs" role="group" aria-label="Pilar kapabilitas Indotech">
                <?php foreach ( $capabilities as $i => $cap ) :
                    $active = ( 0 === $i );
                    ?>
                    <button
                        type="button"
                        class="ch-cap-thumb<?php echo $active ? ' is-active' : ''; ?>"
                        aria-pressed="<?php echo $active ? 'true' : 'false'; ?>"
                        aria-label="<?php echo esc_attr( $cap['label'] ); ?>"
                        data-cap-index="<?php echo (int) $i; ?>"
                        data-cap-label="<?php echo esc_attr( $cap['label'] ); ?>"
                        data-cap-note="<?php echo esc_attr( $cap['note'] ); ?>"
                        data-cap-duration="<?php echo esc_attr( $cap['duration'] ); ?>"
                    >
                        <img
                            src="<?php echo esc_url( $cap['img'] ); ?>"
                            width="92"
                            height="92"
                            alt="<?php echo esc_attr( $cap['alt'] ); ?>"
                            decoding="async"
                        >
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="ch-cap-caption">
                <strong id="ch-cap-label"><?php echo esc_html( $capabilities[0]['label'] ); ?></strong>
                <p id="ch-cap-note"><?php echo esc_html( $capabilities[0]['note'] ); ?></p>
            </div>
        </div>
    </div>

    <div class="ch-about-grid">
        <div class="ch-about-media-wrap">
            <figure class="ch-about-poster" data-about-poster>
                <div class="ch-about-slides">
                    <?php foreach ( $capabilities as $i => $cap ) :
                        $active = ( 0 === $i );
                        ?>
                        <div class="ch-about-slide<?php echo $active ? ' is-active' : ''; ?>" data-about-slide="<?php echo (int) $i; ?>">
                            <img
                                src="<?php echo esc_url( $cap['poster'] ); ?>"
                                width="<?php echo (int) $cap['pWidth']; ?>"
                                height="<?php echo (int) $cap['pHeight']; ?>"
                                alt="<?php echo esc_attr( $cap['pAlt'] ); ?>"
                                decoding="async"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="ch-poster-scrim" aria-hidden="true"></div>
                <div class="ch-poster-meta">
                    <span class="ch-poster-kicker" id="ch-poster-kicker">Video Profil · <span id="ch-poster-duration"><?php echo esc_html( $video_duration ); ?></span></span>
                    <strong class="ch-poster-label" id="ch-poster-label"><?php echo esc_html( $capabilities[0]['label'] ); ?></strong>
                </div>
                <button
                    type="button"
                    class="ch-video-play-fab"
                    data-video-open
                    aria-haspopup="dialog"
                    aria-controls="ch-video-modal"
                    aria-label="Putar video profil perusahaan PT Indotech Berkah Abadi"
                >
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="7 4 21 12 7 20 7 4"></polygon></svg>
                </button>
            </figure>
        </div>

        <div class="ch-about-content">
            <p class="ch-about-desc">
                Berbasis di Sleman, D.I. Yogyakarta, PT Indotech Berkah Abadi menyatukan riset formulasi, pabrikasi terstandar, dan jaringan distribusi untuk melayani usaha laundry, perhotelan, toko kebersihan, hingga pemilik merek pribadi.
            </p>

            <div class="ch-legal-badges" aria-label="Standar legalitas produk">
                <span class="ch-legal-pill">Izin Edar Kemenkes RI (PKRT)</span>
                <span class="ch-legal-pill">Sertifikasi Halal</span>
            </div>

            <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>">
                <span>Pelajari profil perusahaan</span>
                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
            </a>

            <dl class="ch-kpi-grid">
                <?php foreach ( $kpis as $kpi ) : ?>
                    <div class="ch-kpi-item">
                        <dt class="ch-kpi-label"><?php echo esc_html( $kpi['label'] ); ?></dt>
                        <dd class="ch-kpi-value" data-kpi-target="<?php echo esc_attr( $kpi['val'] ); ?>">
                            <?php echo esc_html( $kpi['val'] ); ?><?php if ( $kpi['accent'] !== '' ) : ?><span><?php echo esc_html( $kpi['accent'] ); ?></span><?php endif; ?>
                        </dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>

<?php get_template_part( 'template-parts/home/company-video-modal' ); ?>
