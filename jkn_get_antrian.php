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
   

$nik = '';
$nohp = '';
$norm = '';
$kodedokter = '';
$jampraktek = '';
$no_rujukan = '';
$jeniskunjungan= 0;

$data = json_decode(file_get_contents('php://input'), true);
if(!empty($data)){
    $no_kartu = $data["nomorkartu"];
    $tgl =  $data["tanggalperiksa"];
    $kode_poli = $data["kodepoli"];
    $no_rujukan = $data["nomorreferensi"];
	$nik = $data["nik"];
	$norm = $data["norm"];
	$nohp = $data["nohp"];
	$kodedokter = $data["kodedokter"];
	$jampraktek = $data["jampraktek"];
	$jeniskunjungan	= $data["jeniskunjungan"];
}else{
    echo '{"metadata":{"message":"INVALID DATA","code":"500"}}';
    exit();
}


if(strlen($no_kartu)!=13){ echo '{"metadata":{"message":"NO KARTU HARUS 13 DIGIT","code":"506"}}';  exit(); }
if($jeniskunjungan!=1&&$jeniskunjungan!=2){ echo '{"metadata":{"message":"KODE JENIS KUNJUNGAN TIDAK SESUAI","code":"500"}}';  exit(); }
if(strlen($no_kartu)==0){ echo '{"metadata":{"message":"NO KARTU TIDAK BOLEH KOSONG","code":"501"}}'; exit(); }

//////////////////// KODE POLI SALAH ///////////////////////
$namapoli = '';
$lama_tunggu = 10; //default 10 menit
$query = $koneksi -> query("select * from poli where kode_poli = '$kode_poli'  LIMIT 1");
while($row = $query -> fetch_array()){	$namapoli = $row["poli"]; $lama_tunggu = $row['avg_service_time']; }
if($namapoli==''){
    echo '{"metadata":{"message":"KODE POLI('.$kode_poli.') TIDAK TERSEDIA Di REFERENSI","code":"501"}}';
    exit();
}

$isFound = false;
$query = $koneksi -> query("select * from pasien_pribadi where no_kartu_bpjs = '$no_kartu'  LIMIT 1");
while($row = $query -> fetch_array()){								
   $isFound = true;
}
if($isFound==false){
    echo '{"metadata":{"message":"NO KARTU BPJS BELUM TERDAFTAR DI RS SILAHKAN MENDAFTAR LANGSUNG UNTUK MENDAPATKAN NO RM (BERLAKU 1X DI KUNJUNGAN PERTAMA)","code":"506"}}';
    exit();
}


///////////////// CEK FORMAT TANGGAL INVALID
if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$tgl)==false) {
	echo '{"metadata":{"message":"Tanggal Periksa Invalid","code":"501"}}';
    exit();
}



$query = $koneksi -> query("select * from antrian_tpp where tgl = '$tgl' and no_kartu_bpjs = '$no_kartu' ORDER BY no DESC LIMIT 1");
while($row = $query -> fetch_array()){								
    echo '{"metadata":{"message":"PASIEN SUDAH MENDAFTAR DI TANGGAL TERSEBUT","code":"502"}}';
    exit();
}


//////////////////// BACA HARI PRAKTEK DOKTERNYA ///////////////////////
$dayofweek = date('w', strtotime($tgl));
$jambuka = '2000-10-10 00:00:00';


$isFound = false;
$query = $koneksi -> query("select *, curdate()  as today from tdok_jadwal, dokter, poli where index_hari = '$dayofweek' and dokter.nama = tdok_jadwal.nama and poli.poli = dokter.poli and poli.kode_poli = '$kode_poli'  LIMIT 1");
while($row = $query -> fetch_array()){	$isFound = true;  $jambuka = $row["today"].' '.$row["jam_mulai"]; }
if($isFound==false){ echo '{"metadata":{"message":"POLI TUTUP PADA HARI TERSEBUT","code":"501"}}';  exit(); }


$now = new DateTime();
$tutup = new DateTime($jambuka);
$tutup->add(new DateInterval('PT360M'));
if($tutup<$now){ echo '{"metadata":{"message":"PENDAFTARAN KE POLI SUDAH TUTUP PADA '.$tutup.'" ,"code":"501"}}';  exit(); }


///baca apakah dokter sudah terdaftar
$isFound = false;
$query = $koneksi -> query("select * from dokter where kode_mapping_dpjp = '$kodedokter' LIMIT 1");
while($row = $query -> fetch_array()){	$isFound = true; }
if($isFound==false){ echo '{"metadata":{"message":"JADWAL DOKTER TERSEBUT BELUM TERSEDIA, SILAHKAN RESCHEDULE TANGGAL DAN JAM PAKTEKNYA","code":"501"}}'; exit(); }


