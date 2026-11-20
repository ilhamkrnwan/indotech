<?php
/**
 * Template Name: FAQ
 *
 * Halaman Pusat Bantuan & FAQ PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 * Preserves FAQ data, JSON-LD FAQPage schema, #faq-search-input, .faq-nav-btn, #sec-*, and accordion behavior.
 */

$whatsapp = function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088';
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya lebih lanjut karena tidak menemukan jawaban di halaman FAQ.' );

$faq_categories = [
    'umum' => [
        'num'   => '01',
        'label' => 'Umum',
        'items' => [
            [
                'q' => 'Siapa PT Indotech Berkah Abadi?',
                'a' => 'PT Indotech Berkah Abadi adalah produsen dan pemasok terpercaya untuk produk kebersihan rumah tangga (homecare), kimia laundry, produk perawatan otomotif (car care), serta penyedia jasa maklon (private label) yang berpusat di Sleman, Yogyakarta.',
            ],
            [
                'q' => 'Apakah seluruh produk Indotech memiliki izin edar resmi?',
                'a' => 'Ya, seluruh produk kami telah teruji secara klinis dan memiliki izin edar resmi dari Kementerian Kesehatan Republik Indonesia (Kemenkes RI PKRT) serta sertifikasi Halal resmi.',
            ],
            [
                'q' => 'Di mana lokasi kantor operasional PT Indotech Berkah Abadi?',
                'a' => 'Kantor operasional kami berlokasi di Jongke Tengah No. 30, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285. Anda dapat melihat peta petunjuk arah langsung di halaman Kontak kami.',
            ],
        ],
    ],
    'produk' => [
        'num'   => '02',
        'label' => 'Produk & Formulasi',
        'items' => [
            [
                'q' => 'Apa keunggulan produk paket bahan sabun (biang/konsentrat)?',
                'a' => 'Produk paket bahan sabun (seperti Arai, Detta Plus, dan Determat) dirancang untuk meminimalkan biaya pengiriman. Anda cukup membeli biang konsentrat seberat 1 kg, lalu mencampurnya dengan air bersih di lokasi Anda untuk menghasilkan hingga 15 liter sabun siap pakai berkualitas premium.',
            ],
            [
                'q' => 'Bagaimana cara melarutkan paket bahan sabun konsentrat?',
                'a' => 'Setiap pembelian paket bahan sabun dilengkapi dengan petunjuk pembuatan tertulis yang sangat detail di dalam kemasan. Secara umum, Anda cukup mencampurkan pasta biang ke dalam wadah bersih, lalu menuangkan air secara bertahap sambil diaduk rata, kemudian mendiamkannya selama 12–24 jam hingga busa mereda sepenuhnya.',
            ],
            [
                'q' => 'Apakah produk detergen dan sabun cuci aman untuk kulit sensitif?',
                'a' => 'Ya, formulasi sabun kami menggunakan pH balancer khusus yang lembut di kulit, ramah lingkungan, serta tidak menimbulkan rasa panas atau iritasi bagi sebagian besar pengguna.',
            ],
        ],
    ],
    'kemitraan' => [
        'num'   => '03',
        'label' => 'Kemitraan & Maklon',
        'items' => [
            [
                'q' => 'Bagaimana cara menjadi agen atau distributor resmi Indotech?',
                'a' => 'Kami membuka kesempatan kemitraan seluas-luasnya di seluruh wilayah Indonesia. Anda dapat mendaftar melalui menu Kemitraan di website ini atau langsung menghubungi perwakilan marketing kami melalui WhatsApp untuk mendapatkan proposal paket kemitraan.',
            ],
            [
                'q' => 'Apakah Indotech melayani jasa maklon (private label) produk?',
                'a' => 'Tentu. Kami melayani jasa maklon OEM/ODM secara profesional mulai dari formulasi custom sesuai kebutuhan Anda, penyediaan kemasan, pendaftaran izin edar Kemenkes RI PKRT, hingga produksi massal berskala besar dengan brand milik Anda sendiri.',
            ],
            [
                'q' => 'Apakah ada minimal pemesanan (MOQ) untuk jasa maklon?',
                'a' => 'Minimal pemesanan (MOQ) untuk maklon bervariasi tergantung pada jenis produk, volume kemasan, dan tingkat kesulitan formulasi. Silakan hubungi tim B2B kami untuk melakukan konsultasi gratis mengenai rencana brand Anda.',
            ],
        ],
    ],
    'pengiriman' => [
        'num'   => '04',
        'label' => 'Pemesanan & Pengiriman',
        'items' => [
            [
                'q' => 'Apakah bisa mengirim ke luar pulau Jawa?',
                'a' => 'Bisa. Kami bekerja sama dengan berbagai ekspedisi kargo darat dan laut terpercaya yang siap mengantarkan produk kimia cair maupun paket bahan sabun kami dengan aman ke seluruh wilayah 34 provinsi di Indonesia.',
            ],
            [
                'q' => 'Berapa lama estimasi waktu pengiriman barang?',
                'a' => 'Untuk wilayah pulau Jawa, estimasi pengiriman kargo berkisar antara 2–4 hari kerja. Sedangkan untuk luar pulau Jawa berkisar antara 5–12 hari kerja tergantung jarak lokasi tujuan Anda.',
            ],
        ],
    ],
];

