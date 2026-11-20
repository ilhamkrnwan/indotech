<?php
/**
 * Shared Minimalist Editorial Archive Item — Anti-Slop Primitive
 *
 * Clean rounded image frame paired with Title and concise Description
 * rendered outside & below the image (no card borders, no corner pills, no buttons).
 */

$item = wp_parse_args(
    $args ?? [],
    [
        'url'            => '',
        'title'          => '',
        'desc'           => '',
        'image_html'     => '',
        'fallback_label' => 'Indotech',
        'media_variant'  => 'product',
        'heading_tag'    => 'h2',
        'post_id'        => 0,
        'role_listitem'  => false,
    ]
);

$tag          = in_array( $item['heading_tag'], [ 'h2', 'h3', 'h4' ], true ) ? $item['heading_tag'] : 'h2';
$post_id      = absint( $item['post_id'] );
$role_attr    = ! empty( $item['role_listitem'] ) ? ' role="listitem"' : '';
$media_class  = '';
if ( $item['media_variant'] === 'wide' ) {
    $media_class = ' cs-item-media--wide';
} elseif ( $item['media_variant'] === 'logo' ) {
    $media_class = ' cs-item-media--logo';
}
$desc = trim( (string) $item['desc'] );
?>
<article class="cs-item"<?php echo $post_id ? ' id="post-' . $post_id . '"' : ''; ?><?php echo $role_attr; ?>>
    <a class="cs-item-link" href="<?php echo esc_url( $item['url'] ); ?>">
        <div class="cs-item-media<?php echo esc_attr( $media_class ); ?>">
            <?php if ( ! empty( $item['image_html'] ) ) : ?>
                <?php echo $item['image_html']; ?>
            <?php else : ?>
                <span class="cs-item-placeholder" aria-hidden="true"><?php echo esc_html( $item['fallback_label'] ); ?></span>
            <?php endif; ?>
        </div>
        <div class="cs-item-body">
            <<?php echo $tag; ?> class="cs-item-title"><?php echo esc_html( $item['title'] ); ?></<?php echo $tag; ?>>
            <?php if ( $desc !== '' ) : ?>
                <p class="cs-item-desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>
