<?php
/**
 * Template Name: Cookie Policy
 *
 * Template halaman Cookie Policy PT Indotech Berkah Abadi.
 */

if ( ! function_exists( 'indotech_extract_headings' ) ) {
    function indotech_extract_headings( $content ) {
        preg_match_all( '/<h([2-3])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER );
        $headings = [];
        foreach ( $matches as $m ) {
            $text   = wp_strip_all_tags( $m[2] );
            $anchor = sanitize_title( $text );
            $level  = (int) $m[1];
            $headings[] = compact( 'text', 'anchor', 'level' );
        }
        return $headings;
    }
}

if ( ! function_exists( 'indotech_add_heading_ids' ) ) {
    function indotech_add_heading_ids( $content ) {
        return preg_replace_callback(
            '/<h([2-3])([^>]*)>(.*?)<\/h\1>/i',
            function ( $m ) {
                $text   = wp_strip_all_tags( $m[3] );
                $anchor = sanitize_title( $text );
                $attrs  = $m[2];
                if ( strpos( $attrs, 'id=' ) === false ) {
                    $attrs .= ' id="' . esc_attr( $anchor ) . '"';
                }
                return "<h{$m[1]}{$attrs}>{$m[3]}</h{$m[1]}>";
            },
            $content
        );
    }
}

get_header();

$page_title   = get_the_title();
$page_content = '';
$headings     = [];

$default_content = '
<h2>1. Pengertian Cookie</h2>
<p>Cookie adalah file teks kecil berisi data unik yang dikirimkan oleh server situs web ke peramban (<em>browser</em>) komputer atau perangkat seluler Anda saat Anda mengunjungi situs tersebut. Cookie disimpan di penyimpanan lokal perangkat Anda agar situs web dapat mengenali perangkat Anda dan mengingat preferensi Anda pada kunjungan berikutnya.</p>

<h2>2. Alasan Kami Menggunakan Cookie</h2>
<p>PT Indotech Berkah Abadi menggunakan cookie untuk meningkatkan kualitas penelusuran situs web B2B kami dan mempermudah operasional transaksi Anda. Cookie membantu kami mendeteksi masalah teknis, mempercepat waktu pemuatan halaman, dan mengenali apakah Anda adalah calon mitra yang telah mengisi inquiry formulir kontak sebelumnya.</p>

<h2>3. Kategori Cookie yang Kami Gunakan</h2>
<p>Situs web kami memanfaatkan beberapa kategori cookie berikut demi menyajikan pengalaman web yang optimal:</p>
<h3>A. Cookie Mutlak Diperlukan (Essential Cookies)</h3>
<p>Cookie ini sangat penting untuk memungkinkan Anda menjelajahi situs web dan menggunakan fitur keamanan dasarnya. Tanpa cookie ini, fungsi-fungsi krusial seperti pemeliharaan sesi login kemitraan B2B atau validasi formulir inquiry tidak dapat berjalan.</p>
<h3>B. Cookie Analisis dan Performa (Analytics Cookies)</h3>
<p>Cookie ini mengumpulkan informasi tentang cara pengunjung berinteraksi dengan situs web kami secara anonim (misalnya halaman mana yang paling sering dikunjungi dan apakah ada pesan kesalahan). Kami menggunakan data ini (seperti Google Analytics) untuk mengoptimalkan navigasi dan tata letak situs web.</p>
<h3>C. Cookie Fungsional (Preference Cookies)</h3>
<p>Cookie ini memungkinkan situs web kami untuk mengingat pilihan yang Anda buat (seperti preferensi bahasa, filter produk yang dipilih, atau ukuran layar) untuk memberikan pengalaman yang lebih personal.</p>
<h3>D. Cookie Pemasaran dan Target (Marketing Cookies)</h3>
<p>Cookie ini melacak kebiasaan menjelajah Anda untuk membantu kami menyajikan iklan promosi yang relevan dengan minat bisnis B2B Anda (misalnya Facebook Pixel). Cookie ini juga membatasi berapa kali Anda melihat iklan yang sama untuk meningkatkan kenyamanan visual Anda.</p>

<h2>4. Mengontrol dan Menonaktifkan Cookie</h2>
<p>Anda memiliki hak penuh untuk menyetujui, menolak, atau menghapus cookie yang tersimpan di perangkat Anda. Sebagian besar browser web secara otomatis menerima cookie, tetapi Anda dapat mengubah pengaturan browser Anda untuk menolaknya:</p>
<ul>
    <li><strong>Google Chrome:</strong> Masuk ke <em>Setelan &gt; Privasi dan Keamanan &gt; Cookie dan Data Situs Lainnya</em>.</li>
    <li><strong>Safari (Mac/iOS):</strong> Buka <em>Preferences &gt; Privacy &gt; Block all cookies</em>.</li>
    <li><strong>Mozilla Firefox:</strong> Buka <em>Pengaturan &gt; Privasi &amp; Keamanan &gt; Cookie dan Data Situs</em>.</li>
    <li><strong>Microsoft Edge:</strong> Masuk ke <em>Settings &gt; Cookies and site permissions</em>.</li>
</ul>
<p>Harap diperhatikan bahwa jika Anda menonaktifkan cookie tertentu, beberapa bagian atau fitur interaktif di situs web B2B kami (seperti validasi inquiry form atau fitur filter katalog) mungkin tidak dapat berfungsi dengan sempurna.</p>

<h2>5. Pembaruan Kebijakan Cookie</h2>
<p>Kami dapat memperbarui Kebijakan Cookie ini dari waktu ke waktu untuk mencerminkan perubahan teknologi atau regulasi pelindungan data pribadi yang berlaku di Indonesia. Setiap pembaruan akan dipasang pada halaman ini dengan tanggal pembaruan yang disesuaikan.</p>
';

if ( have_posts() ) {
    the_post();
    $raw_content = get_the_content();
    if ( empty( trim( $raw_content ) ) ) {
        $raw_content = $default_content;
    }
    $page_content = apply_filters( 'the_content', indotech_add_heading_ids( $raw_content ) );
    $headings     = indotech_extract_headings( $raw_content );
}

$last_updated    = get_the_modified_date( 'd F Y' ) ?: date( 'd F Y' );
$reading_minutes = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( $page_content ) ) / 200 ) );

get_template_part(
    'template-parts/static/legal-doc',
    null,
    [
        'title'           => $page_title,
        'content'         => $page_content,
        'headings'        => $headings,
        'last_updated'    => $last_updated,
        'active_slug'     => 'cookie-policy',
        'reading_minutes' => $reading_minutes,
        'subtitle'        => 'Penjelasan penggunaan cookie esensial, analitik, fungsional, serta kontrol pengaturan preferensi di peramban Anda.',
    ]
);

get_footer();
