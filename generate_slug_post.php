<?php
/**
 * Script untuk menghasilkan file slug_post.txt yang lengkap dari post_artikel.json
 * Dapat dijalankan via CLI: php generate_slug_post.php
 */

$json_file = __DIR__ . '/post_artikel.json';
$txt_file  = __DIR__ . '/slug_post.txt';

if (!file_exists($json_file)) {
    die("Error: File post_artikel.json tidak ditemukan di " . __DIR__ . "\n");
}

$data = json_decode(file_get_contents($json_file), true);
$posts = $data['semua_data'] ?? array();

if (empty($posts)) {
    die("Error: Tidak ada data artikel dalam post_artikel.json!\n");
}

$out = "========================================================================\n";
$out .= "DAFTAR LENGKAP SLUG, JUDUL, SEO & REFERENSI BACKLINK ARTIKEL INDOTECH\n";
$out .= "Total Artikel : " . count($posts) . " Artikel\n";
$out .= "Di-generate   : " . date('Y-m-d H:i:s') . "\n";
$out .= "========================================================================\n\n";

$counter = 1;
foreach ($posts as $p) {
    $id        = $p['ID'] ?? '-';
    $title     = trim($p['title'] ?? 'Tanpa Judul');
    $slug      = trim($p['slug'] ?? '');
    $permalink = trim($p['permalink'] ?? ('https://indotech.id/' . $slug));
    $date      = trim($p['date'] ?? '-');

    // Extract categories
    $cat_names = array();
    if (!empty($p['categories'])) {
        foreach ($p['categories'] as $cat) {
            $cat_names[] = $cat['name'];
        }
    }
    $kategori = !empty($cat_names) ? implode(', ', $cat_names) : '-';

    // Extract SEO & Excerpt
    $seo_title = trim($p['meta']['_yoast_wpseo_title'] ?? '');
    if (empty($seo_title)) {
        $seo_title = $title;
    }

    $focus_kw = trim($p['meta']['_yoast_wpseo_focuskw'] ?? '');

    // Deskripsi Singkat: Utamakan Meta Description SEO Yoast, jika kosong gunakan Excerpt atau cuplikan Content
    $deskripsi = trim($p['meta']['_yoast_wpseo_metadesc'] ?? '');
    if (empty($deskripsi) && !empty($p['excerpt'])) {
        $deskripsi = trim(strip_tags($p['excerpt']));
    }
    if (empty($deskripsi) && !empty($p['content'])) {
        $clean_content = strip_tags($p['content']);
        $clean_content = preg_replace('/\s+/', ' ', $clean_content);
        $deskripsi = mb_substr($clean_content, 0, 200) . '...';
    }

    $baca_juga = "Baca juga: " . $title . " (" . $permalink . ")";
    $html_link = '<a href="' . $permalink . '" title="' . htmlspecialchars($title) . '">' . $title . '</a>';
    $markdown  = '[' . $title . '](' . $permalink . ')';

    $block  = "[" . $counter . "] " . $title . "\n";
    $block .= "ID Post         : " . $id . "\n";
    $block .= "Judul Artikel   : " . $title . "\n";
    $block .= "SEO Title       : " . $seo_title . "\n";
    $block .= "Slug            : " . $slug . "\n";
    $block .= "URL Backlink    : " . $permalink . "\n";
    $block .= "Kategori        : " . $kategori . "\n";
    $block .= "Tanggal Publish : " . $date . "\n";
    if ($focus_kw) {
        $block .= "Focus Keyword   : " . $focus_kw . "\n";
    }
    $block .= "Deskripsi Singkat: " . $deskripsi . "\n";
    $block .= "Format Baca Juga: " . $baca_juga . "\n";
    $block .= "Format HTML Link: " . $html_link . "\n";
    $block .= "Format Markdown : " . $markdown . "\n";
    $block .= "------------------------------------------------------------------------\n\n";

    $out .= $block;
    $counter++;
}

file_put_contents($txt_file, $out);
echo "BERHASIL: " . count($posts) . " artikel diekspor secara lengkap ke " . $txt_file . "\n";
