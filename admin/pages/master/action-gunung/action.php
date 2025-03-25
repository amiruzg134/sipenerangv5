<?php
require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id = '$code_id'");
        $rows    = mysqli_fetch_array($sql);
        if($rows['is_active'] == 1){
            $valuechecked = "checked";
        }else{
            $valuechecked = "non_checked";
        }

        $data = [
            "id"            => $rows['id'],
            "is_active"     => $rows['is_active'],
            "valuechecked"  => $valuechecked,
            "max_date"      => $rows['max_date'],
            "nama"          => $rows['nama'],
            "mountain_id"   => $rows['mountain_id'],
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
}else if($_GET['action'] == "sync") {
    try {

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $response = $client->get($env_base_url.'sync/master/mountain', [
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
            $mountain_id    = $item['id'];
            $name           = $item['name'];
            $is_active      = $item['is_active'] ? 1 : 0;
            $is_verified_user   = $item['is_verified_user'] ? 1 : 0;

            $result = mysqli_query($conn, "SELECT id FROM tb_gunung WHERE mountain_id='$mountain_id'");
            if (mysqli_num_rows($result) > 0) {
                $queryUpdate = "UPDATE tb_gunung SET nama = '$name', is_active = '$is_active', is_verified_user='$is_verified_user' WHERE mountain_id = '$mountain_id'";
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
                $queryInsert = "INSERT INTO tb_gunung (nama, mountain_id, max_date, is_active, is_verified_user) VALUES ('$name', '$mountain_id', 5, '$is_active', '$is_verified_user')";
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

}else if($_GET['action'] == "store") {
    try {
        $gunung         = $_POST['nama_gunung'];
        $max_date       = $_POST['max_date'];
        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }
        $mountain_id    = $_POST['mountain_id'];

        $sql   = "INSERT INTO tb_gunung (nama, max_date, is_active, mountain_id) 
        VALUES ('$gunung', '$max_date', '$is_active', '$mountain_id')";
        $exec  = mysqli_query($conn, $sql);

        $respon = [
            "error" => false,
            "message" => "Berhasil Menambah Gunung"
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
        $gunung         = $_POST['nama_gunung'];
        $max_date       = $_POST['max_date'];
        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }
        $mountain_id    = $_POST['mountain_id'];

        mysqli_query($conn, "UPDATE tb_gunung 
                    SET nama = '$gunung', max_date='$max_date', 
                     is_active='$is_active', mountain_id='$mountain_id'
                                WHERE id = '$id'");

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