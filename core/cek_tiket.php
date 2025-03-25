<?php
require '../config/connection.php';
require_once ('../config/ektensi.php');

$gunung_id          = $_POST['gunung'];
$pos_id             = $_POST['pos'];
$kewarganegaraan    = $_POST['kewarganegaraan'];
$start_date         = $_POST['start_date'];
$end_date           = $_POST['end_date'];

$format_start_date  = strtotime($start_date);
$format_end_date    = strtotime($end_date);
$is_ready   = false;
for ($i = $format_start_date; $i<=$format_end_date; $i=$i+86400) {
    $thisDate  = date('Y-m-d', $i);

    $sqlCek     = mysqli_query($conn, "SELECT * FROM tiket_kuota WHERE tb_gunung_id='$gunung_id' 
                  AND tb_pos_pendaki_id='$pos_id' AND date='$thisDate' AND is_active=1");
    $kuotaCek   = mysqli_fetch_array($sqlCek);

    if(!empty($kuotaCek)){
        $is_ready = true;
    }else{
        $is_ready = false;
        break;
    }
}

if (!$is_ready){
    $respon = [
        'error'   => true,
        'message' => "Kuota tiket tidak tersedia",
    ];
    echo json_encode($respon);
    exit();
}

$date = date('Y-m-d', strtotime($start_date));

$gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$gunung_id'"));
$pos    = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$pos_id'"));
$tiket_kuota = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tiket_kuota 
                WHERE tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id' AND 
                date='$date'"));

$nama_gunung = $gunung['nama'];
$nama_pos    = $pos['pp_nama'];
if (empty($tiket_kuota)){
    $respon = [
        "error"   => true,
        "message" => "Kuota $nama_gunung di $nama_pos belum tersedia"
    ];
    echo json_encode($respon);
    exit();
}

$total_trx 	 = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian 
                WHERE is_region_new=1 AND tb_gunung_id='$gunung_id' AND pd_pos_pendakian='$pos_id'
                AND sts_bayar='paid' AND DATE(tgl_naik) = '$date'"));

$total = intval($tiket_kuota['stock_available'])-intval($total_trx);

if(1 > $total){
    $respon = [
        "error"   => true,
        "message" => "Kuota $nama_gunung di $nama_pos sudah penuh silakan pesan di lain tanggal"
    ];
    echo json_encode($respon);
    exit();
}else{
    $detail = [];
    for ($i = $format_start_date; $i<=$format_end_date; $i=$i+86400){
        $thisDateFormat = date( 'Y-m-d', $i);

        $sqlKuota     = mysqli_query($conn, "SELECT * FROM tiket_kuota WHERE tb_gunung_id='$gunung_id' 
                  AND tb_pos_pendaki_id='$pos_id' AND date='$thisDateFormat'");
        $kuotaData   = mysqli_fetch_array($sqlKuota);

        $status_hari   = "Hari Kerja";
        $is_weekendDay = false;
        $day = date("D", strtotime($thisDateFormat));
        if($day == 'Sat' || $day == 'Sun'){
            $is_weekendDay = true;
            $status_hari   = "Hari Libur";
        }

        if($kewarganegaraan == "wni"){
            if($is_weekendDay){
                $harga  = $kuotaData['price_weekend_wni'];
            }else{
                $harga  = $kuotaData['price_weekday_wni'];
            }
        }else{
            if($is_weekendDay){
                $harga  = $kuotaData['price_weekend_wna'];
            }else{
                $harga  = $kuotaData['price_weekday_wna'];
            }
        }
        $format_harga = rupiah($harga);
        $detail[] = [
            "warganegara"   => strtoupper($kewarganegaraan),
            "keterangan"    => "(1 x $format_harga)",
            "waktu"         => $thisDateFormat,
            "status_hari"   => $status_hari,
            "total_value"   => $harga,
            "total"         => $format_harga
        ];
    }


    $total_bayar = array_sum(array_column($detail, 'total_value'));

    $respon = [
        "error"   => false,
        "message" => "Kuota $nama_gunung di $nama_pos tersedia",
        "data"    => [
            "total_bayar" => rupiah($total_bayar),
            "penyebut"    => penyebut($total_bayar),
            "detail"      => $detail
        ],
    ];
    echo json_encode($respon);
    exit();
}