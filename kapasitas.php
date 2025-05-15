<?php 
  session_start();
  include 'config/connection.php';
  include 'config.php';
  $token_user = $_SESSION['token'];

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

    .ui-datepicker {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    /* Tanggal default */
    .ui-datepicker td span.ui-state-default,
    .ui-datepicker td a.ui-state-default {
        display: block;
        text-align: center;
        padding: 5px;
        margin: auto;
        position: relative;
    }

    /* Tanggal dengan kuota diberi warna hijau */
    .highlight {
        background-color: #d4edda !important;
        color: #bff4ab !important;
    }

    .highlight0::after,
    .ui-datepicker td span.ui-state-default::after,
    .ui-datepicker td a.ui-state-default::after {
        content: attr(title); /* Menampilkan teks dari atribut title */
        display: block;
        font-size: 10px;
        color: #6c757d;
        background: #fcab2c;
        margin-top: 2px;
        text-align: center;
    }

    /* Blok kuota di dalam tanggal */
    .highlight::after,
    .ui-datepicker td span.ui-state-default::after,
    .ui-datepicker td a.ui-state-default::after {
        content: attr(title); /* Menampilkan teks dari atribut title */
        display: block;
        font-size: 10px;
        color: #6c757d;
        background: #bff4ab;
        margin-top: 2px;
        text-align: center;
    }

    /* Tanggal tanpa kuota atau kuota = 0 */
    .ui-datepicker td span.ui-state-default[title="Kuota: 0"],
    .ui-datepicker td a.ui-state-default[title="Kuota: 0"] {
        color: #adb5bd !important; /* Warna teks lebih redup */
    }

    /* Highlight tanggal yang dipilih */
    .ui-datepicker .ui-state-active {
        background-color: #0056b3 !important;
        color: white !important;
        z-index: 9999 !important; /* Pastikan datepicker memiliki z-index tinggi */
        position: absolute; /* Supaya menyesuaikan posisi secara tepat */
    }

    .form-control#gunung, .form-control#pos{
        padding: .3rem 1rem;
    }

    .kolom .form-control{
        padding: .5rem 1rem;
    }
  </style>
</head>

