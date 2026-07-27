<?php
/**
 * Script Update Data Produk Berdasarkan REFERENCES.MD
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

echo "Memulai update data produk berdasarkan REFERENCES.MD...\n";

// Definisi aturan update per produk dari REFERENCES.MD
$updates = array(
    // 1. Softsense
    array(
        'search' => 'Softsense',
        'content' => 'Softsense adalah paket bahan softener pelembut pakaian konsentrat premium berukuran lebih besar. Dirancang khusus untuk efisiensi tinggi bagi pengusaha laundry maupun kebutuhan rumah tangga besar, satu kemasan Softsense dapat menghasilkan hingga 15 liter pelembut pakaian siap pakai berkualitas tinggi dengan keharuman microcapsule yang mewah.',
        'specs' => array(
            'Bentuk Fisik' => 'Paket bahan softener',
            'Kemasan' => 'Box Karton Segel'
        )
    ),
    // 2. Softa
    array(
        'search' => 'Softa',
        'replace_in_content' => array('bahan ' => '')
    ),
    // 3. Octa
    array(
        'search' => 'Octa',
        'new_title' => 'Octa - Paket Bahan Sabun Cuci Piring Pasta',
        'replace_in_content' => array('paket bahan' => 'paket biang'),
        'specs' => array(
            'Komposisi' => 'Surfactant, Fragrance, Colorant'
        )
    ),
    // 4. Oclean
    array(
        'search' => 'Oclean',
        'new_title' => 'Oclean - Paket Bahan Sabun Cuci Piring 15 liter',
        'content' => 'Oclean adalah paket bahan sabun cuci piring dengan formula khusus pembersih lemak (anti-grease) yang sangat efektif mengangkat kotoran, minyak, dan lemak membandel pada peralatan makan dan masak. Dirancang khusus untuk efisiensi tinggi bagi kebutuhan rumah tangga, pengusaha warung makan maupun restoran besar, satu kemasan oclean dapat menghasilkan hingga 15 liter sabun cuci piring. Aroma jeruk nipis yang segar membantu menghilangkan bau amis secara instan.',
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 15 liter)',
            'Bentuk Fisik' => 'Paket bahan sabun cuci piring',
            'Kemasan' => 'Box Karton Segel',
            'Bahan Aktif' => 'Active surfactant paste dan Foam booster',
            'Komposisi' => 'Active surfactant paste, Foam booster, Fragrance Lime, Pewarna'
        )
    ),
    // 5. Essenz
    array(
        'search' => 'Essenz',
        'new_title' => 'Essenz - Paket bahan parfum waterbase',
        'content' => 'EssenZ adalah formula paket bahan parfum berbasis air (waterbase) premium yang dirancang khusus untuk memberikan keharuman tahan lama pada pakaian tanpa meninggalkan noda kuning atau bercak minyak. Dilengkapi dengan teknologi micro-capsule aktif yang melepaskan aroma wangi secara perlahan saat pakaian mengalami gesekan, sehingga pakaian tetap wangi sepanjang hari.',
        'specs' => array(
            'Ukuran Tersedia' => 'Paket bahan (hasil 8 liter dan 15 liter)',
            'Bentuk Fisik' => 'Paket bahan essenz',
            'Kemasan' => 'Box Karton Segel'
        )
    ),
    // 6. Bibit Parfum & Wewangian
    array(
        'search' => 'Bibit Parfum',
        'specs' => array(
            'Bahan Aktif' => 'Fragrance compound'
        )
    ),
    // 7. Konsentrat Parfum Alkohol Base
    array(
        'search' => 'Konsentrat Parfum Alkohol Base',
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
        'content' => 'Biang Pelicin Setrika adalah paket biang pelicin setrika dengan formula hasil jadi 5 Liter untuk melembutkan serat kain dan mempermudah proses setrika pakaian. Memberikan aroma harum dan efek antikusut pada pakaian.',
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
        'content' => 'Biang Pel Lantai adalah paket biang pel lantai konsentrat dengan formula hasil jadi 5 Liter. Efektif mengangkat kotoran, membunuh kuman, serta memberikan keharuman tahan lama pada lantai ruangan Anda.',
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
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 450gr, 900gr',
            'Bentuk Fisik' => 'Serbuk',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'Solid Hydrogen Peroxide',
            'Komposisi' => 'Solid Hydrogen Peroxide'
        )
    ),
    // 13. Malabeez – Parfum Laundry Oriental Premium
    array(
        'search' => 'Malabeez',
        'content' => 'Malabeez – Parfum Laundry Oriental Premium adalah produk parfum berkualitas premium dari Indotech yang harumnya tahan lama untuk pakaian, karpet, peci maupun sajadah.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 6 ml, 250 ml, 800 ml, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol',
            'Bahan Aktif' => 'fragrance, aqua',
            'Komposisi' => 'fragrance, aqua'
        )
    ),
    // 14. Sleek – Cairan Setrika & Perawat Kain Waterbase
    array(
        'search' => 'Sleek',
        'content' => 'Sleek adalah cairan pelicin setrika waterbase premium yang merawat serat kain agar tetap licin, tidak mudah kusut, dan terlihat rapi profesional. Diformulasikan khusus untuk kebutuhan laundry komersial, binatu, dan hotel.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok untuk' => 'Kemeja, Jas, Linen Hotel',
            'Bahan Aktif' => 'Fragrance, micro parfum',
            'Komposisi' => 'Fragrance, micro parfum, aqua'
        )
    ),
    // 15. Shampoo Mobil – Car Wash Shampoo
    array(
        'search' => 'Shampoo Mobil',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'pH Formula' => 'Netral (pH 6.5–7.5)',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Fragrance, micro parfum'
        )
    ),
    // 16. Sabun Cuci Piring – Dish Soap Anti Lemak
    array(
        'search' => 'Sabun Cuci Piring',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster',
            'Komposisi' => 'Active surfactant agents, Foam booster, Fragrance segar jeruk/lemon'
        )
    ),
    // 17. Handwash
    array(
        'search' => 'Handwash',
        'content' => 'Hand wash adalah produk Sabun Cuci Tangan Cair dari Indotech yang higienitas dan perawatan kulitnya berkualitas premium serta dirancang secara khusus untuk menjaga kebersihan tangan Anda secara maksimal setelah melakukan berbagai aktivitas harian. Sabun cuci tangan ini efektif membersihkan kotoran, debu, dan sisa minyak yang menempel pada kulit tangan dengan lembut tanpa menimbulkan efek kering atau iritasi. Diperkaya dengan kandungan bahan pelembab dan aroma yang segar, produk ini memastikan tangan Anda tetap bersih, higienis, lembut, dan harum sepanjang hari.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 5 liter',
            'Bentuk Fisik' => 'Cairan kental',
            'Kemasan' => 'Jrigen',
            'Bahan Aktif' => 'Active surfactant agents, Foam booster'
        )
    ),
    // 18. Pembersih Kerak – Anti Scale & Descaler
    array(
        'search' => 'Pembersih Kerak',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 500 ml, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Cocok untuk' => 'Keran, Shower, Toilet, Bak Mandi',
            'Bahan Aktif' => 'Hydrofluoric acid, Oxalic acid',
            'Komposisi' => 'Hydrofluoric acid, Oxalic acid'
        )
    ),
    // 19. Prime+ – Parfum Laundry Premium Eksklusif
    array(
        'search' => 'Prime+',
        'content' => 'Prime+ adalah parfum laundry premium eksklusif dalam kemasan 1 dan 5 liter yang menghadirkan aroma mewah dan elegan untuk setiap cucian. Formula konsentrat tinggi memberikan keharuman kuat dan tahan lama yang terasa pada pakaian seharian.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter'
        )
    ),
    // 20. Pelmos – Cairan Pel Lantai Wangi
    array(
        'search' => 'Pelmos',
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
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance, Anti Fungi Agent',
            'Komposisi' => 'Fragrance, Anti Fungi Agent'
        )
    ),
    // 22. Parfum SUP – Pewangi Laundry Super Series
    array(
        'search' => 'Parfum SUP',
        'specs' => array(
            'Varian' => 'SUP A, SUP B',
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer',
            'Komposisi' => 'Fragrance solubilizer, fixative stabilizer, aqua'
        )
    ),
    // 23. Parfum Karpet – Pewangi Khusus Karpet & Tekstil
    array(
        'search' => 'Parfum Karpet',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter, 5 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Fungsi' => 'Pewangi Karpet & Tekstil',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer',
            'Komposisi' => 'Fragrance solubilizer, fixative stabilizer, aqua'
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
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1 liter',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Jrigen',
            'Keunggulan' => 'Aman Warna dan Ramah Lingkungan',
            'Bahan Aktif' => 'Fragrance solubilizer, fixative stabilizer',
            'Komposisi' => 'Solid Hydrogen Peroxide'
        )
    ),
    // 26. Nauki Deterjen Khusus Batik Buah Lerak Premium
    array(
        'search' => 'Nauki',
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
        'content' => 'Karbol adalah cairan pembersih lantai dan disinfektan berbasis Pine Oil dengan aroma cemara pinus dan sereh yang menyegarkan. Membunuh kuman dan bakteri, menghilangkan bau tidak sedap, serta membersihkan lantai dari kotoran dan debu.',
        'specs' => array(
            'Ukuran Tersedia' => 'Default, 1,5 liter, 5 liter',
            'Aroma' => 'Pinus Cemara dan sereh',
            'Bentuk Fisik' => 'Cairan',
            'Kemasan' => 'Botol dan Jrigen',
            'Fungsi' => 'Disinfektan & Pembersih Lantai',
            'Komposisi' => 'Pine Oil murni, Citrunella, Surfaktan emulsifier, Disinfektan aktif pembunuh kuman'
        )
    )
);

$updated_count = 0;

foreach ($updates as $rule) {
    // Cari produk berdasarkan judul
    $args = array(
        'post_type'   => 'product',
        's'           => $rule['search'],
        'post_status' => 'any',
        'numberposts' => 1
    );
    $found = get_posts($args);

    if (empty($found)) {
        echo "[SKIP] Produk tidak ditemukan untuk query: {$rule['search']}\n";
        continue;
    }

    $post = $found[0];
    $post_data = array('ID' => $post->ID);
    $is_post_changed = false;

    // Update Title jika ada
    if (!empty($rule['new_title'])) {
        $post_data['post_title'] = $rule['new_title'];
        $is_post_changed = true;
    }

    // Update Content jika ada
    if (!empty($rule['content'])) {
        $post_data['post_content'] = $rule['content'];
        $is_post_changed = true;
    } elseif (!empty($rule['replace_in_content']) && is_array($rule['replace_in_content'])) {
        $current_content = $post->post_content;
        foreach ($rule['replace_in_content'] as $from => $to) {
            $current_content = str_replace($from, $to, $current_content);
        }
        $post_data['post_content'] = $current_content;
        $is_post_changed = true;
    }

    if ($is_post_changed) {
        wp_update_post($post_data);
    }

    // Update Spesifikasi (Carbon Fields meta)
    if (!empty($rule['specs']) && is_array($rule['specs'])) {
        // High level Carbon Fields postmeta format
        // Key: _product_specifications|spec_name|0|0|value & _product_specifications|spec_value|0|0|value
        // Atau array meta standar _product_specifications
        $existing_specs = get_post_meta($post->ID, '_product_specifications', true);
        if (!is_array($existing_specs)) {
            $existing_specs = array();
        }

        // Convert key-value
        $spec_map = array();
        foreach ($existing_specs as $item) {
            if (isset($item['spec_name']) && isset($item['spec_value'])) {
                $spec_map[$item['spec_name']] = $item['spec_value'];
            }
        }

        // Merge updates
        foreach ($rule['specs'] as $spec_k => $spec_v) {
            $spec_map[$spec_k] = $spec_v;
        }

        // Rebuild complex array
        $new_specs = array();
        foreach ($spec_map as $sk => $sv) {
            $new_specs[] = array(
                '_type'      => 'product_specifications',
                'spec_name'  => $sk,
                'spec_value' => $sv,
            );
        }

        update_post_meta($post->ID, '_product_specifications', $new_specs);
    }

    $updated_count++;
    echo "[$updated_count] BERHASIL UPDATE: {$post->post_title} (ID: {$post->ID})\n";
}

echo "\nSELESAI: Total $updated_count produk berhasil diperbarui berdasarkan REFERENCES.MD!\n";
