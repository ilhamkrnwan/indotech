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
$categories = array('Peralatan & Pembersih Kopi', 'Biang Pembersih Konsentrat', 'Bahan Kimia Laundry & Sabun', 'Bibit Parfum & Wewangian');

$cat_cache = array();
foreach ($categories as $cat) {
    $term = get_term_by('name', $cat, 'product_cat');
    if (!$term) {
        $new_term = wp_insert_term($cat, 'product_cat');
        if (is_wp_error($new_term)) {
            echo "  Error creating category $cat: " . $new_term->get_error_message() . "\n";
        } else {
            echo "  Created category: $cat\n";
            $cat_cache[$cat] = $new_term['term_id'];
        }
    } else {
        echo "  Category exists: $cat\n";
        $cat_cache[$cat] = $term->term_id;
    }
}

// ── 2. Define Products Data Array (46 products) ───────────────────────────
echo "\n[2/6] Importing products and restoring featured images...\n";
$products = array();

// 1. Pro Kopi
$products[] = array(
    'title' => 'Pembersih Mesin Kopi (Pro Kopi)-450gr',
    'slug' => 'pro-kopi-pembersih-mesin-kopi-450gr',
    'sku' => 'PK-PK450',
    'category' => 'Peralatan & Pembersih Kopi',
    'content' => '<h3>Deskripsi Produk</h3><p>Pro Kopi adalah bubuk pembersih mesin kopi espresso (coffee machine cleaner) premium berkualitas food-grade. Berfungsi efektif untuk membersihkan sisa residu minyak kopi, kerak kopi, serta kotoran pada group head, filter, dan portafilter.</p><h3>Cara Penggunaan</h3><ol><li>Masukkan 3 gram bubuk Pro Kopi ke dalam blind basket.</li><li>Pasang portafilter pada group head, jalankan mesin selama 10 detik, matikan selama 10 detik. Ulangi sebanyak 5 kali.</li><li>Lepaskan portafilter dan bilas group head dengan air panas.</li><li>Bilas portafilter hingga bersih. Buang espresso extraction pertama sebelum digunakan menyeduh kembali.</li></ol>',
    'image_file' => 'Pembersih Mesin Kopi (Pro Kopi)-450gr.png'
);
$products[] = array(
    'title' => 'Pembersih Mesin Kopi (Pro Kopi)-900gr',
    'slug' => 'pro-kopi-pembersih-mesin-kopi-900gr',
    'sku' => 'PK-PK900',
    'category' => 'Peralatan & Pembersih Kopi',
    'content' => '<h3>Deskripsi Produk</h3><p>Pro Kopi adalah bubuk pembersih mesin kopi espresso (coffee machine cleaner) premium berkualitas food-grade. Berfungsi efektif untuk membersihkan sisa residu minyak kopi, kerak kopi, serta kotoran pada group head, filter, dan portafilter.</p><h3>Cara Penggunaan</h3><ol><li>Masukkan 3 gram bubuk Pro Kopi ke dalam blind basket.</li><li>Pasang portafilter pada group head, jalankan mesin selama 10 detik, matikan selama 10 detik. Ulangi sebanyak 5 kali.</li><li>Lepaskan portafilter dan bilas group head dengan air panas.</li><li>Bilas portafilter hingga bersih. Buang espresso extraction pertama sebelum digunakan menyeduh kembali.</li></ol>',
    'image_file' => 'Pembersih Mesin Kopi (Pro Kopi)-900gr.png'
);

// 2. Biang Sabun
$products[] = array(
    'title' => 'Athari - Biang Sabun Mandi Cair-3 Liter',
    'slug' => 'athari-biang-sabun-mandi-cair-3-liter',
    'sku' => 'BG-SM3L',
    'category' => 'Biang Pembersih Konsentrat',
    'content' => '<h3>Deskripsi Produk</h3><p>Athari Biang Sabun Mandi Cair adalah konsentrat sabun mandi beraroma segar yang dirancang untuk diencerkan menjadi sabun mandi siap pakai. Sangat hemat biaya dan cocok untuk kebutuhan rumah tangga maupun usaha.</p><h3>Cara Penggunaan</h3><p>Campurkan konsentrat dengan air bersih dengan perbandingan yang disarankan pada kemasan, aduk hingga rata dan mengental, diamkan sejenak hingga busa mereda sebelum dikemas.</p>',
    'image_file' => 'Athari - Biang Sabun Mandi Cair-3 Liter.png'
);
$products[] = array(
    'title' => 'Biang Pel Lantai-5 Liter',
    'slug' => 'biang-pel-lantai-5-liter',
    'sku' => 'BG-PL5L',
    'category' => 'Biang Pembersih Konsentrat',
    'content' => '<h3>Deskripsi Produk</h3><p>Biang Pel Lantai konsentrat formula pembersih lantai aromatik berukuran 5 Liter. Efektif mengangkat kotoran, membunuh kuman, serta memberikan keharuman tahan lama pada lantai ruangan Anda.</p><h3>Cara Penggunaan</h3><p>Campurkan konsentrat biang pel lantai dengan air bersih dengan perbandingan formulasi standar Anda untuk mendapatkan cairan pel siap pakai.</p>',
    'image_file' => 'Biang Pel Lantai-5 Liter.png'
);
$products[] = array(
    'title' => 'Biang Pelicin Setrika-5 Liter',
    'slug' => 'biang-pelicin-setrika-5-liter',
    'sku' => 'BG-PS5L',
    'category' => 'Biang Pembersih Konsentrat',
    'content' => '<h3>Deskripsi Produk</h3><p>Biang Pelicin Setrika formula konsentrat 5 Liter untuk melembutkan serat kain dan mempermudah proses setrika pakaian. Memberikan aroma harum dan efek antikusut pada pakaian.</p><h3>Cara Penggunaan</h3><p>Larutkan biang pelicin setrika dengan air bersih sesuai dosis kekentalan dan keharuman yang diinginkan, lalu masukkan ke dalam botol spray siap pakai.</p>',
    'image_file' => 'Biang Pelicin Setrika-5 Liter.png'
);
$products[] = array(
    'title' => 'Detta+ - Biang Deterjen Cair-5 Liter',
    'slug' => 'detta-biang-deterjen-cair-5-liter',
    'sku' => 'BG-DC5L',
    'category' => 'Biang Pembersih Konsentrat',
    'content' => '<h3>Deskripsi Produk</h3><p>Detta+ adalah Biang Deterjen Cair berformula ramah lingkungan yang hemat air dan berbusa melimpah. Efektif mengangkat noda membandel pada serat pakaian.</p><h3>Cara Penggunaan</h3><p>Larutkan konsentrat Detta+ dengan air bersih sesuai takaran kemasan, aduk merata hingga mengental, lalu diamkan 12 jam hingga busa tenang.</p>',
    'image_file' => 'Detta+ - Biang Deterjen Cair-5 Liter.png'
);

