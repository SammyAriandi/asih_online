<?php

require("config.php");


$poli = $_GET['poli'];
$polix = explode(",",$poli);

for($i=0;$i<=count($polix)-1;$i++){
	$dt = explode("@" , $polix[$i]);

	if(count($dt)>2){
	    if(strlen($dt[0])>3){
	        mysqli_query($koneksi, "DELETE FROM poli where poli = '$dt[0]'");   
		    $query = mysqli_query($koneksi, "INSERT INTO poli values ('$dt[0]','$dt[1]', '$dt[2]', '', '', '', '', '')"); 
	    }
	}
}
?>
