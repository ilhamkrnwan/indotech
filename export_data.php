<?php
/**
 * Script Export Data Artikel & Produk WordPress / WooCommerce
 * 
 * Penggunaan via CLI:
 *   php export_data.php
 * 
 * Penggunaan via Web Browser / HTTP API (opsional):
 *   https://domain-vps.com/export_data.php?key=indotech_export_key_2026
 */

// Konfigurasi Kunci Keamanan untuk Akses via Web (Ubah sesuai kebutuhan)
define('SECRET_KEY', 'indotech_export_key_2026');

// Cek Mode Eksekusi (CLI atau Web)
$is_cli = (php_sapi_name() === 'cli');

// Batas jumlah data terbaru (default 10, bisa dicustom via URL ?limit=20 atau CLI --limit=20)
$latest_limit = 10;
if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    $latest_limit = (int)$_GET['limit'];
} elseif ($is_cli) {
    foreach ($argv as $arg) {
        if (strpos($arg, '--limit=') === 0) {
            $val = substr($arg, 8);
            if (is_numeric($val)) { $latest_limit = (int)$val; }
        }
    }
}
define('LATEST_LIMIT', $latest_limit);

if (!$is_cli) {
    // Keamanan jika diakses via HTTP Web
    $provided_key = isset($_GET['key']) ? $_GET['key'] : '';
    if ($provided_key !== SECRET_KEY) {
        header('HTTP/1.0 403 Forbidden');
        header('Content-Type: application/json');
        die(json_encode([
            'status' => 'error',
            'message' => 'Akses ditolak. Kunci keamanan (key) tidak valid.'
        ]));
    }
}

define('WP_USE_THEMES', false);
$wp_load = __DIR__ . '/wp-load.php';

if (!file_exists($wp_load)) {
    $msg = "Error: File wp-load.php tidak ditemukan di " . __DIR__;
    if ($is_cli) { die($msg . "\n"); } else { die(json_encode(['status' => 'error', 'message' => $msg])); }
}

require_once $wp_load;

/**
 * Helper function untuk mendapatkan data lengkap dari sebuah Post / Artikel
 */
function get_full_post_data($post) {
    $post_id = $post->ID;
    
    // Author details
    $author_id = $post->post_author;
    $author_data = array(
        'id'           => $author_id,
        'name'         => get_the_author_meta('display_name', $author_id),
        'email'        => get_the_author_meta('user_email', $author_id),
    );

    // Featured Image
    $featured_image = null;
    if (has_post_thumbnail($post_id)) {
        $thumb_id = get_post_thumbnail_id($post_id);
        $featured_image = array(
            'thumbnail' => wp_get_attachment_image_url($thumb_id, 'thumbnail'),
            'medium'    => wp_get_attachment_image_url($thumb_id, 'medium'),
            'full'      => wp_get_attachment_image_url($thumb_id, 'full'),
            'alt'       => get_post_meta($thumb_id, '_wp_attachment_image_alt', true),
        );
    }

    // Categories & Tags
    $categories = wp_get_post_categories($post_id, array('fields' => 'all'));
    $cat_list = array();
    if (!is_wp_error($categories)) {
        foreach ($categories as $cat) {
            $cat_list[] = array(
                'id'   => $cat->term_id,
                'name' => $cat->name,
                'slug' => $cat->slug
            );
        }
    }

    $tags = wp_get_post_tags($post_id, array('fields' => 'all'));
    $tag_list = array();
    if (!is_wp_error($tags)) {
        foreach ($tags as $tag) {
            $tag_list[] = array(
                'id'   => $tag->term_id,
                'name' => $tag->name,
                'slug' => $tag->slug
            );
        }
    }

    // Meta Data
    $raw_meta = get_post_meta($post_id);
    $clean_meta = array();
    if (is_array($raw_meta)) {
        foreach ($raw_meta as $key => $values) {
            $unserialized = array_map(function($v) {
                return @maybe_unserialize($v);
            }, $values);
            $clean_meta[$key] = (count($unserialized) === 1) ? $unserialized[0] : $unserialized;
        }
    }

    return array(
        'ID'             => $post_id,
        'title'          => $post->post_title,
        'slug'           => $post->post_name,
        'status'         => $post->post_status,
        'content'        => $post->post_content,
        'excerpt'        => $post->post_excerpt,
        'date'           => $post->post_date,
        'date_gmt'       => $post->post_date_gmt,
        'modified'       => $post->post_modified,
        'modified_gmt'   => $post->post_modified_gmt,
        'permalink'      => get_permalink($post_id),
        'author'         => $author_data,
        'featured_image' => $featured_image,
        'categories'     => $cat_list,
        'tags'           => $tag_list,
        'meta'           => $clean_meta,
    );
}

