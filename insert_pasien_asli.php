<?php
require("config.php");


$no_rm = $_GET['no_rm'];
$nama = $_GET['nama'];
$alamat = $_GET['alamat'];
$tgl_lahir = $_GET['tgl_lahir'];

if(strlen($nama)>3){
	$query = mysql_query("INSERT INTO pasien_pribadi values ($no_rm, '$nama', '$alamat', hex(AES_ENCRYPT('$tgl_lahir','secure123')))");
	if($query) { echo '200'; }
	else{ echo '100'; }
}

?>
