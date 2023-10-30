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


$jenisreferensi = 0;
$jenisrequest = 0;
$data = json_decode(file_get_contents('php://input'), true);
if(!empty($data)){
	$kode_poli = $data["kodepoli"];
    $kode_dokter = $data["kodedokter"];
	$tgl =  $data["tanggalperiksa"];
	$jampraktek =  $data["jam_praktek"];
}else{
    echo '{"metadata":{"message":"INVALID DATA","code":"500"}}';
    exit();
}


//////////////////// KODE POLI SALAH ///////////////////////
$isFound = false;
$query = $koneksi -> query("select * from poli where kode_poli = '$kode_poli'  LIMIT 1");
while($row = $query -> fetch_array()){	$isFound = true; }
if($isFound==false){
    echo '{"metadata":{"message":"KODE POLI('.$kode_poli.') TIDAK TERSEDIA Di REFERENSI","code":"501"}}';
    exit();
}

///////////////// CEK FORMAT TANGGAL INVALID
if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$tgl)==false) {
	echo '{"metadata":{"message":"Tanggal Invalid","code":"501"}}';
    exit();
}



$total_antrean = 0;
$kuotanonjkn = 30;
$kuotajkn = 30;
$sisakuotajkn = 0;
$query = $koneksi -> query("select count(*) as cnt from antrian_tpp where tgl = '$tgl' and length(no_kartu_bpjs) > 0 LIMIT 1");
while($row = $query -> fetch_array()){	$sisakuotajkn = $kuotajkn - $row['cnt'];  $total_antrean = $total_antrean + $row['cnt']; }

$sisakuotanonjkn =0;
$query = $koneksi -> query("select count(*) as cnt from antrian_tpp where tgl = '$tgl' and length(no_kartu_bpjs) = 0 LIMIT 1");
while($row = $query -> fetch_array()){	$sisakuotanonjkn = $kuotanonjkn - $row['cnt']; $total_antrean = $total_antrean + $row['cnt']; }


$nama_poli = '';
$query = $koneksi -> query("select * from poli where kode_poli = '$kode_poli'  LIMIT 1");
while($row = $query -> fetch_array()){ $nama_poli = $row['poli'];  }


$nama_dokter = '';
$query = $koneksi -> query("select * from dokter where kode_mapping_dpjp = '$kode_dokter' LIMIT 1");
while($row = $query -> fetch_array()){ $nama_dokter = $row['nama'];  }

$sudah_dilayani = 0;
$query = $koneksi -> query("select count(*) as cnt from antrian_tpp, dokter where nama = nama_dokter and kode_poli = '$kode_poli' and kode_mapping_dpjp = '$kode_dokter' and isSudahDilayani <> '' LIMIT 1");
while($row = $query -> fetch_array()){	$sudah_dilayani = $row['cnt'];  }


$sisa_antrean = $total_antrean -  $sudah_dilayani;
$antrean_dipanggil = $sudah_dilayani + 1;

$myObj = new \stdClass();
$myObj->namapoli = $nama_poli;
$myObj->totalantrean = $total_antrean;
$myObj->sisaantrean = $sisa_antrean;
$myObj->antreanpanggil = $antrean_dipanggil;
$myObj->sisakuotajkn = $sisakuotajkn;
$myObj->kuotajkn = $kuotajkn;
$myObj->sisakuotanonjkn = $sisakuotajkn;
$myObj->kuotanonjkn = $kuotajkn;
$myObj->keterangan = "";
$myJSON = json_encode($myObj);


$myRep = new \stdClass();
$myRep->message = "OK";
$myRep->code = "200";
$myRep = json_encode($myRep);

echo '{"response":',$myJSON.',"metadata":'.$myRep.'}';





?>