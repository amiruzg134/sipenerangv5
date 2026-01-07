<?php
function generateKodeTransaksi8Digit(mysqli $conn, $code_pos_pendakian): string {
    $code_pos = str_pad($code_pos_pendakian, 2, '0', STR_PAD_LEFT);
    $year_digit = date('y') % 10;
    $kode = '';
    $max_attempts = 10;
    $attempt = 0;

    do {
        if (++$attempt > $max_attempts) {
            throw new Exception("Gagal membuat kode unik setelah $max_attempts percobaan.");
        }

        $micro = (int)((microtime(true) - floor(microtime(true))) * 1000000);
        $unik5 = substr(str_pad($micro, 6, '0', STR_PAD_LEFT), 0, 5);
        $kode = $code_pos . $year_digit . $unik5;
        $kode_registrasi = "PD-" . $kode;
        $cek = mysqli_query($conn, "SELECT 1 FROM tb_pendakian WHERE pd_nomor = '$kode_registrasi'");
    } while (mysqli_num_rows($cek) > 0);

    return $kode;
}