<?php

use Carbon\Carbon;

require '../vendor/autoload.php';
require '../config/env.php';
require '../config/connection.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$token_user = $_POST['token_user'];
$email      = $_POST['email'];
$gunung_id  = $_POST['gunung'];

$sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
$env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

$sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
$env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');


$gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT is_verified_user FROM tb_gunung WHERE id='$gunung_id'"));

$response = $client->post($env_base_url.'cek-email-anggota', [
        'form_params' => [
            'email' => $_POST['email'],
        ],
        'headers' => [
            'Access-Key'    => $env_access_key,
            'Authorization' => "Bearer $token_user"
        ],
    ]
);

$res = json_decode($response->getBody(), true);

$tanggal_lahir = $res['data']['user']['date_birth'];
$umur          = Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->age;
if($res['error']){
    echo json_encode($res);
    exit();
}else{
    if ($gunung['is_verified_user'] == 1){
        if($res['data']['is_verified_account']){
            $res['data']['user']['umur'] = $umur;
            echo json_encode($res);
            exit();
        }else{
            $respon = [
                "error"   => true,
                "message" => "Akun email yang anda tambah belum terverifikasi"
            ];
            echo json_encode($respon);
            exit();
        }
    }else{
        if($res['data']['is_complate']){
            $res['data']['user']['umur'] = $umur;
            echo json_encode($res);
            exit();
        }else{
            $respon = [
                "error"   => true,
                "message" => "Akun email yang anda tambah belum melengkapi data diri"
            ];
            echo json_encode($respon);
            exit();
        }
    }
}

