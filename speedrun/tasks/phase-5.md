# Phase 5 Checklist: REST API & Headless CMS Readiness

- [x] **Registrasi Route API Custom - `indotech-core`**
    - [x] Daftarkan REST API namespace `indotech/v1` menggunakan hook `rest_api_init`.
    - [x] Buat custom endpoint `GET /wp-json/indotech/v1/brands`:
        - [x] Tampilkan daftar brand lengkap dengan data meta (logo URL, tagline, warna aksen, web link).
    - [x] Buat custom endpoint `GET /wp-json/indotech/v1/products`:
        - [x] Izinkan parameter query `?brand={id}` dan `?category={slug}`.
        - [x] Output list produk dengan format JSON terstruktur lengkap dengan relasi file downloads.

- [x] **Keamanan & CORS Setup**
    - [x] Tulis filter hook untuk membatasi origin request eksternal yang diizinkan memanggil API.
    - [x] Siapkan JWT validation untuk proses input data dari origin luar (jika diperlukan).

- [x] **Pengujian API**
    - [x] Lakukan verifikasi payload response menggunakan Postman / REST client untuk memastikan kesesuaian skema JSON.
