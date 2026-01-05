<?php

use Carbon\Carbon;

require '../vendor/autoload.php';
require '../config/env.php';
require '../config/connection.php';

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
$env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

$sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
$env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

$token_user = $_POST['token_user'];
$response = $client->get($env_base_url.'profile', [
        'headers' => [
            'Access-Key'    => $env_access_key,
            'Authorization' => "Bearer $token_user"
        ],
    ]
);
$res = json_decode($response->getBody(), true);

$user_id = $res['data']['user']['id'];
$sql     = mysqli_query($conn, "SELECT * FROM user_verification WHERE user_id_tiket_pendakian='$user_id'");
$row     = mysqli_fetch_array($sql);
$umur    = 0;
if(!empty($row)){
    if($row['status_code'] == 1){
        $is_enable_button_pengajuan = true;
        $status_pengajuan = "Belum melakukan pengajuan";
    }else if($row['status_code'] == 2){
        $is_enable_button_pengajuan = false;
        $status_pengajuan = "Proses pengajuan";

        $tanggal_lahir = $res['data']['user']['date_birth'];
        $umur          = Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->age;
    }else if($row['status_code'] == 3){
        $is_enable_button_pengajuan = false;
        $status_pengajuan = "Pengajuan disetujui";

        $tanggal_lahir = $res['data']['user']['date_birth'];
        $umur          = Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->age;
    }else if($row['status_code'] == 4){
        $is_enable_button_pengajuan = true;
        $status_pengajuan = "Pengajuan ditolak";

        $tanggal_lahir = $res['data']['user']['date_birth'];
        $umur          = Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->age;
    }
}else{
    if($res['data']['is_verified_account']){
        $is_enable_button_pengajuan = false;
        $status_pengajuan = "Pengajuan disetujui";

        $tanggal_lahir = $res['data']['user']['date_birth'];
        $umur          = Carbon::createFromFormat('d-m-Y', $tanggal_lahir)->age;
    }else{
        $is_enable_button_pengajuan = true;
        $status_pengajuan = "Akun anda belum terverifikasi, silakan cek status akun anda di aplikasi tiket pendakian";
    }
}

$res['data']['user']['umur'] = $umur;
$res['is_enable_button_pengajuan'] = $is_enable_button_pengajuan;
$res['status_pengajuan'] = $status_pengajuan;
echo json_encode($res);