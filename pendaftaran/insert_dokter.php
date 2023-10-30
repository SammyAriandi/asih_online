<?php

require("config.php");

$dokter = $_GET['dokter'];
$dokterx = explode("$",$dokter);

for($i=0;$i<=count($dokterx)-1;$i++){
	$data = explode(";", $dokterx[$i]);
	if(strlen($data[0])>3){
		mysqli_query($koneksi, "DELETE FROM dokter where nama = '$data[0]' ");
		$query = mysqli_query($koneksi, "INSERT INTO dokter values ('$data[0]', '$data[1]', '0' )");
	}
}

?>
