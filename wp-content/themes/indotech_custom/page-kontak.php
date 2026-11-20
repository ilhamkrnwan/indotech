<?php
/**
 * Template Name: Kontak
 *
 * Halaman Hubungi Kami PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 * Preserves #indotech-inquiry-form, #kontak-subject (including maklon & pelatihan), and AJAX nonce hooks.
 */

$phone    = function_exists( 'indotech_opt' ) ? indotech_opt( 'phone', '+62 856-0006-1005' ) : '+62 856-0006-1005';
$email    = function_exists( 'indotech_opt' ) ? indotech_opt( 'email', 'indotechberkahabadi@gmail.com' ) : 'indotechberkahabadi@gmail.com';
$address  = function_exists( 'indotech_opt' ) ? indotech_opt( 'address', 'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285' ) : 'Jongke Tengah No. 30, Sendangadi, Mlati, Sleman, Yogyakarta 55285';
$whatsapp = function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088';
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya mengenai produk, maklon, atau kemitraan.' );

$divisions = [
    [
        'role'  => 'CS Keagenan &amp; Maklon',
        'num'   => '+62 878-8559-0088',
        'href'  => 'https://wa.me/6287885590088',
        'note'  => 'Distributor, grosir curah &amp; private label Cleanique Lab',
    ],
    [
        'role'  => 'CS Pelatihan Formulasi',
        'num'   => '+62 822-1584-0088',
        'href'  => 'https://wa.me/6282215840088',
        'note'  => 'Kelas praktik &amp; jadwal Cleanique Academy',
    ],
    [
        'role'  => 'CS Retail &amp; Paket Usaha',
        'num'   => '+62 855-5947-4797',
        'href'  => 'https://wa.me/6285559474797',
        'note'  => 'Gerai Cleanique Mart &amp; Depo isi ulang',
    ],
];

