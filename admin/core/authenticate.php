<?php
require '../../vendor/autoload.php';
include '../../config/connection.php';
include '../../config/env.php';
require_once ('../../config/ektensi.php');


$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM user WHERE nip='$username' LIMIT 1";
$result = mysqli_query($conn, $query);
if($result){
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)){
            session_start();
            $_SESSION['uuid_admin']  = $row['user_id'];
            $_SESSION['nama_admin']  = $row['nama'];
            $respon = [
                "error"     => false,
                "message"   => 'Logged In Successfully',
            ];
            echo json_encode($respon, true);
            exit();
        }else{
            $respon = [
                "error"     => true,
                "message"   => 'Invalid Password',
            ];
            echo json_encode($respon, true);
            exit();
        }
    }else{
        $respon = [
            "error"     => true,
            "message"   => 'Invalid Email Address',
        ];
        echo json_encode($respon, true);
        exit();
    }
}else{
    $respon = [
        "error"     => true,
        "message"   => 'Something Went Wrong!',
    ];
    echo json_encode($respon, true);
    exit();
}