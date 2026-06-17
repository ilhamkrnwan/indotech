<?php
// Render CTA banner section on pages that don't already have a specific CTA banner.
$dc_is_checkout_or_cart = false;
if ( class_exists( 'WooCommerce' ) ) {
    $dc_is_checkout_or_cart = is_cart() || is_checkout();
}

if ( ! is_front_page() && ! is_page_template( 'page-kontak.php' ) && ! is_singular( 'partnership' ) && ! is_post_type_archive( 'partnership' ) && ! $dc_is_checkout_or_cart ) {
    get_template_part( 'template-parts/sections/cta-banner' );
}
?>
<?php get_template_part( 'template-parts/layout/floating-tools' ); ?>
<?php get_template_part( 'template-parts/layout/site-footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

