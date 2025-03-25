<?php
require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$code_id'");
        $rows   = mysqli_fetch_array($sql);

        $arr_jabatan = [];
        $sql_jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
        while ($rowgunung=mysqli_fetch_array($sql_jabatan)) {
            $arr_jabatan[] = [
                "id"    => $rowgunung['id_jabatan'],
                "nama"  => $rowgunung['nama_jabatan'],
            ];
        }

        $user_id = $rows['user_id'];
        $rowrole = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_role_menu WHERE rm_user_id='$user_id'"));
        $arr_role = [
            "rm_jabatan"    => $rowrole != null ? $rowrole['rm_jabatan'] : false,
            "rm_gunung"     => $rowrole != null ? $rowrole['rm_gunung'] : false,
            "rm_pos"        => $rowrole != null ? $rowrole['rm_pos'] : false,
            "rm_pengguna"   => $rowrole != null ? $rowrole['rm_pengguna'] : false,
            "rm_pendaki"    => $rowrole != null ? $rowrole['rm_pendaki'] : false,
            "rm_laporan"    => $rowrole != null ? $rowrole['rm_laporan'] : false,
            "rm_acc"        => $rowrole != null ? $rowrole['rm_acc'] : false,
            "rm_broad"      => $rowrole != null ? $rowrole['rm_broad'] : false,
            "rm_kuota"      => $rowrole != null ? $rowrole['rm_kuota'] : false,
            "rm_verification_account"  => $rowrole != null ? $rowrole['rm_verification_account'] : false,
            "rm_konfigurasi"  => $rowrole != null ? $rowrole['rm_konfigurasi'] : false,
            "edit"          => $rowrole != null ? $rowrole['edit'] : false,
        ];

        $data = [
            "id"                        => $user_id,
            "id_jabatan"                => $rows['id_jabatan'],
            "nip"                       => $rows['nip'],
            "nama"                      => $rows['nama'],
            "user_id_tiket_pendakian"   => $rows['user_id_tiket_pendakian'],
            "jabatan"                   => $arr_jabatan,
            "role"                      => $arr_role
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
}else if($_GET['action'] == "jabatan"){
    try {
        $arr_jabatan = [];
        $sql_jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
        while ($rowgunung=mysqli_fetch_array($sql_jabatan)) {
            $arr_jabatan[] = [
                "id"    => $rowgunung['id_jabatan'],
                "nama"  => $rowgunung['nama_jabatan'],
            ];
        }

        $respon = [
            "error"   => false,
            "message" => "Jabatan",
            "data"    => $arr_jabatan
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
        $nama       = $_POST['nama'];
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $jabatan_id = $_POST['jabatan_id'];
        $user_id_tiket_pendakian    = $_POST['user_id_tiket_pendakian'];

        $rm_jabatan     = $_POST['data_checked_jabatan'];
        $rm_gunung      = $_POST['data_checked_gunung'];
        $rm_pos         = $_POST['data_checked_pos'];
        $rm_pengguna    = $_POST['data_checked_pengguna'];
        $rm_kuota       = $_POST['data_checked_kuota'];
        $rm_pendaki     = $_POST['data_checked_pendaki'];
        $rm_laporan     = $_POST['data_checked_laporan'];
        $rm_verifikator = $_POST['data_checked_verifikator'];
        $rm_broadcast   = $_POST['data_checked_broadcast'];
        $rm_verification_account = $_POST['data_checked_verifikasi_akun'];
        $rm_konfigurasi = $_POST['data_checked_konfigurasi'];

        $validateexist  = mysqli_query($conn,"select count(*) as allcount from user 
        where user_id_tiket_pendakian='$user_id_tiket_pendakian'");
        $rowexist       = mysqli_fetch_assoc($validateexist);
        if($rowexist > 0){
            $respon = [
                "error" => true,
                "message" => "Kode sync sudah terdaftar di akun lain"
            ];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $sqlinsert = mysqli_query($conn, "INSERT INTO user(id_jabatan, nip, password, nama, user_id_tiket_pendakian) VALUES(
                                                '$jabatan_id', '$username', '$hashedPassword', '$nama',
                                         '$user_id_tiket_pendakian')");
        $last_id = mysqli_insert_id($conn);

        mysqli_query($conn, "INSERT INTO tb_role_menu(rm_user_id, rm_jabatan, rm_gunung, rm_pos, rm_pengguna,
                         rm_pendaki, rm_laporan, rm_acc, rm_broad, rm_kuota, rm_verification_account, rm_konfigurasi) VALUES(
                                '$last_id', '$rm_jabatan', '$rm_gunung', '$rm_pos', '$rm_pengguna', '$rm_pendaki',
                                '$rm_laporan', '$rm_verifikator', '$rm_broadcast', '$rm_kuota', '$rm_verification_account', '$rm_konfigurasi')");

        $respon = [
            "error" => false,
            "message" => "Berhasil Menambah Akun Pengguna"
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
}else if($_GET['action'] == "sync") {
    try {
        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $response = $client->get($env_base_url.'sync/master/user', [
                'headers' => [
                    'Access-Key' => $env_access_key
                ],
            ]
        );
        $res = json_decode($response->getBody(), true);

        if($res['error']){
            $respon = [
                "error"   => true,
                "message" => $res['message']
            ];
            echo json_encode($respon, true);
            exit();
        }

        foreach ($res['data'] as $item) {
            $user_id        = $item['id'];
            $username       = $item['username'];
            $name           = $item['name'];
            $hashedPassword = password_hash("admin123", PASSWORD_BCRYPT, ['cost' => 10]);
            $is_active      = $item['is_active'] ? 1 : 0;

            $result = mysqli_query($conn, "SELECT user_id_tiket_pendakian FROM user WHERE user_id_tiket_pendakian='$user_id'");
            if (mysqli_num_rows($result) > 0) {
                $queryUpdate = "UPDATE user SET nip='$username', nama='$name', is_active =$is_active WHERE user_id_tiket_pendakian='$user_id'";
                if (mysqli_query($conn, $queryUpdate)) {
                } else {
                    $respon = [
                        "error"   => true,
                        "message" => "Error saat memperbarui data: " . mysqli_error($conn),
                        "data"    => null
                    ];
                    echo json_encode($respon, true);
                    exit();
                }
            } else {
                $queryInsert = "INSERT INTO user (nip, password, nama, is_active, user_id_tiket_pendakian) 
                            VALUES ('$username', '$hashedPassword', '$name', $is_active, '$user_id')";
                if (mysqli_query($conn, $queryInsert)) {
                } else {
                    $respon = [
                        "error"   => true,
                        "message" => "Error saat menambahkan data: " . mysqli_error($conn),
                        "data"    => null
                    ];
                    echo json_encode($respon, true);
                    exit();
                }
            }
        }

        $respon = [
            "error"   => false,
            "message" => "Success",
            "data"    => null
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
        $id         = $_POST['id'];
        $nama       = $_POST['nama'];
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $jabatan_id = $_POST['jabatan_id'];
        $user_id_tiket_pendakian    = $_POST['user_id_tiket_pendakian'];

        $rm_jabatan     = $_POST['data_checked_jabatan'];
        $rm_gunung      = $_POST['data_checked_gunung'];
        $rm_pos         = $_POST['data_checked_pos'];
        $rm_pengguna    = $_POST['data_checked_pengguna'];
        $rm_kuota       = $_POST['data_checked_kuota'];
        $rm_pendaki     = $_POST['data_checked_pendaki'];
        $rm_laporan     = $_POST['data_checked_laporan'];
        $rm_verifikator = $_POST['data_checked_verifikator'];
        $rm_broadcast   = $_POST['data_checked_broadcast'];
        $rm_verification_account = $_POST['data_checked_verifikasi_akun'];
        $rm_konfigurasi = $_POST['data_checked_konfigurasi'];

        $validateexist  = mysqli_query($conn,"select count(*) as allcount from user 
        where user_id NOT IN('$id') AND user_id_tiket_pendakian='$user_id_tiket_pendakian'");
        $rowexist       = mysqli_fetch_assoc($validateexist);
        if($rowexist > 0){
            $respon = [
                "error" => true,
                "message" => "Kode sync sudah terdaftar di akun lain"
            ];
        }

        if(!empty($password)){
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
            $sqlinsert = mysqli_query($conn, "UPDATE user SET 
                                        id_jabatan  = '$jabatan_id',
                                        nip         = '$username',
                                        password    = '$hashedPassword',
                                        nama        = '$nama',
                                        user_id_tiket_pendakian = '$user_id_tiket_pendakian'
                                WHERE user_id       = '$id'");
        }else{
            $sqlinsert = mysqli_query($conn, "UPDATE user SET 
                                        id_jabatan  = '$jabatan_id',
                                        nip         = '$username',
                                        nama        = '$nama',
                                        user_id_tiket_pendakian = '$user_id_tiket_pendakian'
                                WHERE user_id       = '$id'");
        }

        mysqli_query($conn, "UPDATE tb_role_menu SET 
                                        rm_jabatan  = '$rm_jabatan',
                                        rm_gunung   = '$rm_gunung',
                                        rm_pos      = '$rm_pos',
                                        rm_pengguna = '$rm_pengguna',
                                        rm_pendaki  = '$rm_pendaki',
                                        rm_laporan  = '$rm_laporan',
                                        rm_acc      = '$rm_verifikator',
                                        rm_broad    = '$rm_broadcast',
                                        rm_kuota    = '$rm_kuota',
                                        rm_verification_account = '$rm_verification_account',
                                        rm_konfigurasi = '$rm_konfigurasi'
                                WHERE rm_user_id    = '$id'");

        $respon = [
            "error" => false,
            "message" => "Berhasil Update Akun"
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