// 3. Atinsoft
$products[] = array(
    'title' => 'Atinsoft-1 Liter',
    'slug' => 'atinsoft-1-liter',
    'sku' => 'CH-AT1L',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Atinsoft adalah bahan kimia aditif khusus (foam booster dan pembersih lemak) untuk menstabilkan busa dan meningkatkan daya bersih pada sabun cuci piring, deterjen laundry, maupun hand wash.</p><h3>Cara Penggunaan</h3><p>Campurkan Atinsoft ke dalam formula sabun cair sebanyak 2% - 5% dari volume formulasi adonan sabun cair Anda.</p>',
    'image_file' => 'Atinsoft-1 Liter.png'
);
$products[] = array(
    'title' => 'Atinsoft-5 Liter',
    'slug' => 'atinsoft-5-liter',
    'sku' => 'CH-AT5L',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Atinsoft adalah bahan kimia aditif khusus (foam booster dan pembersih lemak) untuk menstabilkan busa and meningkatkan daya bersih pada sabun cuci piring, deterjen laundry, maupun hand wash.</p><h3>Cara Penggunaan</h3><p>Campurkan Atinsoft ke dalam formula sabun cair sebanyak 2% - 5% dari volume formulasi adonan sabun cair Anda.</p>',
    'image_file' => 'Atinsoft-5 Liter.png'
);

// 4. Fixamax
$products[] = array(
    'title' => 'Fixamax Cair-100ml',
    'slug' => 'fixamax-cair-100ml',
    'sku' => 'FX-C100',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Cair adalah bahan pengikat parfum (fixative) premium yang mengikat molekul wewangian agar menempel lebih lama pada serat kain. Bekerja sangat baik sebagai pengikat aroma parfum laundry.</p><h3>Cara Penggunaan</h3><p>Campurkan 2-5 ml Fixamax Cair ke dalam 1 liter larutan pelarut parfum (seperti metanol atau alkohol) sebelum diaplikasikan.</p>',
    'image_file' => 'Fixamax Cair-100ml.png'
);
$products[] = array(
    'title' => 'Fixamax Cair-500ml',
    'slug' => 'fixamax-cair-500ml',
    'sku' => 'FX-C500',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Cair adalah bahan pengikat parfum (fixative) premium yang mengikat molekul wewangian agar menempel lebih lama pada serat kain. Bekerja sangat baik sebagai pengikat aroma parfum laundry.</p><h3>Cara Penggunaan</h3><p>Campurkan 2-5 ml Fixamax Cair ke dalam 1 liter larutan pelarut parfum (seperti metanol atau alkohol) sebelum diaplikasikan.</p>',
    'image_file' => 'Fixamax Cair-500ml.png'
);
$products[] = array(
    'title' => 'Fixamax Cair-1 Liter',
    'slug' => 'fixamax-cair-1-liter',
    'sku' => 'FX-C1L',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Cair adalah bahan pengikat parfum (fixative) premium yang mengikat molekul wewangian agar menempel lebih lama pada serat kain. Bekerja sangat baik sebagai pengikat aroma parfum laundry.</p><h3>Cara Penggunaan</h3><p>Campurkan 2-5 ml Fixamax Cair ke dalam 1 liter larutan pelarut parfum (seperti metanol atau alkohol) sebelum diaplikasikan.</p>',
    'image_file' => 'Fixamax Cair-1 Liter.png'
);
$products[] = array(
    'title' => 'Fixamax Crystal-80gr',
    'slug' => 'fixamax-crystal-80gr',
    'sku' => 'FX-K80',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Crystal adalah agen booster parfum berbentuk kristal yang memperkuat penyebaran wangi parfum agar tercium lebih semerbak dan intens.</p><h3>Cara Penggunaan</h3><p>Larutkan 3-5 gram Fixamax Crystal ke dalam 1 liter pelarut parfum laundry sebelum dicampur dengan bibit wewangian.</p>',
    'image_file' => 'Fixamax Crystal-80gr.png'
);
$products[] = array(
    'title' => 'Fixamax Crystal-450gr',
    'slug' => 'fixamax-crystal-450gr',
    'sku' => 'FX-K450',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Crystal adalah agen booster parfum berbentuk kristal yang memperkuat penyebaran wangi parfum agar tercium lebih semerbak dan intens.</p><h3>Cara Penggunaan</h3><p>Larutkan 3-5 gram Fixamax Crystal ke dalam 1 liter pelarut parfum laundry sebelum dicampur dengan bibit wewangian.</p>',
    'image_file' => 'Fixamax Crystal-450gr.png'
);
$products[] = array(
    'title' => 'Fixamax Crystal-950gr',
    'slug' => 'fixamax-crystal-950gr',
    'sku' => 'FX-K950',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Fixamax Crystal adalah agen booster parfum berbentuk kristal yang memperkuat penyebaran wangi parfum agar tercium lebih semerbak dan intens.</p><h3>Cara Penggunaan</h3><p>Larutkan 3-5 gram Fixamax Crystal ke dalam 1 liter pelarut parfum laundry sebelum dicampur dengan bibit wewangian.</p>',
    'image_file' => 'Fixamax Crystal-950gr.png'
);

// 5. Foam Booster & NaCl
$products[] = array(
    'title' => 'Foam Booster-100ml',
    'slug' => 'foam-booster-100ml',
    'sku' => 'CH-FB100',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>Foam Booster (cocamidopropyl betaine / CAPB) berfungsi untuk meningkatkan kuantitas busa, mempertebal busa, dan memberikan efek kelembutan ekstra pada adonan sabun cair laundry atau pencuci piring.</p><h3>Cara Penggunaan</h3><p>Tambahkan Foam Booster ke dalam campuran surfaktan utama saat formulasi adonan sabun cair sesuai persentase standar.</p>',
    'image_file' => 'Foam Booster-100ml.png'
);
$products[] = array(
    'title' => 'NaCl-1 kg',
    'slug' => 'nacl-1-kg',
    'sku' => 'CH-NC1K',
    'category' => 'Bahan Kimia Laundry & Sabun',
    'content' => '<h3>Deskripsi Produk</h3><p>NaCl (Sodium Chloride / Garam Murni) tanpa yodium berkualitas industri. Berfungsi sebagai bahan pengental (thickening agent) alami yang sangat efektif ketika dicampurkan dengan surfaktan untuk sabun cuci piring dan deterjen cair.</p><h3>Cara Penggunaan</h3><p>Larutkan NaCl secara perlahan ke dalam larutan sabun cair hingga mencapai tingkat kekentalan yang diinginkan.</p>',
    'image_file' => 'NaCl-1 kg.png'
);

// 6. Konsentrat Parfum & Paket Bahan
$products[] = array(
    'title' => 'Konsentrat Parfum Alkohol Base-10 Liter',
    'slug' => 'konsentrat-parfum-alkohol-base-10-liter',
    'sku' => 'PF-KA10L',
    'category' => 'Bibit Parfum & Wewangian',
    'content' => '<h3>Deskripsi Produk</h3><p>Konsentrat parfum berbasis alkohol siap pakai berukuran 10 Liter. Diformulasikan dengan alkohol berkualitas tinggi dan fixative agar keharuman bertahan lama pada pakaian setelah proses setrika.</p><h3>Cara Penggunaan</h3><p>Siap pakai. Semprotkan langsung pada pakaian laundry setelah disetrika sebelum masuk ke proses pengemasan plastik.</p>',
    'image_file' => 'Konsentrat Parfum Alkohol Base-10 Liter.png'
);
$products[] = array(
    'title' => 'Determat Eco - Paket Bahan Deterjen Eco-10-20 Liter',
    'slug' => 'determat-eco-paket-bahan-deterjen-eco-10-20-liter',
    'sku' => 'BG-DCECO',
    'category' => 'Biang Pembersih Konsentrat',
    'content' => '<h3>Deskripsi Produk</h3><p>Determat Eco adalah paket bahan deterjen cair hemat dan praktis untuk diolah sendiri menjadi 10-20 liter deterjen cair laundry siap pakai dengan formula ramah lingkungan.</p><h3>Cara Penggunaan</h3><p>Ikuti petunjuk pencampuran air dan pengadukan bertahap yang disertakan di dalam kemasan hingga adonan deterjen mengental sempurna.</p>',
    'image_file' => 'Determat Eco - Paket Bahan Deterjen Eco-10-20 Liter.png'
);

