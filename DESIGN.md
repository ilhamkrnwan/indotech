---
name: Indotech
description: Profil perusahaan manufaktur dan distribusi B2B dengan arsitektur editorial daylight, palet Indotech Cobalt + Deep Obsidian-Navy + Signal Lime, dan tipografi Onest & Inter.
colors:
  cobalt: "#144ee3"
  cobalt-hover: "#0e3bc0"
  cobalt-tint: "#e8effd"
  ink: "#0b1220"
  ink-elevated: "#162035"
  slate: "#4b586e"
  muted-display: "#768299"
  on-dark: "#c6d1e4"
  canvas: "#f6f7fa"
  white: "#ffffff"
  grid: "#dce3ee"
  rule-dark: "#28344c"
  lime: "#d9f99d"
  lime-bright: "#a3e635"
typography:
  display:
    fontFamily: "Onest, Inter, sans-serif"
    fontSize: "clamp(2.85rem, 6.2vw, 5.5rem)"
    fontWeight: 700
    lineHeight: 0.96
    letterSpacing: "-0.035em"
  heading:
    fontFamily: "Onest, Inter, sans-serif"
    fontSize: "clamp(2.15rem, 4.3vw, 3.65rem)"
    fontWeight: 700
    lineHeight: 1.04
    letterSpacing: "-0.035em"
  body:
    fontFamily: "Inter, -apple-system, BlinkMacSystemFont, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.65
rounded:
  control: "999px"
  card: "20px"
  media: "28px"
  panel: "32px"
spacing:
  gutter: "clamp(18px, 3.6vw, 48px)"
  container: "1320px"
components:
  pill-cta:
    backgroundColor: "{colors.cobalt}"
    textColor: "{colors.white}"
    rounded: "{rounded.control}"
    padding: "6px 6px 6px 24px"
  stage-card:
    backgroundColor: "{colors.white}"
    textColor: "{colors.ink}"
    rounded: "{rounded.card}"
    padding: "20px 22px"
  solutions-dark:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.white}"
    rounded: "{rounded.panel}"
  tilt-badge:
    backgroundColor: "{colors.lime}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
---

## Overview

