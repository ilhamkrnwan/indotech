<?php
/**
 * Script Update Penyesuaian Produk Indotech Phase 3 (4 Produk: No. 53 - 56)
 * Berdasarkan REFERENCES-PHASE-3.md
 * (Tanpa mengubah/menyentuh media/gambar produk)
 * 
 * Jalankan via CLI pada VPS (/home/indotech.id/public_html) atau Lokal:
 * php update_phase3_products.php
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

// Nonaktifkan filter kses dan set user admin agar HTML tidak difilter/dibersihkan oleh WP
if (function_exists('kses_remove_filters')) {
    kses_remove_filters();
}
if (function_exists('wp_set_current_user')) {
    wp_set_current_user(1);
}

echo "=== Memulai Penyesuaian 4 Produk Phase 3 (No. 53 - 56) Berdasarkan REFERENCES-PHASE-3.md ===\n\n";

/**
 * Helper untuk memformat item list <li> dengan label tebal (bold) jika mengandung titik dua (:)
 */
function phase3_format_li_item($text) {
    $clean_text = trim(strip_tags($text, '<strong><b><i><em>'));
    $clean_text = preg_replace('/^<\s*(?:strong|b)\s*>(.*?)<\s*\/\s*(?:strong|b)\s*>\s*:?/i', '$1:', $clean_text);
    
    if (strpos($clean_text, ':') !== false) {
        $parts = explode(':', $clean_text, 2);
        $title = trim($parts[0]);
        $val = trim($parts[1]);
        if (!empty($title) && !empty($val)) {
            return "<strong>" . esc_html($title) . ":</strong> " . esc_html($val);
        }
    }
    return esc_html($clean_text);
}

/**
 * Helper mengekstrak item list dari teks
 */
function phase3_extract_items_from_block($text_block) {
    $items = array();
    if (strpos($text_block, '<li>') !== false) {
        preg_match_all('/<li>(.*?)<\/li>/is', $text_block, $lis);
        if (!empty($lis[1])) {
            foreach ($lis[1] as $li) {
                $item = trim(strip_tags($li));
                if (!empty($item)) {
                    $items[] = $item;
                }
            }
            return array_values(array_filter($items));
        }
    }

    $lines = explode("\n", $text_block);
    foreach ($lines as $line) {
        $clean = trim(strip_tags($line));
        $clean = preg_replace('/^(?:\d+[\.\)]\s*|[-*\x{2022}]\s*)/u', '', $clean);
        if (!empty($clean)) {
            $items[] = $clean;
        }
    }
    return array_values(array_filter($items));
}

/**
 * Universal Parser untuk ekstrak section
 */
