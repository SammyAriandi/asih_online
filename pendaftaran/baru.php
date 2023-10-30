<?php
session_start();	
$_SESSION['id'] = ""; 


$m = "";
if(isset($_GET['m']) && !empty($_GET['m'])) { $m = $_GET['m']; } 

?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="viewport" content="width=device-width; initial-scale=0.9; maximum-scale=0.9;">
</head>

<body bgcolor="#C0C0C0" style="text-align: center">
<div align="center">
&nbsp;</div>
<table border="0" width="100%" height="80%">
	<tr>
		<td height="308" width="1080">
		<div align="center">
			<img border="0" src="images/logo.png" width="308" height="113"><table border="0" width="30%" height="280" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
				<tr>
					<td width="396" background="images/bg_login.png" align="center">
					<table border="0" width="80%" cellspacing="1" cellpadding="0" height="221">
						<tr>
							<td>
							<font size="4" color="#FFFFFF">Mohon maaf fitur ini 
							belum tersedia, untuk pendaftaran pasien baru harus 
							dilakukan secara langsung melalui loket pendaftaran 
							di rumah sakit.</font><p><font size="4">
							<a style="color: #FFFFFF; text-decoration: underline" href="login.php">
							Kembali ke halaman login</a></font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>

</body>

</html>
