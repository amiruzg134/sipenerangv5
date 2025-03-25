<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
//require '../config/env.php';

use Carbon\Carbon;

try{
    $kode_registrasi    = Carbon::now()->timestamp;
    $pd_nomor           = 'PD-'.$kode_registrasi;

    $entityBody = json_decode($_GET['json']);
    $pd_nama_ketua  = $entityBody->pd_nama_ketua;
    $pd_no_ktp      = $entityBody->pd_no_ktp;
    $pd_tempat_lahir = $entityBody->pd_tempat_lahir;
    $pd_tgl_lahir = $entityBody->pd_tgl_lahir;
    $pd_no_hp = $entityBody->pd_no_hp;
    $pd_email = $entityBody->pd_email;
    $pd_alamat = $entityBody->pd_alamat;
    $pd_provinsi = $entityBody->pd_provinsi;
    $pd_kabupaten = $entityBody->pd_kabupaten;
    $pd_kecamatan = $entityBody->pd_kecamatan;
    $pd_desa = $entityBody->pd_desa;
    $pd_kewarganegaraan = $entityBody->pd_kewarganegaraan;
    $pd_jenis_kelamin = $entityBody->pd_jenis_kelamin;
    $tgl_naik = $entityBody->tgl_naik;
    $tgl_turun = $entityBody->tgl_turun;
    $keterangan = "order form tiket pendakian";
    $biaya = $entityBody->biaya;
    $expired_at = $entityBody->expired_at;
    $tb_gunung_id = $entityBody->tb_gunung_id;
    $pd_pos_pendakian = $entityBody->pd_pos_pendakian;
    $trx_pendakian_id = $entityBody->trx_pendakian_id;
    $user_id_tiket_pendakian = $entityBody->user_id_tiket_pendakian;

    $gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE mountain_id='$tb_gunung_id'"));
    $gunung_id = $gunung['id'];

    $pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE mountain_gate_id='$pd_pos_pendakian'"));
    $pos_id = $pos['pp_id'];

    $sqlKR    = "INSERT INTO tb_pendakian (
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
                          trx_pendakian_id
        ) VALUES ('$pd_nomor',
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
                  'menunggu pembayaran', 
                  '$tgl_naik',
                  '$tgl_turun',
                  '$keterangan', 
                  '$biaya',
                  '$gunung_id',
                  'unpaid',
                  '0',
                  '$expired_at',
                  true,
                  false,
                  '$gunung_id',
                  '$pos_id',
                  '$user_id_tiket_pendakian',
                  '$trx_pendakian_id'
        )";
    $sql     = mysqli_query($conn, $sqlKR);
    $last_id = mysqli_insert_id($conn);


    if(isset($entityBody->arr_anggota)){
        $set_ap_nomor = 1;
        $arr_data = [];
        foreach ($entityBody->arr_anggota as $anggota) {
            $ap_pendakian  = $last_id;
            $ap_nomor      = $set_ap_nomor;
            $ap_nama       = $anggota->ap_nama;
            $ap_no_telp    = $anggota->ap_no_telp;
            $ap_no_ktp     = $anggota->ap_no_ktp;
            $email         = $anggota->email;
            $ap_kewarganegaraan  = $anggota->ap_kewarganegaraan;
            $ap_kelamin    = $anggota->ap_kelamin;
            $sqlAnggota    = "INSERT INTO tb_anggota_pendakian (ap_pendakian, ap_nomor, ap_nama, ap_no_telp, ap_no_ktp, email,
                          ap_kewarganegaraan, ap_kelamin, naik) VALUES ('$ap_pendakian','$ap_nomor','$ap_nama','$ap_no_telp',
            '$ap_no_ktp','$email', '$ap_kewarganegaraan','$ap_kelamin','N')";
            $sqlagt     = mysqli_query($conn, $sqlAnggota);
            $set_ap_nomor++;
        }
    }

    if(isset($entityBody->arr_emergency)){
        $set_kd_nomor = 1;
        foreach ($entityBody->arr_emergency as $emergency) {
            $ap_pendakian  = $last_id;
            $kd_nomor      = $set_kd_nomor;
            $kd_nama       = $emergency->name;
            $kd_no_telp    = $emergency->no_telp;
            $kd_hubungan   = $emergency->hubungan;
            $sqlEmergency  = "INSERT INTO tb_kontak_darurat (kd_pendakian, kd_nomor, kd_nama, kd_no_telp, kd_hubungan)
            VALUES ('$ap_pendakian','$kd_nomor','$kd_nama','$kd_no_telp', '$kd_hubungan')";
            $qEmergency  = mysqli_query($conn, $sqlEmergency);
            $set_kd_nomor++;
        }
    }

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
    $respon = [
        "error" => true,
        "message" => $e,
        "data" => null
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}


