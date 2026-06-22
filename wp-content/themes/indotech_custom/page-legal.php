<?php
/**
 * Template Name: Halaman Legal
 *
 * Template bersama untuk halaman legal:
 * - Privacy Policy (/privacy-policy)
 * - Syarat & Ketentuan (/syarat-ketentuan)
 * - Cookie Policy (/cookie-policy)
 *
 * Konten dikelola via WordPress editor.
 * Layout: Hero + sidebar navigasi anchor kiri + konten artikel kanan.
 */

// Build heading anchors dari konten halaman untuk navigasi sidebar
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

// Tambahkan id anchor ke heading dalam konten
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

get_header();

// Ambil data halaman
$page_title   = get_the_title();
$page_content = '';
$headings     = [];

if ( have_posts() ) {
    the_post();
    $raw_content  = get_the_content();
    $page_content = apply_filters( 'the_content', indotech_add_heading_ids( $raw_content ) );
    $headings     = indotech_extract_headings( $raw_content );
}

$last_updated = get_the_modified_date( 'd F Y' );
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
                            <a href="mailto:<?php echo esc_attr( indotech_opt('email', 'info@indotech.id') ); ?>" class="btn btn-outline">
                                <?php echo esc_html( indotech_opt('email', 'info@indotech.id') ); ?>
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
