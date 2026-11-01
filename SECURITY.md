# 🛡️ Kebijakan Keamanan & Atribusi (*Security & Attribution Policy*)

<div align="center">

**Sistem Prediksi Persediaan Tiket Bus Trans Metro Pekanbaru — Metode Triple Exponential Smoothing**  
Dikembangkan oleh [**Radevanka Project**](https://radevankaproject.com)  
*“Build with Logic. Secure with Discipline. Deliver with Pride”*

</div>

---

## 1. ⚖️ Ketentuan Penggunaan Open Source & Kewajiban Atribusi (Wajib Dibaca)

Proyek ini dirilis sebagai **Open Source** untuk tujuan **edukasi, pembelajaran akademik, dan referensi Skripsi / Tugas Akhir Mahasiswa**. Anda diperbolehkan untuk mempelajari, memodifikasi, dan mengembangkan kode sumber ini dengan mematuhi ketentuan mutlak berikut:

### ✅ Yang Diperbolehkan:
- Menggunakan aplikasi ini sebagai bahan pembelajaran, riset akademik, atau referensi skripsi.
- Memodifikasi tampilan, dataset deret waktu (*time series*), koridor, maupun studi kasus sesuai kebutuhan penelitian akademik.
- Menambahkan nama Anda sebagai *kontributor / pengembang lanjutan* di samping kredit penulis dan pengembang awal.

### 🚫 Yang Dilarang Keras (*Strictly Prohibited*):
1. **DILARANG MENGHILANGKAN KREDIT AWAL (*Original Credit*)**  
   Anda **tidak diperbolehkan menghapus, menyembunyikan, atau mengganti total** identitas penulis penelitian (**Rahmad Rizki Adi — UIN Suska Riau**) dan pengembang awal (**Radevanka Project** / `radevankaproject.com`) baik pada:
   - Dokumentasi proyek (`README.md`, `SECURITY.md`).
   - Footer & atribut aplikasi (`$develop` & `$footer` di [`func.php`](func.php)).
   - Atribusi pengembang pada repositori hasil *fork* atau publikasi ulang.
2. **Dilarang Mengklaim Karya Secara Sepihak (*Plagiarisme Lisensi*)**  
   Mendistribusikan ulang atau memperjualbelikan *source code* ini secara komersial atas nama pihak lain dengan menghapus kredit **Radevanka Project** merupakan pelanggaran integritas karya intelektual.

---

## 2. 📌 Versi yang Didukung (*Supported Versions*)

Pembaruan keamanan dan perbaikan *bug* aktif diberikan untuk versi berikut:

| Versi | Status Dukungan | Keterangan |
| :--- | :---: | :--- |
| **v2.x (PHP 8 & KaTeX Edition)** | ✅ Didukung Penuh | Kompatibilitas penuh PHP 7.4/8.x, KaTeX Math Rendering, Proteksi CSRF, Anti-XSS, Prepared Statements & Bcrypt Password |
| **v1.x (Legacy 2019)** | ⚠️ Terbatas | Versi awal PHP 7.0 sebelum peningkatan keamanan & kompatibilitas PHP 8 |

---

## 3. 🔒 Standar Keamanan pada Aplikasi

Sesuai dengan prinsip ***"Build with Logic. Secure with Discipline. Deliver with Pride"***, aplikasi ini menerapkan lapisan keamanan berikut:

- **Access Control (`aut()`)**: Pembatasan hak akses halaman dashboard dan modul manajemen data menggunakan autentikasi sesi terverifikasi ([`func.php`](func.php)).
- **CSRF Token Protection**: Form autentikasi login dilindungi menggunakan token CSRF kriptografis berbasis sesi (`csrf_token()` & `verify_csrf_token()` dengan `random_bytes(32)` dan `hash_equals()`).
- **Password Hashing (`bcrypt`)**: Kata sandi pengguna dienkripsi satu arah menggunakan algoritma `PASSWORD_DEFAULT` (`password_hash()` & `password_verify()`) beserta mekanisme migrasi otomatis dari plaintext.
- **SQL Injection Prevention**: Proses autentikasi dan manajemen pengguna menggunakan *MySQLi Prepared Statements* (`mysqli::prepare` & `bind_param`).
- **XSS Mitigation & Session Hardening**: Input pengguna disanitasi menggunakan helper `clean_xss()` (`strip_tags` + `htmlspecialchars`) dan dilengkapi `session_regenerate_id(true)` untuk mencegah *Session Fixation*.

---

## 4. 🚨 Pelaporan Celah Keamanan (*Reporting a Vulnerability*)

Jika Anda menemukan celah keamanan (*security vulnerability*) atau pelanggaran atribusi pada proyek ini, mohon **jangan** mempublikasikannya secara terbuka di *public issue* sebelum diperbaiki. Silakan laporkan langsung kepada tim **Radevanka Project** melalui:

- 📧 **Email Resmi**: [hi@radevankaproject.com](mailto:hi@radevankaproject.com)
- 🌐 **Website**: [https://radevankaproject.com](https://radevankaproject.com)
- 📸 **Instagram / TikTok / Facebook / Threads**: `@radevankaproject`

Tim kami akan meninjau laporan Anda dan memberikan tanggapan secepatnya.

---

<div align="center">
  <sub>&copy; <strong>Radevanka Project</strong> • <em>"Build with Logic. Secure with Discipline. Deliver with Pride"</em></sub>
</div>
