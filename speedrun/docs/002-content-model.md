# 002: Content Model

Dokumen ini mendefinisikan skema data terstruktur untuk seluruh entitas bisnis di PT Indotech Berkah Abadi.

## 1. Custom Post Types & Custom Taxonomies

### 1.1. Brand (`brand`)
Menyimpan data entitas brand korporat.
*   **Taxonomy**: Tidak ada.
*   **Carbon Fields**:
    *   `brand_tagline` (Text) - Slogan promosi brand.
    *   `brand_accent_color` (Color) - Warna aksen HEX khusus brand untuk styling frontend.
    *   `brand_website_url` (URL) - Link external jika brand memiliki situs terpisah.
    *   `brand_gallery` (Media Gallery) - Gambar-gambar pendukung brand.

### 1.2. Product (`product`)
Katalog spesifikasi produk non-transaksional.
*   **Taxonomy**: Kategori Produk (`product_cat`).
*   **Carbon Fields**:
    *   `product_sku` (Text) - Kode unit produk (wajib diisi).
    *   `product_brand` (Post Object / Association) - Merujuk ke satu CPT Brand (Many-to-One).
    *   `product_downloads` (Association) - Merujuk ke banyak media attachment PDF di Media Library (Many-to-Many).
    *   `product_specifications` (Complex / Repeater) - Tabel spesifikasi dinamis (Key-Value):
        *   `spec_name` (Text) - Nama spesifikasi (misal: "pH", "Aroma").
        *   `spec_value` (Text) - Nilai spesifikasi (misal: "7.0 (Netral)", "Lavender Premium").

### 1.3. Industry (`industry`)
Target industri penggunaan produk.
*   **Taxonomy**: Tidak ada.
*   **Carbon Fields**:
    *   `industry_icon` (Text) - Nama icon SVG untuk ilustrasi.
    *   `industry_tagline` (Text) - Ringkasan solusi industri.

### 1.4. Application (`application`)
Landing page target SEO kata kunci layanan B2B.
*   **Taxonomy**: Tidak ada.
*   **Carbon Fields**:
    *   `app_tagline` (Text) - Proposisi solusi B2B.
    *   `app_related_products` (Association) - Menyimpan array Product CPT IDs yang relevan dengan aplikasi ini.

## 2. Resource Library (Media Library)
Dokumen unduhan dikelola di dalam **Media Library** standar.
*   **Taxonomy**: Kategori Unduhan (`download_category`) yang terikat pada tipe data `attachment`.
*   **Custom Meta (via register_meta)**:
    *   `download_gate_active` (Boolean) - Menentukan apakah form leads wajib diisi sebelum file didownload.
    *   `download_counter` (Integer) - Jumlah unduhan.
