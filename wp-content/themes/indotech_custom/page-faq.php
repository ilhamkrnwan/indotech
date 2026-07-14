<?php
/**
 * Template Name: FAQ
 *
 * Halaman FAQ (Frequently Asked Questions) PT Indotech Berkah Abadi.
 * Features: Search Filter · Category Navigation · Interactive Accordion · Contact CTA
 */

$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya lebih lanjut karena tidak menemukan jawaban di halaman FAQ.' );

get_header();

// FAQ Data Array categorized for clean display
$faq_categories = [
    'umum' => [
        'label' => 'Umum',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        'items' => [
            [
                'q' => 'Siapa PT Indotech Berkah Abadi?',
                'a' => 'PT Indotech Berkah Abadi adalah produsen dan pemasok terpercaya untuk produk kebersihan rumah tangga (homecare), kimia laundry, produk perawatan otomotif (car care), serta penyedia jasa maklon (private label) yang berpusat di Sleman, Yogyakarta.'
            ],
            [
                'q' => 'Apakah seluruh produk Indotech memiliki izin edar resmi?',
                'a' => 'Ya, seluruh produk kami telah teruji secara klinis dan memiliki izin edar resmi dari Kementerian Kesehatan Republik Indonesia (Kemenkes RI) serta sertifikasi Halal resmi dari MUI.'
            ],
            [
                'q' => 'Di mana lokasi kantor operasional PT Indotech Berkah Abadi?',
                'a' => 'Kantor operasional kami berlokasi di Jongke Tengah No. 30, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285. Anda dapat melihat peta petunjuk arah langsung di halaman Kontak kami.'
            ]
        ]
    ],
    'produk' => [
        'label' => 'Produk & Formulasi',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
        'items' => [
            [
                'q' => 'Apa keunggulan produk paket bahan sabun (biang/konsentrat)?',
                'a' => 'Produk paket bahan sabun (seperti Arai, Detta Plus, dan Determat) dirancang untuk meminimalkan biaya pengiriman. Anda cukup membeli biang konsentrat seberat 1 kg, lalu mencampurnya dengan air bersih di lokasi Anda untuk menghasilkan hingga 15 liter sabun siap pakai berkualitas premium.'
            ],
            [
                'q' => 'Bagaimana cara melarutkan paket bahan sabun konsentrat?',
                'a' => 'Setiap pembelian paket bahan sabun dilengkapi dengan petunjuk pembuatan tertulis yang sangat detail di dalam kemasan. Secara umum, Anda cukup mencampurkan pasta biang ke dalam wadah bersih, lalu menuangkan air secara bertahap sambil diaduk rata, kemudian mendiamkannya selama 12–24 jam hingga busa mereda sepenuhnya.'
            ],
            [
                'q' => 'Apakah produk detergen dan sabun cuci aman untuk kulit sensitif?',
                'a' => 'Ya, formulasi sabun kami menggunakan pH balancer khusus yang lembut di kulit, ramah lingkungan, serta tidak menimbulkan rasa panas atau iritasi bagi sebagian besar pengguna.'
            ]
        ]
    ],
    'kemitraan' => [
        'label' => 'Kemitraan & Maklon',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'items' => [
            [
                'q' => 'Bagaimana cara menjadi agen atau distributor resmi Indotech?',
                'a' => 'Kami membuka kesempatan kemitraan seluas-luasnya di seluruh wilayah Indonesia. Anda dapat mendaftar melalui menu Kemitraan di website ini atau langsung menghubungi perwakilan marketing kami melalui WhatsApp untuk mendapatkan proposal paket kemitraan.'
            ],
            [
                'q' => 'Apakah Indotech melayani jasa maklon (private label) produk?',
                'a' => 'Tentu. Kami melayani jasa maklon OEM/ODM secara profesional mulai dari formulasi custom sesuai kebutuhan Anda, penyediaan kemasan, pendaftaran izin edar Kemenkes RI, hingga produksi massal berskala besar dengan brand milik Anda sendiri.'
            ],
            [
                'q' => 'Apakah ada minimal pemesanan (MOQ) untuk jasa maklon?',
                'a' => 'Minimal pemesanan (MOQ) untuk maklon bervariasi tergantung pada jenis produk, volume kemasan, dan tingkat kesulitan formulasi. Silakan hubungi tim B2B kami untuk melakukan konsultasi gratis mengenai rencana brand Anda.'
            ]
        ]
    ],
    'pengiriman' => [
        'label' => 'Pemesanan & Pengiriman',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'items' => [
            [
                'q' => 'Apakah bisa mengirim ke luar pulau Jawa?',
                'a' => 'Bisa. Kami bekerja sama dengan berbagai ekspedisi kargo darat dan laut terpercaya yang siap mengantarkan produk kimia cair maupun paket bahan sabun kami dengan aman ke seluruh wilayah 34 provinsi di Indonesia.'
            ],
            [
                'q' => 'Berapa lama estimasi waktu pengiriman barang?',
                'a' => 'Untuk wilayah pulau Jawa, estimasi pengiriman kargo berkisar antara 2–4 hari kerja. Sedangkan untuk luar pulau Jawa berkisar antara 5–12 hari kerja tergantung jarak lokasi tujuan Anda.'
            ]
        ]
    ]
];