// 7. Bibit Parfum (14 Varian x 2 Ukuran = 28 produk)
$variants = array(
    'Baccarat' => 'BC',
    'Downy Mystique' => 'DM',
    'Downy Passion' => 'DP',
    'Dunhill Blue' => 'DB',
    'Floral' => 'FL',
    'Jeruk Nipis' => 'JN',
    'Lavender' => 'LV',
    'Lemon Fresh' => 'LF',
    'Molto Blue' => 'MB',
    'Ocean Fresh' => 'OF',
    'Phylux' => 'PL',
    'Sakura' => 'SK',
    'Snappy' => 'SN',
    'Strawberry' => 'ST'
);
$sizes = array('50ML', '100ML');
foreach ($variants as $var_name => $sku_code) {
    foreach ($sizes as $size) {
        $products[] = array(
            'title' => "Bibit Parfum - {$var_name}-{$size}",
            'slug' => "bibit-parfum-" . sanitize_title($var_name) . "-" . strtolower($size),
            'sku' => "PF-{$sku_code}{$size}",
            'category' => 'Bibit Parfum & Wewangian',
            'content' => "<h3>Deskripsi Produk</h3><p>Bibit parfum laundry konsentrat murni varian {$var_name} berkualitas tinggi tanpa campuran. Menghasilkan keharuman mewah, segar, dan tahan lama yang cocok untuk pewangi laundry profesional.</p><h3>Cara Penggunaan</h3><p>Campurkan bibit parfum dengan metanol/alkohol dan fixative (Fixamax) dengan takaran sesuai tingkat konsentrasi aroma yang diinginkan.</p>",
            'image_file' => "Bibit Parfum - {$var_name}-{$size}.png"
        );
    }
}

// Plus remaining new products mentioned in CPT (to upload missing images for them too)
$extra_products = array(
    array('title' => 'Anti Noda Jamur – Penghilang Noda Jamur & Bau Apek', 'slug' => 'anti-noda-jamur-penghilang-noda-jamur-bau-apek', 'image_file' => 'Anti Noda Jamur-1 kg.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Deterjen Karpet – Pembersih Karpet & Sofa', 'slug' => 'deterjen-karpet-pembersih-karpet-sofa', 'image_file' => 'Deterjen Karpet-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Deterjen Eco – Deterjen Cair Wangi Premium', 'slug' => 'deterjen-eco-deterjen-cair-wangi-premium', 'image_file' => 'Deterjen Eco-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Anti Noda – Penghilang Noda Pakaian', 'slug' => 'anti-noda-penghilang-noda-pakaian', 'image_file' => 'Anti Noda Bandel-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Engine Degreaser – Pembersih Mesin Kendaraan', 'slug' => 'engine-degreaser-pembersih-mesin-kendaraan', 'image_file' => 'Pembersih Mesin (Engine Degreaser)-900ml.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Alkali – Pengangkat Noda & Pencerah Pakaian', 'slug' => 'alkali-pengangkat-noda-pencerah-pakaian', 'image_file' => 'Anti Noda Bandel-1 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Deodoran – Pewangi & Penghilang Bau Kain', 'slug' => 'deodoran-pewangi-penghilang-bau-kain', 'image_file' => 'Parfum Linen Spray - Malabeez-250ml.png', 'category' => 'Bibit Parfum & Wewangian'),
    array('title' => 'Glass Cleaner – Pembersih Kaca & Cermin', 'slug' => 'glass-cleaner-pembersih-kaca-cermin', 'image_file' => 'Pembersih Interior – Perawatan Kabin Kendaraan.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Glika – Pelicin & Pengharum Kain', 'slug' => 'glika-pelicin-pengharum-kain', 'image_file' => 'Biang Pelicin Setrika-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Glory – Softener & Pelembut Pakaian', 'slug' => 'glory-softener-pelembut-pakaian', 'image_file' => 'Atinsoft-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Karbol – Pembersih Lantai & Disinfektan Pinus', 'slug' => 'karbol-pembersih-lantai-disinfektan-pinus', 'image_file' => 'Biang Karbol – Paket Bahan Karbol Wangi.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Parfum Karpet – Pewangi Khusus Karpet & Tekstil', 'slug' => 'parfum-karpet-pewangi-khusus-karpet-tekstil', 'image_file' => 'Parfum Aroma Timur Tengah - Malabeez-800ml.png', 'category' => 'Bibit Parfum & Wewangian'),
    array('title' => 'Parfum Laundry – Pewangi Pakaian Waterbase & Alkohol', 'slug' => 'parfum-laundry-pewangi-pakaian-waterbase-alkohol', 'image_file' => 'Konsentrat Parfum Alkohol Base-10 Liter.png', 'category' => 'Bibit Parfum & Wewangian'),
    array('title' => 'Semir Ban – Tire Shine & Dressing Kendaraan', 'slug' => 'semir-ban-tire-shine-dressing-kendaraan', 'image_file' => 'Semir Ban-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Pembersih Kerak – Anti Scale & Descaler', 'slug' => 'pembersih-kerak-anti-scale-descaler', 'image_file' => 'Pembersih Mesin (Engine Degreaser)-250ml.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Sleek – Cairan Setrika & Perawat Kain', 'slug' => 'sleek-cairan-setrika-perawat-kain', 'image_file' => 'Biang Pelicin Setrika-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Souring – Penetral pH & Pelembut Kain Asam', 'slug' => 'souring-penetral-ph-pelembut-kain-asam', 'image_file' => 'Atinsoft-1 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Sabun 3 in 1 – Sabun Mandi, Keramas & Cuci Muka', 'slug' => 'sabun-3-in-1-sabun-mandi-keramas-cuci-muka', 'image_file' => 'Athari - Biang Sabun Mandi Cair-3 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Nauki – Pelembut & Pewangi Pakaian', 'slug' => 'nauki-pelembut-pewangi-pakaian', 'image_file' => 'Atinsoft-5 Liter.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Compound – Poles Bodi & Penghilang Baret Kendaraan', 'slug' => 'compound-poles-bodi-penghilang-baret-kendaraan', 'image_file' => 'Pembersih Mesin (Engine Degreaser)-250ml.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Pengkilap Body – Wax & Shine Bodi Kendaraan', 'slug' => 'pengkilap-body-wax-shine-bodi-kendaraan', 'image_file' => 'Pembersih Mesin (Engine Degreaser)-100ml.png', 'category' => 'Bahan Kimia Laundry & Sabun'),
    array('title' => 'Prime+ 1000ml – Parfum Laundry Premium Eksklusif', 'slug' => 'prime-1000ml-parfum-laundry-premium-eksklusif', 'image_file' => 'Parfum Aroma Timur Tengah - Malabeez-800ml.png', 'category' => 'Bibit Parfum & Wewangian'),
    array('title' => 'Prokopi – Pembersih Mesin Fotokopi & Elektronik', 'slug' => 'prokopi-pembersih-mesin-fotokopi-elektronik', 'image_file' => 'Pembersih Mesin Kopi (Pro Kopi)-900gr.png', 'category' => 'Peralatan & Pembersih Kopi')
);

