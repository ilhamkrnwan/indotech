# Audit Situs Aktif & Tema Produksi (`https://indotech.id`)

Audit dilakukan terhadap situs publik `https://indotech.id` serta source code tema aktif `wp-content/themes/indotech_custom` (basis commit produksi `780ef92` sebelum redesain).

## 1. Inventaris Gaya Tema Aktif Saat Ini

| Aspek | Kondisi Pada Tema Aktif (`origin/master`) |
| --- | --- |
| **Platform & Arsitektur** | WordPress custom PHP (`indotech_custom`) + plugin `indotech-core` (Carbon Fields) dengan CPT `product`, `brand`, `industry`, `application`, `testimonial`, serta taksonomi `product_cat`. |
| **Palet Warna** | Electric Blue (`#0057FF`), Cobalt Dark (`#0041CC`), Ink Dark (`#0A0F1E`), White (`#FFFFFF`), Surface (`#F8F9FC`), Border (`#E4E8F0`), dan WhatsApp Green (`#25D366`). Logo resmi Indotech sendiri memakai Biru Cobalt + Hijau Lime. |
| **Tipografi** | `Space Grotesk` (heading) dan `Inter` (body) dari berkas WOFF2 lokal (`assets/fonts/`). |
| **Header & Footer** | Header putih fixed `72px` dengan tombol `WhatsApp` hijau dan `Hubungi Kami` biru; footer 4 kolom gelap `#0A0F1E` disertai tombol melayang Scroll-Up & WhatsApp multi-CS. |
| **Struktur Beranda Aktif** | 9 bagian vertikal: Hero gelap abstrak + 3 kartu angka melayang → Stats Strip 4 kolom → Grid 6 Brand → 3 Kartu Layanan → Why Us 2 kolom → Marquee Testimoni bergerak otomatis → Blog Preview → FAQ Accordion (+ JSON-LD `FAQPage`) → CTA Banner gelap. |

## 2. Kekurangan Sebagai Company Profile B2B Profesional

| Prioritas | Temuan / Bukti di Tema & Situs Aktif | Dampak Bisnis & Teknis | Keputusan Perbaikan |
| --- | --- | --- | --- |
| **Kritis** | **Pilar bisnis B2B tidak imbang**: `hero.php` dan `services.php` hanya menonjolkan grosir dan kemitraan; jasa **Maklon & R&D** baru muncul di FAQ, sedangkan **Pelatihan (Cleanique Academy)** hanya jadi kartu brand. | Pemilik merek dan calon peserta pelatihan tidak langsung melihat penawaran relevan di layar pertama. | Tampilkan seluruh 4 pilar solusi B2B secara interaktif langsung di Hero Stage dan blok Solusi B2B gelap. |
| **Kritis** | **Inkonsistensi klaim legalitas**: `hero.php`, `services.php`, dan `page-tentang-kami.php` mencantumkan *BPOM, Halal MUI, ISO 9001*, sementara `faq.php` dan label kemasan fisik menyebut *Kemenkes RI PKD (PKRT)*. | Berisiko menimbulkan keraguan kepatuhan hukum B2B karena produk pembersih rumah tangga berada di bawah izin PKRT Kemenkes, bukan BPOM kosmetik/pangan. | Gunakan klaim **Izin Edar Kemenkes RI (PKRT/PKD)** dan **Sertifikasi Halal** pada beranda baru; tahan BPOM/ISO hingga dokumen resmi terkonfirmasi. |
| **Kritis** | **Absennya fotografi nyata & video profil**: Hero memakai latar gelap abstrak dengan kartu statistik kaca; tidak ada bagian video perkenalan maupun visual laboratorium/fasilitas. | Terlihat seperti situs SaaS generik, gagal membangun kredibilitas kapasitas pabrikasi dan kontrol kualitas R&D Indotech. | Hadirkan foto editorial fasilitas & laboratorium dengan safe-zone terukur, foto gerai mitra nyata, serta modul **Video Profil + Lightbox Modal** yang terhubung ke Customizer. |
| **Tinggi** | **Inkonsistensi data brand & usia perusahaan**: Hero menampilkan 7 pill brand (termasuk Prokopi), namun `brands.php` membatasi `posts_per_page => 6` sehingga Prokopi terpotong dari CPT; `stats.php` juga masih menulis `6 Brand` dan `13+ Tahun (sejak 2011)`. | Data perusahaan bertabrakan antarbagian dalam satu halaman beranda yang sama. | Selaraskan ke **7 Brand Portofolio** (termasuk Prokopi sebagai *Pembersih Mesin Kopi Profesional*, mengecualikan `cokusi`) dan **15+ Tahun Pengalaman (2011–2026)**. |
| **Menengah** | **Kelelahan visual & isu aksesibilitas**: Animasi `.reveal` membuat konten tersembunyi sampai di-scroll; marquee testimoni berjalan tanpa henti; menu mobile lama memakai `opacity`/`pointer-events` tanpa manajemen fokus keyboard lengkap. | Menyulitkan pembaca layar, pengguna keyboard, serta mengurangi fokus baca pada bukti sosial mitra. | Render konten langsung terlihat saat muat, ganti marquee otomatis dengan etalase 3 kartu kisah mitra interaktif yang dikontrol pengguna, dan lengkapi navigasi keyboard + `prefers-reduced-motion`. |
| **Menengah** | **Tidak ada standar produksi gambar latar & alur routing konsultasi lanjutan**: Belum ada aturan komposisi background image; formulir `page-kontak.php` belum memisahkan topik Maklon dan Pelatihan. | Gambar mudah terpotong di mobile atau teks kehilangan kontras di atas foto. | Terbitkan aturan baku background image di `media-dan-video.md` dan jadwalkan penyelarasan subjek formulir kontak pada fase rollout halaman dalam. |
