<?php
/**
 * Partnership archive landing page.
 */

get_header();
get_template_part( 'template-parts/layout/site-header' );

$trust_items = [
    [ 'icon' => 'store', 'title' => __( 'Data mitra terdaftar', 'depocleanique-custom' ) ],
    [ 'icon' => 'map-pin', 'title' => __( 'Informasi area mitra', 'depocleanique-custom' ) ],
    [ 'icon' => 'package', 'title' => __( 'Produk dan layanan mitra', 'depocleanique-custom' ) ],
    [ 'icon' => 'shield', 'title' => __( 'Profil mudah dikelola', 'depocleanique-custom' ) ],
];

$audiences = [
    [ 'icon' => 'users', 'title' => __( 'Calon pelanggan', 'depocleanique-custom' ) ],
    [ 'icon' => 'store', 'title' => __( 'Mitra retail', 'depocleanique-custom' ) ],
    [ 'icon' => 'package', 'title' => __( 'Mitra laundry', 'depocleanique-custom' ) ],
    [ 'icon' => 'handshake', 'title' => __( 'Distributor/reseller', 'depocleanique-custom' ) ],
    [ 'icon' => 'shield', 'title' => __( 'Tim internal brand', 'depocleanique-custom' ) ],
];

$steps = [ 'Mitra didaftarkan dari dashboard', 'Lengkapi kategori dan area', 'Isi kontak dan profil singkat', 'Tambahkan foto outlet atau mitra', 'Publikasikan ke halaman kemitraan' ];
$requirements = [ 'Nama mitra atau outlet jelas', 'Area operasional terisi', 'Jenis kemitraan dipilih', 'Kontak atau WhatsApp valid', 'Foto dan ringkasan diperbarui berkala' ];
$faqs = [
    [ 'q' => 'Apa isi halaman kemitraan?', 'a' => 'Halaman ini menampilkan daftar mitra Depo Cleanique yang sudah terdaftar dan dipublikasikan dari dashboard.' ],
    [ 'q' => 'Apakah setiap mitra punya halaman detail?', 'a' => 'Ya. Setiap mitra memiliki halaman detail berisi profil, area, kategori, kontak, dan produk atau layanan.' ],
    [ 'q' => 'Apakah bisa menampilkan jenis mitra tertentu?', 'a' => 'Bisa. Jenis kemitraan seperti Retail, Laundry, Reseller, atau Distributor dapat dikelola melalui taxonomy.' ],
    [ 'q' => 'Bagaimana cara menambahkan mitra?', 'a' => 'Admin dapat membuka menu Kemitraan, tambah mitra baru, isi informasi, pilih jenis kemitraan, lalu publish.' ],
    [ 'q' => 'Apakah data kontak wajib publik?', 'a' => 'Kontak bisa diisi sesuai kebutuhan. Jika WhatsApp mitra kosong, tombol akan memakai WhatsApp global Depo Cleanique.' ],
];
$testimonials = [
    [
        'name'   => 'Ibu Hani Syarifah',
        'role'   => 'Owner Depo Cleanique Cibinong',
        'rating' => 5,
        'quote'  => 'Sangat terbantu dengan sistem kemitraan Depo Cleanique. Produknya disukai pelanggan karena wangi tahan lama dan ramah lingkungan. Penjualan stabil setiap bulan!',
    ],
    [
        'name'   => 'Bapak Budi Santoso',
        'role'   => 'Owner Depo Cleanique Semarang',
        'rating' => 5,
        'quote'  => 'Pendampingan dari tim Depo Cleanique sangat intensif. Dari survei lokasi, layout outlet, sampai training karyawan dibantu sampai bisa. Sangat recommended untuk pemula.',
    ],
    [
        'name'   => 'Ibu Rina Wijaya',
        'role'   => 'Mitra Agen Depo Cleanique Bandung',
        'rating' => 5,
        'quote'  => 'Modal terjangkau dengan margin keuntungan yang sangat menarik. Pengiriman produk tepat waktu dan tim support-nya cepat tanggap dalam membantu promosi lokal.',
    ],
];
?>