foreach ($extra_products as $ep) {
    // Add to processing loop if not already in list
    $found = false;
    foreach ($products as $p) {
        if ($p['slug'] === $ep['slug']) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $products[] = array(
            'title' => $ep['title'],
            'slug' => $ep['slug'],
            'sku' => '',
            'category' => $ep['category'],
            'content' => '<h3>Deskripsi Produk</h3><p>Formula khusus premium berkualitas tinggi untuk kebutuhan industri dan rumah tangga Anda.</p>',
            'image_file' => $ep['image_file']
        );
    }
}

$src_dir = __DIR__ . '/src';
$imported_ids = array();

foreach ($products as $p) {
    $title = html_entity_decode($p['title']);
    
    // Check if product already exists by slug or title
    $existing = get_posts(array(
        'name' => $p['slug'],
        'post_type' => 'product',
        'post_status' => 'any',
        'numberposts' => 1
    ));
    
    if (!empty($existing)) {
        $post_id = $existing[0]->ID;
        echo "  Exists: '$title' (ID: $post_id). Checking image...\n";
    } else {
        // Double check by title
        $existing_by_title = get_page_by_title($title, OBJECT, 'product');
        if ($existing_by_title) {
            $post_id = $existing_by_title->ID;
            echo "  Exists by title: '$title' (ID: $post_id). Checking image...\n";
        } else {
            echo "  Creating: '$title'...\n";
            $post_id = wp_insert_post(array(
                'post_title'   => $title,
                'post_name'    => $p['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'product',
                'post_content' => $p['content'],
                'post_excerpt' => mb_strimwidth(strip_tags($p['content']), 0, 160, '...')
            ));
            
            if (is_wp_error($post_id)) {
                echo "    Error inserting product: " . $post_id->get_error_message() . "\n";
                continue;
            }
            
            // Set SKU
            if (!empty($p['sku'])) {
                carbon_set_post_meta($post_id, 'product_sku', $p['sku']);
            }
            
            // Set category
            if (isset($cat_cache[$p['category']])) {
                wp_set_object_terms($post_id, intval($cat_cache[$p['category']]), 'product_cat');
            }
        }
    }
    
    // Upload/Re-verify image if missing or invalid
    if (!has_post_thumbnail($post_id)) {
        $img_file = $src_dir . '/' . $p['image_file'];
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
            if (is_array($specs[$i]) && isset($specs[$i]['spec_name']) && (strtolower(trim($specs[$i]['spec_name'])) === 'ukuran tersedia' || strtolower(trim($specs[$i]['spec_name'])) === 'berat bersih' || strtolower(trim($specs[$i]['spec_name'])) === 'volume')) {
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
                    if (is_array($specs[$i]) && isset($specs[$i]['spec_name']) && (strtolower(trim($specs[$i]['spec_name'])) === 'ukuran tersedia' || strtolower(trim($specs[$i]['spec_name'])) === 'berat bersih' || strtolower(trim($specs[$i]['spec_name'])) === 'volume')) {
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
    
    if (empty($aromas)) {
        $aromas = array('Baccarat', 'Downy Mystique', 'Downy Passion', 'Dunhill Blue', 'Floral', 'Jeruk Nipis', 'Lavender', 'Lemon Fresh', 'Molto Blue', 'Ocean Fresh', 'Phylux', 'Sakura', 'Snappy', 'Strawberry');
    }
    
    $gallery_ids = array_unique(array_filter($gallery_ids));
    $aromas = array_unique($aromas);
    sort($aromas);
    
    $unified_title = "Bibit Parfum & Wewangian";
    $unified_slug = "bibit-parfum";
    
    $description = "<p>Bibit Parfum &amp; Wewangian Premium merupakan konsentrat parfum murni berkualitas tinggi yang dirancang khusus untuk industri laundry, perawatan rumah tangga (homecare), kosmetik, maupun penggunaan pribadi. Formula konsentrat murni ini menghasilkan keharuman yang kuat, elegan, dan tahan lama.</p>\n";
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
            'Hydrogen Peroxide'
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
            'Active surfactant agents',
            'Foam Stabilizer',
            'Fragrance',
            'Colorant Powder packet'
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
            'Total surfaktan 2,9%'
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
            'Fragrance 2.5%',
            'Anti Fungi Agent 0.8%'
        ),
        'directions' => array(
            'Campurkan 1 bagian Biang Pelicin Setrika dengan 5-10 bagian air bersih (sesuaikan dengan kekuatan aroma yang diinginkan).',
            'Aduk hingga tercampur rata dan berwarna putih susu.',
            'Masukkan ke dalam botol spray setrika.',
            'Semprotkan merata pada bagian pakaian yang akan disetrika.'
        )
    ),
    'Detta+ – Biang Deterjen Cair' => array(
        'description' => 'Detta+ adalah Biang Deterjen Cair berformula ramah lingkungan yang hemat air dan berbusa melimpah. Efektif mengangkat noda membandel pada serat pakaian.',
        'features' => array(
            'Daya Bersih Extra (Heavy Duty): Menghilangkan kotoran minyak, lumpur, dan noda makanan dengan cepat.',
            'Anti-Redeposition Agent: Mencegah kotoran yang telah lepas menempel kembali ke serat kain selama proses pencucian.',
            'Optical Brightener (OBA): Menjaga pakaian putih tetap cemerlang dan warna pakaian tetap cerah tanpa memudarkannya.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance'
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
            'Linear Alkyl Benzene Sulfonate',
            'Natrium Hidroksida'
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
            'Difenil keton',
            'Dipropylene Glycol (DPG)'
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
            'Difenil keton'
        ),
        'directions' => array(
            'Larutkan Fixamax Crystal ke dalam sedikit pelarut hangat atau bibit parfum murni.',
            'Dosis penggunaan: 0.5% hingga 2% dari berat total formula parfum laundry.',
            'Aduk hingga kristal larut sepenuhnya sebelum dicampurkan dengan sisa formula.'
        )
    ),
    'Foam Booster' => array(
        'description' => 'Foam Booster (cocamidopropyl betaine / CAPB) berfungsi untuk meningkatkan kuantitas busa, mempertebal busa, dan memberikan efek kelembutan ekstra pada adonan sabun cair laundry atau pencuci piring.',
        'features' => array(
            'Foam & Lather Booster: Meningkatkan kuantitas dan stabilitas busa secara signifikan pada sabun laundry dan pencuci piring.',
            'Mild Surfactant: Lembut di tangan dan mengurangi potensi iritasi dari bahan pembersih utama.',
            'Viscosity Builder: Membantu meningkatkan kekentalan sabun cair secara alami ketika dikombinasikan dengan garam.'
        ),
        'ingredients' => array(
            'Cocamidopropyl Betaine (CAPB)'
        ),
        'directions' => array(
            'Tambahkan Foam Booster ke dalam adonan sabun cair laundry atau pencuci piring saat pencampuran surfaktan utama.',
            'Aduk perlahan hingga tercampur secara homogen untuk meningkatkan kuantitas busa sabun cair.'
        )
    ),
    'NaCl' => array(
        'description' => 'NaCl (Sodium Chloride / Garam Murni) tanpa yodium berkualitas industri. Berfungsi sebagai bahan pengental (thickening agent) alami yang sangat efektif ketika dicampurkan dengan surfaktan untuk sabun cuci piring dan deterjen cair.',
        'features' => array(
            'Kristal Murni Food Grade: Garam murni berkualitas tinggi tanpa kandungan yodium untuk kekentalan sabun yang stabil.',
            'Viscosity Modifier Alami: Agen pengental paling efektif untuk surfaktan jenis Sodium Lauryl Ether Sulfate (SLES).',
            'Pembersih Alami: Membantu melarutkan kotoran organik dan menyeimbangkan tegangan permukaan air.'
        ),
        'ingredients' => array(
            'Sodium Chloride (NaCl)'
        ),
        'directions' => array(
            'Larutkan NaCl dalam sedikit air sebelum dimasukkan ke dalam campuran sabun cair.',
            'Masukkan larutan NaCl sedikit demi sedikit ke dalam adonan sabun cair yang sudah mengandung surfaktan sambil diaduk cepat.',
            'Hentikan penambahan jika sabun sudah mencapai puncak kekentalan yang diinginkan (penggunaan berlebih justru dapat mengencerkan sabun).'
        )
    ),
    'Konsentrat Parfum Alkohol Base' => array(
        'description' => 'Konsentrat parfum berbasis alkohol siap pakai berukuran 10 Liter. Diformulasikan dengan alkohol berkualitas tinggi dan fixative agar keharuman bertahan lama pada pakaian setelah proses setrika.',
        'features' => array(
            'Formula Siap Pakai: Pelarut parfum laundry kelas profesional dengan campuran fixative dan stabilizer aktif.',
            'Cepat Kering: Menguap seketika setelah disemprot tanpa membuat kain menjadi basah atau berjamur.',
            'Aroma Menyebar Sempurna: Membantu menyebarkan aroma parfum laundry secara merata ke seluruh permukaan serat kain.'
        ),
        'ingredients' => array(
            'Fragrance solubilizer',
            'Fixative stabilizer'
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
            'Active surfactant agents',
            'Fragrance',
            'Colorant Powder packet'
        ),
        'directions' => array(
            'Siapkan wadah bersih ukuran 15-20 Liter.',
            'Larutkan pasta pembersih (SLES) dengan air bersih secara bertahap sambil diaduk konstan.',
            'Masukkan bahan pengental dan foam booster, aduk hingga larut merata.',
            'Tambahkan pewangi dan pewarna yang telah dilarutkan terlebih dahulu.',
            'Tambahkan sisa air hingga volume mencapai 10-15 Liter, diamkan selama 12 jam hingga busa mereda sepenuhnya sebelum dikemas.'
        )
    ),
    'Hand Wash – Sabun Cuci Tangan Cair' => array(
        'description' => 'Hand Wash – Sabun Cuci Tangan Cair adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk menjaga kebersihan tangan Anda setelah beraktivitas.',
        'features' => array(
            'Antibakteri Efektif: Melindungi tangan dari kuman, bakteri, dan kotoran setelah beraktivitas.',
            'Formula Lembut di Kulit: Mengandung pelembap agar kulit tangan tidak kering atau kasar meskipun sering digunakan.',
            'Aroma Segar Premium: Memberikan keharuman mewah yang tahan lama di tangan Anda.'
        ),
        'ingredients' => array(
            'Total Surfaktan 9%'
        ),
        'directions' => array(
            'Basahi tangan dengan air bersih mengalir.',
            'Tuangkan cairan Hand Wash secukupnya pada telapak tangan.',
            'Gosok seluruh bagian tangan, termasuk sela-sela jari dan punggung tangan selama minimal 20 detik.',
            'Bilas dengan air bersih hingga kesat dan keringkan.'
        )
    ),
    'Engine Degreaser – Pembersih Mesin Kendaraan' => array(
        'description' => 'Engine Degreaser – Pembersih Mesin Kendaraan adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk membersihkan mesin kendaraaan Anda supaya terlihat seperti baru kembali.',
        'features' => array(
            'Formula Pembersih Berat (Heavy Duty): Meluruhkan kerak oli, gemuk/grease, jelaga, dan kotoran jalanan membandel di ruang mesin.',
            'Aman untuk Komponen Logam: Tidak merusak besi, aluminium, maupun blok mesin kendaraan.',
            'Mudah Diaplikasikan: Cukup disemprotkan dan dibilas untuk melarutkan kotoran dengan cepat.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance',
            'Monoethanolamine',
            'Sodium Metasilicate',
            'Oxalic Acid'
        ),
        'directions' => array(
            'Pastikan kondisi mesin kendaraan dalam keadaan dingin.',
            'Semprotkan cairan Engine Degreaser pada area mesin yang kotor dan berminyak.',
            'Diamkan selama 2-5 menit agar formula melunakkan kerak kotoran.',
            'Gosok perlahan dengan kuas detailing jika diperlukan, lalu bilas dengan air bersih hingga bersih.'
        )
    ),
    'Deterjen Karpet – Pembersih Karpet & Sofa' => array(
        'description' => 'Deterjen Karpet – Pembersih Karpet & Sofa adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk membersihkan karpet Anda dari kotoran dan debu yang menempel di karpet.',
        'features' => array(
            'Formula Busa Aktif: Penetrasi cepat ke serat kain karpet tebal untuk mengangkat debu dan noda.',
            'Pencerah Serat Kain: Mengembalikan kesegaran warna karpet dan sofa agar terlihat bersih cemerlang.',
            'Anti-Bacterial Active: Menghilangkan kuman, tungau, dan bau apek lembap pada karpet.'
        ),
        'ingredients' => array(
            'Total Surfaktan 10%'
        ),
        'directions' => array(
            'Sedot debu pada karpet atau sofa terlebih dahulu.',
            'Larutkan Deterjen Karpet dengan air hangat sesuai kebutuhan pencucian.',
            'Sikat permukaan karpet perlahan dengan busa melimpah hasil campuran deterjen.',
            'Keringkan karpet dengan vacuum extractor atau jemur di tempat berangin.'
        )
    ),
    'Deterjen Eco – Deterjen Cair Wangi Premium' => array(
        'description' => 'Deterjen Eco – Deterjen Cair Wangi Premium adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk membersihkan pakaian Anda dari noda, keringat, debu, dan kotoran yang menempel.',
        'features' => array(
            'Formula Pembersih Ramah Lingkungan: Surfaktan biodegradable yang efektif namun aman bagi ekosistem.',
            'Keharuman Premium Tahan Lama: Mengandung parfum berkualitas yang melekat erat di serat kain.',
            'Optical Brightener: Menjaga warna pakaian tetap cemerlang dan putih tetap bersih bersinar.'
        ),
        'ingredients' => array(
            'Total Surfaktan 6%'
        ),
        'directions' => array(
            'Pisahkan pakaian putih dan berwarna.',
            'Gunakan 30-50 ml deterjen untuk mesin cuci kapasitas 5-7 kg (atau larutkan untuk mencuci manual).',
            'Cuci dan bilas pakaian seperti biasa hingga bersih.'
        )
    ),
    'Anti Noda Jamur – Penghilang Noda Jamur & Bau Apek' => array(
        'description' => 'Anti Noda Jamur – Penghilang Noda Jamur & Bau Apek adalah produk kebersihan dan perawatan berkualitas premium dari Indotech untuk menunjang aktivitas kebersihan harian Anda.',
        'features' => array(
            'Heavy Duty Mold Remover: Sangat efektif melarutkan noda bintik hitam jamur pada serat kain.',
            'Anti-Bacterial & Odor Eliminator: Menghilangkan bau apek membandel akibat kelembapan.',
            'Multisurface Action: Cocok untuk pakaian, sprei, handuk, mukena, dan perlengkapan tidur lainnya.'
        ),
        'ingredients' => array(
            'Total surfaktan 16%'
        ),
        'directions' => array(
            'Oleskan atau semprotkan cairan pada bagian kain yang terkena noda jamur.',
            'Sikat perlahan menggunakan sikat halus atau biarkan bereaksi selama 5-10 menit.',
            'Cuci pakaian dengan deterjen biasa dan bilas hingga bersih.'
        )
    ),
    'Souring – Penetral pH & Pelembut Kain Asam' => array(
        'features' => array(
            'Penetral pH Serat Kain: Menetralisir residu alkali dari deterjen utama agar serat kain tidak kaku.',
            'Mencegah Kerusakan Serat: Menjaga warna tetap cerah dan mencegah pelapukan serat kain akibat sisa kimia.',
            'Pelembut Alami: Membantu melembutkan pakaian secara alami setelah proses pencucian.'
        ),
        'ingredients' => array(
            'Citric acid',
            'Aqua'
        ),
        'directions' => array(
            'Tambahkan cairan Souring pada bilasan terakhir proses pencucian.',
            'Gunakan takaran 20-30 ml untuk kapasitas mesin cuci 5-7 kg.',
            'Bilas pakaian hingga bersih dan keringkan seperti biasa.'
        )
    ),
    'Prokopi – Pembersih Mesin Fotokopi & Elektronik' => array(
        'features' => array(
            'Formula Pembersih Cepat Kering: Efektif membersihkan kotoran dan tinta pada mesin fotokopi dan printer.',
            'Perlindungan Anti-Statik: Mencegah debu menempel kembali pada permukaan elektronik pasca pembersihan.',
            'Aman untuk Komponen Plastik: Tidak merusak panel plastik maupun sasis luar mesin elektronik.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance',
            'Monoethanolamine',
            'Sodium Metasilicate',
            'Oxalic Acid'
        ),
        'directions' => array(
            'Semprotkan cairan Prokopi pada lap microfiber bersih.',
            'Usapkan secara merata pada permukaan luar mesin fotokopi atau printer yang ingin dibersihkan.',
            'Lap kembali dengan bagian kain yang kering hingga bersih mengkilap.'
        )
    ),
    'Pembersih Bahan Kulit – Leather Cleaner & Conditioner' => array(
        'features' => array(
            'Pembersih Alami Ekstrak Lerak: Membersihkan noda debu dan kotoran pada kulit tanpa merusak pori-porinya.',
            'Kondisioner Serat Kulit: Menjaga kelembapan alami kulit agar tidak pecah-pecah atau kusam.',
            'Aplikasi Serbaguna: Aman digunakan untuk tas kulit, sepatu kulit, jaket kulit, maupun jok mobil.'
        ),
        'ingredients' => array(
            'Lerak',
            'Distilled water'
        ),
        'directions' => array(
            'Kocok produk terlebih dahulu sebelum digunakan.',
            'Tuangkan cairan secukupnya pada spons aplikator atau kain lembut.',
            'Gosok permukaan kulit secara perlahan dengan gerakan memutar.',
            'Lap sisa busa dan kotoran dengan kain kering, lalu angin-anginkan.'
        )
    ),
    'Parfum Helm – Pewangi Khusus Helm' => array(
        'features' => array(
            'Pewangi Khusus Padding Helm: Menghilangkan bau keringat, apek, dan debu di dalam helm.',
            'Cepat Kering & Bebas Lembap: Formula berbasis air yang menguap dengan cepat tanpa membuat padding basah.',
            'Aroma Segar Tahan Lama: Memberikan keharuman maskulin yang segar sepanjang perjalanan.'
        ),
        'ingredients' => array(
            'Fragrance solubilizer',
            'Fixative stabilizer',
            'Aqua'
        ),
        'directions' => array(
            'Semprotkan Parfum Helm secukupnya ke bagian dalam helm.',
            'Biarkan mengering selama 3-5 menit sebelum helm digunakan kembali.'
        )
    ),
    'Oxy Bleach – Pemutih Kain Berbasis Oksigen' => array(
        'features' => array(
            'Oxygen Active Bleach: Melarutkan noda membandel pada pakaian putih maupun berwarna tanpa memudarkan warna.',
            'Aman untuk Serat Pakaian: Tidak merusak rajutan serat kain dan tidak menyebabkan kekuningan.',
            'Formula Ramah Lingkungan: Mudah terurai dan aman bagi lingkungan sekitar.'
        ),
        'ingredients' => array(
            'Hydrogen Peroxide'
        ),
        'directions' => array(
            'Larutkan Oxy Bleach dengan deterjen dalam air hangat.',
            'Rendam pakaian yang bernoda selama 15-30 menit sebelum dicuci.',
            'Cuci and bilas pakaian seperti biasa hingga bersih.'
        )
    ),
    'Nauki – Pelembut & Pewangi Pakaian' => array(
        'features' => array(
            'Softener Alami Ekstrak Lerak: Melembutkan serat pakaian secara alami tanpa residu kimia buatan.',
            'Aroma Mewah Tahan Lama: Menghasilkan keharuman bunga yang menenangkan dan bertahan lama.',
            'Ramah Lingkungan & Lembut di Kulit: Aman untuk mencuci pakaian bayi dan orang berkulit sensitif.'
        ),
        'ingredients' => array(
            'Lerak',
            'Distilled water'
        ),
        'directions' => array(
            'Tambahkan cairan Nauki pada bilasan terakhir proses pencucian pakaian.',
            'Gunakan takaran 30-50 ml untuk cucian 5-7 kg.',
            'Aduk rata, rendam pakaian selama 5-10 menit, lalu peras dan jemur.'
        )
    ),
    'Mizuny – Softener Kain Aroma Segar' => array(
        'features' => array(
            'Softener Konsentrat Tinggi: Melembutkan pakaian secara optimal dengan dosis penggunaan yang sangat hemat.',
            'Aroma Segar Semerbak: Memberikan keharuman fresh yang menyegarkan pakaian sepanjang hari.',
            'Perlindungan Serat Kain: Mengurangi kerutan pasca cuci dan mempermudah proses penyetrikaan.'
        ),
        'ingredients' => array(
            'Total Surfaktan 18%'
        ),
        'directions' => array(
            'Tambahkan Mizuny pada bilasan akhir pencucian.',
            'Gunakan 20-30 ml untuk kapasitas mesin cuci 5-7 kg.',
            'Rendam sejenak lalu peras pakaian dan jemur.'
        )
    ),
    'Malabeez – Parfum Laundry Oriental Premium' => array(
        'features' => array(
            'Aroma Khas Timur Tengah: Keharuman oriental mewah berbasis micro parfum yang harum semerbak.',
            'Formula Bebas Bercak: Tidak meninggalkan noda kuning atau bercak minyak pada serat kain.',
            'Keharuman Tahan Lama: Wangi menempel erat di pakaian hingga berhari-hari di dalam lemari.'
        ),
        'ingredients' => array(
            'Micro parfum',
            'Parfum',
            'Aqua'
        ),
        'directions' => array(
            'Semprotkan cairan Malabeez langsung ke pakaian setelah proses penyetrikaan.',
            'Lakukan pengemasan plastik laundry segera untuk hasil aroma maksimal.'
        )
    ),
    'Glory – Softener & Pelembut Pakaian' => array(
        'features' => array(
            'Cationic Softener Formula: Melunakkan serat kain secara efektif sehingga nyaman saat dikenakan.',
            'Fragrance Microcapsules: Mengandung kombinasi micro-parfum untuk pelepasan keharuman secara bertahap.',
            'Anti-Static Agent: Mencegah timbulnya listrik statis pada pakaian sintetis pasca pengeringan.'
        ),
        'ingredients' => array(
            'Surfaktan 3.6%',
            'Micro parfum 0.6%',
            'Parfum 0.3%'
        ),
        'directions' => array(
            'Campurkan 1 bagian Glory dengan formulasi pelarut air sesuai standar kebutuhan Anda.',
            'Gunakan pada bilasan cucian terakhir untuk melembutkan serat kain.'
        )
    ),
    'Glika – Pelicin & Pengharum Kain' => array(
        'features' => array(
            'Anti-Kusut Instan: Memudahkan setrika meluncur di atas pakaian dengan licin dan cepat.',
            'Formula Anti-Jamur (Anti-Fungi): Mencegah timbulnya jamur dan bau apek akibat kelembapan setrika.',
            'Wangi Segar Premium: Pakaian tetap wangi sepanjang hari selama beraktivitas.'
        ),
        'ingredients' => array(
            'Fragrance 0.6%',
            'Anti Fungi Agent 0.1%'
        ),
        'directions' => array(
            'Masukkan cairan Glika ke dalam botol spray setrika.',
            'Semprotkan merata pada bagian pakaian yang akan disetrika.'
        )
    ),
    'Crystal Cleaner – Pembersih Kristal Serbaguna' => array(
        'features' => array(
            'Pembersih Serbaguna Kuat: Melarutkan noda kerak air, noda kuning, dan minyak membandel di berbagai permukaan.',
            'Oxygen Active Action: Formula kristal aktif berbasis hidrogen peroksida yang aman bagi permukaan keramik dan logam.',
            'Mudah Dibilas: Bersih berkilau tanpa meninggalkan residu sabun yang licin.'
        ),
        'ingredients' => array(
            'Hydrogen Peroxide'
        ),
        'directions' => array(
            'Taburkan atau larutkan Crystal Cleaner pada permukaan yang basah.',
            'Biarkan bereaksi selama 5-10 menit, lalu sikat perlahan.',
            'Bilas dengan air bersih hingga bersih mengkilap.'
        )
    ),
    'Alkali – Pengangkat Noda & Pencerah Pakaian' => array(
        'features' => array(
            'Detergent Builder Booster: Meningkatkan daya pembersih deterjen utama dalam meluruhkan noda minyak dan lemak.',
            'Pencerah Warna Pakaian: Mencegah warna pakaian memudar dan membuat pakaian putih tampak cemerlang.',
            'pH Modifier: Menjaga stabilitas alkalinity air pencucian untuk performa detergen optimal.'
        ),
        'ingredients' => array(
            'Sodium hydroxide',
            'Aqua'
        ),
        'directions' => array(
            'Tambahkan Alkali bersamaan dengan deterjen utama pada tangki pencucian mesin cuci.',
            'Dosis penggunaan berkisar antara 5-15 ml per kilogram cucian kering.'
        )
    ),
    'Semir Ban – Tire Shine & Dressing Kendaraan' => array(
        'features' => array(
            'High-Gloss Shine: Mengembalikan warna hitam pekat ban dengan kilap basah (wet-look) yang memukau.',
            'Tire Protection Active: Mengandung polimer khusus untuk mencegah ban retak-retak akibat paparan cuaca.',
            'Water Repellent Effect: Lapisan anti-air yang melindungi ban dari kotoran lumpur dan debu jalanan.'
        ),
        'ingredients' => array(
            'Surfaktan',
            'Dimethyl Polysiloxane Polymer 10%'
        ),
        'directions' => array(
            'Pastikan permukaan ban kendaraan dalam keadaan bersih dan kering.',
            'Oleskan cairan Semir Ban secara merata menggunakan spons aplikator pada dinding samping ban.',
            'Biarkan mengering secara alami hingga menghasilkan kilap hitam pekat.'
        )
    ),
    'Pengusir Tikus – Rodent Repellent Kendaraan' => array(
        'features' => array(
            'Effective Rodent Repellent: Mencegah tikus dan hewan pengerat bersarang di dalam ruang mesin kendaraan.',
            'Aman untuk Kabel & Sensor: Tidak merusak kabel kelistrikan, karet selang, maupun komponen sensitif mesin.',
            'Perlindungan Tahan Lama: Memberikan bau repellent yang mengusir hama secara konstan.'
        ),
        'ingredients' => array(
            'Cationic Surfactant',
            'Fragrance',
            'Solubilizer'
        ),
        'directions' => array(
            'Bersihkan ruang mesin kendaraan dari sisa kotoran tikus terlebih dahulu.',
            'Semprotkan cairan Pengusir Tikus pada kabel, selang, dan sasis mesin.',
            'Ulangi penyemprotan setiap 1-2 minggu sekali untuk proteksi maksimal.'
        )
    ),
    'Pengkilap Body – Wax & Shine Bodi Kendaraan' => array(
        'features' => array(
            'Instant Shine & Protect: Memberikan kilau berkilau (glossy) pada permukaan cat bodi mobil/motor.',
            'Hydrophobic Layer: Menghasilkan efek daun talas (water beading) untuk menangkal noda air hujan.',
            'UV Protection: Melindungi cat dari kusam akibat paparan sinar matahari.'
        ),
        'ingredients' => array(
            'Dimethyl Polysiloxane Polymer',
            'Solubilizer'
        ),
        'directions' => array(
            'Cuci dan keringkan kendaraan terlebih dahulu.',
            'Semprotkan atau oleskan cairan Pengkilap Body pada permukaan panel kendaraan.',
            'Lap dan buff secara memutar menggunakan kain microfiber bersih hingga mengkilap.'
        )
    ),
    'Penghitam Body – Restorer Eksterior Kendaraan' => array(
        'features' => array(
            'Trim Restorer Premium: Mengembalikan warna hitam alami pada bagian bumper dan trim plastik yang pudar.',
            'Long Lasting Protection: Lapisan tahan air yang tidak luntur meskipun dicuci berulang kali.',
            'Mencegah Penuaan Plastik: Melindungi plastik dari retak dan kusam akibat paparan sinar UV.'
        ),
        'ingredients' => array(
            'Pigmen hitam',
            'Dimethyl Polysiloxane Polymer',
            'Solubilizer'
        ),
        'directions' => array(
            'Bersihkan permukaan trim plastik eksterior kendaraan dari debu dan kotoran.',
            'Tuangkan cairan Penghitam Body pada spons aplikator.',
            'Usapkan secara merata pada permukaan plastik dan biarkan meresap.'
        )
    ),
    'Pembersih Kaca Mobil – Glass Cleaner Kendaraan' => array(
        'features' => array(
            'Streak-Free Shine: Membersihkan kaca mobil secara sempurna tanpa meninggalkan bercak garis pasca lap.',
            'Melarutkan Water Spot: Efektif menghilangkan noda jamur kaca (water spot) ringan dan minyak jalanan.',
            'Slick Coating Action: Memberikan efek licin pada kaca agar air dan debu tidak mudah menempel.'
        ),
        'ingredients' => array(
            'Amodimethicone',
            'Solven',
            'Hydrogen fluoride'
        ),
        'directions' => array(
            'Semprotkan cairan Pembersih Kaca Mobil secara merata pada kaca kendaraan.',
            'Lap bersih menggunakan kain microfiber khusus kaca dengan gerakan satu arah.',
            'Pastikan tidak ada residu cairan tertinggal.'
        )
    ),
    'Compound – Poles Bodi & Penghilang Baret Kendaraan' => array(
        'features' => array(
            'Scratch & Swirl Remover: Menghilangkan baret halus dan goresan swirl marks pada pernis cat kendaraan.',
            'Safe for Clear Coat: Tidak mengikis lapisan cat secara berlebihan, aman untuk cat metallic.',
            'Pre-Wax Treatment: Menghaluskan permukaan cat sebelum masuk ke proses pengkilapan bodi.'
        ),
        'ingredients' => array(
            'Aqua',
            'Mineral Oil',
            'Silicone Emulsion',
            'Talc'
        ),
        'directions' => array(
            'Bersihkan bodi kendaraan dan pastikan dalam kondisi dingin di bawah naungan.',
            'Oleskan Compound secukupnya pada area baret bodi kendaraan.',
            'Gosok dengan gerakan memutar menggunakan spons pad poles atau mesin polisher.',
            'Lap bersih sisa residu dengan kain microfiber.'
        )
    ),
    'Determat Eco – Paket Bahan Detergen Cair Ekonomis' => array(
        'features' => array(
            'Paket Pembuatan Detergen Ekonomis: Bahan lengkap untuk diolah sendiri menjadi deterjen laundry cair hemat biaya.',
            'Busa Melimpah & Wangi: Menghasilkan deterjen cair yang memiliki daya cuci bersih dan keharuman segar.',
            'Sangat Hemat Produksi: Pilihan ideal untuk pengusaha laundry kiloan skala pemula.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance',
            'Colorant Powder packet'
        ),
        'directions' => array(
            'Larutkan pasta aktif ke dalam wadah berisi air bersih secara perlahan.',
            'Tambahkan formulasi pewangi dan pewarna yang telah disediakan.',
            'Aduk secara konstan hingga mengental sempurna dan siap dikemas.'
        )
    ),
    'Detta Plus – Paket Bahan Sabun Cuci Piring' => array(
        'features' => array(
            'Paket Bahan Sabun Ekonomis: Paket lengkap untuk membuat sabun cuci piring cair siap pakai dengan biaya rendah.',
            'Melarutkan Lemak Cepat: Menghasilkan sabun cuci piring yang efektif membersihkan sisa lemak makanan.',
            'Busa Melimpah: Busa tebal dan stabil untuk kenyamanan saat mencuci peralatan dapur.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance'
        ),
        'directions' => array(
            'Larutkan paket bahan sabun ke dalam air bersih bertahap sesuai petunjuk kemasan.',
            'Aduk hingga mengental sempurna, diamkan beberapa jam hingga busa tenang, lalu siap digunakan.'
        )
    ),
    'Biang Karbol – Paket Bahan Karbol Wangi' => array(
        'features' => array(
            'Paket Bahan Pembersih Pinus: Satu paket bahan untuk diolah menjadi karbol lantai disinfektan konsentrat.',
            'Desinfektan Kuat: Efektif mensterilkan lantai rumah sakit, hotel, kandang, maupun toilet.',
            'Aroma Pinus Alami: Menghilangkan bau busuk membandel dengan keharuman pinus cemara yang menyegarkan.'
        ),
        'ingredients' => array(
            'Pine oil 17%',
            'Benzalkonium chloride 1%'
        ),
        'directions' => array(
            'Larutkan bahan biang karbol ke dalam air bersih sesuai instruksi.',
            'Aduk perlahan hingga tercampur merata dan larutan berubah warna susu cemara siap pakai.'
        )
    ),
    'Arai – Paket Bahan Sabun Cuci Tangan' => array(
        'features' => array(
            'Paket Bahan Hand Wash Ekonomis: Sangat mudah diolah menjadi sabun cuci tangan cair premium berbusa melimpah.',
            'Pelembab Lembut di Kulit: Menghasilkan hand wash yang ramah di tangan tanpa menimbulkan iritasi kulit.',
            'Aroma Segar & Menyenangkan: Menghilangkan bau tidak sedap pada tangan setelah beraktivitas atau makan.'
        ),
        'ingredients' => array(
            'Active surfactant agents',
            'Fragrance',
            'Colorant Powder packet'
        ),
        'directions' => array(
            'Campurkan adonan biang dengan air bersih hangat perlahan dalam wadah bersih.',
            'Aduk hingga homogen dan mengental alami, lalu diamkan 12 jam sebelum dikemas.'
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
        
        if (isset($data['description'])) {
            $desc_text = $data['description'];
        } elseif (preg_match('/<p>(.*?)<\/p>/is', $content, $m)) {
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
    
    // Update Carbon Fields specifications table with Bahan Aktif
    if (!empty($ingredients_list)) {
        $ingredients_string = implode(', ', $ingredients_list);
        $specs = carbon_get_post_meta($id, 'product_specifications');
        if (!is_array($specs)) {
            $specs = array();
        }
        $found_active_ingredient = false;
        for ($i = 0; $i < count($specs); $i++) {
            if (is_array($specs[$i]) && isset($specs[$i]['spec_name']) && (strtolower(trim($specs[$i]['spec_name'])) === 'bahan aktif' || strtolower(trim($specs[$i]['spec_name'])) === 'komposisi' || strtolower(trim($specs[$i]['spec_name'])) === 'kandungan')) {
                $specs[$i]['spec_name'] = 'Bahan Aktif';
                $specs[$i]['spec_value'] = $ingredients_string;
                $found_active_ingredient = true;
                break;
            }
        }
        if (!$found_active_ingredient) {
            $specs[] = array(
                'spec_name' => 'Bahan Aktif',
                'spec_value' => $ingredients_string
            );
        }
        carbon_set_post_meta($id, 'product_specifications', $specs);
    }
    
    $desc_updated_count++;
}
wp_reset_postdata();
echo "  Upgraded HTML descriptions for $desc_updated_count products.\n";

echo "\n=== Migration & Restructuring Deployment Completed Successfully! ===\n";