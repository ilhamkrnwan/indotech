<?php
/**
 * Related partners.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();
$terms   = get_the_terms( $post_id, 'partnership_type' );
$args    = [
    'post_type'           => 'partnership',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'post__not_in'        => [ $post_id ],
    'ignore_sticky_posts' => true,
    'orderby'             => [
        'menu_order' => 'ASC',
        'date'       => 'DESC',
    ],
];

if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'partnership_type',
            'field'    => 'term_id',
            'terms'    => wp_list_pluck( $terms, 'term_id' ),
        ],
    ];
}

$related = new WP_Query( $args );

if ( ! $related->have_posts() && ! empty( $args['tax_query'] ) ) {
    unset( $args['tax_query'] );
    $related = new WP_Query( $args );
}

if ( ! $related->have_posts() ) {
    wp_reset_postdata();
    return;
}
?>

<section class="partnership-related" aria-labelledby="partnership-related-title">
    <div class="partnership-heading is-left">
        <div class="section-kicker">
            <span class="section-kicker-dot" aria-hidden="true"></span>
            <span><?php esc_html_e( 'Mitra Lain', 'depocleanique-custom' ); ?></span>
        </div>
        <h2 id="partnership-related-title"><?php esc_html_e( 'Mitra terdaftar lain yang bisa dilihat', 'depocleanique-custom' ); ?></h2>
    </div>
    <div class="partnership-grid">
        <?php
        while ( $related->have_posts() ) :
            $related->the_post();
            get_template_part( 'template-parts/partnership/card' );
        endwhile;
        ?>
    </div>
</section>

<?php wp_reset_postdata(); ?>
