# Requirement redesain company profile

## Tujuan dan cakupan

Calon pelanggan dapat mengenali PT Indotech Berkah Abadi, menemukan solusi yang relevan, dan menghubungi tim melalui “Diskusikan Kebutuhan B2B”. Iterasi pertama menerapkan sistem desain baru pada beranda WordPress dan mendokumentasikan struktur untuk halaman lain. CTA beranda membuka bagian formulir permintaan penawaran pada halaman Kontak yang ada.

## Struktur situs

| Halaman | Konten yang diperlukan | Aksi utama | Lingkup |
| --- | --- | --- | --- |
| Beranda `/` | Proposisi B2B, media editorial, profil dan video, empat solusi, portofolio brand, wawasan, dan kontak. | Diskusikan Kebutuhan B2B | Implementasi pertama |
| Tentang Kami `/tentang-kami/` | Identitas, sejarah terverifikasi, visi/misi, tim/fasilitas, profil video, dan bukti legal relevan. | Diskusikan kebutuhan atau lihat solusi | Spesifikasi lanjutan |
| Solusi B2B | Empat jalur berdasarkan kebutuhan, audiens, cakupan, proses, dokumen, dan CTA terkait. Industri dan aplikasi menjadi konteks penggunaan pada solusi yang relevan. | Pilih solusi atau konsultasi | Bagian beranda pada fase pertama. URL khusus dapat diputuskan setelah isi tiap solusi siap. |
| Produk `/produk/` dan detail | Kategori, pencarian, filter, spesifikasi, ukuran, dokumen resmi yang berlaku, dan jalur penawaran. | Lihat produk atau minta penawaran | Spesifikasi lanjutan dengan URL katalog yang ada |
| Brand `/brands/{slug}/` | Peran brand, cakupan produk/layanan, dan hubungan dengan PT Indotech Berkah Abadi. | Jelajahi brand atau situs resminya | Ringkasan di beranda, detail memakai rute yang ada |
| Kemitraan `/kemitraan/` | Tipe program, manfaat dan persyaratan yang disetujui, alur, FAQ, dan kontak. | Ajukan kemitraan | Spesifikasi lanjutan |
| Blog dan FAQ `/blog/`, `/faq/` | Artikel industri dan kumpulan jawaban terawat. FAQ ditautkan ketika halaman sudah terbit. | Buka artikel atau jawaban | Ringkasan di beranda, halaman tersendiri berikutnya |
| Kontak `/kontak/` | Formulir, empat pilihan konsultasi yang jelas, kontak resmi, alamat, jam operasional yang konsisten, dan konfirmasi. | Kirim kebutuhan | Formulir saat ini dipakai oleh CTA beranda. Penyelarasan pilihan dan routing didesain pada fase lanjutan. |
| Legal, dokumen, daftar harga | Kebijakan, katalog PDF, lembar data dan dokumen yang masih berlaku. Tampilkan jenis, versi, tanggal, dan ruang lingkup. | Baca atau unduh | Spesifikasi lanjutan sesuai ketersediaan dokumen |

## Urutan beranda

1. Header dengan logo resmi, menu aktif sesuai WordPress, dan Kontak B2B. Hero menjawab bidang usaha dan menampilkan satu CTA konsultasi, foto editorial, serta navigasi ke solusi.
2. “Kenali Indotech” memuat ringkasan perusahaan, poster, dan tautan profil. Saat video resmi siap, kontrol pemutaran tampil pada bagian ini.
3. “Apa kebutuhan bisnis Anda?” memperlihatkan pasokan dan distribusi, maklon dan formulasi, kemitraan usaha, serta pelatihan dan edukasi. Setiap jalur mempunyai tujuan yang spesifik.
4. “Ekosistem brand” memuat Orchid Care, Cleanique Lab, Cleanique Academy, Cleanique Mart, Depo Cleanique, Malabeez, dan Prokopi. Profil WordPress yang terbit didahulukan. Brand dengan situs afiliasi memakai situs resmi sebagai tautan cadangan. Prokopi memakai katalog bila profilnya belum terbit.
5. “Wawasan & bantuan” menghubungkan pembaca ke artikel dan FAQ yang tersedia. Daftar artikel menampilkan maksimal tiga entri terbit di luar kategori bawaan WordPress. Tim editorial mengelola kualitas dan status publikasi konten melalui WordPress.
6. CTA penutup menuju formulir yang sama. Footer memberikan identitas dan kanal kontak resmi.

Tempatkan bukti kualitas dan studi kasus antara solusi dan CTA penutup setelah tersedia materi yang disetujui. Minta persetujuan pemakaian untuk foto partner atau testimoni. Kelola izin edar berdasarkan produk dan sertifikasi berdasarkan pemegang serta ruang lingkup dokumen. Catat sumber, tanggal, dan definisi untuk metrik publik.

## Kriteria penerimaan

- Tata letak dapat digunakan pada 320, 390, 768, 1024, dan 1440 px. Judul utuh, menu bisa dibuka dan ditutup dengan keyboard, fokus terlihat, konten dapat dibaca sejak render pertama, serta tautan utama menuju target yang valid.
- Satu H1, struktur heading berurutan, landmark yang jelas, dan gambar dekoratif tanpa teks alternatif redundan. Gunakan 4,5:1 untuk teks normal, 3:1 untuk teks besar serta kontras indikator kontrol yang relevan, dan target kontrol utama 44 px secara internal. Evaluasi manual melengkapi pemindaian otomatis. [WCAG 2.2](https://www.w3.org/TR/WCAG22/).
- Target performa setelah rollout pada persentil ke-75 adalah LCP ≤2,5 detik, INP ≤200 ms, dan CLS ≤0,1, dinilai terpisah untuk mobile dan desktop. Pakai kompresi, media responsif, pemuatan tertunda untuk poster di bawah hero, dan ruang media yang tetap. [Panduan Web Vitals](https://web.dev/articles/vitals).
- Gunakan CMS dan template yang ada untuk URL publik, artikel, brand, dan formulir. Cek canonical, schema, sitemap, serta regresi fungsi katalog dan detail dalam staging sebelum rollout.
- Saat produksi video, siapkan aset asli yang disetujui, caption Bahasa Indonesia, transkrip, navigasi player melalui keyboard, fallback teks, dan uji dengan koneksi lambat. [Storyboard dan aturan media](media-dan-video.md).
- Penerimaan alur konsultasi memerlukan pengujian kirim formulir dengan tujuan uji yang disetujui, penanganan kegagalan, dan verifikasi routing setiap topik. Pengukuran konversi menggunakan klik CTA dan pengiriman berhasil tanpa menyertakan isi atau identitas calon pelanggan pada payload analitik.

## Input yang masih dibutuhkan

Video profil resmi dan sumber media perusahaan, daftar klaim beserta dokumen pendukung, studi kasus atau izin penggunaan testimoni, dan pemilik routing lead tiap jenis konsultasi.

Lihat juga [sistem desain](../../DESIGN.md), [audit situs](audit-situs-aktif.md), dan [keputusan struktur beranda](../adr/0001-beranda-berdasarkan-kebutuhan-b2b.md).
