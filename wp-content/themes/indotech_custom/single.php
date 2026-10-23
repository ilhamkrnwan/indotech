<?php
/**
 * Single Post Template - Clean Editorial Layout with Left & Right Panels
 * Theme: Indotech Custom
 */
get_header();

$whatsapp = indotech_opt('whatsapp', '6285600061005');
$wa_num   = preg_replace('/[^0-9]/', '', $whatsapp);
?>

<!-- ── Reading Progress Bar ────────────────────────────────────────── -->
<div id="reading-progress-bar" class="reading-progress-bar" aria-hidden="true"></div>

<style>
/* ============================================================
   SINGLE BLOG POST — MODERN EDITORIAL 2-PANEL LAYOUT
   ============================================================ */

/* ── Reading Progress Indicator ── */
.reading-progress-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 0%;
    height: 3px;
    background: linear-gradient(90deg, #0057FF 0%, #38BDF8 100%);
    z-index: 99999;
    transition: width 0.1s ease-out;
}

/* ── Hero / Page Title Section ── */
#single-post-hero.inner-page-hero {
    padding: calc(var(--header-h, 72px) + 36px) 0 44px;
    background: linear-gradient(180deg, #0A0F1E 0%, #0F172A 100%);
    position: relative;
    overflow: hidden;
    color: #FFFFFF;
}

.single-hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.65);
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.single-hero-breadcrumb a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: color 0.2s ease;
}
.single-hero-breadcrumb a:hover {
    color: #FFFFFF;
}
.single-hero-breadcrumb .sep {
    opacity: 0.4;
    font-size: 11px;
}
.single-hero-breadcrumb .current {
    color: #93C5FD;
    max-width: 320px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.single-hero-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13.5px;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.single-cat-badge {
    background: rgba(0, 87, 255, 0.35);
    color: #93C5FD;
    border: 1px solid rgba(147, 197, 253, 0.3);
    padding: 3px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
}
.single-cat-badge:hover {
    background: #0057FF;
    color: #FFFFFF;
    border-color: #0057FF;
}

.single-hero-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
}
.single-hero-meta-sep {
    opacity: 0.35;
}

.single-post-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(26px, 3.6vw, 44px);
    font-weight: 700;
    line-height: 1.22;
    letter-spacing: -0.025em;
    color: #FFFFFF;
    margin: 0;
    max-width: 900px;
}

/* ── Main Layout: Content + Sidebar Grid ── */
.single-blog-wrapper {
    padding: 52px 0 88px;
    background: #FFFFFF;
}

.single-blog-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 340px;
    gap: 48px;
    align-items: start;
}

/* ── LEFT / MAIN CONTENT PANEL ───────────────────────────── */
.single-main-panel {
    min-width: 0;
}

/* Social Share Bar (Top Strip) */
.article-share-strip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    padding: 12px 20px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 32px;
}
.share-strip-label {
    font-size: 13.5px;
    font-weight: 700;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 8px;
}
.share-strip-icons {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.share-btn {
    position: relative;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
    flex-shrink: 0;
}
.share-btn:hover {
    transform: translateY(-2px) scale(1.06);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
}

/* Share Tooltips */
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

/* Featured Image */
.single-featured-figure {
    margin: 0 0 36px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #E2E8F0;
    background: #F1F5F9;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
}
.single-featured-figure img {
    width: 100%;
    height: auto;
    max-height: 480px;
    object-fit: cover;
    display: block;
    cursor: zoom-in;
    transition: transform 0.35s ease;
}
.single-featured-figure:hover img {
    transform: scale(1.015);
}

/* In-Content Table of Contents (Mobile / Tablet Accordion) */
.article-toc-mobile-box {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 36px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}
.toc-toggle-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: #F1F5F9;
    border: none;
    border-bottom: 1px solid #E2E8F0;
    cursor: pointer;
    text-align: left;
    transition: background 0.2s ease;
}
.toc-toggle-btn:hover {
    background: #E2E8F0;
}
.toc-body {
    padding: 16px 20px 20px 20px;
    background: #F8FAFC;
}
.toc-body ul {
    margin: 0;
    padding-left: 20px;
    font-size: 14.5px;
    line-height: 1.8;
    color: #334155;
}

/* ── Typography & Post Body ───────────────────────────────── */
.post-body {
    color: #1E293B;
    font-size: 17px;
    line-height: 1.85;
    letter-spacing: -0.005em;
    word-break: break-word;
}
.post-body p {
    color: #1E293B;
    margin-bottom: 24px;
    font-size: 17px;
    line-height: 1.85;
}
.post-body strong, .post-body b {
    color: #0A0F1E;
    font-weight: 700;
}

