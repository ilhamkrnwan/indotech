<?php
/**
 * Section: Pricing
 * Paket kemitraan dari _landing-source.html.
 * Anchor: id="paket"
 */

// TODO: Convert pricing packages to editable fields in a later phase.

$packages = [
    [
        'name'           => 'Starter',
        'icon'           => 'rocket_launch',
        'price'          => '15jt',
        'discount_price' => '',
        'price_note'     => 'Rupiah',
        'payment_note'   => 'Sekali Bayar',
        'break_even'     => '4 – 6 Bulan',
        'progress'       => 52,
        'recommended'    => false,
        'cta_label'      => 'Pilih Paket Starter',
        'features'       => [
            [ 'label' => 'Hak Lisensi Seumur Hidup', 'included' => true ],
            [ 'label' => 'Initial Stok 200L (Campur)', 'included' => true ],
            [ 'label' => 'Banner & Media Promosi Offline', 'included' => true ],
            [ 'label' => '1 Month Premium Support', 'included' => true ],
            [ 'label' => 'Eksklusif Wilayah 5KM', 'included' => false ],
            [ 'label' => 'Full AI Marketing Support', 'included' => false ],
        ],
    ],
    [
        'name'           => 'King',
        'icon'           => 'crown',
        'price'          => '27.5jt',
        'discount_price' => '',
        'price_note'     => 'Rupiah',
        'payment_note'   => 'Sekali Bayar',
        'break_even'     => '3 – 4 Bulan',
        'progress'       => 88,
        'recommended'    => true,
        'badge'          => 'Paling Populer',
        'cta_label'      => 'Pilih Paket King →',
        'features'       => [
            [ 'label' => 'Eksklusif Area (Radius 5KM)', 'included' => true ],
            [ 'label' => 'Initial Stok 600L + Dispenser', 'included' => true ],
            [ 'label' => 'Full AI Marketing Support (3 Bulan)', 'included' => true ],
            [ 'label' => 'Lifetime Training & Priority Support', 'included' => true ],
            [ 'label' => '3D Interior Design Depo', 'included' => true ],
            [ 'label' => 'SEO Landing Page Eksklusif', 'included' => true ],
        ],
    ],
];

$trust_items = [
    [ 'icon' => 'shield', 'label' => '100% Garansi Modal Kembali' ],
    [ 'icon' => 'payments', 'label' => 'Tanpa Biaya Royalti' ],
    [ 'icon' => 'support_agent', 'label' => 'Support Seumur Hidup' ],
    [ 'icon' => 'verified', 'label' => 'Izin Kemenkes & Halal' ],
];
?>

<section id="paket" class="pricing-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="pricing-heading">
            <div class="section-kicker">
                <span class="section-kicker-dot" aria-hidden="true"></span>
                <span>
                    Investasi Sekali Seumur Hidup
                </span>
            </div>
            <h2>
                Pilihan Paket Kemitraan
            </h2>
            <p>
                Tidak ada royalti bulanan — bayar sekali, nikmati keuntungan selamanya.
            </p>
        </div>

        <div class="pricing-grid">
            <?php foreach ( $packages as $package ) : ?>
                <?php
                $is_recommended = ! empty( $package['recommended'] );
                $wa_message      = sprintf(
                    'Halo! Saya tertarik dengan Paket %s Depo Cleanique.',
                    $package['name']
                );
                ?>
                <article
                    class="pricing-card<?php echo $is_recommended ? ' is-featured' : ''; ?>"
                >
                    <?php if ( $is_recommended ) : ?>
                        <div class="pricing-popular-badge">
                            <span class="material-symbols-outlined" aria-hidden="true">star</span>
                            <span>
                                <?php echo esc_html( $package['badge'] ); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="pricing-card-head">
                        <div class="pricing-icon">
                            <span class="material-symbols-outlined" style="<?php echo 'crown' === $package['icon'] ? "font-variation-settings:'FILL' 1;" : ''; ?>" aria-hidden="true">
                                <?php echo esc_html( $package['icon'] ); ?>
                            </span>
                        </div>
                        <div>
                            <p class="pricing-eyebrow">
                                Paket
                            </p>
                            <h3>
                                <?php echo esc_html( $package['name'] ); ?>
                            </h3>
                        </div>
                    </div>

                    <div class="pricing-price-block">
                        <div class="pricing-price-row">
                            <?php if ( ! empty( $package['discount_price'] ) ) : ?>
                                <span class="pricing-discount-price">
                                    <?php echo esc_html( $package['price'] ); ?>
                                </span>
                                <span class="pricing-price">
                                    <?php echo esc_html( $package['discount_price'] ); ?>
                                </span>
                            <?php else : ?>
                                <span class="pricing-price">
                                    <?php echo esc_html( $package['price'] ); ?>
                                </span>
                            <?php endif; ?>
                            <div>
                                <p class="pricing-price-note">
                                    <?php echo esc_html( $package['price_note'] ); ?>
                                </p>
                                <p class="pricing-payment-note">
                                    <?php echo esc_html( $package['payment_note'] ); ?>
                                </p>
                            </div>
                        </div>

                        <div class="pricing-progress">
                            <div class="pricing-progress-meta">
                                <span>
                                    Est. Break Even
                                </span>
                                <strong>
                                    <?php echo esc_html( $package['break_even'] ); ?>
                                </strong>
                            </div>
                            <div class="pricing-progress-track">
                                <div class="pricing-progress-fill" style="width:<?php echo esc_attr( (string) absint( $package['progress'] ) ); ?>%;"></div>
                            </div>
                        </div>
                    </div>

                    <ul class="pricing-features">
                        <?php foreach ( $package['features'] as $feature ) : ?>
                            <li class="<?php echo $feature['included'] ? 'is-included' : 'is-muted'; ?>">
                                <span
                                    class="material-symbols-outlined"
                                    style="<?php echo $feature['included'] ? "font-variation-settings:'FILL' 1;" : ''; ?>"
                                    aria-hidden="true"
                                >
                                    <?php echo $feature['included'] ? 'check_circle' : 'remove_circle'; ?>
                                </span>
                                <span>
                                    <?php echo esc_html( $feature['label'] ); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <a
                        href="<?php echo esc_url( dc_get_wa_url( 'pricing', $wa_message ) ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="pricing-card-cta"
                        aria-label="<?php echo esc_attr( 'Pilih Paket ' . $package['name'] . ' via WhatsApp' ); ?>"
                    >
                        <?php echo esc_html( $package['cta_label'] ); ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="pricing-trust-row">
            <?php foreach ( $trust_items as $index => $item ) : ?>
                <?php if ( $index > 0 ) : ?>
                    <div class="pricing-trust-separator hidden md:block" aria-hidden="true"></div>
                <?php endif; ?>
                <div class="pricing-trust-item">
                    <span class="material-symbols-outlined" aria-hidden="true">
                        <?php echo esc_html( $item['icon'] ); ?>
                    </span>
                    <span>
                        <?php echo esc_html( $item['label'] ); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
