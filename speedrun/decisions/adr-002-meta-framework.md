# ADR-002: Pemilihan Meta Fields Framework

## Status
Approved

## Context
PT Indotech Berkah Abadi memerlukan pengelolaan metadata yang kompleks:
*   Menghubungkan Produk ke Brand (Relasi Many-to-One).
*   Menghubungkan Produk ke Media PDF (Relasi Many-to-Many).
*   Menyimpan Spesifikasi Teknis dinamis (Key-Value Repeater).
*   Halaman Pengaturan Global Site Settings.

Kami mengevaluasi tiga opsi:
1.  **ACF Pro**: Sangat ramah GUI, tapi berbayar, menyimpan definisi bidang di database (sulit untuk Git workflow developer), dan melakukan query database berlebih.
2.  **Carbon Fields**: Gratis, open-source, konfigurasi 100% menggunakan kode PHP (bisa disimpan di Git repository), query database sangat bersih, dan mendukung field relasi (*association*) secara efisien.
3.  **Native register_meta**: Zero-dependency, performa tercepat, namun membutuhkan penulisan UI React/Gutenberg secara manual untuk field kompleks (seperti relasi many-to-many atau repeater), yang meningkatkan waktu pengembangan secara signifikan.

## Decision
Kami memutuskan untuk menggunakan **Carbon Fields** sebagai kerangka kerja meta fields utama:
*   Carbon Fields akan di-load sebagai library Composer vendor di dalam core plugin `indotech-core`.
*   Semua definisi bidang (seperti SKU, relasi brand, file MSDS) akan ditulis menggunakan PHP dan di-version control.
*   Untuk data metadata yang sangat ringan dan performa krusial, native `register_meta` tetap digunakan jika diperlukan.

## Consequences
*   **Kelebihan**: Definisi metadata sinkron antar-developer karena berbentuk file PHP di repositori Git. Database bersih dari ribuan baris konfigurasi ACF.
*   **Kekurangan**: Editor konten tidak bisa mengubah letak bidang atau tipe data dari panel WP Admin (perubahan struktur field wajib melalui modifikasi kode PHP).
