<?php
    require("jkn_get_token.php");
	require("tools.php");     
	$host = "10.10.1.3:3307";	
	$username = "root";
	$password = "joerfin";
	$dbName = "pendaftaran_online";
	
	//mysql_connect($host, $username, $password) or die ("Database tidak dapat diakses !");	
	//mysql_select_db($dbName);
	
	$koneksi = mysqli_connect($host, $username, $password, $dbName);
    if(mysqli_connect_error()){ echo "Koneksi database gagal : " . mysqli_connect_error(); }
	
?>