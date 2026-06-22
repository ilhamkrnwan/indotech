<?php
/**
 * Template Name: Single Product
 * Template Post Type: product
 */

get_header();

while (have_posts()) : the_post();
    $product_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $sku = carbon_get_post_meta($product_id, 'product_sku');
    $brand_relation = carbon_get_post_meta($product_id, 'product_brand');
    $downloads = carbon_get_post_meta($product_id, 'product_downloads');
    $specs = carbon_get_post_meta($product_id, 'product_specifications');

    // Retrieve associated brand info
    $brand_id = 0;
    $brand_title = '';
    $brand_accent = '#0057FF';
    $brand_url = '#';
    if (!empty($brand_relation) && isset($brand_relation[0]['id'])) {
        $brand_id = $brand_relation[0]['id'];
        $brand_title = get_the_title($brand_id);
        $brand_accent = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
        $brand_url = get_permalink($brand_id);
    }
?>

<!-- JSON-LD B2B Product Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php echo esc_js(get_the_title()); ?>",
  "sku": "<?php echo esc_js($sku); ?>",
  "image": "<?php echo esc_js(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>",
  "description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt())); ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?php echo esc_js($brand_title); ?>"
  },
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "IDR",
    "lowPrice": "0",
    "highPrice": "0",
    "offerCount": "1",
    "url": "<?php echo esc_js(get_permalink()); ?>",
    "availability": "https://schema.org/InStock"
  },
  "manufacturer": {
    "@type": "Organization",
    "name": "PT Indotech Berkah Abadi",
    "url": "https://indotech.id"
  }
}
</script>

