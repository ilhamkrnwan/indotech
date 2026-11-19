<?php
/**
 * Tentang Kami, Video Profil Modal & KPI Utama — PT Indotech Berkah Abadi.
 */

$media_cp  = get_theme_file_uri( 'assets/images/company-profile' );
$media_img = get_theme_file_uri( 'assets/images' );

$video_raw      = indotech_opt( 'video_url', '' );
$video_title    = indotech_opt( 'video_title', 'Profil PT Indotech Berkah Abadi — Ekosistem Manufaktur B2B' );
$video_duration = indotech_opt( 'video_duration', '01:05' );
$video_config   = indotech_get_video_embed_config( $video_raw );

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
        'alt'      => 'Pengujian formulasi di laboratorium Indotech',
        'pAlt'     => 'Formulator senior memeriksa larutan formulasi biru cobalt di laboratorium R&D Indotech',
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
        'alt'      => 'Tim teknis memeriksa proses produksi dan kontrol kualitas',
        'pAlt'     => 'Tim quality control memeriksa proses manufaktur dan formulasi produk kebersihan',
    ],
    [
        'id'       => 'logistics',
        'label'    => 'Distribusi Nasional',
        'note'     => 'Pengiriman aman kemasan curah 5L–20L hingga karton ritel ke 34 provinsi Indonesia.',
        'img'      => $media_cp . '/cta-logistics-b2b.webp',
        'poster'   => $media_cp . '/cta-logistics-b2b.webp',
        'pWidth'   => 800,
        'pHeight'  => 600,
        'duration' => '00:52',
        'alt'      => 'Gudang distribusi kemasan jeriken industri Indotech',
        'pAlt'     => 'Gudang distribusi palet dan jeriken produk kebersihan B2B Indotech',
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

$storyboard_steps = [
    [
        'time'  => '00:00 – 00:15',
        'title' => 'Identitas & Basis Operasi Sleman',
        'copy'  => 'Berdiri sejak 2011 di Sleman, D.I. Yogyakarta, PT Indotech Berkah Abadi hadir sebagai produsen dan supplier kimia kebersihan B2B.',
    ],
    [
        'time'  => '00:15 – 00:32',
        'title' => 'R&D & Jasa Maklon Cleanique Lab',
        'copy'  => 'Pengembangan formulasi custom dan layanan private label dengan dukungan pengurusan izin edar Kemenkes RI PKRT serta Halal.',
    ],
    [
        'time'  => '00:32 – 00:48',
        'title' => 'Suplai 1.000+ SKU & Jaringan Kemitraan',
        'copy'  => 'Melayani pengadaan grosir hingga pengembangan gerai toko modern Cleanique Mart dan depo isi ulang Depo Cleanique.',
    ],
    [
        'time'  => '00:48 – 01:05',
        'title' => 'Pelatihan Formulasi Cleanique Academy',
        'copy'  => 'Membuka transfer ilmu pembuatan produk kebersihan dan pendampingan kewirausahaan bagi mitra di seluruh Indonesia.',
    ],
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

<div
    id="ch-video-modal"
    class="ch-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="ch-video-modal-title"
    data-video-type="<?php echo esc_attr( $video_config['type'] ); ?>"
    data-video-src="<?php echo esc_url( $video_config['src'] ); ?>"
    hidden
>
    <div class="ch-modal-backdrop" data-modal-close></div>
    <div class="ch-modal-dialog ch-modal-dialog--video">
        <div class="ch-modal-header">
            <h2 id="ch-video-modal-title" class="ch-modal-title"><?php echo esc_html( $video_title ); ?></h2>
            <button type="button" class="ch-modal-close" data-modal-close aria-label="Tutup pemutar video">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div class="ch-modal-body">
            <?php if ( $video_config['type'] !== 'none' ) : ?>
                <div class="ch-video-frame" id="ch-video-embed-mount"></div>
            <?php else : ?>
                <div class="ch-storyboard-preview">
                    <div class="ch-storyboard-visual">
                        <img
                            src="<?php echo esc_url( $media_cp . '/hero-manufy-stage.webp' ); ?>"
                            width="1376"
                            height="768"
                            alt="Preview fasilitas R&D dan operasional PT Indotech Berkah Abadi"
                            loading="lazy"
                        >
                        <div class="ch-storyboard-caption">
                            <span class="ch-storyboard-badge">Ringkasan Profil · <?php echo esc_html( $video_duration ); ?></span>
                            <p>Pilih babak di bawah untuk meninjau cakupan ekosistem bisnis PT Indotech Berkah Abadi.</p>
                        </div>
                    </div>

                    <div class="ch-storyboard-steps" role="tablist" aria-label="Babak video profil Indotech">
                        <?php foreach ( $storyboard_steps as $idx => $step ) : ?>
                            <button
                                type="button"
                                role="tab"
                                class="ch-storyboard-step<?php echo 0 === $idx ? ' is-active' : ''; ?>"
                                aria-selected="<?php echo 0 === $idx ? 'true' : 'false'; ?>"
                                data-storyboard-step="<?php echo (int) $idx; ?>"
                            >
                                <span class="ch-step-time"><?php echo esc_html( $step['time'] ); ?></span>
                                <strong><?php echo esc_html( $step['title'] ); ?></strong>
                                <span class="ch-step-copy"><?php echo esc_html( $step['copy'] ); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="ch-modal-footer-actions">
                <a class="ch-header-btn ch-header-btn--outline" href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>">Halaman Tentang Kami</a>
                <a class="ch-header-btn ch-header-btn--primary" href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>">Konsultasi B2B</a>
            </div>
        </div>
    </div>
</div>
