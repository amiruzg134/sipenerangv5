<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once ('../config/connection.php');
require_once ('../config/ektensi.php');
if (!isset($_SESSION['uuid_admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="dist/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="dist/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="dist/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

  </head>
  <body id="id_body" class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <a href="index.php" class="logo"><b>Admin</b></a>
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/avatar.jpg" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $_SESSION['nama_admin'] ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/avatar.jpg" class="img-circle" alt="User Image" />
                    <p>
                        <?php echo $_SESSION['nama_admin'] ?>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="core/logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/avatar.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['nama_admin'] ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
            <?php
                $sql = mysqli_query($conn, "SELECT * FROM user a JOIN tb_role_menu b ON a.user_id=b.rm_user_id WHERE a.user_id ='$_SESSION[uuid_admin]'");
                $row = mysqli_fetch_array($sql);
            ?>
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li id="li_dashboard">
                      <a class="button_menu" id="dashboard"><i class="fa fa-circle-o"></i> Report</a>
                  </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Master</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <?php
                  if ($row['rm_jabatan'] == 'Y') { ?>
                      <li id="li_jabatan">
                          <a class="button_menu" id="jabatan">Master Jabatan</a>
                      </li>
                  <?php }

                  if ($row['rm_gunung'] == 'Y') { ?>
                      <li id="li_gunung">
                          <a class="button_menu" id="gunung">Master Gunung Pendakian</a>
                      </li>
                      <li id="li_pembayaran">
                          <a class="button_menu" id="pembayaran">Master Pembayaran</a>
                      </li>
                  <?php }

                  if ($row['rm_pos'] == 'Y') { ?>
                      <li id="li_pos">
                          <a class="button_menu" id="pos">Master Pos Pendakian</a>
                      </li>
                  <?php }

                  if ($row['rm_pengguna'] == 'Y') { ?>
                      <li id="li_pengguna">
                          <a class="button_menu" id="pengguna">Master Pengguna</a>
                      </li>
                  <?php }

                  if ($row['rm_kuota'] == 'Y') { ?>
                      <li id="li_kuota">
                          <a class="button_menu" id="kuota">Master Kuota</a>
                      </li>
                  <?php } ?>
             </ul>
            </li>

              <?php
              if ($row['rm_pendaki'] == 'Y') { ?>
                  <li id="li_transaksi">
                      <a class="button_menu" id="transaksi">
                      <i class="fa fa-calendar"></i> <span>Transaksi</span>
                      </a>
                  </li>
              <?php } ?>
              <?php
              if ($row['rm_verification_account'] == 'Y') { ?>
                  <li id="li_verifikasi_akun">
                      <a class="button_menu" id="verifikasi-akun">
                          <i class="fa fa-envelope"></i> <span>Verifikasi Akun</span>
                      </a>
                  </li>
              <?php } ?>
              <?php
              if ($row['rm_konfigurasi'] == 'Y') {  ?>
                  <li id="li_konfigurasi">
                      <a class="button_menu" id="konfigurasi">
                          <i class="fa fa-envelope"></i> <span>Konfigurasi</span>
                      </a>
                  </li>
              <?php } ?>
              <?php
              if ($row['rm_laporan'] == 'Y') { ?>
                  <li id="li_laporan">
                      <a class="button_menu" id="laporan">
                          <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                      </a>
                  </li>
              <?php } ?>
<!--            <li>-->
<!--              <a href="pages/mailbox/mailbox.html">-->
<!--                <i class="fa fa-envelope"></i> <span>Laporan</span>-->
<!--                              <small class="label pull-right bg-yellow">12</small>-->
<!--              </a>-->
<!--            </li>-->

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content" id="data_konten">
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2024 sipenerang & tiket pendakian.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->


    <!-- jQuery 2.1.3 -->
    <script src="dist/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery UI 1.11.2 -->
    <!-- Bootstrap 3.3.2 JS -->
    <script src="dist/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <!-- Sparkline -->
    <script src="dist/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>

    <link href="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.js"></script>
    <!-- Datatable JS -->
    <link href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <!-- jQuery Knob Chart -->
    <script src="dist/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="dist/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="dist/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="dist/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='dist/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
  <script>
      $(document).ready(function(){
          $('.button_menu').click(function(){
              var menu = $(this).attr('id');
              if(menu === "dashboard"){
                  $('#data_konten').load('pages/dashboard/dashboard.php');
              }else if(menu === "jabatan"){
                  $('#data_konten').load('pages/master/jabatan.php');
              }else if(menu === "gunung"){
                  $('#data_konten').load('pages/master/gunung.php');
              }else if(menu === "pos"){
                  $('#data_konten').load('pages/master/pos.php');
              }else if(menu === "pembayaran"){
                  $('#data_konten').load('pages/master/pembayaran.php');
              }else if(menu === "pengguna"){
                  $('#data_konten').load('pages/master/pengguna.php');
              }else if(menu === "kuota"){
                  $('#data_konten').load('pages/master/kuota.php');
              }else if(menu === "transaksi"){
                  $('#data_konten').load('pages/report/transaksi.php');
              }else if(menu === "verifikasi-akun"){
                  $('#data_konten').load('pages/verification/verifikasi-akun.php');
              }else if(menu === "laporan"){
                  $('#data_konten').load('pages/report/laporan.php');
              }else if(menu === "grafik"){
                  $('#data_konten').load('pages/grafik/grafik.php');
              }else if(menu === "konfigurasi"){
                  $('#data_konten').load('pages/konfigurasi/konfigurasi.php');
              }

          });
          $('#data_konten').load('pages/dashboard/dashboard.php');

      });
  </script>
  </body>
<?php
    ob_end_flush();
?>
</html>