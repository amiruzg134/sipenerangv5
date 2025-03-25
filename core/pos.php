<?php
require '../config/connection.php';
$gunung_id = $_POST['gunung_id'];

echo "<option value=''>- Pilih Pintu Masuk -</option>";

$query   = "SELECT * FROM tb_pos_pendakian WHERE tb_gunung_id='$gunung_id' AND is_active=1";
$prepare = $conn->prepare($query);
$prepare->execute();
$res     = $prepare->get_result();
while ($row = $res->fetch_assoc()) {
    echo "<option value='" . $row['pp_id'] . "'>" . $row['pp_nama'] . "</option>";
}