<?php
/**
 * Depocleanique Custom — inc/helpers.php
 *
 * Helper functions untuk mengambil data global theme.
 * Semua nilai diambil dari WordPress Customizer (theme_mod) dengan fallback yang aman.
 *
 * Cara ubah nilai: Appearance → Customize → Depo Cleanique
 *
 * Cara pakai di template:
 *   echo esc_url( dc_get_wa_url( 'hero' ) );
 *   echo esc_html( dc_get_email() );
 *   echo dc_get_address_html(); // sudah di-escape, langsung echo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ─── WhatsApp ───────────────────────────────────────── */

/**
 * Nomor WhatsApp mentah (tanpa + atau spasi).
 * Diambil dari Customizer. Fallback: '6285600061005'.
 *
 * @return string
 */
function dc_get_wa_number() {
    return get_theme_mod( 'dc_wa_number', '6285600061005' );
}

/**
 * Label tampil nomor WA — teks yang ditampilkan ke pengunjung.
 *
 * @return string
 */
function dc_get_wa_label() {
    return get_theme_mod( 'dc_wa_label', '0856-0006-1005' );
}

/**
 * URL WhatsApp lengkap dengan pesan pre-filled berdasarkan konteks.
 *
 * Konteks yang tersedia:
 *   'header', 'hero', 'pricing', 'partnership',
 *   'cta', 'contact', 'floating', 'about', 'faq', 'default'
 *
 * @param string $context  Kode konteks untuk memilih pesan default.
 * @param string $custom   Pesan kustom — override konteks jika diisi.
 * @return string
 */
function dc_get_wa_url( $context = 'default', $custom = '' ) {
    $number = dc_get_wa_number();

    if ( $custom ) {
        $message = $custom;
    } else {
        $messages = [
            'header'      => 'Halo Depo Cleanique! Saya ingin konsultasi mengenai produk dan kemitraan.',
            'hero'        => 'Halo Depo Cleanique! Saya ingin konsultasi kemitraan.',
            'pricing'     => 'Halo! Saya tertarik dengan paket kemitraan Depo Cleanique.',
            'partnership' => 'Halo! Saya ingin mendaftar sebagai mitra Depo Cleanique.',
            'cta'         => 'Halo Depo Cleanique! Saya siap bergabung sebagai mitra.',
            'contact'     => 'Halo Depo Cleanique! Saya ingin berkonsultasi.',
            'floating'    => 'Halo Depo Cleanique! Saya ingin bertanya mengenai produk dan kemitraan.',
            'footer'      => 'Halo Depo Cleanique! Saya ingin bertanya lebih lanjut.',
            'about'       => 'Halo Depo Cleanique! Saya ingin mengenal lebih jauh tentang peluang kemitraan.',
            'faq'         => 'Halo Depo Cleanique! Saya punya pertanyaan.',
            'default'     => 'Halo Depo Cleanique!',
        ];
        $message = isset( $messages[ $context ] ) ? $messages[ $context ] : $messages['default'];
    }

    return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}


/* ─── Kontak ─────────────────────────────────────────── */

/**
 * Email bisnis.
 *
 * @return string
 */
function dc_get_email() {
    return get_theme_mod( 'dc_email', 'hello@depocleanique.com' );
}

/**
 * Alamat lengkap dalam format plain text (bisa multiline dengan \n).
 *
 * @return string
 */
function dc_get_address() {
    return get_theme_mod(
        'dc_address',
        "Jongke Tengah No. 30 RT.01/RW.23\nMlati, Sleman\nYogyakarta 55285\nIndonesia"
    );
}

/**
 * Alamat dalam format HTML — baris baru dikonversi ke <br>.
 * Sudah di-escape dengan esc_html(), aman untuk langsung di-echo.
 *
 * @return string HTML
 */
function dc_get_address_html() {
    return nl2br( esc_html( dc_get_address() ) );
}

/**
 * Jam operasional bisnis.
 *
 * @return string
 */
