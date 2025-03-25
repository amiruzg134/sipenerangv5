<?php
require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id = '$code_id'");
        $row    = mysqli_fetch_array($sql);

        $arr_gunung = [];
        $sql_gunung = mysqli_query($conn, "SELECT * FROM tb_gunung");
        while ($rowgunung=mysqli_fetch_array($sql_gunung)) {
            $arr_gunung[] = [
                "id"    => $rowgunung['id'],
                "nama"  => $rowgunung['nama'],
            ];
        }
        
        if($row['is_active'] == 1){
            $valuechecked = "checked";
        }else{
            $valuechecked = "non_checked";
        }

        $data = [
            "gunung" => $arr_gunung,
            "detail" => [
                "id"            => $row['pp_id'],
                "pp_nama"       => $row['pp_nama'],
                "tb_gunung_id"  => $row['tb_gunung_id'],
                "min_pesan"     => $row['min_pesan'],
                "max_pesan"     => $row['max_pesan'],
                "can_booking_before_day" => $row['can_booking_before_day'],
                "is_active"     => intval($row['is_active']),
                "valuechecked"  => $valuechecked,
                "mountain_gate_id"  => $row['mountain_gate_id'],
            ]
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
        $gunung_id      = $_POST['gunung_id'];
        $pp_nama        = $_POST['pp_nama'];
        $min_pesan      = $_POST['min_pesan'];
        $max_pesan      = $_POST['max_pesan'];
        $can_booking_before_day = $_POST['can_booking_before_day'];
        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }
        $mountain_gate_id = $_POST['mountain_gate_id'];

        $sql   = "INSERT INTO tb_pos_pendakian (pp_nama, tb_gunung_id, is_active, mountain_gate_id, min_pesan, max_pesan, can_booking_before_day) 
                        VALUES ('$pp_nama', '$gunung_id', '$is_active', '$mountain_gate_id', '$min_pesan', '$max_pesan', '$can_booking_before_day')";
        $exec  = mysqli_query($conn, $sql);

        $respon = [
            "error" => false,
            "message" => "Berhasil Menambah Pos Perizinan"
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

        $response = $client->get($env_base_url.'sync/master/gate', [
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
            $mountain_gate_id   = $item['id'];
            $mountain_id        = $item['mountain_id'];
            $name               = $item['name'];
            $is_active          = $item['is_active'] ? 1 : 0;

            $result = mysqli_query($conn, "SELECT tb_gunung_id FROM tb_pos_pendakian WHERE mountain_gate_id='$mountain_gate_id'");
            if (mysqli_num_rows($result) > 0) {
                $data_gunung =  mysqli_fetch_array($result);
                $id_gunung   = $data_gunung['tb_gunung_id'];
                $queryUpdate = "UPDATE tb_pos_pendakian SET pp_nama='$name', tb_gunung_id='$id_gunung', is_active =$is_active WHERE mountain_gate_id='$mountain_gate_id'";
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
                $mountain = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM tb_gunung WHERE mountain_id='$mountain_id'"));
                $id_gunung = $mountain['id'];
                $queryInsert = "INSERT INTO tb_pos_pendakian (pp_nama, tb_gunung_id, min_pesan, max_pesan, can_booking_before_day, is_active, mountain_gate_id) 
                            VALUES ('$name', '$id_gunung', 3, 10, 2, $is_active, '$mountain_gate_id')";
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
        $id             = $_POST['id'];
        $gunung_id      = $_POST['gunung_id'];
        $pp_nama        = $_POST['pp_nama'];
        $min_pesan      = $_POST['min_pesan'];
        $max_pesan      = $_POST['max_pesan'];
        $can_booking_before_day = $_POST['can_booking_before_day'];
        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }
        $mountain_gate_id = $_POST['mountain_gate_id'];

        mysqli_query($conn, "UPDATE tb_pos_pendakian SET tb_gunung_id='$gunung_id',
                            pp_nama = '$pp_nama', mountain_gate_id='$mountain_gate_id', min_pesan='$min_pesan',
                            max_pesan='$max_pesan', can_booking_before_day='$can_booking_before_day', is_active='$is_active' WHERE pp_id='$id'");

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