<div class="product-detail-wrapper" style="--brand-accent: <?php echo esc_attr($brand_accent); ?>; background: var(--surface); min-height: 100vh; padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
        
        <!-- Breadcrumbs / Navigation Back -->
        <nav class="product-breadcrumbs" style="margin-bottom: 24px; font-size: 13.5px; color: var(--text-secondary);">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--text-muted);">Beranda</a> &nbsp;/&nbsp; 
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" style="color: var(--text-muted);">Produk</a> &nbsp;/&nbsp; 
            <?php if ($brand_id) : ?>
                <a href="<?php echo esc_url($brand_url); ?>" style="color: var(--brand-accent); font-weight:600;"><?php echo esc_html($brand_title); ?></a> &nbsp;/&nbsp;
            <?php endif; ?>
            <span style="color: var(--ink); font-weight: 500;"><?php the_title(); ?></span>
        </nav>

        <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 48px; align-items: start;">
            
            <!-- ── LEFT COLUMN: Product Info, Specs, & Downloads ── -->
            <div>
                <!-- Main Header Info Card -->
                <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: var(--shadow-xs);">
                    <div style="display: flex; gap: 20px; align-items: start; flex-wrap: wrap;">
                        
                        <!-- Thumbnail -->
                        <div style="width: 140px; height: 140px; border-radius: 12px; background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                            <?php else : ?>
                                <span style="font-weight:700; color:var(--text-muted); font-size:14px;">NO IMAGE</span>
                            <?php endif; ?>
                        </div>

                        <!-- Brand & Title -->
                        <div style="flex: 1;">
                            <?php if ($sku) : ?>
                                <span style="display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 4px 10px; background: var(--surface); border-radius: 4px; border: 1px solid var(--border); margin-bottom: 12px; color: var(--text-secondary);">
                                    SKU: <?php echo esc_html($sku); ?>
                                </span>
                            <?php endif; ?>
                            <h1 style="font-size: clamp(24px, 4vw, 36px); margin-bottom: 8px; letter-spacing: -0.03em; line-height: 1.15;"><?php the_title(); ?></h1>
                            
                            <?php if ($brand_id) : ?>
                                <p style="font-size: 14px; color: var(--text-secondary); font-weight: 500;">
                                    Brand: <a href="<?php echo esc_url($brand_url); ?>" style="color: var(--brand-accent); font-weight: 600;"><?php echo esc_html($brand_title); ?></a>
                                </p>
                            <?php endif; ?>
                        </div>

                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">

                    <!-- Product Description Content -->
                    <div class="product-description" style="color: var(--text-secondary); line-height: 1.8; font-size: 15px;">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Technical Specifications Card -->
                <?php if (!empty($specs)) : ?>
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 24px; letter-spacing: -0.02em; border-bottom: 1px solid var(--border); padding-bottom: 12px;">Spesifikasi Teknis</h2>
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14.5px;">
                            <tbody>
                                <?php foreach ($specs as $spec) : 
                                    if (empty($spec['spec_name'])) continue;
                                ?>
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 14px 10px 14px 0; font-weight: 600; color: var(--ink); width: 35%;"><?php echo esc_html($spec['spec_name']); ?></td>
                                        <td style="padding: 14px 10px; color: var(--text-secondary);"><?php echo esc_html($spec['spec_value']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Related Downloads Card -->
                <?php if (!empty($downloads)) : ?>
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-xs);">
                        <h2 style="font-size: 20px; margin-bottom: 20px; letter-spacing: -0.02em; border-bottom: 1px solid var(--border); padding-bottom: 12px;">Brosur & Dokumen Teknis</h2>
                        <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 20px;">Silakan unduh dokumen panduan keselamatan (SDS) atau katalog teknis berikut:</p>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <?php 
                            foreach ($downloads as $dl) : 
                                $dl_id = $dl['id'];
                                $dl_url = wp_get_attachment_url($dl_id);
                                $dl_title = get_the_title($dl_id);
                                $is_gated = carbon_get_post_meta($dl_id, 'download_gate_active') === 'yes';
                            ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 16px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <!-- PDF Icon representation -->
                                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(255,0,0,0.1); color: red; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">PDF</div>
                                        <div>
                                            <span style="font-size: 14px; font-weight: 600; color: var(--ink); display: block;"><?php echo esc_html($dl_title); ?></span>
                                            <?php if ($is_gated) : ?>
                                                <span style="font-size: 10px; color: var(--brand-accent); font-weight: 600; text-transform: uppercase;">Wajib Isi Form Prospek</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a href="<?php echo esc_url($dl_url); ?>" <?php echo !$is_gated ? 'download' : ''; ?> class="btn btn-outline" style="font-size: 12px; padding: 8px 16px; border-color: var(--brand-accent); color: var(--brand-accent);">
                                        Unduh File
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- ── RIGHT COLUMN: STICKY B2B INQUIRY FORM ── -->
            <aside style="position: sticky; top: calc(var(--header-h) + 20px); z-index: 10;">
                <div style="background: var(--white); border: 1px solid var(--brand-accent); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-md);">
                    <h3 style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 8px; letter-spacing: -0.02em;">Request for Quotation</h3>
                    <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 24px;">Hubungi tim penjualan B2B kami untuk konsultasi formula, harga grosir, atau kemitraan maklon.</p>

                    <!-- Inquiry Form -->
                    <form id="indotech-inquiry-form" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
                        <!-- Hidden inputs -->
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                        <input type="text" name="website_url" value="" style="display: none;" tabindex="-1" autocomplete="off"> <!-- Honeypot -->

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nama Lengkap *</label>
                            <input type="text" name="full_name" placeholder="Masukkan nama Anda" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Email Bisnis *</label>
                            <input type="email" name="email" placeholder="nama@perusahaan.com" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nomor WA / Telepon *</label>
                            <input type="tel" name="phone" placeholder="Contoh: 0812345678" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Perusahaan</label>
                                <input type="text" name="company_name" placeholder="PT / CV" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Estimasi Qty (Unit)</label>
                                <input type="number" name="quantity" min="1" value="1" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Pesan Kustom / Spesifikasi</label>
                            <textarea name="message" placeholder="Tuliskan spesifikasi khusus, aroma, atau detail kemasan yang diinginkan..." rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 11px 14px; font-family: inherit; font-size: 14px; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--brand-accent); border-color: var(--brand-accent); padding: 14px;">
                            Kirim Penawaran &rarr;
                        </button>
                    </form>

                    <!-- Alert Feedback Box -->
                    <div id="indotech-inquiry-response" style="display: none; margin-top: 16px; padding: 14px 18px; border-radius: 8px; font-size: 13.5px; line-height: 1.45; font-weight: 500;"></div>
                </div>
            </aside>

        </div>
    </div>
</div>

<?php
endwhile;

get_footer();
