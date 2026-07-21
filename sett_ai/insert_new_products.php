<?php
/**
 * PT Indotech Berkah Abadi
 * Product Insertion Script for EssenZ, Oclean, Octa, Softa, Softsense
 * 
 * Instructions:
 * 1. Push changes to GitHub and pull on VPS, or upload directly.
 * 2. Run: php sett_ai/insert_new_products.php
 */

define('WP_USE_THEMES', false);
require_once __DIR__ . '/../wp-load.php';

if (php_sapi_name() !== 'cli') {
    die("Error: This script must be executed via CLI (SSH terminal) for safety.\n");
}

echo "=== PT Indotech Berkah Abadi - Starting New Product Insertion ===\n";

// ── 1. Brand Alignment ──────────────────────────────────────────────────
// Find Orchid Care Brand ID (usually 7, but lookup dynamically for safety)
$brand_post = get_page_by_title('Orchid Care', OBJECT, 'brand');
$brand_id = $brand_post ? $brand_post->ID : 7;
echo "Orchid Care Brand ID identified as: $brand_id\n";

// ── 2. Helper Function to Build Content ──────────────────────────────────
function build_product_content($desc, $features, $ingredients, $directions) {
    $html = "<h3>Deskripsi Produk</h3>\n<p>" . esc_html($desc) . "</p>\n\n";
    
    $html .= "<h3>Fitur &amp; Keunggulan</h3>\n<ul>\n";
    foreach ($features as $f) {
        $html .= "  <li>" . esc_html($f) . "</li>\n";
    }
    $html .= "</ul>\n\n";
    
    $html .= "<h3>Komposisi Bahan</h3>\n<ul>\n";
    foreach ($ingredients as $i) {
        $html .= "  <li>" . esc_html($i) . "</li>\n";
    }
    $html .= "</ul>\n\n";
    
    $html .= "<h3>Cara Penggunaan</h3>\n<ol>\n";
    foreach ($directions as $d) {
        $html .= "  <li>" . esc_html($d) . "</li>\n";
    }
    $html .= "</ol>\n\n";
    
    $html .= "<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>\n<ul>\n";
    $safety_list = array(
        'Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).',
        'Hindari paparan sinar matahari langsung dan area lembap.',
        'Jauhkan dari jangkauan anak-anak dan hewan peliharaan.',
        'Gunakan sarung tangan karet saat menangani produk konsentrat untuk mencegah iritasi kulit.',
        'Jika terkena mata, bilas segera dengan air mengalir selama 15 menit.'
    );
    foreach ($safety_list as $s) {
        $html .= "  <li>" . esc_html($s) . "</li>\n";
    }
    $html .= "</ul>\n";
    
    return $html;
}

