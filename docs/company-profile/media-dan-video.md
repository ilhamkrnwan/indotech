# Aturan Produksi Background Image & Panduan Video Perkenalan

Dokumen ini menetapkan standar teknis dan art-direction pembuatan serta penggunaan gambar latar (*background image*) dan modul video perkenalan perusahaan pada sistem desain PT Indotech Berkah Abadi.

## 1. Aturan Membuat & Menggunakan Background Image

Setiap aset foto yang digunakan sebagai latar elemen UI wajib memenuhi 5 pilar aturan berikut agar visual tetap modern, konsisten dengan palet Indotech, dan teks/kontrol di atasnya selalu terbaca (WCAG 2.2 AA).

### A. Matriks Rasio, Resolusi, & Safe-Zone Komposisi

| Penempatan | Aspek Rasio & Dimensi Target | Safe-Zone UI (Wajib Tenang / Bersih) | Aturan Fokus Subjek |
| --- | --- | --- | --- |
| **Hero Interactive Stage** (`hero-manufy-stage.webp`, `ilustrasi-formulasi.webp`) | `16:9` (`1376×768` / `960×540`, WebP `<= 120 KB`) | **Bawah-kiri 30%** (untuk tab proses `01–04`) dan **bawah-kanan 35%** (untuk kartu putih L-shape) harus berupa permukaan meja/lantai bersih tanpa detail rumit. | Fokus pada reaktor stainless, alat gelas borosilikat & larutan biru cobalt di **area tengah-atas**, tanpa model manusia atau wajah. |
| **About Lab & Video Poster** (`about-lab-video.webp`) | `4:5` (`800×1000`, WebP `<= 80 KB`) | **Bawah 20%** harus tenang/minim kontras ekstrem sebagai tempat tombol *Play Video Profil* mengambang. | Peralatan gelas formulasi, *magnetic stirrer*, & neraca analitik berada di **2/3 bagian atas**, tanpa model manusia atau wajah. |
| **Orbital CTA Kiri & Kanan** (`cta-collab-b2b.webp`, `cta-logistics-b2b.webp`) | `4:3` (`800×600`, WebP `<= 80 KB`) | Seluruh pinggir dan sudut bawah-kanan tetap bersih karena kartu dipotong dengan `border-radius: 24px` atau ditempati overlay L-shape. | Sampel kemasan polos & lorong palet logistik rapi dalam daylight `5500K` tanpa kehadiran manusia maupun label merek fiktif. |
| **Kisah Mitra / Gerai Nyata** (`mitra-*.webp`) | `4:3` / `1:1` (foto dokumentasi nyata yang disetujui) | **Bawah-kiri 35%** memakai kartu putih solid/semi-buram berbatas jelas agar nama gerai dan peran terbaca tanpa bergantung pada kecerahan papan toko. | Pastikan fasad dan papan nama gerai Cleanique Mart tidak terpotong oleh sudut membulat kartu. |

### B. Aturan Pencahayaan, Warna, & Estetika Industrial-Modern

1. **Pencahayaan Daylight Arsitektural (`5200K–6000K`)**: Gunakan cahaya natural terang yang menonjolkan kebersihan fasilitas produksi, laboratorium kaca, dan lantai epoksi gudang — hindari filter gelap suram, efek neon berlebihan, atau saturasi kuning/oranye berlebih.
2. **Visual Fasilitas Bebas Wajah & Model Wanita**: Seluruh aset editorial hasil generasi di `assets/images/company-profile/` berfokus pada arsitektur fasilitas manufaktur, peralatan gelas laboratorium presisi, kemasan jeriken polos B2B, serta rak logistik gudang **tanpa menampilkan model wanita maupun wajah manusia**.
3. **Harmoni Palet Indotech**: Utamakan latar netral terang (baja tahan karat, kaca arsitektural, dinding putih-abu dingin) dengan aksen **Indotech Cobalt (`#144EE3`)** atau **Deep Obsidian-Navy (`#0B1220`)** pada cairan sampel dan kemasan HDPE polos agar menyatu dengan tema situs.
4. **Larangan Keras Elemen UI di Dalam Gambar**: Dilarang keras menghasilkan atau menempelkan teks promosi, tipografi judul, logo brand fiktif, stiker sertifikasi, angka statistik, ikon tombol *play*, maupun watermark ke dalam file raster gambar. Semua teks, badge, sertifikasi, dan tombol wajib dirender sebagai HTML/SVG.
5. **Kejujuran Visual & Kemasan**: Untuk ilustrasi konsep fasilitas/kemasan B2B, gunakan wadah/jeriken polos tanpa merek (*unbranded*) agar tidak menimbulkan ekspektasi label SKU palsu; untuk foto gerai dan produk spesifik, gunakan dokumentasi foto nyata atau packshot katalog resmi.

