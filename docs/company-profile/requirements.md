# Requirement & Arsitektur Halaman Redesain Company Profile

Dokumen ini merumuskan kebutuhan fungsional, non-fungsional, struktur seluruh halaman situs, dan spesifikasi beranda Fase 1 untuk PT Indotech Berkah Abadi berdasarkan referensi tata letak [Manufy](https://dribbble.com/shots/25142818-Manufacturing-Company-Profile) dan ekosistem bisnis B2B Indotech.

## 1. Tujuan & Cakupan Fase

- **Tujuan**: Memberikan kesan modern, kreatif, dan kredibel layaknya perusahaan manufaktur B2B terkemuka melalui komposisi editorial arsitektural, fotografi produk/fasilitas beraturan, serta akses video perkenalan perusahaan — tanpa menghilangkan satu pun pilar bisnis B2B Indotech.
- **Cakupan Fase 1 (Implementasi Sekarang)**: Penerapan total sistem desain baru, token warna, tipografi lokal `Onest` + `Inter`, aset background image baru, modul Video Profil berbasis Customizer, serta perombakan penuh beranda (`front-page.php`, header & footer beranda).
- **Cakupan Fase 2 (Rollout Terencana)**: Penyelarasan halaman dalam (`/tentang-kami/`, `/produk/`, `/kemitraan/`, `/kontak/`, `/blog/`, `/faq/`, dan arsip brand/industri) mengikuti `DESIGN.md` baru serta penambahan topik Maklon & Pelatihan di formulir `/kontak/`.

## 2. Struktur Halaman Situs (Information Architecture)

| Rute / Halaman | Peran & Konten Wajib | Aksi Utama (CTA) | Status Implementasi |
| --- | --- | --- | --- |
| **Beranda** `/` | 7 blok editorial B2B: Hero + Interactive Process Stage `01–04`, Tentang Kami + Video Profil & KPI, Blok Gelap 4 Solusi B2B, Ekosistem 7 Brand, Kisah Mitra Asimetris, Wawasan & FAQ, Orbital CTA & Footer Kartu Putih. | `Konsultasi B2B` & `Lihat Katalog` | **Fase 1 (Aktif)** |
| **Tentang Kami** `/tentang-kami/` | Sejarah sejak 2011, visi/misi, fasilitas R&D Sleman, video profil resmi, dan daftar izin edar Kemenkes RI PKRT & Halal yang terverifikasi. | `Konsultasi B2B` | Fase 2 (template ada) |
| **Solusi B2B** `/#solusi-b2b` (atau halaman khusus) | Penjabaran 4 pilar: Pasokan & Distribusi, Maklon & Formulasi (`cleaniquelab.com`), Kemitraan Usaha (`/kemitraan/`), dan Pelatihan (`cleaniqueacademy.com`), terhubung ke CPT `industry` & `application`. | `Pilih Jalur Solusi` | Ringkasan di Beranda Fase 1; landing page terpisah di Fase 2 |
| **Produk & Katalog** `/produk/` & `/products/{slug}/` | Katalog interaktif dengan filter kategori (`product_cat`), brand, pencarian AJAX, spesifikasi kemasan, dan tombol minta penawaran. | `Minta Penawaran` / `Lihat Detail` | Template & AJAX aktif |
| **Profil Brand** `/brands/{slug}/` | Profil masing-masing dari 7 brand (`Orchid Care`, `Cleanique Lab`, `Cleanique Mart`, `Depo Cleanique`, `Cleanique Academy`, `Malabeez`, `Prokopi`) beserta produk terkait. | `Jelajahi Produk Brand` / Situs Resmi | Template aktif + diringkas di Beranda |
| **Kemitraan** `/kemitraan/` | Skema Distributor, Agen, Toko Cleanique Mart, dan Depo Cleanique, alur pendaftaran 4 langkah, serta formulir pengajuan mitra. | `Ajukan Kemitraan` | Template aktif |
| **Blog & Edukasi** `/blog/` | Artikel industri kebersihan, formulasi, tips laundry, dan artikel SEO terkait maklon. | `Baca Artikel` | Template aktif |
| **FAQ B2B** `/faq/` | Daftar tanya-jawab komprehensif terkait pemesanan, legalitas PKRT/Halal, pengiriman luar Jawa, maklon, dan pelatihan. | `Tanya via WhatsApp` | Terintegrasi ringkas di Beranda + halaman `/faq/` |
| **Kontak & Penawaran** `/kontak/#form-kontak` | Formulir permintaan penawaran, informasi alamat Sleman, peta lokasi, dan jalur WhatsApp 3 divisi CS (Keagenan, Retail, Pelatihan). | `Kirim Penawaran` | Target CTA Beranda; perluasan subjek Maklon & Pelatihan di Fase 2 |
| **Legal, Download & Pricelist** `/privacy-policy/`, `/syarat-ketentuan/`, `/cookie-policy/`, `/download-center/`, `/daftar-harga/` | Dokumen legalitas situs, kebijakan privasi/cookie, katalog PDF, dan halaman daftar harga. | `Baca / Unduh` | Halaman aktif terpisah |

## 3. Spesifikasi 7 Blok Beranda Fase 1

1. **Header Arsitektural**: Logo Indotech di kiri, navigasi terpisah titik (`•`) di tengah, dan dual CTA di kanan (`Katalog` outline + `Konsultasi B2B` Cobalt solid), plus drawer mobile yang fokus-aman.
2. **Hero Editorial + Interactive Process Stage**: Judul display `Onest` dua baris kontras (*"Formulasi Masa Depan"*) dengan badge miring Signal Lime `PT Indotech`, copy nilai B2B + pill CTA `Konsultasi B2B`, dan kontainer foto `16:9` bersudut tumpul yang memuat **tab proses interaktif `01`–`04`** serta **kartu putih L-shape** yang dinamis.
3. **Tentang Kami, Video Profil & KPI**: Judul dua warna + strip 4 ikon kapabilitas interaktif + poster laboratorium `4:5` yang menjorok (*overlap*) ke tepi blok gelap di bawahnya dengan tombol **Play Video Profil** (membuka Lightbox Modal YouTube/MP4 Customizer atau Storyboard interaktif) + 4 angka KPI (`15+ Tahun`, `500+ Mitra B2B`, `1.000+ SKU`, `34 Provinsi`) dan pill legalitas `Kemenkes RI PKRT` & `Halal`.
4. **Blok Gelap Solusi B2B & Ekosistem 7 Brand**: Kontainer Deep Obsidian-Navy (`#0B1220`) menampilkan 4 kartu solusi dalam grid `2×2` dengan aksen ikon gelap & tautan Signal Lime (`#A3E635`), dilanjutkan direktori arsitektural **7 Brand Portofolio** (termasuk Prokopi, mengecualikan Cokusi).
5. **Kisah Mitra & Jejak Kemitraan**: Showcase asimetris 3 kartu bergaya *Customer Stories* menggunakan foto nyata gerai Cleanique Mart (`mitra-*.webp`), mendukung tombol navigasi `<` `>` serta modal detail testimoni mitra.
6. **Wawasan Industri & FAQ B2B**: 3 artikel terbit terbaru (di luar kategori bawaan *Tak Berkategori*) berdampingan dengan 5 FAQ inti dan JSON-LD `FAQPage`.
7. **Orbital CTA & Footer Kartu Putih**: Bagian ajakan akhir dengan cincin orbit putus-putus + 2 foto editorial (`cta-collab-b2b`, `cta-logistics-b2b`) + trust indicator `★ 15+ Tahun · PKRT & Halal`, diikuti footer kartu putih membulat berisi formulir cepat WA B2B, detail 3 CS WhatsApp, legal links, dan watermark `[INDOTECH]`.

## 4. Kriteria Penerimaan & Kualitas

- **Responsivitas**: Nol horizontal overflow (`scrollWidth <= innerWidth`) pada `320px`, `390px`, `768px`, `1024px`, `1280px`, dan `1440px`.
- **Aksesibilitas (WCAG 2.2 AA)**: Rasio kontras teks normal `>= 4.5:1` dan teks besar `>= 3:1` (Signal Lime `#A3E635` eksklusif di atas `#0B1220`, bukan di latar putih; pill terang memakai `#D9F99D` dengan teks `#0B1220`), navigasi keyboard lengkap (`Tab`, `ArrowLeft`/`ArrowRight` pada tab hero, `Escape` pada menu & modal), hit target `>= 44×44px`, dan dukungan `prefers-reduced-motion`.
- **Performa**: Font `Onest` dan `Inter` dilayani lokal (WOFF2), gambar menggunakan WebP terkompresi dengan `width`/`height` eksplisit, hero image diberi `fetchpriority="high"`, gambar bawah lipatan memakai `loading="lazy"`, dan video player memakai *lazy embed* hanya saat dibuka.
- **SEO & Integritas Data**: Tetap mempertahankan meta tag, OpenGraph, `Organization`/`LocalBusiness` schema, dan `FAQPage` schema dari `inc/seo.php` tanpa menyisipkan komentar atau atribut metadata desain internal ke DOM publik.
