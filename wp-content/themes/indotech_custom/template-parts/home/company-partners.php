<?php
/** Storefront photography previously published in the Indotech partner section. */
$locations = [
    [ 'Jambi', 'mitra-jambi.webp', 400, 300 ],
    [ 'Boyolali', 'mitra-boyolali.webp', 400, 300 ],
    [ 'Temanggung', 'mitra-temanggung.webp', 400, 400 ],
];
?>

<section class="company-partners company-wrap" aria-labelledby="company-partners-title">
    <header class="company-section-heading">
        <div>
            <h2 id="company-partners-title">Jejak kemitraan.</h2>
            <p>Dokumentasi gerai Cleanique Mart di beberapa daerah.</p>
        </div>
        <a class="company-text-link" href="<?php echo esc_url( home_url( '/kemitraan/' ) ); ?>">
            Lihat program kemitraan
            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
        </a>
    </header>
    <div class="company-partner-gallery">
        <?php foreach ( $locations as [ $city, $file, $width, $height ] ) : ?>
            <figure class="company-partner-photo">
                <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $file ) ); ?>"
                    width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>"
                    alt="<?php echo esc_attr( 'Tampak depan gerai Cleanique Mart ' . $city ); ?>" loading="lazy" decoding="async">
                <figcaption><?php echo esc_html( 'Cleanique Mart ' . $city ); ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
