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

<?php while (have_posts()): the_post(); ?>
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
        <div class="blog-meta" style="color:rgba(255,255,255,.7); margin-bottom:12px; display:flex; align-items:center; gap:8px; font-size:12px;">
            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
            <span class="blog-meta-sep" aria-hidden="true">·</span>
            <span><?php the_author(); ?></span>
        </div>
        <h1 class="inner-page-title" style="font-size: clamp(24px, 3.5vw, 44px); line-height: 1.25;"><?php the_title(); ?></h1>
    </div>
</section>

<main id="main-content" class="page-content" style="padding: 60px 0;">
    <div class="container" style="max-width:760px; padding: 0 16px;">
        <?php if (has_post_thumbnail()): ?>
            <figure class="post-featured-img" style="margin-bottom:40px;border-radius:12px;overflow:hidden;">
                <?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto;object-fit:cover;']); ?>
            </figure>
        <?php endif; ?>
        <div class="post-body">
            <?php the_content(); ?>
        </div>

        <!-- Editorial Verification & Approval Card -->
        <div class="article-approval-card" style="background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%); border: 1px solid #E2E8F0; border-radius: 12px; padding: 22px 26px; margin-top: 40px; margin-bottom: 24px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);">
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

    </div>
</main>

<?php
// Related Blog Query
$categories = get_the_category();
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

    const contentImages = document.querySelectorAll('.post-body img, .post-featured-img img');

    if (!contentImages.length) return;

    const images = Array.from(contentImages).map(img => {
        // Fallback to src if thumbnail/srcset path is used
        return img.src;
    });

    let currentIndex = 0;

    // Lightbox Modal selectors
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

    // Hide prev/next buttons if only 1 image exists
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

    // Attach click events to post body images
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

    // Close on clicking overlay (outside content image)
    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });
    }

    // Keyboard navigation
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
