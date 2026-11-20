<?php
/**
 * Template Name: Kemitraan
 *
 * Halaman program & pendaftaran kemitraan B2B PT Indotech Berkah Abadi — Arsitektur Manufy.
 * Preserves #indotech-inquiry-form, data-form-type="kemitraan", wp_nonce_field, honeypot, whatsapp_number.
 */

$media_cp  = get_theme_file_uri( 'assets/images/company-profile' );
$media_img = get_theme_file_uri( 'assets/images' );
$whatsapp  = '+62 878-8559-0088';
$wa_num    = '6287885590088';
$wa_msg    = rawurlencode( 'Halo indotech.id, saya tertarik untuk mendaftar sebagai mitra distribusi. Mohon informasi lebih lanjut.' );

$schemes = [
    [
        'value'   => 'distributor',
        'badge'   => 'Skala Regional',
        'title'   => 'Distributor Daerah',
        'desc'    => 'Untuk pelaku usaha distribusi skala kabupaten/provinsi dengan struktur margin grosir tertinggi dan dukungan pasokan kargo terprioritas.',
        'bullets' => [
            'Harga grosir tier distributor & insentif volume',
            'Prioritas area distribusi & stok 1.000+ SKU',
            'Pendampingan Account Manager khusus',
        ],
    ],
    [
        'value'   => 'reseller',
        'badge'   => 'Gerai & E-Commerce',
        'title'   => 'Reseller & Cleanique Mart',
        'desc'    => 'Dirancang bagi pemilik toko kebersihan modern, gerai isi ulang Depo Cleanique, atau toko retail dengan perputaran cepat.',
        'bullets' => [
            'Paket stok awal fleksibel tanpa gudang raksasa',
            'Perlengkapan branding & materi promosi digital',
            'Akses penuh lini homecare, laundry & pewangi',
        ],
    ],
    [
        'value'   => 'horeka',
        'badge'   => 'Hospitality',
        'title'   => 'Hotel, Resto &amp; Katering',
        'desc'    => 'Suplai terjadwal kemasan curah ekonomis untuk housekeeping hotel, dapur restoran, dan laundry komersial.',
        'bullets' => [
            'Harga kontrak rutin & pengemasan jeriken 5L–20L',
            'Tersedia formula khusus Prokopi & linen care',
            'Jaminan konsistensi batch dan dokumen MSDS',
        ],
    ],
    [
        'value'   => 'institusi',
        'badge'   => 'B2B & Pengadaan',
        'title'   => 'Institusi &amp; Korporat',
        'desc'    => 'Kemitraan pengadaan produk kebersihan bagi perkantoran, sekolah, fasilitas kesehatan, hingga tender instansi.',
        'bullets' => [
            'Dukungan penawaran harga resmi & faktur pajak',
            'Produk berizin edar Kemenkes RI PKRT & Halal',
            'Pengiriman kargo terjadwal ke 34 provinsi',
        ],
    ],
];

