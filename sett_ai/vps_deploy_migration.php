<?php
/**
 * PT Indotech Berkah Abadi
 * B2B Products Migration & Restructuring Deployment Script for VPS
 * 
 * Instructions:
 * 1. Push changes to GitHub and pull on VPS.
 * 2. Run: php sett_ai/vps_deploy_migration.php
 */

define('WP_USE_THEMES', false);
require_once __DIR__ . '/../wp-load.php';

if (php_sapi_name() !== 'cli') {
    die("Error: This script must be executed via CLI (SSH terminal) for safety.\n");
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

echo "=== PT Indotech Berkah Abadi - Starting VPS Deployment & Migration (Fixed Image Import) ===\n";

$target_user = 'indot3349';
$target_group = 'indot3349';

function add_product_image_vps($file_path, $post_id, $user, $group) {
    if (!file_exists($file_path)) {
        echo "    [Image Warning] File not found: $file_path\n";
        return false;
    }
    
    $wp_upload_dir = wp_upload_dir();
    $filename = basename($file_path);
    
    if (!empty($wp_upload_dir['error'])) {
        echo "    [Image Error] Upload directory error: " . $wp_upload_dir['error'] . "\n";
        return false;
    }
    
    $new_file_path = $wp_upload_dir['path'] . '/' . $filename;
    
    // Copy file
    if (copy($file_path, $new_file_path)) {
        // Fix permissions and ownership immediately
        @chown($new_file_path, $user);
        @chgrp($new_file_path, $group);
        @chmod($new_file_path, 0644);
        
        $file_type = wp_check_filetype($filename, null);
        
        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        
        $attach_id = wp_insert_attachment($attachment, $new_file_path, $post_id);
        
        if (!is_wp_error($attach_id)) {
            $attach_data = wp_generate_attachment_metadata($attach_id, $new_file_path);
            wp_update_attachment_metadata($attach_id, $attach_data);
            
            // Fix permissions for generated thumbnails/sizes
            if (!empty($attach_data['sizes'])) {
                foreach ($attach_data['sizes'] as $size_info) {
                    $thumb_path = $wp_upload_dir['path'] . '/' . $size_info['file'];
                    if (file_exists($thumb_path)) {
                        @chown($thumb_path, $user);
                        @chgrp($thumb_path, $group);
                        @chmod($thumb_path, 0644);
                    }
                }
            }
            
            set_post_thumbnail($post_id, $attach_id);
            echo "    [Image Success] Image attached as ID: $attach_id (Permissions corrected)\n";
            return $attach_id;
        } else {
            echo "    [Image Error] Failed to insert attachment: " . $attach_id->get_error_message() . "\n";
            return false;
        }
    } else {
        echo "    [Image Error] Failed to copy $filename to uploads directory\n";
        return false;
    }
}

// ── 1. Create/Verify Categories ───────────────────────────────────────────
echo "\n[1/6] Verifying product categories...\n";
$categories = array(
    'Peralatan & Pembersih Mesin Kopi' => 'Peralatan & Pembersih Kopi',
    'Biang Pembersih Konsentrat' => 'Biang Pembersih Konsentrat',
    'Bahan Kimia Laundry & Sabun' => 'Bahan Kimia Laundry & Sabun',
    'Bibit Parfum & Wewangian' => 'Bibit Parfum & Wewangian'
);

$cat_map = array();
foreach ($categories as $orig => $clean_name) {
    $term = get_term_by('name', $clean_name, 'product_cat');
    if (!$term) {
        $new_term = wp_insert_term($clean_name, 'product_cat');
        if (!is_wp_error($new_term)) {
            $cat_map[$orig] = $new_term['term_id'];
            echo "  Created category: '$clean_name'\n";
        } else {
            echo "  Error creating category '$clean_name': " . $new_term->get_error_message() . "\n";
        }
    } else {
        $cat_map[$orig] = $term->term_id;
        echo "  Category exists: '$clean_name'\n";
    }
}

// ── 2. Load Products and Sideload Images ──────────────────────────────────
echo "\n[2/6] Importing products and restoring featured images...\n";
$json_path = __DIR__ . '/products.json';
$src_dir = __DIR__ . '/src';

if (!file_exists($json_path)) {
    die("Error: products.json not found in " . $json_path . "\n");
}

$products = json_decode(file_get_contents($json_path), true);
if (empty($products)) {
    die("Error: products.json is empty or invalid.\n");
}

$imported_ids = array();

foreach ($products as $p) {
    $title = html_entity_decode($p['title']);
    
    // Check if product already exists by title
    $existing = get_page_by_title($title, OBJECT, 'product');
    if ($existing) {
        echo "  Exists: '$title' (ID: {$existing->ID}). Checking image...\n";
        $post_id = $existing->ID;
    } else {
        echo "  Creating: '$title'...\n";
        $post_id = wp_insert_post(array(
            'post_title'   => $title,
            'post_status'  => 'publish',
            'post_type'    => 'product',
            'post_content' => $p['content'],
            'post_excerpt' => $p['excerpt']
        ));
        
        if (is_wp_error($post_id)) {
            echo "    Error inserting product: " . $post_id->get_error_message() . "\n";
            continue;
        }
        
        // Set SKU & specifications
        carbon_set_post_meta($post_id, 'product_sku', $p['sku']);
        carbon_set_post_meta($post_id, 'product_specifications', $p['specifications']);
        
        // Set categories
        $term_ids = array();
        foreach ($p['categories'] as $cat_name) {
            if (isset($cat_map[$cat_name])) {
                $term_ids[] = $cat_map[$cat_name];
            }
        }
        if (!empty($term_ids)) {
            wp_set_post_terms($post_id, $term_ids, 'product_cat');
        }
    }
    
    // Upload/Re-verify image if missing
    if (!has_post_thumbnail($post_id)) {
        $img_file = $src_dir . '/' . $p['image_filename'];
        add_product_image_vps($img_file, $post_id, $target_user, $target_group);
    } else {
        echo "    Image already set.\n";
    }
    
    $imported_ids[] = $post_id;
}

// ── 3. Group and Merge Variations ──────────────────────────────────────────
echo "\n[3/6] Merging variations and setting up image galleries...\n";
$q = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any',
    'orderby' => 'ID',
    'order' => 'ASC'
));

