# Phase 2 Checklist: Content Model

- [x] **Registrasi Custom Post Type (CPT) - `indotech-core`**
    - [x] Daftarkan CPT `brand` (dengan slug `/brands/` dan REST API diaktifkan).
    - [x] Daftarkan CPT `product` (dengan slug `/products/` dan REST API diaktifkan).
    - [x] Daftarkan CPT `industry` (dengan slug `/industries/` dan REST API diaktifkan).
    - [x] Daftarkan CPT `application` (dengan slug `/applications/` dan REST API diaktifkan).

- [x] **Registrasi Custom Taxonomy - `indotech-core`**
    - [x] Daftarkan taksonomi `product_cat` (kategori produk) berelasi ke CPT `product`.
    - [x] Daftarkan taksonomi `download_category` berelasi ke Media Library (`attachment`).

- [x] **Integrasi Carbon Fields (PHP Definitions) - `indotech-core`**
    - [x] Daftarkan Custom Fields untuk CPT `brand` (tagline, warna aksen, URL eksternal).
    - [x] Daftarkan Custom Fields untuk CPT `product` (SKU, spesifikasi key-value repeater, dan relasi post object `product_brand` & array `product_downloads`).
    - [x] Daftarkan Custom Fields untuk Media Attachment (kategori unduhan via taxonomy, toggle `download_gate_active`, counter).
    - [x] Daftarkan Options Page untuk **Site Settings** (kontak, sosial media, company profile PDF).

- [x] **Seeding Dummy Data**
    - [x] Masukkan data 4 Brand unggulan (*Orchid Care, Depo Cleanique, Malabeez, Cokusi*).
    - [x] Masukkan 5 produk contoh dengan file PDF MSDS terikat di Media Library.
    - [x] Hubungkan produk ke brand masing-masing.
