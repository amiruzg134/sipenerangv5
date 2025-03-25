<?php
    include 'config.php';
    include 'api.php';
    session_start();
    $_SESSION = array();
    session_destroy();

    try{
        $kode_registrasi    = rand(10,99).date('His');
        $pd_nomor           = 'PD-'.$kode_registrasi;

        if ($_POST['tjn'] == 'pundak') {
            $jalur = 5;
        }
        else {
            $jalur = $_POST['jalur'];
        }

        $kode = str_pad($jalur, 2, '0', STR_PAD_LEFT);

        $dataVa =  array(
            "VirtualAccount"        => '15186101'.$kode.$kode_registrasi,
            "Nama"                  => $_POST['namaketua'],
            "TotalTagihan"          => $_POST['bayar']+$_POST['bayarcam'],
            "TanggalExp"            => date('Ymd', strtotime('+1 days')),
            "Berita1"               => "Retribusi Pendakian ".$pd_nomor,
            "Berita2"               => "UPT Tahura Raden Soerjo",
            "Berita3"               => "",
            "Berita4"               => "",
            "Berita5"               => "",
            "FlagProses"            => "1"
        );

        // daftar VA
       // $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/RegPen', json_encode($dataVa));

        $response_array['status'] = $pd_nomor;
        echo json_encode($response_array);

        // KETUA ROMBONGAN
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
            pd_tgl_naik, 
            pd_tgl_turun,
            tgl_naik, 
            tgl_turun,
            keterangan, 
            biaya, 
            va, 
            jalur, 
            sts_bayar,
            denda
        ) VALUES (
            '".$pd_nomor."', 
            '".addslashes($_POST['namaketua'])."', 
            '".$_POST['identitasketua']."', 
            '".$_POST['tmptlahir']."', 
            '".$_POST['tgllahir']."', 
            '".$_POST['hpketua']."', 
            '".$_POST['email']."', 
            '".$_POST['almtketua']."', 
            '".$_POST['provinsi']."', 
            '".$_POST['kabupaten']."', 
            '".$_POST['kecamatan']."', 
            '".$_POST['kelurahan']."', 
            '".$_POST['wargaketua']."', 
            '".$_POST['jnsketua']."', 
            'menunggu pembayaran', 
            '".$_POST['tglnaik']."',  
            '".$_POST['tglturun']."',
            '".$_POST['tglnaik']."',  
            '".$_POST['tglturun']."',
            '".$_POST['tjn']."', 
            '".$_POST['bayar']."', 
            '".$dataVa['VirtualAccount']."', 
            '$jalur', 
            'unpaid',
            '0'
        )";
        mysqli_query($conn, $sqlKR) or die(mysqli_error($conn));

        // ANGGOTA ROMBONGAN
        $num = 1;
        $last_id = mysqli_insert_id($conn);
      
    if ($_POST['rombongan'] > 1) {  
        foreach($_POST['namaanggota'] as $key => $anggota){
            $noTelp     = $_POST['hpanggota'][$key];
            $identitas  = $_POST['identitasanggota'][$key];
            $warga      = $_POST['wargaanggota'][$key];
            $jenis      = $_POST['jnsanggota'][$key];
            
            if(!empty($anggota) && !empty($noTelp) && !empty($identitas)){
                $queryAnggota = "INSERT INTO tb_anggota_pendakian (
                    ap_pendakian,
                    ap_nomor,
                    ap_nama,
                    ap_no_telp,
                    ap_no_ktp,
                    ap_kewarganegaraan,
                    ap_kelamin,
                    naik
                )

                VALUES (
                    '$last_id', 
                    '$num', 
                    '".addslashes($anggota)."',  
                    '$noTelp', 
                    '$identitas', 
                    '$warga', 
                    '$jenis',
                    'N'
                )";

                mysqli_query($conn, $queryAnggota) or die(mysqli_error($conn));
                $num++;
            }
        }
    }
    
        // KONTAK DARURAT
        $queryKontak = "INSERT INTO tb_kontak_darurat (
            kd_pendakian, 
            kd_nomor, 
            kd_nama, 
            kd_no_telp,
            kd_alamat,
            kd_hubungan 
        )

        VALUES (
            '$last_id', 
            1, 
            '".addslashes($_POST['namadarurat'])."', 
            '".$_POST['hpdarurat']."', 
            '".$_POST['almtdarurat']."', 
            '".$_POST['hubungan']."'
        )";
        mysqli_query($conn, $queryKontak) or die(mysqli_error($conn));

        if ($_POST['tjn'] == 'arjuno') {
            //PERLENGKAPAN
            $queryPerlengkapan = "INSERT INTO tb_peralatan (
                pr_pendakian, 
                pr_tenda, 
                pr_sleeping_bag, 
                pr_peralatan_masak, 
                pr_bahan_bakar, 
                pr_ponco, 
                pr_senter, 
                pr_obat, 
                pr_matras, 
                pr_kantong_sampah, 
                pr_jaket
            ) 
            VALUES (
                '$last_id', 
                '".$_POST['tenda']."', 
                '".$_POST['sb']."', 
                '".$_POST['masak']."', 
                '".$_POST['bahanbakar']."', 
                '".$_POST['jashujan']."', 
                '".$_POST['senter']."', 
                '".$_POST['obat']."', 
                '".$_POST['matras']."', 
                '".$_POST['sampah']."', 
                '".$_POST['jaket']."' 
            )";
            
            mysqli_query($conn, $queryPerlengkapan) or die(mysqli_error($conn));

            // LOGISTIK
            $num = 1;
            foreach($_POST['makanan'] as $key => $logistik){
                $jmlmakanan     = $_POST['jmlmakanan'][$key];
                $queryLogistik  = "INSERT INTO tb_logistik (lg_pendakian, lg_nomor, lg_nama, lg_jumlah) VALUES (
                    '$last_id', 
                    '$num', 
                    '$logistik', 
                    '$jmlmakanan'
                )";

                mysqli_query($conn, $queryLogistik) or die(mysqli_error($conn));
                $num++;
            }
        }

        // Konfigurasi SMTP dan send email
        require_once 'PHPMailer/PHPMailerAutoload.php';
        
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;  
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tahuraradensoerjo@gmail.com';
        $mail->Password = 'feirfifqucxcjspu';
        $mail->SMTPSecure = 'TLS';
        $mail->Port = 587;

        $mail->setFrom('tahurarsoerjo.dishut@jatimprov.go.id', 'UPT Tahura Raden Soerjo');

        // Menambahkan penerima
        $mail->addAddress($_POST['email'], $_POST['namaketua']);

        // Mengatur format email ke HTML
        $mail->isHTML(true);

        // Load file content.php
        ob_start();

        if (isset($_POST['onhot'])) {
            include "emailtagihanonhot.php";
        }
        else{
            include "emailtagihan.php";   
        }
        
        $content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content

        ob_end_clean();   

        // Konten/isi email
        $mail->Subject = 'Booking Online e-Simaksi UPT Tahura Raden Soerjo';
        $mail->Body    = $content;

        $mail->send();

        $jml = mysqli_fetch_array(mysqli_query($conn, "SELECT count(ap_pendakian)+1 as id FROM tb_anggota_pendakian WHERE ap_pendakian = (SELECT pd_id FROM tb_pendakian ORDER BY pd_id DESC LIMIT 1)"));
        $startTime = date("Y-m-d H:i:s");
        $exp  = date('Y-m-d H:i:s', strtotime('+6 hour',strtotime($startTime)));

        $token    = "W2mfmQtXghGtURt@b0##";
        $target   = $_POST['hpketua'];
        $message  = 
        '
