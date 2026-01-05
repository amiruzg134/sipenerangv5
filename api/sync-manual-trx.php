<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    mysqli_begin_transaction($conn);
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $pd_nama_ketua  = mysqli_real_escape_string($conn, $entityBody['pd_nama_ketua']);
    $total_pesanan  = mysqli_real_escape_string($conn, $entityBody['total_pesanan']);
    $pd_no_ktp      = mysqli_real_escape_string($conn, $entityBody['pd_no_ktp']);
    $pd_tempat_lahir = mysqli_real_escape_string($conn, $entityBody['pd_tempat_lahir']);
    $pd_tgl_lahir = mysqli_real_escape_string($conn, $entityBody['pd_tgl_lahir']);
    $pd_no_hp = mysqli_real_escape_string($conn, $entityBody['pd_no_hp']);
    $pd_email = mysqli_real_escape_string($conn, $entityBody['pd_email']);
    $pd_alamat = mysqli_real_escape_string($conn, $entityBody['pd_alamat']);
    $pd_provinsi = mysqli_real_escape_string($conn, $entityBody['pd_provinsi']);
    $pd_kabupaten = mysqli_real_escape_string($conn, $entityBody['pd_kabupaten']);
    $pd_kecamatan = mysqli_real_escape_string($conn, $entityBody['pd_kecamatan']);
    $pd_desa = mysqli_real_escape_string($conn, $entityBody['pd_desa']);
    $pd_kewarganegaraan = mysqli_real_escape_string($conn, $entityBody['pd_kewarganegaraan']);
    $pd_jenis_kelamin = mysqli_real_escape_string($conn, $entityBody['pd_jenis_kelamin']);
    $tgl_naik = mysqli_real_escape_string($conn, $entityBody['tgl_naik']);
    $tgl_turun = mysqli_real_escape_string($conn, $entityBody['tgl_turun']);
    $keterangan = "order form tiket pendakian";
    $biaya = mysqli_real_escape_string($conn, $entityBody['biaya']);
    $expired_at = mysqli_real_escape_string($conn, $entityBody['expired_at']);
    $tb_gunung_id = mysqli_real_escape_string($conn, $entityBody['tb_gunung_id']);
    $pd_pos_pendakian = mysqli_real_escape_string($conn, $entityBody['pd_pos_pendakian']);
    $trx_pendakian_id = mysqli_real_escape_string($conn, $entityBody['trx_pendakian_id']);
    $user_id_tiket_pendakian = mysqli_real_escape_string($conn, $entityBody['user_id_tiket_pendakian']);
    $payment_number = $entityBody['payment_number'] != null ? mysqli_real_escape_string($conn, $entityBody['payment_number']) : '';
    $payment_method_id = mysqli_real_escape_string($conn, $entityBody['payment_method_id']);
    $get_status_trx  = mysqli_real_escape_string($conn, $entityBody['transaction_status']);
    $code = isset($entityBody['code']) && $entityBody['code'] !== '' ? "'" . mysqli_real_escape_string($conn, base64_encode($entityBody['code'])) . "'" : "NULL";

    if ($get_status_trx == "menunggu pembayaran"){
        $pd_status = "menunggu pembayaran";
        $sts_bayar = "unpaid";
    }else if ($get_status_trx == "dibayar"){
        $pd_status = "disetujui";
        $sts_bayar = "paid";
    }else if ($get_status_trx == "selesai"){
        $pd_status = "disetujui";
        $sts_bayar = "paid";
    }else if ($get_status_trx == "kedaluwarsa"){
        $pd_status = "kedaluwarsa";
        $sts_bayar = "unpaid";
    }else if ($get_status_trx == "dibatalkan"){
        $pd_status = "batal";
        $sts_bayar = "unpaid";
    }

    if (empty($entityBody['partner_kode_registrasi'])){
        $kode_registrasi    = generateKodeTransaksi8Digit();
        $pd_nomor           = 'PD-'.$kode_registrasi;
    }else{
        $pd_nomor           = $entityBody['partner_kode_registrasi'];
    }

    $is_exist_trx = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_nomor='$pd_nomor'"));
    if ($is_exist_trx) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => "Transaksi dengan kode registrasi ini sudah ada dan tidak dapat dibuat ulang.",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    $entityBody['is_manual_sync'] = 1;
    $responseDataTiketPendakian = [
        "code"              => $pd_nomor,
        "log"               => $entityBody,
    ];
    logPayment('RESPONSE_TIKET_PENDAKIAN', $responseDataTiketPendakian);

    $gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE mountain_id='$tb_gunung_id'"));
    $gunung_id = $gunung['id'];

    $metode_pembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM metode_pembayaran WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'"));
    $metode_pembayaran_id = $metode_pembayaran['id'];

    $pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE mountain_gate_id='$pd_pos_pendakian'"));
    $pos_id = $pos['pp_id'];

    $checkin_at         = $entityBody['checkin_at'];
    $checkout_at        = $entityBody['checkout_at'];
    $checkin_by_id      = $entityBody['checkin_by_id'];
    $checkout_by_id     = $entityBody['checkout_by_id'];
    $gate_checkin_id    = $entityBody['gate_checkin_id'];
    $gate_checkout_id   = $entityBody['gate_checkout_id'];


    $pd_acc_naik_by = '';
    $pd_pos_pendakian = '';
    if (!empty($checkin_at) && !empty($checkin_by_id) && !empty($gate_checkin_id)) {
        $sql_naik_admin     = mysqli_fetch_array(mysqli_query($conn, "SELECT user_id FROM user WHERE user_id_tiket_pendakian='$checkin_by_id'"));
        $sql_naik_gate      = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_id FROM tb_pos_pendakian WHERE mountain_gate_id='$gate_checkin_id'"));
        $pd_acc_naik_by     = $sql_naik_admin['user_id'];
        $pd_pos_pendakian   = $sql_naik_gate['pp_id'];
        $pd_status          = 'sudah naik';
    }

    $pd_acc_turun_by = '';
    $pd_pos_turun    = '';
    if (!empty($checkout_at) && !empty($checkout_by_id) && !empty($gate_checkout_id)) {
        $sql_turun_admin     = mysqli_fetch_array(mysqli_query($conn, "SELECT user_id FROM user WHERE user_id_tiket_pendakian='$checkout_by_id'"));
        $sql_turun_gate      = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_id FROM tb_pos_pendakian WHERE mountain_gate_id='$gate_checkout_id'"));
        $pd_acc_turun_by     = $sql_turun_admin['user_id'];
        $pd_pos_turun        = $sql_turun_gate['pp_id'];
        $pd_status           = 'sudah turun';
    }

    $sqlKR = "INSERT INTO tb_pendakian (
    pd_nomor,
    pd_nama_ketua,
    pd_no_ktp,
    pd_tempat_lahir,
    pd_tgl_lahir,
    pd_no_hp,
    pd_email,
    pd_alamat,
    pd_provinsi,
    pd_kabupaten,
    pd_kecamatan,
    pd_desa,
    pd_kewarganegaraan,
    pd_jenis_kelamin,
    pd_status, 
    tgl_naik,
    tgl_turun,
    keterangan,
    biaya,
    jalur,
    sts_bayar,
    denda,
    expired_at,
    is_region_new,
    is_tiket_pendakian,
    tb_gunung_id, 
    pd_pos_pendakian,
    user_id_tiket_pendakian,
    trx_pendakian_id,
    payment_number,
    metode_pembayaran_id,
    pd_acc_naik_by,
    pd_tgl_naik,
    pd_acc_turun_by,
    pd_pos_turun,
    pd_tgl_turun,
    code
) VALUES (
    '$pd_nomor',
    '$pd_nama_ketua',
    '$pd_no_ktp',
    '$pd_tempat_lahir',
    '$pd_tgl_lahir',
    '$pd_no_hp',
    '$pd_email',
    '$pd_alamat',
    '$pd_provinsi',
    '$pd_kabupaten',
    '$pd_kecamatan',
    '$pd_desa',
    '$pd_kewarganegaraan',
    '$pd_jenis_kelamin',
    '$pd_status',
    '$tgl_naik',
    '$tgl_turun',
    '$keterangan',
    '$biaya',
    '$pos_id',
    '$sts_bayar',
    '0',
    '$expired_at',
    true,
    true,
    '$gunung_id',
    " . (is_numeric($pos_id) ? "'$pos_id'" : "NULL") . ",
    '$user_id_tiket_pendakian',
    '$trx_pendakian_id',
    '$payment_number',
    '$metode_pembayaran_id',
    " . (is_numeric($pd_acc_naik_by) ? "'$pd_acc_naik_by'" : "NULL") . ",
    " . (!empty($checkin_at) ? "'$checkin_at'" : "NULL") . ",
    " . (is_numeric($pd_acc_turun_by) ? "'$pd_acc_turun_by'" : "NULL") . ",
    " . (is_numeric($pd_pos_turun) ? "'$pd_pos_turun'" : "NULL") . ",
    " . (!empty($checkout_at) ? "'$checkout_at'" : "NULL") . ",
    $code
)";

    $sql     = mysqli_query($conn, $sqlKR);
    if (!$sql) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => "Transaksi gagal. Terjadi kesalahan saat menyimpan informasi data transaksi.",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }
    $last_id = mysqli_insert_id($conn);

    if(isset($entityBody['arr_anggota'])){
        $set_ap_nomor = 1;
        $arr_data = [];
        foreach ($entityBody['arr_anggota'] as $anggota) {

            $ap_pendakian  = $last_id;
            $ap_nomor      = $set_ap_nomor;
            $ap_nama       = $anggota['ap_nama'];
            $ap_no_telp    = $anggota['ap_no_telp'];
            $ap_no_ktp     = $anggota['ap_no_ktp'];
            $email         = $anggota['email'];
            $ap_kewarganegaraan  = $anggota['ap_kewarganegaraan'];
            $ap_kelamin    = $anggota['ap_kelamin'];
            $sqlAnggota    = "INSERT INTO tb_anggota_pendakian (ap_pendakian, ap_nomor, ap_nama, ap_no_telp, ap_no_ktp, email,
                          ap_kewarganegaraan, ap_kelamin, naik) VALUES ('$ap_pendakian','$ap_nomor','$ap_nama','$ap_no_telp',
            '$ap_no_ktp','$email', '$ap_kewarganegaraan','$ap_kelamin','N')";
            if (!mysqli_query($conn, $sqlAnggota)) {
                mysqli_rollback($conn);
                $respon = [
                    "error" => true,
                    "message" => "Transaksi gagal. Terjadi kesalahan saat menyimpan informasi data anggota.",
                    "data" => null
                ];
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($respon);
                exit();
            }
            $set_ap_nomor++;
        }
    }

    if(isset($entityBody['arr_emergency'])){
        $set_kd_nomor = 1;
        foreach ($entityBody['arr_emergency'] as $emergency) {
            $ap_pendakian  = $last_id;
            $kd_nomor      = $set_kd_nomor;
            $kd_nama       = $emergency['name'];
            $kd_no_telp    = $emergency['no_telp'];
            $kd_hubungan   = $emergency['hubungan'];
            $sqlEmergency  = "INSERT INTO tb_kontak_darurat (kd_pendakian, kd_nomor, kd_nama, kd_no_telp, kd_hubungan)
            VALUES ('$ap_pendakian','$kd_nomor','$kd_nama','$kd_no_telp', '$kd_hubungan')";
            if (!mysqli_query($conn, $sqlEmergency)) {
                mysqli_rollback($conn);
                $respon = [
                    "error" => true,
                    "message" => "Transaksi gagal. Terjadi kesalahan saat menyimpan informasi kontak darurat.",
                    "data" => null
                ];
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($respon);
                exit();
            }
            $set_kd_nomor++;
        }
    }

    if ($total_pesanan <= 0 || !$gunung_id || !$pos_id || !$tgl_naik) {
        $respon = [
            "error" => true,
            "message" => "Input tidak valid.",
            "data" => null
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($respon);
        exit();
    }

    mysqli_commit($conn);
    $respon = [
        "error"     => false,
        "message"   => "sync trx success",
        "data"      => [
            "partner_kode_registrasi"   => $pd_nomor,
            "partner_transaksi_id"      => $last_id,
            "sync_at"                   => Carbon::now()->format('Y-m-d H:i:s'),
        ]
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