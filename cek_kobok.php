<?php
require 'vendor/autoload.php';
require 'config/connection.php';
require_once ('config/ektensi.php');
include 'config.php';
 
$kode = mysqli_real_escape_string($conn, $_POST['kode']);
$status_login = mysqli_real_escape_string($conn, $_POST['status_login']);

 
$data 	= mysqli_query($conn,"SELECT * FROM tb_pendakian where pd_nomor='$kode'");
$row 	= mysqli_fetch_array($data);
 
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    if ($status_login){
        header("location:status-trx.php?inv=$kode");
    }else{
        header("location:statusbooking.php?inv=$kode");
    }
}else{
	header("location:index.php?pesan=gagal");
}
?>