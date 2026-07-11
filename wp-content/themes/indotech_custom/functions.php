<?php
/**
 * Indotech Custom Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('INDOTECH_VERSION', '2.0.3');
define('INDOTECH_DIR', get_template_directory());
define('INDOTECH_URI', get_template_directory_uri());

// ── Theme Setup ──────────────────────────────────────────────────────────────
function indotech_setup() {
    load_theme_textdomain('indotech', INDOTECH_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'indotech'),
        'footer'  => __('Footer Navigation', 'indotech'),
    ]);

    add_image_size('indotech-hero', 1920, 900, true);
    add_image_size('indotech-card', 600, 400, true);
    add_image_size('indotech-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'indotech_setup');

// ── Enqueue Assets ───────────────────────────────────────────────────────────
function indotech_enqueue() {
    // Google Fonts
    wp_enqueue_style(
        'indotech-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style('indotech-main', INDOTECH_URI . '/assets/css/main.css', ['indotech-fonts'], filemtime(get_template_directory() . '/assets/css/main.css'));

    // Main JS
    wp_enqueue_script('indotech-main', INDOTECH_URI . '/assets/js/main.js', [], filemtime(get_template_directory() . '/assets/js/main.js'), true);

    // Inquiry AJAX JS (depends on jQuery and indotech-main for localized object)
    wp_enqueue_script('indotech-inquiry', INDOTECH_URI . '/assets/js/inquiry-ajax.js', ['jquery', 'indotech-main'], filemtime(get_template_directory() . '/assets/js/inquiry-ajax.js'), true);

    $whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
    $wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );

    wp_localize_script('indotech-main', 'indotechData', [
        'ajaxUrl'  => admin_url('admin-ajax.php', 'relative'),
        'nonce'    => wp_create_nonce('indotech_nonce'),
        'whatsapp' => $wa_num,
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'indotech_enqueue');

// ── Register Sidebars ─────────────────────────────────────────────────────────
function indotech_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'indotech'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    register_sidebar([
        'name'          => __('Footer Widget 1', 'indotech'),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'indotech_widgets_init');

// ── Custom Post Types ─────────────────────────────────────────────────────────
function indotech_register_cpts() {
    // Testimonials
    register_post_type('testimonial', [
        'labels'      => ['name' => 'Testimonials', 'singular_name' => 'Testimonial'],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-format-quote',
        'supports'    => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'indotech_register_cpts');

// ── Helper: Get Posts ─────────────────────────────────────────────────────────
function indotech_get_posts($post_type = 'post', $count = 3, $args = []) {
    $defaults = [
        'post_type'      => $post_type,
        'posts_per_page' => $count,
        'post_status'    => 'publish',
    ];
    return new WP_Query(array_merge($defaults, $args));
}

// ── Excerpt ───────────────────────────────────────────────────────────────────
function indotech_excerpt_length($length) { return 20; }
add_filter('excerpt_length', 'indotech_excerpt_length');

function indotech_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'indotech_excerpt_more');

// ── Include Partials ──────────────────────────────────────────────────────────
require_once INDOTECH_DIR . '/inc/customizer.php';
require_once INDOTECH_DIR . '/inc/helpers.php';

// ── AJAX Product Filtering ───────────────────────────────────────────────────
add_action('wp_ajax_indotech_filter_products', 'indotech_filter_products_handler');
add_action('wp_ajax_nopriv_indotech_filter_products', 'indotech_filter_products_handler');

function indotech_filter_products_handler() {
    // Relaxed check for public read-only AJAX filtering
    check_ajax_referer('indotech_nonce', 'nonce', false);

    $brand_id = isset($_POST['brand_id']) ? sanitize_text_field($_POST['brand_id']) : '';
    $cat_slug = isset($_POST['cat_slug']) ? sanitize_text_field($_POST['cat_slug']) : '';
    $search   = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $paged    = isset($_POST['page']) ? absint($_POST['page']) : 1;

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
    ];

    if (!empty($brand_id)) {
        global $wpdb;
        $product_ids = $wpdb->get_col($wpdb->prepare("
            SELECT post_id 
            FROM {$wpdb->postmeta} 
            WHERE (meta_key = '_product_brand' AND meta_value = %s)
               OR (meta_key = '_product_brand|||0|id' AND meta_value = %d)
        ", 'post:brand:' . absint($brand_id), absint($brand_id)));
        $args['post__in'] = !empty($product_ids) ? $product_ids : [0];
    }

    if (!empty($cat_slug)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $cat_slug
            ]
        ];
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $product_query = new WP_Query($args);

    ob_start();
    if ($product_query->have_posts()) :
        while ($product_query->have_posts()) : $product_query->the_post();
            $p_id = get_the_ID();
            $sku = carbon_get_post_meta($p_id, 'product_sku');
            $brand_relation = carbon_get_post_meta($p_id, 'product_brand');
            
            $b_title = '';
            $b_accent = '#0057FF';
            if (!empty($brand_relation) && isset($brand_relation[0]['id'])) {
                $b_id = $brand_relation[0]['id'];
                $b_title = get_the_title($b_id);
                $b_accent = carbon_get_post_meta($b_id, 'brand_accent_color') ?: '#0057FF';
            }
            ?>
            <article class="brand-product-card" style="--brand-accent: <?php echo esc_attr($b_accent); ?>;">
                <div class="brand-product-card-img-wrap">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('indotech-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                    <?php else : ?>
                        <span style="font-weight:700; color: var(--text-muted); font-size: 14px;">TIDAK ADA GAMBAR</span>
                    <?php endif; ?>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column;">
                    <?php if ($sku) : ?>
                        <div class="brand-product-card-sku-wrap">
                            <span><?php echo esc_html($sku); ?></span>
                            <?php if ($b_title) : ?>
                                <span style="opacity: 0.7; font-weight: 600; text-transform: none;"><?php echo esc_html($b_title); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="brand-product-card-title"><?php the_title(); ?></h3>
                    <p class="brand-product-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                        Lihat Produk &rarr;
                    </a>
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        ?>
        <div style="grid-column: 1 / -1; background: var(--white); padding: 40px; border-radius: 12px; text-align: center; color: var(--text-muted); border: 1px solid var(--border);">
            Belum ada produk terdaftar.
        </div>
        <?php
    endif;

    $html = ob_get_clean();

    // Generate updated pagination HTML
    $total_pages = $product_query->max_num_pages;
    $pagination_html = '';
    
    if ($total_pages > 1) {
        $pagination_html .= '<nav class="product-pagination" aria-label="Navigasi halaman produk">';
        
        if ($paged > 1) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . ($paged - 1) . '" aria-label="Halaman sebelumnya">&lsaquo; Sebelumnya</a>';
        }
        
        $start = max(1, $paged - 2);
        $end   = min($total_pages, $paged + 2);
        
        if ($start > 1) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="1">1</a>';
            if ($start > 2) {
                $pagination_html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $active_class = $i === $paged ? 'active' : '';
            $aria_current = $i === $paged ? ' aria-current="page"' : '';
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn ' . $active_class . '" data-page="' . $i . '"' . $aria_current . '>' . $i . '</a>';
        }
        
        if ($end < $total_pages) {
            if ($end < $total_pages - 1) {
                $pagination_html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
            }
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . $total_pages . '">' . $total_pages . '</a>';
        }
        
        if ($paged < $total_pages) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . ($paged + 1) . '" aria-label="Halaman berikutnya">Berikutnya &rsaquo;</a>';
        }
        
        $pagination_html .= '</nav>';
        $pagination_html .= '<p class="product-pagination-info">Halaman ' . $paged . ' dari ' . $total_pages . '</p>';
    }

    wp_send_json_success([
        'html'       => $html,
        'pagination' => $pagination_html
    ]);
}

// ── AJAX Blog Post Filtering ──────────────────────────────────────────────────
add_action('wp_ajax_indotech_filter_posts', 'indotech_filter_posts_handler');
add_action('wp_ajax_nopriv_indotech_filter_posts', 'indotech_filter_posts_handler');

function indotech_filter_posts_handler() {
    // Relaxed check for public read-only AJAX filtering
    check_ajax_referer('indotech_nonce', 'nonce', false);

    $cat_slug = isset($_POST['cat_slug']) ? sanitize_text_field($_POST['cat_slug']) : '';
    $search   = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $sort_by  = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'newest';
    $paged    = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $per_page = 6;

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
    ];

    if (!empty($cat_slug)) {
        $args['category_name'] = $cat_slug;
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    switch ($sort_by) {
        case 'oldest':
            $args['orderby'] = 'date';
            $args['order']   = 'ASC';
            break;
        case 'title_asc':
            $args['orderby'] = 'title';
            $args['order']   = 'ASC';
            break;
        case 'newest':
        default:
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
            break;
    }

    $blog_query = new WP_Query($args);

    ob_start();
    if ($blog_query->have_posts()) :
        while ($blog_query->have_posts()) : $blog_query->the_post();
            $thumb     = get_the_post_thumbnail_url(null, 'medium_large');
            $post_cats = get_the_category();
            $cat_lbl   = $post_cats ? esc_html($post_cats[0]->name) : '';
            ?>
            <article class="blog-card reveal" role="listitem" id="post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>" class="blog-thumb" aria-label="Baca: <?php the_title_attribute(); ?>">
                    <?php if ($thumb) : ?>
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" class="blog-img" loading="lazy">
                    <?php else : ?>
                        <div class="blog-img-placeholder"><span class="blog-placeholder-label">Indotech</span></div>
                    <?php endif; ?>
                    <?php if ($cat_lbl) : ?>
                        <span class="blog-category"><?php echo $cat_lbl; ?></span>
                    <?php endif; ?>
                </a>
                <div class="blog-body">
                    <div class="blog-meta">
                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('d M Y'); ?></time>
                        <span class="blog-meta-sep" aria-hidden="true">·</span>
                        <span><?php the_author(); ?></span>
                    </div>
                    <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="blog-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?></p>
                    <a href="<?php the_permalink(); ?>" class="blog-read-more" aria-label="Baca selengkapnya: <?php the_title_attribute(); ?>">
                        Baca Selengkapnya →
                    </a>
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        ?>
        <div class="blog-empty reveal" style="text-align:center;padding:80px 0;grid-column:1/-1;">
            <div class="blog-empty-icon" aria-hidden="true">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:var(--border-dark);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            </div>
            <h3 style="font-size:20px;margin:20px 0 8px;">Belum ada artikel</h3>
            <p style="color:var(--text-secondary);margin-bottom:28px;">
                Coba cari dengan kata kunci atau filter kategori yang berbeda.
            </p>
            <a href="#" class="btn btn-outline reset-filters-btn">Lihat Semua Artikel</a>
        </div>
        <?php
    endif;
    $html = ob_get_clean();

    // Generate updated pagination HTML
    $total_pages = $blog_query->max_num_pages;
    $pagination_html = '';

    if ($total_pages > 1) {
        $pagination_html .= '<nav class="product-pagination" aria-label="Navigasi halaman blog">';
        
        if ($paged > 1) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . ($paged - 1) . '" aria-label="Halaman sebelumnya">&lsaquo; Sebelumnya</a>';
        }
        
        $start = max(1, $paged - 2);
        $end   = min($total_pages, $paged + 2);
        
        if ($start > 1) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="1">1</a>';
            if ($start > 2) {
                $pagination_html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $active_class = $i === $paged ? 'active' : '';
            $aria_current = $i === $paged ? ' aria-current="page"' : '';
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn ' . $active_class . '" data-page="' . $i . '"' . $aria_current . '>' . $i . '</a>';
        }
        
        if ($end < $total_pages) {
            if ($end < $total_pages - 1) {
                $pagination_html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
            }
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . $total_pages . '">' . $total_pages . '</a>';
        }
        
        if ($paged < $total_pages) {
            $pagination_html .= '<a href="#" class="page-btn ajax-page-btn" data-page="' . ($paged + 1) . '" aria-label="Halaman berikutnya">Berikutnya &rsaquo;</a>';
        }
        
        $pagination_html .= '</nav>';
        $pagination_html .= '<p class="product-pagination-info">Halaman ' . $paged . ' dari ' . $total_pages . '</p>';
    }

    wp_send_json_success([
        'html'       => $html,
        'pagination' => $pagination_html
    ]);
}


