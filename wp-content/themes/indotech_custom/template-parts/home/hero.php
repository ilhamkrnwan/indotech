<?php
$headline = indotech_opt('hero_headline', 'Supplier Produk Homecare<br><em>B2B Terpercaya</em>');
$subtitle = indotech_opt('hero_sub', 'PT Indotech Berkah Abadi menyediakan produk homecare, laundry, dan pewangi berkualitas untuk mitra bisnis di seluruh Indonesia. Grosir, distribusi, dan kemitraan B2B dengan harga kompetitif.');
$cta1     = indotech_opt('hero_cta1', 'Jadi Mitra Kami');
$cta1_url = indotech_opt('hero_cta1_url', home_url('/kemitraan'));
$cta2     = indotech_opt('hero_cta2', 'Lihat Produk');
$cta2_url = indotech_opt('hero_cta2_url', home_url('/produk'));
$whatsapp = preg_replace('/[^0-9]/', '', indotech_opt('whatsapp', '6281234567890'));
?>

<section class="hero-section" id="hero">

    <div class="hero-bg" aria-hidden="true">
        <div class="hero-grid-overlay"></div>
        <div class="hero-glow hero-glow--1"></div>
        <div class="hero-glow hero-glow--2"></div>
        <div class="hero-diagonal"></div>
    </div>

    <div class="container hero-container">

        <div class="hero-content">

            <div class="hero-eyebrow">
                <span class="hero-badge">
                    <span class="badge-dot" aria-hidden="true"></span>
                    B2B Expert sejak 2011
                </span>
                <span class="hero-badge-sep" aria-hidden="true">/</span>
                <span class="hero-badge hero-badge--plain">PT Indotech Berkah Abadi</span>
            </div>

            <h1 class="hero-headline">
                <?php echo wp_kses_post($headline); ?>
            </h1>

            <p class="hero-subtitle"><?php echo esc_html($subtitle); ?></p>

            <div class="hero-actions">
                <a href="<?php echo esc_url($cta1_url); ?>" class="btn btn-gold btn-lg">
                    <?php echo esc_html($cta1); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>?text=Halo%20Indotech%2C%20saya%20ingin%20mengetahui%20produk%20Anda"
                   class="btn btn-outline-white btn-lg"
                   target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    Chat WhatsApp
                </a>
            </div>

            <div class="hero-brands-strip">
                <span class="hbs-label">Brand kami:</span>
                <div class="hbs-pills">
                    <span class="hbs-pill">Orchid Care</span>
                    <span class="hbs-pill">Depo Cleanique</span>
                    <span class="hbs-pill">Malabeez</span>
                    <span class="hbs-pill">Cokusi</span>
                </div>
            </div>

        </div>

        <div class="hero-visual" aria-hidden="true">

            <div class="hv-ring hv-ring--outer"></div>
            <div class="hv-ring hv-ring--inner"></div>

            <div class="hv-card hv-card--1">
                <div class="hvc-top">
                    <div class="hvc-icon">SKU</div>
                    <span class="hvc-trend hvc-trend--up">+12%</span>
                </div>
                <div class="hvc-value">1.000+</div>
                <div class="hvc-label">Varian Produk</div>
            </div>

            <div class="hv-card hv-card--2">
                <div class="hvc-top">
                    <div class="hvc-icon">B2B</div>
                    <span class="hvc-trend hvc-trend--up">+8%</span>
                </div>
                <div class="hvc-value">500+</div>
                <div class="hvc-label">Mitra B2B Aktif</div>
            </div>

            <div class="hv-card hv-card--3">
                <div class="hvc-icon-large">ID</div>
                <div class="hvc-value">34</div>
                <div class="hvc-label">Provinsi Terjangkau</div>
            </div>

            <div class="hv-badge-cert">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                BPOM &middot; Halal MUI &middot; ISO 9001
            </div>

        </div>

    </div>

    <div class="hero-scroll-hint" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>

</section>
