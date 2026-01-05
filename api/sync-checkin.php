<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';


try{
    $checkin_at     = $_GET['checkin_at'];
    $gate_checkin   = $_GET['gate_checkin'];
    $admin_id       = $_GET['checkin_verification_admin_id'];
    $trx_id         = $_GET['trx_id'];

    $trx  = mysqli_fetch_array(mysqli_query($conn, "SELECT pd_nomor FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'"));
    $responseDataTiketPendakian = [
        "code"              => $trx['pd_nomor'],
        "log"               => [
            "checkin_at" => $checkin_at,
            "gate_checkin" => $gate_checkin,
            "checkin_verification_admin_id" => $admin_id,
            "trx_id" => $trx_id,
        ],
    ];
    logPayment('RESPONSE_CHECKIN', $responseDataTiketPendakian);

    $admin = mysqli_fetch_array(mysqli_query($conn, "SELECT user_id FROM user WHERE user_id_tiket_pendakian='$admin_id'"));
    $gate  = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_id FROM tb_pos_pendakian WHERE mountain_gate_id='$gate_checkin'"));

    $user_admin_id  = $admin['user_id'];
    $gate_id        = $gate['pp_id'];
    mysqli_query($conn, "UPDATE tb_pendakian 
                    SET pd_acc_naik_by='$user_admin_id', pd_status='sudah naik', pd_pos_pendakian='$gate_id', 
                     pd_tgl_naik='$checkin_at' WHERE trx_pendakian_id= '$trx_id'");


    $respon = [
        "error"     => false,
        "message"   => "Checkin Berhasil",
        "data"      => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
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

