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

    $payment_method_id  = $entityBody->payment_method_id;
    $trx_id             = $entityBody->trx_id;
    $total_tagihan      = $entityBody->total_tagihan;
    $fullname           = $entityBody->fullname;
    $expired_at         = $entityBody->expired_at;

    $trx_pendaki =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'"));
    $metodePembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM metode_pembayaran WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'"));
    $kategori_pembayaran = $metodePembayaran['kategori'];
    $metode_pembayaran_id = $metodePembayaran['id'];
    $set_expired_at = Carbon::parse($expired_at)->format("y-m-d H:i:s");

    $datatest = [
        "VirtualAccount"        => '15186101'.Carbon::now()->timestamp,
        "Nama"                  => $fullname,
        "TotalTagihan"          => $total_tagihan,
        "TanggalExp"            => Carbon::parse($set_expired_at)->format("Ymd"),
        "Berita1"               => "Retribusi Pendakian ".$trx_pendaki['pd_nomor'],
        "Berita2"               => "UPT Tahura Raden Soerjo",
        "Berita3"               => "",
        "Berita4"               => "",
        "Berita5"               => "",
        "FlagProses"            => "1"
    ];

    if($kategori_pembayaran == "VA"){
        $sql_env_url_va = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_VA'"));
        $env_url_va = $sql_env_url_va['value'] != null ? $sql_env_url_va['value'] : getenv('BASE_URL_VA');

        $register_va = $client->post($env_url_va.'RegPen', [
                'form_params' => [
                    "VirtualAccount"        => '15186101'.Carbon::now()->timestamp,
                    "Nama"                  => $fullname,
                    "TotalTagihan"          => $total_tagihan,
                    "TanggalExp"            => Carbon::parse($set_expired_at)->format("Ymd"),
                    "Berita1"               => "Retribusi Pendakian ".$trx_pendaki['pd_nomor'],
                    "Berita2"               => "UPT Tahura Raden Soerjo",
                    "Berita3"               => "",
                    "Berita4"               => "",
                    "Berita5"               => "",
                    "FlagProses"            => "1"
                ]
            ]
        );
        $res_data = json_decode($register_va->getBody(), true);

        $payment_number = $res_data['VirtualAccount'];
    }else if($kategori_pembayaran == "QRIS"){
        $sql_env_url_qris = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_QRIS'"));
        $env_url_qris = $sql_env_url_qris['value'] != null ? $sql_env_url_qris['value'] : getenv('BASE_URL_QRIS');
        $register_va = $client->post($env_url_qris.'Dynamic', [
                'form_params' => [
                    "merchantPan"   => getenv('MERCHANTPAN'),
                    "hashcodeKey"   => hash('sha256', getenv('MERCHANTPAN').$trx_pendaki['pd_id'].getenv('TERMINALUSER').getenv('MERCHANTHASHKEY')),
                    "billNumber"    => $trx_pendaki['pd_nomor'],
                    "purposetrx"    => "PENGUJIAN",
                    "storelabel"    => "DISHUB KEPANJEN",
                    "customerlabel" => "PUBLIC",
                    "terminalUser"  => getenv('TERMINALUSER'),
                    "expiredDate"   => $expired_at,
                    "amount"        => $total_tagihan
                ],
            ]
        );
        $res_data = json_decode($register_va->getBody(), true);
        $payment_number = $res_data['qrValue'];
    }else{
        $respon = [
            "error" => true,
            "message" => "Bembayaran selain VA & QRIS belum tersedia",
            "data" => null
        ];
        echo json_encode($respon);
        exit();
    }

    mysqli_query($conn, "UPDATE tb_pendakian SET payment_number='$payment_number', metode_pembayaran_id='$metode_pembayaran_id' WHERE trx_pendakian_id='$trx_id'");

    $respon = [
        "error"     => false,
        "message"   => "Sync Payment Success",
        "data"      => [
            "payment_number" => $payment_number
        ]
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}catch(Exception $e){
    $respon = [
        "error" => true,
        "message" => $e,
        "data" => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}


