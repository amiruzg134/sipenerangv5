<?php
	include 'config.php';
	$provinsi = $_POST['provinsi'];

	echo "<option value=''>- Pilih Kabupaten -</option>";

	$query = "SELECT * FROM regencies WHERE province_id=? ORDER BY name ASC";
	$dewan1 = $conn->prepare($query);
	$dewan1->bind_param("i", $provinsi);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
		echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	}
?>