function dc_get_business_hours() {
    return get_theme_mod( 'dc_business_hours', 'Senin – Sabtu, 08.00 – 21.00 WIB' );
}


/* ─── Media Sosial ───────────────────────────────────── */

/**
 * URL media sosial berdasarkan nama platform.
 *
 * Platform yang didukung: 'instagram', 'facebook', 'tiktok'
 * Mengembalikan '#' jika belum diisi di Customizer.
 *
 * @param string $platform
 * @return string URL
 */
function dc_get_social_url( $platform ) {
    return get_theme_mod( 'dc_social_' . $platform, '#' );
}

/* ─── Icon System ────────────────────────────────────── */

if ( ! function_exists( 'dc_icon' ) ) {
    /**
     * Render icon SVG line/outline yang konsisten (reusable).
     *
     * ATURAN GLOBAL: jangan pernah memakai emoji/system icon sebagai UI.
     * Selalu gunakan dc_icon() agar ukuran, stroke, warna
     * (currentColor → token tema), dan alignment seragam.
     *
     * @param string $name  Nama icon, mis. 'search', 'check-circle', 'award'.
     * @param string $class Class tambahan untuk <svg>.
     * @return string HTML SVG, atau '' bila nama tidak dikenal.
     */
    function dc_icon( $name, $class = '' ) {
        $icons = [
            'arrow-right'   => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
            'arrow-left'    => '<path d="M19 12H5"/><path d="m11 18-6-6 6-6"/>',
            'calendar'      => '<path d="M8 2v4"/><path d="M16 2v4"/><path d="M3 10h18"/><rect width="18" height="18" x="3" y="4" rx="2"/>',
            'clock'         => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
            'facebook'      => '<path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v6h4v-6h3l1-4h-4V9c0-.6.4-1 1-1Z"/>',
            'mail'          => '<rect width="18" height="14" x="3" y="5" rx="2"/><path d="m3 7 9 6 9-6"/>',
            'search'        => '<circle cx="11" cy="11" r="7"/><path d="m16 16 4 4"/>',
            'share'         => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.6 10.7 6.8-4.4"/><path d="m8.6 13.3 6.8 4.4"/>',
            'tag'           => '<path d="M20.6 13.4 13.5 20.5a2 2 0 0 1-2.8 0L3 12.8V3h9.8l7.8 7.8a2 2 0 0 1 0 2.6Z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
            'user'          => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
            'users'         => '<path d="M16 21a6 6 0 0 0-12 0"/><circle cx="10" cy="8" r="4"/><path d="M22 21a5 5 0 0 0-5-5"/><path d="M17 4a4 4 0 0 1 0 8"/>',
            'whatsapp'      => '<path d="M4 20.5 5.3 16A8 8 0 1 1 8 18.7L4 20.5Z"/><path d="M9.5 8.8c.2 3 2.1 4.9 5.1 5.7l1.2-1.4c.2-.3.1-.7-.2-.9l-1.4-.8c-.3-.2-.6-.1-.8.1l-.5.6c-.9-.4-1.7-1.1-2.2-2l.6-.5c.2-.2.3-.6.1-.8l-.8-1.4c-.2-.3-.6-.4-.9-.2L9.5 8.8Z"/>',
            'x'             => '<path d="M4 4l16 16"/><path d="M20 4 4 20"/>',
            // Icon UI tambahan.
            'award'         => '<circle cx="12" cy="8" r="5"/><path d="M8.2 12.3 7 21l5-3 5 3-1.2-8.7"/>',
            'check-circle'  => '<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/>',
            'check'         => '<path d="M4 12.5 9 17.5 20 6.5"/>',
            'scale'         => '<path d="M12 3v18"/><path d="M7 7h10"/><path d="M5 21h14"/><path d="m7 7-3 6a3 3 0 0 0 6 0L7 7Z"/><path d="m17 7-3 6a3 3 0 0 0 6 0l-3-6Z"/>',
            'star'          => '<path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.9 6.8 19.6l1-5.8-4.3-4.1 5.9-.9L12 3.5Z"/>',
            'message-circle'=> '<path d="M21 11.5a8 8 0 0 1-11.5 7.2L3 21l2.3-6.5A8 8 0 1 1 21 11.5Z"/>',
            'package'       => '<path d="M21 8 12 3 3 8v8l9 5 9-5V8Z"/><path d="m3 8 9 5 9-5"/><path d="M12 13v8"/>',
            'handshake'     => '<path d="m11 17 2 2a2.1 2.1 0 0 0 3-3l-3-3"/><path d="m14 14 3 3a2.1 2.1 0 0 0 3-3l-4.5-4.5a3 3 0 0 0-4.2 0L10 10.8a2 2 0 1 1-2.8-2.8l2.1-2.1a4 4 0 0 1 5.7 0l1 1"/><path d="m7 12 4 4"/><path d="m2 7 3-3 5 5-3 3-5-5Z"/><path d="m22 7-3-3-5 5 3 3 5-5Z"/>',
            'store'         => '<path d="M4 10h16"/><path d="M5 10l1-6h12l1 6"/><path d="M6 10v10h12V10"/><path d="M9 20v-6h6v6"/>',
            'chart'         => '<path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16v-5"/><path d="M12 16V8"/><path d="M16 16v-9"/>',
            'shield'        => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-5"/>',
            'shopping-cart' => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h2l2.4 12.4a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L21 7H5"/>',
            'map-pin'       => '<path d="M12 21s7-6.3 7-11a7 7 0 0 0-14 0c0 4.7 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
            'phone'         => '<path d="M5 3h3l2 5-2.5 1.5a12 12 0 0 0 5 5L19 11l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 3 5.2 2 2 0 0 1 5 3Z"/>',
            'rocket'        => '<path d="M5 14c-1.5.5-3 2-3 5 3 0 4.5-1.5 5-3"/><path d="M9 13a18 18 0 0 1 8-9 11 11 0 0 1 4 0 11 11 0 0 1 0 4 18 18 0 0 1-9 8l-3-3Z"/><circle cx="15" cy="9" r="1.5"/>',
            'menu'          => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
        ];

        if ( ! isset( $icons[ $name ] ) ) {
            return '';
        }

        return sprintf(
            '<svg class="dc-icon %s" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">%s</svg>',
            esc_attr( $class ),
            $icons[ $name ]
        );
    }
}


