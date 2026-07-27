<?php
/**
 * Script Import Data Produk VPS ke Database Lokal Laragon
 * Jalankan via CLI pada lokal: php import_vps_products.php
 */

if (php_sapi_name() !== 'cli') {
    die("Script ini hanya dapat dijalankan melalui CLI.\n");
}

define('WP_USE_THEMES', false);
$wp_load = __DIR__ . '/wp-load.php';

if (!file_exists($wp_load)) {
    die("File wp-load.php tidak ditemukan di " . __DIR__ . "\n");
}

require_once $wp_load;

$json_file = __DIR__ . '/vps_products_export.json';
if (!file_exists($json_file)) {
    die("ERROR: File vps_products_export.json tidak ditemukan di " . __DIR__ . "\n");
}

$data = json_decode(file_get_contents($json_file), true);
if (!is_array($data)) {
    die("ERROR: Format JSON pada vps_products_export.json tidak valid!\n");
}

echo "Memulai import " . count($data) . " produk dari JSON ke database lokal...\n";

$count = 0;
foreach ($data as $item) {
    // Cari produk eksisting berdasarkan post_name atau post_title
    $existing = get_page_by_path($item['post_name'], OBJECT, 'product');
    if (!$existing) {
        $existing_posts = get_posts(array(
            'title'     => $item['post_title'],
            'post_type' => 'product',
            'post_status' => 'any',
            'numberposts' => 1
        ));
        if (!empty($existing_posts)) {
            $existing = $existing_posts[0];
        }
    }

    $post_data = array(
        'post_title'   => $item['post_title'],
        'post_name'    => $item['post_name'],
        'post_content' => $item['post_content'],
        'post_excerpt' => $item['post_excerpt'],
        'post_status'  => $item['post_status'],
        'post_type'    => 'product',
    );

    if ($existing) {
        $post_data['ID'] = $existing->ID;
        $product_id = wp_update_post($post_data);
    } else {
        $product_id = wp_insert_post($post_data);
    }

    if (is_wp_error($product_id)) {
        echo "Gagal mengimpor produk: " . $item['post_title'] . "\n";
        continue;
    }

    // Import postmeta
    if (!empty($item['meta']) && is_array($item['meta'])) {
        foreach ($item['meta'] as $meta_key => $meta_values) {
            delete_post_meta($product_id, $meta_key);
            foreach ($meta_values as $val) {
                $unserialized = @maybe_unserialize($val);
                add_post_meta($product_id, $meta_key, $unserialized);
            }
        }
    }

    // Import taxonomy terms
    if (!empty($item['terms']) && is_array($item['terms'])) {
        foreach ($item['terms'] as $tax => $slugs) {
            if (taxonomy_exists($tax)) {
                wp_set_object_terms($product_id, $slugs, $tax);
            }
        }
    }

    $count++;
    echo "[$count] Berhasil import: {$item['post_title']} (ID: $product_id)\n";
}

echo "\nSELESAI: Total $count produk berhasil diperbarui/diimpor ke database lokal.\n";
