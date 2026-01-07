<?php
require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');
require '../../../../config/env.php';

use Carbon\Carbon;
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$code_id'");
        $row    = mysqli_fetch_array($sql);

        $code_desa      = $row['pd_desa'];
        $code_kecamatan = $row['pd_kecamatan'];
        $code_kota      = $row['pd_kabupaten'];
        $code_provinsi  = $row['pd_provinsi'];

        if ($row['is_region_new']){
            $desa       = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_villages WHERE code='$code_desa'"));
            $kecamatan  = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_districts WHERE code='$code_kecamatan'"));
            $kota       = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_cities WHERE code='$code_kota'"));
            $provinsi      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM indonesia_provinces WHERE code='$code_provinsi'"));
        }else{
            $desa       = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM villages WHERE id='$code_desa'"));
            $kecamatan  = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM districts WHERE id='$code_kecamatan'"));
            $kota       = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM regencies WHERE id='$code_kota'"));
            $provinsi      = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM provinces WHERE id='$code_provinsi'"));
        }
        if(isset($row['pd_pos_pendakian'])){
            $pos_naik_id = $row['pd_pos_pendakian'];
            $sql_pos_naik = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_nama FROM tb_pos_pendakian WHERE pp_id='$pos_naik_id'"));
            if (!empty($sql_pos_naik)){
                $pos_naik = $sql_pos_naik['pp_nama'];
            }else{
                $pos_naik = "-";
            }
        }else{
            $pos_naik = "-";
        }