### C. Aturan Overlay, Scrim & Keterbacaan Kontras

- Jangan pernah mengandalkan piksel foto mentah untuk menjamin kontras teks putih atau kontrol transparan.
- **Scrim Gradien Wajib**: Pada Hero Stage dan Video Poster yang menampung elemen interaktif di sisi bawah, pasang overlay CSS pelindung bawah:
  `linear-gradient(180deg, rgba(11, 18, 32, 0) 42%, rgba(11, 18, 32, 0.72) 100%)`
  atau bungkus teks dengan kartu solid/blur berlatar stabil (`.ch-stage-card` berlatar `#FFFFFF`, atau `.ch-video-trigger` berlatar `rgba(11, 18, 32, 0.86)` dengan `backdrop-filter: blur(8px)`).
- Selalu tentukan warna `background-color` fallback (`#0B1220` untuk frame gelap, `#DCE3EE` untuk frame foto terang) agar rasio kontras tetap aman sebelum gambar selesai diunduh.

### D. Aturan Performa & Markup HTML

- Cantumkan atribut `width` dan `height` eksplisit + properti CSS `aspect-ratio` untuk menjaga `CLS = 0`.
- Hanya gambar LCP di atas lipatan (`hero-manufy-stage.webp`) yang boleh menggunakan `fetchpriority="high"` dan tanpa `loading="lazy"`. Seluruh gambar di blok ke-2 ke bawah wajib menggunakan `loading="lazy"` dan `decoding="async"`.
- Simpan gambar hasil generate sebagai WebP (kualitas 82–86, tanpa upscaling) beserta file JSON provenance (`<nama>.webp.json`) di `wp-content/themes/indotech_custom/assets/images/company-profile/`.

### E. Template Prompt Generasi Gambar Standar

```text
[Framing & Aspect Ratio] editorial corporate/industrial photograph of [subjek spesifik di fasilitas/lab/kantor Indonesia].
[Pencahayaan & Warna]: bright 5500K architectural daylight, clean minimalist steel/glass environment with subtle cobalt-blue (#144EE3) and deep navy (#0B1220) accents.
[Safe-Zone]: subject positioned in [area fokus], leaving [zona aman dalam %] calm and uncluttered for UI overlays.
[Hard Exclusions]: Strictly NO text, NO logos, NO printed bottle labels, NO badges, NO UI icons, NO watermarks.
```

---

## 2. Katalog Aset Background Image Terpasang (Fase 1)

| Berkas | Lokasi & Penempatan | Sumber & Provenance |
| --- | --- | --- |
| `hero-manufy-stage.webp` | `assets/images/company-profile/` — Latar Hero Interactive Process Stage (Maklon & R&D) | Aset `master-konten` Batch 1/016 (Alur Produksi Private Label Pabrik Kemenkes) |
| `about-lab-video.webp` | `assets/images/company-profile/` — Poster vertikal *overlapping* Tentang Kami & Video | Aset `master-konten` Batch 1/001 (Validasi Kualitas Formula B2B) |
| `cta-collab-b2b.webp` | `assets/images/company-profile/` — Hero Stage 03 & Foto Kiri-Bawah Orbital CTA | Aset `master-konten` Batch 1/002 (Depo Cleanique Mitra Bisnis Siap Jalan) |
| `cta-logistics-b2b.webp` | `assets/images/company-profile/` — Hero Stage 01 & Foto Kanan-Atas Orbital CTA | Aset `master-konten` Batch 4/003 (Kemasan Jerigen HDPE Tebal Standar Kargo) |
| `ilustrasi-formulasi.webp`| `assets/images/company-profile/` — Hero Stage 04 & Slide Pelatihan Akademi | Aset `master-konten` Batch 1/004 (Belajar Formulasi Cleanique Academy) |
| `industry-hospitality.webp`| `assets/images/company-profile/` — Arsip Sektor Industri Hospitality & Hotel | Aset `master-konten` Batch 1/001 (Hospitality B2B) |
| `industry-laundry.webp`    | `assets/images/company-profile/` — Arsip Sektor Industri Laundry Komersial | Aset `master-konten` Batch 1/001 (Laundry B2B) |
| `mitra-*.webp` | `assets/images/` — Etalase Kisah Mitra Cleanique Mart | Dokumentasi foto gerai nyata pada repositori Indotech |

