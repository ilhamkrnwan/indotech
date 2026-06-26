<?php
/**
 * Template Name: Kemitraan
 *
 * Halaman pendaftaran mitra distribusi PT Indotech Berkah Abadi.
 * Sections: Hero · Keunggulan · Alur Kemitraan · Tipe Mitra · FAQ · Form Pendaftaran
 */

$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya tertarik untuk mendaftar sebagai mitra distribusi. Mohon informasi lebih lanjut.' );

get_header();
?>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         HERO
    ════════════════════════════════════════════════════════ -->
    <section class="about-hero-section" id="kemitraan-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1"></div>
            <div class="hero-glow hero-glow--2"></div>
        </div>

        <div class="container about-hero-container">
            <div class="about-hero-content reveal">
                <div class="hero-eyebrow">
                    <span class="hero-badge">
                        <span class="badge-dot" aria-hidden="true"></span>
                        Program Mitra B2B
                    </span>
                    <span class="hero-badge-sep" aria-hidden="true">/</span>
                    <span class="hero-badge hero-badge--plain">500+ Mitra Aktif</span>
                </div>

                <h1 class="hero-headline">
                    Bergabung &amp; Tumbuh<br>
                    Bersama <em>Indotech</em>
                </h1>
                <p class="hero-subtitle">
                    Jadilah bagian dari jaringan distributor produk homecare dan laundry terpercaya di Indonesia. Margin kompetitif, dukungan penuh, dan produk bersertifikat — siap mendorong bisnis Anda.
                </p>

                <div class="hero-actions">
                    <a href="#form-kemitraan" class="btn btn-gold btn-lg">
                        Daftar Mitra Sekarang
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                       class="btn btn-outline-white btn-lg"
                       target="_blank" rel="noopener">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Stats visual -->
            <div class="about-hero-visual" aria-hidden="true">
                <div class="hv-card hv-card--1">
                    <div class="hvc-top">
                        <div class="hvc-icon">MARGIN</div>
                        <span class="hvc-trend hvc-trend--up">Kompetitif</span>
                    </div>
                    <div class="hvc-value">25%+</div>
                    <div class="hvc-label">Rata-rata Margin Mitra</div>
                </div>
                <div class="hv-card hv-card--2">
                    <div class="hvc-top">
                        <div class="hvc-icon">SKU</div>
                        <span class="hvc-trend hvc-trend--up">+12%</span>
                    </div>
                    <div class="hvc-value">1.000+</div>
                    <div class="hvc-label">Pilihan Produk</div>
                </div>
                <div class="hv-badge-cert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                    Konsultasi Gratis &middot; Tanpa Komitmen Awal
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         KEUNGGULAN BERMITRA — 3 benefit cards
    ════════════════════════════════════════════════════════ -->
    <section class="services-section section-padding" id="keunggulan-mitra">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">Mengapa Bermitra?</span>
                <h2 class="section-title" style="margin-top:16px;">Keunggulan Menjadi Mitra <em>Indotech</em></h2>
                <p class="section-desc">Tiga keunggulan utama yang membuat ratusan pelaku usaha memilih bermitra bersama kami.</p>
            </div>

            <div class="services-grid" style="grid-template-columns: repeat(3, 1fr);">

                <article class="service-card reveal">
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h3 class="service-title">Margin Kompetitif</h3>
                    <p class="service-desc">Harga grosir eksklusif dengan margin keuntungan yang kompetitif di pasaran. Semakin besar volume order, semakin besar keuntungan Anda.</p>
                    <ul class="service-perks">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Harga grosir khusus mitra terdaftar
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Diskon volume progresif
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Promo dan cashback periodik
                        </li>
                    </ul>
                </article>

                <article class="service-card service-card--featured reveal reveal-delay-1">
                    <div class="service-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                        Unggulan
                    </div>
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <h3 class="service-title">Dukungan Marketing</h3>
                    <p class="service-desc">Tim marketing kami siap mendukung pertumbuhan bisnis Anda dengan materi promosi, konten digital, dan strategi penjualan yang terbukti efektif.</p>
                    <ul class="service-perks">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Materi promosi siap pakai
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Account manager khusus
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Pelatihan penjualan gratis
                        </li>
                    </ul>
                    <a href="#form-kemitraan" class="service-cta">
                        Daftar Sekarang
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </article>

                <article class="service-card reveal reveal-delay-2">
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="service-title">Produk Tersertifikasi</h3>
                    <p class="service-desc">Jual produk dengan keyakinan penuh. Semua lini produk kami telah tersertifikasi BPOM, Halal MUI, dan memenuhi standar ISO 9001 internasional.</p>
                    <ul class="service-perks">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Sertifikasi BPOM & Halal MUI
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Standar ISO 9001 terpenuhi
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            MSDS & dokumen lengkap tersedia
                        </li>
                    </ul>
                </article>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         ALUR KEMITRAAN — Step-by-step process
    ════════════════════════════════════════════════════════ -->
    <section class="about-story-section section-padding" id="alur-kemitraan" style="background:var(--surface);">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag section-tag--dark">Proses Mudah</span>
                <h2 class="section-title" style="margin-top:16px;">Alur Menjadi Mitra</h2>
                <p class="section-desc">Empat langkah sederhana untuk memulai perjalanan kemitraan bersama Indotech.</p>
            </div>

            <div class="partner-steps reveal">
                <div class="partner-step">
                    <div class="partner-step-num" aria-hidden="true">01</div>
                    <div class="partner-step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>
                    </div>
                    <h3>Isi Form Pendaftaran</h3>
                    <p>Lengkapi form pendaftaran mitra di bawah halaman ini atau hubungi kami via WhatsApp untuk konsultasi awal.</p>
                    <div class="partner-step-arrow" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>

                <div class="partner-step">
                    <div class="partner-step-num" aria-hidden="true">02</div>
                    <div class="partner-step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.92 12 19.79 19.79 0 0 1 1.93 3.4 2 2 0 0 1 3.9 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9a16 16 0 0 0 6.93 6.93l1.13-1.14a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <h3>Verifikasi & Konsultasi</h3>
                    <p>Tim kami akan menghubungi Anda dalam 1×24 jam untuk verifikasi data dan diskusi kebutuhan bisnis Anda.</p>
                    <div class="partner-step-arrow" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>

                <div class="partner-step">
                    <div class="partner-step-num" aria-hidden="true">03</div>
                    <div class="partner-step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3>Onboarding & Pelatihan</h3>
                    <p>Dapatkan orientasi produk, akses harga mitra, dan materi marketing dari account manager kami yang berpengalaman.</p>
                    <div class="partner-step-arrow" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>

                <div class="partner-step partner-step--last">
                    <div class="partner-step-num" aria-hidden="true">04</div>
                    <div class="partner-step-icon partner-step-icon--active">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/><polyline points="17,6 23,6 23,12"/></svg>
                    </div>
                    <h3>Aktif Berjualan!</h3>
                    <p>Mulai terima order, nikmati harga mitra, dan kembangkan bisnis Anda bersama dukungan penuh tim Indotech.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         TIPE MITRA — 4 tipe kemitraan
    ════════════════════════════════════════════════════════ -->
    <section class="about-values-section section-padding" id="tipe-mitra">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">Program Tersedia</span>
                <h2 class="section-title" style="margin-top:16px;">Tipe <em>Kemitraan</em></h2>
                <p class="section-desc">Pilih program kemitraan yang paling sesuai dengan skala dan model bisnis Anda.</p>
            </div>

            <div class="values-grid">
                <div class="value-card reveal">
                    <div class="partner-type-tag">Skala Besar</div>
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <h3 class="service-title">Distributor</h3>
                    <p class="service-desc">Untuk bisnis distribusi berskala besar dengan jangkauan regional atau nasional. Mendapatkan harga terbaik dan area distribusi eksklusif.</p>
                </div>

                <div class="value-card reveal reveal-delay-1">
                    <div class="partner-type-tag">Skala Menengah</div>
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <h3 class="service-title">Reseller</h3>
                    <p class="service-desc">Cocok untuk toko retail, e-commerce, atau pelaku usaha yang ingin menjual produk Indotech tanpa biaya operasional gudang besar.</p>
                </div>

                <div class="value-card reveal reveal-delay-2">
                    <div class="partner-type-tag">Horeka</div>
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
                    </div>
                    <h3 class="service-title">Hotel, Resto & Katering</h3>
                    <p class="service-desc">Solusi kebutuhan operasional hotel, restoran, dan katering. Pengiriman terjadwal, harga kontrak, dan layanan after-sales khusus.</p>
                </div>

                <div class="value-card reveal reveal-delay-3">
                    <div class="partner-type-tag">Korporat</div>
                    <div class="service-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3 class="service-title">Institusi & Korporat</h3>
                    <p class="service-desc">Untuk sekolah, rumah sakit, perkantoran, dan institusi pemerintah. Penawaran harga kontrak tahunan dan faktur resmi tersedia.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         FAQ — Pertanyaan umum kemitraan
    ════════════════════════════════════════════════════════ -->
    <section class="faq-section section-padding" id="faq-kemitraan" style="background:var(--surface);">
        <div class="container">

            <div class="section-header--split reveal">
                <div>
                    <span class="section-tag section-tag--dark">FAQ</span>
                    <h2 class="section-title" style="margin-top:16px;">Pertanyaan yang<br>Sering Ditanyakan</h2>
                </div>
                <div class="sh-divider" aria-hidden="true"></div>
                <div class="sh-right">
                    <p class="section-desc">Tidak menemukan jawaban yang Anda cari? Hubungi tim kami langsung via WhatsApp.</p>
                    <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                       class="btn btn-outline" target="_blank" rel="noopener">
                        Tanya via WhatsApp
                    </a>
                </div>
            </div>

            <div class="faq-list reveal">

                <details class="faq-item" id="faq-1">
                    <summary class="faq-question">
                        Berapa minimum order untuk menjadi mitra Indotech?
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                    </summary>
                    <div class="faq-answer">
                        <p>Minimum order pertama bervariasi tergantung tipe kemitraan. Untuk Reseller, mulai dari Rp 500.000. Untuk Distributor, mulai dari Rp 5.000.000. Silakan hubungi tim kami untuk penawaran yang disesuaikan dengan kebutuhan bisnis Anda.</p>
                    </div>
                </details>

                <details class="faq-item" id="faq-2">
                    <summary class="faq-question">
                        Apakah ada biaya pendaftaran untuk menjadi mitra?
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                    </summary>
                    <div class="faq-answer">
                        <p>Tidak ada biaya pendaftaran. Proses pendaftaran mitra Indotech sepenuhnya gratis. Anda hanya perlu melengkapi form pendaftaran dan menunggu verifikasi dari tim kami dalam 1×24 jam kerja.</p>
                    </div>
                </details>

                <details class="faq-item" id="faq-3">
                    <summary class="faq-question">
                        Bagaimana sistem pengiriman ke luar Jawa?
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                    </summary>
                    <div class="faq-answer">
                        <p>Kami melayani pengiriman ke seluruh 34 provinsi Indonesia melalui mitra ekspedisi terpercaya (JNE, J&T, SiCepat, dan ekspedisi kargo). Untuk order dalam jumlah besar ke luar Jawa, tersedia opsi pengiriman kargo dengan harga yang lebih efisien.</p>
                    </div>
                </details>

                <details class="faq-item" id="faq-4">
                    <summary class="faq-question">
                        Apakah produk Indotech sudah memiliki sertifikasi resmi?
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                    </summary>
                    <div class="faq-answer">
                        <p>Ya. Seluruh lini produk kami telah mendapatkan sertifikasi dari BPOM RI (Badan Pengawas Obat dan Makanan) dan label Halal dari MUI (Majelis Ulama Indonesia). Dokumen sertifikasi tersedia atas permintaan.</p>
                    </div>
                </details>

                <details class="faq-item" id="faq-5">
                    <summary class="faq-question">
                        Apakah tersedia dukungan marketing untuk mitra?
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                    </summary>
                    <div class="faq-answer">
                        <p>Tentu saja. Setiap mitra terdaftar mendapatkan: materi promosi digital (banner, foto produk, konten media sosial), akses ke katalog digital, pelatihan produk, dan dukungan dari account manager yang ditunjuk khusus untuk Anda.</p>
                    </div>
                </details>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         FORM PENDAFTARAN MITRA
    ════════════════════════════════════════════════════════ -->
    <section class="contact-section section-padding" id="form-kemitraan">
        <div class="container">

            <div class="contact-grid">

                <!-- Info kontak -->
                <div class="contact-info reveal">
                    <span class="section-tag">Daftar Sekarang</span>
                    <h2 class="section-title" style="margin-top:16px;font-size:clamp(28px,3.5vw,44px);">
                        Siap Memulai<br>Kemitraan?
                    </h2>
                    <p class="why-us-desc">
                        Isi form di samping dan tim kami akan menghubungi Anda dalam 1×24 jam kerja untuk mendiskusikan peluang kemitraan terbaik.
                    </p>

                    <div class="contact-wa-strip">
                        <div class="contact-wa-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        </div>
                        <div>
                            <span class="contact-wa-label">Atau chat langsung:</span>
                            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                               class="contact-wa-number" target="_blank" rel="noopener">
                                <?php echo esc_html( $whatsapp ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="contact-perks">
                        <div class="contact-perk">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Konsultasi gratis tanpa komitmen
                        </div>
                        <div class="contact-perk">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Respon dalam 1×24 jam kerja
                        </div>
                        <div class="contact-perk">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20,6 9,17 4,12"/></svg>
                            Data Anda aman dan terlindungi
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="contact-form-wrap reveal reveal-delay-1">
                    <?php
                    if ( ! wp_doing_ajax() ) {
                        wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' );
                    }
                    ?>
                    <form
                        id="indotech-inquiry-form"
                        class="contact-form"
                        data-form-type="kemitraan"
                        novalidate
                        aria-label="Form Pendaftaran Mitra"
                    >
                        <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>

                        <!-- Honeypot field -->
                        <div style="display:none;" aria-hidden="true">
                            <label for="website_url">Website</label>
                            <input type="url" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="partner-name">Nama Lengkap <span class="form-required">*</span></label>
                                <input
                                    type="text"
                                    id="partner-name"
                                    name="contact_name"
                                    class="form-input"
                                    placeholder="Nama Anda"
                                    required
                                    autocomplete="name"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="partner-company">Nama Perusahaan / Toko</label>
                                <input
                                    type="text"
                                    id="partner-company"
                                    name="company_name"
                                    class="form-input"
                                    placeholder="PT / CV / Toko ..."
                                    autocomplete="organization"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="partner-email">Alamat Email <span class="form-required">*</span></label>
                                <input
                                    type="email"
                                    id="partner-email"
                                    name="contact_email"
                                    class="form-input"
                                    placeholder="email@perusahaan.com"
                                    required
                                    autocomplete="email"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="partner-phone">Nomor WhatsApp <span class="form-required">*</span></label>
                                <input
                                    type="tel"
                                    id="partner-phone"
                                    name="contact_phone"
                                    class="form-input"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                    autocomplete="tel"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="partner-city">Kota / Kabupaten <span class="form-required">*</span></label>
                                <input
                                    type="text"
                                    id="partner-city"
                                    name="partner_city"
                                    class="form-input"
                                    placeholder="Kota domisili"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="partner-type">Tipe Kemitraan <span class="form-required">*</span></label>
                                <select id="partner-type" name="partner_type" class="form-input form-select" required>
                                    <option value="" disabled selected>Pilih tipe mitra...</option>
                                    <option value="distributor">Distributor</option>
                                    <option value="reseller">Reseller</option>
                                    <option value="horeka">Hotel / Restoran / Katering</option>
                                    <option value="institusi">Institusi / Korporat</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="partner-message">Ceritakan Bisnis Anda</label>
                            <textarea
                                id="partner-message"
                                name="contact_message"
                                class="form-input form-textarea"
                                rows="4"
                                placeholder="Ceritakan singkat tentang bisnis Anda dan produk apa yang Anda butuhkan..."
                            ></textarea>
                        </div>

                        <div id="indotech-inquiry-response" class="form-response" role="alert" aria-live="polite" style="display:none;"></div>

                        <button type="submit" id="partner-submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                            <span class="btn-text">Kirim Pendaftaran</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
