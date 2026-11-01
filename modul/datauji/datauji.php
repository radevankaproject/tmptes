<?php
aut(array(1));
$a=$_GET['a'] ?? '';
switch($a){
	default:
?>
	<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line">DATA UJI <?php //echo strtoupper($m);?>
						<span class="pull-right text-muted">
						<a href="<?php echo $site.$m;?>/tambah" class="btn btn-primary">Tambah</a></span>
						</h1>
                    </div>
                </div>
                <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="t1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tahun </th>
                                        <th>Koridor</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Pemakaian</th>
                                        <th>Total</th>
										<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php 
									javascript($m,'confirm');
									$no=0;
									$q=$con->query("SELECT *, a.id as idUji FROM data_uji a, koridor b, jenis c WHERE a.koridorID=b.id AND b.jenisID=c.id ORDER BY a.id ASC");
									while($r=$q->fetch_object()){
									$no++;
									$ttl = $r->hargaTiket*$r->jumlah;
										echo "<tr>
											<td>$no</td>
											<td>$r->tahun</td>
											<td>$r->koridor</td>
											<td>$r->jenisTiket</td>
											<td>Rp. ".money($r->hargaTiket)."</td>
											<td>$r->jumlah</td>
											<td>Rp. ".money($ttl)."</td>
											<td>
											<a href='".$site."$m/update/$r->idUji'><i class='fa fa-edit fa-fw' title='Update data_uji'></i></a>
											<a href='".$site."$m/delete/$r->idUji'><i class='fa fa-times fa-fw' title='Delete data_uji' onclick='return konfirmasi()'></i></a>
											</td>
										</tr>";
									}
									?>
                                </tbody>
                            </table>
                        </div>

                        </div>
              
             
            </div>
            <!-- /. PAGE INNER  -->
		
			
<?php break; ?>

<?php case 'tambah': ?>
<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line"><?php echo strtoupper($a).' '.strtoupper($m);?></h1>
                    </div>
                </div>
                <div class="row">
				   <div class="col-lg-5">
								<div class="panel panel-default">
								<div class="panel-body">
							   <form action="" method="POST" enctype="multipart/form-data">
								  <div class="form-group">
									 <label>Koridor <small><i>(ketik untuk cari)</i></small></label>
								<input type="text"  class="form-control" id="koridor" name="koridor" required >
								<input type="hidden"  class="form-control" id="idKor" name="idKor" required>
								<label>Jenis Tiket</label>
								<input type="text"  class="form-control" id="jenisTiket" name="jenisTiket" readonly >
                                      <script>
                                          function angka(evt) {
                                              var charCode = (evt.which) ? evt.which : event.keyCode
                                              if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                  return false;
                                              return true;
                                          }
                                      </script>
                                      <label>Jumlah Penjualan</label>
                                      <input type="text"  class="form-control" name="jumlah" onkeypress="return angka(event)" required >
                                      <label>Tahun</label>
                                      <select class="form-control" name="tahun">
                                          <option value="">-- Pilih Tahun --</option>
                                          <?php
                                          $thn_skr = date('Y')+1;
                                          for ($x = $thn_skr; $x >= 2014; $x--) {
                                              ?>
                                              <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                              <?php
                                          }
                                          ?>
                                      </select>
									</div>
								</div>
								<div class="panel-footer">
								   <a href="<?php echo $site.$m;?>" class="btn btn-primary">Kembali</a>
								   <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
								</div>								
								</form>
								</div>
							</div>
              
             
            </div>
            <!-- /. PAGE INNER  -->
			
			<?php 
			#insert
			if(isset($_POST['submit'])){
				$jumlah=$_POST['jumlah'];
				$tahun=$_POST['tahun'];
				$idKor=$_POST['idKor'];
                $cek_kor = $con->query("SELECT id FROM koridor WHERE id=$idKor");
                if ($cek_kor == '0') {
                    javascript('datauji/tambah','alert','Data Koridor Tidak Ada Atau Belum Terdaftar');
                } else {
                    $q=$con->query("INSERT INTO data_uji (koridorID,jumlah,tahun) VALUES('$idKor','$jumlah','$tahun')");
                    javascript('datauji','redirect');
                }
			}
			?>
			
<?php break; ?>

<?php case 'update': ?>
<?php 
$q=$con->query("SELECT *, a.id as idUji FROM data_uji a, koridor b,jenis c WHERE a.koridorID=b.id AND b.jenisID=c.id AND a.id='$_GET[id]'")->fetch_assoc();?>
<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line"><?php echo strtoupper($a).' '.strtoupper($m);?></h1>
                    </div>
                </div>
                <div class="row">
				   <div class="col-lg-5">
								<div class="panel panel-default">
								<div class="panel-body">
							   <form action="" method="POST" enctype="multipart/form-data">
								  <div class="form-group">
									 <label>Koridor <small><i>(ketik untuk cari)</i></small></label>
								<input type="text" value="<?php echo $q['koridor'];?>"  class="form-control" id="koridor" name="koridor" required >
								<input type="hidden"  value="<?php echo $q['koridorID'];?>"  class="form-control" id="idKor" name="idKor" required>
								<label>Jenis Tiket</label>
								<input type="text"  value="<?php echo $q['jenisTiket'];?>"  class="form-control" id="jenisTiket" name="jenisTiket" readonly >
								<script>
									                                 function angka(evt) {
									                                     var charCode = (evt.which) ? evt.which : event.keyCode
									                                     if (charCode > 31 && (charCode < 48 || charCode > 57))

									                                         return false;
									                                     return true;
									                                 }
									                             </script>
									                             <label>Jumlah Penjualan</label>
									                             <input type="text" value="<?php echo $q['jumlah'];?>" class="form-control" name="jumlah" onkeypress="return angka(event)" required >
									                             <label>Tahun</label>
									                             <select class="form-control" name="tahun">
									                                 <option value="<?php echo $q['tahun'];?>"><?php echo $q['tahun'];?></option>
									                                 <?php
									                                 $thn_skr = date('Y')+1;
									                                 for ($x = $thn_skr; $x >= 2014; $x--) {
									                                     ?>
									                                     <option value="<?php echo $x ?>"><?php echo $x ?></option>
									                                     <?php
									                                 }
									                                 ?>
									                             </select>
								<input type="hidden" name="idUji" value="<?php echo $q['idUji'];?>">
								</div>
								</div>
								<div class="panel-footer">
								   <a href="<?php echo $site.$m;?>" class="btn btn-primary">Kembali</a>
								   <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
								</div>
								</form>	
								
									</div>
							</div>
              
             
            </div>
            <!-- /. PAGE INNER  -->
			<?php 
			#insert
			if(isset($_POST['submit'])){
				$id=$_POST['idUji'];
				$jumlah=$_POST['jumlah'];
				$tahun=$_POST['tahun'];
				$idKor=$_POST['idKor'];

				$q=$con->query("UPDATE data_uji SET koridorID='$idKor', jumlah='$jumlah',tahun='$tahun' WHERE id='$id'");
				if($q===true){
					javascript($m,'redirect');
				}else{
					echo 'Gagal: '.$con->error;
				}
			}
			?>
			
<?php break; ?>

<?php case 'delete': ?>
<?php 

$q=$con->query("DELETE FROM data_uji WHERE id='$_GET[id]'");
if($q===false){
	echo 'Gagal: '.$con->error;
}else{
	javascript($m,'redirect');
}
?>
<?php break; ?>


<?php }	?>
 
 <style>

     		
		/*auto complete barang*/
		.ui-helper-hidden-accessible { display:none; }  /*hilangkan notif*/
		   .ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;   
    padding: 4px 0;
    margin: 0 0 10px 25px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
}

.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}

.ui-state-hover, .ui-state-active {
    color: #ffffff;
    text-decoration: none;
    background-color: #0088cc;
    border-radius: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    background-image: none;
}
</style>