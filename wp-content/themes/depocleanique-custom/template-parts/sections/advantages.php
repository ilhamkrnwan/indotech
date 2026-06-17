<?php
/**
 * Section: Advantages (Keunggulan — bento grid)
 * Diport dari _landing-source.html (id="keunggulan").
 * Gambar lokal: about-hq.png, avatar-1..3.png.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$dc_img = get_template_directory_uri() . '/assets/images';
?>

<section class="py-24 bg-surface" id="keunggulan">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <h2 class="font-headline-lg text-headline-lg text-on-surface"><?php esc_html_e( 'Data-Driven Advantages', 'depocleanique-custom' ); ?></h2>
            <p class="text-on-surface-variant">
                <?php esc_html_e( 'Mengapa ribuan pengusaha memilih Depo Cleanique sebagai mitra strategis mereka?', 'depocleanique-custom' ); ?>
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 grid-rows-2 gap-gutter h-full md:h-[600px]">
            <!-- Card 1: Stabilitas -->
            <div class="md:col-span-8 bg-white p-8 rounded-xl border border-outline-variant/30 shadow-sm flex flex-col justify-between group hover:shadow-lg transition-all card-accent">
                <div class="flex justify-between items-start">
                    <div class="space-y-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">monetization_on</span>
                        </div>
                        <h3 class="text-2xl font-bold"><?php esc_html_e( 'Stabilitas Harga Terjamin', 'depocleanique-custom' ); ?></h3>
                        <p class="text-on-surface-variant max-w-md">
                            <?php esc_html_e( 'Kami memastikan tidak ada perang harga di antara mitra. Kontrak eksklusif wilayah menjaga profit margin Anda tetap sehat dan berkelanjutan.', 'depocleanique-custom' ); ?>
                        </p>
                    </div>
                    <img class="w-32 h-32 object-cover rounded-lg hidden lg:block"
                         src="<?php echo esc_url( $dc_img . '/about-hq.png' ); ?>"
                         alt="<?php esc_attr_e( 'Stabilitas harga Depo Cleanique', 'depocleanique-custom' ); ?>" />
                </div>
                <div class="flex gap-4">
                    <span class="px-3 py-1 bg-surface-container rounded-full text-xs font-bold uppercase tracking-wider"><?php esc_html_e( 'No Royalty Fee', 'depocleanique-custom' ); ?></span>
                    <span class="px-3 py-1 bg-surface-container rounded-full text-xs font-bold uppercase tracking-wider"><?php esc_html_e( 'Fixed Margin', 'depocleanique-custom' ); ?></span>
                </div>
            </div>
            <!-- Card 2: AI Marketing -->
            <div class="md:col-span-4 bg-secondary text-white p-8 rounded-xl flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-20 transform group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-8xl" style="font-variation-settings: 'FILL' 1;">psychology</span>
                </div>
                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-bold"><?php esc_html_e( 'Automasi AI Marketing', 'depocleanique-custom' ); ?></h3>
                    <p class="text-surface-variant text-sm">
                        <?php esc_html_e( 'Dukungan teknologi AI untuk mapping calon pembeli potensial di radius 5km dari lokasi depo Anda.', 'depocleanique-custom' ); ?>
                    </p>
                </div>
                <button class="w-fit text-primary-fixed font-bold flex items-center gap-2 group-hover:gap-4 transition-all relative z-10">
                    <?php esc_html_e( 'Lihat Cara Kerja', 'depocleanique-custom' ); ?>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
            <!-- Card 3: Legalitas -->
            <div class="md:col-span-4 bg-white p-8 rounded-xl border border-outline-variant/30 shadow-sm flex flex-col gap-6 group hover:shadow-lg transition-all">
                <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">gavel</span>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-bold"><?php esc_html_e( 'Legalitas Penuh', 'depocleanique-custom' ); ?></h3>
                    <p class="text-on-surface-variant text-sm">
                        <?php esc_html_e( 'Dibantu pengurusan izin OSS, Kemenkes, hingga sertifikasi Halal secara tuntas dan cepat.', 'depocleanique-custom' ); ?>
                    </p>
                </div>
            </div>
            <!-- Card 4: Forecast Graph -->
            <div class="md:col-span-8 bg-on-secondary-fixed text-white p-8 rounded-xl flex flex-col md:flex-row gap-8 items-center justify-between">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold"><?php esc_html_e( 'Prediksi Omzet Rp 50jt+', 'depocleanique-custom' ); ?></h3>
                    <p class="text-surface-variant text-sm max-w-xs">
                        <?php esc_html_e( 'Berdasarkan data historis 100+ mitra aktif kami di seluruh Indonesia.', 'depocleanique-custom' ); ?>
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-on-secondary-fixed" src="<?php echo esc_url( $dc_img . '/avatar-1.png' ); ?>" alt="<?php esc_attr_e( 'Mitra Depo Cleanique', 'depocleanique-custom' ); ?>" />
                            <img class="w-10 h-10 rounded-full border-2 border-on-secondary-fixed" src="<?php echo esc_url( $dc_img . '/avatar-2.png' ); ?>" alt="<?php esc_attr_e( 'Mitra Depo Cleanique', 'depocleanique-custom' ); ?>" />
                            <img class="w-10 h-10 rounded-full border-2 border-on-secondary-fixed" src="<?php echo esc_url( $dc_img . '/avatar-3.png' ); ?>" alt="<?php esc_attr_e( 'Mitra Depo Cleanique', 'depocleanique-custom' ); ?>" />
                        </div>
                        <span class="text-xs font-bold"><?php esc_html_e( '+120 Mitra Sukses', 'depocleanique-custom' ); ?></span>
                    </div>
                </div>
                <div class="w-full md:w-64 h-32 bg-white/5 rounded-lg border border-white/10 p-4 flex items-end gap-2">
                    <div class="flex-1 bg-primary-container/40 h-[40%] rounded-t-sm"></div>
                    <div class="flex-1 bg-primary-container/60 h-[60%] rounded-t-sm"></div>
                    <div class="flex-1 bg-primary-container/80 h-[75%] rounded-t-sm"></div>
                    <div class="flex-1 bg-primary-container h-[100%] rounded-t-sm"></div>
                </div>
            </div>
        </div>
    </div>
</section>
