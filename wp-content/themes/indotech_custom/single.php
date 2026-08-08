<?php get_header(); ?>

<style>
/* ── Post Body High Contrast Typography ───────────────────── */
.post-body {
    color: #1E293B !important; /* Dark solid text (slate-800) instead of faint 60% opacity */
    opacity: 1 !important;
    font-size: 16px !important;
    line-height: 1.85 !important;
}

.post-body p {
    color: #1E293B !important;
    opacity: 1 !important;
    margin-bottom: 22px !important;
    font-size: 16px !important;
    line-height: 1.85 !important;
}

.post-body strong, .post-body b {
    color: #0A0F1E !important;
    font-weight: 700 !important;
}

.post-body h1, .post-body h2, .post-body h3, .post-body h4, .post-body h5, .post-body h6 {
    color: #0A0F1E !important;
    font-weight: 700 !important;
    margin-top: 36px !important;
    margin-bottom: 16px !important;
    line-height: 1.3 !important;
    scroll-margin-top: 90px;
}

.post-body h2 {
    font-size: 22px !important;
    border-bottom: none !important;
    padding-bottom: 0 !important;
}

.post-body h3 {
    font-size: 19px !important;
}

.post-body ol,
.post-body ul {
    color: #1E293B !important;
    padding-left: 24px;
    margin-top: 10px;
    margin-bottom: 24px;
}
.post-body ol {
    list-style-type: decimal;
}
.post-body ul {
    list-style-type: disc;
}
.post-body li {
    color: #1E293B !important;
    margin-bottom: 8px;
}

/* ── Post Body Link Styling ──────────────────────────────── */
.post-body a {
    color: #0057FF !important;
    font-weight: 600 !important;
    text-decoration: underline !important;
    text-decoration-color: rgba(0, 87, 255, 0.4) !important;
    text-underline-offset: 3px !important;
    transition: all 0.2s ease !important;
    padding: 1px 3px !important;
    border-radius: 3px !important;
}

.post-body a:hover {
    color: #003ECC !important;
    text-decoration-color: #003ECC !important;
    background-color: rgba(0, 87, 255, 0.08) !important;
}

/* ── "Baca Juga" Callout Box Styling ─────────────────────── */
.post-body p.baca-juga-box,
.post-body .baca-juga-box {
    background: linear-gradient(135deg, #EEF4FF 0%, #F8FAFC 100%) !important;
    border: 1px solid #BFDBFE !important;
    border-radius: 10px !important;
    padding: 14px 18px !important;
    margin: 24px 0 !important;
    font-size: 15.5px !important;
    line-height: 1.6 !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    box-shadow: 0 2px 8px rgba(0, 87, 255, 0.05) !important;
}

.post-body p.baca-juga-box strong,
.post-body p.baca-juga-box b,
.post-body .baca-juga-label {
    color: #0057FF !important;
    font-weight: 700 !important;
    white-space: nowrap !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
}

.post-body p.baca-juga-box a {
    color: #0A0F1E !important;
    font-weight: 600 !important;
    text-decoration: underline !important;
    text-decoration-color: #0057FF !important;
    transition: color 0.2s ease !important;
}

.post-body p.baca-juga-box a:hover {
    color: #0057FF !important;
    background: transparent !important;
}

/* ── Share Buttons & Tooltips ───────────────────────── */
.share-btn {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 50% !important;
    padding: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    text-decoration: none !important;
    border: none !important;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
.share-btn:hover {
    transform: translateY(-3px) scale(1.08) !important;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18) !important;
}

/* Tooltip Popup */
.share-btn[data-tooltip]::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%) translateY(4px);
    background: #0F172A;
    color: #FFFFFF;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
    padding: 5px 10px;
    border-radius: 6px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
    z-index: 10;
}

/* Tooltip Arrow */
.share-btn[data-tooltip]::after {
    content: '';
    position: absolute;
    bottom: calc(100% + 2px);
    left: 50%;
    transform: translateX(-50%) translateY(4px);
    border-width: 5px 5px 0 5px;
    border-style: solid;
    border-color: #0F172A transparent transparent transparent;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    z-index: 10;
}

