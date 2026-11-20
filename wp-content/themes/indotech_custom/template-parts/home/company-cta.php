<?php
/**
 * Orbital CTA Penutup — Gaya Cincin Orbit Manufy dengan Foto Kolaborasi & Logistik Indotech.
 */

$media_cp    = get_theme_file_uri( 'assets/images/company-profile' );
$contact_url = home_url( '/kontak/#form-kontak' );
$wa_num      = preg_replace( '/[^0-9]/', '', indotech_opt( 'whatsapp', '6287885590088' ) );
$wa_msg      = rawurlencode( 'Halo Indotech, saya ingin mendiskusikan kebutuhan B2B (pasokan/maklon/kemitraan/pelatihan).' );
?>

<section class="ch-orbital-cta" aria-labelledby="ch-cta-title">
    <div class="ch-orbit-rings" aria-hidden="true">
        <span class="ch-orbit-ring ch-orbit-ring--inner"></span>
        <span class="ch-orbit-ring ch-orbit-ring--outer"></span>
    </div>

    <div class="ch-wrap ch-orbital-inner">
        <p class="ch-orbital-note">Kami mendampingi pertumbuhan bisnis kebersihan Anda dari Sleman ke 34 provinsi.</p>

        <figure class="ch-orbital-photo ch-orbital-photo--tr">
            <img
                src="<?php echo esc_url( $media_cp . '/cta-logistics-b2b.webp' ); ?>"
                width="1376"
                height="768"
                alt="Stok kemasan jeriken industri HDPE dan logistik pengiriman kargo PT Indotech Berkah Abadi"
                loading="lazy"
                decoding="async"
            >
        </figure>

        <div class="ch-orbital-center">
            <h2 id="ch-cta-title" class="ch-orbital-h2">Siap Memulai<br>Kerja Sama B2B?</h2>
            <p>Diskusikan kebutuhan pengadaan grosir, maklon produk, kemitraan gerai, atau pelatihan formulasi bersama tim kami.</p>
            <div class="ch-orbital-actions">
                <a class="ch-pill-cta" href="<?php echo esc_url( $contact_url ); ?>">
                    <span>Konsultasi B2B</span>
                    <span class="ch-pill-cta-icon" aria-hidden="true">
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </span>
                </a>
                <a class="ch-inline-link" href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" target="_blank" rel="noopener">
                    <span>Chat WhatsApp B2B</span>
                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                </a>
            </div>
        </div>

        <figure class="ch-orbital-photo ch-orbital-photo--bl">
            <img
                src="<?php echo esc_url( $media_cp . '/cta-collab-b2b.webp' ); ?>"
                width="1376"
                height="768"
                alt="Stasiun isi ulang modern Depo Cleanique dan kemitraan produk kebersihan PT Indotech Berkah Abadi"
                loading="lazy"
                decoding="async"
            >
        </figure>

        <div class="ch-orbital-trust">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26"></polygon></svg>
            <span>15+ Tahun · Kemenkes PKRT &amp; Halal</span>
        </div>
    </div>
</section>
