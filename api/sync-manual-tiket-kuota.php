<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $tb_gunung_id       = $entityBody['mountain_id'];
    $pd_pos_pendakian   = $entityBody['mountain_gate_id'];
    $start_date         = $entityBody['start_date'];
    $end_date           = $entityBody['end_date'];

    $gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE mountain_id='$tb_gunung_id'"));
    $gunung_id = $gunung['id'];

    $pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE mountain_gate_id='$pd_pos_pendakian'"));
    $pos_id = $pos['pp_id'];

    if (!$gunung_id || !$pos_id || !$start_date || !$end_date) {
        $respon = [
            "error"   => true,
            "message" => "Parameter tidak lengkap atau tidak valid.",
            "data"    => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $query = "SELECT  date, stock, stock_available, is_active, price_weekday_wni, 
       price_weekday_wna, price_weekend_wni, price_weekend_wna
          FROM tiket_kuota
          WHERE 
            tb_gunung_id = '$gunung_id' 
            AND tb_pos_pendaki_id = '$pos_id'
            AND date BETWEEN '$start_date' AND '$end_date'
          ORDER BY date ASC";
    $result = mysqli_query($conn, $query);

    $data_tiket_kuota = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['is_active'] = ($row['is_active'] == 1);
        $row['tb_gunung_id'] = $tb_gunung_id;
        $row['tb_pos_pendakian'] = $pd_pos_pendakian;
        $data_tiket_kuota[] = $row;
    }

    $respon = [
        "error"     => false,
        "message"   => "sync trx success",
        "data"      => $data_tiket_kuota
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