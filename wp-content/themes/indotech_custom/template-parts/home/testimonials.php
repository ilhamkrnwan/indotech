<?php
/**
 * Testimonials Section — "Kata Mitra Bisnis Kami"
 *
 * Menampilkan ulasan dari mitra bisnis dalam bentuk infinite scroll marquee
 * yang akan menjeda pergerakan ketika di-hover oleh pengguna.
 */

$default_testimonials = [
    [
        'name'    => 'H. Rahmat',
        'company' => 'Cleanique Mart Boyolali',
        'role'    => 'Pemilik',
        'text'    => 'Bergabung dengan franchise Cleanique Mart Boyolali sangat menguntungkan. Pendampingan manajemennya sangat intensif, suplai produk kebersihan dari Indotech juga lancar dan selalu diminati masyarakat.',
        'rating'  => 5,
        'avatar'  => 'HR',
        'image'   => 'mitra-boyolali.webp',
    ],
    [
        'name'    => 'Ibu Retno',
        'company' => 'Cleanique Mart Demak',
        'role'    => 'Pemilik',
        'text'    => 'Cleanique Mart Demak menjadi pelopor toko sabun terlengkap di wilayah kami. Kualitas produk detergen, softener, dan pewangi dari Indotech sangat konsisten sehingga pelanggan selalu kembali.',
        'rating'  => 5,
        'avatar'  => 'IR',
        'image'   => 'mitra-demak.webp',
    ],
    [
        'name'    => 'Bapak Hendra',
        'company' => 'Cleanique Mart Jambi',
        'role'    => 'Pengelola',
        'text'    => 'Membuka cabang Cleanique Mart di Jambi mendapat respon luar biasa. Produk dari Indotech memiliki harga grosir B2B yang sangat kompetitif, membantu kami bersaing dengan margin keuntungan yang sehat.',
        'rating'  => 5,
        'avatar'  => 'BH',
        'image'   => 'mitra-jambi.webp',
    ],
    [
        'name'    => 'Ibu Diana',
        'company' => 'Cleanique Mart Malang',
        'role'    => 'Pemilik',
        'text'    => 'Konsep minimarket sabun dan perlengkapan laundry Cleanique Mart Malang sangat disukai konsumen. Penjualan produk eceran maupun curah sangat stabil berkat kualitas dari pabrik Indotech.',
        'rating'  => 5,
        'avatar'  => 'ID',
        'image'   => 'mitra-malang.webp',
    ],
    [
        'name'    => 'Bapak Ahmad',
        'company' => 'Cleanique Mart Situbondo',
        'role'    => 'Manajer',
        'text'    => 'Suplai deterjen curah dan bahan kimia pembersih dari Indotech untuk Cleanique Mart Situbondo tidak pernah mengecewakan. Pengiriman ke luar kota selalu aman dan tepat waktu.',
        'rating'  => 5,
        'avatar'  => 'BA',
        'image'   => 'mitra-situbondo.webp',
    ],
    [
        'name'    => 'Ibu Laras',
        'company' => 'Cleanique Mart Tajem, Maguwoharjo',
        'role'    => 'Pemilik',
        'text'    => 'Toko kami di Tajem Maguwoharjo melayani banyak pelanggan laundry kiloan. Pewangi premium Orchid Care dan deterjen dari Indotech adalah produk paling laris dan mendapat rating tinggi.',
        'rating'  => 5,
        'avatar'  => 'IL',
        'image'   => 'mitra-tajem.webp',
    ],
    [
        'name'    => 'Bapak Fahmi',
        'company' => 'Cleanique Mart Palembang',
        'role'    => 'Pemilik',
        'text'    => 'Kemitraan Cleanique Mart Palembang memberikan kemudahan bisnis yang nyata. Formulasi produknya ramah lingkungan dan tim support Indotech sangat sigap membantu promosi lokal kami.',
        'rating'  => 5,
        'avatar'  => 'BF',
        'image'   => 'mitra-palembang.webp',
    ],
    [
        'name'    => 'Ibu Susi',
        'company' => 'Cleanique Mart Temanggung',
        'role'    => 'Pengelola',
        'text'    => 'Sejak bermitra dengan Indotech di Temanggung, pasokan bahan pembersih rumah tangga kami selalu aman. Produk curah isi ulangnya sangat membantu warga menghemat belanja bulanan.',
        'rating'  => 5,
        'avatar'  => 'IS',
        'image'   => 'mitra-temanggung.webp',
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
        
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: '';
        if (empty($image_url)) {
            $title = get_the_title();
            $mapped_img = '';
            foreach ($default_testimonials as $dt) {
                if (stripos($title, $dt['name']) !== false || stripos($company, $dt['company']) !== false) {
                    $mapped_img = get_template_directory_uri() . '/assets/images/' . $dt['image'];
                    break;
                }
            }
            if (empty($mapped_img)) {
                $mapped_img = get_template_directory_uri() . '/assets/images/mitra-malang.webp'; // fallback
            }
            $image_url = $mapped_img;
        }

        $testimonials_list[] = [
            'name'    => get_the_title(),
            'company' => $company,
            'role'    => $role,
            'text'    => get_the_content(),
            'rating'  => 5,
            'avatar'  => $avatar,
            'image'   => $image_url,
        ];
    }
    wp_reset_postdata();
} else {
    foreach ($default_testimonials as $t) {
        $t['image'] = get_template_directory_uri() . '/assets/images/' . $t['image'];
        $testimonials_list[] = $t;
    }
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
                            <div class="testimonial-card" style="--mitra-bg: url('<?php echo esc_url($t['image']); ?>');">
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
                            <div class="testimonial-card" style="--mitra-bg: url('<?php echo esc_url($t['image']); ?>');">
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