---

## 3. Spesifikasi Video Perkenalan Perusahaan (60–65 Detik)

### Konfigurasi & Perilaku Teknis
- Admin dapat mengisi tautan video resmi di **WordPress Customizer → Video Profil Perusahaan** (`indotech_video_url`), bersama judul (`indotech_video_title`) dan durasi tampilan (`indotech_video_duration`).
- Mendukung tautan **YouTube**, **Vimeo**, maupun berkas **MP4** langsung yang di-host di media library/CDN resmi.
- **Lazy Embed**: Tidak ada `<iframe>` atau `<video>` yang dimuat saat beranda dibuka. Pemutar hanya disuntikkan ke dalam dialog modal sinema tunggal (`#ch-video-modal`, berbagi partial `template-parts/home/company-video-modal.php`) ketika pengunjung menekan tombol **Tonton Video Profil**, dan dibersihkan kembali saat modal ditutup (`Close` / klik backdrop / tombol `Escape`).
- **Tampilan Modal Fokus Video (`Cinema Lightbox`)**: Modal dibuat besar (`min(1140px, 94vw)`, rasio `16:9` penuh) dengan tombol tutup mengambang di pojok kanan atas tanpa bilah header tambahan, kartu babak storyboard, maupun tombol CTA footer agar perhatian pengunjung sepenuhnya tertuju ke video. Jika `indotech_video_url` belum diisi, panggung `16:9` menampilkan poster visual bersih dengan penanda tombol putar dan judul singkat video profil.

### Storyboard Produksi Video Resmi

| Durasi | Visual Rekaman yang Disiapkan | Narasi / Pesan Utama |
| --- | --- | --- |
| **00–08 dtk** | Bidikan eksterior/operasional resmi PT Indotech Berkah Abadi di Sleman + overlay logo resmi | *"PT Indotech Berkah Abadi, mitra manufaktur dan pasokan kebersihan B2B sejak 2011 dari Sleman, Yogyakarta."* |
| **08–22 dtk** | Proses formulasi di lab R&D Cleanique Lab, uji viskositas/pH, serta pengecekan sampel kemasan | *"Melalui fasilitas R&D dan layanan maklon Cleanique Lab, kami memproduksi formulasi yang memenuhi izin edar Kemenkes RI PKRT dan sertifikasi Halal."* |
| **22–38 dtk** | Lini pengemasan produk curah 5L/20L Orchid Care & gudang palet siap kirim ke 34 provinsi | *"Menyediakan lebih dari 1.000 varian SKU laundry, homecare, pewangi, hingga pembersih khusus bagi ratusan mitra bisnis di 34 provinsi."* |
| **38–52 dtk** | Suasana gerai Cleanique Mart, isi ulang Depo Cleanique, dan kelas praktik Cleanique Academy | *"Didukung jaringan kemitraan toko modern Cleanique Mart, Depo Cleanique, serta pembinaan kewirausahaan bersama Cleanique Academy."* |
| **52–65 dtk** | Tim manajemen/konsultan B2B + animasi logo & ajakan konsultasi | *"Temukan solusi pasokan, maklon, atau kemitraan usaha Anda. Diskusikan kebutuhan B2B bersama tim Indotech."* |

### Persyaratan Produksi & Aksesibilitas Video Akhir
- Ekspor master 1080p MP4 (H.264) atau unggah ke kanal resmi dengan poster WebP 16:9.
- Wajib menyertakan file **caption Bahasa Indonesia (`.vtt`)** dan ringkasan **transkrip teks** setara agar memenuhi [WCAG 2.2 Time-Based Media](https://www.w3.org/TR/WCAG22/#time-based-media).
- Pastikan persetujuan tertulis (*release form*) untuk seluruh staf maupun pemilik gerai mitra yang tampil dalam rekaman.
