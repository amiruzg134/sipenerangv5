<?php
require '../config/connection.php';
require_once ('../config/ektensi.php');

$gunung_id  = $_POST['gunung_id'];
$gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$gunung_id'"));
$respon = [
    "error"   => false,
    "message" => "Verified User",
    "data"    => [
        "is_verified_user" => $gunung['is_verified_user']
    ],
];
echo json_encode($respon);
exit();