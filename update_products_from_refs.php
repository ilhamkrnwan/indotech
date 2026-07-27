<?php
/**
 * Script Update & Restorasi Produk Indotech dengan Format Bold & Heading Presisi
 * Jalankan via CLI: php update_products_from_refs.php
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

echo "=== Memulai Restorasi & Update Struktur HTML Produk Berdasarkan REFERENCES.MD ===\n";

// Muat backup awal jika ada (vps_products_export.json)
$backup_file = __DIR__ . '/vps_products_export.json';
$backup_products = array();

if (file_exists($backup_file)) {
    $raw_backup = json_decode(file_get_contents($backup_file), true);
    if (is_array($raw_backup)) {
        foreach ($raw_backup as $b_item) {
            $backup_products[$b_item['ID']] = $b_item;
            $backup_products['slug_' . $b_item['post_name']] = $b_item;
            $backup_products['title_' . strtolower(trim($b_item['post_title']))] = $b_item;
        }
        echo "Berhasil memuat " . count($raw_backup) . " produk dari backup (vps_products_export.json).\n";
    }
}

/**
 * Helper untuk memformat teks li dengan label tebal (bold) jika mengandung titik dua (:)
 */
function format_li_item($text) {
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
 * Helper untuk menyusun ulang HTML post_content dengan section terstruktur dan bolding
 */
function build_structured_content(
    $orig_content,
    $new_desc = null,
    $new_features = null,
    $remove_features = null,
    $new_ingredients = null,
    $remove_ingredients = null,
    $new_directions = null,
    $remove_direction_index = null,
    $directions_title = 'Cara Penggunaan'
) {
    // 1. Dapatkan Deskripsi
    $desc_text = '';
    if (!empty($new_desc)) {
        $desc_text = $new_desc;
    } elseif (preg_match('/<h3>Deskripsi Produk<\/h3>\s*<p>(.*?)<\/p>/is', $orig_content, $m)) {
        $desc_text = trim(strip_tags($m[1]));
    } else {
        $clean = preg_replace('/<h3>.*?<\/h3>/i', '', $orig_content);
        $clean = preg_replace('/<ul.*?>.*?<\/ul>/is', '', $clean);
        $clean = preg_replace('/<ol.*?>.*?<\/ol>/is', '', $clean);
        $desc_text = trim(strip_tags($clean));
    }

    // Hapus pengulangan kata "Deskripsi Produk" di dalam paragraf
    $desc_text = preg_replace('/^(?:Deskripsi\s+Produk\s*)+/i', '', trim($desc_text));

    // 2. Dapatkan Fitur & Keunggulan
    $features_list = array();
    if (!empty($new_features) && is_array($new_features)) {
        $features_list = $new_features;
    } elseif (preg_match('/<h3>Fitur (?:&amp;|&) Keunggulan<\/h3>\s*<ul.*?>(.*?)<\/ul>/is', $orig_content, $m)) {
        preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $lis);
        if (!empty($lis[1])) {
            foreach ($lis[1] as $li) {
                $features_list[] = trim(strip_tags($li));
            }
        }
    }

    // Filter remove_features
    if (!empty($remove_features) && is_array($remove_features) && !empty($features_list)) {
        $filtered = array();
        foreach ($features_list as $f_idx => $f_val) {
            $should_remove = false;
            foreach ($remove_features as $rf) {
                if (is_numeric($rf) && ($f_idx + 1) == $rf) {
                    $should_remove = true;
                    break;
                } elseif (is_string($rf) && stripos($f_val, $rf) !== false) {
                    $should_remove = true;
                    break;
                }
            }
            if (!$should_remove) {
                $filtered[] = $f_val;
            }
        }
        $features_list = $filtered;
    }

    // 3. Dapatkan Komposisi Bahan
    $ingredients_list = array();
    if (!empty($new_ingredients) && is_array($new_ingredients)) {
        $ingredients_list = $new_ingredients;
    } elseif (preg_match('/<h3>Komposisi Bahan<\/h3>\s*<ul.*?>(.*?)<\/ul>/is', $orig_content, $m)) {
        preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $lis);
        if (!empty($lis[1])) {
            foreach ($lis[1] as $li) {
                $ingredients_list[] = trim(strip_tags($li));
            }
        }
    }

    // Filter remove_ingredients
    if (!empty($remove_ingredients) && is_array($remove_ingredients) && !empty($ingredients_list)) {
        $filtered_ing = array();
        foreach ($ingredients_list as $ing_val) {
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
        $ingredients_list = $filtered_ing;
    }

    // 4. Dapatkan Cara Penggunaan / Pengolahan
    $directions_list = array();
    if (!empty($new_directions) && is_array($new_directions)) {
        $directions_list = $new_directions;
    } elseif (preg_match('/<h3>Cara (?:Penggunaan|Pengolahan)<\/h3>\s*<ol.*?>(.*?)<\/ol>/is', $orig_content, $m)) {
        preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $lis);
        if (!empty($lis[1])) {
            foreach ($lis[1] as $li) {
                $directions_list[] = trim(strip_tags($li));
            }
        }
    }

    // Filter remove_direction_index
    if (!empty($remove_direction_index) && !empty($directions_list)) {
        $filtered_dir = array();
        foreach ($directions_list as $d_idx => $d_val) {
            if (($d_idx + 1) != $remove_direction_index) {
                $filtered_dir[] = $d_val;
            }
        }
        $directions_list = $filtered_dir;
    }

    // 5. Dapatkan Petunjuk Keamanan & Penyimpanan
    $safety_list = array();
    if (preg_match('/<h3>Petunjuk Keamanan (?:&amp;|&) Penyimpanan<\/h3>\s*<ul.*?>(.*?)<\/ul>/is', $orig_content, $m)) {
        preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $lis);
        if (!empty($lis[1])) {
            foreach ($lis[1] as $li) {
                $safety_list[] = trim(strip_tags($li));
            }
        }
    }

    if (empty($safety_list)) {
        $safety_list = array(
            'Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).',
            'Hindari paparan sinar matahari langsung dan area lembap.',
            'Jauhkan dari jangkauan anak-anak dan hewan peliharaan.',
            'Gunakan sarung tangan karet saat menangani produk konsentrat untuk mencegah iritasi kulit.',
            'Jika terkena mata, bilas segera dengan air mengalir selama 15 menit.'
        );
    }

    // Rakit HTML kembali
    $html = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($desc_text) . "</p>\n\n";

    if (!empty($features_list)) {
        $html .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
        foreach ($features_list as $f) {
            $html .= "  <li>" . format_li_item($f) . "</li>\n";
        }
        $html .= "</ul>\n\n";
    }

    if (!empty($ingredients_list)) {
        $html .= "<h3>Komposisi Bahan</h3>\n<ul>\n";
        foreach ($ingredients_list as $i) {
            $html .= "  <li>" . esc_html($i) . "</li>\n";
        }
        $html .= "</ul>\n\n";
    }

    if (!empty($directions_list)) {
        $html .= "<h3>" . esc_html($directions_title) . "</h3>\n<ol>\n";
        foreach ($directions_list as $d) {
            $html .= "  <li>" . esc_html($d) . "</li>\n";
        }
        $html .= "</ol>\n\n";
    }

    if (!empty($safety_list)) {
        $html .= "<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>\n<ul>\n";
        foreach ($safety_list as $s) {
            $html .= "  <li>" . esc_html($s) . "</li>\n";
        }
        $html .= "</ul>\n";
    }

    return $html;
}