$subject_chips = [
    'inquiry-produk'  => 'Permintaan Produk',
    'maklon'          => 'Jasa Maklon OEM',
    'kemitraan'       => 'Kemitraan Daerah',
    'pelatihan'       => 'Cleanique Academy',
    'penawaran-harga' => 'Penawaran Harga',
];

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 1: Manufy Split Hero + Borderless 3-Column Contact Ledger -->
        <section class="cs-hero cs-hero--compact ch-wrap" id="kontak-hero" aria-labelledby="cs-contact-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Kontak</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Tim konsultan B2B kami siap membantu permintaan penawaran grosir, maklon merek pribadi, program keagenan, hingga jadwal pelatihan.</p>
                    <div class="cs-hero-actions">
                        <a class="ch-pill-cta" href="#form-kontak">
                            <span>Isi Formulir B2B</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a class="ch-inline-link" href="#lokasi-peta">
                            <span>Lihat peta kantor</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </div>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-contact-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Ada yang Bisa</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Respon 1×24 Jam</span>
                            <span class="ch-h1-secondary">Kami Bantu?</span>
                        </span>
                    </h1>
                    <p class="ch-hero-aside">Senin – Sabtu<br>Sleman, Yogyakarta</p>
                </div>
            </div>

            <div class="cs-contact-ledger" id="info-kontak" aria-label="Saluran kontak resmi Indotech">
                <div class="cs-ledger-cell">
                    <span class="cs-eyebrow-label">Telepon Kantor</span>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[\s\-]/', '', $phone ) ); ?>" class="cs-ledger-val">
                        <?php echo esc_html( $phone ); ?>
                    </a>
                    <p>Senin – Jumat · 08.00 – 17.00 WIB</p>
                </div>

                <div class="cs-ledger-cell">
                    <span class="cs-eyebrow-label">Email Resmi</span>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="cs-ledger-val cs-ledger-val--cobalt">
                        <?php echo esc_html( $email ); ?>
                    </a>
                    <p>Balasan penawaran dalam 1×24 jam kerja</p>
                </div>

                <div class="cs-ledger-cell">
                    <span class="cs-eyebrow-label">Kantor Pusat &amp; Pabrik</span>
                    <p class="cs-ledger-address"><?php echo esc_html( $address ); ?></p>
                    <p>Kunjungan &amp; survei dengan perjanjian</p>
                </div>
            </div>
        </section>

        <!-- Band 2: Split Inquiry Form Studio (Left) + Obsidian-Navy 3-Division Concierge (Right) -->
        <section class="cs-band ch-wrap" id="form-kontak" aria-labelledby="cs-contact-form-title">
            <div class="cs-contact-studio">
                <div class="cs-studio-form-wrap cs-studio-form-wrap--primary">
                    <div class="cs-studio-form-head">
                        <span class="cs-pill-tag">Kirim Pesan</span>
                        <h2 id="cs-contact-form-title" class="ch-section-h2 ch-section-h2--sm">Formulir <span>Permintaan B2B</span></h2>
                        <p>Pilih topik cepat di bawah atau lengkapi data untuk terhubung langsung dengan konsultan kami.</p>
                    </div>

                    <div class="cs-subject-chips" role="group" aria-label="Pilih cepat topik konsultasi">
                        <?php foreach ( $subject_chips as $slug => $label ) : ?>
                            <button
                                type="button"
                                class="cs-subject-chip"
                                data-select-subject="<?php echo esc_attr( $slug ); ?>"
                            >
                                <?php echo esc_html( $label ); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <form
                        id="indotech-inquiry-form"
                        class="cs-form"
                        novalidate
                        aria-label="Form Kontak Indotech"
                    >
                        <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>

                        <div style="display:none;" aria-hidden="true">
                            <label for="website_url_kontak">Website</label>
                            <input type="url" name="website_url" id="website_url_kontak" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="cs-form-row">
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="kontak-name">Nama Lengkap <span class="form-required">*</span></label>
                                <input type="text" id="kontak-name" name="contact_name" class="cs-form-input" placeholder="Nama Anda / Nama Perusahaan" required autocomplete="name">
                            </div>
                            <div class="cs-form-group">
                                <label class="cs-form-label" for="kontak-phone">Nomor WhatsApp <span class="form-required">*</span></label>
                                <input type="tel" id="kontak-phone" name="contact_phone" class="cs-form-input" placeholder="08xxxxxxxxxx" required autocomplete="tel">
                            </div>
                        </div>

                        <div class="cs-form-group">
                            <label class="cs-form-label" for="kontak-subject">Subjek Konsultasi</label>
                            <select id="kontak-subject" name="subject" class="cs-form-input cs-form-select">
                                <option value="" disabled selected>Pilih topik...</option>
                                <option value="inquiry-produk">Permintaan Produk</option>
                                <option value="maklon">Jasa Maklon (OEM / Private Label)</option>
                                <option value="kemitraan">Kemitraan &amp; Distribusi</option>
                                <option value="pelatihan">Program Pelatihan (Cleanique Academy)</option>
                                <option value="penawaran-harga">Permintaan Penawaran Harga</option>
                                <option value="komplain">Keluhan / Komplain</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="cs-form-group">
                            <label class="cs-form-label" for="kontak-message">Detail Kebutuhan <span class="form-required">*</span></label>
                            <textarea id="kontak-message" name="contact_message" class="cs-form-input cs-form-textarea" rows="5" placeholder="Jelaskan jenis produk, estimasi volume order, atau kota pengiriman..." required></textarea>
                        </div>

                        <div id="indotech-inquiry-response" class="form-response" role="alert" aria-live="polite" style="display:none;"></div>

                        <button type="submit" id="kontak-submit" class="ch-pill-cta cs-form-submit">
                            <span class="btn-text">Kirim Pesan &amp; Buka WhatsApp</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </button>
                    </form>
                </div>

                <aside class="cs-studio-concierge" aria-label="Layanan WhatsApp Divisi Indotech">
                    <span class="cs-pill-tag cs-pill-tag--lime">Jalur Cepat WhatsApp</span>
                    <h2 class="cs-dark-h2 cs-dark-h2--sm">Terhubung Sesuai Divisi Anda</h2>
                    <p class="cs-studio-copy">Hubungi kontak divisi yang paling relevan untuk mendapatkan respon langsung.</p>

                    <ul class="cs-division-list">
                        <?php foreach ( $divisions as $div ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $div['href'] ); ?>?text=<?php echo $wa_msg; ?>" target="_blank" rel="noopener">
                                    <div class="cs-division-meta">
                                        <strong><?php echo wp_kses_post( $div['role'] ); ?></strong>
                                        <span><?php echo wp_kses_post( $div['note'] ); ?></span>
                                    </div>
                                    <span class="cs-division-num"><?php echo esc_html( $div['num'] ); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="cs-hours-block">
                        <h3>Jam Operasional Layanan</h3>
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
                                <span>Minggu &amp; Hari Libur</span>
                                <strong class="cs-hours-closed">Tutup</strong>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </section>

        <!-- Band 3: Full-Width Split Map Showcase -->
        <section class="cs-band ch-wrap" id="lokasi-peta" aria-labelledby="cs-contact-map-title">
            <div class="cs-hq-split cs-hq-split--light">
                <div class="cs-hq-info">
                    <span class="cs-pill-tag">Lokasi Fisik</span>
                    <h2 id="cs-contact-map-title" class="ch-section-h2 ch-section-h2--sm">Sleman, <span>Yogyakarta</span></h2>
                    <p class="cs-hq-address"><?php echo esc_html( $address ); ?></p>
                    <p class="cs-hq-note">Silakan jadwalkan kunjungan sampel, diskusi maklon, atau konsultasi formulasi langsung di kantor operasional kami.</p>

                    <div class="cs-hq-actions">
                        <a
                            href="https://maps.google.com/?q=PT.+Indotech+Berkah+Abadi+Sleman+Yogyakarta"
                            class="ch-pill-cta"
                            target="_blank"
                            rel="noopener"
                        >
                            <span>Petunjuk Arah Maps</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" class="ch-inline-link" target="_blank" rel="noopener">
                            <span>Konfirmasi via WhatsApp</span>
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
    </div>
</main>

<?php get_footer(); ?>
