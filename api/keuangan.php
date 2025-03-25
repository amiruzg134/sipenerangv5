<?php
	include '../config.php';
	$request_method=$_SERVER["REQUEST_METHOD"];

	switch($request_method) {
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"])) {
				$id=intval($_GET["id"]);
				get_employees($id);
			}
			else {
				get_employees();
			}
		break;
		default:
			// Invalid Request Method
		header("HTTP/1.0 405 Method Not Allowed");
		break;
	}

	function get_employees($id=0) {
		global $conn;
		$query 		= "SELECT SUM(biaya) AS total FROM tb_pendakian WHERE jalur = ".$id." AND date(tgl_bayar) BETWEEN '2023-12-29' AND '2024-12-28' AND sts_bayar = 'paid' ";
		$response 	= array();
		$result 	= mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		header('Content-Type: application/json');
		echo $row['total'];
	}

?>	