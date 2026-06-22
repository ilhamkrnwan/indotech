# 008: Inquiry & Lead Generation Module

Modul Inquiry menyediakan jalur bagi pelanggan B2B untuk mengirimkan Request for Quotation (RFQ) atau pertanyaan teknis terkait produk secara instan tanpa WooCommerce.

## 1. Custom Database Table (`wp_indotech_inquiries`)
Tabel SQL dibuat menggunakan engine `dbDelta` pada inisialisasi plugin:
```sql
CREATE TABLE wp_indotech_inquiries (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  product_id bigint(20) DEFAULT NULL,
  full_name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  phone varchar(30) NOT NULL,
  company_name varchar(150) DEFAULT NULL,
  quantity int(11) DEFAULT 1,
  message text DEFAULT NULL,
  status varchar(20) DEFAULT 'pending', -- pending, contacted, completed
  created_at datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## 2. Alur Pengiriman AJAX
1.  **Form Submit**: Pengunjung mengklik "Kirim Penawaran" pada form inquiry produk.
2.  **JS Capturing**: JavaScript mencegah behavior default form, melampirkan CSRF nonce token, dan mengirim data via AJAX ke `action: indotech_submit_inquiry`.
3.  **Spam Filter (Honeypot)**: Backend memeriksa input field tersembunyi `website_url`. Jika field ini memiliki isi (yang biasanya diisi bot otomatis), request digugurkan seketika.
4.  **SQL Insert & Email Notification**:
    *   Data masuk ke `wp_indotech_inquiries` via `wpdb->insert()`.
    *   Sistem memicu `wp_mail()` mengirim email notifikasi HTML ke tim penjualan Indotech dan email konfirmasi terima ke pengirim.
5.  **JSON Return**: Mengirimkan status sukses untuk menampilkan pesan terima kasih di UI frontend.

## 3. Modul Management Leads di WP Admin
Di dalam plugin `indotech-core` (`src/AdminDashboard.php`), kita mengemas class extend `WP_List_Table` bawaan WordPress untuk menampilkan leads secara terstruktur:
*   Paginasi query leads langsung dari database.
*   Filter filter status leads.
*   Tombol tindakan aksi cepat (Tandai "Sudah Dihubungi" / "Selesai").
*   Fungsi ekspor data prospek terpilih ke file spreadsheet CSV.
