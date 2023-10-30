<?php

require("config.php");
session_start();	
$poli =	$_SESSION['poli'];

$scale = 25;
$view = 'desktop';
if(isset($_SESSION['view']) && !empty($_SESSION['view'])) { $view = $_SESSION['view']; } 
if($view!='desktop'){ $scale = 100;  }


$id_dokter = $_SESSION['dokter'];
$max_booking = 3; //booking maks hingga 3 hari kedepan


?>


<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="viewport" content="width=device-width; initial-scale=0.9; maximum-scale=0.9;">
<link REL="SHORTCUT ICON" HREF="images/icon.png">
<title>Pendaftaran Online</title>
</head>

<body bgcolor="#C0C0C0">
<table border="0" width="100%" height="100%"  <?php if($view!='desktop') {  echo 'background="images/bg_login.png"'; } ?> >
	<tr>
		<td height="308" width="100%">
		<div align="center">
		<img border="0" src="images/logo.png" width="268" height="148">
		<table border="0" width="<?php echo $scale; ?>%" height="280" cellspacing="0" cellpadding="0" <?php if($view=='desktop') {  echo 'background="images/bg_login.png"'; } ?> >
		<tr>
		<td height="308" width="100%" valign="top">
		<div align="center">			
			<table border="0" width="100%" height="280" align="center">		
					<br>
					<table border="1" width="80%">
						<tr>
							<td align="center" bgcolor="#666666">
							<font color="#FFFFFF" size="4"><b><?php echo $id_dokter; ?></b></font></td>
						</tr>
						
						<?php
						
							$index_hari = 0;
							$query = $koneksi -> query("select dayofweek(now()) as t");
							if($row = $query -> fetch_array()){ $index_hari = $row['t'] - 1;	}

							

						
						    $add_date = 0;
							$find = false;
							for($i=$index_hari+1;$i<=$index_hari+$max_booking;$i++){
							
								$tanggal = '';
								$add_date = $add_date + 1;					
								$query = $koneksi -> query("select date_format(adddate(now(), interval $add_date DAY), '%d-%m-%Y') as t");
								if($row = $query -> fetch_array()){ $tanggal = $row['t']; }

	


								$idx = $i % 7;
														
								
								$query = $koneksi -> query("select * from tdok_jadwal where nama = '$id_dokter' and index_hari = '$idx'");
								while($row = $query -> fetch_array()){
									
							
							
									$jum_pasien_yg_sudah_daftar = 0;
       								$qx = $koneksi -> query("select count(*) as cnt from antrian_online_format_inc where dokter = '$id_dokter' and tgl = '".invertDate($tanggal)."' ");
									if($rwx = $qx -> fetch_array()){ $jum_pasien_yg_sudah_daftar = $rwx['cnt']; }	
							
								
									$max_pasien = $row['jumlah_pasien'];
									$jam = $row['jam_mulai'];									
									$hari = '';
									if($i%7==0){ $hari = 'Minggu'; }
									else if($i%7==1){ $hari = 'Senin'; }
									else if($i%7==2){ $hari = 'Selasa'; }
									else if($i%7==3){ $hari = 'Rabu'; }
									else if($i%7==4){ $hari = 'Kamis'; }
									else if($i%7==5){ $hari = 'Jumat'; }
									else if($i%7==6){ $hari = 'Sabtu'; }

									echo '<tr>';
									if($max_pasien>$jum_pasien_yg_sudah_daftar){
										echo '<td align="center" height="65"><font size="4"><a style="color: #000000; text-decoration: underline" href="cek_hari.php?index_hari='.($i%7).'&tanggal='.$tanggal.'&jam='.date('H:i',strtotime($jam)).'">'.$hari.', '.$tanggal.' (Jam: '.date('H:i',strtotime($jam)).')</a></font></td>';
									}else{
										echo '<td align="center" height="65"><font size="4" color="#999999">'.$hari.', '.$tanggal.' (Jam: '.date('H:i',strtotime($jam)).') [FULL]</font></td>';
									}
									echo '</tr>';	
									$find = true;							
								}

							}

							
							if($find==false){							
								$dokter_lain = '';
								for($i=$index_hari+1;$i<=$index_hari+$max_booking;$i++){
									$query = $koneksi -> query("select * from tdok_jadwal, dokter where dokter.nama = tdok_jadwal.nama and poli = '$poli' and index_hari = '$i' group by tdok_jadwal.nama");
							   		while($row = $query -> fetch_array()){
								   		if(strpos($dokter_lain, $row['nama'])==false){	$dokter_lain = '<br>'.$dokter_lain.'<a style="color: #000000; text-decoration: underline" href="cek_dokter.php?dokter='.$row['nama'].'">'.$row['nama'].';</a>'; }
							 	    }
							    }
							
								echo '<tr>';
								echo '<td align="center">';
								echo 'Tidak ada jadwal '.$id_dokter.' untuk '.$max_booking.' hari kedepan<br><br>';
								if(strlen($dokter_lain)>0) { 
								    echo 'Dokter tersedia '.$max_booking.' hari kedepan '.$dokter_lain.'<br><br>'; 
								    
								}
								echo 'Informasi Lebih lanjut hubungi Customer Services.';
								echo '</td>';
								echo '</tr>';
							}
							
						
						?>
						
						
						
						
					</table>
					
					<p><br>
					<a href="pilih_dokter.php"><img border="0" src="images/back.png" width="129" height="41"></a>
					<a href="login.php"><img border="0" src="images/logout.png" width="129" height="41"></a></td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>

</body>

</html>