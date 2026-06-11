<?php
/**
 * Depocleanique Custom — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─── Load helper functions dan Customizer ────────────
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/customizer.php';

function depocleanique_enqueue_assets() {
    $v   = wp_get_theme()->get( 'Version' );
    $uri = get_template_directory_uri();

    // Google Fonts — Plus Jakarta Sans
    wp_enqueue_style(
        'depocleanique-google-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap',
        [],
        null
    );

    // Google Fonts — Material Symbols Outlined (icon font dipakai header/footer/section)
    wp_enqueue_style(
        'depocleanique-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        [],
        null
    );

    // Tailwind CSS CDN (sementara untuk testing)
    wp_enqueue_script(
        'depocleanique-tailwind',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false
    );

    // Main stylesheet
    wp_enqueue_style(
        'depocleanique-main',
        $uri . '/assets/css/main.css',
        [ 'depocleanique-google-fonts' ],
        $v
    );

    // Main script
    wp_enqueue_script(
        'depocleanique-main',
        $uri . '/assets/js/main.js',
        [],
        $v,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'depocleanique_enqueue_assets' );


function depocleanique_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'depocleanique-custom' ),
    ] );
}
add_action( 'after_setup_theme', 'depocleanique_theme_setup' );
