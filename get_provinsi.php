<?php
	include 'config.php';
 
	echo "<option value=''>- Pilih Provinsi -</option>";
 
	$query = "SELECT * FROM provinces ORDER BY name ASC";
	$dewan1 = $conn->prepare($query);
	$dewan1->execute();
	$res1 = $dewan1->get_result();
	while ($row = $res1->fetch_assoc()) {
		echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
	}
?>