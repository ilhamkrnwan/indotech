# Requirement & Arsitektur Halaman Redesain Company Profile

Dokumen ini merumuskan kebutuhan fungsional, non-fungsional, struktur seluruh halaman situs, dan spesifikasi beranda Fase 1 untuk PT Indotech Berkah Abadi berdasarkan referensi tata letak [Manufy](https://dribbble.com/shots/25142818-Manufacturing-Company-Profile) dan ekosistem bisnis B2B Indotech.

## 1. Tujuan & Cakupan Fase

- **Tujuan**: Memberikan kesan modern, kreatif, dan kredibel layaknya perusahaan manufaktur B2B terkemuka melalui komposisi editorial arsitektural, fotografi produk/fasilitas beraturan, serta akses video perkenalan perusahaan — tanpa menghilangkan satu pun pilar bisnis B2B Indotech.
- **Cakupan Fase 1 (Implementasi Beranda)**: Penerapan sistem desain baru, token warna, tipografi lokal `Onest` + `Inter`, aset background image baru, carousel liquid Hero & Kisah Mitra, modul Video Profil terintegrasi, serta perombakan penuh beranda (`front-page.php`, header & footer kartu putih).
- **Cakupan Fase 2 (Diterapkan Penuh pada Template Statis)**: Perombakan menyeluruh tata letak dan arsitektur visual seluruh template halaman statis (`/tentang-kami/`, `/kemitraan/`, `/kontak/`, `/faq/`, `/blog/`, `/privacy-policy/`, `/syarat-ketentuan/`, `/cookie-policy/`, `page-legal.php`, `page.php`, dan `404.php`) menggunakan grid Manufy (`.ch-canvas-band` + `.ch-grid-guides` + `.cs-*`), partial bersama `template-parts/static/legal-doc.php`, lightbox video profil di `/tentang-kami/`, pemilih skema/topik cepat, serta opsi subjek *Jasa Maklon* & *Program Pelatihan* di `/kontak/`. (Arsip/detail CPT produk & pricelist tetap terisolasi.)

## 2. Struktur Halaman Situs (Information Architecture)

| Rute / Halaman | Peran & Konten Wajib | Aksi Utama (CTA) | Status Implementasi |
| --- | --- | --- | --- |
| **Beranda** `/` | 7 blok editorial B2B: Hero + Interactive Process Stage `01–04`, Tentang Kami + Video Profil & KPI, Blok Gelap 4 Solusi B2B, Ekosistem Brand Kami, Kisah Mitra Asimetris, Wawasan & FAQ, Orbital CTA & Footer Kartu Putih. | `Konsultasi B2B` & `Lihat Katalog` | **Fase 1 (Aktif)** |
| **Tentang Kami** `/tentang-kami/` | Split Hero Manufy + stage foto `28px` ber-dock 4 KPI (`15+`, `500+`, `1.000+`, `34`) & pemutar Lightbox Video Profil, kisah & timeline ledger 2011–2024, panel Obsidian-Navy Visi/Misi & Sertifikasi PKRT/Halal bergaris hairline, matriks 4 nilai, CPT Aplikasi B2B, peta HQ Sleman, dan CTA orbital. | `Konsultasi B2B` & `Tonton Video` | **Fase 2 (Total Redesign)** |
| **Solusi B2B** `/#solusi-b2b` (atau halaman khusus) | Penjabaran 4 pilar: Pasokan & Distribusi, Maklon & Formulasi (`cleaniquelab.com`), Kemitraan Usaha (`/kemitraan/`), dan Pelatihan (`cleaniqueacademy.com`), terhubung ke CPT `industry` & `application`. | `Pilih Jalur Solusi` | Aktif terintegrasi di Beranda |
| **Produk & Katalog** `/produk/` & `/products/{slug}/` | Katalog interaktif dengan filter kategori (`product_cat`), brand, pencarian AJAX, spesifikasi kemasan, dan tombol minta penawaran. | `Minta Penawaran` / `Lihat Detail` | Template & AJAX aktif (terisolasi) |
| **Profil Brand** `/brands/{slug}/` | Profil brand (`Orchid Care`, `Cleanique Lab`, `Cleanique Mart`, `Depo Cleanique`, `Cleanique Academy`, `Malabeez`, `Prokopi`) beserta produk terkait. | `Jelajahi Produk Brand` / Situs Resmi | Template CPT aktif + diringkas di Beranda |
| **Kemitraan** `/kemitraan/` | Split Hero + kolase 2 foto (kartu L-shape & gerai Cleanique Mart), panel Obsidian-Navy 3 keunggulan hairline, rel proses `01–04`, matriks 2×2 skema interaktif (Distributor, Reseller, Horeka, Institusi) pemilih `#partner-type`, studio formulir konversi, & FAQ split. | `Daftar Jadi Mitra` | **Fase 2 (Total Redesign)** |
| **Blog & Edukasi** `/blog/` | Masthead jurnal B2B, stage artikel pilihan `32px`, toolbar horizontal kategori + cari + urutkan, grid 3 kolom AJAX + pagination, strip konsultasi formulasi Obsidian-Navy, & CTA orbital. | `Baca Artikel Lengkap` | **Fase 2 (Total Redesign)** |
| **FAQ B2B** `/faq/` | Hero berbasis pencarian `#faq-search-input` + pill lompat kategori berhitung item, concierge sticky Obsidian-Navy, daftar pertanyaan bernomor `01–04` bergaris hairline + JSON-LD `FAQPage`, & CTA orbital. | `Chat WhatsApp` | **Fase 2 (Total Redesign)** |
| **Kontak & Penawaran** `/kontak/#form-kontak` | Split hero + ledger kontak 3 kolom tanpa batas kotak, studio formulir B2B dengan chip cepat topik (`Maklon`, `Pelatihan`, dll.) + concierge 3 divisi WhatsApp & jam operasional Obsidian-Navy, serta split peta HQ Sleman. | `Kirim Pesan B2B` | **Fase 2 (Total Redesign)** |
| **Legal, Default Page & 404** `/privacy-policy/`, `/syarat-ketentuan/`, `/cookie-policy/` | Partial bersama `legal-doc.php` dengan pengalih dokumen pill, TOC sticky + progres baca, prosa `65ch`, & penutup dukungan Obsidian-Navy; `page.php` bergrid editorial; `404.php` split stage + direktori rute cepat. | `Baca / Kembali ke Beranda` | **Fase 2 (Total Redesign)** |

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
