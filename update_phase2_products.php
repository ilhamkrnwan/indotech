<?php
/**
 * Script Update Penyesuaian Produk Indotech Phase 2 (18 Produk: No. 35 - 52)
 * Berdasarkan REFERENCES-PHASE-2.md
 * (Tanpa mengubah/menyentuh media/gambar produk)
 * 
 * Jalankan via CLI pada VPS (/home/indotech.id/public_html) atau Lokal:
 * php update_phase2_products.php
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

echo "=== Memulai Penyesuaian 18 Produk Phase 2 (No. 35 - 52) Berdasarkan REFERENCES-PHASE-2.md ===\n\n";

/**
 * Helper untuk memformat item list <li> dengan label tebal (bold) jika mengandung titik dua (:)
 */
function phase2_format_li_item($text) {
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
function phase2_extract_items_from_block($text_block) {
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
function phase2_parse_content($content) {
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
            $result['features'] = phase2_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Komposisi(?:\s+Bahan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['ingredients'] = phase2_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Cara\s+(Penggunaan|Pengolahan))\s*===\n*(.*)$/is', $block, $m)) {
            if (stristr($m[1], 'Pengolahan')) {
                $result['directions_title'] = 'Cara Pengolahan';
            }
            $result['directions'] = phase2_extract_items_from_block($m[3]);
        } elseif (preg_match('/^===\s*(Petunjuk\s+Keamanan(?:\s*(?:&amp;|&|\b)\s*Penyimpanan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['safety'] = phase2_extract_items_from_block($m[2]);
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
function phase2_render_html($desc, $features, $ingredients, $directions, $safety, $directions_title = 'Cara Penggunaan') {
    $clean_desc = trim(preg_replace('/^(?:Deskripsi\s+Produk\s*|Deskripsi\s*)+/i', '', trim($desc)));

    $html = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($clean_desc) . "</p>\n\n";

    if (!empty($features)) {
        $html .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
        foreach ($features as $f) {
            $html .= "  <li>" . phase2_format_li_item($f) . "</li>\n";
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

// ── Aturan Perubahan 18 Produk Phase 2 Berdasarkan REFERENCES-PHASE-2.md ─────────────────
$product_rules = array(
    // 35. Hand Sanitizer Cair
    array(
        'search' => 'hand-sanitizer-cair-antiseptik-cuci-tangan',
        'new_desc' => 'Hand Sanitizer Cair merupakan cairan antiseptik pembersih tangan berbasis alkohol premium yang dikemas secara higienis, menjadikannya pilihan ideal dan ekonomis untuk pengisian ulang dispenser hand sanitizer. Produk sanitasi ini diformulasikan khusus agar efektif membunuh kuman, bakteri, dan virus berbahaya pada permukaan kulit tangan dengan cepat tanpa memerlukan bilasan air. Sangat cocok diletakkan di berbagai fasilitas umum dengan mobilitas tinggi, seperti area kantor, sekolah, restoran, hotel, pusat perbelanjaan, dan rumah sakit guna mendukung protokol kesehatan harian.',
        'remove_feature_index' => 2,
        'remove_ingredients' => array('Aloe Vera extract', 'aloe vera'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Aroma' => 'Lemon Fresh',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Ethanol >=70% (Alkohol aktif), Glycerin pelembab tangan'
        )
    ),

    // 36. Green Solvent
    array(
        'search' => 'green-solvent-pembersih-minyak-lemak-ramah-lingkungan',
        'update_feature_index' => array(2 => 'Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok Untuk' => 'kebaya dengan payet rumit, jas almamater, blazer, dan gaun pesta',
            'Bahan Aktif' => 'Biodegradable Solvent (D-Limonene base), Surfaktan emulsifier minyak-air, Anti-bacterial agent ringan'
        )
    ),

    // 37. Glory
    array(
        'search' => 'glory-softener-pelembut-pakaian',
        'remove_feature_index' => 3,
        'specs' => array(
            'Ukuran Tersedia' => '1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pelembut & Softener Pakaian',
            'Bahan Aktif' => 'Surfaktan, Micro parfum, Parfum'
        )
    ),

    // 38. Glika
    array(
        'search' => 'glika-pelicin-pengharum-kain',
        'specs' => array(
            'Ukuran Tersedia' => '1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok Untuk' => 'Semua Jenis Kain, Linen, Seragam',
            'Fungsi' => 'Pelicin Setrika & Pengharum Kain',
            'Bahan Aktif' => 'Fragrance, Anti Fungi Agent'
        )
    ),

    // 39. Glass Cleaner
    array(
        'search' => 'glass-cleaner-pembersih-kaca-cermin',
        'update_feature_index' => array(2 => 'Aman untuk semua jenis kaca: Tidak korosif, meninggalkan bercak, dan menjaga kaca tetap bersih setelah penggunaan.'),
        'specs' => array(
            'Ukuran Tersedia' => '1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pembersih Kaca, Cermin, Permukaan Transparan',
            'Bahan Aktif' => 'Isopropyl Alcohol (IPA), Surfaktan non-ionik anti-bercak, Deionized water'
        )
    ),

    // 40. Deterjen Helm
    array(
        'search' => 'deterjen-helm-sabun-cuci-helm-khusus',
        'update_feature_index' => array(2 => 'Aman untuk semua jenis helm: membantu menjaga kebersihan semua jenis helm tanpa perlu menggunakan deterjen pakaian yang mungkin terlalu keras untuk beberapa material.'),
        'new_ingredients' => array('Surfaktan', 'Fragrance'),
        'specs' => array(
            'Ukuran Tersedia' => '1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Sabun Cuci Busa & Padding Helm',
            'Bahan Aktif' => 'Surfaktan, Fragrance'
        )
    ),

    // 41. Deodoran
    array(
        'search' => 'deodoran-pewangi-penghilang-bau-kain',
        'update_feature_index' => array(2 => 'Membantu Mengurangi Bau Badan: Membantu menjaga kesegaran tubuh dengan mengurangi bau yang timbul akibat keringat.'),
        'new_ingredients' => array('Antibacterial deodorizing agent', 'potassium aluminum sulfate dodecahydrate', 'Fragrance', 'Aqua'),
        'new_directions' => array(
            'Semprotkan langsung ke ketiak dari jarak 15–20 cm.',
            'Tunggu 30 detik hingga mengering sebelum memakai pakaian.',
            'Tersedia dalam kemasan spray 60ml untuk pemakaian praktis dan 1000ml isi ulang.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => '60 ml, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol',
            'Varian Aroma' => 'Reguler, Dunhill, Polo, Vanilla, Spray',
            'Bahan Aktif' => 'Antibacterial deodorizing agent, potassium aluminum sulfate dodecahydrate, Fragrance, Aqua'
        )
    ),

    // 42. Denum
    array(
        'search' => 'denum-deterjen-cair-premium-laundry',
        'update_feature_index' => array(2 => 'Hemat digunakan: Formula konsentrat membuat penggunaan lebih efisien karena sedikit produk dapat digunakan untuk satu kali pencucian (sesuaikan dengan petunjuk dosis).'),
        'new_ingredients' => array('Surfaktan', 'Fragrance'),
        'specs' => array(
            'Ukuran Tersedia' => '1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Jrigen',
            'Kompatibilitas' => 'Mesin Cuci (Front & Top Load) & Manual',
            'Bahan Aktif' => 'Surfaktan, Fragrance'
        )
    ),

    // 43. Crystal Cleaner
    array(
        'search' => 'crystal-cleaner-pembersih-kristal-serbaguna',
        'new_ingredients' => array('Solid Hydrogen Peroxide'),
        'specs' => array(
            'Ukuran Tersedia' => '100 gram',
            'Bentuk Fisik' => 'Kristal / Granul',
            'Kemasan' => 'Botol',
            'Kompatibilitas' => 'Mesin Cuci (Front & Top Load)',
            'Bahan Aktif' => 'Solid Hydrogen Peroxide'
        )
    ),

    // 44. Chlorine Bleach
    array(
        'search' => 'chlorine-bleach-pemutih-pakaian-profesional',
        'new_features' => array(
            'Membantu Memutihkan Pakaian Putih: Membantu mengembalikan tampilan pakaian putih yang kusam akibat noda dan pemakaian sehari-hari.',
            'Membantu Mengurangi Bau Tidak Sedap: Membantu mengurangi bau yang berasal dari noda organik atau area lembap setelah proses pembersihan.',
            'Mudah Digunakan: Dapat digunakan dengan cara diencerkan atau sesuai petunjuk penggunaan pada kemasan.'
        ),
        'new_ingredients' => array('Sodium Hypochlorite', 'Air murni terdeionisasi'),
        'specs' => array(
            'Ukuran Tersedia' => '1 liter dan 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Sodium Hypochlorite'
        )
    ),

    // 45. Alkali
    array(
        'search' => 'alkali-pengangkat-noda-pencerah-pakaian',
        'specs' => array(
            'Ukuran Tersedia' => '1 liter dan 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi Utama' => 'Booster Deterjen & Pengangkat Noda',
            'Aplikasi' => 'Laundry Profesional & Industri',
            'Bahan Aktif' => 'Sodium hydroxide'
        )
    ),

    // 46. Semir Ban
    array(
        'search' => 'semir-ban-tire-shine-dressing-kendaraan',
        'specs' => array(
            'Bentuk Fisik' => 'Cairan sedikit gel',
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 47. Pengusir Tikus
    array(
        'search' => 'pengusir-tikus-rodent-repellent-kendaraan',
        'specs' => array(
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 48. Pengkilap Body
    array(
        'search' => 'pengkilap-body-wax-shine-bodi-kendaraan',
        'specs' => array(
            'Bentuk Fisik' => 'Cairan sedikit gel',
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 49. Penghitam Body
    array(
        'search' => 'penghitam-body-restorer-eksterior-kendaraan',
        'specs' => array(
            'Bentuk Fisik' => 'Cairan',
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 50. Pembersih Kaca Mobil
    array(
        'search' => 'pembersih-kaca-mobil-glass-cleaner-kendaraan',
        'specs' => array(
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 51. Pembersih Interior
    array(
        'search' => 'pembersih-interior-perawatan-kabin-kendaraan',
        'specs' => array(
            'Ukuran Tersedia' => '250 ml, 900 ml'
        )
    ),

    // 52. Compound
    array(
        'search' => 'compound-poles-bodi-penghilang-baret-kendaraan',
        'specs' => array(
            'Ukuran Tersedia' => '100 gram'
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
    $parsed = phase2_parse_content($post->post_content);

    // Apply Transformations
    $new_title = isset($rule['new_title']) ? $rule['new_title'] : null;

    if (isset($rule['new_desc'])) {
        $new_desc = $rule['new_desc'];
    } else {
        $new_desc = $parsed['desc'];
    }

    $features = isset($rule['new_features']) ? $rule['new_features'] : $parsed['features'];
    $remove_feature_index = isset($rule['remove_feature_index']) ? $rule['remove_feature_index'] : null;
    $update_feature_index = isset($rule['update_feature_index']) ? $rule['update_feature_index'] : null;

    if (!empty($update_feature_index) && is_array($update_feature_index) && !empty($features)) {
        foreach ($update_feature_index as $idx => $new_val) {
            $array_idx = $idx - 1;
            if (isset($features[$array_idx])) {
                $features[$array_idx] = $new_val;
            }
        }
    }

    if (!empty($remove_feature_index) && !empty($features)) {
        $filtered_f = array();
        foreach ($features as $f_idx => $f_val) {
            if (($f_idx + 1) != $remove_feature_index) {
                $filtered_f[] = $f_val;
            }
        }
        $features = array_values($filtered_f);
    }

    $ingredients = isset($rule['new_ingredients']) ? $rule['new_ingredients'] : $parsed['ingredients'];
    $remove_ingredients = isset($rule['remove_ingredients']) ? $rule['remove_ingredients'] : null;

    if (!empty($remove_ingredients) && is_array($remove_ingredients) && !empty($ingredients)) {
        $filtered_ing = array();
        foreach ($ingredients as $ing_val) {
            $should_remove = false;
            foreach ($remove_ingredients as $ri) {
                if (stripos($ing_val, $ri) !== false) {
                    $should_remove = true;
                    break;
                }
            }
            if (!$should_remove) {
                $filtered_ing[] = $ing_val;
            }
        }
        $ingredients = array_values($filtered_ing);
    }

    $directions = isset($rule['new_directions']) ? $rule['new_directions'] : $parsed['directions'];
    $directions_title = isset($rule['directions_title']) ? $rule['directions_title'] : $parsed['directions_title'];
    $safety = !empty($parsed['safety']) ? $parsed['safety'] : array();

    // Rakit ulang HTML terstruktur
    $final_html = phase2_render_html(
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
    echo "[$success_count/18] BERHASIL UPDATE PHASE 2: {$post->post_title} (ID: $post_id)\n";
}

echo "\n=== SELESAI: 18 PRODUK PHASE 2 (NO. 35 - 52) BERHASIL DIPERBARUI TANPA MENGUBAH MEDIA/GAMBAR! ===\n";
