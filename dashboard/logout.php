<?php
ob_start();
session_start();
require '../vendor/autoload.php';
require '../config/env.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$response = $client->get(getenv('BASE_URL').'logout', [
        'headers' => [
            'Authorization' => $_SESSION['token'],
            'Access-Key' => getenv('ACCESS_KEY')
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