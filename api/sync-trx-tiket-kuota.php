<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
require '../config/env.php';

use Carbon\Carbon;

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

try{
    $entityBody         = json_decode(file_get_contents('php://input'), true);
    $tgl_naik           = $entityBody['tgl_naik'];
    $tgl_turun          = $entityBody['tgl_turun'];
    $tb_gunung_id       = $entityBody['tb_gunung_id'];
    $pd_pos_pendakian   = $entityBody['pd_pos_pendakian'];
    $total_pesanan      = $entityBody['total_pesanan'];

    $gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE mountain_id='$tb_gunung_id'"));
    $gunung_id = $gunung['id'];

    $set_tgl_naik  = Carbon::parse($tgl_naik)->format('Y-m-d');
    $set_tgl_turun  = Carbon::parse($tgl_turun)->format('Y-m-d');
    if ($gunung_id == 1 && $set_tgl_naik == $set_tgl_turun) {
        $respon = [
            "error" => true,
            "message" => "Transaksi ditolak: Tanggal naik dan tanggal turun tidak boleh sama untuk Gunung ini",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE mountain_gate_id='$pd_pos_pendakian'"));
    $pos_id = $pos['pp_id'];

    $sqlKuotaUpdate = "
        UPDATE tiket_kuota
        SET stock_available = stock_available - $total_pesanan
        WHERE tb_gunung_id = '$gunung_id'
          AND tb_pos_pendaki_id = '$pos_id'
          AND date = '$tgl_naik'
          AND stock_available >= $total_pesanan
    ";

    mysqli_query($conn, $sqlKuotaUpdate);
    if (mysqli_affected_rows($conn) === 0) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => "Stok tidak mencukupi untuk jumlah pemesanan anda.",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $respon = [
        "error"     => false,
        "message"   => "Sync Payment Success",
        "data"      => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}catch(Exception $e){
    mysqli_rollback($conn);
    $respon = [
        "error" => true,
        "message" => $e->getMessage(),
        "data" => null
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}