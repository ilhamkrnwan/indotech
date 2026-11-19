---
name: Indotech
description: Profil perusahaan B2B dengan komposisi editorial industrial, palet biru, dan fotografi produk.
colors:
  primary: "#164ce5"
  primary-hover: "#123cba"
  ink: "#101d36"
  muted: "#4c5b71"
  paper: "#f6f8fc"
  white: "#ffffff"
  rule: "#d9e0ec"
  on-dark: "#c4d0e8"
  signal: "#c5f47b"
typography:
  display:
    fontFamily: "Space Grotesk, sans-serif"
    fontSize: "clamp(3rem, 6.8vw, 6rem)"
    fontWeight: 700
    lineHeight: 1.01
    letterSpacing: "-0.04em"
  heading:
    fontFamily: "Space Grotesk, sans-serif"
    fontSize: "clamp(2.35rem, 4.6vw, 4.25rem)"
    fontWeight: 700
    lineHeight: 1.04
    letterSpacing: "-0.04em"
  body:
    fontFamily: "Inter, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.65
rounded:
  control: "8px"
  media: "16px"
spacing:
  gutter: "clamp(20px, 4vw, 48px)"
  section: "clamp(64px, 8vw, 116px)"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.white}"
    rounded: "{rounded.control}"
    padding: "13px 18px"
  button-primary-hover:
    backgroundColor: "{colors.primary-hover}"
  catalog-link:
    backgroundColor: "{colors.white}"
    textColor: "{colors.ink}"
    rounded: "{rounded.media}"
    padding: "16px"
  media-frame:
    backgroundColor: "{colors.ink}"
    rounded: "{rounded.media}"
---

## Overview

Komposisi editorial industrial memperkenalkan Indotech melalui judul besar, fotografi produk, dan navigasi berdasarkan kebutuhan bisnis. Referensi Manufy memberi arah pada susunan judul di atas media, komposisi dua kolom, dan pergantian bidang terang ke gelap. Logo resmi, palet biru, dan konten perusahaan menerjemahkan pola tersebut ke identitas Indotech. Sistem ini pertama kali diterapkan pada beranda WordPress. [Referensi layout Manufy](https://dribbble.com/shots/25142818-Manufacturing-Company-Profile).

## Colors

- **Primary dan primary-hover** untuk aksi utama, tautan di atas putih, serta penekanan judul.
- **Ink, paper, dan white** membangun ritme bidang halaman. **Muted** dipakai untuk teks pendukung terang dan **on-dark** untuk teks pendukung di atas ink.
- **Rule** memisahkan baris tanpa mengurangi ruang baca. **Signal** menggemakan hijau pada logo melalui tautan dan fokus di permukaan gelap.

## Typography

Space Grotesk membentuk hierarki judul. Inter dipakai untuk isi, navigasi, dan kontrol. Keduanya dilayani dari aset lokal. H1 memakai dua baris yang terencana di desktop dan membungkus alami di layar sempit. Teks penjelas dijaga sekitar 32–47 karakter per baris pada bagian yang berdampingan dengan foto atau CTA.

## Layout

Lebar konten maksimum 1.280 px. Judul dan ringkasan hero berada di atas panel packshot dengan kartu katalog di kanan. Pada desktop, poster profil 16:9 berada di kiri dan melintasi tepi panel solusi navy. Panel tersebut mengelompokkan empat penawaran dalam kisi dua kolom. Daftar brand diikuti galeri mitra asimetris. Pada ≤768 px, profil disusun satu kolom dan navigasi beralih ke menu mobile. Pada ≤640 px, hero, daftar solusi, dan kontak juga disusun satu kolom. Foto pertama galeri membentang di atas dua foto pendukung.

## Elevation & Depth

Hierarki dibangun dari bidang warna, batas tipis, dan kedalaman foto. Header dapat memiliki bayangan ringan saat halaman digulir.

## Shapes

Media dan panel memakai sudut 16 px. Kontrol berbentuk persegi dengan sudut 8 px. Baris brand dan solusi memakai garis pemisah.

## Components

- **CTA utama** berlabel “Diskusikan Kebutuhan B2B” dan menuju formulir kontak. Kartu katalog di dalam hero berfungsi sebagai jalur sekunder.
- **Tautan aksi** memiliki label spesifik dan ikon panah dekoratif. Tautan pada latar gelap memakai signal sebagai warna teks dan fokus.
- **Media editorial** menampilkan packshot katalog, foto gerai dengan caption, dan ilustrasi yang ditandai sesuai konteks. Gunakan `picture` ketika crop berbeda antarlayar.
- **Menu mobile** memakai tombol dengan status terbuka, fokus keyboard, dan Escape untuk menutup. Konten dan CTA utama tampil langsung.

## Do's and Don'ts

- Gunakan foto nyata yang disetujui untuk fasilitas, tim, partner, produk tertentu, dan sertifikasi.
- Tandai still life generatif sebagai ilustrasi, dan periksa komposisi pada crop desktop dan mobile.
- Jaga fokus yang terlihat, target utama minimal 44 px sebagai standar internal, dan rasio kontras WCAG 2.2 AA. [WCAG 2.2](https://www.w3.org/TR/WCAG22/).
- Letakkan pesan, klaim, dan tautan sebagai HTML. Gunakan transisi singkat untuk perubahan keadaan kontrol.
