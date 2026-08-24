<?php
/**
 * Script Konversi produk.json menjadi katalog teks compact product.txt
 */

$json_file = __DIR__ . '/produk.json';
$txt_file  = __DIR__ . '/product.txt';

if (!file_exists($json_file)) {
    die("File produk.json tidak ditemukan di " . __DIR__ . "\n");
}

$data = json_decode(file_get_contents($json_file), true);
if (!isset($data['semua_data'])) {
    die("Format produk.json tidak valid!\n");
}

$products = $data['semua_data'];
$out = "================================================================================\n";
$out .= "KATALOG PRODUK INDOTECH (TOTAL: " . count($products) . " PRODUK)\n";
$out .= "================================================================================\n\n";

$counter = 1;
foreach ($products as $p) {
    $title     = trim($p['title'] ?? 'Tanpa Judul');
    $slug      = trim($p['slug'] ?? '');
    $link      = "https://indotech.id/products/" . $slug;
    $sku       = trim($p['sku'] ?? ($p['meta']['_product_sku'] ?? ''));

    // Extract categories
    $cat_names = array();
    if (!empty($p['product_terms']['product_cat'])) {
        foreach ($p['product_terms']['product_cat'] as $cat) {
            $cat_names[] = html_entity_decode($cat['name']);
        }
    }
    $kategori = !empty($cat_names) ? implode(', ', $cat_names) : '-';

    // Raw HTML content
    $raw_content = $p['content'] ?? '';
    $raw_content = html_entity_decode($raw_content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Replace <h3>, <h2>, <h1> headers with compact section tags [SECTION TITLE]
    $content_formatted = preg_replace_callback('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/i', function($m) {
        $sec_title = strtoupper(trim(strip_tags($m[1])));
        return "\n[" . $sec_title . "]\n";
    }, $raw_content);

    // Replace list items <li> to bullets •
    $content_formatted = preg_replace('/<li[^>]*>/i', '• ', $content_formatted);
    $content_formatted = preg_replace('/<\/li>/i', "\n", $content_formatted);

    // Replace <ol> items if numbered
    $content_formatted = preg_replace('/<\/p>/i', "\n", $content_formatted);
    $content_formatted = preg_replace('/<br\s*\/?>/i', "\n", $content_formatted);

    // Strip remaining HTML tags
    $clean_text = strip_tags($content_formatted);

    // Process line by line to remove unwanted empty lines
    $lines = explode("\n", $clean_text);
    $compact_lines = array();
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed !== '') {
            $compact_lines[] = $trimmed;
        }
    }

    // Reconstruct with smart line spacing (blank line ONLY before new [SECTION])
    $final_content = "";
    foreach ($compact_lines as $line) {
        if (preg_match('/^\[.*\]$/', $line)) {
            $final_content .= "\n" . $line . "\n";
        } else {
            $final_content .= $line . "\n";
        }
    }
    $final_content = trim($final_content);

    // Extract Specifications from meta
    $specs = array();
    if (!empty($p['meta']['_product_specifications']) && is_array($p['meta']['_product_specifications'])) {
        foreach ($p['meta']['_product_specifications'] as $sp) {
            if (isset($sp['spec_name']) && isset($sp['spec_value'])) {
                $specs[] = "• " . trim($sp['spec_name']) . ": " . trim($sp['spec_value']);
            }
        }
    }

    // Build compact product block string
    $block  = "================================================================================\n";
    $block .= "#" . sprintf('%02d', $counter) . " | " . strtoupper($title) . "\n";
    $block .= "Link    : " . $link . "\n";
    $block .= "Kategori: " . $kategori . ($sku ? " | SKU: " . $sku : "") . "\n";
    $block .= "--------------------------------------------------------------------------------\n";
    $block .= $final_content . "\n";

    if (!empty($specs)) {
        $block .= "\n[SPESIFIKASI TAMBAHAN]\n";
        $block .= implode("\n", $specs) . "\n";
    }

    $block .= "\n";
    $out .= $block;
    $counter++;
}

file_put_contents($txt_file, $out);
echo "BERHASIL: " . count($products) . " produk dikonversi dengan format compact ke " . $txt_file . "\n";
