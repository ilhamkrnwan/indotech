<?php
/**
 * Template Name: Download Center
 * Template Post Type: page, attachment
 *
 * Perpustakaan Dokumen & SDS/MSDS PT Indotech Berkah Abadi — Arsitektur Manufy Daylight.
 * Mempertahankan search, category tabs, 6 mode tampilan, PDF preview modal, & gated lead modal.
 */

$terms = get_terms( [
    'taxonomy'   => 'download_category',
    'hide_empty' => true,
] );

$files = get_posts( [
    'post_type'      => 'attachment',
    'post_mime_type' => 'application/pdf',
    'post_status'    => 'inherit',
    'posts_per_page' => -1,
] );

get_header();
?>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <section class="cs-hero cs-hero--compact ch-wrap" id="download-hero" aria-labelledby="cs-dl-hero-title">
            <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Unduhan</span>
            </nav>

            <div class="cs-hero-head">
                <div class="cs-hero-copy">
                    <p>Akses lembar data keselamatan bahan (SDS/MSDS), dokumen legalitas, serta katalog resmi produk PT Indotech Berkah Abadi.</p>
                </div>

                <div class="cs-hero-title-group">
                    <h1 id="cs-dl-hero-title" class="ch-hero-h1">
                        <span class="ch-h1-primary">Pusat Unduhan</span>
                        <span class="ch-h1-row">
                            <span class="ch-tilt-badge">Dokumen PDF</span>
                            <span class="ch-h1-secondary">Katalog &amp; SDS</span>
                        </span>
                    </h1>
                </div>
            </div>
        </section>

        <section class="cs-band cs-band--tight ch-wrap" aria-label="Direktori dokumen PDF">
            <div class="download-toolbar">
                <div class="search-box-wrap">
                    <label class="ch-sr-only" for="download-search">Cari nama dokumen PDF</label>
                    <input type="text" id="download-search" class="search-input" placeholder="Cari nama dokumen atau kategori...">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <div class="view-switcher">
                    <span class="view-switcher-label">Tampilan:</span>
                    <div class="view-buttons-group">
                        <button type="button" class="view-btn active" data-view="card" title="Tampilan Card">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            <span>Card</span>
                        </button>
                        <button type="button" class="view-btn" data-view="grid" title="Tampilan Grid">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Grid</span>
                        </button>
                        <button type="button" class="view-btn" data-view="list" title="Tampilan List">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span>List</span>
                        </button>
                        <button type="button" class="view-btn" data-view="icon-small" title="Ikon Kecil">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon K</span>
                        </button>
                        <button type="button" class="view-btn" data-view="icon-medium" title="Ikon Sedang">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon S</span>
                        </button>
                        <button type="button" class="view-btn" data-view="icon-large" title="Ikon Besar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon B</span>
                        </button>
                    </div>
                </div>
            </div>

            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                <div class="category-filters-container" aria-label="Filter kategori dokumen">
                    <button type="button" class="filter-btn active" data-filter="all">Semua Kategori</button>
                    <?php foreach ( $terms as $term ) : ?>
                        <button type="button" class="filter-btn" data-filter="<?php echo esc_attr( $term->slug ); ?>">
                            <?php echo esc_html( $term->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $files ) ) : ?>
                <div class="download-grid view-card" id="download-files-grid">
                    <?php
                    foreach ( $files as $file ) :
                        $file_id  = $file->ID;
                        $file_url = wp_get_attachment_url( $file_id );
                        $is_gated = function_exists( 'carbon_get_post_meta' ) && carbon_get_post_meta( $file_id, 'download_gate_active' ) === 'yes';

                        $file_categories = get_the_terms( $file_id, 'download_category' );
                        $cat_slugs       = [];
                        $cat_names       = [];
                        if ( ! empty( $file_categories ) && ! is_wp_error( $file_categories ) ) {
                            foreach ( $file_categories as $cat ) {
                                $cat_slugs[] = $cat->slug;
                                $cat_names[] = $cat->name;
                            }
                        }
                        $cat_slugs_str = implode( ' ', $cat_slugs );
                        $cat_names_str = implode( ', ', $cat_names );
                        ?>
                        <article
                            class="download-item"
                            data-title="<?php echo esc_attr( strtolower( $file->post_title ) ); ?>"
                            data-categories="<?php echo esc_attr( $cat_slugs_str ); ?>"
                            data-category-names="<?php echo esc_attr( strtolower( $cat_names_str ) ); ?>"
                        >
                            <div class="download-content-left">
                                <div class="pdf-icon-wrapper" aria-hidden="true">PDF</div>
                                <div class="download-details">
                                    <h2 class="download-title"><?php echo esc_html( $file->post_title ); ?></h2>
                                    <div class="download-meta-wrap">
                                        <span class="download-meta"><?php echo esc_html( $cat_names_str ?: 'Umum' ); ?></span>
                                        <span class="cs-dl-status<?php echo $is_gated ? '' : ' cs-dl-status--open'; ?>">
                                            <?php echo $is_gated ? 'Akses Prospek B2B' : 'Akses Bebas'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="download-actions-wrap">
                                <div class="download-actions">
                                    <button
                                        type="button"
                                        class="cs-dl-btn cs-dl-btn--outline preview-pdf-btn"
                                        data-id="<?php echo esc_attr( $file_id ); ?>"
                                        data-url="<?php echo esc_url( $file_url ); ?>"
                                        data-title="<?php echo esc_attr( $file->post_title ); ?>"
                                        data-gated="<?php echo $is_gated ? '1' : '0'; ?>"
                                    >
                                        Pratinjau
                                    </button>
                                    <a
                                        href="<?php echo esc_url( $file_url ); ?>"
                                        class="cs-dl-btn cs-dl-btn--primary download-pdf-btn"
                                        data-id="<?php echo esc_attr( $file_id ); ?>"
                                        data-url="<?php echo esc_url( $file_url ); ?>"
                                        data-title="<?php echo esc_attr( $file->post_title ); ?>"
                                        data-gated="<?php echo $is_gated ? '1' : '0'; ?>"
                                        <?php echo ! $is_gated ? 'download' : ''; ?>
                                    >
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div id="search-empty-state" class="cs-empty-panel" style="display: none;">
                    <h2>Pencarian Tidak Ditemukan</h2>
                    <p>Tidak ada berkas PDF yang sesuai dengan kata kunci atau filter kategori Anda.</p>
                </div>
            <?php else : ?>
                <div class="cs-empty-panel">
                    <h2>Belum ada dokumen unduhan</h2>
                    <p>Berkas SDS, katalog, dan dokumen teknis PT Indotech Berkah Abadi belum tersedia di daftar unduhan.</p>
                </div>
            <?php endif; ?>
        </section>

        <?php get_template_part( 'template-parts/home/company-cta' ); ?>
    </div>
