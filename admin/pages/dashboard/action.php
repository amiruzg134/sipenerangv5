<?php

require '../../../vendor/autoload.php';
require_once('../../../config/connection.php');
require_once('../../../config/ektensi.php');

use Carbon\Carbon;


if($_GET['action'] == "pos_perbulan"){
    try {
        $year = $_POST['tahun_select'] ?? Carbon::now()->format('Y');
        if (isset($_POST['bulan_select'])) {
            $date = $year.'-'.$_POST['bulan_select'].'-01';
            $end = $year.'-'.$_POST['bulan_select'].'-'. date('t', strtotime($date)); //get end date of month
        }
        else{
            $date = $year.'-'.date('m').'-01';
            $end = $year.'-'.date('m').'-' . date('t', strtotime($date)); //get end date of month
        }


//        $respon = [
//            "error"   => false,
//            "message" => "Report",
//            "data"    => [
//                "start" => $date,
//                "end"   => $end,
//                "detail" => $detail
//            ]
//        ];
//        echo json_encode($respon, true);
//        exit();

        $posSql = mysqli_query($conn, "SELECT pp_id, pp_nama, tb_gunung_id FROM tb_pos_pendakian WHERE is_active=1");
        $pos    = null;
        $detail = null;
        while ($po=mysqli_fetch_array($posSql)) {
            $pos_id = $po['pp_id'];
            for ($i = strtotime($date); $i<=strtotime($end); $i=$i+86400){
                $thisDate = date( 'Y-m-d', $i);
                $total = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(det.ap_pendakian) AS jumlah_anggota
                    FROM tb_pendakian trx JOIN tb_anggota_pendakian det ON trx.pd_id=det.ap_pendakian
                    WHERE DATE(trx.tgl_naik)='$thisDate' AND trx.pd_pos_pendakian='$pos_id' AND trx.sts_bayar='paid' AND is_region_new=1"));

                $detail[] = [
                    "date"  => Carbon::parse($thisDate)->format('d F Y'),
                    "total" => $total['jumlah_anggota'] != 0 ? $total['jumlah_anggota']+1 : 0,
                ];
            }
            $pos[] = [
                "pos" => $po['pp_nama'],
                "detail" => $detail
            ];
            $detail = null;
        }
        $respon = [
            "error"   => false,
            "message" => "Report",
            "data"    => $pos
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

        for ($i = $start_date; $i<=$end_date; $i=$i+86400){
            $thisDate = date( 'Y-m-d', $i);

            $sql   = "INSERT INTO tiket_kuota (tb_gunung_id, date, stock, stock_available,
                         price_weekday_wni, price_weekday_wna, price_weekend_wni, price_weekend_wna,
                         tb_pos_pendaki_id, is_active) 
        VALUES ('$gunung_id', '$thisDate', '$kuota', '$kuota', '$weekday_wni', 
                '$weekday_wna', '$weekend_wni', '$weekend_wna', '$pos_id', true)";
            $exec  = mysqli_query($conn, $sql);
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

        $data_active    = $_POST['data_checked'];
        if($data_active == 'checked'){
            $is_active = 1;
        }else{
            $is_active = 0;
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