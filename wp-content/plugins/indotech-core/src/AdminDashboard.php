<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

class AdminDashboard {
    /**
     * Initialize Admin Dashboard Hooks
     */
    public static function register() {
        add_action('admin_menu', [self::class, 'register_admin_menu']);
        add_action('admin_init', [self::class, 'handle_csv_export']);
    }

    /**
     * Register Admin Menu Page
     */
    public static function register_admin_menu() {
        add_menu_page(
            __('Inquiry Masuk', 'indotech-core'),
            __('Inquiry Masuk', 'indotech-core'),
            'manage_options',
            'indotech-inquiries',
            [self::class, 'render_inquiries_page'],
            'dashicons-email-alt',
            56
        );
    }

    /**
     * Export database leads to CSV format
     */
    public static function handle_csv_export() {
        if (!is_admin() || !current_user_can('manage_options')) {
            return;
        }

        if (isset($_GET['page']) && $_GET['page'] === 'indotech-inquiries' && isset($_GET['action']) && $_GET['action'] === 'export_csv') {
            global $wpdb;
            $table_name = InquiryHandler::get_table_name();
            
            // Validate nonce
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'indotech_export_csv')) {
                wp_die(__('Akses ditolak.', 'indotech-core'));
            }

            $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC", ARRAY_A);

