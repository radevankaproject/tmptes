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
                                        <th>Nama</th>
                                        <th>Username</th>
          <th style="width:5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
         <?php
         javascript($m,'confirm');
         $no=0;
         $q=$con->query("SELECT* FROM user ORDER BY nama ASC");
         while($r=$q->fetch_assoc()){
         $no++;
          echo "<tr>
           <td>$no</td>
           <td>$r[nama]</td>
           <td>$r[username]</td>
           <td>
											<a href='".$site."$m/update/$r[idUser]'><i class='fa fa-edit fa-fw' title='Update'></i></a>
											<a href='".$site."$m/delete/$r[idUser]'><i class='fa fa-times fa-fw' title='Delete' onclick='return konfirmasi()'></i></a>
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
                        <h1 class="page-head-line"><?php echo strtoupper($a);?> Pengguna</h1>
                    </div>
                </div>
                <div class="row">
				   <div class="col-lg-5">
								<div class="panel panel-default">
								<div class="panel-body">
							   <form action="" method="POST" enctype="multipart/form-data">
								  <div class="form-group">
									<label>Nama</label>
									<input type="text" name="nama" class="form-control" required>
									<label>Username</label>
									<input type="text" name="username" class="form-control" required>
								  <label>Password</label>
								 <input type="password" name="password" class="form-control" required>
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
				$nama=ucwords(clean_xss($_POST['nama'] ?? ''));
				$user=clean_xss($_POST['username'] ?? '');
				$pass=password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
				
				$stmt=$con->prepare("INSERT INTO user (nama,username,password) VALUES(?,?,?)");
				$stmt->bind_param("sss", $nama, $user, $pass);
				if($stmt->execute()){
					$stmt->close();
					javascript($m,'redirect');
				}else{
					echo 'Gagal: '.$con->error;
					$stmt->close();
				}
			}
			?>
			
<?php break; ?>

<?php case 'update': ?>
<?php $q=$con->query("SELECT * FROM user WHERE idUser='$_GET[id]'")->fetch_assoc();?>
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
									<label>Nama</label>
									<input type="text" name="nama" value="<?php echo $q['nama'];?>" class="form-control" reqiured>
									<label>Username</label>
									<input type="text" name="username" value="<?php echo $q['username'];?>"  class="form-control" required>
									 <label>Password <small><i>(kosongkan jika tidak diubah)</i></small></label>
									<input type="password" name="password" value="" placeholder="Kosongkan jika tidak diubah" class="form-control">
									<input type="hidden" name="idUser" value="<?php echo $q['idUser'];?>">
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
				$id=(int)$_POST['idUser'];
				$nama=ucwords(clean_xss($_POST['nama'] ?? ''));
				$user=clean_xss($_POST['username'] ?? '');
				$rawPass=$_POST['password'] ?? '';
				
				if($rawPass !== ''){
					$pass=password_hash($rawPass, PASSWORD_DEFAULT);
					$stmt=$con->prepare("UPDATE user SET nama=?, username=?, password=? WHERE idUser=?");
					$stmt->bind_param("sssi", $nama, $user, $pass, $id);
				}else{
					$stmt=$con->prepare("UPDATE user SET nama=?, username=? WHERE idUser=?");
					$stmt->bind_param("ssi", $nama, $user, $id);
				}
				if($stmt->execute()){
					$stmt->close();
					javascript($m,'redirect');
				}else{
					echo 'Gagal: '.$con->error;
					$stmt->close();
				}
			}
			?>
			
<?php break; ?>

<?php case 'delete': ?>
<?php 

$q=$con->query("DELETE FROM user WHERE idUser='$_GET[id]'");
if($q===false){
	echo 'Gagal: '.$con->error;
}else{
	javascript($m,'redirect');
}
?>
<?php break; ?>

<?php }	?>
    