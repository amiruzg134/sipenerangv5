<?php
session_start();
if (!isset($_SESSION['uuid'])) {
    header('Location: login.php');
    exit;
}
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/logo.png">
    <title>
        Book Pendakian Gunung Arjuno Welirang Pundak
    </title>

    <meta name="keywords" content="booking gunung arjuno welirang, booking gunung pundak, booking online, pendakian">
    <meta name="description" content="Booking Pendakian Gunung Arjuno Welirang dan Pundak">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="assetsform-backup/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assetsform-backup/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assetsform-backup/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="assetsform-backup/css/soft-ui-dashboard.min.css?v=1.1.1" rel="stylesheet" />
    <style>
        .async-hide {
            opacity: 0 !important
        }
        .input-group .form-control:not(:first-child){
            padding-left: 10px;
        }
        .choices__list--dropdown .choices__item--selectable {
            padding-right: 0;
        }
        #removeRow2, .btn-danger{
            margin: 0;
        }
        .btn-danger {
            padding: 0.72rem 1.15rem;
        }
    </style>
    <script type="text/javascript">
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + " " + " " + seconds;

                if (--timer < 0) {
                    // timer = duration;
                    $.ajax({
                        type: 'post',
                        url: 'logout.php',
                        data: {
                            logout: "logout"
                        },
                        success: function(response) {
                            window.location = "index.php";
                        }
                    });
                }
                console.log(parseInt(seconds))
                window.localStorage.setItem("seconds",seconds)
                window.localStorage.setItem("minutes",minutes)
            }, 1000);
        }

        window.onload = function () {
            sec  = parseInt(window.localStorage.getItem("seconds"))
            min = parseInt(window.localStorage.getItem("minutes"))

            if(parseInt(min*sec)){
                var fiveMinutes = (parseInt(min*60)+sec);
            }else{
                var fiveMinutes = 60 * 60;
            }
            // var fiveMinutes = 60 * 5;
            display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };

    </script>

</head>
<body class="g-sidenav-show bg-gray-100">