function phase3_parse_content($content) {
    $result = array(
        'desc' => '',
        'features' => array(),
        'ingredients' => array(),
        'directions' => array(),
        'safety' => array(),
        'directions_title' => 'Cara Penggunaan'
    );

    $content = str_replace(array("\r\n", "\r"), "\n", $content);
    $content = preg_replace('/<h3[^>]*>\s*(.*?)\s*<\/h3>/i', "\n\n===$1===\n\n", $content);
    $content = str_replace('###', '', $content);

    $plain_keywords = array(
        'desc'        => '/^(?:Deskripsi(?:\s+Produk)?)$/i',
        'features'    => '/^(?:Fitur\s*(?:&amp;|&|\b)\s*Keunggulan)$/i',
        'ingredients' => '/^(?:Komposisi(?:\s+Bahan)?)$/i',
        'directions'  => '/^(?:Cara\s+(Penggunaan|Pengolahan))$/i',
        'safety'      => '/^(?:Petunjuk\s+Keamanan(?:\s*(?:&amp;|&|\b)\s*Penyimpanan)?)$/i',
    );

    $lines = explode("\n", $content);
    $new_lines = array();
    foreach ($lines as $line) {
        $trimmed = trim(strip_tags($line));
        $is_header = false;

        foreach ($plain_keywords as $key => $pattern) {
            if (preg_match($pattern, $trimmed, $m)) {
                $new_lines[] = "===" . $trimmed . "===";
                $is_header = true;
                break;
            }
        }
        if (!$is_header) {
            $new_lines[] = $line;
        }
    }

    $full_text = implode("\n", $new_lines);
    $blocks = preg_split('/\n(?====\s*)/', $full_text);

    foreach ($blocks as $block) {
        $block = trim($block);
        if (empty($block)) continue;

        if (preg_match('/^===\s*(Deskripsi(?:\s+Produk)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['desc'] = trim(strip_tags($m[2]));
        } elseif (preg_match('/^===\s*(Fitur\s*(?:&amp;|&|\b)\s*Keunggulan)\s*===\n*(.*)$/is', $block, $m)) {
            $result['features'] = phase3_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Komposisi(?:\s+Bahan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['ingredients'] = phase3_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Cara\s+(Penggunaan|Pengolahan))\s*===\n*(.*)$/is', $block, $m)) {
            if (stristr($m[1], 'Pengolahan')) {
                $result['directions_title'] = 'Cara Pengolahan';
            }
            $result['directions'] = phase3_extract_items_from_block($m[3]);
        } elseif (preg_match('/^===\s*(Petunjuk\s+Keamanan(?:\s*(?:&amp;|&|\b)\s*Penyimpanan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['safety'] = phase3_extract_items_from_block($m[2]);
        } else {
            $clean_block = trim(strip_tags(preg_replace('/===.*?===/', '', $block)));
            if (!empty($clean_block) && empty($result['desc'])) {
                $result['desc'] = $clean_block;
            }
        }
    }

    $result['desc'] = trim(preg_replace('/^(?:===.*?===|\s*Deskripsi\s*Produk\s*|Deskripsi\s*)+/i', '', $result['desc']));
    return $result;
}

/**
 * Helper Merakit HTML Terstruktur
 */
function phase3_render_html($desc, $features, $ingredients, $directions, $safety, $directions_title = 'Cara Pengolahan') {
    $clean_desc = trim(preg_replace('/^(?:Deskripsi\s+Produk\s*|Deskripsi\s*)+/i', '', trim($desc)));

    $html = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($clean_desc) . "</p>\n\n";

    if (!empty($features)) {
        $html .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
        foreach ($features as $f) {
            $html .= "  <li>" . phase3_format_li_item($f) . "</li>\n";
        }
        $html .= "</ul>\n\n";
    }

    if (!empty($ingredients)) {
        $html .= "<h3>Komposisi Bahan</h3>\n<ul>\n";
        foreach ($ingredients as $i) {
            $html .= "  <li>" . esc_html($i) . "</li>\n";
        }
        $html .= "</ul>\n\n";
    }

    if (!empty($directions)) {
        $html .= "<h3>" . esc_html($directions_title) . "</h3>\n<ol>\n";
        foreach ($directions as $d) {
            $html .= "  <li>" . esc_html($d) . "</li>\n";
        }
        $html .= "</ol>\n\n";
    }

    if (empty($safety)) {
        $safety = array(
            'Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).',
            'Hindari paparan sinar matahari langsung dan area lembap.',
            'Jauhkan dari jangkauan anak-anak dan hewan peliharaan.',
            'Gunakan sarung tangan karet saat menangani konsentrat untuk mencegah iritasi kulit.',
            'Jika terkena mata, bilas segera dengan air mengalir selama 15 menit.'
        );
    }

    $html .= "<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>\n<ul>\n";
    foreach ($safety as $s) {
        $html .= "  <li>" . esc_html($s) . "</li>\n";
    }
    $html .= "</ul>\n";

    return $html;
}

// ── Aturan Perubahan 4 Produk Phase 3 Berdasarkan REFERENCES-PHASE-3.md ─────────────────
$product_rules = array(
    // 53. Determat Eco – Paket Bahan Detergen Cair Ekonomis
    array(
        'search' => 'determat-eco-paket-bahan-detergen-cair-ekonomis',
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Larutkan bahan-bahan yang ada di dalam kardus ke dalam wadah sesuai dengan petunjuk pengolahan.',
            'Tambahkan formulasi pewangi dan pewarna yang telah disediakan.',
            'Tuangkan air sesuai petunjuk pengolahan dan aduk sampai homogen.',
            'Masukkan garam secara bertahap sesuai dengan takaran petunjuk pengolahan dan aduk sampai homogen.',
            'Diamkan sampai busa hilang setelah itu bisa digunakan dan dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 15 - 20 liter)',
            'Bentuk Fisik' => 'Paket bahan deterjen cair ekonomis',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance, Colorant Powder packet'
        )
    ),

    // 54. Determat – Paket Bahan Detergen Cair
    array(
        'search' => 'determat-paket-bahan-detergen-cair',
        'update_feature_index' => array(2 => 'Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'new_ingredients' => array('Active surfactant agents', 'Fragrance', 'Colorant Powder packet'),
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Larutkan bahan-bahan yang ada di dalam kardus ke dalam wadah sesuai dengan petunjuk pengolahan.',
            'Tambahkan formulasi pewangi dan pewarna yang telah disediakan.',
            'Tuangkan air sesuai petunjuk pengolahan dan aduk sampai homogen.',
            'Masukkan garam secara bertahap sesuai dengan takaran petunjuk pengolahan dan aduk sampai homogen.',
            'Diamkan sampai busa hilang setelah itu bisa digunakan dan dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 15 - 20 liter)',
            'Bentuk Fisik' => 'Paket bahan deterjen cair',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance, Colorant Powder packet'
        )
    ),

    // 55. Biang Karbol – Paket Bahan Setengah Jadi Karbol Wangi
    array(
        'search' => 'biang-karbol-paket-bahan-karbol-wangi',
        'transform_features' => function($features) {
            if (!empty($features) && isset($features[0])) {
                $features[0] = str_ireplace(array('pinus', 'pinus '), '', $features[0]);
                $features[0] = trim(preg_replace('/\s+/', ' ', $features[0]));
            }
            return $features;
        },
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 5 liter dan air bersih atau air yang rendah mineralnya 4,5 liter.',
            'Tuangkan biang karbol ke wadah.',
            'Masukkan air yang telah disiapkan.',
            'Aduk merata hingga warna tercampur sempurna.',
            'Karbol siap digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Cairan (Biang)',
            'Aroma' => 'Cemara Pinus (Pine) dan Sereh (Citrunella)',
            'Fungsi Utama' => 'Pembersih Lantai & Disinfektan',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Pine oil 17%, Benzalkonium chloride 1%'
        )
    ),

    // 56. Arai – Paket Bahan Sabun Cuci Tangan
    array(
        'search' => 'arai-paket-bahan-sabun-cuci-tangan',
        'transform_desc' => function($desc) {
            $paras = explode("\n", trim($desc));
            return trim($paras[0]);
        },
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Larutkan bahan-bahan yang ada di dalam kardus ke dalam wadah sesuai dengan petunjuk pengolahan.',
            'Tambahkan formulasi pewangi dan pewarna yang telah disediakan.',
            'Tuangkan air sesuai petunjuk pengolahan dan aduk sampai homogen.',
            'Masukkan garam secara bertahap sesuai dengan takaran petunjuk pengolahan dan aduk sampai homogen.',
            'Diamkan sampai busa hilang setelah itu bisa digunakan dan dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 10 - 15 liter)',
            'Fungsi Utama' => 'Sabun Cuci Tangan (Hand Wash)',
            'Aroma' => 'Wangi Strawberry',
            'Bentuk Fisik' => 'Paket bahan sabun cuci tangan',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance, Colorant Powder packet'
        )
    )
);

