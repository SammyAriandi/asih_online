<?php


require("config.php");


$no_rm = $_GET['no_rm'];
$nama = $_GET['nama'];
$alamat = $_GET['alamat'];
$tgl_lahir = $_GET['tgl_lahir'];


if(strlen($no_rm)>=9&&strlen($nama)>3){
	$query = mysqli_query($koneksi,"DELETE FROM pasien_pribadi where id = $no_rm");
	$query = mysqli_query($koneksi,"INSERT INTO pasien_pribadi values ($no_rm, '$nama', '$alamat', hex(AES_ENCRYPT('$tgl_lahir','secure123')), ''  ) ");
	if($query) { echo '200'; exit(); }
	else{ echo 'FAILED #1'; exit(); }
}

echo 'FAILED #2';
?>
