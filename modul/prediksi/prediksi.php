<?php
aut(array(1));
$a=$_GET['a'] ?? '';
$filter=$filter ?? '';

switch($a){
	default:
	
	
	$q=$con->query("SELECT *,SUM(a.jumlah) AS jumlahP FROM penjualan a, koridor b, jenis c
		WHERE a.koridorID=b.id $filter AND b.jenisID=c.id GROUP BY b.id");
	if($q->num_rows==0){
		javascript('penjualan','alert','Belum ada data penjualan ');
	}
	
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line"><?php echo strtoupper($m);?>
						<span class="pull-right text-muted">
						<!--<a href="<?php echo $site.$m;?>/tambah" class="btn btn-primary">Tambah</a></span>-->
						</h1>
                    </div>
                </div>
                <div class="row">
            <div class="col-lg-12">
               <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="t_prediksi">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">#</th>
                                        <th>Koridor</th>
                                        <th>Jenis</th>
          <th>Prediksi Penjualan</th>
          <th>Aktual</th>
          <th>Error (-)</th>
                                        <th>Error (+)</th>
          <th>MAPE (%)</th>
          <th style="width:5%;">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $q=$con->query("SELECT * FROM penjualan a, koridor b, jenis c WHERE a.koridorID=b.id AND b.jenisID=c.id GROUP BY a.koridorID ORDER BY b.id ASC");
                                $i=0;
                                while($r=$q->fetch_object()){
                                    $i++;
                                    $r2=$con->query("SELECT * FROM data_uji WHERE koridorID='$r->koridorID' LIMIT 1")->fetch_object();
                                    $aktual[$i]=$r2->jumlah ?? 0;
                                    if(empty($aktual[$i])){
                                        $aktual[$i]=0;
                                    }
                                    $prediksi[$i]=prediksiTiket($r->koridorID);
                                    $error[$i]=$aktual[$i]-$prediksi[$i];
                                    $err[$i]=abs($error[$i]);
                                    $mape[$i]=number_format(($err[$i]/$prediksi[$i])*100,2,'.','');
                                    if(!empty($aktual[$i])){
                                        $xmape[$i]=(float)number_format(($err[$i]/$prediksi[$i])*100,2,'.','');
                                    }

                                    echo "<tr>
         <td>$i</td>
         <td>$r->koridor</td>
									<td>$r->jenisTiket</td>
									<td>".$prediksi[$i]."</td>
									<td>$aktual[$i]</td>
									<td>$error[$i]</td>
									<td>$err[$i]</td>
									<td>$mape[$i]%</td>
									<td>
											<a href='".$site."$m/detail/$r->koridorID'><i class='fa fa-eye fa-fw' title='Klik Untuk Melihat Detail Perhitungan'></i></a>
											</td>
									</tr>";
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <?php
                                $rata=number_format(array_sum($xmape)/count($xmape),2,'.','');
                                $akurasi=100-(float)$rata;
                                ?>
                                    <tr> 
                                        <th colspan="7" class="text-right"><center>Rata-rata MAPE</center></th>
										<th colspan="2"><?php echo $rata;?>%</th>
                                    </tr>
									 <tr> 
                                         <th colspan="7" class="text-right"><center>Akurasi</center></th>
										<th colspan="2"><?php echo $akurasi;?>%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        </div>
              
             
            </div>
            <!-- /. PAGE INNER  -->


<?php break; ?>

<?php case 'detail'; ?>

                <div class="row">
            <div class="col-lg-12">
              <?php prediksi($_GET['id']);?>
			

                        </div>
				
				</div>
            <!-- /. PAGE INNER  -->
		
			
<?php break; ?>


<?php }	?>
    