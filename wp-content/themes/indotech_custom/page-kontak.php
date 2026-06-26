<?php
/**
 * Template Name: Kontak
 *
 * Halaman Hubungi Kami PT Indotech Berkah Abadi.
 * Sections: Hero · Info Kontak · Map · Form Inquiry · WhatsApp Strip
 */

$phone    = indotech_opt( 'phone',    '+62 856-0006-1005' );
$email    = indotech_opt( 'email',    'indotechberkahabadi@gmail.com' );
$address  = indotech_opt( 'address',  'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285' );
$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya mengenai produk/layanan Anda.' );

get_header();
?>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         PAGE HERO — Pendek, elegant
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero" id="kontak-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Kontak</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Hubungi Kami</span>
            <h1 class="inner-page-title">Ada yang Bisa <em>Kami Bantu?</em></h1>
            <p class="inner-page-subtitle">Tim kami siap menjawab pertanyaan Anda seputar produk, kemitraan, dan distribusi. Respon dalam 1×24 jam kerja.</p>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         INFO KONTAK — 3 kartu informasi
    ════════════════════════════════════════════════════════ -->
    <section class="contact-info-section section-padding" id="info-kontak" style="background:var(--surface);">
        <div class="container">
            <div class="contact-cards-grid">

                <div class="contact-info-card reveal">
                    <div class="contact-info-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.92 12 19.79 19.79 0 0 1 1.93 3.4 2 2 0 0 1 3.9 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9a16 16 0 0 0 6.93 6.93l1.13-1.14a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <span class="contact-info-label">Telepon</span>
                    <a href="tel:<?php echo esc_attr( preg_replace('/[\s\-]/', '', $phone) ); ?>" class="contact-info-value">
                        <?php echo esc_html( $phone ); ?>
                    </a>
                    <p class="contact-info-note">Senin – Jumat, 08.00 – 17.00 WIB</p>
                </div>

                <div class="contact-info-card contact-info-card--featured reveal reveal-delay-1">
                    <div class="contact-info-icon" style="background:#ffffff; border-color:#ffffff; color:var(--cobalt);" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <span class="contact-info-label" style="color:rgba(255,255,255,.5);">Email</span>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-info-value" style="color:var(--white);">
                        <?php echo esc_html( $email ); ?>
                    </a>
                    <p class="contact-info-note" style="color:rgba(255,255,255,.45);">Balasan dalam 1×24 jam kerja</p>
                </div>

                <div class="contact-info-card reveal reveal-delay-2">
                    <div class="contact-info-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <span class="contact-info-label">Kantor</span>
                    <span class="contact-info-value contact-info-value--text">
                        <?php echo esc_html( $address ); ?>
                    </span>
                    <p class="contact-info-note">Kunjungan dengan perjanjian</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         FORM + MAP — Layout 2 kolom
    ════════════════════════════════════════════════════════ -->
    <section class="contact-section section-padding" id="form-kontak">
        <div class="container">

            <div class="contact-grid">

                <!-- Form Inquiry -->
                <div class="contact-form-wrap reveal">

                    <div style="margin-bottom:36px;">
                        <span class="section-tag section-tag--dark">Kirim Pesan</span>
                        <h2 class="section-title" style="margin-top:16px;font-size:clamp(26px,3vw,40px);">Form Inquiry</h2>
                        <p class="section-desc" style="max-width:100%;">Isi form di bawah dan kami akan menghubungi Anda secepatnya.</p>
                    </div>

                    <form
                        id="indotech-inquiry-form"
                        class="contact-form"
                        novalidate
                        aria-label="Form Kontak Indotech"
                    >
                        <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>

                        <!-- Honeypot -->
                        <div style="display:none;" aria-hidden="true">
                            <label for="website_url_kontak">Website</label>
                            <input type="url" name="website_url" id="website_url_kontak" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="kontak-name">Nama Lengkap <span class="form-required">*</span></label>
                                <input type="text" id="kontak-name" name="contact_name" class="form-input" placeholder="Nama Anda" required autocomplete="name">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="kontak-phone">Nomor WhatsApp <span class="form-required">*</span></label>
                                <input type="tel" id="kontak-phone" name="contact_phone" class="form-input" placeholder="08xxxxxxxxxx" required autocomplete="tel">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kontak-email">Alamat Email <span class="form-required">*</span></label>
                            <input type="email" id="kontak-email" name="contact_email" class="form-input" placeholder="email@perusahaan.com" required autocomplete="email">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kontak-subject">Subjek</label>
                            <select id="kontak-subject" name="subject" class="form-input form-select">
                                <option value="" disabled selected>Pilih topik...</option>
                                <option value="inquiry-produk">Inquiry Produk</option>
                                <option value="kemitraan">Kemitraan & Distribusi</option>
                                <option value="penawaran-harga">Permintaan Penawaran Harga</option>
                                <option value="komplain">Keluhan / Komplain</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kontak-message">Pesan <span class="form-required">*</span></label>
                            <textarea id="kontak-message" name="contact_message" class="form-input form-textarea" rows="5" placeholder="Ceritakan kebutuhan Anda..." required></textarea>
                        </div>

                        <div id="indotech-inquiry-response" class="form-response" role="alert" aria-live="polite" style="display:none;"></div>

                        <button type="submit" id="kontak-submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                            <span class="btn-text">Kirim Pesan</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22,2 15,22 11,13 2,9"/></svg>
                        </button>

                    </form>
                </div>

                <!-- Informasi tambahan + Map -->
                <div class="contact-info reveal reveal-delay-1">

                    <div class="contact-map-placeholder" aria-label="Peta Lokasi PT Indotech Berkah Abadi">
                        <iframe
                            src="https://maps.google.com/maps?q=PT.+Indotech+Berkah+Abadi+Sleman+Yogyakarta&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <div class="contact-wa-strip" style="margin-top:28px;">
                        <div class="contact-wa-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        </div>
                        <div>
                            <span class="contact-wa-label">Chat langsung via WhatsApp:</span>
                            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                               class="contact-wa-number"
                               target="_blank" rel="noopener">
                                <?php echo esc_html( $whatsapp ); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="operating-hours">
                        <h4 class="oh-title">Jam Operasional</h4>
                        <ul class="oh-list">
                            <li>
                                <span class="oh-day">Senin – Jumat</span>
                                <span class="oh-time">08.00 – 17.00 WIB</span>
                            </li>
                            <li>
                                <span class="oh-day">Sabtu</span>
                                <span class="oh-time">08.00 – 13.00 WIB</span>
                            </li>
                            <li>
                                <span class="oh-day">Minggu & Hari Libur</span>
                                <span class="oh-time oh-closed">Tutup</span>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         WHATSAPP CTA STRIP
    ════════════════════════════════════════════════════════ -->
    <section class="wa-cta-strip" id="wa-strip">
        <div class="container wa-cta-inner">
            <div class="wa-cta-text">
                <span class="wa-cta-title">Lebih cepat via WhatsApp?</span>
                <span class="wa-cta-sub">Tim kami aktif Senin–Sabtu, 08.00–17.00 WIB</span>
            </div>
            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
               class="btn wa-cta-btn"
               target="_blank" rel="noopener"
               id="wa-cta-strip-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Chat WhatsApp Sekarang
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
