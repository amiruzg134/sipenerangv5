<?php 
 
include 'config.php';
 
$kode = mysqli_real_escape_string($conn, $_POST['namaketua']);
 
$data 	= mysqli_query($conn,"SELECT * FROM tb_pendakian where pd_nama_ketua='$kode'");
$row 	= mysqli_fetch_array($data);
 
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
	header("location:statusbooking.php?id=$kode");
}else{
	header("location:index.php?pesan=gagal");
}
?>