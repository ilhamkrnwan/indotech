<?php
/**
 * Kisah Mitra & Jejak Kemitraan — Etalase Asimetris 3 Kartu (Manufy Customer Stories).
 */

$media_img = get_theme_file_uri( 'assets/images/' );

$stories = [
    [
        'name'    => 'Bapak Hendra',
        'role'    => 'Pengelola · Cleanique Mart Jambi',
        'quote'   => 'Membuka cabang Cleanique Mart di Jambi mendapat respons luar biasa. Harga grosir B2B dari Indotech sangat kompetitif dengan margin usaha yang sehat.',
        'image'   => $media_img . 'mitra-jambi.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Jambi',
    ],
    [
        'name'    => 'Ibu Susi',
        'role'    => 'Pengelola · Cleanique Mart Temanggung',
        'quote'   => 'Sejak bermitra di Temanggung, pasokan produk pembersih dan sistem isi ulang selalu aman sehingga pelanggan rumah tangga rutin berbelanja ulang.',
        'image'   => $media_img . 'mitra-temanggung.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Temanggung',
    ],
    [
        'name'    => 'Bapak Fahmi',
        'role'    => 'Pemilik · Cleanique Mart Palembang',
        'quote'   => 'Kemitraan Cleanique Mart Palembang memberi dukungan produk yang konsisten dan respons tim yang sigap membantu kebutuhan promosi daerah kami.',
        'image'   => $media_img . 'mitra-palembang.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Palembang',
    ],
    [
        'name'    => 'H. Rahmat',
        'role'    => 'Pemilik · Cleanique Mart Boyolali',
        'quote'   => 'Pendampingan manajemen dan kelancaran suplai produk kebersihan dari Indotech menjaga perputaran stok gerai kami tetap stabil.',
        'image'   => $media_img . 'mitra-boyolali.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Boyolali',
    ],
    [
        'name'    => 'Ibu Retno',
        'role'    => 'Pemilik · Cleanique Mart Demak',
        'quote'   => 'Kualitas deterjen, softener, dan pewangi dari Indotech sangat konsisten sehingga pelanggan laundry dan rumah tangga selalu kembali.',
        'image'   => $media_img . 'mitra-demak.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Demak',
    ],
    [
        'name'    => 'Ibu Laras',
        'role'    => 'Pemilik · Cleanique Mart Tajem, Sleman',
        'quote'   => 'Pelanggan laundry kiloan di sekitar Sleman sangat menyukai pewangi Orchid Care dan deterjen konsentrat dari Indotech.',
        'image'   => $media_img . 'mitra-tajem.webp',
        'alt'     => 'Tampak depan gerai kemitraan Cleanique Mart Tajem Sleman',
    ],
];

if ( post_type_exists( 'testimonial' ) ) {
    $cpt_stories = get_posts( [
        'post_type'      => 'testimonial',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
    ] );
    if ( ! empty( $cpt_stories ) ) {
        $mapped = [];
        foreach ( $cpt_stories as $item ) {
            $company = get_post_meta( $item->ID, 'company', true );
            $role    = get_post_meta( $item->ID, 'role', true );
            $img     = get_the_post_thumbnail_url( $item->ID, 'large' ) ?: ( $media_img . 'mitra-jambi.webp' );
            $mapped[] = [
                'name'  => get_the_title( $item ),
                'role'  => trim( implode( ' · ', array_filter( [ $role, $company ] ) ) ) ?: 'Mitra B2B Indotech',
                'quote' => wp_strip_all_tags( $item->post_content ),
                'image' => $img,
                'alt'   => 'Dokumentasi mitra ' . get_the_title( $item ),
            ];
        }
        if ( count( $mapped ) >= 3 ) {
            $stories = $mapped;
        }
    }
}
?>

