<?php
/**
 * Shared Cinema Video Profile Modal — PT Indotech Berkah Abadi.
 */

$media_cp     = get_theme_file_uri( 'assets/images/company-profile' );
$video_raw    = function_exists( 'indotech_opt' ) ? indotech_opt( 'video_url', '' ) : '';
$video_title  = function_exists( 'indotech_opt' ) ? indotech_opt( 'video_title', 'Video Profil PT Indotech Berkah Abadi' ) : 'Video Profil PT Indotech Berkah Abadi';
$video_config = function_exists( 'indotech_get_video_embed_config' ) ? indotech_get_video_embed_config( $video_raw ) : [ 'type' => 'none', 'src' => '' ];
?>

<div
    id="ch-video-modal"
    class="ch-modal ch-modal--video"
    role="dialog"
    aria-modal="true"
    aria-labelledby="ch-video-modal-title"
    data-video-type="<?php echo esc_attr( $video_config['type'] ); ?>"
    data-video-src="<?php echo esc_url( $video_config['src'] ); ?>"
    hidden
>
    <div class="ch-modal-backdrop" data-modal-close></div>
    <div class="ch-modal-dialog ch-modal-dialog--video">
        <h2 id="ch-video-modal-title" class="screen-reader-text"><?php echo esc_html( $video_title ); ?></h2>
        <button type="button" class="ch-modal-close ch-video-modal-close" data-modal-close aria-label="Tutup pemutar video">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="ch-video-stage">
            <?php if ( $video_config['type'] !== 'none' ) : ?>
                <div class="ch-video-frame" id="ch-video-embed-mount"></div>
            <?php else : ?>
                <div class="ch-video-placeholder">
                    <img
                        src="<?php echo esc_url( $media_cp . '/hero-manufy-stage.webp' ); ?>"
                        width="1376"
                        height="768"
                        alt="Preview video profil fasilitas PT Indotech Berkah Abadi"
                        loading="lazy"
                        decoding="async"
                    >
                    <div class="ch-video-placeholder-scrim" aria-hidden="true"></div>
                    <div class="ch-video-placeholder-center">
                        <span class="ch-video-placeholder-play" aria-hidden="true">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><polygon points="8 5 20 12 8 19 8 5"></polygon></svg>
                        </span>
                        <span class="ch-video-placeholder-title"><?php echo esc_html( $video_title ); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
