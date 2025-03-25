<?php
require '../config/connection.php';
require_once ('../config/ektensi.php');

$gunung_id          = $_POST['gunung'];
$pos_id             = $_POST['pos'];
$kewarganegaraan    = $_POST['kewarganegaraan'];
$start_date         = date('Y-m-d', strtotime($_POST['start_date']));
$end_date           = date('Y-m-d', strtotime($_POST['end_date']));

$camwni     = $_POST['camwni'] ?? 0;
$camwna     = $_POST['camwna'] ?? 0;;

$total_anggota       = $_POST['total_anggota'];
$arr_anggota[] = [
    "email"           => $_POST["email_ketua"],
    "kewarganegaraan" => $kewarganegaraan,
    "umur"            => $_POST["umur_ketua"],
    "is_ketua"        => true,
];

for ($i = 1; $i<=$total_anggota; $i++) {
    if(!empty($_POST["email_anggotake$i"])){
        $arr_anggota[] = [
            "email"           => $_POST["email_anggotake$i"],
            "kewarganegaraan" => $_POST["kw_anggotake$i"],
            "umur"            => $_POST["umur_anggotake$i"],
            "is_ketua"        => false,
        ];
    }
}

$notifikasi = [];
foreach ($arr_anggota as $item) {
    if ((int)$item['umur'] < 17) {
        $notifikasi[] = [
            "name" => "{$item['email']} memiliki umur {$item['umur']} tahun.",
        ];
    }
}

$is_show_umur = false;
foreach ($arr_anggota as $item) {
    if ((int)$item['umur'] < 17) {
        $is_show_umur = true;
        break;
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

$gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$gunung_id'"));
$pos    = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$pos_id'"));
$tiket_kuota = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tiket_kuota 
                WHERE tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id' AND 
                date='$start_date'"));

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
                AND sts_bayar='paid' AND DATE(tgl_naik) = '$start_date'"));

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

        if($count_wni > 0){
            if($is_weekendDay){
                $harga  = $kuotaData['price_weekend_wni'];
            }else{
                $harga  = $kuotaData['price_weekday_wni'];
            }
            $format_harga = rupiah($harga);
            $total = $count_wni*$harga;
            $format_total = rupiah($total);
            $detail_arr[] = [
                "warganegara"   => "WNI",
                "keterangan"    => "($count_wni x $format_harga)",
                "total_value"   => $total,
                "total"         => $format_total
            ];
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
            $format_harga = rupiah($harga);
            $total = $count_wna*$harga;
            $format_total = rupiah($total);
            $detail_arr[] = [
                "warganegara"   => "WNA",
                "keterangan"    => "($count_wna x $format_harga)",
                "total_value"   => $total,
                "total"         => $format_total
            ];
            $set_total_bayar[] = [
                "total"   => $total,
            ];
        }

        $detail[] = [
            "waktu"         => $thisDateFormat,
            "status_hari"   => $status_hari,
            "detail_arr"    => $detail_arr
        ];
        $detail_arr = null;
    }

    $total_bayar = array_sum(array_column($set_total_bayar, 'total'));

    $detail_kamera = null;
    if ($camwni > 0){
        $harga_camera_wni = 150000;
        $format_harga_camera_wna = rupiah($harga_camera_wni);
        $totalcam_wni = $camwni*$harga_camera_wni;
        $detail_kamera[] = [
            "name"   => "WNI",
            "keterangan"    => "($camwni x $format_harga_camera_wna)",
            "total_value"   => $totalcam_wni,
            "total"         => rupiah($totalcam_wni)
        ];
    }
    if ($camwna > 0){
        $harga_camera_wna = 300000;
        $format_harga_camera_wna = rupiah($harga_camera_wna);
        $totalcam_wna = $camwna*$harga_camera_wna;
        $detail_kamera[] = [
            "name"   => "WNA",
            "keterangan"    => "($camwna x $format_harga_camera_wna)",
            "total_value"   => $totalcam_wna,
            "total"         => rupiah($totalcam_wna)
        ];
    }
    $total_bayar_kamera = 0;
    $data_kamera = null;
    if (!empty($detail_kamera)){
        $data_kamera[] = [
            "name"          => "Kamera",
            "detail_arr"    => $detail_kamera
        ];
        $total_bayar_kamera = array_sum(array_column($detail_kamera, 'total_value'));
    }

    $total_bayar_akhir  = $total_bayar+$total_bayar_kamera;

    $respon = [
        "error"   => false,
        "message" => "Kuota $nama_gunung di $nama_pos tersedia",
        "information" => [
            "is_show_umur"  => $is_show_umur,
            "notif_umur"    => $notifikasi,
        ],
        "data"    => [
            "total_bayar" => rupiah($total_bayar_akhir),
            "penyebut"    => penyebut($total_bayar_akhir),
            "detail"      => $detail,
            "kamera"      => $data_kamera
        ],
    ];
    echo json_encode($respon);
    exit();
}