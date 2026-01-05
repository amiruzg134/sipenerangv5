<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    mysqli_begin_transaction($conn);
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $partner_kode_registrasi  = $entityBody['partner_kode_registrasi'];
    $transaction_id           = $entityBody['transaction_id'];
    $get_admin_id                 = $entityBody['admin_id'];

    $access_account = mysqli_query($conn, "
        SELECT user_id 
        FROM user 
        WHERE user_id_tiket_pendakian='$get_admin_id'
    ");

    if (mysqli_num_rows($access_account) === 0) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => "Akun Anda tidak memiliki akses ke server sipenerang, silakan hubungi admin",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $data_user = mysqli_fetch_assoc($access_account);
    $admin_id = $data_user['user_id'];

    $get = mysqli_query($conn, "
        SELECT payment_number, pd_nomor 
        FROM tb_pendakian 
        WHERE trx_pendakian_id='$transaction_id' AND is_backup=0
    ");

    if ($get && mysqli_num_rows($get) == 0) {
        $respon = [
            "error"     => false,
            "message"   => "update trx success",
            "data"      => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    if (mysqli_num_rows($get) > 0) {
        $data = mysqli_fetch_assoc($get);
        $old_payment_number = $data['payment_number'];
        $old_pd_nomor       = $data['pd_nomor'];

        $base_payment_number = preg_replace('/-old(\d+)?$/', '', $old_payment_number);
        $base_pd_nomor       = preg_replace('/-old(\d+)?$/', '', $old_pd_nomor);
        $base_trx_id         = $base_payment_number;

        $check_suffix = mysqli_query($conn, "
            SELECT trx_pendakian_id 
            FROM tb_pendakian 
            WHERE (trx_pendakian_id LIKE '{$base_trx_id}-old%' OR trx_pendakian_id = '{$base_trx_id}')
        ");

        $max_suffix = 0;
        while ($row = mysqli_fetch_assoc($check_suffix)) {
            if (preg_match('/-old(\d+)$/', $row['trx_pendakian_id'], $matches)) {
                $num = (int)$matches[1];
                if ($num > $max_suffix) {
                    $max_suffix = $num;
                }
            } elseif ($row['trx_pendakian_id'] == $base_trx_id) {
                if ($max_suffix == 0) $max_suffix = 0;
            }
        }

        $next_suffix = $max_suffix + 1;

        $new_pd_nomor       = $base_pd_nomor . "-old" . $next_suffix;
        $new_payment_number = $base_payment_number . "-old" . $next_suffix;
        $new_trx_id         = $base_trx_id . "-old" . $next_suffix;

        $update = mysqli_query($conn, "
            UPDATE tb_pendakian 
            SET pd_nomor='$new_pd_nomor', 
                payment_number='$new_payment_number', 
                is_backup=1,
                trx_pendakian_id='$new_trx_id'
            WHERE trx_pendakian_id='$transaction_id' AND is_backup=0
        ");

        mysqli_commit($conn);
        $respon = [
            "error"     => false,
            "message"   => "update trx success",
            "data"      => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }
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