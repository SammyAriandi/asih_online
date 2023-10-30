<?php

session_start();	

if(isset($_GET['index_hari']) && !empty($_GET['index_hari'])) { 
	$_SESSION['index_hari'] = $_GET['index_hari']; 
}else{
	header('location:pilih_hari.php');
	exit();
} 


if(isset($_GET['tanggal']) && !empty($_GET['tanggal'])) { 
	$_SESSION['tanggal'] = $_GET['tanggal']; 
}else{
	header('location:pilih_hari.php');
	exit();
} 

header('location:pilih_jam.php');
	
?>

