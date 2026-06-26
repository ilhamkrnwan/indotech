<?php
/**
 * Testimonials Section — "Kata Mitra Bisnis Kami"
 *
 * Menampilkan ulasan dari mitra bisnis dalam bentuk infinite scroll marquee
 * yang akan menjeda pergerakan ketika di-hover oleh pengguna.
 */

$default_testimonials = [
    [
        'name'    => 'Budi Santoso',
        'company' => 'CV Maju Bersama, Jakarta',
        'role'    => 'Pemilik',
        'text'    => 'Sudah 5 tahun bermitra dengan Indotech dan belum pernah kecewa. Produk kualitasnya konsisten, pengiriman tepat waktu, dan harganya sangat kompetitif dibanding supplier lain.',
        'rating'  => 5,
        'avatar'  => 'BS',
    ],
    [
        'name'    => 'Sari Dewi',
        'company' => 'Toko Modern Sejahtera, Surabaya',
        'role'    => 'Manajer',
        'text'    => 'Produk Depo Cleanique dari Indotech selalu laris di toko kami. Tim support-nya responsif dan membantu kami dalam strategi display produk. Sangat rekomendasikan!',
        'rating'  => 5,
        'avatar'  => 'SD',
    ],
    [
        'name'    => 'Ahmad Fauzi',
        'company' => 'UD Berkah Niaga, Medan',
        'role'    => 'Direktur',
        'text'    => 'Bergabung sebagai distributor resmi Indotech adalah keputusan terbaik. Margin keuntungan bagus, produk mudah dijual, dan support dari tim selalu ada saat dibutuhkan.',
        'rating'  => 5,
        'avatar'  => 'AF',
    ],
    [
        'name'    => 'Hendra Wijaya',
        'company' => 'PT Indoclean Solusindo, Bandung',
        'role'    => 'Direktur Utama',
        'text'    => 'Kerja sama maklon dengan Indotech sangat memuaskan. Formulasi produk homecare mereka ramah lingkungan dan tim R&D sangat akomodatif terhadap spesifikasi khusus kami.',
        'rating'  => 5,
        'avatar'  => 'HW',
    ],
    [
        'name'    => 'Rina Marlina',
        'company' => 'Orchid Laundry, Yogyakarta',
        'role'    => 'Pemilik',
        'text'    => 'Pewangi laundry dari Indotech memiliki daya tahan aroma yang luar biasa. Pelanggan laundry kami sering menanyakan rahasia keharuman pakaian mereka. Sangat menguntungkan!',
        'rating'  => 5,
        'avatar'  => 'RM',
    ],
    [
        'name'    => 'Yusuf Mansur',
        'company' => 'Kemitraan Depo Cleanique, Semarang',
        'role'    => 'Mitra Waralaba',
        'text'    => 'Konsep depot sabun isi ulang ini sangat diminati ibu rumah tangga. Selain hemat, kualitas sabun pencuci piring dan deterjennya setara dengan merk terkenal.',
        'rating'  => 5,
        'avatar'  => 'YM',
    ],
    [
        'name'    => 'Elisa Putri',
        'company' => 'Resto Premium Prokopi, Bali',
        'role'    => 'Manajer Operasional',
        'text'    => 'Pembersih mesin kopi Prokopi sangat ampuh menjaga kualitas espresso kami. Aman untuk mesin (food grade) dan harganya jauh lebih hemat dibandingkan produk impor.',
        'rating'  => 5,
        'avatar'  => 'EP',
    ],
];

$testimonial_query = new WP_Query([
    'post_type'      => 'testimonial',
    'posts_per_page' => -1, // Ambil semua data testimoni jika ada CPT
    'post_status'    => 'publish',
]);
$use_cpt = $testimonial_query->have_posts();

// Satukan data ke dalam array tunggal agar konsisten
$testimonials_list = [];
if ($use_cpt) {
    while ($testimonial_query->have_posts()) {
        $testimonial_query->the_post();
        $company = get_post_meta(get_the_ID(), 'company', true);
        $role    = get_post_meta(get_the_ID(), 'role', true);
        $avatar  = strtoupper(substr(get_the_title(), 0, 2));
        $testimonials_list[] = [
            'name'    => get_the_title(),
            'company' => $company,
            'role'    => $role,
            'text'    => get_the_content(),
            'rating'  => 5,
            'avatar'  => $avatar,
        ];
    }
    wp_reset_postdata();
} else {
    $testimonials_list = $default_testimonials;
}
?>

<section class="testimonials-section section-padding" id="testimoni">
    <div class="container">
        
        <!-- Header Section (Symmetric) -->
        <div class="section-header">
            <div class="section-tag">Testimoni</div>
            <h2 class="section-title">Kata Mitra Bisnis Kami</h2>
            <p class="section-desc">Lebih dari 500 mitra bisnis telah mempercayakan kebutuhan homecare mereka kepada kami.</p>
        </div>

        <?php if (!empty($testimonials_list)): ?>
            <!-- Infinite Scroll Marquee Container -->
            <div class="testimonials-marquee-container">
                <div class="testimonials-marquee-track">
                    
                    <!-- Group 1 -->
                    <div class="testimonials-marquee-group">
                        <?php foreach ($testimonials_list as $t): ?>
                            <div class="testimonial-card">
                                <div class="testimonial-stars">
                                    <?php for ($i = 0; $i < $t['rating']; $i++): ?>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#4CAF50" stroke="none"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                                    <?php endfor; ?>
                                </div>
                                <blockquote class="testimonial-text"><?php echo wp_kses_post($t['text']); ?></blockquote>
                                <div class="testimonial-author">
                                    <div class="author-avatar"><?php echo esc_html($t['avatar']); ?></div>
                                    <div class="author-info">
                                        <span class="author-name"><?php echo esc_html($t['name']); ?></span>
                                        <span class="author-meta"><?php echo esc_html($t['role']); ?> · <?php echo esc_html($t['company']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Group 2 (Duplicate for seamless infinite scroll loop) -->
                    <div class="testimonials-marquee-group" aria-hidden="true">
                        <?php foreach ($testimonials_list as $t): ?>
                            <div class="testimonial-card">
                                <div class="testimonial-stars">
                                    <?php for ($i = 0; $i < $t['rating']; $i++): ?>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#4CAF50" stroke="none"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                                    <?php endfor; ?>
                                </div>
                                <blockquote class="testimonial-text"><?php echo wp_kses_post($t['text']); ?></blockquote>
                                <div class="testimonial-author">
                                    <div class="author-avatar"><?php echo esc_html($t['avatar']); ?></div>
                                    <div class="author-info">
                                        <span class="author-name"><?php echo esc_html($t['name']); ?></span>
                                        <span class="author-meta"><?php echo esc_html($t['role']); ?> · <?php echo esc_html($t['company']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>
