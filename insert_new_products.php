<?php
/**
 * Script Insert Produk Baru: KitClean & SHABIL
 * 
 * Penggunaan via CLI pada VPS / Lokal:
 * php insert_new_products.php
 */

if (php_sapi_name() !== 'cli') {
    die("Script ini hanya dapat dijalankan melalui CLI.\n");
}

define('WP_USE_THEMES', false);
$wp_load = __DIR__ . '/wp-load.php';

if (!file_exists($wp_load)) {
    die("ERROR: File wp-load.php tidak ditemukan di " . __DIR__ . "\n");
}

require_once $wp_load;

// Nonaktifkan filter kses dan set user admin agar HTML tidak difilter/dibersihkan oleh WP
if (function_exists('kses_remove_filters')) {
    kses_remove_filters();
}
if (function_exists('wp_set_current_user')) {
    wp_set_current_user(1);
}

echo "=======================================================\n";
echo "  MEMULAI PROSES INSERT / UPDATE PRODUK NEW INDOTECH   \n";
echo "=======================================================\n\n";

// Definisi Data Produk Baru
$new_products = array(
    // 1. KitClean
    array(
        'title'     => 'KitClean – Pembersih Dapur & Meja Makan',
        'slug'      => 'kitclean-pembersih-dapur-meja-makan',
        'sku'        => 'PK-KTC',
        'cat_slug'  => 'homecare-surface-cleaner',
        'cat_name'  => 'Homecare & Surface Cleaner',
        'excerpt'   => 'KitClean Pembersih Dapur & Meja Makan adalah cairan pembersih multifungsi yang diformulasikan untuk mengangkat minyak, lemak, noda makanan, dan kotoran membandel. Membuat area dapur dan meja makan lebih bersih, higienis, dan mengilap tanpa rasa lengket.',
        'content'   => '<h3>Deskripsi Produk</h3>
<p>Pembersih Dapur & Meja Makan adalah cairan pembersih multifungsi yang diformulasikan untuk membantu mengangkat minyak, lemak, noda makanan, dan kotoran membandel pada berbagai permukaan dapur. Dengan aroma yang segar dan tidak menyengat, produk ini membuat dapur dan area makan terasa lebih bersih, higienis, dan nyaman digunakan setiap hari. Cocok digunakan untuk membersihkan meja makan, kitchen set, kompor, backsplash, kabinet dapur, wastafel, keramik dinding dapur, kulkas bagian luar, microwave bagian luar, hingga berbagai permukaan yang sering terkena cipratan minyak dan sisa makanan. Formula efektif ini membantu membersihkan tanpa meninggalkan rasa lengket sehingga permukaan tampak bersih dan mengilap.</p>

<h3>Fungsi Utama</h3>
<p>Untuk membersihkan, menghilangkan lemak, menjaga kebersihan, serta membantu mengurangi pertumbuhan bakteri pada permukaan yang sering digunakan untuk mengolah dan menyajikan makanan.</p>

<h3>Fitur &amp; Keunggulan</h3>
<ul>
  <li><strong>Formula Konsentrat Premium:</strong> Dirancang dengan bahan aktif berkualitas untuk membersihkan semua area dapur.</li>
  <li><strong>Wangi Segar &amp; Tahan Lama:</strong> Memberikan keharuman khas produk Indotech yang elegan dan tahan lama.</li>
  <li><strong>Mudah Diaplikasikan:</strong> Cukup disemprotkan dan dilap untuk melarutkan kotoran dengan cepat.</li>
</ul>

<h3>Manfaat bagi Pengguna</h3>
<ul>
  <li>Dapur tampak lebih bersih dan higienis.</li>
  <li>Mempermudah membersihkan noda minyak sehari-hari.</li>
  <li>Menghemat waktu karena lemak lebih cepat terangkat.</li>
  <li>Mengurangi bau tidak sedap.</li>
  <li>Membuat aktivitas memasak lebih nyaman.</li>
</ul>

<h3>Karakteristik Produk</h3>
<ul>
  <li><strong>Bentuk Fisik:</strong> Cair</li>
  <li><strong>Warna Produk:</strong> Bening</li>
  <li><strong>Tekstur:</strong> Tidak lengket</li>
  <li><strong>Varian Aroma:</strong> Lemon Fresh (Segar)</li>
  <li><strong>Busa:</strong> Busa rendah</li>
  <li><strong>Pengeringan:</strong> Cepat mengering</li>
</ul>

<h3>Komposisi Bahan</h3>
<ul>
  <li>Solvent 2%</li>
  <li>Surfaktan 2%</li>
</ul>

<h3>Cara Penggunaan</h3>
<ol>
  <li>Semprotkan KitClean ke area yang ingin dibersihkan.</li>
  <li>Diamkan beberapa detik.</li>
  <li>Usap area yang sudah disemprot untuk membersihkan noda.</li>
  <li>Lap dengan kain yang kering supaya tidak meninggalkan bercak.</li>
  <li>Untuk noda berat bisa ulangi langkah yang sama.</li>
</ol>

<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>
<ul>
  <li>Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).</li>
  <li>Hindari paparan sinar matahari langsung dan area lembap.</li>
  <li>Jauhkan dari jangkauan anak-anak dan hewan peliharaan.</li>
  <li>Jika terkena mata, bilas segera dengan air mengalir selama 15 menit dan hubungi dokter jika iritasi berlanjut.</li>
</ul>',
        'specs' => array(
            'Ukuran Tersedia' => '250 ml, 1 liter, 5 liter',
            'Bentuk Fisik'    => 'Cair (Bening)',
            'Warna Produk'    => 'Bening',
            'Varian Aroma'    => 'Lemon Fresh',
            'Kemasan'         => 'Botol Spray / Jrigen',
            'Bahan Aktif'     => 'Solvent 2%, Surfaktan 2%',
            'Fungsi'          => 'Pembersih Dapur & Meja Makan, Pengangkat Lemak',
            'Izin Edar'       => 'Disamakan seperti Glass Cleaner (Pembersih Permukaan)'
        )
    ),

    // 2. SHABIL
    array(
        'title'     => 'SHABIL – Biang Shampo Mobil',
        'slug'      => 'shabil-biang-shampo-mobil',
        'sku'        => 'PK-SBL',
        'cat_slug'  => 'biang-pembersih-konsentrat',
        'cat_name'  => 'Biang Pembersih Konsentrat',
        'excerpt'   => 'SHABIL Biang Shampo Mobil adalah paket bahan setengah jadi shampo mobil berkualitas tinggi yang dirancang untuk menghasilkan 5 liter shampo mobil berbusa melimpah, berdaya bersih maksimal, dan aman untuk cat kendaraan dengan biaya lebih hemat.',
        'content'   => '<h3>Deskripsi Produk</h3>
<p>Biang Shampo Mobil adalah paket bahan setengah jadi shampo mobil berkualitas tinggi yang dirancang untuk menghasilkan shampo mobil dengan busa melimpah, daya bersih maksimal, dan tetap aman untuk berbagai jenis cat kendaraan. Cukup hanya ditambahkan air sesuai petunjuk dapat menghasilkan shampo mobil yang siap digunakan dengan biaya lebih hemat. Produk ini efektif mengangkat debu, lumpur, minyak ringan, bekas hujan, dan kotoran harian tanpa membuat permukaan kendaraan menjadi kusam. Formula menghasilkan busa lembut yang membantu mengurangi gesekan saat proses pencucian sehingga meminimalkan risiko baret halus pada cat kendaraan.</p>

<h3>Fungsi Utama</h3>
<p>Untuk membersihkan debu, lumpur, pasir, dan kotoran yang menempel pada permukaan kendaraan serta untuk menghilangkan bekas minyak, solar, asap kendaraan, dan residu jalan tanpa merusak cat.</p>

<h3>Fitur &amp; Keunggulan</h3>
<ul>
  <li><strong>Membersihkan Secara Maksimal:</strong> Mengangkat debu, lumpur, minyak ringan, bekas hujan, dan kotoran harian dengan mudah.</li>
  <li><strong>Busa Melimpah:</strong> Menghasilkan busa yang banyak dan stabil sehingga membantu melumasi permukaan kendaraan saat dicuci.</li>
  <li><strong>Aroma Segar:</strong> Memberikan sensasi bersih dengan aroma Strawberry yang nyaman selama dan setelah proses pencucian.</li>
</ul>

<h3>Cocok Digunakan Untuk</h3>
<ul>
  <li>Mobil pribadi</li>
  <li>Motor</li>
  <li>Kendaraan niaga</li>
  <li>Bengkel detailing</li>
  <li>Salon mobil</li>
  <li>Usaha cuci mobil dan motor</li>
</ul>

<h3>Komposisi Bahan</h3>
<ul>
  <li>Surfaktan</li>
  <li>Foam booster</li>
  <li>Fragrance</li>
</ul>

<h3>Cara Penggunaan</h3>
<ol>
  <li>Siapkan wadah bersih ukuran minimal 5-6 Liter dan air bersih sebanyak 4.5 Liter.</li>
  <li>Masukkan pasta Shabil ke dalam wadah.</li>
  <li>Tambahkan air yang sudah disiapkan secara bertahap.</li>
  <li>Aduk perlahan hingga pasta larut sepenuhnya.</li>
  <li>Pastikan semua air dan pasta larut sempurna, lalu diamkan larutan selama 12-24 jam hingga busa mereda sempurna sebelum digunakan atau dikemas.</li>
</ol>

<h3>Petunjuk Keamanan &amp; Penyimpanan</h3>
<ul>
  <li>Simpan di wadah tertutup rapat pada suhu ruangan (20–30°C).</li>
  <li>Hindari paparan sinar matahari langsung dan area lembap.</li>
  <li>Jauhkan dari jangkauan anak-anak dan hewan peliharaan.</li>
  <li>Jika terkena mata, bilas segera dengan air mengalir selama 15 menit dan hubungi dokter jika iritasi berlanjut.</li>
</ul>',
        'specs' => array(
            'Ukuran Tersedia' => 'Paket biang (hasil jadi 5 liter)',
            'Bentuk Fisik'    => 'Pasta',
            'Warna Produk'    => 'Merah',
            'Varian Aroma'    => 'Strawberry',
            'Kemasan'         => 'Box Karton Segel',
            'Bahan Aktif'     => 'Surfaktan, Foam booster, Fragrance',
            'Fungsi'          => 'Shampo Mobil & Motor Konsentrat',
            'Izin Edar'       => 'Disamakan seperti Octa dan Detta (Biang Pembersih Konsentrat)'
        )
    )
);

