<?php

     $secret_key = "896b035293824ef89974154c476cb09f";
     $nama_rs = 'mitra idaman';
     $main_hosting = "http://10.10.1.2/rsmi_online";     
     $host = "10.10.1.2:3307";	
     $username = "root";
     $password = "joerfin";
     $dbName = "pendaftaran_online";	
	
	//mysql_connect($host, $username, $password) or die ("Database tidak dapat diakses !");	
	//mysql_select_db($dbName);
	
	$koneksi = mysqli_connect($host, $username, $password, $dbName);
    if(mysqli_connect_error()){ echo "Connection Failed."; }
    
    
    	
function getMainURL(){
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$var = preg_split("#/#", $actual_link); 
	$go = '';
	for($i=0;$i<= count($var)-2;$i++){ $go = $go.$var[$i].'/';	}
	return $go;
}



function invertDate($tgl) {
	$t = explode("-", $tgl);
	return $t[2].'-'.$t[1].'-'.$t[0];
}
	
?>