<body class="presentation-page bg-gray-200">

	<div class="container position-sticky top-0" style="z-index: 3; background: white;">
		<div class="row">
		  <div class="col-12">
		    <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
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
		<div class="page-header min-vh-50" style="background-image: url('assets/img/pundak.jpg');">
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

    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6" id="div_informasi" style="display: none;">
        <div class="container">
            <div class="row border-radius-md pb-4 mx-sm-0 mx-1 position-relative">
                <span class="text-primary text-center mt-3">Untuk dapat melakukan pemesanan tiket silahkan lengkapi data diri terlebih dahulu dengan klik tombol di bawah.</span>
                <button type='button' onclick='showModalVerifikasiAkun()' class="btn bg-gradient-primary mb-0 submit btn-rounded btn-lg mt-3 mb-3">Lengkapi Data</button>
                <p>Log :</p>
                <ul id="log_verification"> </ul>
            </div>
        </div>
    </div>

	<form autocomplete="off" method="post" action="">
		<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6" id="div_pemesanan" style="display: none;">
		  <div class="container mt-4">
		    <div class="row border-radius-md pb-4 mx-sm-0 mx-1 position-relative">
		    	<div class="col-lg-10">
		    		<div class="row">
                        <input type="hidden" id="max_date" name="max_date">
                        <div class="col-lg-4 mt-lg-n2 mt-2">
                            <label for="gunung">Gunung</label>
                            <select class="form-control" name="gunung" id="gunung" required>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-lg-2 mt-lg-n2 mt-2">
                            <label for="pos">Pos Pendakian</label>
                            <select class="form-control" name="pos" id="pos" required>
                                <option value="">- Pilih -</option>
                            </select>
                        </div>

                        <div class="col-lg-2 mt-lg-n2 mt-2">
                            <label class="ms-0">Jumlah Pendaki</label>
                            <div class="input-group input-group-static">
                                <input name="total_anggota" class="form-control" id="total_anggota" type="number" required>
                            </div>
                        </div>

				      <div class="col-lg-2 mt-lg-n2 mt-2">
				        <label class="ms-0">Tanggal Naik</label>
				        <div class="input-group input-group-static">
							<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					        <input name="start_date" class="form-control readonly" id="start_date" type="text" data-input required value="" placeholder="-- pilih --">
						</div>
				      </div>
				      <div class="col-lg-2 mt-lg-n2 mt-2">
				        <label class="ms-0">Tanggal Turun</label>
				        <div class="input-group input-group-static">
									<span class="input-group-text"><i class="fas fa-calendar"></i></span>
				        	<input name="end_date" class="form-control readonly" id="end_date" type="text" data-input required placeholder="-- pilih --">
								</div>
				      </div>
			    	</div>
                    <p class="mt-2">
                        <span id="informasi_tanggal" style="display: none;" class="text-primary"></span>
                        <span id="informasi_status_akun" style="display: none;" class="text-info"></span>
                    </p>
		    	</div>
		    	<div class="col-lg-2">
			      <div class="col-lg-12 mt-4">
			        <button type="submit" class="btn bg-gradient-primary mb-0 w-100" name="cek_kuota" id="cek_kuota">cek kuota</button>
			      </div>
		    	</div>
		    </div>
		  </div>
		</div>
	</form>

    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-4" id="status_user_verified" style="display: none;">
        <div class="container mt-4">
            <div class="row border-radius-md mx-sm-0 mx-1 position-relative">
                <button type='button' style='border-radius: 10px;' onclick='showModalVerifikasiAkun()' class='btn btn-info'>Verifikasi Akun</button>
                <span>
                    <p> Status Akun : <span id="status_akun_verified" style="font-weight: bold;"></span> </p>
                </span>
                <!-- <p>Log Verifikasi:</p> -->
                <ul id="log_user_verification">

                </ul>
            </div>
        </div>
    </div>

    <form action="" method="post">
        <section id="profile_pemesan" style="display: none;">
            <input type="hidden" id="token_user" name="token_user" value="<?php echo $token_user; ?>">
            <input type="hidden" id="ketua_is_wni" name="ketua_is_wni">
            <input type="hidden" id="umur_ketua" name="umur_ketua">
            <input type="hidden" id="tb_pos_pendakian_id" name="tb_pos_pendakian_id">
            <input type="hidden" id="tb_gunung_id" name="tb_gunung_id">
            <input type="hidden" id="tb_start_date" name="tb_start_date">
            <input type="hidden" id="tb_end_date" name="tb_end_date">

            <div class="col-lg-9 col-12 mt-4 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Data Ketua Pendaki</h6>
                                </div>
                                <span>
                                    <span class="text-primary text-sm">Data pendaki secara otomatis terisi dari data profil login anda.</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body kolom">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label mt-4">Nama Depan</label>
                                            <div class="input-group">
                                                <input class="form-control input-border" type="text" name="first_name" id="first_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="form-label mt-4">Nama Belakang</label>
                                                <div class="input-group">
                                                    <input class="form-control input-border" type="text" name="last_name" id="last_name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <label class="form-label mt-4">Nomor Identitas <small id="id_card_type"></small></label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text"  name="id_card_number" id="id_card_number" value="" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label mt-4">Tempat Lahir</label>
                                            <div class="input-group">
                                                <input class="form-control input-border" type="text" id="place_birth" name="place_birth" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="form-label mt-4">Tanggal Lahir</label>
                                                <div class="input-group">
                                                    <input class="form-control input-border" type="text" name="date_birth" id="date_birth" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="form-label mt-4">No. Telepon</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" name="phone" id="phone" readonly>
                                    </div>
                                    <label class="form-label mt-4">Email</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="email" name="email" readonly>
                                    </div>
                                    <label class="form-label mt-4">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="gender" name="gender" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label mt-4">Alamat</label>
                                    <div class="input-group">
                                        <textarea class="form-control input-border" style="height: 50px;border-radius: 5px;" type="text" id="address" name="address" readonly></textarea>
                                    </div>

                                    <label class="form-label mt-4" style="margin-top: 15px !important;">Provinsi</label>
                                    <input type="hidden" name="province_code" id="province_code">
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" name="province_name" id="province_name" readonly>
                                    </div>

                                    <input type="hidden" id="city_code" name="city_code">
                                    <label class="form-label mt-4">Kabupaten/Kota</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="city_name" name="city_name" readonly>
                                    </div>
                                    <input type="hidden" id="district_code" name="district_code">
                                    <label class="form-label mt-4">Kecamatan</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="district_name" name="district_name" readonly>
                                    </div>
                                    <input type="hidden" id="village_code" name="village_code">
                                    <label class="form-label mt-4">Desa/Kelurahan</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="village_name" name="village_name" readonly>
                                    </div>
                                    <input type="hidden" id="is_wni" name="is_wni">
                                    <label class="form-label mt-4">Kewarganegaraan</label>
                                    <div class="input-group">
                                        <input class="form-control input-border" type="text" id="data_wni" name="data_wni" readonly>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="respon_anggota" style="display: none;">
            <div class="col-lg-9 col-12 mt-4 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Data Anggota</h6>
                                </div>
                                <span>
                                    <span class="text-primary text-sm">Masukkan email anggota yang sudah terdaftar di website booking atau aplikasi Tiket Pendakian. Jika belum memiliki akun, silahkan daftar terlebih dahulu.</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body" id="form_anggota">
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="detail_kamera" style="display: none;">
            <div class="col-lg-9 col-12 mt-4 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Penggunaan Kamera</h6>
                                </div>
                                <span>
                                    <span class="text-primary text-sm">Masukkan jumlah kamera yang anda bawa.</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">   
                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="ms-0">Kamera Pendaki WNI</label>
                                    <div class="input-group input-group-static">
                                        <input name="camwni" id="camwni" class="form-control" type="number" min="0" value="0" required placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="ms-0">Kamera Pendaki WNA</label>
                                    <div class="input-group input-group-static">
                                        <input name="camwna" id="camwna" class="form-control" type="number" min="0" value="0" required placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="respon_summary" style="display: none;">
            <div class="col-lg-9 col-12 mt-4 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Rincian Biaya</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <ul id="summary">

                                    </ul>
                                </div>
                                <div class="col-lg-4 my-auto" style="text-align: center;">
                                    <h6 class="mt-sm-4 mt-0 mb-0">Total Tagihan Pembayaran</h6>
                                    <h1 class="mt-0">
                                        <span id="summary_total_bayar"></span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="div_metode_pembayaran" style="display: none;">
            <div class="col-lg-9 col-12 mt-4 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div id="div_informasi_surat_izin" style="display: none; margin-top: 10px !important;">
                                <span style="font-weight: bold;" class="text-danger">Informasi : </span><br>
                                <span class="text-danger">
                                    Khusus pendaki Gunung Arjuno Welirang usia kurang dari 17 tahun wajib menunjukkan surat izin dari orangtua/wali
                                </span>
                                <ul id="list_dibawah_umur" class="text-dark"></ul>
                                <a href="surat_izin.pdf" target="_blank" class="btn btn-info">Download Surat Izin</a>
                            </div>

                            <div class="form-group" style="margin-top: 20px;">
                                <label class="col-sm-4 control-label" style="font-weight: bold;">Pilih Metode Pembayaran: </label>
                                <div class="col-sm-12">
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control"
                                            style="background: #f2f2f2;padding: 10px;margin-bottom: 10px;">
                                        <option disabled selected> -- Pilih Pembayaran -- </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="col-lg-9 col-12 mt-4 mx-auto">
            <div class="container">
                <div class="d-flex justify-content-end">
                    <button style="display: none;" type="button" name="checkout" id="checkout" class="btn bg-gradient-primary w-100 mb-0">
                        <span id="btn-text-proses">Booking</span>
                        <div class="spinner-border spinner-border-sm" role="status" id="loading" style="display: none;">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </form>


    <!-- Modal -->
    <div class="modal" id="myModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title">Detail Anggota</strong>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mt-4" style="margin-top: 10px !important;">Nama:</label>
                            <div class="input-group" style="margin-top: -10px;margin-left: 5px;">
                                <span style="font-weight: bold" id="review_name"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Nomor Identitas <small id="review_id_card_type"></small></label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_id_card_number"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Ttg:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_ttg"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">No. Telepon:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_phone"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Email:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_email"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Jenis Kelamin:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_gender"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mt-4" style="margin-top: 10px !important;">Alamat:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_address"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Provinsi:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_province_name"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Kabupaten/Kota:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_city_name"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Kecamatan:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_district_name"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Desa/Kelurahan:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_village_name"></span>
                            </div>

                            <label class="form-label mt-4" style="margin-top: 10px !important;">Kewarganegaraan:</label>
                            <div class="input-group">
                                <span style="font-weight: bold; margin-top: -10px;margin-left: 5px;" id="review_data_wni"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 0px !important;height: 50px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="verifikasiakunFE" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Verifikasi Akun</h6>
                </div>
                <input type="hidden" id="url_path" name="url_path">
                <input type="hidden" id="status_pengajuan" name="status_pengajuan">
                <input type="hidden" id="is_enable_button_pengajuan" name="is_enable_button_pengajuan">
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <form id="form_verifikasi_disetujui" action="" method="post" enctype="multipart/form-data">
                            <p>Lengkapi data akun anda untuk dapat melakukan pemesanan tiket.</p>
                            <button type="button" class="btn bg-gradient-info btn-block mb-3" id="btn_verifikasi_pengajuan">
                                Lengkapi data
                            </button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 0px !important;height: 50px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal_verifikasi_akun">Close</button>
                </div>
            </div>
        </div>
    </div>


    <input type="hidden" id="is_verified_user" name="is_verified_user">
    <input type="hidden" id="log_verified_user" name="log_verified_user">
    <input type="hidden" id="verified_user_status" name="verified_user_status">

    <input type="hidden" id="data_anggota1" name="data_anggota1">
    <input type="hidden" id="data_anggota2" name="data_anggota2">
    <input type="hidden" id="data_anggota3" name="data_anggota3">
    <input type="hidden" id="data_anggota4" name="data_anggota4">
    <input type="hidden" id="data_anggota5" name="data_anggota5">
    <input type="hidden" id="data_anggota6" name="data_anggota6">
    <input type="hidden" id="data_anggota7" name="data_anggota7">
    <input type="hidden" id="data_anggota8" name="data_anggota8">
    <input type="hidden" id="data_anggota9" name="data_anggota9">

    <input type="hidden" id="save_total_anggota" name="save_total_anggota">

    <input type="hidden" id="save_kw_anggotake1" name="save_kw_anggotake1">
    <input type="hidden" id="save_email_anggotake1" name="save_email_anggotake1">
    <input type="hidden" id="save_umur_anggotake1" name="save_umur_anggotake1">

    <input type="hidden" id="save_kw_anggotake2" name="save_kw_anggotake2">
    <input type="hidden" id="save_email_anggotake2" name="save_email_anggotake2">
    <input type="hidden" id="save_umur_anggotake2" name="save_umur_anggotake2">

    <input type="hidden" id="save_kw_anggotake3" name="save_kw_anggotake3">
    <input type="hidden" id="save_email_anggotake3" name="save_email_anggotake3">
    <input type="hidden" id="save_umur_anggotake3" name="save_umur_anggotake3">

    <input type="hidden" id="save_kw_anggotake4" name="save_kw_anggotake4">
    <input type="hidden" id="save_email_anggotake4" name="save_email_anggotake4">
    <input type="hidden" id="save_umur_anggotake4" name="save_umur_anggotake4">

    <input type="hidden" id="save_kw_anggotake5" name="save_kw_anggotake5">
    <input type="hidden" id="save_email_anggotake5" name="save_email_anggotake5">
    <input type="hidden" id="save_umur_anggotake5" name="save_umur_anggotake5">

    <input type="hidden" id="save_kw_anggotake6" name="save_kw_anggotake6">
    <input type="hidden" id="save_email_anggotake6" name="save_email_anggotake6">
    <input type="hidden" id="save_umur_anggotake6" name="save_umur_anggotake6">

    <input type="hidden" id="save_kw_anggotake7" name="save_kw_anggotake7">
    <input type="hidden" id="save_email_anggotake7" name="save_email_anggotake7">
    <input type="hidden" id="save_umur_anggotake7" name="save_umur_anggotake7">

    <input type="hidden" id="save_kw_anggotake8" name="save_kw_anggotake8">
    <input type="hidden" id="save_email_anggotake8" name="save_email_anggotake8">
    <input type="hidden" id="save_umur_anggotake8" name="save_umur_anggotake8">

    <input type="hidden" id="save_kw_anggotake9" name="save_kw_anggotake9">
    <input type="hidden" id="save_email_anggotake9" name="save_email_anggotake9">
    <input type="hidden" id="save_umur_anggotake9" name="save_umur_anggotake9">

    <input type="hidden" id="save_kw_anggotake10" name="save_kw_anggotake10">
    <input type="hidden" id="save_email_anggotake10" name="save_email_anggotake10">
    <input type="hidden" id="save_umur_anggotake10" name="save_umur_anggotake10">

    <!-- FOOTER -->
    <footer class="footer pt-5 mt-5">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="text-center">
                <p class="text-dark my-4 text-sm font-weight-normal">
                  All rights reserved. © 2019
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
    <script src="./assets/js/material-kit-pro.min.js?v=3.0.2" type="text/javascript"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $.datepicker.regional['id'] = {
                closeText: 'Tutup',
                prevText: '&#x3C;mundur',
                nextText: 'maju&#x3E;',
                currentText: 'Hari ini',
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                dayNamesMin: ['Mi', 'Sn', 'Sl', 'Rb', 'Km', 'Ju', 'Sa'],
                weekHeader: 'Mg',
                dateFormat: 'dd-mm-yy', // Format tanggal Indonesia
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['id']);
        });



        $(document).ready(function() {

                var token_user = $('#token_user').val();
                $.ajax({
                    type    : "POST",
                    url     : "api/profile.php",
                    data    : {
                        token_user: token_user
                    },
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.error){
                            alert(json.message);
                        }else{
                            document.getElementById("is_verified_user").value = json.data.is_verified_account;
                            document.getElementById("verified_user_status").value = json.data.status_verified_account;

                            const logArray = json.data.log_verified
                            const jsonStringLog = JSON.stringify(logArray);
                            document.getElementById("log_verified_user").value = jsonStringLog;

                            if (json.data.is_complate){
                                var div_informasi = document.getElementById("div_informasi");
                                var div_pemesanan = document.getElementById("div_pemesanan");
                                div_informasi.style.display = "none";
                                div_pemesanan.style.display = "block";

                                document.getElementById("first_name").value = json.data.user.firstname;
                                document.getElementById("last_name").value = json.data.user.lastname;
                                document.getElementById("id_card_number").value = json.data.user.id_card_number;
                                document.getElementById("id_card_type").textContent= "("+json.data.user.id_card_type+")";
                                document.getElementById("place_birth").value = json.data.user.place_birth;
                                document.getElementById("date_birth").value = json.data.user.date_birth;
                                document.getElementById("phone").value = json.data.user.phone;
                                document.getElementById("email").value = json.data.user.email;
                                document.getElementById("gender").value = json.data.user.gender;

                                document.getElementById("address").value = json.data.user.location.address;
                                document.getElementById("province_code").value = json.data.user.location.province_code;
                                document.getElementById("province_name").value = json.data.user.location.province_name;
                                document.getElementById("city_code").value = json.data.user.location.city_code;
                                document.getElementById("city_name").value = json.data.user.location.city_name;
                                document.getElementById("district_code").value = json.data.user.location.district_code;
                                document.getElementById("district_name").value = json.data.user.location.district_name;
                                document.getElementById("village_code").value = json.data.user.location.village_code;
                                document.getElementById("village_name").value = json.data.user.location.village_name;
                                document.getElementById("umur_ketua").value = json.data.user.umur;

                                if(json.data.user.is_wni){
                                    document.getElementById("ketua_is_wni").value = 'wni';
                                    document.getElementById("is_wni").value = 'wni';
                                    document.getElementById("data_wni").value = "WNI";
                                }else{
                                    document.getElementById("ketua_is_wni").value = 'wna';
                                    document.getElementById("is_wni").value = 'wna';
                                    document.getElementById("data_wni").value = "WNA";
                                }

                                var divInformasiSuratIzin = document.getElementById("div_informasi_surat_izin");
                                var listDibawahUmur = $("#list_dibawah_umur");
                                listDibawahUmur.html("");
                                if(json.data.user.umur < 17){
                                    divInformasiSuratIzin.style.display = "block";
                                    var listSuratIzin = "";
                                    listSuratIzin += "<li>" + json.data.user.email + " memiliki umur "+json.data.user.umur+" tahun.</li>";
                                    listDibawahUmur.html(listSuratIzin);
                                } else {
                                    divInformasiSuratIzin.style.display = "none";
                                }

                            }else{
                                document.getElementById("status_pengajuan").value = json.status_pengajuan;
                                document.getElementById("is_enable_button_pengajuan").value = json.is_enable_button_pengajuan;
                                document.getElementById("url_path").value = json.data.path_verified;

                                //document.getElementById("status_akun").textContent= json.data.status_verified_account;
                                var div_informasi = document.getElementById("div_informasi");
                                var div_pemesanan = document.getElementById("div_pemesanan");
                                div_informasi.style.display = "block";
                                div_pemesanan.style.display = "none";
                                $.each(json.data.log_verified, function (key, value) {
                                    $('#log_verification').append("<li><strong>\Waktu: "+ value.waktu+"</strong>\
                                        <table class='table table-bordered' style='margin-top: 0.5rem;border: 0px solid #f0f8ff00;'>\
                                        <tr>\
                                        <td width='50'>Status:</td>\
                                        <td>"+value.status_verified_account+"</td>\
                                        </tr>\
                                        <tr>\
                                            <td width='50'>Catatan:</td>\
                                            <td>"+value.catatan+"</td>\
                                        </tr>\
                                        </table>\
                                        </li>");
                                })
                            }
                        }
                    }
                });
        });

        function showModalVerifikasiAkun(){
            var modal = document.getElementById("verifikasiakunFE");
            var close_modal = document.getElementById("close_modal_verifikasi_akun");

            modal.style.display = "block";

            close_modal.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }



        $("#btn_verifikasi_pengajuan").on("click",function(){
            var url_path = $('#url_path').val();
            var is_enable_button_pengajuan = $('#is_enable_button_pengajuan').val();
            var status_pengajuan = $('#verified_user_status').val();
            if (!is_enable_button_pengajuan){
                alert("Maaf anda tidak dapat melakukan pengajuan ulang, status akun anda saat ini : "+status_pengajuan)
            }else{
                window.location.href = url_path;
            }
        });



        $('#checkout').click(function () {
            var token_user      = $('#token_user').val();
            var first_name      = $('#first_name').val();
            var last_name       = $('#last_name').val();
            var id_card_number  = $('#id_card_number').val();
            var id_card_type    = $('#id_card_type').val();
            var place_birth     = $('#place_birth').val();
            var date_birth      = $('#date_birth').val();
            var phone           = $('#phone').val();
            var email           = $('#email').val();
            var gender          = $('#gender').val();
            var address         = $('#address').val();
            var province_code   = $('#province_code').val();
            var province_name   = $('#province_name').val();
            var city_code       = $('#city_code').val();
            var city_name       = $('#city_name').val();
            var district_code   = $('#district_code').val();
            var district_name   = $('#district_name').val();
            var village_code    = $('#village_code').val();
            var village_name    = $('#village_name').val();
            var is_wni          = $('#is_wni').val();
            var data_wni        = $('#data_wni').val();
            var tb_gunung_id    = $('#tb_gunung_id').val();
            var tb_pos_pendakian_id = $('#tb_pos_pendakian_id').val();
            var tb_start_date   = $('#tb_start_date').val();
            var tb_end_date     = $('#tb_end_date').val();

            var camwni     = $('#camwni').val();
            var camwna     = $('#camwna').val();

            var total_anggota   = $('#total_anggota').val();

            var email_anggotake1    = $('#save_email_anggotake1').val();
            var email_anggotake2    = $('#save_email_anggotake2').val();
            var email_anggotake3    = $('#save_email_anggotake3').val();
            var email_anggotake4    = $('#save_email_anggotake4').val();
            var email_anggotake5    = $('#save_email_anggotake5').val();
            var email_anggotake6    = $('#save_email_anggotake6').val();
            var email_anggotake7    = $('#save_email_anggotake7').val();
            var email_anggotake8    = $('#save_email_anggotake8').val();
            var email_anggotake9    = $('#save_email_anggotake9').val();

            var kw_anggotake1       = $('#save_kw_anggotake1').val();
            var kw_anggotake2       = $('#save_kw_anggotake2').val();
            var kw_anggotake3       = $('#save_kw_anggotake3').val();
            var kw_anggotake4       = $('#save_kw_anggotake4').val();
            var kw_anggotake5       = $('#save_kw_anggotake5').val();
            var kw_anggotake6       = $('#save_kw_anggotake6').val();
            var kw_anggotake7       = $('#save_kw_anggotake7').val();
            var kw_anggotake8       = $('#save_kw_anggotake8').val();
            var kw_anggotake9       = $('#save_kw_anggotake9').val();

            var metode_pembayaran = $('#metode_pembayaran').val();
            if (metode_pembayaran == null || metode_pembayaran == ""){
                alert("Pilih metode pembayaran anda");
                return false;
            }

            for(let i=1; i < total_anggota; i++){
                var text_anggota = `#email_anggotake${i}`;
                if ($(''+text_anggota+'').val() == null || $(''+text_anggota+'').val() == ""){
                    alert("Lengkapi data anggota anda");
                    return false;
                }
            }
            $.ajax({
                type    : "POST",
                url     : "core/checkout.php",
                data    : {
                    token_user: token_user,
                    first_name: first_name,
                    last_name: last_name,
                    id_card_number: id_card_number,
                    id_card_type: id_card_type,
                    place_birth: place_birth,
                    date_birth: date_birth,
                    phone: phone,
                    email: email,
                    gender: gender,
                    address: address,
                    province_code: province_code,
                    province_name: province_name,
                    city_code: city_code,
                    city_name: city_name,
                    district_code: district_code,
                    district_name: district_name,
                    village_code: village_code,
                    village_name: village_name,
                    is_wni: is_wni,
                    data_wni: data_wni,
                    tb_gunung_id: tb_gunung_id,
                    tb_pos_pendakian_id: tb_pos_pendakian_id,
                    tb_start_date: tb_start_date,
                    tb_end_date: tb_end_date,
                    camwni: camwni,
                    camwna: camwna,
                    total_anggota: total_anggota,
                    email_anggotake1: email_anggotake1,
                    email_anggotake2: email_anggotake2,
                    email_anggotake3: email_anggotake3,
                    email_anggotake4: email_anggotake4,
                    email_anggotake5: email_anggotake5,
                    email_anggotake6: email_anggotake6,
                    email_anggotake7: email_anggotake7,
                    email_anggotake8: email_anggotake8,
                    email_anggotake9: email_anggotake9,
                    kw_anggotake1: kw_anggotake1,
                    kw_anggotake2: kw_anggotake2,
                    kw_anggotake3: kw_anggotake3,
                    kw_anggotake4: kw_anggotake4,
                    kw_anggotake5: kw_anggotake5,
                    kw_anggotake6: kw_anggotake6,
                    kw_anggotake7: kw_anggotake7,
                    kw_anggotake8: kw_anggotake8,
                    kw_anggotake9: kw_anggotake9,
                    metode_pembayaran:metode_pembayaran
                },
                beforeSend: function() {
                    $('#btn-text-proses').hide()
                    $('#loading').show()
                    $('#checkout').prop('disabled', true)
                },
                complete: function() {
                    $('#btn-text-proses').show()
                    $('#loading').hide()
                    $('#checkout').prop('disabled', false)
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.error){
                        alert(json.message);
                    }else{
                        alert(json.message);
                        window.location = "status-trx.php?inv="+json.data;
                    }
                }
            });
            return false;
        });


        $(document).ready(function() {
            $('#cek_kuota').click(function () {

                document.getElementById("camwni").value = 0;
                document.getElementById("camwna").value = 0;

                var total_anggota = $('#total_anggota').val();
                var gunung = $('#gunung').val();
                var pos = $('#pos').val();
                var kewarganegaraan = $('#ketua_is_wni').val();
                var umur_ketua = $('#umur_ketua').val();
                var total_anggota = $('#total_anggota').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                $.ajax({
                    type    : "POST",
                    url     : "core/cek_tiket.php",
                    data    : {
                        gunung: gunung,
                        pos: pos,
                        kewarganegaraan: kewarganegaraan,
                        start_date: start_date,
                        end_date: end_date,
                    },
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.error){

                            var div_summary = document.getElementById("respon_summary");
                            var profile_pemesan = document.getElementById("profile_pemesan");
                            var div_anggota = document.getElementById("respon_anggota");
                            var div_button = document.getElementById("checkout");
                            var div_pembayaran = document.getElementById("div_metode_pembayaran");

                            div_summary.style.display = "none";
                            profile_pemesan.style.display = "none";
                            div_anggota.style.display = "none";
                            div_button.style.display = "none";
                            div_pembayaran.style.display = "none"

                            var detail_kamera = document.getElementById("detail_kamera");
                            detail_kamera.style.display = "none";

                            alert(json.message);
                        }else{
                            document.getElementById("tb_pos_pendakian_id").value = pos;
                            document.getElementById("tb_gunung_id").value = gunung;
                            document.getElementById("tb_start_date").value = start_date;
                            document.getElementById("tb_end_date").value = end_date;
                            var div_summary = document.getElementById("respon_summary");
                            var profile_pemesan = document.getElementById("profile_pemesan");
                            var div_anggota = document.getElementById("respon_anggota");
                            var div_button = document.getElementById("checkout");
                            var div_pembayaran = document.getElementById("div_metode_pembayaran");
                            div_summary.style.display = "block";
                            profile_pemesan.style.display = "block";
                            div_anggota.style.display = "block";
                            div_button.style.display = "block";
                            div_pembayaran.style.display = "block"

                            var detail_kamera = document.getElementById("detail_kamera");
                            detail_kamera.style.display = "block";

                            $("#save_umur_anggotake1").value = "";
                            $("#save_umur_anggotake2").value = "";
                            $("#save_umur_anggotake3").value = "";
                            $("#save_umur_anggotake4").value = "";
                            $("#save_umur_anggotake5").value = "";
                            $("#save_umur_anggotake6").value = "";
                            $("#save_umur_anggotake7").value = "";
                            $("#save_umur_anggotake8").value = "";
                            $("#save_umur_anggotake9").value = "";
                            $("#save_umur_anggotake10").value = "";
                            var divInformasiSuratIzin = document.getElementById("div_informasi_surat_izin");
                            var listDibawahUmur = $("#list_dibawah_umur");
                            listDibawahUmur.html("");
                            if (umur_ketua < 17) {
                                divInformasiSuratIzin.style.display = "block";
                                var listSuratIzin = "";
                                listSuratIzin += "<li>" + $("#email").val() + " memiliki umur "+ umur_ketua +" tahun.</li>";
                                listDibawahUmur.html(listSuratIzin);
                            } else {
                                divInformasiSuratIzin.style.display = "none";
                            }

                            $("#summary").html("");
                            document.getElementById("summary_total_bayar").textContent= json.data.total_bayar;
                            $.each(json.data.detail, function (key, value) {
                                $('#summary').append("<li>\Tanggal "+ value.waktu +" ("+value.status_hari+")\
                                        <table class='table table-bordered' style='margin-top: 0.5rem'>\
                                        <tr>\
                                        <td>"+value.warganegara+"</td>\
                                        <td>"+value.keterangan+"</td>\
                                        <td>"+value.total+"</td>\
                                        </tr>\
                                        </table>\
                                        </li>");
                            })

                            if (total_anggota > 1){
                                $("#form_anggota").html("");
                                var text = "";
                                for (var i=1; i< total_anggota; i++) {
                                    text += "<form method='post' action='' id='formanggota"+i+"' class='cek_anggota"+i+"'>";
                                    text += "<div class='row'>";

                                    text += "<div class='col-md-6'>";
                                    text += "<div class='input-group'>";
                                    text += "<input class='form-control input-border' placeholder='Masukan Email Anggota' type='text' id='email_anggotake"+i+"' name='email_anggotake"+i+"'>";
                                    text += "</div>";
                                    text += "<p><span style='color: red;margin-left: 10px;' id='informasi_anggota"+i+"'></span></p>";
                                    text += "</div>";

                                    text += "<div class='col-md-1 col-4'>";
                                    text += "<div class='form-group'>";
                                    text += "<div class='input-group'>";
                                    text += "<h4 id='anggota_status"+i+"' class='mx-auto'></h4>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";

                                    text += "<div class='col-md-1 col-4'>";
                                    text += "<div class='form-group'>";
                                    text += "<button type='button' style='display: block;' onclick='cekAnggota("+i+")'  name='cek_anggota"+i+"' id='cek_anggota"+i+"' class='btn bg-gradient-primary  cek_anggota"+i+"'>";
                                    text += "<span id='btn-text-proses"+i+"'>Tambah</span>";
                                    text += "<div class='spinner-border spinner-border-sm' id='loading"+i+"' style='display: none;'>";
                                    text += "</div>";
                                    text += "</button>";
                                    text += "<button type='button' style='display: none;' onclick='detailAnggota("+i+")' name='detail_anggota"+i+"' id='detail_anggota"+i+"' class='btn bg-gradient-info detail_anggota"+i+"'>Detail</button>";
                                    text += "</div>";
                                    text += "</div>";

                                    text += "<div class='col-md-2 col-4'>";
                                    text += "<div class='form-group'>";
                                    text += "<div class='input-group'>";
                                    text += "<button type='button' style='display: none' onclick='batalAnggota("+i+")' name='batal_anggota"+i+"' id='batal_anggota"+i+"' class='btn bg-gradient-danger batal_anggota"+i+"'>Batal</button>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</form>";
                                }
                                $("#form_anggota").append(text);
                            }else{
                                div_anggota.style.display = "none";
                            }
                        }
                    }
                });
                return false;
            });
        });

        function cekAnggota(i){

            document.getElementById("camwni").value = 0;
            document.getElementById("camwna").value = 0;

            var email_ketua = $("#email").val();
            var token_user  = $('#token_user').val();
            var gunung = $('#gunung').val();
            var pos = $('#pos').val();
            var kewarganegaraan = $('#ketua_is_wni').val();
            var umur_ketua    = $('#umur_ketua').val();
            var total_anggota = $('#total_anggota').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();


            var validate_email1 = $("#email_anggotake1").val();
            var validate_email2 = $("#email_anggotake2").val();
            var validate_email3 = $("#email_anggotake3").val();
            var validate_email4 = $("#email_anggotake4").val();
            var validate_email5 = $("#email_anggotake5").val();
            var validate_email6 = $("#email_anggotake6").val();
            var validate_email7 = $("#email_anggotake7").val();
            var validate_email8 = $("#email_anggotake8").val();
            var validate_email9 = $("#email_anggotake9").val();
            if(i === 1){
                if (validate_email1 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email1 == validate_email2) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email1 == validate_email3) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email1 == validate_email4) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email1 == validate_email5) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email1 == validate_email6) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email1 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email1 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email1 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake1").val(),
                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 2){
                if (validate_email2 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email2 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email2 == validate_email3) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email2 == validate_email4) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email2 == validate_email5) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email2 == validate_email6) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email2 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email2 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email2 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake2").val(),
                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 3){
                if (validate_email3 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email3 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email3 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email3 == validate_email4) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email3 == validate_email5) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email3 == validate_email6) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email3 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email3 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email3 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake3").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();

            };
            if(i === 4){
                if (validate_email4 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email4 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email4 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email4 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email4 == validate_email5) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email4 == validate_email6) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email4 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email4 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email4 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake4").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 5){
                if (validate_email5 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email5 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email5 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email5 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email5 == validate_email4) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email5 == validate_email6) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email5 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email5 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email5 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake5").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 6){
                if (validate_email6 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email6 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email6 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email6 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email6 == validate_email4) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email6 == validate_email5) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email6 == validate_email7) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email6 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email6 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake6").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 7){
                if (validate_email7 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email7 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email7 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email7 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email7 == validate_email4) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email7 == validate_email5) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email7 == validate_email6) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email7 == validate_email8) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email7 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake7").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
            };
            if(i === 8){
                if (validate_email8 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email8 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email8 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email8 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email8 == validate_email4) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email8 == validate_email5) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email8 == validate_email6) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email8 == validate_email7) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email8 == validate_email9) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake8").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake9 = $("#email_anggotake9").val(),
                    kw_anggotake9 = $("#kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();

            };
            if(i === 9){
                if (validate_email9 == email_ketua) {
                    alert("Email yang anda masukan sama");
                    return !1
                } else {
                    if (validate_email9 == validate_email1) {
                        alert("Email yang anda masukan sama");
                        return !1
                    } else {
                        if (validate_email9 == validate_email2) {
                            alert("Email yang anda masukan sama");
                            return !1
                        } else {
                            if (validate_email9 == validate_email3) {
                                alert("Email yang anda masukan sama");
                                return !1
                            } else {
                                if (validate_email9 == validate_email4) {
                                    alert("Email yang anda masukan sama");
                                    return !1
                                } else {
                                    if (validate_email9 == validate_email5) {
                                        alert("Email yang anda masukan sama");
                                        return !1
                                    } else {
                                        if (validate_email9 == validate_email6) {
                                            alert("Email yang anda masukan sama");
                                            return !1
                                        } else {
                                            if (validate_email9 == validate_email7) {
                                                alert("Email yang anda masukan sama");
                                                return !1
                                            } else {
                                                if (validate_email9 == validate_email8) {
                                                    alert("Email yang anda masukan sama");
                                                    return !1
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var email = $("#email_anggotake9").val(),
                    email_anggotake1 = $("#email_anggotake1").val(),
                    kw_anggotake1 = $("#kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#email_anggotake2").val(),
                    kw_anggotake2 = $("#kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#email_anggotake3").val(),
                    kw_anggotake3 = $("#kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#email_anggotake4").val(),
                    kw_anggotake4 = $("#kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#email_anggotake5").val(),
                    kw_anggotake5 = $("#kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#email_anggotake6").val(),
                    kw_anggotake6 = $("#kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#email_anggotake7").val(),
                    kw_anggotake7 = $("#kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#email_anggotake8").val(),
                    kw_anggotake8 = $("#kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val();
            };
            $.ajax({
                type: "POST",
                url: "api/cek_email_anggota.php",
                data:{
                    token_user: token_user,
                    email: email,
                    gunung: gunung
                },
                beforeSend: function() {
                    $("#btn-text-proses"+i).hide();
                    $("#loading"+i).show();
                    $("#cek_anggota"+i).prop('disabled', true);
                },
                complete: function() {
                    $("#btn-text-proses"+i).show();
                    $("#loading"+i).hide();
                },
                success: function (response){
                    var json = $.parseJSON(response);
                    if (json.error){
                        $("#cek_anggota"+i).prop('disabled', false)
                        var text = document.getElementById("anggota_status"+i);
                        text.textContent = "INVALID";
                        text.style.color = "red";
                        var batal_anggota = document.getElementById("batal_anggota"+i);
                        batal_anggota.style.display = "none";

                        var cek_anggota = document.getElementById("cek_anggota"+i);
                        cek_anggota.style.display = "block";

                        var detail_anggota = document.getElementById("detail_anggota"+i);
                        detail_anggota.style.display = "none";

                        document.getElementById("informasi_anggota"+i).textContent= json.message;

                        document.getElementById("data_anggota"+i).value = "";
                    }else{
                        document.getElementById("data_anggota"+i).value = JSON.stringify(json.data.user);

                        document.getElementById("informasi_anggota"+i).textContent= "";
                        var text = document.getElementById("anggota_status"+i);
                        text.textContent = "VALID";
                        text.style.color = "green";

                        var cek_anggota = document.getElementById("cek_anggota"+i);
                        cek_anggota.style.display = "none";

                        var detail_anggota = document.getElementById("detail_anggota"+i);
                        detail_anggota.style.display = "block";

                        document.getElementById("cek_anggota"+i).disabled = true;
                        document.getElementById("email_anggotake"+i).readOnly = true;
                        var batal_anggota = document.getElementById("batal_anggota"+i);
                        batal_anggota.style.display = "block";

                        document.getElementById("save_email_anggotake"+i).value = email;
                        document.getElementById("save_umur_anggotake"+i).value = json.data.user.umur;
                        var data_umur = json.data.user.umur;
                        var data_wni  = "";
                        if (json.data.user.is_wni){
                            document.getElementById("save_kw_anggotake"+i).value = "wni";
                            data_wni = "wni";
                        }else{
                            document.getElementById("save_kw_anggotake"+i).value = "wna";
                            data_wni = "wna";
                        }

                        if (i == 1){
                            var email_anggotake1 = email;
                            var kw_anggotake1    = data_wni;
                            var umur_anggotake1  = data_umur;

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 2){
                            var email_anggotake2 = email;
                            var kw_anggotake2    = data_wni;
                            var umur_anggotake2  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 3){
                            var email_anggotake3 = email;
                            var kw_anggotake3    = data_wni;
                            var umur_anggotake1  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 4){
                            var email_anggotake4 = email;
                            var kw_anggotake4    = data_wni;
                            var umur_anggotake4  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 5){
                            var email_anggotake5 = email;
                            var kw_anggotake5    = data_wni;
                            var umur_anggotake5  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 6){
                            var email_anggotake6 = email;
                            var kw_anggotake6    = data_wni;
                            var umur_anggotake6  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 7){
                            var email_anggotake7 = email;
                            var kw_anggotake7    = data_wni;
                            var umur_anggotake7  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 8){
                            var email_anggotake8 = email;
                            var kw_anggotake8    = data_wni;
                            var umur_anggotake8  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake9    = $("#save_email_anggotake9").val();
                            var kw_anggotake9       = $("#save_kw_anggotake9").val();
                            var umur_anggotake9     = $("#save_umur_anggotake9").val();

                        }
                        if (i == 9){
                            var email_anggotake9 = email;
                            var kw_anggotake9    = data_wni;
                            var umur_anggotake2  = data_umur;

                            var email_anggotake1    = $("#save_email_anggotake1").val();
                            var kw_anggotake1       = $("#save_kw_anggotake1").val();
                            var umur_anggotake1     = $("#save_umur_anggotake1").val();

                            var email_anggotake2    = $("#save_email_anggotake2").val();
                            var kw_anggotake2       = $("#save_kw_anggotake2").val();
                            var umur_anggotake2     = $("#save_umur_anggotake2").val();

                            var email_anggotake3    = $("#save_email_anggotake3").val();
                            var kw_anggotake3       = $("#save_kw_anggotake3").val();
                            var umur_anggotake3     = $("#save_umur_anggotake3").val();

                            var email_anggotake4    = $("#save_email_anggotake4").val();
                            var kw_anggotake4       = $("#save_kw_anggotake4").val();
                            var umur_anggotake4     = $("#save_umur_anggotake4").val();

                            var email_anggotake5    = $("#save_email_anggotake5").val();
                            var kw_anggotake5       = $("#save_kw_anggotake5").val();
                            var umur_anggotake5     = $("#save_umur_anggotake5").val();

                            var email_anggotake6    = $("#save_email_anggotake6").val();
                            var kw_anggotake6       = $("#save_kw_anggotake6").val();
                            var umur_anggotake6     = $("#save_umur_anggotake6").val();

                            var email_anggotake7    = $("#save_email_anggotake7").val();
                            var kw_anggotake7       = $("#save_kw_anggotake7").val();
                            var umur_anggotake7     = $("#save_umur_anggotake7").val();

                            var email_anggotake8    = $("#save_email_anggotake8").val();
                            var kw_anggotake8       = $("#save_kw_anggotake8").val();
                            var umur_anggotake8     = $("#save_umur_anggotake8").val();

                        }

                        $.ajax({
                            type    : "POST",
                            url     : "core/cek_tiket_anggota.php",
                            data    : {
                                gunung: gunung,
                                pos: pos,
                                email_ketua: email_ketua,
                                umur_ketua: umur_ketua,
                                kewarganegaraan: kewarganegaraan,
                                start_date: start_date,
                                end_date: end_date,
                                total_anggota: total_anggota,

                                email_anggotake1: email_anggotake1,
                                kw_anggotake1: kw_anggotake1,
                                umur_anggotake1: umur_anggotake1,

                                email_anggotake2: email_anggotake2,
                                kw_anggotake2: kw_anggotake2,
                                umur_anggotake2: umur_anggotake2,

                                email_anggotake3: email_anggotake3,
                                kw_anggotake3: kw_anggotake3,
                                umur_anggotake3: umur_anggotake3,

                                email_anggotake4: email_anggotake4,
                                kw_anggotake4: kw_anggotake4,
                                umur_anggotake4: umur_anggotake4,

                                email_anggotake5: email_anggotake5,
                                kw_anggotake5: kw_anggotake5,
                                umur_anggotake5: umur_anggotake5,

                                email_anggotake6: email_anggotake6,
                                kw_anggotake6: kw_anggotake6,
                                umur_anggotake6: umur_anggotake6,

                                email_anggotake7: email_anggotake7,
                                kw_anggotake7: kw_anggotake7,
                                umur_anggotake7: umur_anggotake7,

                                email_anggotake8: email_anggotake8,
                                kw_anggotake8: kw_anggotake8,
                                umur_anggotake8: umur_anggotake8,

                                email_anggotake9: email_anggotake9,
                                kw_anggotake9: kw_anggotake9,
                                umur_anggotake9: umur_anggotake9
                            },
                            success: function (response) {
                                var det_json = $.parseJSON(response);
                                if (det_json.error){

                                }else{
                                    var divInformasiSuratIzin = document.getElementById("div_informasi_surat_izin");
                                    var listDibawahUmur = $("#list_dibawah_umur");
                                    listDibawahUmur.html("");
                                    if (det_json.information.is_show_umur) {
                                        divInformasiSuratIzin.style.display = "block";
                                        var listSuratIzin = "";
                                        $.each(det_json.information.notif_umur, function (key, value) {
                                            listSuratIzin += "<li>" + value.name + "</li>";
                                        });

                                        listDibawahUmur.html(listSuratIzin);

                                    } else {
                                        divInformasiSuratIzin.style.display = "none";
                                    }

                                    $("#summary").html("");
                                    var summary_text = "";
                                    document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                    $.each(det_json.data.detail, function (key, value) {
                                        summary_text += "</li>";
                                        summary_text += "Tanggal "+ value.waktu +" ("+value.status_hari+")";
                                        summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                                        $.each(value.detail_arr, function (key_det, value_det) {
                                            summary_text += "<tr>";
                                            summary_text += "<td>"+value_det.warganegara+"</td>";
                                            summary_text += "<td>"+value_det.keterangan+"</td>";
                                            summary_text += "<td>"+value_det.total+"</td>";
                                            summary_text += "</tr>";
                                        })
                                        summary_text += "</table>";
                                        summary_text += "</li>";
                                    })
                                    $('#summary').html(summary_text);
                                }
                            }
                        })
                    }}
            });
        }


        function batalAnggota(i){

            document.getElementById("camwni").value = 0;
            document.getElementById("camwna").value = 0;

            var cek_anggota = document.getElementById("cek_anggota"+i);
            cek_anggota.style.display = "block";

            var detail_anggota = document.getElementById("detail_anggota"+i);
            detail_anggota.style.display = "none";

            document.getElementById("informasi_anggota"+i).textContent= "";
            var email_ketua = $("#email").val();
            var umur_ketua = $("#umur_ketua").val();
            var gunung = $('#gunung').val();
            var pos = $('#pos').val();
            var kewarganegaraan = $('#ketua_is_wni').val();
            var total_anggota = $('#total_anggota').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            if (i === 1) {
                        var email_anggotake1 = "",
                        kw_anggotake1        = "",
                        umur_anggotake1      = "",
                        email_anggotake2 = $("#save_email_anggotake2").val(),
                        kw_anggotake2 = $("#save_kw_anggotake2").val(),
                        umur_anggotake2 = $("#save_umur_anggotake2").val(),

                        email_anggotake3 = $("#save_email_anggotake3").val(),
                        kw_anggotake3 = $("#save_kw_anggotake3").val(),
                        umur_anggotake3 = $("#save_umur_anggotake3").val(),

                        email_anggotake4 = $("#save_email_anggotake4").val(),
                        kw_anggotake4 = $("#save_kw_anggotake4").val(),
                        umur_anggotake4 = $("#save_umur_anggotake4").val(),

                        email_anggotake5 = $("#save_email_anggotake5").val(),
                        kw_anggotake5 = $("#save_kw_anggotake5").val(),
                        umur_anggotake5 = $("#save_umur_anggotake5").val(),

                        email_anggotake6 = $("#save_email_anggotake6").val(),
                        kw_anggotake6 = $("#save_kw_anggotake6").val(),
                        umur_anggotake6 = $("#save_umur_anggotake6").val(),

                        email_anggotake7 = $("#save_email_anggotake7").val(),
                        kw_anggotake7 = $("#save_kw_anggotake7").val(),
                        umur_anggotake7 = $("#save_umur_anggotake7").val(),

                        email_anggotake8 = $("#save_email_anggotake8").val(),
                        kw_anggotake8 = $("#save_kw_anggotake8").val(),
                        umur_anggotake8 = $("#save_umur_anggotake8").val(),

                        email_anggotake9 = $("#save_email_anggotake9").val(),
                        kw_anggotake9 = $("#save_kw_anggotake9").val(),
                        umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake1;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake1;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake1;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake1;
            };
            if (i === 2) {
                var email_anggotake2 =  "",
                    kw_anggotake2 = "",
                    umur_anggotake2 = "",
                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake2;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake2;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake2;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake2;
            };
            if (i === 3) {
                var email_anggotake3 =  "",
                    kw_anggotake3 = "",
                    umur_anggotake3 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake3;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake3;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake3;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake3;
            };
            if (i === 4) {
                var email_anggotake4 =  "",
                    kw_anggotake4 = "",
                    umur_anggotake4 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake4;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake4;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake4;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake4;
            };
            if (i === 5) {
                var email_anggotake5 =  "",
                    kw_anggotake5 = "",
                    umur_anggotake5 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake5;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake5;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake5;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake5;
            };
            if (i === 6) {
                var email_anggotake6 =  "",
                    kw_anggotake6 = "",
                    umur_anggotake6 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake6;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake6;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake6;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake6;
            };
            if (i === 7) {
                var email_anggotake7 =  "",
                    kw_anggotake7 = "",
                    umur_anggotake7 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake7;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake7;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake7;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake7;
            };
            if (i === 8) {
                var email_anggotake8 =  "",
                    kw_anggotake8 = "",
                    umur_anggotake8 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake9 = $("#save_email_anggotake9").val(),
                    kw_anggotake9 = $("#save_kw_anggotake9").val(),
                    umur_anggotake9 = $("#save_umur_anggotake9").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake8;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake8;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake8;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake8;
            };
            if (i === 9) {
                var email_anggotake9 =  "",
                    kw_anggotake9 = "",
                    umur_anggotake9 = "",

                    email_anggotake1 = $("#save_email_anggotake1").val(),
                    kw_anggotake1 = $("#save_kw_anggotake1").val(),
                    umur_anggotake1 = $("#save_umur_anggotake1").val(),

                    email_anggotake2 = $("#save_email_anggotake2").val(),
                    kw_anggotake2 = $("#save_kw_anggotake2").val(),
                    umur_anggotake2 = $("#save_umur_anggotake2").val(),

                    email_anggotake3 = $("#save_email_anggotake3").val(),
                    kw_anggotake3 = $("#save_kw_anggotake3").val(),
                    umur_anggotake3 = $("#save_umur_anggotake3").val(),

                    email_anggotake4 = $("#save_email_anggotake4").val(),
                    kw_anggotake4 = $("#save_kw_anggotake4").val(),
                    umur_anggotake4 = $("#save_umur_anggotake4").val(),

                    email_anggotake5 = $("#save_email_anggotake5").val(),
                    kw_anggotake5 = $("#save_kw_anggotake5").val(),
                    umur_anggotake5 = $("#save_umur_anggotake5").val(),

                    email_anggotake6 = $("#save_email_anggotake6").val(),
                    kw_anggotake6 = $("#save_kw_anggotake6").val(),
                    umur_anggotake6 = $("#save_umur_anggotake6").val(),

                    email_anggotake7 = $("#save_email_anggotake7").val(),
                    kw_anggotake7 = $("#save_kw_anggotake7").val(),
                    umur_anggotake7 = $("#save_umur_anggotake7").val(),

                    email_anggotake8 = $("#save_email_anggotake8").val(),
                    kw_anggotake8 = $("#save_kw_anggotake8").val(),
                    umur_anggotake8 = $("#save_umur_anggotake8").val();
                document.getElementById("email_anggotake"+i).value = email_anggotake9;
                document.getElementById("save_email_anggotake"+i).value = email_anggotake9;
                document.getElementById("save_kw_anggotake"+i).value = kw_anggotake9;
                document.getElementById("save_umur_anggotake"+i).value = umur_anggotake9;
            };

            $.ajax({
                type    : "POST",
                url     : "core/cek_tiket_anggota.php",
                data    : {
                    gunung: gunung,
                    pos: pos,
                    email_ketua: email_ketua,
                    umur_ketua: umur_ketua,
                    kewarganegaraan: kewarganegaraan,
                    start_date: start_date,
                    end_date: end_date,
                    total_anggota: total_anggota,

                    email_anggotake1: email_anggotake1,
                    kw_anggotake1: kw_anggotake1,
                    umur_anggotake1: umur_anggotake1,

                    email_anggotake2: email_anggotake2,
                    kw_anggotake2: kw_anggotake2,
                    umur_anggotake2: umur_anggotake2,

                    email_anggotake3: email_anggotake3,
                    kw_anggotake3: kw_anggotake3,
                    umur_anggotake3: umur_anggotake3,

                    email_anggotake4: email_anggotake4,
                    kw_anggotake4: kw_anggotake4,
                    umur_anggotake4: umur_anggotake4,

                    email_anggotake5: email_anggotake5,
                    kw_anggotake5: kw_anggotake5,
                    umur_anggotake5: umur_anggotake5,

                    email_anggotake6: email_anggotake6,
                    kw_anggotake6: kw_anggotake6,
                    umur_anggotake6: umur_anggotake6,

                    email_anggotake7: email_anggotake7,
                    kw_anggotake7: kw_anggotake7,
                    umur_anggotake7: umur_anggotake7,

                    email_anggotake8: email_anggotake8,
                    kw_anggotake8: kw_anggotake8,
                    umur_anggotake8: umur_anggotake8,

                    email_anggotake9: email_anggotake9,
                    kw_anggotake9: kw_anggotake9,
                    umur_anggotake9: umur_anggotake9
                },
                success: function (response) {
                    var det_json = $.parseJSON(response);
                    if (det_json.error){

                    }else{
                        var text = document.getElementById("anggota_status"+i);
                        text.textContent = "";
                        text.style.color = "gray";

                        var batal_anggota = document.getElementById("batal_anggota"+i);
                        batal_anggota.style.display = "none";
                        document.getElementById('email_anggotake'+i).readOnly = false;
                        document.getElementById('cek_anggota'+i).disabled = false;

                        var divInformasiSuratIzin = document.getElementById("div_informasi_surat_izin");
                        var listDibawahUmur = $("#list_dibawah_umur");
                        listDibawahUmur.html("");
                        if (det_json.information.is_show_umur) {
                            divInformasiSuratIzin.style.display = "block";

                            var listSuratIzin = "";
                            $.each(det_json.information.notif_umur, function (key, value) {
                                listSuratIzin += "<li>" + value.name + "</li>";
                            });

                            listDibawahUmur.html(listSuratIzin);

                        } else {
                            divInformasiSuratIzin.style.display = "none";
                        }

                        $("#summary").html("");
                        var summary_text = "";
                        document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                        $.each(det_json.data.detail, function (key, value) {
                            summary_text += "</li>";
                            summary_text += "Tanggal "+ value.waktu +" ("+value.status_hari+")";
                            summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                            $.each(value.detail_arr, function (key_det, value_det) {
                                summary_text += "<tr>";
                                summary_text += "<td>"+value_det.warganegara+"</td>";
                                summary_text += "<td>"+value_det.keterangan+"</td>";
                                summary_text += "<td>"+value_det.total+"</td>";
                                summary_text += "</tr>";
                            })
                            summary_text += "</table>";
                            summary_text += "</li>";
                        });
                        $('#summary').html(summary_text);
                    }
                }
            })
        }

        function detailAnggota(i){
            var modal = document.getElementById("myModal");
            var close_modal = document.getElementById("close_modal");

            modal.style.display = "block";

            close_modal.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            var datastring = document.getElementById("data_anggota"+i).value
            var json = $.parseJSON(datastring);

            document.getElementById("review_name").textContent = json.fullname;
            document.getElementById("review_id_card_number").textContent = json.id_card_number;
            document.getElementById("review_id_card_type").textContent= "("+json.id_card_type+")";
            document.getElementById("review_ttg").textContent = json.place_birth+", "+json.date_birth;
            document.getElementById("review_phone").textContent = json.phone;
            document.getElementById("review_email").textContent = json.email;
            document.getElementById("review_gender").textContent = json.gender;

            document.getElementById("review_address").textContent = json.location.address;
            document.getElementById("review_province_name").textContent = json.location.province_name;
            document.getElementById("review_city_name").textContent = json.location.city_name;
            document.getElementById("review_district_name").textContent = json.location.district_name;
            document.getElementById("review_village_name").textContent = json.location.village_name;
            var wni_wna = "";
            if (json.is_wni){
                wni_wna = "WNI";
            }else{
                wni_wna = "WNA";
            }
            document.getElementById("review_data_wni").textContent = wni_wna;

        }


        $.ajax({
            type: 'POST',
            url: "core/gunung.php",
            cache: false,
            success: function(msg){
                $("#gunung").html(msg);
                var informasi_status_akun = document.getElementById("informasi_status_akun");
                informasi_status_akun.style.display = "none";
            }
        });

        $("#gunung").change(function(){
            var gunung_id = $("#gunung").val();
            $.ajax({
                type: 'POST',
                url: "core/cek_max_date.php",
                data: {gunung_id: gunung_id},
                cache: false,
                success: function(response){
                    var json = $.parseJSON(response);
                    $("#max_date").val(json.data);
                }
            });
        });

        $("#gunung").change(function(){
            var gunung_id = $("#gunung").val();

            $.ajax({
                type: 'POST',
                url: "core/cek_verified_user.php",
                data: {gunung_id: gunung_id},
                cache: false,
                success: function(msg){
                    var json = $.parseJSON(msg);

                    var informasi_status_akun = document.getElementById("informasi_status_akun");
                    document.getElementById("status_akun_verified").innerText = $("#verified_user_status").val();

                    if (json.data.is_verified_user == "1"){
                        informasi_status_akun.style.display = "block";
                        var get_is_verified_user = $("#is_verified_user").val();
                        if(get_is_verified_user == "true" || get_is_verified_user == true){
                            var status_user_verified = document.getElementById("status_user_verified");
                            status_user_verified.style.display = "none";
                            informasi_status_akun.style.display = "none";
                            document.getElementById("cek_kuota").disabled = false;

                            $('#log_user_verification').remove();
                        }else{
                            var status_user_verified = document.getElementById("status_user_verified");
                            status_user_verified.style.display = "block";
                            informasi_status_akun.style.display = "block";

                            document.getElementById("cek_kuota").disabled = true;
                            var get_log_verif = $("#log_verified_user").val();
                            const jsonArrayLog = JSON.parse(get_log_verif);
                            $.each(jsonArrayLog, function (key, value) {
                                $('#log_user_verification').append("<li><strong>\Waktu: "+ value.waktu+"</strong>\
                                        <table class='table table-bordered' style='margin-top: 0.5rem;border: 0px solid #f0f8ff00;'>\
                                        <tr>\
                                        <td width='50'>Status:</td>\
                                        <td>"+value.status_verified_account+"</td>\
                                        </tr>\
                                        <tr>\
                                            <td width='50'>Catatan:</td>\
                                            <td>"+value.catatan+"</td>\
                                        </tr>\
                                        </table>\
                                        </li>");
                            })

                        }
                        informasi_status_akun.textContent = "Pemesanan pada gunung ini mewajibkan pendaki untuk melakukan verifikasi akun, jika akun belum terverifikasi silakan ajukan verifikasi akun, dan tunggu sampai admin melakukan persetujuan verifikasi akun anda.";
                    }else{
                        var status_user_verified = document.getElementById("status_user_verified");
                        status_user_verified.style.display = "none";
                        $('#log_user_verification').empty();

                        document.getElementById("cek_kuota").disabled = false;
                        informasi_status_akun.style.display = "none";
                        informasi_status_akun.textContent = "";
                    }

                    $.ajax({
                        type: 'POST',
                        url: "core/pos.php",
                        data: {gunung_id: gunung_id},
                        cache: false,
                        success: function(msg){
                            var informasi_tanggal = document.getElementById("informasi_tanggal");
                            informasi_tanggal.style.display = "none";
                            $("#pos").html(msg);

                            var detail_kamera = document.getElementById("detail_kamera");
                            detail_kamera.style.display = "none";

                            var div_summary = document.getElementById("respon_summary");
                            var profile_pemesan = document.getElementById("profile_pemesan");
                            var div_anggota = document.getElementById("respon_anggota");
                            var div_button = document.getElementById("checkout");
                            var div_pembayaran = document.getElementById("div_metode_pembayaran");

                            $("#start_date").datepicker('destroy').val('');
                            $("#end_date").datepicker('destroy').val('');

                            div_summary.style.display = "none";
                            profile_pemesan.style.display = "none";
                            div_anggota.style.display = "none";
                            div_button.style.display = "none";
                            div_pembayaran.style.display = "none"
                        }
                    });

                }
            });
        });

        $("#pos").change(function(){
            var pos_id = $('#pos').val();

            $.ajax({
                type: 'POST',
                url: "core/min_max_order.php",
                data: {pos_id: pos_id},
                cache: false,
                success: function(response){
                    var json = $.parseJSON(response);
                    let min_pesan = parseInt(json.data.min_pesan);
                    let max_pesan = parseInt(json.data.max_pesan);
                    var total_anggota = document.getElementById("total_anggota");
                    total_anggota.value = min_pesan
                    total_anggota.min = min_pesan;
                    total_anggota.max = max_pesan;

                    $("#start_date").datepicker('destroy').val('');
                    $("#end_date").datepicker('destroy').val('');

                    var detail_kamera = document.getElementById("detail_kamera");
                    detail_kamera.style.display = "none";

                    var div_summary = document.getElementById("respon_summary");
                    var profile_pemesan = document.getElementById("profile_pemesan");
                    var div_anggota = document.getElementById("respon_anggota");
                    var div_button = document.getElementById("checkout");
                    var div_pembayaran = document.getElementById("div_metode_pembayaran");

                    $("#total_anggota").change(function() {

                        var detail_kamera = document.getElementById("detail_kamera");
                        detail_kamera.style.display = "none";

                        div_summary.style.display = "none";
                        profile_pemesan.style.display = "none";
                        div_anggota.style.display = "none";
                        div_button.style.display = "none";
                        div_pembayaran.style.display = "none"
                        if ($(this).val() > max_pesan)
                        {
                            $(this).val(max_pesan);
                        }
                        else if ($(this).val() < min_pesan)
                        {
                            $(this).val(min_pesan);
                        }
                    });

                    div_summary.style.display = "none";
                    profile_pemesan.style.display = "none";
                    div_anggota.style.display = "none";
                    div_button.style.display = "none";
                    div_pembayaran.style.display = "none"

                    var informasi_tanggal = document.getElementById("informasi_tanggal");
                    informasi_tanggal.style.display = "block";

                    var max_date = $("#max_date").val();
                    let num = parseInt(max_date);

                    var pos_id = json.data.pos_id;
                    var gunung_id = json.data.gunung_id;

                    $.ajax({
                        type: 'POST',
                        url: "core/metode_pembayaran.php",
                        data: {gunung_id: gunung_id, pos_id: pos_id},
                        cache: false,
                        success: function(msg){
                            $("#metode_pembayaran").html(msg);
                            // $("#div_metode_pembayaran").show();
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "core/show_kuota_tiket.php",
                        data: {pos_id: pos_id, gunung_id: gunung_id},
                        cache: false,
                        success: function (response_tiket){
                            var json_tiket = $.parseJSON(response_tiket);

                            function getKuotaTiket(date) {
                                const dateString = $.datepicker.formatDate('dd-mm-yy', date);
                                const match = json_tiket.data.find(item => item.date === dateString);
                                return match ? match.kuota : null;
                            }

                            let endpicker = $("#end_date").datepicker({
                                dateFormat: "dd-mm-yy", // Format tanggal
                                beforeShowDay: function (date) {
                                    $.datepicker.formatDate('dd-mm-yy', date);
                                    const kuota = getKuotaTiket(date);
                                    if (kuota !== null) {
                                        const kuotaText = `Kuota: ${kuota}`;
                                        return [true, kuota > 0 ? "highlight" : "highlight0", kuotaText];
                                    } else {
                                        const kuotaText = `Kuota: 0`;
                                        return [true, "highlight0", kuotaText];
                                    }
                                },
                                onSelect: function (dateText) {
                                    const selectedDate = $(this).datepicker('getDate');
                                    const kuota = getKuotaTiket(selectedDate);
                                },
                                onClose: function () {
                                    // Sembunyikan elemen-elemen tertentu saat datepicker ditutup
                                    $("#profile_pemesan").hide();
                                    $("#respon_anggota").hide();
                                    $("#respon_summary").hide();
                                    $("#div_metode_pembayaran").hide();
                                    $("#checkout").hide();
                                }
                            });

                            if (json.data.can_booking_before_day > 0){
                                informasi_tanggal.textContent = "Pemesanan hanya bisa di lakukan di H-"+json.data.can_booking_before_day;

                                var date_now = new Date(Date.now() + json.data.can_booking_before_day * 24 * 60 * 60 * 1000);
                                var date_min = formatDate(date_now);

                                $("#start_date").datepicker({
                                    dateFormat: "dd-mm-yy",
                                    minDate: date_min,
                                    maxDate: "+30d",
                                    beforeShowDay: function (date) {
                                        $.datepicker.formatDate('dd-mm-yy', date);
                                        const kuota = getKuotaTiket(date);

                                        // Highlight tanggal berdasarkan kuota
                                        if (kuota !== null) {
                                            const kuotaText = `Kuota: ${kuota}`;
                                            return [true, kuota > 0 ? "highlight" : "highlight0", kuotaText];
                                        } else {
                                            const kuotaText = `Kuota: 0`;
                                            return [true, "highlight0", kuotaText];
                                        }
                                    },
                                    onSelect: function (dateText) {
                                        const selectedDate = $(this).datepicker('getDate');
                                        const kuota = getKuotaTiket(selectedDate);
                                    },
                                    onClose: function (dateStr) {
                                        if (dateStr) {
                                            endpicker.datepicker("option", "minDate", dateStr);

                                            $("#end_date").val('');

                                            let dateParts = dateStr.split("-");
                                            let date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                                            date.setDate(date.getDate() + num);
                                            endpicker.datepicker("option", "maxDate", date);

                                            $("#profile_pemesan").hide();
                                            $("#respon_anggota").hide();
                                            $("#respon_summary").hide();
                                            $("#div_metode_pembayaran").hide();
                                            $("#checkout").hide();
                                            $("#detail_kamera").hide();
                                        }
                                    }
                                });
                            }else{
                                informasi_tanggal.textContent = "Pemesanan bisa dilakukan secara langsung di hari H";
                                $("#start_date").datepicker({
                                    dateFormat: "dd-mm-yy",
                                    minDate: "0",
                                    maxDate: "+30d",
                                    beforeShowDay: function (date) {
                                        $.datepicker.formatDate('dd-mm-yy', date);
                                        const kuota = getKuotaTiket(date);

                                        if (kuota !== null) {
                                            const kuotaText = `Kuota: ${kuota}`;
                                            return [true, kuota > 0 ? "highlight" : "highlight0", kuotaText];
                                        } else {
                                            const kuotaText = `Kuota: 0`;
                                            return [true, "highlight0", kuotaText];
                                        }
                                    },
                                    onSelect: function (dateText) {
                                        const selectedDate = $(this).datepicker('getDate');
                                        const kuota = getKuotaTiket(selectedDate);
                                        // Sembunyikan elemen-elemen tertentu setelah tanggal dipilih

                                        $("#profile_pemesan").hide();
                                        $("#respon_anggota").hide();
                                        $("#respon_summary").hide();
                                        $("#div_metode_pembayaran").hide();
                                        $("#checkout").hide();
                                        $("#detail_kamera").hide();
                                    },
                                    onClose: function (dateStr) {
                                        if (dateStr) {
                                            endpicker.datepicker("option", "minDate", dateStr);
                                            let dateParts = dateStr.split("-");
                                            let date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                                            date.setDate(date.getDate() + num);
                                            endpicker.datepicker("option", "maxDate", date);

                                            $("#profile_pemesan").hide();
                                            $("#respon_anggota").hide();
                                            $("#respon_summary").hide();
                                            $("#div_metode_pembayaran").hide();
                                            $("#checkout").hide();
                                            $("#detail_kamera").hide();
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });


        $("#camwni").change(function(){
            var email_ketua = $("#email").val();
            var gunung = $('#gunung').val();
            var pos = $('#pos').val();
            var umur_ketua = $("#umur_ketua").val();
            var kewarganegaraan = $('#ketua_is_wni').val();
            var total_anggota = $('#total_anggota').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var camwni = $('#camwni').val();
            var camwna = $('#camwna').val();

            var email_anggotake1    = $("#save_email_anggotake1").val(),
                kw_anggotake1       = $("#save_kw_anggotake1").val(),
                umur_anggotake1     = $("#save_umur_anggotake1").val(),

                email_anggotake2    = $("#save_email_anggotake2").val(),
                kw_anggotake2       = $("#save_kw_anggotake2").val(),
                umur_anggotake2     = $("#save_umur_anggotake2").val(),

                email_anggotake3    = $("#save_email_anggotake3").val(),
                kw_anggotake3       = $("#save_kw_anggotake3").val(),
                umur_anggotake3     = $("#save_umur_anggotake3").val(),

                email_anggotake4    = $("#save_email_anggotake4").val(),
                kw_anggotake4       = $("#save_kw_anggotake4").val(),
                umur_anggotake4     = $("#save_umur_anggotake4").val(),

                email_anggotake5    = $("#save_email_anggotake5").val(),
                kw_anggotake5       = $("#save_kw_anggotake5").val(),
                umur_anggotake5     = $("#save_umur_anggotake5").val(),

                email_anggotake6    = $("#save_email_anggotake6").val(),
                kw_anggotake6       = $("#save_kw_anggotake6").val(),
                umur_anggotake6     = $("#save_umur_anggotake6").val(),

                email_anggotake7    = $("#save_email_anggotake7").val(),
                kw_anggotake7       = $("#save_kw_anggotake7").val(),
                umur_anggotake7     = $("#save_umur_anggotake7").val(),

                email_anggotake8    = $("#save_email_anggotake8").val(),
                kw_anggotake8       = $("#save_kw_anggotake8").val(),
                umur_anggotake8     = $("#save_umur_anggotake8").val(),

                email_anggotake9    = $("#save_email_anggotake9").val(),
                kw_anggotake9       = $("#save_kw_anggotake9").val(),
                umur_anggotake9     = $("#save_umur_anggotake9").val();
            $.ajax({
                type    : "POST",
                url     : "core/cek_tiket_anggota.php",
                data    : {
                    gunung: gunung,
                    pos: pos,
                    email_ketua: email_ketua,
                    umur_ketua: umur_ketua,
                    kewarganegaraan: kewarganegaraan,
                    start_date: start_date,
                    end_date: end_date,
                    total_anggota: total_anggota,

                    email_anggotake1: email_anggotake1,
                    kw_anggotake1: kw_anggotake1,
                    umur_anggotake1:umur_anggotake1,

                    email_anggotake2: email_anggotake2,
                    kw_anggotake2: kw_anggotake2,
                    umur_anggotake2:umur_anggotake2,

                    email_anggotake3: email_anggotake3,
                    kw_anggotake3: kw_anggotake3,
                    umur_anggotake3:umur_anggotake3,

                    email_anggotake4: email_anggotake4,
                    kw_anggotake4: kw_anggotake4,
                    umur_anggotake4:umur_anggotake4,

                    email_anggotake5: email_anggotake5,
                    kw_anggotake5: kw_anggotake5,
                    umur_anggotake5:umur_anggotake5,

                    email_anggotake6: email_anggotake6,
                    kw_anggotake6: kw_anggotake6,
                    umur_anggotake6:umur_anggotake6,

                    email_anggotake7: email_anggotake7,
                    kw_anggotake7: kw_anggotake7,
                    umur_anggotake7:umur_anggotake7,

                    email_anggotake8: email_anggotake8,
                    kw_anggotake8: kw_anggotake8,
                    umur_anggotake8:umur_anggotake8,

                    email_anggotake9: email_anggotake9,
                    kw_anggotake9: kw_anggotake9,
                    umur_anggotake9:umur_anggotake9,

                    camwni: camwni,
                    camwna: camwna
                },
                success: function (response) {
                    var det_json = $.parseJSON(response);
                    if (det_json.error){

                    }else{
                        $("#summary").html("");
                        var summary_text = "";
                        document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                        $.each(det_json.data.detail, function (key, value) {
                            summary_text += "</li>";
                            summary_text += "Tanggal "+ value.waktu +" ("+value.status_hari+")";
                            summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                            $.each(value.detail_arr, function (key_det, value_det) {
                                summary_text += "<tr>";
                                summary_text += "<td>"+value_det.warganegara+"</td>";
                                summary_text += "<td>"+value_det.keterangan+"</td>";
                                summary_text += "<td>"+value_det.total+"</td>";
                                summary_text += "</tr>";
                            })
                            summary_text += "</table>";
                            summary_text += "</li>";
                        })
                        if(det_json.data.kamera){
                            $.each(det_json.data.kamera, function (key, value) {
                                summary_text += "<hr style='border: 1px solid #000; width: 100%;'>";
                                summary_text += "</li>";
                                summary_text += value.name;
                                summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                                $.each(value.detail_arr, function (key_det, value_det) {
                                    summary_text += "<tr>";
                                    summary_text += "<td>"+value_det.name+"</td>";
                                    summary_text += "<td>"+value_det.keterangan+"</td>";
                                    summary_text += "<td>"+value_det.total+"</td>";
                                    summary_text += "</tr>";
                                })
                                summary_text += "</table>";
                                summary_text += "</li>";
                            })
                        }


                        $('#summary').html(summary_text);
                    }
                }
            })
        });

        $("#camwna").change(function(){
            var email_ketua = $("#email").val();
            var gunung = $('#gunung').val();
            var pos = $('#pos').val();
            var umur_ketua = $("#umur_ketua").val();
            var kewarganegaraan = $('#ketua_is_wni').val();
            var total_anggota = $('#total_anggota').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var camwni = $('#camwni').val();
            var camwna = $('#camwna').val();

            var email_anggotake1    = $("#save_email_anggotake1").val(),
                kw_anggotake1       = $("#save_kw_anggotake1").val(),
                umur_anggotake1     = $("#save_umur_anggotake1").val(),

                email_anggotake2    = $("#save_email_anggotake2").val(),
                kw_anggotake2       = $("#save_kw_anggotake2").val(),
                umur_anggotake2     = $("#save_umur_anggotake2").val(),

                email_anggotake3    = $("#save_email_anggotake3").val(),
                kw_anggotake3       = $("#save_kw_anggotake3").val(),
                umur_anggotake3     = $("#save_umur_anggotake3").val(),

                email_anggotake4    = $("#save_email_anggotake4").val(),
                kw_anggotake4       = $("#save_kw_anggotake4").val(),
                umur_anggotake4     = $("#save_umur_anggotake4").val(),

                email_anggotake5    = $("#save_email_anggotake5").val(),
                kw_anggotake5       = $("#save_kw_anggotake5").val(),
                umur_anggotake5     = $("#save_umur_anggotake5").val(),

                email_anggotake6    = $("#save_email_anggotake6").val(),
                kw_anggotake6       = $("#save_kw_anggotake6").val(),
                umur_anggotake6     = $("#save_umur_anggotake6").val(),

                email_anggotake7    = $("#save_email_anggotake7").val(),
                kw_anggotake7       = $("#save_kw_anggotake7").val(),
                umur_anggotake7     = $("#save_umur_anggotake7").val(),

                email_anggotake8    = $("#save_email_anggotake8").val(),
                kw_anggotake8       = $("#save_kw_anggotake8").val(),
                umur_anggotake8     = $("#save_umur_anggotake8").val(),

                email_anggotake9    = $("#save_email_anggotake9").val(),
                kw_anggotake9       = $("#save_kw_anggotake9").val(),
                umur_anggotake9     = $("#save_umur_anggotake9").val();
            $.ajax({
                type    : "POST",
                url     : "core/cek_tiket_anggota.php",
                data    : {
                    gunung: gunung,
                    pos: pos,
                    email_ketua: email_ketua,
                    umur_ketua: umur_ketua,
                    kewarganegaraan: kewarganegaraan,
                    start_date: start_date,
                    end_date: end_date,
                    total_anggota: total_anggota,

                    email_anggotake1: email_anggotake1,
                    kw_anggotake1: kw_anggotake1,
                    umur_anggotake1:umur_anggotake1,

                    email_anggotake2: email_anggotake2,
                    kw_anggotake2: kw_anggotake2,
                    umur_anggotake2:umur_anggotake2,

                    email_anggotake3: email_anggotake3,
                    kw_anggotake3: kw_anggotake3,
                    umur_anggotake3:umur_anggotake3,

                    email_anggotake4: email_anggotake4,
                    kw_anggotake4: kw_anggotake4,
                    umur_anggotake4:umur_anggotake4,

                    email_anggotake5: email_anggotake5,
                    kw_anggotake5: kw_anggotake5,
                    umur_anggotake5:umur_anggotake5,

                    email_anggotake6: email_anggotake6,
                    kw_anggotake6: kw_anggotake6,
                    umur_anggotake6:umur_anggotake6,

                    email_anggotake7: email_anggotake7,
                    kw_anggotake7: kw_anggotake7,
                    umur_anggotake7:umur_anggotake7,

                    email_anggotake8: email_anggotake8,
                    kw_anggotake8: kw_anggotake8,
                    umur_anggotake8:umur_anggotake8,

                    email_anggotake9: email_anggotake9,
                    kw_anggotake9: kw_anggotake9,
                    umur_anggotake9:umur_anggotake9,

                    camwni: camwni,
                    camwna: camwna
                },
                success: function (response) {
                    var det_json = $.parseJSON(response);
                    if (det_json.error){

                    }else{
                        $("#summary").html("");
                        var summary_text = "";
                        document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                        $.each(det_json.data.detail, function (key, value) {
                            summary_text += "</li>";
                            summary_text += "Tanggal "+ value.waktu +" ("+value.status_hari+")";
                            summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                            $.each(value.detail_arr, function (key_det, value_det) {
                                summary_text += "<tr>";
                                summary_text += "<td>"+value_det.warganegara+"</td>";
                                summary_text += "<td>"+value_det.keterangan+"</td>";
                                summary_text += "<td>"+value_det.total+"</td>";
                                summary_text += "</tr>";
                            })
                            summary_text += "</table>";
                            summary_text += "</li>";
                        })
                        if(det_json.data.kamera){
                            $.each(det_json.data.kamera, function (key, value) {
                                summary_text += "<hr style='border: 1px solid #000; width: 100%;'>";
                                summary_text += "</li>";
                                summary_text += value.name;
                                summary_text += "<table class='table table-bordered' style='margin-top: 0.5rem'>";
                                $.each(value.detail_arr, function (key_det, value_det) {
                                    summary_text += "<tr>";
                                    summary_text += "<td>"+value_det.name+"</td>";
                                    summary_text += "<td>"+value_det.keterangan+"</td>";
                                    summary_text += "<td>"+value_det.total+"</td>";
                                    summary_text += "</tr>";
                                })
                                summary_text += "</table>";
                                summary_text += "</li>";
                            })
                        }


                        $('#summary').html(summary_text);
                    }
                }
            })
        });

        function formatDate(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + year;
        }
    </script>
  </body>

</html>