/**
 * Helper function untuk mendapatkan data lengkap dari Produk WooCommerce
 */
function get_full_product_data($post) {
    $post_id = $post->ID;
    
    // Dasar Post
    $base_data = get_full_post_data($post);

    // Taxonomy khusus Produk (product_cat, product_tag, product_brand, dll)
    $taxonomies = get_object_taxonomies('product');
    $product_terms = array();
    foreach ($taxonomies as $tax) {
        $terms = wp_get_object_terms($post_id, $tax, array('fields' => 'all'));
        $term_items = array();
        if (!is_wp_error($terms)) {
            foreach ($terms as $t) {
                $term_items[] = array(
                    'id'   => $t->term_id,
                    'name' => $t->name,
                    'slug' => $t->slug
                );
            }
        }
        $product_terms[$tax] = $term_items;
    }

    // WooCommerce Meta
    $regular_price = get_post_meta($post_id, '_regular_price', true);
    $sale_price    = get_post_meta($post_id, '_sale_price', true);
    $price         = get_post_meta($post_id, '_price', true);
    $sku           = get_post_meta($post_id, '_sku', true);
    $stock_status  = get_post_meta($post_id, '_stock_status', true);
    $stock_qty     = get_post_meta($post_id, '_stock', true);

    // Gallery Images
    $gallery_images = array();
    $attachment_ids = get_post_meta($post_id, '_product_image_gallery', true);
    if (!empty($attachment_ids)) {
        $ids = explode(',', $attachment_ids);
        foreach ($ids as $img_id) {
            $img_id = trim($img_id);
            if ($img_id) {
                $gallery_images[] = array(
                    'id'        => $img_id,
                    'thumbnail' => wp_get_attachment_image_url($img_id, 'thumbnail'),
                    'full'      => wp_get_attachment_image_url($img_id, 'full'),
                );
            }
        }
    }

    $product_specific = array(
        'price'          => $price,
        'regular_price'  => $regular_price,
        'sale_price'     => $sale_price,
        'sku'            => $sku,
        'stock_status'   => $stock_status,
        'stock_quantity' => ($stock_qty !== '') ? (int)$stock_qty : null,
        'product_terms'  => $product_terms,
        'gallery_images' => $gallery_images,
    );

    return array_merge($base_data, $product_specific);
}

// ----------------------------------------------------
// 1. PROCESS POST ARTIKEL
// ----------------------------------------------------
if ($is_cli) { echo "=== Memproses Export Artikel ===\n"; }

$all_posts_raw = get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$artikel_all = array();
foreach ($all_posts_raw as $p) {
    $artikel_all[] = get_full_post_data($p);
}

$artikel_latest = array_slice($artikel_all, 0, LATEST_LIMIT);

$export_artikel_payload = array(
    'info' => array(
        'generated_at'   => date('Y-m-d H:i:s'),
        'total_all'      => count($artikel_all),
        'total_terbaru'  => count($artikel_latest),
        'latest_limit'   => LATEST_LIMIT,
        'site_url'       => get_site_url(),
    ),
    'data_terbaru' => $artikel_latest,
    'semua_data'   => $artikel_all,
);

$file_artikel = __DIR__ . '/post_artikel.json';
file_put_contents($file_artikel, json_encode($export_artikel_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($is_cli) {
    echo "BERHASIL: " . count($artikel_all) . " artikel diekspor ke post_artikel.json\n";
}

// ----------------------------------------------------
// 2. PROCESS PRODUK
// ----------------------------------------------------
if ($is_cli) { echo "=== Memproses Export Produk ===\n"; }

$all_products_raw = get_posts(array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$produk_all = array();
foreach ($all_products_raw as $p) {
    $produk_all[] = get_full_product_data($p);
}

$produk_latest = array_slice($produk_all, 0, LATEST_LIMIT);

$export_produk_payload = array(
    'info' => array(
        'generated_at'   => date('Y-m-d H:i:s'),
        'total_all'      => count($produk_all),
        'total_terbaru'  => count($produk_latest),
        'latest_limit'   => LATEST_LIMIT,
        'site_url'       => get_site_url(),
    ),
    'data_terbaru' => $produk_latest,
    'semua_data'   => $produk_all,
);

$file_produk = __DIR__ . '/produk.json';
file_put_contents($file_produk, json_encode($export_produk_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($is_cli) {
    echo "BERHASIL: " . count($produk_all) . " produk diekspor ke produk.json\n";
    echo "Selesai!\n";
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Berhasil mengekspor post_artikel.json dan produk.json',
        'artikel_summary' => $export_artikel_payload['info'],
        'produk_summary'  => $export_produk_payload['info'],
    ], JSON_PRETTY_PRINT);
}
