<?php
aut(array(1));
$a=$_GET['a'] ?? '';
switch($a){
	default:
?>
	<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line"><?php echo strtoupper($m);?>
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
                                        <th style="width:5%;">#</th>
                                        <th>Jenis Tiket</th>
                                        <th>Harga Tiket</th>
										<th style="width:9%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php 
									javascript($m,'confirm');
									$no=0;
									$q=$con->query("SELECT * FROM jenis ORDER BY id ASC");
									while($r=$q->fetch_object()){
									$no++;
										echo "<tr>
											<td>$no</td>
											<td>$r->jenisTiket</td>
											<td>Rp. ".money($r->hargaTiket)."</td>
											<td>
											<a href='".$site."$m/update/$r->id'><i class='fa fa-edit fa-fw' title='Update Jenis'></i></a>
											<a href='".$site."$m/delete/$r->id'><i class='fa fa-times fa-fw' title='Delete Jenis' onclick='return konfirmasi()'></i></a>
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
									<label>Jenis Tiket</label>
									<input type="text" name="jenis" class="form-control" required>
									</div>
                                   <script>
                                       function angka(evt) {
                                           var charCode = (evt.which) ? evt.which : event.keyCode
                                           if (charCode > 31 && (charCode < 48 || charCode > 57))

                                               return false;
                                           return true;
                                       }
                                   </script>
                                   <label>Harga</label>
                                   <input type="text" name="harga" class="form-control" placeholder="Ex: 4000" onkeypress="return angka(event)" required>
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
				$jenis=ucwords($_POST['jenis']);
                $harga=ucwords($_POST['harga']);
				
				$q=$con->query("INSERT INTO jenis (jenisTiket, hargaTiket) VALUES('$jenis','$harga')");
				if($q===true){
					javascript($m,'redirect');
				}else{
					echo 'Gagal: '.$con->error;
				}
			}
			?>
			
<?php break; ?>

<?php case 'update': ?>
<?php 
$q=$con->query("SELECT * FROM jenis WHERE id='$_GET[id]'")->fetch_assoc();?>
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
									<label>Jenis Tiket</label>
									<input type="text" name="jenis" value="<?php echo $q['jenisTiket'];?>" class="form-control" reqiured>
								</div>
									                          <div class="form-group">
									                              <script>
									                                  function angka(evt) {
									                                      var charCode = (evt.which) ? evt.which : event.keyCode
									                                      if (charCode > 31 && (charCode < 48 || charCode > 57))

									                                          return false;
									                                      return true;
									                                  }
									                              </script>
									                              <label>Harga</label>
									                              <input type="text" name="harga" value="<?php echo $q['hargaTiket'];?>" class="form-control" onkeypress="return angka(event)" reqiured>
									                              <input type="hidden" name="id" value="<?php echo $q['id'];?>">
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
				$id=$_POST['id'];
				$jenis=ucwords($_POST['jenis']);
                $harga=ucwords($_POST['harga']);
				$q=$con->query("UPDATE jenis SET jenisTiket='$jenis', hargaTiket='$harga' WHERE id='$id'");
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

$q=$con->query("DELETE FROM jenis WHERE id='$_GET[id]'");
if($q===false){
	echo 'Gagal: '.$con->error;
}else{
	javascript($m,'redirect');
}
?>
<?php break; ?>


<?php }	?>
    