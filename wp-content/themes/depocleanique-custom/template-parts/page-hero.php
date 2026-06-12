<?php
/**
 * Reusable internal page hero.
 *
 * Expects optional args:
 * - page_type, post_id, eyebrow, title_line_1, title_line_2, description
 * - button_label, button_url, visual_url, meta_items
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args = wp_parse_args(
    $args ?? [],
    [
        'page_type'    => 'default',
        'post_id'      => get_the_ID(),
        'eyebrow'      => __( 'Depo Cleanique', 'depocleanique-custom' ),
        'title_line_1' => get_the_title(),
        'title_line_2' => '',
        'description'  => '',
        'button_label' => '',
        'button_url'   => '',
        'visual_url'   => '',
        'meta_items'   => [],
    ]
);

$post_id      = absint( $args['post_id'] );
$page_type    = sanitize_html_class( $args['page_type'] );
$eyebrow      = dc_get_page_hero_meta_value( $post_id, 'eyebrow', $args['eyebrow'] );
$title_line_1 = dc_get_page_hero_meta_value( $post_id, 'title_line_1', $args['title_line_1'] );
$title_line_2 = dc_get_page_hero_meta_value( $post_id, 'title_line_2', $args['title_line_2'] );
$description  = dc_get_page_hero_description( $post_id, $args['description'] );
$button_label = dc_get_page_hero_meta_value( $post_id, 'button_label', $args['button_label'] );
$button_url   = dc_get_page_hero_meta_value( $post_id, 'button_url', $args['button_url'] );
$visual_url   = dc_get_page_hero_meta_value( $post_id, 'visual_url', $args['visual_url'] );
$meta_items   = is_array( $args['meta_items'] ) ? $args['meta_items'] : [];

$has_button         = '' !== trim( $button_label ) && '' !== trim( $button_url );
$has_visual         = '' !== trim( $visual_url );
$is_external_button = $has_button && 0 === strpos( $button_url, 'http' ) && 0 !== strpos( $button_url, home_url() );
?>

<section class="internal-page-hero internal-page-hero--<?php echo esc_attr( $page_type ); ?>">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="internal-page-hero-inner">
            <div class="internal-page-hero-content">
                <p class="internal-page-hero-eyebrow">
                    <span aria-hidden="true"></span>
                    <?php echo esc_html( $eyebrow ); ?>
                </p>

                <h1 class="internal-page-hero-title">
                    <span class="internal-page-hero-title-primary"><?php echo esc_html( $title_line_1 ); ?></span>
                    <?php if ( '' !== trim( $title_line_2 ) ) : ?>
                        <span class="internal-page-hero-title-secondary"><?php echo esc_html( $title_line_2 ); ?></span>
                    <?php endif; ?>
                </h1>

                <?php if ( '' !== trim( $description ) ) : ?>
                    <p class="internal-page-hero-description">
                        <?php echo wp_kses_post( $description ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $has_button ) : ?>
                    <a
                        class="internal-page-hero-button"
                        href="<?php echo esc_url( $button_url ); ?>"
                        <?php echo $is_external_button ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                    >
                        <span><?php echo esc_html( $button_label ); ?></span>
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="internal-page-hero-aside">
                <div
                    class="internal-page-hero-visual<?php echo $has_visual ? ' has-image' : ''; ?>"
                    <?php if ( $has_visual ) : ?>
                        style="background-image:url('<?php echo esc_url( $visual_url ); ?>');"
                    <?php endif; ?>
                    aria-hidden="true"
                >
                    <span class="internal-page-hero-orbit"></span>
                    <span class="internal-page-hero-mark material-symbols-outlined">water_drop</span>
                </div>

                <?php if ( ! empty( $meta_items ) ) : ?>
                    <div class="internal-page-hero-facts">
                        <?php foreach ( $meta_items as $item ) : ?>
                            <div class="internal-page-hero-fact">
                                <?php if ( ! empty( $item['icon'] ) ) : ?>
                                    <span class="material-symbols-outlined" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></span>
                                <?php endif; ?>
                                <div>
                                    <span><?php echo esc_html( $item['label'] ?? '' ); ?></span>
                                    <strong><?php echo esc_html( $item['value'] ?? '' ); ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
