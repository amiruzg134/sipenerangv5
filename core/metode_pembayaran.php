<?php
require '../config/connection.php';
$gunung_id  = $_POST['gunung_id'];
$pos_id     = $_POST['pos_id'];

echo "<option value=''>- Pilih Pembayaran -</option>";

$query   = "SELECT * FROM metode_pembayaran WHERE tb_gunung_id='$gunung_id' AND tb_pos_pendakian_id='$pos_id'";
$prepare = $conn->prepare($query);
$prepare->execute();
$res     = $prepare->get_result();
while ($row = $res->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
}