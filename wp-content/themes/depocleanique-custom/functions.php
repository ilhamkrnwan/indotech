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
require_once get_template_directory() . '/inc/page-hero-meta.php';

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

    // Konfigurasi Tailwind (token Material 3) — diport dari _landing-source.html.
    // Wajib agar class token (bg-surface, text-on-surface, gap-gutter, font-headline-lg, dst.) render.
    wp_add_inline_script(
        'depocleanique-tailwind',
        "tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'on-secondary-fixed-variant': '#004c69',
                        'on-primary-fixed': '#131f00',
                        'tertiary-fixed': '#d5e3ff',
                        'on-primary-fixed-variant': '#364e00',
                        'error-container': '#ffdad6',
                        'on-tertiary': '#ffffff',
                        'secondary-container': '#00bdfd',
                        'on-secondary-container': '#004964',
                        'inverse-primary': '#a3d73c',
                        'tertiary-fixed-dim': '#b1c7f0',
                        'surface-variant': '#e0e3e5',
                        'tertiary-container': '#a7bee6',
                        'surface-tint': '#496800',
                        tertiary: '#495f82',
                        surface: '#f7f9fb',
                        'surface-dim': '#d8dadc',
                        'on-primary-container': '#3a5400',
                        'outline-variant': '#c3c9b1',
                        primary: '#496800',
                        'on-background': '#191c1e',
                        'primary-container': '#9acd32',
                        'on-surface-variant': '#434937',
                        'secondary-fixed-dim': '#7ad0ff',
                        'surface-container': '#eceef0',
                        'surface-container-highest': '#e0e3e5',
                        'surface-container-high': '#e6e8ea',
                        secondary: '#00668a',
                        outline: '#747a65',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-lowest': '#ffffff',
                        error: '#ba1a1a',
                        'secondary-fixed': '#c3e8ff',
                        'on-surface': '#191c1e',
                        'on-primary': '#ffffff',
                        'on-tertiary-fixed-variant': '#314769',
                        'inverse-surface': '#2d3133',
                        'on-error': '#ffffff',
                        'inverse-on-surface': '#eff1f3',
                        background: '#f7f9fb',
                        'on-secondary': '#ffffff',
                        'primary-fixed': '#bef456',
                        'primary-fixed-dim': '#a3d73c',
                        'on-tertiary-fixed': '#001c3b',
                        'on-secondary-fixed': '#001e2c',
                        'on-error-container': '#93000a',
                        'surface-bright': '#f7f9fb',
                        'on-tertiary-container': '#364d6f',
                    },
                    borderRadius: { DEFAULT: '1rem', lg: '2rem', xl: '3rem', full: '9999px' },
                    spacing: {
                        'container-max': '1280px',
                        'margin-mobile': '16px',
                        gutter: '24px',
                        'margin-desktop': '48px',
                        base: '8px',
                    },
                    fontFamily: {
                        'headline-xl': ['Plus Jakarta Sans'],
                        'label-sm': ['Plus Jakarta Sans'],
                        'headline-lg-mobile': ['Plus Jakarta Sans'],
                        'body-md': ['Plus Jakarta Sans'],
                        'title-md': ['Plus Jakarta Sans'],
                        'body-lg': ['Plus Jakarta Sans'],
                        'headline-lg': ['Plus Jakarta Sans'],
                    },
                    fontSize: {
                        'headline-xl': ['48px', { lineHeight: '56px', letterSpacing: '-0.02em', fontWeight: '800' }],
                        'label-sm': ['13px', { lineHeight: '18px', letterSpacing: '0.05em', fontWeight: '600' }],
                        'headline-lg-mobile': ['28px', { lineHeight: '36px', fontWeight: '700' }],
                        'body-md': ['16px', { lineHeight: '24px', fontWeight: '400' }],
                        'title-md': ['20px', { lineHeight: '28px', fontWeight: '600' }],
                        'body-lg': ['18px', { lineHeight: '28px', fontWeight: '400' }],
                        'headline-lg': ['32px', { lineHeight: '40px', letterSpacing: '-0.01em', fontWeight: '700' }],
                    },
                },
            },
        };",
        'after'
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
    add_post_type_support( 'page', 'excerpt' );
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
