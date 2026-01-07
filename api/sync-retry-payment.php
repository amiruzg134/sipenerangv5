<?php

require '../vendor/autoload.php';
require '../config/connection.php';
require_once ('../config/ektensi.php');
require '../config/env.php';
require '../config/generate_code_registrasi.php';

use Carbon\Carbon;

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

try{
    mysqli_begin_transaction($conn);

    $entityBody = json_decode(file_get_contents('php://input'), true);
    if (!$entityBody || !isset($entityBody['trx_id'])) {
        echo json_encode([
            "error" => true,
            "message" => "Payload tidak valid atau trx_id kosong.",
            "data" => null
        ]);
        exit();
    }

    $payment_method_id  = mysqli_real_escape_string($conn, $entityBody['payment_method_id'] ?? '');
    $trx_id             = mysqli_real_escape_string($conn, $entityBody['trx_id']);
    $pin                = mysqli_real_escape_string($conn, $entityBody['pin'] ?? '');
    $total_tagihan      = mysqli_real_escape_string($conn, $entityBody['total_tagihan'] ?? '');
    $fullname           = mysqli_real_escape_string($conn, $entityBody['fullname'] ?? '');
    $mountain_id        = mysqli_real_escape_string($conn, $entityBody['mountain_id'] ?? '');
    $mountain_gate_id   = mysqli_real_escape_string($conn, $entityBody['mountain_gate_id'] ?? '');
    $expired_at         = isset($entityBody['expired_at']) && $entityBody['expired_at'] !== ''
        ? mysqli_real_escape_string($conn, $entityBody['expired_at'])
        : date('Y-m-d H:i:s', strtotime('+1 day'));

    $getMetode = mysqli_query($conn, "SELECT * FROM metode_pembayaran WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'");
    $metodePembayaran = mysqli_fetch_array($getMetode);

    if (!$metodePembayaran) {
        echo json_encode([
            "error" => true,
            "message" => "Metode pembayaran diserver sipenerang tidak ditemukan.",
            "data" => null
        ]);
        exit();
    }

    $kategori_pembayaran = $metodePembayaran['kategori'];
    $metode_pembayaran_id = $metodePembayaran['id'];

    $getTransaksi = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE trx_pendakian_id='$trx_id'");
    $transaksi = mysqli_fetch_array($getTransaksi);
    if (!$transaksi) {
        echo json_encode([
            "error" => true,
            "message" => "Transaksi diserver sipenerang tidak ditemukan atau terjadi kesalahan.",
            "data" => null
        ]);
        exit();
    }

    $getPos = mysqli_query($conn, "SELECT code FROM tb_pos_pendakian WHERE mountain_gate_id='$mountain_gate_id'");
    $pos_pendakian = mysqli_fetch_array($getPos);

    if (!$pos_pendakian) {
        echo json_encode([
            "error" => true,
            "message" => "Pos pendakian diserver sipenerang tidak ditemukan.",
            "data" => null
        ]);
        exit();
    }

    $code_pos_pendakian = $pos_pendakian['code'] ?? date('y');
    $kode_registrasi = generateKodeTransaksi8Digit($conn, $code_pos_pendakian);
    $pd_nomor = 'PD-' . $kode_registrasi;

    if($kategori_pembayaran == "VA"){
        $sql_BASE_URL_VA = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL_VA'"));
        $BASE_URL_VA = $sql_BASE_URL_VA['value'] != null ? $sql_BASE_URL_VA['value'] : getenv('BASE_URL_VA');

        $send_va = [
            "VirtualAccount"        => '15186101'.$kode_registrasi,
            "Nama"                  => $fullname,
            "TotalTagihan"          => $total_tagihan,
            "TanggalExp"            => Carbon::parse($expired_at)->format('Ymd'),
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


        try {
            $register_va = $client->post($BASE_URL_VA.'RegPen', [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'json' => $send_va,
                    'timeout' => 30,
                    'connect_timeout' => 15,
                    'http_errors' => false
                ]
            );

            $statusCode = $register_va->getStatusCode();
            $body = (string) $register_va->getBody();
            $res_data = json_decode($body, true);

            $responseData = [
                "code"              => $pd_nomor,
                "payment_category"  => "VA",
                "http_status"       => $statusCode,
                "log"               => $res_data ?? $body,
            ];
            logPayment('RESPONSE', $responseData);

            if ($statusCode >= 400) {
                $msg = $res_data['message'] ?? "Terjadi kendala pada layanan VA Bank Jatim (Status: $statusCode). Kode Registrasi: $pd_nomor";
                logPayment('ERROR', [
                    'code' => $pd_nomor,
                    'payment_category' => 'VA',
                    'error_type' => 'http_error',
                    'status' => $statusCode,
                    'body' => $res_data ?? $body,
                    'message' => $msg,
                ]);
                throw new Exception($msg);
            }

            if (!$res_data || !isset($res_data['VirtualAccount'])) {
                $msg = "Response API VA BANK JATIM tidak valid: " . substr($body, 0, 200);
                logPayment('ERROR', [
                    'code' => $pd_nomor,
                    'payment_category' => 'VA',
                    'error_type' => 'invalid_response',
                    'status' => $statusCode,
                    'body' => $res_data ?? $body,
                    'message' => $msg,
                ]);
                throw new Exception($msg);
            }

            $payment_number = $res_data['VirtualAccount'];

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            logPayment('ERROR', [
                'code' => $pd_nomor,
                'payment_category' => 'VA',
                'error_type' => 'connect_exception',
                'message' => $e->getMessage(),
                'send_data' => $send_va,
            ]);
            throw new Exception("Koneksi ke layanan VA Bank Jatim gagal atau sedang dalam perawatan sistem. Kode Registrasi: $pd_nomor");
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $resp = $e->hasResponse() ? $e->getResponse() : null;
            $status = $resp ? $resp->getStatusCode() : 500;
            $body = $resp ? (string) $resp->getBody() : null;

            logPayment('ERROR', [
                'code' => $pd_nomor,
                'payment_category' => 'VA',
                'error_type' => 'request_exception',
                'status' => $status,
                'body' => $body,
                'message' => $e->getMessage(),
            ]);
            throw new Exception("Mohon maaf, sistem pembayaran Bank Jatim sedang mengalami gangguan. Silakan coba beberapa saat lagi. Kode Registrasi: $pd_nomor");
        }


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
            "amount"        => $total_tagihan
        ];

        $dataLog = [
            "code"              => $pd_nomor,
            "payment_category"  => "QRIS",
            "log"               => $data_qris,
        ];
        logPayment('PAYLOAD', $dataLog);

        try {
            $register_qris = $client->post($BASE_URL_QRIS.'Dynamic', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => $data_qris,
                'timeout' => 30,
                'connect_timeout' => 15,
                'http_errors' => false
            ]);

            $statusCode = $register_qris->getStatusCode();
            $body = (string) $register_qris->getBody();
            $res_data = json_decode($body, true);

            $responseData = [
                "code"              => $pd_nomor,
                "payment_category"  => "QRIS",
                "http_status"       => $statusCode,
                "log"               => $res_data,
            ];
            logPayment('RESPONSE', $responseData);
            if ($statusCode >= 400 || !$res_data || !isset($res_data['qrValue'])) {
                $msg = "Server QRIS error ($statusCode): " . substr($body, 0, 200);
                logPayment('ERROR', [
                    'code' => $pd_nomor,
                    'payment_category' => 'QRIS',
                    'status' => $statusCode,
                    'body' => $body,
                    'message' => $msg,
                ]);
                throw new Exception($msg);
            }

            $payment_number = $res_data['qrValue'];
        } catch (Exception $e) {
            throw new Exception("Mohon maaf, sistem pembayaran QRIS sedang mengalami kendala. Silakan coba kembali nanti. Kode Registrasi: $pd_nomor");
        }

    }else{
        $respon = [
            "error" => true,
            "message" => "Bembayaran selain VA & QRIS belum tersedia",
            "data" => null
        ];
        echo json_encode($respon);
        exit();
    }

    $query = "UPDATE tb_pendakian SET pd_nomor='$pd_nomor', payment_number='$payment_number' WHERE trx_pendakian_id='$trx_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
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

    mysqli_commit($conn);
    $respon = [
        "error"     => false,
        "message"   => "Sync Payment Success",
        "data"      => [
            "payment_number" => $payment_number,
            "kode_registrasi" => $pd_nomor,
            "payment" => $res_data,
        ]
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}catch (Exception $e) {
    mysqli_rollback($conn);
    $respon = [
        "error" => true,
        "message" => $e->getMessage(),
        "data" => null
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respon);
    exit();
}