<?php

session_start();	
require('config.php');


if(!isset($_COOKIE['cookie_kode_booking'])) {
    /*Do nothing*/
} else {
    $kode_booking = $_COOKIE['cookie_kode_booking'];
    
    $result = $koneksi -> query("select * from pasien_baru, antrian_online_format_inc where id = cib and kode_booking = '$kode_booking' LIMIT 1");
	if($row = $result -> fetch_array()){	
		$_SESSION['id'] = $row['id'];
		$_SESSION['nama_pasien'] = $row['nama'];
		$_SESSION['poli'] = $row['poli'];
		$_SESSION['dokter'] = $row['dokter'];
		$_SESSION['index_hari'] = $row['index_hari'];
		$_SESSION['tanggal'] = invertDate($row['tgl']);
		$_SESSION['jam'] = $row['jam'];
		$_SESSION['no_online'] = $row['no_online'];
		$_SESSION['kode_booking'] = $kode_booking;	
	    header('location:cetak.php');							
	    exit();
	}
}


$m = '';
if(isset($_GET['m']) ){ $m = $_GET['m']; }

if($m==''){ 
	$_SESSION['t1'] = "";
	$_SESSION['t2'] = ""; 
	$_SESSION['t3'] = ""; 
	$_SESSION['t4'] = ""; 
	$_SESSION['t5'] = ""; 
	$_SESSION['t6'] = ""; 
	$_SESSION['t7'] = ""; 
	$_SESSION['t8'] = "";  
	$_SESSION['t9'] = "";
	$_SESSION['t10'] = "";  	
	$_SESSION['t11'] = "";  	

}

$t1 = '';
$t2 = '';
$t3 = '';
$t4 = '';
$t5 = '';
$t6 = '';
$t7 = '';
$t8 = '';
$t9 = '';
$t10 = '';
$t11 = '';


if(isset($_SESSION['t1']) ){ $t1 = $_SESSION['t1']; }
if(isset($_SESSION["t2"]) ){ $t2 = $_SESSION["t2"]; }
if(isset($_SESSION["t3"]) ){ $t3 = $_SESSION["t3"]; }
if(isset($_SESSION["t4"]) ){ $t4 = $_SESSION["t4"]; }
if(isset($_SESSION["t5"]) ){ $t5 = $_SESSION["t5"]; }
if(isset($_SESSION["t6"]) ){ $t6 = $_SESSION["t6"]; }
if(isset($_SESSION["t7"]) ){ $t7 = $_SESSION["t7"]; }
if(isset($_SESSION["t8"]) ){ $t8 = $_SESSION["t8"]; }
if(isset($_SESSION["t9"]) ){ $t9 = $_SESSION["t9"]; }
if(isset($_SESSION["t10"]) ){ $t10 = $_SESSION["t10"]; }
if(isset($_SESSION["t11"]) ){ $t10 = $_SESSION["t11"]; }

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{ 
     $_SESSION['view'] = 'mobile';
}
else{
     $_SESSION['view'] = 'desktop';
}

$scale = 30;
$view = 'desktop';
if(isset($_SESSION['view']) && !empty($_SESSION['view'])) { $view = $_SESSION['view']; } 
if($view!='desktop'){ $scale = 100;  }

?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="viewport" content="width=device-width; initial-scale=0.9; maximum-scale=0.9;">
<link REL="SHORTCUT ICON" HREF="images/icon.png">
<link href="jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.theme.css">

<script src="jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="jquery-1.2.3.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
    $('#nama_kota').change(function(){
      var kota =$(this).val();
      $.ajax({
            type: 'POST',
            url : 'kec.php',
            data: 'kota='+kota,
            success:function(response){
              $('#nama_kec').html(response);
            }
      });
    })
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $('#nama_kec').change(function(){
      var kec = $(this).val();
      $.ajax({
            type: 'POST',
            url : 'kel.php',
            data: 'kecamatan='+kec,
            success:function(response){
              $('#nama_kel').html(response);
            }
      });
    })
  });
</script>


</head>

