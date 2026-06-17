<?php
/**
 * Template Name: Kontak
 * Template: page-kontak
 */

get_header();
get_template_part( 'template-parts/layout/site-header' );
?>

<main id="main-content">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>

            <?php
            get_template_part(
                'template-parts/page-hero',
                null,
                [
                    'page_type'    => 'contact',
                    'post_id'      => get_the_ID(),
                    'eyebrow'      => __( 'Hubungi Kami', 'depocleanique-custom' ),
                    'title_line_1' => __( 'Mari Mulai', 'depocleanique-custom' ),
                    'title_line_2' => __( 'Percakapan.', 'depocleanique-custom' ),
                    'description'  => __( 'Konsultasikan lokasi, kebutuhan, dan rencana bisnis Anda bersama tim Depo Cleanique.', 'depocleanique-custom' ),
                    'button_label' => __( 'Konsultasi Gratis', 'depocleanique-custom' ),
                    'button_url'   => dc_get_wa_url( 'contact' ),
                    'meta_items'   => [
                        [
                            'icon'  => 'forum',
                            'label' => __( 'Kanal', 'depocleanique-custom' ),
                            'value' => __( 'WhatsApp', 'depocleanique-custom' ),
                        ],
                        [
                            'icon'  => 'schedule',
                            'label' => __( 'Operasional', 'depocleanique-custom' ),
                            'value' => dc_get_business_hours(),
                        ],
                        [
                            'icon'  => 'location_on',
                            'label' => __( 'HQ', 'depocleanique-custom' ),
                            'value' => __( 'Yogyakarta', 'depocleanique-custom' ),
                        ],
                    ],
                ]
            );
            ?>

            <section class="internal-contact-section">
                <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
                    <div class="internal-contact-grid">
                        <div class="internal-contact-copy">
                            <div class="section-kicker">
                                <span class="section-kicker-dot" aria-hidden="true"></span>
                                <span><?php esc_html_e( 'Kontak & Konsultasi', 'depocleanique-custom' ); ?></span>
                            </div>
                            <h2><?php esc_html_e( 'Tim Kami Siap Membantu', 'depocleanique-custom' ); ?></h2>
                            <div class="dc-page-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <aside class="internal-contact-panel" aria-label="<?php esc_attr_e( 'Informasi kontak Depo Cleanique', 'depocleanique-custom' ); ?>">
                            <h2><?php esc_html_e( 'Informasi Kontak', 'depocleanique-custom' ); ?></h2>

                            <div class="internal-contact-list">
                                <a class="internal-contact-item" href="<?php echo esc_url( dc_get_wa_url( 'contact' ) ); ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="material-symbols-outlined" aria-hidden="true">chat</span>
                                    <div>
                                        <strong><?php esc_html_e( 'WhatsApp', 'depocleanique-custom' ); ?></strong>
                                        <p><?php echo esc_html( dc_get_wa_label() ); ?></p>
                                    </div>
                                </a>

                                <a class="internal-contact-item" href="<?php echo esc_url( 'mailto:' . dc_get_email() ); ?>">
                                    <span class="material-symbols-outlined" aria-hidden="true">mail</span>
                                    <div>
                                        <strong><?php esc_html_e( 'Email', 'depocleanique-custom' ); ?></strong>
                                        <p><?php echo esc_html( dc_get_email() ); ?></p>
                                    </div>
                                </a>

                                <div class="internal-contact-item">
                                    <span class="material-symbols-outlined" aria-hidden="true">schedule</span>
                                    <div>
                                        <strong><?php esc_html_e( 'Jam Operasional', 'depocleanique-custom' ); ?></strong>
                                        <p><?php echo esc_html( dc_get_business_hours() ); ?></p>
                                    </div>
                                </div>

                                <div class="internal-contact-item">
                                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                                    <div>
                                        <strong><?php esc_html_e( 'Alamat HQ', 'depocleanique-custom' ); ?></strong>
                                        <address><?php echo dc_get_address_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></address>
                                    </div>
                                </div>
                            </div>

                            <a class="internal-contact-cta" href="<?php echo esc_url( dc_get_wa_url( 'contact' ) ); ?>" target="_blank" rel="noopener noreferrer">
                                <span><?php esc_html_e( 'Konsultasi via WhatsApp', 'depocleanique-custom' ); ?></span>
                                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                            </a>
                        </aside>
                    </div>

                    <!-- Peta Lokasi (Google Maps Embed) -->
                    <div class="internal-contact-map-row mt-16">
                        <div class="bg-white p-4 rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden">
                            <iframe
                                src="https://maps.google.com/maps?q=<?php echo urlencode( dc_get_address() ); ?>&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                width="100%"
                                height="450"
                                style="border:0; border-radius: 12px; display: block;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="<?php esc_attr_e( 'Lokasi Depo Cleanique', 'depocleanique-custom' ); ?>"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </section>

        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
