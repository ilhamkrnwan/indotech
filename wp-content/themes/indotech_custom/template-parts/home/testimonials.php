<?php
$default_testimonials = [
    [
        'name'    => 'Budi Santoso',
        'company' => 'CV Maju Bersama, Jakarta',
        'role'    => 'Owner',
        'text'    => 'Sudah 5 tahun bermitra dengan Indotech dan belum pernah kecewa. Produk kualitasnya konsisten, pengiriman tepat waktu, dan harganya sangat kompetitif dibanding supplier lain.',
        'rating'  => 5,
        'avatar'  => 'BS',
    ],
    [
        'name'    => 'Sari Dewi',
        'company' => 'Toko Modern Sejahtera, Surabaya',
        'role'    => 'Manager',
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
];

$testimonial_query = new WP_Query([
    'post_type'      => 'testimonial',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
]);
$use_cpt = $testimonial_query->have_posts();
?>

<section class="testimonials-section section-padding" id="testimoni">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">Testimoni</div>
            <h2 class="section-title">Kata Mitra Bisnis Kami</h2>
            <p class="section-desc">Lebih dari 500 mitra bisnis telah mempercayakan kebutuhan homecare mereka kepada kami.</p>
        </div>

        <div class="testimonials-grid">
            <?php if ($use_cpt):
                while ($testimonial_query->have_posts()): $testimonial_query->the_post();
                    $company = get_post_meta(get_the_ID(), 'company', true);
                    $role    = get_post_meta(get_the_ID(), 'role', true);
                    $avatar  = strtoupper(substr(get_the_title(), 0, 2));
            ?>
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#4CAF50" stroke="none"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                    <?php endfor; ?>
                </div>
                <blockquote class="testimonial-text"><?php the_content(); ?></blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar"><?php echo esc_html($avatar); ?></div>
                    <div class="author-info">
                        <span class="author-name"><?php the_title(); ?></span>
                        <span class="author-meta"><?php echo esc_html($role); ?> · <?php echo esc_html($company); ?></span>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata();
            else:
                foreach ($default_testimonials as $t): ?>
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <?php for ($i = 0; $i < $t['rating']; $i++): ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#4CAF50" stroke="none"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                    <?php endfor; ?>
                </div>
                <blockquote class="testimonial-text"><?php echo esc_html($t['text']); ?></blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar"><?php echo esc_html($t['avatar']); ?></div>
                    <div class="author-info">
                        <span class="author-name"><?php echo esc_html($t['name']); ?></span>
                        <span class="author-meta"><?php echo esc_html($t['role']); ?> · <?php echo esc_html($t['company']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
