<?php
aut(array(1));
$a=$_GET['a'] ?? '';
switch($a){
    default:
        if(empty($_GET['thn'])){$tahun=array();$tampil="SEMUA TAHUN";$filter="";}
        else{$thnFilter=$_GET['thn'];$tahun=array();$tampil="$thnFilter";$filter=" AND tahun='$thnFilter'";}


        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-head-line"><?php echo strtoupper($m);?>
                    <span class="pull-right text-muted">
						<a href="<?php echo $site.$m;?>/reset" class="btn btn-primary" onclick="return konfirmasi()">Reset</a>
						<a href="<?php echo $site.$m;?>/tambah" class="btn btn-primary">Tambah</a>
                        <!--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                           <?php echo $tampil;?> <span class="caret"></span>
                             </button>
                                            <ul class="dropdown-menu" role="menu">
												<li><a href="<?php echo $site.$m;?>">SEMUA TAHUN</a></li>
												<li class="divider"></li>
												<?php
                        $q2=$con->query("SELECT tahun FROM penjualan GROUP BY tahun ORDER BY koridorID DESC");
                        while($r2=$q2->fetch_object()){
                            echo "<li><a href='".$site.$m."/$r2->tahun'>$r2->tahun</a></li>";
                        }
                        ?>

                                            </ul>

						</span>-->
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- nav tabs-->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#entri" data-toggle="tab" aria-expanded="true"><i class="fa fa-location-arrow "></i>Entri</a>
                    </li>
                    <li class=""><a href="#total" data-toggle="tab" aria-expanded="false"><i class="fa  fa-random"></i>Total</a>
                    </li>
                </ul>
                <!-- tabs pane-->
                <!-- tabs content-->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="entri">
                        <br/>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="t1">
                            <thead>
                            <tr>
                                <th style="width:5%;">#</th>
                                <th  style="width:10%;">Tahun</th>
                                <th>Koridor</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Jumlah Penjualan</th>
                                <th>Total Pendapatan</th>
                                <th style="width:5%;">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            javascript($m,'confirm');
                            $no=0;
                            $q=$con->query("SELECT *,a.id as idPen FROM penjualan a, koridor b, jenis c WHERE 
									a.koridorID=b.id AND b.jenisID=c.id $filter ORDER BY tahun ASC ");
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
											<a href='".$site."$m/update/$r->idPen'><i class='fa fa-edit fa-fw' title='Update'></i></a>
											<a href='".$site."$m/delete/$r->idPen'><i class='fa fa-times fa-fw' title='Delete' onclick='return konfirmasi()'></i></a>
											</td>
										</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                    <div class="tab-pane fade in" id="total">
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="t2">
                                <thead>
                                <tr>
                                    <th style="width:5%;" rowspan="2">#</th>
                                    <th rowspan="2" class="text-center">Koridor</th>
                                    <th rowspan="2" class="text-center">Jenis</th>
                                    <th colspan="12" class="text-center">Tahun</th>
                                </tr>
                                <tr>
                                    <?php
                                    $t=$con->query("SELECT tahun FROM penjualan GROUP BY tahun ORDER BY tahun");
                                    $i=0;
                                    while($r=$t->fetch_object()){
                                        $tahun[$i]=$r->tahun;
                                        echo "<th class='text-center'>$tahun[$i]</th>";
                                        $i++;
                                    }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                javascript($m,'confirm');
                                $no=0;
                                $q2=$con->query("SELECT *,SUM(a.jumlah) AS jumlah, tahun FROM penjualan a, koridor b, jenis c WHERE 
									a.koridorID=b.id AND b.jenisID=c.id $filter GROUP BY a.koridorID  ORDER BY b.id ASC");
                                while($r2=$q2->fetch_object()){
                                    $no++;
                                    echo "<tr>
											<td>$no</td>
											<td>$r2->koridor</td>
											<td>$r2->jenisTiket</td>";
                                    for($i=0;$i<count($tahun);$i++){
                                        $q3=$con->query("SELECT *,SUM(a.jumlah) AS jumlah FROM penjualan a, koridor b, jenis c WHERE 
											a.koridorID=b.id AND b.jenisID=c.id AND a.koridorID='$r2->koridorID' AND tahun='$tahun[$i]' $filter ")->fetch_object();
                                        echo "<td>$q3->jumlah</td>";
                                    }
                                    echo "
										</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!--</div>-->

                    </div>
                <!-- tabs content-->


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
                    <form action="" method="POST" enctype="multipart/form-data" onsubmit="cekKoridor()">
                        <div class="form-group">
                            <label>Nama Koridor <small><i>(ketik untuk cari)</i></small></label>
                            <input type="text"  class="form-control" id="koridor" name="koridor" required >
                            <input type="hidden"  class="form-control" id="idKor" name="idKor" required>
                            <label>Jenis Tiket</label>
                            <input type="text"  class="form-control" id="jenisTiket" name="jenis" required readonly>
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
                            <select class="form-control" name="tahun" required>
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
                            <!--<label>Keterangan</label>
                            <textarea type="text" class="form-control" name="ketPemakaian" ></textarea>-->


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
        $idKor=$_POST['idKor'];
        $koridor=$_POST['koridor'];
        $jumlah=$_POST['jumlah'];
        $tahun=$_POST['tahun'];
        $cek_kor = $con->query("SELECT id FROM koridor WHERE id=$idKor");
        if ($cek_kor == '0') {
            javascript('penjualan/tambah','alert','Data Koridor Tidak Ada Atau Belum Terdaftar');
        } else {
            $q=$con->query("INSERT INTO penjualan (koridorID,jumlah,tahun) 
					VALUES('$idKor','$jumlah','$tahun')");
            javascript('penjualan','redirect');
        }
    }
    ?>

    <?php break; ?>

<?php case 'update': ?>
    <?php
    $r=$con->query("SELECT *,a.id as idPen FROM penjualan a, koridor b, jenis c WHERE 
	a.koridorID=b.id AND b.jenisID=c.id  AND a.id='$_GET[id]'")->fetch_object();
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
                            <label>Koridor <small><i>(ketik untuk cari)</i></small></label>
                            <input type="text" value="<?php echo $r->koridor;?>"  class="form-control" id="koridor" name="koridor" required readonly>
                            <input type="hidden"  value="<?php echo $r->koridorID;?>"  class="form-control" id="idKor" name="idKor" required>
                            <label>Jenis</label>
                            <input type="text"  value="<?php echo $r->jenisTiket;?>"  class="form-control" id="jenisTiket" name="jenis" readonly >
                            <script>
                                function angka(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode
                                    if (charCode > 31 && (charCode < 48 || charCode > 57))

                                        return false;
                                    return true;
                                }
                            </script>
                            <label>Jumlah Penjualan</label>
                            <input type="text"  value="<?php echo $r->jumlah;?>" class="form-control" name="jumlah" onkeypress="return angka(event)" required >
                            <label>Tahun</label>
                            <select class="form-control" name="tahun">
                                <option value="<?php echo $r->tahun;?>"><?php echo $r->tahun;?></option>
                                <?php
                                $thn_skr = date('Y')+1;
                                for ($x = $thn_skr; $x >= 2014; $x--) {
                                    ?>
                                    <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="hidden"  value="<?php echo $r->idPen;?>"  class="form-control" name="idPen" required>

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
        $idPen=$_POST['idPen'];
        $idKor=$_POST['idKor'];
        $jumlah=$_POST['jumlah'];
        $tahun=$_POST['tahun'];

        $q=$con->query("UPDATE penjualan SET koridorID='$idKor',jumlah='$jumlah',
				tahun='$tahun' WHERE id='$idPen'");

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

    $q=$con->query("DELETE FROM penjualan WHERE id='$_GET[id]'");
    if($q===false){
        echo 'Gagal: '.$con->error;
    }else{
        javascript($m,'redirect');
    }
    ?>
    <?php break; ?>

<?php case 'reset': ?>
    <?php

    $q=$con->query("TRUNCATE penjualan");
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
    