.post-body h2, .post-body h3, .post-body h4, .post-body h5, .post-body h6 {
    font-family: 'Space Grotesk', sans-serif;
    color: #0A0F1E;
    font-weight: 700;
    line-height: 1.28;
    margin-top: 44px;
    margin-bottom: 18px;
    scroll-margin-top: 100px;
}
.post-body h2 {
    font-size: 24px;
    letter-spacing: -0.02em;
    position: relative;
    padding-left: 14px;
    border-left: 4px solid #0057FF;
}
.post-body h3 {
    font-size: 20px;
    letter-spacing: -0.015em;
    margin-top: 36px;
    margin-bottom: 14px;
}
.post-body h4 {
    font-size: 18px;
    margin-top: 28px;
    margin-bottom: 12px;
}

.post-body ul, .post-body ol {
    color: #1E293B;
    padding-left: 26px;
    margin: 16px 0 26px;
}
.post-body ol { list-style-type: decimal; }
.post-body ul { list-style-type: disc; }
.post-body li {
    margin-bottom: 10px;
    line-height: 1.75;
}

.post-body a {
    color: #0057FF;
    font-weight: 600;
    text-decoration: underline;
    text-decoration-color: rgba(0, 87, 255, 0.35);
    text-underline-offset: 3px;
    transition: all 0.2s ease;
    padding: 1px 3px;
    border-radius: 3px;
}
.post-body a:hover {
    color: #003ECC;
    text-decoration-color: #003ECC;
    background-color: rgba(0, 87, 255, 0.08);
}

.post-body blockquote {
    background: #F8FAFC;
    border-left: 4px solid #0057FF;
    border-radius: 0 12px 12px 0;
    padding: 20px 24px;
    margin: 32px 0;
    font-style: italic;
    color: #334155;
    font-size: 16.5px;
    line-height: 1.75;
    position: relative;
}
.post-body blockquote p:last-child {
    margin-bottom: 0;
}

.post-body img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 32px 0 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    cursor: zoom-in;
    transition: opacity 0.2s ease;
}
.post-body img:hover {
    opacity: 0.95;
}

/* Callout Box "Baca Juga" */
.post-body p.baca-juga-box,
.post-body .baca-juga-box {
    background: linear-gradient(135deg, #EEF4FF 0%, #F8FAFC 100%);
    border: 1px solid #BFDBFE;
    border-left: 4px solid #0057FF;
    border-radius: 10px;
    padding: 14px 20px;
    margin: 28px 0;
    font-size: 15.5px;
    line-height: 1.6;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(0, 87, 255, 0.05);
}
.post-body p.baca-juga-box strong,
.post-body p.baca-juga-box b {
    color: #0057FF;
    font-weight: 700;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.post-body p.baca-juga-box a {
    color: #0A0F1E;
    font-weight: 600;
    text-decoration: underline;
    text-decoration-color: #0057FF;
    transition: color 0.2s ease;
}
.post-body p.baca-juga-box a:hover {
    color: #0057FF;
    background: transparent;
}

/* Table Responsive Wrapper */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 28px 0;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    background: #FFFFFF;
}
.post-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14.5px;
    line-height: 1.6;
}
.post-body th {
    background: #F1F5F9;
    color: #0F172A;
    font-weight: 700;
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #CBD5E1;
}
.post-body td {
    padding: 12px 16px;
    border-bottom: 1px solid #E2E8F0;
    color: #334155;
}
.post-body tr:nth-child(even) td {
    background: #F8FAFC;
}
.post-body tr:hover td {
    background: #EEF4FF;
}

/* ── Article Bottom Cards ─────────────────────────────────── */

/* WhatsApp Consultation Banner */
.article-wa-cta-card {
    background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
    border-radius: 14px;
    padding: 28px;
    margin: 44px 0 28px;
    color: #FFFFFF;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.08);
}
.wa-cta-watermark {
    position: absolute;
    right: -20px;
    bottom: -20px;
    opacity: 0.06;
    color: #FFFFFF;
    pointer-events: none;
}
.wa-cta-inner {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.wa-cta-badge {
    font-size: 11px;
    font-weight: 700;
    background: rgba(37, 211, 102, 0.2);
    color: #4ADE80;
    padding: 4px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 8px;
}
.wa-cta-btn {
    background: #25D366;
    color: #FFFFFF;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
    white-space: nowrap;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.wa-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45);
    color: #FFFFFF;
}

/* Editorial Verification Card */
.article-approval-card {
    background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%);
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 22px 24px;
    margin: 28px 0;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
}

/* Tags */
.article-tags-wrapper {
    margin-top: 32px;
    padding-top: 20px;
    border-top: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.article-tag-pill {
    background: #F1F5F9;
    color: #334155;
    font-size: 12.5px;
    padding: 5px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    border: 1px solid #E2E8F0;
    transition: all 0.2s ease;
}
.article-tag-pill:hover {
    background: #0057FF;
    color: #FFFFFF;
    border-color: #0057FF;
}

/* Author Bio Card */
.article-author-bio-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    margin-top: 36px;
}
.author-avatar-badge {
    width: 60px;
    height: 60px;
    min-width: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0057FF 0%, #38BDF8 100%);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(0, 87, 255, 0.25);
}

