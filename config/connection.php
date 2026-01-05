<?php
date_default_timezone_set('Asia/Jakarta');
include 'env_connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'),getenv('DB_DATABASE'));

if (mysqli_connect_errno()){
    die("Koneksi gagal: " . mysqli_connect_error());
}