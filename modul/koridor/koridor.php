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
                                        <th>Koridor</th>
										 <th>Jenis Tiket</th>
										 <th>Harga</th>
										<th style="width:5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php 
									javascript($m,'confirm');
									$no=0;
									$q=$con->query("SELECT *, a.id as idKor FROM koridor a, jenis b 
									WHERE a.jenisID=b.id ORDER BY idKor ASC");
									while($r=$q->fetch_assoc()){
									$no++;
										echo "<tr>
											<td>$no</td>
											<td>$r[koridor]</td>
											<td>$r[jenisTiket]</td>
											<td>Rp. $r[hargaTiket]</td>
											<td>
											<a href='".$site."$m/update/$r[idKor]'><i class='fa fa-edit fa-fw' title='Update'></i></a>
											<a href='".$site."$m/delete/$r[idKor]'><i class='fa fa-times fa-fw' title='Delete' onclick='return konfirmasi()'></i></a>
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
                                    <label>Koridor</label>
                                      <input type="text" name="koridor" class="form-control" required>
									<label>Jenis</label>
									<select name="jenis" class="form-control" required>
                                        <option value=''>-- Pilih Jenis --</option>
									<?php 
									$q=$con->query("SELECT * FROM jenis ORDER BY jenisTiket DESC");
									while($r=$q->fetch_object()){
										echo "<option value='$r->id'>$r->jenisTiket</option>";
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
				$jenis=$_POST['jenis'];
				$koridor=ucwords($_POST['koridor']);
				$q=$con->query("INSERT INTO koridor (jenisID,koridor) VALUES('$jenis','$koridor')");
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
$q=$con->query("SELECT *, a.id as idKor FROM koridor a, jenis b WHERE a.jenisID=b.id AND a.id='$_GET[id]'")->fetch_object();
									
?>
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
                                    <label>Koridor</label>
                                    <input type="text" name="koridor" value="<?php echo $q->koridor;?>" class="form-control" reqiured>
                                         <input type="hidden" name="id" value="<?php echo $q->idKor;?>">
									<label>Jenis</label>
									<select name="jenis" class="form-control" required>
									<option value="<?php echo $q->id;?>"><?php echo $q->jenisTiket;?></option>
									<?php 
									$q2=$con->query("SELECT * FROM jenis ORDER BY jenisTiket DESC");
									while($r=$q2->fetch_object()){
										echo "<option value='$r->id'>$r->jenisTiket</option>";
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
				$id=$_POST['id'];
				$jenis=$_POST['jenis'];
				$koridor=ucwords($_POST['koridor']);
				
				$q=$con->query("UPDATE koridor SET koridor='$koridor',jenisID='$jenis' WHERE id='$id'");
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

$q=$con->query("DELETE FROM koridor WHERE id='$_GET[id]'");
if($q===false){
	echo 'Gagal: '.$con->error;
}else{
	javascript($m,'redirect');
}
?>
<?php break; ?>

<?php }	?>
    