<?php
	session_start();
    unset($_SESSION['uuid_admin']);
    unset($_SESSION['token_admin']);
    unset($_SESSION['nama_admin']);

	header("location:../login.php");
?>