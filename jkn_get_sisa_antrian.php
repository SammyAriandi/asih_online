<?php
include("tools.php");
require("config.php");
date_default_timezone_set('Asia/Jakarta');


//////////////////////////////// HEADER TOKEN DO  NOT REMOVE //////////////////////////////////
$token = 'NOT_FOUND';
$token_valid = false;
foreach (getallheaders() as $name => $value) {
    if(strtolower($name)=='x-token'){ $token = $value; }
}

$query = $koneksi -> query("select * from token_active where token = '$token' and now() <= expired LIMIT 1");
while($row = $query -> fetch_array()){								
   $token_valid = true;
}

if($token_valid==false){
    echo '{"metadata":{"message":"TOKEN INVALID ATAU EXPIRED","code":"600"}}';
    exit();
}
//////////////////////////////// HEADER TOKEN DO  NOT REMOVE //////////////////////////////////
   

$kodebooking = '';
$data = json_decode(file_get_contents('php://input'), true);
if(!empty($data)){
    $kodebooking = $data["kodebooking"];
}else{
    echo '{"metadata":{"message":"INVALID DATA","code":"500"}}';
    exit();
}
if(strlen($kodebooking)==0){ echo '{"metadata":{"message":"KODE BOOKING TIDAK BOLEH KOSONG","code":"506"}}';  exit(); }

$no_online = '0';
$kodepoli = '';
$namapoli = '';
$namadokter = '';
$sisa_antrian = '';
$antrian_panggil = '1';
$waktutunggu = '';
$isFound = false;
$query = $koneksi -> query("select * from antrian_tpp where kode_booking = '$kodebooking'  LIMIT 1");
while($row = $query -> fetch_array()){
	$isFound = true;
	$no_online = $row['no'];
	$kodepoli = $row['kode_poli'];
	$namadokter = $row['nama_dokter'];
}

if($isFound==false){
    echo '{"metadata":{"message":"KODE BOOKUNG('.$kodebooking.') TIDAK DITEMUKAN ATAU SUDAH DIBATALKAN","code":"501"}}';
    exit();
}

$avg_waktu = 10;
$query = $koneksi -> query("select * from poli where kode_poli = '$kodepoli'  LIMIT 1");
while($row = $query -> fetch_array()){ $namapoli = $row['poli'];  $avg_waktu = $row['avg_service_time']; }

//echo "select * from antrian_tpp where isSudahDilayani <> '' and kode_poli = '$kodepoli' and tgl = curdate() and nama_dokter = '$namadokter' ORDER BY no DESC LIMIT 1";
$query = $koneksi -> query("select * from antrian_tpp where isSudahDilayani <> '' and kode_poli = '$kodepoli' and tgl = curdate() and nama_dokter = '$namadokter' ORDER BY no DESC LIMIT 1");
while($row = $query -> fetch_array()){
	$antrian_panggil = $no;
}
$sisa_antrian = $no_online - $antrian_panggil;
$waktutunggu = $sisa_antrian * $avg_waktu;

$keterangan = '';

$myObj = new \stdClass();
$myObj->nomorantrean = "$no_online";
$myObj->namapoli = $namapoli;
$myObj->namadokter = $namadokter;
$myObj->sisaantrean = $sisa_antrian;
$myObj->antrianpanggil = $antrian_panggil;
$myObj->waktutunggu = $waktutunggu;
$myObj->keterangan = $keterangan;
$myJSON = json_encode($myObj);

        
$myRep = new \stdClass();
$myRep->message = "OK";
$myRep->code = "200";
$myRep = json_encode($myRep);

echo '{"response":',$myJSON.',"metadata":'.$myRep.'}';


?>