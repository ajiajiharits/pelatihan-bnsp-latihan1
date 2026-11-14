APLIKASI PENDAFTARAN SISWA - HTML, PHP, MYSQL

FITUR
- Create: menambahkan data siswa
- Read: menampilkan data siswa
- Update: mengubah data siswa
- Delete: menghapus data siswa

PERSIAPAN
1. Install XAMPP.
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Salin folder aplikasi_pendaftaran_siswa ke:
   C:\xampp\htdocs\
4. Buka phpMyAdmin melalui:
   http://localhost/phpmyadmin
5. Pilih menu Import, lalu pilih file database.sql dari folder proyek.
6. Klik Import / Go untuk membuat database dan tabel.
7. Buka aplikasi melalui browser:
   http://localhost/aplikasi_pendaftaran_siswa/

PENGATURAN DATABASE
Buka koneksi.php.
Konfigurasi default XAMPP:
- host: localhost
- database: db_pendaftaran_siswa
- username: root
- password: kosong

Jika MySQL Anda menggunakan password, ubah nilai $password di koneksi.php.

CATATAN
Pilihan Paket A, Paket B, dan Paket C adalah contoh karena nama paket
sebenarnya belum disebutkan. Silakan ganti pilihan tersebut di index.php
dan daftar validasi di proses.php agar sama.
