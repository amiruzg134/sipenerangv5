<?php
require '../vendor/autoload.php';
require '../config/env.php';
require '../config/connection.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $base64   = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    $key      = $_POST['key'];

    $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
    $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

    $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
    $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

    $response = $client->post($env_base_url.'proses-verif/'.$key, [
            'form_params' => [
                'riwayat_penyakits' => $_POST["riwayat_penyakits"],
                'image_base64'      => $base64,
                'firstname'         => $_POST["firstname"],
                'lastname'          => $_POST["lastname"],
                'id_card_type'      => $_POST["id_card_type"],
                'id_card_number'    => $_POST["id_card_number"],
                'gender'            => $_POST["gender"],
                'phone_code_id'     => $_POST["phone_code_id"],
                'phone'             => $_POST["phone"],
                'is_wni'            => $_POST["is_wni"],
                'place_birth'       => $_POST["place_birth"],
                'date_birth'        => $_POST["date_birth"],
                'province_code'     => $_POST["province_code"],
                'city_code'         => $_POST["city_code"],
                'district_code'     => $_POST["district_code"],
                'village_code'      => $_POST["village_code"],
                'address'           => $_POST["address"],
                'emergency' => [
                    'emergency_name_one'            => $_POST['emergency_name_one'],
                    'emergency_phone_code_id_one'   => $_POST['emergency_phone_code_id_one'],
                    'emergency_phone_one'           => $_POST['emergency_phone_one'],
                    'emergency_relationship_one'    => $_POST['emergency_relationship_one'],
                ]
            ],
            'headers' => [
                'Access-Key' => $env_access_key
            ],
        ]
    );

    $res = json_decode($response->getBody(), true);
    if($res['error']){
        $respon = [
            "error"   => true,
            'message' => $res['message'],
            "data"    => null,
        ];
        echo json_encode($respon);
        exit();
    }else{
        $email = $_POST["email"];
        mysqli_query($conn, "UPDATE user_verification SET status_code=2 WHERE email='$email'");
        echo json_encode($res);
        exit();
    }
}