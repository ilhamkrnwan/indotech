<?php
/**
 * Template Name: Tentang Kami
 *
 * Halaman profil perusahaan PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 * Sections: Split Hero & Media Stage · Kisah & Timeline Ledger · Visi Misi & Sertifikasi (Obsidian-Navy) ·
 *           Nilai Perusahaan · Aplikasi Layanan B2B · Peta Kantor Sleman · Orbital CTA · Video Lightbox
 */

$media_cp       = get_theme_file_uri( 'assets/images/company-profile' );
$phone          = function_exists( 'indotech_opt' ) ? indotech_opt( 'phone', '+62 856-0006-1005' ) : '+62 856-0006-1005';
$email          = function_exists( 'indotech_opt' ) ? indotech_opt( 'email', 'indotechberkahabadi@gmail.com' ) : 'indotechberkahabadi@gmail.com';
$address        = function_exists( 'indotech_opt' ) ? indotech_opt( 'address', 'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285' ) : 'Jongke Tengah No. 30, Sendangadi, Mlati, Sleman, Yogyakarta 55285';
$whatsapp       = function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088';
$wa_num         = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg         = rawurlencode( 'Halo Indotech, saya ingin berkonsultasi mengenai profil perusahaan dan kerja sama B2B.' );

$video_duration = function_exists( 'indotech_opt' ) ? indotech_opt( 'video_duration', '01:05' ) : '01:05';

$timeline_rows = [
    [
        'year'  => '2011',
        'title' => 'Pendirian Perusahaan',
        'copy'  => 'PT Indotech Berkah Abadi resmi berdiri dan mulai melayani mitra distribusi di wilayah Yogyakarta dan Pulau Jawa.',
    ],
    [
        'year'  => '2014',
        'title' => 'Ekspansi Jaringan Nasional',
        'copy'  => 'Jaringan distribusi berkembang menjangkau 10 provinsi dengan penambahan lini produk kimia laundry profesional.',
    ],
    [
        'year'  => '2017',
        'title' => 'Izin Edar Kemenkes RI & Halal',
        'copy'  => 'Lini produk kebersihan utama memperoleh Izin Edar Kemenkes RI (PKRT) serta Sertifikasi Halal untuk memperkuat kepastian legalitas mitra.',
    ],
    [
        'year'  => '2020',
        'title' => 'Konsolidasi Ekosistem 7 Brand',
        'copy'  => 'Cleanique Academy, Cleanique Lab, Cleanique Mart, Depo Cleanique, Malabeez, Orchid Care, dan Prokopi hadir melayani segmen B2B terintegrasi.',
    ],
    [
        'year'  => '2024',
        'title' => '500+ Mitra B2B di 34 Provinsi',
        'copy'  => 'Melayani lebih dari 500 mitra usaha, agen, toko modern, dan institusi aktif di 34 provinsi dengan 1.000+ varian SKU siap kirim.',
    ],
];