// ── 3. Define the 5 Products ─────────────────────────────────────────────
$products_to_insert = array(
    // 1. EssenZ
    array(
        'title' => 'EssenZ – Parfum Waterbase',
        'slug' => 'essenz-parfum-waterbase',
        'category_name' => 'Bibit Parfum & Wewangian',
        'sku' => 'PF-EZ',
        'desc' => 'EssenZ adalah formula parfum berbasis air (waterbase) premium yang dirancang khusus untuk memberikan keharuman tahan lama pada pakaian tanpa meninggalkan noda kuning atau bercak minyak. Dilengkapi dengan teknologi micro-capsule aktif yang melepaskan aroma wangi secara perlahan saat pakaian mengalami gesekan, sehingga pakaian tetap wangi sepanjang hari.',
        'features' => array(
            'Formula Berbasis Air (Waterbase): Sangat aman untuk semua jenis kain dan warna pakaian, bebas noda dan residu minyak.',
            'Teknologi Microcapsule: Mengunci keharuman pada serat kain dan melepaskan aroma segar secara bertahap saat pakaian dipakai.',
            'Ramah Lingkungan & Halal: Terbuat dari bahan-bahan berkualitas tinggi yang ramah lingkungan dan bersertifikasi Halal.',
            'Varian Aroma Lengkap: Sakura, Floral, Lavender, Molto Blue, Ocean, Orchid, Orchid Passion, dan Phylux.'
        ),
        'ingredients' => array(
            'Aqua (water)',
            'Fragrance compound',
            'Microcapsule fragrance',
            'Solubilizer',
            'Preservative'
        ),
        'directions' => array(
            'Semprotkan EssenZ Parfum Waterbase secara merata pada pakaian saat proses menyetrika atau sebagai finishing sebelum pakaian dikemas.',
            'Simpan pakaian di tempat tertutup untuk mempertahankan keharuman maksimal.'
        ),
        'specs' => array(
            array('spec_name' => 'Ukuran Tersedia', 'spec_value' => '1 Liter, 5 Liter'),
            array('spec_name' => 'Aroma Tersedia', 'spec_value' => 'Sakura, Floral, Lavender, Molto Blue, Ocean, Orchid, Orchid Passion, Phylux'),
            array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Cairan (Water Base)'),
            array('spec_name' => 'Kemasan', 'spec_value' => 'Jerigen Premium'),
            array('spec_name' => 'Bahan Aktif', 'spec_value' => 'Aqua, Fragrance compound, Microcapsule fragrance')
        )
    ),
    // 2. Oclean
    array(
        'title' => 'Oclean – Sabun Cuci Piring',
        'slug' => 'oclean-sabun-cuci-piring',
        'category_name' => 'Homecare & Surface Cleaner',
        'sku' => 'HC-OC',
        'desc' => 'Oclean adalah sabun cuci piring cair siap pakai dengan formula khusus pembersih lemak (anti-grease) yang sangat efektif mengangkat kotoran, minyak, dan lemak membandel pada peralatan makan dan masak. Aroma jeruk nipis yang segar membantu menghilangkan bau amis secara instan.',
        'features' => array(
            'Formula Anti-Lemak (Anti-Grease): Melarutkan noda minyak dan lemak membandel dengan cepat tanpa sisa.',
            'Aroma Jeruk Nipis Segar: Menghilangkan bau amis dan bau tidak sedap pada peralatan makan.',
            'Lembut di Tangan: Mengandung pelembap alami sehingga tidak menimbulkan iritasi atau kulit kering.',
            'Busa Melimpah: Memberikan efisiensi mencuci yang tinggi dengan busa tebal yang mudah dibilas.'
        ),
        'ingredients' => array(
            'Sodium Lauryl Ether Sulfate (SLES)',
            'Cocamidopropyl Betaine (CAPB)',
            'Lime Extract',
            'Sodium Chloride',
            'Aqua'
        ),
        'directions' => array(
            'Tuangkan cairan Oclean secukupnya pada spons pencuci yang sudah dibasahi.',
            'Remas spons hingga berbusa melimpah, lalu usapkan pada peralatan makan atau memasak.',
            'Bilas peralatan dapur hingga bersih dengan air mengalir.'
        ),
        'specs' => array(
            array('spec_name' => 'Ukuran Tersedia', 'spec_value' => '1 Liter, 5 Liter'),
            array('spec_name' => 'Aroma Tersedia', 'spec_value' => 'Jeruk Nipis'),
            array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Cairan Kental (Liquid)'),
            array('spec_name' => 'Kemasan', 'spec_value' => 'Jerigen Premium'),
            array('spec_name' => 'Bahan Aktif', 'spec_value' => 'Sodium Lauryl Ether Sulfate (SLES), Cocamidopropyl Betaine (CAPB)')
        )
    ),
    // 3. Octa
    array(
        'title' => 'Octa – Paket Bahan Sabun Cuci Piring',
        'slug' => 'octa-paket-bahan-sabun-cuci-piring',
        'category_name' => 'Paket Bahan & Biang Sabun',
        'sku' => 'PK-OCT',
        'desc' => 'Octa adalah biang sabun cuci piring berbentuk pasta konsentrat ekonomis dan praktis. Satu box paket bahan Octa dirancang sangat mudah diolah sendiri di rumah dan dapat menghasilkan hingga 5 liter sabun cuci piring cair siap pakai berkualitas premium. Sangat cocok untuk kebutuhan rumah tangga maupun usaha kuliner (restoran, warung makan, kafe).',
        'features' => array(
            'Hasil Melimpah (5 Liter): Sangat hemat, mengubah 1 box pasta menjadi 5 liter sabun cuci piring siap pakai.',
            'Daya Cuci Premium: Mengandung formula aktif yang efektif melarutkan lemak dan menghilangkan bau amis.',
            'Lembut & Aman: Ramah di kulit tangan, ramah lingkungan, serta aman untuk mencuci buah dan sayuran.',
            'Anti-Gagal: Proses pembuatan yang sangat mudah dengan instruksi lengkap yang disertakan.'
        ),
        'ingredients' => array(
            'Active surfactant paste (Texapon/SLES)',
            'NaCl (pengental)',
            'Foam booster',
            'Fragrance Lime',
            'Pewarna'
        ),
        'directions' => array(
            'Siapkan wadah bersih ukuran minimal 5-6 Liter dan air bersih sebanyak 4.5 Liter.',
            'Masukkan pasta Octa ke dalam wadah, tambahkan air secara bertahap sambil diaduk perlahan hingga pasta larut sepenuhnya.',
            'Masukkan bahan pengental (NaCl) secara perlahan sambil terus diaduk hingga cairan mengental secara merata.',
            'Diamkan larutan selama 12-24 jam hingga busa mereda sepenuhnya dan larutan berubah menjadi cairan jernih berwarna hijau siap pakai.'
        ),
        'specs' => array(
            array('spec_name' => 'Ukuran Tersedia', 'spec_value' => 'Paket Bahan (Hasil 5 Liter)'),
            array('spec_name' => 'Aroma Tersedia', 'spec_value' => 'Jeruk Nipis (Lime)'),
            array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Pasta & Bubuk (Biang)'),
            array('spec_name' => 'Kemasan', 'spec_value' => 'Box Karton Segel'),
            array('spec_name' => 'Bahan Aktif', 'spec_value' => 'Active surfactant paste, Foam booster, NaCl')
        )
    ),
    // 4. Softa
    array(
        'title' => 'Softa – Paket Bahan Softener Pasta',
        'slug' => 'softa-paket-bahan-softener',
        'category_name' => 'Paket Bahan & Biang Sabun',
        'sku' => 'PK-SFT',
        'desc' => 'Softa adalah paket bahan (biang) softener atau pelembut pakaian berbentuk pasta yang ekonomis. Diformulasikan dengan teknologi micro-encapsulation, satu paket pasta Softa sangat mudah diolah sendiri dengan air bersih dan menghasilkan hingga 5 liter pelembut pakaian siap pakai yang wangi, lembut di kulit, dan menjaga kualitas serat pakaian.',
        'features' => array(
            'Sangat Hemat (Hasil 5 Liter): Menghasilkan 5 liter pelembut pakaian siap pakai dari satu box pasta.',
            'Keharuman Micro-capsule: Mengunci aroma wewangian di serat pakaian yang akan aktif mengeluarkan keharuman saat terjadi gesekan.',
            'Pelembut Serat Pakaian: Membuat pakaian lebih halus, mudah disetrika, dan mencegah efek kaku pada kain.',
            'Aman di Kulit: Ramah lingkungan dan tidak menimbulkan iritasi kulit (teruji aman).'
        ),
        'ingredients' => array(
            'Softener active agent (pasta)',
            'Fragrance compound',
            'Microcapsule fragrance',
            'Pewarna'
        ),
        'directions' => array(
            'Siapkan wadah bersih ukuran minimal 5-6 Liter dan air bersih sebanyak 4.5 Liter.',
            'Masukkan pasta Softa ke dalam wadah, tuangkan air bersih secara bertahap sambil diaduk secara konstan hingga pasta larut sepenuhnya dan tercampur rata.',
            'Diamkan selama 12 jam hingga formula stabil dan busa menghilang sepenuhnya sebelum dikemas ke dalam botol atau jerigen.'
        ),
        'specs' => array(
            array('spec_name' => 'Ukuran Tersedia', 'spec_value' => 'Paket Bahan (Hasil 5 Liter)'),
            array('spec_name' => 'Aroma Tersedia', 'spec_value' => 'Sakura, Molto Blue, Downy Passion, Downy Mystique'),
            array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Pasta (Biang)'),
            array('spec_name' => 'Kemasan', 'spec_value' => 'Box Karton Segel'),
            array('spec_name' => 'Bahan Aktif', 'spec_value' => 'Softener active agent, Fragrance microcapsule')
        )
    ),
    // 5. Softsense
    array(
        'title' => 'Softsense – Paket Bahan Softener 15 Liter',
        'slug' => 'softsense-paket-bahan-softener',
        'category_name' => 'Paket Bahan & Biang Sabun',
        'sku' => 'PK-SFS',
        'desc' => 'Softsense adalah paket bahan (biang) softener pelembut pakaian konsentrat premium berukuran lebih besar (sekitar 600 gram). Dirancang khusus untuk efisiensi tinggi bagi pengusaha laundry maupun kebutuhan rumah tangga besar, satu kemasan Softsense dapat menghasilkan hingga 15 liter pelembut pakaian siap pakai berkualitas tinggi dengan keharuman microcapsule yang mewah.',
        'features' => array(
            'Hasil Sangat Melimpah (15 Liter): Sangat efisien dan hemat biaya untuk menekan pengeluaran laundry/rumah tangga.',
            'Teknologi Microcapsule Premium: Memberikan wangi mewah tahan lama pada serat pakaian yang bertahan berhari-hari.',
            'Pelembut Ekstra: Menjaga pakaian tetap lembut, empuk, dan sangat mudah disetrika.',
            'Mudah Dibuat: Dilengkapi dengan petunjuk manual pembuatan yang praktis dan anti-gagal.'
        ),
        'ingredients' => array(
            'High-concentrate softener active agent',
            'Premium fragrance',
            'Microcapsule',
            'Pewarna'
        ),
        'directions' => array(
            'Siapkan wadah besar ukuran minimal 15-20 Liter dan siapkan air bersih sebanyak 14 Liter.',
            'Larutkan bahan konsentrat Softsense ke dalam air bersih secara perlahan-lahan sambil diaduk terus secara homogen.',
            'Pastikan semua pasta larut rata, lalu diamkan larutan selama 12-24 jam hingga busa mereda sempurna sebelum digunakan atau dikemas.'
        ),
        'specs' => array(
            array('spec_name' => 'Ukuran Tersedia', 'spec_value' => 'Paket Bahan (Hasil 15 Liter)'),
            array('spec_name' => 'Aroma Tersedia', 'spec_value' => 'Sakura, Molto Blue, Downy Passion, Downy Mystique'),
            array('spec_name' => 'Bentuk Fisik', 'spec_value' => 'Pasta Konsentrat (Biang)'),
            array('spec_name' => 'Kemasan', 'spec_value' => 'Box Karton Segel (600gr)'),
            array('spec_name' => 'Bahan Aktif', 'spec_value' => 'High-concentrate softener active agent, Premium fragrance, Microcapsule')
        )
    )
);

