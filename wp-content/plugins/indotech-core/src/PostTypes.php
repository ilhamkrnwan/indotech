<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

class PostTypes {
    /**
     * Initialize Post Types registrations
     */
    public static function register() {
        add_action('init', [self::class, 'register_post_types']);

        // Cache invalidation hooks
        add_action('save_post_brand', [self::class, 'clear_brand_transients']);
        add_action('create_product_cat', [self::class, 'clear_category_transients']);
        add_action('edit_product_cat', [self::class, 'clear_category_transients']);
        add_action('delete_product_cat', [self::class, 'clear_category_transients']);
    }

    public static function clear_brand_transients() {
        delete_transient('indotech_filter_brands');
    }

    public static function clear_category_transients() {
        delete_transient('indotech_filter_categories');
    }

    /**
     * Register CPTs
     */
    public static function register_post_types() {
        // 1. CPT: Brand
        register_post_type('brand', [
            'labels'      => [
                'name'          => __('Brands', 'indotech-core'),
                'singular_name' => __('Brand', 'indotech-core'),
                'add_new_item'  => __('Add New Brand', 'indotech-core'),
                'edit_item'     => __('Edit Brand', 'indotech-core'),
                'all_items'     => __('All Brands', 'indotech-core'),
            ],
            'public'             => true,
            'show_in_rest'       => true, // Enable Gutenberg & REST API
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-tag',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'rewrite'            => ['slug' => 'brands', 'with_front' => false],
            'show_in_menu'       => true,
        ]);

        // 2. CPT: Product
        register_post_type('product', [
            'labels'      => [
                'name'          => __('Products', 'indotech-core'),
                'singular_name' => __('Product', 'indotech-core'),
                'add_new_item'  => __('Add New Product', 'indotech-core'),
                'edit_item'     => __('Edit Product', 'indotech-core'),
                'all_items'     => __('All Products', 'indotech-core'),
            ],
            'public'             => true,
            'show_in_rest'       => true, // Enable Gutenberg & REST API
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-products',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'rewrite'            => ['slug' => 'products', 'with_front' => false],
            'show_in_menu'       => true,
        ]);

        // 3. CPT: Industry (Solusi Industri)
        register_post_type('industry', [
            'labels'      => [
                'name'          => __('Industries', 'indotech-core'),
                'singular_name' => __('Industry', 'indotech-core'),
                'add_new_item'  => __('Add New Industry', 'indotech-core'),
                'edit_item'     => __('Edit Industry', 'indotech-core'),
                'all_items'     => __('All Industries', 'indotech-core'),
            ],
            'public'             => true,
            'show_in_rest'       => true, // Enable Gutenberg & REST API
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-networking',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'rewrite'            => ['slug' => 'industries', 'with_front' => false],
            'show_in_menu'       => true,
        ]);

        // 4. CPT: Application (Aplikasi Layanan B2B untuk SEO)
        register_post_type('application', [
            'labels'      => [
                'name'          => __('Applications', 'indotech-core'),
                'singular_name' => __('Application', 'indotech-core'),
                'add_new_item'  => __('Add New Application', 'indotech-core'),
                'edit_item'     => __('Edit Application', 'indotech-core'),
                'all_items'     => __('All Applications', 'indotech-core'),
            ],
            'public'             => true,
            'show_in_rest'       => true, // Enable Gutenberg & REST API
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-screenoptions',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'rewrite'            => ['slug' => 'applications', 'with_front' => false],
            'show_in_menu'       => true,
        ]);
    }
}
