<?php
require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM metode_pembayaran WHERE id = '$code_id'");
        $row    = mysqli_fetch_array($sql);

        $arr_kategori = [
            [
                "id"    => "VA",
                "nama"  => "Virtual Account",
            ],
            [
                "id"    => "QRIS",
                "nama"  => "Qris",
            ],
            [
                "id"    => "TF",
                "nama"  => "Transfer",
            ],
        ];
        
        if($row['is_active'] == 1){
            $valuechecked = "checked";
        }else{
            $valuechecked = "non_checked";
        }

        $sqlgunung  = mysqli_query($conn, "SELECT id, nama FROM tb_gunung");
        $arr_gunung = [];
        while ($rowgunung = mysqli_fetch_assoc($sqlgunung)) {
            $arr_gunung[] = [
                "id"    => $rowgunung['id'],
                "nama"  => $rowgunung['nama'],
            ];
        }

        $gunung_id  = $row['tb_gunung_id'];
        $sqlpos     = mysqli_query($conn, "SELECT pp_id as id, pp_nama as nama FROM tb_pos_pendakian WHERE tb_gunung_id='$gunung_id'");
        $arr_pos = [];
        while ($rowpos = mysqli_fetch_assoc($sqlpos)) {
            $arr_pos[] = [
                "id"    => $rowpos['id'],
                "nama"  => $rowpos['nama'],
            ];
        }

        $data = [
            "list_kategori" => $arr_kategori,
            "list_gunung"   => $arr_gunung,
            "list_pos"      => $arr_pos,
            "detail" => [
                "id"                    => $row['id'],
                "tb_gunung_id"          => $row['tb_gunung_id'],
                "tb_pos_pendakian_id"   => $row['tb_pos_pendakian_id'],
                "name"                  => $row['name'],
                "kategori"              => $row['kategori'],
                "number"                => $row['number'],
                "motode_pembayaran_id"  => $row['metode_pembayaran_tiket_pendakian_id'],
                "is_active"             => intval($row['is_active']),
                "valuechecked"          => $valuechecked,
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
        $gunung_select  = $_POST['gunung_select'];
        $pos_select     = $_POST['pos_select'];
        $nama                   = $_POST['nama'];
        $kategori_pembayaran    = $_POST['kategori_pembayaran'];
        $number                 = $_POST['number'];
        $motode_pembayaran_id   = $_POST['motode_pembayaran_id'];
        $data_active            = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }

        $sql   = "INSERT INTO metode_pembayaran (name, tb_gunung_id, tb_pos_pendakian_id, number, kategori, metode_pembayaran_tiket_pendakian_id, is_active) 
                        VALUES ('$nama', '$gunung_select', '$pos_select', '$number', '$kategori_pembayaran', '$motode_pembayaran_id', '$is_active')";
        $exec  = mysqli_query($conn, $sql);

        $respon = [
            "error" => false,
            "message" => "Berhasil Menambah Metode Pembayaran"
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

        $response = $client->get($env_base_url.'sync/master/payment-method', [
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
            $payment_method_id  = $item['id'];
            $mountain_id        = $item['mountain_id'];
            $mountain_gate_id   = $item['mountain_gate_id'];
            $name               = $item['name'];
            $number             = $item['number'];
            $kategori           = $item['kategori'];
            $is_active          = $item['is_active'] ? 1 : 0;

            $queryGunung = "SELECT id FROM tb_gunung WHERE mountain_id='$mountain_id'";
            $resultGunung = mysqli_query($conn, $queryGunung);
            if (!$resultGunung) {
                die("Error query Gunung: " . mysqli_error($conn));
            }
            $mountain = mysqli_fetch_array($resultGunung);
            $gunung_id = $mountain ? $mountain['id'] : null;

            $queryPos = "SELECT pp_id FROM tb_pos_pendakian WHERE mountain_gate_id='$mountain_gate_id'";
            $resultPos = mysqli_query($conn, $queryPos);
            if (!$resultPos) {
                die("Error query Pos Pendakian: " . mysqli_error($conn));
            }
            $mountain_gate = mysqli_fetch_array($resultPos);
            $pos_id = $mountain_gate ? $mountain_gate['pp_id'] : null;

            if (!empty($gunung_id) && !empty($pos_id)){
                $queryCheck = "SELECT id FROM metode_pembayaran 
                        WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'
                        AND tb_gunung_id='$gunung_id' 
                        AND tb_pos_pendakian_id='$pos_id'";
                $resultCheck = mysqli_query($conn, $queryCheck);
                if (!$resultCheck) {
                    die("Error query Check: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($resultCheck) > 0) {
                    $queryUpdate = "UPDATE metode_pembayaran 
                            SET name='$name', 
                                number='$number',
                                kategori='$kategori', 
                                is_active=$is_active
                            WHERE metode_pembayaran_tiket_pendakian_id='$payment_method_id'
                            AND tb_gunung_id='$gunung_id' 
                            AND tb_pos_pendakian_id='$pos_id'";
                    if (!mysqli_query($conn, $queryUpdate)) {
                        $respon = [
                            "error"   => true,
                            "message" => "Error saat memperbarui data: " . mysqli_error($conn),
                            "data"    => null
                        ];
                        echo json_encode($respon, true);
                        exit();
                    }
                } else {
                    $queryInsert = "INSERT INTO metode_pembayaran (tb_gunung_id, tb_pos_pendakian_id, name, number,
                               kategori, metode_pembayaran_tiket_pendakian_id, is_active)
                            VALUES ('$gunung_id', '$pos_id', '$name', '$number', '$kategori', '$payment_method_id', $is_active)";
                    if (!mysqli_query($conn, $queryInsert)) {
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
        $id                     = $_POST['id'];
        $gunung_select          = $_POST['gunung_select'];
        $pos_select             = $_POST['pos_select'];
        $nama                   = $_POST['nama'];
        $kategori_pembayaran    = $_POST['kategori_pembayaran'];
        $number                 = $_POST['number'];
        $motode_pembayaran_id   = $_POST['motode_pembayaran_id'];
        $data_active            = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
        }

        mysqli_query($conn, "UPDATE metode_pembayaran SET name='$nama',
                            number = '$number', tb_gunung_id='$gunung_select', tb_pos_pendakian_id='$pos_select', kategori='$kategori_pembayaran', 
                            metode_pembayaran_tiket_pendakian_id='$motode_pembayaran_id',
                            is_active='$is_active' WHERE id='$id'");

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