// ── 4. Process and Insert Products ───────────────────────────────────────
foreach ($products_to_insert as $p) {
    echo "\nProcessing product: '{$p['title']}'...\n";
    
    // Resolve Category
    $term = get_term_by('name', $p['category_name'], 'product_cat');
    if (!$term) {
        echo "  Category '{$p['category_name']}' not found, creating...\n";
        $new_term = wp_insert_term($p['category_name'], 'product_cat');
        if (is_wp_error($new_term)) {
            echo "  [Error] Failed to create category '{$p['category_name']}': " . $new_term->get_error_message() . "\n";
            continue;
        }
        $cat_id = $new_term['term_id'];
    } else {
        $cat_id = $term->term_id;
    }
    echo "  Category ID for '{$p['category_name']}' is $cat_id\n";
    
    // Build Content
    $content = build_product_content($p['desc'], $p['features'], $p['ingredients'], $p['directions']);
    $excerpt = mb_strimwidth($p['desc'], 0, 160, '...');
    
    // Check if product already exists by slug
    $existing = get_posts(array(
        'name' => $p['slug'],
        'post_type' => 'product',
        'post_status' => 'any',
        'numberposts' => 1
    ));
    
    if (!empty($existing)) {
        $post_id = $existing[0]->ID;
        echo "  Product already exists with ID: $post_id. Updating...\n";
        wp_update_post(array(
            'ID'           => $post_id,
            'post_title'   => $p['title'],
            'post_content' => $content,
            'post_excerpt' => $excerpt
        ));
    } else {
        // Double check by title
        $existing_by_title = get_page_by_title($p['title'], OBJECT, 'product');
        if ($existing_by_title) {
            $post_id = $existing_by_title->ID;
            echo "  Product already exists by title with ID: $post_id. Updating...\n";
            wp_update_post(array(
                'ID'           => $post_id,
                'post_name'    => $p['slug'],
                'post_content' => $content,
                'post_excerpt' => $excerpt
            ));
        } else {
            echo "  Inserting new product...\n";
            $post_id = wp_insert_post(array(
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'product',
                'post_content' => $content,
                'post_excerpt' => $excerpt
            ));
            
            if (is_wp_error($post_id)) {
                echo "  [Error] Failed to insert product: " . $post_id->get_error_message() . "\n";
                continue;
            }
        }
    }
    
    // Set SKU
    carbon_set_post_meta($post_id, 'product_sku', $p['sku']);
    echo "  SKU set to '{$p['sku']}'\n";
    
    // Set Category
    wp_set_object_terms($post_id, intval($cat_id), 'product_cat');
    echo "  Category terms set.\n";
    
    // Set Brand
    carbon_set_post_meta($post_id, 'product_brand', array(
        array('id' => $brand_id, 'type' => 'post', 'subtype' => '', 'value' => '')
    ));
    echo "  Brand set to Orchid Care (ID: $brand_id)\n";
    
    // Set Specifications
    carbon_set_post_meta($post_id, 'product_specifications', $p['specs']);
    echo "  Specifications set successfully.\n";
}

echo "\n=== All 5 products processed successfully! ===\n";
