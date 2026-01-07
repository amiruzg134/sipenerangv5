<?php
require '../../../../vendor/autoload.php';
include '../../../../config.php';
include '../../../../config/connection.php';
use Carbon\Carbon;
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/../../../../temp-mpdf']);
ob_start();
?>

    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset='utf-8'>
        <title>Laporan Asuransi</title>
        <link href="style.css" media="all" rel="stylesheet" type="text/css" />
        <style>
            body {
                font-family: Arial, sans-serif;
                background: white;
                color: #333;
                line-height: 1.5;
            }

            h3 {
                text-align: center;
                text-transform: uppercase;
                margin-bottom: 15px;
                font-size: 22px;
                color: #444;
            }

            .wrapper-content {
                padding: 0;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 12px;
            }

            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
                vertical-align: middle;
            }

            .table th {
                background-color: #3c8dbc;
                color: #fff;
                text-transform: uppercase;
                font-size: 11px;
            }

            .table td {
                font-size: 12px;
            }

            .table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .table tr:hover {
                background-color: #f1f1f1;
            }

            .table tr:last-child td {
                font-weight: bold;
                background-color: #f4f4f9;
            }

            .ibox-content {
                border: none;
                padding: 15px 0 20px 0;
            }

            .border-bottom {
                border-bottom: 2px solid #e7eaec;
                margin-bottom: 15px;
            }

            .text-right {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            .currency {
                font-weight: bold;
                color: #444;
            }

            .header-left img {
                height: 120px;
                margin-right: 20px;
            }

            .header-center {
                text-align: center;
            }

            .header-title {
                margin: 0;
                font-size: 18px;
                font-weight: bold;
                letter-spacing: 1px;
                color: #2c3e50;
                text-transform: uppercase;
            }

            .header-subtitle {
                font-size: 14px;
                font-weight: normal;
                color: #7f8c8d;
                margin: 5px 0;
                font-style: italic;
            }
        </style>
    </head>

    <body style="background: white">

    <?php
    $gunung_select  = $_GET['gunung_select'];
    $pos_select     = $_GET['pos_select'];

    $start_date = $_GET['start_date'] ?? Carbon::now()->format('Y-m-d');
    $end_date   = $_GET['end_date'] ?? Carbon::now()->format('Y-m-d');

    $set_start_date = Carbon::parse($start_date)->format('Y-m-d');
    $set_end_date   = Carbon::parse($end_date)->format('Y-m-d');

    $gunung = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$gunung_select'"));
    $pos    = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id='$pos_select'"));

    $sql = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE is_region_new=1 AND tb_gunung_id='$gunung_select' AND pd_pos_pendakian = '$pos_select' AND DATE(pd_tgl_naik) BETWEEN '$set_start_date' AND '$set_end_date' ORDER BY pd_tgl_naik ");
    $sql6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian WHERE pp_id = '$pos_select'"));
    ?>
<table>
    <tr>
        <td class="header-left" style="text-align: right;">
            <img style="height: 120px;" src="../../../../assets/img/logo_jawa_timur.png" alt="Logo Jawa Timur">
        </td>
        <td class="header-center" colspan="2" style="width: 700px;">
            <h2 class="header-title">PEMERINTAH PROVINSI JAWA TIMUR</h2>
            <h2 class="header-title">DINAS KEHUTANAN</h2>
            <h2 class="header-title">UPT TAMAN HUTAN RAYA (TAHURA) RADEN SOERJO</h2>
            <p class="header-subtitle">Jl. Simpang Panji Suroso Kav. 144, Telp. 0341-483254</p>
            <h2 class="header-title">MALANG</h2>
        </td>
    </tr>
    <tr>
        <td class="tg-lj5e" colspan="4">
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="4"><h4  style="text-transform: none;">Laporan Asuransi <?php echo $gunung['nama'].'('.$pos['pp_nama'].')';  ?></h4></td>
    </tr>
    <tr>
        <td colspan="4"><h4><?php echo 'tanggal ' .Carbon::parse($_GET['start_date'])->format('d-m-Y'). ' - ' .Carbon::parse($_GET['end_date'])->format('d-m-Y'); ?></h4></td>
    </tr>
</table>



    <div class="wrapper wrapper-content" style="padding: 0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content" style="border: none; padding: 15px 0 20px 0">
                        <table class="table table-bordered" style="width: 100%">
                            <thead>
                            <tr style="font-size: 10px; text-transform: uppercase;">
                                <th rowspan="2" style="vertical-align: middle;">#</th>
                                <th rowspan="2" style="vertical-align: middle;">Kode</th>
                                <th rowspan="2" style="vertical-align: middle;">Nama</th>
                                <th rowspan="2" style="vertical-align: middle;">Naik</th>
                                <th rowspan="2" style="vertical-align: middle;">Turun</th>
                                <th rowspan="2" style="vertical-align: middle;">Hari</th>
                                <th colspan="2">rombongan</th>
                                <th rowspan="2" style="vertical-align: middle;">Asuransi</th>
                            </tr>
                            <tr style="font-size: 10px">
                                <th>WNI</th>
                                <th>WNA</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            $jumwni = 0;
                            $jumwna = 0;
                            $totasuransi = 0;
                            while ($row = mysqli_fetch_array($sql)) { ?>
                                <tr style="font-size: 12px">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['pd_nomor']; ?></td>
                                    <td><?php echo $row['pd_nama_ketua']; ?></td>
                                    <td style="text-align: center"><?php echo Carbon::parse($row['pd_tgl_naik'])->format('d-m-Y'); ?></td>
                                    <?php
                                    if ($row['pd_pos_turun'] == '') { ?>
                                        <td style="text-align: center"><?php echo Carbon::parse($row['pd_tgl_turun'])->format('d-m-Y');?><small><strong>(rencana)</strong></small></td>
                                    <?php }
                                    else{ ?>
                                        <td style="text-align: center"><?php echo Carbon::parse($row['pd_tgl_turun'])->format('d-m-Y'); ?></td>
                                    <?php }?>
                                    <?php
                                    $awal  = Carbon::parse($row['pd_tgl_naik']);
                                    $akhir = Carbon::parse($row['pd_tgl_turun']);
                                    $hari  = $awal->diffInDays($akhir) == 0 ? 1 : $awal->diffInDays($akhir);
                                    ?>
                                    <td style="text-align: center"><?php echo $hari; ?></td>
                                    <?php ?>
                                    <?php
                                    $wniang = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_anggota_pendakian a JOIN tb_pendakian b ON a.ap_pendakian=b.pd_id WHERE ap_kewarganegaraan = 'WNI' AND pd_id = '$row[pd_id]'"));
                                    $wnaang = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_anggota_pendakian a JOIN tb_pendakian b ON a.ap_pendakian=b.pd_id WHERE ap_kewarganegaraan = 'WNA' AND pd_id = '$row[pd_id]'"));
                                    $jumwni += $wniang['jml']+1;
                                    $jumwna += $wnaang['jml'];
                                    $asuransi = $hari * (($wniang['jml']+$wnaang['jml']+1)*1000);
                                    $totasuransi += $asuransi;
                                    ?>
                                    <td style="text-align: center;"><?php echo $wniang['jml']+1; ?></td>
                                    <td style="text-align: center;"><?php echo $wnaang['jml']; ?></td>
                                    <td style="text-align: center;"><?php echo 'Rp. '.number_format($asuransi,0,",",".")?></td>
                                </tr>
                            <?php }
                            ?>
                            <tr>
                                <td colspan="6" style="text-align: center"><strong></strong></td>
                                <td style="text-align: center;"><strong><?php echo $jumwni; ?></strong></td>
                                <td style="text-align: center;"><strong><?php echo $jumwna; ?></strong></td>
                                <td style="text-align: center;"><strong><?php echo 'Rp. '.number_format($totasuransi,0,",",".") ?></strong></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
    </html>
<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>