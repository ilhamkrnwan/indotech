<?php
/**
 * Template Name: Syarat & Ketentuan
 *
 * Template halaman Syarat & Ketentuan (Terms of Use) PT Indotech Berkah Abadi.
 * Layout: Hero + sidebar navigasi anchor kiri + konten artikel kanan.
 */

// Build heading anchors dari konten halaman untuk navigasi sidebar
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

// Tambahkan id anchor ke heading dalam konten
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

// Ambil data halaman
$page_title   = get_the_title();
$page_content = '';
$headings     = [];

// Default Legal Content
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
    <li><strong>Inquiry Harga:</strong> Harga produk yang tertera di situs bersifat estimasi dasar B2B. Harga final grosir ditentukan berdasarkan volume pesanan dan kesepakatan tertulis yang diterbitkan melalui penawaran harga resmi (*Quotation*).</li>
    <li><strong>Termin Pembayaran (TOP):</strong> Metode pembayaran standar adalah transfer bank lunas sebelum pengiriman (CBD - *Cash Before Delivery*), kecuali telah disetujui kesepakatan tertulis mengenai termin pembayaran (*Term of Payment*) untuk akun distributor tertentu.</li>
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
    <li>Laporan kerusakan atau ketidaksesuaian barang harus diajukan maksimal **2×24 jam** sejak produk diterima oleh gudang Anda, dengan menyertakan video unboxing resmi dan nomor batch produksi.</li>
    <li>Kami akan mengganti produk yang cacat dengan produk baru yang sesuai setelah proses verifikasi tim quality control kami selesai.</li>
</ul>

<h2>6. Hak Kekayaan Intelektual</h2>
<p>Semua materi di situs web ini, termasuk desain visual, teks, nama brand dagang (**Cleanique Academy, Cleanique Lab, Cleanique Mart, Depo Cleanique, Malabeez, Orchid Care, Prokopi**), logo perusahaan PT. Indotech Berkah Abadi, grafis, dan kode pemrograman adalah hak cipta milik kami. Penggunaan komersial, reproduksi, atau modifikasi konten tanpa izin tertulis dari direksi PT Indotech Berkah Abadi sangat dilarang dan dapat dituntut secara hukum.</p>

<h2>7. Hukum yang Berlaku & Resolusi Perselisihan</h2>
<p>Syarat & Ketentuan ini diatur dan ditafsirkan berdasarkan hukum Negara Kesatuan Republik Indonesia. Setiap perselisihan, sengketa dagang, atau tuntutan hukum yang timbul terkait dengan layanan dan produk PT Indotech Berkah Abadi akan diselesaikan secara musyawarah mufakat terlebih dahulu. Apabila tidak tercapai mufakat, perselisihan akan diselesaikan melalui **Pengadilan Negeri Sleman**, Daerah Istimewa Yogyakarta.</p>
';

if ( have_posts() ) {
    the_post();
    $raw_content  = get_the_content();
    if ( empty( trim( $raw_content ) ) ) {
        $raw_content = $default_content;
    }
    $page_content = apply_filters( 'the_content', indotech_add_heading_ids( $raw_content ) );
    $headings     = indotech_extract_headings( $raw_content );
}

$last_updated = get_the_modified_date( 'd F Y' );
if ( empty( $last_updated ) ) {
    $last_updated = date( 'd F Y' );
}
?>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         PAGE HERO
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero inner-page-hero--sm" id="legal-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.3;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php echo esc_html( $page_title ); ?></span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Dokumen Resmi</span>
            <h1 class="inner-page-title"><?php echo esc_html( $page_title ); ?></h1>
            <?php if ( $last_updated ) : ?>
            <p class="inner-page-subtitle" style="font-size:14px;opacity:.5;">
                Terakhir diperbarui: <?php echo esc_html( $last_updated ); ?>
            </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         KONTEN LEGAL — Sidebar + Artikel
    ════════════════════════════════════════════════════════ -->
    <section class="legal-section section-padding" id="legal-content">
        <div class="container">
            <div class="legal-layout">

                <!-- Sidebar navigasi anchor -->
                <?php if ( $headings ) : ?>
                <aside class="legal-sidebar" id="legal-sidebar" aria-label="Daftar isi">
                    <div class="legal-toc" role="navigation" aria-label="Daftar Isi">
                        <h2 class="legal-toc-title">Daftar Isi</h2>
                        <nav>
                            <ul class="legal-toc-list" id="toc-list">
                                <?php foreach ( $headings as $h ) : ?>
                                <li class="legal-toc-item legal-toc-level-<?php echo esc_attr( $h['level'] ); ?>">
                                    <a href="#<?php echo esc_attr( $h['anchor'] ); ?>" class="legal-toc-link">
                                        <?php echo esc_html( $h['text'] ); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    </div>
                </aside>
                <?php endif; ?>

                <!-- Konten artikel -->
                <article class="legal-content post-body" id="legal-article">
                    <?php if ( $page_content ) : ?>
                        <?php echo $page_content; ?>
                    <?php else : ?>
                        <p class="text-muted">Konten belum tersedia. Silakan tambahkan konten melalui dashboard WordPress.</p>
                    <?php endif; ?>

                    <!-- Footer artikel -->
                    <div class="legal-article-footer">
                        <p>
                            Jika Anda memiliki pertanyaan mengenai <?php echo esc_html( strtolower( $page_title ) ); ?> ini, silakan hubungi kami:
                        </p>
                        <div class="legal-contact-strip">
                            <a href="<?php echo esc_url( home_url('/kontak') ); ?>" class="btn btn-primary">
                                Hubungi Kami
                            </a>
                            <a href="mailto:<?php echo esc_attr( indotech_opt('email', 'indotechberkahabadi@gmail.com') ); ?>" class="btn btn-outline">
                                <?php echo esc_html( indotech_opt('email', 'indotechberkahabadi@gmail.com') ); ?>
                            </a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

</main>

<script>
/* ── Active TOC link highlight on scroll ── */
(function () {
    var tocLinks = document.querySelectorAll('.legal-toc-link');
    if ( ! tocLinks.length ) return;

    var headings = Array.from( document.querySelectorAll('#legal-article h2, #legal-article h3') );

    function getActiveId() {
        var scrollY = window.scrollY + 120;
        var active  = headings[0];
        for ( var h of headings ) {
            if ( h.offsetTop <= scrollY ) active = h;
        }
        return active ? active.id : '';
    }

    function updateActive() {
        var id = getActiveId();
        tocLinks.forEach( function(l) {
            var href = l.getAttribute('href').replace('#', '');
            l.classList.toggle( 'active', href === id );
        });
    }

    window.addEventListener( 'scroll', updateActive, { passive: true } );
    updateActive();
})();
</script>

<?php get_footer(); ?>
