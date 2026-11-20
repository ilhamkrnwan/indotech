<?php
/**
 * Template Name: Privacy Policy
 *
 * Template halaman Kebijakan Privasi PT Indotech Berkah Abadi.
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
<h2>1. Komitmen Privasi Kami</h2>
<p>PT Indotech Berkah Abadi ("kami", "Indotech") selaku penyedia platform B2B dan produsen produk kebersihan berkomitmen penuh untuk melindungi privasi setiap pelanggan, mitra distribusi, dan pengunjung situs web kami. Kebijakan Privasi ini disusun berdasarkan regulasi pelindungan data yang berlaku di Republik Indonesia, termasuk Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP).</p>
<p>Kebijakan ini bertujuan untuk menjelaskan secara transparan bagaimana kami mengumpulkan, menyimpan, memproses, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan B2B kami.</p>

<h2>2. Jenis Data yang Kami Kumpulkan</h2>
<p>Dalam menjalankan operasional bisnis B2B dan kemitraan grosir, kami mengumpulkan beberapa kategori data pribadi dari Anda:</p>
<h3>A. Data Identitas dan Kontak Mitra</h3>
<p>Nama lengkap penanggung jawab bisnis, alamat email perusahaan/pribadi, nomor telepon resmi, nomor WhatsApp aktif, jabatan di perusahaan, serta kartu identitas (KTP/NPWP) jika diperlukan untuk proses legalitas kemitraan B2B.</p>
<h3>B. Data Profil Bisnis dan Legalitas</h3>
<p>Nama badan usaha (PT/CV/UD), alamat kantor pusat, alamat pengiriman gudang/Franco, dokumen legalitas usaha (NIB, SIUP) untuk verifikasi kelayakan distribusi produk.</p>
<h3>C. Data Keuangan dan Transaksi</h3>
<p>Detail rekening bank pengirim, informasi bukti transfer pembayaran, riwayat pesanan produk (Cleanique Academy, Cleanique Lab, Cleanique Mart, Depo Cleanique, Malabeez, Orchid Care, Prokopi), total volume pembelian, serta status penawaran harga (<em>price inquiry</em>).</p>
<h3>D. Data Teknis dan Kunjungan Web</h3>
<p>Alamat IP (<em>Internet Protocol</em>), tipe peramban web (<em>browser</em>), zona waktu, sistem operasi yang digunakan, aktivitas kunjungan halaman (<em>clickstream</em>), durasi kunjungan, serta informasi yang diperoleh melalui cookie analitis.</p>

<h2>3. Metode Pengumpulan Data Pribadi</h2>
<p>Kami mengumpulkan data Anda melalui beberapa cara:</p>
<ul>
    <li><strong>Interaksi Langsung:</strong> Saat Anda mengisi Formulir Kemitraan, Formulir Kontak, atau mengajukan penawaran harga grosir di situs web kami.</li>
    <li><strong>Komunikasi Resmi:</strong> Pesan dan data yang Anda kirimkan kepada kami melalui layanan pelanggan WhatsApp resmi, panggilan telepon, atau surat elektronik (email).</li>
    <li><strong>Teknologi Otomatis:</strong> Data teknis kunjungan yang terekam secara otomatis oleh server web dan sistem analitis saat Anda menjelajahi halaman web kami.</li>
</ul>

<h2>4. Tujuan Pemrosesan dan Penggunaan Data</h2>
<p>Data pribadi yang terkumpul diproses demi kelancaran administrasi B2B, hukum, dan pemasaran dengan rincian:</p>
<ul>
    <li><strong>Pemrosesan Transaksi:</strong> Mengelola pemesanan grosir, memverifikasi pembayaran bank, menjadwalkan pengiriman kargo, dan menerbitkan faktur atau surat jalan resmi.</li>
    <li><strong>Layanan Kemitraan:</strong> Menghubungi calon mitra untuk diskusi kelayakan keagenan, memberikan konsultasi gratis kemitraan, dan menunjuk Account Manager khusus bagi akun B2B Anda.</li>
    <li><strong>Kepatuhan Regulasi:</strong> Memastikan seluruh transaksi bisnis dan produk memenuhi regulasi Izin Edar Kemenkes RI (PKRT), Sertifikasi Halal, dan standar uji mutu laboratorium kami.</li>
    <li><strong>Pengembangan Layanan:</strong> Menganalisis preferensi pasar B2B guna mengembangkan varian aroma/produk baru dan memperbaiki sistem distribusi kami.</li>
    <li><strong>Pemasaran Terarah:</strong> Mengirimkan katalog produk terbaru, brosur marketing cetak/digital, program diskon musiman, atau info acara B2B nasional.</li>
</ul>

<h2>5. Keamanan dan Penyimpanan Data</h2>
<p>Kami sangat memprioritaskan keamanan informasi Anda dengan menerapkan standar perlindungan berikut:</p>
<ul>
    <li><strong>Enkripsi Data:</strong> Situs web kami dilindungi oleh enkripsi SSL (Secure Sockets Layer) 256-bit untuk mengamankan data transmisi formulir.</li>
    <li><strong>Akses Terbatas:</strong> Hanya staf berwenang (Tim Finance, Operasional, dan Sales) yang memiliki hak akses terbatas ke database fisik dan cloud kami untuk memproses pesanan Anda.</li>
    <li><strong>Retensi Data:</strong> Kami menyimpan informasi pribadi Anda hanya selama diperlukan untuk memenuhi tujuan pengumpulan, termasuk untuk mematuhi persyaratan hukum, akuntansi, atau pelaporan bisnis.</li>
</ul>

<h2>6. Pengungkapan kepada Pihak Ketiga</h2>
<p>Kami berkomitmen untuk tidak menjual, memperdagangkan, atau menyewakan data pribadi Anda kepada pihak luar. Kami hanya membagikan informasi terbatas kepada pihak ketiga terpercaya dalam skenario berikut:</p>
<ul>
    <li><strong>Penyedia Jasa Logistik:</strong> Memberikan nama, telepon, dan alamat gudang kepada perusahaan ekspedisi (kargo laut/darat) pihak ketiga untuk mengirimkan kontainer produk ke lokasi Anda.</li>
    <li><strong>Penyedia Infrastruktur IT:</strong> Penyedia server hosting cloud aman yang membantu kami mengoperasikan situs web dan sistem e-commerce B2B kami.</li>
    <li><strong>Kepatuhan Hukum:</strong> Apabila diwajibkan oleh aparat penegak hukum, instansi pemerintah berwenang (Kemenkes RI/MUI), atau perintah pengadilan resmi di bawah hukum Republik Indonesia.</li>
</ul>

<h2>7. Hak Pelindungan Data Anda</h2>
<p>Sesuai dengan UU PDP, Anda memiliki hak-hak penting terkait data pribadi Anda:</p>
<ul>
    <li><strong>Hak Akses:</strong> Meminta salinan informasi data pribadi yang kami simpan tentang profil bisnis atau transaksi Anda.</li>
    <li><strong>Hak Koreksi:</strong> Meminta perbaikan data kontak, nama perusahaan, atau alamat pengiriman yang tidak akurat atau tidak lengkap.</li>
    <li><strong>Hak Penarikan Persetujuan:</strong> Menarik kembali persetujuan pengiriman email pemasaran atau promosi WhatsApp kapan saja.</li>
    <li><strong>Hak Penghapusan (Hak untuk Dilupakan):</strong> Meminta penghapusan permanen atas data pribadi Anda dari sistem kami, selama data tersebut tidak lagi diperlukan untuk kepatuhan hukum atau pemenuhan kewajiban kontrak aktif.</li>
</ul>
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
        'active_slug'     => 'privacy-policy',
        'reading_minutes' => $reading_minutes,
        'subtitle'        => 'Penjelasan transparan mengenai pengumpulan, penyimpanan, dan perlindungan data pribadi mitra B2B sesuai UU PDP.',
    ]
);

get_footer();