//        if(isset($row['pd_acc_by'])){
//            $pd_acc_by = $row['pd_acc_by'];
//            $sql_verifikasi_mebayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user WHERE user_id='$pd_acc_by'"));
//            $verifikasi_pembayaran = $sql_verifikasi_mebayaran['nama'];
//        }else{
//            $verifikasi_pembayaran = "-";
//        }

        if(isset($row['metode_pembayaran_id'])){
            $metode_pembayaran_id = $row['metode_pembayaran_id'];
            $sql_pembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT name, kategori FROM metode_pembayaran WHERE id='$metode_pembayaran_id'"));
            $metode_pembayaran   = $sql_pembayaran['name'];
            $kategori_pembayaran = $sql_pembayaran['kategori'];
        }else{
            $metode_pembayaran   = "-";
            $kategori_pembayaran = "-";
        }

        if(isset($row['pd_acc_naik_by'])){
            $pd_acc_naik_by = $row['pd_acc_naik_by'];
            $sql_verifikasi_checkin = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user WHERE user_id='$pd_acc_naik_by'"));
            if (!empty($sql_verifikasi_checkin)){
                $verifikasi_checkin = $sql_verifikasi_checkin['nama'];
            }else{
                $verifikasi_checkin = "-";
            }
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
            if (!empty($sql_verifikasi_checkout)){
                $verifikasi_checkout = $sql_verifikasi_checkout['nama'];
            }else{
                $verifikasi_checkout = "-";
            }
        }else{
            $verifikasi_checkout = "-";
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

        $expired_at = $row['expired_at'];
        $is_expired = false;
        if (!empty($expired_at)) {
            $now = new DateTime();
            $expired_time = new DateTime($expired_at);
            if ($expired_time < $now) {
                $is_expired = true;
            }
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
            "expired_at"        => $row['expired_at'] != null ? Carbon::parse($row['expired_at'])->format('d-m-Y H:i') : "-",
            "is_expired"        => $is_expired,
            "informasi"         => [
                "is_region_new"     => $row['is_region_new'],
                "no_registrasi"     => $row['pd_nomor'],
                "tgl_registrasi"    => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i'),
                "pos_naik"          => $pos_naik,
                "tgl_naik"          => Carbon::parse($row['tgl_naik'])->format('d-m-Y'),
                "tgl_turun"         => Carbon::parse($row['tgl_turun'])->format('d-m-Y'),
                "tarif"             => $row['biaya'] != null ? rupiah($row['biaya']) : 0,
                "payment_number"    => $row['payment_number'],
                "tgl_bayar"         => $row['tgl_bayar'] != null ? Carbon::parse($row['tgl_bayar'])->format('d-m-Y H:i') : "-",
                "pd_status"         => $row['pd_status'],
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
        $status_transaksi = $_POST['status_transaksi'] == "all" ? null : $_POST['status_transaksi'];
        $start_date       = $_POST['filter_start_date'] ?? null;
        $end_date         = $_POST['filter_end_date'] ?? null;
        $status_data      = $_POST['status_data'] != null ? $_POST['status_data'] : 1;

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length'];
        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']);

        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " AND (
            p.pd_nama_ketua LIKE '%$searchValue%' OR 
            p.pd_no_ktp LIKE '%$searchValue%' OR 
            p.pd_nomor LIKE '%$searchValue%' OR 
            a.ap_nama LIKE '%$searchValue%' OR 
            a.ap_no_ktp LIKE '%$searchValue%' OR 
            a.ap_no_telp LIKE '%$searchValue%' OR 
            a.ap_nomor LIKE '%$searchValue%' OR 
            a.email LIKE '%$searchValue%'
        )";
        }

        $sqlWhere = " WHERE p.is_region_new = $status_data";

        if(!empty($start_date) && !empty($end_date)){
            $filter_date_start = Carbon::parse($start_date)->format('Y-m-d');
            $filter_date_end   = Carbon::parse($end_date)->format('Y-m-d');
            $sqlWhere .= " AND p.pd_tanggal_registrasi BETWEEN '$filter_date_start' AND '$filter_date_end'";
        }

        if($status_transaksi != null){
            $sqlWhere .= " AND p.pd_status = '$status_transaksi'";
        }

        // Hitung total record
        $sel = mysqli_query($conn,"
        SELECT COUNT(DISTINCT p.pd_id) AS allcount 
        FROM tb_pendakian p
        LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id
        $sqlWhere
    ");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

        // Hitung total record setelah filter
        $sel = mysqli_query($conn,"
        SELECT COUNT(DISTINCT p.pd_id) AS allcount 
        FROM tb_pendakian p
        LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id
        $sqlWhere $searchQuery
    ");
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

        // Ambil data
        $empQuery = "
            SELECT p.* 
            FROM tb_pendakian p
            LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id
            $sqlWhere $searchQuery
            GROUP BY p.pd_id
            ORDER BY $columnName $columnSortOrder
            LIMIT $row, $rowperpage
        ";
        $empRecords = mysqli_query($conn, $empQuery);
        $data = array();

        while ($row = mysqli_fetch_array($empRecords)) {
            $id = $row['pd_id'];
            $anggotaQuery = mysqli_query($conn, "SELECT ap_nama FROM tb_anggota_pendakian WHERE ap_pendakian = '$id'");
            $anggotaList = [];
            while ($anggota = mysqli_fetch_assoc($anggotaQuery)) {
                $anggotaList[] = $anggota['ap_nama'];
            }
            $nama_anggota = '<ul style="padding-left: 18px; margin: 0">';
            foreach ($anggotaList as $anggota) {
                $nama_anggota .= "<li>$anggota</li>";
            }
            $nama_anggota .= '</ul>';

            $style = 'text-transform:uppercase;background-color:#36b6d5;color:#ffffff';

            switch ($row['pd_status']) {
                case 'menunggu pembayaran':
                    $style = 'text-transform:uppercase;background-color:#dedede;color:#ffffff';
                    break;
                case 'menunggu verifikasi':
                    $style = 'text-transform:uppercase;background-color:#ffc107;color:#ffffff';
                    break;
                case 'disetujui':
                    $style = 'text-transform:uppercase;background-color:#3bd536;color:#ffffff';
                    break;
                case 'ditolak':
                    $style = 'text-transform:uppercase;background-color:#bf4336;color:#ffffff';
                    break;
                case 'sudah naik':
                case 'sudah turun':
                    $style = 'text-transform:uppercase;background-color:#36b6d5;color:#ffffff';
                    break;
                case 'batal':
                case 'dibatalkan':
                    $style = 'text-transform:uppercase;background-color:#FF5733;color:#ffffff';
                    break;
            }

            $status = '<span class="label" style="'.$style.'">'.$row['pd_status'].'</span>';

            $data[] = array(
                "pd_nomor"              => $row['pd_nomor'],
                "pd_nama_ketua"         => $row['pd_nama_ketua'],
                "anggota"               => $nama_anggota,
                "tgl_naik"              => Carbon::parse($row['tgl_naik'])->format('d-m-Y'),
                "tgl_turun"             => Carbon::parse($row['tgl_turun'])->format('d-m-Y'),
                "pd_tanggal_registrasi" => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i:s'),
                "biaya"                 => rupiah(intval($row['biaya'])),
                "status"                => $status,
                "action"                => "<a class='btn btn-info button_menu' id='detail-kelola-transaksi' data-id='$id'><i class='fa fa-paste'></i> Detail</a>",
            );
        }

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
}else if($_GET['action'] == "list_terlewatkan") {
    try {
        $start_date = $_POST['filter_start_date'] ?? null;
        $end_date   = $_POST['filter_end_date'] ?? null;

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length'];
        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']);

        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " AND (
            p.pd_nama_ketua LIKE '%$searchValue%' OR 
            p.pd_no_ktp LIKE '%$searchValue%' OR 
            p.pd_nomor LIKE '%$searchValue%' OR 
            a.ap_nama LIKE '%$searchValue%' OR 
            a.ap_no_ktp LIKE '%$searchValue%' OR 
            a.ap_no_telp LIKE '%$searchValue%' OR 
            a.ap_nomor LIKE '%$searchValue%' OR 
            a.email LIKE '%$searchValue%'
        )";
        }

        $sqlWhere = " WHERE p.is_region_new=1 AND p.expired_at < NOW() AND p.sts_bayar='unpaid'";
        if(!empty($start_date) && !empty($end_date)){
            $filter_date_start = Carbon::parse($start_date)->format('Y-m-d');
            $filter_date_end   = Carbon::parse($end_date)->format('Y-m-d');
            $sqlWhere .= " AND p.tgl_naik BETWEEN '$filter_date_start' AND '$filter_date_end'";
        }

        // Hitung total
        $sel = mysqli_query($conn,"SELECT COUNT(DISTINCT p.pd_id) AS allcount 
        FROM tb_pendakian p 
        LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id 
        $sqlWhere");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

        // Hitung total setelah filter
        $sel = mysqli_query($conn,"SELECT COUNT(DISTINCT p.pd_id) AS allcount 
        FROM tb_pendakian p 
        LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id 
        $sqlWhere $searchQuery");
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

        // Ambil data
        $empQuery = "SELECT p.* FROM tb_pendakian p 
        LEFT JOIN tb_anggota_pendakian a ON a.ap_pendakian = p.pd_id 
        $sqlWhere $searchQuery 
        GROUP BY p.pd_id 
        ORDER BY $columnName $columnSortOrder 
        LIMIT $row, $rowperpage";
        $empRecords = mysqli_query($conn, $empQuery);
        $data = array();

        while ($row = mysqli_fetch_array($empRecords)) {
            $id = $row['pd_id'];
            $anggotaQuery = mysqli_query($conn, "SELECT ap_nama FROM tb_anggota_pendakian WHERE ap_pendakian = '$id'");
            $anggotaList = [];
            while ($anggota = mysqli_fetch_assoc($anggotaQuery)) {
                $anggotaList[] = $anggota['ap_nama'];
            }
            $nama_anggota = '<ul style="padding-left: 18px; margin: 0">';
            foreach ($anggotaList as $anggota) {
                $nama_anggota .= "<li>$anggota</li>";
            }
            $nama_anggota .= '</ul>';

            $style = 'text-transform:uppercase;background-color:#36b6d5;color:#ffffff';

            switch ($row['pd_status']) {
                case 'menunggu pembayaran':
                    $style = 'text-transform:uppercase;background-color:#dedede;color:#ffffff';
                    break;
                case 'menunggu verifikasi':
                    $style = 'text-transform:uppercase;background-color:#ffc107;color:#ffffff';
                    break;
                case 'disetujui':
                    $style = 'text-transform:uppercase;background-color:#3bd536;color:#ffffff';
                    break;
                case 'ditolak':
                    $style = 'text-transform:uppercase;background-color:#bf4336;color:#ffffff';
                    break;
                case 'sudah naik':
                case 'sudah turun':
                    $style = 'text-transform:uppercase;background-color:#36b6d5;color:#ffffff';
                    break;
                case 'batal':
                case 'dibatalkan':
                    $style = 'text-transform:uppercase;background-color:#FF5733;color:#ffffff';
                    break;
            }

            $status = '<span class="label" style="'.$style.'">'.$row['pd_status'].'</span>';

            $data[] = array(
                "pd_nomor"              => $row['pd_nomor'],
                "pd_nama_ketua"         => $row['pd_nama_ketua'],
                "anggota"               => $nama_anggota,
                "tgl_naik"              => Carbon::parse($row['tgl_naik'])->format('d-m-Y'),
                "tgl_turun"             => Carbon::parse($row['tgl_turun'])->format('d-m-Y'),
                "pd_tanggal_registrasi" => Carbon::parse($row['pd_tanggal_registrasi'])->format('d-m-Y H:i:s'),
                "biaya"                 => rupiah(intval($row['biaya'])),
                "status"                => $status,
                "action"                => "<a class='btn btn-info button_menu' id='detail-kelola-transaksi' data-id='$id'><i class='fa fa-paste'></i> Detail</a>",
            );
        }

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
        $admin_id = $_POST['admin_id'];
        $status_konfirmasi = $_POST['status_konfirmasi'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_accest_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_accest_key = $sql_accest_key['value'] != null ? $sql_accest_key['value'] : getenv('ACCESS_KEY');

        if($status_konfirmasi == "null"){
            $respon = [
                "error"   => true,
                "message" => "Pilih status verifikasi pengajuan reschedule pendakian",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai pembayaran",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $trx_pendakian = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));
        $reschedule_verified_at = Carbon::now()->format('Y-m-d H:i');

        $response = $client->post($env_base_url.'reschedule-trx/sync/confirm', [
                'form_params' => [
                    'trx_id'    => $trx_pendakian['trx_pendakian_id'],
                    'admin_id'  => $user_admin['user_id_tiket_pendakian'],
                    'reschedule_verified_at' => $reschedule_verified_at,
                    'status'    => $status_konfirmasi
                ],
                'headers' => [
                    'Access-Key'    => $env_accest_key,
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
            if($status_konfirmasi == 2){
                $old_start_date = $trx_pendakian['tgl_naik'];
                $old_end_date   = $trx_pendakian['tgl_turun'];

                $start_date     = $trx_pendakian['reschedule_tgl_naik'];
                $end_date       = $trx_pendakian['reschedule_tgl_turun'];
                $sql = mysqli_query($conn, "UPDATE tb_pendakian SET 
                status_reschedule=2,
                tgl_naik='$start_date',
                tgl_turun='$end_date',
                reschedule_tgl_naik='$old_start_date', 
                reschedule_tgl_turun='$old_end_date',
                reschedule_verified_id='$admin_id',
                reschedule_verified_at ='$reschedule_verified_at'
                WHERE pd_id='$trx_id'");
            }else{
                $sql = mysqli_query($conn, "UPDATE tb_pendakian SET 
                status_reschedule=3,
                reschedule_verified_id='$admin_id',
                reschedule_verified_at ='$reschedule_verified_at'
                WHERE pd_id='$trx_id'");
            }

            $respon = [
                "error"   => false,
                "message" => $res['message'],
                "data"    => null,
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
}else if($_GET['action'] == "konfirmasi-pembayaran") {
    try {
        mysqli_begin_transaction($conn);

        $trx_id   = $_POST['data_trx_id'];
        $admin_id = $_POST['admin_id'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai pembayaran",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $trx_pendakian = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));


        $test = [
            'trx_id'        => $trx_pendakian['trx_pendakian_id'],
            'total_payment' => $trx_pendakian['biaya'],
            'user_verifikasi_id' => $user_admin['user_id_tiket_pendakian'],
        ];

        $response = $client->post($env_base_url.'confirm-payment', [
                'form_params' => [
                    'trx_id'        => $trx_pendakian['trx_pendakian_id'],
                    'total_payment' => $trx_pendakian['biaya'],
                    'user_verifikasi_id' => $user_admin['user_id_tiket_pendakian'],
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key,
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
            session_start();
            $user_admin_id = $_SESSION['uuid_admin'];
            $date   = Carbon::now()->format('Y-m-d H:i:s');
            $sql = mysqli_query($conn, "UPDATE tb_pendakian SET tgl_bayar = '$date',
                sts_bayar='paid', pd_status='disetujui', pd_acc_by='$user_admin_id' WHERE pd_id='$trx_id'");

            mysqli_commit($conn);
            $respon = [
                "error"   => false,
                "message" => "Konfirmasi Pembayaran Berhasil",
                "data"    => $trx_id,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "change-tgl-transaksi") {
    try {
        mysqli_begin_transaction($conn);
        if (empty($_POST['start_date']) || empty($_POST['end_date'])) {
            echo json_encode([
                "error" => true,
                "message" => "Tanggal Naik dan Turun harus diisi."
            ]);
            exit();
        }

        $trx_id   = $_POST['data_trx_id'];
        $admin_id = $_POST['admin_id'];
        $start_date = $_POST['start_date'];
        $end_date   = $_POST['end_date'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai pembayaran",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));
        $anggota   = mysqli_fetch_array(mysqli_query($conn, "SELECT count(ap_pendakian) AS total FROM tb_anggota_pendakian WHERE ap_pendakian='$trx_id'"));
        $total_anggota = $anggota['total']+1;

        $tb_gunung_id        = $transaksi['tb_gunung_id'];
        $tb_pos_pendakian_id = $transaksi['pd_pos_pendakian'];
        $tanggal_naik        = date('Y-m-d', strtotime($transaksi['tgl_naik']));

        $tanggal_naik_old  = date('Y-m-d', strtotime($transaksi['tgl_naik']));
        $tanggal_turun_old = date('Y-m-d', strtotime($transaksi['tgl_turun']));

        $tanggal_naik_new  = date('Y-m-d', strtotime($start_date));
        $tanggal_turun_new = date('Y-m-d', strtotime($end_date));

        $sqlKuotaUpdate = "UPDATE tiket_kuota SET stock_available = stock_available - $total_anggota 
                    WHERE tb_gunung_id='$tb_gunung_id'
                      AND tb_pos_pendaki_id='$tb_pos_pendakian_id' AND date='$tanggal_naik_new' 
                      AND stock_available >= $total_anggota";
        mysqli_query($conn, $sqlKuotaUpdate);
        if (mysqli_affected_rows($conn) == 0) {
            mysqli_rollback($conn);
            $respon = [
                "error" => true,
                "message" => "Stok tidak cukup.",
                "data" => null
            ];
            echo json_encode($respon);
            exit();
        }

        $response = $client->post($env_base_url.'reshedule-tanggal-pendakian', [
                'form_params' => [
                    'trx_id'        => $transaksi['trx_pendakian_id'],
                    'tanggal_naik_old'  => $tanggal_naik_old,
                    'tanggal_turun_old' => $tanggal_turun_old,
                    'tanggal_naik_new'  => $tanggal_naik_new,
                    'tanggal_turun_new' => $tanggal_turun_new,
                    'user_verifikasi_id' => $user_admin['user_id_tiket_pendakian'],
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key
                ],
            ]
        );

        $res = json_decode($response->getBody(), true);
        if($res['error']){
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => $res['message'],
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }else{
            $sqlKuotaRestore = mysqli_query($conn,"
                    UPDATE tiket_kuota 
                    SET stock_available = stock_available + $total_anggota 
                    WHERE tb_gunung_id = '$tb_gunung_id' 
                      AND tb_pos_pendaki_id = '$tb_pos_pendakian_id' 
                      AND date = '$tanggal_naik'
                ");

            $sql = mysqli_query($conn, "UPDATE tb_pendakian SET tgl_naik ='$tanggal_naik_new', tgl_turun='$tanggal_turun_new' WHERE pd_id='$trx_id'");

            mysqli_commit($conn);
            $respon = [
                "error"   => false,
                "message" => "Rubahan Tanggal Pendakian Berhasil",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "cancel-transaksi") {
    try {
        mysqli_begin_transaction($conn);

        $trx_id   = $_POST['data_trx_id'];
        $admin_id = $_POST['admin_id'];
        $cancel_reason = $_POST['cancel_reason'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai pembayaran",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));
        $anggota   = mysqli_fetch_array(mysqli_query($conn, "SELECT count(ap_pendakian) AS total FROM tb_anggota_pendakian WHERE ap_pendakian='$trx_id'"));
        $total_anggota = $anggota['total']+1;

        $tb_gunung_id        = $transaksi['tb_gunung_id'];
        $tb_pos_pendakian_id = $transaksi['pd_pos_pendakian'];
        $tanggal_naik        = date('Y-m-d', strtotime($transaksi['tgl_naik']));

        $response = $client->post($env_base_url.'pembatalan-transaksi', [
                'form_params' => [
                    'trx_id'        => $transaksi['trx_pendakian_id'],
                    'tanggal_naik'  => $tanggal_naik,
                    'total_anggota' => $total_anggota,
                    'user_verifikasi_id' => $user_admin['user_id_tiket_pendakian'],
                    'cancel_reason'    => $cancel_reason,
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key
                ],
            ]
        );

        $res = json_decode($response->getBody(), true);
        if($res['error']){
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => $res['message'],
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }else{
            session_start();
            $user_admin_id = $_SESSION['uuid_admin'];
            $sqlKuotaRestore = mysqli_query($conn,"
                    UPDATE tiket_kuota 
                    SET stock_available = stock_available + $total_anggota 
                    WHERE tb_gunung_id = '$tb_gunung_id' 
                      AND tb_pos_pendaki_id = '$tb_pos_pendakian_id' 
                      AND date = '$tanggal_naik'
                ");

            $status = "-";
            if ($cancel_reason == "batal"){
                $status = "dibatalkan";
            }else if($cancel_reason == "expired"){
                $status = "kadaluwarsa";
            }

            $sql = mysqli_query($conn, "UPDATE tb_pendakian SET sts_bayar='unpaid', pd_status='$status', pd_acc_by='$user_admin_id' WHERE pd_id='$trx_id'");

            mysqli_commit($conn);
            $respon = [
                "error"   => false,
                "message" => "Pembatalan transaksi berhasil",
                "data"    => $trx_id,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "rollback-transaksi") {
    try {
        mysqli_begin_transaction($conn);

        $trx_id   = $_POST['data_trx_id'];
        $admin_id = $_POST['admin_id'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai pembayaran",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id='$trx_id'"));

        if($transaksi['pd_status'] != 'batal' && $transaksi['pd_status'] != 'dibatalkan' && $transaksi['pd_status'] != 'kadaluwarsa') {
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => "Anda tidak dapat melakukan proses rollback transaksi di status pembayaran kecuali batal & kadaluwarsa",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $anggota   = mysqli_fetch_array(mysqli_query($conn, "SELECT count(ap_pendakian) AS total FROM tb_anggota_pendakian WHERE ap_pendakian='$trx_id'"));
        $total_anggota = $anggota['total']+1;

        $tb_gunung_id        = $transaksi['tb_gunung_id'];
        $tb_pos_pendakian_id = $transaksi['pd_pos_pendakian'];
        $tanggal_naik        = date('Y-m-d', strtotime($transaksi['tgl_naik']));

        $response = $client->post($env_base_url.'rollback-status-transaksi', [
                'form_params' => [
                    'trx_id'        => $transaksi['trx_pendakian_id'],
                    'tanggal_naik'  => $tanggal_naik,
                    'total_anggota' => $total_anggota,
                    'user_verifikasi_id' => $user_admin['user_id_tiket_pendakian']
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key
                ],
            ]
        );

        $res = json_decode($response->getBody(), true);
        if($res['error']){
            mysqli_rollback($conn);
            $respon = [
                "error"   => true,
                "message" => $res['message'],
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }else{
            session_start();
            $user_admin_id = $_SESSION['uuid_admin'];
            $sqlKuotaRestore = mysqli_query($conn,"
                    UPDATE tiket_kuota SET stock_available = stock_available - $total_anggota 
                    WHERE tb_gunung_id='$tb_gunung_id'
                      AND tb_pos_pendaki_id='$tb_pos_pendakian_id' AND date='$tanggal_naik' 
                      AND stock_available >= $total_anggota
                ");

            $sql = mysqli_query($conn, "UPDATE tb_pendakian SET sts_bayar='unpaid', pd_status='menunggu pembayaran', pd_acc_by='$user_admin_id' WHERE pd_id='$trx_id'");
            mysqli_commit($conn);
            $respon = [
                "error"   => false,
                "message" => "Rollback status transaksi berhasil",
                "data"    => $trx_id,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}