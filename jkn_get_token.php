<?php

require("config.php");
require("tools.php");

$username = 'jkn_mobile';
$password = '31122021';

foreach (getallheaders() as $name => $value) {
    if(strtolower($name)=='x-username'){ $username = $value; }
    if(strtolower($name)=='x-password'){ $password = $value; }
}


if($username!='jkn_mobile'){
    echo '{"metadata":{"message":"ACCESS DENIED","code":"500"}}';
    exit();
}

if($password!='31122021'){
    echo '{"metadata":{"message":"ACCESS DENIED","code":"500"}}';
    exit();
}


$seed = date("Y-m-d h:m:s");
$token = get_jwtx();

mysqli_query($koneksi, "DELETE FROM token_active where expired < now()");
mysqli_query($koneksi, "INSERT INTO token_active values ('$token', DATE_ADD(now(), INTERVAL 10 MINUTE) )");
echo '{"response": { "token" : "'.$token.'" }, "metadata": {"message": "Ok","code": 200}}';

?>
