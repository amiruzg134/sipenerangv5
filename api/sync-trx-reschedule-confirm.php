<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    $entityBody = json_decode($_GET['json']);
    $pd_nomor                   = $entityBody->pd_nomor;
    $admin_tiket_pendakian_id   = $entityBody->admin_id;
    $status_konfirmasi          = $entityBody->status_konfirmasi;
    $reschedule_verified_at     = $entityBody->reschedule_verified_at;

    $admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id_tiket_pendakian='$admin_tiket_pendakian_id'"));
    $admin_id = $admin['user_id'];

    $trx_pendakian = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_nomor='$pd_nomor'"));

    if($status_konfirmasi == 2){
        $old_start_date = $trx_pendakian['tgl_naik'];
        $old_end_date   = $trx_pendakian['tgl_turun'];

        $start_date     = $trx_pendakian['reschedule_tgl_naik'];
        $end_date       = $trx_pendakian['reschedule_tgl_turun'];
        $sql = mysqli_query($conn, "UPDATE tb_pendakian SET 
            status_reschedule=2,
            tgl_naik='$start_date',
            tgl_turun='$end_date',
            reschedule_tgl_naik='$old_start_date', 
            reschedule_tgl_turun='$old_end_date',
            reschedule_verified_id='$admin_id',
            reschedule_verified_at ='$reschedule_verified_at'
            WHERE pd_nomor='$pd_nomor'");
    }else{
        $sql = mysqli_query($conn, "UPDATE tb_pendakian SET 
            status_reschedule=3,
            reschedule_verified_id='$admin_id',
            reschedule_verified_at ='$reschedule_verified_at'
            WHERE pd_nomor='$pd_nomor'");
    }

    $respon = [
        "error"     => false,
        "message"   => "sync reschedule success",
        "data"      => null
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


