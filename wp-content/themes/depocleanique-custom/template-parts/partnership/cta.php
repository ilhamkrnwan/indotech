<?php
/**
 * Partnership CTA block.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();
$wa_url  = is_singular( 'partnership' ) ? dc_get_partnership_whatsapp_url( $post_id ) : dc_get_wa_url( 'partnership' );
?>

<section class="partnership-cta-section" aria-labelledby="partnership-cta-title">
    <div>
        <span><?php esc_html_e( 'Kemitraan Depo Cleanique', 'depocleanique-custom' ); ?></span>
        <h2 id="partnership-cta-title"><?php esc_html_e( 'Ingin terdaftar sebagai mitra Depo Cleanique?', 'depocleanique-custom' ); ?></h2>
        <p><?php esc_html_e( 'Hubungi tim kami untuk membahas peluang kerja sama, area operasional, dan kebutuhan produk.', 'depocleanique-custom' ); ?></p>
    </div>
    <a class="partnership-button partnership-button-light" href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener noreferrer">
        <?php echo dc_icon( 'message-circle' ); ?>
        <?php esc_html_e( 'Hubungi WhatsApp', 'depocleanique-custom' ); ?>
    </a>
</section>
