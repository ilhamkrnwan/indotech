<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

use WP_REST_Request;
use WP_REST_Response;

class RestApi {
    /**
     * Initialize REST API Hooks
     */
    public static function register() {
        add_action('rest_api_init', [self::class, 'register_routes']);
    }

    /**
     * Register Custom routes
     */
    public static function register_routes() {
        // GET /wp-json/indotech/v1/brands
        register_rest_route('indotech/v1', '/brands', [
            'methods'             => 'GET',
            'callback'            => [self::class, 'get_brands'],
            'permission_callback' => '__return_true', // Public endpoint
        ]);

        // GET /wp-json/indotech/v1/products
        register_rest_route('indotech/v1', '/products', [
            'methods'             => 'GET',
            'callback'            => [self::class, 'get_products'],
            'permission_callback' => '__return_true', // Public endpoint
        ]);
    }

    /**
     * Callback for GET /wp-json/indotech/v1/brands
     */
    public static function get_brands(WP_REST_Request $request) {
        $brands = get_posts([
            'post_type'      => 'brand',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'menu_order',
            'order'          => 'ASC'
        ]);

        $data = [];
        if (!empty($brands)) {
            foreach ($brands as $b) {
                $id = $b->ID;
                $logo_url = get_the_post_thumbnail_url($id, 'full') ?: '';
                $tagline = carbon_get_post_meta($id, 'brand_tagline');
                $accent = carbon_get_post_meta($id, 'brand_accent_color') ?: '#0057FF';
                $url = carbon_get_post_meta($id, 'brand_website_url');

                $data[] = [
                    'id'           => $id,
                    'name'         => $b->post_title,
                    'slug'         => $b->post_name,
                    'tagline'      => $tagline,
                    'accent_color' => $accent,
                    'website_url'  => $url,
                    'logo'         => $logo_url
                ];
            }
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Callback for GET /wp-json/indotech/v1/products
     */
    public static function get_products(WP_REST_Request $request) {
        $brand_filter = $request->get_param('brand');
        $cat_filter   = $request->get_param('category');

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => 100,
            'post_status'    => 'publish'
        ];

        // Apply Brand filter if set
        if (!empty($brand_filter)) {
            $args['meta_query'] = [
                [
                    'key'     => '_product_brand',
                    'value'   => 'post:brand:' . absint($brand_filter),
                    'compare' => '='
                ]
            ];
        }

        // Apply Category taxonomy filter if set
        if (!empty($cat_filter)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($cat_filter)
                ]
            ];
        }

        $products = get_posts($args);
        $data = [];

        if (!empty($products)) {
            foreach ($products as $p) {
                $id = $p->ID;
                $sku = carbon_get_post_meta($id, 'product_sku');
                $brand_relation = carbon_get_post_meta($id, 'product_brand');
                $downloads_relation = carbon_get_post_meta($id, 'product_downloads');
                $specs_relation = carbon_get_post_meta($id, 'product_specifications');

                // Extract Brand details
                $brand = null;
                if (!empty($brand_relation) && isset($brand_relation[0]['id'])) {
                    $b_id = $brand_relation[0]['id'];
                    $brand = [
                        'id'   => $b_id,
                        'name' => get_the_title($b_id)
                    ];
                }

                // Extract Technical Specifications
                $specifications = [];
                if (!empty($specs_relation)) {
                    foreach ($specs_relation as $spec) {
                        if (!empty($spec['spec_name'])) {
                            $specifications[] = [
                                'key'   => $spec['spec_name'],
                                'value' => $spec['spec_value']
                            ];
                        }
                    }
                } else {
                    // Fallback: Parse raw Carbon Fields postmeta directly from wp_postmeta
                    global $wpdb;
                    $meta_rows = $wpdb->get_results($wpdb->prepare(
                        "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id = %d AND meta_key LIKE %s",
                        $id,
                        '_product_specifications|%'
                    ), ARRAY_A);
                    if (!empty($meta_rows)) {
                        $temp_specs = [];
                        foreach ($meta_rows as $row) {
                            if (preg_match('/^_product_specifications\|(spec_name|spec_value)\|(\d+)\|0$/', $row['meta_key'], $matches)) {
                                $field_name = $matches[1];
                                $index      = intval($matches[2]);
                                $temp_specs[$index][$field_name] = $row['meta_value'];
                            }
                        }
                        ksort($temp_specs);
                        foreach ($temp_specs as $index => $item) {
                            if (isset($item['spec_name'])) {
                                $specifications[] = [
                                    'key'   => $item['spec_name'],
                                    'value' => $item['spec_value'] ?? ''
                                ];
                            }
                        }
                    }
                }

                // Extract Document Downloads
                $downloads = [];
                if (!empty($downloads_relation)) {
                    foreach ($downloads_relation as $dl) {
                        if (isset($dl['id'])) {
                            $dl_id = $dl['id'];
                            $is_gated = carbon_get_post_meta($dl_id, 'download_gate_active') === 'yes';
                            $downloads[] = [
                                'title' => get_the_title($dl_id),
                                'url'   => wp_get_attachment_url($dl_id),
                                'gated' => $is_gated
                            ];
                        }
                    }
                }

                $data[] = [
                    'id'             => $id,
                    'sku'            => $sku,
                    'name'           => $p->post_title,
                    'slug'           => $p->post_name,
                    'excerpt'        => $p->post_excerpt,
                    'image'          => get_the_post_thumbnail_url($id, 'large') ?: '',
                    'brand'          => $brand,
                    'specifications' => $specifications,
                    'downloads'      => $downloads
                ];
            }
        }

        return new WP_REST_Response($data, 200);
    }
}