Sistem desain Indotech mengadaptasi tata letak editorial manufaktur dari referensi [Manufy](https://dribbble.com/shots/25142818-Manufacturing-Company-Profile) untuk menerjemahkan posisi PT Indotech Berkah Abadi sebagai produsen, penyedia jasa maklon, distributor B2B, dan akademi formulasi produk kebersihan. Token diterapkan melalui `.indotech-company-home` pada beranda WordPress sekaligus meluas penuh ke seluruh template halaman statis dengan arsitektur layout `.cs-*` ([company-static.css](wp-content/themes/indotech_custom/assets/css/company-static.css), [company-static.js](wp-content/themes/indotech_custom/assets/js/company-static.js), dan partial bersama [legal-doc.php](wp-content/themes/indotech_custom/template-parts/static/legal-doc.php): *Tentang Kami*, *Kemitraan*, *Kontak*, *FAQ*, *Blog*, *Legal*, `page.php`, `404.php`), menjaga arsip/detail CPT produk & pricelist tetap terisolasi.

## Colors

- **Cobalt & Cobalt-Hover** (`#144ee3` / `#0e3bc0`) untuk CTA utama (`Konsultasi B2B`), tombol navigasi aktif, penekanan angka KPI `+`, dan tautan di atas kanvas terang.
- **Canvas, White, & Grid** (`#f6f7fa`, `#ffffff`, `#dce3ee`) membentuk kanvas terang arsitektural dengan lima garis panduan vertikal putus-putus.
- **Ink & Ink-Elevated** (`#0b1220` / `#162035`) dipakai untuk blok gelap *Layanan B2B Terintegrasi*, kartu fitur kontras, foto scrim, dan kontras tipografi utama; **Slate** (`#4b586e`) dan **Muted-Display** (`#768299`, >=3:1 untuk teks display besar) menjaga hierarki teks.
- **Lime & Lime-Bright** (`#d9f99d` / `#a3e635`) menggemakan aksen hijau logo resmi Indotech: `#d9f99d` dengan tinta `#0b1220` untuk badge miring, pill label, tombol play video, dan pill legalitas; `#a3e635` eksklusif sebagai tautan/ikon aksen di permukaan gelap `#0b1220`.

## Typography

**Onest** (variabel lokal bobot 400–800) dipakai untuk display hero, heading bagian, angka KPI, dan watermark footer `INDOTECH`. **Inter** (variabel lokal) dipakai untuk paragraf isi, label, navigasi, dan kontrol antarmuka.

## Layout & Background Imagery

Lebar maksimal kontainer adalah `1320px`. Navigasi header dan footer tampil bersih tanpa titik maupun garis pemisah. Hero beranda menampilkan lockup judul dua warna + badge miring di atas **carousel 4 slide bertransisi liquid reveal** (`cta-logistics-b2b.webp`, `hero-manufy-stage.webp`, `cta-collab-b2b.webp`, `ilustrasi-formulasi.webp`) yang menampung tab proses `01–04` (dengan morph `GSAP Flip` dan indikator progres) serta kartu putih berlekuk L-shape. Bagian *Tentang Kami* menampilkan poster video vertikal `4:5` yang diposisikan agak ke tengah (*inset* `32px–72px` dari tepi kiri pada desktop `>960px`) serta menjorok turun menimpa tepi atas blok solusi obsidian-navy; visualnya bersinkronisasi dengan 4 tombol kapabilitas di atas melalui liquid wave reveal, dilengkapi teks langsung di atas gradasi tema serta **tombol Play bulat Signal Lime di pojok kanan bawah** yang membuka modal lightbox Customizer. Bagian berikutnya memuat *Ekosistem Brand Kami* (tanpa angka jumlah atau badge kategori), etalase kisah mitra asimetris 3 kartu dengan teks langsung di atas gradasi Cobalt–Obsidian dan **ekspansi liquid FLIP kanan-ke-kiri**, wawasan & FAQ B2B, CTA orbital konsentris, dan kartu footer putih dengan baris info 3 kolom. Seluruh template halaman statis kini dibangun ulang dengan grid arsitektural Manufy penuh (`.cs-*`): split hero daylight, stage foto `28px`, panel Obsidian-Navy bergaris hairline tanpa nested card (Visi/Misi/Sertifikasi, Keunggulan Kemitraan, Concierge WhatsApp), timeline tabular 2011–2024, pemilih skema/topik cepat interaktif, toolbar horizontal 3-kolom Blog, reader legal ber-switcher + bilah progres baca, panggung `404` dua kolom, serta koreografi smooth scroll `GSAP 3.13`. Aturan lengkap background image dan video profil terdokumentasi pada [panduan media dan video](docs/company-profile/media-dan-video.md).

## Elevation & Shapes

Sudut besar `28px–32px` membingkai media stage, kartu kisah mitra, panel solusi gelap, dan kartu footer putih; `20px` untuk kartu dalam; `999px` (pill penuh) untuk tombol aksi header/CTA dan badge miring. Kedalaman dibangun melalui tumpukan bidang warna kontras, batas tipis `1px` (`#dce3ee`), dan drop shadow lembut hanya pada kartu mengambang di atas fotografi.

## Do's and Don'ts

- Gunakan hanya klaim legalitas terverifikasi (`Izin Edar Kemenkes RI PKRT` & `Sertifikasi Halal`) dan angka yang sinkron (`15+ Tahun`, `500+ Mitra`, `1.000+ SKU`, `34 Provinsi`, `7 Brand`).
- Gunakan `#a3e635` hanya di latar gelap `#0b1220`; di latar terang gunakan `#d9f99d` dengan teks gelap `#0b1220`.
- Jaga *safe-zone* gambar latar bebas objek penting agar tab, tombol play video, dan kartu detail selalu terbaca dengan kontras WCAG 2.2 AA serta target minimal `44×44px`.
- Jangan menanamkan teks, logo, angka, atau ikon tombol *play* di dalam aset raster gambar.