// FAQPage schema (GEO): ratakan semua Q&A jadi satu daftar untuk mesin AI.
$faq_flat = [];
foreach ( $faq_categories as $cat ) {
	foreach ( $cat['items'] as $item ) {
		$faq_flat[] = $item;
	}
}
if ( function_exists( 'indotech_render_faq_schema' ) ) {
	indotech_render_faq_schema( $faq_flat );
}
?>

<style>
/* ════════════════════════════════════════════════════════
   FAQ CUSTOM PAGE STYLES (Clean & Modern Glassmorphism)
   ════════════════════════════════════════════════════════ */
.faq-search-wrap {
    margin-top: -30px;
    margin-bottom: 50px;
    position: relative;
    z-index: 10;
}
.faq-search-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-md);
    max-width: 680px;
    margin: 0 auto;
    transition: all 0.3s ease;
}
.faq-search-card:focus-within {
    border-color: var(--cobalt);
    box-shadow: 0 10px 25px rgba(0, 87, 255, 0.12);
}
.faq-search-input {
    border: none;
    outline: none;
    font-size: 16px;
    color: var(--ink);
    width: 100%;
    background: transparent;
}
.faq-search-icon {
    color: var(--text-muted);
    flex-shrink: 0;
}

.faq-layout-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 40px;
    align-items: start;
}

/* Sidebar Tabs Navigation */
.faq-sidebar {
    position: sticky;
    top: 100px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.faq-nav-btn {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    border: 1px solid transparent;
    border-radius: 12px;
    background: transparent;
    color: var(--text-secondary);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    text-align: left;
    transition: all 0.3s ease;
}
.faq-nav-btn svg {
    transition: color 0.3s ease;
}
.faq-nav-btn:hover {
    background: var(--white);
    color: var(--cobalt);
}
.faq-nav-btn--active {
    background: var(--white);
    color: var(--cobalt);
    border-color: var(--border);
    box-shadow: var(--shadow-sm);
}

/* Accordion Styling */
.faq-content-wrap {
    display: flex;
    flex-direction: column;
    gap: 40px;
}
.faq-group-section {
    scroll-margin-top: 110px;
}
.faq-group-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 12px;
}
.faq-group-title-wrap svg {
    color: var(--cobalt);
}
.faq-group-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
}

.faq-accordion-item {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.faq-accordion-item:hover {
    border-color: var(--cobalt-pale-border);
    box-shadow: 0 4px 15px rgba(0, 87, 255, 0.04);
}
.faq-accordion-item--active {
    border-color: var(--cobalt);
    box-shadow: 0 8px 24px rgba(0, 87, 255, 0.06);
}

.faq-header-btn {
    width: 100%;
    padding: 22px 28px;
    background: none;
    border: none;
    outline: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    font-size: 16px;
    font-weight: 700;
    color: var(--ink);
    cursor: pointer;
    gap: 16px;
}
.faq-header-btn:focus-visible {
    background: var(--surface);
}
.faq-toggle-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--surface);
    color: var(--text-secondary);
    transition: all 0.3s ease;
}
.faq-accordion-item--active .faq-toggle-icon {
    background: var(--cobalt);
    color: var(--white);
    transform: rotate(180deg);
}

