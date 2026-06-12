<?php
/**
 * Section: CTA Banner
 * Banner garansi dari _landing-source.html.
 */
?>

<section id="cta" class="dc-cta-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="dc-cta-card">
            <div class="dc-cta-icon-wrap" aria-hidden="true">
                <div class="dc-cta-icon">
                    <span class="material-symbols-outlined">verified_user</span>
                    <span class="dc-cta-icon-check material-symbols-outlined">check</span>
                </div>
            </div>

            <div class="dc-cta-content">
                <div class="dc-cta-badge">
                    <span class="dc-cta-badge-dot" aria-hidden="true"></span>
                    <span>GARANSI RESMI</span>
                </div>

                <h2 class="dc-cta-title">100% Success Guarantee</h2>
                <p class="dc-cta-copy">
                    Kami menjamin modal Anda akan kembali dalam <strong>12 bulan</strong>, atau kami mengembalikan dana Anda sepenuhnya.
                </p>
            </div>

            <div class="dc-cta-action">
                <a
                    href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>"
                    class="dc-cta-link"
                    aria-label="<?php esc_attr_e( 'Ambil jaminan sekarang melalui halaman kontak', 'depocleanique-custom' ); ?>"
                >
                    <span>Ambil Jaminan Sekarang</span>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </a>

                <div class="dc-cta-note">
                    <span class="material-symbols-outlined" aria-hidden="true">verified</span>
                    <span>Tanpa syarat tersembunyi</span>
                </div>
            </div>
        </div>
    </div>
</section>
