<?php
/**
 * Template Name: Blank PDF - Pricelist
 * Template Post Type: page
 *
 * Halaman Blank Fokus PDF Pricelist dengan Floating Download Button
 * PT Indotech Berkah Abadi
 */

// Mencegah akses langsung
if (!defined('ABSPATH')) {
    exit;
}

$pdf_file_id   = '1YUquGSjkgzAieqSN0zjY6NTYy8qtHf67';
$pdf_preview   = 'https://drive.google.com/file/d/' . $pdf_file_id . '/preview';
$pdf_download  = 'https://drive.usercontent.google.com/download?id=' . $pdf_file_id . '&export=download';
$pdf_alt_dl    = 'https://drive.google.com/uc?export=download&id=' . $pdf_file_id;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Pricelist Produk &amp; Kemitraan - PT Indotech Berkah Abadi</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="Pricelist resmi produk PT Indotech Berkah Abadi (Cleanique Lab, Cleanique Mart, Orchid Brand).">

    <!-- Open Graph -->
    <meta property="og:title" content="Pricelist Produk - PT Indotech Berkah Abadi">
    <meta property="og:description" content="Katalog dan daftar harga produk resmi PT Indotech Berkah Abadi.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url( get_permalink() ); ?>">

    <!-- Favicon -->
    <?php if ( function_exists('has_site_icon') && has_site_icon() ) : ?>
        <?php wp_site_icon(); ?>
    <?php else : ?>
        <link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotech-baru.avif' ); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>

    <style>
        /* Reset all host styles for full blank focus canvas */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100% !important;
            height: 100% !important;
            height: 100dvh !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background-color: #0f172a !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #f8fafc;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Suppress site header, footer, floating actions, cookie notice, etc. */
        .site-header,
        .site-footer,
        .indotech-floating-actions,
        .page-hero,
        #cookie-notice,
        .cookie-banner {
            display: none !important;
        }

        /* Support WordPress admin bar cleanly for logged-in users */
        body.admin-bar .pdf-main-container {
            height: calc(100vh - 32px) !important;
            height: calc(100dvh - 32px) !important;
            margin-top: 32px;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .pdf-main-container {
                height: calc(100vh - 46px) !important;
                height: calc(100dvh - 46px) !important;
                margin-top: 46px;
            }
        }

        /* PDF Main Viewport Container */
        .pdf-main-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            background-color: #0f172a;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Loading Screen Placeholder */
        .pdf-loading-state {
            position: absolute;
            inset: 0;
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #0f172a;
            gap: 16px;
            padding: 24px;
            text-align: center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .pdf-loading-state.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .pdf-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(255, 255, 255, 0.12);
            border-top-color: #0284c7;
            border-radius: 50%;
            animation: pdfSpin 0.9s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
        }

        @keyframes pdfSpin {
            to { transform: rotate(360deg); }
        }

        .loading-title {
            font-size: 15px;
            font-weight: 500;
            color: #94a3b8;
            letter-spacing: 0.2px;
        }

        .loading-hint {
            font-size: 13px;
            color: #64748b;
        }
        .loading-hint a {
            color: #38bdf8;
            text-decoration: underline;
        }

        /* Iframe Fullscreen PDF Frame */
        .pdf-embed-frame {
            position: relative;
            z-index: 10;
            width: 100%;
            height: 100%;
            flex: 1 1 auto;
            border: none;
            display: block;
            background-color: #525659;
        }

        /* Subtle Floating Home Button */
        .floating-back-link {
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 999999;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: rgba(15, 23, 42, 0.82);
            color: #e2e8f0;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }
        .floating-back-link:hover {
            background: rgba(15, 23, 42, 0.95);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        .floating-back-link svg {
            width: 15px;
            height: 15px;
            stroke-width: 2.2;
        }

        /* Floating Download Action Button */
        .floating-download-action {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999999;
            display: flex;
            align-items: center;
        }

        .floating-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff !important;
            text-decoration: none !important;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
            border-radius: 999px;
            box-shadow: 0 10px 25px -4px rgba(2, 132, 199, 0.5), 0 6px 10px -4px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            user-select: none;
        }

        .floating-download-btn:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-2px);
            box-shadow: 0 16px 30px -4px rgba(2, 132, 199, 0.6), 0 8px 14px -4px rgba(0, 0, 0, 0.4);
            color: #ffffff !important;
        }

        .floating-download-btn:active {
            transform: translateY(0);
            box-shadow: 0 6px 14px -3px rgba(2, 132, 199, 0.4);
        }

        .floating-download-btn svg {
            width: 19px;
            height: 19px;
            stroke-width: 2.3;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .floating-download-btn:hover svg {
            transform: translateY(2px);
        }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            .floating-download-action {
                bottom: 16px;
                right: 16px;
            }
            .floating-download-btn {
                padding: 12px 18px;
                font-size: 13px;
                gap: 8px;
            }
            .btn-text-desktop {
                display: none;
            }
            .btn-text-mobile {
                display: inline;
            }
            .floating-back-link {
                top: 12px;
                left: 12px;
                padding: 6px 11px;
                font-size: 12px;
            }
        }
        @media (min-width: 641px) {
            .btn-text-mobile {
                display: none;
            }
            .btn-text-desktop {
                display: inline;
            }
        }
    </style>
</head>
<body <?php body_class('blank-pdf-viewer'); ?>>

    <!-- Minimal Subtle Back to Home Link -->
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="floating-back-link" title="Kembali ke Beranda">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        <span>indotech.id</span>
    </a>

    <!-- PDF Main Container -->
    <main class="pdf-main-container">
        <!-- Loading Placeholder -->
        <div id="pdfLoader" class="pdf-loading-state" aria-live="polite">
            <div class="pdf-spinner"></div>
            <div class="loading-title">Memuat Dokumen Pricelist...</div>
            <div class="loading-hint">
                Jika preview tidak muncul, silakan <a href="<?php echo esc_url($pdf_download); ?>" target="_blank" rel="noopener">klik di sini untuk mengunduh PDF</a>.
            </div>
        </div>

        <!-- Fullscreen PDF Iframe -->
        <iframe 
            id="pdfFrame"
            class="pdf-embed-frame"
            src="<?php echo esc_url($pdf_preview); ?>"
            title="Pricelist Cleanique Lab - PT Indotech Berkah Abadi"
            allow="autoplay; fullscreen"
            loading="eager"
            onload="document.getElementById('pdfLoader').classList.add('loaded')">
        </iframe>
    </main>

    <!-- Floating Download Button -->
    <div class="floating-download-action">
        <a href="<?php echo esc_url($pdf_download); ?>" 
           class="floating-download-btn"
           target="_blank"
           rel="noopener noreferrer"
           download="Pricelist-Cleanique-Lab-Indotech.pdf"
           aria-label="Download Pricelist PDF"
           title="Download Pricelist PDF">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            <span class="btn-text-desktop">Download Pricelist (PDF)</span>
            <span class="btn-text-mobile">Download PDF</span>
        </a>
    </div>

    <script>
        // Fallback untuk menyembunyikan loader jika onload iframe terhambat
        setTimeout(function() {
            var loader = document.getElementById('pdfLoader');
            if (loader) {
                loader.classList.add('loaded');
            }
        }, 3500);
    </script>

    <?php wp_footer(); ?>
</body>
</html>