$faq_flat = [];
foreach ( $faq_categories as $cat ) {
    foreach ( $cat['items'] as $item ) {
        $faq_flat[] = $item;
    }
}

get_header();

if ( function_exists( 'indotech_render_faq_schema' ) ) {
    indotech_render_faq_schema( $faq_flat );
}
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <!-- Band 1: Search-First Editorial Hero + Horizontal Category Pills -->
        <section class="cs-hero cs-hero--compact ch-wrap" id="faq-hero" aria-labelledby="cs-faq-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">FAQ</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Temukan jawaban seputar legalitas produk, paket biang konsentrat, syarat kemitraan B2B, maklon merek pribadi, dan pengiriman kargo nasional.</p>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-faq-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Pusat</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Bantuan B2B</span>
                            <span class="ch-h1-secondary">Informasi &amp; FAQ</span>
                        </span>
                    </h1>
                </div>
            </div>

            <div class="cs-faq-search-bar">
                <label class="ch-sr-only" for="faq-search-input">Cari pertanyaan</label>
                <div class="cs-search-field">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input
                        type="text"
                        id="faq-search-input"
                        class="faq-search-input cs-faq-search-input"
                        placeholder="Ketik kata kunci pertanyaan Anda di sini (mis. maklon, Kemenkes, luar Jawa)..."
                        aria-label="Cari pertanyaan"
                    >
                </div>

                <nav class="faq-sidebar cs-faq-jumpbar" aria-label="Lompat ke kategori FAQ">
                    <?php
                    $first = true;
                    foreach ( $faq_categories as $key => $category ) :
                        ?>
                        <button
                            type="button"
                            class="faq-nav-btn cs-faq-jump-pill <?php echo $first ? 'faq-nav-btn--active' : ''; ?>"
                            data-target="<?php echo esc_attr( $key ); ?>"
                        >
                            <span><?php echo esc_html( $category['label'] ); ?></span>
                            <span class="cs-jump-count"><?php echo count( $category['items'] ); ?></span>
                        </button>
                        <?php
                        $first = false;
                    endforeach;
                    ?>
                </nav>
            </div>
        </section>

        <!-- Band 2: Sticky Obsidian-Navy Concierge (Left) + Numbered Hairline Knowledge Ledger (Right) -->
        <section class="cs-band ch-wrap" id="faq-directory" aria-label="Daftar pertanyaan yang sering diajukan">
            <div class="cs-faq-layout">
                <aside class="cs-faq-concierge">
                    <span class="cs-pill-tag cs-pill-tag--lime">Dukungan Langsung</span>
                    <h2>Belum Menemukan Jawaban yang Anda Cari?</h2>
                    <p>Konsultan bisnis dan layanan pelanggan kami siap merespons pertanyaan spesifik mengenai MOQ maklon maupun kontrak pasokan.</p>

                    <div class="cs-faq-concierge-meta">
                        <div>
                            <span>Waktu Respon</span>
                            <strong>1×24 Jam Kerja</strong>
                        </div>
                        <div>
                            <span>Jam Operasional</span>
                            <strong>Senin – Sabtu · 08.00–17.00</strong>
                        </div>
                    </div>

                    <div class="cs-faq-concierge-actions">
                        <a
                            href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                            class="ch-pill-cta"
                            target="_blank"
                            rel="noopener"
                            id="faq-wa-btn"
                        >
                            <span>Chat WhatsApp Sekarang</span>
                            <span class="ch-pill-cta-icon" aria-hidden="true">
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </span>
                        </a>
                        <div class="cs-faq-sublinks">
                            <a href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>" class="ch-lime-link">Halaman Kontak</a>
                            <a href="<?php echo esc_url( home_url( '/kemitraan/' ) ); ?>" class="ch-lime-link">Program Kemitraan</a>
                        </div>
                    </div>
                </aside>

                <div class="faq-content-wrap cs-faq-ledger">
                    <?php foreach ( $faq_categories as $key => $category ) : ?>
                        <section class="faq-group-section cs-faq-group" id="sec-<?php echo esc_attr( $key ); ?>">
                            <header class="cs-faq-group-head">
                                <span class="cs-index-num"><?php echo esc_html( $category['num'] ); ?></span>
                                <h2 class="faq-group-title"><?php echo esc_html( $category['label'] ); ?></h2>
                            </header>

                            <div class="faq-accordion-group cs-faq-accordion-list">
                                <?php foreach ( $category['items'] as $item ) : ?>
                                    <div class="faq-accordion-item cs-faq-row">
                                        <button type="button" class="faq-header-btn cs-faq-trigger" aria-expanded="false">
                                            <span><?php echo esc_html( $item['q'] ); ?></span>
                                            <span class="faq-toggle-icon" aria-hidden="true">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"/></svg>
                                            </span>
                                        </button>
                                        <div class="faq-body-content cs-faq-body" aria-hidden="true">
                                            <div class="faq-body-inner cs-faq-answer">
                                                <p><?php echo esc_html( $item['a'] ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>

                    <div id="faq-empty-state" class="faq-empty-state cs-empty-panel">
                        <h3>Pertanyaan tidak ditemukan</h3>
                        <p>Coba gunakan kata kunci pencarian lain atau tampilkan kembali seluruh pertanyaan.</p>
                        <button type="button" id="faq-reset-btn" class="cs-doc-pill">Tampilkan Semua Pertanyaan</button>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionHeaders = document.querySelectorAll('.faq-header-btn');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const item = this.parentElement;
            const content = this.nextElementSibling;
            const isOpen = item.classList.contains('faq-accordion-item--active');

            const siblingItems = item.parentElement.querySelectorAll('.faq-accordion-item');
            siblingItems.forEach(sib => {
                if (sib !== item) {
                    sib.classList.remove('faq-accordion-item--active');
                    sib.querySelector('.faq-header-btn').setAttribute('aria-expanded', 'false');
                    sib.querySelector('.faq-body-content').style.maxHeight = null;
                    sib.querySelector('.faq-body-content').setAttribute('aria-hidden', 'true');
                }
            });

            if (!isOpen) {
                item.classList.add('faq-accordion-item--active');
                this.setAttribute('aria-expanded', 'true');
                content.style.maxHeight = content.scrollHeight + 'px';
                content.setAttribute('aria-hidden', 'false');
            } else {
                item.classList.remove('faq-accordion-item--active');
                this.setAttribute('aria-expanded', 'false');
                content.style.maxHeight = null;
                content.setAttribute('aria-hidden', 'true');
            }
        });
    });

    const navButtons = document.querySelectorAll('.faq-nav-btn');
    const sections = document.querySelectorAll('.faq-group-section');

    navButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            navButtons.forEach(b => b.classList.remove('faq-nav-btn--active'));
            this.classList.add('faq-nav-btn--active');
            const targetSection = document.getElementById('sec-' + this.getAttribute('data-target'));
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    window.addEventListener('scroll', function() {
        let currentSectionId = '';
        const scrollPosition = window.scrollY + 150;
        sections.forEach(section => {
            if (section.style.display !== 'none') {
                const top = section.offsetTop;
                const height = section.offsetHeight;
                if (scrollPosition >= top && scrollPosition < top + height) {
                    currentSectionId = section.getAttribute('id').replace('sec-', '');
                }
            }
        });
        if (currentSectionId) {
            navButtons.forEach(btn => {
                btn.classList.toggle('faq-nav-btn--active', btn.getAttribute('data-target') === currentSectionId);
            });
        }
    }, { passive: true });

    const searchInput = document.getElementById('faq-search-input');
    const emptyState = document.getElementById('faq-empty-state');
    const resetBtn = document.getElementById('faq-reset-btn');
    const jumpBar = document.querySelector('.cs-faq-jumpbar');

    function runFaqFilter(rawQuery) {
        const query = rawQuery.toLowerCase().trim();
        let totalVisible = 0;

        sections.forEach(section => {
            const items = section.querySelectorAll('.faq-accordion-item');
            let sectionHasMatches = false;

            items.forEach(item => {
                const questionText = item.querySelector('.faq-header-btn span').textContent.toLowerCase();
                const answerText = item.querySelector('.faq-body-inner p').textContent.toLowerCase();

                if (questionText.includes(query) || answerText.includes(query)) {
                    item.style.display = 'block';
                    sectionHasMatches = true;
                    totalVisible++;
                } else {
                    item.style.display = 'none';
                    item.classList.remove('faq-accordion-item--active');
                    item.querySelector('.faq-header-btn').setAttribute('aria-expanded', 'false');
                    item.querySelector('.faq-body-content').style.maxHeight = null;
                }
            });

            section.style.display = sectionHasMatches ? 'block' : 'none';
        });

        if (emptyState) {
            emptyState.style.display = totalVisible === 0 ? 'block' : 'none';
        }
        if (jumpBar) {
            jumpBar.style.opacity = totalVisible === 0 ? '0.45' : '1';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            runFaqFilter(this.value);
        });
    }

    if (resetBtn && searchInput) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            runFaqFilter('');
            searchInput.focus();
        });
    }
});
</script>

<?php get_footer(); ?>
