# ADR-004: Arsitektur Penyimpanan Leads & Inquiry

## Status
Approved

## Context
Katalog produk PT Indotech Berkah Abadi bersifat non-transaksional (tanpa checkout e-commerce). Pengguna mengajukan pertanyaan/inquiry per produk (*Request for Quotation*). Kita memerlukan tempat penyimpanan data prospek yang aman, berkinerja tinggi, dan mudah diekspor.

Opsi penanganan leads:
1.  **WooCommerce**: Terlalu berat, memuat puluhan tabel SQL baru, merusak performa page load, dan tidak diperlukan karena transaksi tidak terjadi secara langsung.
2.  **Contact Form Plugin (Contact Form 7 / WPForms)**: Mudah digunakan, namun data leads tersimpan acak di tabel `wp_posts` / `wp_postmeta` (sebagai tipe post khusus) yang lambat untuk kueri pelaporan analitik B2B skala besar.
3.  **Custom Database Table (`wp_indotech_inquiries`)**: Membuat tabel SQL custom terdedikasi untuk data formulir.

## Decision
Kami memutuskan untuk menggunakan **Custom Database Table**:
*   Tabel SQL baru `wp_indotech_inquiries` dibuat secara otomatis saat plugin core aktif via `dbDelta`.
*   Formulir dikirim via AJAX endpoint teramankan dengan *nonce validation*.
*   Admin dashboard memiliki modul tampilan (WP_List_Table) khusus untuk mengelola status inquiry (`Pending`, `Contacted`, `Completed`) dan fitur eksport ke CSV.

## Consequences
*   **Kelebihan**: Sangat cepat, menghemat ukuran database utama WordPress, mempermudah ekspor data mentah leads ke CRM eksternal via REST API.
*   **Kekurangan**: Developer harus menulis query SQL manual untuk operasi CRUD (Create, Read, Update, Delete) dan tidak bisa memanfaatkan plugin backup form instan.
