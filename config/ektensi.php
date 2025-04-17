<?php
function rupiah($nominal)
{
    return number_format($nominal, 0, ",", ".");
}

function logPayment($type, $data) {
    $logFile = __DIR__ . '/payment_gateway.log';
    $logEntry = [
        'insert_time' => date('Y-m-d H:i:s'),
        'type' => $type,
        'data' => $data
    ];
    file_put_contents($logFile, json_encode($logEntry, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
}

function encrypt_openssl($plaintext, $key)
{
    $iv = random_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv);

    return base64_encode($iv . $ciphertext);
}

function decrypt_openssl($encrypted, $key)
{
    $data = base64_decode($encrypted);
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $iv_length);
    $ciphertext = substr($data, $iv_length);

    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
}


function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }
    return $temp;
}