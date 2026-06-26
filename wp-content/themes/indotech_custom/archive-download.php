<?php
/**
 * Template Name: Download Center
 * Template Post Type: page, attachment
 */

get_header();

// Fetch all download categories
$terms = get_terms([
    'taxonomy'   => 'download_category',
    'hide_empty' => false
]);
?>

<div class="download-archive-wrapper" style="background: var(--surface); min-height: 100vh; padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
        
        <!-- Header -->
        <header style="margin-bottom: 50px; text-align: center;">
            <div class="section-tag" style="margin-bottom: 12px;">Perpustakaan Dokumen</div>
            <h1 style="font-size: clamp(32px, 5vw, 46px); font-weight: 700; letter-spacing: -0.04em; margin-bottom: 12px; line-height: 1.1;">Pusat Unduhan Dokumen</h1>
            <p style="color: var(--text-secondary); font-size: 16px; max-width: 600px; margin: 0 auto; line-height: 1.6;">Akses lembar data keselamatan (SDS/MSDS), sertifikat legalitas, dan katalog PDF produk resmi kami.</p>
        </header>

        <!-- Categories and Files list -->
        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
            <div style="display: flex; flex-direction: column; gap: 48px;">
                <?php foreach ($terms as $term) : 
                    // Query attachments for this category term
                    $files = get_posts([
                        'post_type'      => 'attachment',
                        'post_mime_type' => 'application/pdf',
                        'post_status'    => 'inherit',
                        'posts_per_page' => -1,
                        'tax_query'      => [
                            [
                                'taxonomy' => 'download_category',
                                'field'    => 'term_id',
                                'terms'    => $term->term_id
                            ]
                        ]
                    ]);

                    if (empty($files)) continue; // Skip empty categories
                ?>
                    <div class="download-category-block" style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 24px; letter-spacing: -0.02em; border-bottom: 2px solid var(--cobalt-pale); padding-bottom: 12px; color: var(--ink);">
                            <?php echo esc_html($term->name); ?>
                        </h2>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                            <?php foreach ($files as $file) : 
                                $file_id = $file->ID;
                                $file_url = wp_get_attachment_url($file_id);
                                $is_gated = carbon_get_post_meta($file_id, 'download_gate_active') === 'yes';
                            ?>
                                <div style="display: flex; flex-direction: column; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 20px; min-height: 140px; justify-content: space-between;">
                                    <div>
                                        <span style="font-size: 11px; font-weight: 700; color: var(--cobalt); text-transform: uppercase; display: block; margin-bottom: 6px;">DOKUMEN PDF</span>
                                        <h3 style="font-size: 15px; font-weight: 700; color: var(--ink); line-height: 1.4; margin-bottom: 8px;"><?php echo esc_html($file->post_title); ?></h3>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                        <?php if ($is_gated) : ?>
                                            <span style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Wajib Isi Formulir</span>
                                        <?php else : ?>
                                            <span style="font-size: 10px; font-weight: 700; color: #137333; text-transform: uppercase;">Akses Bebas</span>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url($file_url); ?>" <?php echo !$is_gated ? 'download' : ''; ?> class="btn btn-outline" style="font-size: 12px; padding: 6px 14px; border-color: var(--cobalt); color: var(--cobalt);">
                                            Unduh &darr;
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div style="background: var(--white); padding: 40px; border-radius: 16px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                Belum ada kategori dokumen unduhan terdaftar.
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