.share-btn[data-tooltip]:hover::before,
.share-btn[data-tooltip]:hover::after {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

/* Lightbox Modal Style for Blog Content Images */
.post-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.95);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.post-lightbox.active {
    opacity: 1;
    pointer-events: auto;
}
.lightbox-content {
    max-width: 85%;
    max-height: 85%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.95);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.post-lightbox.active .lightbox-content {
    transform: scale(1);
}
.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}
.lightbox-close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    color: var(--white);
    font-size: 40px;
    line-height: 1;
    cursor: pointer;
    opacity: 0.7;
    transition: all var(--trans);
    z-index: 2;
}
.lightbox-close:hover {
    opacity: 1;
}
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: var(--white);
    font-size: 32px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.6;
    transition: all var(--trans);
    user-select: none;
    z-index: 2;
}
.lightbox-prev:hover, .lightbox-next:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.2);
}
.lightbox-prev {
    left: 24px;
}
.lightbox-next {
    right: 24px;
}
.lightbox-counter {
    position: absolute;
    bottom: 24px;
    color: var(--white);
    font-size: 14px;
    font-weight: 600;
    opacity: 0.8;
}
.post-body img,
.post-featured-img img {
    cursor: zoom-in;
    transition: opacity var(--trans);
}
.post-body img:hover,
.post-featured-img img:hover {
    opacity: 0.9;
}
@media (max-width: 767px) {
    .lightbox-prev { left: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-next { right: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-close { top: 12px; right: 12px; font-size: 32px; }
}
</style>

<?php while (have_posts()): the_post(); 
    // Article calculation & meta data
    $post_content = get_the_content();
    $word_count = str_word_count(strip_tags($post_content));
    $reading_time = max(1, ceil($word_count / 200));
    $categories = get_the_category();
    $cat_name = !empty($categories) ? $categories[0]->name : '';
    $post_permalink = get_permalink();
    $post_title = get_the_title();
?>
<section class="inner-page-hero" id="single-post-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.4;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url('/') ); ?>">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="<?php echo esc_url( home_url('/blog') ); ?>">Blog</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?php the_title(); ?></span>
        </nav>
        <div class="blog-meta" style="color:rgba(255,255,255,.8); margin-bottom:12px; display:flex; align-items:center; gap:8px; font-size:13px; flex-wrap:wrap;">
            <?php if ($cat_name): ?>
                <span style="background: rgba(0, 87, 255, 0.3); color: #93C5FD; border: 1px solid rgba(147, 197, 253, 0.3); padding: 2px 10px; border-radius: 20px; font-weight: 600; font-size: 11px; text-transform: uppercase;">
                    <?php echo esc_html($cat_name); ?>
                </span>
                <span class="blog-meta-sep" aria-hidden="true">·</span>
            <?php endif; ?>
            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
            <span class="blog-meta-sep" aria-hidden="true">·</span>
            <span><?php the_author(); ?></span>
            <span class="blog-meta-sep" aria-hidden="true">·</span>
            <span style="display:inline-flex; align-items:center; gap:4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo $reading_time; ?> mnt baca
            </span>
        </div>
        <h1 class="inner-page-title" style="font-size: clamp(24px, 3.5vw, 44px); line-height: 1.25;"><?php the_title(); ?></h1>
    </div>
</section>

<main id="main-content" class="page-content" style="padding: 60px 0;">
    <div class="container" style="max-width:760px; padding: 0 16px;">
        
        <!-- Social Sharing Bar (Top - Icon Only with Tooltips) -->
        <div class="article-share-bar" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 28px; padding: 12px 18px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px;">
            <span style="font-size: 13.5px; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                Bagikan Artikel:
            </span>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <!-- WhatsApp Share -->
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($post_title . ' ' . $post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-wa" data-tooltip="WhatsApp" aria-label="Bagikan via WhatsApp" style="background: #25D366; color: #FFF;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                </a>
                <!-- Facebook Share -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-fb" data-tooltip="Facebook" aria-label="Bagikan via Facebook" style="background: #1877F2; color: #FFF;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.7 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                </a>
                <!-- LinkedIn Share -->
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-li" data-tooltip="LinkedIn" aria-label="Bagikan via LinkedIn" style="background: #0A66C2; color: #FFF;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.262-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
                <!-- Twitter/X Share -->
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($post_permalink); ?>&text=<?php echo urlencode($post_title); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-tw" data-tooltip="X (Twitter)" aria-label="Bagikan via X" style="background: #000; color: #FFF;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <!-- Copy Link Button -->
                <button id="copy-article-link" class="share-btn share-copy" data-tooltip="Salin Link" aria-label="Salin Tautan Artikel" style="background: #64748B; color: #FFF;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                </button>
            </div>
        </div>

        <?php if (has_post_thumbnail()): ?>
            <figure class="post-featured-img" style="margin-bottom:32px;border-radius:12px;overflow:hidden;">
                <?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto;object-fit:cover;']); ?>
            </figure>
        <?php endif; ?>

        <!-- Table of Contents (Dropdown Accordion Style) -->
        <div id="article-toc-container" class="article-toc-dropdown" style="display:none; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 32px; overflow: hidden; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);">
            <button type="button" id="toc-toggle-btn" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: #F1F5F9; border: none; border-bottom: 1px solid #E2E8F0; cursor: pointer; text-align: left; transition: background 0.2s ease;">
                <span style="font-size: 15px; font-weight: 700; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0057FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Daftar Isi Artikel
                </span>
                <span style="display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; color: #0057FF;">
                    <span id="toc-status-text">Sembunyikan</span>
                    <svg id="toc-chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.25s ease; transform: rotate(180deg);"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </button>
            <div id="toc-content-body" style="padding: 16px 20px 20px 20px; background: #F8FAFC;">
                <ul id="toc-list" style="margin: 0 !important; padding-left: 20px !important; font-size: 14.5px; line-height: 1.8; color: #334155;"></ul>
            </div>
        </div>

        <div class="post-body">
            <?php the_content(); ?>
        </div>

        <!-- Article WhatsApp Consultation Callout -->
        <div class="article-wa-cta-card" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 12px; padding: 26px; margin: 40px 0 24px; color: #FFF; position: relative; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);">
            <div style="position: absolute; right: -20px; bottom: -20px; opacity: 0.08; color: #FFF; pointer-events: none;">
                <svg width="180" height="180" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            </div>
            <div style="position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div style="max-width: 480px;">
                    <span style="font-size: 11px; font-weight: 700; background: rgba(37, 211, 102, 0.2); color: #4ADE80; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Konsultasi Gratis</span>
                    <h3 style="font-size: 20px; font-weight: 700; color: #FFF; margin: 8px 0 6px;">Butuh Solusi Formulasi atau Bahan Kimia Produk Ini?</h3>
                    <p style="font-size: 13.5px; color: #94A3B8; margin: 0; line-height: 1.5;">Tim teknis PT Indotech Berkah Abadi siap membantu kebutuhan bahan baku, sampel, dan konsultasi formulasi usaha Anda.</p>
                </div>
                <div>
                    <a href="https://wa.me/6281234567890?text=<?php echo urlencode('Halo Indotech, saya ingin bertanya seputar artikel: ' . $post_title); ?>" target="_blank" rel="noopener noreferrer" style="background: #25D366; color: #FFF; padding: 12px 22px; border-radius: 8px; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); white-space: nowrap;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        Konsultasi WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Editorial Verification & Approval Card -->
        <div class="article-approval-card" style="background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%); border: 1px solid #E2E8F0; border-radius: 12px; padding: 22px 26px; margin-top: 24px; margin-bottom: 24px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);">
            <div style="display: flex; align-items: flex-start; gap: 16px;">
                <div style="width: 44px; height: 44px; min-width: 44px; border-radius: 50%; background: #D1FAE5; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 22px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">
                        <h4 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0; font-family: 'Space Grotesk', sans-serif;">Artikel Terverifikasi & Disetujui Redaksi</h4>
                        <span style="font-size: 11px; font-weight: 700; background: #10B981; color: #FFFFFF; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Terverifikasi</span>
                    </div>
                    <p style="font-size: 13.5px; color: #334155; margin: 0; line-height: 1.6;">
                        Konten artikel ini telah ditinjau dan disetujui oleh <strong>Tim Redaksi & Tim Ahli Formulasi PT Indotech Berkah Abadi</strong> untuk memastikan keakuratan informasi teknis, standar kebersihan, serta keamanan penggunaan produk.
                    </p>
                    <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 12px; font-size: 12px; color: #64748B; border-top: 1px dashed #CBD5E1; padding-top: 10px;">
                        <span><strong style="color: #1E293B;">Peninjau:</strong> Tim Redaksi Indotech</span>
                        <span>•</span>
                        <span><strong style="color: #1E293B;">Penerbit:</strong> PT Indotech Berkah Abadi</span>
                        <span>•</span>
                        <span><strong style="color: #1E293B;">Terakhir Diperbarui:</strong> <?php echo get_the_modified_date('d M Y'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Tags -->
        <?php
        $tags = get_the_tags();
        if ($tags):
        ?>
        <div class="article-tags-wrapper" style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #E2E8F0; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span style="font-size: 13px; font-weight: 700; color: #64748B;">Tag Artikel:</span>
            <?php foreach ($tags as $tag): ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" style="background: #F1F5F9; color: #334155; font-size: 12px; padding: 4px 10px; border-radius: 6px; text-decoration: none !important; font-weight: 500; border: 1px solid #E2E8F0;">
                    #<?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Post Navigation (Previous / Next Article) -->
        <?php
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        if ($prev_post || $next_post):
        ?>
        <div class="post-navigation-card" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #E2E8F0;">
            <?php if ($prev_post): ?>
                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px 18px; text-decoration: none !important; transition: border-color 0.2s;">
                    <span style="font-size: 11px; color: #0057FF; font-weight: 700; text-transform: uppercase;">&larr; Artikel Sebelumnya</span>
                    <h5 style="margin: 6px 0 0; font-size: 14px; font-weight: 600; color: #0F172A; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo esc_html($prev_post->post_title); ?></h5>
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>

            <?php if ($next_post): ?>
                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px 18px; text-decoration: none !important; text-align: right; transition: border-color 0.2s;">
                    <span style="font-size: 11px; color: #0057FF; font-weight: 700; text-transform: uppercase;">Artikel Selanjutnya &rarr;</span>
                    <h5 style="margin: 6px 0 0; font-size: 14px; font-weight: 600; color: #0F172A; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo esc_html($next_post->post_title); ?></h5>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php
// Related Blog Query
$cat_ids = [];
if ($categories) {
    foreach ($categories as $cat) {
        $cat_ids[] = $cat->term_id;
    }
}

$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'post_status'    => 'publish',
    'category__in'   => !empty($cat_ids) ? $cat_ids : [],
    'orderby'        => 'rand'
];

$related_query = new WP_Query($related_args);
// Fallback if not enough related posts in same categories
if ($related_query->post_count < 3) {
    $exclude = array_merge([get_the_ID()], wp_list_pluck($related_query->posts, 'ID'));
    $fallback_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3 - $related_query->post_count,
        'post__not_in'   => $exclude,
        'post_status'    => 'publish'
    ]);
    $related_posts = array_merge($related_query->posts, $fallback_query->posts);
} else {
    $related_posts = $related_query->posts;
}
?>

<?php if (!empty($related_posts)) : ?>
    <section class="blog-section section-padding" style="background: var(--surface); border-top: 1px solid var(--border); margin-top: 60px;">
        <div class="container" style="max-width: 1000px;">
            
            <div class="blog-section-header" style="margin-bottom: 32px;">
                <div class="blog-section-left">
                    <span class="section-tag">Rekomendasi</span>
                    <h2 class="section-title" style="margin-top: 8px;">Artikel <em>Terkait</em></h2>
                </div>
            </div>
            
            <div class="blog-grid">
                <?php 
                global $post;
                foreach ($related_posts as $post) : 
                    setup_postdata($post);
                ?>
                    <article class="blog-card">
                        <!-- Thumbnail -->
                        <a href="<?php the_permalink(); ?>" class="blog-thumb" tabindex="-1" aria-hidden="true">
                            <?php if ( has_post_thumbnail() ): ?>
                                <?php the_post_thumbnail( 'indotech-card', [
                                    'class'   => 'blog-img',
                                    'loading' => 'lazy',
                                    'alt'     => get_the_title(),
                                ] ); ?>
                            <?php else: ?>
                                <div class="blog-img-placeholder">
                                    <span class="blog-placeholder-label">Tidak Ada Gambar</span>
                                </div>
                            <?php endif; ?>

                            <!-- Pill category badge -->
                            <?php
                            $cats = get_the_category();
                            if ( $cats ):
                            ?>
                            <span class="blog-category"><?php echo esc_html( $cats[0]->name ); ?></span>
                            <?php endif; ?>
                        </a>

                        <!-- Body -->
                        <div class="blog-body">
                            <div class="blog-meta">
                                <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>">
                                    <?php echo esc_html( get_the_date('d M Y') ); ?>
                                </time>
                                <span class="blog-meta-sep">&middot;</span>
                                <span><?php echo esc_html( get_the_author() ); ?></span>
                            </div>

                            <h3 class="blog-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class="blog-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?></p>

                            <a href="<?php the_permalink(); ?>" class="blog-read-more">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                <?php 
                endforeach; 
                wp_reset_postdata(); 
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php endwhile; ?>

<!-- Lightbox Modal for Post Images -->
<div id="post-gallery-lightbox" class="post-lightbox">
    <button class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="post-lightbox-img" src="" alt="Artikel Detail">
    </div>
    <button class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="post-lightbox-current">1</span> / <span id="post-lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Auto-format "Baca juga:" paragraphs into clean callout boxes ──
    const bodyPs = document.querySelectorAll('.post-body p');
    bodyPs.forEach(p => {
        const text = p.textContent || p.innerText;
        if (/baca\s*juga\s*:/i.test(text) || (p.querySelector('strong, b') && /baca\s*juga/i.test(p.querySelector('strong, b').textContent))) {
            p.classList.add('baca-juga-box');
        }
    });

    // ── Auto Table of Contents Generation (Dropdown Accordion) ──
    const headings = document.querySelectorAll('.post-body h2, .post-body h3');
    const tocContainer = document.getElementById('article-toc-container');
    const tocList = document.getElementById('toc-list');
    const tocToggleBtn = document.getElementById('toc-toggle-btn');
    const tocContentBody = document.getElementById('toc-content-body');
    const tocChevronIcon = document.getElementById('toc-chevron-icon');
    const tocStatusText = document.getElementById('toc-status-text');

    if (headings.length >= 2 && tocContainer && tocList) {
        headings.forEach((heading, idx) => {
            const id = heading.id || `section-heading-${idx + 1}`;
            heading.id = id;

            const li = document.createElement('li');
            li.style.marginBottom = '6px';
            if (heading.tagName.toLowerCase() === 'h3') {
                li.style.marginLeft = '16px';
                li.style.listStyleType = 'circle';
            }

            const a = document.createElement('a');
            a.href = `#${id}`;
            a.textContent = heading.textContent.replace(/^[0-9]+\.\s*/, '');
            a.style.color = '#0057FF';
            a.style.textDecoration = 'none';
            a.style.fontWeight = '500';
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(id);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });

            li.appendChild(a);
            tocList.appendChild(li);
        });

        tocContainer.style.display = 'block';

        let isTocOpen = true;
        if (tocToggleBtn && tocContentBody && tocChevronIcon && tocStatusText) {
            tocToggleBtn.addEventListener('click', function() {
                isTocOpen = !isTocOpen;
                if (isTocOpen) {
                    tocContentBody.style.display = 'block';
                    tocToggleBtn.style.borderBottom = '1px solid #E2E8F0';
                    tocChevronIcon.style.transform = 'rotate(180deg)';
                    tocStatusText.textContent = 'Sembunyikan';
                } else {
                    tocContentBody.style.display = 'none';
                    tocToggleBtn.style.borderBottom = 'none';
                    tocChevronIcon.style.transform = 'rotate(0deg)';
                    tocStatusText.textContent = 'Tampilkan';
                }
            });
        }
    }

    // ── Copy Link Button Handler ──
    const copyBtn = document.getElementById('copy-article-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(function() {
                copyBtn.setAttribute('data-tooltip', 'Link Tersalin!');
                copyBtn.style.background = '#10B981';
                setTimeout(() => {
                    copyBtn.setAttribute('data-tooltip', 'Salin Link');
                    copyBtn.style.background = '#64748B';
                }, 2500);
            }).catch(function() {
                alert('Gagal menyalin tautan');
            });
        });
    }

    // ── Lightbox Image Modal ──
    const contentImages = document.querySelectorAll('.post-body img, .post-featured-img img');

    if (!contentImages.length) return;

    const images = Array.from(contentImages).map(img => {
        return img.src;
    });

    let currentIndex = 0;

    const lightbox = document.getElementById('post-gallery-lightbox');
    const lightboxImg = document.getElementById('post-lightbox-img');
    const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;
    const lightboxPrev = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
    const lightboxNext = lightbox ? lightbox.querySelector('.lightbox-next') : null;
    const lightboxCurrent = document.getElementById('post-lightbox-current');
    const lightboxTotal = document.getElementById('post-lightbox-total');

    if (lightboxTotal) {
        lightboxTotal.textContent = images.length;
    }

    if (images.length <= 1) {
        if (lightboxPrev) lightboxPrev.style.display = 'none';
        if (lightboxNext) lightboxNext.style.display = 'none';
    }

    function updateLightboxImage() {
        if (lightboxImg) {
            lightboxImg.src = images[currentIndex];
        }
        if (lightboxCurrent) {
            lightboxCurrent.textContent = currentIndex + 1;
        }
    }

    function openLightbox(index) {
        if (!lightbox) return;
        currentIndex = index;
        updateLightboxImage();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function showNext() {
        if (images.length <= 1) return;
        currentIndex = (currentIndex + 1) % images.length;
        updateLightboxImage();
    }

    function showPrev() {
        if (images.length <= 1) return;
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightboxImage();
    }

    contentImages.forEach((img, idx) => {
        img.addEventListener('click', function(e) {
            e.preventDefault();
            openLightbox(idx);
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', showPrev);
    }
    if (lightboxNext) {
        lightboxNext.addEventListener('click', showNext);
    }

    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (!lightbox || !lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (images.length > 1) {
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        }
    });
});
</script>

<?php get_footer(); ?>
