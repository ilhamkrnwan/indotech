<?php
/**
 * Template Name: Syarat & Ketentuan
 *
 * Template halaman Syarat & Ketentuan (Terms of Use) PT Indotech Berkah Abadi.
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
<h2>1. Ketentuan Umum & Penerimaan</h2>
<p>Selamat datang di situs web PT Indotech Berkah Abadi. Dengan mengakses, menelusuri, atau bertransaksi di situs web kami, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui untuk terikat secara hukum oleh Syarat & Ketentuan ini.</p>
<p>Situs web ini dirancang khusus untuk keperluan transaksi Business-to-Business (B2B). Pengguna situs ini wajib bertindak atas nama badan usaha (PT, CV, UD, koperasi, atau usaha dagang perorangan) yang sah di bawah hukum Republik Indonesia.</p>

<h2>2. Akun Kemitraan B2B & Pendaftaran</h2>
<p>Untuk mendapatkan akses penuh ke katalog harga grosir khusus, penawaran eksklusif, dan sistem kemitraan keagenan, Anda mungkin diwajibkan melakukan pendaftaran akun kemitraan B2B:</p>
<ul>
    <li>Anda bertanggung jawab menjaga kerahasiaan kredensial login (username dan password) akun kemitraan Anda.</li>
    <li>Anda setuju untuk memberikan data legalitas usaha (NIB, NPWP, atau SIUP jika diminta) yang valid dan akurat demi kelancaran verifikasi administratif B2B.</li>
    <li>PT Indotech Berkah Abadi berhak menolak pendaftaran akun atau menonaktifkan akun kemitraan yang terindikasi melakukan penyalahgunaan atau tindakan kecurangan.</li>
</ul>

<h2>3. Pemesanan, Harga Grosir, & Pembayaran</h2>
<p>Seluruh transaksi grosir B2B diatur oleh ketentuan pemesanan sebagai berikut:</p>
<ul>
    <li><strong>Inquiry Harga:</strong> Harga produk yang tertera di situs bersifat estimasi dasar B2B. Harga final grosir ditentukan berdasarkan volume pesanan dan kesepakatan tertulis yang diterbitkan melalui penawaran harga resmi (<em>Quotation</em>).</li>
    <li><strong>Termin Pembayaran (TOP):</strong> Metode pembayaran standar adalah transfer bank lunas sebelum pengiriman (CBD - <em>Cash Before Delivery</em>), kecuali telah disetujui kesepakatan tertulis mengenai termin pembayaran (<em>Term of Payment</em>) untuk akun distributor tertentu.</li>
    <li><strong>Mata Uang & Pajak:</strong> Seluruh harga disajikan dalam mata uang Rupiah (IDR). Penyesuaian pajak pertambahan nilai (PPN) akan disesuaikan dengan faktur pajak resmi perusahaan sesuai undang-undang perpajakan Indonesia.</li>
</ul>

<h2>4. Kebijakan Pengiriman dan Penyerahan Barang</h2>
<p>Pengiriman produk homecare dan laundry dalam skala grosir diatur dengan ketentuan:</p>
<ul>
    <li><strong>Syarat Pengiriman:</strong> Pengiriman dapat dilakukan secara Franco (biaya kirim ditanggung penjual ke gudang pembeli dengan syarat minimum order tertentu) atau Loco (diambil langsung dari gudang produksi Indotech di Sleman, Yogyakarta).</li>
    <li><strong>Waktu Pengiriman:</strong> Jadwal pengiriman barang disepakati setelah bukti transfer pembayaran divalidasi oleh tim keuangan kami. Kami tidak bertanggung jawab atas keterlambatan yang disebabkan oleh pihak ekspedisi kargo eksternal.</li>
    <li><strong>Pemeriksaan Fisik:</strong> Mitra wajib memeriksa kondisi segel drum/kemasan produk saat serah terima barang dari kurir. Segala bentuk kerusakan fisik pengiriman harus langsung dicatat pada berita acara serah terima (surat jalan) dan difoto sebagai bukti klaim.</li>
</ul>

<h2>5. Kebijakan Retur dan Garansi Produk</h2>
<p>Sebagai produsen berstandar tinggi, kami menjamin seluruh mutu produk kami:</p>
<ul>
    <li>Klaim retur produk hanya diterima jika terjadi cacat produksi dari pabrik (misalnya kebocoran segel mesin, ketidaksesuaian formula produk, atau salah kirim varian).</li>
    <li>Laporan kerusakan atau ketidaksesuaian barang harus diajukan maksimal <strong>2×24 jam</strong> sejak produk diterima oleh gudang Anda, dengan menyertakan video unboxing resmi dan nomor batch produksi.</li>
    <li>Kami akan mengganti produk yang cacat dengan produk baru yang sesuai setelah proses verifikasi tim quality control kami selesai.</li>
</ul>

<h2>6. Hak Kekayaan Intelektual</h2>
<p>Semua materi di situs web ini, termasuk desain visual, teks, nama brand dagang (<strong>Cleanique Academy, Cleanique Lab, Cleanique Mart, Depo Cleanique, Malabeez, Orchid Care, Prokopi</strong>), logo perusahaan PT. Indotech Berkah Abadi, grafis, dan kode pemrograman adalah hak cipta milik kami. Penggunaan komersial, reproduksi, atau modifikasi konten tanpa izin tertulis dari direksi PT Indotech Berkah Abadi sangat dilarang dan dapat dituntut secara hukum.</p>

<h2>7. Hukum yang Berlaku & Resolusi Perselisihan</h2>
<p>Syarat &amp; Ketentuan ini diatur dan ditafsirkan berdasarkan hukum Negara Kesatuan Republik Indonesia. Setiap perselisihan, sengketa dagang, atau tuntutan hukum yang timbul terkait dengan layanan dan produk PT Indotech Berkah Abadi akan diselesaikan secara musyawarah mufakat terlebih dahulu. Apabila tidak tercapai mufakat, perselisihan akan diselesaikan melalui <strong>Pengadilan Negeri Sleman</strong>, Daerah Istimewa Yogyakarta.</p>
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
        'active_slug'     => 'syarat-ketentuan',
        'reading_minutes' => $reading_minutes,
        'subtitle'        => 'Ketentuan pemesanan grosir, kemitraan B2B, pengiriman kargo, hak kekayaan intelektual, dan garansi mutu Indotech.',
    ]
);

get_footer();
