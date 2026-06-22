# 012: Testing Specifications

Dokumen ini mendefinisikan standar pengujian sistem sebelum perilisan ke server produksi.

## 1. Automated PHP Linting
Sebelum commit ke Git, kode plugin dan tema wajib diuji menggunakan **PHP_CodeSniffer** untuk memastikan compliance terhadap WordPress Coding Standards (WPCS):
```bash
phpcs --standard=WordPress wp-content/plugins/indotech-core/
phpcs --standard=WordPress wp-content/themes/indotech_custom/
```

## 2. Uji Integrasi Logika Bisnis (Theme Swap Test)
Untuk membuktikan bahwa pemisahan business logic dan visual berhasil:
1.  Aktifkan tema default **Twenty Twenty-Four** di lingkungan Staging.
2.  Buka admin dashboard WordPress.
3.  Pastikan menu "Inquiry", dan entitas data CPT (Brands, Products, Industries, Applications) tetap tampil utuh di dashboard.
4.  Kembalikan ke tema kustom `indotech_custom` dan verifikasi seluruh template ter-render normal kembali.

## 3. Uji Fungsionalitas Inquiry Form
Menguji pengiriman formulir penawaran pada detail produk:
*   **Honeypot Validation**: Mengirim form dengan field spam terisi, pastikan server merespon error/gagal.
*   **Database Record**: Kirim inquiry normal, periksa tabel `wp_indotech_inquiries` apakah data masuk secara akurat.
*   **SMTP Email Delivery**: Pastikan email notifikasi HTML dikirimkan secara instan ke admin dan pengirim.
