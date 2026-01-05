<?php 
  ob_start(); 
  include 'config.php';
  $sql = mysqli_query($conn, "SELECT a.*, f.name AS provinsi, g.name AS kabupaten, h.name AS kecamatan, i.name AS kelurahan FROM tb_pendakian a LEFT JOIN tb_anggota_pendakian b ON a.pd_id=b.ap_pendakian LEFT JOIN tb_kontak_darurat c ON a.pd_id=c.kd_pendakian LEFT JOIN tb_logistik d ON a.pd_id=d.lg_pendakian LEFT JOIN tb_peralatan e ON a.pd_id=e.pr_id LEFT JOIN provinces f ON a.pd_provinsi=f.id LEFT JOIN regencies g ON a.pd_kabupaten=g.id LEFT JOIN districts h ON a.pd_kecamatan=h.id LEFT JOIN villages i ON a.pd_desa=i.id LEFT JOIN tb_pos_pendakian j ON a.jalur=j.pp_id WHERE pd_id = '$_GET[id]' ");
  $row = mysqli_fetch_array($sql);
  $sql2 = mysqli_query($conn, "SELECT * FROM tb_anggota_pendakian WHERE ap_pendakian = '$_GET[id]'");
  $sql3 = mysqli_query($conn, "SELECT * FROM tb_kontak_darurat WHERE kd_pendakian = '$_GET[id]'");
  $sql4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_peralatan WHERE pr_pendakian = '$_GET[id]'"));
  $sql5 = mysqli_query($conn, "SELECT * FROM tb_logistik WHERE lg_pendakian = '$_GET[id]'");
  $sql6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user a LEFT JOIN tb_pendakian b ON a.user_id = b.pd_acc_turun_by WHERE pd_id = '$_GET[id]'"));
  $sql7 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_pos_pendakian a LEFT JOIN tb_pendakian b ON a.pp_id = b.pd_pos_turun WHERE pd_id = '$_GET[id]'"));
?>

<style type="text/css">
    .page_break { page-break-before: always; }

    table, th, td {
      border-collapse: collapse;
      font-size: 14px;
      font-family: sans-serif;
    }
    .centered{
        text-align: center;
    }
    .text-indent{
        position: relative;
        left: -60px;
    }
    .m-0{
        margin: 0;
    }
    .m-1{
        margin: 5px;
    }
    .p-5{
        padding: 10px;
    }
    .pt-20{
        padding-top: 20px;
    }
    .bold{
        font-weight: 700;
    }
    .skewed {
      transform: skew(-20deg); /* Equal to skewX(10deg) */
      background-color: #d9d9d9;
      border: 1px solid black;
    }
</style>

