<?php


session_start();	
require("config.php");

$cib       = $_SESSION['id']; 
$dokter    = $_SESSION['dokter'];
$tgl       = invertDate($_SESSION['tanggal']);
$jam       = $_SESSION['jam'];
$index_hari = $_SESSION['index_hari']; 
$poli       = $_SESSION['poli']; 
$jenis      = $_SESSION['jenis']; 



$no_online = 7; ///start nomor
$query = $koneksi -> query("select * from dokter where nama = '$dokter' LIMIT 1");
while($row = $query -> fetch_array()){								
	$prior = explode("#",$row['quota_pasien_prior_vs_non_prior']);
	$no_online = $prior[0];
}


if($jenis=='UMUM'){
	for($ix=0;$ix<=50;$ix++){ 
		$query = $koneksi -> query("select * from antrian_online_format_inc where no_online = '$ix' and dokter = '$dokter' and tgl = '$tgl' and jam = '$jam' LIMIT 1");
		if($row = $query -> fetch_array()){	/*Do Nothing*/ }
		else{ $no_online = $row['no_online'] + 1; break; }
	}	
}else{
	$query = $koneksi -> query("select * from antrian_online_format_inc where no_online >= '$no_online' and dokter = '$dokter' and tgl = '$tgl' and jam = '$jam' ORDER BY no_online DESC LIMIT 1");
	if($row = $query -> fetch_array()){	$no_online = $row['no_online'] + 1; }
	
}



$kode_booking = substr(rand(),-6);
setcookie('cookie_kode_booking', $kode_booking, time() + (86400 * 3), "/"); //86400 = 1 day
$query = mysqli_query($koneksi, "INSERT INTO antrian_online_format_inc values ('$dokter', '$tgl', '$jam', '$no_online', '$cib', '$index_hari', '$poli' , '$kode_booking' )");
$_SESSION['no_online'] = $no_online; 
$_SESSION['kode_booking'] = $kode_booking; 


header('location:cetak.php');


?>