/* Post Navigation (Prev / Next) */
.post-navigation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-top: 36px;
    padding-top: 28px;
    border-top: 1px solid #E2E8F0;
}
.post-nav-card {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 16px 20px;
    text-decoration: none;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
}
.post-nav-card:hover {
    background: #FFFFFF;
    border-color: #0057FF;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 87, 255, 0.08);
}
.post-nav-card.next {
    text-align: right;
}

/* ── RIGHT SIDEBAR PANEL ──────────────────────────────────── */
.single-sidebar-panel {
    min-width: 0;
}
.single-sidebar-sticky {
    position: sticky;
    top: calc(var(--header-h, 72px) + 24px);
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Sidebar Widget Base */
.sidebar-widget {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}
.sidebar-widget-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Sidebar Table of Contents */
.sidebar-toc-list {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 380px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #CBD5E1 transparent;
}
.sidebar-toc-list::-webkit-scrollbar {
    width: 4px;
}
.sidebar-toc-list::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 4px;
}
.sidebar-toc-list li {
    margin-bottom: 6px;
}
.sidebar-toc-link {
    display: block;
    font-size: 13.5px;
    line-height: 1.45;
    color: #475569;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 6px;
    border-left: 2px solid transparent;
    transition: all 0.2s ease;
}
.sidebar-toc-link:hover {
    color: #0057FF;
    background: #F8FAFC;
}
.sidebar-toc-link.active {
    color: #0057FF;
    font-weight: 700;
    background: #EEF4FF;
    border-left-color: #0057FF;
}
.sidebar-toc-link.is-h3 {
    margin-left: 12px;
    font-size: 12.5px;
    opacity: 0.9;
}

/* Sidebar CTA Formulasi Card */
.sidebar-cta-widget {
    background: linear-gradient(135deg, #0A0F1E 0%, #1E293B 100%);
    border-radius: 14px;
    padding: 24px;
    color: #FFFFFF;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.25);
    position: relative;
    overflow: hidden;
}
.sidebar-cta-badge {
    font-size: 10px;
    font-weight: 700;
    background: rgba(37, 211, 102, 0.2);
    color: #4ADE80;
    padding: 3px 8px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 10px;
}
.sidebar-cta-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px;
    font-weight: 700;
    color: #FFFFFF;
    margin: 0 0 8px;
    line-height: 1.3;
}
.sidebar-cta-desc {
    font-size: 12.5px;
    color: #94A3B8;
    line-height: 1.5;
    margin: 0 0 18px;
}
.sidebar-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #25D366;
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 700;
    padding: 11px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
}
.sidebar-wa-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.45);
    color: #FFFFFF;
}

/* Sidebar Recent Posts List */
.sidebar-recent-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.sidebar-recent-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.sidebar-recent-thumb {
    width: 64px;
    height: 64px;
    min-width: 64px;
    border-radius: 8px;
    overflow: hidden;
    background: #F1F5F9;
    flex-shrink: 0;
}
.sidebar-recent-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}
.sidebar-recent-item:hover .sidebar-recent-thumb img {
    transform: scale(1.08);
}
.sidebar-recent-info {
    flex: 1;
    min-width: 0;
}
.sidebar-recent-meta {
    font-size: 11px;
    color: #64748B;
    margin-bottom: 4px;
}
.sidebar-recent-title {
    font-size: 13px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.sidebar-recent-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}
.sidebar-recent-title a:hover {
    color: #0057FF;
}

/* Sidebar Categories List */
.sidebar-cat-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.sidebar-cat-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13.5px;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
}
.sidebar-cat-link:hover {
    background: #F1F5F9;
    color: #0057FF;
}
.sidebar-cat-count {
    font-size: 11.5px;
    font-weight: 600;
    background: #E2E8F0;
    color: #475569;
    padding: 2px 7px;
    border-radius: 12px;
}

/* Lightbox Modal */
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
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
    transform: scale(0.96);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
    color: #FFFFFF;
    font-size: 40px;
    line-height: 1;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
    z-index: 2;
}
.lightbox-close:hover { opacity: 1; }
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #FFFFFF;
    font-size: 32px;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.6;
    transition: all 0.2s;
    user-select: none;
    z-index: 2;
}
.lightbox-prev:hover, .lightbox-next:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.25);
}
.lightbox-prev { left: 24px; }
.lightbox-next { right: 24px; }
.lightbox-counter {
    position: absolute;
    bottom: 24px;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: 600;
    opacity: 0.8;
}