/* ─── Artikel / Blog Helpers ─────────────────────────── */

function dc_article_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) );
    $words   = preg_split( '/\s+/u', trim( $content ), -1, PREG_SPLIT_NO_EMPTY );
    $minutes = max( 1, (int) ceil( count( $words ) / 200 ) );

    return sprintf(
        _n( '%s menit baca', '%s menit baca', $minutes, 'depocleanique-custom' ),
        number_format_i18n( $minutes )
    );
}

function dc_article_category_badge( $post_id = null ) {
    $post_id    = $post_id ?: get_the_ID();
    $categories = get_the_category( $post_id );

    if ( empty( $categories ) ) {
        return '';
    }

    $category = $categories[0];

    return sprintf(
        '<a class="article-category-badge" href="%s">%s</a>',
        esc_url( get_category_link( $category ) ),
        esc_html( $category->name )
    );
}

function dc_get_archive_title() {
    if ( is_category() ) {
        return sprintf(
            /* translators: %s: category name */
            __( 'Kategori: %s', 'depocleanique-custom' ),
            single_cat_title( '', false )
        );
    }

    if ( is_tag() ) {
        return sprintf(
            /* translators: %s: tag name */
            __( 'Tag: %s', 'depocleanique-custom' ),
            single_tag_title( '', false )
        );
    }

    if ( is_author() ) {
        return sprintf(
            /* translators: %s: author display name */
            __( 'Artikel oleh: %s', 'depocleanique-custom' ),
            get_the_author_meta( 'display_name', get_queried_object_id() )
        );
    }

    if ( is_year() ) {
        return sprintf(
            /* translators: %s: year */
            __( 'Arsip tahun %s', 'depocleanique-custom' ),
            get_the_date( 'Y' )
        );
    }

    if ( is_month() ) {
        return sprintf(
            /* translators: %s: month and year */
            __( 'Arsip bulan %s', 'depocleanique-custom' ),
            get_the_date( 'F Y' )
        );
    }

    if ( is_day() ) {
        return sprintf(
            /* translators: %s: date */
            __( 'Arsip tanggal %s', 'depocleanique-custom' ),
            get_the_date( 'j F Y' )
        );
    }

    return __( 'Arsip Artikel', 'depocleanique-custom' );
}

