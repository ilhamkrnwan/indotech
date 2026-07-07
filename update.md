# Ringkasan Pembaruan Sistem (Update) - Indotech Custom Theme & Core Plugin

Dokumen ini mencantumkan detail file yang berubah serta penjelasannya terkait peningkatan responsivitas mobile, pembaruan formulir inquiry B2B, dan integrasi WhatsApp redirect otomatis.

---

## Daftar File yang Berubah & Penjelasan Perubahan

### 1. Core Plugin
#### [InquiryHandler.php](file:///c:/wp-content/plugins/indotech-core/src/InquiryHandler.php)
* **Penyempurnaan Validasi & Data Capture**:
  * Menambahkan fallback input field dinamis (`contact_name`, `contact_email`, `contact_phone`, `contact_message`) untuk mendukung form kontak umum.
  * Melonggarkan validasi mandatory field (hanya mewajibkan nama lengkap).
  * Memungkinkan penyimpanan inquiry tanpa `product_id` (bernilai `null` / untuk pertanyaan non-produk).
  * Menambahkan pengecekan agar email notifikasi pelanggan hanya dikirim jika format email valid dan diisi.

---

### 2. Custom Theme Templates
#### [archive-product.php](file:///c:/wp-content/themes/indotech_custom/archive-product.php)
* **Optimasi Mobile & Tampilan Arsip**:
  * Mengubah filter kategori agar dapat di-scroll secara horizontal (`overflow-x: auto`) pada perangkat mobile untuk menghemat ruang vertikal.
  * Mengubah layout grid produk pada mobile menjadi 2 kolom dengan card produk yang lebih ringkas (compact padding, ukuran teks, dan button outline disesuaikan).
  * Memindahkan styling inline layout ke dalam blok `<style>` terstruktur.

#### [single-product.php](file:///c:/wp-content/themes/indotech_custom/single-product.php)
* **Form Inquiry Lebih Ringkas & WhatsApp Redirect**:
  * Menyederhanakan form inquiry dengan menghapus field Telepon, Perusahaan, dan Estimasi Qty agar conversion rate lebih tinggi.
  * Menambahkan tag `<style>` untuk mempercantik list deskripsi (`ol`, `ul`, `li`).
  * Menerapkan responsive layout 2 kolom produk serupa di mobile, serta penyesuaian padding pada card & box inquiry.
  * Menambahkan input hidden `product_title` untuk dikirimkan ke redirect WhatsApp.

#### [single-brand.php](file:///c:/wp-content/themes/indotech_custom/single-brand.php)
* **Pembaruan Halaman Detail Brand**:
  * Menyederhanakan formulir inquiry brand (menghapus input WhatsApp & Perusahaan).
  * Menambahkan hidden input `brand_title` untuk melacak asal brand pada redirect WhatsApp.
  * Menerapkan style responsive mobile untuk deskripsi brand, galeri foto, info box, dan form inquiry.
  * Menambahkan list styling untuk deskripsi brand.

#### [single-application.php](file:///c:/wp-content/themes/indotech_custom/single-application.php)
* **Redesain Detail Sektor Aplikasi**:
  * Menambahkan blok `<style>` terstruktur untuk menampung class layout khusus aplikasi (`app-grid-container`, `app-description-card`, `app-products-grid`, `app-cta-card`).
  * Menerapkan grid produk rekomendasi 2 kolom di mobile.
  * Mengubah CTA "Hubungi Kami" menjadi "Hubungi via WhatsApp" dengan redirect link dinamis + template pesan kustom berdasarkan sektor aplikasi.

#### [single.php](file:///c:/wp-content/themes/indotech_custom/single.php)
* **Penyempurnaan Halaman Artikel Blog**:
  * Menambahkan section "Artikel Terkait" (Related Posts) di bagian bawah artikel berdasarkan kategori yang sama (dengan fallback random).
  * Redesain hero header postingan menggunakan `inner-page-hero` dan menambahkan navigasi breadcrumb.
  * Menambahkan styling untuk list dalam artikel.

#### [page-blog.php](file:///c:/wp-content/themes/indotech_custom/page-blog.php)
* **Penyesuaian Struktur Class Pencarian**:
  * Membungkus input search dan select sorting ke dalam class wrapper `blog-search-sort-row` agar tampil berdampingan secara responsif pada perangkat mobile.

#### [page-kontak.php](file:///c:/wp-content/themes/indotech_custom/page-kontak.php)
* **Penyederhanaan Form Kontak**:
  * Menghapus input field email (`contact_email`) agar form lebih ringkas dan berfokus langsung ke redirect WhatsApp.

#### [footer.php](file:///c:/wp-content/themes/indotech_custom/footer.php)
* **Daftar Brand Dinamis**:
  * Mengubah daftar "Brand Kami" di footer agar mengambil data secara dinamis dari Custom Post Type `brand` (diurutkan berdasarkan `menu_order` ASC, mengecualikan brand "cokusi").
  * Menyediakan list statis sebagai fallback jika query post tidak mengembalikan data.

---

### 3. Assets (CSS & JS)
#### [main.css](file:///c:/wp-content/themes/indotech_custom/assets/css/main.css)
* **Style Responsive untuk Blog**:
  * Menambahkan media query `max-width: 991px` untuk menyelaraskan halaman blog archive.
  * Mengubah list artikel blog pada mobile menjadi tampilan landscape/horizontal card (aspect ratio gambar 1:1, judul dan ringkasan lebih ringkas).
  * Mengatur pencarian dan pengurutan artikel agar tampil side-by-side.
  * Mengimplementasikan panel filter kategori blog horizontal-scrolling di mobile.

#### [inquiry-ajax.js](file:///c:/wp-content/themes/indotech_custom/assets/js/inquiry-ajax.js)
* **Dinamisasi Form & Integrasi WhatsApp Redirect**:
  * Menyesuaikan fungsi validasi input data agar bersifat dinamis sesuai tipe formulir yang digunakan.
  * Menambahkan logika penanganan WhatsApp Redirect setelah pengiriman form sukses dilakukan.
  * Teks pesan WhatsApp di-generate secara dinamis dengan template berbeda untuk detail produk, brand, kontak umum, dan pendaftaran kemitraan.

---

### 4. Konfigurasi Theme
#### [functions.php](file:///c:/wp-content/themes/indotech_custom/functions.php)
* **Kenaikan Versi & Enqueue Config**:
  * Menaikkan versi theme `INDOTECH_VERSION` menjadi `2.0.3`.
  * Membaca opsi nomor WhatsApp perusahaan dari pengaturan tema (`indotech_opt`), membersihkannya dari karakter non-numerik, dan menyalurkannya ke script JS (`indotechData.whatsapp`).
