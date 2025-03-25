<?php 
	include 'api.php';

	$kode_registrasi    = rand(10,99).date('His');
    $pd_nomor           = 'PD-'.$kode_registrasi;

    $jalur = 5;

    $kode = str_pad($jalur, 2, '0', STR_PAD_LEFT);

    $dataVa =  array(
        "VirtualAccount"        => '15186101'.$kode.$kode_registrasi,
        "Nama"                  => 'Khaerul Anam',
        "TotalTagihan"          => '40000',
        "TanggalExp"            => date('Ymd', strtotime('+1 days')),
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