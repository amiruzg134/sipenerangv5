<?php
  require '../vendor/autoload.php';
  require '../config/env.php';
  require '../config/connection.php';
  $client = new \GuzzleHttp\Client();
  $cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
$env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

$sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
$env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');


$response = $client->post($env_base_url.'login', [
    'form_params' => [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ],
    'headers' => [
        'Access-Key' => $env_access_key
    ],
]
);

$res = json_decode($response->getBody(), true);

if($res['error']){
    echo json_encode($res);
}else{
    session_start();
    $_SESSION['uuid']  = $res['data']['user']['id'];
    $_SESSION['nama_user']  = $res['data']['user']['fullname'];
    $_SESSION['token'] = "bearer ".$res['data']['authorization']['token'];
    echo json_encode($res);
}

