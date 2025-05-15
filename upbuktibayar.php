<?php
require 'vendor/autoload.php';
require 'config/connection.php';
require_once ('config/ektensi.php');
include 'config.php';

if (isset($_POST['nomor'])) {
		$date = date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE tb_pendakian SET pd_status = 'menunggu verifikasi', tgl_bayar = '$date' WHERE pd_id = '".$_POST['nomor']."' ");
		echo 1;
		exit;
	}

	else {
		echo 0;
		exit;
	}

?>