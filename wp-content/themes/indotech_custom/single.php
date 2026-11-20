<?php
/**
 * Single Post Template — Editorial 2-Column Architecture (Indotech–Manufy)
 */

$whatsapp = function_exists( 'indotech_opt' ) ? indotech_opt( 'whatsapp', '6287885590088' ) : '6287885590088';
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );

get_header();
?>

<div id="reading-progress-bar" class="reading-progress-bar" aria-hidden="true"></div>

<main id="main-content" class="ch-main cs-main" tabindex="-1">
    <div class="ch-canvas-band ch-canvas-band--top">
        <div class="ch-grid-guides" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <?php
        while ( have_posts() ) :
            the_post();
            $post_id        = get_the_ID();
            $post_content   = get_the_content();
            $word_count     = str_word_count( wp_strip_all_tags( $post_content ) );
            $reading_time   = max( 1, ceil( $word_count / 200 ) );
            $categories     = get_the_category();
            $primary_cat    = ! empty( $categories ) ? $categories[0] : null;
            $cat_name       = $primary_cat ? $primary_cat->name : '';
            $cat_slug       = $primary_cat ? $primary_cat->slug : '';
            $post_permalink = get_permalink();
            $post_title     = get_the_title();
            $author_name    = get_the_author();
            $author_bio     = get_the_author_meta( 'description' );
            if ( empty( $author_bio ) ) {
                $author_bio = 'Tim Redaksi & Riset PT Indotech Berkah Abadi menyajikan panduan formulasi, wawasan bahan kimia industri, dan edukasi seputar produk pembersih B2B.';
            }

            $sidebar_recent_query = new WP_Query( [
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'post__not_in'   => [ $post_id ],
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ] );

            $all_categories = get_categories( [
                'orderby'    => 'count',
                'order'      => 'DESC',
                'hide_empty' => true,
                'exclude'    => [ 1, 20 ],
            ] );
            if ( ! empty( $all_categories ) ) {
                $all_categories = array_filter( $all_categories, function ( $cat ) {
                    return ! is_numeric( $cat->name ) && ! in_array( strtolower( $cat->slug ), [ 'uncategorized', 'tak-berkategori' ], true );
                } );
            }
            ?>

            <section class="cs-hero cs-hero--compact ch-wrap" id="single-post-hero" aria-labelledby="single-post-title">
                <nav class="cs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a>
                    <?php if ( $primary_cat ) : ?>
                        <span aria-hidden="true">/</span>
                        <a href="<?php echo esc_url( home_url( '/blog/?kategori=' . $cat_slug ) ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                    <?php endif; ?>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?php echo esc_html( wp_trim_words( $post_title, 7, '...' ) ); ?></span>
                </nav>

                <header class="cs-article-header">
                    <div class="cs-article-meta-row">
                        <?php if ( $cat_name ) : ?>
                            <a href="<?php echo esc_url( home_url( '/blog/?kategori=' . $cat_slug ) ); ?>" class="cs-pill-tag">
                                <?php echo esc_html( $cat_name ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="cs-article-meta-items">
                            <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></time>
                            <span aria-hidden="true">&middot;</span>
                            <span><?php echo esc_html( $author_name ); ?></span>
                            <span aria-hidden="true">&middot;</span>
                            <span><?php echo (int) $reading_time; ?> mnt baca</span>
                        </div>
                    </div>

                    <h1 id="single-post-title" class="cs-single-h1"><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="cs-single-figure">
                        <?php
                        the_post_thumbnail( 'large', [
                            'alt'           => esc_attr( $post_title ),
                            'fetchpriority' => 'high',
                            'decoding'      => 'async',
                        ] );
                        ?>
                    </figure>
                <?php endif; ?>
            </section>

            <section class="cs-band cs-band--tight ch-wrap" aria-label="Konten artikel">
                <div class="cs-single-layout">
                    <article class="cs-single-article">
                        <div class="cs-share-strip">
                            <span class="cs-share-label">Bagikan Artikel</span>
                            <div class="cs-share-icons">
                                <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( $post_title . ' ' . $post_permalink ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Bagikan ke WhatsApp">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( $post_permalink ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Bagikan ke LinkedIn">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.262-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( $post_permalink ); ?>&text=<?php echo rawurlencode( $post_title ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Bagikan ke X">
                                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                                <button type="button" id="copy-article-link" class="share-btn" aria-label="Salin Tautan Artikel">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                </button>
                            </div>
                        </div>

                        <div id="article-toc-container" class="article-toc-mobile-box" style="display:none;">
                            <button type="button" id="toc-toggle-btn" class="toc-toggle-btn">
                                <span>Daftar Isi Artikel</span>
                                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8125rem; color: var(--ch-cobalt);">
                                    <span id="toc-status-text">Sembunyikan</span>
                                    <svg id="toc-chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="transition: transform 0.22s ease; transform: rotate(180deg);" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                                </span>
                            </button>
                            <div id="toc-content-body" class="toc-body">
                                <ul id="toc-list"></ul>
                            </div>
                        </div>

                        <div class="post-body">
                            <?php the_content(); ?>
                        </div>

                        <div class="cs-article-wa-band">
                            <div>
                                <span class="cs-pill-tag cs-pill-tag--lime">Konsultasi Teknis B2B</span>
                                <h2>Butuh Solusi Formulasi atau Bahan Kimia Produk Ini?</h2>
                                <p>Tim teknis PT Indotech Berkah Abadi siap membantu kebutuhan bahan baku, sampel uji coba, dan konsultasi formulasi B2B Anda.</p>
                            </div>
                            <a
                                href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Halo Indotech, saya membaca artikel "' . $post_title . '" dan ingin berkonsultasi seputar bahan kimia/formulasi terkait.' ); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="ch-pill-cta"
                            >
                                <span>Konsultasi WhatsApp</span>
                                <span class="ch-pill-cta-icon" aria-hidden="true">
                                    <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                                </span>
                            </a>
                        </div>

                        <div class="cs-article-note-list">
                            <div class="cs-article-note-item">
                                <strong>Redaksi Teknis Terverifikasi · Diperbarui <?php echo esc_html( get_the_modified_date( 'd M Y' ) ); ?></strong>
                                <p>Konten ditinjau oleh Tim Redaksi &amp; Formulasi PT Indotech Berkah Abadi untuk memastikan akurasi standar mutu dan relevansi operasional B2B.</p>
                            </div>
                            <div class="cs-article-note-item">
                                <strong>Tentang Penulis · <?php echo esc_html( $author_name ); ?></strong>
                                <p><?php echo esc_html( $author_bio ); ?></p>
                            </div>
                        </div>

                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                            ?>
                            <div class="cs-tag-list" aria-label="Topik terkait">
                                <?php foreach ( $tags as $tag ) : ?>
                                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="cs-tag-pill">
                                        #<?php echo esc_html( $tag->name ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        if ( $prev_post || $next_post ) :
                            ?>
                            <nav class="cs-post-nav" aria-label="Navigasi antar artikel">
                                <?php if ( $prev_post ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="cs-post-nav-link">
                                        <span class="cs-post-nav-label">&larr; Artikel Sebelumnya</span>
                                        <h3 class="cs-post-nav-title"><?php echo esc_html( $prev_post->post_title ); ?></h3>
                                    </a>
                                <?php else : ?>
                                    <div></div>
                                <?php endif; ?>

                                <?php if ( $next_post ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="cs-post-nav-link cs-post-nav-link--next">
                                        <span class="cs-post-nav-label">Artikel Selanjutnya &rarr;</span>
                                        <h3 class="cs-post-nav-title"><?php echo esc_html( $next_post->post_title ); ?></h3>
                                    </a>
                                <?php endif; ?>
                            </nav>
                        <?php endif; ?>
                    </article>

                    <aside class="cs-single-rail" aria-label="Sidebar artikel">
                        <div id="sidebar-toc-widget" class="cs-rail-section" style="display:none;">
                            <h2 class="cs-rail-title">Daftar Isi</h2>
                            <ul id="sidebar-toc-list" class="sidebar-toc-list"></ul>
                        </div>

                        <div class="cs-rail-dark-cta">
                            <span class="cs-pill-tag cs-pill-tag--lime">Layanan Formulasi</span>
                            <h2>Formulasi &amp; Sampel Kimia</h2>
                            <p>Dapatkan formulasi presisi, penawaran grosir, dan sampel produk kebersihan untuk bisnis Anda.</p>
                            <a
                                href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Halo Indotech, saya ingin berkonsultasi mengenai kebutuhan bahan baku dan formulasi.' ); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="ch-lime-link"
                            >
                                <span>Konsultasi WhatsApp</span>
                                <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                            </a>
                        </div>

                        <?php if ( $sidebar_recent_query->have_posts() ) : ?>
                            <div class="cs-rail-section">
                                <h2 class="cs-rail-title">Artikel Terbaru</h2>
                                <ul class="cs-rail-recent">
                                    <?php
                                    while ( $sidebar_recent_query->have_posts() ) :
                                        $sidebar_recent_query->the_post();
                                        ?>
                                        <li class="cs-rail-recent-item">
                                            <?php if ( has_post_thumbnail() ) : ?>
                                                <a href="<?php the_permalink(); ?>" class="cs-rail-recent-thumb" tabindex="-1" aria-hidden="true">
                                                    <?php the_post_thumbnail( 'thumbnail', [ 'alt' => '' ] ); ?>
                                                </a>
                                            <?php endif; ?>
                                            <h3 class="cs-rail-recent-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                        </li>
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $all_categories ) ) : ?>
                            <div class="cs-rail-section">
                                <h2 class="cs-rail-title">Kategori Blog</h2>
                                <ul class="cs-rail-cats">
                                    <?php foreach ( $all_categories as $cat ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( home_url( '/blog/?kategori=' . $cat->slug ) ); ?>">
                                                <span><?php echo esc_html( $cat->name ); ?></span>
                                                <span><?php echo (int) $cat->count; ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </aside>
                </div>
            </section>

            <?php
            $cat_ids = $categories ? wp_list_pluck( $categories, 'term_id' ) : [];
            $related_query = new WP_Query( [
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post__not_in'   => [ $post_id ],
                'post_status'    => 'publish',
                'category__in'   => ! empty( $cat_ids ) ? $cat_ids : [],
                'orderby'        => 'rand',
            ] );
            if ( $related_query->post_count < 3 ) {
                $exclude        = array_merge( [ $post_id ], wp_list_pluck( $related_query->posts, 'ID' ) );
                $fallback_query = new WP_Query( [
                    'post_type'      => 'post',
                    'posts_per_page' => 3 - $related_query->post_count,
                    'post__not_in'   => $exclude,
                    'post_status'    => 'publish',
                ] );
                $related_posts = array_merge( $related_query->posts, $fallback_query->posts );
            } else {
                $related_posts = $related_query->posts;
            }
            ?>

            <?php if ( ! empty( $related_posts ) ) : ?>
                <section class="cs-band ch-wrap" aria-labelledby="cs-related-posts-title">
                    <header class="ch-section-head">
                        <div>
                            <span class="cs-pill-tag">Rekomendasi</span>
                            <h2 id="cs-related-posts-title" class="ch-section-h2 ch-section-h2--sm">Artikel <span>Terkait</span></h2>
                        </div>
                        <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="ch-inline-link">
                            <span>Semua artikel</span>
                            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                        </a>
                    </header>

                    <div class="cs-editorial-grid">
                        <?php
                        global $post;
                        foreach ( $related_posts as $post ) :
                            setup_postdata( $post );
                            $r_id     = get_the_ID();
                            $img_html = has_post_thumbnail( $r_id )
                                ? get_the_post_thumbnail( $r_id, 'indotech-card', [ 'loading' => 'lazy', 'decoding' => 'async' ] )
                                : '';
                            $desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );
                            get_template_part( 'template-parts/archive/editorial-item', null, [
                                'url'            => get_permalink( $r_id ),
                                'title'          => get_the_title( $r_id ),
                                'desc'           => $desc,
                                'image_html'     => $img_html,
                                'fallback_label' => 'Indotech Journal',
                                'media_variant'  => 'wide',
                                'heading_tag'    => 'h3',
                                'post_id'        => $r_id,
                            ] );
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php get_template_part( 'template-parts/home/company-cta' ); ?>

        <?php endwhile; ?>
    </div>
</main>

<div id="post-gallery-lightbox" class="post-lightbox" role="dialog" aria-modal="true" aria-label="Peninjau Gambar">
    <button type="button" class="lightbox-close" aria-label="Tutup Galeri">&times;</button>
    <button type="button" class="lightbox-prev" aria-label="Gambar Sebelumnya">&lsaquo;</button>
    <div class="lightbox-content">
        <img id="post-lightbox-img" src="" alt="Artikel Detail">
    </div>
    <button type="button" class="lightbox-next" aria-label="Gambar Berikutnya">&rsaquo;</button>
    <div class="lightbox-counter"><span id="post-lightbox-current">1</span> / <span id="post-lightbox-total">1</span></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    document.querySelectorAll('.post-body p').forEach(p => {
        const text = p.textContent || p.innerText;
        if (/baca\s*juga\s*:/i.test(text) || (p.querySelector('strong, b') && /baca\s*juga/i.test(p.querySelector('strong, b').textContent))) {
            p.classList.add('baca-juga-box');
        }
    });

    const headings           = document.querySelectorAll('.post-body h2, .post-body h3');
    const mobileTocContainer = document.getElementById('article-toc-container');
    const mobileTocList      = document.getElementById('toc-list');
    const sidebarTocWidget   = document.getElementById('sidebar-toc-widget');
    const sidebarTocList     = document.getElementById('sidebar-toc-list');

    if (headings.length >= 2) {
        const tocLinks = [];

        headings.forEach((heading, idx) => {
            const id   = heading.id || `section-heading-${idx + 1}`;
            heading.id = id;
            const text = heading.textContent.replace(/^[0-9]+\.\s*/, '').trim();
            const isH3 = heading.tagName.toLowerCase() === 'h3';

            if (mobileTocList) {
                const li = document.createElement('li');
                if (isH3) li.style.marginLeft = '16px';
                const a       = document.createElement('a');
                a.href        = `#${id}`;
                a.textContent = text;
                a.addEventListener('click', e => {
                    e.preventDefault();
                    heading.scrollIntoView({ behavior: 'smooth' });
                });
                li.appendChild(a);
                mobileTocList.appendChild(li);
            }

            if (sidebarTocList) {
                const li    = document.createElement('li');
                const a     = document.createElement('a');
                a.href      = `#${id}`;
                a.textContent = text;
                a.className = 'sidebar-toc-link' + (isH3 ? ' is-h3' : '');
                a.addEventListener('click', e => {
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

        if (tocLinks.length > 0) {
            const updateActiveToc = () => {
                const scrollPos = window.scrollY + 120;
                let activeIndex = 0;
                tocLinks.forEach((item, index) => {
                    const top = item.heading.getBoundingClientRect().top + window.scrollY;
                    if (scrollPos >= top) activeIndex = index;
                });
                tocLinks.forEach((item, index) => item.link.classList.toggle('active', index === activeIndex));
            };
            window.addEventListener('scroll', updateActiveToc, { passive: true });
            updateActiveToc();
        }

        const tocToggleBtn    = document.getElementById('toc-toggle-btn');
        const tocContentBody  = document.getElementById('toc-content-body');
        const tocChevronIcon  = document.getElementById('toc-chevron-icon');
        const tocStatusText   = document.getElementById('toc-status-text');

        if (tocToggleBtn && tocContentBody) {
            let isTocOpen = true;
            tocToggleBtn.addEventListener('click', function() {
                isTocOpen = !isTocOpen;
                tocContentBody.style.display = isTocOpen ? 'block' : 'none';
                if (tocChevronIcon) tocChevronIcon.style.transform = isTocOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                if (tocStatusText) tocStatusText.textContent = isTocOpen ? 'Sembunyikan' : 'Tampilkan';
            });
        }
    }

    const copyBtn = document.getElementById('copy-article-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                copyBtn.style.borderColor = '#10b981';
                copyBtn.style.color       = '#10b981';
                setTimeout(() => {
                    copyBtn.style.borderColor = '';
                    copyBtn.style.color       = '';
                }, 2000);
            }).catch(() => {});
        });
    }

    const contentImages = document.querySelectorAll('.post-body img, .cs-single-figure img');
    if (contentImages.length) {
        const images          = Array.from(contentImages).map(img => img.src);
        let currentIndex      = 0;
        const lightbox        = document.getElementById('post-gallery-lightbox');
        const lightboxImg     = document.getElementById('post-lightbox-img');
        const lightboxClose   = lightbox ? lightbox.querySelector('.lightbox-close') : null;
        const lightboxPrev    = lightbox ? lightbox.querySelector('.lightbox-prev') : null;
        const lightboxNext    = lightbox ? lightbox.querySelector('.lightbox-next') : null;
        const lightboxCurrent = document.getElementById('post-lightbox-current');
        const lightboxTotal   = document.getElementById('post-lightbox-total');

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
            img.addEventListener('click', e => {
                e.preventDefault();
                openLightbox(idx);
            });
        });

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxPrev) lightboxPrev.addEventListener('click', showPrev);
        if (lightboxNext) lightboxNext.addEventListener('click', showNext);
        if (lightbox) {
            lightbox.addEventListener('click', e => {
                if (e.target === lightbox || e.target.classList.contains('lightbox-content')) closeLightbox();
            });
        }
        document.addEventListener('keydown', e => {
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
