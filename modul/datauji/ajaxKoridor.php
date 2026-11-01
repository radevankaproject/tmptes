<?php 
include '../../func.php';

$sql = $con->query ("SELECT *, a.id as idKor FROM koridor a, jenis b WHERE a.jenisID=b.id");
while ($row = $sql->fetch_assoc()) {
     $datas[] = array('koridor' => $row['koridor'],'idKor' => $row['idKor'],'jenisTiket'=>$row['jenisTiket']);
}


//print_r($datas);
//exit;
// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
 
// Rudimentary search
$matches = array();
foreach($datas as $data){
	if(stripos($data['koridor'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$data['value'] = $data['koridor'];
		$data['label'] = "{$data['koridor']},{$data['jenisTiket']}";
		$matches[] = $data;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 6);
print json_encode($matches);


?>