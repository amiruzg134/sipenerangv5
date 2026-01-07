<?php
ob_start();
session_start();
require '../vendor/autoload.php';
require '../config/env.php';
require '../config/connection.php';

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
$env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

$sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
$env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

$response = $client->get($env_base_url.'logout', [
        'headers' => [
            'Authorization' => $_SESSION['token'],
            'Access-Key' => $env_access_key
        ],
    ]
);
$res = json_decode($response->getBody(), true);

if(!$res['error']){
    if(!empty($_SESSION['access_token'])){
        $RevokeTokenURL="https://accounts.google.com/o/oauth2/revoke?token=".$_SESSION['access_token'];
        $ch = curl_init($RevokeTokenURL);
        curl_exec($ch);
        curl_close($ch);
    }

    session_destroy();
    header('Location: ../index.php');
}

ob_end_flush();