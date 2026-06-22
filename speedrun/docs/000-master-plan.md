# 000: Master Plan - PT Indotech Berkah Abadi Rebuild

## 1. Visi Proyek
Membangun ulang website corporate PT Indotech Berkah Abadi ([indotech.id](https://indotech.id)) menjadi platform B2B berkinerja tinggi, ramah SEO, dan siap headless. Platform ini menyajikan portofolio korporat, katalog produk terpadu untuk 4 brand utama, serta solusi industri dan aplikasi layanan untuk menangkap peluang prospek (leads).

## 2. Pilar Utama Pengembangan
*   **Pemisahan Logika & Tampilan (Enterprise Standard)**: Logika bisnis dan data CPT dikelola oleh plugin core `indotech-core`, sedangkan penampilan visual ditangani oleh tema kustom `indotech_custom`.
*   **Performa & DOM Ringkas**: Tidak menggunakan heavy page builder (seperti Elementor/Oxygen). Seluruh halaman dibangun menggunakan native WordPress Gutenberg Editor.
*   **Lead Generation Efisien**: Sistem penawaran produk (Inquiry / RFQ) dibangun secara mandiri menggunakan formulir AJAX terhubung ke database SQL custom, tanpa menggunakan WooCommerce.
*   **Metadata Terstruktur**: Menggunakan library PHP-driven **Carbon Fields** untuk manajemen bidang data.
*   **Headless CMS Ready**: Kerangka database dirancang agar bisa dikonsumsi oleh Next.js/Nuxt.js via WP REST API di masa mendatang.

## 3. Struktur Navigasi & Sitemap
1.  **Beranda (Home)**: Landing page korporat utama.
2.  **Tentang Kami (About Us)**: Sejarah, visi, misi, legalitas, pabrik, sertifikasi (ISO, BPOM, Halal).
3.  **Brand Ekosistem (Brands Archive & Single)**: Portofolio 4 brand (Orchid Care, Depo Cleanique, Malabeez, Cokusi).
4.  **Katalog Produk (Products Archive & Single)**: Filter dinamis per brand dan kategori, detail SKU, datasheet, dan form penawaran.
5.  **Solusi Industri (Industries Archive & Single)**: Target industri B2B (misal: Solusi Rumah Sakit, Hotel).
6.  **Aplikasi Layanan (Applications Archive & Single)**: Landing page SEO kata kunci volume tinggi (Laundry Hotel, Cleaning Service).
7.  **Pusat Unduhan (Downloads Archive)**: Pendaftaran formulir untuk mengunduh MSDS, SDS, brosur.
8.  **Hubungi Kami (Contact)**: Alamat pabrik, Google Maps, WhatsApp Link.
