<div align="center">

<img src="asts/plugins/images/f_tmp/logo01.png" alt="Logo Trans Metro Pekanbaru" width="120" />

# 🚌 Sistem Prediksi Persediaan Tiket Bus Trans Metro Pekanbaru — Metode Triple Exponential Smoothing
### Penerapan Data Mining Peramalan (*Forecasting*) Berbasis Web (Studi Kasus: UPT Pengelolaan Angkutan Perkotaan Dinas Perhubungan Kota Pekanbaru)

[![PHP](https://img.shields.io/badge/PHP-7.4%2B%20%7C%208.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-00802B?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Method](https://img.shields.io/badge/Metode-Triple%20Exponential%20Smoothing-F4B400?style=for-the-badge)](https://en.wikipedia.org/wiki/Exponential_smoothing#Triple_exponential_smoothing)
[![KaTeX](https://img.shields.io/badge/Math%20Render-KaTeX%20LaTeX-32797D?style=for-the-badge)](https://katex.org/)
[![License](https://img.shields.io/badge/Open%20Source-Edukasi%20%26%20Skripsi-D91B1B?style=for-the-badge)](#lisensi--edukasi)
[![Developer](https://img.shields.io/badge/Developed%20by-Radevanka%20Project-0B3D20?style=for-the-badge)](https://radevankaproject.com)

<p align="center">
  <strong>Aplikasi Peramalan (<em>Forecasting</em>) Open-Source untuk Pembelajaran & Referensi Skripsi Mahasiswa</strong><br/>
  Dikembangkan dengan penuh dedikasi oleh <a href="https://radevankaproject.com"><strong>Radevanka Project</strong></a><br/>
  <em>"Build with Logic. Secure with Discipline. Deliver with Pride"</em>
</p>

---

[📖 Tentang Skripsi](#-tentang-aplikasi--penelitian-skripsi) •
[✨ Fitur Utama](#-fitur-utama) •
[📐 Metodologi Triple Exponential Smoothing](#-metodologi-triple-exponential-smoothing-brown) •
[🗂️ Struktur Proyek](#️-struktur-proyek) •
[🚀 Cara Instalasi](#-cara-instalasi) •
[💼 Jasa Aplikasi Skripsi](#-butuh-bantuan-pembuatan-aplikasi-skripsi)

</div>

---

## 📖 Tentang Aplikasi & Penelitian Skripsi

Aplikasi ini merupakan implementasi dari penelitian **Tugas Akhir / Skripsi** dengan identitas akademik sebagai berikut:

| Informasi Akademik | Detail Penelitian |
| :--- | :--- |
| **Judul Skripsi** | **Penerapan Metode Triple Exponential Smoothing Dalam Memprediksi Persediaan Tiket Bus Trans Metro Pekanbaru** |
| **Studi Kasus** | Unit Pelaksanaan Teknis Pengelolaan Angkutan Perkotaan (UPT PAP) Dinas Perhubungan Kota Pekanbaru |
| **Penulis** | **Rahmad Riskiadi** (NIM: `11251105158`) |
| **Program Studi** | Teknik Informatika — Fakultas Sains dan Teknologi |
| **Universitas** | **Universitas Islam Negeri Sultan Syarif Kasim Riau (UIN Suska Riau)** |
| **Tahun Lulus** | 2019 |

### Latar Belakang Masalah
**Bus Trans Metro Pekanbaru (TMP)** merupakan sarana transportasi publik vital di Kota Pekanbaru yang beroperasi pada **13 koridor** dengan dua kategori tarif tiket: **Umum (Rp4.000)** dan **Pelajar (Rp3.000)**. Ketersediaan tiket fisik sangat krusial bagi kelancaran operasional bus:
- Tahun **2015**: Terjual `2.794.797` tiket umum dan `815.038` tiket pelajar.
- Tahun **2016**: Terjual `2.341.622` tiket umum dan `558.886` tiket pelajar.
- Tahun **2017**: Terjual `2.539.151` tiket umum dan `567.902` tiket pelajar (sedangkan pemesanan mencapai `3.150.000` tiket umum dan `700.000` tiket pelajar sehingga terjadi penumpukan sisa tiket di gudang).
- Tahun **2018**: Terjual `2.922.656` tiket umum dan `654.072` tiket pelajar.

Sebelumnya, proses rekapitulasi dan estimasi pemesanan tiket setiap triwulan di UPT PAP Dinas Perhubungan Kota Pekanbaru masih dilakukan secara manual menggunakan *Microsoft Excel* berdasarkan perkiraan kasar tahun sebelumnya. Hal tersebut mengakibatkan ketidakseimbangan antara jumlah pemesanan dan realisasi pemakaian tiket (kekurangan tiket pada triwulan tertentu atau kelebihan sisa tiket di akhir tahun yang tidak dapat dipakai kembali).

Melalui aplikasi ini, diterapkan metode **Triple Exponential Smoothing (Metode Satu Parameter Brown)** berbasis data deret waktu (*time series*) tahun **2015–2018** untuk memprediksi kebutuhan persediaan tiket pada tahun berikutnya secara akurat. Hasil pengujian menunjukkan nilai parameter optimal pada **$\alpha = 0.5$** dengan nilai kesalahan peramalan **Mean Absolute Percentage Error (MAPE) di bawah 10%** (rata-rata MAPE **9.24%** / akurasi **90.76%**), yang berarti kinerja peramalan tergolong **sangat baik (*very good*)**.

---

## ✨ Fitur Utama

### 1. 🧮 Detail Perhitungan Triple Exponential Smoothing *Step-by-Step* dengan KaTeX
Menampilkan penjabaran perhitungan matematis metode Triple Exponential Smoothing secara transparan untuk setiap koridor dan jenis tiket menggunakan **KaTeX LaTeX Math Rendering**:
- Tabel historis penjualan tiket per tahun per koridor.
- **Tahap 1**: Perhitungan *Single Smoothing* / Pemulusan Pertama ($S'_t$).
- **Tahap 2**: Perhitungan *Double Smoothing* / Pemulusan Kedua ($S''_t$).
- **Tahap 3**: Perhitungan *Triple Smoothing* / Pemulusan Ketiga ($S'''_t$).
- **Tahap 4**: Penentuan nilai Konstanta ($a_t$).
- **Tahap 5**: Penentuan nilai Slope Linier ($b_t$).
- **Tahap 6**: Penentuan nilai Slope Kuadratik ($c_t$).
- **Tahap 7**: Perhitungan nilai *Forecast* / Peramalan periode berikutnya ($F_{t+m}$).
- **Tahap 8**: Evaluasi error dan tingkat akurasi menggunakan **MAPE (*Mean Absolute Percentage Error*)**.

### 2. 📊 Manajemen Data Master & Data Deret Waktu (*Time Series*)
- **Manajemen Jenis Tiket**: Pengelolaan kategori tiket (`Umum` Rp4.000 dan `Pelajar` Rp3.000).
- **Manajemen Koridor**: Pengelolaan daftar 13 rute koridor Bus Trans Metro Pekanbaru (`Koridor 01`, `1A`, `02`, `03`, `4A`, `4B`, `4C`, `05`, `06`, `7A`, `7B`, `8A`, `8B` untuk masing-masing kategori Umum & Pelajar — total 26 entitas koridor).
- **Konfigurasi Nilai Alpha ($\alpha$)**: Pengaturan parameter bobot pemulusan eksponensial ($0 < \alpha < 1$, default optimal $\alpha = 0.5$).
- **Data Penjualan (Data Latih)**: Pencatatan data penjualan tiket historis per koridor dan tahun (2015–2018).
- **Data Uji (Data Aktual)**: Pencatatan data aktual untuk memvalidasi akurasi hasil peramalan beserta perhitungan otomatis `Error (-)`, `Error (+)`, `MAPE (%)`, `Rata-rata MAPE`, dan `Akurasi (%)`.

### 3. 🔐 Keamanan Modern & Kompatibilitas PHP 8.x
Aplikasi telah diperbarui (*modernized*) agar berjalan stabil dan aman di lingkungan server terbaru:
- **Password Hashing (`bcrypt`)**: Menggunakan `password_hash(..., PASSWORD_DEFAULT)` dan `password_verify()` dengan dukungan *auto-migration* dari password lama.
- **CSRF Protection**: Dilengkapi token kriptografis (`random_bytes(32)` & `hash_equals`) pada form autentikasi.
- **Anti-XSS & SQL Injection Prevention**: Sanitasi input menggunakan helper `clean_xss()` dan penggunaan **MySQLi Prepared Statements**.
- **Session Security**: Regenerasi ID sesi (`session_regenerate_id(true)`) saat login berhasil.
- **Full PHP 7.4 & PHP 8.x Support**: Bebas dari *Fatal Error* array key maupun ketidakcocokan mode SQL (`ONLY_FULL_GROUP_BY`).

---

## 📐 Metodologi Triple Exponential Smoothing (Brown)

Metode **Triple Exponential Smoothing Satu Parameter dari Brown** adalah metode peramalan deret waktu (*time series*) kuadratik yang digunakan ketika data historis menunjukkan adanya pola **tren non-linier / kuadratik** maupun fluktuasi tanpa unsur musiman.

Tahapan perhitungannya adalah sebagai berikut:

1. **Menentukan Pemulusan Pertama (*Single Smoothing* — $S'_t$)**
   $$S'_t = \alpha X_t + (1 - \alpha) S'_{t-1}$$
   *(Untuk periode awal $t = 1$, ditetapkan $S'_1 = S''_1 = S'''_1 = X_1$).*

2. **Menentukan Pemulusan Kedua (*Double Smoothing* — $S''_t$)**
   $$S''_t = \alpha S'_t + (1 - \alpha) S''_{t-1}$$

3. **Menentukan Pemulusan Ketiga (*Triple Smoothing* — $S'''_t$)**
   $$S'''_t = \alpha S''_t + (1 - \alpha) S'''_{t-1}$$

4. **Menentukan Nilai Konstanta ($a_t$)**
   $$a_t = 3S'_t - 3S''_t + S'''_t$$

5. **Menentukan Nilai Slope Linier ($b_t$)**
   $$b_t = \frac{\alpha}{2(1 - \alpha)^2} \left[ (6 - 5\alpha)S'_t - (10 - 8\alpha)S''_t + (4 - 3\alpha)S'''_t \right]$$

6. **Menentukan Nilai komponen Kuadratik ($c_t$)**
   $$c_t = \frac{\alpha^2}{(1 - \alpha)^2} \left( S'_t - 2S''_t + S'''_t \right)$$

7. **Menghitung Nilai Peramalan Periode Berikutnya ($F_{t+m}$)**
   $$F_{t+m} = a_t + b_t(m) + \frac{1}{2}c_t(m^2)$$
   *(Di mana $m$ adalah jumlah periode ke depan yang diramalkan, yakni $m = 1$ untuk 1 tahun berikutnya).*

8. **Menghitung Akurasi Peramalan dengan MAPE (*Mean Absolute Percentage Error*)**
   $$\text{PE}_t = \left| \frac{X_t - F_t}{F_t} \right| \times 100\% \quad , \quad \text{MAPE} = \frac{\sum_{t=1}^{n} \text{PE}_t}{n}$$
   $$\text{Akurasi} = 100\% - \text{MAPE}$$

   **Kriteria Nilai MAPE:**
   - $\text{MAPE} < 10\%$: Kemampuan peramalan **Sangat Baik**
   - $10\% \le \text{MAPE} < 20\%$: Kemampuan peramalan **Baik**
   - $20\% \le \text{MAPE} < 50\%$: Kemampuan peramalan **Cukup / Layak**
   - $\text{MAPE} \ge 50\%$: Kemampuan peramalan **Buruk**

---

## 🗂️ Struktur Proyek

```text
├── assets/                     # Asset utama (Bootstrap, FontAwesome, DataTables, jQuery UI)
├── asts/                       # Asset tambahan & ikon/logo Trans Metro Pekanbaru
│   └── plugins/images/f_tmp/   # Logo TMP, favicon, dan avatar pengguna
├── modul/                      # Modul-modul aplikasi (MVC Sederhana)
│   ├── home/
│   │   └── home.php            # Halaman beranda / sambutan dashboard
│   ├── user/
│   │   └── user.php            # CRUD Manajemen Pengguna (Bcrypt password_hash)
│   ├── jenis/
│   │   └── jenis.php           # CRUD Jenis & Harga Tiket (Umum / Pelajar)
│   ├── koridor/
│   │   └── koridor.php         # CRUD Data Koridor Bus TMP
│   ├── pengaturan/
│   │   └── pengaturan.php      # Pengaturan nilai parameter Alpha (α)
│   ├── penjualan/
│   │   ├── penjualan.php       # CRUD Data Penjualan Tiket per Tahun (Data Latih)
│   │   └── ajaxKoridor.php     # Endpoint Autocomplete pencarian Koridor
│   ├── datauji/
│   │   ├── datauji.php         # CRUD Data Uji / Aktual Penjualan Tiket
│   │   └── ajaxKoridor.php     # Endpoint Autocomplete pencarian Koridor
│   └── prediksi/
│       └── prediksi.php        # Halaman Tabel Hasil Prediksi, MAPE, Akurasi & Rincian Detail
├── .htaccess                   # Konfigurasi URL Rewrite untuk Apache (XAMPP/Laragon/cPanel)
├── dashboard.php               # Layout utama aplikasi (Navbar, Sidebar, KaTeX CDN, DataTables)
├── func.php                    # Konfigurasi DB, Security Helper (CSRF/XSS), Routing & Algoritma TES
├── index.php                   # Entry point aplikasi (Session check)
├── login.php                   # Halaman & Handler Autentikasi Login (Prepared Statement + CSRF)
└── tmptes.sql                  # File dump database MySQL lengkap (Data 2015–2018)
```

---

## 🚀 Cara Instalasi

### Prasyarat Sistem
- **PHP** versi `7.4` atau `8.x` (ekstensi `mysqli` aktif)
- **MySQL** atau **MariaDB**
- Web Server: **Apache** (Laragon / XAMPP / cPanel) atau **Nginx** (aaPanel / VPS)

### Langkah-Langkah Instalasi

1. **Clone / Unduh Repository**
   ```bash
   git clone https://github.com/radevankaproject/tmptes.git
   cd tmptes
   ```

2. **Buat Database & Import SQL**
   - Buat database baru di phpMyAdmin / MySQL dengan nama `sql_skripsi_tes` (atau sesuai keinginan).
   - Import file database [`tmptes.sql`](tmptes.sql) ke dalam database tersebut.

3. **Konfigurasi Koneksi Database**
   Buka file [`func.php`](func.php) dan sesuaikan kredensial database pada bagian atas:
   ```php
   $con = mysqli_connect("localhost", "sql_skripsi_tes", "password_anda", "sql_skripsi_tes");
   ```

4. **Konfigurasi Web Server (URL Rewrite)**
   - **Pengguna Apache (Laragon / XAMPP / cPanel)**:
     Pastikan `mod_rewrite` aktif dan sesuaikan `RewriteBase` di dalam file [`.htaccess`](.htaccess).
   - **Pengguna Nginx (aaPanel / VPS)**:
     Tambahkan konfigurasi berikut pada menu **URL Rewrite** di panel Nginx / aaPanel Anda:
     ```nginx
     location / {
         rewrite ^/([^/]+)/?$ /index.php?m=$1 last;
         rewrite ^/([^/]+)/([^/]+)/?$ /index.php?m=$1&a=$2 last;
         rewrite ^/([^/]+)/([^/]+)/([^/]+)/?$ /index.php?m=$1&a=$2&id=$3 last;
     }
     ```

5. **Login ke Aplikasi**
   Akses URL aplikasi melalui browser dan gunakan akun default berikut:
   - **Username**: `admin`
   - **Password**: `admin`

---

## 💼 Butuh Bantuan Pembuatan Aplikasi Skripsi?

Aplikasi ini di-*open-source*-kan secara gratis oleh **Radevanka Project** sebagai bentuk kontribusi nyata untuk dunia pendidikan dan referensi pembelajaran mahasiswa di Indonesia.

Namun, jika Anda membutuhkan:
- 🚀 **Pembuatan Aplikasi Skripsi / Tugas Akhir Custom** (Forecasting / Peramalan: *Single/Double/Triple Exponential Smoothing, Holt-Winters, Moving Average, ARIMA, Regresi Linier*; SPK: *TOPSIS, SAW, AHP, WP, MOORA, ELECTRE, PROMETHEE, SMART*; Data Mining: *K-Means, Naive Bayes, C4.5, Apriori, KNN, SVM*; Sistem Informasi Geografis, IoT, dll.)
- 🛠️ **Kustomisasi Fitur, Studi Kasus Baru, Upgrade ke PHP 8, atau Revisi Sidang Skripsi**
- 📱 **Aplikasi Berbasis Web (PHP Native, Laravel, CodeIgniter, Node.js, React) maupun Mobile (Flutter / Android)**

Jangan ragu untuk menghubungi tim kami! **Harga ramah kantong mahasiswa, mulai dari DI BAWAH 1 JUTA RUPIAH (< Rp1.000.000)!**

<div align="center">

### 🤝 Hubungi **Radevanka Project** Sekarang
> ***"Build with Logic. Secure with Discipline. Deliver with Pride"***

| Kanal Kontak | Informasi |
| :--- | :--- |
| 🏢 **Developer** | **Radevanka Project** |
| 🌐 **Website Resmi** | [**https://radevankaproject.com**](https://radevankaproject.com) |
| 📧 **Email** | [**hi@radevankaproject.com**](mailto:hi@radevankaproject.com) |
| 📸 **Instagram** | [**@radevankaproject**](https://instagram.com/radevankaproject) |
| 🎵 **TikTok** | [**@radevankaproject**](https://tiktok.com/@radevankaproject) |
| 📘 **Facebook** | [**@radevankaproject**](https://facebook.com/radevankaproject) |
| 🧵 **Threads** | [**@radevankaproject**](https://threads.net/@radevankaproject) |
| 💰 **Estimasi Biaya** | **Mulai dari di bawah Rp1.000.000** *(Konsultasi Gratis!)* |

</div>

---

## 📄 Lisensi & Edukasi

Source code proyek ini bersifat **Open Source** untuk keperluan **pembelajaran, riset akademik, dan referensi skripsi mahasiswa**. Silakan gunakan, pelajari, dan kembangkan lebih lanjut dengan tetap mencantumkan atribusi penulis penelitian (**Rahmad Riskiadi — UIN Suska Riau**) dan pengembang (**Radevanka Project**).

<div align="center">
  <sub>Dibuat dengan ❤️ oleh <a href="https://radevankaproject.com"><strong>Radevanka Project</strong></a> — <em>"Build with Logic. Secure with Discipline. Deliver with Pride"</em></sub>
</div>
