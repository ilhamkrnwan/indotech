<?php
/**
 * PT Indotech Berkah Abadi
 * Yoast SEO Configuration Script for Products
 * 
 * Instructions:
 * 1. Push changes to GitHub and pull on VPS.
 * 2. Run: php sett_ai/update_yoast_seo.php
 */

define('WP_USE_THEMES', false);
require_once __DIR__ . '/../wp-load.php';

if (php_sapi_name() !== 'cli') {
    die("Error: This script must be executed via CLI (SSH terminal) for safety.\n");
}

echo "=== PT Indotech Berkah Abadi - Updating Yoast SEO Configuration ===\n";

$seo_configs = array(
    // 1. KONSENTRAT PARFUM ALKOHOLBASE
    array(
        'current_slug' => 'konsentrat-parfum-alkohol-base',
        'new_slug'     => 'konsentrat-parfum-alkohol-base',
        'title'        => 'Konsentrat Parfum Alkohol Base',
        'focus_kw'     => 'Konsentrat Parfum Alkohol Base',
        'seo_title'    => 'Jual Konsentrat Parfum Alkohol Base 10L | Indotech',
        'meta_desc'    => 'Konsentrat parfum alkohol base siap pakai 10 Liter dari Indotech. Diformulasikan dengan alkohol premium & fixative agar wangi laundry bertahan sangat lama.'
    ),
    // 2. NaCl
    array(
        'current_slug' => 'nacl',
        'new_slug'     => 'nacl-garam-murni-industri',
        'title'        => 'NaCl',
        'focus_kw'     => 'NaCl Garam Industri',
        'seo_title'    => 'Jual NaCl Garam Murni Kualitas Industri | Indotech',
        'meta_desc' => 'Cari NaCl murni tanpa yodium berkualitas industri? Pengental sabun cair alami yang sangat efektif meningkatkan viskositas deterjen & sabun cuci piring.'
    ),
    // 3. FOAM BOOSTER
    array(
        'current_slug' => 'foam-booster',
        'new_slug'     => 'foam-booster-capb-sabun',
        'title'        => 'Foam Booster',
        'focus_kw'     => 'Foam Booster CAPB',
        'seo_title'    => 'Jual Foam Booster CAPB Pengental & Busa Sabun | Indotech',
        'meta_desc'    => 'Tingkatkan melimpahnya busa sabun Anda dengan Foam Booster CAPB premium. Memberikan efek busa tebal, stabil, dan ekstra lembut di tangan.'
    )
);

foreach ($seo_configs as $cfg) {
    echo "\nProcessing: '{$cfg['title']}'...\n";
    
    // Find post by current slug
    $posts = get_posts(array(
        'name'        => $cfg['current_slug'],
        'post_type'   => 'product',
        'post_status' => 'any',
        'numberposts' => 1
    ));
    
    // If not found by current slug, check by new slug (in case already renamed)
    if (empty($posts) && $cfg['current_slug'] !== $cfg['new_slug']) {
        $posts = get_posts(array(
            'name'        => $cfg['new_slug'],
            'post_type'   => 'product',
            'post_status' => 'any',
            'numberposts' => 1
        ));
    }
    
    if (empty($posts)) {
        echo "  [Warning] Product with slug '{$cfg['current_slug']}' not found.\n";
        continue;
    }
    
    $post_id = $posts[0]->ID;
    echo "  Found product ID: $post_id\n";
    
    // Update slug (post_name) if it has changed
    if ($posts[0]->post_name !== $cfg['new_slug']) {
        wp_update_post(array(
            'ID'        => $post_id,
            'post_name' => $cfg['new_slug']
        ));
        echo "  Slug updated: '{$posts[0]->post_name}' -> '{$cfg['new_slug']}'\n";
    } else {
        echo "  Slug already matches: '{$cfg['new_slug']}'\n";
    }
    
    // Update Yoast SEO Meta
    update_post_meta($post_id, '_yoast_wpseo_focuskw', $cfg['focus_kw']);
    update_post_meta($post_id, '_yoast_wpseo_title', $cfg['seo_title']);
    update_post_meta($post_id, '_yoast_wpseo_metadesc', $cfg['meta_desc']);
    
    echo "  Yoast SEO focus keyword set to: '{$cfg['focus_kw']}'\n";
    echo "  Yoast SEO title set to: '{$cfg['seo_title']}'\n";
    echo "  Yoast SEO meta description set.\n";
}

echo "\n=== Yoast SEO Configuration Completed Successfully! ===\n";