$groups = array();
$size_patterns = array(
    '/-\s*\d+(\.\d+)?\s*(liter|ml|kg|l|gr|kg|oz)\b/i',
    '/\b\d+(\.\d+)?\s*(liter|ml|kg|l|gr|kg|oz)\b/i',
);

while ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    
    $base_name = $title;
    foreach ($size_patterns as $pattern) {
        $base_name = preg_replace($pattern, '', $base_name);
    }
    $base_name = html_entity_decode(trim(preg_replace('/\s*-\s*$/', '', trim($base_name))));
    
    if (!isset($groups[$base_name])) {
        $groups[$base_name] = array();
    }
    $groups[$base_name][] = array(
        'id' => $id,
        'title' => $title,
        'slug' => get_post_field('post_name', $id),
        'thumbnail' => get_post_thumbnail_id($id),
        'sku' => carbon_get_post_meta($id, 'product_sku')
    );
}
wp_reset_postdata();

foreach ($groups as $base_title => $items) {
    $parent_id = $items[0]['id'];
    
    if (count($items) > 1) {
        echo "  Merging variations for: '$base_title'\n";
        wp_update_post(array(
            'ID' => $parent_id,
            'post_title' => $base_title,
            'post_name' => sanitize_title($base_title)
        ));
        
        $sizes = array();
        $skus = array();
        $gallery_ids = array();
        
        foreach ($items as $item) {
            if (preg_match('/(\d+(\.\d+)?\s*(liter|ml|kg|l|gr|kg))/i', $item['title'], $m)) {
                $sizes[] = $m[1];
            } else {
                $sizes[] = "Default";
            }
            if ($item['sku']) {
                $skus[] = $item['sku'];
            }
            if ($item['thumbnail']) {
                $gallery_ids[] = intval($item['thumbnail']);
            }
        }
        
        $sizes = array_unique($sizes);
        $skus = array_unique($skus);
        $gallery_ids = array_unique($gallery_ids);
        
        if (!empty($skus)) {
            carbon_set_post_meta($parent_id, 'product_sku', implode(' / ', $skus));
        }
        
        $sizes_string = implode(', ', $sizes);
        $specs = carbon_get_post_meta($parent_id, 'product_specifications');
        if (!is_array($specs)) {
            $specs = array();
        }
        $found_spec = false;
        for ($i = 0; $i < count($specs); $i++) {
            if (strtolower(trim($specs[$i]['spec_name'])) === 'ukuran tersedia' || strtolower(trim($specs[$i]['spec_name'])) === 'berat bersih' || strtolower(trim($specs[$i]['spec_name'])) === 'volume') {
                $specs[$i]['spec_name'] = 'Ukuran Tersedia';
                $specs[$i]['spec_value'] = $sizes_string;
                $found_spec = true;
                break;
            }
        }
        if (!$found_spec) {
            $specs[] = array(
                'spec_name' => 'Ukuran Tersedia',
                'spec_value' => $sizes_string
            );
        }
        carbon_set_post_meta($parent_id, 'product_specifications', $specs);
        
        if (!empty($gallery_ids)) {
            set_post_thumbnail($parent_id, $gallery_ids[0]);
            carbon_set_post_meta($parent_id, 'product_gallery', $gallery_ids);
        }
        
        for ($i = 1; $i < count($items); $i++) {
            $child_id = $items[$i]['id'];
            wp_delete_post($child_id, true);
            echo "    Deleted child duplicate post ID: $child_id\n";
        }
    } else {
        // Clean single title
        $original_title = $items[0]['title'];
        if ($original_title !== $base_title) {
            wp_update_post(array(
                'ID' => $parent_id,
                'post_title' => $base_title,
                'post_name' => sanitize_title($base_title)
            ));
            
            if (preg_match('/(\d+(\.\d+)?\s*(liter|ml|kg|l|gr|kg))/i', $original_title, $m)) {
                $size = $m[1];
                $specs = carbon_get_post_meta($parent_id, 'product_specifications');
                if (!is_array($specs)) {
                    $specs = array();
                }
                $found_spec = false;
                for ($i = 0; $i < count($specs); $i++) {
                    if (strtolower(trim($specs[$i]['spec_name'])) === 'ukuran tersedia' || strtolower(trim($specs[$i]['spec_name'])) === 'berat bersih' || strtolower(trim($specs[$i]['spec_name'])) === 'volume') {
                        $specs[$i]['spec_name'] = 'Ukuran Tersedia';
                        $specs[$i]['spec_value'] = $size;
                        $found_spec = true;
                        break;
                    }
                }
                if (!$found_spec) {
                    $specs[] = array(
                        'spec_name' => 'Ukuran Tersedia',
                        'spec_value' => $size
                    );
                }
                carbon_set_post_meta($parent_id, 'product_specifications', $specs);
            }
            echo "  Cleaned title: '$original_title' -> '$base_title'\n";
        }
    }
}

