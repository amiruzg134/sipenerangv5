<?php 
    
    require_once 'PHPMailer/PHPMailerAutoload.php';
        
    $mail = new PHPMailer;
    $mail->SMTPDebug = 4;  
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tahuraradensoerjo@gmail.com';
    $mail->Password = 'feirfifqucxcjspu';
    $mail->SMTPSecure = 'TLS';
    $mail->Port = 587;

    $mail->setFrom('tahurarsoerjo.dishut@jatimprov.go.id', 'UPT Tahura Raden Soerjo');

    // Menambahkan penerima
    $mail->addAddress('amiruzg@gmail.com', 'Amiruzzuhhad Gunes');

    // Mengatur format email ke HTML
    $mail->isHTML(true);

    // Load file content.php
    ob_start();

    if (isset($_POST['onhot'])) {
        include "emailtagihanonhot.php";
    }
    else{
        include "emailtagihan.php";   
    }
    
    $content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content

    ob_end_clean();   

    // Konten/isi email
    $mail->Subject = 'Booking Online e-Simaksi UPT Tahura Raden Soerjo';
    $mail->Body    = $content;

    $mail->send();

?>