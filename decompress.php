<?php 

include 'LZCompressor/LZString.php';
include 'LZCompressor/LZReverseDictionary.php';
include 'LZCompressor/LZContext.php';
include 'LZCompressor/LZData.php';
include 'LZCompressor/LZUtil.php';
include 'LZCompressor/LZUtil16.php';

$file_name = $_GET['file_name'];  ///data yang diterima dari BPJS masih dalam bentuk ENCRIPT+COMPRESS
$myfile = fopen('storage/'.$file_name, "r") or die("Unable to open file!");
$full_text = fgets($myfile);



$row = explode("<tr>",$full_text); 
$string_data = $row[0];
$key = $row[1];

echo $key;

$decrypt_data = stringDecrypt($key, $string_data);
echo decompress($decrypt_data);

fclose($myfile);
unlink("storage/".$file_name);


function stringDecrypt($key, $string){
  $encrypt_method = 'AES-256-CBC';
  $key_hash = hex2bin(hash('sha256', $key));
  $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  return $output;
}
    
    
function decompress($string){
    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
}


?>