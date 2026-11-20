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
    register_nav_menus([
        'primary' => __('Primary Navigation', 'indotech'),
        'footer'  => __('Footer Navigation', 'indotech'),
    ]);

    add_image_size('indotech-hero', 1920, 900, true);
    add_image_size('indotech-card', 600, 400, true);
    add_image_size('indotech-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'indotech_setup');

/**
 * Menentukan apakah halaman saat ini menggunakan sistem desain editorial Indotech–Manufy
 * (Beranda, halaman statis, arsip, single CPT/post, pencarian, dan 404 — tidak termasuk pricelist).
 */
function indotech_is_manufy_page() {
    if (
        is_page_template( [ 'page-pricelist.php', 'page-daftar-harga.php', 'page-price-list.php' ] ) ||
        is_page( [ 'daftar-harga', 'price-list', 'pricelist' ] )
    ) {
        return false;
    }
    return true;
}

// ── Enqueue Assets ───────────────────────────────────────────────────────────
function indotech_enqueue() {
    // Main stylesheet
    wp_enqueue_style('indotech-main', INDOTECH_URI . '/assets/css/main.css', [], filemtime(get_template_directory() . '/assets/css/main.css'));

    if ( indotech_is_manufy_page() ) {
        $company_css = 'assets/css/company-home.css';
        wp_enqueue_style( 'indotech-company-home', get_theme_file_uri( $company_css ), [ 'indotech-main' ], filemtime( get_theme_file_path( $company_css ) ) );

        $gsap_ver = '3.13.0';
        wp_enqueue_script( 'indotech-gsap', get_theme_file_uri( 'assets/js/lib/gsap.min.js' ), [], $gsap_ver, true );
        wp_enqueue_script( 'indotech-gsap-scrolltrigger', get_theme_file_uri( 'assets/js/lib/ScrollTrigger.min.js' ), [ 'indotech-gsap' ], $gsap_ver, true );
        wp_enqueue_script( 'indotech-gsap-scrollto', get_theme_file_uri( 'assets/js/lib/ScrollToPlugin.min.js' ), [ 'indotech-gsap' ], $gsap_ver, true );

        if ( is_front_page() ) {
            wp_enqueue_script( 'indotech-gsap-flip', get_theme_file_uri( 'assets/js/lib/Flip.min.js' ), [ 'indotech-gsap' ], $gsap_ver, true );

            $company_js = 'assets/js/company-home.js';
            wp_enqueue_script(
                'indotech-company-home-js',
                get_theme_file_uri( $company_js ),
                [ 'indotech-gsap', 'indotech-gsap-scrolltrigger', 'indotech-gsap-flip', 'indotech-gsap-scrollto' ],
                filemtime( get_theme_file_path( $company_js ) ),
                true
            );
        } else {
            $static_css = 'assets/css/company-static.css';
            wp_enqueue_style( 'indotech-company-static', get_theme_file_uri( $static_css ), [ 'indotech-company-home' ], filemtime( get_theme_file_path( $static_css ) ) );

            $editorial_css = 'assets/css/company-editorial.css';
            wp_enqueue_style( 'indotech-company-editorial', get_theme_file_uri( $editorial_css ), [ 'indotech-company-static' ], filemtime( get_theme_file_path( $editorial_css ) ) );

            $static_js = 'assets/js/company-static.js';
            wp_enqueue_script(
                'indotech-company-static-js',
                get_theme_file_uri( $static_js ),
                [ 'indotech-gsap', 'indotech-gsap-scrolltrigger', 'indotech-gsap-scrollto' ],
                filemtime( get_theme_file_path( $static_js ) ),
                true
            );
        }
    }

    // Main JS
    wp_enqueue_script('indotech-main', INDOTECH_URI . '/assets/js/main.js', [], filemtime(get_template_directory() . '/assets/js/main.js'), true);

    // Inquiry AJAX JS — Enqueue only on pages with inquiry/contact forms
    if (is_page(['kontak', 'kemitraan']) || is_singular(['product', 'brand'])) {
        wp_enqueue_script('indotech-inquiry', INDOTECH_URI . '/assets/js/inquiry-ajax.js', ['jquery', 'indotech-main'], filemtime(get_template_directory() . '/assets/js/inquiry-ajax.js'), true);
    }

    $whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
    $wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );

    wp_localize_script('indotech-main', 'indotechData', [
        'ajaxUrl'  => admin_url('admin-ajax.php', 'relative'),
        'nonce'    => wp_create_nonce('indotech_nonce'),
        'whatsapp' => $wa_num,
    ]);

    // Lacak semua klik tombol WhatsApp → kirim event GA4 (via Google Site Kit).
    // Satu delegated listener menangkap SEMUA link wa.me di seluruh situs
    // (header, footer, floating, hero, produk, FAQ). Tandai `whatsapp_click`
    // sebagai Key Event di GA4 untuk mengukur lead.
    $wa_tracker = <<<'JS'
(function () {
  document.addEventListener('click', function (e) {
    var a = e.target.closest(
      'a[href*="wa.me"], a[href*="api.whatsapp.com"], a[href*="whatsapp://"], a[href^="https://web.whatsapp.com"]'
    );
    if (!a) return;

    var href   = a.href || '';
    var label  = (a.getAttribute('aria-label') || a.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 80);
    var numMatch = href.match(/(?:wa\.me\/|phone=|send\?phone=)(\d+)/);
    var waNumber = numMatch ? numMatch[1] : '';

    var payload = {
      link_url:      href,
      link_text:     label,
      wa_number:     waNumber,
      page_location: window.location.href
    };

    if (typeof window.gtag === 'function') {
      window.gtag('event', 'whatsapp_click', payload);
    } else if (Array.isArray(window.dataLayer)) {
      window.dataLayer.push(Object.assign({ event: 'whatsapp_click' }, payload));
    }
  }, true);
})();
JS;
    wp_add_inline_script('indotech-main', $wa_tracker);

    // Dequeue comment-reply since comments are not used on theme single templates
    wp_dequeue_script('comment-reply');

    // Conditionally dequeue WooCommerce styles & scripts on non-shop pages
    if (class_exists('WooCommerce') && !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_singular('product')) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_style('woocommerce_frontend_styles');
        wp_dequeue_style('wc-blocks-vendors-style');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'indotech_enqueue', 99);