<main id="main-content" class="partnership-archive">
    <section class="partnership-hero" aria-labelledby="partnership-archive-title">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop partnership-hero-inner">
            <div class="partnership-hero-copy">
                <div class="section-kicker">
                    <span class="section-kicker-dot" aria-hidden="true"></span>
                    <span><?php esc_html_e( 'Kemitraan Depo Cleanique', 'depocleanique-custom' ); ?></span>
                </div>
                <h1 id="partnership-archive-title"><?php esc_html_e( 'Daftar mitra resmi Depo Cleanique', 'depocleanique-custom' ); ?></h1>
                <p><?php esc_html_e( 'Temukan informasi mitra Depo Cleanique yang sudah terdaftar, mulai dari area operasional, jenis kemitraan, profil singkat, hingga produk dan layanan yang tersedia.', 'depocleanique-custom' ); ?></p>
                <div class="partnership-hero-actions">
                    <a class="partnership-button partnership-button-primary" href="<?php echo esc_url( dc_get_wa_url( 'partnership' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo dc_icon( 'message-circle' ); ?><?php esc_html_e( 'Hubungi Kami', 'depocleanique-custom' ); ?></a>
                    <a class="partnership-button partnership-button-ghost" href="#daftar-mitra"><?php esc_html_e( 'Lihat Mitra', 'depocleanique-custom' ); ?><?php echo dc_icon( 'arrow-right' ); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="partnership-trust">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop partnership-trust-grid">
            <?php foreach ( $trust_items as $item ) : ?>
                <div class="partnership-trust-item"><?php echo dc_icon( $item['icon'] ); ?><span><?php echo esc_html( $item['title'] ); ?></span></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="daftar-mitra" class="partnership-programs" aria-labelledby="partnership-programs-title">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="partnership-heading">
                <div class="section-kicker">
                    <span class="section-kicker-dot" aria-hidden="true"></span>
                    <span><?php esc_html_e( 'Daftar Mitra', 'depocleanique-custom' ); ?></span>
                </div>
                <h2 id="partnership-programs-title"><?php esc_html_e( 'Semua mitra yang sudah terdaftar', 'depocleanique-custom' ); ?></h2>
            </div>
            <?php if ( have_posts() ) : ?>
                <div class="partnership-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/partnership/card' );
                    endwhile;
                    ?>
                </div>
            <?php else : ?>
                <?php get_template_part( 'template-parts/partnership/empty' ); ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="partnership-section partnership-testimonials" aria-labelledby="testimonials-title">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="partnership-heading">
                <div class="section-kicker">
                    <span class="section-kicker-dot" aria-hidden="true"></span>
                    <span><?php esc_html_e( 'Testimoni Mitra', 'depocleanique-custom' ); ?></span>
                </div>
                <h2 id="testimonials-title"><?php esc_html_e( 'Cerita sukses para mitra kami', 'depocleanique-custom' ); ?></h2>
            </div>
            <div class="testimonials-grid">
                <?php foreach ( $testimonials as $item ) : ?>
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <?php for ( $i = 0; $i < $item['rating']; $i++ ) : ?>
                                <?php echo dc_icon( 'star', 'dc-icon-sm' ); ?>
                            <?php endfor; ?>
                        </div>
                        <p class="testimonial-quote">"<?php echo esc_html( $item['quote'] ); ?>"</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">
                                <span><?php echo esc_html( substr( $item['name'], 4, 1 ) ?: substr( $item['name'], 0, 1 ) ); ?></span>
                            </div>
                            <div class="testimonial-meta">
                                <h4><?php echo esc_html( $item['name'] ); ?></h4>
                                <span><?php echo esc_html( $item['role'] ); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="partnership-section" id="faq-mitra">
        <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="partnership-heading">
                <div class="section-kicker">
                    <span class="section-kicker-dot" aria-hidden="true"></span>
                    <span><?php esc_html_e( 'FAQ Mitra', 'depocleanique-custom' ); ?></span>
                </div>
                <h2><?php esc_html_e( 'Pertanyaan seputar direktori mitra', 'depocleanique-custom' ); ?></h2>
            </div>
            <div class="faq-list">
                <?php foreach ( $faqs as $faq_index => $faq ) : ?>
                    <?php
                    $partner_faq_trigger = 'partner-faq-trigger-' . $faq_index;
                    $partner_faq_panel   = 'partner-faq-panel-' . $faq_index;
                    ?>
                    <div class="dc-faq-item">
                        <button
                            id="<?php echo esc_attr( $partner_faq_trigger ); ?>"
                            type="button"
                            class="dc-faq-trigger"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( $partner_faq_panel ); ?>"
                        >
                            <span class="dc-faq-question-wrap">
                                <span class="dc-faq-number"><?php echo esc_html( str_pad( (string) ( $faq_index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
                                <span class="dc-faq-question"><?php echo esc_html( $faq['q'] ); ?></span>
                            </span>
                            <span class="material-symbols-outlined dc-faq-icon" aria-hidden="true">expand_more</span>
                        </button>
                        <div
                            id="<?php echo esc_attr( $partner_faq_panel ); ?>"
                            class="dc-faq-panel"
                            role="region"
                            aria-labelledby="<?php echo esc_attr( $partner_faq_trigger ); ?>"
                            aria-hidden="true"
                        >
                            <div class="dc-faq-answer"><?php echo esc_html( $faq['a'] ); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <?php get_template_part( 'template-parts/partnership/cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>