$values = [
    [
        'num'   => '01',
        'title' => 'Integritas',
        'copy'  => 'Setiap janji produksi dan pasokan adalah komitmen. Kami menjunjung keterbukaan spesifikasi dan konsistensi transaksi B2B.',
    ],
    [
        'num'   => '02',
        'title' => 'Inovasi',
        'copy'  => 'Pengembangan formula terus berjalan di laboratorium R&D kami untuk menghasilkan performa pembersihan yang efektif dan relevan.',
    ],
    [
        'num'   => '03',
        'title' => 'Kemitraan',
        'copy'  => 'Pertumbuhan mitra adalah fondasi kami. Kami mendampingi distributor, gerai ritel, dan pemilik merek pribadi secara jangka panjang.',
    ],
    [
        'num'   => '04',
        'title' => 'Kualitas',
        'copy'  => 'Mutu produk dikawal melalui Izin Edar Kemenkes RI (PKRT), Sertifikasi Halal, serta pengujian mutu dan stabilitas terstandar.',
    ],
];

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 1: Split Editorial Hero + Full-Bleed Stage -->
        <section class="cs-hero ch-wrap" id="tentang-kami-hero" aria-labelledby="cs-about-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Tentang Kami</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Produsen, pengembang formulasi, penyedia jasa maklon, dan distributor B2B produk kebersihan terpercaya untuk mitra di seluruh Indonesia.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-pill-cta" href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>">
                            <span>Konsultasi B2B</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a class="ch-inline-link" href="#our-story">
                            <span>Telusuri perjalanan kami</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-about-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Membangun</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Sejak 2011</span>
                            <span class="ch-h1-secondary">Kepercayaan B2B</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Sleman, D.I. Yogyakarta<br>Jangkauan 34 Provinsi</p>
                </div>
            </div>

            <div class="cs-media-stage">
                <img
                    class="cs-media-stage-img"
                    src="<?php echo esc_url( $media_cp . '/hero-manufy-stage.webp' ); ?>"
                    width="1376"
                    height="768"
                    alt="Fasilitas manufaktur dan laboratorium R&D produk kebersihan PT Indotech Berkah Abadi"
                    fetchpriority="high"
                    decoding="async"
                >
                <div class="ch-stage-scrim" aria-hidden="true"></div>

                <div class="cs-stage-footer">
                    <dl class="cs-kpi-dock" aria-label="Pencapaian Utama Indotech">
                        <div class="cs-kpi-dock-item">
                            <dt>Pengalaman Manufaktur</dt>
                            <dd>15+ Tahun</dd>
                        </div>
                        <div class="cs-kpi-dock-item">
                            <dt>Mitra B2B Aktif</dt>
                            <dd>500+ Mitra</dd>
                        </div>
                        <div class="cs-kpi-dock-item">
                            <dt>Varian Formulasi SKU</dt>
                            <dd>1.000+ SKU</dd>
                        </div>
                        <div class="cs-kpi-dock-item">
                            <dt>Jangkauan Distribusi</dt>
                            <dd>34 Provinsi</dd>
                        </div>
                    </dl>

                    <button
                        type="button"
                        class="cs-stage-video-trigger"
                        data-video-open
                        aria-haspopup="dialog"
                        aria-controls="ch-video-modal"
                    >
                        <span class="cs-stage-play-dot" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><polygon points="7 4 21 12 7 20 7 4"/></svg>
                        </span>
                        <span class="cs-stage-video-meta">
                            <strong>Tonton Video Profil</strong>
                            <span><?php echo esc_html( $video_duration ); ?> · Fasilitas &amp; R&amp;D</span>
                        </span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Band 2: Editorial Story (Left Sticky + Lab Visual) & Tabular Hairline Timeline (Right) -->
        <section class="cs-band ch-wrap" id="our-story" aria-labelledby="cs-story-title">
            <div class="cs-story-layout">
                <div class="cs-story-lead">
                    <span class="cs-pill-tag">Kisah Kami</span>
                    <h2 id="cs-story-title" class="ch-section-h2">Dari Satu Kota, <span>Menjangkau 34 Provinsi</span></h2>
                    <div class="cs-story-prose">
                        <p>Berdiri pada tahun 2011 di Sleman, Yogyakarta, PT Indotech Berkah Abadi menyatukan riset kimia aplikatif, produksi terukur, dan rantai pasok B2B untuk usaha kecil hingga korporasi.</p>
                        <p>Selama lebih dari satu dekade, jaringan distribusi kami berkembang menjangkau seluruh penjuru nusantara dengan kepatuhan mutu dan legalitas produk yang konsisten.</p>
                    </div>

                    <div class="ch-legal-badges" aria-label="Legalitas terverifikasi">
                        <span class="ch-legal-pill">Izin Edar Kemenkes RI (PKRT)</span>
                        <span class="ch-legal-pill">Sertifikasi Halal</span>
                    </div>

                    <figure class="cs-inset-portrait">
                        <img
                            src="<?php echo esc_url( $media_cp . '/about-lab-video.webp' ); ?>"
                            width="800"
                            height="1000"
                            alt="Peralatan gelas laboratorium dan larutan sampel formulasi di ruang R&D Indotech"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="ch-poster-scrim" aria-hidden="true"></div>
                        <figcaption class="cs-inset-caption">
                            <span>Laboratorium Formulasi &amp; QC</span>
                            <strong>Pengujian Stabilitas Batch Produksi</strong>
                        </figcaption>
                    </figure>
                </div>

                <div class="cs-timeline-col" aria-label="Tonggak sejarah perusahaan">
                    <ol class="cs-ledger-list">
                        <?php foreach ( $timeline_rows as $row ) : ?>
                            <li class="cs-ledger-row">
                                <span class="cs-ledger-year"><?php echo esc_html( $row['year'] ); ?></span>
                                <div class="cs-ledger-body">
                                    <h3><?php echo esc_html( $row['title'] ); ?></h3>
                                    <p><?php echo esc_html( $row['copy'] ); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </section>
    </div>

    <!-- Band 3: Full-Width Obsidian-Navy Block (Visi, Misi & Sertifikasi Hairline — NO Nested Cards) -->
    <section class="ch-wrap cs-dark-section" id="visi-misi" aria-labelledby="cs-visi-title">
        <div class="cs-dark-panel">
            <div class="cs-visi-split">
                <div class="cs-visi-col">
                    <span class="cs-pill-tag cs-pill-tag--lime">Arah &amp; Tujuan</span>
                    <h2 id="cs-visi-title" class="cs-dark-h2">Visi &amp; <span>Misi</span></h2>
                    <div class="cs-visi-statement">
                        <span class="cs-dark-kicker">VISI 2030</span>
                        <h3>Menjadi Mitra Distribusi B2B Produk Homecare Terpercaya di Asia Tenggara</h3>
                        <p>Membangun ekosistem manufaktur dan suplai produk kebersihan yang tangguh, berizin lengkap, dan berdampak bagi ribuan pelaku usaha di kawasan regional.</p>
                    </div>
                </div>

                <div class="cs-misi-col">
                    <span class="cs-dark-kicker">MISI · EMPAT PILAR EKSEKUSI</span>
                    <ul class="cs-dark-ledger">
                        <li>
                            <span class="cs-dark-index">01</span>
                            <p>Menyediakan produk homecare, laundry, dan pewangi bersertifikat standar resmi Kemenkes RI (PKRT) &amp; Halal.</p>
                        </li>
                        <li>
                            <span class="cs-dark-index">02</span>
                            <p>Membangun kemitraan jangka panjang yang saling menguntungkan bagi agen, distributor, toko ritel, dan pemilik merek.</p>
                        </li>
                        <li>
                            <span class="cs-dark-index">03</span>
                            <p>Terus berinovasi dalam formulasi kimia terapan dan efisiensi pengemasan curah untuk memperluas daya saing mitra.</p>
                        </li>
                        <li>
                            <span class="cs-dark-index">04</span>
                            <p>Menghadirkan pendampingan menyeluruh berupa pelatihan Cleanique Academy, materi pemasaran, dan layanan purna jual.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="cs-cert-band" id="sertifikasi">
                <div class="cs-cert-head">
                    <span class="cs-pill-tag cs-pill-tag--lime">Terverifikasi Resmi</span>
                    <h2 class="cs-cert-h2">Standar Kualitas yang Tidak Berkompromi</h2>
                    <p>Setiap produk melewati uji kelayakan mutu internal dan memenuhi ketentuan legalitas edar resmi di Indonesia.</p>
                </div>

                <div class="cs-cert-columns">
                    <article class="cs-cert-item">
                        <div class="cs-cert-title-row">
                            <span class="cs-dark-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </span>
                            <h3>Kemenkes RI (PKRT)</h3>
                        </div>
                        <p>Izin edar resmi Perbekalan Kesehatan Rumah Tangga dari Kementerian Kesehatan Republik Indonesia.</p>
                    </article>

                    <article class="cs-cert-item">
                        <div class="cs-cert-title-row">
                            <span class="cs-dark-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            </span>
                            <h3>Sertifikasi Halal</h3>
                        </div>
                        <p>Jaminan kehalalan pemilihan bahan baku serta proses produksi sesuai ketentuan regulasi halal.</p>
                    </article>

                    <article class="cs-cert-item">
                        <div class="cs-cert-title-row">
                            <span class="cs-dark-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="9 11 12 14 22 4"/></svg>
                            </span>
                            <h3>Uji Mutu &amp; Stabilitas</h3>
                        </div>
                        <p>Pengujian formulasi laboratorium terstandar oleh tim R&amp;D berpengalaman sejak tahun 2011.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <div class="ch-canvas-band">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 4: 4-Column Architectural Hairline Values -->
        <section class="cs-band ch-wrap" id="nilai-perusahaan" aria-labelledby="cs-values-title">
            <header class="ch-section-head">
                <div>
                    <span class="cs-pill-tag">DNA Perusahaan</span>
                    <h2 id="cs-values-title" class="ch-section-h2">Nilai-Nilai <span>Utama Kami</span></h2>
                </div>
                <p class="ch-section-sub">Empat prinsip kerja yang membentuk standar layanan PT Indotech Berkah Abadi kepada ratusan mitra B2B.</p>
            </header>

            <div class="cs-hairline-matrix cs-hairline-matrix--4">
                <?php foreach ( $values as $val ) : ?>
                    <article class="cs-hairline-cell">
                        <div class="cs-cell-head">
                            <span class="cs-index-num"><?php echo esc_html( $val['num'] ); ?></span>
                            <h3><?php echo esc_html( $val['title'] ); ?></h3>
                        </div>
                        <p><?php echo esc_html( $val['copy'] ); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Band 5: Aplikasi Layanan B2B (CPT WP_Query Preserved) -->
        <section class="cs-band ch-wrap" id="aplikasi-layanan" aria-labelledby="cs-apps-title">
            <header class="ch-section-head">
                <div>
                    <span class="cs-pill-tag">Penerapan Solusi</span>
                    <h2 id="cs-apps-title" class="ch-section-h2">Aplikasi <span>Layanan B2B</span></h2>
                </div>
                <p class="ch-section-sub">Jangkauan formula produk kimia pembersih dan solusi maklon kami untuk berbagai sektor operasional usaha.</p>
            </header>

            <div class="cs-editorial-grid">
                <?php
                $app_query = new WP_Query( [
                    'post_type'      => 'application',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                ] );

                if ( $app_query->have_posts() ) :
                    while ( $app_query->have_posts() ) :
                        $app_query->the_post();
                        $app_id      = get_the_ID();
                        $app_title   = get_the_title();
                        $title_lower = strtolower( $app_title );
                        $tagline     = function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( $app_id, 'app_tagline' ) : '';
                        $desc        = $tagline ? wp_trim_words( wp_strip_all_tags( $tagline ), 16, '...' ) : wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );

                        if ( has_post_thumbnail() ) {
                            $img_html = get_the_post_thumbnail( $app_id, 'indotech-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] );
                        } else {
                            $fallback_img = $media_cp . '/ilustrasi-formulasi.webp';
                            if ( strpos( $title_lower, 'laundry' ) !== false ) {
                                $fallback_img = $media_cp . '/hero-manufy-stage.webp';
                            } elseif ( strpos( $title_lower, 'detail' ) !== false || strpos( $title_lower, 'car' ) !== false || strpos( $title_lower, 'auto' ) !== false ) {
                                $fallback_img = $media_cp . '/cta-logistics-b2b.webp';
                            }
                            $img_html = '<img src="' . esc_url( $fallback_img ) . '" alt="' . esc_attr( $app_title ) . '" loading="lazy" decoding="async">';
                        }

                        get_template_part( 'template-parts/archive/editorial-item', null, [
                            'url'            => get_permalink( $app_id ),
                            'title'          => $app_title,
                            'desc'           => $desc,
                            'image_html'     => $img_html,
                            'fallback_label' => $app_title,
                            'media_variant'  => 'wide',
                            'heading_tag'    => 'h3',
                            'post_id'        => $app_id,
                        ] );
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="cs-empty-panel">
                        Belum ada data aplikasi layanan terdaftar.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Band 6: Split Map & HQ Office Showcase -->
        <section class="cs-band ch-wrap" id="lokasi-kantor" aria-labelledby="cs-map-title">
            <div class="cs-hq-split">
                <div class="cs-hq-info">
                    <span class="cs-pill-tag cs-pill-tag--lime">Kunjungi Kami</span>
                    <h2 id="cs-map-title" class="cs-dark-h2 cs-dark-h2--sm">Kantor Pusat &amp; Operasional</h2>
                    <p class="cs-hq-address"><?php echo esc_html( $address ); ?></p>

                    <ul class="cs-hq-hours">
                        <li>
                            <span>Senin – Jumat</span>
                            <strong>08.00 – 17.00 WIB</strong>
                        </li>
                        <li>
                            <span>Sabtu</span>
                            <strong>08.00 – 13.00 WIB</strong>
                        </li>
                        <li>
                            <span>Telepon Kantor</span>
                            <strong><?php echo esc_html( $phone ); ?></strong>
                        </li>
                    </ul>

                    <div class="cs-hq-actions">
                        <a
                            href="https://maps.google.com/?q=PT.+Indotech+Berkah+Abadi+Sleman+Yogyakarta"
                            class="ch-pill-cta"
                            target="_blank"
                            rel="noopener"
                        >
                            <span>Buka Google Maps</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" class="ch-lime-link" target="_blank" rel="noopener">
                            <span>Janji Kunjungan WhatsApp</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hq-map">
                    <iframe
                        src="https://maps.google.com/maps?q=PT.+Indotech+Berkah+Abadi+Sleman+Yogyakarta&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Peta lokasi PT Indotech Berkah Abadi di Sleman, Yogyakarta">
                    </iframe>
                </div>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<?php get_template_part( 'template-parts/home/company-video-modal' ); ?>

<?php get_footer(); ?>