.faq-body-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.faq-body-inner {
    padding: 0 28px 28px 28px;
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-secondary);
}

/* Empty search placeholder */
.faq-empty-state {
    display: none;
    text-align: center;
    padding: 60px 20px;
    background: var(--white);
    border: 1px dashed var(--border);
    border-radius: 16px;
    color: var(--text-muted);
}
.faq-empty-state svg {
    margin-bottom: 16px;
    color: var(--text-muted);
}

/* Responsive Styles */
@media (max-width: 991px) {
    .faq-layout-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .faq-sidebar {
        position: static;
        flex-direction: row;
        overflow-x: auto;
        padding-bottom: 8px;
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
    }
    .faq-sidebar::-webkit-scrollbar {
        display: none;
    }
    .faq-nav-btn {
        flex-shrink: 0;
        scroll-snap-align: start;
        padding: 12px 18px;
    }
}
</style>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         HERO SECTION — Desain Premium & Selaras dengan Tema
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero" id="faq-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">FAQ</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Pusat Bantuan</span>
            <h1 class="inner-page-title">Pertanyaan <em>Sering Diajukan</em></h1>
            <p class="inner-page-subtitle">Temukan jawaban cepat atas pertanyaan seputar formulasi produk, metode penggunaan, serta prosedur kemitraan kami.</p>
        </div>
    </section>

    <div class="container" style="margin-bottom: 100px;">

        <!-- ════════════════════════════════════════════════════════
             SEARCH BAR — Filter Pencarian Realtime
        ════════════════════════════════════════════════════════ -->
        <div class="faq-search-wrap reveal">
            <div class="faq-search-card">
                <div class="faq-search-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input 
                    type="text" 
                    id="faq-search-input" 
                    class="faq-search-input" 
                    placeholder="Ketik kata kunci pertanyaan Anda di sini..."
                    aria-label="Cari pertanyaan"
                >
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════════
             MAIN LAYOUT — Sidebar & List Accordion
        ════════════════════════════════════════════════════════ -->
        <div class="faq-layout-grid">
            
            <!-- Sidebar Navigation Tabs -->
            <aside class="faq-sidebar reveal">
                <?php 
                $first = true;
                foreach ($faq_categories as $key => $category) : 
                ?>
                    <button 
                        class="faq-nav-btn <?php echo $first ? 'faq-nav-btn--active' : ''; ?>"
                        data-target="<?php echo esc_attr($key); ?>"
                    >
                        <?php echo $category['icon']; ?>
                        <span><?php echo esc_html($category['label']); ?></span>
                    </button>
                <?php 
                    $first = false;
                endforeach; 
                ?>
            </aside>

            <!-- Accordion List Content -->
            <div class="faq-content-wrap">
                
                <?php foreach ($faq_categories as $key => $category) : ?>
                    <section class="faq-group-section reveal" id="sec-<?php echo esc_attr($key); ?>">
                        <div class="faq-group-title-wrap">
                            <?php echo $category['icon']; ?>
                            <h2 class="faq-group-title"><?php echo esc_html($category['label']); ?></h2>
                        </div>

                        <div class="faq-accordion-group">
                            <?php foreach ($category['items'] as $item) : ?>
                                <div class="faq-accordion-item">
                                    <button class="faq-header-btn" aria-expanded="false">
                                        <span><?php echo esc_html($item['q']); ?></span>
                                        <span class="faq-toggle-icon" aria-hidden="true">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                                        </span>
                                    </button>
                                    <div class="faq-body-content" aria-hidden="true">
                                        <div class="faq-body-inner">
                                            <p><?php echo esc_html($item['a']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>

                <!-- Empty State (Jika hasil pencarian tidak ditemukan) -->
                <div id="faq-empty-state" class="faq-empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M8 15h8"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                    <h3>Pertanyaan tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci pencarian yang lain.</p>
                </div>

            </div>

        </div>

    </div>

    <!-- ════════════════════════════════════════════════════════
         STILL HAVE QUESTIONS? — CTA Strip ke WhatsApp
    ════════════════════════════════════════════════════════ -->
    <section class="wa-cta-strip" id="faq-wa-strip">
        <div class="container wa-cta-inner">
            <div class="wa-cta-text">
                <span class="wa-cta-title">Belum menemukan jawaban Anda?</span>
                <span class="wa-cta-sub">Tanyakan langsung pada customer support kami yang ramah via WhatsApp.</span>
            </div>
            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
               class="btn wa-cta-btn"
               target="_blank" rel="noopener"
               id="faq-wa-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Chat WhatsApp Sekarang
            </a>
        </div>
    </section>

</main>

<script>
/**
 * FAQ Interactive JS (Accordion & Filter Search)
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Accordion Toggle Logic
    const accordionHeaders = document.querySelectorAll('.faq-header-btn');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const item = this.parentElement;
            const content = this.nextElementSibling;
            const isOpen = item.classList.contains('faq-accordion-item--active');
            
            // Close other open accordions in the same group (optional, but cleaner)
            const siblingItems = item.parentElement.querySelectorAll('.faq-accordion-item');
            siblingItems.forEach(sib => {
                if (sib !== item) {
                    sib.classList.remove('faq-accordion-item--active');
                    sib.querySelector('.faq-header-btn').setAttribute('aria-expanded', 'false');
                    sib.querySelector('.faq-body-content').style.maxHeight = null;
                    sib.querySelector('.faq-body-content').setAttribute('aria-hidden', 'true');
                }
            });

            // Toggle current accordion
            if (!isOpen) {
                item.classList.add('faq-accordion-item--active');
                this.setAttribute('aria-expanded', 'true');
                content.style.maxHeight = content.scrollHeight + "px";
                content.setAttribute('aria-hidden', 'false');
            } else {
                item.classList.remove('faq-accordion-item--active');
                this.setAttribute('aria-expanded', 'false');
                content.style.maxHeight = null;
                content.setAttribute('aria-hidden', 'true');
            }
        });
    });

    // 2. Sidebar Navigation Smooth Scroll / Filter
    const navButtons = document.querySelectorAll('.faq-nav-btn');
    const sections = document.querySelectorAll('.faq-group-section');

    navButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active classes
            navButtons.forEach(b => b.classList.remove('faq-nav-btn--active'));
            this.classList.add('faq-nav-btn--active');

            const targetId = this.getAttribute('data-target');
            const targetSection = document.getElementById('sec-' + targetId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Highlight sidebar category on scroll
    window.addEventListener('scroll', function() {
        let currentSectionId = '';
        const scrollPosition = window.scrollY + 150; // offset

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
                if (btn.getAttribute('data-target') === currentSectionId) {
                    btn.classList.add('faq-nav-btn--active');
                } else {
                    btn.classList.remove('faq-nav-btn--active');
                }
            });
        }
    });

    // 3. Realtime Search Filter Logic
    const searchInput = document.getElementById('faq-search-input');
    const emptyState = document.getElementById('faq-empty-state');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
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
                    // If closed, collapse heights
                    item.classList.remove('faq-accordion-item--active');
                    item.querySelector('.faq-header-btn').setAttribute('aria-expanded', 'false');
                    item.querySelector('.faq-body-content').style.maxHeight = null;
                }
            });

            // If no items match in this section, hide the entire section title
            if (sectionHasMatches) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });

        // Show/hide empty state message
        if (totalVisible === 0) {
            emptyState.style.display = 'block';
            document.querySelector('.faq-sidebar').style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            document.querySelector('.faq-sidebar').style.display = 'flex';
        }
    });
});
</script>

<?php get_footer(); ?>
