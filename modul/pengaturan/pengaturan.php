<?php
aut(array(1));
$a=$_GET['a'] ?? '';
switch($a){
	default:
?>
	

			<?php
			#insert
			if(isset($_POST['submit'])){
				$alpa=$_POST['alpa'];
				$d=$con->query("UPDATE pengaturan SET value='$alpa'");
				if($d===true){
					javascript($m,'redirect');
				}else{
					echo 'Gagal: '.$con->error;
				}
			}
			$r=$con->query("SELECT value FROM pengaturan WHERE pengaturan='alpa'")->fetch_object();
			?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-head-line">Nilai Alpha</h1>
                    </div>
                </div>
                <div class="row">
				   <div class="col-lg-5">
								<div class="panel panel-default">
								<div class="panel-body">
							   <form action="" method="POST" enctype="multipart/form-data">
								  <div class="form-group">
									 <div class="table-responsive">
									 <label>Konstanta Penghalusan ( &alpha; [0-1] )</label>
                                     <select name="alpa" class="form-control" required>
                                         <option value="<?php echo $r->value;?>"><?php echo $r->value;?></option>
                                         <option value="0.1">0.1</option>
                                         <option value="0.2">0.2</option>
                                         <option value="0.3">0.3</option>
                                         <option value="0.4">0.4</option>
                                         <option value="0.5">0.5</option>
                                         <option value="0.6">0.6</option>
                                         <option value="0.7">0.7</option>
                                         <option value="0.8">0.8</option>
                                         <option value="0.9">0.9</option>
                                     </select>
                        </div>
									
									
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
			
<?php break; ?>



<?php }	?>
    