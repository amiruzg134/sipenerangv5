<?php 
  include 'config.php';
  $sql 			= mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_nomor = '$_GET[id]'");
  $row 			= mysqli_fetch_array($sql);
  $anggota 	= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(ap_pendakian)+1 as jml FROM tb_anggota_pendakian WHERE ap_pendakian = '$row[pd_id]'"));
  $bln 			= date('M', strtotime($row['pd_tanggal_registrasi']));
  $tgl 			= date('j', strtotime($row['pd_tanggal_registrasi']));
  $thn 			= date('Y', strtotime($row['pd_tanggal_registrasi']));
  $h 				= date('H:i:s', strtotime($row['pd_tanggal_registrasi']));
?>

<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
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
  <meta property="og:image" content='assets/img/gunung.jpg'/>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="./assets/css/material-kit-pro.min.css?v=3.0.2" rel="stylesheet" />

  <link href="assets/css/sweetalert2.min.css">

  <style>
    .async-hide { opacity: 0 !important}
    .files {
      visibility: hidden;
      position: absolute;
      margin: 0;
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
		                Tutorial Booking
		              </a>
		            </li>
		            <li class="nav-item dropdown dropdown-hover mx-2">
		              <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="tutorpembayaran.php">
		                Tutorial Pembayaran
		              </a>
		            </li>
		          </ul>
		        </div>
		      </div>
		    </nav>
		  </div>
		</div>
	</div>

	<section class="pt-3 pt-md-5 pb-md-5 pt-lg-8 bg-gray-200">
	  <div class="container">
	    <div class="row">
	      <div class="col-lg-12 mb-lg-0 mb-5 mt-8 mt-md-5 mt-lg-0">
	        <div class="card shadow-lg mb-5">
	          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
	            <div class="bg-gradient-primary shadow-primary border-radius-lg p-3">
	              <h4 class="text-white mb-0">Status Booking</h4>
	            </div>
	          </div>
	          <div class="card-body p-5 table-responsive">
	            <table class="table table-hover">
	            	<tr>
	            		<td width="25%">Status</td>
	            		<td width="1%">:</td>
	            		<td><b id="sts" style="text-transform: uppercase;" class="text-primary"></b></td>
	            	</tr>
	            	<tr>
	            		<td>Bank Tujuan</td>
	            		<td>:</td>
	            		<td>Bank Jatim/BPD Jatim</td>
	            	</tr>
	            	<tr>
	            		<td>No. Virtual Account</td>
	            		<td>:</td>
	            		<td><?php echo $row['va'] ?></td>
	            	</tr>
	            	<tr>
	            		<td>Total Tagihan</td>
	            		<td>:</td>
	            		<td><?php echo 'Rp. '.number_format($row['biaya'],0,",",".") ?></td>
	            	</tr>
	            	<tr>
	            		<td>Sisa Waktu Pembayaran</td>
	            		<td>:</td>
	            		<td><b id="demo" class="text-primary"></b></td>
	            	</tr>
	            	<tr>
	            		<td>Kode Booking</td>
	            		<td>:</td>
	            		<td><b><?php echo $row['pd_nomor']?></b></td>
	            	</tr>
	            	<tr>
	            		<td>Nama Ketua</td>
	            		<td>:</td>
	            		<td><?php echo $row['pd_nama_ketua']?></td>
	            	</tr>
	            	<tr>
	            		<td>Jumlah Rombongan</td>
	            		<td>:</td>
	            		<td><?php echo $anggota['jml'].' orang'?></td>
	            	</tr>
	            	<tr>
	            		<td>Tujuan</td>
	            		<td>:</td>
	            		<td><?php echo $row['keterangan']?></td>
	            	</tr>
	            	<tr>
	            		<td>Tanggal Naik</td>
	            		<td>:</td>
	            		<td><?php echo tgl_indo(date('Y-m-d', strtotime($row['pd_tgl_naik'])));?></td>
	            	</tr>
	            	<tr>
	            		<td>Tanggal Turun</td>
	            		<td>:</td>
	            		<td><?php echo tgl_indo(date('Y-m-d', strtotime($row['pd_tgl_turun'])));?></td>
	            	</tr>
	            </table>
            	<?php 
            		if ($row['pd_status'] == 'menunggu pembayaran') { ?>
	            		<table class="table">
	            			<tr>
	            				<td>
		                		<h6 class="text-center text-sm mb-0">Jika sudah melakukan pembayaran silahkan klik tombol di bawah.</h6>
		                	</td>
	            			</tr>
		                <tr>
		                  <td>
		                  	<input type="hidden" name="nomor" id="nomor" value="<?php echo $row['pd_id'] ?>">
		                    <button class="btn btn-rounded bg-gradient-warning me-2 btn-lg" style="width: 100%" id="bayar">saya sudah bayar</button>
		                  </td>
		                </tr>
              		</table>
            		<?php }
            	?>
              <table class="table table-bordered">
	              <tbody>
	                <?php
	                  if ($row['pd_status'] == 'disetujui') { ?>
                      <tr>
                        <th class="text-center" colspan="4">
                          <div class="file-box" style="margin: 20px auto; float: none;">
                            <div class="file" style="margin: unset;">
                              <?php
                                  if ($row['keterangan'] == 'pundak') { ?>
                                    <a href="berkas_pundak.php?id=<?php echo $row['pd_id'] ?>" target="_blank">
                                      <i class="fa fa-file-pdf-o fa-5x" style="color: #0099CC"></i>
                                      <div class="file-name text-center">
                                          Berkas eSimaksi.pdf
                                      </div>
                                    </a>
                                  <?php }
                                  elseif ($row['keterangan'] == 'arjuno') { ?>
                                    <a href="berkas_arjuno.php?id=<?php echo $row['pd_id'] ?>" target="_blank">
                                      <i class="fa fa-file-pdf-o fa-5x" style="color: #0099CC"></i>
                                      <div class="file-name text-center">
                                          Berkas eSimaksi.pdf
                                      </div>
                                    </a>
                                  <?php }
                                ?>
                            </div>
                          </div>
                        </th>
                      </tr>
	                  <?php } ?>
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</section>

  <section class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mb-lg-0 mb-5 mt-md-5 mt-lg-0">
          <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-primary shadow-primary border-radius-lg p-4">
                <h4 class="text-white mb-0">Panduan Pembayaran</h4>
              </div>
            </div>
            <div class="accordion p-3" id="accordionRental">
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingOne">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Pembayaran Melalui Bank Jatim
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Pada ATM Bank Jatim, pilih menu Pembayaran</li>
                          <li>Pilih lainnya</li>
                          <li>Pilih Virtual Account</li>
                          <li>Masukkan nomor Bank Jatim Virtual Account</li>
                          <li>Lakukan konfirmasi pembayaran anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking Bank Jatim
                        <ul>
                          <li>Login ke aplikasi mobile banking JConnect Mobile</li>
                          <li>Pilih menu Bayar</li>
                          <li>Pilih menu Virtual Account</li>
                          <li>Pilih Virtual Account</li>
                          <li>Masukkan Nomor Virtual Account</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingTwo">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Pembayaran Melalui Bank Mandiri
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Masukkan kartu di mesin ATM Bank Mandiri</li>
                          <li>Masukkan PIN anda</li>
                          <li>Pilih Transaksi Lainnya</li>
                          <li>Pilih Transfer</li>
                          <li>Pilih Antar Bank</li>
                          <li>Masukkan Kode Bank Jatim 114 + nomor Rekening Virtual Account</li>
                          <li>Masukkan jumlah transfer sesuai dengan nominal tagihan</li>
                          <li>Lakukan konfirmasi pembayaran</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking 
                        <ul>
                          <li>Login ke aplikasi mobile banking Livin' by Mandiri</li>
                          <li>Pilih menu Transfer</li>
                          <li>Pilih Transfer ke Penerima Baru</li>
                          <li>Pilih bank BPD Jatim</li>
                          <li>Masukkan Nomor Virtual Account sebagai nomor rekening tujuan</li>
                          <li>Masukkan Nominal Transfer sesuai dengan tagihan</li>
                          <li>Pilih metode transfer Transfer Online</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingThree">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Pembayaran Melalui Bank BCA
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Masukkan kartu di mesin ATM Bank BCA</li> 
                          <li>Masukkan PIN anda</li>
                          <li>Pilih Transaksi Lainnya</li>
                          <li>Pilih Transfer</li>
                          <li>Pilih Ke Rekening Bank Lain</li>
                          <li>Masukkan Kode Bank Jatim 114 + Nomor Rekening Virtual Account</li>
                          <li>Masukkan Nominal Transfer sesuai dengan nominal tagihan</li>
                          <li>Lakukan konfirmasi pembayaran</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking 
                        <ul>
                          <li>Login ke aplikasi mobile banking BCA mobile</li>
                          <li>Pilih menu m-Transfer</li>
                          <li>Pilih menu Daftar Transfer - Antar Bank</li>
                          <li>Pilih bank Bank Jatim</li>
                          <li>Masukkan Nomor Virtual Account sebagai nomor rekening tujuan</li>
                          <li>Masukkan PIN anda</li>
                          <li>Pilih menu Transfer - Antar Bank</li>
                          <li>Pilih bank Bank Jatim</li>
                          <li>Pilih rekening tujuan sesuai nomor Virtual Account</li>
                          <li>Masukkan jumlah uang sesuai Nominal Tagihan</li>
                          <li>Pilih layanan transfer Realtime Online</li>
                          <li>Klik Kirim</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingFifth">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
                    Pembayaran Melalui Bank BRI
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseFifth" class="accordion-collapse collapse" aria-labelledby="headingFifth" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Masukkan kartu di mesin ATM Bank BRI</li> 
                          <li>Masukkan PIN anda</li>
                          <li>Pilih Menu Lainnya</li>
                          <li>Pilih menu Transfer</li>
                          <li>Masukkan Kode Bank Jatim 114 + Nomor Rekening Virtual Account</li>
                          <li>Masukkan Nominal Transfer sesuai dengan nominal tagihan</li>
                          <li>Lakukan konfirmasi pembayaran</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking 
                        <ul>
                          <li>Login ke aplikasi mobile banking BRImo</li>
                          <li>Pilih menu Transfer</li>
                          <li>Pilih Tambah Daftar Baru</li>
                          <li>Pilih Bank Tujuan Bank Jatim</li>
                          <li>Masukkan Nomor Virtual Account sebagai nomor rekening tujuan</li>
                          <li>Masukkan Nominal Transfer sesuai dengan nominal tagihan</li>
                          <li>Pilih metode transfer Transfer Online</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingSixth">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixth" aria-expanded="false" aria-controls="collapseSixth">
                    Pembayaran Melalui Bank Cimb Niaga
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseSixth" class="accordion-collapse collapse" aria-labelledby="headingSixth" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Masukkan kartu di mesin ATM Bank CIMB NIAGA</li> 
                          <li>Masukkan PIN anda</li>
                          <li>Pilih Transfer</li>
                          <li>Pilih Bank Lain</li>
                          <li>Masukkan Kode Bank Jatim 114 + Nomor Rekening Virtual Account</li>
                          <li>Masukkan Nominal Transfer sesuai dengan nominal tagihan</li>
                          <li>Lakukan konfirmasi pembayaran</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking 
                        <ul>
                          <li>Login ke aplikasi mobile banking OCTO Mobile</li>
                          <li>Pilih menu Transfer</li>
                          <li>Pilih Transfer ke Bank Lainnya</li>
                          <li>Pilih Bank Tujuan Bank Jatim</li>
                          <li>Masukkan Nomor Virtual Account sebagai nomor rekening tujuan</li>
                          <li>Masukkan Nominal Transfer sesuai dengan tagihan</li>
                          <li>Pilih metode transfer Online</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-3">
                <h5 class="accordion-header" id="headingSeven">
                  <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    Pembayaran Melalui Bank Lainnya
                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                  </button>
                </h5>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionRental">
                  <div class="accordion-body text-sm opacity-8">
                    <ol>
                      <li>
                        Melalui Transfer ATM 
                        <ul>
                          <li>Masukkan kartu di mesin ATM</li> 
                          <li>Masukkan PIN anda</li>
                          <li>Pilih Transfer</li>
                          <li>Pilih Bank Lain</li>
                          <li>Masukkan Kode Bank Jatim 114 + Nomor Rekening Virtual Account</li>
                          <li>Masukkan Nominal Transfer sesuai dengan nominal tagihan</li>
                          <li>Lakukan konfirmasi pembayaran</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                      <li class="mt-3">
                        Melalui Mobile Banking 
                        <ul>
                          <li>Login ke aplikasi mobile banking</li>
                          <li>Pilih menu Transfer</li>
                          <li>Pilih Transfer ke Bank Lainnya</li>
                          <li>Pilih Bank Tujuan Bank Jatim</li>
                          <li>Masukkan Nomor Virtual Account sebagai nomor rekening tujuan</li>
                          <li>Masukkan Nominal Transfer sesuai dengan tagihan</li>
                          <li>Pilih metode transfer Realtime/Transfer Online</li>
                          <li>Masukkan PIN anda</li>
                          <li>Transaksi selesai</li>
                        </ul>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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

    <script src="./assets/js/plugins/sweetalert2.all.min.js"></script>

  </body>

    <?php
      if ($row['pd_status'] == 'menunggu pembayaran') { ?>
        <script>
          // Set the date we're counting down to
          var countDownDate = new Date("<?php echo $bln.' '.$tgl.', '.$thn.' '.$h; ?>").getTime()+(6*60*60*1000);

          // Update the count down every 1 second
          var x = setInterval(function() {

            // Get today's date and time
            var now = new Date();
            // var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element
            document.getElementById("sts").innerHTML = "<?php echo $row['pd_status']?>";
            document.getElementById("demo").innerHTML = hours + " jam " + minutes + " menit " + seconds + " detik ";
              
            var id = "<?php echo $row['pd_id'];?>";

            // If the count down is finished, write some text
            if (distance < 0) {
              clearInterval(x);
              document.getElementById("demo").innerHTML = "<span style='color:red'>" + "EXPIRED" + "</span>";
              $.ajax({
                  url: 'habis.php',
                  data: {id:id},
                  type: "POST"
              });
              document.getElementById("sts").innerHTML = "expired";
              window.location.reload();

            }

            if (distance > 0) {
              $.ajax({
                url: 'cek_status.php',
                type: "POST",
                data: {id:id},
                success: function(response) {
                  if (response == 0) {
                    clearInterval(x);
                    document.getElementById("sts").innerHTML = "<?php echo $row['pd_status']?>";
                  } 
                }
              });
            } 
          }, 1000);
        </script>
      <?php }
      else { ?>
        <script>
          document.getElementById("sts").innerHTML = "<?php echo $row['pd_status']?>";
        </script>
      <?php }
    ?>

    <script type="text/javascript">
      $(document).on('click', '#bayar', function () {
        var nomor = $('#nomor').val();   
        $.ajax({
            url: "upbuktibayar.php",
            type: "POST",
            data: { nomor : nomor },
            success: function(response){
              if(response == 1){
                Swal.fire({
                  allowOutsideClick: false,
									allowEscapeKey: false,
                  icon : 'success',
                  title : 'Berhasil!',
                  text : 'Verifikasi pembayaran maksimal 1x24 jam',
                  confirmButtonText: '<a href="statusbooking.php?id=<?php echo $_GET['id'] ?>" style="color:white"> OK </a>' 
                })
              }
            }
        });
      });
    </script>

</html>