// ── 4. Consolidate Bibit Parfum ────────────────────────────────────────────
echo "\n[4/6] Consolidating all Bibit Parfum aromas into a single product...\n";
$q = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any',
    's' => 'Bibit Parfum'
));

$bibit_posts = array();
while ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    if (strpos($title, 'Bibit Parfum') === 0 || $title === 'Bibit Parfum & Wewangian') {
        $bibit_posts[] = array(
            'id' => $id,
            'title' => $title,
            'thumbnail' => get_post_thumbnail_id($id)
        );
    }
}
wp_reset_postdata();

if (!empty($bibit_posts)) {
    usort($bibit_posts, function($a, $b) {
        return $a['id'] - $b['id'];
    });
    
    $parent_id = $bibit_posts[0]['id'];
    $gallery_ids = array();
    $aromas = array();
    
    foreach ($bibit_posts as $post) {
        if ($post['thumbnail']) {
            $gallery_ids[] = intval($post['thumbnail']);
        }
        $aroma = trim(preg_replace('/^Bibit Parfum\s*(\-|–)\s*/i', '', $post['title']));
        if ($aroma && $aroma !== 'Bibit Parfum & Wewangian') {
            $aromas[] = $aroma;
        }
    }
    
    // Add default aromas list if empty
    if (empty($aromas)) {
        $aromas = array('Baccarat', 'Downy Mystique', 'Downy Passion', 'Dunhill Blue', 'Floral', 'Jeruk Nipis', 'Lavender', 'Lemon Fresh', 'Molto Blue', 'Ocean Fresh', 'Phylux', 'Sakura', 'Snappy', 'Strawberry');
    }
    
    $gallery_ids = array_unique(array_filter($gallery_ids));
    $aromas = array_unique($aromas);
    sort($aromas);
    
    $unified_title = "Bibit Parfum & Wewangian";
    $unified_slug = "bibit-parfum";
    
    $description = "<p><strong>Bibit Parfum &amp; Wewangian Premium</strong> merupakan konsentrat parfum murni berkualitas tinggi yang dirancang khusus untuk industri laundry, perawatan rumah tangga (homecare), kosmetik, maupun penggunaan pribadi. Formula konsentrat murni ini menghasilkan keharuman yang kuat, elegan, dan tahan lama.</p>\n";
    $description .= "<h3>Varian Aroma Tersedia &amp; Karakteristik:</h3>\n<ul>\n";
    
    $scent_details = array(
        'Baccarat' => 'Aroma mewah perpaduan jasmine, saffron, cedarwood, dan ambergris yang elegan khas parfum eropa.',
        'Downy Mystique' => 'Aroma segar, manis, eksotis dan misterius yang sangat tahan lama.',
        'Downy Passion' => 'Aroma floral-fruity yang manis-segar, romantis, dan penuh kehangatan.',
        'Dunhill Blue' => 'Aroma maskulin maskulin klasik yang segar, berenergi, sejuk dan elegan.',
        'Floral' => 'Keharuman alami kelopak bunga segar musim semi yang lembut dan feminin.',
        'Jeruk Nipis' => 'Keharuman citrus jeruk nipis yang asam-segar, bersih, higienis dan membangkitkan semangat.',
        'Lavender' => 'Aroma aromaterapi bunga lavender yang menenangkan, rileks, dan meredakan stres.',
        'Lemon Fresh' => 'Aroma buah lemon segar alami yang ceria, energik, dan bersih.',
        'Molto Blue' => 'Aroma powdery segar khas pelembut pakaian klasik yang lembut, bersih, dan disukai keluarga.',
        'Ocean Fresh' => 'Kesegaran hembusan angin laut yang bersih, sejuk, maskulin, dan sangat menyegarkan.',
        'Phylux' => 'Aroma mewah khas laundry premium yang manis, bersih, segar, dan berkelas.',
        'Sakura' => 'Aroma bunga sakura Jepang yang manis, lembut, harum feminin yang elegan.',
        'Snappy' => 'Aroma segar buah-buahan dan bunga yang ceria, manis, dan berdaya tahan tinggi.',
        'Strawberry' => 'Keharuman manis-segar buah strawberry matang yang ceria, manis, dan memikat.'
    );
    
    foreach ($aromas as $aroma) {
        $desc = isset($scent_details[$aroma]) ? $scent_details[$aroma] : "Keharuman eksklusif berkualitas premium.";
        $description .= "  <li><strong>$aroma:</strong> $desc</li>\n";
    }
    $description .= "</ul>\n";
    
    wp_update_post(array(
        'ID' => $parent_id,
        'post_title' => $unified_title,
        'post_name' => $unified_slug,
        'post_content' => $description
    ));
    
    $specs = array(
        array('spec_name' => 'Ukuran Tersedia', 'spec_value' => '50ML, 100ML'),
        array('spec_name' => 'Aroma Tersedia', 'spec_value' => implode(', ', $aromas)),
        array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Cairan Murni (Oil Base)'),
        array('spec_name' => 'Kemasan', 'spec_value' => 'Botol Segel Premium')
    );
    carbon_set_post_meta($parent_id, 'product_specifications', $specs);
    carbon_set_post_meta($parent_id, 'product_sku', 'BP-50ML / BP-100ML');
    
    if (!empty($gallery_ids)) {
        set_post_thumbnail($parent_id, $gallery_ids[0]);
        carbon_set_post_meta($parent_id, 'product_gallery', $gallery_ids);
    }
    
    // Delete child duplicates
    for ($i = 1; $i < count($bibit_posts); $i++) {
        if ($bibit_posts[$i]['id'] !== $parent_id) {
            wp_delete_post($bibit_posts[$i]['id'], true);
        }
    }
    echo "  Successfully consolidated Bibit Parfum.\n";
}

