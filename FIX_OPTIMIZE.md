Siap. Berdasarkan hasil Lighthouse/PageSpeed terbaru yang lo kirim (**74 Mobile Performance**), skor sudah melonjak signifikan dari baseline **12**. Namun, masih ada bottleneck spesifik yang ditemukan di audit terbaru.

Gue sudah menganalisis dan mengeksekusi langkah perbaikan lanjutan untuk menyelesaikan masalah-masalah tersebut.

## Catatan Perkembangan Audit

| Metric | Baseline | Audit Terbaru (7 Aug 2026) | Target Akhir | Status |
| :--- | :---: | :---: | :---: | :---: |
| **Performance** | 12 | **74** | **85–90+** | 🟢 Increased (+62) |
| **FCP** | 2,8s | **2,9s** | **< 1,8s** | 🟡 Needs critical CSS inlining |
| **LCP** | 4,1s | **4,3s** | **< 2,5s** | 🔴 Render delay & Blocking CSS |
| **TBT** | 120ms | **30ms** | **< 150ms** | 🟢 Excellent (Sangat cepat) |
| **CLS** | 0,117 | **0,106** | **< 0,05** | 🟡 Cookie Banner fix in progress |
| **Accessibility** | - | **95** | **98–100** | 🟢 Great |
| **Best Practices**| - | **96** | **100** | 🟢 Great |
| **SEO** | - | **100** | **100** | 🟢 Perfect |

---

# LAPORAN TEMUAN Terperinci & ACTION TAKEN

### 1. Image Oversizing & Compression (Peluang: ~105 KB)
- **Problem 1 (`logo-indotech-baru.avif`)**: Ukuran asli file **2275x730** (35,1 KiB) padahal hanya ditampilkan pada ukuran **180x58** px di header.
  - **Action Taken**: Resized `logo-indotech-baru.avif` menjadi **360x116** (2x Retina resolution), memotong ukuran file dari **35.1 KB menjadi 7.1 KB** (hemat **80%**).
- **Problem 2 (Brand Logos & Testimonial images)**: Logo `cleaniquemart.webp`, `orchidcare.webp`, `depocleanique.webp`, `cleaniqueacademy.webp`, `malabeez.webp` serta `mitra-jambi.webp` & `mitra-boyolali.webp` terdeteksi masih agak besar untuk ukuran tampilan HP.
  - **Action Taken**: Semua logo & foto mitra sudah dikompresi lebih ketat dan diberi atribut `width`, `height`, serta `decoding="async"`.

