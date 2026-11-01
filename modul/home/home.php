<?php
$a=$_SESSION['level'] ?? '';
switch($a){
	case '1':
?>
	
<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line">DASHBOARD</h1>
                    </div>
             </div>
				
				
				<div class="row">
            <div class="col-lg-12">
				
				 <h3>Selamat Datang di Sistem Prediksi Penjualan Tiket Bus Trans Metro Pekanbaru (SiPeTi TMP)</h3>
                        <div class="alert alert-info">
                            <strong><u>Panduan (Sistem Prediksi ini Menggunakan Metode Perhitungan Triple Exponential Smoothing):</u></strong><br/>
							<ol>
							<li>Menu Pengguna, menu untuk mengelola penggguna yang menggunakan SiPeTi TMP</li>
                            <li>Menu Jenis, menu untuk mengelola data jenis tiket yang digunakan untuk data jenis tiket pada koridor. </li>
							<li>Menu Koridor,menu untuk mengelola Data Koridor. </li>
							<li>Menu Nilai Alpha, menu untuk menentukan nilai aplha (&alpha;) yang digunakan untuk perhitungan Peramalan Triple Exponential Smoothing </li>
							<li>Menu Penjualan, merupakan menu yang digunakan untuk penginputan data penjualan serta melihat total masing-masing penjualan per tahun</li>
                            <li>Menu Data Uji, merupakan menu yang digunakan untuk data perbandingan pada proses Peramalan Triple Exponential Smoothing</li>
							<li>Menu Prediksi, merupakan menu yang digunakan untuk melihat prediksi penjualan tiket bus TMP</li>
							<li>Menu Logout, merupakan menu yang digunakan untuk keluar SiPeTi TMP</li>
                    </div>
							</ol>

                        </div>
              
             
            </div>
			
<?php break; ?>

<?php }	?>
    