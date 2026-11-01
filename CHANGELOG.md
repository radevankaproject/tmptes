# 📋 Catatan Perubahan (*Changelog*)

<div align="center">

**Sistem Prediksi Persediaan Tiket Bus Trans Metro Pekanbaru — Metode Triple Exponential Smoothing**  
Dikembangkan oleh [**Radevanka Project**](https://radevankaproject.com)  
*“Build with Logic. Secure with Discipline. Deliver with Pride”*

</div>

Seluruh perubahan penting pada proyek ini didokumentasikan di dalam file ini.  
Format dokumentasi mengacu pada standar [Keep a Changelog](https://keepachangelog.com/id-ID/1.0.0/) dan menggunakan penomoran [Semantic Versioning](https://semver.org/lang/id/).

---

## [v2.0.0] — PHP 8, Security Hardening & KaTeX Math Edition (2026-11-01)

Rilis besar (*Major Release*) yang memodernisasi aplikasi skripsi agar berjalan penuh pada **PHP 8.x & MySQL 8**, meningkatkan standar keamanan autentikasi (*CSRF Token, Anti-XSS, Prepared Statements, Bcrypt Password Hashing*), menyematkan **KaTeX LaTeX Math Rendering** pada rincian rumus peramalan, serta memperbaiki akurasi operator eksponensial pada algoritma **Triple Exponential Smoothing**.

### ✨ Ditambahkan (*Added*)
- **Integrasi KaTeX LaTeX Math Rendering (`dashboard.php` & `func.php`)**:
  - Penyematan CDN **KaTeX v0.16.11** (`katex.min.css`, `katex.min.js`, dan `auto-render.min.js`) untuk merender rumus matematika secara murni di browser.
  - Konversi seluruh tahapan rumus **Triple Exponential Smoothing (Brown)** pada halaman detail prediksi (`prediksi/detail/{id}`) ke dalam notasi LaTeX:
    - Pemulusan Pertama ($S'_t = \alpha X_t + (1 - \alpha) S'_{t-1}$)
    - Pemulusan Kedua ($S''_t = \alpha S'_t + (1 - \alpha) S''_{t-1}$)
    - Pemulusan Ketiga ($S'''_t = \alpha S''_t + (1 - \alpha) S'''_{t-1}$)
    - Konstanta ($a_t = 3S'_t - 3S''_t + S'''_t$)
    - Slope Linier ($b_t$) dan Slope Kuadratik ($c_t$)
    - Peramalan Periode Berikutnya ($F_{t+m} = a_t + b_t(m) + \frac{1}{2}c_t(m^2)$)
    - Perhitungan `Error (-)`, `Error (+)`, `MAPE (%)`, dan `Akurasi (%)`.
- **Tabel Ringkasan Akurasi pada Detail Prediksi (`func.php`)**:
  - Penambahan tabel ringkasan hasil akhir per koridor yang menampilkan kolom `Koridor`, `Jenis`, `Prediksi Penjualan`, `Aktual`, `Error (-)`, `Error (+)`, `MAPE (%)`, dan `Akurasi (%)`.
- **Lapisan Keamanan Autentikasi & Form (`func.php`, `login.php`, `modul/user/user.php`)**:
  - Helper `csrf_token()` dan `verify_csrf_token()` menggunakan `random_bytes(32)` serta `hash_equals()`.
  - Helper `clean_xss()` (`strip_tags` + `htmlspecialchars`) untuk mencegah serangan *Cross-Site Scripting* (XSS).
  - Enkripsi password satu arah menggunakan algoritma `bcrypt` (`password_hash(..., PASSWORD_DEFAULT)` & `password_verify()`) disertai fitur *auto-migration* dari password lama (plaintext).
  - Regenerasi ID sesi (`session_regenerate_id(true)`) saat login untuk mencegah *Session Fixation*.
- **Dukungan Multi-Web Server (Apache & Nginx aaPanel)**:
  - Dukungan URL Rewrite untuk server **Nginx (aaPanel / VPS)** di samping `.htaccess` untuk **Apache (XAMPP / Laragon / cPanel)**.
- **Dokumentasi Standar Open-Source Radevanka Project**:
  - Penambahan [`README.md`](README.md), [`SECURITY.md`](SECURITY.md), [`CHANGELOG.md`](CHANGELOG.md), dan [`.gitignore`](.gitignore).

### 🔄 Diubah (*Changed*)
- **Tampilan Tabel Prediksi Lengkap (`modul/prediksi/prediksi.php` & `dashboard.php`)**:
  - Konfigurasi DataTables `#t_prediksi` dengan `pageLength: -1` dan `responsive: false` agar seluruh 26 baris data koridor (13 koridor $\times$ 2 jenis tiket) beserta semua kolom (`Koridor`, `Jenis`, `Prediksi Penjualan`, `Aktual`, `Error (-)`, `Error (+)`, `MAPE (%)`, `Detail`) tampil utuh sekaligus tanpa terpotong paginasi.
- **Privasi Tabel Manajemen Pengguna (`modul/user/user.php` & `tmptes.sql`)**:
  - Penghapusan kolom `Password` dari tabel daftar pengguna pada halaman `/user`.
  - Perubahan tipe input password menjadi `type="password"` serta opsi pengosongan kolom password saat *update* user jika tidak ingin mengubah password.
  - Perluasan kolom `user.password` di database dari `VARCHAR(35)` menjadi `VARCHAR(255)` untuk menampung hash `bcrypt`.
- **Deteksi Base URL Dinamis (`func.php`)**:
  - Variabel `$site` kini otomatis mendeteksi protokol (`http` / `https` maupun reverse proxy `HTTP_X_FORWARDED_PROTO`) dan nama domain aktif.

### 🐛 Diperbaiki (*Fixed*)
- **Perbaikan Bug Operator Eksponensial Rumus Forecast $F_{t+m}$ (`func.php`)**:
  - Perbaikan ekspresi `(1^2)` pada perhitungan $F_{t+m} = a_t + b_t(m) + \frac{1}{2}c_t(m^2)$ di fungsi `prediksi()` dan `prediksiTiket()`. Di PHP, operator `^` merupakan *bitwise XOR* (`1 ^ 2 = 3`), sehingga sebelumnya nilai komponen kuadratik $\frac{1}{2}c_t$ dikalikan `3` alih-alih $1^2 = 1$. Kini diperbaiki menggunakan `pow(1, 2)`.
- **Perbaikan Variabel Pemulusan Pertama (`func.php`)**:
  - Perbaikan *undefined variable* `$pemakaian[$i-1]` menjadi `$penjualan[$i-1]` pada iterasi kedua ($t = 2$) perhitungan *Single Smoothing* ($S'_t$).
- **Kompatibilitas Penuh PHP 8.x & MySQL 8 (`login.php`, `dashboard.php`, `func.php`, `modul/*`)**:
  - Perbaikan seluruh *Fatal Error: Uncaught Error: Undefined constant* akibat penulisan *unquoted array keys* (`$r['username']`, `$_SESSION['level']`, `$_GET['m']`, dll.) di seluruh modul.
  - Perbaikan pemanggilan `number_format(..., 4, '.', '')` tanpa pemisah ribuan koma agar tidak memicu `TypeError: Unsupported operand types` pada operasi aritmatika float di PHP 8.
  - Penonaktifan mode `ONLY_FULL_GROUP_BY` pada koneksi MySQLi agar query agregasi per koridor berjalan lancar di MySQL 8 / MariaDB terbaru.

---

## [v1.0.0] — Initial Release / Sidang Skripsi (2019-05-20)

Rilis perdana aplikasi **Penerapan Metode Triple Exponential Smoothing Dalam Memprediksi Persediaan Tiket Bus Trans Metro Pekanbaru (Studi Kasus: UPT Pengelolaan Angkutan Perkotaan Dinas Perhubungan Kota Pekanbaru)** pada **20 Mei 2019** oleh **Rahmad Riskiadi (NIM: 11251105158)** — Teknik Informatika, Fakultas Sains dan Teknologi, **UIN Sultan Syarif Kasim Riau**.

### ✨ Fitur Awal
- Mesin perhitungan **Triple Exponential Smoothing (Metode Satu Parameter Brown)** untuk meramalkan persediaan tiket Bus Trans Metro Pekanbaru:
  1. Pemulusan Tunggal ($S'_t$)
  2. Pemulusan Ganda ($S''_t$)
  3. Pemulusan Majemuk / Triple ($S'''_t$)
  4. Penentuan Konstanta ($a_t$), Slope ($b_t$), dan Kuadratik ($c_t$)
  5. Perhitungan Forecast tahun berikutnya ($F_{t+m}$)
  6. Pengujian tingkat kesalahan peramalan menggunakan **MAPE (*Mean Absolute Percentage Error*)**
- Dataset historis penjualan tiket Bus Trans Metro Pekanbaru tahun **2015–2018** pada **13 Koridor** (`Koridor 01`, `1A`, `02`, `03`, `4A`, `4B`, `4C`, `05`, `06`, `7A`, `7B`, `8A`, `8B`) untuk kategori **Umum (Rp4.000)** dan **Pelajar (Rp3.000)**.
- Modul CRUD Data Master: Pengguna (`/user`), Jenis Tiket (`/jenis`), Koridor Bus (`/koridor`), dan Nilai Alpha (`/pengaturan`).
- Modul CRUD Data Tiket: Data Penjualan / Latih (`/penjualan`) dan Data Uji / Aktual (`/datauji`) dilengkapi fitur *autocomplete* pencarian koridor.
- Modul Tabel Peramalan & Detail Perhitungan (`/prediksi` & `/prediksi/detail/{id}`).

---

<div align="center">
  <sub>Dikembangkan oleh <a href="https://radevankaproject.com"><strong>Radevanka Project</strong></a> • <a href="mailto:hi@radevankaproject.com">hi@radevankaproject.com</a> • <code>@radevankaproject</code></sub><br/>
  <sub><em>"Build with Logic. Secure with Discipline. Deliver with Pride"</em></sub>
</div>