$success_count = 0;

foreach ($new_products as $item) {
    echo "Processing: {$item['title']}...\n";

    // 1. Cari apakah produk sudah ada sebelumnya (berdasarkan slug atau title)
    $existing = get_page_by_path($item['slug'], OBJECT, 'product');
    if (!$existing) {
        $found_posts = get_posts(array(
            'title'       => $item['title'],
            'post_type'   => 'product',
            'post_status' => 'any',
            'numberposts' => 1
        ));
        if (!empty($found_posts)) {
            $existing = $found_posts[0];
        }
    }

    $post_data = array(
        'post_title'   => $item['title'],
        'post_name'    => $item['slug'],
        'post_content' => $item['content'],
        'post_excerpt' => $item['excerpt'],
        'post_status'  => 'publish',
        'post_type'    => 'product',
    );

    if ($existing) {
        $post_data['ID'] = $existing->ID;
        $product_id = wp_update_post($post_data);
        $action = "UPDATE";
    } else {
        $product_id = wp_insert_post($post_data);
        $action = "INSERT (NEW)";
    }

    if (is_wp_error($product_id)) {
        echo "[ERROR] Gagal memproses produk {$item['title']}: " . $product_id->get_error_message() . "\n\n";
        continue;
    }

    // 2. Set Meta SKU (Carbon Fields & Postmeta)
    if (!empty($item['sku'])) {
        update_post_meta($product_id, '_product_sku', $item['sku']);
        if (function_exists('carbon_set_post_meta')) {
            carbon_set_post_meta($product_id, 'product_sku', $item['sku']);
        }
    }

    // 3. Set Meta Spesifikasi (Carbon Fields product_specifications)
    if (!empty($item['specs']) && is_array($item['specs'])) {
        $new_specs = array();
        foreach ($item['specs'] as $sk => $sv) {
            $new_specs[] = array(
                'spec_name'  => $sk,
                'spec_value' => $sv,
            );
        }

        if (function_exists('carbon_set_post_meta')) {
            carbon_set_post_meta($product_id, 'product_specifications', $new_specs);
        } else {
            global $wpdb;
            $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND (meta_key = '_product_specifications' OR meta_key LIKE '_product_specifications|%%')", $product_id));
            $formatted = array();
            foreach ($new_specs as $ns) {
                $formatted[] = array(
                    '_type'      => '_',
                    'spec_name'  => $ns['spec_name'],
                    'spec_value' => $ns['spec_value'],
                );
            }
            update_post_meta($product_id, '_product_specifications', $formatted);
        }
    }

    // 4. Assign Taxonomy Term Category (product_cat)
    if (!empty($item['cat_slug'])) {
        $term = get_term_by('slug', $item['cat_slug'], 'product_cat');
        if (!$term && !empty($item['cat_name'])) {
            $inserted_term = wp_insert_term($item['cat_name'], 'product_cat', array('slug' => $item['cat_slug']));
            if (!is_wp_error($inserted_term)) {
                $term_id = $inserted_term['term_id'];
            }
        } elseif ($term) {
            $term_id = $term->term_id;
        }

        if (!empty($term_id)) {
            wp_set_object_terms($product_id, array((int)$term_id), 'product_cat');
        } else {
            wp_set_object_terms($product_id, array($item['cat_slug']), 'product_cat');
        }
    }

    $success_count++;
    echo "[SUCCESS] {$action} Berhasil! ID: {$product_id} | Title: {$item['title']} | SKU: {$item['sku']}\n\n";
}

echo "=======================================================\n";
echo "  SELESAI: Total {$success_count} produk berhasil ditambahkan/diperbarui.\n";
echo "=======================================================\n";