<body>
<div align="center">
<table border="0" width="98%" height="100%"  <?php if($view!='desktop') {  echo 'background="images/bg_login.png"'; } ?> cellspacing="0" cellpadding="0" >
<tr>
<td valign="top">
    <form method="POST" action="insert_pasien_baru.php" autocomplete="off">
	<div align="center">
	<table border="0" width="353" height="247"  <?php if($view=='desktop') {  echo 'background="images/bg_login.png"'; } ?>>
	
	<tr>
	<td colspan="2">
	<p align="center">
	<img border="0" src="images/logo.png" width="248" height="95"><br>	
	<font color="#FF0000"><b>							
	<?php 						
	    if($m=='n') { echo "NAMA BELUM DIMASUKKAN<br>"; } 
		if($m=='a') { echo "ALAMAT BELUM DIMASUKKAN<br>"; } 
		if($m=='kota') { echo "KOTA BELUM DIMASUKKAN<br>"; }
		if($m=='kec') { echo "KECAMATAN BELUM DIMASUKKAN<br>"; } 
		if($m=='kel') { echo "KELURAHAN BELUM DIMASUKKAN<br>"; } 
		if($m=='tgl') { echo "TGL LAHIR BELUM DIMASUKKAN<br>"; } 
		if($m=='ktp') { echo "KTP BELUM DIMASUKKAN<br>"; } 	
		if($m=='telp') { echo "TELP/WA BELUM DIMASUKKAN<br>"; } 							
	 ?>	 
	</b> 
	</font><b>PENDAFTARAN PASIEN BARU</b>
		<tr>
		<td>No KTP*</td>
		<td>
			<font size="3" color="#FFFFFF">
			<input type="text" name="T7" placeholder="Masukkan No KTP (WAJIB)" size="30" value="<?php echo $t7; ?>" style="width: 261; height: 32; text-align:center"></font></td>
		</tr>
		<tr>
		<td colspan="2">*) Bila sudah mendaftar, masukkan No KTP kemudian tekan 
		simpan</td>
		</tr>
		<tr>
		<td>Nama</td>
		<td>
			<font size="3" color="#FFFFFF">
			<input type="text" name="T1" placeholder="Masukkan nama (WAJIB)" size="30" value="<?php echo $t1; ?>" style="width: 261; height: 32; text-align:center"></font></td>
		</tr>
		<tr>
		<td>Alamat</td>
		<td>
			<font size="3" color="#FFFFFF">
			<input type="text" name="T2" placeholder="Masukkan alamat (WAJIB)" size="30" value="<?php echo $t2; ?>" style="width: 261; height: 32; text-align:center"></font></td>
		</tr>
		<tr>
			<td>
			Kota</td>
			<td>
			<select size="1" name="T10" id="nama_kota" style="width: 139; height: 32">
			<option value="">PILIH KOTA</option>
			<?php
					$result = $koneksi -> query("select kota from kota order by kota ASC");
					while($row = $result -> fetch_array()){									
						if($t9==$row['kota']){ echo '<option selected>'.$row['kota'].'</option>'; }
						else{  echo '<option>'.$row['kota'].'</option>'; }
					}
			?>	
			</select>
		  </td>
		</tr>
		<tr>
		<td>Kecamatan</td>
		<td>
		<select size="1" name="T3" id="nama_kec" style="width: 139; height: 32"></select>
		</td>
		</tr>
		<tr>
		<td>Kelurahan</td>
		<td>
		<select size="1" name="T4" id="nama_kel" style="width: 139; height: 32"></select></td>
		</tr>
		<tr>
		<td>Tgl Lahir</td>
		<td>
		<input type="date" name="T5" size="20" style="width: 139; height: 32"></td>
		</tr>
		<tr>
		<td>J.Kelamin</td>
		<td>
			<select size="1" name="T6" style="width: 109; height: 32">
			<option selected>Laki-laki</option>
			<option>Perempuan</option>
			</select>
		</td>
		</tr>
		<tr>
		<td>No BPJS</td>
		<td>
			<font size="3" color="#FFFFFF">
			<input type="text" name="T8" placeholder="Masukkan No BPJS (kosongi bila umum)" size="30" value="<?php echo $t8; ?>" style="width: 261; height: 32; text-align:center"></font></td>
		</tr>
		<tr>
		<td>Telp / WA</td>
		<td>
			<font size="3" color="#FFFFFF"><input type="text" name="T9" placeholder="Masukkan Telp/WA (WAJIB)" id="telp" size="30" value="<?php echo $t9; ?>" style="width: 261; height: 32; text-align:center"></font></td>
		</tr>
		<tr>
		<td colspan="2">
		<p align="center">
	    <input type="submit" value="Simpan" name="B1" style="width: 154; height: 40"></td>
		</tr>
		</div>
</form>
<p align="center">&nbsp;</p>
<tr>
<td colspan="2">
<form method="POST" action="login.php">
<p align="center">
<input type="submit" value="Batal" name="B3"  style="width: 154; height: 40"></p>
</form>
</td>
</tr>
</table>

</tr>
</td>
</table>
</div>
</body>

</html>