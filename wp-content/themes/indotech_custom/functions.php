<?php
/**
 * Indotech Custom Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('INDOTECH_VERSION', '2.0.0');
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
    wp_enqueue_style('indotech-main', INDOTECH_URI . '/assets/css/main.css', ['indotech-fonts'], INDOTECH_VERSION);

    // Main JS
    wp_enqueue_script('indotech-main', INDOTECH_URI . '/assets/js/main.js', [], INDOTECH_VERSION, true);

    // Inquiry AJAX JS (depends on jQuery and indotech-main for localized object)
    wp_enqueue_script('indotech-inquiry', INDOTECH_URI . '/assets/js/inquiry-ajax.js', ['jquery', 'indotech-main'], INDOTECH_VERSION, true);

    wp_localize_script('indotech-main', 'indotechData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('indotech_nonce'),
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
    check_ajax_referer('indotech_nonce', 'nonce');

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