/*
$data = get_data_rujukan($no_rujukan);
$data_rujukan = json_decode($data, true);
if(!empty($data_rujukan)){
    $metadata =  $data_rujukan["metaData"];
    $code = $metadata["code"];
    if($code!=200){
            echo '{"metadata":{"message":"DATA RUJUKAN '.$no_rujukan.' TIDAK DITEMUKAN","code":"502"}}';
            exit();
        
    }
    $response = $data_rujukan['response'];
    $rujukan = $response['rujukan'];
    $tglKunjungan = $rujukan['tglKunjungan'];
    $date90hari= date('Y-m-d H:i:s', strtotime($tglKunjungan . ' +90 day'));
 
     if(strtotime($tgl) > strtotime($date90hari)) {
        echo '{"metadata":{"message":"Tanggal Periksa sudah melebihi 90 hari dari tanggal rujukan FKTP","code":"502"}}';
        exit();
     }
}else{
    echo '{"metadata":{"message":"DATA RUJUKAN '.$no_rujukan.' TIDAK DITEMUKAN","code":"502"}}';
    exit();
}*/



$now = date("Y-m-d 00:00:00");
if(strtotime($tgl) <= strtotime($now)){
    echo '{"metadata":{"message":"TANGGAL DAFTAR BERLAKU UNTUK BESOK ATAU LUSA","code":"503"}}';
    exit();
 }
 
$now = date("Y-m-d h:m:s");
if(strtotime($tgl) == strtotime($now)){
    echo '{"metadata":{"message":"TANGGAL DAFTAR BERLAKU UNTUK BESOK ATAU LUSA","code":"504"}}';
    exit();
}
 

$datediff = strtotime($tgl) - strtotime($now);
$selisih = round($datediff / (60 * 60 * 24));
if($selisih>3){
    echo '{"metadata":{"message":"TANGGAL DAFTAR MAKSIMAL H+2","code":"505"}}';
    exit();
 }
 





$no_online = 10;               /// Start nomor
$jam_buka = $tgl."06:00:00";   /// Default Jam Buka
$query = $koneksi -> query("select * from antrian_tpp where tgl = '$tgl' ORDER BY no DESC LIMIT 1");
while($row = $query -> fetch_array()){	$no_online = $row['no'] + 1; }
$kode_booking = substr(rand(),-8);


$lama_tunggu = $lama_tunggu * $no_online;
$estimasi_dilayani = strtotime("+".$lama_tunggu." minutes", strtotime($jam_buka)) * 1000; ///dalam milisecond
$namadokter = $kodedokter;


$kuotanonjkn = 30;
$kuotajkn = 30;

$sisakuotajkn = 0;
$query = $koneksi -> query("select count(*) as cnt from antrian_tpp where tgl = '$tgl' and length(no_kartu_bpjs) > 0 LIMIT 1");
while($row = $query -> fetch_array()){	$sisakuotajkn = $kuotajkn - $row['cnt']; }

$sisakuotanonjkn =0;
$query = $koneksi -> query("select count(*) as cnt from antrian_tpp where tgl = '$tgl' and length(no_kartu_bpjs) = 0 LIMIT 1");
while($row = $query -> fetch_array()){	$sisakuotanonjkn = $kuotanonjkn - $row['cnt']; }


$query = mysqli_query($koneksi, "INSERT INTO antrian_tpp values ('$no_online', '$tgl', '$no_kartu', '$kode_booking', '', '$kode_poli' , '$namadokter' )");
$myObj = new \stdClass();
$myObj->nomorantrean = "$no_online";
$myObj->angkarantrean = $no_online;
$myObj->kodebooking = $kode_booking;
$myObj->norm = $norm;
$myObj->namapoli = $namapoli;
$myObj->namadokter = $namadokter;
$myObj->estimasidilayani = $estimasi_dilayani;
$myObj->sisakuotajkn = $sisakuotajkn;
$myObj->kuotajkn = $kuotajkn;
$myObj->sisakuotanonjkn = $sisakuotajkn;
$myObj->kuotanonjkn = $kuotajkn;
$myObj->namapoli = $namapoli;
$myObj->keterangan = "Peserta harap 60 menit lebih awal guna pencatatan administrasi.";
$myJSON = json_encode($myObj);

        

$myRep = new \stdClass();
$myRep->message = "OK";
$myRep->code = "200";
$myRep = json_encode($myRep);

echo '{"response":',$myJSON.',"metadata":'.$myRep.'}';





?>