<table style="width: 700px;">
    <tr>
        <td rowspan="9" style="width:20px"> </td>
        <td class="centered" style="width:10px; border-bottom: 2px solid black;">
            <img style="height: 100px; " src="assets/img/logo_jawa_timur.png">
        </td>
        <td class="centered" colspan="2" style="border-bottom: 2px solid black; padding-bottom: 10px;">
            <h3 class="m-0 text-indent">PEMERINTAH PROVINSI JAWA TIMUR</h3>
            <h3 class="m-0 text-indent">DINAS KEHUTANAN</h3>
            <h3 class="m-0 text-indent">UPT TAMAN HUTAN RAYA (TAHURA) RADEN SOERJO</h3>
            <h3 class="m-0 text-indent" style="font-weight: normal;">Jl. Simpang Panji Suroso Kav. 144, Telp. 0341-483254</h3>
            <h3 class="m-0 text-indent">MALANG</h3>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="centered" style="padding-top: 30px;">
            <h3 class="m-0 bold">BERITA ACARA</h3>
            <h3 class="m-0 bold">KETERLAMBATAN KELUAR KAWASAN TAHURA RADEN SOERJO</h3>
            <h4 class="m-0" style="padding-bottom: 30px;">NOMOR : <?php echo '0'.$row['jalur'].'/ <span style="color:white">nom</span> /'.date('m', strtotime($row['pd_tgl_turun'])).'/'.date('Y', strtotime($row['pd_tgl_turun'])) ?> </h4>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 10px">
            Pada hari ini <?php echo format_hari_tanggal($row['pd_tgl_turun']) ?> kami yang bertanda tangan di bawah ini :
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 10px">
            <table width="100%">
                <tr>
                    <td rowspan="4" style="vertical-align: top; width: 10px">1.</td>
                    <td style="width: 100px">Nama Ketua</td>
                    <td style="width: 10px" class="centered">:</td>
                    <td colspan="2"><?php echo $row['pd_nama_ketua'] ?></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $row['pd_no_ktp'] ?></td>
                </tr>
                <tr>
                    <td>Kode Booking</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $row['pd_nomor'] ?></td>
                </tr>
                <tr>
                    <td colspan="4">Selanjutnya disebut <b>PIHAK PERTAMA</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 10px">
            <table width="100%">
                <tr>
                    <td rowspan="4" style="vertical-align: top; width: 10px">2.</td>
                    <td style="width: 100px">Nama Petugas</td>
                    <td style="width: 10px" class="centered">:</td>
                    <td colspan="2"><?php echo $sql6['nama'] ?></td>
                </tr>
                <tr>
                    <td>Pos Pendakian</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $sql7['pp_nama'] ?></td>
                </tr>
                <tr>
                    <td colspan="4">Selanjutnya disebut <b>PIHAK KEDUA</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <ul>
    <?php 
        $awal  = date_create(date('Y-m-d', strtotime($row['tgl_turun'])));
        $akhir = date_create(date('Y-m-d', strtotime($row['pd_tgl_turun']))); 
        $diff  = date_diff( $awal, $akhir );
        $hari  = $diff->days;

        $startDate  = strtotime(date('Y-m-d', strtotime($row['tgl_turun'] . ' +1 day')));
        $endDate    = strtotime($row['pd_tgl_turun']);
        $totalbayar = 0;

        $wni = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*)+1 as jml FROM tb_anggota_pendakian WHERE ap_kewarganegaraan = 'WNI' AND ap_pendakian = '$_GET[id]' AND naik = 'Y' "));
        $wna = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_anggota_pendakian WHERE ap_kewarganegaraan = 'WNA' AND ap_pendakian = '$_GET[id]' AND naik = 'Y' "));

        for ($i = $startDate; $i <= $endDate; $i += (86400)) {
          
            $date = new DateTime(date('Y-m-d', $i));
                    
            if ($date->format('N') >= 6) {
                $ket    = 'Hari Libur';
                $tarif  = 15000; 
            }
            elseif(
                date('d-m-Y', $i) == '07-04-2023' || 
                date('d-m-Y', $i) == '19-04-2023' ||
                date('d-m-Y', $i) == '20-04-2023' ||
                date('d-m-Y', $i) == '21-04-2023' ||
                date('d-m-Y', $i) == '22-04-2023' ||
                date('d-m-Y', $i) == '23-04-2023' || 
                date('d-m-Y', $i) == '24-04-2023' ||
                date('d-m-Y', $i) == '25-04-2023' ||
                date('d-m-Y', $i) == '01-05-2023' || 
                date('d-m-Y', $i) == '18-05-2023' ||
                date('d-m-Y', $i) == '01-06-2023' ||
                date('d-m-Y', $i) == '02-06-2023' ||
                date('d-m-Y', $i) == '04-06-2023' ||
                date('d-m-Y', $i) == '29-06-2023' ||
                date('d-m-Y', $i) == '19-07-2023' ||
                date('d-m-Y', $i) == '17-08-2023' ||
                date('d-m-Y', $i) == '28-09-2023' ||
                date('d-m-Y', $i) == '25-12-2023' ||
                date('d-m-Y', $i) == '26-12-2023' 
            ){
                $ket        = 'Hari Libur Nasional';
                $tarif  = 15000;
            } 
            else {
                $ket        = 'Hari Kerja';
                $tarif  = 10000;
            }
            $totalbayar += ($wni['jml']*$tarif)+($wna['jml']*200000);
        }
    ?>
