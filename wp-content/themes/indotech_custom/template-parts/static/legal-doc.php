<?php
/**
 * Shared Manufy Architectural Legal Document Renderer
 * Used by Privacy Policy, Syarat & Ketentuan, Cookie Policy, and Halaman Legal.
 */

$doc = wp_parse_args(
    $args ?? [],
    [
        'title'           => get_the_title(),
        'content'         => '',
        'headings'        => [],
        'last_updated'    => get_the_modified_date( 'd F Y' ) ?: wp_date( 'd F Y' ),
        'active_slug'     => '',
        'reading_minutes' => 3,
        'subtitle'        => 'Ketentuan resmi pengelolaan layanan B2B, transaksi grosir, serta pelindungan data mitra PT Indotech Berkah Abadi.',
    ]
);

$legal_docs = [
    'privacy-policy'   => [
        'label' => 'Kebijakan Privasi',
        'url'   => home_url( '/privacy-policy/' ),
    ],
    'syarat-ketentuan' => [
        'label' => 'Syarat & Ketentuan',
        'url'   => home_url( '/syarat-ketentuan/' ),
    ],
    'cookie-policy'    => [
        'label' => 'Kebijakan Cookie',
        'url'   => home_url( '/cookie-policy/' ),
    ],
];

$email = function_exists( 'indotech_opt' ) ? indotech_opt( 'email', 'indotechberkahabadi@gmail.com' ) : 'indotechberkahabadi@gmail.com';
$wa_num = preg_replace( '/[^0-9]/', '', function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088' );
$wa_msg = rawurlencode( 'Halo Indotech, saya memiliki pertanyaan terkait dokumen ' . $doc['title'] . '.' );
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="legal-hero" aria-labelledby="cs-legal-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php echo esc_html( $doc['title'] ); ?></span>
            </nav>

            <div class="cs-hero-head cs-hero-head--legal">
                <div class="cs-hero-copy">
                    <p><?php echo esc_html( $doc['subtitle'] ); ?></p>
                    <dl class="cs-doc-meta-strip">
                        <div>
                            <dt>Pembaruan Terakhir</dt>
                            <dd><?php echo esc_html( $doc['last_updated'] ); ?></dd>
                        </div>
                        <div>
                            <dt>Estimasi Baca</dt>
                            <dd><?php echo (int) $doc['reading_minutes']; ?> menit</dd>
                        </div>
                    </dl>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-legal-title" class="cs-hero-h1">
                        <span class="cs-h1-row">
                            <span class="ch-tilt-badge">Dokumen Resmi</span>
                        </span>
                        <span class="cs-h1-block"><?php echo esc_html( $doc['title'] ); ?></span>
                    </h1>
                </div>
            </div>

            <nav class="cs-doc-switcher" aria-label="Navigasi dokumen legal Indotech">
                <?php foreach ( $legal_docs as $slug => $item ) :
                    $is_current = ( $slug === $doc['active_slug'] );
                    ?>
                    <a
                        class="cs-doc-pill<?php echo $is_current ? ' is-active' : ''; ?>"
                        href="<?php echo esc_url( $item['url'] ); ?>"
                        <?php echo $is_current ? 'aria-current="page"' : ''; ?>
                    >
                        <?php echo esc_html( $item['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </section>

        <section class="cs-legal-band ch-wrap" id="legal-content" aria-label="Isi dokumen <?php echo esc_attr( $doc['title'] ); ?>">
            <div class="cs-legal-grid<?php echo empty( $doc['headings'] ) ? ' cs-legal-grid--single' : ''; ?>">
                <?php if ( ! empty( $doc['headings'] ) ) : ?>
                    <aside class="cs-legal-rail" id="legal-sidebar" aria-label="Daftar isi">
                        <div class="cs-legal-toc">
                            <div class="cs-toc-header">
                                <span class="cs-eyebrow-label">Daftar Isi</span>
                                <div class="cs-toc-progress" aria-hidden="true">
                                    <span class="cs-toc-progress-bar" data-legal-progress></span>
                                </div>
                            </div>
                            <nav aria-label="Daftar isi <?php echo esc_attr( $doc['title'] ); ?>">
                                <ul class="cs-toc-list" id="toc-list">
                                    <?php foreach ( $doc['headings'] as $h ) : ?>
                                        <li class="cs-toc-item cs-toc-item--lvl-<?php echo (int) $h['level']; ?>">
                                            <a href="#<?php echo esc_attr( $h['anchor'] ); ?>" class="legal-toc-link cs-toc-link">
                                                <?php echo esc_html( $h['text'] ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </div>
                    </aside>
                <?php endif; ?>

                <div class="cs-legal-body-col">
                    <article class="legal-content post-body cs-legal-article" id="legal-article">
                        <?php if ( ! empty( $doc['content'] ) ) : ?>
                            <?php echo $doc['content']; ?>
                        <?php else : ?>
                            <p class="cs-muted-note">Konten dokumen belum tersedia. Silakan lengkapi melalui editor halaman WordPress.</p>
                        <?php endif; ?>
                    </article>

                    <div class="cs-legal-footer-band">
                        <div class="cs-legal-footer-copy">
                            <span class="cs-pill-tag cs-pill-tag--lime">Kepatuhan &amp; Dukungan Legal</span>
                            <h2>Ada Pertanyaan Terkait <?php echo esc_html( $doc['title'] ); ?>?</h2>
                            <p>Hubungi tim legal dan layanan B2B PT Indotech Berkah Abadi untuk klarifikasi klausul kontrak, kemitraan, maupun pengelolaan data bisnis Anda.</p>
                        </div>
                        <div class="cs-legal-footer-actions">
                            <a href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>" class="ch-pill-cta">
                                <span>Hubungi Tim Indotech</span>
                                <span class="ch-pill-cta-icon" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="cs-dark-outline-btn">
                                <?php echo esc_html( $email ); ?>
                            </a>
                            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>" class="ch-lime-link" target="_blank" rel="noopener">
                                <span>Konsultasi via WhatsApp</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