<section class="ch-stories ch-wrap" id="kisah-mitra" aria-labelledby="ch-stories-title">
    <div class="ch-stories-head">
        <div class="ch-stories-title-wrap">
            <h2 id="ch-stories-title" class="ch-stories-h2">
                <span>Kisah</span>
                <span class="ch-stories-row">
                    <span class="ch-h2-muted">Mitra</span>
                    <span class="ch-tilt-badge ch-tilt-badge--story">Mitra B2B</span>
                </span>
            </h2>
        </div>

        <div class="ch-stories-controls">
            <p>Menjelajahi pertumbuhan gerai Cleanique Mart dan mitra distribusi B2B di seluruh nusantara.</p>
            <div class="ch-stories-nav">
                <button type="button" class="ch-round-btn ch-round-btn--tint" data-story-prev aria-label="Kisah mitra sebelumnya">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="ch-round-btn ch-round-btn--cobalt" data-story-next aria-label="Kisah mitra berikutnya">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
    </div>

    <div
        class="ch-stories-stage"
        data-stories-stage
        data-stories="<?php echo esc_attr( wp_json_encode( $stories, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) ); ?>"
    >
        <?php for ( $slot = 0; $slot < 3; $slot++ ) :
            $story = $stories[ $slot ];
            $is_lead = ( 0 === $slot );
            ?>
            <article class="ch-story-card<?php echo $is_lead ? ' is-featured' : ' is-secondary'; ?>" data-story-slot="<?php echo (int) $slot; ?>">
                <img
                    class="ch-story-img"
                    src="<?php echo esc_url( $story['image'] ); ?>"
                    width="400"
                    height="300"
                    alt="<?php echo esc_attr( $story['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
                <div class="ch-story-scrim" aria-hidden="true"></div>
                <div class="ch-story-overlay">
                    <div class="ch-story-meta">
                        <h3 class="ch-story-name"><?php echo esc_html( $story['name'] ); ?></h3>
                        <p class="ch-story-role"><?php echo esc_html( $story['role'] ); ?></p>
                    </div>
                    <?php if ( $is_lead ) : ?>
                        <button
                            type="button"
                            class="ch-story-open"
                            data-story-open
                            aria-haspopup="dialog"
                            aria-controls="ch-story-modal"
                            aria-label="<?php echo esc_attr( 'Baca cerita lengkap ' . $story['name'] ); ?>"
                        >
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="7 5 19 12 7 19 7 5"></polygon></svg>
                        </button>
                    <?php endif; ?>
                </div>
                <?php if ( ! $is_lead ) : ?>
                    <button
                        type="button"
                        class="ch-story-select"
                        data-story-promote="<?php echo (int) $slot; ?>"
                        aria-label="<?php echo esc_attr( 'Tampilkan kisah ' . $story['name'] ); ?>"
                    >
                        <span class="ch-sr-only">Pilih kisah</span>
                    </button>
                <?php endif; ?>
            </article>
        <?php endfor; ?>
    </div>

    <div class="ch-stories-foot">
        <a class="ch-inline-link" href="<?php echo esc_url( home_url( '/kemitraan/' ) ); ?>">
            <span>Jelajahi skema kemitraan Cleanique Mart &amp; agen</span>
            <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
        </a>
    </div>
</section>

<div id="ch-story-modal" class="ch-modal" role="dialog" aria-modal="true" aria-labelledby="ch-story-modal-title" hidden>
    <div class="ch-modal-backdrop" data-modal-close></div>
    <div class="ch-modal-dialog ch-modal-dialog--story">
        <div class="ch-modal-header">
            <h2 id="ch-story-modal-title" class="ch-modal-title" data-story-modal-name></h2>
            <button type="button" class="ch-modal-close" data-modal-close aria-label="Tutup kisah mitra">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="ch-modal-body ch-story-modal-body">
            <img class="ch-story-modal-img" src="<?php echo esc_url( $stories[0]['image'] ); ?>" width="400" height="300" alt="" data-story-modal-img>
            <div class="ch-story-modal-copy">
                <p class="ch-story-modal-role" data-story-modal-role></p>
                <blockquote class="ch-story-modal-quote" data-story-modal-quote></blockquote>
                <div class="ch-modal-footer-actions">
                    <a class="ch-header-btn ch-header-btn--outline" href="<?php echo esc_url( home_url( '/kemitraan/' ) ); ?>">Program Kemitraan</a>
                    <a class="ch-header-btn ch-header-btn--primary" href="<?php echo esc_url( home_url( '/kontak/#form-kontak' ) ); ?>">Diskusikan Kemitraan</a>
                </div>
            </div>
        </div>
    </div>
</div>