/* ── Responsive Behavior ──────────────────────────────────── */
@media (min-width: 1025px) {
    /* On desktop, hide in-content mobile TOC since sidebar TOC is active */
    .article-toc-mobile-box {
        display: none !important;
    }
}

@media (max-width: 1024px) {
    .single-blog-layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .single-sidebar-sticky {
        position: static;
    }
    #sidebar-toc-widget {
        display: none !important;
    }
    .single-featured-figure img {
        max-height: 400px;
    }
}

@media (max-width: 767px) {
    .single-blog-wrapper {
        padding: 36px 0 60px;
    }
    .post-body {
        font-size: 16px;
    }
    .post-body p {
        font-size: 16px;
    }
    .post-body h2 {
        font-size: 21px;
    }
    .post-body h3 {
        font-size: 18px;
    }
    .wa-cta-inner {
        flex-direction: column;
        align-items: flex-start;
    }
    .wa-cta-btn {
        width: 100%;
        justify-content: center;
    }
    .article-author-bio-card {
        flex-direction: column;
        text-align: center;
    }
    .lightbox-prev { left: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-next { right: 12px; width: 44px; height: 44px; font-size: 24px; }
    .lightbox-close { top: 12px; right: 12px; font-size: 32px; }
}
</style>

<?php while (have_posts()): the_post(); 
    // Article metrics & metadata
    $post_content = get_the_content();
    $word_count   = str_word_count(strip_tags($post_content));
    $reading_time = max(1, ceil($word_count / 200));
    $categories   = get_the_category();
    $primary_cat  = !empty($categories) ? $categories[0] : null;
    $cat_name     = $primary_cat ? $primary_cat->name : '';
    $cat_slug     = $primary_cat ? $primary_cat->slug : '';
    $post_permalink = get_permalink();
    $post_title     = get_the_title();
    $author_id      = get_the_author_meta('ID');
    $author_name    = get_the_author();
    $author_bio     = get_the_author_meta('description');
    if (empty($author_bio)) {
        $author_bio = 'Tim Redaksi & Riset PT Indotech Berkah Abadi berdedikasi menyajikan panduan formulasi, wawasan bahan kimia industri, dan edukasi seputar produk pembersih berkualitas.';
    }

    // Sidebar Latest Posts Query
    $sidebar_recent_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post__not_in'   => [get_the_ID()],
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);

    // All categories with count (exclude Uncategorized & numeric junk)
    $all_categories = get_categories([
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => true,
        'exclude'    => [1, 20]
    ]);
    if (!empty($all_categories)) {
        $all_categories = array_filter($all_categories, function($cat) {
            return !is_numeric($cat->name) && !in_array(strtolower($cat->slug), ['uncategorized', 'tak-berkategori']);
        });
    }
?>

<!-- ── Inner Hero Section ─────────────────────────────────────────── -->
<section class="inner-page-hero" id="single-post-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.35;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <!-- Breadcrumb -->
        <nav class="single-hero-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
            <span class="sep" aria-hidden="true">/</span>
            <a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a>
            <?php if ($primary_cat): ?>
                <span class="sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url(home_url('/blog/?kategori=' . $cat_slug)); ?>"><?php echo esc_html($cat_name); ?></a>
            <?php endif; ?>
            <span class="sep" aria-hidden="true">/</span>
            <span class="current" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <!-- Meta info -->
        <div class="single-hero-meta">
            <?php if ($cat_name): ?>
                <a href="<?php echo esc_url(home_url('/blog/?kategori=' . $cat_slug)); ?>" class="single-cat-badge">
                    <?php echo esc_html($cat_name); ?>
                </a>
                <span class="single-hero-meta-sep" aria-hidden="true">·</span>
            <?php endif; ?>
            
            <span class="single-hero-meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
            </span>

            <span class="single-hero-meta-sep" aria-hidden="true">·</span>

            <span class="single-hero-meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><?php echo esc_html($author_name); ?></span>
            </span>

            <span class="single-hero-meta-sep" aria-hidden="true">·</span>

            <span class="single-hero-meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span><?php echo $reading_time; ?> mnt baca</span>
            </span>
        </div>

        <!-- Post Title -->
        <h1 class="single-post-title"><?php the_title(); ?></h1>
    </div>
</section>

