<?php
  require 'vendor/autoload.php';
  use Carbon\Carbon;

  session_start();
  include 'config.php';
  include 'config/env.php';
  include 'config/connection.php';
  $year = Carbon::now()->format('Y');

  $arjuno  = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian a JOIN tb_anggota_pendakian b ON a.pd_id = b.ap_pendakian WHERE tb_gunung_id=1 AND sts_bayar = 'paid' AND YEAR(tgl_naik) ='$year'"));
  $pundak   = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian a JOIN tb_anggota_pendakian b ON a.pd_id = b.ap_pendakian WHERE tb_gunung_id=2 AND sts_bayar = 'paid' AND YEAR(tgl_naik) ='$year'"));
  ?>

<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="./assets/img/logo.png">

  <title>Book Pendakian Gunung Arjuno Welirang Pundak</title>
  <meta name="description" content="Booking Pendakian Gunung Arjuno Welirang & Pundak" />
  <meta property="og:title" content="SIPENERANG (Sistem Informasi Monitoring Pendakian Gunung Arjuno Welirang)" />
  <meta property="og:url" content="https://tahurarsoerjo.dishut.jatimprov.go.id/sipenerang" />
  <meta property="og:description" content="Booking Pendakian Gunung Arjuno Welirang & Pundak" />
  <meta property="og:image" content="https://tahurarsoerjo.dishut.jatimprov.go.id/sipenerang/assets/img/logo.png" />
  <meta name="keywords" content="booking gunung arjuno welirang, booking gunung pundak, booking online, pendakian">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="./assets/css/material-kit-pro.min.css?v=3.0.2" rel="stylesheet" />

  <style>
    .async-hide { opacity: 0 !important}
    .bg-gradient-primaryy{background-image:linear-gradient(195deg,#AEE2FF,#7286D3)}
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
                      <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="sop.php">
                          SOP Pendaki
                      </a>
                  </li>
                <li class="nav-item dropdown dropdown-hover mx-2">
                  <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="tutorbooking.php">
                    Panduan Booking
                  </a>
                </li>
                <li class="nav-item dropdown dropdown-hover mx-2">
                  <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="tutorpembayaran.php">
                    Panduan  Pembayaran
                  </a>
                </li>
                  <li class="nav-item dropdown dropdown-hover mx-2">
                      <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#exampleModalSignup">
                          Status Booking
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

  <header class="header-2">
    <div class="page-header min-vh-75" style="background-image: url('./assets/img/gunung.jpg')" loading="lazy" >
      <span class="mask bg-gradient-primaryy opacity-7"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-7 d-flex justify-content-center text-md-start text-center flex-column mt-sm-0 mt-4">
            <h1 class="text-white">Gunung Arjuno Welirang</h1>
            <p class="lead pe-md-5 me-md-5 text-white opacity-8">Puncak Arjuno dikenal dengan nama puncak Ogal Agil yang berada di ketinggian 3.399 mdpl.</p>
            <div class="buttons">
              <a type="button" class="btn btn-rounded bg-gradient-primary mt-4 me-2 btn-lg" href="sop.php">Booking</a>
              <a type="button" class="btn btn-rounded btn-light shadow-none mt-4 btn-lg" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#exampleModalSignup">Status Booking</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">

    <!-- STATS -->
    <section class="pt-3 pb-4" id="count-stats">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 z-index-2 border-radius-xl mx-auto py-3">
            <div class="row">
              <div class="col-md-6 position-relative">
                <div class="p-3 text-center">
                  <h1 class="text-gradient text-primary">
                    <span id="state1" countTo="<?php echo $arjuno['jml']?>"><?php echo $arjuno['jml']?></span>
                  </h1>
                  <h5 class="mt-3">Gunung Arjuno Welirang</h5>
                  <p class="text-sm font-weight-normal">
                    Jumlah pendaki tahun <?php echo date('Y') ?>
                  </p>
                </div>
                <hr class="vertical dark" />
              </div>
              <div class="col-md-6 position-relative">
                <div class="p-3 text-center">
                  <h1 class="text-gradient text-primary">
                    <span id="state2" countTo="<?php echo $pundak['jml']?>"><?php echo $pundak['jml']?></span>
                  </h1>
                  <h5 class="mt-3">Gunung Pundak</h5>
                  <p class="text-sm font-weight-normal">
                    Jumlah pendaki tahun <?php echo date('Y') ?>
                  </p>
                </div>
                <hr class="vertical dark" />
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="py-5 bg-gradient-dark position-relative border-radius-xl" style="background-image:url('https://images.unsplash.com/photo-1533563906091-fdfdffc3e3c4?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80')" loading="lazy">
        <div class="container position-relative z-index-2">
          <div class="row">
            <div class="col-lg-5 col-md-8 m-auto text-start">
              <h5 class="text-white mb-lg-0 mb-5"> Untuk meningkatkan pelayanan kami, silahkan mengisi survey berikut</h5>
            </div>
            <div class="col-lg-6 m-auto">
              <div class="row">
                <div class="col-sm-4 col-6 ps-sm-0 ms-auto">
                  <a href="https://sukma.jatimprov.go.id/fe/survey?idUser=190&idEvent=1634" target="_blank" class="btn bg-gradient-warning mb-0 ms-lg-3 ms-sm-2 mb-sm-0 mb-2 me-auto w-100 d-block">Survey Kepuasan Masyarakat</a>
                </div>
                <div class="col-sm-4 col-6 ps-sm-0 me-lg-0 me-auto">
                  <a href="https://forms.gle/u5bLZ8usEtW6GDMk7" target="_blank" class="btn btn-white mb-0 ms-lg-3 ms-sm-2 mb-sm-0 mb-2 me-auto w-100 d-block">Survey Persepsi Anti Korupsi</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ALUR BOOKING -->
    <section class="py-7">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ms-auto me-auto text-center">
            <h3 class="text-dark mb-0 mt-3">Alur Booking</h3>
            <p>Booking dapat dilakukan 24/7 dan proses Verifikasi dilakukan pada hari Senin - Jumat pukul 08.00 - 16.00. Booking dilakukan maksimal H-2 sebelum tanggal keberangkatan.</p>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-md-5 ms-auto my-auto">
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>1. Portal Booking Pendakian Arjuno-Welirang dan Pundak</h5>
                <p>Klik tombol BOOKING. Disarankan menggunakan browser Google Chrome untuk melakukan Booking. </p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>2. SOP Pendakian</h5>
                <p> Pahami dan taati SOP dan peraturan pendakian yang berlaku. </p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>3. Pilih Tujuan dan Jadwal</h5>
                <p> Pilih tujuan Gunung Arjuno-Welirang atau Gunung Pundak serta tentukan tanggal keberangkatan dan turunnya. </p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>4. Mengisi Form</h5>
                <p> Lengkapi semua kolom yang telah disediakan dan pastikan alamat Email dan nomor telepon sudah sesuai. Informasi tagihan dan status booking akan dikirimkan melalui Email atau Whatsapp.</p>
              </div>
            </div>
          </div>
          <div class="col-md-5 me-auto my-auto ms-md-5">
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>5. Pembayaran</h5>
                <p>Tagihan akan dikirimkan melalui email dan whatsapp. Rincian tagihan juga dapat dilihat di menu Status Booking. Batas waktu melakukan pembayaran yakni 6 jam setelah submit form. Lebih dari waktu tersebut maka kode booking hangus. </p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>6. Klik Bayar</h5>
                <p> Setelah melakukan pembayaran, pastikan pendaki untuk klik tombol SUDAH BAYAR yang terdapat di menu status booking. Verifikasi pembayaran maksimal 1x24 jam pada hari Senin-Jumat pukul 08.00-16.00</p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>7. Cetak SIMAKSI</h5>
                <p> SIMAKSI (Surat Izin Memasuki Kawasan Konservasi) dapat dilihat di kotak masuk email atau melalui menu status booking di website. Cetak SIMAKSI dan tunjukkan ke petugas di pos pendakian.</p>
              </div>
            </div>
            <div class="p-3 info-horizontal d-flex">
              <div>
                <h5>8. Verifikasi SIMAKSI di Pos</h5>
                <p> Petugas akan melakukan validasi SIMAKSI dengan scan QRCode yang terdapat pada lembar SIMAKSI. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-10 mx-auto">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-danger shadow-danger border-radius-lg p-4">
                  <h4 class="text-white mb-0">FAQ</h4>
                  <p class="text-white opacity-8 mb-0">Frequently Asked Questions</p>
                </div>
              </div>
              <div class="accordion p-3" id="accordionRental">
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="headingOne">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      Tarif
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      <ol>
                        <li>
                          <p><b>Tarif karcis masuk pendaki Warga Negara Indonesia</b></p>
                          <p>Rp. 10.000,- Senin - Jumat / Orang / Hari <br>
                          Rp. 15.000,- Sabtu - Minggu - Libur Nasional / Orang / Hari</p>
                        </li>
                        <li>
                          <p><b>Tarif karcis masuk pendaki Warga Negara Asing</b></p>
                          <p>Rp. 200.000,- / Orang / Hari</p>
                        </li>
                        <li>
                          <p><b>Asuransi (bayar di pos)</b></p>
                          <p>Rp. 1.000,- / orang / hari</p>
                        </li>
                        <li>
                          <p><b>Tarif karcis kendaraan Roda 2</b></p>
                          <p>Rp. 3.000,- / unit</p>
                        </li>
                        <li>
                          <p><b>Tarif karcis kendaraan Roda 4</b></p>
                          <p>Rp. 5.000,- / unit</p>
                        </li>
                        <li>
                          <p><b>Fasilitas berbayar (Sumber Brantas)</b></p>
                          <!-- <p><b>Gelang Rp. 5.000,- / pcs</b></p> -->
                          <p>Ojek Pickup : Rp. 25.000,- / orang / sekali jalan <br>
                          Loker : Rp. 5.000,- / ruang <br>
                          Kamar mandi air hangat : Rp. 10.000,- / ruang</p>
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="headingTwo">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Jumlah rombongan
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      Khusus untuk pendakian gunung Arjuno Welirang, setiap rombongan minimal beranggotakan 3 orang pendaki
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="headingThree">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Durasi Pendakian
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      Durasi maksimal melakukan pendakian ialah 3 hari 2 malam
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="headingFifth">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
                      Jam Pelayanan Administrasi
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapseFifth" class="accordion-collapse collapse" aria-labelledby="headingFifth" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      Hari Senin - Jumat pukul 08.00 - 16.00 <br>
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="headingSixth">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixth" aria-expanded="false" aria-controls="collapseSixth">
                      Jam Pelayanan Pendakian
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapseSixth" class="accordion-collapse collapse" aria-labelledby="headingSixth" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      Hari Senin - minggu pukul 08.00 - 17.00 <br>
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="tujuh">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetujuh" aria-expanded="false" aria-controls="collapsetujuh">
                      Apakah bisa melakukan pembayaran di pos?
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapsetujuh" class="accordion-collapse collapse" aria-labelledby="tujuh" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      Saat ini pendaftaran pendakian hanya melalui online dan pembayaran melalui transfer ke Virtual Account yang diberikan setelah melakukan booking.
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="delapan">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsedelapan" aria-expanded="false" aria-controls="collapsedelapan">
                      Apakah bisa menambah anggota rombongan ketika booking telah disetujui?
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapsedelapan" class="accordion-collapse collapse" aria-labelledby="delapan" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      <b>Tidak bisa</b>
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="sembilan">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesembilan" aria-expanded="false" aria-controls="collapsesembilan">
                      Berapa batas waktu pembayaran?
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapsesembilan" class="accordion-collapse collapse" aria-labelledby="sembilan" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      <b>6 Jam setelah berhasil melakukan booking. Lebih dari itu otomatis booking akan hangus</b>
                    </div>
                  </div>
                </div>
                <div class="accordion-item mb-3">
                  <h5 class="accordion-header" id="sepuluh">
                    <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesepuluh" aria-expanded="false" aria-controls="collapsesepuluh">
                      Masa berlaku surat keterangan sehat?
                      <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                      <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                    </button>
                  </h5>
                  <div id="collapsesepuluh" class="accordion-collapse collapse" aria-labelledby="sepuluh" data-bs-parent="#accordionRental">
                    <div class="accordion-body text-sm opacity-8">
                      <b>Masa berlaku surat keterangan sehat maksimal H-3 sebelum tanggal naik</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PETA JALUR -->
    <section class="features-3 py-7">
      <div class="container">
        <div class="row text-center justify-content-center">
          <div class="col-lg-6">
            <h2>Peta Jalur Pendakian</h2>
            <p> Jalur pendakian pada masing-masing jalur pendakian gunung Arjuno Welirang</p>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-lg-3 mb-lg-0 mb-4 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="assets/img/jalur/cangar.jpg" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <h5 class="font-weight-normal">Pos Sumber Brantas</h5>
                <p>Jl. Raya Sumber Brantas No.246, Sumber Brantas, Kec. Bumiaji, Kota Batu, Jawa Timur</p>
                <a href="assets/img/jalur/cangar.pdf" target="_blank" class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Download</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-lg-0 mb-4 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="assets/img/jalur/tretes.jpg" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <h5 class="font-weight-normal">Pos Tretes</h5>
                <p>Jl. Wilis 523 Tretes, Kec. Prigen, Kab. Pasuruan, Jawa Timur</p>
                <a href="assets/img/jalur/tretes.pdf" target="_blank" class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Download</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-lg-0 mb-4 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="assets/img/jalur/tambaksari.jpg" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <h5 class="font-weight-normal">Pos Tambaksari</h5>
                <p>Tambakwatu, Tambak Sari, Kec. Purwodadi, Kab. Pasuruan, Jawa Timur</p>
                <a href="assets/img/jalur/tambaksari.pdf" target="_blank" class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Download</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-lg-0 mb-4 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="assets/img/jalur/lawang.jpg" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <h5 class="font-weight-normal">Pos Lawang</h5>
                <p>Wonorejo, Kec. Lawang, Kabupaten Malang, Jawa Timur</p>
                <a href="assets/img/jalur/lawang.pdf" target="_blank" class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Download</a>
              </div>
            </div>
          </div>
          <!-- <div class="col-lg-4 mb-lg-0 mb-4 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="assets/img/jalur/avenza.jpg" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <h5 class="font-weight-normal">Maps Avenza Offline</h5>
                <p>Offline maps semua jalur pendakian. Peta dapat digunakan di aplikasi <b>AVENZA</b> di playstore. </p>
                <a href="assets/img/jalur/avenza.pdf" target="_blank" class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Download</a>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </section>

    <!-- MAPS -->
    <section class="py-7">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mx-auto text-center">
            <h2 class="mb-0">Maps</h2>
            <p class="lead">
              Lokasi Pos Pendakian Gunung Arjuno Welirang, Pundak, Watu Jengger
            </p>
          </div>
        </div>
        <div class="row mt-6">
          <div class="col-lg-12">
            <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1B7HBcUAhf5vjJw6QezvYESEV8rEJifKB" width="100%" height="600"></iframe>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT US -->
    <section class="py-7">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mx-auto text-center">
            <h2>Kontak Kami</h2>
            <p class="font-weight-normal">Jika ada pertanyaan silahkan hubungi kami</p>
          </div>
        </div>
        <div class="row mt-6">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="row">
                <div class="col-lg-4 d-flex">
                  <div class="bg-gradient-dark mt-n5 mb-3 ms-lg-3 border-radius-md">
                    <div class="card-body p-5 position-relative">
                      <h3 class="text-white">Kontak Kantor</h3>
                      <div class="d-flex p-2 text-white">
                        <i class="material-icons text-sm">call</i>
                        <span class="text-sm opacity-8 ps-3">(0341) 483254</span>
                      </div>
                      <div class="d-flex p-2 text-white">
                        <i class="material-icons text-sm">email</i>
                        <span class="text-sm opacity-8 ps-3">tahuraradensoerjo @gmail.com</span>
                      </div>
                      <div class="d-flex p-2 text-white">
                        <i class="material-icons text-sm">location_on</i>
                        <span class="text-sm opacity-8 ps-3">Jl. Simpang Panji Suroso Kav. 144, Arjosari, Blimbing, Malang</span>
                      </div>
                      <div class="mt-4">
                        <a type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" href="https://www.instagram.com/tahuraradensoerjo.official/" target="_blank">
                          <i class="fab fa-instagram"></i>
                        </a>
                        <a type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" href="https://www.instagram.com/upttahuraradensoerjo/" target="_blank">
                          <i class="fab fa-instagram"></i>
                        </a>
                        <a type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" href="https://twitter.com/RadenTahura" target="_blank">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card-body position-relative">
                    <div class="row">
                      <div class="col-md-12">
                        <h5>Admin</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Amiruzzuhhad Gunes - 085156579564 (<span style="color:red">chat only</span>) </span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h5 class="mt-3">Pos Tretes</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Rudiono - 081330787722</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Mujianto - 089661413345</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Kasiyanto - 081336889910</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Wahyu Rama Dhoni - 08973854949</span>
                        </div>
                        <h5 class="mt-4">Pos Sumberbrantas</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Eko Budiono - 082234604229</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Dadang Suhendro - 082257496114</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Sudarmanto - 085336983164</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Rudi Siswanto - 081358832678</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h5 class="mt-4">Pos Tambaksari</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Nur Yusuf - 082245814672</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Talis - 085606589978</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Eko Nur Hasan - 085895660666</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Karyadi - 081331330207</span>
                        </div>
                        <h5 class="mt-4">Pos Lawang</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Muhamad Junaedi - 081554432204</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Khairul Anam - 082231518172</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Arif Yuwono - 081331834646</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Roni Sulianto - 082244447790</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h5 class="mt-4">Gunung Pundak</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Wahyu - 085855731963</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Wandik - 085843255053</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h5 class="mt-4">Watu Jengger</h5>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Bagus - 08563474247</span>
                        </div>
                        <div class="d-flex ps-0">
                          <i class="material-icons text-sm">call</i>
                          <span class="ps-3">Heri - 081336716003</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

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

    <script type="text/javascript">
      if (document.getElementById('state1')) {
        const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
        if (!countUp.error) {
          countUp.start();
        } else {
          console.error(countUp.error);
        }
      }
      if (document.getElementById('state2')) {
        const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
        if (!countUp1.error) {
          countUp1.start();
        } else {
          console.error(countUp1.error);
        }
      }
      if (document.getElementById('state3')) {
        const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
        if (!countUp2.error) {
          countUp2.start();
        } else {
          console.error(countUp2.error);
        };
      }
      $(window).load(function(){        
         $('#exampleModalNotification').modal('show');
      }); 
    </script>
  </body>

<!-- Modal -->
<div class="modal fade" id="exampleModalSignup" tabindex="-1" aria-labelledby="exampleModalSignup" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-body pb-3 mt-3">
                        <form role="form text-start" method="post" action="cek_kobok.php" autocomplete="off">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Kode Booking</label>
                                <input type="text" class="form-control" name="kode" required>
                                <?php
                                    $status_login = false;
                                    if (isset($_SESSION['uuid'])) {
                                        $status_login = true;
                                    }
                                ?>
                                <input type="hidden" class="form-control" name="status_login" value="<?php echo $status_login; ?>">
                            </div>
                            <div class="text-center">
                                <button class="btn bg-gradient-info w-100 mt-3 mb-0">cek status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Modal -->
<!--   <div class="modal fade" id="exampleModalNotification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="heading text-primary"> Khusus pendakian gunung Arjuno Welirang pada tanggal 27-28 Mei 2023, registrasi dilakukan dengan klik flyer di bawah. </h4>
        </div>
        <div class="modal-body">
          <a href="https://bit.ly/HikingArjuna" target="_blank"><img src="assets/img/ss.jpg" style="width: 100%; display: block; margin: 0 auto;"></a>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->
  
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

  <?php 
    if(isset($_GET['pesan'])){
      if($_GET['pesan'] == "gagal"){
        echo '
          <div class="modal fade" id="exampleModalNotification" tabindex="-1" aria-labelledby="exampleModalNotification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
              <div class="modal-content bg-gradient-danger">
                <div class="modal-body">
                  <div class="py-3 text-center text-white">
                    <i class="material-icons text-3xl">notifications_active</i>
                    <p class="text-white opacity-8">Kode Booking Tidak Ditemukan</p>
                  </div>
                </div>
                <hr class="horizontal light mb-0">
                <div class="modal-footer justify-content-between border-0">
                  <button type="button" class="btn btn-link text-white my-1" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#exampleModalSignup">Close</button>
                </div>
              </div>
            </div>
          </div>
        ';
      }
    }
  ?>
</body>
</html>
</html>