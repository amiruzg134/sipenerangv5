<?php
	include 'config.php';
    $sql = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id = '$_POST[id]'");
    $row = mysqli_fetch_array($sql);

    if ($row['pd_status'] == 'menunggu pembayaran') {
        echo 1;
        exit;
    }
    else{
        echo 0;
        exit;
    }
    
?>