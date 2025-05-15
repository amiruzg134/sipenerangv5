<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';


try{
    $checkout_at     = $_GET['checkout_at'];
    $gate_checkout   = $_GET['gate_checkout'];
    $admin_id        = $_GET['checkout_verification_admin_id'];
    $trx_id          = $_GET['trx_id'];

    $trx  = mysqli_fetch_array(mysqli_query($conn, "SELECT pd_nomor FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'"));
    $responseDataTiketPendakian = [
        "code"              => $trx['pd_nomor'],
        "log"               => [
            "checkout_at" => $checkout_at,
            "gate_checkout" => $gate_checkout,
            "checkout_verification_admin_id" => $admin_id,
            "trx_id" => $trx_id,
        ],
    ];
    logPayment('RESPONSE_CHECKOUT', $responseDataTiketPendakian);

    $admin = mysqli_fetch_array(mysqli_query($conn, "SELECT user_id FROM user WHERE user_id_tiket_pendakian='$admin_id'"));
    $gate  = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_id FROM tb_pos_pendakian WHERE mountain_gate_id='$gate_checkout'"));

    $user_admin_id  = $admin['user_id'];
    $gate_id        = $gate['pp_id'];
    mysqli_query($conn, "UPDATE tb_pendakian 
                    SET pd_acc_turun_by='$user_admin_id', pd_status='sudah turun', pd_pos_turun='$gate_id', 
                     pd_tgl_turun='$checkout_at' WHERE trx_pendakian_id= '$trx_id'");

    $respon = [
        "error"     => false,
        "message"   => "Checkout Berhasil",
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

