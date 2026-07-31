<?php
/**
 * Script Update Penyesuaian Produk Indotech Phase 1 (28 Produk: No. 1 - 28)
 * Berdasarkan REFERENCES.MD
 * (Tanpa mengubah/menyentuh media/gambar produk)
 * 
 * Jalankan via CLI pada VPS (/home/indotech.id/public_html) atau Lokal:
 * php update_phase1_products.php
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

echo "=== Memulai Penyesuaian 28 Produk Phase 1 Berdasarkan REFERENCES.MD ===\n\n";

/**
 * Helper untuk memformat item list <li> dengan label tebal (bold) jika mengandung titik dua (:)
 */
function phase1_format_li_item($text) {
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
function phase1_extract_items_from_block($text_block) {
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
function phase1_parse_content($content) {
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
            $result['features'] = phase1_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Komposisi(?:\s+Bahan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['ingredients'] = phase1_extract_items_from_block($m[2]);
        } elseif (preg_match('/^===\s*(Cara\s+(Penggunaan|Pengolahan))\s*===\n*(.*)$/is', $block, $m)) {
            if (stristr($m[1], 'Pengolahan')) {
                $result['directions_title'] = 'Cara Pengolahan';
            }
            $result['directions'] = phase1_extract_items_from_block($m[3]);
        } elseif (preg_match('/^===\s*(Petunjuk\s+Keamanan(?:\s*(?:&amp;|&|\b)\s*Penyimpanan)?)\s*===\n*(.*)$/is', $block, $m)) {
            $result['safety'] = phase1_extract_items_from_block($m[2]);
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
function phase1_render_html($desc, $features, $ingredients, $directions, $safety, $directions_title = 'Cara Penggunaan') {
    $clean_desc = trim(preg_replace('/^(?:Deskripsi\s+Produk\s*|Deskripsi\s*)+/i', '', trim($desc)));

    $html = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($clean_desc) . "</p>\n\n";

    if (!empty($features)) {
        $html .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
        foreach ($features as $f) {
            $html .= "  <li>" . phase1_format_li_item($f) . "</li>\n";
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
            'Gunakan sarung tangan karet saat menangani produk konsentrat untuk mencegah iritasi kulit.',
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

// ── Aturan Perubahan 28 Produk Berdasarkan REFERENCES.MD ─────────────────
$product_rules = array(
    // 1. Softsense
    array(
        'search' => 'Softsense',
        'new_desc' => 'Softsense adalah paket bahan softener pelembut pakaian konsentrat premium berukuran lebih besar. Dirancang khusus untuk efisiensi tinggi bagi pengusaha laundry maupun kebutuhan rumah tangga besar, satu kemasan Softsense dapat menghasilkan hingga 15 liter pelembut pakaian siap pakai berkualitas tinggi dengan keharuman microcapsule yang mewah.',
        'new_features' => array(
            'Formula Konsentrat Premium: Menghasilkan hingga 15 liter pelembut pakaian dari satu kemasan.',
            'Teknologi Microcapsule: Mengunci wangi mewah di serat pakaian.',
            'Hemat & Efisien: Cocok untuk usaha laundry maupun rumah tangga besar.'
        ),
        'new_ingredients' => array('Softener active paste', 'Microcapsule fragrance', 'Aqua', 'Stabilizer'),
        'new_directions' => array(
            'Siapkan wadah besar ukuran 15-20 Liter dan air bersih 14 Liter.',
            'Larutkan bahan Softsense secara bertahap sambil diaduk hingga larut sempurna.',
            'Diamkan larutan selama 12-24 jam hingga busa mereda sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 15 liter)',
            'Bentuk Fisik' => 'Paket bahan softener',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 2. Softa
    array(
        'search' => 'Softa',
        'transform_desc' => function($desc) {
            return str_replace(array('paket bahan', 'bahan '), array('paket', ''), $desc);
        },
        'new_features' => array(
            'Sangat Hemat (Hasil 5 Liter): Menghasilkan 5 liter pelembut pakaian siap pakai dari satu box pasta.',
            'Keharuman Micro-capsule: Mengunci aroma wewangian di serat pakaian yang akan aktif mengeluarkan keharuman saat terjadi gesekan.',
            'Pelembut Serat Pakaian: Membuat pakaian lebih halus, mudah disetrika, dan mencegah efek kaku pada kain.',
            'Aman di Kulit: Ramah lingkungan dan tidak menimbulkan iritasi kulit (teruji aman).'
        ),
        'new_ingredients' => array(
            'Softener active agent (pasta)',
            'Fragrance compound',
            'Microcapsule fragrance',
            'Pewarna'
        ),
        'new_directions' => array(
            'Siapkan wadah bersih ukuran minimal 5-6 Liter dan air bersih sebanyak 4.5 Liter.',
            'Masukkan pasta Softa ke dalam wadah, tuangkan air bersih secara bertahap sambil diaduk secara konstan hingga pasta larut sepenuhnya.',
            'Diamkan selama 12 jam hingga formula stabil dan busa menghilang sepenuhnya sebelum dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 5 liter)',
            'Aroma Tersedia' => 'Sakura, Molto Blue, Downy Passion, Downy Mystique',
            'Bentuk Fisik' => 'Pasta (Biang)',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 3. Octa
    array(
        'search' => 'Octa',
        'new_title' => 'Octa - Paket Bahan Sabun Cuci Piring Pasta',
        'transform_desc' => function($desc) {
            return str_replace('paket bahan', 'paket biang', $desc);
        },
        'new_features' => array(
            'Formula Biang Pasta: Hemat dan sangat mudah diolah menjadi 5 liter sabun cuci piring.',
            'Pengangkat Lemak Membandel: Efektif membersihkan noda minyak pada peralatan dapur.',
            'Busa Melimpah: Busa tebal dan lembut di tangan.'
        ),
        'remove_ingredients' => array('texapon', 'sles'),
        'remove_direction_index' => 3,
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Pasta (Biang)',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 4. Oclean
    array(
        'search' => 'Oclean',
        'new_title' => 'Oclean - Paket Bahan Sabun Cuci Piring 15 liter',
        'new_desc' => 'Oclean adalah paket bahan sabun cuci piring dengan formula khusus pembersih lemak (anti-grease) yang sangat efektif mengangkat kotoran, minyak, dan lemak membandel pada peralatan makan dan masak. Dirancang khusus untuk efisiensi tinggi bagi kebutuhan rumah tangga, pengusaha warung makan maupun restoran besar, satu kemasan oclean dapat menghasilkan hingga 15 liter sabun cuci piring. Aroma jeruk nipis yang segar membantu menghilangkan bau amis secara instan.',
        'new_ingredients' => array('Active surfactant paste', 'Foam booster', 'Fragrance Lime', 'Pewarna'),
        'new_directions' => array(
            'Siapkan wadah besar ukuran minimal 15-20 Liter dan siapkan air bersih sebanyak 9-14 Liter dan garam 1 kg.',
            'Larutkan bahan-bahan Oclean sesuai dengan petunjuk yang sudah diberikan.',
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
            'Siapkan wadah besar ukuran minimal 10 Liter dan siapkan air bersih sebanyak 9-14 Liter.',
            'Larutkan bahan-bahan Essenz sesuai dengan petunjuk yang sudah diberikan.',
            'Pastikan semua bahan larut lalu diamkan larutan selama 12 jam sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 8 liter dan 15 liter)',
            'Bentuk Fisik' => 'Paket bahan essenz',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 6. Bibit Parfum
    array(
        'search' => 'bibit-parfum',
        'remove_features' => array('Aman untuk peralatan'),
        'remove_ingredients' => array('Active surfactant agents', 'Aqua & stabilizer'),
        'new_directions' => array(
            'Larutkan bibit dengan produk yang ingin ditambahkan bibit wewangian sesuai takaran kebutuhan.',
            'Aduk sampai larut sempurna.',
            'Aplikasikan produk yang sudah ditambahkan bibit wewangian sesuai dengan kegunaan.'
        ),
        'specs' => array(
            'Bahan Aktif' => 'Fragrance compound'
        )
    ),

    // 7. Konsentrat Parfum Alkohol Base
    array(
        'search' => 'konsentrat-parfum',
        'new_directions' => array(
            'Siapkan wadah besar ukuran minimal 11 Liter dan siapkan metanol sebanyak 8 Liter.',
            'Larutkan bahan-bahan konsentrat parfum alkohol base sesuai dengan petunjuk yang sudah diberikan.',
            'Pastikan semua bahan larut lalu diamkan larutan selama 12 jam sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan konsentrat parfum alkohol base (hasil 10 liter)',
            'Aroma Tersedia' => 'Sakura, Floral, Lavender, Molto Blue, Ocean, Orchid, Orchid Passion, Phylux',
            'Bentuk Fisik' => 'Paket bahan konsentrat parfum alkohol base',
            'Kemasan' => 'Box Karton Segel'
        )
    ),

    // 8. Detta+
    array(
        'search' => 'detta',
        'new_directions' => array(
            'Larutkan Biang Deterjen Detta+ dengan air bersih secara bertahap (rasio anjuran 1:4 untuk hasil premium).'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil 5 liter)',
            'Aroma Tersedia' => 'Sakura, Molto Blue, Downy Passion, Downy Mystique',
            'Bentuk Fisik' => 'Pasta (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance'
        )
    ),

    // 9. Biang Pelicin Setrika
    array(
        'search' => 'biang-pelicin-setrika',
        'new_desc' => 'Biang Pelicin Setrika adalah paket biang pelicin setrika dengan formula hasil jadi 5 Liter untuk melembutkan serat kain dan mempermudah proses setrika pakaian. Memberikan aroma harum dan efek antikusut pada pakaian.',
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 5 liter dan air Amidis atau air yang rendah mineralnya 4,5 liter.',
            'Tuangkan biang pelicin setrika ke wadah.',
            'Masukkan air yang telah disiapkan.',
            'Aduk merata hingga warna tercampur sempurna.',
            'Pelicin setrika siap digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Cairan (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Fragrance 2.5%, Anti Fungi Agent 0.8%'
        )
    ),

    // 10. Biang Pel Lantai
    array(
        'search' => 'biang-pel-lantai',
        'new_desc' => 'Biang Pel Lantai adalah paket biang pel lantai konsentrat dengan formula hasil jadi 5 Liter. Efektif mengangkat kotoran, membunuh kuman, serta memberikan keharuman tahan lama pada lantai ruangan Anda.',
        'new_features' => array(
            'Konsentrat Super Hemat: Formula yang dapat diencerkan menjadi cairan pel lantai siap pakai berkualitas tinggi.',
            'Aroma Lemon Fresh Aromatik: Memberikan keharuman lemon segar yang tahan lama dan menghilangkan bau tidak sedap.'
        ),
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 5 liter dan air bersih atau air yang rendah mineralnya 4,5 liter.',
            'Tuangkan biang pel lantai ke wadah.',
            'Masukkan air yang telah disiapkan.',
            'Aduk merata hingga warna tercampur sempurna.',
            'Pel lantai siap digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil 5 liter)',
            'Bentuk Fisik' => 'Cairan (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Surfaktan 2,9%'
        )
    ),

    // 11. Athari
    array(
        'search' => 'athari',
        'new_features' => array(
            'Formula Konsentrat Tinggi: Cukup diencerkan dengan air bersih dan garam untuk menghasilkan sabun mandi cair siap pakai dalam volume besar.'
        ),
        'directions_title' => 'Cara Pengolahan',
        'new_directions' => array(
            'Siapkan wadah minimal 3-5 liter, garam, dan air Amidis atau air yang rendah mineralnya 4,5 liter.',
            'Tuangkan Athari ke wadah.',
            'Masukkan air yang telah disiapkan secara bertahap.',
            'Aduk merata hingga warna tercampur sempurna.',
            'Tambahkan garam secara bertahap dan aduk sampai larut sempurna.',
            'Pastikan semua bahan larut lalu diamkan larutan sampai busanya hilang sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan biang (hasil 3 liter)',
            'Aroma Tersedia' => 'Dunhill Blue dan Baccarat',
            'Bentuk Fisik' => 'Pasta (Biang)',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant agents, Foam Stabilizer, Fragrance'
        )
    ),

    // 12. Pembersih Mesin Kopi (Pro Kopi)
    array(
        'search' => 'pro-kopi',
        'new_ingredients' => array('Solid Hydrogen Peroxide'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 450gr, 900gr',
            'Bentuk Fisik' => 'Serbuk',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'Solid Hydrogen Peroxide'
        )
    ),

    // 13. Malabeez
    array(
        'search' => 'malabeez',
        'new_desc' => 'Malabeez – Parfum Laundry Oriental Premium adalah produk parfum berkualitas premium dari Indotech yang harumnya tahan lama untuk pakaian, karpet, peci maupun sajadah.',
        'new_features' => array(
            'Keharuman Tahan Lama: Wangi menempel erat di pakaian, karpet, peci maupun sajadah hingga berhari-hari.'
        ),
        'new_ingredients' => array('Fragrance', 'Aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 6 ml, 250 ml, 800 ml, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'Fragrance, Aqua'
        )
    ),

    // 14. Handwash
    array(
        'search' => 'hand-wash',
        'new_desc' => 'Hand wash adalah produk Sabun Cuci Tangan Cair dari Indotech yang higienitas dan perawatan kulitnya berkualitas premium serta dirancang secara khusus untuk menjaga kebersihan tangan Anda secara maksimal setelah melakukan berbagai aktivitas harian. Sabun cuci tangan ini efektif membersihkan kotoran, debu, dan sisa minyak yang menempel pada kulit tangan dengan lembut tanpa menimbulkan efek kering atau iritasi. Diperkaya dengan kandungan bahan pelembab dan aroma yang segar, produk ini memastikan tangan Anda tetap bersih, higienis, lembut, dan harum sepanjang hari.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster'
        )
    ),

    // 15. Sleek
    array(
        'search' => 'sleek',
        'new_desc' => 'Sleek adalah cairan pelicin setrika waterbase premium yang merawat serat kain agar tetap licin, tidak mudah kusut, dan terlihat rapi profesional. Diformulasikan khusus untuk kebutuhan laundry komersial, binatu, dan hotel.',
        'new_features' => array(
            'Aman untuk Kain: Menjaga integritas serat kain dan tidak membuat kain rusak.'
        ),
        'new_ingredients' => array('Fragrance', 'Micro Parfum', 'Aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok Untuk' => 'Kemeja, Jas, Linen Hotel',
            'Bahan Aktif' => 'Fragrance, Micro Parfum'
        )
    ),

    // 16. Shampoo Mobil
    array(
        'search' => 'shampoo-mobil',
        'new_features' => array(
            'Aman untuk Kendaraan: Tidak korosif dan menjaga integritas bodi kendaraan.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'pH Formula' => 'Netral (pH 6.5–7.5)',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Fragrance, Micro Parfum'
        )
    ),

    // 17. Sabun Cuci Piring
    array(
        'search' => 'sabun-cuci-piring-dish-soap',
        'remove_feature_index' => 2,
        'new_ingredients' => array('Active surfactant agents', 'Foam booster', 'Fragrance segar jeruk/lemon'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster'
        )
    ),

    // 18. Pembersih Kerak
    array(
        'search' => 'pembersih-kerak',
        'new_features' => array(
            'Ampuh Mengatasi Semua Kerak: Semua kerak yang ada di peralatan maupun keramik dapat hilang seketika.'
        ),
        'new_ingredients' => array('Hydrofluoric acid', 'Oxalic acid'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 500 ml, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok Untuk' => 'Keran, Shower, Toilet, Bak Mandi',
            'Bahan Aktif' => 'Hydrofluoric acid, Oxalic acid'
        )
    ),

    // 19. Prime+
    array(
        'search' => 'prime-parfum-laundry',
        'new_desc' => 'Prime+ adalah parfum laundry premium eksklusif dalam kemasan 1 dan 5 liter yang menghadirkan aroma mewah dan elegan untuk setiap cucian. Formula konsentrat tinggi memberikan keharuman kuat dan tahan lama yang terasa pada pakaian seharian.',
        'new_features' => array(
            'Aman untuk Kain: Menjaga integritas serat kain dan tidak membuat kain rusak.'
        ),
        'new_directions' => array(
            'Semprotkan ke kain lalu setrika seperti biasa.',
            'Untuk kain tebal: semprotkan lebih banyak dan biarkan meresap 1–2 menit sebelum disetrika.',
            'Simpan di lemari untuk ketahanan aroma pada pakaian apabila belum dipakai.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter'
        )
    ),

    // 20. Pelmos
    array(
        'search' => 'pelmos',
        'new_features' => array(
            'Aman untuk Semua Jenis Lantai: Memberikan kebersihan pada semua jenis lantai dan tidak meninggalkan bekas.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok Untuk' => 'Keramik, Marmer, Granit, Vinyl',
            'Bahan Aktif' => 'Active surfactant agents, Fragrance segar anti-bau, Disinfektan ringan'
        )
    ),

    // 21. Pelicin Setrika Eco
    array(
        'search' => 'pelicin-setrika-eco',
        'new_features' => array(
            'Aman untuk Kain: Menjaga integritas serat kain dan tidak membuat kain rusak.'
        ),
        'new_ingredients' => array('Fragrance', 'Anti Fungi Agent'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance, Anti Fungi Agent'
        )
    ),

    // 22. Parfum SUP
    array(
        'search' => 'parfum-sup',
        'new_features' => array(
            'Aman untuk Kain: Menjaga integritas serat kain dan tidak membuat kain rusak.'
        ),
        'new_ingredients' => array('Fragrance solubilizer', 'Fixative stabilizer', 'Aqua'),
        'new_directions' => array(
            'Semprotkan ke kain lalu setrika seperti biasa.',
            'Untuk kain tebal: semprotkan lebih banyak dan biarkan meresap 1–2 menit sebelum disetrika.',
            'Simpan di lemari untuk ketahanan aroma pada pakaian apabila belum dipakai.'
        ),
        'specs' => array(
            'Varian' => 'SUP A, SUP B',
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance solubilizer, Fixative stabilizer'
        )
    ),

    // 23. Parfum Karpet
    array(
        'search' => 'parfum-karpet',
        'new_features' => array(
            'Aman untuk Berbagai Permukaan Bahan Tekstil Dalam Ruangan: Memberikan atmosfer ruangan yang bersih, wangi, dan menyegarkan. Selain itu, parfum karpet ini juga efektif melenyapkan bau tidak sedap akibat hewan peliharaan, asap rokok, makanan, hingga bau lembab karena kondisi ruangan yang tertutup.'
        ),
        'new_ingredients' => array('Fragrance solubilizer', 'Fixative stabilizer', 'Aqua'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pewangi Karpet & Tekstil',
            'Bahan Aktif' => 'Fragrance solubilizer, Fixative stabilizer'
        )
    ),

    // 24. Parfum Helm
    array(
        'search' => 'parfum-helm',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pewangi & Antibakteri Helm',
            'Bahan Aktif' => 'Fragrance solubilizer, Fixative stabilizer'
        )
    ),

    // 25. Oxy Bleach
    array(
        'search' => 'oxy-bleach',
        'new_ingredients' => array('Solid Hydrogen Peroxide'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Keunggulan' => 'Aman Warna dan Ramah Lingkungan',
            'Bahan Aktif' => 'Fragrance solubilizer, Fixative stabilizer'
        )
    ),

    // 26. Nauki
    array(
        'search' => 'nauki',
        'new_features' => array(
            'Deterjen Alami Ekstrak Lerak: Membersihkan kotoran dan noda serat pakaian batik secara alami tanpa residu kimia buatan.'
        ),
        'new_directions' => array(
            'Tuangkan 30-60 ml untuk 1 kg batik.',
            'Rendam selama 10 menit.',
            'Cuci secara manual menggunakan tangan.',
            'Hindari menjemur langsung di bawah matahari untuk menjaga warna batik.'
        ),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Lerak, Distilled Water'
        )
    ),

    // 27. Karbol
    array(
        'search' => 'karbol-pembersih-lantai',
        'new_desc' => 'Karbol adalah cairan pembersih lantai dan disinfektan berbasis Pine Oil dengan aroma cemara pinus dan sereh yang menyegarkan. Membunuh kuman dan bakteri, menghilangkan bau tidak sedap, serta membersihkan lantai dari kotoran dan debu.',
        'new_features' => array(
            'Aman untuk Semua Jenis Lantai: Memberikan kebersihan pada semua jenis lantai dan tidak meninggalkan bekas.'
        ),
        'new_ingredients' => array('Pine Oil murni', 'Citronella', 'Surfaktan emulsifier', 'Disinfektan aktif pembunuh kuman'),
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Aroma' => 'Pinus Cemara dan Sereh',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Fungsi' => 'Disinfektan & Pembersih Lantai'
        )
    ),

    // 28. Seri Hemat
    array(
        'search' => 'seri-hemat',
        'remove_feature_index' => 2
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
        // Fallback: cari berdasarkan judul atau LIKE slug
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
    $parsed = phase1_parse_content($post->post_content);

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
    $remove_features = isset($rule['remove_features']) ? $rule['remove_features'] : null;
    $remove_feature_index = isset($rule['remove_feature_index']) ? $rule['remove_feature_index'] : null;

    if (!empty($remove_features) && !empty($features)) {
        $filtered_f = array();
        foreach ($features as $f_val) {
            $should_remove = false;
            foreach ($remove_features as $rf) {
                if (stripos($f_val, $rf) !== false) {
                    $should_remove = true;
                    break;
                }
            }
            if (!$should_remove) {
                $filtered_f[] = $f_val;
            }
        }
        $features = array_values($filtered_f);
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
    $remove_direction_index = isset($rule['remove_direction_index']) ? $rule['remove_direction_index'] : null;

    if (!empty($remove_direction_index) && !empty($directions)) {
        $filtered_dir = array();
        foreach ($directions as $d_idx => $d_val) {
            if (($d_idx + 1) != $remove_direction_index) {
                $filtered_dir[] = $d_val;
            }
        }
        $directions = array_values($filtered_dir);
    }

    $directions_title = isset($rule['directions_title']) ? $rule['directions_title'] : $parsed['directions_title'];
    $safety = !empty($parsed['safety']) ? $parsed['safety'] : array();

    // Rakit ulang HTML terstruktur
    $final_html = phase1_render_html(
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
    echo "[$success_count/28] BERHASIL UPDATE: {$post->post_title} (ID: $post_id)\n";
}

echo "\n=== SELESAI: 28 PRODUK PHASE 1 BERHASIL DIPERBARUI TAMPA MENGUBAH MEDIA/GAMBAR! ===\n";
