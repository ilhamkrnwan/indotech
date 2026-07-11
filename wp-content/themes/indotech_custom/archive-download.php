<?php
/**
 * Template Name: Download Center
 * Template Post Type: page, attachment
 */

get_header();

// Fetch all download categories for the filter tabs
$terms = get_terms([
    'taxonomy'   => 'download_category',
    'hide_empty' => true
]);

// Fetch all PDF files in a single query so they can align side-by-side in one grid
$files = get_posts([
    'post_type'      => 'attachment',
    'post_mime_type' => 'application/pdf',
    'post_status'    => 'inherit',
    'posts_per_page' => -1,
]);
?>

<style>
/* Toolbar Styling */
.download-toolbar {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-xs);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}
.search-box-wrap {
    position: relative;
    flex: 1;
    max-width: 420px;
    min-width: 260px;
}
.search-input {
    width: 100%;
    border: 1.5px solid var(--border);
    border-radius: 30px;
    padding: 12px 20px 12px 48px;
    font-size: 14px;
    color: var(--ink);
    background: var(--surface);
    transition: all 0.2s ease;
}
.search-input:focus {
    border-color: var(--cobalt);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.1);
    outline: none;
}
.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    pointer-events: none;
    transition: color 0.2s;
}
.search-input:focus + .search-icon {
    color: var(--cobalt);
}

.view-switcher {
    display: flex;
    align-items: center;
    gap: 12px;
}
.view-switcher-label {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-secondary);
}
.view-buttons-group {
    display: flex;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 4px;
    gap: 2px;
}
.view-btn {
    background: transparent;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.view-btn svg {
    color: var(--text-muted);
    transition: color 0.2s;
}
.view-btn:hover {
    color: var(--ink);
}
.view-btn:hover svg {
    color: var(--text-secondary);
}
.view-btn.active {
    background: var(--white);
    color: var(--cobalt);
    box-shadow: var(--shadow-xs);
}
.view-btn.active svg {
    color: var(--cobalt);
}

/* Category Filters (Tabs) */
.category-filters-container {
    display: flex;
    gap: 10px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}
.filter-btn {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 8px 18px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s ease;
}
.filter-btn:hover {
    border-color: var(--cobalt);
    color: var(--cobalt);
    background: rgba(0, 87, 255, 0.02);
}
.filter-btn.active {
    background: var(--cobalt);
    border-color: var(--cobalt);
    color: var(--white);
    box-shadow: 0 4px 10px rgba(0, 87, 255, 0.15);
}

/* Download Grid & Item Layouts */
.download-grid {
    display: grid;
    transition: all 0.3s ease;
}

.download-item {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    text-align: left; /* Enforce default left align */
}
.download-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-sm);
    border-color: var(--cobalt);
}

.pdf-icon-wrapper {
    background: rgba(239, 68, 68, 0.08);
    color: #ef4444;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-family: 'Space Grotesk', sans-serif;
    transition: all 0.3s ease;
}

.download-title {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.45;
    margin-bottom: 8px;
    transition: color 0.2s;
    text-align: left; /* Enforce default left align */
}
.download-item:hover .download-title {
    color: var(--cobalt);
}

.download-meta-wrap {
    text-align: left; /* Enforce default left align */
    width: 100%;
}

.download-meta {
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.download-actions {
    display: flex;
    gap: 8px;
    width: 100%;
}
.download-actions .btn {
    flex: 1;
    font-size: 12px;
    padding: 8px 12px;
    justify-content: center;
    text-align: center;
}

/* Layout definitions */

/* 1. LIST VIEW */
.download-grid.view-list {
    grid-template-columns: 1fr !important;
    gap: 12px;
}
.download-grid.view-list .download-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    text-align: left;
}
.download-grid.view-list .download-content-left {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
    text-align: left;
}
.download-grid.view-list .pdf-icon-wrapper {
    width: 42px;
    height: 42px;
    font-size: 11px;
    margin-left: 0;
    margin-right: 0;
}
.download-grid.view-list .download-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    text-align: left;
}
.download-grid.view-list .download-title {
    margin-bottom: 0;
    text-align: left;
}
.download-grid.view-list .download-meta-wrap {
    text-align: left;
}
.download-grid.view-list .download-actions-wrap {
    display: flex;
    align-items: center;
    gap: 20px;
}
.download-grid.view-list .download-actions {
    width: auto;
    min-width: 200px;
}

