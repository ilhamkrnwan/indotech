# Audit situs publik Indotech

19 November 2026. Audit mencakup tampilan publik Beranda, Tentang Kami, Produk, Kemitraan, Blog, Kontak, dan FAQ, serta inventaris keluarga template dalam tema lokal. Pemeriksaan memakai akses publik dan pembacaan source lokal.

## Tema aktif

| Lapisan | Temuan |
| --- | --- |
| Platform | WordPress dengan tema PHP `indotech_custom` dan plugin `indotech-core`. Tema memiliki template arsip dan detail untuk produk, brand, industri, dan aplikasi, serta template blog, pencarian, dokumen, legal, daftar harga, dan 404. |
| Token | `assets/css/main.css` dan `theme.json` mendefinisikan electric blue `#0057FF`, ink `#0A0F1E`, putih, dan abu terang. Katalog dan konten editorial memakai fondasi yang sama dengan variasi template. |
| Tipografi | Space Grotesk untuk judul dan Inter untuk isi. Font variabel tersedia lokal. README menyebut Plus Jakarta Sans dan Tailwind CDN dari fase awal sehingga perlu sinkronisasi terpisah. |
| Komposisi | Header putih fixed, hero gelap dengan grid/radial, judul besar dengan aksen biru, kartu metrik mengambang, badge, sudut membulat, kontainer 1.200 px, dan footer gelap. Halaman dalam berulang memakai `.inner-page-hero`. |
| Interaksi | Menu mobile, animasi reveal dengan IntersectionObserver, testimoni bergulir, filter katalog, dan akses WhatsApp. `assets/js/main.js` juga menangani anchor dan status navigasi. |
| Konten | `front-page.php` merangkai sembilan bagian pada tema lama. CPT memisahkan produk, brand, industri, dan aplikasi. Kategori produk menggunakan taksonomi tersendiri. |

## Temuan dan prioritas

| Prioritas | Bukti | Dampak dan tindak lanjut |
| --- | --- | --- |
| Tinggi | Hero situs memimpin dengan homecare dan CTA “Jadi Mitra Kami”. Penawaran maklon baru muncul jauh di bawah pada FAQ. Pelatihan tampil sebagai nama brand. | Calon pembeli dan pemilik merek sulit melihat jalur yang relevan. Tempatkan pengenalan perusahaan dan empat solusi sebelum direktori brand. [Beranda lama](https://indotech.id/). |
| Tinggi | Hero, bagian layanan, halaman perusahaan, dan halaman kemitraan menyajikan BPOM, Halal MUI, dan ISO 9001 secara luas. FAQ menyebut Kemenkes. Sumber publik yang diperiksa belum menyediakan bukti per klaim dalam konteksnya. | Kumpulkan penerbit, nomor, entitas atau SKU, ruang lingkup, dan masa berlaku. Beranda baru menunggu bukti tersebut sebelum menampilkan badge. [Tentang Kami](https://indotech.id/tentang-kami/), [FAQ](https://indotech.id/faq/). |
| Tinggi | Angka 500+, 1.000+, 34, dan persentase pertumbuhan muncul tanpa tanggal data atau penjelasan di hero. Prokopi terlihat pada hero, sementara kisi produksi menampilkan enam brand. Source membatasi query kisi ke enam entri dan cadangan statis berisi tujuh. | Tetapkan sumber data dan tanggal untuk setiap angka. Gunakan portofolio berlabel dengan tautan yang sesuai. WordPress lokal memuat tujuh profil termasuk Prokopi. [Beranda lama](https://indotech.id/). |
| Tinggi | Beberapa bagian inti dibuat transparan sampai masuk viewport oleh script reveal. Navigasi mobile lama menutup dengan opacity dan pointer-events, tanpa menyembunyikan anak dari urutan fokus. | Beranda baru merender konten langsung, menyembunyikan drawer tertutup dari pembaca layar dan keyboard, serta mendukung Escape dan tautan lewati navigasi. |
| Menengah | Hero menampilkan kartu angka, sementara pengalaman perusahaan, proses, tim, dan video perkenalan tidak mendapat porsi media yang setara. | Gunakan media lebar dan bagian pengenalan di awal. Jadwalkan produksi video serta kumpulkan foto tim, proses, atau fasilitas yang dapat dipublikasikan. [Beranda lama](https://indotech.id/), [Tentang Kami](https://indotech.id/tentang-kami/). |
| Menengah | Beranda lama menampilkan testimonial berulang dalam markup dan copy komersial seperti jaminan stok serta estimasi respons. Kontak menampilkan jam layanan yang berbeda antarbagiannya. | Gunakan bukti mitra dengan persetujuan dan rincian kasus. Samakan jam, kanal, pemilik lead, dan SLA sebelum rollout desain ke halaman kontak. [Beranda lama](https://indotech.id/), [Kontak](https://indotech.id/kontak/). |
| Menengah | Katalog memiliki filter dan detail. Halaman Kemitraan dan Kontak memiliki alur tersendiri. Subjek formulir kontak lokal belum menyediakan pilihan eksplisit untuk maklon dan pelatihan. | Pertahankan jalur yang sudah ada. Jadikan penyelarasan subjek dan routing lead bagian dari desain halaman Kontak. [Produk](https://indotech.id/produk/), [Kemitraan](https://indotech.id/kemitraan/), [Kontak](https://indotech.id/kontak/). |

## Rujukan bisnis

- Orchid Care untuk pembersih, bahan laundry, konsentrat, dan pewangi. [Orchid Care](https://orchidbrand.id/).
- Cleanique Lab untuk produksi dan maklon. [Profil Indotech](https://indotech.id/brands/cleanique-lab/), [Cleanique Lab](https://cleaniquelab.com/).
- Cleanique Academy untuk pelatihan, Cleanique Mart untuk distribusi dan retail, dan Depo Cleanique untuk kemitraan depo. [Cleanique Academy](https://cleaniqueacademy.com/), [Cleanique Mart](https://cleaniquemart.com/), [Depo Cleanique](https://depocleanique.co.id/).
- Malabeez untuk pewangi sajadah dan tekstil. Prokopi tercantum pada profil perusahaan dan pada WordPress lokal. [Malabeez](https://malabeez.co.id/), [Tentang Kami](https://indotech.id/tentang-kami/).

Audit ini mencatat klaim sebagaimana dipublikasikan. Validasi dokumen perusahaan, pengiriman lead, analitik produksi, dan pengujian semua detail individual berada di luar pemeriksaan publik ini.
