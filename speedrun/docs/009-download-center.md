# 009: Download Center

Modul Pusat Unduhan didesain ramah database tanpa membuat CPT tambahan yang memicu ribuan baris baris data baru.

## 1. Integrasi Media Library & Taksonomi Unduhan
Kami meregistrasikan Custom Taxonomy `download_category` yang ditempelkan ke objek `attachment` (Media Library) di plugin `indotech-core` (`src/Taxonomies.php`):
```php
register_taxonomy('download_category', 'attachment', [
    'labels'       => [
        'name'          => 'Kategori Unduhan',
        'singular_name' => 'Kategori Unduhan'
    ],
    'hierarchical' => false,
    'show_in_rest' => true
]);
```
Dengan demikian, admin dapat masuk ke Media Library WordPress, mengklik satu file PDF katalog, dan menandainya sebagai "Safety Data Sheet (SDS)" atau "Katalog Produk".

## 2. Pintu Unduhan (Download Gating Workflow)
Untuk mengunduh dokumen yang memiliki tanda metadata `download_gate_active` setingkat `true`:
1.  **Gated UI**: Tombol download tidak langsung mengarah ke tautan file PDF absolut, melainkan membuka modal pop-up "Formulir Unduhan".
2.  **Lead Collection**: Pengguna mengisi formulir singkat (Nama, Email, Perusahaan).
3.  **AJAX Validation**: Backend mencatat data user ke database (opsional) atau memicu log counter unduhan (`download_counter`), kemudian mengembalikan link download unik atau memicu download langsung di browser via JavaScript.
4.  **Cookie Session**: Menyetel cookie browser jangka pendek (misalnya 7 hari) agar setelah mengisi formulir sekali, pengguna bebas mengunduh PDF lain di website tanpa perlu mengisi form berulang kali.