/* 2. CARD VIEW (Default) */
.download-grid.view-card {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}
.download-grid.view-card .download-item {
    min-height: 190px;
    align-items: flex-start;
    text-align: left;
}
.download-grid.view-card .pdf-icon-wrapper {
    width: 48px;
    height: 48px;
    font-size: 12px;
    margin-bottom: 14px;
    margin-left: 0;
    margin-right: auto;
}
.download-grid.view-card .download-title {
    text-align: left;
}
.download-grid.view-card .download-meta-wrap {
    text-align: left;
}
.download-grid.view-card .download-actions {
    margin-top: 16px;
}

/* 3. GRID VIEW (Compact) */
.download-grid.view-grid {
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 16px;
}
.download-grid.view-grid .download-item {
    min-height: 160px;
    align-items: flex-start;
    text-align: left;
}
.download-grid.view-grid .pdf-icon-wrapper {
    width: 38px;
    height: 38px;
    font-size: 10px;
    margin-bottom: 12px;
    margin-left: 0;
    margin-right: auto;
}
.download-grid.view-grid .download-title {
    font-size: 13.5px;
    text-align: left;
}
.download-grid.view-grid .download-meta-wrap {
    text-align: left;
}
.download-grid.view-grid .download-actions {
    margin-top: 12px;
}

/* 4. ICON SMALL */
.download-grid.view-icon-small {
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}
.download-grid.view-icon-small .download-item {
    align-items: center;
    text-align: center;
    padding: 16px;
}
.download-grid.view-icon-small .pdf-icon-wrapper {
    width: 48px;
    height: 48px;
    font-size: 12px;
    margin-bottom: 12px;
    margin-left: auto;
    margin-right: auto;
}
.download-grid.view-icon-small .download-title {
    font-size: 13px;
    line-height: 1.35;
    margin-bottom: 6px;
    text-align: center;
}
.download-grid.view-icon-small .download-meta-wrap {
    text-align: center;
}
.download-grid.view-icon-small .download-actions {
    margin-top: 12px;
}

/* 5. ICON MEDIUM */
.download-grid.view-icon-medium {
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}
.download-grid.view-icon-medium .download-item {
    align-items: center;
    text-align: center;
    padding: 20px;
}
.download-grid.view-icon-medium .pdf-icon-wrapper {
    width: 68px;
    height: 68px;
    font-size: 15px;
    margin-bottom: 16px;
    margin-left: auto;
    margin-right: auto;
}
.download-grid.view-icon-medium .download-title {
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 8px;
    text-align: center;
}
.download-grid.view-icon-medium .download-meta-wrap {
    text-align: center;
}
.download-grid.view-icon-medium .download-actions {
    margin-top: 14px;
}

/* 6. ICON LARGE */
.download-grid.view-icon-large {
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
}
.download-grid.view-icon-large .download-item {
    align-items: center;
    text-align: center;
    padding: 28px 20px;
}
.download-grid.view-icon-large .pdf-icon-wrapper {
    width: 96px;
    height: 96px;
    font-size: 20px;
    margin-bottom: 20px;
    margin-left: auto;
    margin-right: auto;
}
.download-grid.view-icon-large .download-title {
    font-size: 15px;
    line-height: 1.45;
    margin-bottom: 10px;
    text-align: center;
}
.download-grid.view-icon-large .download-meta-wrap {
    text-align: center;
}
.download-grid.view-icon-large .download-actions {
    margin-top: 18px;
}

/* Modal Overlay Styling */
.pdf-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(6px);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.pdf-modal-overlay.active {
    display: flex;
    opacity: 1;
}
.pdf-modal-container {
    width: 90%;
    height: 85%;
    background: var(--white);
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: scale(0.95);
    transition: transform 0.3s ease;
}
.pdf-modal-overlay.active .pdf-modal-container {
    transform: scale(1);
}
.pdf-modal-header {
    background: #0f172a;
    color: var(--white);
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pdf-modal-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--white);
}
.pdf-modal-close {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    transition: color 0.2s;
}
.pdf-modal-close:hover {
    color: var(--white);
}
.pdf-modal-body {
    flex: 1;
    background: #f1f5f9;
}

