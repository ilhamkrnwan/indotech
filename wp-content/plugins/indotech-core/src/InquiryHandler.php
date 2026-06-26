<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

class InquiryHandler {
    /**
     * Get inquiries table name
     * @return string
     */
    public static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . 'indotech_inquiries';
    }

    /**
     * Create custom SQL database table on plugin activation
     */
    public static function create_table() {
        global $wpdb;
        $table_name = self::get_table_name();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
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
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    /**
     * Register AJAX hooks
     */
    public static function register_ajax() {
        add_action('wp_ajax_indotech_submit_inquiry', [self::class, 'handle_submit_inquiry']);
        add_action('wp_ajax_nopriv_indotech_submit_inquiry', [self::class, 'handle_submit_inquiry']);
    }

    /**
     * Handle AJAX inquiry submissions
     */
    public static function handle_submit_inquiry() {
        // 1. Verify Nonce Security (CSRF Protection)
        if (!check_ajax_referer('indotech_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => __('Sesi kedaluwarsa. Silakan muat ulang halaman.', 'indotech-core')]);
        }

        // 2. Anti-Spam: Honeypot field (should remain empty)
        if (!empty($_POST['website_url'])) {
            wp_send_json_error(['message' => __('Karakter bot terdeteksi.', 'indotech-core')]);
        }

        // 3. Sanitization & Parsing
        $name         = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
        $email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone        = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $company      = isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '';
        $quantity     = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
        $message      = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $product_id   = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;

        // 4. Validate Mandatory Fields
        if (empty($name) || empty($email) || empty($phone) || empty($product_id)) {
            wp_send_json_error(['message' => __('Mohon lengkapi semua kolom wajib.', 'indotech-core')]);
        }

        if (!is_email($email)) {
            wp_send_json_error(['message' => __('Format email bisnis tidak valid.', 'indotech-core')]);
        }

        // 5. Insert into custom database table
        global $wpdb;
        $table_name = self::get_table_name();

        $inserted = $wpdb->insert($table_name, [
            'product_id'   => $product_id,
            'full_name'    => $name,
            'email'        => $email,
            'phone'        => $phone,
            'company_name' => $company,
            'quantity'     => $quantity,
            'message'      => $message,
            'status'       => 'pending'
        ]);

        if ($inserted === false) {
            wp_send_json_error(['message' => __('Gagal menyimpan penawaran ke database.', 'indotech-core')]);
        }

        // 6. Send Emails (Dual Notification)
        $product_title = get_the_title($product_id);
        $admin_email   = get_option('_company_email', get_option('admin_email')); // Use options page email, fallback to default WP admin

        self::send_notification_emails($admin_email, $email, $name, $phone, $company, $quantity, $message, $product_title);

        wp_send_json_success([
            'message' => __('Pertanyaan Anda berhasil dikirim! Tim penjualan kami akan segera menghubungi Anda.', 'indotech-core')
        ]);
    }

    /**
     * Send HTML notification emails
     */
    private static function send_notification_emails($admin_email, $customer_email, $name, $phone, $company, $qty, $message, $product_title) {
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        // Email to Admin (Sales Team)
        $admin_subject = "Permintaan Penawaran Baru (B2B): " . $product_title;
        $admin_body = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #0057FF; border-bottom: 2px solid #EEF3FF; padding-bottom: 10px;'>Permintaan Penawaran Baru</h2>
                <p>Halo Tim Sales Indotech,</p>
                <p>Prospek B2B baru saja mengajukan penawaran harga untuk produk berikut:</p>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr><td style='padding: 8px 0; font-weight: bold; width: 40%;'>Produk:</td><td style='padding: 8px 0;'>{$product_title}</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold;'>Nama Pengirim:</td><td style='padding: 8px 0;'>{$name}</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold;'>Email:</td><td style='padding: 8px 0;'>{$customer_email}</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold;'>WhatsApp:</td><td style='padding: 8px 0;'>{$phone}</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold;'>Perusahaan:</td><td style='padding: 8px 0;'>{$company}</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold;'>Jumlah Estimasi:</td><td style='padding: 8px 0;'>{$qty} Unit</td></tr>
                    <tr><td style='padding: 8px 0; font-weight: bold; vertical-align: top;'>Pesan Khusus:</td><td style='padding: 8px 0;'>{$message}</td></tr>
                </table>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='font-size: 12px; color: #777;'>Email ini dikirim otomatis dari website official indotech.id</p>
            </div>
        </body>
        </html>";

        @wp_mail($admin_email, $admin_subject, $admin_body, $headers);

        // Email to Customer (Auto Confirmation)
        $customer_subject = "Terima Kasih Atas Permintaan Penawaran Anda - PT Indotech Berkah Abadi";
        $customer_body = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #0057FF; border-bottom: 2px solid #EEF3FF; padding-bottom: 10px;'>PT Indotech Berkah Abadi</h2>
                <p>Halo Bapak/Ibu {$name},</p>
                <p>Terima kasih telah menghubungi kami. Kami telah menerima permintaan penawaran Anda untuk produk <strong>{$product_title}</strong>.</p>
                <p>Tim penjualan B2B kami akan segera meninjau spesifikasi yang Anda kirimkan dan menghubungi Anda dalam waktu 1-2 hari kerja.</p>
                <div style='background: #F8F9FC; padding: 15px; border-radius: 6px; margin: 20px 0;'>
                    <span style='font-weight: bold; display: block; margin-bottom: 10px;'>Ringkasan Permintaan:</span>
                    <ul style='margin: 0; padding-left: 20px;'>
                        <li>Estimasi Jumlah: {$qty} Unit</li>
                        <li>Spesifikasi Kustom: {$message}</li>
                    </ul>
                </div>
                <p>Jika ada pertanyaan mendesak, silakan hubungi WhatsApp Hotline kami di nomor tertera di website.</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='font-size: 12px; color: #777;'>Hormat Kami,<br><strong>Tim B2B PT Indotech Berkah Abadi</strong></p>
            </div>
        </body>
        </html>";

        @wp_mail($customer_email, $customer_subject, $customer_body, $headers);
    }
}
