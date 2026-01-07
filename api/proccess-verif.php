<?php
require '../vendor/autoload.php';
require '../config/env.php';
require '../config/connection.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //resize image
    $max_width = 1000;
    $jpeg_quality = 85;
    $png_compression = 8;

    $tmp_file = $_FILES['image']['tmp_name'];
    $file_type = mime_content_type($tmp_file);

    if (!in_array($file_type, ['image/jpeg', 'image/png'])) {
        die('Hanya format JPG dan PNG yang diperbolehkan');
    }

    list($width, $height, $type) = getimagesize($tmp_file);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($tmp_file);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($tmp_file);
            break;
        default:
            die('Format gambar tidak didukung');
    }

    if ($width > $max_width) {
        $ratio = $max_width / $width;
        $new_width = $max_width;
        $new_height = $height * $ratio;
    } else {
        $new_width = $width;
        $new_height = $height;
    }

    $resized = imagecreatetruecolor($new_width, $new_height);

    if ($type == IMAGETYPE_PNG) {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
    }

    imagecopyresampled($resized, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    ob_start();
    if ($type == IMAGETYPE_JPEG) {
        imagejpeg($resized, null, $jpeg_quality);
    } elseif ($type == IMAGETYPE_PNG) {
        imagepng($resized, null, $png_compression);
    }
    $image_data = ob_get_clean();

    $base64 = base64_encode($image_data);

    imagedestroy($src);
    imagedestroy($resized);
    //end resize image

    $key      = $_POST['key'];

    $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
    $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

    $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
    $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

    $format_data = [
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
    ];
    
    $response = $client->post($env_base_url.'proses-verif/'.$key, [
            'form_params' => $format_data,
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