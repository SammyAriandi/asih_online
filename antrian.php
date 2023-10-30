<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" href="images/apple-touch-startup-image-320x460.png" />
<meta name="author" content="SindevoThemes" />
<meta name="description" content="GoMobile - A next generation web app theme" />
<meta name="keywords" content="mobile web app, mobile template, mobile design, mobile app design, mobile app theme, mobile wordpress theme, my mobile app" />
<title>RSMI_mobile</title>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<link type="text/css" rel="stylesheet" href="colors/slider/slider.css"/>
<link type="text/css" rel="stylesheet" href="css/swipebox.css"/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'/>
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/code.js"></script>
</head>
<body>
<div id="wrapper">

    <div id="content">
      
      <div class="sliderbg_menu">
      
        <div class="logo"><a href="#">RSMI Mobile</a></div>
        
       <div class="flexslider">
        <ul class="slides">
            <li><img src="images/slide/slide1.jpg" alt="" title=""/></li>
            <li><img src="images/slide/slide2.jpg" alt="" title=""/></li>
            <li><img src="images/slide/slide3.jpg" alt="" title=""/></li>
        </ul>
      </div>
        
        <nav id="menu">
	  <?php

session_start();
require("config.php");
$txt = "";
//$query = $koneksi -> query("select * from antrian_online_format_inc where tgl >= now() order by jam ASC, dokter ASC");

$query = $koneksi -> query("select * from antrian_online_format_inc where tgl >= curdate() order by jam ASC, poli ASC");

while($row = $query -> fetch_array()){
	echo "BOOKING ANDA"."<br>"
	."Dokter    :   ".$row['dokter']."<br>". "Tanggal Kunjungan    :   ".$row['tgl']."<br>"
	."Jam Pelayanan :".$row['jam']."<br>"
	."No Rekam Medis : ".$row['cib']."<br>"
	."Poli Tujuan : ".$row['poli']."<br>"
	."Kode Booking :".$row['kode_booking']."<br>"
	.  "lakukan verifikasi Kehadiran Anda  di APM Maksimal 30 menit sebelum jam praktek di mulai ";
}
?>
</div>
<script type="text/javascript" src="js/jquery.tabify.js"></script>
<script type="text/javascript" src="js/jquery.swipebox.js"></script>
<script type="text/javascript" src="js/jquery.fitvids.js"></script>
<script type="text/javascript" src="js/twitter/jquery.tweet.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" charset="utf-8">
var $ = jQuery.noConflict();
  $(document).ready(function() {
    $('.flexslider').flexslider({
          animation: "slide",
			start: function(){
					 swiperNested.reInit();
				}
    });
  });
</script>
<script src="js/email.js"></script>
</body>
</html>