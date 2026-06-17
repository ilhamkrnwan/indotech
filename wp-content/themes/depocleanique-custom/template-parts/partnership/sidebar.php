<?php
/**
 * Sticky sidebar for partnership single.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id    = get_the_ID();
$summary    = dc_get_partnership_summary( $post_id );
$location   = dc_get_partnership_location( $post_id );
$owner      = dc_get_partnership_meta( $post_id, '_partnership_owner' );
$phone      = dc_get_partnership_meta( $post_id, '_partnership_phone' );
$address    = dc_get_partnership_meta( $post_id, '_partnership_address' );
$since      = dc_get_partnership_meta( $post_id, '_partnership_since' );
$type_label = dc_get_partnership_types_label( $post_id );
?>

<aside class="partnership-sidebar" aria-label="<?php esc_attr_e( 'Ringkasan mitra', 'depocleanique-custom' ); ?>">
    <h2><?php esc_html_e( 'Informasi Mitra', 'depocleanique-custom' ); ?></h2>
    <?php if ( $summary ) : ?>
        <p><?php echo esc_html( $summary ); ?></p>
    <?php endif; ?>
    <dl>
        <div>
            <dt><?php esc_html_e( 'Kota / area', 'depocleanique-custom' ); ?></dt>
            <dd><?php echo esc_html( $location ?: '-' ); ?></dd>
        </div>
        <?php if ( $address ) : ?>
            <div>
                <dt><?php esc_html_e( 'Alamat lengkap', 'depocleanique-custom' ); ?></dt>
                <dd><?php echo nl2br( esc_html( $address ) ); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ( $owner ) : ?>
            <div>
                <dt><?php esc_html_e( 'Penanggung jawab', 'depocleanique-custom' ); ?></dt>
                <dd><?php echo esc_html( $owner ); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ( $phone ) : ?>
            <div>
                <dt><?php esc_html_e( 'Kontak', 'depocleanique-custom' ); ?></dt>
                <dd><?php echo esc_html( $phone ); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ( $since ) : ?>
            <div>
                <dt><?php esc_html_e( 'Bergabung sejak', 'depocleanique-custom' ); ?></dt>
                <dd><?php echo esc_html( $since ); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ( $type_label ) : ?>
            <div>
                <dt><?php esc_html_e( 'Jenis kemitraan', 'depocleanique-custom' ); ?></dt>
                <dd><?php echo esc_html( $type_label ); ?></dd>
            </div>
        <?php endif; ?>
    </dl>
    <a class="partnership-button partnership-button-primary partnership-sidebar-cta" href="<?php echo esc_url( dc_get_partnership_whatsapp_url( $post_id ) ); ?>" target="_blank" rel="noopener noreferrer">
        <?php echo dc_icon( 'message-circle' ); ?>
        <?php esc_html_e( 'Hubungi Mitra', 'depocleanique-custom' ); ?>
    </a>
    <a class="partnership-back" href="<?php echo esc_url( get_post_type_archive_link( 'partnership' ) ); ?>">
        <?php echo dc_icon( 'arrow-left' ); ?>
        <?php esc_html_e( 'Kembali ke semua mitra', 'depocleanique-custom' ); ?>
    </a>
</aside>
