<?php get_header(); ?>

<main id="main-content" style="min-height:60vh; display:flex; align-items:center;">
    <div class="container" style="text-align:center; padding:80px 24px;">
        <div style="font-size:80px; font-family:'Syne',sans-serif; font-weight:800; color:var(--gray-200); line-height:1; margin-bottom:16px;">404</div>
        <h1 style="font-size:32px; color:var(--navy); margin-bottom:16px;">Halaman Tidak Ditemukan</h1>
        <p style="color:var(--text-secondary); font-size:17px; margin-bottom:40px;">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</main>

<?php get_footer(); ?>
