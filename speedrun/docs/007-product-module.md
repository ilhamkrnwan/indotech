# 007: Product Module

Modul Produk mengelola data katalog B2B dan visualisasi produk secara responsif.

## 1. Registrasi Custom Fields (Carbon Fields)
Definisi field diletakkan pada `indotech-core` (`src/MetaFields.php`):
```php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Product Details')
    ->where('post_type', '=', 'product')
    ->add_fields([
        Field::make('text', 'product_sku', 'SKU / Kode Produk')
            ->set_required(true),
        Field::make('association', 'product_brand', 'Pilih Brand')
            ->set_types([[
                'type'      => 'post',
                'post_type' => 'brand'
            ]])
            ->set_max(1),
        Field::make('association', 'product_downloads', 'Dokumen Unduhan Terkait')
            ->set_types([[
                'type'      => 'post',
                'post_type' => 'attachment'
            ]])
            ->set_help_text('Relasikan file MSDS/TDS/Sertifikat ke produk ini'),
        Field::make('complex', 'product_specifications', 'Spesifikasi Produk (Tabel Key-Value)')
            ->add_fields([
                Field::make('text', 'spec_name', 'Nama Parameter (misal: Warna)'),
                Field::make('text', 'spec_value', 'Nilai Parameter (misal: Biru)')
            ])
    ]);
```

## 2. Relasi Banyak-ke-Banyak (Product ↔ Download)
Karena relasi ini bersifat Many-to-Many:
*   Di halaman detail **Produk**, daftar dokumen unduhan ditarik dengan memanggil array attachment ID dari metadata `product_downloads`.
*   Di halaman **Download Center**, jika ingin mengetahui produk apa saja yang berkaitan dengan suatu file dokumen PDF, kita menjalankan query postingan `product` yang memiliki data meta `product_downloads` mengandung Attachment ID bersangkutan.

## 3. Filter AJAX pada Katalog Produk (`archive-product.php`)
Katalog produk menyertakan filter kategori dan brand dinamis tanpa refresh halaman.
*   **HTML Filter UI**: Tombol filter berkelas `.filter-btn` dengan atribut data `data-brand-id` dan `data-cat-slug`.
*   **JS Ajax Trigger**: JavaScript mendeteksi klik pada filter button, mengumpulkan nilai filter, lalu mengirimkan request AJAX `POST` ke endpoint admin-ajax.php:
```javascript
let data = {
    action: 'indotech_filter_products',
    brand_id: activeBrandId,
    cat_slug: activeCatSlug,
    nonce: indotechData.nonce
};
jQuery.post(indotechData.ajaxUrl, data, function(response) {
    if (response.success) {
        jQuery('#products-grid').html(response.data.html);
    }
});
```
*   **PHP Handler**: Backend memproses query `WP_Query` berdasarkan filter yang dikirimkan, me-render loop produk kecil (partial template), lalu mengembalikan markup HTML ter-render dalam format JSON.
