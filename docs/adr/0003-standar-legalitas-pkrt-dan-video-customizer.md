---
status: accepted
---

# Standar klaim legalitas PKRT/Halal dan integrasi video profil melalui Customizer

Beranda baru hanya menampilkan klaim legalitas **Izin Edar Kemenkes RI (PKRT/PKD)** dan **Sertifikasi Halal** yang sesuai dengan kategori produk pembersih serta kemasan aktual, sambil menangguhkan klaim BPOM atau ISO 9001 hingga nomor registrasi dan sertifikat resmi per entitas tersedia.

Untuk memenuhi kebutuhan video perkenalan perusahaan tanpa mengikat halaman pada pemutar eksternal yang memblokir render awal, URL video dikelola melalui WordPress Customizer (`indotech_video_url`) dengan *lazy embed* di modal lightbox saat tombol Play ditekan, serta menyediakan preview storyboard 4 babak apabila URL video resmi belum diisi.
