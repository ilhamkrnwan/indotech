# ADR-001: Plugin-Centric vs Theme-Centric Architecture

## Status
Approved

## Context
Dalam arsitektur WordPress tradisional, pendaftaran Custom Post Types (CPT), Taxonomies, dan pengolahan form sering diletakkan di dalam file `functions.php` tema. Namun, pendekatan ini memiliki kelemahan kritis: jika tema visual diganti atau didekorasi ulang di masa depan, struktur data bisnis (Brand, Product, Industry, Application) dan data leads/inquiry yang tersimpan akan hilang dari admin panel.

## Decision
Kami memutuskan untuk memisahkan seluruh logika bisnis dari visual dengan pendekatan **Plugin-Centric**:

1.  **Core Plugin (`indotech-core`)**:
    *   Mendaftarkan seluruh Custom Post Type: `brand`, `product`, `industry`, `application`.
    *   Mendaftarkan taksonomi kustom: `product_cat`, `download_category`.
    *   Membuat custom database table untuk data leads (`wp_indotech_inquiries`).
    *   Mendaftarkan API routes `/wp-json/indotech/v1/*`.
    *   Menghubungkan library metabox **Carbon Fields** untuk Custom Fields dan Global Settings Page.
2.  **Custom Theme (`indotech_custom`)**:
    *   Hanya berisi file visual (HTML markup, CSS grid, JavaScript frontend).
    *   Mengatur template rendering (`single-product.php`, `archive-brand.php`, dll.) dengan memanggil data CPT dari plugin.
    *   Tidak menyimpan data bisnis mentah.

## Consequences
*   **Kelebihan**: Data bisnis aman jika terjadi perubahan tema. Tema visual bisa dibangun ulang (misalnya migrasi ke FSE/Full Site Editing atau Headless Next.js) tanpa memengaruhi data CPT dan Leads.
*   **Kekurangan**: Membutuhkan pemeliharaan dua komponen (satu plugin dan satu tema), serta inisialisasi loading order plugin yang tepat sebelum tema aktif.