</main>

<!-- Modal: PDF Preview -->
<div id="pdf-preview-modal" class="pdf-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="pdf-preview-title">
    <div class="pdf-modal-container">
        <div class="pdf-modal-header">
            <h2 id="pdf-preview-title" style="font-size:1rem;margin:0;color:#fff;">Pratinjau Dokumen</h2>
            <div style="display: flex; gap: 12px; align-items: center;">
                <a id="pdf-preview-open-tab" href="#" target="_blank" rel="noopener" class="cs-dark-outline-btn" style="min-height:38px;padding:6px 14px;font-size:0.8125rem;">Buka Tab Baru &nearr;</a>
                <button type="button" class="pdf-modal-close" id="preview-modal-close-btn" aria-label="Tutup pratinjau">&times;</button>
            </div>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdf-preview-iframe" src="" width="100%" height="100%" style="border: none;" title="Pratinjau dokumen PDF"></iframe>
        </div>
    </div>
</div>

<!-- Modal: Gated Lead Form -->
<div id="gated-lead-modal" class="pdf-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="gated-modal-heading">
    <div class="pdf-modal-container" style="max-width: 500px; height: auto; max-height: 90vh;">
        <div class="pdf-modal-header" style="background: var(--ch-cobalt);">
            <h2 id="gated-modal-heading" style="font-size:1rem;margin:0;color:#fff;">Formulir Akses Unduhan</h2>
            <button type="button" class="pdf-modal-close" id="gated-modal-close-btn" aria-label="Tutup formulir">&times;</button>
        </div>
        <div style="padding: 28px; background: var(--ch-white); overflow-y: auto;">
            <p style="font-size: 0.9rem; color: var(--ch-slate); margin: 0 0 18px; line-height: 1.55;">
                Lengkapi formulir singkat berikut sekali saja untuk membuka akses pratinjau dan unduh dokumen katalog serta data keselamatan kami.
            </p>
            <form id="gated-download-form" class="cs-form">
                <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>
                <div style="display:none;" aria-hidden="true">
                    <input type="url" name="website_url" id="website_url_gate" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" id="gated-target-id" name="product_id" value="">
                <input type="hidden" id="gated-target-url" value="">
                <input type="hidden" id="gated-target-action" value="">

                <div class="cs-form-group">
                    <label class="cs-form-label" for="gated-name">Nama Lengkap <span class="form-required">*</span></label>
                    <input type="text" id="gated-name" name="full_name" required placeholder="Masukkan nama Anda" class="gated-form-input">
                </div>

                <div class="cs-form-group">
                    <label class="cs-form-label" for="gated-email">Email Bisnis <span class="form-required">*</span></label>
                    <input type="email" id="gated-email" name="email" required placeholder="nama@perusahaan.com" class="gated-form-input">
                </div>

                <div class="cs-form-group">
                    <label class="cs-form-label" for="gated-phone">Nomor WhatsApp <span class="form-required">*</span></label>
                    <input type="tel" id="gated-phone" name="phone" required placeholder="Contoh: 081234567890" class="gated-form-input">
                </div>

                <div class="cs-form-group">
                    <label class="cs-form-label" for="gated-company">Nama Perusahaan / Instansi</label>
                    <input type="text" id="gated-company" name="company_name" placeholder="Nama perusahaan Anda" class="gated-form-input">
                </div>

                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="message" value="Mengakses dokumen via Download Center Gate.">

                <div id="gated-form-response" class="form-response" style="display: none;"></div>

                <button type="submit" id="gated-submit-btn" class="ch-pill-cta cs-form-submit">
                    <span>Dapatkan Akses Unduh &amp; Pratinjau</span>
                    <span class="ch-pill-cta-icon" aria-hidden="true">
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const filesGrid   = document.getElementById('download-files-grid');

    function applyViewMode(mode) {
        if (!filesGrid) return;
        viewButtons.forEach(b => b.classList.toggle('active', b.dataset.view === mode));
        filesGrid.className = 'download-grid view-' + mode;
    }

    const storedView = localStorage.getItem('indotech_download_view') || 'card';
    applyViewMode(storedView);

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const viewMode = this.dataset.view;
            applyViewMode(viewMode);
            localStorage.setItem('indotech_download_view', viewMode);
        });
    });

    const searchInput   = document.getElementById('download-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const downloadItems = document.querySelectorAll('.download-item');
    const emptyState    = document.getElementById('search-empty-state');

    function runCombinedFilter() {
        const query           = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const activeFilterBtn = document.querySelector('.filter-btn.active');
        const activeFilter    = activeFilterBtn ? activeFilterBtn.dataset.filter : 'all';
        let visibleCount      = 0;

        downloadItems.forEach(item => {
            const title         = item.dataset.title || '';
            const categories    = (item.dataset.categories || '').split(' ');
            const categoryNames = item.dataset.categoryNames || '';

            const matchesSearch   = title.includes(query) || categoryNames.includes(query);
            const matchesCategory = (activeFilter === 'all' || categories.includes(activeFilter));

            if (matchesSearch && matchesCategory) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            runCombinedFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', runCombinedFilter);
    }

    const previewModal   = document.getElementById('pdf-preview-modal');
    const previewIframe  = document.getElementById('pdf-preview-iframe');
    const previewTitle   = document.getElementById('pdf-preview-title');
    const previewOpenTab = document.getElementById('pdf-preview-open-tab');
    const gatedModal     = document.getElementById('gated-lead-modal');
    const gatedForm      = document.getElementById('gated-download-form');

    function isUnlocked() {
        return localStorage.getItem('indotech_gated_unlocked') === '1';
    }

    function closeAllModals() {
        if (previewModal) {
            previewModal.classList.remove('active');
            if (previewIframe) previewIframe.src = '';
        }
        if (gatedModal) {
            gatedModal.classList.remove('active');
            const responseBox = document.getElementById('gated-form-response');
            if (responseBox) responseBox.style.display = 'none';
        }
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.pdf-modal-close').forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });

    [previewModal, gatedModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeAllModals();
                }
            });
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAllModals();
    });

    function openPreview(url, title) {
        if (!previewModal) return;
        if (previewTitle) previewTitle.textContent = title;
        if (previewOpenTab) previewOpenTab.href = url;
        if (previewIframe) previewIframe.src = url;
        previewModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function openGatedModal(id, url, action) {
        if (!gatedModal) return;
        document.getElementById('gated-target-id').value     = id;
        document.getElementById('gated-target-url').value    = url;
        document.getElementById('gated-target-action').value = action;
        gatedModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    document.querySelectorAll('.preview-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.dataset.gated === '1' && !isUnlocked()) {
                openGatedModal(this.dataset.id, this.dataset.url, 'preview');
            } else {
                openPreview(this.dataset.url, this.dataset.title);
            }
        });
    });

    document.querySelectorAll('.download-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.dataset.gated === '1' && !isUnlocked()) {
                e.preventDefault();
                openGatedModal(this.dataset.id, this.dataset.url, 'download');
            }
        });
    });

    if (gatedForm) {
        gatedForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn   = document.getElementById('gated-submit-btn');
            const responseBox = document.getElementById('gated-form-response');
            const formData    = new FormData(gatedForm);
            formData.append('action', 'indotech_submit_inquiry');
            formData.append('nonce', indotechData.nonce);

            if (submitBtn) {
                submitBtn.disabled = true;
            }

            fetch(indotechData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    localStorage.setItem('indotech_gated_unlocked', '1');
                    if (responseBox) {
                        responseBox.style.display = 'block';
                        responseBox.className     = 'form-response success';
                        responseBox.textContent   = 'Akses dibuka! Mengunduh dokumen...';
                    }

                    const action   = document.getElementById('gated-target-action').value;
                    const url      = document.getElementById('gated-target-url').value;
                    const targetId = document.getElementById('gated-target-id').value;

                    setTimeout(() => {
                        closeAllModals();
                        if (action === 'preview') {
                            const btn   = document.querySelector(`.preview-pdf-btn[data-id="${targetId}"]`);
                            const title = btn ? btn.dataset.title : 'Dokumen';
                            openPreview(url, title);
                        } else {
                            const downloadLink    = document.createElement('a');
                            downloadLink.href     = url;
                            downloadLink.download = url.split('/').pop();
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }
                    }, 1000);
                } else if (responseBox) {
                    responseBox.style.display = 'block';
                    responseBox.className     = 'form-response error';
                    responseBox.textContent   = (data.data && data.data.message) ? data.data.message : 'Gagal mengirimkan formulir.';
                }
            })
            .catch(() => {
                if (responseBox) {
                    responseBox.style.display = 'block';
                    responseBox.className     = 'form-response error';
                    responseBox.textContent   = 'Koneksi internet bermasalah. Silakan coba kembali.';
                }
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
            });
        });
    }
});
</script>

<?php get_footer(); ?>
