<?php
require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
require '../config/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;

session_start();
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

try{
    mysqli_begin_transaction($conn);
    $token_user         = $_POST['token_user'];
    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $id_card_number     = $_POST['id_card_number'];
    $id_card_type       = $_POST['id_card_type'];
    $place_birth        = $_POST['place_birth'];
    $date_birth         = Carbon::createFromFormat('d-m-Y', $_POST['date_birth'])->format('Y-m-d');
    $phone              = $_POST['phone'];
    $email              = $_POST['email'];
    $gender             = $_POST['gender'] == 'laki-laki' ? 'L' : 'P';
    $address            = $_POST['address'];
    $province_code      = $_POST['province_code'];
    $province_name      = $_POST['province_name'];
    $city_code          = $_POST['city_code'];
    $city_name          = $_POST['city_name'];
    $district_code      = $_POST['district_code'];
    $district_name      = $_POST['district_name'];
    $village_code       = $_POST['village_code'];
    $village_name       = $_POST['village_name'];
    $is_wni             = $_POST['is_wni'];
    $data_wni           = $_POST['data_wni'];
    $tb_gunung_id       = $_POST['tb_gunung_id'];
    $tb_pos_pendakian_id= $_POST['tb_pos_pendakian_id'];

    $camwni             = $_POST['camwni'] ?? 0;
    $camwna             = $_POST['camwna'] ?? 0;
    $harga_camera_wni   = 150000;
    $harga_camera_wna   = 300000;

    $start_date         = Carbon::parse($_POST['tb_start_date'])->format('Y-m-d');
    $end_date           = Carbon::parse($_POST['tb_end_date'])->format('Y-m-d');
    $expired_at         = Carbon::now()->addDays(1);

    $show_expired_at    = Carbon::parse($expired_at)->format('d-m-Y H:i:s');
    $show_start_date    = Carbon::parse($_POST['tb_start_date'])->format('d-m-Y');
    $show_end_date      = Carbon::parse($_POST['tb_end_date'])->format('d-m-Y');

    $sqlGunung = mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$tb_gunung_id'");
    $gunung    = mysqli_fetch_array($sqlGunung);

    $sqlMountainGate = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$tb_pos_pendakian_id'");
    $mountainGate    = mysqli_fetch_array($sqlMountainGate);

    $datepilih = Carbon::parse($_POST['tb_start_date'])->format('Y-m-d');
    if($mountainGate['can_booking_before_day'] > 0){
        $dateset = Carbon::now()->addDay($mountainGate['can_booking_before_day'])->format('Y-m-d');
        if(strtotime($datepilih) < strtotime($dateset)){
            $respon = [
                "error" => true,
                "message" => "Minimal Tanggal Naik H-".$mountainGate['can_booking_before_day'],
                "data" => null
            ];
            echo json_encode($respon);
            exit();
        }
    }


    $email_received = $_POST['email'];

    $nama_gunung = $gunung['nama'];
    $mountain_id = $gunung['mountain_id'];
    $mountain_gate_id = $mountainGate['mountain_gate_id'];

    $total_anggota = $_POST['total_anggota'];
    $arr_anggota[] = [
        "email"           => $email,
        "kewarganegaraan" => strtolower($data_wni),
        "is_ketua"        => true,
    ];

    for ($i = 1; $i < intval($total_anggota); $i++) {
        if(!empty($_POST["email_anggotake$i"])){
            $arr_anggota[] = [
                "email"           => $_POST["email_anggotake$i"],
                "kewarganegaraan" => $_POST["kw_anggotake$i"],
                "is_ketua"        => false,
            ];
        }
    }

    $count_kw = [];
    foreach ($arr_anggota as $item) {
        if($item['kewarganegaraan'] == "wni"){
            $count_kw[] = [
                "wni" => 1,
                "wna" => 0,
            ];
        }else{
            $count_kw[] = [
                "wni" => 0,
                "wna" => 1,
            ];
        }
    }

    $count_wni = array_sum(array_column($count_kw, 'wni'));
    $count_wna = array_sum(array_column($count_kw, 'wna'));

    $format_start_date  = strtotime($start_date);
    $format_end_date    = strtotime($end_date);
    for ($i = $format_start_date; $i<=$format_end_date; $i=$i+86400){
        $thisDateFormat = date( 'Y-m-d', $i);

        $sqlKuota   = mysqli_query($conn, "SELECT * FROM tiket_kuota WHERE tb_gunung_id='$tb_gunung_id' 
                  AND tb_pos_pendaki_id='$tb_pos_pendakian_id' AND date='$thisDateFormat'");
        $kuotaData  = mysqli_fetch_array($sqlKuota);
        $kuota_id   = $kuotaData['id'];


        $is_weekendDay = false;
        $day = date("D", strtotime($thisDateFormat));
        if($day == 'Sat' || $day == 'Sun'){
            $is_weekendDay = true;
        }

        if($count_wni > 0){
            if($is_weekendDay){
                $harga  = $kuotaData['price_weekend_wni'];
            }else{
                $harga  = $kuotaData['price_weekday_wni'];
            }
            $total = $count_wni*$harga;
            $set_total_bayar[] = [
                "total"   => $total,
            ];
        }

        if($count_wna > 0){
            if($is_weekendDay){
                $harga  = $kuotaData['price_weekend_wna'];
            }else{
                $harga  = $kuotaData['price_weekday_wna'];
            }
            $total = $count_wna*$harga;
            $set_total_bayar[] = [
                "total"   => $total,
            ];
        }

        $total_kuota_available =  intval($kuotaData['stock_available'])-$total_anggota;
        $sqlKuotaUpdate  = "UPDATE tiket_kuota SET stock_available='$total_kuota_available' WHERE id='$kuota_id'";
        $qKuotaUpdate    = mysqli_query($conn, $sqlKuotaUpdate);
    }

    $total_bayar_tiket = array_sum(array_column($set_total_bayar, 'total'));

    $detail_kamera = null;
    if ($camwni > 0){
        $totalcam_wni = $camwni*$harga_camera_wni;
        $detail_kamera[] = [
            "total" => $totalcam_wni,
        ];
    }
    if ($camwna > 0){
        $totalcam_wna = $camwna*$harga_camera_wna;
        $detail_kamera[] = [
            "total" => $totalcam_wna
        ];
    }

    $total_bayar_kamera = 0;
    if (!empty($detail_kamera)){
        $total_bayar_kamera = array_sum(array_column($detail_kamera, 'total'));
    }

    $total_bayar  = $total_bayar_tiket+$total_bayar_kamera;

    $fullname           = $first_name." ".$last_name;
    $kode_registrasi    = Carbon::now()->timestamp;
    $pd_nomor           = 'PD-'.$kode_registrasi;
    $set_expired_at = $expired_at->format('Y-m-d H:i');

    $metode_pembayaran_id = $_POST['metode_pembayaran'];
    $uuid     = $_SESSION['uuid'];
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
                          metode_pembayaran_id,
                          is_tiket_pendakian,
                          tb_gunung_id, 
                          pd_pos_pendakian, 
                          user_id_tiket_pendakian
        ) VALUES ('$pd_nomor',
                  '$fullname',
                  '$id_card_number',
                  '$place_birth',
                  '$date_birth',
                  '0$phone',
                  '$email',
                  '$address',
                  '$province_code',
                  '$city_code',
                  '$district_code',
                  '$village_code',
                  '$data_wni',
                  '$gender',
                  'menunggu pembayaran', 
                  '$start_date',
                  '$end_date',
                  '$tb_gunung_id', 
                  '$total_bayar',
                  '$tb_gunung_id',
                  'unpaid',
                  '0',
                  '$set_expired_at',
                  true,
                  '$metode_pembayaran_id',
                  false,
                  '$tb_gunung_id',
                  '$tb_pos_pendakian_id',
                  '$uuid'
        )";
    $sql     = mysqli_query($conn, $sqlKR);
    $last_id = mysqli_insert_id($conn);


    $metodePembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM metode_pembayaran WHERE id='$metode_pembayaran_id'"));
    $kategori_pembayaran = $metodePembayaran['kategori'];

    if($kategori_pembayaran == "VA"){

        $sql_BASE_URL_VA = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_VA'"));
        $BASE_URL_VA = $sql_BASE_URL_VA['value'] != null ? $sql_BASE_URL_VA['value'] : getenv('BASE_URL_VA');

        $send_va = [
            "VirtualAccount"        => '1518610109'.$kode_registrasi,
            "Nama"                  => $fullname,
            "TotalTagihan"          => $total_bayar,
            "TanggalExp"            => $expired_at->format('Ymd'),
            "Berita1"               => "Retribusi Pendakian ".$pd_nomor,
            "Berita2"               => "UPT Tahura Raden Soerjo",
            "Berita3"               => "",
            "Berita4"               => "",
            "Berita5"               => "",
            "FlagProses"            => "1"
        ];

        $dataLog = [
            "code"              => $pd_nomor,
            "payment_category"  => "VA",
            "log"               => $send_va,
        ];
        logPayment('PAYLOAD', $dataLog);
        $register_va = $client->post($BASE_URL_VA.'RegPen', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => $send_va
            ]
        );
        $res_data = json_decode($register_va->getBody(), true);
        $responseData = [
            "code"              => $pd_nomor,
            "payment_category"  => "VA",
            "log"               => $res_data,
        ];
        logPayment('RESPONSE', $responseData);
        $payment_number = $res_data['VirtualAccount'];
    }else if($kategori_pembayaran == "QRIS"){

        $sql_BASE_URL_QRIS = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_QRIS'"));
        $BASE_URL_QRIS = $sql_BASE_URL_QRIS['value'] != null ? $sql_BASE_URL_QRIS['value'] : getenv('BASE_URL_QRIS');

        $sql_MERCHANTPAN= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='MERCHANTPAN'"));
        $MERCHANTPAN = $sql_MERCHANTPAN['value'] != null ? $sql_MERCHANTPAN['value'] : getenv('MERCHANTPAN');

        $sql_TERMINALUSER= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='TERMINALUSER'"));
        $TERMINALUSER = $sql_TERMINALUSER['value'] != null ? $sql_TERMINALUSER['value'] : getenv('TERMINALUSER');

        $sql_MERCHANTHASHKEY= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='MERCHANTHASHKEY'"));
        $MERCHANTHASHKEY = $sql_MERCHANTHASHKEY['value'] != null ? $sql_MERCHANTHASHKEY['value'] : getenv('MERCHANTHASHKEY');

        $data_qris = [
            "merchantPan"   => $MERCHANTPAN,
            "hashcodeKey"   => hash('sha256', $MERCHANTPAN.$pd_nomor.$TERMINALUSER.$MERCHANTHASHKEY),
            "billNumber"    => $pd_nomor,
            "purposetrx"    => "PENGUJIAN",
            "storelabel"    => "DISHUB KEPANJEN",
            "customerlabel" => "PUBLIC",
            "terminalUser"  => $TERMINALUSER,
            "expiredDate"   => $expired_at->format('Y-m-d H:i:s'),
            "amount"        => $total_bayar
        ];

        $dataLog = [
            "code"              => $pd_nomor,
            "payment_category"  => "QRIS",
            "log"               => $data_qris,
        ];
        logPayment('PAYLOAD', $dataLog);
        $register_va = $client->post($BASE_URL_QRIS.'Dynamic', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => $data_qris
        ]);
        $res_data = json_decode($register_va->getBody(), true);
        $responseData = [
            "code"              => $pd_nomor,
            "payment_category"  => "QRIS",
            "log"               => $res_data,
        ];
        logPayment('RESPONSE', $responseData);
        $payment_number = $res_data['qrValue'];
    }else{
        $respon = [
            "error" => true,
            "message" => "Bembayaran selain VA & QRIS belum tersedia",
            "data" => null
        ];
        echo json_encode($respon);
        exit();
    }

    $sql_BASE_URL = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
    $BASE_URL = $sql_BASE_URL['value'] != null ? $sql_BASE_URL['value'] : getenv('BASE_URL');

    $sql_ACCESS_KEY = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
    $ACCESS_KEY = $sql_ACCESS_KEY['value'] != null ? $sql_ACCESS_KEY['value'] : getenv('ACCESS_KEY');

    $response = $client->post($BASE_URL.'trx', [
            'form_params' => [
                "metode_pembayaran_id" => $metodePembayaran['metode_pembayaran_tiket_pendakian_id'],
                "expired_at"        => $set_expired_at,
                "partner_transaksi_id" => $last_id,
                "partner_kode_registrasi" => $pd_nomor,
                "mountain_id"       => $mountain_id,
                "mountain_gate_id"  => $mountain_gate_id,
                "is_wni"            => $is_wni,
                "payment_number"    => $payment_number,
                "start_date"        => $start_date,
                "end_date"          => $end_date,
                "camwni"            => $camwni,
                "harga_camwni"      => $harga_camera_wni,
                "camwna"            => $camwna,
                "harga_camwna"      => $harga_camera_wna,
                "arr_anggota"       => $arr_anggota,
            ],
            'headers' => [
                'Access-Key' => $ACCESS_KEY,
                'Authorization' => "Bearer $token_user"
            ],
        ]
    );
    $res = json_decode($response->getBody(), true);

    $responseDataTiketPendakian = [
        "code"              => $pd_nomor,
        "log"               => $res,
    ];
    logPayment('RESPONSE_TIKET_PENDAKIAN', $responseDataTiketPendakian);

    if($res['error']){
        mysqli_rollback($conn);
        $respon = [
            "error" => true,
            "message" => $res['message'],
            "data" => null
        ];
        echo json_encode($respon);
        exit();
    }

    if(isset($res['data']['data_user'])){
        $set_ap_nomor = 1;
        foreach ($res['data']['data_user'] as $datum) {
            $ap_pendakian  = $last_id;
            $ap_nomor      = $set_ap_nomor;
            $ap_nama       = $datum['ap_nama'];
            $ap_no_telp    = $datum['ap_no_telp'];
            $ap_no_ktp     = $datum['ap_no_ktp'];
            $email         = $datum['email'];
            $ap_kewarganegaraan  = $datum['ap_kewarganegaraan'];
            $ap_kelamin    = $datum['ap_kelamin'];
            $sqlAnggota    = "INSERT INTO tb_anggota_pendakian (ap_pendakian, ap_nomor, ap_nama, ap_no_telp, ap_no_ktp, email,
                          ap_kewarganegaraan, ap_kelamin, naik) VALUES ('$ap_pendakian','$ap_nomor','$ap_nama','$ap_no_telp',
            '$ap_no_ktp','$email', '$ap_kewarganegaraan','$ap_kelamin','N')";
            $sqlagt     = mysqli_query($conn, $sqlAnggota);
            $set_ap_nomor++;
        }
    }

    if(isset($res['data']['data_emergency'])){
        $set_kd_nomor = 1;
        foreach ($res['data']['data_emergency'] as $datum) {
            $ap_pendakian  = $last_id;
            $kd_nomor      = $set_kd_nomor;
            $kd_nama       = $datum['kd_nama'];
            $kd_no_telp    = $datum['kd_no_telp'];
            $kd_hubungan   = $datum['kd_hubungan'];
            $sqlEmergency  = "INSERT INTO tb_kontak_darurat (kd_pendakian, kd_nomor, kd_nama, kd_no_telp, kd_hubungan) 
            VALUES ('$ap_pendakian','$kd_nomor','$kd_nama','$kd_no_telp', '$kd_hubungan')";
            $qEmergency  = mysqli_query($conn, $sqlEmergency);
            $set_kd_nomor++;
        }
    }

    if(isset($res['data']['trx_id'])){
        $code = base64_encode($res['data']['code']);
        $trx_pendakian_id = $res['data']['trx_id'];
        $sqlUpdate  = "UPDATE tb_pendakian SET trx_pendakian_id='$trx_pendakian_id', 
                        payment_number='$payment_number', 
                        code='$code',
                        camwni=$camwni,
                        camwna=$camwna,
                        bayarkamera=$total_bayar_kamera
                        WHERE pd_id='$last_id'";
        $qUpdate    = mysqli_query($conn, $sqlUpdate);
    }

    $mail = new PHPMailer;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = getenv('MAIL_HOST');
    $mail->SMTPAuth = getenv('MAIL_SMTPAUTH');
    $mail->Username = getenv('MAIL_USERNAME');
    $mail->Password = getenv('MAIL_PASSWORD');
    $mail->SMTPSecure = getenv('MAIL_SMTPSECURE');
    $mail->Port = getenv('MAIL_PORT');
    $mail->setFrom(getenv('MAIL_FROM'), 'UPT Tahura Raden Soerjo');
    $mail->addAddress($email_received, $fullname);
    $mail->isHTML(true);
    ob_start();
    include "../emailtagihan.php";
    $content = ob_get_contents();
    ob_end_clean();
    $mail->Subject = 'Booking Online e-Simaksi UPT Tahura Raden Soerjo';
    $mail->Body    = $content;
    $mail->send();

    mysqli_commit($conn);

    $respon = [
        "error" => false,
        "message" => "Pemesanan Berhasil",
        "data" => $pd_nomor
    ];
    echo json_encode($respon);
    exit();

}catch(mysqli_sql_exception $exception){
    mysqli_rollback($conn);
    $respon = [
      "error" => true,
      "message" => $exception,
      "data" => null
    ];
    echo json_encode($respon);
    exit();
}