<?php
/**
 * Script Export Data Produk dari VPS (Tanpa Media/Gambar)
 * Jalankan via CLI pada server VPS WordPress: php export_vps_products.php
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

echo "Memulai ekspor data produk dari VPS...\n";

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'any',
);

$products = get_posts($args);
$export_data = array();

foreach ($products as $post) {
    $meta = get_post_meta($post->ID);
    
    // Taxonomies
    $taxonomies = get_object_taxonomies('product');
    $terms = array();
    foreach ($taxonomies as $tax) {
        $terms[$tax] = wp_get_object_terms($post->ID, $tax, array('fields' => 'slugs'));
    }

    $export_data[] = array(
        'ID'           => $post->ID,
        'post_title'   => $post->post_title,
        'post_name'    => $post->post_name,
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_status'  => $post->post_status,
        'meta'         => $meta,
        'terms'        => $terms,
    );
}

$output_file = __DIR__ . '/vps_products_export.json';
file_put_contents($output_file, json_encode($export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "BERHASIL: Mengekspor " . count($export_data) . " produk ke " . $output_file . "\n";
