<?php 
	include 'api.php';

    $tambaksari     = 1;
    $sumberbrantas  = 2;
    $lawang         = 3;
    $tretes         = 4;
    $pundak         = 5;
    $lincing        = 8;
    $kamera         = 9;

	$kode_registrasi    = date('His');
    $pd_nomor           = 'PD-'.$kode_registrasi;
    $jalur              = $sumberbrantas;
    $kode               = str_pad($jalur, 2, '0', STR_PAD_LEFT);

    $dataVa =  array(
        "VirtualAccount"        => '15186101'.$kode.$kode_registrasi,
        "Nama"                  => 'UPt Tahura Raden Soerjo',
        "TotalTagihan"          => '360000',
        "TanggalExp"            => date('Ymd', strtotime('+7 days')),
        "Berita1"               => "Retribusi Pendakian ".$pd_nomor,
        "Berita2"               => "UPT Tahura Raden Soerjo",
        "Berita3"               => "",
        "Berita4"               => "",
        "Berita5"               => "",
        "FlagProses"            => "1"
    );

    // daftar VA
    $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/RegPen', json_encode($dataVa));
    $response = json_decode($make_call, true);

    var_dump(json_encode($response));

    // cek pendaftaran (sukses / gagal)
    if($response['Status']['IsError']){
        echo json_encode([
            'status'    => 'gagal',
            'message'   => 'Gagal mendaftarkan nomor VA. Coba lagi nanti',
        ]);

        return;
    }
	
?>