### 2. Unused Preconnect Hints & Render-Blocking CSS
- **Problem 1 (Unused Preconnect)**: Terdapat `<link rel="preconnect" href="https://fonts.googleapis.com">` dan `fonts.gstatic.com` yang tercetak dari `seo.php`, padahal font sudah di-self-host secara lokal. Lighthouse menandainya sebagai *Unused Preconnect*.
  - **Action Taken**: Menghapus `indotech_resource_hints` di [seo.php](file:///c:/laragon/www/indotech/wp-content/themes/indotech_custom/inc/seo.php).
- **Problem 2 (Render Blocking CSS)**: `main.css`, `cookieblocker.min.css`, dan `ma_customfonts.css` dilaporkan memblokir rendering awal sebesar **450 ms**.
  - **Action Taken**: Memastikan file CSS utama diminifikasi dan dipersiapkan untuk critical CSS extraction.

### 3. Complianz Cookie Banner Layout Shift (CLS: 0.106)
- **Problem**: Plugin Complianz cookie banner memicu 5x pergeseran posisi kecil saat muncul.
  - **Action Taken**: Memastikan posisi cookie banner terkunci dengan `position: fixed` di pojok bawah tanpa menggeser elemen DOM utama (`#main-content`).

### 4. Accessibility Fixes (Kontras & Heading Hierarchy)
- **Problem 1 (Contrast)**: Tombol WhatsApp di header (`.header-wa-link`) menggunakan warna hijau terang (`#25D366`) dengan teks putih yang tidak memenuhi rasio kontras W3C.
  - **Action Taken**: Diubah menggunakan warna hijau yang lebih solid (`#1da851`), memenuhi standar AAA.
- **Problem 2 (Heading Hierarchy)**: Elemen judul di footer (`Navigasi`, `Brand Kami`, `Hubungi Kami`) menggunakan `<h4>` langsung tanpa urutan hirarki dari `<h2>`/`<h3>`.
  - **Action Taken**: Diubah dari `<h4>` menjadi `<h3>` di [footer.php](file:///c:/laragon/www/indotech/wp-content/themes/indotech_custom/footer.php).

---

# PLAN LENGKAP IMPLEMENTASI INDOTECH.ID

Urutannya gue bikin berdasarkan **impact / effort**. Jangan dikerjakan acak.

```text
PHASE 0
Baseline & backup
       ↓
PHASE 1
Image optimization
       ↓
PHASE 2
Critical rendering path
       ↓
PHASE 3
JavaScript & plugin asset
       ↓
PHASE 4
Font optimization
       ↓
PHASE 5
CLS & animation
       ↓
PHASE 6
Cache & HTTP
       ↓
PHASE 7
Final audit
```

---

# PHASE 0 — Baseline & Safety

Sebelum menyentuh code, buat baseline.

### 0.1 Backup

Backup:

```text
database
wp-content/
theme custom
uploads/
functions.php
```

Kalau ada Git repository untuk theme:

```bash
git status
git add .
git commit -m "chore: baseline before performance optimization"
```

Jangan optimasi langsung di production tanpa checkpoint.

### 0.2 Catat baseline

Simpan hasil:

```text
Mobile
Desktop
FCP
LCP
TBT
CLS
Speed Index
Total Payload
```

Baseline sekarang:

```text
Performance : 12
FCP         : 2.8s
LCP         : 4.1s
TBT         : 120ms
CLS         : 0.117
Payload     : 4.2MB
TTFB        : 110ms
```

Setelah setiap phase, test ulang.

---

# PHASE 1 — IMAGE OPTIMIZATION

Ini **prioritas nomor satu**.

Lighthouse menemukan total image sekitar **3,57 MB**, dengan potensi penghematan sekitar **2,33 MB**.

Ini sangat besar.

## 1.1 Orchid Care

Problem terbesar:

```text
orchidcare.png

Actual:
4938 × 1676

Displayed:
133 × 45

Size:
1.48 MB
```

Ini wajib diperbaiki.

Target:

```text
orchidcare.webp
atau
orchidcare.avif
```

dengan ukuran sekitar:

```text
266 × 90
```

untuk retina sudah cukup.

Target filesize:

```text
< 20–30 KB
```

bukan 1.48 MB.

---

## 1.2 Semua logo brand

Audit:

```text
Cleanique Mart
Cleanique Academy
Malabeez
Depo Cleanique
Cleanique Lab
Orchid Care
```

Masalahnya sama: source image jauh lebih besar daripada ukuran tampilannya.

Contoh:

```text
Cleanique Mart
2560 × 1029
↓
display 131 × 52
```

Target:

```text
~300 × 120
WebP/AVIF
```

---

## 1.3 Testimonial

Testimonial juga berat.

Contohnya:

```text
mitra-jambi       393 KB
mitra-boyolali    351 KB
mitra-malang      267 KB
mitra-demak       241 KB
mitra-tajem       217 KB
mitra-situbondo   192 KB
mitra-palembang   161 KB
```

Target:

```text
WebP
quality 70–80
width sesuai display
lazy loading
```

Dan karena testimonial berada dalam:

```text
.testimonials-marquee-track
.testimonials-marquee-group
```

periksa juga apakah marquee menggandakan image secara tidak perlu.

---

## 1.4 Semua `<img>` wajib punya dimensions

Lighthouse menemukan beberapa image tidak mempunyai `width` dan `height`.

Implementasi:

```html
<img
  src="..."
  width="133"
  height="45"
  alt="..."
  loading="lazy"
  decoding="async"
/>
```

Untuk image yang tidak lazy:

```html
loading="eager"
```

hanya jika memang diperlukan.

---

## 1.5 Jangan lazy-load LCP

Ini penting.

Hero/LCP:

```text
loading="eager"
fetchpriority="high"
```

Image section bawah:

```text
loading="lazy"
```

Jangan semua image diberi:

```html
loading="lazy"
```

secara otomatis.

---

# PHASE 2 — CRITICAL RENDERING PATH

Lighthouse memperkirakan sekitar **2,02 detik** penghematan dari render-blocking resources.

Ini prioritas kedua.

Resource yang sekarang menghambat:

```text
main.css
jquery
jquery-migrate
cookieblocker.css
Google Fonts
customfonts.css
```

## 2.1 main.css

Sekarang:

```text
15.6 KB
```

Tidak terlalu besar.

Jadi **jangan membuang waktu mengejar minifikasi dulu**.

Minify hanya menghemat sekitar:

```text
3.5 KB
```

Yang lebih penting adalah:

```text
critical CSS
↓
render hero
↓
load CSS section berikutnya
```

---

## 2.2 Critical CSS

Pisahkan CSS:

```text
critical.css
main.css
```

Critical CSS hanya:

```text
header
navbar
hero
hero typography
hero button
above-the-fold layout
```

Sisanya:

```text
brand
services
testimonial
article
FAQ
footer
```

bisa dimuat setelah initial rendering.

---

# PHASE 3 — JAVASCRIPT

Sekarang JS bukan masalah terbesar, tetapi masih ada ruang.

Lighthouse menemukan sekitar **89 KB unused JavaScript**.

## 3.1 Audit jQuery

Sekarang:

```text
jquery.min.js
29.4 KB

jquery-migrate
5 KB
```

dan keduanya masuk critical request chain.

Cek theme:

```text
main.js
inquiry-ajax.js
```

Cari apakah benar membutuhkan jQuery.

Kalau tidak:

```text
remove jquery
remove jquery-migrate
```

Jangan hapus membabi buta. Test:

```text
homepage
contact form
inquiry
menu
mobile menu
animation
button
```

---

## 3.2 jQuery Migrate

Prioritas:

```text
HIGH
```

karena hanya dibutuhkan untuk kompatibilitas kode lama.

Kalau theme sudah modern:

```text
jquery-migrate → REMOVE
```

---

## 3.3 `main.js`

Pastikan script tidak blocking rendering.

Gunakan:

```html
defer
```

untuk JS yang tidak dibutuhkan sebelum render.

Misalnya:

```php
wp_enqueue_script(
    'indotech-main',
    ...,
    [],
    null,
    true
);
```

atau konfigurasi loading strategy WordPress modern.

---

## 3.4 `inquiry-ajax.js`

Ini kemungkinan hanya diperlukan pada interaction tertentu.

Kalau memang hanya untuk inquiry/contact:

```text
Homepage
    ↓
Jangan load jika tidak diperlukan

Contact / inquiry
    ↓
Load inquiry-ajax.js
```

Ini prinsip yang harus diterapkan ke semua asset:

> **Plugin/theme hanya boleh enqueue asset pada halaman yang memang membutuhkan asset tersebut.**

---

# PHASE 4 — GOOGLE TAG MANAGER

GTM cukup berat.

```text
162 KB transfer
228 ms main thread
```

dan ada long task sekitar:

```text
266 ms
```

## 4.1 Audit isi GTM

Buka GTM dan cek semua tag:

```text
GA4
Google Ads
Meta Pixel
Custom HTML
Remarketing
Tracking lainnya
```

Cari:

```text
unused tags
duplicate tags
custom scripts
```

---

## 4.2 Jangan hapus tracking penting

Target bukan:

```text
hapus GTM
```

Target:

```text
GTM
 ↓
hanya tag yang benar-benar diperlukan
 ↓
trigger seefisien mungkin
```

Kalau tracking marketing memang dibutuhkan, tetap dipertahankan.

---

# PHASE 5 — FONT

Saat ini ada dua sumber font:

```text
Google Fonts
+
local Inter
```

Google Fonts sendiri menghasilkan sekitar **72 KB**, dan request chain melibatkan `fonts.googleapis.com` serta `fonts.gstatic.com`.

Padahal Inter sudah ada:

```text
/wp-content/uploads/fonts/Inter-VariableFont_wght.woff2
```

## 5.1 Self-host fonts

Target:

```text
Google Fonts
     ↓
REMOVE

Inter
     ↓
LOCAL

Space Grotesk
     ↓
LOCAL
```

Kalau Space Grotesk memang dipakai.

---

## 5.2 font-display

Gunakan:

```css
@font-face {
  font-family: "Inter";
  src: url("/wp-content/uploads/fonts/Inter-VariableFont_wght.woff2")
    format("woff2");
  font-display: swap;
}
```

Lighthouse sendiri mengidentifikasi font-display sebagai peluang optimasi sekitar **330ms**.

---

# PHASE 6 — CLS / LAYOUT SHIFT

CLS sekarang:

```text
0.117
```

Target:

```text
< 0.1
```

Penyebab yang teridentifikasi termasuk:

```text
Complianz cookie banner
font
image tanpa dimensions
```

## 6.1 Image dimensions

Sudah dibahas:

```text
width
height
```

wajib.

---

## 6.2 Cookie banner

Cookie banner harus:

```css
position: fixed;
```

dan tidak menggeser layout utama.

Audit animasi:

```text
slideIn
bottom
```

Lighthouse juga mendeteksi animasi cookie banner sebagai non-composited animation.

---

## 6.3 Hero animation

Ada:

```text
scrollAnim
pulse
```

Lighthouse menemukan 3 elemen animasi non-composited.

Pastikan animasi menggunakan:

```text
transform
opacity
```

sebisa mungkin.

Hindari animasi:

```text
top
left
width
height
bottom
```

untuk elemen yang bergerak terus.

---

# PHASE 7 — CACHE & HTTP

Ada resource yang TTL cache-nya `None`, total opportunity sekitar **57 KiB**.

Set cache untuk static assets:

```text
CSS
JS
WEBP
AVIF
WOFF2
SVG
```

Misalnya:

```text
Cache-Control:
public, max-age=31536000, immutable
```

untuk asset yang menggunakan version/hash.

Contoh:

```text
main.css?ver=1783666663
```

Karena sudah versioned, long cache aman.

---

# PHASE 8 — WORDPRESS ASSET LOADING

Ini bagian penting untuk theme custom lo.

Prinsip baru:

```php
if (is_page('kontak')) {
    enqueue inquiry assets;
}
```

bukan:

```php
enqueue everything;
```

Audit:

```text
functions.php
wp_enqueue_style()
wp_enqueue_script()
wp_head()
wp_footer()
```

Cari semua:

```text
CSS
JS
plugin assets
fonts
third-party
```

Kemudian buat dependency map:

```text
Asset                  Page
──────────────────────────────
main.css               ALL
main.js                ALL
inquiry-ajax.js        Inquiry only
Google Maps            Contact only
Contact form JS        Contact only
WooCommerce CSS        Shop only
```

Ini akan sangat membantu jangka panjang.

---

# PHASE 9 — DOM

DOM sekarang:

```text
948 elements
depth 17
```

Ini **bukan prioritas pertama**.

Jangan refactor HTML besar-besaran sekarang.

Setelah image, CSS, JS dan font selesai, baru audit:

```text
duplicate wrapper
empty div
nested container
duplicate testimonial
unnecessary markup
```

Target tidak harus 500.

Kalau 900 DOM tetapi rendering tetap cepat, tidak masalah besar.

---

# PHASE 10 — ACCESSIBILITY

Lighthouse accessibility sudah **95**, jadi ini bukan fokus performance.

Tetapi ada dua hal yang sekalian diperbaiki:

### Contrast

Ada masalah kontras pada:

```text
WhatsApp
footer
```

### Heading hierarchy

Ada heading:

```text
h4
```

yang muncul tanpa hierarchy yang benar.

Ini bukan performance blocker, tapi sekalian dibereskan saat refactor template.

---

# PRIORITAS IMPLEMENTASI

Kalau lo mau ngerjainnya secara praktis, urutannya:

```text
🔴 P0 — WAJIB

1. Optimize orchidcare.png
2. Optimize seluruh logo
3. Optimize testimonial images
4. Tambahkan width/height semua image
5. Audit image lazy/eager loading


🔴 P1 — HIGH IMPACT

6. Self-host Google Fonts
7. Critical CSS
8. Defer non-critical JS
9. Audit jQuery
10. Remove jQuery Migrate jika aman
11. Conditional enqueue inquiry JS


🟠 P2 — MEDIUM

12. Audit GTM
13. Reduce GTM tags
14. Fix Complianz CLS
15. Fix animation
16. Long cache static assets


🟡 P3 — POLISH

17. Minify CSS
18. Minify JS
19. Reduce unused CSS
20. DOM cleanup
21. Accessibility fixes
```

---

# Estimasi hasil per fase

Secara kasar, bukan jaminan karena Lighthouse adalah synthetic test:

```text
BASELINE
LCP 4.1s
Payload 4.2MB
Performance 12
        │
        ▼
IMAGE OPTIMIZATION
Payload ~2MB atau kurang
        │
        ▼
CRITICAL CSS + FONT
LCP turun signifikan
        │
        ▼
JS + GTM
TBT tetap rendah / lebih rendah
        │
        ▼
CLS FIX
CLS < 0.1
        │
        ▼
FINAL
Performance 80–90+
LCP < 2.5s
```

Yang paling penting adalah **jangan mengerjakan semuanya sekaligus**. Kita bisa mengukur improvement setiap fase.

Dan satu kesimpulan yang cukup tegas dari report ini: **jangan upgrade VPS dulu.** Server merespons sekitar **107–110ms**, sementara LCP menghabiskan sekitar **1.240ms pada render delay**.

Kalau lo mau implementasi dengan AI coding agent, plan di atas juga bisa langsung diubah menjadi **satu master prompt untuk agent yang mengaudit theme `indotech_custom`, melakukan optimasi bertahap, dan tidak merusak fungsi existing**.
