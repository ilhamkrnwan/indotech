<?php
/**
 * Blok Solusi B2B Gelap — 4 Pilar Layanan Terintegrasi.
 */

$solutions = [
    [
        'title' => 'Pasokan & Distribusi',
        'copy'  => 'Suplai curah dan kemasan produk homecare, bahan kimia laundry, car care, dan pewangi bagi pengadaan ritel, hotel, serta grosir.',
        'label' => 'Lihat katalog produk',
        'url'   => home_url( '/produk/' ),
        'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>',
    ],
    [
        'title' => 'Maklon & Formulasi',
        'copy'  => 'Riset formulasi, uji mutu, pendampingan izin edar Kemenkes RI PKRT & Halal, hingga pengemasan merek Anda bersama Cleanique Lab.',
        'label' => 'Pelajari layanan maklon',
        'url'   => 'https://cleaniquelab.com/',
        'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 3h6"></path><path d="M10 3v6l-4.5 8.2A2 2 0 0 0 7.2 20h9.6a2 2 0 0 0 1.7-2.8L14 9V3"></path><path d="M8.5 14h7"></path></svg>',
    ],
    [
        'title' => 'Kemitraan Usaha',
        'copy'  => 'Program keagenan dan distributor daerah, termasuk konsep toko kebersihan modern Cleanique Mart dan depo isi ulang Depo Cleanique.',
        'label' => 'Lihat program kemitraan',
        'url'   => home_url( '/kemitraan/' ),
        'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
    ],
    [
        'title' => 'Pelatihan & Edukasi',
        'copy'  => 'Pelatihan formulasi produk kebersihan dan pendampingan kewirausahaan terstruktur bersama Cleanique Academy.',
        'label' => 'Lihat program pelatihan',
        'url'   => 'https://cleaniqueacademy.com/',
        'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>',
    ],
];
?>

<section class="ch-solutions-band ch-wrap" id="solusi-b2b" aria-labelledby="ch-solutions-title">
    <div class="ch-solutions-dark">
        <div class="ch-solutions-left">
            <h2 id="ch-solutions-title" class="ch-solutions-h2">Layanan B2B Terintegrasi</h2>
            <p class="ch-solutions-lead">Dari pengadaan produk jadi hingga pembangunan merek dan jaringan toko kebersihan, pilih jalur yang sesuai kebutuhan bisnis Anda.</p>

            <div class="ch-solutions-nav" aria-label="Sorot solusi layanan">
                <button type="button" class="ch-round-btn ch-round-btn--dark" data-solution-prev aria-label="Sorot solusi sebelumnya">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="ch-round-btn ch-round-btn--light" data-solution-next aria-label="Sorot solusi berikutnya">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <ul class="ch-solutions-grid">
            <?php foreach ( $solutions as $index => $solution ) : ?>
                <li class="ch-solution-card<?php echo 0 === $index ? ' is-highlighted' : ''; ?>" data-solution-card>
                    <div class="ch-solution-head">
                        <span class="ch-solution-icon"><?php echo $solution['icon']; ?></span>
                        <h3><?php echo esc_html( $solution['title'] ); ?></h3>
                    </div>
                    <p><?php echo esc_html( $solution['copy'] ); ?></p>
                    <a class="ch-lime-link" href="<?php echo esc_url( $solution['url'] ); ?>">
                        <span><?php echo esc_html( $solution['label'] ); ?></span>
                        <?php get_template_part( 'template-parts/home/company-arrow' ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
