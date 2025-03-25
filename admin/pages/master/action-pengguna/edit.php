<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Update Pengguna
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Pengguna</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">
            <div class="form-group"><label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama" id="nama">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group"><label class="col-sm-2 control-label">Username / NIP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" id="username">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group"><label class="col-sm-2 control-label">Password <small style="font-weight: normal">(Password default admin123 .Kosongkan jika tidak ingin mengganti password)</small></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group"><label class="col-sm-2 control-label">Jabatan</label>
                <div class="col-sm-10">
                    <select class="form-control m-b" name="jabatan_id" id="jabatan_id">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Sync User Id </br><small>(harus sama dengan ID user tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="user_id_tiket_pendakian" id="user_id_tiket_pendakian">
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group"><label class="col-sm-2 control-label">Hak akses</label>
                <div class="col-sm-4">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="tengah">
                            <th>Menu</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Master Jabatan</td>
                            <td>
                                <input type="checkbox" name="is_active_jabatan" id="is_active_jabatan" onclick="mycheckedJabatan()">
                                <input type="hidden" id="data_checked_jabatan" name="data_checked_jabatan">
                            </td>
                        </tr>
                        <tr>
                            <td>Master Gunung</td>
                            <td>
                                <input type="checkbox" name="is_active_gunung" id="is_active_gunung" onclick="mycheckedGunung()">
                                <input type="hidden" id="data_checked_gunung" name="data_checked_gunung">
                            </td>
                        </tr>
                        <tr>
                            <td>Master Pos Pendakian</td>
                            <td>
                                <input type="checkbox" name="is_active_pos" id="is_active_pos" onclick="mycheckedPos()">
                                <input type="hidden" id="data_checked_pos" name="data_checked_pos">
                            </td>
                        </tr>
                        <tr>
                            <td>Master Pengguna</td>
                            <td>
                                <input type="checkbox" name="is_active_pengguna" id="is_active_pengguna" onclick="mycheckedPengguna()">
                                <input type="hidden" id="data_checked_pengguna" name="data_checked_pengguna">
                            </td>
                        </tr>
                        <tr>
                            <td>Master Kuota</td>
                            <td>
                                <input type="checkbox" name="is_active_kuota" id="is_active_kuota" onclick="mycheckedKuota()">
                                <input type="hidden" id="data_checked_kuota" name="data_checked_kuota">
                            </td>
                        </tr>
                        <tr>
                            <td>Data Pendaki</td>
                            <td>
                                <input type="checkbox" name="is_active_pendaki" id="is_active_pendaki" onclick="mycheckedPendaki()">
                                <input type="hidden" id="data_checked_pendaki" name="data_checked_pendaki">
                            </td>
                        </tr>
                        <tr>
                            <td>Laporan</td>
                            <td>
                                <input type="checkbox" name="is_active_laporan" id="is_active_laporan" onclick="mycheckedLaporan()">
                                <input type="hidden" id="data_checked_laporan" name="data_checked_laporan">
                            </td>
                        </tr>
                        <tr>
                            <td>Verifikator</td>
                            <td>
                                <input type="checkbox" name="is_active_verifikator" id="is_active_verifikator" onclick="mycheckedVerifikator()">
                                <input type="hidden" id="data_checked_verifikator" name="data_checked_verifikator">
                            </td>
                        </tr>
                        <tr>
                            <td>Broadcast</td>
                            <td>
                                <input type="checkbox" name="is_active_broadcast" id="is_active_broadcast" onclick="mycheckedBroadcast()">
                                <input type="hidden" id="data_checked_broadcast" name="data_checked_broadcast">
                            </td>
                        </tr>
                        <tr>
                            <td>Verifikasi Akun</td>
                            <td>
                                <input type="checkbox" name="is_active_verifikasi_akun" id="is_active_verifikasi_akun" onclick="mycheckedVerifikasiaKun()">
                                <input type="hidden" id="data_checked_verifikasi_akun" name="data_checked_verifikasi_akun">
                            </td>
                        </tr>
                        <tr>
                            <td>Konfigurasi Sistem</td>
                            <td>
                                <input type="checkbox" name="is_active_konfigurasi" id="is_active_konfigurasi" onclick="mycheckedKonfigurasi()">
                                <input type="hidden" id="data_checked_konfigurasi" name="data_checked_konfigurasi">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" id="batal">Batal</a>
                    <button class="btn btn-primary" type="button" id="update">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var code_id = urlParams.get('id')
    $.ajax({
        type    : "POST",
        url     : "pages/master/action-pengguna/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                $.each(json.data.jabatan, function (key_det, value_det) {
                    select_jabatan = document.getElementById('jabatan_id');
                    var opt_jabatan = document.createElement('option');
                    opt_jabatan.value = value_det.id;
                    opt_jabatan.innerHTML = value_det.nama;
                    if (value_det.id == json.data.id_jabatan){
                        opt_jabatan.selected = true;
                    }
                    select_jabatan.appendChild(opt_jabatan);
                })
                document.getElementById("nama").value = json.data.nama;
                document.getElementById("username").value = json.data.nip;
                document.getElementById("user_id_tiket_pendakian").value = json.data.user_id_tiket_pendakian;

                document.getElementById("data_checked_jabatan").value = json.data.role.rm_jabatan;
                if(json.data.role.rm_jabatan === "Y"){
                    $("#is_active_jabatan").prop("checked", true);
                }else{
                    $("#is_active_jabatan").prop("checked", false);
                }

                document.getElementById("data_checked_gunung").value = json.data.role.rm_gunung;
                if(json.data.role.rm_gunung === "Y"){
                    $("#is_active_gunung").prop("checked", true);
                }else{
                    $("#is_active_gunung").prop("checked", false);
                }

                document.getElementById("data_checked_pos").value = json.data.role.rm_pos;
                if(json.data.role.rm_pos === "Y"){
                    $("#is_active_pos").prop("checked", true);
                }else{
                    $("#is_active_pos").prop("checked", false);
                }

                document.getElementById("data_checked_pengguna").value = json.data.role.rm_pengguna;
                if(json.data.role.rm_pengguna === "Y"){
                    $("#is_active_pengguna").prop("checked", true);
                }else{
                    $("#is_active_pengguna").prop("checked", false);
                }

                document.getElementById("data_checked_kuota").value = json.data.role.rm_kuota;
                if(json.data.role.rm_kuota === "Y"){
                    $("#is_active_kuota").prop("checked", true);
                }else{
                    $("#is_active_kuota").prop("checked", false);
                }

                document.getElementById("data_checked_pendaki").value = json.data.role.rm_pendaki;
                if(json.data.role.rm_pendaki === "Y"){
                    $("#is_active_pendaki").prop("checked", true);
                }else{
                    $("#is_active_pendaki").prop("checked", false);
                }

                document.getElementById("data_checked_laporan").value = json.data.role.rm_laporan;
                if(json.data.role.rm_laporan === "Y"){
                    $("#is_active_laporan").prop("checked", true);
                }else{
                    $("#is_active_laporan").prop("checked", false);
                }

                document.getElementById("data_checked_verifikator").value = json.data.role.rm_verifikator;
                if(json.data.role.rm_verifikator === "Y"){
                    $("#is_active_verifikator").prop("checked", true);
                }else{
                    $("#is_active_verifikator").prop("checked", false);
                }

                document.getElementById("data_checked_konfigurasi").value = json.data.role.rm_konfigurasi;
                if(json.data.role.rm_konfigurasi === "Y"){
                    $("#is_active_konfigurasi").prop("checked", true);
                }else{
                    $("#is_active_konfigurasi").prop("checked", false);
                }

                document.getElementById("data_checked_broadcast").value = json.data.role.rm_broadcast;
                if(json.data.role.rm_broadcast === "Y"){
                    $("#is_active_broadcast").prop("checked", true);
                }else{
                    $("#is_active_broadcast").prop("checked", false);
                }

                document.getElementById("data_checked_verifikasi_akun").value = json.data.role.rm_verification_account;
                if(json.data.role.rm_verification_account === "Y"){
                    $("#is_active_verifikasi_akun").prop("checked", true);
                }else{
                    $("#is_active_verifikasi_akun").prop("checked", false);
                }




            }
        }
    });


    function mycheckedJabatan() {
        var checkBox = document.getElementById("is_active_jabatan");
        if (checkBox.checked == true){
            document.getElementById("data_checked_jabatan").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_jabatan").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedGunung() {
        var checkBox = document.getElementById("is_active_gunung");
        if (checkBox.checked == true){
            document.getElementById("data_checked_gunung").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_gunung").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedPos() {
        var checkBox = document.getElementById("is_active_pos");
        if (checkBox.checked == true){
            document.getElementById("data_checked_pos").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_pos").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedPengguna() {
        var checkBox = document.getElementById("is_active_pengguna");
        if (checkBox.checked == true){
            document.getElementById("data_checked_pengguna").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_pengguna").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedKuota() {
        var checkBox = document.getElementById("is_active_kuota");
        if (checkBox.checked == true){
            document.getElementById("data_checked_kuota").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_kuota").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedPendaki() {
        var checkBox = document.getElementById("is_active_pendaki");
        if (checkBox.checked == true){
            document.getElementById("data_checked_pendaki").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_pendaki").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedLaporan() {
        var checkBox = document.getElementById("is_active_laporan");
        if (checkBox.checked == true){
            document.getElementById("data_checked_laporan").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_laporan").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedVerifikator() {
        var checkBox = document.getElementById("is_active_verifikator");
        if (checkBox.checked == true){
            document.getElementById("data_checked_verifikator").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_verifikator").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedBroadcast() {
        var checkBox = document.getElementById("is_active_broadcast");
        if (checkBox.checked == true){
            document.getElementById("data_checked_broadcast").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_broadcast").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedVerifikasiaKun() {
        var checkBox = document.getElementById("is_active_verifikasi_akun");
        if (checkBox.checked == true){
            document.getElementById("data_checked_verifikasi_akun").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_verifikasi_akun").value = "N";
            checkBox.checked = false
        }
    }
    function mycheckedKonfigurasi() {
        var checkBox = document.getElementById("is_active_konfigurasi");
        if (checkBox.checked == true){
            document.getElementById("data_checked_konfigurasi").value = "Y";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked_konfigurasi").value = "N";
            checkBox.checked = false
        }
    }


    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/master/pengguna.php');
    });

    $('#update').click(function () {
        var id          = code_id;
        var nama        = $('#nama').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var jabatan_id  = $('#jabatan_id').val();
        var user_id_tiket_pendakian = $('#user_id_tiket_pendakian').val();
        var data_checked_jabatan            =  $('#data_checked_jabatan').val();
        var data_checked_gunung             =  $('#data_checked_gunung').val();
        var data_checked_pos                =  $('#data_checked_pos').val();
        var data_checked_pengguna           =  $('#data_checked_pengguna').val();
        var data_checked_kuota              =  $('#data_checked_kuota').val();
        var data_checked_pendaki            =  $('#data_checked_pendaki').val();
        var data_checked_laporan            =  $('#data_checked_laporan').val();
        var data_checked_verifikator        =  $('#data_checked_verifikator').val();
        var data_checked_broadcast          =  $('#data_checked_broadcast').val();
        var data_checked_verifikasi_akun    =  $('#data_checked_verifikasi_akun').val();
        var data_checked_konfigurasi        =  $('#data_checked_konfigurasi').val();
        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pengguna/action.php?action=update",
            data    : {
                id: id,
                nama: nama,
                username: username,
                password: password,
                jabatan_id: jabatan_id,
                user_id_tiket_pendakian: user_id_tiket_pendakian,
                data_checked_jabatan: data_checked_jabatan,
                data_checked_gunung: data_checked_gunung,
                data_checked_pos: data_checked_pos,
                data_checked_pengguna: data_checked_pengguna,
                data_checked_kuota: data_checked_kuota,
                data_checked_pendaki: data_checked_pendaki,
                data_checked_laporan: data_checked_laporan,
                data_checked_verifikator: data_checked_verifikator,
                data_checked_broadcast: data_checked_broadcast,
                data_checked_verifikasi_akun: data_checked_verifikasi_akun,
                data_checked_konfigurasi: data_checked_konfigurasi
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/pengguna.php');
                }
            }
        });
        return false;
    });
</script>
