<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
require '../config/env.php';

use Carbon\Carbon;
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

try{
    $entityBody = json_decode($_GET['json']);
    $kode       = $entityBody->pd_nomor;
    $amount     = $entityBody->amount;
    $tanggal    = $entityBody->tanggal;

    $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
    $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

    $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
    $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

    $trx = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_nomor='$kode'"));
    $response = $client->post($env_base_url.'callback-qris', [
            'form_params' => [
                'trx_id'        => $trx['trx_pendakian_id'],
                'total_payment' => $amount,
                'tanggal'       => $tanggal
            ],
            'headers' => [
                'Access-Key'    => $env_access_key,
            ],
        ]
    );
    $res = json_decode($response->getBody(), true);
    if($res['error']){
        $respon = [
            "error"   => true,
            "message" => $res['message'],
            "data"    => null,
        ];
        echo json_encode($respon, true);
        exit();
    }else{
        $sql = mysqli_query($conn, "UPDATE tb_pendakian SET tgl_bayar = '$tanggal',
                sts_bayar='paid', pd_status='disetujui' WHERE pd_nomor='$kode'");
        $respon = [
            "error"   => false,
            "message" => $res['message'],
            "data"    => null,
        ];
        echo json_encode($respon, true);
        exit();
    }
}catch(Exception $e){
    $respon = [
        "error" => true,
        "message" => $e,
        "data" => null
    ];
    echo json_encode($respon);
    exit();
}


