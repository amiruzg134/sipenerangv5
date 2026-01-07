<?php
    require '../../vendor/autoload.php';
    require_once('../../config/connection.php');
    require_once('../../config/ektensi.php');

    use Carbon\Carbon;

try {
    $uuid = $_POST['uuid'];

    $total_transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(trx.pd_id) AS total
                    FROM tb_pendakian trx WHERE user_id_tiket_pendakian='$uuid'"));

    $total_sukses = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(trx.pd_id) AS total
                    FROM tb_pendakian trx WHERE sts_bayar='paid' AND pd_status='disetujui' AND  user_id_tiket_pendakian='$uuid'"));

    $total_menunggu = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(trx.pd_id) AS total
                    FROM tb_pendakian trx WHERE sts_bayar='unpaid' AND pd_status='menunggu pembayaran' AND user_id_tiket_pendakian='$uuid'"));

    $total_kadaluwarsa = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(trx.pd_id) AS total
                    FROM tb_pendakian trx WHERE sts_bayar='unpaid' AND pd_status='expired' AND user_id_tiket_pendakian='$uuid'"));
    $data = [
        "total_transaksi"   => $total_transaksi['total'],
        "total_sukses"      => $total_sukses['total'],
        "total_menunggu"    => $total_menunggu['total'],
        "total_kadaluwarsa" => $total_kadaluwarsa['total'],
    ];
    $respon = [
        "error"   => false,
        "message" => "Success",
        "data"    => $data
    ];
    echo json_encode($respon, true);
    exit();
} catch (Exception $e) {
    $respon = [
        "error" => true,
        "message" => $e
    ];
    echo json_encode($respon, true);
    exit();
}