            // Set CSV headers
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=inquiries_indotech_' . date('Y-m-d') . '.csv');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');
            
            // Add column titles
            fputcsv($output, [
                'ID',
                'Nama Lengkap',
                'Email',
                'Nomor Phone/WA',
                'Perusahaan',
                'Nama Produk',
                'Estimasi Qty',
                'Pesan',
                'Status',
                'Tanggal Masuk'
            ]);

            if (!empty($results)) {
                foreach ($results as $row) {
                    $product_name = get_the_title($row['product_id']) ?: 'Produk Dihapus';
                    fputcsv($output, [
                        $row['id'],
                        $row['full_name'],
                        $row['email'],
                        $row['phone'],
                        $row['company_name'],
                        $product_name,
                        $row['quantity'],
                        $row['message'],
                        strtoupper($row['status']),
                        $row['created_at']
                    ]);
                }
            }
            fclose($output);
            exit;
        }
    }

    /**
     * Render Admin Dashboard Inquiries Page
     */
    public static function render_inquiries_page() {
        global $wpdb;
        $table_name = InquiryHandler::get_table_name();

        // 1. Process Actions (Status update or Delete)
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id = absint($_GET['id']);
            $action = sanitize_text_field($_GET['action']);

            if ($action === 'status_contacted' && wp_verify_nonce($_GET['_wpnonce'], 'indotech_action_' . $id)) {
                $wpdb->update($table_name, ['status' => 'contacted'], ['id' => $id]);
                echo '<div class="notice notice-success is-dismissible"><p>' . __('Status diperbarui menjadi Dihubungi.', 'indotech-core') . '</p></div>';
            }
            if ($action === 'status_completed' && wp_verify_nonce($_GET['_wpnonce'], 'indotech_action_' . $id)) {
                $wpdb->update($table_name, ['status' => 'completed'], ['id' => $id]);
                echo '<div class="notice notice-success is-dismissible"><p>' . __('Status diperbarui menjadi Selesai.', 'indotech-core') . '</p></div>';
            }
            if ($action === 'delete' && wp_verify_nonce($_GET['_wpnonce'], 'indotech_action_' . $id)) {
                $wpdb->delete($table_name, ['id' => $id]);
                echo '<div class="notice notice-warning is-dismissible"><p>' . __('Data inquiry berhasil dihapus.', 'indotech-core') . '</p></div>';
            }
        }

        // 2. Fetch Filter Status
        $active_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
        $where_clause = "";
        if (in_array($active_status, ['pending', 'contacted', 'completed'])) {
            $where_clause = $wpdb->prepare("WHERE status = %s", $active_status);
        }

        // 3. Fetch logs
        $results = $wpdb->get_results("SELECT * FROM $table_name $where_clause ORDER BY id DESC");
        $export_url = wp_nonce_url(admin_url('admin.php?page=indotech-inquiries&action=export_csv'), 'indotech_export_csv');
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Inquiry & Leads Masuk B2B', 'indotech-core'); ?></h1>
            <a href="<?php echo esc_url($export_url); ?>" class="page-title-action"><?php _e('Export ke CSV', 'indotech-core'); ?></a>
            <hr class="wp-header-end">

            <!-- Status Tabs Navigation -->
            <ul class="subsubsub">
                <li><a href="<?php echo admin_url('admin.php?page=indotech-inquiries'); ?>" class="<?php echo $active_status === 'all' ? 'current' : ''; ?>"><?php _e('Semua', 'indotech-core'); ?></a> |</li>
                <li><a href="<?php echo admin_url('admin.php?page=indotech-inquiries&status=pending'); ?>" class="<?php echo $active_status === 'pending' ? 'current' : ''; ?>"><?php _e('Pending', 'indotech-core'); ?></a> |</li>
                <li><a href="<?php echo admin_url('admin.php?page=indotech-inquiries&status=contacted'); ?>" class="<?php echo $active_status === 'contacted' ? 'current' : ''; ?>"><?php _e('Dihubungi', 'indotech-core'); ?></a> |</li>
                <li><a href="<?php echo admin_url('admin.php?page=indotech-inquiries&status=completed'); ?>" class="<?php echo $active_status === 'completed' ? 'current' : ''; ?>"><?php _e('Selesai', 'indotech-core'); ?></a></li>
            </ul>

            <form method="get" style="clear: both;">
                <div style="overflow-x: auto; margin-top: 15px; margin-bottom: 15px;">
                    <table class="wp-list-table widefat striped table-view-list" style="min-width: 1000px; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px; vertical-align: middle;">ID</th>
                                <th style="width: 150px; vertical-align: middle;">Nama Pengirim</th>
                                <th style="width: 180px; vertical-align: middle;">Kontak (Email / Phone)</th>
                                <th style="width: 130px; vertical-align: middle;">Perusahaan</th>
                                <th style="width: 180px; vertical-align: middle;">Produk Target</th>
                                <th style="width: 60px; text-align: center; vertical-align: middle;">Qty</th>
                                <th style="vertical-align: middle;">Pesan</th>
                                <th style="width: 100px; vertical-align: middle;">Status</th>
                                <th style="width: 160px; text-align: center; vertical-align: middle;">Tanggal Masuk</th>
                                <th style="width: 200px; text-align: right; vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($results)) : ?>
                                <?php foreach ($results as $row) : 
                                    $p_name = get_the_title($row->product_id) ?: '<em style="color:red;">Produk Dihapus</em>';
                                    $badge_color = '';
                                    if ($row->status === 'pending') $badge_color = '#C5221F'; // Red
                                    if ($row->status === 'contacted') $badge_color = '#E37400'; // Orange
                                    if ($row->status === 'completed') $badge_color = '#137333'; // Green
                                    
                                    $nonce_url = 'indotech_action_' . $row->id;
                                ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?php echo esc_html($row->id); ?></td>
                                        <td style="vertical-align: middle;"><strong><?php echo esc_html($row->full_name); ?></strong></td>
                                        <td style="vertical-align: middle;">
                                            <a href="mailto:<?php echo esc_attr($row->email); ?>"><?php echo esc_html($row->email); ?></a><br>
                                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $row->phone)); ?>" target="_blank" style="color: #25D366; font-weight: 600;">WA: <?php echo esc_html($row->phone); ?></a>
                                        </td>
                                        <td style="vertical-align: middle;"><?php echo esc_html($row->company_name ?: '-'); ?></td>
                                        <td style="vertical-align: middle;"><strong><?php echo $p_name; ?></strong></td>
                                        <td style="text-align: center; vertical-align: middle;"><?php echo esc_html($row->quantity); ?></td>
                                        <td style="vertical-align: middle;"><span style="font-size: 12.5px; color: #555;"><?php echo nl2br(esc_html($row->message)); ?></span></td>
                                        <td style="vertical-align: middle;">
                                            <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-weight: 700; font-size: 11px; color: white; background: <?php echo $badge_color; ?>;">
                                                <?php echo strtoupper($row->status); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: center; font-size: 12px; vertical-align: middle;"><?php echo esc_html($row->created_at); ?></td>
                                        <td style="text-align: right; vertical-align: middle;">
                                            <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                                <?php if ($row->status === 'pending') : ?>
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=indotech-inquiries&action=status_contacted&id=' . $row->id), $nonce_url)); ?>" class="button button-secondary"><?php _e('Hubungi', 'indotech-core'); ?></a>
                                                <?php endif; ?>
                                                <?php if ($row->status !== 'completed') : ?>
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=indotech-inquiries&action=status_completed&id=' . $row->id), $nonce_url)); ?>" class="button button-primary"><?php _e('Selesai', 'indotech-core'); ?></a>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=indotech-inquiries&action=delete&id=' . $row->id), $nonce_url)); ?>" class="button delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="color: red; border-color: red;"><?php _e('Hapus', 'indotech-core'); ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 30px; color: #777;">
                                        <?php _e('Tidak ada leads inquiry ditemukan.', 'indotech-core'); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <?php
    }
}
