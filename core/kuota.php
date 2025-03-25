<?php
require '../config/connection.php';
$action = $_GET['action'];


if($action == "store"){
    $gunung_id          = $_POST['gunung'];
    $pos_id             = $_POST['pos'];
    $start_date         = strtotime($_POST['start_date']);
    $end_date           = strtotime($_POST['end_date']);
    $kuota              = $_POST['kuota'];
    $weekday_wni        = $_POST['weekday_wni'];
    $weekday_wna        = $_POST['weekday_wna'];
    $weekend_wni        = $_POST['weekend_wni'];
    $weekend_wna         = $_POST['weekend_wna'];

    for ($i = $start_date; $i<=$end_date; $i=$i+86400){
        $thisDate = date( 'Y-m-d', $i);

        $sql   = "INSERT INTO tiket_kuota (tb_gunung_id, date, stock, stock_available,
                         price_weekday_wni, price_weekday_wna, price_weekend_wni, price_weekend_wna,
                         tb_pos_pendaki_id, is_active) 
        VALUES ('$gunung_id', '$thisDate', '$kuota', '$kuota', '$weekday_wni', 
                '$weekday_wna', '$weekend_wni', '$weekend_wna', '$pos_id', true)";
        $exec  = mysqli_query($conn, $sql);
    }
    $respon = [
        "error"   => false,
        "message" => "Kuota berhasil di buat"
    ];
    echo json_encode($respon);
    exit();
}else{
    $id                 = $_POST['id_tiket_kuota'];
    $kuota              = $_POST['kuota'];
    $kuota_tersedia     = $_POST['stock_available'];
    $weekday_wni        = $_POST['weekday_wni'];
    $weekday_wna        = $_POST['weekday_wna'];
    $weekend_wni        = $_POST['weekend_wni'];
    $weekend_wna        = $_POST['weekend_wna'];
    $data_active        = $_POST['data_checked'];
    if($data_active == 'checked'){
        $is_active = 1;
    }else{
        $is_active = 0;
    }

    mysqli_query($conn, "UPDATE tiket_kuota 
                    SET stock = '$kuota', stock_available='$kuota_tersedia',
                    price_weekday_wni='$weekday_wni', price_weekday_wna='$weekday_wna', 
                    price_weekend_wni ='$weekend_wni', price_weekend_wna='$weekend_wna',
                    is_active='$is_active' WHERE id='$id'");

    $respon = [
        "error"   => false,
        "message" => "Kuota berhasil di update",
        "data"    => $kuota,
    ];
    echo json_encode($respon);
    exit();
}