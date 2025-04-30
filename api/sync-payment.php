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
    $pin                = $entityBody->pin;
    $total_tagihan      = $entityBody->total_tagihan;
    $fullname           = $entityBody->fullname;
    $expired_at         = $entityBody->expired_at;


    $trx_pendaki =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'"));
    $metodePembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM metode_pembayaran WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'"));
    $kategori_pembayaran = $metodePembayaran['kategori'];
    $metode_pembayaran_id = $metodePembayaran['id'];
    $set_expired_at = Carbon::parse($expired_at)->format("y-m-d H:i:s");

    $kode_registrasi    = Carbon::now()->timestamp;
    $pd_nomor           = $trx_pendaki['pd_nomor'];

    if($kategori_pembayaran == "VA"){

        $sql_BASE_URL_VA = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_VA'"));
        $BASE_URL_VA = $sql_BASE_URL_VA['value'] != null ? $sql_BASE_URL_VA['value'] : getenv('BASE_URL_VA');

        $send_va = [
            "VirtualAccount"        => '1518610109'.$kode_registrasi,
            "Nama"                  => $fullname,
            "TotalTagihan"          => $total_tagihan,
            "TanggalExp"            => Carbon::parse($expired_at)->format('Ymd'),
            "Berita1"               => "Retribusi Pendakian ".$pd_nomor,
            "Berita2"               => "UPT Tahura Raden Soerjo",
            "Berita3"               => "",
            "Berita4"               => "",
            "Berita5"               => "",
            "FlagProses"            => "1"
        ];
        $dataLog = [
            "code"              => $pd_nomor,
            "payment_category"  => "VA",
            "log"               => $send_va,
        ];
        logPayment('PAYLOAD', $dataLog);
        $register_va = $client->post($BASE_URL_VA.'RegPen', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => $send_va
            ]
        );
        $res_data = json_decode($register_va->getBody(), true);
        $responseData = [
            "code"              => $pd_nomor,
            "payment_category"  => "VA",
            "log"               => $res_data,
        ];
        logPayment('RESPONSE', $responseData);
        $payment_number = $res_data['VirtualAccount'];
    }else if($kategori_pembayaran == "QRIS"){

        $sql_BASE_URL_QRIS = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_QRIS'"));
        $BASE_URL_QRIS = $sql_BASE_URL_QRIS['value'] != null ? $sql_BASE_URL_QRIS['value'] : getenv('BASE_URL_QRIS');

        $sql_MERCHANTPAN= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='MERCHANTPAN'"));
        $MERCHANTPAN = $sql_MERCHANTPAN['value'] != null ? $sql_MERCHANTPAN['value'] : getenv('MERCHANTPAN');

        $sql_TERMINALUSER= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='TERMINALUSER'"));
        $TERMINALUSER = $sql_TERMINALUSER['value'] != null ? $sql_TERMINALUSER['value'] : getenv('TERMINALUSER');

        $sql_MERCHANTHASHKEY= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='MERCHANTHASHKEY'"));
        $MERCHANTHASHKEY = $sql_MERCHANTHASHKEY['value'] != null ? $sql_MERCHANTHASHKEY['value'] : getenv('MERCHANTHASHKEY');

        $data_qris = [
            "merchantPan"   => $MERCHANTPAN,
            "hashcodeKey"   => hash('sha256', $MERCHANTPAN.$pd_nomor.$TERMINALUSER.$MERCHANTHASHKEY),
            "billNumber"    => $pd_nomor,
            "purposetrx"    => "PENGUJIAN",
            "storelabel"    => "DISHUB KEPANJEN",
            "customerlabel" => "PUBLIC",
            "terminalUser"  => $TERMINALUSER,
            "expiredDate"   => $expired_at->format('Y-m-d H:i:s'),
            "amount"        => $total_tagihan
        ];

        $dataLog = [
            "code"              => $pd_nomor,
            "payment_category"  => "QRIS",
            "log"               => $data_qris,
        ];
        logPayment('PAYLOAD', $dataLog);
        $register_va = $client->post($BASE_URL_QRIS.'Dynamic', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => $data_qris
        ]);
        $res_data = json_decode($register_va->getBody(), true);
        $responseData = [
            "code"              => $pd_nomor,
            "payment_category"  => "QRIS",
            "log"               => $res_data,
        ];
        logPayment('RESPONSE', $responseData);
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

    $pin_code = base64_encode($pin);
    mysqli_query($conn, "UPDATE tb_pendakian SET payment_number='$payment_number', metode_pembayaran_id='$metode_pembayaran_id', code='$pin_code' WHERE trx_pendakian_id='$trx_id'");

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
        "message" => $e->getMessage(),
        "data" => null
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}

