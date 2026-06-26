<?php
/**
 * Template Name: Single Brand
 * Template Post Type: brand
 */

get_header();

while (have_posts()) : the_post();
    $brand_id = get_the_ID();
    
    // Retrieve Carbon Fields Meta
    $tagline = carbon_get_post_meta($brand_id, 'brand_tagline');
    $accent_color = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
    $website_url = carbon_get_post_meta($brand_id, 'brand_website_url');
    $gallery = carbon_get_post_meta($brand_id, 'brand_gallery');

    // Query all products belonging to this brand (robustly supporting both old and new Carbon Fields formats)
    global $wpdb;
    $product_ids = $wpdb->get_col($wpdb->prepare("
        SELECT post_id 
        FROM {$wpdb->postmeta} 
        WHERE (meta_key = '_product_brand' AND meta_value = %s)
           OR (meta_key = '_product_brand|||0|id' AND meta_value = %s)
    ", 'post:brand:' . $brand_id, $brand_id));

    $product_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post__in'       => !empty($product_ids) ? $product_ids : [0]
    ]);
?>

<div class="brand-detail-wrapper" style="--brand-color: <?php echo esc_attr($accent_color); ?>;">
    
    <style>
    .brand-single-hero {
        background: var(--ink);
        color: var(--white);
        padding: 100px 0 70px;
        border-bottom: 4px solid var(--brand-color);
        position: relative;
        overflow: hidden;
    }
    .brand-hero-meta {
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }
    .brand-hero-logo {
        width: 100px;
        height: 100px;
        background: var(--white);
        padding: 12px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    .brand-hero-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .brand-grid-container {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 48px;
        align-items: start;
    }
    .brand-product-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        transition: all var(--trans);
        position: relative;
        box-shadow: var(--shadow-xs);
    }
    .brand-product-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: rgba(0, 87, 255, 0.15);
    }
    .brand-product-card-img-wrap {
        margin-bottom: 20px;
        border-radius: 10px;
        overflow: hidden;
        background: var(--surface);
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        transition: border-color var(--trans);
    }
    .brand-product-card:hover .brand-product-card-img-wrap {
        border-color: rgba(0, 87, 255, 0.15);
    }
    .brand-product-card-title {
        font-size: 18px;
        margin-bottom: 10px;
        line-height: 1.3;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--ink);
        transition: color var(--trans);
    }
    .brand-product-card:hover .brand-product-card-title {
        color: var(--brand-color);
    }
    .brand-product-card .btn-outline {
        margin-top: auto;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        display: block;
        border-color: var(--brand-color) !important;
        color: var(--brand-color) !important;
        background: transparent;
        padding: 10px 16px;
        transition: all var(--trans);
        border-radius: 8px;
        text-decoration: none;
    }
    .brand-product-card:hover .btn-outline {
        background: var(--brand-color) !important;
        color: var(--white) !important;
        border-color: var(--brand-color) !important;
        box-shadow: 0 4px 12px rgba(0, 87, 255, 0.15);
    }
    .brand-usp-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .brand-usp-card {
        background: var(--white);
        padding: 24px;
        border-radius: 16px;
        border: 1px solid var(--border);
        display: flex;
        gap: 16px;
        align-items: start;
        transition: transform var(--trans);
    }
    .brand-usp-card:hover {
        transform: translateY(-2px);
    }
    .brand-usp-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(0, 87, 255, 0.08);
        color: var(--brand-color);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .brand-gallery-img {
        transition: transform var(--trans);
    }
    .brand-gallery-img:hover {
        transform: scale(1.05);
    }
    @media (max-width: 991px) {
        .brand-grid-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }
    @media (max-width: 768px) {
        .brand-usp-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <!-- ── Brand Hero Header ── -->
    <?php
    $glow_color = (in_array(strtolower(trim($accent_color)), ['#111827', '#000', '#000000', '#1a1a1a'])) ? '#0057FF' : $accent_color;
    ?>
    <section class="inner-page-hero" id="brand-hero" style="border-bottom: 4px solid var(--brand-color);">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="background: radial-gradient(circle, <?php echo esc_attr($glow_color); ?>40, transparent 70%); opacity: .5;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <!-- Breadcrumbs -->
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="<?php echo esc_url( get_post_type_archive_link('brand') ); ?>">Brand</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>

            <div class="brand-hero-meta" style="display: flex; align-items: center; gap: 28px; margin-top: 20px; flex-wrap: wrap;">
                <?php 
                $local_logo = indotech_get_brand_logo_url(get_the_title());
                if (has_post_thumbnail() || !empty($local_logo)) : 
                ?>
                    <div class="brand-hero-logo" style="width: 100px; height: 100px; background: var(--white); padding: 12px; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail', ['style' => 'max-width:100%;max-height:100%;object-fit:contain;']);
                        } else {
                            echo '<img src="' . esc_url($local_logo) . '" alt="' . esc_attr(get_the_title()) . ' logo" style="max-width:100%;max-height:100%;object-fit:contain;">';
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <div>
                    <?php if ($tagline) : ?>
                        <span class="section-tag section-tag--white" style="margin-bottom: 12px;"><?php echo esc_html($tagline); ?></span>
                    <?php endif; ?>
                    <h1 class="inner-page-title" style="margin: 0; font-weight: 700;"><?php the_title(); ?></h1>
                </div>
            </div>
            
            <p class="inner-page-subtitle" style="margin-top: 24px; max-width: 700px;"><?php echo esc_html(get_the_excerpt()); ?></p>
        </div>
    </section>

    <!-- ── Brand Content Section ── -->
    <section class="brand-body-section" style="padding: 60px 0; background: var(--surface);">
        <div class="container">
            
            <?php
            $brand_title = get_the_title();
            $brand_usps = [];

            switch (strtolower(trim($brand_title))) {
                case 'cleanique academy':
                    $brand_usps = [
                        [
                            'title' => 'Kurikulum Praktis & Teruji',
                            'desc'  => 'Diajarkan langsung oleh praktisi berpengalaman di industri laundry komersial dengan modul yang mudah dipahami.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>'
                        ],
                        [
                            'title' => 'Konsultasi & Mentoring Bisnis',
                            'desc'  => 'Setiap alumni mendapatkan bimbingan pasca-pelatihan untuk memulai atau mengoptimalkan bisnis laundry secara mandiri.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                        ],
                        [
                            'title' => 'Workshop Formulasi Mandiri',
                            'desc'  => 'Pelajari teknik meracik sabun, softener, dan parfum laundry standar industri untuk memangkas biaya operasional hingga 50%.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
                        ],
                        [
                            'title' => 'Dukungan Komunitas Nasional',
                            'desc'  => 'Bergabung dengan jaringan ribuan pengusaha laundry se-Indonesia untuk saling bertukar informasi dan peluang pasar.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>'
                        ]
                    ];
                    break;

                case 'cleanique lab':
                    $brand_usps = [
                        [
                            'title' => 'Tim R&D Ahli & Berpengalaman',
                            'desc'  => 'Formulasi produk didukung oleh ahli kimia khusus untuk menghasilkan performa pembersihan maksimal dan aman.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.77 3.77z"/></svg>'
                        ],
                        [
                            'title' => 'Layanan Maklon Private Label',
                            'desc'  => 'Solusi produksi ujung-ke-ujung (end-to-end) bagi Anda yang ingin meluncurkan brand sabun atau chemical pembersih sendiri.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
                        ],
                        [
                            'title' => 'Fasilitas Manufaktur Modern',
                            'desc'  => 'Diproduksi menggunakan mesin standar industri demi memastikan konsistensi batch dan output produksi volume tinggi.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>'
                        ],
                        [
                            'title' => 'Legalitas & Sertifikasi Lengkap',
                            'desc'  => 'Formula bersertifikat Halal MUI, standar mutu ISO 9001:2015, serta registrasi izin edar Kemenkes RI.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>'
                        ]
                    ];
                    break;

                case 'cleanique mart':
                    $brand_usps = [
                        [
                            'title' => 'One-Stop Cleaning Supplies',
                            'desc'  => 'Menyediakan stok produk kebersihan terlengkap mulai dari sabun laundry, pembersih rumah, hingga peralatan komersial.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
                        ],
                        [
                            'title' => 'Kemitraan Toko Kebersihan',
                            'desc'  => 'Konsep waralaba/kemitraan toko modern dengan sistem POS terintegrasi, pasokan produk stabil, dan dukungan pemasaran.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                        ],
                        [
                            'title' => 'Konsep Ramah Lingkungan',
                            'desc'  => 'Menerapkan sistem minim sampah (zero waste) melalui stasiun pengisian ulang sabun untuk mengurangi kemasan plastik sekali pakai.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M7 12l3 3 7-7"/></svg>'
                        ],
                        [
                            'title' => 'Jaminan Stok & Distribusi',
                            'desc'  => 'Didukung rantai pasok langsung dari pabrik PT Indotech Berkah Abadi untuk menjamin ketersediaan barang setiap saat.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'
                        ]
                    ];
                    break;

                case 'depo cleanique':
                    $brand_usps = [
                        [
                            'title' => 'Stabilitas Harga Terjamin',
                            'desc'  => 'Kami memastikan tidak ada perang harga di antara mitra. Kontrak eksklusif wilayah menjaga profit margin Anda tetap sehat dan berkelanjutan.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><path d="M12 22V12"/></svg>'
                        ],
                        [
                            'title' => 'Bayar Sabunnya Saja',
                            'desc'  => 'Hampir 40% biaya produk ritel habis untuk kemasan sekali pakai. Di sini, Anda hanya membayar isi sabunnya.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v12M6 12h12"/></svg>'
                        ],
                        [
                            'title' => 'Legalitas Penuh',
                            'desc'  => 'Dibantu pengurusan izin OSS, Kemenkes, hingga sertifikasi Halal secara tuntas dan cepat.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>'
                        ],
                        [
                            'title' => 'Grosir Tangan Pertama',
                            'desc'  => 'Memotong rantai distribusi panjang. Dapatkan harga langsung produsen untuk bisnis laundry dan warung Anda.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                        ]
                    ];
                    break;

                case 'malabeez':
                    $brand_usps = [
                        [
                            'title' => 'Aroma Mewah Timur Tengah',
                            'desc'  => 'Menyediakan wewangian premium khas Timur Tengah seperti Kasturi, Baccarat, Masjidil Haram, dan Masjid Nabawi.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>'
                        ],
                        [
                            'title' => 'Teknologi Anti-Bakteri',
                            'desc'  => 'Diformulasikan dengan perlindungan Anti Musty & Antibacterial untuk menjaga sajadah dan mukena tetap higienis.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22,4 12,14.01 9,11.01"/><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/></svg>'
                        ],
                        [
                            'title' => 'Formula Bebas Alkohol',
                            'desc'  => '100% bebas alkohol sehingga sangat aman digunakan untuk ibadah sehari-hari tanpa memicu pusing atau eneg.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M7 12l3 3 7-7"/></svg>'
                        ],
                        [
                            'title' => 'Wangi Tahan Lama',
                            'desc'  => 'Menggunakan minyak wangi berkualitas tinggi yang menyerap ke serat kain dan bertahan hingga berhari-hari.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>'
                        ]
                    ];
                    break;

                case 'orchid care':
                    $brand_usps = [
                        [
                            'title' => 'Pilihan Utama Laundry Profesional',
                            'desc'  => 'Digunakan oleh ribuan pengusaha laundry komersial karena ampuh mengangkat noda membandel dalam sekali cuci.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>'
                        ],
                        [
                            'title' => 'Proteksi Serat Kain & Warna',
                            'desc'  => 'Menjaga kecerahan warna pakaian agar tidak pudar dan melindungi kelembutan kain meski sering dicuci.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
                        ],
                        [
                            'title' => 'Formula Rendah Busa (Low Suds)',
                            'desc'  => 'Sangat aman untuk mesin cuci tipe front-loading (pintu depan), mencegah korosi, dan menghemat konsumsi air bilasan.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>'
                        ],
                        [
                            'title' => 'Sertifikasi Kemenkes & Halal',
                            'desc'  => 'Seluruh produk memiliki izin edar resmi dari Kementerian Kesehatan RI dan bersertifikat Halal untuk ketenangan bisnis Anda.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>'
                        ]
                    ];
                    break;

                case 'prokopi':
                    $brand_usps = [
                        [
                            'title' => 'Standard Mutu Food-Grade',
                            'desc'  => 'Diformulasikan khusus dengan bahan yang sepenuhnya aman bagi kesehatan manusia dan tidak merusak komponen mesin kopi.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>'
                        ],
                        [
                            'title' => 'Menjaga Cita Rasa Espresso',
                            'desc'  => 'Menghilangkan residu minyak kopi (coffee oils) dan sisa kerak gosong pada group head agar rasa kopi tetap murni.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
                        ],
                        [
                            'title' => 'Formula Descaling Ampuh',
                            'desc'  => 'Efektif melarutkan penumpukan mineral/kerak kapur di dalam boiler dan pipa boiler pemanas mesin espresso.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                        ],
                        [
                            'title' => 'Kompatibel dengan Berbagai Mesin',
                            'desc'  => 'Cocok digunakan untuk mesin espresso komersial kafe, mesin semi-otomatis rumahan, hingga grinder kopi.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
                        ]
                    ];
                    break;

                default:
                    $brand_usps = [
                        [
                            'title' => 'Formulasi Khusus Komersial',
                            'desc'  => 'Dirancang dengan konsentrasi bahan aktif tinggi untuk hasil pembersihan maksimal pada skala industri.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
                        ],
                        [
                            'title' => 'Aroma Tahan Lama',
                            'desc'  => 'Dilengkapi teknologi parfum pilihan yang melekat kuat pada serat kain dan bertahan hingga berhari-hari.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>'
                        ],
                        [
                            'title' => 'Efisiensi Biaya Operasional',
                            'desc'  => 'Harga grosir langsung dari produsen yang memberikan penghematan biaya pengeluaran kimia operasional bisnis Anda.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                        ],
                        [
                            'title' => 'Ramah Serat & Kulit',
                            'desc'  => 'Bahan aktif biodegradable yang lembut di kulit, tidak menimbulkan korosi, serta memperpanjang usia pakai linen Anda.',
                            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>'
                        ]
                    ];
                    break;
            }
            ?>

            <div class="brand-grid-container">
                
                <!-- Left Column: Description, USPs, & Products -->
                <div>
                    <div class="brand-description-box" style="background: var(--white); padding: 40px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 40px;">
                        <h2 style="font-size: 24px; margin-bottom: 20px; letter-spacing: -0.02em; font-weight: 700;">Tentang Brand</h2>
                        <div class="brand-content-text" style="color: var(--text-secondary); line-height: 1.75; font-size: 15px;">
                            <?php the_content(); ?>
                        </div>
                        <?php if ($website_url) : ?>
                            <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="margin-top: 30px; background: var(--brand-color); border-color: var(--brand-color); font-weight: 600;">
                                Kunjungi Website Resmi &rarr;
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Brand Features / USP -->
                    <div class="brand-features-box" style="margin-bottom: 50px;">
                        <h2 style="font-size: 24px; margin-bottom: 24px; letter-spacing: -0.02em; font-weight: 700;">Mengapa Memilih Produk <em><?php the_title(); ?></em>?</h2>
                        <div class="brand-usp-grid">
                            
                            <?php foreach ($brand_usps as $usp) : ?>
                                <div class="brand-usp-card">
                                    <div class="brand-usp-icon" style="background: var(--surface); color: var(--brand-color); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-bottom: 16px;">
                                        <?php echo $usp['icon']; ?>
                                    </div>
                                    <div>
                                        <h4 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 6px;"><?php echo esc_html($usp['title']); ?></h4>
                                        <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin: 0;"><?php echo esc_html($usp['desc']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>


                </div>

                <!-- Right Column: Sidebar (Gallery & Info) -->
                <aside>
                    <!-- B2B Inquiry Box specific to Brand -->
                    <div style="background: var(--white); border: 1px solid var(--brand-color); border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: var(--shadow-sm);">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--ink); margin-bottom: 8px; letter-spacing: -0.01em;">Kemitraan & Maklon</h3>
                        <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;">Hubungi tim penjualan B2B kami untuk meminta katalog harga grosir atau konsultasi Private Label (Maklon) brand <strong><?php the_title(); ?></strong>.</p>
                        
                        <?php
                        // Robustly fetch a product ID from this brand or fallback
                        $first_product_id = 0;
                        if ($product_query->have_posts()) {
                            $first_product_id = $product_query->posts[0]->ID;
                        }
                        if (empty($first_product_id)) {
                            $fallback_posts = get_posts(['post_type' => 'product', 'posts_per_page' => 1]);
                            if (!empty($fallback_posts)) {
                                $first_product_id = $fallback_posts[0]->ID;
                            }
                        }
                        ?>

                        <form id="indotech-inquiry-form" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
                            <input type="hidden" name="product_id" value="<?php echo esc_attr($first_product_id); ?>">
                            <input type="text" name="website_url" value="" style="display: none;" tabindex="-1" autocomplete="off"> <!-- Honeypot -->

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Nama Lengkap *</label>
                                <input type="text" name="full_name" placeholder="Masukkan nama Anda" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: inherit; font-size: 13.5px;">
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Email Bisnis *</label>
                                <input type="email" name="email" placeholder="nama@perusahaan.com" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: inherit; font-size: 13.5px;">
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Nomor WA / Telepon *</label>
                                <input type="tel" name="phone" placeholder="Contoh: 0812345678" required style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: inherit; font-size: 13.5px;">
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Nama Bisnis / Perusahaan</label>
                                <input type="text" name="company_name" placeholder="Nama bisnis Anda" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: inherit; font-size: 13.5px;">
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Pesan Kustom</label>
                                <textarea name="message" rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: inherit; font-size: 13.5px; resize: vertical;">Halo, saya tertarik untuk meminta katalog produk dan harga grosir untuk brand <?php the_title(); ?>.</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--brand-color); border-color: var(--brand-color); padding: 12px; font-size: 13.5px; font-weight: 700;">
                                Kirim Permintaan &rarr;
                            </button>
                        </form>

                        <div id="indotech-inquiry-response" style="display: none; margin-top: 14px; padding: 10px 14px; border-radius: 8px; font-size: 13px; line-height: 1.4; font-weight: 500;"></div>
                    </div>

                    <?php if (!empty($gallery)) : ?>
                        <div class="brand-gallery-box" style="background: var(--white); padding: 30px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 30px;">
                            <h3 style="font-size: 18px; margin-bottom: 20px; letter-spacing: -0.01em; font-weight: 700;">Galeri Brand</h3>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                <?php foreach ($gallery as $img_id) : 
                                    $img_url = wp_get_attachment_image_url($img_id, 'large');
                                ?>
                                    <a href="<?php echo esc_url($img_url); ?>" target="_blank" style="border-radius: 8px; overflow: hidden; height: 100px; display: block;">
                                        <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, ['style' => 'width:100%;height:100%;object-fit:cover;transition:transform var(--trans);', 'class' => 'brand-gallery-img']); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="brand-info-box" style="background: var(--white); padding: 30px; border-radius: 16px; border: 1px solid var(--border);">
                        <h3 style="font-size: 18px; margin-bottom: 20px; letter-spacing: -0.01em; font-weight: 700;">Holding Korporat</h3>
                        <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 15px;">
                            Setiap produk di bawah brand <strong><?php the_title(); ?></strong> diproduksi dengan standar mutu tinggi dan formula khusus dari PT Indotech Berkah Abadi.
                        </p>
                        <hr style="border: 0; border-top: 1px solid var(--border); margin: 15px 0;">
                        <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Sertifikasi</span>
                        <div style="display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;">
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">BPOM</span>
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">Halal MUI</span>
                            <span style="font-size: 10px; font-weight: 700; padding: 4px 8px; background: var(--surface); border-radius: 4px;">ISO 9001</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</div>

<?php
endwhile;

get_footer();

