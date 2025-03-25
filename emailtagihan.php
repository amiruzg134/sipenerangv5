<?php
    date_default_timezone_set('Asia/Jakarta');
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
        <td></td>
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
                                            <?php
                                            if($kategori_pembayaran == "VA"){ ?>
                                                <tr>
                                                    <td><strong>No. Virtual Account</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td><strong><?php echo $payment_number; ?></strong></td>
                                                </tr>
                                            <?php }else if($kategori_pembayaran == "QRIS"){ ?>
                                                <tr>
                                                    <td><strong>QRIS</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td><img class="img-qrcode" src="https://image-charts.com/chart?cht=qr&chl=<?php echo $payment_number; ?>&chs=75x75&choe=UTF-8&icqrf=00000000"/></td>
                                                </tr>
                                            <?php  } ?>
                                            <tr>
                                                <td><strong>Bank </strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong>BPD Jatim / Bank Jatim</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nominal Tagihan</strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong><?php echo 'Rp. '.number_format($total_bayar,0,",",".")?></strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bayar Sebelum</strong></td>
                                                <td><strong>:</strong></td>
                                                <td><strong><?php echo $show_expired_at;?> WIB</strong></td>
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
                                                            <td class="alignright"><strong><?php echo $pd_nomor?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Ketua :</td>
                                                            <td class="alignright"><?php echo $fullname;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tujuan :</td>
                                                            <td class="alignright"><?php echo $nama_gunung;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Naik :</td>
                                                            <td class="alignright"><?php echo $show_start_date;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Turun :</td>
                                                            <td class="alignright"><?php echo $show_end_date;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah Rombongan :</td>
                                                            <td class="alignright"><?php echo $total_anggota ?> Orang</td>
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
        <td></td>
    </tr>
</table>

</body>
</html>