// ── Disable WordPress Emojis ──────────────────────────────────────────────────
add_action('init', function() {
    if (is_admin()) return;
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', function($plugins) {
        return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
    });
    add_filter('wp_resource_hints', function($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $emoji_svg_url = 'https://s.w.org/images/core/emoji/';
            foreach ($urls as $key => $url) {
                if (is_string($url) && strpos($url, $emoji_svg_url) !== false) {
                    unset($urls[$key]);
                }
            }
        }
        return $urls;
    }, 10, 2);
});

// ── Disable Language Switcher on wp-login.php ────────────────────────────────
// Mencegah WordPress memanggil translations_api() ke wordpress.org di halaman login
add_filter('login_display_language_dropdown', '__return_false');

// ── Defer Non-Critical JavaScript & Remove jQuery Migrate ────────────────────
add_filter('script_loader_tag', function($tag, $handle) {
    if (is_admin()) return $tag;
    if (in_array($handle, ['indotech-main', 'indotech-inquiry', 'indotech-gsap', 'indotech-gsap-scrolltrigger', 'indotech-gsap-flip', 'indotech-gsap-scrollto', 'indotech-company-home-js', 'indotech-company-static-js', 'google_gtagjs-js'], true)) {
        return str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);

add_action('wp_default_scripts', function($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
});

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
require_once INDOTECH_DIR . '/inc/seo.php';

// ── Fix: Prevent WordPress 404 on static page pagination ─────────────────────
// WordPress's main query on a static "Page" does not support the `paged` param,
// so navigating to /blog/?paged=2 causes a 404. These hooks prevent that for
// pages that use custom WP_Query pagination (Blog, Products, Downloads, etc.).
add_filter('pre_handle_404', function ($preempt, $wp_query) {
    if (is_page() && (get_query_var('paged') > 1 || isset($_GET['paged']))) {
        // Tell WordPress this is NOT a 404
        $wp_query->is_404 = false;
        status_header(200);
        return true;  // preempt the 404 handling
    }
    return $preempt;
}, 10, 2);

add_filter('redirect_canonical', function ($redirect_url, $requested_url) {
    if (is_page() && (get_query_var('paged') > 1 || isset($_GET['paged']))) {
        return false; // don't redirect — let the page template handle it
    }
    return $redirect_url;
}, 10, 2);

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
            $p_id           = get_the_ID();
            $brand_relation = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($p_id, 'product_brand') : [];
            $brand_fallback = (!empty($brand_relation) && isset($brand_relation[0]['id'])) ? get_the_title($brand_relation[0]['id']) : 'Indotech';
            $img_html       = has_post_thumbnail()
                ? get_the_post_thumbnail($p_id, 'indotech-thumb', [
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'sizes'    => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 410px',
                ])
                : '';
            $desc = wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 14, '...');
            get_template_part('template-parts/archive/editorial-item', null, [
                'url'            => get_permalink($p_id),
                'title'          => get_the_title($p_id),
                'desc'           => $desc,
                'image_html'     => $img_html,
                'fallback_label' => $brand_fallback,
                'media_variant'  => 'product',
                'heading_tag'    => 'h2',
                'post_id'        => $p_id,
            ]);
        endwhile;
        wp_reset_postdata();
    else :
        ?>
        <div class="cs-empty-panel">
            <h3>Belum ada produk terdaftar</h3>
            <p>Coba kata kunci pencarian lain atau pilih kembali seluruh kategori produk.</p>
        </div>
        <?php
    endif;

    $html = ob_get_clean();

    // Generate updated pagination HTML using router URL helper
    $total_pages = $product_query->max_num_pages;
    $base_url    = isset($_POST['current_url']) ? esc_url_raw($_POST['current_url']) : home_url('/produk/');
    $base_url    = strtok($base_url, '?');

    $query_params = [];
    if (!empty($cat_slug)) $query_params['kategori'] = $cat_slug;
    if (!empty($search))   $query_params['s'] = $search;

    $pagination_html = indotech_get_pagination_html($paged, $total_pages, $base_url, $query_params, 'Navigasi halaman produk');

    wp_send_json_success([
        'html'       => $html,
        'pagination' => $pagination_html
    ]);
}

