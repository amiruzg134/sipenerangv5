<?php
require '../config/connection.php';

echo "<option value=''>- Pilih Gunung -</option>";

$query   = "SELECT * FROM tb_gunung WHERE is_active=1";
$prepare = $conn->prepare($query);
$prepare->execute();
$res     = $prepare->get_result();
while ($row = $res->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
}