// ── 5. Align Brands ────────────────────────────────────────────────────────
echo "\n[5/6] Aligning brand relations...\n";
$q = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

$brand_aligned_count = 0;
while ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    
    $brand_id = 8; // Default Depo Cleanique
    $title_lower = strtolower($title);
    if (strpos($title_lower, 'prokopi') !== false || strpos($title_lower, 'pro kopi') !== false) {
        $brand_id = 369; // Prokopi
    } elseif (strpos($title_lower, 'malabeez') !== false) {
        $brand_id = 9; // Malabeez
    } elseif (strpos($title_lower, 'orchid') !== false) {
        $brand_id = 7; // Orchid Care
    } elseif (strpos($title_lower, 'cleanique lab') !== false) {
        $brand_id = 342;
    } elseif (strpos($title_lower, 'cleanique academy') !== false) {
        $brand_id = 343;
    } elseif (strpos($title_lower, 'cleanique mart') !== false) {
        $brand_id = 344;
    }
    
    carbon_set_post_meta($id, 'product_brand', array(
        array('id' => $brand_id, 'type' => 'post', 'subtype' => '', 'value' => '')
    ));
    $brand_aligned_count++;
}
wp_reset_postdata();
echo "  Aligned brand relations for $brand_aligned_count products.\n";