// Proses Eksekusi Update ke Database WordPress
$success_count = 0;

foreach ($product_rules as $rule) {
    $search = $rule['search'];

    // Cari post berdasarkan slug / path
    $posts = get_posts(array(
        'name'        => $search,
        'post_type'   => 'product',
        'post_status' => 'any',
        'numberposts' => 1
    ));

    if (empty($posts)) {
        // Fallback: cari berdasarkan LIKE slug / title
        global $wpdb;
        $found_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND (post_name LIKE %s OR post_title LIKE %s) LIMIT 1", '%' . $search . '%', '%' . $search . '%'));
        if ($found_id) {
            $posts = array(get_post($found_id));
        }
    }

    if (empty($posts)) {
        echo "[WARNING] Produk tidak ditemukan untuk keyword: {$search}\n";
        continue;
    }

    $post = $posts[0];
    $post_id = $post->ID;

    // Parse konten eksisting
    $parsed = phase3_parse_content($post->post_content);

    // Apply Transformations
    $new_title = isset($rule['new_title']) ? $rule['new_title'] : null;

    if (isset($rule['new_desc'])) {
        $new_desc = $rule['new_desc'];
    } elseif (isset($rule['transform_desc']) && is_callable($rule['transform_desc'])) {
        $new_desc = $rule['transform_desc']($parsed['desc']);
    } else {
        $new_desc = $parsed['desc'];
    }

    $features = isset($rule['new_features']) ? $rule['new_features'] : $parsed['features'];
    $update_feature_index = isset($rule['update_feature_index']) ? $rule['update_feature_index'] : null;

    if (!empty($update_feature_index) && is_array($update_feature_index) && !empty($features)) {
        foreach ($update_feature_index as $idx => $new_val) {
            $array_idx = $idx - 1;
            if (isset($features[$array_idx])) {
                $features[$array_idx] = $new_val;
            }
        }
    }

    if (isset($rule['transform_features']) && is_callable($rule['transform_features'])) {
        $features = $rule['transform_features']($features);
    }

    $ingredients = isset($rule['new_ingredients']) ? $rule['new_ingredients'] : $parsed['ingredients'];
    $directions = isset($rule['new_directions']) ? $rule['new_directions'] : $parsed['directions'];
    $directions_title = isset($rule['directions_title']) ? $rule['directions_title'] : 'Cara Pengolahan';
    $safety = !empty($parsed['safety']) ? $parsed['safety'] : array();

    // Rakit ulang HTML terstruktur
    $final_html = phase3_render_html(
        $new_desc,
        $features,
        $ingredients,
        $directions,
        $safety,
        $directions_title
    );

    // Update Post Content & Title
    $update_arr = array(
        'ID'           => $post_id,
        'post_content' => $final_html,
    );

    if (!empty($new_title)) {
        $update_arr['post_title'] = $new_title;
    }

    wp_update_post($update_arr);

    // Update Meta Carbon Fields Spesifikasi Teknis (product_specifications)
    if (!empty($rule['specs']) && is_array($rule['specs'])) {
        $new_specs = array();
        foreach ($rule['specs'] as $sk => $sv) {
            $new_specs[] = array(
                'spec_name'  => $sk,
                'spec_value' => $sv,
            );
        }

        if (function_exists('carbon_set_post_meta')) {
            carbon_set_post_meta($post_id, 'product_specifications', $new_specs);
        } else {
            global $wpdb;
            $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND (meta_key = '_product_specifications' OR meta_key LIKE '_product_specifications|%%')", $post_id));
            $formatted = array();
            foreach ($new_specs as $ns) {
                $formatted[] = array(
                    '_type'      => '_',
                    'spec_name'  => $ns['spec_name'],
                    'spec_value' => $ns['spec_value'],
                );
            }
            update_post_meta($post_id, '_product_specifications', $formatted);
        }
    }

    $success_count++;
    echo "[$success_count/4] BERHASIL UPDATE PHASE 3: {$post->post_title} (ID: $post_id)\n";
}

echo "\n=== SELESAI: 4 PRODUK PHASE 3 (NO. 53 - 56) BERHASIL DIPERBARUI TANPA MENGUBAH MEDIA/GAMBAR! ===\n";
