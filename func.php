<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
ini_set('max_execution_time', 3600);
$site=((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/";
$develop=" Rahmad Riskiadi";
$aplikasi="SiPeTi TMP";
$website="Trans Metro Pekanbaru";
$footer="&COPY; " .date('Y') . $develop. "  | Sistem Informasi Penjualan Tiket TMP";


#koneksi
mysqli_report(MYSQLI_REPORT_OFF);
$con = new mysqli('localhost','sql_skripsi_tes','@m3ck1nd4hTES','sql_skripsi_tes');
if($con->connect_error){
	die("Koneksi gagal: ".$con->connect_error);
}
$con->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

#keamanan CSRF & Anti-XSS
function csrf_token(){
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

function verify_csrf_token($token){
	if (empty($_SESSION['csrf_token']) || empty($token) || !is_string($token)) {
		return false;
	}
	return hash_equals($_SESSION['csrf_token'], $token);
}

function clean_xss($data){
	if (!is_string($data)) {
		return '';
	}
	return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

#money / duid
function money($val, $val2 = ",-") {
    if (strpos($val, ',') !== false) {
        return $val;
    } else {
        $arr = explode('.', $val);
        if (count($arr) == 1) {
            return number_format((double)$val, 0, ',', '.').$val2;
        } else {
            $val2 = substr($arr[1], 0, 2);
            if (strlen($val2) == 1) {
                $val2 = $val2."0";
            }
            return number_format((double)$arr[0], 0, ',', '.').",".$val2;
        }
    }
}

function angka($val, $val2 = "") {
    if (strpos($val, ',') !== false) {
        return $val;
    } else {
        $arr = explode('.', $val);
        if (count($arr) == 1) {
            return number_format((double)$val, 0, ',', '.').$val2;
        } else {
            $val2 = substr($arr[1], 0, 2);
            if (strlen($val2) == 1) {
                $val2 = $val2."0";
            }
            return number_format((double)$arr[0], 0, ',', '.').",".$val2;
        }
    }
}

#javascript
function javascript($m,$t,$pesan=''){//$t=redirect,alert,confirm
	global $site;
	$safeUrl = htmlspecialchars($site.$m, ENT_QUOTES, 'UTF-8');
	if($t=='redirect'){
		echo "<script>window.location='".$safeUrl."';</script>";
	}elseif($t=='alert'){
		$safePesan = htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8');
		echo "<script>alert('".$safePesan."');
				window.location='".$safeUrl."';</script>";
	}elseif($t=='confirm'){
		echo "			<script language='JavaScript'>
			function konfirmasi()
			{
			tanya = confirm('Anda Yakin Akan Menghapus Data ?');
			if (tanya == true) return true;
			else return false;
			}
			</script>";
	}
}

#autentikasi
function aut($level=array()){
	//aut(array(1,4));penggunaan
	global $site;
	if(!in_array($_SESSION['level'] ?? null,$level)){
		echo '<meta http-equiv="refresh" content="0; url='.$site.'" />';exit;
	}
}

#modul
function modul($m){
	global $con;
	global $site;
	if(empty($m)){
		include "modul/home/home.php";
	}elseif($m=='logout'){
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		session_destroy();
		javascript('','redirect');
	}else{
		return include "modul/$m/$m.php";
	}
}

function menu(){
	global $site;
	$l=$_SESSION['level'] ?? '';
	switch($l){
		case '1'://admin
		echo  '     <li><a class="" href="'.$site.'" ><i class="fa fa-home "></i>Dashboard</a></li>
                    <li>
					    <a href="javascript:void(0);"><i class="fa fa-gears "></i>Data Master <span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
					        <li><a href="'.$site.'user"><i class="fa fa-user "></i>Pengguna </a></li>
					        <li><a href="'.$site.'jenis"><i class="fa fa-check-circle-o "></i>Jenis </a></li>
					        <li><a href="'.$site.'koridor"><i class="fa  fa-bus"></i>Koridor </a></li>
                            <li><a href="'.$site.'pengaturan"><i class="fa  fa-at"></i>Nilai Aplha </a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:void(0);"><i class="fa fa-ticket "></i>Data Tiket <span class="fa arrow"></span></a>
						 <ul class="nav nav-second-level">
						 <li><a href="'.$site.'penjualan"><i class="fa fa-dollar"></i>Penjualan </a></li>
						 <li><a href="'.$site.'datauji"><i class="fa fa-table"></i>Data Uji </a></li>
						 </ul>
					</li>
                    <li><a href="'.$site.'prediksi"><i class="fa fa-calendar"></i>Prediksi </a></li>
					<li><a href="'.$site.'logout"><i class="fa fa-power-off "></i>Logout</a></li>
					  ';
			break;
	
	}
}

function prediksi($koridorID){//detail
	global $con;
	$a=$con->query("SELECT value FROM pengaturan")->fetch_object();
	$koridor=$con->query("SELECT * FROM koridor a, jenis b WHERE a.jenisID=b.id AND a.id='$_GET[id]'")->fetch_object();
	  echo '
	  <h2><b>Detail Perhitungan Triple Exponential Smoothing Data ( '.$koridor->koridor.' - '.$koridor->jenisTiket.' )</b></h2><hr/>
	  <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
									<tr>
										<th colspan="2">'.$koridor->koridor.' - '.$koridor->jenisTiket.'</th>
                                    </tr>
                                    <tr>
                                        <th style="width:7%;">Tahun</th>
										<th>Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody>';
									$t=$con->query("SELECT tahun,koridor FROM penjualan a, koridor b WHERE a.koridorID=b.id AND a.koridorID='$koridorID' GROUP BY tahun ORDER BY tahun ASC");
									$i=1;
									while($r=$t->fetch_object()){ 
										$tahun[$i]=$r->tahun;
										$jml=$con->query("SELECT sum(jumlah) AS jumlah FROM penjualan WHERE koridorID='$koridorID' AND tahun='$r->tahun' ")->fetch_object();
										$penjualan[$i]=$jml->jumlah;
										echo "<tr>
										<th class='text-center'>$r->tahun</th>
										<th>$penjualan[$i]</th>
										</tr>";
									$i++;
									}
									echo '
                                </tbody>
                            </table>
                        </div>';




    # Menentukan Smoothing pertama ( S't ) [ S't = α Xt + (1 - α) S't-1 ]
    echo "<h3>Menentukan Smoothing Pertama \\( (S'_t) \\) &mdash; \\( S'_t = \\alpha X_t + (1 - \\alpha) S'_{t-1} \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sSingle[$i]=$penjualan[$i];
            echo "\\( S'_{$i} = {$sSingle[$i]} \\)<br/>";
        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sSingle[$i]=($a->value*$penjualan[$i])+($aa*$st);
            echo "\\( S'_{$i} = ({$a->value})({$penjualan[$i]}) + ({$aa})({$st}) = {$sSingle[$i]} \\)<br/>";
        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sSingle[$i]=($a->value*$penjualan[$i])+($aa*$sSingle[$i-1]);
            echo "\\( S'_{$i} = ({$a->value})({$penjualan[$i]}) + ({$aa})(".$sSingle[$i-1].") = {$sSingle[$i]} \\)<br/>";
        }
    }

    # Menentukan Smoothing kedua ( S''t ) [ S''t = α S't + (1 - α) S''t-1 ]
    echo "<h3>Menentukan Smoothing Kedua \\( (S''_t) \\) &mdash; \\( S''_t = \\alpha S'_t + (1 - \\alpha) S''_{t-1} \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sDouble[$i]=$penjualan[$i];
            echo "\\( S''_{$i} = {$sSingle[$i]} \\)<br/>";
        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sDouble[$i]=($a->value*$sSingle[$i])+($aa*$st);
            echo "\\( S''_{$i} = ({$a->value})({$sSingle[$i]}) + ({$aa})({$st}) = {$sDouble[$i]} \\)<br/>";
        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sDouble[$i]=($a->value*$sSingle[$i])+($aa*$sDouble[$i-1]);
            echo "\\( S''_{$i} = ({$a->value})({$sSingle[$i]}) + ({$aa})(".$sDouble[$i-1].") = {$sDouble[$i]} \\)<br/>";
        }
    }

    # Menentukan Smoothing ketiga ( S'''t ) [ S'''t = α S''t + (1 - α) S'''t-1 ]
    echo "<h3>Menentukan Smoothing Ketiga \\( (S'''_t) \\) &mdash; \\( S'''_t = \\alpha S''_t + (1 - \\alpha) S'''_{t-1} \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sTriple[$i]=$penjualan[$i];
            echo "\\( S'''_{$i} = {$sDouble[$i]} \\)<br/>";
        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sTriple[$i]=($a->value*$sDouble[$i])+($aa*$st);
            echo "\\( S'''_{$i} = ({$a->value})({$sDouble[$i]}) + ({$aa})({$st}) = {$sTriple[$i]} \\)<br/>";
        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sTriple[$i]=($a->value*$sDouble[$i])+($aa*$sTriple[$i-1]);
            echo "\\( S'''_{$i} = ({$a->value})({$sDouble[$i]}) + ({$aa})(".$sTriple[$i-1].") = {$sTriple[$i]} \\)<br/>";
        }
    }

    # Menentukan besarnya Konstanta ( at ) [ at = 3S't - 3S''t + S'''t ]
    echo "<h3>Menentukan Besarnya Konstanta \\( (a_t) \\) &mdash; \\( a_t = 3S'_t - 3S''_t + S'''_t \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){
        $at[$i]=(3*$sSingle[$i])-(3*$sDouble[$i])+$sTriple[$i];
        echo "\\( a_{$i} = 3({$sSingle[$i]}) - 3({$sDouble[$i]}) + ({$sTriple[$i]}) = {$at[$i]} \\)<br/>";
    }

    # Menentukan besarnya Slope ( bt ) [ α/{2(1-α)^2}][(6-5 α)S't - (10-8 α)S''t + (4-3 α)S'''t]
    echo "<h3>Menentukan Besarnya Slope \\( (b_t) \\) &mdash; \\( b_t = \\frac{\\alpha}{2(1-\\alpha)^2} \\left[ (6 - 5\\alpha)S'_t - (10 - 8\\alpha)S''_t + (4 - 3\\alpha)S'''_t \\right] \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){

        # Mencari Hasil Dari [ α/{2(1-α)^2}]
        $alp  = $a->value;
        $alp2 = 2*(pow(1-$alp,2));
        $alp3 = $alp/$alp2;


        //$bt[$i]=($a->value/$aa)*($sSingle[$i]-$sDouble[$i]);
        $bt[$i]=$alp3*(((6-5*($alp))*$sSingle[$i])-((10-8*($alp))*$sDouble[$i])+((4-3*($alp))*$sTriple[$i]));
        echo "\\( b_{$i} = \\frac{{$a->value}}{2(1 - {$a->value})^2} \\left[ (6 - 5({$alp}))({$sSingle[$i]}) - (10 - 8({$alp}))({$sDouble[$i]}) + (4 - 3({$alp}))({$sTriple[$i]}) \\right] = {$bt[$i]} \\)<br/>";
    }

    # Menentukan besarnya Slope ( ct ) [ α^2 / (1-α)^2 ][ S't - 2S''t + S'''t ]
    echo "<h3>Menentukan Besarnya Slope \\( (c_t) \\) &mdash; \\( c_t = \\frac{\\alpha^2}{(1-\\alpha)^2} \\left( S'_t - 2S''_t + S'''_t \\right) \\)</h3>";
    for($i=1;$i<=count($tahun);$i++){

        # Mencari Hasil Dari [ α^2/(1-α)^2 ]
        $alp  = $a->value;
        $alp2 = pow($alp,2)/pow(1-$alp,2);

        //$bt[$i]=($a->value/$aa)*($sSingle[$i]-$sDouble[$i]);
        $ct[$i]=$alp2*(($sSingle[$i])-(2*$sDouble[$i])+($sTriple[$i]));
        echo "\\( c_{$i} = \\frac{{$alp}^2}{(1 - {$alp})^2} \\left[ ({$sSingle[$i]}) - 2({$sDouble[$i]}) + ({$sTriple[$i]}) \\right] = {$ct[$i]} \\)<br/>";
    }

    # Menentukan besarnya forecast ( Ft+m ) [ Ft+m = at + bt(m) + 0.5ct(m^2) ]
    echo "<h3>Menentukan Besarnya Forecast \\( (F_{t+m}) \\) &mdash; \\( F_{t+m} = a_t + b_t(m) + \\frac{1}{2}c_t(m^2) \\)</h3>";

    $lastAt = end($at);
    $lastBt = end($bt);
    $lastCt = end($ct);
    $ft = $lastAt + ($lastBt * 1) + (0.5 * $lastCt * pow(1, 2));
    echo "<h5><b>\\( F_{t+1} = ({$lastAt}) + ({$lastBt})(1) + \\frac{1}{2}({$lastCt})(1^2) = {$ft} \\)</b></h5><br>";
    $s=$ft;
    $nb= round($s);
    echo "<h5><b>Prediksi penjualan tahun berikutnya \\( (\\approx \\text{round}(F_{t+1})) = {$nb} \\)</b></h5><p/>";


    # Akurasi
    echo "<h3>Akurasi MAPE (Mean Absolute Percentage Error) Penjualan Tiket Bus (".$koridor->koridor." - ".$koridor->jenisTiket.")</h3>";
    $dataUji=$con->query("SELECT * FROM data_uji WHERE koridorID='$koridorID'")->fetch_object();

    $prediksi=round($s);
    if(empty($dataUji->jumlah)){
        $aktual=0;
    }else{
        $aktual=$dataUji->jumlah;
    }
    $errorMin=$aktual-$prediksi;
    $error=abs($errorMin);
    $mape=number_format(($error/$prediksi)*100,2,'.','');
    $akurasi=100-(float)$mape;
    echo "
 \\( \\text{Prediksi } (F_t) = \\mathbf{{$prediksi}} \\) <br/>
 \\( \\text{Aktual } (X_t) = \\mathbf{{$aktual}} \\)<br/>
 \\( \\text{Error } (-) = X_t - F_t = {$aktual} - {$prediksi} = \\mathbf{{$errorMin}} \\)<br/>
 \\( \\text{Error } (+) = |X_t - F_t| = |{$aktual} - {$prediksi}| = \\mathbf{{$error}} \\)<br/>
 \\( \\text{MAPE} = \\frac{|X_t - F_t|}{F_t} \\times 100\\% = \\frac{{$error}}{{$prediksi}} \\times 100\\% = \\mathbf{{$mape}\\%} \\)<br/>
 \\( \\text{Akurasi} = 100\\% - \\text{MAPE} = 100\\% - {$mape}\\% = \\mathbf{{$akurasi}\\%} \\) <br/><br/>
 <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover'>
        <thead>
            <tr>
                <th>Koridor</th>
                <th>Jenis</th>
                <th>Prediksi Penjualan</th>
                <th>Aktual</th>
                <th>Error (-)</th>
                <th>Error (+)</th>
                <th>MAPE (%)</th>
                <th>Akurasi (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{$koridor->koridor}</td>
                <td>{$koridor->jenisTiket}</td>
                <td>{$prediksi}</td>
                <td>{$aktual}</td>
                <td>{$errorMin}</td>
                <td>{$error}</td>
                <td>{$mape}%</td>
                <td>{$akurasi}%</td>
            </tr>
        </tbody>
    </table>
 </div>";

//    echo"</br>";
//    echo"</br>";
//    echo"</br>";
//    echo"Mencari Nilai Aplha</br>";
//    $d1 = 1052325; #Data Penjualan Koridor 01 - Umum (2015)
//    $d2 = 959375;  #Data Penjualan Koridor 01 - Umum (2016)
//    $d3 = 1051108; #Data Penjualan Koridor 01 - Umum (2017)
//
//    #0.1
//    $d  = (0.1*$d2)+(1-0.1)*$d1;
//    $dd = (0.1*$d3)+(1-0.1)*$d2;
//    $hd = $d-$dd;
//
//
//    #0.2
//    $e  = (0.2*$d2)+(1-0.2)*$d1;
//    $ee = (0.2*$d3)+(1-0.2)*$d2;
//    $he = $e-$ee;
//
//
//    #0.3
//    $f  = (0.3*$d2)+(1-0.3)*$d1;
//    $ff = (0.3*$d3)+(1-0.3)*$d2;
//    $hf = $f-$ff;
//
//
//    #0.4
//    $g  = (0.4*$d2)+(1-0.4)*$d1;
//    $gg = (0.4*$d3)+(1-0.4)*$d2;
//    $hg = $g-$gg;
//
//
//    #0.5
//    $z  = (0.5*$d2)+(1-0.5)*$d1;
//    $zz = (0.5*$d3)+(1-0.5)*$d2;
//    $hz = $z-$zz;
//
//    #0.6
//    $y  = (0.6*$d2)+(1-0.6)*$d1;
//    $yy = (0.6*$d3)+(1-0.6)*$d2;
//    $hy = $y-$yy;
//
//    #0.7
//    $w  = (0.7*$d2)+(1-0.7)*$d1;
//    $ww = (0.7*$d3)+(1-0.7)*$d2;
//    $hw = $w-$ww;
//
//    #0.8
//    $x  = (0.8*$d2)+(1-0.8)*$d1;
//    $xx = (0.8*$d3)+(1-0.8)*$d2;
//    $hx = $x-$xx;
//
//    #0.9
//    $t  = (0.9*$d2)+(1-0.9)*$d1;
//    $tt = (0.9*$d3)+(1-0.9)*$d2;
//    $ht = $t-$tt;
//
//    #0.1
//    echo "0.1($d2) + (1-0.1)$d1= $d</br>";
//    echo "(0.1($d3)) + (1-0.1)$d2= $dd</br>";
//    echo "$d - $dd = $hd</br>";
//    echo "</br>";
//
//    #0.2
//    echo "(0.2 * $d2) + (1 - 0.2)$d1= $e</br>";
//    echo "(0.2 * $d3) + (1 - 0.2)$d2= $ee</br>";
//    echo "$e - $ee = $he</br>";
//    echo "</br>";
//
//    #0.3
//    echo "(0.3 * $d2) + (1 - 0.3)$d1= $f</br>";
//    echo "(0.3 * $d3) + (1 - 0.3)$d2= $ff</br>";
//    echo "$f - $ff = $hf</br>";
//    echo "</br>";
//
//    #0.4
//    echo "(0.4 * $d2) + (1 - 0.4)$d1= $g</br>";
//    echo "(0.4 * $d3) + (1 - 0.4)$d2= $gg</br>";
//    echo "$g - $gg = $hg</br>";
//    echo "</br>";
//
//    #0.5
//    echo "(0.5 * $d2) + (1 - 0.5)$d1= $z</br>";
//    echo "(0.5 * $d3) + (1 - 0.5)$d2= $zz</br>";
//    echo "$z - $zz = $hz</br>";
//    echo "</br>";
//
//    #0.6
//    echo "(0.6 * $d2) + (1 - 0.6)$d1= $y</br>";
//    echo "(0.6 * $d3) + (1 - 0.6)$d2= $yy</br>";
//    echo "$y - $yy = $hy</br>";
//    echo "</br>";
//
//    #0.7
//    echo "(0.7 * $d2) + (1 - 0.7)$d1= $w</br>";
//    echo "(0.7 * $d3) + (1 - 0.7)$d2= $ww</br>";
//    echo "$w - $ww = $hw</br>";
//    echo "</br>";
//
//    #0.8
//    echo "(0.8 * $d2) + (1 - 0.8)$d1= $x</br>";
//    echo "(0.8 * $d3) + (1 - 0.8)$d2= $xx</br>";
//    echo "$x - $xx = $hx</br>";
//    echo "</br>";
//
//    #0.9
//    echo "(0.9 * $d2) + (1 - 0.9)$d1= $t</br>";
//    echo "(0.9 * $d3) + (1 - 0.9)$d2= $tt</br>";
//    echo "$t - $tt = $ht</br>";
//    echo "</br>";
}

