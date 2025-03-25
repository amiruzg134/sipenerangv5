<?php
	include 'config.php';
	$kecamatan = $_POST['kecamatan'];

	echo "<option value=''>- Pilih Kelurahan -</option>";

	$query = "SELECT * FROM villages WHERE district_id=? ORDER BY name ASC";
	$dewan1 = $conn->prepare($query);
	$dewan1->bind_param("i", $kecamatan);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
		echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	}
?>