// ── Aturan Pembaruan Per Produk Berdasarkan REFERENCES.MD ─────────────────
$product_rules = array(
    // 1. Softsense
    array(
        'search' => 'Softsense',
        'new_desc' => 'Softsense adalah paket bahan softener pelembut pakaian konsentrat premium berukuran lebih besar. Dirancang khusus untuk efisiensi tinggi bagi pengusaha laundry maupun kebutuhan rumah tangga besar, satu kemasan Softsense dapat menghasilkan hingga 15 liter pelembut pakaian siap pakai berkualitas tinggi dengan keharuman microcapsule yang mewah.',
        'specs' => array('Bentuk Fisik' => 'Paket bahan softener', 'Kemasan' => 'Box Karton Segel')
    ),

    // 2. Softa
    array(
        'search' => 'Softa',
        'transform_desc' => function($desc) {
            return str_replace(array('paket bahan', 'bahan '), array('paket', ''), $desc);
        }
    ),

    // 3. Octa
    array(
        'search' => 'Octa',
        'new_title' => 'Octa - Paket Bahan Sabun Cuci Piring Pasta',
        'transform_desc' => function($desc) {
            return str_replace('paket bahan', 'paket biang', $desc);
        },
        'remove_ingredients' => array('texapon', 'sles'),
        'remove_direction_index' => 3
    ),

    // 4. Oclean
    array(
        'search' => 'Oclean',
        'new_title' => 'Oclean - Paket Bahan Sabun Cuci Piring 15 liter',
        'new_desc' => 'Oclean adalah paket bahan sabun cuci piring dengan formula khusus pembersih lemak (anti-grease) yang sangat efektif mengangkat kotoran, minyak, dan lemak membandel pada peralatan makan dan masak. Dirancang khusus untuk efisiensi tinggi bagi kebutuhan rumah tangga, pengusaha warung makan maupun restoran besar, satu kemasan oclean dapat menghasilkan hingga 15 liter sabun cuci piring. Aroma jeruk nipis yang segar membantu menghilangkan bau amis secara instan.',
        'new_ingredients' => array('Active surfactant paste', 'Foam booster', 'Fragrance Lime', 'Pewarna'),
        'new_directions' => array(
            'Siapkan wadah besar ukuran minimal 15-20 Liter dan siapkan air bersih sebanyak 9-14 Liter dan garam 1 kg',
            'Larutkan bahan-bahan oclean sesuai dengan petunjuk yang sudah diberikan',
            'Pastikan semua bahan larut rata, lalu diamkan larutan selama 12-24 jam hingga busa mereda sempurna sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 15 liter)',
            'Bentuk Fisik' => 'Paket bahan sabun cuci piring',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant paste dan Foam booster'
        )
    ),

    // 5. Essenz
    array(
        'search' => 'Essenz',
        'new_title' => 'Essenz - Paket bahan parfum waterbase',
        'new_desc' => 'EssenZ adalah formula paket bahan parfum berbasis air (waterbase) premium yang dirancang khusus untuk memberikan keharuman tahan lama pada pakaian tanpa meninggalkan noda kuning atau bercak minyak. Dilengkapi dengan teknologi micro-capsule aktif yang melepaskan aroma wangi secara perlahan saat pakaian mengalami gesekan, sehingga pakaian tetap wangi sepanjang hari.',
        'new_directions' => array(
            'Siapkan wadah besar ukuran minimal 10 Liter dan siapkan air bersih sebanyak 9-14 Liter',
            'Larutkan bahan-bahan essenz sesuai dengan petunjuk yang sudah diberikan',
            'Pastikan semua bahan larut lalu diamkan larutan selama 12 jam sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 8 liter dan 15 liter)',
            'Bentuk Fisik' => 'Paket bahan essenz',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 6. Bibit Parfum & Wewangian
    array(
        'search' => 'Bibit Parfum',
        'remove_features' => array('aman untuk peralatan'),
        'remove_ingredients' => array('Active surfactant agents', 'Aqua & stabilizer'),
        'new_directions' => array(
            'Larutkan bibit dengan produk yang ingin ditambahkan bibit wewangian sesuai takaran kebutuhan.',
            'Aduk sampai larut sempurna',
            'Aplikasikan produk yang sudah ditambahkan bibit wewangian sesuai dengan kegunaan'
        ),
        'specs' => array('Bahan Aktif' => 'Fragrance compound')
    ),

    // 7. Konsentrat Parfum Alkohol Base
    array(
        'search' => 'Konsentrat Parfum Alkohol Base',
        'new_directions' => array(
            'Siapkan wadah besar ukuran minimal 11 Liter dan siapkan metanol sebanyak 8 Liter',
            'Larutkan bahan-bahan konsentrat parfum alkohol base sesuai dengan petunjuk yang sudah diberikan',
            'Pastikan semua bahan larut lalu diamkan larutan selama 12 jam sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan konsentrat parfum alkohol base (hasil 10 liter)',
            'Aroma Tersedia' => 'Sakura, Floral, Lavender, Molto Blue, Ocean, Orchid, Orchid Passion, Phylux',
            'Bentuk Fisik' => 'paket bahan konsentrat parfum alkohol base',
            'Kemasan' => 'box karton segel'
        )
    ),

    // 8. Detta+
    array(
        'search' => 'Detta+',
        'new_directions' => array(
            'Larutkan Biang Deterjen Detta+ dengan air bersih secara bertahap (rasio anjuran 1:4 untuk hasil premium).'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'paket biang (hasil 5 liter)',
            'Aroma Tersedia' => 'Sakura, Molto Blue, Downy Passion, Downy Mystique',
            'Bentuk Fisik' => 'Pasta (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance'
        )
    ),

    // 9. Biang Pelicin Setrika
    array(
        'search' => 'Biang Pelicin Setrika',
        'new_desc' => 'Biang Pelicin Setrika adalah paket biang pelicin setrika dengan formula hasil jadi 5 Liter untuk melembutkan serat kain dan mempermudah proses setrika pakaian. Memberikan aroma harum dan efek antikusut pada pakaian.',
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 5 liter dan air amidis atau air yang rendah mineralnya 4,5 liter',
            'Tuangkan biang pelicin setrika ke wadah',
            'Masukkan air yang telah disiapkan',
            'Aduk merata hingga warna tercampur sempurna',
            'Pelicin setrika siap digunakan atau dikemas'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Cairan (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Fragrance 2.5%, Anti Fungi Agent 0.8%'
        )
    ),

    // 10. Biang Pel Lantai
    array(
        'search' => 'Biang Pel Lantai',
        'new_desc' => 'Biang Pel Lantai adalah paket biang pel lantai konsentrat dengan formula hasil jadi 5 Liter. Efektif mengangkat kotoran, membunuh kuman, serta memberikan keharuman tahan lama pada lantai ruangan Anda.',
        'new_features' => array(
            'Konsentrat Super Hemat: Formula yang dapat diencerkan menjadi cairan pel lantai siap pakai berkualitas tinggi.',
            'Aroma lemon fresh Aromatik: Memberikan keharuman lemon segar yang tahan lama dan menghilangkan bau tidak sedap.'
        ),
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 5 liter dan air bersih atau air yang rendah mineralnya 4,5 liter',
            'Tuangkan biang pel lantai ke wadah',
            'Masukkan air yang telah disiapkan',
            'Aduk merata hingga warna tercampur sempurna',
            'Pel lantai siap digunakan atau dikemas'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Cairan (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Surfaktan 2,9%'
        )
    ),

    // 11. Athari
    array(
        'search' => 'Athari',
        'new_features' => array(
            'Formula Konsentrat Tinggi: Cukup diencerkan dengan air bersih dan garam untuk menghasilkan sabun mandi cair siap pakai dalam volume besar.'
        ),
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 3-5 liter, garam, dan air amidis atau air yang rendah mineralnya 4,5 liter',
            'Tuangkan athari ke wadah',
            'Masukkan air yang telah disiapkan secara bertahap',
            'Aduk merata hingga warna tercampur sempurna',
            'Tambahkan garam secara bertahap dan aduk sampai larut sempurna',
            'Pastikan semua bahan larut lalu diamkan larutan sampai busanya hilang sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan biang (hasil 3 liter)',
            'Aroma Tersedia' => 'Dunhill blue dan Baccarat',
            'Bentuk Fisik' => 'pasta (biang)',
            'Kemasan' => 'box karton segel',
            'Bahan Aktif' => 'Active surfactant agents, Foam Stabilizer, Fragrance'
        )
    ),

    // 12. Pembersih Mesin Kopi (Pro Kopi)
    array(
        'search' => 'Pro Kopi',
        'new_ingredients' => array('Solid Hydrogen Peroxide'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 450gr, 900gr',
            'Bentuk Fisik' => 'Serbuk',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'Solid Hydrogen Peroxide'
        )
    ),

    // 13. Malabeez – Parfum Laundry Oriental Premium
    array(
        'search' => 'Malabeez',
        'new_desc' => 'Malabeez – Parfum Laundry Oriental Premium adalah produk parfum berkualitas premium dari Indotech yang harumnya tahan lama untuk pakaian, karpet, peci maupun sajadah.',
        'new_features' => array(
            'Keharuman Tahan Lama: Wangi menempel erat di pakaian, karpet, peci maupun sajadah hingga berhari-hari'
        ),
        'new_ingredients' => array('fragrance', 'aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 6 ml, 250 ml, 800 ml, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'fragrance, aqua'
        )
    ),

    // 14. Handwash
    array(
        'search' => 'Handwash',
        'new_desc' => 'Hand wash adalah produk Sabun Cuci Tangan Cair dari Indotech yang higienitas dan perawatan kulitnya berkualitas premium serta dirancang secara khusus untuk menjaga kebersihan tangan Anda secara maksimal setelah melakukan berbagai aktivitas harian. Sabun cuci tangan ini efektif membersihkan kotoran, debu, dan sisa minyak yang menempel pada kulit tangan dengan lembut tanpa menimbulkan efek kering atau iritasi. Diperkaya dengan kandungan bahan pelembab dan aroma yang segar, produk ini memastikan tangan Anda tetap bersih, higienis, lembut, dan harum sepanjang hari.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster'
        )
    ),

    // 15. Sleek – Cairan Setrika & Perawat Kain Waterbase
    array(
        'search' => 'Sleek',
        'new_desc' => 'Sleek adalah cairan pelicin setrika waterbase premium yang merawat serat kain agar tetap licin, tidak mudah kusut, dan terlihat rapi profesional. Diformulasikan khusus untuk kebutuhan laundry komersial, binatu, dan hotel.',
        'new_features' => array('Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'new_ingredients' => array('Fragrance', 'micro parfum', 'aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok untuk' => 'Kemeja, Jas, Linen Hotel',
            'Bahan Aktif' => 'Fragrance, micro parfum'
        )
    ),

    // 16. Shampoo Mobil – Car Wash Shampoo
    array(
        'search' => 'Shampoo Mobil',
        'new_features' => array('Aman untuk kendaraan : Tidak korosif dan menjaga integritas bodi kendaraan.'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'pH Formula' => 'Netral (pH 6.5–7.5)',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Fragrance, micro parfum'
        )
    ),

    // 17. Sabun Cuci Piring – Dish Soap Anti Lemak
    array(
        'search' => 'Sabun Cuci Piring',
        'remove_features' => array(2),
        'new_ingredients' => array('Active surfactant agents', 'Foam booster', 'Fragrance segar jeruk/lemon'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster'
        )
    ),

    // 18. Pembersih Kerak – Anti Scale & Descaler
    array(
        'search' => 'Pembersih Kerak',
        'new_features' => array('Ampuh mengatasi semua kerak : Semua kerak yang ada di peralatan maupun keramik dapat hilang seketika'),
        'new_ingredients' => array('Hydrofluoric acid', 'Oxalic acid'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 500 ml, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok untuk' => 'Keran, Shower, Toilet, Bak Mandi',
            'Bahan Aktif' => 'Hydrofluoric acid, Oxalic acid'
        )
    ),

    // 19. Prime+ – Parfum Laundry Premium Eksklusif
    array(
        'search' => 'Prime+',
        'new_desc' => 'Prime+ adalah parfum laundry premium eksklusif dalam kemasan 1 dan 5 liter yang menghadirkan aroma mewah dan elegan untuk setiap cucian. Formula konsentrat tinggi memberikan keharuman kuat dan tahan lama yang terasa pada pakaian seharian.',
        'new_features' => array('Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'new_directions' => array(
            'Semprotkan ke kain lalu setrika seperti biasa.',
            'Untuk kain tebal: semprotkan lebih banyak dan biarkan meresap 1–2 menit sebelum disetrika.',
            'Simpan di lemari untuk ketahanan aroma pada pakaian apabila belum dipakai'
        ),
        'specs' => array('Ukuran Tersedia' => 'Default, 1 liter, 5 liter')
    ),

    // 20. Pelmos – Cairan Pel Lantai Wangi
    array(
        'search' => 'Pelmos',
        'new_features' => array('Aman untuk semua jenis lantai: Memberikan kebersihan pada semua jenis lantai dan tidak ada bekasnya'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok untuk' => 'Keramik, Marmer, Granit, Vinyl',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance segar anti-bau, Disinfektan ringan'
        )
    ),

    // 21. Pelicin Setrika Eco – Cairan Setrika Hemat
    array(
        'search' => 'Pelicin Setrika Eco',
        'new_features' => array('Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'new_ingredients' => array('Fragrance', 'Anti Fungi Agent'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance, Anti Fungi Agent'
        )
    ),

    // 22. Parfum SUP – Pewangi Laundry Super Series
    array(
        'search' => 'Parfum SUP',
        'new_features' => array('Aman untuk kain: Menjaga integritas serat kain dan tidak membuat kain rusak'),
        'new_ingredients' => array('Fragrance solubilizer', 'fixative stabilizer', 'aqua'),
        'new_directions' => array(
            'Semprotkan ke kain lalu setrika seperti biasa.',
            'Untuk kain tebal: semprotkan lebih banyak dan biarkan meresap 1–2 menit sebelum disetrika.',
            'Simpan di lemari untuk ketahanan aroma pada pakaian apabila belum dipakai'
        ),
        'specs' => array(
            'Varian' => 'SUP A, SUP B',
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer'
        )
    ),

    // 23. Parfum Karpet – Pewangi Khusus Karpet & Tekstil
    array(
        'search' => 'Parfum Karpet',
        'new_features' => array('Aman untuk berbagai permukaan bahan tekstil dalam ruangan: Memberikan atmosfer ruangan yang bersih, wangi, dan menyegarkan. Selain itu, parfum karpet ini juga efektif melenyapkan bau tidak sedap akibat hewan peliharaan, asap rokok, makanan, hingga bau lembab karena kondisi ruangan yang tertutup.'),
        'new_ingredients' => array('Fragrance solubilizer', 'fixative stabilizer', 'aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pewangi Karpet & Tekstil',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer'
        )
    ),

    // 24. Parfum Helm – Pewangi Khusus Helm
    array(
        'search' => 'Parfum Helm',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pewangi & Antibakteri Helm',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer'
        )
    ),

    // 25. Oxy Bleach – Pemutih Kain Berbasis Oksigen
    array(
        'search' => 'Oxy Bleach',
        'new_ingredients' => array('Solid Hydrogen Peroxide'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Keunggulan' => 'Aman Warna dan Ramah Lingkungan',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer'
        )
    ),

    // 26. Nauki Deterjen Khusus Batik Buah Lerak Premium
    array(
        'search' => 'Nauki',
        'new_features' => array('Deterjen Alami Ekstrak Lerak: Membersihkan kotoran dan noda serat pakaian batik secara alami tanpa residu kimia buatan.'),
        'new_directions' => array(
            'Tuangkan 30-60 ml untuk 1 kg batik',
            'Rendam selama 10 menit',
            'Cuci secara manual menggunakan tangan',
            'Hindari menjemur langsung dibawah matahari untuk menjaga warna batik'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Lerak, Distilled water'
        )
    ),

    // 27. Karbol – Pembersih Lantai & Disinfektan Pinus dan Sereh
    array(
        'search' => 'Karbol',
        'new_desc' => 'Karbol adalah cairan pembersih lantai dan disinfektan berbasis Pine Oil dengan aroma cemara pinus dan sereh yang menyegarkan. Membunuh kuman dan bakteri, menghilangkan bau tidak sedap, serta membersihkan lantai dari kotoran dan debu.',
        'new_features' => array('Aman untuk semua jenis lantai: Memberikan kebersihan pada semua jenis lantai dan tidak ada bekasnya'),
        'new_ingredients' => array('Pine Oil murni', 'Citrunella', 'Surfaktan emulsifier', 'Disinfektan aktif pembunuh kuman'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Aroma' => 'Pinus Cemara dan sereh',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Fungsi' => 'Disinfektan & Pembersih Lantai'
        )
    ),

    // 28. Seri Hemat – Produk Kebersihan Ekonomis
    array(
        'search' => 'Seri Hemat',
        'remove_features' => array(2)
    )
);

