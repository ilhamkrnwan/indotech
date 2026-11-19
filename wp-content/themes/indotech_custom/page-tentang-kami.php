<?php
/**
 * Template Name: Tentang Kami
 *
 * Halaman profil perusahaan PT Indotech Berkah Abadi.
 * Sections: Hero · Our Story · Visi & Misi · Nilai Perusahaan · Sertifikasi · CTA
 */

$phone    = indotech_opt( 'phone',    '+62 856-0006-1005' );
$email    = indotech_opt( 'email',    'indotechberkahabadi@gmail.com' );
$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin mengetahui lebih lanjut tentang perusahaan Anda.' );

get_header();
?>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         HERO — Pendek, elegant (seperti kontak)
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero" id="tentang-kami-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Tentang Kami</span>
            </nav>
            <span class="section-tag">Profil Perusahaan</span>
            <h1 class="inner-page-title">Membangun Kepercayaan <em>Bisnis B2B</em> Indonesia</h1>
            <p class="inner-page-subtitle">Kami adalah pemasok produk homecare, laundry, dan pewangi B2B yang berkomitmen menghadirkan kualitas premium dengan harga kompetitif untuk mitra bisnis di seluruh Indonesia.</p>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         OUR STORY — Timeline & narasi perusahaan
    ════════════════════════════════════════════════════════ -->
    <section class="about-story-section section-padding" id="our-story">
        <div class="container">

            <div class="about-story-grid">

                <!-- Kiri: Narasi -->
                <div class="about-story-content reveal">
                    <span class="section-tag">Kisah Kami</span>
                    <h2 class="section-title" style="margin-bottom:20px;">
                        Dari Satu Kota,<br>Menjangkau <em>34 Provinsi</em>
                    </h2>
                    <p class="why-us-desc">
                        PT Indotech Berkah Abadi lahir pada tahun 2011 dengan visi sederhana: menyediakan produk kebersihan dan perawatan berkualitas untuk pelaku usaha kecil hingga korporasi besar di Indonesia.
                    </p>
                    <p class="why-us-desc" style="margin-bottom:36px;">
                        Selama lebih dari satu dekade, kami telah membangun jaringan distribusi yang menjangkau seluruh penjuru nusantara — dari Sabang hingga Merauke — dengan standar kualitas yang tidak pernah berkompromi.
                    </p>

                    <div class="about-stats-strip">
                        <div class="about-stat-item">
                            <span class="about-stat-value">15+</span>
                            <span class="about-stat-label">Tahun Pengalaman</span>
                        </div>
                        <div class="about-stat-divider" aria-hidden="true"></div>
                        <div class="about-stat-item">
                            <span class="about-stat-value">1.000+</span>
                            <span class="about-stat-label">Varian Produk</span>
                        </div>
                        <div class="about-stat-divider" aria-hidden="true"></div>
                        <div class="about-stat-item">
                            <span class="about-stat-value">34</span>
                            <span class="about-stat-label">Provinsi Terjangkau</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Timeline -->
                <div class="about-timeline reveal reveal-delay-1">
                    <div class="timeline-item timeline-item--active">
                        <div class="timeline-dot" aria-hidden="true"></div>
                        <div class="timeline-body">
                            <span class="timeline-year">2011</span>
                            <h3>Pendirian Perusahaan</h3>
                            <p>PT Indotech Berkah Abadi resmi berdiri dan mulai melayani mitra distribusi di wilayah Yogyakarta dan Jawa.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" aria-hidden="true"></div>
                        <div class="timeline-body">
                            <span class="timeline-year">2014</span>
                            <h3>Ekspansi Nasional</h3>
                            <p>Jaringan distribusi berkembang ke 10 provinsi, dengan penambahan lini produk laundry profesional.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" aria-hidden="true"></div>
                        <div class="timeline-body">
                            <span class="timeline-year">2017</span>
                            <h3>Izin Edar Kemenkes RI &amp; Halal</h3>
                            <p>Lini produk kebersihan kami memperoleh Izin Edar Kemenkes RI (PKRT) serta Sertifikasi Halal, memperkuat kepercayaan mitra bisnis.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" aria-hidden="true"></div>
                        <div class="timeline-body">
                            <span class="timeline-year">2020</span>
                            <h3>Peluncuran Brand Unggulan</h3>
                            <p>Cleanique Academy, Cleanique Lab, Cleanique Mart, Depo Cleanique, Malabeez, Orchid Care, dan Prokopi resmi diluncurkan sebagai brand andalan perusahaan.</p>
                        </div>
                    </div>
                    <div class="timeline-item timeline-item--active">
                        <div class="timeline-dot" aria-hidden="true"></div>
                        <div class="timeline-body">
                            <span class="timeline-year">2024</span>
                            <h3>500+ Mitra Aktif</h3>
                            <p>Mencapai tonggak 500+ mitra bisnis aktif di 34 provinsi Indonesia dengan lini produk yang terus berkembang.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         VISI & MISI
    ════════════════════════════════════════════════════════ -->
    <section class="about-visi-section section-padding" id="visi-misi">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag section-tag--dark">Arah & Tujuan</span>
                <h2 class="section-title" style="margin-top:16px;">Visi &amp; Misi</h2>
                <p class="section-desc">Landasan yang mengarahkan setiap keputusan dan langkah PT Indotech Berkah Abadi.</p>
            </div>

            <div class="visi-misi-grid">

                <!-- Visi -->
                <div class="visi-card reveal">
                    <div class="visi-card-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg>
                    </div>
                    <span class="visi-card-label">VISI</span>
                    <h3 class="visi-card-title">Menjadi Mitra Distribusi B2B Produk Homecare Terpercaya di Asia Tenggara</h3>
                    <p class="visi-card-desc">
                        Kami bercita-cita menjadi perusahaan distribusi produk kebersihan dan perawatan yang paling dipercaya, tidak hanya di Indonesia tetapi juga di kawasan Asia Tenggara pada tahun 2030.
                    </p>
                </div>

                <!-- Misi -->
                <div class="visi-card visi-card--misi reveal reveal-delay-1">
                    <div class="visi-card-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="9,11 12,14 22,4"/><path d="M21,12v7a2,2 0 0,1-2,2H5a2,2 0 0,1-2-2V5a2,2 0 0,1 2-2h11"/></svg>
                    </div>
                    <span class="visi-card-label">MISI</span>
                    <h3 class="visi-card-title">Menghadirkan Produk Berkualitas dengan Layanan Prima</h3>
                    <ul class="misi-list">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Menyediakan produk homecare dan laundry bersertifikat standar nasional dan internasional
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Membangun kemitraan jangka panjang yang saling menguntungkan dengan seluruh mitra bisnis
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Terus berinovasi dalam lini produk dan sistem distribusi untuk memenuhi kebutuhan pasar
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Memberikan dukungan penuh kepada mitra: pelatihan, marketing materials, dan layanan purna jual
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         NILAI PERUSAHAAN — 4 value cards
    ════════════════════════════════════════════════════════ -->
    <section class="about-values-section section-padding" id="nilai-perusahaan">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">DNA Perusahaan</span>
                <h2 class="section-title" style="margin-top:16px;">Nilai-Nilai Kami</h2>
                <p class="section-desc">Empat pilar yang membentuk karakter dan budaya kerja PT Indotech Berkah Abadi.</p>
            </div>

            <div class="values-grid">

                <div class="value-card reveal">
                    <div class="value-num" aria-hidden="true">01</div>
                    <div class="ch-card-head">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3 class="service-title">Integritas</h3>
                    </div>
                    <p class="service-desc">Setiap janji adalah komitmen. Kami menjunjung tinggi kejujuran dan transparansi dalam setiap transaksi dan hubungan bisnis dengan mitra.</p>
                </div>

                <div class="value-card reveal reveal-delay-1">
                    <div class="value-num" aria-hidden="true">02</div>
                    <div class="ch-card-head">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
                        </div>
                        <h3 class="service-title">Inovasi</h3>
                    </div>
                    <p class="service-desc">Kami tidak berhenti berkembang. Inovasi produk, sistem distribusi, dan layanan pelanggan terus kami dorong untuk tetap relevan dan kompetitif.</p>
                </div>

                <div class="value-card reveal reveal-delay-2">
                    <div class="value-num" aria-hidden="true">03</div>
                    <div class="ch-card-head">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3 class="service-title">Kemitraan</h3>
                    </div>
                    <p class="service-desc">Sukses mitra adalah sukses kami. Kami membangun hubungan bisnis yang setara, saling mendukung, dan berorientasi pada pertumbuhan bersama jangka panjang.</p>
                </div>

                <div class="value-card reveal reveal-delay-3">
                    <div class="value-num" aria-hidden="true">04</div>
                    <div class="ch-card-head">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="9,11 12,14 22,4"/><path d="M21,12v7a2,2 0 0,1-2,2H5a2,2 0 0,1-2-2V5a2,2 0 0,1 2-2h11"/></svg>
                        </div>
                        <h3 class="service-title">Kualitas</h3>
                    </div>
                    <p class="service-desc">Standar tidak pernah dikompromikan. Setiap produk melewati seleksi ketat dengan Izin Edar Kemenkes RI (PKRT), Sertifikasi Halal, dan uji stabilitas laboratorium sebagai jaminan mutu.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         APLIKASI LAYANAN B2B
    ════════════════════════════════════════════════════════ -->
    <section class="about-applications-section section-padding" id="aplikasi-layanan">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag section-tag--dark">Penerapan Solusi</span>
                <h2 class="section-title" style="margin-top:16px;">Aplikasi Layanan B2B</h2>
                <p class="section-desc">Jangkauan formula produk kimia pembersih dan solusi maklon kami untuk berbagai kebutuhan operasional.</p>
            </div>

            <div class="applications-grid">
                <?php
                $app_query = new WP_Query([
                    'post_type'      => 'application',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish'
                ]);

                if ($app_query->have_posts()) :
                    while ($app_query->have_posts()) : $app_query->the_post();
                        $app_id = get_the_ID();
                        $tagline = carbon_get_post_meta($app_id, 'app_tagline');

                        $title_lower = strtolower(get_the_title());
                        $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>';

                        if (strpos($title_lower, 'laundry') !== false) {
                            $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="12" cy="13" r="5"/><path d="M12 10a3 3 0 0 1 0 6"/><circle cx="8" cy="6" r="1"/></svg>';
                        } elseif (strpos($title_lower, 'detail') !== false || strpos($title_lower, 'car') !== false || strpos($title_lower, 'auto') !== false) {
                            $svg_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>';
                        }
                ?>
                    <article class="premium-app-card reveal">
                        <div class="premium-app-icon-wrap" aria-hidden="true">
                            <?php echo $svg_icon; ?>
                        </div>

                        <div class="premium-app-card-body">
                            <span class="premium-app-tag">Aplikasi B2B</span>
                            <h3 class="premium-app-title"><?php the_title(); ?></h3>
                            <?php if ($tagline) : ?>
                                <p class="premium-app-desc"><?php echo esc_html($tagline); ?></p>
                            <?php endif; ?>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="premium-app-btn">
                            <span>Pelajari Selengkapnya</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </article>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                ?>
                    <div style="grid-column: 1 / -1; background: var(--ch-white); padding: 40px; border-radius: 20px; text-align: center; color: var(--ch-slate); border: 1px solid var(--ch-grid);">
                        Belum ada data aplikasi layanan terdaftar.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         SERTIFIKASI — Strip sertifikat perusahaan
    ════════════════════════════════════════════════════════ -->
    <section class="about-cert-section" id="sertifikasi">
        <div class="container">
            <div class="about-cert-inner reveal">
                <div class="about-cert-left">
                    <span class="section-tag section-tag--dark">Terverifikasi Resmi</span>
                    <h2 class="section-title" style="margin-top:16px;font-size:clamp(24px,3vw,38px);">
                        Standar Kualitas<br>yang Tidak Berkompromi
                    </h2>
                    <p class="why-us-desc" style="max-width:400px;">
                        Semua produk kami telah melalui uji kelayakan dan memenuhi legalitas edar resmi yang berlaku di Indonesia.
                    </p>
                </div>
                <div class="about-cert-grid">
                    <div class="cert-card">
                        <div class="ch-card-head">
                            <div class="cert-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <h3>Kemenkes RI (PKRT)</h3>
                        </div>
                        <p>Izin edar resmi Perbekalan Kesehatan Rumah Tangga Kemenkes Republik Indonesia</p>
                    </div>
                    <div class="cert-card">
                        <div class="ch-card-head">
                            <div class="cert-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            </div>
                            <h3>Sertifikasi Halal</h3>
                        </div>
                        <p>Jaminan kehalalan bahan baku dan proses produksi sesuai ketentuan resmi</p>
                    </div>
                    <div class="cert-card">
                        <div class="ch-card-head">
                            <div class="cert-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="9,11 12,14 22,4"/></svg>
                            </div>
                            <h3>Uji Mutu &amp; Stabilitas</h3>
                        </div>
                        <p>Pengujian formulasi laboratorium terstandar oleh tim R&amp;D kami sejak 2011</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         LOKASI KANTOR — Map Interaktif
    ════════════════════════════════════════════════════════ -->
    <section class="about-map-section section-padding" id="lokasi-kantor">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-tag section-tag--dark">Kunjungi Kami</span>
                <h2 class="section-title" style="margin-top:16px;">Lokasi Kantor</h2>
                <p class="section-desc">Kantor pusat dan operasional PT Indotech Berkah Abadi di Yogyakarta.</p>
            </div>
            
            <div class="about-map-wrap reveal">
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

    <!-- ════════════════════════════════════════════════════════
         CTA BANNER
    ════════════════════════════════════════════════════════ -->
    <?php get_template_part( 'template-parts/home/company-cta' ); ?>

</main>

<?php get_footer(); ?>
