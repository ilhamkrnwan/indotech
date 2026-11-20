<?php
/**
 * Template Name: Halaman Legal
 *
 * Template bersama untuk dokumen legal WordPress PT Indotech Berkah Abadi.
 */

if ( ! function_exists( 'indotech_extract_headings' ) ) {
    function indotech_extract_headings( $content ) {
        preg_match_all( '/<h([2-3])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER );
        $headings = [];
        foreach ( $matches as $m ) {
            $text   = wp_strip_all_tags( $m[2] );
            $anchor = sanitize_title( $text );
            $level  = (int) $m[1];
            $headings[] = compact( 'text', 'anchor', 'level' );
        }
        return $headings;
    }
}

if ( ! function_exists( 'indotech_add_heading_ids' ) ) {
    function indotech_add_heading_ids( $content ) {
        return preg_replace_callback(
            '/<h([2-3])([^>]*)>(.*?)<\/h\1>/i',
            function ( $m ) {
                $text   = wp_strip_all_tags( $m[3] );
                $anchor = sanitize_title( $text );
                $attrs  = $m[2];
                if ( strpos( $attrs, 'id=' ) === false ) {
                    $attrs .= ' id="' . esc_attr( $anchor ) . '"';
                }
                return "<h{$m[1]}{$attrs}>{$m[3]}</h{$m[1]}>";
            },
            $content
        );
    }
}

get_header();

$page_title   = get_the_title();
$page_content = '';
$headings     = [];

if ( have_posts() ) {
    the_post();
    $raw_content  = get_the_content();
    $page_content = apply_filters( 'the_content', indotech_add_heading_ids( $raw_content ) );
    $headings     = indotech_extract_headings( $raw_content );
}

$last_updated    = get_the_modified_date( 'd F Y' ) ?: date( 'd F Y' );
$reading_minutes = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( $page_content ) ) / 200 ) );
$current_slug    = get_post_field( 'post_name', get_queried_object_id() );

get_template_part(
    'template-parts/static/legal-doc',
    null,
    [
        'title'           => $page_title,
        'content'         => $page_content,
        'headings'        => $headings,
        'last_updated'    => $last_updated,
        'active_slug'     => $current_slug,
        'reading_minutes' => $reading_minutes,
    ]
);

get_footer();
