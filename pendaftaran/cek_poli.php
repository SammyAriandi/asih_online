<?php

function invertDate($tgl) {
	$t = explode("-", $tgl);
	return $t[2].'-'.$t[1].'-'.$t[0];
}

session_start();
require("config.php");	


if(isset($_GET['poli']) && !empty($_GET['poli'])) { 
	$_SESSION['poli'] = $_GET['poli']; 

	$result = $koneksi -> query("select * from antrian_online, dokter where tgl > now() and antrian_online.dokter = dokter.nama and dokter.poli = '".$_SESSION['poli']."' and cib = '".$_SESSION['id']."' LIMIT 1");
	if($row = $result -> fetch_array()){ 

		session_start();	
		$_SESSION['dokter'] = $row['dokter'];		
		$_SESSION['index_hari'] = $row['index_hari']; 
		$_SESSION['tanggal'] =  invertDate($row['tgl']);		
		$_SESSION['no'] = $row['no_online'];
		$_SESSION['jam_nomor'] = strtotime($row['jam']);		
		header('location:cetak.php');
	}else{
		header('location:pilih_dokter.php');
	}
}else{
	header('location:pilih_poli.php');
} 



?>