$steps = [
    [
        'num'   => '01',
        'title' => 'Isi Form Pendaftaran',
        'copy'  => 'Lengkapi profil singkat dan pilih tipe kemitraan pada formulir di bawah atau hubungi WhatsApp Keagenan.',
    ],
    [
        'num'   => '02',
        'title' => 'Verifikasi &amp; Konsultasi',
        'copy'  => 'Tim kemitraan menghubungi Anda dalam 1×24 jam kerja untuk membahas wilayah, kapasitas, dan daftar harga grosir.',
    ],
    [
        'num'   => '03',
        'title' => 'Onboarding &amp; Materi',
        'copy'  => 'Terima katalog lengkap, skema margin, materi promosi digital, dan panduan produk siap jual.',
    ],
    [
        'num'   => '04',
        'title' => 'Aktif Berjualan!',
        'copy'  => 'Pesanan diproses dari Sleman ke seluruh Indonesia dengan dukungan restock berkala dan Account Manager.',
    ],
];

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 1: Manufy Split Hero + Asymmetric 2-Photo Partner Showcase -->
        <section class="cs-hero ch-wrap" id="kemitraan-hero" aria-labelledby="cs-partner-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Kemitraan</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Bergabung dengan jaringan distributor, agen grosir, toko modern Cleanique Mart, dan mitra pengadaan B2B di seluruh Indonesia.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-pill-cta" href="#form-kemitraan">
                            <span>Daftar Jadi Mitra</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a class="ch-inline-link" href="#tipe-mitra">
                            <span>Bandingkan skema mitra</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-partner-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Tumbuh</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">500+ Mitra</span>
                            <span class="ch-h1-secondary">Bersama Kami</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Tanpa Biaya Pendaftaran<br>Respon 1×24 Jam Kerja</p>
                </div>
            </div>

            <div class="cs-partner-collage">
                <figure class="cs-collage-main">
                    <img
                        src="<?php echo esc_url( $media_cp . '/cta-collab-b2b.webp' ); ?>"
                        width="800"
                        height="600"
                        alt="Konsultan B2B Indotech berdiskusi mengenai paket kemasan kemitraan bersama calon mitra usaha"
                        fetchpriority="high"
                        decoding="async"
                    >
                    <div class="ch-stage-scrim" aria-hidden="true"></div>
                    <div class="cs-collage-l-card">
                        <div class="cs-collage-l-top">
                            <p>Gratis biaya pendaftaran dengan dukungan katalog, materi promosi, dan pasokan langsung dari pabrik.</p>
                        </div>
                        <div class="cs-collage-l-bottom">
                            <a href="#form-kemitraan" class="ch-stage-card-link">
                                <span>Ajukan Pendaftaran Mitra</span>
                                <span class="ch-stage-card-arrow" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </figure>

                <figure class="cs-collage-side">
                    <img
                        src="<?php echo esc_url( $media_img . '/mitra-jambi.webp' ); ?>"
                        width="400"
                        height="300"
                        alt="Gerai mitra Cleanique Mart Jambi yang beroperasi dalam ekosistem Indotech"
                        decoding="async"
                    >
                    <div class="ch-poster-scrim" aria-hidden="true"></div>
                    <figcaption class="cs-collage-caption">
                        <span>Jaringan Ritel &amp; Grosir</span>
                        <strong>Cleanique Mart &amp; Distributor · 34 Provinsi</strong>
                    </figcaption>
                </figure>
            </div>
        </section>
    </div>

    <!-- Band 2: Obsidian-Navy Keunggulan Panel (Flattened Hairline Columns — NO Nested Cards) -->
    <section class="ch-wrap cs-dark-section" id="keunggulan-mitra" aria-labelledby="cs-advantages-title">
        <div class="cs-dark-panel">
            <div class="cs-dark-split-head">
                <div>
                    <span class="cs-pill-tag cs-pill-tag--lime">Mengapa Bermitra</span>
                    <h2 id="cs-advantages-title" class="cs-dark-h2">Keunggulan Menjadi <span>Mitra Indotech</span></h2>
                </div>
                <p class="cs-dark-lead">Tiga fondasi bisnis yang dirancang untuk mempercepat perputaran stok serta menjaga margin usaha Anda.</p>
            </div>

            <div class="cs-dark-cols-3">
                <article class="cs-dark-col">
                    <div class="cs-dark-col-head">
                        <span class="cs-dark-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </span>
                        <h3>Margin Kompetitif</h3>
                    </div>
                    <p>Struktur harga pabrik berjenjang dengan ruang margin grosir dan ritel yang sehat di berbagai kelas order.</p>
                    <ul class="cs-dark-checks">
                        <li>Harga grosir eksklusif mitra terdaftar</li>
                        <li>Skema diskon volume order progresif</li>
                        <li>Program promo dan cashback periodik</li>
                    </ul>
                </article>

                <article class="cs-dark-col cs-dark-col--highlight">
                    <div class="cs-dark-col-head">
                        <span class="cs-dark-icon cs-dark-icon--cobalt" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <h3>Dukungan Marketing <span class="cs-inline-lime-tag">Unggulan</span></h3>
                    </div>
                    <p>Materi promosi siap pakai, strategi pemasaran digital, dan pendampingan tim untuk mendorong penjualan mitra.</p>
                    <ul class="cs-dark-checks">
                        <li>Konten visual, katalog &amp; brosur digital</li>
                        <li>Account Manager khusus per akun mitra</li>
                        <li>Akses pelatihan penjualan &amp; produk</li>
                    </ul>
                    <a href="#form-kemitraan" class="ch-lime-link cs-dark-col-link">
                        <span>Daftar Sekarang</span>
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </a>
                </article>

                <article class="cs-dark-col">
                    <div class="cs-dark-col-head">
                        <span class="cs-dark-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </span>
                        <h3>Produk Tersertifikasi</h3>
                    </div>
                    <p>Pasarkan produk dengan percaya diri karena seluruh lini telah memenuhi izin edar serta standar mutu laboratorium.</p>
                    <ul class="cs-dark-checks">
                        <li>Izin Edar Kemenkes RI (PKRT)</li>
                        <li>Sertifikasi Halal &amp; uji stabilitas</li>
                        <li>Dokumen MSDS &amp; COA tersedia lengkap</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <div class="ch-canvas-band">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 3: Horizontal 4-Step Architectural Process Track -->
        <section class="cs-band ch-wrap" id="alur-kemitraan" aria-labelledby="cs-steps-title">
            <header class="ch-section-head">
                <div>
                    <span class="cs-pill-tag">Proses Mudah</span>
                    <h2 id="cs-steps-title" class="ch-section-h2">Alur Menjadi <span>Mitra</span></h2>
                </div>
                <p class="ch-section-sub">Empat tahap terstruktur untuk memulai distribusi produk Indotech di kota Anda tanpa biaya pendaftaran.</p>
            </header>

            <ol class="cs-process-rail">
                <?php foreach ( $steps as $step ) : ?>
                    <li class="cs-process-step">
                        <div class="cs-cell-head">
                            <span class="cs-index-num"><?php echo esc_html( $step['num'] ); ?></span>
                            <h3><?php echo wp_kses_post( $step['title'] ); ?></h3>
                        </div>
                        <p><?php echo esc_html( $step['copy'] ); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>

        <!-- Band 4: 2x2 Interactive Scheme Matrix (Pre-fills #partner-type) -->
        <section class="cs-band ch-wrap" id="tipe-mitra" aria-labelledby="cs-schemes-title">
            <header class="ch-section-head">
                <div>
                    <span class="cs-pill-tag">Program Tersedia</span>
                    <h2 id="cs-schemes-title" class="ch-section-h2">Pilih Skema <span>Kemitraan</span></h2>
                </div>
                <p class="ch-section-sub">Klik tombol pada skema yang sesuai untuk langsung mengisi jenis kemitraan di formulir pendaftaran.</p>
            </header>

            <div class="cs-scheme-grid">
                <?php foreach ( $schemes as $scheme ) : ?>
                    <article class="cs-scheme-card">
                        <div class="cs-scheme-top">
                            <span class="cs-pill-tag cs-pill-tag--subtle"><?php echo esc_html( $scheme['badge'] ); ?></span>
                            <h3><?php echo wp_kses_post( $scheme['title'] ); ?></h3>
                            <p><?php echo esc_html( $scheme['desc'] ); ?></p>
                        </div>

                        <ul class="cs-scheme-list">
                            <?php foreach ( $scheme['bullets'] as $bullet ) : ?>
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <button
                            type="button"
                            class="cs-scheme-select-btn"
                            data-select-partner="<?php echo esc_attr( $scheme['value'] ); ?>"
                        >
                            <span>Pilih Skema Ini</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </button>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Band 5: Split Conversion Form Studio (#indotech-inquiry-form intact) -->
        <section class="cs-band ch-wrap" id="form-kemitraan" aria-labelledby="cs-partner-form-title">
            <div class="cs-split-studio">
                <div class="cs-studio-concierge">
                    <span class="cs-pill-tag cs-pill-tag--lime">Daftar Sekarang</span>
                    <h2 id="cs-partner-form-title" class="cs-dark-h2 cs-dark-h2--sm">Siap Memulai Kemitraan?</h2>
                    <p class="cs-studio-copy">Lengkapi formulir di samping dan tim kemitraan Indotech akan menghubungi Anda dalam 1×24 jam kerja.</p>

                    <div class="cs-concierge-wa">
                        <span class="cs-dark-kicker">WHATSAPP KEAGENAN LANGSUNG</span>
                        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" class="cs-wa-number-link" target="_blank" rel="noopener">
                            <?php echo esc_html( $whatsapp ); ?>
                        </a>
                    </div>

                    <ul class="cs-dark-checks cs-dark-checks--compact">
                        <li>Konsultasi gratis tanpa komitmen awal</li>
                        <li>Respon cepat dalam 1×24 jam kerja</li>
                        <li>Pengiriman kargo darat, laut, &amp; udara ke 34 provinsi</li>
                    </ul>

                    <figure class="cs-studio-photo">
                        <img
                            src="<?php echo esc_url( $media_cp . '/cta-logistics-b2b.webp' ); ?>"
                            width="800"
                            height="600"
                            alt="Gudang logistik kemasan curah PT Indotech Berkah Abadi"
                            loading="lazy"
                            decoding="async"
                        >
                    </figure>
                </div>

                <div class="cs-studio-form-wrap">
                    <form
                        id="indotech-inquiry-form"
                        class="cs-form"
                        data-form-type="kemitraan"
                        novalidate
                        aria-label="Form Pendaftaran Mitra"
                    >
                        <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>

                        <div style="display:none;" aria-hidden="true">
                            <label for="website_url">Website</label>
                            <input type="url" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>
                        <input type="hidden" name="whatsapp_number" value="6287885590088">

                        <div class="cs-form-row">
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="partner-name">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="partner-name"
                                    name="contact_name"
                                    class="cs-form-input"
                                    placeholder="Nama Anda"
                                    autocomplete="name"
                                >
                            </div>
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="partner-email">Alamat Email</label>
                                <input
                                    type="email"
                                    id="partner-email"
                                    name="contact_email"
                                    class="cs-form-input"
                                    placeholder="email@perusahaan.com"
                                    autocomplete="email"
                                >
                            </div>
                        </div>

                        <div class="cs-form-row">
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="partner-city">Kota / Kabupaten (Domisili)</label>
                                <input
                                    type="text"
                                    id="partner-city"
                                    name="partner_city"
                                    class="cs-form-input"
                                    placeholder="Contoh: Sleman, Semarang, Surabaya"
                                >
                            </div>
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="partner-type">Tipe Kemitraan</label>
                                <select id="partner-type" name="partner_type" class="cs-form-input cs-form-select">
                                    <option value="" selected>Pilih tipe mitra...</option>
                                    <option value="distributor">Distributor</option>
                                    <option value="reseller">Reseller</option>
                                    <option value="horeka">Hotel / Restoran / Katering</option>
                                    <option value="institusi">Institusi / Korporat</option>
                                </select>
                            </div>
                        </div>

                        <div class="cs-form-group">
                            <label class="cs-form-label" for="partner-message">Pesan / Rencana Bisnis Anda</label>
                            <textarea
                                id="partner-message"
                                name="contact_message"
                                class="cs-form-input cs-form-textarea"
                                rows="4"
                                placeholder="Ceritakan singkat target pasar atau kebutuhan order awal Anda (opsional)..."
                            ></textarea>
                        </div>

                        <div id="indotech-inquiry-response" class="form-response" role="alert" aria-live="polite" style="display:none;"></div>

                        <button type="submit" id="partner-submit" class="ch-pill-cta cs-form-submit">
                            <span class="btn-text">Daftar Kemitraan via WhatsApp</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Band 6: Manufy Split FAQ Kemitraan -->
        <section class="cs-band ch-wrap" id="faq-kemitraan" aria-labelledby="cs-partner-faq-title">
            <div class="cs-split-faq">
                <div class="cs-split-faq-left">
                    <span class="cs-pill-tag">FAQ Kemitraan</span>
                    <h2 id="cs-partner-faq-title" class="ch-section-h2 ch-section-h2--sm">Pertanyaan <span>Sering Diajukan</span></h2>
                    <p>Masih membutuhkan rincian skema harga grosir atau ekspedisi daerah? Tim kami siap membantu langsung.</p>
                    <a
                        href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                        class="ch-pill-cta"
                        target="_blank"
                        rel="noopener"
                    >
                        <span>Tanya via WhatsApp</span>
                        <span class="ch-pill-cta-icon" aria-hidden="true">
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </span>
                    </a>
                </div>

                <div class="cs-split-faq-right">
                    <details class="ch-faq-item" id="faq-1">
                        <summary class="ch-faq-q">
                            <span>Berapa minimum order untuk menjadi mitra Indotech?</span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p>Minimum order pertama bervariasi tergantung tipe kemitraan. Untuk Reseller, mulai dari Rp 500.000. Untuk Distributor, mulai dari Rp 5.000.000. Silakan hubungi tim kami untuk penawaran yang disesuaikan dengan kebutuhan bisnis Anda.</p>
                        </div>
                    </details>

                    <details class="ch-faq-item" id="faq-2">
                        <summary class="ch-faq-q">
                            <span>Apakah ada biaya pendaftaran untuk menjadi mitra?</span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p>Tidak ada biaya pendaftaran. Proses pendaftaran mitra Indotech sepenuhnya gratis. Anda hanya perlu melengkapi form pendaftaran dan menunggu verifikasi dari tim kami dalam 1×24 jam kerja.</p>
                        </div>
                    </details>

                    <details class="ch-faq-item" id="faq-3">
                        <summary class="ch-faq-q">
                            <span>Bagaimana sistem pengiriman ke luar Jawa?</span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p>Kami melayani pengiriman ke seluruh 34 provinsi Indonesia melalui mitra ekspedisi terpercaya. Untuk order dalam jumlah besar ke luar Jawa, tersedia opsi pengiriman kargo darat maupun laut dengan ongkos kirim yang efisien.</p>
                        </div>
                    </details>

                    <details class="ch-faq-item" id="faq-4">
                        <summary class="ch-faq-q">
                            <span>Apakah produk Indotech sudah memiliki sertifikasi resmi?</span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p>Ya. Seluruh lini produk kami telah memiliki Izin Edar Kementerian Kesehatan RI (PKRT), Sertifikasi Halal resmi, serta pengujian mutu dan stabilitas laboratorium. Dokumen legalitas tersedia atas permintaan.</p>
                        </div>
                    </details>

                    <details class="ch-faq-item" id="faq-5">
                        <summary class="ch-faq-q">
                            <span>Apakah tersedia dukungan marketing untuk mitra?</span>
                            <svg class="ch-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </summary>
                        <div class="ch-faq-a">
                            <p>Tentu saja. Setiap mitra terdaftar mendapatkan materi promosi digital (banner, foto produk, konten media sosial), akses katalog digital, pelatihan produk, dan dukungan Account Manager khusus.</p>
                        </div>
                    </details>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
