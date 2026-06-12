<?php
/**
 * Section: Partnership Flow
 * Alur kemitraan dari _landing-source.html.
 * Anchor: id="alur-kemitraan"
 */

$partnership_steps = [
    [
        'number'      => '1',
        'label'       => 'Langkah 01',
        'icon'        => 'support_agent',
        'icon_color'  => 'var(--color-accent-dark)',
        'icon_bg'     => 'var(--color-accent-soft)',
        'title'       => 'Konsultasi Gratis',
        'description' => 'Hubungi tim konsultan via WhatsApp untuk menceritakan lokasi, modal, dan target pasar Anda.',
        'badge'       => 'via WhatsApp',
        'badge_style' => 'wa',
    ],
    [
        'number'      => '2',
        'label'       => 'Langkah 02',
        'icon'        => 'storefront',
        'icon_color'  => 'var(--color-primary)',
        'icon_bg'     => 'var(--color-primary-soft)',
        'title'       => 'Pilih Paket Kemitraan',
        'description' => 'Pilih paket yang paling sesuai dengan modal dan kebutuhan bisnis Anda, mulai dari Starter hingga King.',
        'badge'       => 'Mulai dari Rp 15jt',
        'badge_style' => 'blue',
    ],
    [
        'number'      => '3',
        'label'       => 'Langkah 03',
        'icon'        => 'contract',
        'icon_color'  => 'var(--color-primary-dark)',
        'icon_bg'     => 'var(--color-primary-soft)',
        'title'       => 'Tanda Tangan Kontrak',
        'description' => 'Proses kontrak kemitraan dilakukan secara aman, jelas, dan sah secara hukum.',
        'badge'       => 'Legal & Aman',
        'badge_style' => 'green',
    ],
    [
        'number'      => '4',
        'label'       => 'Langkah 04',
        'icon'        => 'construction',
        'icon_color'  => 'var(--color-primary)',
        'icon_bg'     => 'var(--color-primary-soft)',
        'title'       => 'Persiapan Outlet',
        'description' => 'Tim membantu arahan layout, kebutuhan display, perlengkapan awal, dan persiapan operasional outlet.',
        'badge'       => 'Siap Dibuka',
        'badge_style' => 'blue',
    ],
    [
        'number'      => '5',
        'label'       => 'Langkah 05',
        'icon'        => 'school',
        'icon_color'  => 'var(--color-primary-dark)',
        'icon_bg'     => 'var(--color-primary-soft)',
        'title'       => 'Training & Pendampingan',
        'description' => 'Mitra mendapatkan panduan produk, cara jualan, operasional, serta pendampingan awal agar bisnis lebih siap berjalan.',
        'badge'       => 'Didampingi Tim',
        'badge_style' => 'green',
    ],
    [
        'number'      => '6',
        'label'       => 'Langkah 06',
        'icon'        => 'rocket_launch',
        'icon_color'  => 'var(--color-primary)',
        'icon_bg'     => 'var(--color-primary-soft)',
        'title'       => 'Mulai Berjualan',
        'description' => 'Outlet mulai beroperasi dengan dukungan produk, strategi promosi, dan sistem kemitraan yang sudah disiapkan.',
        'badge'       => 'Go Live 🚀',
        'badge_style' => 'green',
        'final'       => true,
    ],
];

$badge_styles = [
    'green' => 'background:var(--color-accent-soft);border:1px solid rgba(125,186,47,0.24);color:var(--color-accent-dark);',
    'blue'  => 'background:var(--color-primary-soft);border:1px solid rgba(11,126,219,0.2);color:var(--color-primary-dark);',
    'wa'    => 'background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.25);color:#1a9e52;',
];
?>

<section id="alur-kemitraan" class="partnership-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="partnership-heading">
            <div class="section-kicker">
                <span class="section-kicker-dot" aria-hidden="true"></span>
                <span>
                    Proses Bergabung
                </span>
            </div>
            <h2>
                Alur Kemitraan
            </h2>
            <p>
                6 langkah mudah dari konsultasi pertama hingga depo Anda mulai berjualan.
            </p>
        </div>

        <div class="relative max-w-[900px] mx-auto md:flex md:flex-col md:items-stretch">
            <div aria-hidden="true" class="partnership-timeline-line absolute top-[23px] bottom-0 left-[23px] md:left-1/2 md:-translate-x-1/2"></div>

            <?php foreach ( $partnership_steps as $index => $step ) : ?>
                <?php
                $is_odd        = 1 === ( ( $index + 1 ) % 2 );
                $desktop_class = $is_odd ? 'md:self-start md:flex-row-reverse' : 'md:self-end md:flex-row';
                $is_final      = ! empty( $step['final'] );
                ?>
                <article class="relative z-10 flex flex-row items-start gap-[18px] pb-9 md:pb-[52px] last:pb-0 md:w-[calc(50%+23px)] <?php echo esc_attr( $desktop_class ); ?>">
                    <div class="partnership-step-number<?php echo $is_final ? ' is-final' : ''; ?>">
                        <?php echo esc_html( $step['number'] ); ?>
                    </div>

                    <div
                        class="partnership-step-card min-w-0 flex-1<?php echo $is_final ? ' is-final' : ''; ?>"
                    >
                        <span class="partnership-step-label">
                            <?php echo esc_html( $step['label'] ); ?>
                        </span>
                        <div class="flex items-center gap-3 mb-2.5">
                            <div style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:<?php echo esc_attr( $step['icon_bg'] ); ?>;">
                                <span class="material-symbols-outlined" style="font-size:19px;color:<?php echo esc_attr( $step['icon_color'] ); ?>;font-variation-settings:'FILL' 1;" aria-hidden="true">
                                    <?php echo esc_html( $step['icon'] ); ?>
                                </span>
                            </div>
                            <h3>
                                <?php echo esc_html( $step['title'] ); ?>
                            </h3>
                        </div>
                        <p>
                            <?php echo esc_html( $step['description'] ); ?>
                        </p>
                        <span class="partnership-step-badge" style="<?php echo esc_attr( $badge_styles[ $step['badge_style'] ] ); ?>">
                            <?php echo esc_html( $step['badge'] ); ?>
                        </span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
