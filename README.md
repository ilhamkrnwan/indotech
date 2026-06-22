# Indotech — WordPress

Situs WordPress untuk **Indotech**, berupa *landing page* perusahaan yang dibangun di atas tema kustom **Indotech Custom**. Tema ini dibuat dari nol sebagai pondasi migrasi dari landing page statis ke WordPress, dengan struktur section yang modular dan data global yang dapat diatur lewat Customizer.

## Teknologi

- **WordPress** (struktur core standar di root proyek)
- **PHP** 8.3+ (minimum 7.4)
- **MySQL** 5.5.5+ / MariaDB
- **Tema kustom** — `indotech-custom`
- **Tailwind CSS** (via CDN, sementara untuk testing) + CSS kustom
- **Google Fonts** — Plus Jakarta Sans
- Lingkungan pengembangan lokal: **Laragon** (`c:\laragon\www\indotech`)

## Struktur Proyek

```
wordpress/
├── wp-admin/                 # Core WordPress (admin)
├── wp-includes/              # Core WordPress
├── wp-content/
│   ├── plugins/              # Akismet, Hello Dolly
│   ├── uploads/              # Media yang diunggah
│   └── themes/
│       ├── indotech-custom/   # ◄ Tema utama proyek
│       ├── twentytwentyfive/       # Tema bawaan (fallback)
│       ├── twentytwentyfour/
│       └── twentytwentythree/
├── wp-config.php             # Konfigurasi (DB, prefix, debug)
└── README.md
```

### Anatomi Tema `indotech-custom`

```
indotech-custom/
├── style.css                 # Header tema & info
├── functions.php             # Setup tema, enqueue aset, nav menu
├── front-page.php            # Titik masuk landing page (merangkai semua section)
├── header.php / footer.php
├── index.php / page.php
├── page-kontak.php           # Template halaman Kontak
├── page-tentang-kami.php     # Template halaman Tentang Kami
├── assets/
│   ├── css/main.css
│   └── js/main.js
├── inc/
│   ├── customizer.php        # Registrasi panel Customizer "Indotech"
│   └── helpers.php           # Fungsi ambil data global (dc_get_*)
└── template-parts/
    ├── layout/               # site-header, site-footer, floating-tools
    └── sections/             # hero, pricing, faq, dll.
```

## Komposisi Landing Page

Halaman depan ([front-page.php](wp-content/themes/indotech-custom/front-page.php)) merangkai section berikut secara berurutan, masing-masing dipanggil via `get_template_part()` agar modular dan mudah diedit:

1. **Hero** — banner utama
2. **Social Proof** — bukti sosial / kepercayaan
3. **About Preview** — ringkasan tentang perusahaan
4. **Advantages** — keunggulan
5. **Product Catalog** — katalog produk
6. **Pricing** — harga
7. **Comparison Table** — tabel perbandingan
8. **Partnership Flow** — alur kemitraan
9. **FAQ** — pertanyaan umum
10. **CTA Banner** — ajakan bertindak
11. **Contact Preview** — ringkasan kontak

## Data Global (Customizer)

Data kontak dan media sosial diatur terpusat lewat **Appearance → Customize → Indotech**, lalu diambil di template menggunakan helper di [inc/helpers.php](wp-content/themes/indotech-custom/inc/helpers.php) (mis. `dc_get_wa_url()`, `dc_get_email()`, `dc_get_address_html()`).

| Pengaturan | Setting key | Keterangan |
|---|---|---|
| Nomor WhatsApp | `dc_wa_number` | Tanpa `+`, spasi, atau strip. Contoh: `6281234567890` |
| Label WhatsApp | `dc_wa_label` | Format tampil. Contoh: `+62 812-3456-7890` |
| Email | `dc_email` | |
| Alamat Lengkap | `dc_address` | Multi-baris |
| Jam Operasional | `dc_business_hours` | |
| Instagram | `dc_social_instagram` | URL lengkap |
| Facebook | `dc_social_facebook` | URL lengkap |
| TikTok | `dc_social_tiktok` | URL lengkap |

## Setup Lokal

Proyek ini dikembangkan dengan **Laragon**.

1. **Letakkan proyek** di `c:\laragon\www\indotech`.
2. **Buat database** sesuai nama di [wp-config.php](wp-config.php) (`DB_NAME = indotech_db`). Prefix tabel: `dc_`.
3. **Sesuaikan kredensial** DB pada `wp-config.php` bila berbeda dari default Laragon (`root` / tanpa password).
4. **Jalankan Laragon** lalu akses situs melalui host virtual (mis. `http://indotech.test`).
5. **Aktifkan tema** di Appearance → Themes → *Indotech Custom*.
6. **Set halaman depan statis** di Settings → Reading agar `front-page.php` tampil.
7. **Isi data global** di Appearance → Customize → Indotech.

## Pengembangan

- **Mengedit konten section** — ubah file di `template-parts/sections/`.
- **Menambah section baru** — buat file di `template-parts/sections/`, lalu daftarkan dengan `get_template_part()` di `front-page.php`.
- **Aset** — `assets/css/main.css` dan `assets/js/main.js` di-enqueue dengan versi tema di [functions.php](wp-content/themes/indotech-custom/functions.php).
- **Tailwind CSS** saat ini dimuat via CDN untuk keperluan testing. Untuk produksi, disarankan beralih ke build Tailwind lokal agar performa dan ukuran CSS lebih optimal.

## Catatan

- `WP_DEBUG` di-set `false` pada [wp-config.php](wp-config.php).
- Jangan commit kredensial produksi ke repositori; gunakan `wp-config.php` lokal yang terpisah bila perlu.
