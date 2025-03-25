<?php
require '../config/connection.php';
require '../config/ektensi.php';

$pos_id     = $_POST['pos_id'];
$sql        = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$pos_id'");
$pos        = mysqli_fetch_array($sql);

$respon = [
    "error"   => false,
    "message" => "success",
    "data"    => [
        "gunung_id" => $pos['tb_gunung_id'],
        "pos_id"    => $pos_id,
        "min_pesan" => $pos['min_pesan'],
        "max_pesan" => $pos['max_pesan'],
        "can_booking_before_day" => $pos['can_booking_before_day'],
    ],
];
echo json_encode($respon);
exit();