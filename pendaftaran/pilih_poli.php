<?php

session_start();
require("config.php");


$scale = 25;
$view = 'desktop';
if(isset($_SESSION['view']) && !empty($_SESSION['view'])) { $view = $_SESSION['view']; } 
if($view!='desktop'){ $scale = 100;  }



$id = '';
if(isset($_SESSION['id']) && !empty($_SESSION['id'])) { $id = $_SESSION['id']; }
$nama_pasien = '';
if(isset($_SESSION['nama_pasien']) && !empty($_SESSION['nama_pasien'])) { $nama_pasien = $_SESSION['nama_pasien']; }

if(strlen($id)==0||strlen($nama_pasien)==0){
	header('location:login.php');
}


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
						
						<table border="0" width="100%" height="158">
							<?php
								$result = $koneksi -> query("select poli.poli from poli, dokter where poli.poli = dokter.poli GROUP BY poli.poli ORDER BY poli.poli ASC");
								while($row = $result -> fetch_array()){

									echo '<tr><td>';
									echo '<font size="4"><a style="color: #FFFFFF; text-decoration: underline" href="cek_poli.php?poli='.$row['poli'].'">'.$row['poli'].'</a><br></font>';
									echo '<br></td></tr>';								
								}

							?>
							</table>
							
					<p><a href="login.php">
					<img border="0" src="images/home.png" width="155" height="48"></a><p>&nbsp;</td>
				</tr>
			</table>
		</div>
		</td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>

</body>

</html>