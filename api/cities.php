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

$response = $client->post($env_base_url.'location/cities', [
        'form_params' => [
            'province_code' => $_POST['province'],
        ],
        'headers' => [
            'Access-Key' => $env_access_key
        ],
    ]
);
$res = json_decode($response->getBody(), true);
$message = $res['message'];
if($res['error']){
    echo "<p class='error'>$message</p>";
}else{

    foreach ($res['data'] as $re) {
        echo "<option value='" . $re['code'] . "'>" . $re['name'] . "</option>";
    }
}