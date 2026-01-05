<?php 
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
  }
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
    .input-border{
        border: 1px solid #d5d5d5;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 20px;
    }
    .input-border:focus {
        outline: none !important;
        border-color: #9dc7f3;
        box-shadow: 0 0 10px #94bce7;
        border-radius: 20px;
    }
    /*.row {*/
    /*    --bs-gutter-x: 0px !important;*/
    /*}*/
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
                <span>
                    <p>
                        Status Akun : <span id="status_akun" style="font-weight: bold;"></span>
                    </p>
                    <small style="color: red;">! Untuk dapat melakukan pemesanan, akun anda harus dalam status terverifikasi. Silakan klik tombol <strong>verifikai</strong> dibawah ini, jika sudah melakukan <strong>verifikai</strong> tunggu sampai <strong>verifikasi</strong> disetujui oleh admin, atau cek <strong>log verifikai</strong> secara berkala untuk melihat proses verfikai akun anda sejauh mana jika anda sudah mengajukan verifikai akun.</small>
                </span>
                <a href="" id="url_verification" class="btn btn-info btn-sm" style="width: auto;font-size: 10px; margin-left: 10px;">Verifikai Akun</a>

                <p>Log Verifikasi:</p>
                <ul id="log_verification">

                </ul>
            </div>
        </div>
    </div>

	<form autocomplete="off" method="post" action="">
		<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6" id="div_pemesanan" style="display: none;">
		  <div class="container">
		    <div class="row border-radius-md pb-4 mx-sm-0 mx-1 position-relative">
		    	<div class="col-lg-10">
		    		<div class="row">
                        <input type="hidden" id="max_date" name="max_date">
                        <div class="col-lg-3 mt-lg-n2 mt-2">
                            <label for="gunung">Gunung:</label>
                            <select class="form-control" name="gunung" id="gunung" required>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-lg-3 mt-lg-n2 mt-2">
                            <label for="pos">Pos Pendakian:</label>
                            <select class="form-control" name="pos" id="pos" required>
                                <option value="">- Pilih -</option>
                            </select>
                        </div>

                        <div class="col-lg-2 mt-lg-n2 mt-2">
                            <label class="ms-0">Total Anggota</label>
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

    <form action="" method="post">
    <div id="profile_pemesan" style="display: none;">
        <input type="hidden" id="token_user" name="token_user" value="<?php echo $token_user; ?>">
        <input type="hidden" id="ketua_is_wni" name="ketua_is_wni">
        <input type="hidden" id="tb_pos_pendakian_id" name="tb_pos_pendakian_id">
        <input type="hidden" id="tb_gunung_id" name="tb_gunung_id">
        <input type="hidden" id="tb_start_date" name="tb_start_date">
        <input type="hidden" id="tb_end_date" name="tb_end_date">
        <div class="col-lg-9 col-12 mx-auto">
            <div class="card mt-4">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <h6 class="mb-0">Data Pemesan</h6>
                        </div>
                        <span>
                            <small style="color: red;">! Data pemesan secara otomatis terisi dari data profil anda yang sudah terverifikasi.</small>
                        </span>
                    </div>
                </div>
                <div class="card-body p-3">
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


    <section id="respon_anggota" style="display: none; margin-top: 10px !important;">
        <div class="col-lg-9 col-12 mx-auto">
            <div class="row">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <label style="font-size: 15px;margin: 10px;font-weight: bold;">Data Anggota: </label>
                            <p>
                                <small style="color: red;">! Masukan email anggota yang sudah terdaftar di website tahura/aplikasi tiket pendakian, jika belum memiliki akun silakan daftar di website tahura/aplikasi tiket pendakian.</small>
                            </p>

                            <div class="card-body" id="form_anggota">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="respon_summary" style="display: none; margin-top: 10px !important;">
        <div class="col-lg-9 col-12 mx-auto">
            <div class="row">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-body">
                                <h3 class="text-dark"></h3>
                                <label class="form-label mt-4">Rincian biaya :</label>
                                <ul id="summary">

                                </ul>
                            </div>
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
    </section>
        <div class="d-flex justify-content-end mt-4" style="margin: 140px;">

            <button style="display: none;" type="button" name="checkout" id="checkout" class="btn bg-gradient-primary w-100 mb-0">
                <span id="btn-text-proses">Booking</span>
                <div class="spinner-border spinner-border-sm" role="status" id="loading" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </div>
    </form>



    <input type="hidden" id="total_anggota" name="total_anggota">
    <input type="hidden" id="kw_anggotake1" name="kw_anggotake1">
    <input type="hidden" id="email_anggotake1" name="email_anggotake1">
    <input type="hidden" id="kw_anggotake2" name="kw_anggotake2">
    <input type="hidden" id="email_anggotake2" name="email_anggotake2">
    <input type="hidden" id="kw_anggotake3" name="kw_anggotake3">
    <input type="hidden" id="email_anggotake3" name="email_anggotake3">
    <input type="hidden" id="kw_anggotake4" name="kw_anggotake4">
    <input type="hidden" id="email_anggotake4" name="email_anggotake4">
    <input type="hidden" id="kw_anggotake5" name="kw_anggotake5">
    <input type="hidden" id="email_anggotake5" name="email_anggotake5">
    <input type="hidden" id="kw_anggotake6" name="kw_anggotake6">
    <input type="hidden" id="email_anggotake6" name="email_anggotake6">
    <input type="hidden" id="kw_anggotake7" name="kw_anggotake7">
    <input type="hidden" id="email_anggotake7" name="email_anggotake7">
    <input type="hidden" id="kw_anggotake8" name="kw_anggotake8">
    <input type="hidden" id="email_anggotake8" name="email_anggotake8">
    <input type="hidden" id="kw_anggotake9" name="kw_anggotake9">
    <input type="hidden" id="email_anggotake9" name="email_anggotake9">
    <input type="hidden" id="kw_anggotake10" name="kw_anggotake10">
    <input type="hidden" id="email_anggotake10" name="email_anggotake10">

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
    <script src="./assets/js/material-kit-pro.min.js?v=3.0.2" type="text/javascript"></script>
    <script src="assets/js/plugins/flatpickr.min.js"></script>
    <script type="text/javascript">
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
                            if (json.data.is_verified_account){
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
                                if(json.data.user.is_wni){
                                    document.getElementById("ketua_is_wni").value = 'wni';
                                    document.getElementById("is_wni").value = 'wni';
                                    document.getElementById("data_wni").value = "WNI";
                                }else{
                                    document.getElementById("ketua_is_wni").value = 'wna';
                                    document.getElementById("is_wni").value = 'wna';
                                    document.getElementById("data_wni").value = "WNA";
                                }
                            }else{
                                var a = document.getElementById('url_verification');
                                a.href = json.data.path_verified;

                                document.getElementById("status_akun").textContent= json.data.status_verified_account;
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

            var total_anggota   = $('#total_anggota').val();

            var email_anggotake1    = $('#email_anggotake1').val();
            var email_anggotake2    = $('#email_anggotake2').val();
            var email_anggotake3    = $('#email_anggotake3').val();
            var email_anggotake4    = $('#email_anggotake4').val();
            var email_anggotake5    = $('#email_anggotake5').val();
            var email_anggotake6    = $('#email_anggotake6').val();
            var email_anggotake7    = $('#email_anggotake7').val();
            var email_anggotake8    = $('#email_anggotake8').val();
            var email_anggotake9    = $('#email_anggotake9').val();

            var kw_anggotake1       = $('#kw_anggotake1').val();
            var kw_anggotake2       = $('#kw_anggotake2').val();
            var kw_anggotake3       = $('#kw_anggotake3').val();
            var kw_anggotake4       = $('#kw_anggotake4').val();
            var kw_anggotake5       = $('#kw_anggotake5').val();
            var kw_anggotake6       = $('#kw_anggotake6').val();
            var kw_anggotake7       = $('#kw_anggotake7').val();
            var kw_anggotake8       = $('#kw_anggotake8').val();
            var kw_anggotake9       = $('#kw_anggotake9').val();

            for(let i=1; i < total_anggota; i++){
                var text_anggota = `#email_anggotake${i}`;
                // console.log(text_anggota);
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
                    kw_anggotake9: kw_anggotake9
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
                var total_anggota = $('#total_anggota').val();
                var gunung = $('#gunung').val();
                var pos = $('#pos').val();
                var  kewarganegaraan = $('#ketua_is_wni').val();
                var  total_anggota = $('#total_anggota').val();
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
                            div_summary.style.display = "none";
                            profile_pemesan.style.display = "none";
                            div_anggota.style.display = "none";
                            div_button.style.display = "none";
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
                            div_summary.style.display = "block";
                            profile_pemesan.style.display = "block";
                            div_anggota.style.display = "block";
                            div_button.style.display = "block";
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
                                    text += "<span style='color: red' id='informasi_anggota"+i+"'>email belum terdaftar</span>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "<div class='col-md-2'>";
                                    text += "<div class='form-group'>";
                                    text += "<div class='input-group' style='margin-top: 5px;'>";
                                    text += "<button type='button' style='display: block;border-radius: 10px;'  name='cek_anggota"+i+"' id='cek_anggota"+i+"' class='btn btn-info btn-sm cek_anggota"+i+"'>";
                                    text += "<span id='btn-text-proses"+i+"'>Tambah</span>";
                                    text += "<div class='spinner-border spinner-border-sm' id='loading"+i+"' style='display: none;'>";
                                    text += "<span class='sr-only'>Loading...</span>";
                                    text += "</div>";
                                    text += "</button>";
                                    text += "<button type='button' style='display: none;border-radius: 10px;' name='detail_anggota"+i+"' id='detail_anggota"+i+"' class='btn btn-info btn-sm detail_anggota"+i+"'>Detail</button>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "<div class='col-md-2'>";
                                    text += "<div class='form-group'>";
                                    text += "<div class='input-group' style='margin-top: 10px;font-weight: bold;'>";
                                    text += "<span id='anggota_status"+i+"'></span>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "<div class='col-md-2'>";
                                    text += "<div class='form-group'>";
                                    text += "<div class='input-group' style='margin-top: 5px;'>";
                                    text += "<button type='button' style='display: none' name='batal_anggota"+i+"' id='batal_anggota"+i+"' class='btn btn-danger btn-sm batal_anggota"+i+"'>Batal</button>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</div>";
                                    text += "</form>";
                                }
                                $("#form_anggota").append(text);

                                $('#cek_anggota1').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake1").val();

                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses1').hide()
                                            $('#loading1').show()
                                            $('#cek_anggota1').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses1').show()
                                            $('#loading1').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota1').prop('disabled', false)
                                                var text = document.getElementById("anggota_status1");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota1 = document.getElementById("batal_anggota1");
                                                batal_anggota1.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status1");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota1').disabled = true;
                                                document.getElementById('email_anggotake1').readOnly = true;
                                                var batal_anggota1 = document.getElementById("batal_anggota1");
                                                batal_anggota1.style.display = "block";

                                                var email_anggotake1 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake1 = "wni";
                                                }else{
                                                    var kw_anggotake1 = "wna";
                                                }

                                                document.getElementById("email_anggotake1").value = email;
                                                document.getElementById("kw_anggotake1").value = kw_anggotake1;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota1').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = "";
                                    var kw_anggotake1       = ""
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake1").value = email_anggotake1;
                                    document.getElementById("kw_anggotake1").value = kw_anggotake1;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status1");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota1 = document.getElementById("batal_anggota1");
                                                batal_anggota1.style.display = "none";
                                                document.getElementById('email_anggotake1').readOnly = false;
                                                document.getElementById('cek_anggota1').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-2 ==============================
                                $('#cek_anggota2').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake2").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();

                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses2').hide()
                                            $('#loading2').show()
                                            $('#cek_anggota2').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses2').show()
                                            $('#loading2').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota2').prop('disabled', false)
                                                var text = document.getElementById("anggota_status2");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota1 = document.getElementById("batal_anggota2");
                                                batal_anggota1.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status2");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota2').disabled = true;
                                                document.getElementById('email_anggotake2').readOnly = true;
                                                var batal_anggota2 = document.getElementById("batal_anggota2");
                                                batal_anggota2.style.display = "block";

                                                var email_anggotake2 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake2 = "wni";
                                                }else{
                                                    var kw_anggotake2 = "wna";
                                                }

                                                document.getElementById("email_anggotake2").value = email;
                                                document.getElementById("kw_anggotake2").value = kw_anggotake2;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota2').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = ""
                                    var kw_anggotake2       = ""
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake2").value = email_anggotake2;
                                    document.getElementById("kw_anggotake2").value = kw_anggotake2;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status2");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota2 = document.getElementById("batal_anggota2");
                                                batal_anggota2.style.display = "none";
                                                document.getElementById('email_anggotake2').readOnly = false;
                                                document.getElementById('cek_anggota2').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-3 ==============================
                                $('#cek_anggota3').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake3").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();

                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses3').hide()
                                            $('#loading3').show()
                                            $('#cek_anggota3').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses3').show()
                                            $('#loading3').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota3').prop('disabled', true)
                                                var text = document.getElementById("anggota_status3");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota3 = document.getElementById("batal_anggota3");
                                                batal_anggota3.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status3");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota3').disabled = true;
                                                document.getElementById('email_anggotake3').readOnly = true;
                                                var batal_anggota3 = document.getElementById("batal_anggota3");
                                                batal_anggota3.style.display = "block";

                                                var email_anggotake3 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake3 = "wni";
                                                }else{
                                                    var kw_anggotake3 = "wna";
                                                }

                                                document.getElementById("email_anggotake3").value = email;
                                                document.getElementById("kw_anggotake3").value = kw_anggotake3;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota3').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = "";
                                    var kw_anggotake3       = "";
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake3").value = email_anggotake3;
                                    document.getElementById("kw_anggotake3").value = kw_anggotake3;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status3");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota3 = document.getElementById("batal_anggota3");
                                                batal_anggota3.style.display = "none";
                                                document.getElementById('email_anggotake3').readOnly = false;
                                                document.getElementById('cek_anggota3').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-4 ==============================
                                $('#cek_anggota4').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake4").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();

                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses4').hide()
                                            $('#loading4').show()
                                            $('#cek_anggota4').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses4').show()
                                            $('#loading4').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota4').prop('disabled', false)
                                                var text = document.getElementById("anggota_status4");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota4 = document.getElementById("batal_anggota4");
                                                batal_anggota4.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status4");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota4').disabled = true;
                                                document.getElementById('email_anggotake4').readOnly = true;
                                                var batal_anggota4 = document.getElementById("batal_anggota4");
                                                batal_anggota4.style.display = "block";

                                                var email_anggotake4 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake4 = "wni";
                                                }else{
                                                    var kw_anggotake4 = "wna";
                                                }

                                                document.getElementById("email_anggotake4").value = email;
                                                document.getElementById("kw_anggotake4").value = kw_anggotake4;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota4').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = "";
                                    var kw_anggotake4       = "";
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake4").value = email_anggotake4;
                                    document.getElementById("kw_anggotake4").value = kw_anggotake4;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status4");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota4 = document.getElementById("batal_anggota4");
                                                batal_anggota4.style.display = "none";
                                                document.getElementById('email_anggotake4').readOnly = false;
                                                document.getElementById('cek_anggota4').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-5 ==============================
                                $('#cek_anggota5').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake5").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();

                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses5').hide()
                                            $('#loading5').show()
                                            $('#cek_anggota5').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses5').show()
                                            $('#loading5').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota5').prop('disabled', false)
                                                var text = document.getElementById("anggota_status5");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota5 = document.getElementById("batal_anggota5");
                                                batal_anggota5.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status5");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota5').disabled = true;
                                                document.getElementById('email_anggotake5').readOnly = true;
                                                var batal_anggota5 = document.getElementById("batal_anggota5");
                                                batal_anggota5.style.display = "block";

                                                var email_anggotake5 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake5 = "wni";
                                                }else{
                                                    var kw_anggotake5 = "wna";
                                                }

                                                document.getElementById("email_anggotake5").value = email;
                                                document.getElementById("kw_anggotake5").value = kw_anggotake5;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota5').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = "";
                                    var kw_anggotake5       = "";
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake5").value = email_anggotake5;
                                    document.getElementById("kw_anggotake5").value = kw_anggotake5;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status5");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota5 = document.getElementById("batal_anggota5");
                                                batal_anggota5.style.display = "none";
                                                document.getElementById('email_anggotake5').readOnly = false;
                                                document.getElementById('cek_anggota5').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-6 ==============================
                                $('#cek_anggota6').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake6").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();

                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses6').hide()
                                            $('#loading6').show()
                                            $('#cek_anggota6').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses6').show()
                                            $('#loading6').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota6').prop('disabled', false)
                                                var text = document.getElementById("anggota_status6");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota6 = document.getElementById("batal_anggota6");
                                                batal_anggota6.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status6");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota6').disabled = true;
                                                document.getElementById('email_anggotake6').readOnly = true;
                                                var batal_anggota6 = document.getElementById("batal_anggota6");
                                                batal_anggota6.style.display = "block";

                                                var email_anggotake6 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake6 = "wni";
                                                }else{
                                                    var kw_anggotake6 = "wna";
                                                }

                                                document.getElementById("email_anggotake6").value = email;
                                                document.getElementById("kw_anggotake6").value = kw_anggotake6;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota6').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = "";
                                    var kw_anggotake6       = "";
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake6").value = email_anggotake6;
                                    document.getElementById("kw_anggotake6").value = kw_anggotake6;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status6");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota6 = document.getElementById("batal_anggota6");
                                                batal_anggota6.style.display = "none";
                                                document.getElementById('email_anggotake6').readOnly = false;
                                                document.getElementById('cek_anggota6').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-7 ==============================
                                $('#cek_anggota7').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake7").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();

                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses7').hide()
                                            $('#loading7').show()
                                            $('#cek_anggota7').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses7').show()
                                            $('#loading7').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota7').prop('disabled', false)
                                                var text = document.getElementById("anggota_status7");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota7 = document.getElementById("batal_anggota7");
                                                batal_anggota7.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status7");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota7').disabled = true;
                                                document.getElementById('email_anggotake7').readOnly = true;
                                                var batal_anggota7 = document.getElementById("batal_anggota7");
                                                batal_anggota7.style.display = "block";

                                                var email_anggotake7 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake7 = "wni";
                                                }else{
                                                    var kw_anggotake7 = "wna";
                                                }

                                                document.getElementById("email_anggotake7").value = email;
                                                document.getElementById("kw_anggotake7").value = kw_anggotake7;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota7').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = "";
                                    var kw_anggotake7       = "";
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake7").value = email_anggotake7;
                                    document.getElementById("kw_anggotake7").value = kw_anggotake7;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status7");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota7 = document.getElementById("batal_anggota7");
                                                batal_anggota7.style.display = "none";
                                                document.getElementById('email_anggotake7').readOnly = false;
                                                document.getElementById('cek_anggota7').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

