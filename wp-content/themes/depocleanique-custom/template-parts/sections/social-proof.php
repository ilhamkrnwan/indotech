<?php
/**
 * Section: Social Proof
 * Diport dari _landing-source.html — 3 stat utama (strip biru gelap).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section class="social-proof-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="social-proof-grid">
            <article class="social-proof-item">
                <div class="social-proof-icon" aria-hidden="true">
                    <span class="material-symbols-outlined">package_2</span>
                </div>
                <div class="social-proof-copy">
                    <h3>1.000.000+</h3>
                    <p><?php esc_html_e( 'Produk Terjual Nasional', 'depocleanique-custom' ); ?></p>
                </div>
            </article>

            <article class="social-proof-item is-featured">
                <div class="social-proof-icon" aria-hidden="true">
                    <span class="material-symbols-outlined">verified_user</span>
                </div>
                <div class="social-proof-copy">
                    <h3>100% <?php esc_html_e( 'Aman', 'depocleanique-custom' ); ?></h3>
                    <p><?php esc_html_e( 'Izin Kemenkes & Halal', 'depocleanique-custom' ); ?></p>
                </div>
            </article>

            <article class="social-proof-item">
                <div class="social-proof-icon" aria-hidden="true">
                    <span class="material-symbols-outlined">history</span>
                </div>
                <div class="social-proof-copy">
                    <h3>12+ <?php esc_html_e( 'Tahun', 'depocleanique-custom' ); ?></h3>
                    <p><?php esc_html_e( 'Pengalaman Industri', 'depocleanique-custom' ); ?></p>
                </div>
            </article>
        </div>
    </div>
</section>