/* Custom form styles for gated modal */
.gated-form-input {
    width: 100%; 
    border: 1.5px solid var(--border); 
    border-radius: 8px; 
    padding: 11px 14px; 
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.2s;
}
.gated-form-input:focus {
    border-color: var(--cobalt);
    outline: none;
}

@media (max-width: 768px) {
    .download-toolbar {
        flex-direction: column;
        align-items: stretch;
        padding: 16px;
    }
    .search-box-wrap {
        max-width: 100%;
    }
    .view-switcher {
        flex-direction: column;
        align-items: flex-start;
    }
    .view-buttons-group {
        width: 100%;
        overflow-x: auto;
    }
    .view-btn {
        flex: 1;
        justify-content: center;
        padding: 8px;
    }
    .view-btn span {
        display: none; /* Hide labels on mobile to fit SVGs */
    }
    .download-grid.view-list .download-item {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    .download-grid.view-list .download-actions {
        width: 100%;
    }
}
</style>

<main id="main-content">

    <!-- ════════════════════════════════════════════════════════
         PAGE HERO
    ════════════════════════════════════════════════════════ -->
    <section class="inner-page-hero" id="download-hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-grid-overlay"></div>
            <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
        </div>
        <div class="container inner-page-hero-inner reveal">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Unduhan</span>
            </nav>
            <span class="section-tag" style="color:rgba(255,255,255,.7);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);">Perpustakaan Dokumen</span>
            <h1 class="inner-page-title">Pusat Unduhan <em>Dokumen</em></h1>
            <p class="inner-page-subtitle">Akses lembar data keselamatan (SDS/MSDS), sertifikat legalitas, dan katalog PDF produk resmi kami secara mudah.</p>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════
         CONTENT SECTION
    ════════════════════════════════════════════════════════ -->
    <section class="download-archive-section section-padding" style="background:var(--surface);">
        <div class="container">

            <!-- ── TOOLBAR (SEARCH & VIEW SWITCHER) ── -->
            <div class="download-toolbar reveal">
                <!-- Search bar -->
                <div class="search-box-wrap">
                    <input type="text" id="download-search" class="search-input" placeholder="Cari nama dokumen...">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>

                <!-- Display Mode Selection Switcher (6 Options) -->
                <div class="view-switcher">
                    <span class="view-switcher-label">Pilih Tampilan:</span>
                    <div class="view-buttons-group">
                        <button class="view-btn active" data-view="card" title="Tampilan Card">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            <span>Card</span>
                        </button>
                        <button class="view-btn" data-view="grid" title="Tampilan Grid">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Grid</span>
                        </button>
                        <button class="view-btn" data-view="list" title="Tampilan List">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span>List</span>
                        </button>
                        <button class="view-btn" data-view="icon-small" title="Ikon Kecil">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon K</span>
                        </button>
                        <button class="view-btn" data-view="icon-medium" title="Ikon Sedang">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon S</span>
                        </button>
                        <button class="view-btn" data-view="icon-large" title="Ikon Besar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Ikon B</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ── CATEGORY FILTERS (TABS) ── -->
            <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                <div class="category-filters-container reveal">
                    <button class="filter-btn active" data-filter="all">Semua Kategori</button>
                    <?php foreach ($terms as $term) : ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- ── SINGLE UNIFIED FILES GRID ── -->
            <?php if (!empty($files)) : ?>
                <div class="download-grid view-card reveal" id="download-files-grid">
                    <?php foreach ($files as $file) : 
                        $file_id = $file->ID;
                        $file_url = wp_get_attachment_url($file_id);
                        $is_gated = carbon_get_post_meta($file_id, 'download_gate_active') === 'yes';
                        
                        // Fetch categories associated with this file
                        $file_categories = get_the_terms($file_id, 'download_category');
                        $cat_slugs = [];
                        $cat_names = [];
                        if (!empty($file_categories) && !is_wp_error($file_categories)) {
                            foreach ($file_categories as $cat) {
                                $cat_slugs[] = $cat->slug;
                                $cat_names[] = $cat->name;
                            }
                        }
                        $cat_slugs_str = implode(' ', $cat_slugs);
                        $cat_names_str = implode(', ', $cat_names);
                    ?>
                        <div class="download-item" 
                             data-title="<?php echo esc_attr(strtolower($file->post_title)); ?>"
                             data-categories="<?php echo esc_attr($cat_slugs_str); ?>"
                             data-category-names="<?php echo esc_attr(strtolower($cat_names_str)); ?>">
                            <div class="download-content-left">
                                <!-- Responsive PDF Icon Graphic -->
                                <div class="pdf-icon-wrapper">PDF</div>
                                <div class="download-details">
                                    <h3 class="download-title"><?php echo esc_html($file->post_title); ?></h3>
                                    <div class="download-meta-wrap">
                                        <span class="download-meta" style="color: var(--text-muted); display: block; margin-bottom: 4px; font-size: 9.5px;">
                                            Category: <?php echo esc_html($cat_names_str ?: 'Umum'); ?>
                                        </span>
                                        <?php if ($is_gated) : ?>
                                            <span class="download-meta" style="color: var(--cobalt);">Wajib Isi Formulir</span>
                                        <?php else : ?>
                                            <span class="download-meta" style="color: #137333;">Akses Bebas</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="download-actions-wrap">
                                <div class="download-actions">
                                    <button class="btn btn-outline preview-pdf-btn" 
                                            data-id="<?php echo esc_attr($file_id); ?>" 
                                            data-url="<?php echo esc_url($file_url); ?>" 
                                            data-title="<?php echo esc_attr($file->post_title); ?>"
                                            data-gated="<?php echo $is_gated ? '1' : '0'; ?>">
                                        Pratinjau
                                    </button>
                                    <a href="<?php echo esc_url($file_url); ?>" 
                                       class="btn btn-primary download-pdf-btn"
                                       data-id="<?php echo esc_attr($file_id); ?>"
                                       data-url="<?php echo esc_url($file_url); ?>"
                                       data-title="<?php echo esc_attr($file->post_title); ?>"
                                       data-gated="<?php echo $is_gated ? '1' : '0'; ?>"
                                       <?php echo !$is_gated ? 'download' : ''; ?>>
                                        Unduh &darr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Empty State Search Result -->
                <div id="search-empty-state" style="display: none; background: var(--white); padding: 50px; border-radius: 16px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);" class="reveal">
                    <h3>Pencarian Tidak Ditemukan</h3>
                    <p>Tidak ada berkas PDF yang sesuai dengan kata kunci atau filter kategori Anda.</p>
                </div>
            <?php else : ?>
                <div class="reveal" style="background: var(--white); padding: 40px; border-radius: 16px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
                    Belum ada dokumen unduhan terdaftar.
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<!-- ════════════════════════════════════════════════════════
     MODAL: PDF PREVIEW (PRATINJAU PDF)
════════════════════════════════════════════════════════ -->
<div id="pdf-preview-modal" class="pdf-modal-overlay">
    <div class="pdf-modal-container">
        <div class="pdf-modal-header">
            <h3 id="pdf-preview-title">Pratinjau Dokumen</h3>
            <div style="display: flex; gap: 12px; align-items: center;">
                <a id="pdf-preview-open-tab" href="#" target="_blank" class="btn btn-outline" style="font-size:12px; padding: 6px 12px; color:#fff; border-color:rgba(255,255,255,0.3);">Buka Tab Baru &nearr;</a>
                <button class="pdf-modal-close" id="preview-modal-close-btn">&times;</button>
            </div>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdf-preview-iframe" src="" width="100%" height="100%" style="border: none;"></iframe>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════════════════
     MODAL: GATED LEAD FORM (FORMULIR UNDUHAN)
════════════════════════════════════════════════════════ -->
<div id="gated-lead-modal" class="pdf-modal-overlay">
    <div class="pdf-modal-container" style="max-width: 500px; height: auto; max-height: 90vh;">
        <div class="pdf-modal-header" style="background: var(--cobalt);">
            <h3>Formulir Akses Unduhan</h3>
            <button class="pdf-modal-close" id="gated-modal-close-btn">&times;</button>
        </div>
        <div style="padding: 30px; background: var(--white); overflow-y: auto;">
            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 20px; line-height: 1.5;">
                Silakan lengkapi formulir singkat berikut sekali saja untuk membuka akses pratinjau dan unduh ke semua dokumen katalog & data keselamatan kami.
            </p>
            <form id="gated-download-form" style="display: flex; flex-direction: column; gap: 16px;">
                <?php wp_nonce_field( 'indotech_inquiry_nonce', 'indotech_nonce' ); ?>
                <!-- Honeypot -->
                <div style="display:none;" aria-hidden="true">
                    <input type="url" name="website_url" id="website_url_gate" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" id="gated-target-id" name="product_id" value="">
                <input type="hidden" id="gated-target-url" value="">
                <input type="hidden" id="gated-target-action" value=""> <!-- 'download' or 'preview' -->
                
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nama Lengkap *</label>
                    <input type="text" id="gated-name" name="full_name" required placeholder="Masukkan nama Anda" class="gated-form-input">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Email Bisnis *</label>
                    <input type="email" id="gated-email" name="email" required placeholder="nama@perusahaan.com" class="gated-form-input">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nomor WA *</label>
                    <input type="tel" id="gated-phone" name="phone" required placeholder="Contoh: 0812345678" class="gated-form-input">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 6px;">Nama Perusahaan / Instansi</label>
                    <input type="text" id="gated-company" name="company_name" placeholder="Nama perusahaan Anda" class="gated-form-input">
                </div>

                <!-- Hidden inputs to conform to standard inquiries handler -->
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="message" value="Mengakses dokumen via Download Center Gate.">

                <div id="gated-form-response" style="display: none; padding: 10px 14px; border-radius: 8px; font-size: 13px; line-height: 1.4; font-weight: 500;"></div>

                <button type="submit" id="gated-submit-btn" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--cobalt); border-color: var(--cobalt); padding: 14px; margin-top: 10px;">
                    Dapatkan Akses Unduh & Pratinjau &rarr;
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================================================
    // 1. DISPLAY LAYOUT SWITCHER (6 MODES)
    // =========================================================================
    const viewButtons = document.querySelectorAll('.view-btn');
    const filesGrid = document.getElementById('download-files-grid');
    
    // Load persisted view from localStorage or fallback to default 'card'
    const storedView = localStorage.getItem('indotech_download_view') || 'card';
    applyViewMode(storedView);

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const viewMode = this.dataset.view;
            applyViewMode(viewMode);
            localStorage.setItem('indotech_download_view', viewMode);
        });
    });

    function applyViewMode(mode) {
        if (!filesGrid) return;

        // Toggle active button class
        viewButtons.forEach(b => {
            if (b.dataset.view === mode) {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });

        // Apply grid classes
        filesGrid.className = 'download-grid';
        filesGrid.classList.add('view-' + mode);
    }

    // =========================================================================
    // 2. CLIENT-SIDE COMBINED FILTER (SEARCH & CATEGORY TABS)
    // =========================================================================
    const searchInput = document.getElementById('download-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const downloadItems = document.querySelectorAll('.download-item');
    const emptyState = document.getElementById('search-empty-state');

    // Handle Category Filter Click
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            runCombinedFilter();
        });
    });

    // Handle Search input
    if (searchInput) {
        searchInput.addEventListener('input', runCombinedFilter);
    }

    function runCombinedFilter() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const activeFilterBtn = document.querySelector('.filter-btn.active');
        const activeFilter = activeFilterBtn ? activeFilterBtn.dataset.filter : 'all';
        
        let visibleCount = 0;

        downloadItems.forEach(item => {
            const title = item.dataset.title || '';
            const categories = (item.dataset.categories || '').split(' ');
            const categoryNames = item.dataset.categoryNames || '';

            const matchesSearch = title.includes(query) || categoryNames.includes(query);
            const matchesCategory = (activeFilter === 'all' || categories.includes(activeFilter));

            if (matchesSearch && matchesCategory) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show empty state if no documents matched
        if (emptyState) {
            emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    // =========================================================================
    // 3. PDF PREVIEW & DOWNLOAD GATING CONTROLLER
    // =========================================================================
    const previewModal = document.getElementById('pdf-preview-modal');
    const previewIframe = document.getElementById('pdf-preview-iframe');
    const previewTitle = document.getElementById('pdf-preview-title');
    const previewOpenTab = document.getElementById('pdf-preview-open-tab');
    
    const gatedModal = document.getElementById('gated-lead-modal');
    const gatedForm = document.getElementById('gated-download-form');
    
    // Check if the user has already unlocked downloads in this browser session
    function isUnlocked() {
        return localStorage.getItem('indotech_gated_unlocked') === '1';
    }

    // Modal close helpers
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

    // Add close events for close buttons and overlays
    document.querySelectorAll('.pdf-modal-close').forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });

    [previewModal, gatedModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('pdf-modal-container')) {
                    closeAllModals();
                }
            });
        }
    });

    // Handle ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAllModals();
    });

    // Preview click handler
    document.querySelectorAll('.preview-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const url = this.dataset.url;
            const title = this.dataset.title;
            const gated = this.dataset.gated === '1';

            if (gated && !isUnlocked()) {
                // Open lead collection form modal
                openGatedModal(id, url, 'preview');
            } else {
                openPreview(url, title);
            }
        });
    });

    // Download click handler
    document.querySelectorAll('.download-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const id = this.dataset.id;
            const url = this.dataset.url;
            const gated = this.dataset.gated === '1';

            if (gated && !isUnlocked()) {
                e.preventDefault();
                // Open lead collection form modal
                openGatedModal(id, url, 'download');
            }
            // If unlocked or not gated, the default browser action takes care of downloading
        });
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
        
        document.getElementById('gated-target-id').value = id;
        document.getElementById('gated-target-url').value = url;
        document.getElementById('gated-target-action').value = action;
        
        gatedModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // =========================================================================
    // 4. AJAX SUBMISSION FOR GATED FORM (Leads Registration)
    // =========================================================================
    if (gatedForm) {
        gatedForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('gated-submit-btn');
            const responseBox = document.getElementById('gated-form-response');
            
            // Collect Form Data
            const formData = new FormData(gatedForm);
            formData.append('action', 'indotech_submit_inquiry'); // Target existing AJAX endpoint
            formData.append('nonce', indotechData.nonce);
            
            // Styling Loading State
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Memproses...';
            }

            // AJAX Request using native fetch API
            fetch(indotechData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // 1. Save unlock status in localStorage
                    localStorage.setItem('indotech_gated_unlocked', '1');

                    // 2. Display success response
                    if (responseBox) {
                        responseBox.style.display = 'block';
                        responseBox.style.background = '#e6f4ea';
                        responseBox.style.color = '#137333';
                        responseBox.innerHTML = 'Akses dibuka! Mengunduh dokumen...';
                    }

                    // 3. Complete the original pending action
                    const action = document.getElementById('gated-target-action').value;
                    const url = document.getElementById('gated-target-url').value;
                    const targetId = document.getElementById('gated-target-id').value;

                    setTimeout(() => {
                        closeAllModals();

                        if (action === 'preview') {
                            const btn = document.querySelector(`.preview-pdf-btn[data-id="${targetId}"]`);
                            const title = btn ? btn.dataset.title : 'Dokumen';
                            openPreview(url, title);
                        } else {
                            // Trigger dynamic file download directly in browser
                            const downloadLink = document.createElement('a');
                            downloadLink.href = url;
                            downloadLink.download = url.split('/').pop();
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }
                    }, 1200);

                } else {
                    // Show error response
                    if (responseBox) {
                        responseBox.style.display = 'block';
                        responseBox.style.background = '#fce8e6';
                        responseBox.style.color = '#c5221f';
                        responseBox.innerHTML = data.data.message || 'Gagal mengirimkan formulir. Coba lagi.';
                    }
                }
            })
            .catch(error => {
                console.error('Error submitting lead form:', error);
                if (responseBox) {
                    responseBox.style.display = 'block';
                    responseBox.style.background = '#fce8e6';
                    responseBox.style.color = '#c5221f';
                    responseBox.innerHTML = 'Koneksi internet bermasalah. Silakan coba kembali.';
                }
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Dapatkan Akses Unduh & Pratinjau &rarr;';
                }
            });
        });
    }
});
</script>

<?php
get_footer();
