<?php
require '../config/connection.php';
require '../config/ektensi.php';

$gunung_id  = $_POST['gunung_id'];
$sql        = mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$gunung_id'");
$gunung     = mysqli_fetch_array($sql);

$respon = [
    "error"   => false,
    "message" => "success",
    "data"    => $gunung['max_date'],
];
echo json_encode($respon);
exit();