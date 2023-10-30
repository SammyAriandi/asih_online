<?php

require("config.php");
session_start();	

$scale = 50;
$view = 'desktop';
if(isset($_SESSION['view']) && !empty($_SESSION['view'])) { $view = $_SESSION['view']; } 
if($view!='desktop'){ $scale = 100;  }


$max_booking = 3; //booking maks hingga 3 hari kedepan


?>


<html>
<head>

<style>
.alias {cursor: alias;}
.all-scroll {cursor: all-scroll;}
.auto {cursor: auto;}
.cell {cursor: cell;}
.context-menu {cursor: context-menu;}
.col-resize {cursor: col-resize;}
.copy {cursor: copy;}
.pointer {cursor: pointer;}
.crosshair {cursor: crosshair;}
.default {cursor: default;}
.e-resize {cursor: e-resize;}
.ew-resize {cursor: ew-resize;}
.grab {cursor: grab;}
.grabbing {cursor: grabbing;}
.help {cursor: help;}
.move {cursor: move;}
.n-resize {cursor: n-resize;}
.ne-resize {cursor: ne-resize;}
.nesw-resize {cursor: nesw-resize;}
.ns-resize {cursor: ns-resize;}
.nw-resize {cursor: nw-resize;}
.nwse-resize {cursor: nwse-resize;}
.no-drop {cursor: no-drop;}
.none {cursor: none;}
.not-allowed {cursor: not-allowed;}
.pointer {cursor: pointer;}
.progress {cursor: progress;}
.row-resize {cursor: row-resize;}
.s-resize {cursor: s-resize;}
.se-resize {cursor: se-resize;}
.sw-resize {cursor: sw-resize;}
.text {cursor: text;}
.url {cursor: url(myBall.cur),auto;}
.w-resize {cursor: w-resize;}
.wait {cursor: wait;}
.zoom-in {cursor: zoom-in;}
.zoom-out {cursor: zoom-out;}
</style>

<meta http-equiv="Content-Language" content="en-us">
<meta name="viewport" content="width=device-width; initial-scale=0.9; maximum-scale=0.9;">
<link REL="SHORTCUT ICON" HREF="images/icon.png">
<title>Pendaftaran Online</title>
</head>

<body bgcolor="#C0C0C0">
<table border="0" width="100%" height="80%">
	<tr>
		<td height="308" width="50%">
		<div align="center">
			<table border="0" width="<?php echo $scale; ?>%" height="280" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
				<tr>
					<td rowspan="3" align="center">
					
					<img border="0" src="images/logo.png" width="308" height="113"><p>
					<font size="5"><b>BERHASIL</b></font></p>
					<table border="0" width="100%">
						<tr>
							<td width="92">No RM</td>
							<td width="8">:</td>
							<td><?php echo $_SESSION['id']; ?></td>
						</tr>
						<tr>
							<td width="92">Nama</td>
							<td width="8">:</td>
							<td><?php echo $_SESSION['nama_pasien']; ?></td>
						</tr>
						<tr>
							<td width="92">Poli</td>
							<td width="8">:</td>
							<td><?php echo $_SESSION['poli']; ?></td>
						</tr>
						<tr>
							<td width="92">Dokter</td>
							<td width="8">:</td>
							<td><?php echo $_SESSION['dokter']; ?></td>
						</tr>
						<tr>
							<td width="92">Hari</td>
							<td width="8">:</td>
							<td>
							<?php 
							
								$index_hari = $_SESSION['index_hari'];
								$hari = '';
								if($index_hari%7==0){ $hari = 'Minggu'; }
								else if($index_hari%7==1){ $hari = 'Senin'; }
								else if($index_hari%7==2){ $hari = 'Selasa'; }
								else if($index_hari%7==3){ $hari = 'Rabu'; }
								else if($index_hari%7==4){ $hari = 'Kamis'; }
								else if($index_hari%7==5){ $hari = 'Jumat'; }
								else if($index_hari%7==6){ $hari = 'Sabtu'; }
								echo $hari;
							?>
							</td>
						</tr>
						<tr>
							<td width="92">Tgl Periksa</td>
							<td width="8">:</td>
							<td><?php echo $_SESSION['tanggal']; ?></td>
						</tr>
						<tr>
							<td width="92">Jam Periksa</td>
							<td width="8">:</td>
							<td><?php echo date('H:i',$_SESSION['jam_nomor']); ?></td>
						</tr>
						<tr>
							<td width="92">No Antrian</td>
							<td width="8">:</td>
							<td><?php echo 'L-'.$_SESSION['no']; ?></td>
						</tr>
					</table>
					<p align="left">*) Harus sudah konfirmasi 30 menit 
					sebelum jam periksa<br>
					*) Apabila terlambat harus antri dari awal.<br>
					*) Bawalah Kartu Pasien saat berobat.<br>
					*) Informasi hubungi&nbsp; 031-00000000<p><font color="#FF0000">
					<br>
					<img class='pointer' border="0" src="images/btn_print.png" width="88" height="78" onClick="document.title = 'Antrian Online.pdf';window.print();"><br>
					<br>
					</font><br>
					<a href="login.php">
					<img border="0" src="images/home.png" width="155" height="48"></a><br>
&nbsp;</td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>

</body>

</html>
