<?php
/**
 * Archive Template (Categories, Tags, Date Archives)
 * Theme: Indotech Custom
 */
get_header(); 
?>

<!-- ── Inner Hero Section ─────────────────────────────────────────── -->
<section class="inner-page-hero" id="archive-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1" style="opacity:.35;"></div>
    </div>
    <div class="container inner-page-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.65);margin-bottom:16px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.75);text-decoration:none;">Beranda</a>
            <span aria-hidden="true" style="opacity:.4;">/</span>
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" style="color:rgba(255,255,255,.75);text-decoration:none;">Blog</a>
            <span aria-hidden="true" style="opacity:.4;">/</span>
            <span aria-current="page" style="color:#93C5FD;"><?php the_archive_title(); ?></span>
        </nav>
        <span class="section-tag" style="color:rgba(255,255,255,.8);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.18);">Arsip Artikel</span>
        <h1 class="inner-page-title"><?php the_archive_title(); ?></h1>
        <?php if (get_the_archive_description()): ?>
            <div class="inner-page-subtitle" style="max-width:700px;margin-top:12px;color:rgba(255,255,255,.7);font-size:15.5px;">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<main id="main-content" class="page-content" style="padding: 72px 0 100px;">
    <div class="container">
        
        <?php if (have_posts()): ?>
            <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 28px;">
                <?php while (have_posts()): the_post(); 
                    $post_cats = get_the_category();
                    $cat_lbl   = $post_cats ? esc_html($post_cats[0]->name) : '';
                    $words     = str_word_count(strip_tags(get_the_content()));
                    $reading_time = max(1, ceil($words / 200));
                ?>
                <article <?php post_class('blog-card'); ?> style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                    <a href="<?php the_permalink(); ?>" class="blog-thumb" style="height: 190px; position: relative; overflow: hidden; display: block; background: #F1F5F9;">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('indotech-card', [
                                'class' => 'blog-img',
                                'style' => 'width:100%;height:100%;object-fit:cover;'
                            ]); ?>
                        <?php else: ?>
                            <div class="blog-img-placeholder" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E2E8F0;color:#64748B;">
                                <span class="blog-placeholder-label">Indotech Blog</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($cat_lbl): ?>
                            <span class="blog-category" style="position: absolute; top: 12px; left: 12px; background: #0057FF; color: #FFFFFF; font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.05em; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <?php echo $cat_lbl; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="blog-body" style="padding: 22px; display: flex; flex-direction: column; flex: 1;">
                        <div class="blog-meta" style="font-size: 12px; color: #64748B; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
                            <span class="blog-meta-sep" aria-hidden="true">·</span>
                            <span><?php the_author(); ?></span>
                            <span class="blog-meta-sep" aria-hidden="true">·</span>
                            <span style="display:inline-flex; align-items:center; gap:3px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <?php echo $reading_time; ?> mnt baca
                            </span>
                        </div>
                        <h2 class="blog-title" style="font-size: 17px; font-weight: 700; line-height: 1.35; margin-bottom: 8px; color: #0F172A;">
                            <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                        </h2>
                        <p class="blog-excerpt" style="font-size: 13.5px; color: #475569; line-height: 1.55; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
                        </p>
                        <a href="<?php the_permalink(); ?>" class="blog-read-more" style="margin-top: auto; font-size: 12.5px; font-weight: 700; color: #0057FF; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            Baca Selengkapnya
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div style="margin-top: 56px; text-align: center;">
                <?php the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← Sebelumnya',
                    'next_text' => 'Selanjutnya →',
                ]); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 80px 0;">
                <h3 style="font-size: 22px; margin-bottom: 12px; color: #0F172A;">Tidak ada artikel ditemukan</h3>
                <p style="color: #64748B; margin-bottom: 24px;">Belum ada artikel yang dipublikasikan dalam kategori atau arsip ini.</p>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                    Kembali ke Semua Artikel
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