// ============================= respon ke-8 ==============================
                                $('#cek_anggota8').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake8").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();

                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();
                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses8').hide()
                                            $('#loading8').show()
                                            $('#cek_anggota8').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses8').show()
                                            $('#loading8').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota8').prop('disabled', false)
                                                var text = document.getElementById("anggota_status8");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota8 = document.getElementById("batal_anggota8");
                                                batal_anggota8.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status8");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota8').disabled = true;
                                                document.getElementById('email_anggotake8').readOnly = true;
                                                var batal_anggota8 = document.getElementById("batal_anggota8");
                                                batal_anggota8.style.display = "block";

                                                var email_anggotake8 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake8 = "wni";
                                                }else{
                                                    var kw_anggotake8 = "wna";
                                                }

                                                document.getElementById("email_anggotake8").value = email;
                                                document.getElementById("kw_anggotake8").value = kw_anggotake8;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota8').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = "";
                                    var kw_anggotake8       = "";
                                    var email_anggotake9    = $("#email_anggotake9").val();
                                    var kw_anggotake9       = $("#kw_anggotake9").val();

                                    document.getElementById("email_anggotake8").value = email_anggotake8;
                                    document.getElementById("kw_anggotake8").value = kw_anggotake8;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status8");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota8 = document.getElementById("batal_anggota8");
                                                batal_anggota8.style.display = "none";
                                                document.getElementById('email_anggotake8').readOnly = false;
                                                document.getElementById('cek_anggota8').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });


