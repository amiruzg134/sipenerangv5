<?php

	date_default_timezone_set('Asia/Jakarta');

	function tgl_indo($tanggal = null){
		$bulan = array (
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

	function bulan($bln) {
		switch ($bln) {
	        case 1 : {
	                $bln = 'Januari';
	            }break;
	        case 2 : {
	                $bln = 'Februari';
	            }break;
	        case 3 : {
	                $bln = 'Maret';
	            }break;
	        case 4 : {
	                $bln = 'April';
	            }break;
	        case 5 : {
	                $bln = 'Mei';
	            }break;
	        case 6 : {
	                $bln = "Juni";
	            }break;
	        case 7 : {
	                $bln = 'Juli';
	            }break;
	        case 8 : {
	                $bln = 'Agustus';
	            }break;
	        case 9 : {
	                $bln = 'September';
	            }break;
	        case 10 : {
	                $bln = 'Oktober';
	            }break;
	        case 11 : {
	                $bln = 'November';
	            }break;
	        case 12 : {
	                $bln = 'Desember';
	            }break;
	        default: {
	                $bln = date("m");
	            }break;
	    }
    	return $bln;
	}

	$bulan = array(
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER',
    );

    function format_hari_tanggal($waktu)
	{
	    $hari_array = array(
	        'Minggu',
	        'Senin',
	        'Selasa',
	        'Rabu',
	        'Kamis',
	        'Jumat',
	        'Sabtu'
	    );
	    $hr = date('w', strtotime($waktu));
	    $hari = $hari_array[$hr];
	    $tanggal = date('j', strtotime($waktu));
	    $bulan_array = array(
	        1 => 'Januari',
	        2 => 'Februari',
	        3 => 'Maret',
	        4 => 'April',
	        5 => 'Mei',
	        6 => 'Juni',
	        7 => 'Juli',
	        8 => 'Agustus',
	        9 => 'September',
	        10 => 'Oktober',
	        11 => 'November',
	        12 => 'Desember',
	    );
	    $bl = date('n', strtotime($waktu));
	    $bulan = $bulan_array[$bl];
	    $tahun = date('Y', strtotime($waktu));
	    $jam = date( 'H:i:s', strtotime($waktu));

	    return "$hari, $tanggal $bulan $tahun";
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}


	// $conn = mysqli_connect("tahuraradensoerjo.or.id","tahurara_tahura","amiruzg627408","tahurara_sipenerang");
	// $conn = mysqli_connect("localhost","tahurars_tahurarsoerjo","Xtahura456","tahurars_sipenerang");

//    $conn = mysqli_connect(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'),getenv('DB_DATABASE'));
//
//	// Check connection
//	if (mysqli_connect_errno()){
//		echo "Koneksi database gagal : " . mysqli_connect_error();
//	}

?>