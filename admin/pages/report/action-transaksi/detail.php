<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
session_start();
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Detail Transaksi
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Transaksi</li>
        <li class="active">Detail</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins ukuran_minimize_detil" style="margin-bottom: 80px">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12 text-primary">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-right"></i> &nbsp;
                                        <strong>Data Ketua Regu</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-info" style="float: right" type="button" name="btn_reload_detail" id="btn_reload_detail">
                                            <i class="fa fa-refresh" aria-hidden="true"></i> Reload
                                        </button>
                                        <span class="badge bg-success fw-bold me-2" style="float: right;margin-right: 10px;padding: 10px;" id="tx_status_data">
                                            Status data : -
                                        </span>
                                        <span class="badge bg-success fw-bold me-2" style="float: right;margin-right: 10px;padding: 10px;" id="tx_status_data_pendaki">
                                            Status Pendaki : -
                                        </span>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table">
                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Nama Ketua </td>
                                        <td> <span id="tx_nama_ketua"></span></td>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Alamat Lengkap </td>
                                        <td> <span id="tx_alamat"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Nomor Identitas </td>
                                        <td> <span id="tx_nomor_identitas"></span></td>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Provinsi </td>
                                        <td> <span id="tx_provinsi"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Tempat, Tanggal Lahir </td>
                                        <td> <span id="tx_ttl"></span></td>

                                        <td class="text-left" style="background: #eee; font-weight: 600;">Kabupaten/Kota </td>
                                        <td><span id="tx_kota"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">No Telepon </td>
                                        <td> <span id="tx_no_telp"></span></td>

                                        <td class="text-left" style="background: #eee; font-weight: 600;">Kecamatan </td>
                                        <td> <span id="tx_kecamatan"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Email </td>
                                        <td> <span id="tx_email"></span></td>

                                        <td class="text-left" style="background: #eee; font-weight: 600;">Desa/Kelurahan </td>
                                        <td> <span id="tx_desa"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Kewarganegaraan </td>
                                        <td> <span id="tx_warganegaraan"></span></td>


                                        <td class="text-left" style="background: #eee; font-weight: 600;">Tanggal Transaksi </td>
                                        <td> <span id="tx_tgl_transaksi"></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Jenis Kelamin </td>
                                        <td><span id="tx_gender"></span></td>

                                        <td class="text-left" style="background: #eee; font-weight: 600;">Waktu Expired </td>
                                        <td> <span id="tx_waktu_expired"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 20px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Data Anggota</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-light-blue">
                                            <th>Nama Anggota</th>
                                            <th>No Identitas</th>
                                            <th>No Telepon</th>
                                            <th>Kewarganegaraan</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_anggota">
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 20px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Data Kontak Darurat</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-light-blue">
                                            <th>Nama</th>
                                            <th>No Telepon </th>
                                            <th>Hubungan Keluarga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_emergency">
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 20px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Informasi Pendakian</strong>
                            </div>


                            <div class="col-md-12" style="margin-top: 10px;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <span id="info_reschedule" style="display: none; background-color: darkorange; color: black; padding: 5px;"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btn_konfirmasi_reschedule" style="float: right; display: none;" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ModalReschedule" ><i class="fa fa-pay" ></i> Konfirmasi Reschedule Pendakian
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <tr class="bg-light-blue">
                                        <th>Nomor Registrasi</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Pos Naik</th>
                                        <th>Tanggal Naik</th>
                                        <th>Tanggal Turun</th>
                                    </tr>
                                    <tr>
                                        <td><span id="tx_no_registrasi"></span></td>
                                        <td><span id="tx_tgl_registrasi"></span></td>
                                        <td><span id="tx_pos_naik"></span></td>
                                        <td><span id="tx_tgl_naik"></span></td>
                                        <td><span id="tx_tgl_turun"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12" style="margin-top: 20px;">
                                <table class="table table-bordered">
                                    <tr class="bg-light-blue">
                                        <th>Tarif</th>
                                        <th>Metode Pembayaran</th>
                                        <th><span id="tx_kategori_pembayaran"></span></th>
                                        <th>Tanggal Bayar</th>
                                        <th>Status Pembayaran</th>
                                    </tr>
                                    <tr>
                                        <td><span id="tx_tarif"></span></td>
                                        <td><span id="tx_metode_pembayaran"></span></td>
                                        <td><span id="tx_payment_number"></span></td>
                                        <td><span id="tx_tgl_bayar"></span></td>
                                        <td><span id="tx_status_bayar" style="font-weight: bold"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12" style="margin-top: 20px;">
                                <table class="table table-bordered">
                                    <tr class="bg-light-blue">
                                        <th>Pos Checkin</th>
                                        <th>Tanggal Checkin</th>
                                        <th>Verifikasi Checkin</th>
                                        <th>Pos Checkout</th>
                                        <th>Tanggal Checkout</th>
                                        <th>Verifikasi Checkout</th>
                                    </tr>
                                    <tr>
                                        <td><span id="tx_pos_checkin"></span></td>
                                        <td><span id="tx_tgl_checkin"></span></td>
                                        <td><span id="tx_verifikasi_checkin"></span></td>
                                        <td><span id="tx_pos_checkout"></span></td>
                                        <td><span id="tx_tgl_checkout"></span></td>
                                        <td><span id="tx_verifikasi_checkout"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 30px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Dokumen Penunjang</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="file-box">
                                    <div class="file">
                                        <a target="_blank" id="tx_url_simaksi" style="font-size: 15px;">
                                            <i class="fa fa-file-pdf-o"></i> &nbsp; e-Simaksi.pdf
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px; border-top: 1px solid #eee;">
                            <div class="col-md-12 text-right" style="padding-top: 15px;">
                                <button type="button" id="btn_konfirmasi_pembayaran" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#konfirmasipembayaran" style="display: inline-block;">
                                    <i class="fa fa-pay"></i> Konfirmasi Pembayaran
                                </button>

                                <button type="button" id="btn_rollback_status_trx" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#rollbackStatusTransaksi" style="display: inline-block; margin-left: 10px;">
                                    <i class="fa fa-pay"></i> Rollback Status Transaksi
                                </button>

                                <button type="button" id="btn_change_trx" class="btn btn-sm btn-info" style="display: inline-block; margin-left: 10px;">
                                    <i class="fa fa-pay"></i> Reschedule Transaksi
                                </button>

                                <button type="button" id="btn_cancel_trx" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#batalTransaksi" style="display: inline-block; margin-left: 10px;">
                                    <i class="fa fa-pay"></i> Batalkan Transaksi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- start modal Reschedule-->