function dc_get_archive_description() {
    $description = get_the_archive_description();

    if ( '' !== trim( wp_strip_all_tags( $description ) ) ) {
        return $description;
    }

    return __( 'Temukan panduan, tips, dan insight terbaru seputar produk homecare, laundry, kebersihan rumah, dan peluang usaha bersama Depo Cleanique.', 'depocleanique-custom' );
}

function dc_article_thumbnail( $post_id = null, $size = 'large', $class = '' ) {
    $post_id = $post_id ?: get_the_ID();

    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail(
            $post_id,
            $size,
            [
                'class'   => trim( 'article-image ' . $class ),
                'loading' => 'lazy',
            ]
        );
    }

    return '<div class="article-image article-image-fallback ' . esc_attr( $class ) . '" aria-hidden="true">'
        . '<span>Depo Cleanique</span>'
        . '</div>';
}

function dc_get_related_posts( $post_id = null, $count = 3 ) {
    $post_id      = $post_id ?: get_the_ID();
    $category_ids = wp_get_post_categories( $post_id );
    $tag_ids      = wp_get_post_tags( $post_id, [ 'fields' => 'ids' ] );

    $args = [
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'post__not_in'        => [ $post_id ],
        'ignore_sticky_posts' => true,
    ];

    if ( ! empty( $tag_ids ) ) {
        $args['tag__in'] = $tag_ids;
    } elseif ( ! empty( $category_ids ) ) {
        $args['category__in'] = $category_ids;
    }

    return new WP_Query( $args );
}

function dc_article_prepare_content( $content ) {
    $used = [];

    return preg_replace_callback(
        '/<h([2-3])([^>]*)>(.*?)<\/h\1>/is',
        static function ( $matches ) use ( &$used ) {
            if ( preg_match( '/\sid=(["\'])(.*?)\1/i', $matches[2] ) ) {
                return $matches[0];
            }

            $text = wp_strip_all_tags( $matches[3] );
            $slug = sanitize_title( $text );

            if ( '' === $slug ) {
                $slug = 'section';
            }

            $base = $slug;
            $i    = 2;

            while ( isset( $used[ $slug ] ) ) {
                $slug = $base . '-' . $i;
                $i++;
            }

            $used[ $slug ] = true;

            return sprintf(
                '<h%s id="%s"%s>%s</h%s>',
                $matches[1],
                esc_attr( $slug ),
                $matches[2],
                $matches[3],
                $matches[1]
            );
        },
        $content
    );
}

function dc_article_toc( $content ) {
    if ( ! preg_match_all( '/<h([2-3])[^>]*\sid=(["\'])(.*?)\2[^>]*>(.*?)<\/h\1>/is', $content, $matches, PREG_SET_ORDER ) ) {
        return '';
    }

    $items = '';

    foreach ( $matches as $heading ) {
        $items .= sprintf(
            '<a class="article-toc-link article-toc-level-%1$s" href="#%2$s">%3$s</a>',
            esc_attr( $heading[1] ),
            esc_attr( $heading[3] ),
            esc_html( wp_strip_all_tags( $heading[4] ) )
        );
    }

    return '<nav class="article-toc" aria-label="' . esc_attr__( 'Daftar isi artikel', 'depocleanique-custom' ) . '">'
        . '<h2>' . esc_html__( 'Daftar isi', 'depocleanique-custom' ) . '</h2>'
        . $items
        . '</nav>';
}
