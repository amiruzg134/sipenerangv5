<?php
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');


if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tb_config WHERE id= '$code_id'");
        $rows   = mysqli_fetch_array($sql);

        $data = [
            "id"                => $rows['id'],
            "name_konfigurasi"  => $rows['name'],
            "value_konfigurasi" => $rows['value'],
        ];

        $respon = [
            "error"   => false,
            "message" => "Detail",
            "data"    => $data
        ];
        echo json_encode($respon, true);
        exit();
    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "update") {
    try {
        $id                = $_POST['id'];
        $value_konfigurasi = $_POST['value_konfigurasi'];
        mysqli_query($conn,"UPDATE tb_config SET value='$value_konfigurasi' WHERE id='$id'");
        $respon = [
            "error" => false,
            "message" => "Update Berhasil"
        ];
        echo json_encode($respon, true);
        exit();
    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}