// ============================= respon ke-9 ==============================
                                $('#cek_anggota9').click(function () {
                                    var email_ketua = $("#email").val();
                                    var token_user  = $('#token_user').val();
                                    var email       = $("#email_anggotake9").val();

                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();

                                    $.ajax({type: "POST",url: "api/cek_email_anggota.php",
                                        data:{
                                            token_user: token_user,
                                            email: email,
                                        },
                                        beforeSend: function() {
                                            $('#btn-text-proses9').hide()
                                            $('#loading9').show()
                                            $('#cek_anggota9').prop('disabled', true)
                                        },
                                        complete: function() {
                                            $('#btn-text-proses9').show()
                                            $('#loading9').hide()
                                        },
                                        success: function (response) {
                                            var json = $.parseJSON(response);
                                            if (json.error){
                                                $('#cek_anggota9').prop('disabled', false)
                                                var text = document.getElementById("anggota_status9");
                                                text.textContent = "INVALID";
                                                text.style.color = "red";
                                                var batal_anggota9 = document.getElementById("batal_anggota9");
                                                batal_anggota9.style.display = "none";
                                            }else{
                                                var text = document.getElementById("anggota_status9");
                                                text.textContent = "VALID";
                                                text.style.color = "green";

                                                document.getElementById('cek_anggota9').disabled = true;
                                                document.getElementById('email_anggotake9').readOnly = true;
                                                var batal_anggota9 = document.getElementById("batal_anggota9");
                                                batal_anggota9.style.display = "block";

                                                var email_anggotake9 = email;
                                                if (json.data.user.is_wni){
                                                    var kw_anggotake9 = "wni";
                                                }else{
                                                    var kw_anggotake9 = "wna";
                                                }

                                                document.getElementById("email_anggotake9").value = email;
                                                document.getElementById("kw_anggotake9").value = kw_anggotake9;

                                                $.ajax({
                                                    type    : "POST",
                                                    url     : "core/cek_tiket_anggota.php",
                                                    data    : {
                                                        gunung: gunung,
                                                        pos: pos,
                                                        email_ketua: email_ketua,
                                                        kewarganegaraan: kewarganegaraan,
                                                        start_date: start_date,
                                                        end_date: end_date,
                                                        total_anggota: total_anggota,
                                                        email_anggotake1: email_anggotake1,
                                                        kw_anggotake1: kw_anggotake1,
                                                        email_anggotake2: email_anggotake2,
                                                        kw_anggotake2: kw_anggotake2,
                                                        email_anggotake3: email_anggotake3,
                                                        kw_anggotake3: kw_anggotake3,
                                                        email_anggotake4: email_anggotake4,
                                                        kw_anggotake4: kw_anggotake4,
                                                        email_anggotake5: email_anggotake5,
                                                        kw_anggotake5: kw_anggotake5,
                                                        email_anggotake6: email_anggotake6,
                                                        kw_anggotake6: kw_anggotake6,
                                                        email_anggotake7: email_anggotake7,
                                                        kw_anggotake7: kw_anggotake7,
                                                        email_anggotake8: email_anggotake8,
                                                        kw_anggotake8: kw_anggotake8,
                                                        email_anggotake9: email_anggotake9,
                                                        kw_anggotake9: kw_anggotake9
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
                                                                summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                    return false;
                                });

                                $('#batal_anggota9').click(function () {
                                    var email_ketua = $("#email").val();
                                    var email_anggotake1    = $("#email_anggotake1").val();
                                    var kw_anggotake1       = $("#kw_anggotake1").val();
                                    var email_anggotake2    = $("#email_anggotake2").val();
                                    var kw_anggotake2       = $("#kw_anggotake2").val();
                                    var email_anggotake3    = $("#email_anggotake3").val();
                                    var kw_anggotake3       = $("#kw_anggotake3").val();
                                    var email_anggotake4    = $("#email_anggotake4").val();
                                    var kw_anggotake4       = $("#kw_anggotake4").val();
                                    var email_anggotake5    = $("#email_anggotake5").val();
                                    var kw_anggotake5       = $("#kw_anggotake5").val();
                                    var email_anggotake6    = $("#email_anggotake6").val();
                                    var kw_anggotake6       = $("#kw_anggotake6").val();
                                    var email_anggotake7    = $("#email_anggotake7").val();
                                    var kw_anggotake7       = $("#kw_anggotake7").val();
                                    var email_anggotake8    = $("#email_anggotake8").val();
                                    var kw_anggotake8       = $("#kw_anggotake8").val();
                                    var email_anggotake9    = "";
                                    var kw_anggotake9       = "";

                                    document.getElementById("email_anggotake9").value = email_anggotake9;
                                    document.getElementById("kw_anggotake9").value = kw_anggotake9;

                                    $.ajax({
                                        type    : "POST",
                                        url     : "core/cek_tiket_anggota.php",
                                        data    : {
                                            gunung: gunung,
                                            pos: pos,
                                            email_ketua: email_ketua,
                                            kewarganegaraan: kewarganegaraan,
                                            start_date: start_date,
                                            end_date: end_date,
                                            total_anggota: total_anggota,
                                            email_anggotake1: email_anggotake1,
                                            kw_anggotake1: kw_anggotake1,
                                            email_anggotake2: email_anggotake2,
                                            kw_anggotake2: kw_anggotake2,
                                            email_anggotake3: email_anggotake3,
                                            kw_anggotake3: kw_anggotake3,
                                            email_anggotake4: email_anggotake4,
                                            kw_anggotake4: kw_anggotake4,
                                            email_anggotake5: email_anggotake5,
                                            kw_anggotake5: kw_anggotake5,
                                            email_anggotake6: email_anggotake6,
                                            kw_anggotake6: kw_anggotake6,
                                            email_anggotake7: email_anggotake7,
                                            kw_anggotake7: kw_anggotake7,
                                            email_anggotake8: email_anggotake8,
                                            kw_anggotake8: kw_anggotake8,
                                            email_anggotake9: email_anggotake9,
                                            kw_anggotake9: kw_anggotake9
                                        },
                                        success: function (response) {
                                            var det_json = $.parseJSON(response);
                                            if (det_json.error){

                                            }else{
                                                var text = document.getElementById("anggota_status9");
                                                text.textContent = "-";
                                                text.style.color = "gray";

                                                var batal_anggota9 = document.getElementById("batal_anggota9");
                                                batal_anggota9.style.display = "none";
                                                document.getElementById('email_anggotake9').readOnly = false;
                                                document.getElementById('cek_anggota9').disabled = false;

                                                $("#summary").html("");
                                                var summary_text = "";
                                                document.getElementById("summary_total_bayar").textContent= det_json.data.total_bayar;
                                                $.each(det_json.data.detail, function (key, value) {
                                                    summary_text += "</li>";
                                                    summary_text += "Tanggal"+ value.waktu +" ("+value.status_hari+")";
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
                                });

                            }else{
                                div_anggota.style.display = "none";
                            }
                        }
                    }
                });
                return false;
            });
        });


        $.ajax({
            type: 'POST',
            url: "core/gunung.php",
            cache: false,
            success: function(msg){
                $("#gunung").html(msg);
            }
        });

        $("#gunung").change(function(){
            var gunung_id = $("#gunung").val();
            $.ajax({
                type: 'POST',
                url: "core/cek_max_date.php",
                data: {gunung_id: gunung_id},
                cache: false,
                success: function (response) {
                    var json = $.parseJSON(response);
                    document.getElementById("max_date").value = json.data;
                    var max_date = $("#max_date").val();
                    let num = parseInt(max_date);
                    flatpickr('#start_date', {
                        allowInput: false,
                        disableMobile: "true",
                        minDate : "today",
                        maxDate: new Date().fp_incr(30),
                        onClose: function(selectedDates, dateStr, instance) {
                            endpicker.set('minDate', dateStr);
                            const date = new Date(dateStr);
                            date.setDate(date.getDate() + num);
                            endpicker.set('maxDate', date);
                        },
                    });

                    let endpicker = flatpickr('#end_date', {
                        allowInput: false,
                        disableMobile: "true",
                    });
                }
            });
        });

        $("#gunung").change(function(){
            var gunung_id = $("#gunung").val();
            $.ajax({
                type: 'POST',
                url: "core/pos.php",
                data: {gunung_id: gunung_id},
                cache: false,
                success: function(msg){
                    $("#pos").html(msg);
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
                }
            });
        });
    </script>
  </body>

</html>