<div class="container-fluid py-4">
    <form method="POST" id="form" name="form" autocomplete="off">
        <input type="hidden" name="tjn" value="<?php echo $_GET['tjn']?>">
        <input type="hidden" name="tglnaik" value="<?php echo $_GET['tglnaik']?>">
        <input type="hidden" name="tglturun" value="<?php echo $_GET['tglturun']?>">
        <input type="hidden" name="bayar" value="<?php echo $_GET['totalbayar']?>">

        <?php
        if (isset($_SESSION['uuid'])) { ?>
            <div class="col-md-6 mx-auto text-center">
                <h5 class="mb-1 text-primary"> sisa waktu mengisi form </h5>
                <h5 class="mb-1 text-primary" id="time"> </h5>
            </div>
        <?php }
        ?>

        <?php
        if ($_GET['tjn'] == 'arjuno') { ?>
            <!-- JALUR -->
            <div class="row">
                <div class="col-lg-9 col-12 mx-auto">
                    <div class="card mt-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Jalur Pendakian</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="col-sm-12">
                                <label class="form-label mt-4">Pilih jalur resmi</label>
                                <select class="form-control jalur" name="jalur" required>
                                    <option value="">- Pilih -</option>
                                    <option value="1">Pos Tambaksari</option>
                                    <?php
                                    $count  = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian WHERE jalur = '2' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_GET[tglnaik]'"));
                                    $count2  = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian a JOIN tb_anggota_pendakian b ON a.pd_id = b.ap_pendakian WHERE jalur = '2' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_GET[tglnaik]'"));
                                    if ($count['jml'] + $count2['jml'] <= 350 ) {
                                        echo '<option value="2">Pos Sumberbrantas</option>';
                                    }
                                    else{
                                        echo '<option disabled>Pos Sumberbrantas (PENUH)</option>';
                                    }
                                    ?>
                                    <option value="3">Pos Lawang</option>
                                    <option value="4">Pos Tretes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>

        <!-- DATA KETUA -->
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center">
                                <h6 class="mb-0">Data Ketua Rombongan</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label mt-4">Nama Ketua</label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" name="namaketua" pattern="[a-zA-Z'\s]+" minlength="6" placeholder="nama lengkap" required >
                                </div>
                                <label class="form-label mt-4">Nomor Identitas <small>(KTP/SIM/Kartu Pelajar/Passport)</small></label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" pattern="\d*" minlength="6" maxlength="16" title="isi dengan angka" name="identitasketua" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label mt-4">Tempat Lahir</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="tmptlahir" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="margin-bottom: 0">
                                            <label class="form-label mt-4">Tanggal Lahir</label>
                                            <div class="input-group" >
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                <input class="form-control datetimepicker" type="text" name="tgllahir" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="form-label mt-4">No. Telepon <small style='color:red'>(whatsapp)</small></label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" pattern="\d*" minlength="10" maxlength="13" title="isi dengan angka" name="hpketua" required>
                                </div>
                                <label class="form-label mt-4">Email</label>
                                <div class="input-group">
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                                <label class="form-label mt-4">Jenis Kelamin</label>
                                <select class="form-control" name="jnsketua" required>
                                    <option value="">- Pilih -</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mt-4">Alamat</label>
                                <div class="input-group">
                                    <textarea class="form-control" style="height: 40px;" name="almtketua" required> </textarea>
                                </div>
                                <label class="form-label mt-4">Provinsi</label>
                                <select class="form-control" name="provinsi" id="provinsi" required>
                                    <option value=""></option>
                                </select>
                                <label class="form-label mt-4">Kabupaten/Kota</label>
                                <select class="form-control" name="kabupaten" id="kabupaten" required>
                                    <option value="">- Pilih -</option>
                                </select>
                                <label class="form-label mt-4">Kecamatan</label>
                                <select class="form-control" name="kecamatan" id="kecamatan" required>
                                    <option value="">- Pilih -</option>
                                </select>
                                <label class="form-label mt-4">Desa/Kelurahan</label>
                                <select class="form-control" name="kelurahan" id="kelurahan" required>
                                    <option value="">- Pilih -</option>
                                </select>
                                <label class="form-label mt-4">Kewarganegaraan</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="wargaketua" value="WNI" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DATA ANGGOTA -->
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center">
                                <h6 class="mb-0">Data Anggota</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <?php
                        for ($i = 1; $i <= $_GET['wni']-1; $i ++) { ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label mt-4 text-primary">Nama Anggota <?php echo $i ?></label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" name="namaanggota[]" id="namaanggota" pattern="[a-zA-Z'\s]+" minlength="6" placeholder="nama lengkap" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">No. Telepon</label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" pattern="\d*" minlength="10" maxlength="13" title="isi dengan angka" name="hpanggota[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">No. Identitas</label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" pattern="\d*" minlength="6" maxlength="16" title="isi dengan angka" name="identitasanggota[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">Jenis Kelamin</label>
                                    <select class="form-control" name="jnsanggota[]"required>
                                        <option value="">- Pilih -</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">Kewarganegaraan</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="wargaanggota[]" value="WNI" readonly required>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        for ($i = 1; $i <= $_GET['wna']; $i ++) {
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label mt-4 text-primary">Nama Anggota <?php echo $i ?></label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" name="namaanggota[]" id="namaanggota" pattern="[a-zA-Z'\s]+" minlength="6" placeholder="nama lengkap" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">No. Telepon</label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" pattern="\d*" minlength="10" maxlength="13" title="isi dengan angka" name="hpanggota[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">No. Identitas</label>
                                    <div class="input-group">
                                        <input class="form-control selector" type="text" minlength="6" maxlength="16" name="identitasanggota[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">Jenis Kelamin</label>
                                    <select class="form-control" name="jnsanggota[]" required>
                                        <option value="">- Pilih -</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">Kewarganegaraan</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="wargaanggota[]" value="WNA" readonly required>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- DATA KONTAK DARURAT -->
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center">
                                <h6 class="mb-0">Data Kontak Darurat</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label mt-4">Nama Kontak Darurat </label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" name="namadarurat" id="namadarurat" minlength="6" pattern="[a-zA-Z'\s]+" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mt-4">No. Telepon</label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" pattern="\d*" minlength="10" maxlength="13" title="isi dengan angka" name="hpdarurat" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mt-4">Alamat</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="almtdarurat" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mt-4">Hubungan</label>
                                <select class="form-control" name="hubungan" required>
                                    <option value="">- Pilih -</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Teman">Teman</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($_GET['tjn'] == 'arjuno') { ?>
            <!-- DATA PERLENGKAPAN -->
            <div class="row">
                <div class="col-lg-9 col-12 mx-auto">
                    <div class="card mt-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Data Perlengkapan</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <label class="form-label mt-4">Tenda</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="tenda" required>
                                    </div>
                                    <label class="form-label mt-4">Sleeping Bag</label>
                                    <div class="input-group">
                                        <?php
                                        $tgl1 = strtotime($_GET['tglnaik']);
                                        $tgl2 = strtotime($_GET['tglturun']);
                                        $jarak = $tgl2 - $tgl1;
                                        $hari = ($jarak / 60 / 60 / 24)+1;
                                        if ($hari > 1) {
                                            echo '<input class="form-control" type="number" name="sb" value="'.($_GET['wni'] + $_GET['wna']).'" readonly required>';
                                        }
                                        else {
                                            echo '<input class="form-control" type="number" name="sb" required>';
                                        }
                                        ?>
                                    </div>
                                    <label class="form-label mt-4">Peralatan Masak</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="masak" required>
                                    </div>
                                    <label class="form-label mt-4">Bahan Bakar</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="bahanbakar" required>
                                    </div>
                                    <label class="form-label mt-4">Ponco/Jas Hujan</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="jashujan" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <label class="form-label mt-4">Senter</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="senter" required>
                                    </div>
                                    <label class="form-label mt-4">Obat-obatan/P3K</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="obat" required>
                                    </div>
                                    <label class="form-label mt-4">Matras</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="matras" required>
                                    </div>
                                    <label class="form-label mt-4">Kantong Sampah</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="sampah" required>
                                    </div>
                                    <label class="form-label mt-4">Jaket</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="jaket" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA LOGISTIK -->
            <div class="row">
                <div class="col-lg-9 col-12 mx-auto">
                    <div class="card mt-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Data Logistik</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="btn bg-gradient-dark mb-0" id="addRow2"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <label class="form-label mt-4">**</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-danger" disabled><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-9 col-7">
                                    <label class="form-label mt-4">Logistik</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" minlength="3" pattern="[a-zA-Z'\s]+" name="makanan[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-3">
                                    <label class="form-label mt-4">Jumlah</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="jmlmakanan[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <label class="form-label mt-4">**</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-danger" disabled><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-9 col-7">
                                    <label class="form-label mt-4">Logistik</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" minlength="3" pattern="[a-zA-Z'\s]+" name="makanan[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-3">
                                    <label class="form-label mt-4">Jumlah</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="jmlmakanan[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <label class="form-label mt-4">**</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-danger" disabled><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-9 col-7">
                                    <label class="form-label mt-4">Logistik</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" minlength="3" pattern="[a-zA-Z'\s]+" name="makanan[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-3">
                                    <label class="form-label mt-4">Jumlah</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="jmlmakanan[]" required>
                                    </div>
                                </div>
                            </div>
                            <div id="newRow2"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>

        <!-- ONE HIKER ONE TREE -->
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center">
                                <h6 class="mb-0">Kegiatan One Hiker One Tree (ONHOT)</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <p style="text-align: justify;"><b>One Hiker One Tree</b> Adalah program pemulihan ekosistem kawasan Tahura Raden Soerjo dengan menggalang partisipasi masyarakat untuk berkontribusi dalam kegiatan penanaman melalui donasi Rp. 130.000/orang yang disalurkan kepada TRC Relawan Tahura. Donasi ini selanjutnya akan dipergunakan untuk membiayai penyediaan bibit, penanaman, pemeliharaan dan perlindungan yang dilakukan oleh TRC relawan Tahura. Pedonasi selanjutnya disebut sebagai Wali Pohon atau Tree Adopter akan memperoleh 1 kaos seri OnHOT, bibit beserta QR Code idenditas pohon yang ditanamkan di Kawasan Tahura, sertifikat sebagai Wali Pohon/Tree Adopter dan laporan periodik perkembangan pertumbuhan pohon. Baca selengkapnya di <a href="https://onehikeronetree.com" target="_blank" class="text-primary">www.onehikeronetree.com</a></p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="onhot" value="Y" id="fcustomCheck1" >
                            <label class="custom-control-label" for="customCheck1">Turut Berpartisipasi (opsional)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RINGKASAN -->
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center">
                                <h5 class="mb-0">Ringkasan Booking</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-hover">
                            <tr>
                                <td><h6 class="text-dark">Tujuan </h6></td>
                                <td>:</td>
                                <td><?php echo $_GET['tjn'] ?></td>
                            </tr>
                            <tr>
                                <td><h6 class="text-dark">Tanggal Naik  </h6></td>
                                <td>:</td>
                                <td><?php echo date('d/m/Y', strtotime($_GET['tglnaik']))?></td>
                            </tr>
                            <tr>
                                <td><h6 class="text-dark">Tanggal Turun </h6></td>
                                <td>:</td>
                                <td><?php echo date('d/m/Y', strtotime($_GET['tglturun']))?></td>
                            </tr>
                            <tr>
                                <td><h6 class="text-dark">Rombongan </h6></td>
                                <td>:</td>
                                <td><?php echo $_GET['wni']+$_GET['wna'] ?> orang</td>
                                <input type="hidden" name="rombongan" value="<?php echo $_GET['wni']+$_GET['wna'] ?>">
                            </tr>
                            <tr>
                                <td><h6 class="text-dark">Tarif </h6></td>
                                <td>:</td>
                                <td>Rp. <?php echo number_format($_GET['totalbayar'],0,",",".")?></td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" name="" class="btn bg-gradient-primary w-100 mb-0" >Booking</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- FOOTER -->
    <footer class="footer pt-6">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-center"> All rights reserved. Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="https://tahurarsoerjo.dishut.jatimprov.go.id" target="_blank">UPT Tahura Raden Soerjo.</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="assetsform-backup/js/jquery-min.js"></script>
<script src="assetsform-backup/js/core/popper.min.js"></script>
<script src="assetsform-backup/js/core/bootstrap.min.js"></script>
<script src="assetsform-backup/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assetsform-backup/js/plugins/smooth-scrollbar.min.js"></script>
<script src="assetsform-backup/js/plugins/dragula/dragula.min.js"></script>
<script src="assetsform-backup/js/plugins/jkanban/jkanban.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="assetsform-backup/js/soft-ui-dashboard.min.js?v=1.1.1"></script>
<script src="assetsform-backup/js/plugins/choices.min.js"></script>
<script src="assetsform-backup/js/plugins/flatpickr.min.js"></script>
<script src="assetsform-backup/js/plugins/sweetalert.min.js"></script>
<script src="assetsform-backup/js/plugins/validate/jquery.validate.min.js"></script>

<script type="text/javascript">
    if (document.getElementById('choices-gender')) {
        var gender = document.getElementById('choices-gender');
        const example = new Choices(gender);
    }
    if (document.getElementById('jenkel')) {
        var gender = document.getElementById('jenkel');
        const example = new Choices(gender, {
            searchEnabled: false,
            itemSelectText: ''
        });
    }
    if (document.getElementById('hubungan')) {
        var gender = document.getElementById('hubungan');
        const example = new Choices(gender, {
            searchEnabled: false,
            itemSelectText: ''
        });
    }

    <?php
    for ($i = 1; $i <= $_GET['wni']-1; $i ++) { ?>
    if (document.getElementById('jenkel<?php echo $i ?>')) {
        var gender = document.getElementById('jenkel<?php echo $i ?>');
        const example = new Choices(gender, {
            searchEnabled: false,
            itemSelectText: ''
        });
    }
    <?php }
    ?>

    <?php
    for ($i = 1; $i <= $_GET['wna']; $i ++) { ?>
    if (document.getElementById('jenkell<?php echo $i ?>')) {
        var gender = document.getElementById('jenkell<?php echo $i ?>');
        const example = new Choices(gender, {
            searchEnabled: false,
            itemSelectText: ''
        });
    }
    <?php }
    ?>

    if (document.querySelector('.datetimepicker')) {
        flatpickr('.datetimepicker', {
            allowInput: true,
            disableMobile: "true",
            maxDate : "today",
            disable: [
                {
                    from: "2006-01-01",
                    to: "today"
                }
            ]
        });
    }

    $.ajax({
        type: 'POST',
        url: "get_provinsi.php",
        cache: false,
        success: function(msg){
            $("#provinsi").html(msg);
        }
    });

    $("#provinsi").change(function(){
        var provinsi = $("#provinsi").val();
        $.ajax({
            type: 'POST',
            url: "get_kabupaten.php",
            data: {provinsi: provinsi},
            cache: false,
            success: function(msg){
                $("#kabupaten").html(msg);
            }
        });
    });

    $("#kabupaten").change(function(){
        var kabupaten = $("#kabupaten").val();
        $.ajax({
            type: 'POST',
            url: "get_kecamatan.php",
            data: {kabupaten: kabupaten},
            cache: false,
            success: function(msg){
                $("#kecamatan").html(msg);
            }
        });
    });

    $("#kecamatan").change(function(){
        var kecamatan = $("#kecamatan").val();
        $.ajax({
            type: 'POST',
            url: "get_kelurahan.php",
            data: {kecamatan: kecamatan},
            cache: false,
            success: function(msg){
                $("#kelurahan").html(msg);
            }
        });
    });

    // add row 2
    $("#addRow2").click(function () {
        var html = '';
        html += '<div class="row" id="inputFormRow2">';
        html += '<div class="col-md-1 col-2 mt-3">';
        html += '<label class="form-label">**</label>';
        html += '<div class="input-group">';
        html += '<button type="button" class="btn btn-danger" id="removeRow2"><i class="fas fa-trash"></i></button>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-9 col-7 mt-3">';
        html += '<label class="form-label">Logistik</label>';
        html += '<div class="input-group">';
        html += '<input class="form-control" type="text" minlength="3" name="makanan[]" required>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2 col-3 mt-3">';
        html += '<label class="form-label">Jumlah</label>';
        html += '<div class="input-group">';
        html += '<input class="form-control" type="text" name="jmlmakanan[]" required>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#newRow2').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow2', function () {
        $(this).closest('#inputFormRow2').remove();
    });

    $('.jalur').change(function(){
        selectedopt =  $(this).val();

        if(selectedopt == "3"){
            Swal.fire({
                icon : 'question',
                title : 'Apakah anda yakin?',
                text : 'Jalur pendakian gunung Arjuno via Lawang khusus untuk pendaki berpengalaman.',
                allowOutsideClick: false
            })
        }
    })

    $("#form").submit(function (e) {
        e.preventDefault(); // stops the default action
        //$("#loader").show(); // shows the loading screen
        Swal.fire({
            title: "Mengirim Formulir...",
            text: "Harap bersabar ini ujian",
            imageUrl: "assets/img/Ellipsis-1s-200px.gif",
            showConfirmButton: false,
            allowOutsideClick: false
        });
        $.ajax({
            url: 'simpan.php',
            data:$(this).serialize(),
            type: "POST",
            success: function (returnhtml) {
                document.getElementById("form").reset();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton : 'btn btn-danger',
                        denyButton : 'btn btn-dark me-2'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Booking Berhasil!',
                    icon: 'success',
                    showCancelButton: false,
                    showDenyButton: true,
                    allowOutsideClick: false,
                    denyButtonText: `Status Booking`,
                    confirmButtonText: 'Survey Kepuasan',
                    reverseButtons: true
                }).then((result) => {
                    returnhtml = JSON.parse(returnhtml);
                    if (result.isConfirmed) {
                        window.open('https://sukma.jatimprov.go.id/fe/survey?idUser=190&idEvent=316', "_blank");
                        window.location = "statusbooking.php?id="+returnhtml.status;
                    }
                    else if (result.isDenied) {
                        window.location = "statusbooking.php?id="+returnhtml.status;
                    }
                })
            }
        });
    });
</script>

<script type="text/javascript">
    $('.selector').on('blur',function () {
        var current_value = $(this).val();
        $(this).attr('value',current_value);
        console.log(current_value);
        if ($('.selector[value="' + current_value + '"]').not($(this)).length > 0 || current_value.length == 0 ) {
            $(this).focus();
            Swal.fire({
                icon : 'warning',
                title : 'Terdapat data sama atau kolom kosong',
                allowOutsideClick: false
            })
        }
    });
</script>

</body>
</html>