# Panduan gambar latar dan video profil

## Arahan produksi gambar

| Penempatan | Komposisi | Ekspor dan penerapan |
| --- | --- | --- |
| Hero desktop | Foto studio industrial satu adegan. Pertahankan ruang tenang di sisi kiri dan tempatkan produk di tengah-kanan. Jaga tutup dan dasar produk dalam area vertikal tengah sekitar 65% agar aman pada frame lebar. | Master minimal 1536 × 1024 px. Ekspor WebP lebar 1024 dan 1536 px. Frame tampilan sekitar 2,32:1 dengan `object-fit: cover`. Target ≤150 KB per varian desktop. |
| Hero mobile | Pangkas ke kelompok produk dengan ruang untuk label di kiri atas dan tautan aksi di kanan bawah. Periksa keterbacaan pada 320 px. | Ekspor WebP sekitar 770 px lebar dengan crop terpisah. Frame tampilan 5:4. Target ≤100 KB. |
| Poster profil | Close-up media atau foto proses yang disetujui, dengan titik fokus di tengah agar aman terhadap crop dan caption. | Ekspor 960 × 540 px, WebP maksimal 100 KB. Muat secara lazy dan pertahankan rasio saat belum dimuat. |
| Media berikutnya | Foto asli untuk tim, fasilitas, mitra dan SKU. Gunakan ilustrasi untuk konteks visual umum. | Catat sumber, hak pemakaian, fokus crop, dimensi, dan teks alternatif bila fotonya memuat informasi. |

- Teks, logo, angka, sertifikasi, dan tombol dipasang sebagai HTML. Hindari menghasilkan elemen itu di dalam gambar.
- Pertahankan gradasi cahaya studio dan palet biru–abu. Hindari latar sibuk dan pertahankan navy sebagai warna fallback. Jika teks berada di atas media, gunakan bidang latar yang stabil dan uji kontras pada setiap crop.
- Hero menggunakan `picture` dengan media query untuk crop mobile. Gunakan dimensi atau rasio eksplisit untuk mencegah pergeseran layout dan prioritaskan satu gambar di hero. Caption menandai aset generatif sebagai ilustrasi.
- Untuk mengganti gambar, verifikasi ukuran, crop, hak pakai, dan keadaan ketika media gagal dimuat. Tetapkan ulang `srcset` bila kandidat ukuran berubah.

## Aset yang dihasilkan

`hero-1536.webp`, `hero-1024.webp`, dan `hero-mobile.webp` berasal dari satu still life yang dihasilkan dengan ImageGen. `profile-poster.webp` menggunakan generasi terpisah. Seluruhnya berada di `wp-content/themes/indotech_custom/assets/images/company-profile/`. Kemasan tanpa merek menunjukkan jenis produk secara ilustratif. Setiap aset memiliki file JSON pendamping berisi prompt produksi.

## Storyboard video 55–65 detik

| Waktu | Visual yang dibutuhkan | Narasi atau pesan |
| --- | --- | --- |
| 00–06 | Bidikan pembuka kantor atau area operasi yang disetujui. Logo resmi masuk sebagai grafis. | “Kami PT Indotech Berkah Abadi, berbasis di Sleman, Yogyakarta.” |
| 06–18 | Produk nyata, pengemasan, dan proses penyiapan pesanan. | “Kami mengembangkan dan memasok produk kebersihan, laundry, dan pewangi untuk kebutuhan bisnis.” |
| 18–31 | Cuplikan proses formulasi dan peninjauan kemasan bersama Cleanique Lab. | “Melalui layanan maklon, kami membantu pelaku usaha mengembangkan produk dengan merek mereka sendiri.” |
| 31–44 | Mitra distribusi, konsep depo/toko, serta kegiatan pelatihan yang disetujui. | “Program kemitraan dan pelatihan mendukung distribusi dan pengembangan usaha.” |
| 44–55 | Logo portofolio sesuai izin, kemudian cuplikan tim atau produk. | “Temukan solusi dan brand yang sesuai dengan kebutuhan Anda.” |
| 55–65 | Logo dan domain resmi, dengan grafis singkat. | “Diskusikan kebutuhan bisnis Anda dengan Indotech.” |

Gunakan rekaman nyata untuk proses dan fasilitas, persetujuan tertulis dari partisipan dan mitra, serta hak penggunaan musik. Gabungkan narasi akhir dengan informasi visual penting agar audiens memahami isi melalui audio. Sediakan caption VTT Bahasa Indonesia dan transkrip yang setara. Siapkan audio description apabila narasi belum mencakup informasi visual penting. [WCAG 2.2 untuk media berbasis waktu](https://www.w3.org/TR/WCAG22/#time-based-media).

Kirim master 1080p dengan versi distribusi MP4 H.264, poster WebP 16:9, caption, dan transkrip. Pemutaran dimulai dari kontrol pengguna. Jika memakai layanan video pihak ketiga, tunda koneksi sampai pengguna memilih memutar dan tangani persetujuan yang berlaku. Tampilkan ringkasan perusahaan dan tautan profil ketika file belum tersedia atau pemutaran gagal.
