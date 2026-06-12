<?php
/**
 * Section: Hero
 * Diport dari _landing-source.html — split layout, float cards, stats.
 * Gambar lokal: assets/images/hero-store.jpg (path via get_template_directory_uri()).
 * CTA WhatsApp via helper dc_get_wa_url().
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$dc_img = get_template_directory_uri() . '/assets/images';
?>

<header class="hero-bg relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden">
    <!-- Decorative blobs -->
    <div class="hero-blob-green" style="top: -120px; right: -80px"></div>
    <div class="hero-blob-blue" style="bottom: -60px; left: -60px"></div>
    <!-- Soft grid texture overlay -->
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(rgba(8,121,201,0.05) 1px, transparent 1px); background-size: 28px 28px; opacity: 0.7;"></div>

    <div class="container mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
        <div class="grid md:grid-cols-2 gap-14 lg:gap-24 items-center">
            <!-- ────────────── LEFT : Copy ────────────── -->
            <div class="space-y-8">
                <!-- Badge -->
                <div class="hero-badge">
                    <span class="material-symbols-outlined" style="font-size: 15px; color: #78be20; font-variation-settings: 'FILL' 1;">verified</span>
                    <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #075a96;">
                        <?php esc_html_e( 'Terpercaya Sejak 2011', 'depocleanique-custom' ); ?>
                    </span>
                </div>

                <!-- Headline -->
                <div>
                    <h1 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(36px, 5vw, 56px); font-weight: 800; line-height: 1.1; letter-spacing: -0.025em; color: #17212b;">
                        <?php esc_html_e( 'Peluang Usaha', 'depocleanique-custom' ); ?><br />
                        <span style="color: #0879c9; position: relative; display: inline-block;">
                            <?php esc_html_e( 'Depo Sabun Curah', 'depocleanique-custom' ); ?>
                            <!-- Underline accent -->
                            <svg aria-hidden="true" style="position: absolute; bottom: -6px; left: 0; width: 100%; height: 8px;" viewBox="0 0 300 8" preserveAspectRatio="none">
                                <path d="M0 6 Q75 0 150 5 Q225 10 300 4" stroke="#78be20" stroke-width="3" fill="none" stroke-linecap="round" />
                            </svg>
                        </span>
                        <br />&amp; Homecare
                    </h1>
                </div>

                <!-- Body -->
                <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; line-height: 1.7; color: #66727d; max-width: 440px;">
                    <?php esc_html_e( 'Investasi cerdas dengan dukungan', 'depocleanique-custom' ); ?>
                    <strong style="color: #075a96"><?php esc_html_e( 'AI marketing', 'depocleanique-custom' ); ?></strong>
                    <?php esc_html_e( 'dan produk kebutuhan harian yang pasti laku. Ekosistem bisnis modern yang teruji.', 'depocleanique-custom' ); ?>
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-3">
                    <a class="hero-cta-primary"
                       href="<?php echo esc_url( dc_get_wa_url( 'hero' ) ); ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Mulai Investasi', 'depocleanique-custom' ); ?>
                        <span class="material-symbols-outlined" style="font-size: 18px">trending_up</span>
                    </a>
                    <a class="hero-cta-ghost" href="<?php echo esc_url( home_url( '/#keunggulan' ) ); ?>">
                        <?php esc_html_e( 'Pelajari Selengkapnya', 'depocleanique-custom' ); ?>
                    </a>
                </div>

                <!-- Animated social proof ticker -->
                <div class="hero-ticker" aria-label="<?php esc_attr_e( 'Ringkasan kepercayaan dan performa Depo Cleanique', 'depocleanique-custom' ); ?>">
                    <?php
                    $hero_ticker_items = [
                        '500+ Mitra Aktif',
                        '74% Growth YoY',
                        'Break Even 4&ndash;6 Bulan',
                        'Dipercaya UMKM &amp; Retail',
                        'Produk Kebutuhan Harian',
                        'Support Marketing &amp; Branding',
                    ];
                    ?>
                    <?php for ( $i = 0; $i < 2; $i++ ) : ?>
                        <div class="hero-ticker-track" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
                            <?php foreach ( $hero_ticker_items as $item ) : ?>
                                <span class="hero-ticker-item">
                                    <?php echo wp_kses_post( $item ); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- ────────────── RIGHT : Visual ────────────── -->
            <div class="hidden md:block relative" style="padding: 20px 20px 40px 10px">
                <!-- Main image -->
                <div class="hero-image-wrap" style="aspect-ratio: 4/3; position: relative">
                    <img src="<?php echo esc_url( $dc_img . '/hero-store.jpg' ); ?>"
                         alt="<?php esc_attr_e( 'Depo Cleanique Store', 'depocleanique-custom' ); ?>"
                         style="width: 100%; height: 100%; object-fit: cover;" />
                    <!-- Subtle vignette at bottom -->
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.12) 0%, transparent 40%); border-radius: 28px;"></div>
                    <!-- Label chip on image -->
                    <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.92); backdrop-filter: blur(8px); border-radius: 12px; padding: 6px 14px; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #78be20; display: inline-block;"></span>
                        <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: #17212b;"><?php esc_html_e( 'Buka Sekarang', 'depocleanique-custom' ); ?></span>
                    </div>
                </div>

                <!-- Float Card: Investment (bottom-left) -->
                <div class="float-card float-anim" style="position: absolute; bottom: -28px; left: -24px; padding: 16px 20px; min-width: 190px;">
                    <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 600; color: #66727d; letter-spacing: 0.04em; text-transform: uppercase;"><?php esc_html_e( 'Min. Investment', 'depocleanique-custom' ); ?></p>
                    <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: #123b5d; margin: 4px 0 8px;">Rp 15 Juta</p>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span class="material-symbols-outlined" style="font-size: 14px; color: #4d7f0b; font-variation-settings: 'FILL' 1;">trending_up</span>
                        <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: #4d7f0b;"><?php esc_html_e( '+74% per tahun', 'depocleanique-custom' ); ?></span>
                    </div>
                </div>

                <!-- Float Card: Progress (top-right) -->
                <div class="float-card float-anim-slow" style="position: absolute; top: -20px; right: -20px; padding: 16px 20px; min-width: 180px;">
                    <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 600; color: #66727d; letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 10px;"><?php esc_html_e( 'Target Progress', 'depocleanique-custom' ); ?></p>
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                        <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: #17212b;">Q4 2024</span>
                        <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: #075a96;">88%</span>
                    </div>
                    <div style="width: 100%; height: 7px; background: #eaf6fd; border-radius: 999px; overflow: hidden;">
                        <div class="mini-bar" style="width: 88%; height: 100%"></div>
                    </div>
                    <!-- Mini bar chart -->
                    <div style="display: flex; align-items: flex-end; gap: 3px; margin-top: 12px; height: 28px;">
                        <div style="flex: 1; background: #cfefff; border-radius: 3px 3px 0 0; height: 45%;"></div>
                        <div style="flex: 1; background: #8fd1f5; border-radius: 3px 3px 0 0; height: 60%;"></div>
                        <div style="flex: 1; background: #0879c9; border-radius: 3px 3px 0 0; height: 75%;"></div>
                        <div style="flex: 1; background: #78be20; border-radius: 3px 3px 0 0; height: 100%;"></div>
                    </div>
                </div>

                <!-- Float Card: Break Even (bottom-right) -->
                <div class="float-card" style="position: absolute; bottom: -16px; right: 20px; padding: 14px 18px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #eaf6fd; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 20px; color: #0879c9; font-variation-settings: 'FILL' 1;">schedule</span>
                    </div>
                    <div>
                        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 600; color: #66727d;"><?php esc_html_e( 'Break Even', 'depocleanique-custom' ); ?></p>
                        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: #123b5d;">4&ndash;6 Bulan</p>
                    </div>
                </div>
            </div>
            <!-- end RIGHT -->
        </div>
    </div>
</header>
