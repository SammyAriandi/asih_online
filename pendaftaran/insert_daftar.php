<?php

function invertDate($tgl) {
	$t = explode("-", $tgl);
	return $t[2].'-'.$t[1].'-'.$t[0];
}

session_start();	
require("config.php");


$dokter    = $_SESSION['dokter'];
$tgl       = invertDate($_SESSION['tanggal']);
$jam       = date('H:i:00', $_SESSION['jam_nomor']);
$no_online = $_SESSION['no'];
$cib       = $_SESSION['id']; 
$index_hari = $_SESSION['index_hari']; 
$poli       = $_SESSION['poli']; 

$query = mysqli_query($koneksi, "INSERT INTO antrian_online values ('$dokter', '$tgl', '$jam', '$no_online', '$cib', '$index_hari', '$poli' )");

header('location:cetak.php');


?>