// ── Helper Function for Clean Pagination HTML with Router URLs ─────────────────
function indotech_get_pagination_html($paged, $total_pages, $base_url, $query_params = [], $aria_label = 'Navigasi halaman') {
    if ($total_pages <= 1) return '';

    $html = '<nav class="product-pagination" aria-label="' . esc_attr($aria_label) . '">';

    $build_url = function($page_num) use ($base_url, $query_params) {
        $params = $query_params;
        if ($page_num > 1) {
            $params['paged'] = $page_num;
        } else {
            unset($params['paged']);
        }
        $filtered_params = array_filter($params, function($v) { return $v !== '' && $v !== null; });
        return add_query_arg($filtered_params, $base_url);
    };

    if ($paged > 1) {
        $html .= '<a href="' . esc_url($build_url($paged - 1)) . '" class="page-btn ajax-page-btn" data-page="' . ($paged - 1) . '" aria-label="Halaman sebelumnya">&lsaquo; Sebelumnya</a>';
    }

    $start = max(1, $paged - 2);
    $end   = min($total_pages, $paged + 2);

    if ($start > 1) {
        $html .= '<a href="' . esc_url($build_url(1)) . '" class="page-btn ajax-page-btn" data-page="1">1</a>';
        if ($start > 2) {
            $html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        $active_class = $i === $paged ? 'active' : '';
        $aria_current = $i === $paged ? ' aria-current="page"' : '';
        $html .= '<a href="' . esc_url($build_url($i)) . '" class="page-btn ajax-page-btn ' . $active_class . '" data-page="' . $i . '"' . $aria_current . '>' . $i . '</a>';
    }

    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $html .= '<span class="page-btn" style="border:none;background:none;pointer-events:none;">…</span>';
        }
        $html .= '<a href="' . esc_url($build_url($total_pages)) . '" class="page-btn ajax-page-btn" data-page="' . $total_pages . '">' . $total_pages . '</a>';
    }

    if ($paged < $total_pages) {
        $html .= '<a href="' . esc_url($build_url($paged + 1)) . '" class="page-btn ajax-page-btn" data-page="' . ($paged + 1) . '" aria-label="Halaman berikutnya">Berikutnya &rsaquo;</a>';
    }

    $html .= '</nav>';
    $html .= '<p class="product-pagination-info">Halaman ' . $paged . ' dari ' . $total_pages . '</p>';

    return $html;
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
            $p_id     = get_the_ID();
            $img_html = has_post_thumbnail()
                ? wp_get_attachment_image(get_post_thumbnail_id(), 'indotech-card', false, [
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'sizes'    => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 410px',
                ])
                : '';
            $desc = wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 16, '...');
            get_template_part('template-parts/archive/editorial-item', null, [
                'url'            => get_permalink($p_id),
                'title'          => get_the_title($p_id),
                'desc'           => $desc,
                'image_html'     => $img_html,
                'fallback_label' => 'Indotech Journal',
                'media_variant'  => 'wide',
                'heading_tag'    => 'h3',
                'post_id'        => $p_id,
                'role_listitem'  => true,
            ]);
        endwhile;
        wp_reset_postdata();
    else :
        ?>
        <div class="blog-empty cs-empty-panel">
            <h3>Belum ada artikel</h3>
            <p>Coba cari dengan kata kunci atau filter kategori yang berbeda.</p>
            <a href="#" class="ch-pill-cta reset-filters-btn">
                <span>Lihat Semua Artikel</span>
            </a>
        </div>
        <?php
    endif;
    $html = ob_get_clean();

    // Generate updated pagination HTML using router URL helper
    $total_pages = $blog_query->max_num_pages;
    $base_url    = isset($_POST['current_url']) ? esc_url_raw($_POST['current_url']) : home_url('/blog/');
    $base_url    = strtok($base_url, '?');

    $query_params = [];
    if (!empty($cat_slug))          $query_params['kategori'] = $cat_slug;
    if (!empty($search))            $query_params['s'] = $search;
    if (!empty($sort_by) && $sort_by !== 'newest') $query_params['sort_by'] = $sort_by;

    $pagination_html = indotech_get_pagination_html($paged, $total_pages, $base_url, $query_params, 'Navigasi halaman blog');

    wp_send_json_success([
        'html'       => $html,
        'pagination' => $pagination_html
    ]);
}


