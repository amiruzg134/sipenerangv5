<?php
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');


if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM jabatan WHERE id_jabatan = '$code_id'");
        $rows   = mysqli_fetch_array($sql);

        $data = [
            "id"            => $rows['id_jabatan'],
            "nomor_jabatan" => $rows['nomor_jabatan'],
            "nama_jabatan"  => $rows['nama_jabatan'],
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
}else if($_GET['action'] == "store") {
    try {
        $nama_jabatan = $_POST['nama_jabatan'];
        $data_id = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id_jabatan) AS id FROM jabatan"));
        $id = $data_id['id']+1;
        $nomor = 'JB-'.str_pad($id, 4, "0", STR_PAD_LEFT);

        $sql   = "INSERT INTO jabatan VALUES ($id, '$nomor', '$nama_jabatan')";
        $exec  = mysqli_query($conn, $sql);

        $respon = [
            "error" => false,
            "message" => "Berhasil Menambah Jabatan"
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
        $id             = $_POST['id'];
        $nama_jabatan   = $_POST['nama_jabatan'];
        mysqli_query($conn,"UPDATE jabatan SET nama_jabatan='$nama_jabatan' WHERE id_jabatan='$id'");
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
}else if($_GET['action'] == "delete") {
    try {
        $id             = $_POST['id'];
        mysqli_query($conn,"DELETE FROM jabatan WHERE id_jabatan='$id'");
        $respon = [
            "error" => false,
            "message" => "Delete Berhasil"
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