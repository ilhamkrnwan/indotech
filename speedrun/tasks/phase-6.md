# Phase 6 Checklist: Optimization & Go-Live

- [x] **Optimasi Performa**
    - [x] Terapkan caching kueri SQL menggunakan **Transient API** WordPress untuk query brand list, product categories, dan settings yang statis.
    - [x] Lakukan audit Google Lighthouse (Target skor: Desktop 95+, Mobile 90+).
    - [x] Pastikan seluruh gambar dimuat dalam format modern (WebP/Avif) dan menerapkan native lazy loading.
    - [x] Uji coba CSS & JS minification untuk meminimalkan blocking time.

- [x] **Uji Coba Keamanan**
    - [x] Blokir akses langsung ke folder `/uploads/` untuk file sensitif (.pdf/MSDS) jika download gate aktif.
    - [x] Pastikan sanitasi dan esc fungsi (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`) diterapkan di semua template visual.

- [x] **Deployment Checklist**
    - [x] Backup database database production saat ini.
    - [x] Aktifkan plugin `indotech-core` di lingkungan production.
    - [x] Aktifkan tema kustom `indotech_custom`.
    - [x] Jalankan regenerasi permalink WordPress untuk memastikan rewrite rule CPT terbaca sempurna.
