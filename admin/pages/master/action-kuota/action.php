<?php

require '../../../../vendor/autoload.php';
require_once('../../../../config/connection.php');
require_once('../../../../config/ektensi.php');
require_once('../../../../config/env.php');

use Carbon\Carbon;

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

if($_GET['action'] == "detail"){
    try {
        $code_id = $_POST['code_id'];
        $sql    = mysqli_query($conn, "SELECT * FROM tiket_kuota WHERE id = '$code_id'");
        $row    = mysqli_fetch_array($sql);

        $gunung_id = $row['tb_gunung_id'];
        $gunung    = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM tb_gunung WHERE id='$gunung_id'"));

        $pos_id = $row['tb_pos_pendaki_id'];
        $pos    = mysqli_fetch_array(mysqli_query($conn, "SELECT pp_nama AS nama FROM tb_pos_pendakian WHERE pp_id='$pos_id'"));

        $data = [
            "id"                => $row['id'],
            "date"              => Carbon::parse($row['date'])->format('d-m-Y'),
            "gunung"            => $gunung['nama'],
            "pos"               => $pos['nama'],
            "stock"             => $row['stock'],
            "stock_available"   => $row['stock_available'],
            "price_weekday_wni" => $row['price_weekday_wni'],
            "price_weekday_wna" => $row['price_weekday_wna'],
            "price_weekend_wni" => $row['price_weekend_wni'],
            "price_weekend_wna" => $row['price_weekend_wna'],
            "is_active"         => $row['is_active'],
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
}else if($_GET['action'] == "list") {
    try {

        $gunung_id  = $_POST['gunung_select'];
        $pos_id     = $_POST['pos_select'];
        $tahun      = $_POST['tahun_select'];
        $bulan      = $_POST['bulan_select'];

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " and (date like '%".$searchValue."%' or 
        price_weekday_wni like '%".$searchValue."%' or 
        price_weekday_wna like'%".$searchValue."%'  or 
        stock_available like'%".$searchValue."%' ) ";
        }

## Total number of records without filtering
        $sel = mysqli_query($conn,"select count(*) as allcount from tiket_kuota WHERE YEAR(date)='$tahun' AND MONTH(date)='$bulan' 
                                                    AND tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($conn,"select count(*) as allcount from tiket_kuota WHERE YEAR(date)='$tahun' AND MONTH(date)='$bulan' 
                                                    AND tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from tiket_kuota WHERE YEAR(date)='$tahun' AND MONTH(date)='$bulan' 
                                                    AND tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($conn, $empQuery);
        $data = array();

        while ($row = mysqli_fetch_array($empRecords)) {
            $pos_id = $row['tb_pos_pendaki_id'];
            $id = $row['id'];

            $sqlPos = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$pos_id'");
            $pos    = mysqli_fetch_array($sqlPos);

            $class = 'label-info';
            if($row['is_active'] == 1) {
                $class = 'label-primary';
                $txt_status = 'aktif';
            }else {
                $class = 'label-warning';
                $txt_status = 'tidak aktif';
            }
            $status = '<span class="label '.$class.'" style="text-transform:uppercase">'.$txt_status.'</span>';


            $data[] = array(
                "date"              => Carbon::parse($row['date'])->format('d-m-Y'),
                "pos"               => $pos['pp_nama'],
                "stock"             => $row['stock'],
                "stock_available"   => $row['stock_available'],
                "price_weekday_wni" => $row['price_weekday_wni'],
                "price_weekday_wna" => $row['price_weekday_wna'],
                "price_weekend_wni" => $row['price_weekend_wni'],
                "price_weekend_wna" => $row['price_weekend_wna'],
                "is_active"         => $status,
                "action"            => "<a class='btn btn-info button_menu' id='edit-kelola-kuota' data-id='$id'><i class='fa fa-paste'></i> Ubah</a>",
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
}else if($_GET['action'] == "store") {
    try {
        $gunung_id          = $_POST['gunung'];
        $pos_id             = $_POST['pos'];
        $start_date         = strtotime($_POST['start_date']);
        $end_date           = strtotime($_POST['end_date']);
        $kuota              = $_POST['kuota'];
        $weekday_wni        = $_POST['weekday_wni'];
        $weekday_wna        = $_POST['weekday_wna'];
        $weekend_wni        = $_POST['weekend_wni'];
        $weekend_wna        = $_POST['weekend_wna'];


        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_accest_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_accest_key = $sql_accest_key['value'] != null ? $sql_accest_key['value'] : getenv('ACCESS_KEY');


        $sqlMountain    = mysqli_fetch_array(mysqli_query($conn, "SELECT mountain_id FROM tb_gunung  WHERE id='$gunung_id'"));
        $sqlPos         = mysqli_fetch_array(mysqli_query($conn, "SELECT mountain_gate_id FROM tb_pos_pendakian  WHERE pp_id='$pos_id'"));
        $response = $client->post($env_base_url.'master/tiket-quota', [
                'form_params' => [
                    'mountain_id'           => $sqlMountain['mountain_id'],
                    'mountain_gate_id'      => $sqlPos['mountain_gate_id'],
                    'date_start'            => Carbon::parse($_POST['start_date'])->format('Y-m-d'),
                    'date_end'              => Carbon::parse($_POST['end_date'])->format('Y-m-d'),
                    'stock'                 => $kuota,
                    'price_weekday_wni'     => $weekday_wni,
                    'price_weekday_wna'     => $weekday_wna,
                    'price_weekend_wni'     => $weekend_wni,
                    'price_weekend_wna'     => $weekend_wna,
                    'is_sharing'            => true
                ],
                'headers' => [
                    'Access-Key' => $env_accest_key
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

        for ($i = $start_date; $i<=$end_date; $i=$i+86400){
            $thisDate = date( 'Y-m-d', $i);

            $cekAvailable    = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM tiket_kuota 
                                WHERE tb_gunung_id='$gunung_id' AND tb_pos_pendaki_id='$pos_id' AND date='$thisDate'"));
            if(!isset($cekAvailable)){
                $sql   = "INSERT INTO tiket_kuota (tb_gunung_id, date, stock, stock_available,
                         price_weekday_wni, price_weekday_wna, price_weekend_wni, price_weekend_wna,
                         tb_pos_pendaki_id, is_active) 
                VALUES ('$gunung_id', '$thisDate', '$kuota', '$kuota', '$weekday_wni', 
                '$weekday_wna', '$weekend_wni', '$weekend_wna', '$pos_id', true)";
                mysqli_query($conn, $sql);
            }
        }

        $respon = [
            "error" => false,
            "message" => "Kuota berhasil di buat"
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
        $id                 = $_POST['id'];
        $stock              = $_POST['stock'];
        $stock_available    = $_POST['stock_available'];
        $price_weekday_wni  = $_POST['price_weekday_wni'];
        $price_weekday_wna  = $_POST['price_weekday_wna'];
        $price_weekend_wni  = $_POST['price_weekend_wni'];
        $price_weekend_wna  = $_POST['price_weekend_wna'];

        $sql_base_url = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='BASE_URL'"));
        $env_base_url = $sql_base_url['value'] != null ? $sql_base_url['value'] : getenv('BASE_URL');

        $sql_access_key = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_config WHERE name='ACCESS_KEY'"));
        $env_access_key = $sql_access_key['value'] != null ? $sql_access_key['value'] : getenv('ACCESS_KEY');


        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
            $send_is_active = true;
        }else{
            $is_active = 0;
            $send_is_active = false;
        }

        $sqlTiketKuota  = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tiket_kuota WHERE id='$id'"));
        $gunung_id = $sqlTiketKuota['tb_gunung_id'];
        $pos_id    = $sqlTiketKuota['tb_pos_pendaki_id'];
        $sqlMountain    = mysqli_fetch_array(mysqli_query($conn, "SELECT mountain_id FROM tb_gunung  WHERE id='$gunung_id'"));
        $sqlPos         = mysqli_fetch_array(mysqli_query($conn, "SELECT mountain_gate_id FROM tb_pos_pendakian  WHERE pp_id='$pos_id'"));

        $response = $client->post($env_base_url.'master/tiket-quota/update', [
                'form_params' => [
                    'mountain_id'           => $sqlMountain['mountain_id'],
                    'mountain_gate_id'      => $sqlPos['mountain_gate_id'],
                    'date'                  => $sqlTiketKuota['date'],
                    'stock'                 => $stock,
                    'stock_available'       => $stock_available,
                    'price_weekday_wni'     => $price_weekday_wni,
                    'price_weekday_wna'     => $price_weekday_wna,
                    'price_weekend_wni'     => $price_weekend_wni,
                    'price_weekend_wna'     => $price_weekend_wna,
                    'is_active'             => $send_is_active,
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
                "message" => $res['message']
            ];
            echo json_encode($respon, true);
            exit();
        }

        mysqli_query($conn,"UPDATE tiket_kuota SET stock='$stock', stock_available='$stock_available',
                       price_weekday_wni='$price_weekday_wni', price_weekday_wna='$price_weekday_wna', 
                       price_weekend_wni='$price_weekend_wni', price_weekend_wna='$price_weekend_wna', 
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