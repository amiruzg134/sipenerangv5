<?php
    date_default_timezone_set('Asia/Jakarta'); 
    $jml        = mysqli_fetch_array(mysqli_query($conn, "SELECT pd_id FROM tb_pendakian ORDER BY pd_id DESC LIMIT 1 "));
    $anggota    = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*)+1 as anggota FROM tb_anggota_pendakian WHERE ap_pendakian = '".$jml['pd_id']."' "));
    $sql        = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_id = '".$jml['pd_id']."' ");
    $row        = mysqli_fetch_array($sql);
    $startTime  = $row['pd_tanggal_registrasi'];
    $exp        = date('Y-m-d H:i:s',strtotime('+6 hour',strtotime($startTime)));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Booking Online Pendakian Gunung Arjuno Welirang</title>
    <link rel="shortcut icon" sizes="196x196" href="img/logo.ico">
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .body-wrap {
            background-color: #f5f5f5;
            width: 100%;
        }
        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }
        .main {
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }
        .content-wrap {
            padding: 20px;
        }
        .content-block {
            padding: 0 0 20px;
        }
        .invoice {
            margin: 40px auto;
            text-align: left;
            width: 80%;
        }
        .invoice .invoice-items {
            width: 100%;
        }
        .invoice td {
            padding: 5px 0;
        }
        .invoice .invoice-items td {
            border-top: #eee 1px solid;
        }
        table td {
            vertical-align: top;
        }
        .alignright {
            text-align: right;
        }
        img{
            max-width: 100%
        }
        .content-block p{
            margin: 0;
        }
        .sub td{
            padding: 0
        }
    </style>
</head>

<body>

<table class="body-wrap">
    <tr>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <img src="https://tahurarsoerjo.dishut.jatimprov.go.id/sipenerang/assets/img/header.jpg" alt="img" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" style="padding-top: 20px">
                                        <h2 style="text-align: center;"><strong>PEMBAYARAN BOOKING ONLINE</strong></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" style="font-size: 14px">
                                        <p><strong>PT. Bank Pembangunan Daerah Jawa Timur (Bank Jatim).</strong></p>
                                        <p>Mohon dibayarkan sesuai dengan nominal tagihan.</p>
                                        <!-- <p>PEMBAYARAN SELAIN MENGGUNAKAN VIRTUAL ACCOUNT AKAN OTOMATIS DITOLAK OLEH SISTEM.</p> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table class="sub" style="font-size: 16px;">
                                            <tr>
                                                <td><strong>No. Virtual Account </strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong><?php echo $row['va']?></strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bank </strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong>BPD Jatim / Bank Jatim</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jumlah Pembayaran</strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong><?php echo 'Rp. '.number_format($row['biaya'],0,",",".")?></strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bayar Sebelum</strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong><?php echo date('d/m/Y h:i:s', strtotime($row['pd_tanggal_registrasi'])+10800);?> WIB</strong></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice" style="margin: auto;">
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>Kode Booking :</td>
                                                            <td class="alignright"><strong><?php echo $row['pd_nomor']?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Ketua :</td>
                                                            <td class="alignright"><?php echo $row['pd_nama_ketua'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tujuan :</td>
                                                            <td class="alignright"><?php echo $row['keterangan'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Naik :</td>
                                                            <td class="alignright"><?php echo date('d/m/Y', strtotime($row['pd_tgl_naik']));?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Turun :</td>
                                                            <td class="alignright"><?php echo date('d/m/Y', strtotime($row['pd_tgl_turun']));?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah Rombongan :</td>
                                                            <td class="alignright"><?php echo $anggota['anggota'];?> Orang</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" style="font-size: 12px">
                                        <ul>
                                            <li>Pembayaran menggunakan selain bank Jatim melalui menu transfer antar bank</li>
                                            <li>Jika transaksi gagal, ubah layanan/metode transfer dari BI-FAST ke Realtime Online</li>
                                            <li>Tidak dapat melakukan pembayaran melalui aplikasi Flip</li>
                                            <li>Setelah melakukan pembayaran pastikan klik tombol SUDAH BAYAR yang terdapat di menu status booking.</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" style="font-size: 12px">
                                        <p><strong>UPT. TAHURA RADEN SOERJO</strong></p>
                                        <p>Jl. Simpang Panji Suroso Kav. 144, Arjosari, Blimbing, Malang</p>
                                        <p>Telp : (0341) 483254</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <p style="font-size: 12px;">*Email ini dibuat otomatis, mohon tidak membalas. Jika butuh bantuan, silahkan hubungi admin di nomor yang tertera di halaman website.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block" style="padding-top: 20px">
                                        <p><h2 style="text-align: center;"><strong>DONASI PROGRAM ONE HIKER ONE TREE</strong></h2></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" style="font-size: 14px">
                                        <p style="padding-bottom: 10px;">Donasi sebesar Rp. 130.000/orang, transfer ke rekening Bank Jatim 0162794612 a.n ARIVAI.</p>
                                        <p style="padding-bottom: 10px;">Anda akan mendapatkan Bibit, QR Code identitas pohon, sertifikat dan Kaos.</p>
                                        <p>Konfirmasi pembayaran bisa melalui nomor Whatsapp 081330357978 atau melalui website <a href="https://onehikeronetree.com" target="_blank" style="text-decoration: none;">onehikeronetree.com</a></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