</ul>
    <tr>
        <td colspan="3" style="padding-bottom: 5px">
            <b>PIHAK PERTAMA</b> dengan ini menyatakan terlambat keluar kawasan Tahura Raden Soerjo dan bersedia membayar kekurangan retribusi dengan rincian sebagai berikut :
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 10px">
            <table width="100%">
                <tr>
                    <td rowspan="6" style="vertical-align: top; width: 10px"> </td>
                    <td style="width: 200px">Rencana turun</td>
                    <td style="width: 10px" class="centered">:</td>
                    <td colspan="2"><?php echo date('d-m-Y', strtotime($row['tgl_turun']))?></td>
                </tr>
                <tr>
                    <td>Tanggal turun</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo date('d-m-Y', strtotime($row['pd_tgl_turun']))?></td>
                </tr>
                <tr>
                    <td>Jumlah hari keterlambatan</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $hari;?> Hari</td>
                </tr>
                <tr>
                    <td>Jumlah anggota</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $wni['jml']+$wna['jml']?> orang</td>
                </tr>
                <tr>
                    <td>Biaya keterlambatan</td>
                    <td class="centered">:</td>
                    <td colspan="2">Rp. <?php echo number_format($row['denda'],0,",",".") ?></td>
                </tr>
                <tr>
                    <td>Alasan keterlambatan</td>
                    <td class="centered">:</td>
                    <td colspan="2"><?php echo $row['alasan'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 10px">
            <b>PIHAK KEDUA</b> membenarkan keterlambatan tersebut berdasarkan SIMAKSI dan data pelaporan kedatangan <b>PIHAK PERTAMA</b>.
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya.
        </td>
    </tr>
</table>

<table width="100%" style="margin-top: 30px;">
    <tr class="centered">
        <td>
            <p style="margin-bottom: 60px">PIHAK KEDUA </p>
            <p style="text-transform: uppercase;"><?php echo $sql6['nama']?></p>
        </td>
        <td>
            <p style="margin-bottom: 60px">PIHAK PERTAMA </p>
            <p style="text-transform: uppercase;"><?php echo $row['pd_nama_ketua']?></p>
        </td>
    </tr>
</table>

<table class="page_break" style="width: 100%">
    <tr>
        <td class="centered" colspan="2">
            <h3 class="m-1" style="font-weight: normal;">PEMERINTAH PROVINSI JAWA TIMUR</h3>
            <h3 class="m-1" style="font-weight: normal;">DINAS KEHUTANAN PROVINSI JAWA TIMUR</h3>
            <h3 class="m-1" style="font-weight: normal; text-decoration: underline;">UPT TAMAN HUTAN RAYA (TAHURA) RADEN SOERJO</h3>
            <h3 class="m-1" style="margin-top: 20px">K W I T A N S I</h3>
            <h3 class="m-1" style="font-weight: normal; margin-bottom: 30px;">(Tanda Bukti Pembayaran)</h3>
        </td>
    </tr>
</table>

<table style="width: 100%">
    <tr>
        <td style="width: 140px; padding: 10px 0;"><b>Terima dari</b></td>
        <td style="width: 10px;">:</td>
        <td style="text-transform: uppercase;"><?php echo $row['pd_nama_ketua'] ?></td>
    </tr>
    <tr>
        <td style="width: 140px;"><b>Jumlah</b></td>
        <td style="width: 10px;">:</td>
        <td>
            <table style="width: 100%">
                <tr>
                    <td style="padding: 5px 20px;" class="skewed"><b><?php echo terbilang($row['denda'])?> rupiah</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0;"><b>Untuk pembayaran</b></td>
        <td>:</td>
        <td>Retribusi keterlambatan keluar kawasan Tahura Raden Soerjo selama <?php echo $hari ?> hari <br> tanggal <?php echo date('d-m-Y', strtotime($row['tgl_turun'] . ' +1 day')).' s/d '.date('d-m-Y', strtotime($row['pd_tgl_turun'])) ?>.</td>
    </tr>
</table>

<table style="width: 100%; margin-top: 40px">
    <tr>
        <td style="width: 140px;"><b>Terbilang Rp.</b></td>
        <td style="width: 10px;">:</td>
        <td>
            <table>
                <tr>
                    <td style="padding: 5px 20px;" class="skewed"><b><?php echo number_format($row['denda'],0,",",".")?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<hr>
<table style="width: 100%; margin-top: 40px">
    <tr>
        <td style="width: 450px"> </td>
        <td>......................, <?php echo tgl_indo(date('Y-m-d'),$row['pd_tgl_turun'])?></td>
    </tr>
    <tr>
        <td style="width: 450px"> </td>
        <td>Penerima,</td>
    </tr>
    <tr>
        <td style="width: 450px; padding-bottom: 150px;"> </td>
        <td style="text-transform: uppercase;"><?php echo $sql6['nama'] ?></td>
    </tr>
</table>



<?php 
  $html = ob_get_clean(); 
  use Dompdf\Dompdf; 
  require_once 'dompdf/autoload.inc.php'; 
  $dompdf = new Dompdf(); 
  $dompdf->loadHtml($html); 
  $dompdf->setPaper('A4', 'portrait'); 
  $dompdf->render(); 
  $dompdf->stream('BA_Keterlambatan"'.$row['pd_nomor'].'".pdf', array("Attachment" => 0)); 
?>