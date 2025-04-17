<?php
	session_start();
  $_SESSION['loggedin']   = 'TRUE';
  include 'config.php';
?>

<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/logo.png">
  <title>
    SOP Pendakian Gunung Arjuno Welirang Pundak
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

	<section class="pt-3 pt-md-5 pb-md-5 pt-lg-8 bg-gray-200">
	  <div class="container">
	    <div class="row">
	      <div class="col-lg-3 mb-lg-0 mb-5 mt-8 mt-md-5 mt-lg-0">
	        <ul class="nav flex-column bg-white border-radius-lg p-3 position-sticky top-10 shadow-lg">
	          <li class="nav-item">
	            <a class="nav-link text-dark d-flex align-items-center" data-scroll href="#satu">
	              <i class="material-icons text-dark opacity-5 pe-2">wysiwyg</i> Ketentuan umum </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-dark d-flex align-items-center" data-scroll href="#dua">
	              <i class="material-icons text-dark opacity-5 pe-2">wysiwyg</i> Tarif </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-dark d-flex align-items-center" data-scroll href="#tiga">
	              <i class="material-icons text-dark opacity-5 pe-2">wysiwyg</i> Pelaksanaan Pendakian </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-dark d-flex align-items-center" data-scroll href="#empat">
	              <i class="material-icons text-dark opacity-5 pe-2">wysiwyg</i> Larangan </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-dark d-flex align-items-center" data-scroll href="#lima">
	              <i class="material-icons text-dark opacity-5 pe-2">wysiwyg</i> Booking </a>
	          </li>
	        </ul>
	      </div>
	      <div class="col-lg-9">
					<div class="card shadow-lg mb-5">
	          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
	            <div class="bg-gradient-primary shadow-primary border-radius-lg p-3">
	              <h3 class="text-white mb-0">Syarat dan Ketentuan</h3>
	              <p class="text-white opacity-8 mb-0">Cermati dan taati peraturan sesuai dengan SOP yang telah ditetapkan.</p>
	            </div>
	          </div>
	          <div class="card-body p-5">
	            <h3 class="mt-5 mb-3" id="satu">Pendaftaran Pendakian</h3>
	            <p>Pendaftaran pendakian di kawasan Tahura Raden Soerjo dilakukan dengan sistem Booking Online, dengan ketentuan sebagai berikut :</p>
	            <ul>
	              <li>Jam Pelayanan <b class="text-primary">Verifikasi Pembayaran</b> dilakukan pada hari Senin s/d Jumat jam 08.00 s/d 15.30 WIB. Proses verifikasi maksimal 1x24 jam hari kerja setelah melakukan pembayaran.</li>
	              <li>Booking dilakukan maksimal 2 (dua) hari sebelum melakukan pendakian (H-2).</li>
	              <li>Jam pelayanan perizinan pendakian di pos pendakian pukul 08.00 - 20.00 WIB.</li>
	              <li>Batas durasi pendakian yang diizinkan maksimal 3 (tiga) hari 2 (dua) malam.</li>
	              <li>Surat Izin Masuk Kawasan Konservasi (eSIMAKSI) diberikan pada kelompok dengan jumlah anggota minimal 3 orang dan menunjuk 1 orang sebagai ketua kelompok yang bertanggung jawab terhadap administrasi pendaki dan keselamatan anggota kelompoknya.</li>
	              <li>Pendaftaran diberlakukan bagi calon pendaki, baik nusantara maupun mancanegara;</li>
	              <li>Pendaki mancanegara wajib menggunakan jasa Guide sebagai penanggung jawab ketua rombongan;</li>
	              <li>Pendaftaran <b class="text-primary">secara online</b> melalui website resmi Tahura Raden Soerjo;</li>
	              <li>Konfirmasi pendaftaran akan diterima ketua rombongan melalui email atau whatsapp. Pastikan alamat email dan nomor telepon benar dan sesuai. Apabila tidak ada pesan pemberitahuan pada kotak masuk email, harap periksa pada kotak SPAM.</li>
	              <li>Calon pendaki diizinkan melakukan pergantian anggota maksimal 1 (satu) kali, dengan batasan waktu 2 (dua) hari (H-2) sebelum keberangkatan. Ketua rombongan tidak dapat digantikan. Anggota kelompok yang dapat diganti maksimal 50% dari jumlah anggota.</li>
	              <li>Penambahan anggota hanya bisa dilakukan sebelum pendaki melakukan pembayaran.</li>
	              <li>Pendaki harus melaksanakan pendakian sesuai dengan tanggal naik dan turun sesuai pada SIMAKSI. Petugas berhak menangguhkan jika pendaki naik tidak sesuai dengan tanggal pada SIMAKSI.</li>
	              <li>Petugas pos perizinan berhak menolak pendaki yang terdaftar dalam <i>blacklist</i> dan pendaki yang tidak memenuhi persyaratan pendakian. </li>
	              <li><b class="text-dark">BAGI YANG TERBUKTI MELAKUKAN MANIPULASI DAN/ATAU PEMALSUAN DATA, MAKA BOOKING AKAN DIBATALKAN DAN DIMASUKKAN DALAM <i>BLACKLIST.</i></b></li>
	            </ul>

	            <h3 class="mt-5 mb-3" id="dua">Tarif dan Pembayaran</h3>
	            <p>Setiap pendaki di kawasan Tahura Raden Soerjo dikenakan tarif karcis masuk sesuai dengan ketentuan pada Peraturan Daerah Provinsi Jawa Timur tentang Pajak Daerah dan Retribusi Daerah No. 8 Tahun 2023. Bila terdapat aturan/kebijakan baru tentang tarif karcis masuk di kawasan konservasi, maka tarif karcis pendakian akan disesuaikan sebagaimana peraturan terbaru tersebut.</p>
	            <ol>
	              <li>
                  <p><b>Tarif Pendakian Gunung Arjuno-Welirang dan Bukit Lincing</b></p>
                  <p>Pendaki WNI : Rp. 20.000,- / orang / hari </p>
                  <p>Pendaki WNA : Rp. 200.000,- / orang / hari </p>
                </li>
                <li>
                  <p><b>Tarif Pendakian Gunung Pundak dan Bukit Cendono</b></p>
                  <p>Pendaki WNI : Rp. 10.000,- / orang / hari </p>
                  <p>Pendaki WNA : Rp. 200.000,- / orang / hari </p>
                </li>
                <li>
                  <p><b>Asuransi (pembayaran di pos)</b></p>
                  <p>Gunung Arjuno-Welirang dan Bukit Lincing : Rp. 10.000,- / orang </p>
                  <p>Gunung Pundak dan Bukit Cendono : Rp. 1.000,- / orang / hari </p>
                </li>
                <li>
                	<p><b>Pertanggung jawaban asuransi :</b></p>
                	<p>
                		<ul>
	                  	<li>Meninggal dunia : Rp. 5.000.000</li>
	                  	<li>Cacat tetap : Rp. 5.000.000</li>
	                  	<li>Biaya perawatan : Rp. 500.000</li>
	                  	<li>Pihak asuransi tidak menanggung biaya evakuasi</li>
	                  </ul>
                	</p>
                </li>
                <li>
                  <p><b>Tarif Karcis Kendaraan Roda 2</b></p>
                  <p>Rp. 5.000,- / unit</p>
                </li>
                <li>
                  <p><b>Tarif Karcis Kendaraan Roda 4</b></p>
                  <p>Rp. 10.000,- / unit</p>
                </li>
                <li>
                  <p><b>Biaya Retribusi Penggunaan Kamera</b></p>
                  <p>Rp. 150.000,- / unit</p>
                </li>
                <li>
                  <p><b>Fasilitas berbayar (Sumber Brantas)</b></p>
                  <p>Ojek Pickup : Rp. 25.000,- / orang / sekali jalan <br>
                  Sewa Loker : Rp. 5.000,- / ruang <br>
                  Kamar mandi air hangat : Rp. 10.000,- / ruang</p>
                </li>
	              <li>Pembayaran eSIMAKSI hanya melalui transfer ke nomor Virtual Account yang didapat setelah melakukan booking;</li>
	              <li>Batas waktu pembayaran Virtual Account maksimal 6 (enam) jam setelah melakukan pendaftaran dan jika melebihi waktu yang telah ditentukan maka booking hangus;</li>
	              <li>Konfirmasi pembayaran akan diterima oleh ketua rombongan melalui email atau whatsapp;</li>
	              <li>Tidak dapat melakukan pengembalian uang <b><i class="text-primary">(refund)</i></b> eSIMAKSI yang telah dibayar;</li>
	              <li>Jika terjadi <i>force majeure</i> (kebakaran hutan, bencana alam, cuaca ekstrim dan kegiatan lainnya) maka pendakian dapat ditutup sewaktu-waktu dan pendaki dapat menjadwalkan ulang <i>(reschedule)</i> pada hari lain yang tersedia kuotanya.</li>
	              <li><b><i class="text-primary">Reschedule</i></b> hanya berlaku sesuai ketentuan pada nomor 13</li>
	              <li>Pembayaran Asuransi dan Karcis Kendaraan dilakukan di pos pendakian resmi Tahura Raden Soerjo</li>
	              <li>Pendaki akan dikenakan denda keterlambatan jika turun melebihi tanggal pada SIMAKSI. Jumlah denda disesuaikan dengan jumlah hari keterlambatan.</li>
	            </ol>
	           	
	           	<h3 class="mt-5 mb-3" id="tiga">Pelaksanaan Pendakian</h3>
	           	<ol>
	           		<li>
	           			Bukti konfirmasi berupa QR Code yang ada pada berkas eSIMAKSI menjadi alat bukti masuk ke dalam kawasan ketika melewati pos pendakian Tretes, pos pendakian Lawang, pos pendakian Tambaksari, pos pendakian Sumber Brantas, Gunung Pundak, dan Bukit Watu jengger.
	           		</li>
	           		<li>
	           			Persyaratan memperoleh izin pendakian :
	           			<ul>
	           				<li>Menunjukkan eSIMAKSI (Surat Izin Masuk Kawasan Konservasi) menjadi syarat untuk memperoleh perizinan pendakian di kawasan Tahura Raden Soerjo;</li>
	           				<li>Bukti identitas asli ketua (KTP/Kartu Pelajar/KTM/SIM/Pasport) wajib diserahkan kepada petugas selama masa pendakian;</li>
	           				<li>Remaja usia 10-18 tahun harap menyertakan Surat Keterangan izin orang tua/wali dan didampingi orang dewasa sebagai penanggung jawab.</li>
	           				<li>Anak-anak usia 6-9 tahun harap menyertakan Surat Pernyataan dari orang tua, bertanggung jawab atas segala resiko yang terjadi selama kegiatan pendakian.</li>
	           				<li>Balita usia 0-5 tahun tidak diperkenankan melakukan kegiatan pendakian.</li>
	           				<li>Setiap pendaki khususnya pendakian gunung Arjuno Welirang wajib menyertakan Surat Keterangan Sehat yang dikeluarkan oleh Rumah Sakit, Puskesmas, Dokter Praktek, Klinik yang diterbitkan maksimal H-2 sebelum melakukan pendakian.</li>
	           				<li>Ketua kelompok bertanggung jawab terhadap kelengkapan administrasi, keselamatan anggota dan bertanggungjawab membawa sampah turun kembali;</li>
	           				<li>Proses pemeriksaan perlengkapan barang dan logistik dilakukan oleh petugas pos pendakian sesuai dengan form eSIMAKSI.</li>
	           				<li>Semua calon pendaki wajib mengikuti pengarahan/briefing;</li>
	           			</ul>
	           		</li>
	           		<li>Membayar Asuransi yang dikeluarkan oleh PT. ASURANSI JASARAHARJA PUTERA sesuai dengan jumlah personil. Pastikan untuk menyimpan tiket asuransi tersebut hingga pendakian selesai.</li>
	           		<li>Pada saat melakukan pendakian agar berjalan secara berkelompok, tidak memisahkan diri dari kelompok/rombongan, berjalan sesuai jalur yang sudah ditetapkan dan dilarang memotong jalur atau membuat jalur baru. Menjaga keselamatan kelompok dan sesama pengunjung/pendaki serta menjaga kebersihan dan keamanan kawasan.</li>
	           		<li>Kegiatan yang bersifat massal (reboisasi, diklat, lomba, upacara, dll) atau dalam bentuk kegiatan khusus (penelitian dan survey) harus melalui proses pengajuan proposal ke kantor UPT Tahura Raden Soerjo paling lambat 14 hari sebelum kegiatan dilaksanakan.</li>
	           		<li>
	           			Dalam rangka pengamanan pendakian dan perlindungan keanekaragaman hayati, beberapa hal yang harus diperhatikan antara lain :
	           			<ul>
	           				<li>Setiap pendaki harus menggunakan perlengkapan/personal use yang memenuhi standar pendakian;</li>
	           				<li>Pendaki harus tetap berjalan pada jalur yang telah ditentukan;</li>
	           				<li>Pendaki harus mematuhi rekomendasi batas aman pendakian yang diberikan;</li>
	           				<li>Tempat mendirikan tenda hanya di lokasi yang telah ditentukan;</li>
	           				<li>Selama melakukan pendakian, setiap pendaki dihimbau untuk membawa jerigen portabel atau botol isi ulang.</li>
	           				<li>Pendaki yang turun harus melapor dan membawa kembali sampah untuk diperiksa oleh petugas di pos pendakian;</li>
	           			</ul>
	           		</li>
	           		<li>Apabila salah satu anggota rombongan mengalami sakit atau kecelakaan saat di tengah perjalanan pendakian maka diwajibkan untuk segera kembali ke Pos Pendakian didampingi oleh ketua atau anggota lainnya.</li>
	           		<li>Selesai melakukan pendakian, ketua wajib menunjukkan eSIMAKSI dan memastikan sampah yang di bawa turun sesuai, sebagai syarat untuk mengambil Kartu Identitas yang ditinggal di pos pendakian.</li>
	           		<li>
	           			Setiap pendaki diwajibkan untuk membawa :
	           			<ul>
	           				<li>Tenda kedap air;</li>
	           				<li>Ransel/carrier dengan kondisi baik, kuat dan nyaman selama melakukan pendakian;</li>
	           				<li>Matras, sleeping bag, sarung tangan, kaos kaki, bandana/kerpus/kupluk, sepatu, dan jas hujan sesuai standar pendakian;</li>
	           				<li>Lampu senter, head lamp dan baterai cadangan;</li>
	           				<li>Perbekalan logistik disesuaikan dengan rencana perjalanan dan jumlah anggota kelompok;</li>
	           				<li>Membawa obat-obatan pribadi (alat P3K);</li>
	           				<li>Disarankan menggunakan Tracking Pole.</li>
	           				<li>Membawa alat navigasi dan peta </li>
	           			</ul>
	           		</li>
	           		<li>Pendaki WAJIB NAIK dan TURUN di pos yang sama.</li>
	           		<li>Khusus untuk pendaki Warga Negara Asing :
	           			<ul>
	           				<li>Pendaki Warga Negara Asing wajib didampingi pemandu lokal (guide).</li>
	           				<li>Pemandu bertanggung jawab penuh terhadap tamu dan menaati peraturan yang berlaku.</li>
	           				<li>Bagi Warga Negara Asing yang mempunyai KITAS tetap diberlakukan tarif Warga Negara Asing.</li>
	           				<li>Jasa pemandu (guide) dapat diperoleh melalui aplikasi Tiket Pendakian.</li>
	           			</ul>
	           		</li>
	           	</ol>

	           	<h3 class="mt-5 mb-3" id="empat">Larangan</h3>
	           	Dalam rangka mempertahankan nilai penting keanekaragaman hayati & ekosistem, maka selama kegiatan pendakian di wilayah Arjuno Welirang, Pundak, Watu Jengger harus memperhatikan :
           			<ul>
           				<li><b>DILARANG MEMAKAI SANDAL GUNUNG</b></li>
           				<li><b>Pendaki dilarang membawa atau menggunakan Drone selama berada di kawasan gunung Arjuno Welirang</b></li>
           				<li><b>Dilarang membawa dan/atau menggunakan pengeras suara/sound speaker selama berada di kawasan gunung Arjuno Welirang dan Pundak.</b></li>
           				<li>Pendaki gunung Arjuno-Welirang tidak diperkenankan melakukan pendakian Tektok</li>
           				<li>Pendaki tidak diperbolehkan lintas jalur</li>
           				<li>Dilarang membawa alat-alat yang terindikasi digunakan untuk melakukan tindakan yang mengakibatkan kerusakan flora/fauna, melakukan coretan-coretan/vandalisme pada benda-benda,pohon atau bangunan didalam kawasan.</li>
           				<li>Dilarang memaksakan diri untuk melanjutkan perjalanan jika kondisi dan situasi tidak memungkinkan (kesehatan, cuaca, keamanan).</li>
           				<li>Dilarang melanggar norma agama, norma asusila, norma budaya dan nilai-nilai adat istiadat masyarakat setempat.</li>
           				<li>Dilarang membawa dan minum-minuman keras (beralkohol) membawa dan menggunakan obat-obat terlarang (narkoba).</li>
           				<li>Dilarang membuat bangunan permanen, semi permanen dengan tujuan tertentu tanpa ada surat izin dari UPT Tahura Raden Soerjo dan mengetahui Dinas Purbakala.</li>
           				<li>Dilarang Merubah bentuk asli, Merusak, Memugar, Mencuri, Memindah letak lokasi, Mengganti yang asli dengan Replika situs Purbakala di dalam kawasan Tahura Raden Soerjo.</li>
           				<li>Dilarang membuang sampah sembarangan dan wajib membawa sampah anda turun kembali.</li>
           				<li>Dilarang membawa senjata tajam dan senjata api yang tidak selayaknya untuk kegiatan pendakian.</li>
           				<li>Dilarang membuat api unggun dari kayu atau sampah untuk tujuan apapun;</li>
           				<li>Dilarang Melakukan tindakan yang mengakibatkan kerusakan flora / fauna serta vandalism.</li>
           			</ul>
	          </div>
	        </div>
	        <div class="card shadow-lg mb-5">
	          <div class="card-body p-5">
	          	<h3 class="mb-3" id="lima">Checklist</h3>
	          	<div class="mb-4 d-flex align-items-center">
                <input class="language" type="checkbox" >
                <span class=" ms-3 mb-0">Saya telah membaca, menyetujui, dan mengikuti semua peraturan dan ketentuan diatas</span>
              </div>
              <div class="d-flex align-items-center">
                <input class="language" type="checkbox" >
                <span class="ms-3 mb-0">Wajib untuk dibawa :</span>
              </div>
              <ol style="padding-left: 40px; font-size: 14px">
              	<li>eSIMAKSI (Surat Izin Masuk Kawasan Konservasi)</li>
              	<li>Membawa KTP/KTM/SIM/Paspor yang masih berlaku</li>
              	<li>Pendaki usia kurang dari 17 tahun wajib menunjukkan surat izin dari orangtua/wali (khusus pendakian Arjuno Welirang) <a href="surat_izin.pdf" target="_blank" class="text-primary">download</a> </li>
              	<li>Surat keterangan sehat (khusus pendakian Arjuno Welirang)</li>
              	<li>Membawa trash bag/kantong sampah</li>
              </ol>
						  <p class="note" style="color: red; display: none">centang persyaratan diatas</p>
						  <div class="row">
						  	<div class="col-md-12 text-center">
								<?php
									if (isset($_SESSION['uuid'])) { ?>
											<button type="submit" class="btn bg-gradient-primary mb-0 submit btn-rounded btn-lg mt-3">setuju</button>
									<?php } else { ?>
										<a href="register.php" class="btn bg-gradient-primary mb-0 btn-rounded btn-lg mt-3">Register</a>
										<a href="login.php" class="btn bg-gradient-primary mb-0 btn-rounded btn-lg mt-3">Login</a>
									<?php } ?>
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="./assets/js/material-kit-pro.min.js?v=3.0.2" type="text/javascript"></script>

    <script type="text/javascript">
      $(".submit").click(function(){
        if ($('.language').filter(':checked').length < 2){
       		$(".note").show();
          return false;
        }else{
          window.location.href = 'kapasitas.php';
        }
    	});
    </script>
  </body>

</html>