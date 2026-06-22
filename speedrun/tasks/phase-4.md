# Phase 4 Checklist: SEO & Lead Generation System

- [x] **Sistem Inquiry Prospek (Core Engine) - `indotech-core`**
    - [x] Tulis logika pembuatan tabel `wp_indotech_inquiries` saat aktivasi plugin.
    - [x] Daftarkan AJAX endpoint `wp_ajax_submit_inquiry` dan `wp_ajax_nopriv_submit_inquiry`.
    - [x] Implementasikan validasi input di backend (sanitasi teks, validasi email, validasi nomor wa).
    - [x] Buat pengamanan spam menggunakan *Honeypot field* dan Google reCAPTCHA v3.
    - [x] Implementasikan integrasi email SMTP menggunakan `wp_mail()` dengan format email HTML.

- [x] **Admin Dashboard Module - `indotech-core`**
    - [x] Buat menu dashboard baru "Inquiry" menggunakan `add_menu_page`.
    - [x] Tulis rendering tabel inquiry dengan list filter status.
    - [x] Tambahkan tombol "Export to CSV" untuk kemudahan integrasi manual.

- [x] **Integrasi SEO & Schema Markup**
    - [x] Tambahkan JSON-LD Schema untuk B2B Product di `single-product.php` (menampilkan SKU, nama, produsen PT Indotech Berkah Abadi, deskripsi, dan link brosur).
    - [x] Konfigurasi meta tag robot canonical link otomatis pada single pages.
