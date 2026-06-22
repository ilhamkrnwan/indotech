<?php
/**
 * Indotech Custom Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('INDOTECH_VERSION', '2.0.0');
define('INDOTECH_DIR', get_template_directory());
define('INDOTECH_URI', get_template_directory_uri());

// ── Theme Setup ──────────────────────────────────────────────────────────────
function indotech_setup() {
    load_theme_textdomain('indotech', INDOTECH_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'indotech'),
        'footer'  => __('Footer Navigation', 'indotech'),
    ]);

    add_image_size('indotech-hero', 1920, 900, true);
    add_image_size('indotech-card', 600, 400, true);
    add_image_size('indotech-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'indotech_setup');

// ── Enqueue Assets ───────────────────────────────────────────────────────────
function indotech_enqueue() {
    // Google Fonts
    wp_enqueue_style(
        'indotech-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style('indotech-main', INDOTECH_URI . '/assets/css/main.css', ['indotech-fonts'], INDOTECH_VERSION);

    // Main JS
    wp_enqueue_script('indotech-main', INDOTECH_URI . '/assets/js/main.js', [], INDOTECH_VERSION, true);

    // Inquiry AJAX JS (depends on jQuery and indotech-main for localized object)
    wp_enqueue_script('indotech-inquiry', INDOTECH_URI . '/assets/js/inquiry-ajax.js', ['jquery', 'indotech-main'], INDOTECH_VERSION, true);

    wp_localize_script('indotech-main', 'indotechData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('indotech_nonce'),
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'indotech_enqueue');

// ── Register Sidebars ─────────────────────────────────────────────────────────
function indotech_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'indotech'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    register_sidebar([
        'name'          => __('Footer Widget 1', 'indotech'),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'indotech_widgets_init');

// ── Custom Post Types ─────────────────────────────────────────────────────────
function indotech_register_cpts() {
    // Testimonials
    register_post_type('testimonial', [
        'labels'      => ['name' => 'Testimonials', 'singular_name' => 'Testimonial'],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-format-quote',
        'supports'    => ['title', 'editor', 'thumbnail'],
    ]);

    // Brands
    register_post_type('brand', [
        'labels'      => ['name' => 'Brands', 'singular_name' => 'Brand'],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-tag',
        'supports'    => ['title', 'editor', 'thumbnail', 'custom-fields'],
    ]);
}
add_action('init', 'indotech_register_cpts');

// ── Helper: Get Posts ─────────────────────────────────────────────────────────
function indotech_get_posts($post_type = 'post', $count = 3, $args = []) {
    $defaults = [
        'post_type'      => $post_type,
        'posts_per_page' => $count,
        'post_status'    => 'publish',
    ];
    return new WP_Query(array_merge($defaults, $args));
}

// ── Excerpt ───────────────────────────────────────────────────────────────────
function indotech_excerpt_length($length) { return 20; }
add_filter('excerpt_length', 'indotech_excerpt_length');

function indotech_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'indotech_excerpt_more');

// ── Include Partials ──────────────────────────────────────────────────────────
require_once INDOTECH_DIR . '/inc/customizer.php';
require_once INDOTECH_DIR . '/inc/helpers.php';
