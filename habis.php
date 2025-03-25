<?php
	include 'config.php';
	mysqli_query($conn, "UPDATE tb_pendakian SET pd_status = 'expired' WHERE pd_id = '$_POST[id]'");
	// $sql = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id = '$_POST[id]'");
 //    $row = mysqli_fetch_array($sql);

 //    require 'PHPMailer/PHPMailerAutoload.php';
 //    $mail = new PHPMailer;

 //    // Konfigurasi SMTP
 //    $mail->SMTPDebug = 0;  
 //    $mail->isSMTP();
 //    $mail->Host = 'mail.tahuraradensoerjo.or.id';
 //    $mail->SMTPAuth = true;
 //    $mail->Username = 'admin@tahuraradensoerjo.or.id';
 //    $mail->Password = '3b5vTa1E3_#5';
 //    $mail->SMTPSecure = 'TLS';
 //    $mail->Port = 587;

 //    $mail->setFrom('noreply@tahuraradensoerjo.or.id', 'UPT Tahura Raden Soerjo');

 //    // Menambahkan penerima
 //    $mail->addAddress($row['pd_email'], $row['pd_nama_ketua']);

 //    // Mengatur format email ke HTML
 //    $mail->isHTML(true);

 //    // Load file content.php
 //    ob_start();

 //    include "emailtolak.php";

 //    $content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content

 //    ob_end_clean();   

 //    // Konten/isi email
 //    $mail->Subject = 'Informasi Booking Online Gunung Arjuno Welirang, Pundak, Jengger';
 //    $mail->Body    = $content;

 //    $mail->send();
?>