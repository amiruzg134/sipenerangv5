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

$response = $client->post($env_base_url.'register', [
  'form_params' => [
      'username'  => $_POST['username'],
      'email'     => $_POST['email'],
      'password'  => $_POST['password'],
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
    $email      = $res['data']['user']['email'];
    $user_id    = $res['data']['user']['id'];
    $is_exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user_verification WHERE email='$email' AND user_id_tiket_pendakian='$user_id'"));
    if(empty($is_exist_user)){
        mysqli_query($conn, "INSERT INTO user_verification(email, status_code, user_id_tiket_pendakian)VALUES('$email', 1, '$user_id')");
    }

    echo json_encode($res);
}
