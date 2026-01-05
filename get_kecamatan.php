<?php
	include 'config.php';
	$kabupaten = $_POST['kabupaten'];

	echo "<option value=''>- Pilih Kecamatan -</option>";

	$query = "SELECT * FROM districts WHERE regency_id=? ORDER BY name ASC";
	$dewan1 = $conn->prepare($query);
	$dewan1->bind_param("i", $kabupaten);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
		echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	}
?>