// ── 6. Enrich HTML Descriptions ────────────────────────────────────────────
echo "\n[6/6] Upgrading product descriptions to premium B2B format...\n";
$rich_desc_data = array(
    'Pembersih Mesin Kopi (Pro Kopi)' => array(
        'features' => array(
            'Formula Degreaser Kuat: Efektif melarutkan sisa minyak kopi (coffee oil) dan kerak kopi gosong pada group head dan portalfilter.',
            'Aman untuk Food Grade: Bebas residu berbahaya, aman digunakan untuk peralatan konsumsi makanan/minuman.',
            'Perlindungan Mesin: Memperpanjang umur elemen pemanas dan pompa mesin espresso dari korosi mineral.'
        ),
        'ingredients' => array(
            'Sodium Carbonate (Detergent Builder)',
            'Sodium Percarbonate (Oxygen Bleach Active)',
            'Chelating Agents & Anti-Corrosion Stabilizer'
        ),
        'directions' => array(
            'Masukkan 1 sendok teh (3-5 gram) bubuk Pro Kopi ke dalam portafilter yang dipasangi blind basket.',
            'Pasang portafilter pada group head mesin espresso.',
            'Jalankan brew cycle selama 10 detik, lalu hentikan selama 10 detik. Ulangi proses ini sebanyak 5 kali.',
            'Lepaskan portafilter, jalankan aliran air dari group head untuk membilas sisa deterjen.',
            'Pasang kembali portafilter (dengan blind basket), ulangi proses brew cycle menggunakan air bersih untuk pembilasan akhir.',
            'Seduh kopi pertama untuk dibuang sebelum mesin digunakan kembali.'
        )
    ),
    'Athari – Biang Sabun Mandi Cair' => array(
        'features' => array(
            'Formula Konsentrat Tinggi: Cukup diencerkan dengan air bersih untuk menghasilkan sabun mandi cair siap pakai dalam volume besar.',
            'Busa Melimpah & Lembut: Memberikan busa tebal yang nyaman di kulit tanpa rasa licin berlebih.',
            'Pelembap Ekstra (Moisturizer): Menjaga kelembapan alami kulit sehingga kulit tidak kering setelah mandi.'
        ),
        'ingredients' => array(
            'Sodium Lauryl Ether Sulfate (SLES) premium',
            'Cocoamidopropyl Betaine (mild surfactant)',
            'Glycerin (moisturizer agent) & Fragrance',
            'Aqua & Preservative'
        ),
        'directions' => array(
            'Siapkan wadah bersih berukuran minimal 5-10 Liter.',
            'Campurkan Biang Sabun Mandi Cair Athari dengan air bersih hangat (perbandingan anjuran 1:2 atau sesuai ketebalan busa yang diinginkan).',
            'Aduk perlahan hingga tercampur rata dan mengental sempurna.',
            'Diamkan selama 12-24 jam hingga busa hasil pengadukan hilang dan sabun menjadi jernih.',
            'Tuangkan ke dalam botol kemasan siap pakai.'
        )
    ),
    'Biang Pel Lantai' => array(
        'features' => array(
            'Konsentrat Super Hemat: Formula kental yang dapat diencerkan menjadi cairan pel lantai siap pakai berkualitas tinggi.',
            'Anti-Bakteri & Kuman: Dilengkapi bahan aktif disinfektan untuk menjaga lantai tetap steril dan higienis.',
            'Aroma Pinus Aromatik: Memberikan keharuman pinus segar yang tahan lama dan menghilangkan bau tidak sedap.'
        ),
        'ingredients' => array(
            'Concentrated Anionic Surfactant',
            'Pine Extract & Benzalkonium Chloride (Disinfectant)',
            'Viscosity Builder & Colorant'
        ),
        'directions' => array(
            'Campurkan 1 bagian Biang Pel Lantai dengan 4 bagian air bersih.',
            'Aduk merata hingga kekentalan dan warna tercampur sempurna.',
            'Cairan pel lantai siap digunakan atau dikemas ke dalam jerigen kecil.',
            'Untuk penggunaan pel harian: larutkan 30 ml hasil enceran ke dalam 3-5 liter air pel.'
        )
    ),
    'Biang Pelicin Setrika' => array(
        'features' => array(
            'Anti-Kusut Instan: Memudahkan setrika meluncur di atas semua jenis serat pakaian dengan licin dan cepat.',
            'Fragrance Microcapsules: Wangi menempel kuat pada serat kain dan bertahan hingga berhari-hari di dalam lemari.',
            'Formula Anti-Apek: Mencegah timbulnya bau apek akibat kelembapan saat pakaian disetrika.'
        ),
        'ingredients' => array(
            'Silicone Emulsion Active (Fabric Glider)',
            'Premium Fragrance compound',
            'Anti-Bacterial agent & Aqua'
        ),
        'directions' => array(
            'Campurkan 1 bagian Biang Pelicin Setrika dengan 5-10 bagian air bersih (sesuaikan dengan kekuatan aroma yang diinginkan).',
            'Aduk hingga tercampur rata dan berwarna putih susu.',
            'Masukkan ke dalam botol spray setrika.',
            'Semprotkan merata pada bagian pakaian yang akan disetrika.'
        )
    ),
    'Detta+ – Biang Deterjen Cair' => array(
        'features' => array(
            'Daya Bersih Extra (Heavy Duty): Menghilangkan kotoran minyak, lumpur, dan noda makanan dengan cepat.',
            'Anti-Redeposition Agent: Mencegah kotoran yang telah lepas menempel kembali ke serat kain selama proses pencucian.',
            'Optical Brightener (OBA): Menjaga pakaian putih tetap cemerlang dan warna pakaian tetap cerah tanpa memudarkannya.'
        ),
        'ingredients' => array(
            'Linear Alkylbenzene Sulfonate (LAS) active',
            'Sodium Lauryl Ether Sulfate (SLES)',
            'Anti-Redeposition Agent & Optical Brightener',
            'Fragrance & Colorant packet'
        ),
        'directions' => array(
            'Larutkan Biang Deterjen Detta+ dengan air bersih (rasio anjuran 1:4 untuk hasil premium).',
            'Aduk perlahan hingga mengental dan homogen.',
            'Diamkan selama beberapa jam hingga gelembung udara menghilang.',
            'Gunakan 30-50 ml deterjen cair hasil enceran untuk 5-7 kg cucian di mesin cuci.'
        )
    ),
    'Atinsoft' => array(
        'features' => array(
            'Foam & Viscosity Enhancer: Berfungsi ganda untuk meningkatkan volume busa dan menstabilkan kekentalan formula sabun/deterjen.',
            'Pelembut Serat Kain: Membantu memberikan efek lembut pada serat kain setelah proses pencucian.',
            'Kompatibilitas Luas: Mudah larut dan bercampur dengan berbagai jenis surfaktan anionik maupun non-ionik.'
        ),
        'ingredients' => array(
            'Cocamide DEA (CDEA) surfactant booster',
            'Fabric conditioning agents',
            'Aqueous stabilizer'
        ),
        'directions' => array(
            'Tambahkan Atinsoft pada fase pencampuran surfaktan saat memformulasi deterjen cair atau sabun mandi.',
            'Dosis anjuran berkisar antara 1% hingga 5% dari total berat formula sabun cair.',
            'Aduk secara konstan hingga kekentalan meningkat secara homogen.'
        )
    ),
    'Fixamax Cair' => array(
        'features' => array(
            'High-Performance Fixative: Mengikat molekul parfum agar menguap lebih lambat, membuat wangi parfum bertahan 3-5 kali lebih lama.',
            'Water & Alcohol Soluble: Sangat mudah larut dalam metanol, etanol, maupun air tanpa menimbulkan kerutan pada kain.',
            'Tanpa Residu: Cairan bening jernih yang tidak meninggalkan noda kuning atau bercak berminyak pada pakaian putih.'
        ),
        'ingredients' => array(
            'PPG-20 Methyl Glucose Ether (Fixative Active)',
            'Solvent stabilizer & odor neutralizer'
        ),
        'directions' => array(
            'Tambahkan Fixamax Cair ke dalam campuran bibit parfum sebelum dicampur dengan metanol/alkohol.',
            'Dosis anjuran: 1% hingga 3% dari total campuran parfum laundry siap pakai (sekitar 10-30 ml per 1 Liter parfum).',
            'Aduk rata selama 2-3 menit agar molekul parfum terikat secara kimiawi.'
        )
    ),
    'Fixamax Crystal' => array(
        'features' => array(
            'Slow Release Technology: Menahan penguapan wewangian secara bertahap sehingga keharuman bertahan ekstra lama pada serat kain.',
            'Bentuk Kristal Jernih: Sangat murni dan mudah dilarutkan ke dalam pelarut organik tanpa residu padat.',
            'Penguat Aroma (Odor Intensifier): Memperkuat aroma top-note dan middle-note pada bibit parfum agar lebih harum saat pertama kali disemprot.'
        ),
        'ingredients' => array(
            'Dipropylene Glycol (DPG) crystal compound',
            'Fragrance binder & long-lasting active crystal'
        ),
        'directions' => array(
            'Larutkan Fixamax Crystal ke dalam sedikit pelarut hangat atau bibit parfum murni.',
            'Dosis penggunaan: 0.5% hingga 2% dari berat total formula parfum laundry.',
            'Aduk hingga kristal larut sepenuhnya sebelum dicampurkan dengan sisa formula.'
        )
    ),
    'Foam Booster' => array(
        'features' => array(
            'Premium Cocamide DEA: Konsentrat murni kelapa kelapa sawit yang sangat efektif menstabilkan busa agar tidak cepat kempes.',
            'Viscosity Builder: Membantu meningkatkan kekentalan sabun cair, deterjen, dan shampoo mobil secara alami.',
            'Mild Conditioner: Memberikan efek lembut dan tidak membuat kulit kering atau kasar saat terkena sabun.'
        ),
        'ingredients' => array(
            '100% Pure Cocamide DEA / CDEA'
        ),
        'directions' => array(
            'Campurkan Foam Booster ke dalam bahan aktif utama (SLES/Texapon) sebelum ditambahkan air.',
            'Gunakan dosis 1% hingga 4% dari total berat formula sabun cair.',
            'Aduk merata hingga campuran mengental secara alami.'
        )
    ),
    'NaCl' => array(
        'features' => array(
            'Kristal Murni Food Grade: Garam murni berkualitas tinggi tanpa kandungan yodium untuk kekentalan sabun yang stabil.',
            'Viscosity Modifier Alami: Agen pengental paling efektif untuk surfaktan jenis Sodium Lauryl Ether Sulfate (SLES).',
            'Pembersih Alami: Membantu melarutkan kotoran organik dan menyeimbangkan tegangan permukaan air.'
        ),
        'ingredients' => array(
            'Sodium Chloride (NaCl) 99% Pure Crystal'
        ),
        'directions' => array(
            'Larutkan NaCl dalam sedikit air sebelum dimasukkan ke dalam campuran sabun cair.',
            'Masukkan larutan NaCl sedikit demi sedikit ke dalam adonan sabun cair yang sudah mengandung surfaktan sambil diaduk cepat.',
            'Hentikan penambahan jika sabun sudah mencapai puncak kekentalan yang diinginkan (penggunaan berlebih justru dapat mengencerkan sabun).'
        )
    ),
    'Konsentrat Parfum Alkohol Base' => array(
        'features' => array(
            'Formula Siap Pakai: Pelarut parfum laundry kelas profesional dengan campuran fixative dan stabilizer aktif.',
            'Cepat Kering: Menguap seketika setelah disemprot tanpa membuat kain menjadi basah atau berjamur.',
            'Aroma Menyebar Sempurna: Membantu menyebarkan aroma parfum laundry secara merata ke seluruh permukaan serat kain.'
        ),
        'ingredients' => array(
            'Denatured Ethanol (Perfume Grade)',
            'Fragrance solubilizer & fixative stabilizer'
        ),
        'directions' => array(
            'Campurkan 10% hingga 20% bibit parfum murni ke dalam cairan Konsentrat Parfum ini.',
            'Aduk perlahan hingga tercampur rata.',
            'Parfum laundry siap disemprotkan langsung pada pakaian saat proses setrika akhir atau sebelum pengemasan plastik.'
        )
    ),
    'Determat Eco – Paket Bahan Deterjen Eco-10' => array(
        'features' => array(
            'Formula Hemat & Praktis: Satu paket lengkap untuk membuat 10-20 Liter deterjen cair siap pakai dengan biaya ekonomis.',
            'Daya Cuci Bersih: Efektif mengangkat kotoran sehari-hari, keringat, dan debu pada pakaian keluarga.',
            'Ramah Lingkungan: Menggunakan surfaktan biodegradable yang mudah terurai dan aman bagi ekosistem air.'
        ),
        'ingredients' => array(
            'SLES Paste (Active Cleaning Agent)',
            'Foam Stabilizer & Thickener builder',
            'Fragrance & Colorant Powder packet'
        ),
        'directions' => array(
            'Siapkan wadah bersih ukuran 15-20 Liter.',
            'Larutkan pasta pembersih (SLES) dengan air bersih secara bertahap sambil diaduk konstan.',
            'Masukkan bahan pengental dan foam booster, aduk hingga larut merata.',
            'Tambahkan pewangi dan pewarna yang telah dilarutkan terlebih dahulu.',
            'Tambahkan sisa air hingga volume mencapai 10-15 Liter, diamkan selama 12 jam hingga busa mereda sepenuhnya sebelum dikemas.'
        )
    )
);

