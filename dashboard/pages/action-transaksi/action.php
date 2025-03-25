<?php

require '../../../vendor/autoload.php';
require_once('../../../config/connection.php');
require_once('../../../config/ektensi.php');
require '../../../config/env.php';

use Carbon\Carbon;
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$code_id'");
        $row    = mysqli_fetch_array($sql);

        $code_desa = $row['pd_desa'];
        $desa      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_villages WHERE code='$code_desa'"));

        $code_kecamatan = $row['pd_kecamatan'];
        $kecamatan      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_districts WHERE code='$code_kecamatan'"));

        $code_kota = $row['pd_kabupaten'];
        $kota      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_cities WHERE code='$code_kota'"));

        $code_provinsi = $row['pd_provinsi'];
        $provinsi      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_provinces WHERE code='$code_provinsi'"));

        if(isset($row['pd_pos_pendakian'])){
            $pos_naik_id = $row['pd_pos_pendakian'];
            $sql_pos_naik = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_nama FROM tb_pos_pendakian WHERE pp_id='$pos_naik_id'"));
            $pos_naik = $sql_pos_naik['pp_nama'];
        }else{
            $pos_naik = "-";
        }

        if(isset($row['pd_acc_by'])){
            $pd_acc_by = $row['pd_acc_by'];
            $sql_verifikasi_mebayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user WHERE user_id='$pd_acc_by'"));
            $verifikasi_pembayaran = $sql_verifikasi_mebayaran['nama'];
        }else{
            $verifikasi_pembayaran = "-";
        }

        if(isset($row['pd_acc_naik_by'])){
            $pd_acc_naik_by = $row['pd_acc_naik_by'];
            $sql_verifikasi_checkin = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user WHERE user_id='$pd_acc_naik_by'"));
            $verifikasi_checkin = $sql_verifikasi_checkin['nama'];
        }else{
            $verifikasi_checkin = "-";
        }

        if(isset($row['pd_pos_turun'])){
            $pos_checkout_id = $row['pd_pos_turun'];
            $sql_checkout = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_nama FROM tb_pos_pendakian WHERE pp_id='$pos_checkout_id'"));
            $pos_checkout = $sql_checkout['pp_nama'];
        }else{
            $pos_checkout = "-";
        }

        if(isset($row['pd_acc_turun_by'])){
            $pd_acc_turun_by = $row['pd_acc_turun_by'];
            $sql_verifikasi_checkout = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user WHERE user_id='$pd_acc_turun_by'"));
            $verifikasi_checkout = $sql_verifikasi_checkout['nama'];
        }else{
            $verifikasi_checkout = "-";
        }


        if(isset($row['metode_pembayaran_id'])){
            $metode_pembayaran_id = $row['metode_pembayaran_id'];
            $sql_pembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT name, kategori FROM metode_pembayaran WHERE id='$metode_pembayaran_id'"));
            $metode_pembayaran   = $sql_pembayaran['name'];
            $kategori_pembayaran = $sql_pembayaran['kategori'];
        }else{
            $metode_pembayaran   = "-";
            $kategori_pembayaran = "-";
        }


        $sqlAnggota     = mysqli_query($conn, "SELECT * FROM tb_anggota_pendakian WHERE ap_pendakian ='$row[pd_id]' ORDER BY ap_nomor ASC");
        $arr_anggota    = null;
        while ($anggota = mysqli_fetch_array($sqlAnggota)) {
            $arr_anggota[] = [
                "nama"              => $anggota['ap_nama'],
                "no_identitas"      => $anggota['ap_no_ktp'],
                "no_telp"           => $anggota['ap_no_telp'],
                "kewarganegaraan"   => $anggota['ap_kewarganegaraan'],
                "gender"            => $anggota['ap_kelamin'],
            ];
        }

        $sqlEmergency     = mysqli_query($conn, "SELECT * FROM tb_kontak_darurat WHERE kd_pendakian='$row[pd_id]'");
        $arr_emergency    = null;
        while ($emergency = mysqli_fetch_array($sqlEmergency)) {
            $arr_emergency[] = [
                "nama"      => $emergency['kd_nama'],
                "no_telp"   => $emergency['kd_no_telp'],
                "hubungan"  => $emergency['kd_hubungan'],
            ];
        }


        $data = [
            "id"                => $row['pd_id'],
            "nama_ketua"        => $row['pd_nama_ketua'],
            "alamat"            => $row['pd_alamat'],
            "no_ktp"            => $row['pd_no_ktp'],
            "ttl"               => $row['pd_tempat_lahir'].", ". Carbon::parse($row['pd_tgl_lahir'])->format('d-m-Y'),
            "pd_no_hp"          => $row['pd_no_hp'],
            "email"             => $row['pd_email'],
            "provinsi"          => $provinsi['name'],
            "kota"              => $kota['name'],
            "kecamatan"         => $kecamatan['name'],
            "desa"              => $desa['name'],
            "kewarganegaraan"   => $row['pd_kewarganegaraan'],
            "tgl_transaksi"     => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i'),
            "gender"            => $row['pd_jenis_kelamin'],
            "informasi"         => [
                "no_registrasi"     => $row['pd_nomor'],
                "tgl_registrasi"    => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i'),
                "pos_naik"          => $pos_naik,
                "tgl_naik"          => Carbon::parse($row['tgl_naik'])->format('d-m-Y'),
                "tgl_turun"         => Carbon::parse($row['tgl_turun'])->format('d-m-Y'),
                "tarif"             => rupiah($row['biaya']),
                "payment_number"    => $row['payment_number'],
                "tgl_bayar"         => $row['tgl_bayar'] != null ? Carbon::parse($row['tgl_bayar'])->format('d-m-Y H:i') : "-",
                "status_bayar"      => $row['sts_bayar'],
                "metode_pembayaran" => $metode_pembayaran,
                "is_reschedule"     => $row['is_reschedule'] != 0 ? true : false,
                "status_reschedule" => $row['status_reschedule'],
                "reschedule_tgl_naik"  => $row['reschedule_tgl_naik'],
                "reschedule_tgl_turun" => $row['reschedule_tgl_turun'],
                "kategori_pembayaran" => $kategori_pembayaran,
//                "verifikasi_pembayaran" => $verifikasi_pembayaran,
                "pos_checkin"           => $pos_naik,
                "tgl_checkin"           => $row['pd_tgl_naik'] != null ? Carbon::parse($row['pd_tgl_naik'])->format('d-m-Y H:i:s') : "-",
                "verifikasi_checkin"    => $verifikasi_checkin,
                "pos_checkout"          => $pos_checkout,
                "tgl_checkout"          => $row['pd_tgl_turun'] != null ? Carbon::parse($row['pd_tgl_turun'])->format('d-m-Y H:i:s') : "-",
                "verifikasi_checkout"   => $verifikasi_checkout,
                "url_simaksi"           => "../simaksi.php?id=".$row['pd_id'],
            ],
            "anggota"           => $arr_anggota,
            "emergency"         => $arr_emergency,
        ];

        $respon = [
            "error"   => false,
            "message" => "Detail",
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
}else if($_GET['action'] == "list") {
    try {
        $status_transaksi   = $_POST['status_transaksi'] == "all" ? null : $_POST['status_transaksi'];
        $start_date         = $_POST['filter_start_date'] ?? null;
        $end_date           = $_POST['filter_end_date'] ?? null;

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $uuid = $_POST['uuid'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " and (pd_nama_ketua like '%".$searchValue."%' or 
        pd_no_ktp like '%".$searchValue."%' or 
        pd_nomor like'%".$searchValue."%' ) ";
        }

## Total number of records without filtering
        if(!empty($start_date) && !empty($end_date)){
            $filter_date_start = Carbon::parse($start_date)->format('Y-m-d');
            $filter_date_end  = Carbon::parse($end_date)->format('Y-m-d');
            if($status_transaksi == null){
                $sqlWhere[] = "WHERE is_region_new=1 AND pd_tanggal_registrasi BETWEEN '$filter_date_start' AND '$filter_date_end'  AND user_id_tiket_pendakian='$uuid'";
            }else{
                $sqlWhere[] = "WHERE is_region_new=1 AND sts_bayar='$status_transaksi' AND pd_tanggal_registrasi BETWEEN '$filter_date_start' AND '$filter_date_end'  AND user_id_tiket_pendakian='$uuid'";
            }
        }{
            if($status_transaksi == null){
                $sqlWhere[] = "WHERE is_region_new=1  AND user_id_tiket_pendakian='$uuid'";
            }else{
                $sqlWhere[] = "WHERE is_region_new=1 AND sts_bayar='$status_transaksi'  AND user_id_tiket_pendakian='$uuid'";
            }
        }

        $sel = mysqli_query($conn,"select count(*) as allcount from tb_pendakian ".$sqlWhere[0].";");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($conn,"select count(*) as allcount from tb_pendakian ".$sqlWhere[0]." AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from tb_pendakian ".$sqlWhere[0]." AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($conn, $empQuery);
        $data = array();

        while ($row = mysqli_fetch_array($empRecords)) {
            $id    = $row['pd_id'];
            $class = 'label-info';
            if($row['sts_bayar'] == 'paid') {
                $class = 'label-success';
            }else {
                $class = 'label-warning';
            }
            $status = '<span class="label '.$class.'" style="text-transform:uppercase">'.$row['sts_bayar'].'</span>';


            $data[] = array(
                "pd_nomor"          => $row['pd_nomor'],
                "pd_nama_ketua"     => $row['pd_nama_ketua'],
                "tgl_naik"          => Carbon::parse($row['tgl_naik'])->format('d-m-Y'),
                "tgl_turun"         => Carbon::parse($row['tgl_turun'])->format('d-m-Y'),
                "pd_tanggal_registrasi" => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i:s'),
                "biaya"             => rupiah(intval($row['biaya'])),
                "status"            => $status,
                "action"            => "<a class='btn btn-info button_menu' id='detail-kelola-transaksi' data-id='$id'><i class='fa fa-paste'></i> Detail</a>",
            );
        }

## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "reschedule-trx") {
    try {
        $trx_id   = $_POST['data_trx_id'];
        $reschedule_start_date  = $_POST['reschedule_start_date'];
        $reschedule_end_date    = $_POST['reschedule_end_date'];

        $trx_pendakian = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));


        $sql_BASE_URL = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $BASE_URL = $sql_BASE_URL['value'] != null ? $sql_BASE_URL['value'] : getenv('BASE_URL');

        $sql_ACCESS_KEY = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $ACCESS_KEY = $sql_ACCESS_KEY['value'] != null ? $sql_ACCESS_KEY['value'] : getenv('ACCESS_KEY');

        $start_date     = Carbon::parse($reschedule_start_date)->format('Y-m-d');
        $end_date       = Carbon::parse($reschedule_end_date)->format('Y-m-d');
        $reschedule_at  = Carbon::now()->format('Y-m-d H:i');

        $response = $client->post($BASE_URL.'reschedule-trx/sync', [
                'form_params' => [
                    'trx_id'                 => $trx_pendakian['trx_pendakian_id'],
                    'reschedule_start_date'  => $start_date,
                    'reschedule_end_date'    => $end_date,
                    'reschedule_at'          => $reschedule_at,
                ],
                'headers' => [
                    'Access-Key'    => $ACCESS_KEY,
                ],
            ]
        );
        $res = json_decode($response->getBody(), true);
        if($res['error']){
            $respon = [
                "error"   => true,
                "message" => $res['message'],
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }else{
            $sql = mysqli_query($conn, "UPDATE tb_pendakian SET is_reschedule=true,
                        reschedule_tgl_naik='$start_date', reschedule_at='$reschedule_at',
                        reschedule_tgl_turun='$end_date', status_reschedule=1 WHERE pd_id='$trx_id'");

            $respon = [
                "error"   => false,
                "message" => "Pengajuan Reschedule Transaksi Berhasil",
                "data"    => $trx_id,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}