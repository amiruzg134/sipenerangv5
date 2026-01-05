<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;

session_start();
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

try{
    mysqli_begin_transaction($conn);
    $jenis  = $_GET['jenis'];
    $trx_id = $_GET['trx_id'];
    if($jenis == "local"){
        $trx =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));
    }else{
        $trx =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'"));
    }

    if(empty($trx)){
        $respon = [
            "error" => true,
            "message" => "transaksi tidak ditemukan",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $id = $trx['pd_id'];
    mysqli_query($conn, "DELETE FROM tb_anggota_pendakian WHERE ap_pendakian='$id'");
    mysqli_query($conn, "DELETE FROM tb_kontak_darurat WHERE kd_pendakian='$id'");
    mysqli_query($conn, "DELETE FROM tb_pendakian WHERE pd_id='$id'");

    mysqli_commit($conn);

    $respon = [
        "error" => false,
        "message" => "Success",
        "data" => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();

}catch(mysqli_sql_exception $exception){
    mysqli_rollback($conn);
    $respon = [
        "error" => true,
        "message" => $exception,
        "data" => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}