// ── Proses Update ────────────────────────────────────────────────────────
$success_count = 0;

foreach ($product_rules as $rule) {
    // Cari produk di DB saat ini
    $found = get_posts(array(
        'post_type'   => 'product',
        's'           => $rule['search'],
        'post_status' => 'any',
        'numberposts' => 1
    ));

    if (empty($found)) {
        echo "[SKIP] Produk tidak ditemukan untuk query: {$rule['search']}\n";
        continue;
    }

    $post = $found[0];
    $post_id = $post->ID;

    // Cari konten awal dari backup jika ada, atau gunakan post_content saat ini
    $orig_content = $post->post_content;
    if (isset($backup_products[$post_id])) {
        $orig_content = $backup_products[$post_id]['post_content'];
    } elseif (isset($backup_products['slug_' . $post->post_name])) {
        $orig_content = $backup_products['slug_' . $post->post_name]['post_content'];
    } elseif (isset($backup_products['title_' . strtolower(trim($post->post_title))])) {
        $orig_content = $backup_products['title_' . strtolower(trim($post->post_title))]['post_content'];
    }

    // Ambil param update
    $new_title = isset($rule['new_title']) ? $rule['new_title'] : null;
    $new_desc = isset($rule['new_desc']) ? $rule['new_desc'] : null;

    if (isset($rule['transform_desc']) && is_callable($rule['transform_desc'])) {
        $current_desc = '';
        if (preg_match('/<h3>Deskripsi Produk<\/h3>\s*<p>(.*?)<\/p>/is', $orig_content, $m)) {
            $current_desc = trim(strip_tags($m[1]));
        } else {
            $clean = preg_replace('/<h3>.*?<\/h3>/i', '', $orig_content);
            $current_desc = trim(strip_tags($clean));
        }
        $new_desc = $rule['transform_desc']($current_desc);
    }

    $new_features = isset($rule['new_features']) ? $rule['new_features'] : null;
    $remove_features = isset($rule['remove_features']) ? $rule['remove_features'] : null;
    $new_ingredients = isset($rule['new_ingredients']) ? $rule['new_ingredients'] : null;
    $remove_ingredients = isset($rule['remove_ingredients']) ? $rule['remove_ingredients'] : null;
    $new_directions = isset($rule['new_directions']) ? $rule['new_directions'] : null;
    $remove_direction_index = isset($rule['remove_direction_index']) ? $rule['remove_direction_index'] : null;
    $directions_title = isset($rule['directions_title']) ? $rule['directions_title'] : 'Cara Penggunaan';

    // Rakit ulang HTML terstruktur yang lengkap
    $final_html = build_structured_content(
        $orig_content,
        $new_desc,
        $new_features,
        $remove_features,
        $new_ingredients,
        $remove_ingredients,
        $new_directions,
        $remove_direction_index,
        $directions_title
    );

    // Update Post
    $update_arr = array(
        'ID'           => $post_id,
        'post_content' => $final_html,
    );

    if (!empty($new_title)) {
        $update_arr['post_title'] = $new_title;
    }

    wp_update_post($update_arr);

    // Update Meta Carbon Fields Spesifikasi Teknis
    if (!empty($rule['specs']) && is_array($rule['specs'])) {
        $existing_specs = get_post_meta($post_id, '_product_specifications', true);
        if (!is_array($existing_specs)) {
            $existing_specs = array();
        }

        $spec_map = array();
        foreach ($existing_specs as $item) {
            if (isset($item['spec_name']) && isset($item['spec_value'])) {
                $spec_map[$item['spec_name']] = $item['spec_value'];
            }
        }

        foreach ($rule['specs'] as $sk => $sv) {
            $spec_map[$sk] = $sv;
        }

        $new_specs = array();
        foreach ($spec_map as $sk => $sv) {
            $new_specs[] = array(
                '_type'      => 'product_specifications',
                'spec_name'  => $sk,
                'spec_value' => $sv,
            );
        }

        update_post_meta($post_id, '_product_specifications', $new_specs);
    }

    $success_count++;
    echo "[$success_count] BERHASIL RESTORASI & UPDATE: {$post->post_title} (ID: $post_id)\n";
}

echo "\n=== SELESAI: Total $success_count produk berhasil direstorasi & diperbarui berdasarkan REFERENCES.MD! ===\n";
