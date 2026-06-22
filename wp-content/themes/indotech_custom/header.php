<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner container">

        <!-- ═══ LOGO ═══════════════════════════════════════════════════ -->
        <div class="site-logo">
            <?php if ( has_custom_logo() ): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="logo-img-link" aria-label="PT Indotech Berkah Abadi - Beranda">
                    <?php
                    /*
                     * TODO: Ganti <img> di bawah ini dengan logo resmi Indotech ketika file
                     *       /assets/images/logo.png sudah tersedia.
                     *       Ukuran yang disarankan: 180×52 px, format PNG dengan background transparan.
                     */
                    $logo_path = get_template_directory() . '/assets/images/logo.png';
                    if ( file_exists( $logo_path ) ):
                    ?>
                        <img
                            src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>"
                            alt="PT Indotech Berkah Abadi"
                            class="site-logo-img"
                            width="180"
                            height="52"
                            loading="eager"
                        >
                    <?php else: ?>
                        <!-- PLACEHOLDER: Logo Indotech belum tersedia — menampilkan wordmark teks -->
                        <span class="logo-text" aria-label="PT Indotech Berkah Abadi">
                            <span class="logo-indo">Indo</span><span class="logo-tech">tech</span>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- ═══ NAVIGATION ══════════════════════════════════════════════ -->
        <nav class="primary-nav" id="primary-nav" aria-label="Navigasi Utama">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => function() {
                    $items = [
                        '/'             => 'Beranda',
                        '/tentang-kami' => 'Tentang Kami',
                        '/produk'       => 'Produk',
                        '/kemitraan'    => 'Kemitraan',
                        '/blog'         => 'Blog',
                        '/kontak'       => 'Kontak',
                    ];
                    echo '<ul class="nav-menu">';
                    foreach ( $items as $path => $label ) {
                        $url    = esc_url( home_url( $path ) );
                        $active = ( untrailingslashit( $_SERVER['REQUEST_URI'] ) === $path ) ? ' class="current-menu-item"' : '';
                        echo "<li{$active}><a href=\"{$url}\">{$label}</a></li>";
                    }
                    echo '</ul>';
                },
            ]); ?>

            <div class="mobile-nav-extra">
                <div class="mobile-nav-divider"></div>
                <div class="mobile-nav-contact">
                    <span class="mn-label">Hubungi Kami</span>
                    <a href="tel:<?php echo esc_attr( preg_replace('/[\s\-]/', '', indotech_opt('phone', '+62 812-3456-7890')) ); ?>" class="mn-link">
                        <?php echo esc_html( indotech_opt('phone', '+62 812-3456-7890') ); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr( indotech_opt('email', 'info@indotech.id') ); ?>" class="mn-link">
                        <?php echo esc_html( indotech_opt('email', 'info@indotech.id') ); ?>
                    </a>
                </div>
                <div class="mobile-nav-social">
                    <a href="#" class="mn-social-link" aria-label="Instagram">IG</a>
                    <a href="#" class="mn-social-link" aria-label="Facebook">FB</a>
                    <a href="https://wa.me/<?php echo esc_attr( preg_replace('/[^0-9]/', '', indotech_opt('whatsapp', '6281234567890')) ); ?>" class="mn-social-link" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>
                </div>
            </div>
        </nav>

        <!-- ═══ ACTIONS ═════════════════════════════════════════════════ -->
        <div class="header-actions">

            <!-- WhatsApp pill link — teks saja, tanpa ikon -->
            <a href="https://wa.me/<?php echo esc_attr( preg_replace('/[^0-9]/', '', indotech_opt('whatsapp', '6281234567890')) ); ?>"
               class="header-wa-link"
               target="_blank"
               rel="noopener"
               aria-label="Chat via WhatsApp">
                <span>WhatsApp</span>
            </a>

            <a href="<?php echo esc_url( home_url('/kontak') ); ?>" class="btn btn-primary">
                Hubungi Kami
            </a>

            <!-- Mobile hamburger — tiga garis CSS murni, tanpa ikon eksternal -->
            <button class="menu-toggle" id="menu-toggle" aria-label="Buka Menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </div>
</header>
