<?php
include 'func.php';
if (empty($_SESSION['username']) AND empty($_SESSION['password'])){
	include 'login.php';
}else{
	include 'dashboard.php';
}
?>