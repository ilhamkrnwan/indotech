# 013: Deployment Guide

Panduan langkah demi langkah memindahkan platform ke server production.

## 1. Persiapan Server Lingkungan Staging/Production
*   Pastikan server menggunakan PHP versi **8.1** atau **8.2**.
*   Aktifkan ekstensi PHP yang diperlukan oleh WordPress (seperti `curl`, `mbstring`, `imagick`, `mysqli`, `zip`).
*   Instal **Composer** secara global di server atau siapkan build script pipeline.

## 2. Prosedur Rilis Menggunakan Git
1.  Push seluruh perubahan (core plugin & theme) ke repository Git utama (`main` branch).
2.  Di server, jalankan clone/pull pada folder plugins & themes:
```bash
cd wp-content/plugins/
git pull origin main
cd ../themes/
git pull origin main
```
3.  Jalankan instalasi dependensi composer pada plugin core:
```bash
cd wp-content/plugins/indotech-core/
composer install --no-dev --optimize-autoloader
```

## 3. Checklist Pasca Rilis (Post-Deployment)
*   **Aktivasi Core Plugin**: Masuk ke WP Admin -> Plugins, aktifkan plugin `Indotech Core` (ini akan men-trigger pembentukan tabel database `wp_indotech_inquiries`).
*   **Penyelarasan Permalink**: Masuk ke WP Admin -> Settings -> Permalinks, lalu klik tombol **Save Changes** dua kali. Ini akan membersihkan kueri routing URL sehingga CPT rewrite rules aktif sempurna.
*   **Audit SSL & HTTPS**: Pastikan seluruh tautan media absolut menggunakan protokol HTTPS yang valid.
*   **SMTP Configuration**: Hubungkan modul SMTP menggunakan Google Workspace atau server SMTP profesional dan kirim email uji coba untuk memastikan flow leads aktif.
