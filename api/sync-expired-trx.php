<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    mysqli_begin_transaction($conn);
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $code  = $entityBody['code'];
    $dates = $entityBody['date'];
    $total_pesanan = $entityBody['total_pesanan'];

    $escaped_dates = array_map(function($d) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $d) . "'";
    }, $dates);

    $date_list = implode(',', $escaped_dates);

    $transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT pd_pos_pendakian, tb_gunung_id FROM tb_pendakian WHERE pd_nomor='$code'"));
    $tb_gunung_id        = $transaksi['tb_gunung_id'];
    $tb_pos_pendakian_id = $transaksi['pd_pos_pendakian'];
    $sqlKuotaRestore = mysqli_query($conn,"UPDATE tiket_kuota 
                    SET stock_available = stock_available + $total_pesanan 
                    WHERE tb_gunung_id = '$tb_gunung_id' 
                      AND tb_pos_pendaki_id = '$tb_pos_pendakian_id' 
                      AND date IN ($date_list)");

    mysqli_query($conn, "UPDATE tb_pendakian SET sts_bayar='expired', pd_status='expired' WHERE pd_nomor='$code'");
    mysqli_commit($conn);
    $respon = [
        "error"     => false,
        "message"   => "sync status trx success",
        "data"      => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}catch(Exception $e){
    mysqli_rollback($conn);
    $respon = [
        "error" => true,
        "message" => $e,
        "data" => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}


