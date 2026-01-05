<?php

require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');
require '../../../../config/env.php';

use Carbon\Carbon;
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $user_id = $_POST['code_id'];
        $response = $client->post($env_base_url.'profile/detail', [
                'form_params' => [
                    'user_id' => $user_id,
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key
                ],
            ]
        );

        $res = json_decode($response->getBody(), true);
        echo json_encode($res, true);
        exit();
    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "list") {
    try {
        $status_filter = $_POST['status_verifikai_akun'] ?? null;
        if(empty($status_filter)){
            $status_verifikasi_akun = null;
        }else{
            $status_verifikasi_akun   = $_POST['status_verifikai_akun'] == "all" ? null : $_POST['status_verifikai_akun'];
        }

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " and (email like '%".$searchValue."%') ";
        }

## Total number of records without filtering
        if($status_verifikasi_akun == null){
            $sqlWhere0[] = "";
            $sqlWhere[] = " WHERE status_code IN(2,3,4) AND ";
        }else{
            $sqlWhere0[] = "";
            $sqlWhere[] = " WHERE status_code=$status_verifikasi_akun AND ";
        }

        $sel = mysqli_query($conn,"select count(*) as allcount from user_verification  ".$sqlWhere0[0].";");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($conn,"select count(*) as allcount from user_verification  ".$sqlWhere[0]." 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

//        echo json_encode("select * from user_verification  ".$sqlWhere[0]." 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage, true);
//        exit();
## Fetch records
        $empQuery = "select * from user_verification  ".$sqlWhere[0]." 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($conn, $empQuery);
        $data = array();
        while ($row = mysqli_fetch_array($empRecords)) {
            $id    = $row['user_id_tiket_pendakian'];
            $class = 'label-info';
            if($row['status_code'] == 2) {
                $class = 'label-warning';
                $status_name = 'Pengajuan';
            }else if($row['status_code'] == 4) {
                $class = 'label-danger';
                $status_name = 'Ditolak';
            }else if($row['status_code'] == 3) {
                $class = 'label-success';
                $status_name = 'Terverifikasi';
            }
            $status = '<span class="label '.$class.'" style="text-transform:uppercase">'.$status_name.'</span>';


            $data[] = array(
                "email"             => $row['email'],
                "status_code"       => $status,
                "action"            => "<a class='btn btn-info button_menu' id='detail-kelola-verifikasi-akun' data-id='$id'><i class='fa fa-paste'></i> Detail</a>",
            );
        }

## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}else if($_GET['action'] == "verifikasi-akun") {
    try {
        session_start();
        $admin_id  = $_SESSION['uuid_admin'];
        $user_id   = $_POST['user_id'];
        $accept    = $_POST['status'];
        $catatan   = $_POST['catatan'] ?? "-";

        $user_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$admin_id'"));
        if(empty($user_admin['user_id_tiket_pendakian'])){
            $respon = [
                "error"   => true,
                "message" => "id-sync akun ada belum di setting lakukan setting di kelola akun untuk dapat memverifikai akun customer",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');

        $response = $client->post($env_base_url.'confirm-verifikasi-akun', [
                'form_params' => [
                    'user_id'       => $user_id,
                    'user_admin_id' => $user_admin['user_id_tiket_pendakian'],
                    'status'        => $accept,
                    'catatan'       => $catatan,
                ],
                'headers' => [
                    'Access-Key'    => $env_access_key,
                ],
            ]
        );

        $res = json_decode($response->getBody(), true);
        if($res['error']){
            $respon = [
                "error"   => true,
                "message" => $res['message'],
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }else{
            $status_code = $accept == "ditolak" ? 4 : 3;
            $sql = mysqli_query($conn, "UPDATE user_verification SET status_code=$status_code WHERE user_id_tiket_pendakian='$user_id'");
            $respon = [
                "error"   => false,
                "message" => "Verifikasi akun berhasil",
                "data"    => null,
            ];
            echo json_encode($respon);
            exit();
        }
    } catch (Exception $e) {
        $respon = [
            "error" => true,
            "message" => $e
        ];
        echo json_encode($respon, true);
        exit();
    }
}