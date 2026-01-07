<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include 'config.php';
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

    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="./assets/css/material-kit-pro.min.css?v=3.0.2" rel="stylesheet" />

    <style>
        .async-hide { opacity: 0 !important}
        .form-control{
            padding: 0.5rem 0.75rem !important;
        }
        .form-control[readonly] {
            background-color: transparent !important;
        }
        .table-bordered>:not(caption)>*>* {
            border-width: 0;
        }
        .table-bordered tr td:nth-child(2){
            text-align: center;
        }
        .table-bordered tr td:nth-child(3){
            text-align: right;
        }
    </style>
</head>

<body class="presentation-page bg-gray-200">

<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid px-0">
                    <a class="navbar-brand font-weight-bolder ms-sm-3 d-none d-md-block" href="index.php" rel="tooltip" data-placement="bottom">
                        Tahura Raden Soerjo
                    </a>
                    <a class="navbar-brand font-weight-bolder ms-sm-3 d-block d-md-none" href="index.php" rel="tooltip" data-placement="bottom">
                        Tahura Raden Soerjo
                    </a>
                    <button class="navbar-toggler shadow-none ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation" >
		          <span class="navbar-toggler-icon mt-2">
		            <span class="navbar-toggler-bar bar1"></span>
		            <span class="navbar-toggler-bar bar2"></span>
		            <span class="navbar-toggler-bar bar3"></span>
		          </span>
                    </button>
                    <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                        <ul class="navbar-nav navbar-nav-hover ms-auto">
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="index.php">
                                    Beranda
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="tutorbooking.php">
                                    Panduan Booking
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="tutorpembayaran.php">
                                    Panduan Pembayaran
                                </a>
                            </li>
                            <?php
                            if (isset($_SESSION['uuid'])) { ?>
                                <li class="nav-item dropdown dropdown-hover mx-2">
                                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="dashboard/index.php">
                                        Dashboard
                                    </a>
                                </li>
                            <?php }else{
                                ?>
                                <form action="login.php" method="post">
                                    <li class="nav-item dropdown dropdown-hover mx-2">
                                        <button type="submit" class="nav-link ps-2 d-flex cursor-pointer align-items-center"
                                                style="background: #faebd700;border: 0px;">
                                            Login
                                        </button>
                                    </li>
                                </form>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<header>
    <div class="page-header min-vh-50" style="background-image: url('assets/img/pundak.jpg');" loading="lazy">
        <span class="mask bg-gradient-dark opacity-4"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white text-center">
                    <h2 class="text-white">Pilih Tujuan dan Tanggal</h2>
                </div>
            </div>
        </div>
    </div>
</header>

<form autocomplete="off" method="post" id="cek">
    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
        <div class="container">
            <div class="row border-radius-md pb-4 mx-sm-0 mx-1 position-relative">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-4 mt-lg-n2 mt-2">

                            <!--                          <select name="gunung_id" id="gunung_id" class="form-control">-->
                            <!--                              <option disabled selected> Pilih </option>-->
                            <!--                              --><?php
                            //                              $sql_gunung = mysqli_query($conn, "SELECT * FROM tb_gunung WHERE is_active=1");
                            //                              while ($data_gunung=mysqli_fetch_array($sql_gunung)) {
                            //                                  if($row['tb_gunung_id'] == $data_gunung['id']){ ?>
                            <!--                                      <option value="--><?//=$data_gunung['id']?><!--" selected>--><?//=$data_gunung['nama']?><!--</option>-->
                            <!--                                  --><?php //}else{ ?>
                            <!--                                      <option value="--><?//=$data_gunung['id']?><!--">--><?//=$data_gunung['nama']?><!--</option>-->
                            <!--                                  --><?php //}
                            //                              }
                            //                              ?>
                            <!--                          </select>-->

                            <select class="form-control prooftype" name="tjn" id="choices-button" required>
                                <option value="">-- pilih --</option>
                                <option value="arjuno">Arjuno Welirang</option>
                                <option value="pundak">Pundak</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mt-lg-n2 mt-2 col-6">
                            <label class="ms-0">WNI</label>
                            <div class="input-group input-group-static">
                                <input name="wni" class="form-control" type="number" id="wni" required placeholder="Jumlah pendaki">
                            </div>
                        </div>
                        <div class="col-lg-2 mt-lg-n2 mt-2 col-6">
                            <label class="ms-0">WNA</label>
                            <div class="input-group input-group-static">
                                <input name="wna" class="form-control" type="number" id="wna" min="0" required placeholder="Jumlah pendaki">
                            </div>
                        </div>
                        <div class="col-lg-2 mt-lg-n2 mt-2">
                            <label class="ms-0">Tanggal Naik</label>
                            <div class="input-group input-group-static">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input name="tglnaik" class="form-control readonly" id="start_time" type="text" data-input required placeholder="-- pilih --">
                            </div>
                        </div>
                        <div class="col-lg-2 mt-lg-n2 mt-2">
                            <label class="ms-0">Tanggal Turun</label>
                            <div class="input-group input-group-static">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input name="tglturun" class="form-control readonly" id="end_time" type="text" data-input required placeholder="-- pilih --">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="col-lg-12 mt-4">
                        <button type="submit" class="btn bg-gradient-primary mb-0 w-100">cek kuota</button>
                        <!-- <a type="submit" class="btn bg-gradient-primary w-100 mb-0" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#exampleModalNotification">cek kuota & tarif</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
if (isset($_POST['tjn'])) {
    $kuota 		= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kuota WHERE pos = '$_POST[tjn]' "));
    $arjuno1 	= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian WHERE keterangan = 'arjuno' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_POST[tglnaik]'"));
    $arjuno2	= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian a JOIN tb_anggota_pendakian b ON a.pd_id = b.ap_pendakian WHERE keterangan = 'arjuno' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_POST[tglnaik]'"));
    $pundak1 	= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian WHERE keterangan = 'pundak' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_POST[tglnaik]'"));
    $pundak2	= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian a JOIN tb_anggota_pendakian b ON a.pd_id = b.ap_pendakian WHERE keterangan = 'pundak' AND sts_bayar = 'paid' AND DATE(tgl_naik) = '$_POST[tglnaik]'"));

    if ($_POST['tjn'] == 'arjuno') {
        if ($_POST['wni']+$_POST['wna'] > $kuota['kuota']-($arjuno1['jml']+$arjuno2['jml'])) {
            echo '
						<section class="py-lg-5 mt-4">
						  <div class="container">
						    <div class="row">
						      <div class="card">
						      	<div class="card-body">
						      		<h3 class="text-dark">Kuota Penuh</h3>
						      		<h6 class="text-dark tet-uppercase">Sisa Kuota : '.($kuota['kuota']-($arjuno1['jml']+$arjuno2['jml'])).' </h6>
						      	</div>
						      </div>
						    </div>
						  </div>
						</section>
					';
        }
        else{
            include 'biaya.php';
        }
    }
    else{
        if ($_POST['wni']+$_POST['wna'] > $kuota['kuota']-($pundak1['jml']+$pundak2['jml'])) {
            echo '
						<section class="py-lg-5 mt-4">
						  <div class="container">
						    <div class="row">
						      <div class="card">
						      	<div class="card-body">
						      		<h3 class="text-dark">Kuota Penuh</h3>
						      		<h6 class="text-dark tet-uppercase">Sisa Kuota : '.($kuota['kuota']-($pundak1['jml']+$pundak2['jml'])).' </h6>
						      	</div>
						      </div>
						    </div>
						  </div>
						</section>
					';
        }
        else{
            include 'biaya.php';
        }
    }

    ?>

<?php }
?>

<!-- FOOTER -->
<footer class="footer pt-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <p class="text-dark my-4 text-sm font-weight-normal">
                        All rights reserved. Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="https://tahurarsoerjo.dishut.jatimprov.go.id" target="_blank">UPT Tahura Raden Soerjo.</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/jquery-min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>

<script src="./assets/js/plugins/typedjs.js"></script>

<script src="./assets/js/plugins/countup.min.js"></script>

<script src="./assets/js/plugins/rellax.min.js"></script>

<script src="./assets/js/plugins/tilt.min.js"></script>

<script src="./assets/js/plugins/choices.min.js"></script>

<script src="./assets/js/plugins/parallax.min.js"></script>

<script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>

<script src="./assets/js/plugins/anime.min.js" type="text/javascript"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="./assets/js/material-kit-pro.min.js?v=3.0.2" type="text/javascript"></script>

<script src="assets/js/plugins/flatpickr.min.js"></script>

<script type="text/javascript">

    let startpicker = flatpickr('#start_time', {
        allowInput: false,
        disableMobile: "true",
        minDate : "today",
        maxDate: new Date().fp_incr(30),
        disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28"],
        onClose: function(selectedDates, dateStr, instance) {
            endpicker.set('minDate', dateStr);
            const date = new Date(dateStr);
            date.setDate(date.getDate() + 3);
            endpicker.set('maxDate', date);
        },
    });

    let endpicker = flatpickr('#end_time', {
        allowInput: false,
        disableMobile: "true",
        disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28"],
    });

    if (document.getElementById('choices-button')) {
        var element = document.getElementById('choices-button');
        const example = new Choices(element, {
            searchEnabled: false
        });
    }

    var selectedopt;
    var wna;
    $('.prooftype').change(function(){
        document.getElementById("cek").reset();
        selectedopt =  $(this).val();

        if(selectedopt == "arjuno"){
            $('#wna').change(function(){
                wna =  $(this).val();
                if (wna == 0) {
                    $('#wni').attr('min','3');
                }
                else if (wna == 1){
                    $('#wni').attr('min','2');
                }
                else if (wna == 2) {
                    $('#wni').attr('min','1');
                }
                else if (wna >= 3) {
                    $('#wni').attr('min','1');
                }
            })

            let startpicker = flatpickr('#start_time', {
                allowInput: false,
                disableMobile: "true",
                minDate : "today",
                maxDate: new Date().fp_incr(30),
                disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28", "2023-06-26", "2023-06-27", "2023-06-28", "2023-06-29"],
                onClose: function(selectedDates, dateStr, instance) {
                    endpicker.set('minDate', dateStr);
                    const date = new Date(dateStr);
                    date.setDate(date.getDate() + 2);
                    endpicker.set('maxDate', date);
                },
            });

            let endpicker = flatpickr('#end_time', {
                allowInput: false,
                disableMobile: "true",
                disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28"],
            });
        }

        else if(selectedopt == "pundak"){
            $('#wni').attr('min','0');

            let startpicker = flatpickr('#start_time', {
                allowInput: false,
                disableMobile: "true",
                minDate : "today",
                maxDate: new Date().fp_incr(30),
                disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28"],
                onClose: function(selectedDates, dateStr, instance) {
                    endpicker.set('minDate', dateStr);
                    const date = new Date(dateStr);
                    date.setDate(date.getDate() + 1);
                    endpicker.set('maxDate', date);
                },
            });

            let endpicker = flatpickr('#end_time', {
                allowInput: false,
                disableMobile: "true",
                disable: ["2023-04-20", "2023-04-21", "2023-04-22", "2023-05-27", "2023-05-28"],
            });
        }
    })
</script>

<!--<div class="modal fade" id="exampleModalNotification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">-->
<!--        <div class="modal-content bg-gradient-danger">-->
<!--            <div class="modal-body">-->
<!--              <div class="py-3 text-center text-white">-->
<!--                <i class="material-icons text-3xl">notifications_active</i>-->
<!--                <h4 class="heading mt-4 text-white">Pada setiap akhir bulan, booking ditutup pada pukul 16.00 dan pembayaran paling lambat diterima pukul 21.00</h4>-->
<!--                <h4 class="heading mt-4 text-white">Booking dapat dilakukan lagi pada pukul 00.01 pada hari berikutnya.</h4>-->
<!--              </div>-->
<!--            </div>-->
<!--            <hr class="horizontal light mb-0">-->
<!--            <div class="modal-footer justify-content-between border-0">-->
<!--              <button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Close</button>-->
<!--            </div>-->
<!--      </div>-->
<!--    </div>-->
<!--</div>-->

</body>

</html>