function prediksiTiket($koridorID){//per koridor
	global $con;
	$a=$con->query("SELECT value FROM pengaturan")->fetch_object();
	
	$t=$con->query("SELECT tahun FROM penjualan WHERE koridorID='$koridorID' GROUP BY tahun ORDER BY tahun ASC");
	$i=1;
	while($r=$t->fetch_object()){ 
		$tahun[$i]=$r->tahun;
		$jml=$con->query("SELECT sum(jumlah) AS jumlah FROM penjualan WHERE koridorID='$koridorID' AND tahun='$tahun[$i]' ")->fetch_object();
		$penjualan[$i]=$jml->jumlah;
	$i++;
	}

    # Menentukan Smoothing pertama ( Sʾt ) [ S’t = α Xt + (1- α) S’t-1 ]
    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sSingle[$i]=$penjualan[$i];

        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sSingle[$i]=($a->value*$penjualan[$i])+($aa*$st);

        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sSingle[$i]=($a->value*$penjualan[$i])+($aa*$sSingle[$i-1]);

        }
    }

    # Menentukan Smoothing kedua ( Sˮt ) [ Sˮt = α S’t + (1- α) Sˮt-1 ]

    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sDouble[$i]=$penjualan[$i];

        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sDouble[$i]=($a->value*$sSingle[$i])+($aa*$st);

        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sDouble[$i]=($a->value*$sSingle[$i])+($aa*$sDouble[$i-1]);

        }
    }

    # Menentukan Smoothing ketiga ( Sˮ’t ) [ Sˮ’t = α Sˮ’t + (1- α) Sˮ’t-1 ]

    for($i=1;$i<=count($tahun);$i++){
        if($i==1){
            $sTriple[$i]=$penjualan[$i];

        }elseif($i==2){
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sTriple[$i]=($a->value*$sDouble[$i])+($aa*$st);

        }else{
            $aa=1-$a->value;
            $st=$penjualan[$i-1];
            $sTriple[$i]=($a->value*$sDouble[$i])+($aa*$sTriple[$i-1]);

        }
    }

    # Menentukan besarnya Konstanta ( at ) [ at = 3S’t– 3Sˮt + Sˮ’t ]

    for($i=1;$i<=count($tahun);$i++){
        $at[$i]=(3*$sSingle[$i])-(3*$sDouble[$i])+$sTriple[$i];

    }

    # Menentukan besarnya Slope  ( bt ) [ α/{2(1-α)^2}][(6-5 α)S’t - (10-8 α)Sˮt + (4-3 α)Sˮ’t]

    for($i=1;$i<=count($tahun);$i++){

        # Mencari Hasil Dari [ α/{2(1-α)^2}]
        $alp  = $a->value;
        $alp2 = 2*(pow(1-$alp,2));
        $alp3 = $alp/$alp2;


        //$bt[$i]=($a->value/$aa)*($sSingle[$i]-$sDouble[$i]);
        $bt[$i]=$alp3*(((6-5*($alp))*$sSingle[$i])-((10-8*($alp))*$sDouble[$i])+((4-3*($alp))*$sTriple[$i]));

    }

    # Menentukan besarnya Slope  ( ct ) [ α^2 / (1-α)^2} ][ S’t - 2Sˮt + Sˮ’t ]

    for($i=1;$i<=count($tahun);$i++){

        # Mencari Hasil Dari [ α/{2(1-α)^2}]
        $alp  = $a->value;
        $alp2 = pow($alp,2)/pow(1-$alp,2);

        //$bt[$i]=($a->value/$aa)*($sSingle[$i]-$sDouble[$i]);
        $ct[$i]=$alp2*(($sSingle[$i])-(2*$sDouble[$i])+($sTriple[$i]));

    }

    # Menentukan besarnya forecast ( St+m ) [ Ft+m = at + bt(m) + 0.5ct(m^2) ]

    //$s=end($at)+end($bt);
    for($i=1;$i<=count($tahun);$i++){
        $ft[$i]=($at[$i])+($bt[$i]*1)+(0.5*($ct[$i])*pow(1,2));

    }

    $s=end($ft);
    $nb= round($s);
    return $nb;
}


?>