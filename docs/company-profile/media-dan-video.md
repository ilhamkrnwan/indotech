# Panduan gambar latar dan video profil

## Arahan produksi gambar

| Penempatan | Komposisi | Ekspor dan penerapan |
| --- | --- | --- |
| Hero | Tiga packshot katalog menggunakan latar studio navy. Pertahankan label asli dan ruang di sekeliling kemasan. Kartu katalog berada di kanan pada desktop dan di bawah kelompok produk pada mobile. | Gunakan WebP transparan, pangkas tepi kosong, dan pertahankan rasio setiap kemasan. Target total ≤150 KB untuk aset hero. |
| Poster profil | Close-up media atau foto proses yang disetujui, dengan titik fokus di tengah agar aman terhadap crop dan caption. | Ekspor 960 × 540 px, WebP maksimal 100 KB. Muat secara lazy dan pertahankan rasio saat belum dimuat. |
| Galeri mitra | Tiga foto gerai yang telah ditampilkan di Indotech. Pertahankan papan nama dan fasad dalam area fokus. | Gunakan berkas tema WebP. Label kota mengikuti publikasi sumber. |
| Media berikutnya | Foto asli untuk tim, fasilitas, mitra dan SKU. Gunakan ilustrasi untuk konteks visual umum. | Catat sumber, hak pemakaian, fokus crop, dimensi, dan teks alternatif bila fotonya memuat informasi. |

- Teks, logo, angka, sertifikasi, dan tombol dipasang sebagai HTML. Hindari menghasilkan elemen itu di dalam gambar.
- Pertahankan gradasi cahaya studio dan palet biru–abu. Hindari latar sibuk dan pertahankan navy sebagai warna fallback. Jika teks berada di atas media, gunakan bidang latar yang stabil dan uji kontras pada setiap crop.
- Prioritaskan satu packshot dan cantumkan dimensi eksplisit pada setiap gambar. Panel kontak menggunakan `picture` dengan crop mobile. Caption poster menandai visual formulasi sebagai ilustrasi.
- Untuk mengganti gambar, verifikasi ukuran, crop, hak pakai, dan keadaan ketika media gagal dimuat. Tetapkan ulang `srcset` bila kandidat ukuran berubah.

## Sumber aset

- `laundry-souring.webp`, `sabun-cuci-piring.webp`, dan `pembersih-lantai.webp` memakai packshot katalog Cleanique Lab. Transparansi dan label asli dipertahankan saat menghapus ruang kosong dan mengompresi berkas. [Katalog Cleanique Lab](https://indotech.id/brands/cleanique-lab/).
- `ilustrasi-formulasi.webp` berasal dari visual “Validasi Kualitas” pada publikasi Indotech. Poster ini dipakai sambil menunggu video resmi. [Publikasi Indotech](https://indotech.id/profil-pabrik-kimia-terlengkap-yogyakarta/).
- `mitra-jambi.webp`, `mitra-boyolali.webp`, dan `mitra-temanggung.webp` menggunakan berkas tema dari bagian mitra pada beranda publik. [Beranda Indotech](https://indotech.id/).
- `hero-1024.webp` dan `hero-mobile.webp` dari ImageGen digunakan sebagai ilustrasi dekoratif pada panel kontak. `hero-1536.webp` dan `profile-poster.webp` adalah opsi cadangan. File JSON pendamping di folder `company-profile` mencatat sumber atau prompt.

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
