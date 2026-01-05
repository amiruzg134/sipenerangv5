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
                            <div class="col-md-12">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Data Pengajuan</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table">
                                    <tr>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Nama Lengkap </td>
                                        <td> <span id="tx_nama"></span></td>
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
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Jenis Kelamin </td>
                                        <td><span id="tx_gender"></span></td>
                                        <td class="text-left" style="background: #eee; font-weight: 600;">Kewarganegaraan </td>
                                        <td> <span id="tx_warganegaraan"></span></td>

                                    </tr>
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
                                <strong>Data Riwayat Penyakit</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="bg-light-blue">
                                        <th>Riwayat Penyakit</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_riwayat_penyakit">
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 30px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Foto Identitas</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="file-box">
                                    <div class="file">
                                        <a target="_blank" id="tx_url_id_card" style="font-size: 15px;">
                                            <i class="fa fa-id-card-o"></i> &nbsp; lihat foto identitas
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="color: #1ab394; margin-top: 20px;">
                                <i class="fa fa-arrow-right"></i> &nbsp;
                                <strong>Log Verifikasi</strong>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="bg-light-blue">
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Waktu</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_log_verifikasi">
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <div class="row" style="margin-top: 20px; border-top: 1px solid #eee;">
                            <div class="col-md-12 text-right" style="padding-top: 15px;">
                                <button type="button" id="btn_setujui" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#verifikasidisetujui" ><i class="fa fa-pay" ></i>Setujui
                                </button> || <button type="button" id="btn_tolak" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#verifikasitolak" ><i class="fa fa-pay" ></i>Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- start modal setujui -->
<div class="modal fade" id="verifikasidisetujui">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verifikasi Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_verifikasi_disetujui" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="catatan_disetujui" name="catatan_disetujui" value="Diterima">
                    <div class="form-group">
                        <label>Apakah anda yakin ingin menyetujui verifikasi akun ini?</label>
                    </div>

                    <button type="button" class="btn btn-success" id="verifikasi_disetujui">
                        Setujui
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- start modal tolak -->
<div class="modal fade" id="verifikasitolak">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verifikasi Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_verifikasi_ditolak" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Apakah anda yakin ingin menolak verifikasi akun ini?</label>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >Catatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="catatan_ditolak" id="catatan_ditolak">
                        </div>
                    </div>

                    <div style="margin-top: 10px;">
                        <button type="button" class="btn btn-danger" id="verifikasi_tolak">
                            Tolak
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
    $.ajax({
        type    : "POST",
        url     : "pages/verification/action-verifikasi-akun/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                document.getElementById("tx_nama").textContent = json.data.user.fullname;
                document.getElementById("tx_alamat").textContent = json.data.user.address;
                document.getElementById("tx_nomor_identitas").textContent = json.data.user.id_card_number;
                document.getElementById("tx_ttl").textContent = json.data.user.place_birth+" ,"+json.data.user.date_birth;
                document.getElementById("tx_no_telp").textContent = json.data.user.phone;

                document.getElementById("tx_provinsi").textContent = json.data.user.location.province_name;
                document.getElementById("tx_kota").textContent = json.data.user.location.city_name;
                document.getElementById("tx_kecamatan").textContent = json.data.user.location.district_name;
                document.getElementById("tx_desa").textContent = json.data.user.location.village_name;

                var a = document.getElementById('tx_url_id_card');
                a.href = json.data.user.id_card_photo;

                document.getElementById("tx_email").textContent = json.data.user.email;
                var kewarganegaraan = "-";
                if (json.data.user.is_wni){
                    kewarganegaraan = "WNI";
                }else{
                    kewarganegaraan = "WNA";
                }
                document.getElementById("tx_warganegaraan").textContent = kewarganegaraan;
                document.getElementById("tx_gender").textContent = json.data.user.gender;

                if (json.data.user.user_emergency.emergency_name_one != null){
                    $('#data_emergency').append("<tr>\
                                    <td>"+json.data.user.user_emergency.emergency_name_one+"</td>\
                                    <td>0"+json.data.user.user_emergency.emergency_phone_one+"</td>\
                                    <td>"+json.data.user.user_emergency.emergency_relationship_one+"</td>\
                                    </tr>");
                }

                if (json.data.user.user_emergency.emergency_name_two != null){
                    $('#data_emergency').append("<tr>\
                                    <td>"+json.data.user.user_emergency.emergency_name_one+"</td>\
                                    <td>0"+json.data.user.user_emergency.emergency_phone_one+"</td>\
                                    <td>"+json.data.user.user_emergency.emergency_relationship_one+"</td>\
                                    </tr>");
                }


                $.each(json.data.user.riwayat_penyakits, function (key, value) {
                    $('#data_riwayat_penyakit').append("<tr>\
										<td>"+value.name+"</td>\
										</tr>");
                })

                if (json.data.is_verified_account == null){
                    document.getElementById("btn_setujui").disabled = false;
                    document.getElementById("btn_tolak").disabled = false;
                    // document.getElementById("tx_status_bayar").style.color = "#26980d";
                }else{
                    document.getElementById("btn_setujui").disabled = true;
                    document.getElementById("btn_tolak").disabled = true;
                    // document.getElementById("tx_status_bayar").style.color = "#ff0000";
                }

                $.each(json.data.log_verified, function (key, value) {
                    $('#data_log_verifikasi').append("<tr>\
										<td>"+value.status_verified_account+"</td>\
										<td>"+value.catatan+"</td>\
										<td>"+value.waktu+"</td>\
										</tr>");
                })

            }
        }
    });

    $("#verifikasi_disetujui").on("click",function(){
        var formData = new FormData();
        formData.append('user_id', code_id);
        formData.append('status', "disetujui");
        formData.append('catatan', $('#catatan_disetujui').val());
        $.ajax({
            type    : "POST",
            url     : "pages/verification/action-verifikasi-akun/action.php?action=verifikasi-akun",
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
                    $('#data_konten').load('pages/verification/action-verifikasi-akun/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $("#verifikasi_tolak").on("click",function(){
        var formData = new FormData();
        formData.append('user_id', code_id);
        formData.append('status', "ditolak");
        formData.append('catatan', $('#catatan_ditolak').val());
        $.ajax({
            type    : "POST",
            url     : "pages/verification/action-verifikasi-akun/action.php?action=verifikasi-akun",
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
                    $('#data_konten').load('pages/verification/action-verifikasi-akun/detail.php');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

</script>