<!-- ── Main Article Layout: Left Panel & Right Sidebar Panel ─────────── -->
<main id="main-content" class="single-blog-wrapper">
    <div class="container">
        
        <div class="single-blog-layout">

            <!-- ══════════════════════════════════════════════════════
                 LEFT / MAIN CONTENT PANEL
            ══════════════════════════════════════════════════════ -->
            <article class="single-main-panel">

                <!-- Top Quick Share Bar -->
                <div class="article-share-strip">
                    <span class="share-strip-label">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        Bagikan Artikel:
                    </span>
                    <div class="share-strip-icons">
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($post_title . ' ' . $post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" data-tooltip="WhatsApp" aria-label="Bagikan ke WhatsApp" style="background: #25D366; color: #FFF;">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        </a>
                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" data-tooltip="LinkedIn" aria-label="Bagikan ke LinkedIn" style="background: #0A66C2; color: #FFF;">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.262-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_permalink); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" data-tooltip="Facebook" aria-label="Bagikan ke Facebook" style="background: #1877F2; color: #FFF;">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.7 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <!-- X (Twitter) -->
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($post_permalink); ?>&text=<?php echo urlencode($post_title); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" data-tooltip="X (Twitter)" aria-label="Bagikan ke X" style="background: #000; color: #FFF;">
                            <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <!-- Copy Link -->
                        <button id="copy-article-link" class="share-btn" data-tooltip="Salin Tautan" aria-label="Salin Tautan Artikel" style="background: #64748B; color: #FFF;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()): ?>
                    <figure class="single-featured-figure">
                        <?php the_post_thumbnail('large', [
                            'style' => 'width:100%;height:auto;object-fit:cover;',
                            'alt'   => esc_attr($post_title)
                        ]); ?>
                    </figure>
                <?php endif; ?>

                <!-- Mobile / Tablet In-Content Table of Contents (Collapsible) -->
                <div id="article-toc-container" class="article-toc-mobile-box" style="display:none;">
                    <button type="button" id="toc-toggle-btn" class="toc-toggle-btn">
                        <span style="font-size: 15px; font-weight: 700; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0057FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Daftar Isi Artikel
                        </span>
                        <span style="display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; color: #0057FF;">
                            <span id="toc-status-text">Sembunyikan</span>
                            <svg id="toc-chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.25s ease; transform: rotate(180deg);"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </button>
                    <div id="toc-content-body" class="toc-body">
                        <ul id="toc-list"></ul>
                    </div>
                </div>

                <!-- Main Post Content -->
                <div class="post-body">
                    <?php the_content(); ?>
                </div>

                <!-- Article WhatsApp Consultation Banner -->
                <div class="article-wa-cta-card">
                    <div class="wa-cta-watermark" aria-hidden="true">
                        <svg width="190" height="190" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    </div>
                    <div class="wa-cta-inner">
                        <div style="max-width: 500px;">
                            <span class="wa-cta-badge">Konsultasi Teknis B2B</span>
                            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 20px; font-weight: 700; color: #FFF; margin: 0 0 8px; line-height: 1.3;">Butuh Solusi Formulasi atau Bahan Kimia Produk Ini?</h3>
                            <p style="font-size: 13.5px; color: #94A3B8; margin: 0; line-height: 1.6;">Tim teknis PT Indotech Berkah Abadi siap membantu kebutuhan bahan baku berkualitas, sampel uji coba, dan konsultasi formulasi untuk bisnis Anda.</p>
                        </div>
                        <div>
                            <a href="https://wa.me/<?php echo esc_attr($wa_num); ?>?text=<?php echo urlencode('Halo Indotech, saya membaca artikel "' . $post_title . '" dan ingin berkonsultasi seputar bahan kimia/formulasi terkait.'); ?>" target="_blank" rel="noopener noreferrer" class="wa-cta-btn">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                Konsultasi WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Editorial Verification & Approval Card -->
                <div class="article-approval-card">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div style="width: 44px; height: 44px; min-width: 44px; border-radius: 50%; background: #D1FAE5; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 22px; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">
                                <h4 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0; font-family: 'Space Grotesk', sans-serif;">Artikel Terverifikasi &amp; Disetujui Redaksi</h4>
                                <span style="font-size: 11px; font-weight: 700; background: #10B981; color: #FFFFFF; padding: 2px 9px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Terverifikasi</span>
                            </div>
                            <p style="font-size: 13.5px; color: #334155; margin: 0; line-height: 1.6;">
                                Konten ini telah ditinjau oleh <strong>Tim Redaksi &amp; Tim Ahli Formulasi PT Indotech Berkah Abadi</strong> untuk memastikan keakuratan teknis, standar keamanan kimia, dan relevansi industri.
                            </p>
                            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 10px; font-size: 12px; color: #64748B; border-top: 1px dashed #CBD5E1; padding-top: 8px;">
                                <span><strong>Penerbit:</strong> PT Indotech Berkah Abadi</span>
                                <span>•</span>
                                <span><strong>Terakhir Diperbarui:</strong> <?php echo get_the_modified_date('d M Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Article Tags -->
                <?php
                $tags = get_the_tags();
                if ($tags):
                ?>
                <div class="article-tags-wrapper">
                    <span style="font-size: 13px; font-weight: 700; color: #64748B; margin-right: 4px;">Topik Terkait:</span>
                    <?php foreach ($tags as $tag): ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="article-tag-pill">
                            #<?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Author Bio Box -->
                <div class="article-author-bio-card">
                    <div class="author-avatar-badge" aria-hidden="true">
                        <?php echo strtoupper(substr($author_name, 0, 1)); ?>
                    </div>
                    <div style="flex: 1;">
                        <span style="font-size: 11.5px; font-weight: 700; color: #0057FF; text-transform: uppercase; letter-spacing: 0.5px;">Tentang Penulis</span>
                        <h4 style="font-family: 'Space Grotesk', sans-serif; font-size: 17px; font-weight: 700; color: #0F172A; margin: 2px 0 6px;">
                            <?php echo esc_html($author_name); ?>
                        </h4>
                        <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.55;">
                            <?php echo esc_html($author_bio); ?>
                        </p>
                    </div>
                </div>

                <!-- Previous / Next Article Navigation -->
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                if ($prev_post || $next_post):
                ?>
                <div class="post-navigation-grid">
                    <?php if ($prev_post): ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="post-nav-card prev">
                            <span style="font-size: 11px; color: #0057FF; font-weight: 700; text-transform: uppercase;">&larr; Artikel Sebelumnya</span>
                            <h5 style="margin: 6px 0 0; font-size: 14px; font-weight: 600; color: #0F172A; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo esc_html($prev_post->post_title); ?></h5>
                        </a>
                    <?php else: ?>
                        <div></div>
                    <?php endif; ?>

                    <?php if ($next_post): ?>
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="post-nav-card next">
                            <span style="font-size: 11px; color: #0057FF; font-weight: 700; text-transform: uppercase;">Artikel Selanjutnya &rarr;</span>
                            <h5 style="margin: 6px 0 0; font-size: 14px; font-weight: 600; color: #0F172A; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo esc_html($next_post->post_title); ?></h5>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </article>

            <!-- ══════════════════════════════════════════════════════
                 RIGHT SIDEBAR PANEL (Sticky)
            ══════════════════════════════════════════════════════ -->
            <aside class="single-sidebar-panel">
                <div class="single-sidebar-sticky">

                    <!-- Widget 1: Sticky Table of Contents -->
                    <div id="sidebar-toc-widget" class="sidebar-widget" style="display:none;">
                        <h4 class="sidebar-widget-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0057FF" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Daftar Isi
                        </h4>
                        <ul id="sidebar-toc-list" class="sidebar-toc-list"></ul>
                    </div>

                    <!-- Widget 2: Formulasi & Consultation CTA Card -->
                    <div class="sidebar-cta-widget">
                        <span class="sidebar-cta-badge">Layanan Formulasi</span>
                        <h4 class="sidebar-cta-title">Formulasi &amp; Sampel Kimia</h4>
                        <p class="sidebar-cta-desc">Dapatkan formulasi presisi, penawaran harga bersaing, dan sampel bahan baku untuk industri Anda.</p>
                        <a href="https://wa.me/<?php echo esc_attr($wa_num); ?>?text=<?php echo urlencode('Halo Indotech, saya ingin berkonsultasi mengenai kebutuhan bahan baku dan formulasi.'); ?>" target="_blank" rel="noopener noreferrer" class="sidebar-wa-btn">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            Konsultasi WhatsApp
                        </a>
                    </div>

                    <!-- Widget 3: Latest / Recommended Posts -->
                    <?php if ($sidebar_recent_query->have_posts()): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0057FF" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Artikel Terbaru
                        </h4>
                        <ul class="sidebar-recent-list">
                            <?php while ($sidebar_recent_query->have_posts()): $sidebar_recent_query->the_post(); 
                                $r_cats = get_the_category();
                                $r_cat_name = !empty($r_cats) ? $r_cats[0]->name : '';
                            ?>
                            <li class="sidebar-recent-item">
                                <a href="<?php the_permalink(); ?>" class="sidebar-recent-thumb" tabindex="-1" aria-hidden="true">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('thumbnail', ['alt' => get_the_title()]); ?>
                                    <?php else: ?>
                                        <div style="width:100%;height:100%;background:#E2E8F0;display:flex;align-items:center;justify-content:center;color:#94A3B8;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="sidebar-recent-info">
                                    <div class="sidebar-recent-meta">
                                        <?php if ($r_cat_name): ?>
                                            <span style="color:#0057FF;font-weight:600;"><?php echo esc_html($r_cat_name); ?></span> · 
                                        <?php endif; ?>
                                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M'); ?></time>
                                    </div>
                                    <h5 class="sidebar-recent-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                </div>
                            </li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Widget 4: Categories List -->
                    <?php if (!empty($all_categories)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0057FF" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            Kategori Blog
                        </h4>
                        <ul class="sidebar-cat-list">
                            <?php foreach ($all_categories as $cat): ?>
                            <li>
                                <a href="<?php echo esc_url(home_url('/blog/?kategori=' . $cat->slug)); ?>" class="sidebar-cat-link">
                                    <span><?php echo esc_html($cat->name); ?></span>
                                    <span class="sidebar-cat-count"><?php echo (int)$cat->count; ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>

    </div>
</main>

<!-- ══════════════════════════════════════════════════════════════
     RELATED ARTICLES SECTION
══════════════════════════════════════════════════════════════ -->
<?php
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

<?php if (!empty($related_posts)): ?>
    <section class="blog-section section-padding" style="background: var(--surface); border-top: 1px solid var(--border);">
        <div class="container">
            
            <div class="blog-section-header" style="margin-bottom: 36px;">
                <div class="blog-section-left">
                    <span class="section-tag">Rekomendasi</span>
                    <h2 class="section-title" style="margin-top: 8px;">Artikel <em>Terkait</em></h2>
                </div>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn-outline" style="align-self: flex-end;">
                    Semua Artikel &rarr;
                </a>
            </div>
            
            <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                <?php 
                global $post;
                foreach ($related_posts as $post): 
                    setup_postdata($post);
                    $r_cats = get_the_category();
                    $r_word_count = str_word_count(strip_tags(get_the_content()));
                    $r_reading_time = max(1, ceil($r_word_count / 200));
                ?>
                    <article class="blog-card" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                        <!-- Thumbnail -->
                        <a href="<?php the_permalink(); ?>" class="blog-thumb" style="height: 180px; position: relative; overflow: hidden; display: block; background: #F1F5F9;" tabindex="-1" aria-hidden="true">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('indotech-card', [
                                    'class'   => 'blog-img',
                                    'loading' => 'lazy',
                                    'alt'     => get_the_title(),
                                    'style'   => 'width:100%;height:100%;object-fit:cover;'
                                ]); ?>
                            <?php else: ?>
                                <div class="blog-img-placeholder" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E2E8F0;color:#64748B;">
                                    <span class="blog-placeholder-label">Indotech Blog</span>
                                </div>
                            <?php endif; ?>

                            <?php if ($r_cats): ?>
                                <span class="blog-category" style="position: absolute; top: 12px; left: 12px; background: #0057FF; color: #FFFFFF; font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.05em; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                    <?php echo esc_html($r_cats[0]->name); ?>
                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- Body -->
                        <div class="blog-body" style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                            <div class="blog-meta" style="font-size: 12px; color: #64748B; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d M Y')); ?>
                                </time>
                                <span class="blog-meta-sep" aria-hidden="true">&middot;</span>
                                <span><?php echo $r_reading_time; ?> mnt baca</span>
                            </div>

                            <h3 class="blog-title" style="font-size: 16px; font-weight: 700; line-height: 1.35; margin-bottom: 8px; color: #0F172A;">
                                <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                            </h3>

                            <p class="blog-excerpt" style="font-size: 13px; color: #475569; line-height: 1.55; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                            </p>

                            <a href="<?php the_permalink(); ?>" class="blog-read-more" style="margin-top: auto; font-size: 12.5px; font-weight: 700; color: #0057FF; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
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

<!-- ══════════════════════════════════════════════════════════════
     IMAGE LIGHTBOX MODAL
══════════════════════════════════════════════════════════════ -->
<div id="post-gallery-lightbox" class="post-lightbox" role="dialog" aria-modal="true" aria-label="Peninjau Gambar">
    <button class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="post-lightbox-img" src="" alt="Artikel Detail">
    </div>
    <button class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="post-lightbox-current">1</span> / <span id="post-lightbox-total">1</span></div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     CLIENT INTERACTIONS & TOC GENERATION
══════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── 1. Reading Progress Bar ─────────────────────────────────
    const progressBar = document.getElementById('reading-progress-bar');
    if (progressBar) {
        window.addEventListener('scroll', function() {
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            if (docHeight > 0) {
                const scrolled = (window.scrollY / docHeight) * 100;
                progressBar.style.width = Math.min(100, Math.max(0, scrolled)) + '%';
            }
        }, { passive: true });
    }

    // ── 2. Auto-format "Baca juga:" paragraphs into callout box ──
    const bodyPs = document.querySelectorAll('.post-body p');
    bodyPs.forEach(p => {
        const text = p.textContent || p.innerText;
        if (/baca\s*juga\s*:/i.test(text) || (p.querySelector('strong, b') && /baca\s*juga/i.test(p.querySelector('strong, b').textContent))) {
            p.classList.add('baca-juga-box');
        }
    });

    // ── 3. Auto Table of Contents Generation (Mobile & Sidebar) ──
    const headings = document.querySelectorAll('.post-body h2, .post-body h3');
    const mobileTocContainer = document.getElementById('article-toc-container');
    const mobileTocList = document.getElementById('toc-list');
    const sidebarTocWidget = document.getElementById('sidebar-toc-widget');
    const sidebarTocList = document.getElementById('sidebar-toc-list');

    if (headings.length >= 2) {
        const tocLinks = [];

        headings.forEach((heading, idx) => {
            const id = heading.id || `section-heading-${idx + 1}`;
            heading.id = id;
            const text = heading.textContent.replace(/^[0-9]+\.\s*/, '').trim();
            const isH3 = heading.tagName.toLowerCase() === 'h3';

            // Mobile TOC Item
            if (mobileTocList) {
                const li = document.createElement('li');
                li.style.marginBottom = '6px';
                if (isH3) {
                    li.style.marginLeft = '16px';
                    li.style.listStyleType = 'circle';
                }
                const a = document.createElement('a');
                a.href = `#${id}`;
                a.textContent = text;
                a.style.color = '#0057FF';
                a.style.textDecoration = 'none';
                a.style.fontWeight = '500';
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    heading.scrollIntoView({ behavior: 'smooth' });
                });
                li.appendChild(a);
                mobileTocList.appendChild(li);
            }

            // Sidebar TOC Item
            if (sidebarTocList) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = `#${id}`;
                a.textContent = text;
                a.className = 'sidebar-toc-link' + (isH3 ? ' is-h3' : '');
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    heading.scrollIntoView({ behavior: 'smooth' });
                });
                li.appendChild(a);
                sidebarTocList.appendChild(li);
                tocLinks.push({ heading, link: a });
            }
        });

        if (mobileTocContainer) mobileTocContainer.style.display = 'block';
        if (sidebarTocWidget) sidebarTocWidget.style.display = 'block';

        // Scrollspy for Sidebar TOC
        if (tocLinks.length > 0) {
            function updateActiveToc() {
                const scrollPos = window.scrollY + 120;
                let activeIndex = 0;
                tocLinks.forEach((item, index) => {
                    const top = item.heading.getBoundingClientRect().top + window.scrollY;
                    if (scrollPos >= top) {
                        activeIndex = index;
                    }
                });
                tocLinks.forEach((item, index) => {
                    if (index === activeIndex) {
                        item.link.classList.add('active');
                    } else {
                        item.link.classList.remove('active');
                    }
                });
            }
            window.addEventListener('scroll', updateActiveToc, { passive: true });
            updateActiveToc();
        }

        // Mobile Accordion Toggle
        const tocToggleBtn = document.getElementById('toc-toggle-btn');
        const tocContentBody = document.getElementById('toc-content-body');
        const tocChevronIcon = document.getElementById('toc-chevron-icon');
        const tocStatusText = document.getElementById('toc-status-text');

        if (tocToggleBtn && tocContentBody && tocChevronIcon && tocStatusText) {
            let isTocOpen = true;
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

    // ── 4. Copy Link Button Handler ─────────────────────────────
    const copyBtn = document.getElementById('copy-article-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(function() {
                copyBtn.setAttribute('data-tooltip', 'Link Tersalin!');
                copyBtn.style.background = '#10B981';
                setTimeout(() => {
                    copyBtn.setAttribute('data-tooltip', 'Salin Tautan');
                    copyBtn.style.background = '#64748B';
                }, 2200);
            }).catch(function() {
                alert('Tautan artikel: ' + url);
            });
        });
    }

    // ── 5. Lightbox Image Modal ─────────────────────────────────
    const contentImages = document.querySelectorAll('.post-body img, .single-featured-figure img');
    if (contentImages.length) {
        const images = Array.from(contentImages).map(img => img.src);
        let currentIndex = 0;

        const lightbox = document.getElementById('post-gallery-lightbox');
        const lightboxImg = document.getElementById('post-lightbox-img');
        const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;
        const lightboxPrev = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
        const lightboxNext = lightbox ? lightbox.querySelector('.lightbox-next') : null;
        const lightboxCurrent = document.getElementById('post-lightbox-current');
        const lightboxTotal = document.getElementById('post-lightbox-total');

        if (lightboxTotal) lightboxTotal.textContent = images.length;
        if (images.length <= 1) {
            if (lightboxPrev) lightboxPrev.style.display = 'none';
            if (lightboxNext) lightboxNext.style.display = 'none';
        }

        function updateLightboxImage() {
            if (lightboxImg) lightboxImg.src = images[currentIndex];
            if (lightboxCurrent) lightboxCurrent.textContent = currentIndex + 1;
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

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxPrev) lightboxPrev.addEventListener('click', showPrev);
        if (lightboxNext) lightboxNext.addEventListener('click', showNext);

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
    }
});
</script>

<?php get_footer(); ?>
