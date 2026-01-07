<?php
require '../config/connection.php';
require '../config/ektensi.php';

$gunung_id  = $_POST['gunung_id'];
$pos_id     = $_POST['pos_id'];
$sql        = mysqli_query($conn, "SELECT date, stock_available AS kuota FROM tiket_kuota 
                WHERE tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id'
                AND (
          DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
          OR DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%Y-%m')
      ) ORDER BY date ASC");
$data = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $data[] = [
        'date' => date('d-m-Y', strtotime($row['date'])),
        'kuota' => (int)$row['kuota']
    ];
}

$respon = [
    "error"   => false,
    "message" => "success",
    "data"    => $data,
];
echo json_encode($respon);
exit();