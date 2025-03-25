<?php
include 'env_connection.php';
$conn = mysqli_connect(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'),getenv('DB_DATABASE'));

if (mysqli_connect_errno()){
    die("Koneksi gagal: " . mysqli_connect_error());
}