# 004: Theme Architecture

Tema kustom `indotech_custom` dirancang sebagai lapisan presentasi murni (*presentation layer*). Ia tidak mengandung logika registrasi CPT atau skema database leads, melainkan murni me-render data ke browser.

## 1. Hierarchy Template Files
Sesuai dengan standard WordPress, file rendering diletakkan di root tema:
*   `front-page.php`: Beranda utama korporasi, memanggil modul-modul dinamis di folder `template-parts/home/`.
*   `single-product.php`: Tampilan detail spesifikasi produk. Mengambil data post meta dari `indotech-core` (SKU, spesifikasi key-value, brand terkait) dan merendernya dengan visual Cobalt/Ink.
*   `archive-product.php`: Halaman etalase filter produk AJAX.
*   `single-brand.php`: Tampilan profil brand dan daftar produk yang terikat ke brand tersebut (menjalankan custom `WP_Query` mencari post tipe `product` yang memiliki relasi meta ke ID brand saat ini).
*   `single-application.php` & `single-industry.php`: Masing-masing bertindak sebagai landing page solusi industri dan solusi aplikasi SEO.

## 2. Struktur Modul Template Parts
Untuk menjaga keterbacaan kode (*maintainability*), visual dibagi secara modular ke dalam sub-folder `template-parts/`:
```
indotech_custom/
├── template-parts/
│   ├── home/
│   │   ├── hero.php
│   │   ├── stats.php
│   │   ├── brands.php
│   │   ├── services.php
│   │   └── testimonials.php
│   ├── common/
│   │   ├── breadcrumbs.php
│   │   └── cta-lead.php
│   └── product/
│       ├── gallery.php
│       ├── specs.php
│       └── inquiry-form.php
```

## 3. Override Gutenberg Editor Styles
Untuk menyelaraskan visual editor di admin dashboard dengan tampilan frontend, berkas stylesheet `assets/css/gutenberg-editor.css` dibuat dan di-load menggunakan hook berikut di `functions.php`:
```php
function indotech_editor_styles() {
    add_theme_support('editor-styles');
    add_editor_style('assets/css/gutenberg-editor.css');
}
add_action('after_setup_theme', 'indotech_editor_styles');
```
Berkas CSS ini mengatur ulang tampilan heading dan font di dalam editor Gutenberg agar identik dengan Space Grotesk & Inter pada frontend.
