<?php

require("config.php");
session_start();	


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
<table border="0" width="100%" height="100%">
	<tr>
		<td height="308" width="100%">
		<div align="center">
		<img border="0" src="images/logo.png" width="308" height="113">
		<table border="0" width="<?php echo $scale; ?>%" height="280" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" background="images/bg_login.png" style="background-position: center top; text-align: center; background-image:url('images/bg_login.png')">
		<tr>
		<td height="308" width="100%" valign="top">
		<div align="center">			
			<table border="0" width="100%" height="280" bgcolor="#FFFFFF" background="images/bg_login.png" align="center">		
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
									echo '<td align="center" height="65"><font size="4"><a style="color: #FFFFFF; text-decoration: underline" href="cek_hari.php?index_hari='.($i%7).'&tanggal='.$tanggal.'">'.$hari.', '.$tanggal.' ('.date('H:i',strtotime($jam)).')</a></font></td>';
									echo '</tr>';	
									$find = true;							
								}

							}

							if($find==false){
									echo '<tr>';
									echo '<td align="center">Tidak ada jadwal praktek untuk '.$max_booking.' hari kedepan, silahkan hubungi Customer Service</td>';
									echo '</tr>';
							}
							
						
						?>
						
						
						
						
					</table>
					
					<p><br>
					<a href="pilih_dokter.php"><img border="0" src="images/back.png" width="129" height="41"></a>
					<a href="login.php"><img border="0" src="images/home.png" width="129" height="41"></a></td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>

</body>

</html>