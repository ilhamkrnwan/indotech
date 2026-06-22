# Phase 1 Checklist: Foundation

- [x] **Inisialisasi Plugin Core (`indotech-core`)**
    - [x] Buat berkas utama plugin: `wp-content/plugins/indotech-core/indotech-core.php`.
    - [x] Buat file `composer.json` di dalam plugin untuk memuat **Carbon Fields** sebagai dependency.
    - [x] Jalankan `composer install` untuk memuat autoload vendor.
    - [x] Buat autoloader kelas modular PHP agar berkas plugin teratur (menggunakan PSR-4 namespace `Indotech\Core`).

- [x] **Boilerplate Tema (`indotech_custom`)**
    - [x] Periksa dan rapikan berkas `style.css` untuk memastikan metadata tema sudah sesuai.
    - [x] Buat berkas konfigurasi Gutenberg `theme.json` di root tema:
        - [x] Batasi palette warna editor pada warna korporat Indotech (Cobalt `#0057FF`, Ink `#0A0F1E`, dll).
        - [x] Nonaktifkan custom font sizes dan batasi hanya pada font family Space Grotesk & Inter.
        - [x] Atur container widths (`--wp--style--global--content-size` dan `--wp--style--global--wide-size`).

- [x] **Asset Pipeline & Utilities**
    - [x] Hubungkan script JavaScript baru `assets/js/inquiry-ajax.js` di dalam fungsi enqueue `functions.php`.
    - [x] Inisialisasi asset localized data (`indotechData` object) dengan ajaxUrl & CSRF nonce.
    - [x] Siapkan berkas helper utility `inc/helpers.php` untuk fungsi sanitasi dan format angka WhatsApp.

- [x] **Coding Standards Setup**
    - [x] Tambahkan file konfigurasi linting `.phpcs.xml` (menggunakan aturan WordPress-Core).
