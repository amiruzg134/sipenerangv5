<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
require '../config/env.php';


try{
    $trx_id     = $_POST['trx_id'];
    $admin_id   = $_POST['admin_id'];
    $date       = $_POST['date'];

    $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
    $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

    $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
    $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

    $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id_tiket_pendakian='$admin_id'"));
    if(empty($user_admin['user_id_tiket_pendakian'])){
        mysqli_query($conn, "UPDATE tb_pendakian SET tgl_bayar = '$date',
                sts_bayar='paid', pd_status='disetujui' WHERE trx_pendakian_id='$trx_id'");
    }else{
        $user_admin_id = $user_admin['user_id'];
        mysqli_query($conn, "UPDATE tb_pendakian SET tgl_bayar = '$date',
            sts_bayar='paid', pd_status='disetujui', pd_acc_by='$user_admin_id' WHERE trx_pendakian_id='$trx_id'");
    }

    $respon = [
        "error"     => false,
        "message"   => "Konfirmasi Pembayaran Berhasil",
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