$q = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

$desc_updated_count = 0;
while ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    $title = html_entity_decode(get_the_title());
    $content = get_the_content();
    
    $desc_text = '';
    $features_list = array();
    $ingredients_list = array();
    $directions_list = array();
    
    $safety_list = array(
        'Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).',
        'Hindari paparan sinar matahari langsung dan area lembap.',
        'Jauhkan dari jangkauan anak-anak dan hewan peliharaan.',
        'Gunakan sarung tangan karet saat menangani produk konsentrat untuk mencegah iritasi kulit.',
        'Jika terkena mata, bilas segera dengan air mengalir selama 15 menit dan hubungi dokter jika iritasi berlanjut.'
    );
    
    $matched_key = '';
    foreach (array_keys($rich_desc_data) as $key) {
        if (strpos($title, $key) !== false || strpos($key, $title) !== false) {
            $matched_key = $key;
            break;
        }
    }
    
    if ($matched_key && isset($rich_desc_data[$matched_key])) {
        $data = $rich_desc_data[$matched_key];
        
        if (preg_match('/<p>(.*?)<\/p>/is', $content, $m)) {
            $desc_text = trim($m[1]);
        } else {
            $desc_text = strip_tags($content);
            $desc_text = preg_replace('/(deskripsi produk|komposisi bahan|cara penggunaan|petunjuk keamanan)/i', '', $desc_text);
            $desc_text = trim($desc_text);
        }
        
        $features_list = $data['features'];
        $ingredients_list = $data['ingredients'];
        $directions_list = $data['directions'];
    } else {
        if (preg_match('/<h3>Deskripsi Produk<\/h3>\s*<p>(.*?)<\/p>/is', $content, $m)) {
            $desc_text = trim($m[1]);
        } elseif (preg_match('/<p>(.*?)<\/p>/is', $content, $m)) {
            $desc_text = trim($m[1]);
        } else {
            $desc_text = trim(wp_strip_all_tags($content));
        }
        
        if (preg_match('/<h3>Komposisi Bahan<\/h3>\s*<ul>(.*?)<\/ul>/is', $content, $m)) {
            preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $li_matches);
            $ingredients_list = array_map('trim', $li_matches[1]);
        }
        
        if (preg_match('/<h3>Cara Penggunaan<\/h3>\s*<ol>(.*?)<\/ol>/is', $content, $m)) {
            preg_match_all('/<li>(.*?)<\/li>/is', $m[1], $li_matches);
            $directions_list = array_map('trim', $li_matches[1]);
        }
        
        if (empty($features_list)) {
            $features_list = array(
                'Formula Konsentrat Premium: Dirancang dengan bahan aktif berkualitas untuk efisiensi penggunaan.',
                'Aman untuk Peralatan: Tidak korosif dan menjaga integritas serat kain atau bodi kendaraan.',
                'Wangi Segar & Tahan Lama: Memberikan keharuman khas produk Indotech yang elegan.'
            );
        }
    }
    
    $features_list = array_unique(array_filter(array_map('strip_tags', $features_list)));
    $ingredients_list = array_unique(array_filter(array_map('strip_tags', $ingredients_list)));
    $directions_list = array_filter(array_map('strip_tags', $directions_list));
    
    if (empty($desc_text)) {
        $desc_text = "$title adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk menunjang aktivitas kebersihan harian Anda.";
    }
    if (empty($ingredients_list)) {
        $ingredients_list = array('Active surfactant agents', 'Fragrance compound', 'Aqua & stabilizer');
    }
    if (empty($directions_list)) {
        $directions_list = array('Larutkan produk dengan air bersih sesuai takaran kebutuhan.', 'Aplikasikan pada permukaan yang ingin dibersihkan atau dirawat.', 'Bilas dengan air bersih hingga tidak ada residu tertinggal.');
    }
    
    $new_content = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($desc_text) . "</p>\n\n";
    $new_content .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
    foreach ($features_list as $feat) { $new_content .= "  <li>" . esc_html($feat) . "</li>\n"; }
    $new_content .= "</ul>\n\n<h3>Komposisi Bahan</h3>\n<ul>\n";
    foreach ($ingredients_list as $ing) { $new_content .= "  <li>" . esc_html($ing) . "</li>\n"; }
    $new_content .= "</ul>\n\n<h3>Cara Penggunaan</h3>\n<ol>\n";
    foreach ($directions_list as $dir) { $new_content .= "  <li>" . esc_html($dir) . "</li>\n"; }
    $new_content .= "</ol>\n\n<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>\n<ul>\n";
    foreach ($safety_list as $saf) { $new_content .= "  <li>" . esc_html($saf) . "</li>\n"; }
    $new_content .= "</ul>\n";
    
    wp_update_post(array('ID' => $id, 'post_content' => $new_content));
    wp_update_post(array('ID' => $id, 'post_excerpt' => mb_strimwidth(strip_tags($desc_text), 0, 160, '...')));
    $desc_updated_count++;
}
wp_reset_postdata();
echo "  Upgraded HTML descriptions for $desc_updated_count products.\n";

echo "\n=== Migration & Restructuring Deployment Completed Successfully! ===\n";
?>
