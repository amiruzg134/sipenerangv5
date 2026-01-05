<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    $entityBody = json_decode($_GET['json']);
    $pd_nomor               = $entityBody->pd_nomor;
    $reschedule_start_date  = $entityBody->reschedule_start_date;
    $reschedule_end_date    = $entityBody->reschedule_end_date;
    $reschedule_at          = $entityBody->reschedule_at;

    $sql = mysqli_query($conn, "UPDATE tb_pendakian SET is_reschedule=true,
                        reschedule_tgl_naik='$reschedule_start_date', 
                        reschedule_tgl_turun='$reschedule_end_date',
                        reschedule_at='$reschedule_at',
                        status_reschedule=1 
    WHERE pd_nomor='$pd_nomor'");

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


