<?php
 
require("config.php");
session_start();	

$scale = 50;
$view = 'desktop';
if(isset($_SESSION['view']) && !empty($_SESSION['view'])) { $view = $_SESSION['view']; } 
if($view!='desktop'){ $scale = 100;  }


$max_booking = 3; //booking maks hingga 3 hari kedepan

if($_SESSION['kode_booking']==''){
    header('location:login.php');
	exit();
}

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

<style type="text/css">
   @font-face {
	font-family: "IDAutomationHC39M";
         src: url('qr_font_tfb/IDAutomationHC39M.ttf');
         }
 
   .digital {
         font-family: "IDAutomationHC39M";
         }
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
					<font size="5"><b>Antrian Anda Saat Ini</b></font></p>
					<table border="0" width="100%">
						<tr>
							<td width="100">No RM</td>
							<td width="6">:</td>
							<td><?php echo $_SESSION['id']; ?></td>
						</tr>
						<tr>
							<td width="100">Nama</td>
							<td width="6">:</td>
							<td><?php echo $_SESSION['nama_pasien']; ?></td>
						</tr>
				
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
								//echo $hari;
							?>
							</td>
						</tr>
					
					 	<tr>
							<td width="100"><font color="#FF0000">Kode Booking</font></td>
							<td width="6"><font color="#FF0000">:</font></td>
							<td><font color="#FF0000"><?php echo $_SESSION['kode_booking']; ?></font></td>							
						</tr>
						
					</table>
					<?php
	include "phpqrcode/qrlib.php"; 

	$tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
	if (!file_exists($tempdir)) //Buat folder bername temp
    mkdir($tempdir);

    //isi qrcode jika di scan
    $codeContents = $_SESSION['kode_booking']; 
	$namaFile = $_SESSION['kode_booking'].".png";
	//simpan file kedalam temp 
	//nilai konfigurasi Frame di bawah 4 tidak direkomendasikan 
       QRcode::png($codeContents, $tempdir.$namaFile, QR_ECLEVEL_L, 5, 3); 
    // displaying 
	echo '<img src="'.$tempdir.$namaFile.'" />';  
?>		
<p					
<font size="2"><b>Silahkan di Scan Di Apm Untuk mendapatkan Antrian/jika Data Tidak Ada Maka Registrasi Sudah dilakukan Atau Hubungi Customer Service</b></font></p>
					<a href="login.php">
					<img border="0" src="images/logout.png" width="155" height="48"></a><br>
&nbsp;</td>
				</tr>
			</table>
		</div>
		
		</td>
	</tr>
</table>

</body>

</html>