*INVOICE!*

Kode booking : '.$pd_nomor.'
Nama ketua : '.$_POST['namaketua'].'
Tujuan : '.$_POST['tjn'].'
Tanggal naik : '.date('d-m-Y', strtotime($_POST['tglnaik'])).'
Tanggal turun : '.date('d-m-Y', strtotime($_POST['tglturun'])).'
Jumlah anggota  : '.$jml['id'].' orang

*Pembayaran :*

Bank Tujuan : BPD Jatim / Bank Jatim
No. Rekening VA : '.$dataVa['VirtualAccount'].'
Tagihan : Rp. '.number_format($_POST['bayar']+$_POST['bayarcam'],0,",",".").'

Bayar dan klik tombol SUDAH BAYAR sebelum *'.$exp.'*

*Note :*
- Pembayaran menggunakan selain Bank Jatim pilih menu transfer antar bank
- Jika rekening tujuan salah atau tidak terdaftar, ubah metode transfer BI-FAST ke Realtime Online
- Tidak dapat melakukan pembayaran menggunakan aplikasi Flip
- Waktu verifikasi 1x24 jam sesuai jam pelayanan

UPT Tahura Raden Soerjo
Dinas Kehutanan Provinsi Jawa Timur
Jam pelayanan Senin-Jumat pukul 08.00-16.00

_pesan dikirim otomatis oleh sistem_
    ';

// $curl = curl_init();
// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://api.fonnte.com/send',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => array(
//     'target' => $target,
//     'message' => $message,
//   ),
//   CURLOPT_HTTPHEADER => array(
//     "Authorization: $token"
//   ),
// ));

// $response = curl_exec($curl);
// curl_close($curl);
    
}catch(Exception $e){
    echo $e;
    return $e;
}
        
?>