<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Update Konfigurasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> System</a></li>
        <li class="active">Konfigurasi</li>
    </ol>
</section>

<div class="box">
    <small style="color: red; margin: 10px;">Peringatan: perubahan konfigurasi ini dapat mempengaruhi sistem yang berjalan, pastikan sebelum melakukan perubahan konfigurasi sudah di uji.</small>
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <tr  style="color: #0e950e;">
                <th>ACCESS_KEY</th>
                <td>Kode ini digunakan untuk meng-akses API dari tiket pendakian.</td>
            </tr>
            <tr  style="color: #0e950e;">
                <th>BASE_URL</th>
                <td>Url ini digunakan untuk konfigurasi endpoint API dari tiket pendakian.</td>
            </tr>
            <tr style="color: #b47009;">
                <th>BASE_URL_VA</th>
                <td>Konfigurasi ini digunakan untuk mengatur url generate Virtual Account dari bank, masukan url sesuai dengan dokumentasi dari bank terkait.</td>
            </tr>
            <tr style="color: #b47009;">
                <th>BASE_URL_QRIS</th>
                <td>Konfigurasi ini digunakan untuk mengatur url generate QRIS dari bank, masukan url sesuai dengan dokumentasi dari bank terkait.</td>
            </tr>
            <tr style="color: #b47009;">
                <th>MERCHANTPAN</th>
                <td>Kode konfigurasi dari pihak bank untuk VA/QRIS.</td>
            </tr>
            <tr style="color: #b47009;">
                <th>TERMINALUSER</th>
                <td>Kode konfigurasi dari pihak bank untuk VA/QRIS.</td>
            </tr>
            <tr style="color: #b47009;">
                <th>MERCHANTHASHKEY</th>
                <td>Kode konfigurasi dari pihak bank untuk VA/QRIS.</td>
            </tr>
            <tr style="color: #cb1c05;">
                <th>CLIENTID</th>
                <td>Kode konfigurasi untuk menggunakan api google console (login by email google).</td>
            </tr>
            <tr style="color: #cb1c05;">
                <th>CLIENTSECRET</th>
                <td>Kode konfigurasi untuk menggunakan api google console (login by email google).</td>
            </tr>
            <tr style="color: #cb1c05;">
                <th>REDIRECTURI</th>
                <td>Url ini adalah konfigurasi saat login by email google.</td>
            </tr>
        </table>

        <div class="box-header" style="float: right; margin-top: 5px;">
            <a class="btn btn-info" id="batal">Kembali</a>
        </div>
    </div>
</div>

<script>
    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/konfigurasi/konfigurasi.php');
    });
</script>
