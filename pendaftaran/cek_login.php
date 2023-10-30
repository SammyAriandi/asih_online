<?php

require("config.php");

$id = $_POST['T1'];
$tgl = $_POST['T2'];


$result = $koneksi -> query("select nama from pasien_pribadi where id = '$id' and tgl_lahir_enc = hex(AES_ENCRYPT('$tgl','secure123')) LIMIT 1");
if($row = $result -> fetch_array()){		
	session_start();	
	$_SESSION['id'] = $id; 
	$_SESSION['nama_pasien'] = $row['nama']; 
	header('location:pilih_poli.php');
}else{
	header('location:login.php?m=denied');
}



?>
