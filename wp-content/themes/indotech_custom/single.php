<?php get_header(); ?>

<style>
.post-body ol,
.post-body ul {
    padding-left: 24px;
    margin-top: 10px;
    margin-bottom: 20px;
}
.post-body ol {
    list-style-type: decimal;
}
.post-body ul {
    list-style-type: disc;
}
.post-body li {
    margin-bottom: 8px;
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
        <div class="post-body" style="color: var(--text-secondary); line-height: 1.8; font-size: 15px;">
            <?php the_content(); ?>
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