<div class="modal fade" id="ModalReschedule">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informasi Pengajuan Reschedule Pendakian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_konfirmasi" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="code_nomor" name="code_nomor">
                    <input type="hidden" id="data_trx_id" name="data_trx_id">
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $_SESSION['uuid_admin'];?>">

                    <div class="form-group" id="date_filter">
                        <label class="control-label">Tanggal Reschedule Pendakian:</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="form-control" name="reschedule_start_date" id="reschedule_start_date" readonly/>
                            <span class="input-group-addon">s/d</span>
                            <input type="text" class="form-control" name="reschedule_end_date" id="reschedule_end_date" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Status Konfirmasi</label>
                        <select class="form-control" name="status_konfirmasi" id="status_konfirmasi">
                            <option value="null">--- Pilih Status Konfirmasi ---</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="reschedule">
                            Proses
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                            Batal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="konfirmasipembayaran">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_konfirmasi" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="code_nomor" name="code_nomor">
                    <input type="hidden" id="data_trx_id" name="data_trx_id">
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $_SESSION['uuid_admin'];?>">

                    <div class="form-group">
                        <label for="name">Apakah anda yakin ingin melakukan konfirmasi pembayaran pada transaksi ini?</label>
                        <br/>
                        <small>Catatan: Konfirmasi pembayaran ini hanya dilakukan jika VA/Virtual Account belum menggunakan sistem otomatis.</small>
                    </div>
                    <button type="button" class="btn btn-success" id="konfirmasi">
                        Konfirmasi
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rollbackStatusTransaksi">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pengembalian Status Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_batal_transaksi" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="code_nomor_cancel" name="code_nomor">
                    <input type="hidden" id="data_trx_id_cancel" name="data_trx_id">
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $_SESSION['uuid_admin']; ?>">

                    <div class="form-group">
                        <label for="name">Apakah anda yakin ingin melakukan rollback status transaksi ini?</label><br/>
                        <small>Catatan: Rollback transaksi akan melakukan proses perubahan status transaksi kembali ke menunggu pembayaran dan akan mengecek ulang stock tiket kuota.</small>
                    </div>

                    <button type="button" class="btn btn-success" id="btn_rollback_trx">
                        Rollback Transaksi
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="batalTransaksi">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Batal Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_batal_transaksi" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="code_nomor_cancel" name="code_nomor">
                    <input type="hidden" id="data_trx_id_cancel" name="data_trx_id">
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $_SESSION['uuid_admin']; ?>">

                    <div class="form-group">
                        <label for="cancel_reason">Pilih Jenis Pembatalan</label>
                        <select name="cancel_reason" id="cancel_reason" class="form-control" required>
                            <option value="">-- Pilih Alasan --</option>
                            <option value="batal">Batal Transaksi</option>
                            <option value="expired">Expired Transaksi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Apakah anda yakin ingin melakukan pembatalan pada transaksi ini?</label><br/>
                        <small>Catatan: Pembatalan transaksi akan melakukan proses sinkron data ke tiket pendakian.</small>
                    </div>

                    <button type="button" class="btn btn-success" id="btn_cancel">
                        Proses Transaksi
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gantiTanggalPendaki">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reschedule Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_batal_transaksi" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="code_nomor_change" name="code_nomor_change">
                    <input type="hidden" id="data_trx_id_change" name="data_trx_id_change">
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $_SESSION['uuid_admin']; ?>">

                    <div class="form-group mb-3">
                        <label for="tx_tanggal_naik" class="font-weight-bold">Tanggal Naik (Saat ini):</label>
                        <input type="text" class="form-control" id="tx_tanggal_naik" name="tx_tanggal_naik" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tx_tanggal_turun" class="font-weight-bold">Tanggal Turun (Saat ini):</label>
                        <input type="text" class="form-control" id="tx_tanggal_turun" name="tx_tanggal_turun" readonly>
                    </div>

                    <div class="form-group" id="date_change">
                        <div class="col-sm-12" style="padding: 0px;">
                            <small class="control-label">Rechedule Tanggal Transaksi:</small>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control" name="change_start_date" id="change_start_date" required/>
                                <span class="input-group-addon">s/d</span>
                                <input type="text" class="form-control" name="change_end_date" id="change_end_date" readonly required/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="margin-top: 20px;">Apakah Anda yakin ingin melakukan perubahan tanggal naik dan tanggal turun pada transaksi ini?</label>
                        <small class="form-text text-muted">
                            Catatan: Perubahan tanggal transaksi akan melakukan proses pengembalian kuota pada tanggal pemesanan dan mengurangi kuota pada tanggal baru. Jika kuota tidak tersedia pada tanggal yang dipilih, perubahan akan ditolak oleh sistem.
                        </small>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <button type="button" class="btn btn-success" id="btn_change">
                            Proses Perubahan Transaksi
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var code_id = urlParams.get('id')
    load_detail(false);

    $("#btn_reload_detail").on("click",function(){
        $('#data_anggota').html("");
        $('#data_emergency').html("");
        load_detail(true);
    });

    function load_detail(is_reload = false){
        $.ajax({
            type    : "POST",
            url     : "pages/report/action-transaksi/action.php?action=detail",
            data    : {
                code_id: code_id
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{

                    if (json.data.informasi.is_region_new == "1"){
                        document.getElementById("tx_status_data").textContent = "Status Data: New";
                    }else{
                        document.getElementById("tx_status_data").textContent = "Status Data: Old";
                    }


                    document.getElementById("tx_nama_ketua").textContent = json.data.nama_ketua;
                    document.getElementById("tx_alamat").textContent = json.data.alamat;
                    document.getElementById("tx_nomor_identitas").textContent = json.data.no_ktp;
                    document.getElementById("tx_ttl").textContent = json.data.ttl;
                    document.getElementById("tx_no_telp").textContent = json.data.pd_no_hp;

                    document.getElementById("tx_provinsi").textContent = json.data.provinsi;
                    document.getElementById("tx_kota").textContent = json.data.kota;
                    document.getElementById("tx_kecamatan").textContent = json.data.kecamatan;
                    document.getElementById("tx_desa").textContent = json.data.desa;

                    document.getElementById("tx_email").textContent = json.data.email;
                    document.getElementById("tx_warganegaraan").textContent = json.data.kewarganegaraan;
                    document.getElementById("tx_tgl_transaksi").textContent = json.data.tgl_transaksi;
                    document.getElementById("tx_gender").textContent = json.data.gender;
                    document.getElementById("tx_waktu_expired").textContent = json.data.expired_at;

                    if (json?.data?.anggota) {
                        $.each(json.data.anggota, function (key, value) {
                            $('#data_anggota').append("<tr>\
										<td>" + value.nama + "</td>\
										<td>" + value.no_identitas + "</td>\
										<td>" + value.no_telp + "</td>\
										<td>" + value.kewarganegaraan + "</td>\
										<td>" + value.gender + "</td>\
										</tr>");
                        })
                    }

                    if (json?.data?.emergency) {
                        $.each(json.data.emergency, function (key, value) {
                            $('#data_emergency').append("<tr>\
										<td>" + value.nama + "</td>\
										<td>" + value.no_telp + "</td>\
										<td>" + value.hubungan + "</td>\
										</tr>");
                        })
                    }

                    document.getElementById("tx_no_registrasi").textContent = json.data.informasi.no_registrasi;
                    document.getElementById("tx_tgl_registrasi").textContent = json.data.informasi.tgl_registrasi;
                    document.getElementById("tx_pos_naik").textContent = json.data.informasi.pos_naik;
                    document.getElementById("tx_tgl_naik").textContent = json.data.informasi.tgl_naik;
                    document.getElementById("tx_tgl_turun").textContent = json.data.informasi.tgl_turun;

                    document.getElementById("tx_tanggal_naik").value = json.data.informasi.tgl_naik;
                    document.getElementById("tx_tanggal_turun").value = json.data.informasi.tgl_turun;

                    document.getElementById("tx_tarif").textContent = json.data.informasi.tarif;

                    if (json.data.informasi.kategori_pembayaran == "VA"){
                        document.getElementById("tx_kategori_pembayaran").textContent = "Nomor VA";
                        document.getElementById("tx_payment_number").textContent = json.data.informasi.payment_number;
                    }else if (json.data.informasi.kategori_pembayaran == "QRIS"){
                        document.getElementById("tx_kategori_pembayaran").textContent = "Qris";
                        var img = document.createElement("img");
                        img.setAttribute("id", "image_qris");
                        img.src = "https://image-charts.com/chart?cht=qr&chl="+json.data.informasi.payment_number+"&chs=75x75&choe=UTF-8&icqrf=00000000";

                        var src = document.getElementById("tx_payment_number");
                        if (is_reload){
                            $("#image_qris").remove();
                            src.appendChild(img);
                        }else{
                            src.appendChild(img);
                        }
                    }else{
                        document.getElementById("tx_kategori_pembayaran").textContent = "Metode Pembayaran";
                        document.getElementById("tx_payment_number").textContent = "Metode pembayaran belum terbuat";
                    }


                    document.getElementById("tx_tgl_bayar").textContent = json.data.informasi.tgl_bayar;
                    document.getElementById("tx_status_bayar").textContent = json.data.informasi.status_bayar;
                    document.getElementById("tx_metode_pembayaran").textContent = json.data.informasi.metode_pembayaran;


                    document.getElementById("reschedule_start_date").value = json.data.informasi.reschedule_tgl_naik;
                    document.getElementById("reschedule_end_date").value = json.data.informasi.reschedule_tgl_turun;


                    var status_pendaki = document.getElementById("tx_status_data_pendaki");
                    status_pendaki.textContent = json.data.informasi.pd_status;
                    if (json.data.informasi.pd_status == "menunggu pembayaran"){
                        status_pendaki.style.backgroundColor = "#dedede";
                    }else if(json.data.informasi.pd_status == "menunggu verifikasi"){
                        status_pendaki.style.backgroundColor = "#ffc107";
                    }else if(json.data.informasi.pd_status == "disetujui"){
                        status_pendaki.style.backgroundColor = "#3bd536";
                    }else if(json.data.informasi.pd_status == "ditolak"){
                        status_pendaki.style.backgroundColor = "#bf4336";
                    }else if(json.data.informasi.pd_status == "sudah naik"){
                        status_pendaki.style.backgroundColor = "#36b6d5";
                    }else if(json.data.informasi.pd_status == "sudah turun"){
                        status_pendaki.style.backgroundColor = "#36b6d5";
                    }

                    if(json.data.informasi.status_bayar == "paid") {
                        if(json.data.informasi.is_reschedule){
                            if(json.data.informasi.status_reschedule == null){
                                document.getElementById("btn_konfirmasi_reschedule").style.display = "none";
                                document.getElementById("info_reschedule").style.display = "none";
                            }else if(json.data.informasi.status_reschedule == 1){
                                document.getElementById("btn_konfirmasi_reschedule").style.display = "block";
                                document.getElementById("info_reschedule").style.display = "block";
                                document.getElementById("info_reschedule").textContent = "User telah melakukan pengajuan reschedule pada tanggal ("+json.data.informasi.reschedule_tgl_naik+" - "+json.data.informasi.reschedule_tgl_turun+")";
                            }else if(json.data.informasi.status_reschedule == 2){
                                document.getElementById("info_reschedule").style.display = "block";
                                document.getElementById("info_reschedule").textContent = "Pengajuan Reschedule diterima";
                            }else if(json.data.informasi.status_reschedule == 3){
                                document.getElementById("info_reschedule").style.display = "block";
                                document.getElementById("info_reschedule").textContent = "Pengajuan Reschedule ditolak";
                            }
                        }else{
                            document.getElementById("btn_konfirmasi_reschedule").style.display = "none";
                            document.getElementById("info_reschedule").style.display = "none";
                        }

                        document.getElementById("tx_status_bayar").style.color = "#51d108";
                        document.getElementById("btn_konfirmasi_pembayaran").disabled = true;
                    }else if(json.data.informasi.status_bayar == 'unpaid') {
                        if (json.data.is_expired){
                            document.getElementById("tx_status_bayar").style.color = "#9b9b9b";
                            document.getElementById("btn_konfirmasi_pembayaran").disabled = true;
                        }else{
                            document.getElementById("tx_status_bayar").style.color = "#ffc107";
                            document.getElementById("btn_konfirmasi_pembayaran").disabled = false;
                        }
                    }else if(json.data.informasi.status_bayar == 'cancel') {
                        document.getElementById("tx_status_bayar").style.color = "#9b9b9b";
                        document.getElementById("btn_konfirmasi_pembayaran").disabled = true;
                    }else if(json.data.informasi.status_bayar == 'expired') {
                        document.getElementById("tx_status_bayar").style.color = "#dc3545";
                        document.getElementById("btn_konfirmasi_pembayaran").disabled = true;
                    }

                    document.getElementById("tx_pos_checkin").textContent = json.data.informasi.pos_checkin;
                    document.getElementById("tx_tgl_checkin").textContent = json.data.informasi.tgl_checkin;
                    document.getElementById("tx_verifikasi_checkin").textContent = json.data.informasi.verifikasi_checkin;
                    document.getElementById("tx_pos_checkout").textContent = json.data.informasi.pos_checkout;
                    document.getElementById("tx_tgl_checkout").textContent = json.data.informasi.tgl_checkout;
                    document.getElementById("tx_verifikasi_checkout").textContent = json.data.informasi.verifikasi_checkout;
                    var url_simaksi = document.getElementById('tx_url_simaksi');
                    url_simaksi.href = json.data.informasi.url_simaksi;


                    document.getElementById("code_nomor").value = json.data.informasi.no_registrasi;
                    document.getElementById("data_trx_id").value = code_id;

                    document.getElementById("code_nomor_cancel").value = json.data.informasi.no_registrasi;
                    document.getElementById("data_trx_id_cancel").value = code_id;

                    document.getElementById("code_nomor_change").value = json.data.informasi.no_registrasi;
                    document.getElementById("data_trx_id_change").value = code_id;

                }
            }
        });
    }



    function parseDMY(dateStr) {
        const parts = dateStr.split('-');
        return new Date(`${parts[2]}-${parts[1]}-${parts[0]}`);
    }

    $('#change_start_date, #change_end_date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true
    });
    $('#change_end_date').on('mousedown', function (e) {
        e.preventDefault();
    });

    $('#btn_change_trx').on('click', function () {
        const rawNaik = $('#tx_tanggal_naik').val();
        const rawTurun = $('#tx_tanggal_turun').val();

        const tglNaik = parseDMY(rawNaik);
        const tglTurun = parseDMY(rawTurun);
        const durasi = Math.ceil((tglTurun - tglNaik) / (1000 * 60 * 60 * 24)) + 1;

        $('#change_start_date').val('');
        $('#change_end_date').val('');

        $('#change_start_date').datepicker('setStartDate', new Date());
        $('#change_end_date').datepicker('setStartDate', null).datepicker('setEndDate', null);

        $('#change_start_date').off('changeDate').on('changeDate', function (e) {
            if (!e.date) {
                $('#change_end_date').val('');
                return;
            }

            const startDate = new Date(e.date);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + durasi - 1);

            $('#change_end_date')
                .datepicker('setDate', endDate)
                .datepicker('setStartDate', endDate)
                .datepicker('setEndDate', endDate);
        });

        $('#gantiTanggalPendaki').modal('show');
    });

    $("#btn_change").on("click", function () {
        var formData = new FormData();
        formData.append('data_trx_id', $('#data_trx_id_change').val());
        formData.append('code_nomor', $('#code_nomor_change').val());
        formData.append('admin_id', $('#admin_id').val());
        formData.append('start_date', $('#change_start_date').val());
        formData.append('end_date', $('#change_end_date').val());

        $.ajax({
            type: "POST",
            url: "pages/report/action-transaksi/action.php?action=change-tgl-transaksi",
            data: formData,
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error) {
                    alert(json.message);
                } else {
                    alert(json.message);
                    var element = document.getElementById('id_body');
                    element.classList.remove('modal-open');

                    window.history.replaceState(null, null, "?id=" + code_id);
                    $('#data_konten').load('pages/report/action-transaksi/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });



    $("#konfirmasi").on("click",function(){
        var formData = new FormData();
        formData.append('data_trx_id', $('#data_trx_id').val());
        formData.append('code_nomor', $('#code_nomor').val());
        formData.append('admin_id', $('#admin_id').val());
        $.ajax({
            type    : "POST",
            url     : "pages/report/action-transaksi/action.php?action=konfirmasi-pembayaran",
            data: formData,
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error) {
                    alert(json.message);
                } else {
                    alert(json.message);
                    var element = document.getElementById('id_body');
                    element.classList.remove('modal-open');

                    window.history.replaceState(null, null, "?id="+code_id);
                    $('#data_konten').load('pages/report/action-transaksi/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $("#btn_cancel").on("click", function () {
        var formData = new FormData();
        formData.append('data_trx_id', $('#data_trx_id').val());
        formData.append('code_nomor', $('#code_nomor').val());
        formData.append('admin_id', $('#admin_id').val());
        formData.append('cancel_reason', $('#cancel_reason').val());

        $.ajax({
            type: "POST",
            url: "pages/report/action-transaksi/action.php?action=cancel-transaksi",
            data: formData,
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error) {
                    alert(json.message);
                } else {
                    alert(json.message);
                    var element = document.getElementById('id_body');
                    element.classList.remove('modal-open');

                    window.history.replaceState(null, null, "?id=" + code_id);
                    $('#data_konten').load('pages/report/action-transaksi/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $("#btn_rollback_trx").on("click", function () {
        var formData = new FormData();
        formData.append('data_trx_id', $('#data_trx_id').val());
        formData.append('code_nomor', $('#code_nomor').val());
        formData.append('admin_id', $('#admin_id').val());

        $.ajax({
            type: "POST",
            url: "pages/report/action-transaksi/action.php?action=rollback-transaksi",
            data: formData,
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error) {
                    alert(json.message);
                } else {
                    alert(json.message);
                    var element = document.getElementById('id_body');
                    element.classList.remove('modal-open');

                    window.history.replaceState(null, null, "?id=" + code_id);
                    $('#data_konten').load('pages/report/action-transaksi/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });


    $("#reschedule").on("click",function(){
        var formData = new FormData();
        formData.append('data_trx_id', $('#data_trx_id').val());
        formData.append('code_nomor', $('#code_nomor').val());
        formData.append('admin_id', $('#admin_id').val());
        formData.append('status_konfirmasi', $('#status_konfirmasi').val());
        $.ajax({
            type    : "POST",
            url     : "pages/report/action-transaksi/action.php?action=reschedule-trx",
            data: formData,
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error) {
                    alert(json.message);
                } else {
                    alert(json.message);
                    var element = document.getElementById('id_body');
                    element.classList.remove('modal-open');

                    window.history.replaceState(null, null, "?id="+code_id);
                    $('#data_konten').load('pages/report/action-transaksi/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
</script>