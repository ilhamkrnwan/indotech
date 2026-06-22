<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

class Taxonomies {
    /**
     * Initialize Taxonomies registrations
     */
    public static function register() {
        add_action('init', [self::class, 'register_taxonomies']);
    }

    /**
     * Register Taxonomies
     */
    public static function register_taxonomies() {
        // 1. Taxonomy: Product Category (product_cat) linked to CPT product
        register_taxonomy('product_cat', 'product', [
            'labels' => [
                'name'              => __('Product Categories', 'indotech-core'),
                'singular_name'     => __('Product Category', 'indotech-core'),
                'search_items'      => __('Search Categories', 'indotech-core'),
                'all_items'         => __('All Categories', 'indotech-core'),
                'parent_item'       => __('Parent Category', 'indotech-core'),
                'parent_item_colon' => __('Parent Category:', 'indotech-core'),
                'edit_item'         => __('Edit Category', 'indotech-core'),
                'update_item'       => __('Update Category', 'indotech-core'),
                'add_new_item'      => __('Add New Category', 'indotech-core'),
                'new_item_name'     => __('New Category Name', 'indotech-core'),
                'menu_name'         => __('Categories', 'indotech-core'),
            ],
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true, // Required for Gutenberg editor
            'query_var'         => true,
            'rewrite'           => ['slug' => 'products/category', 'with_front' => false],
        ]);

        // 2. Taxonomy: Download Category (download_category) linked to Media Library attachment
        register_taxonomy('download_category', 'attachment', [
            'labels' => [
                'name'              => __('Download Categories', 'indotech-core'),
                'singular_name'     => __('Download Category', 'indotech-core'),
                'search_items'      => __('Search Categories', 'indotech-core'),
                'all_items'         => __('All Categories', 'indotech-core'),
                'edit_item'         => __('Edit Category', 'indotech-core'),
                'update_item'       => __('Update Category', 'indotech-core'),
                'add_new_item'      => __('Add New Category', 'indotech-core'),
                'new_item_name'     => __('New Category Name', 'indotech-core'),
                'menu_name'         => __('Download Categories', 'indotech-core'),
            ],
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true, // Required for REST API
            'query_var'         => true,
            'rewrite'           => ['slug' => 'download-category', 'with_front' => false],
        ]);
    }
}
