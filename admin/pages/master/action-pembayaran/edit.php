<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Edit Metode Pembayaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Pos Perizinan</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-4 control-label">Gunung</label>
                <div class="col-sm-8">
                    <select name="gunung_select" id="gunung_select" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Pos Pendakian: </label>
                <div class="col-sm-8">
                    <select name="pos_select" id="pos_select" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Nama</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama" id="nama">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Kategori Pembayaran</label>
                <div class="col-sm-8">
                    <select name="kategori_pembayaran" id="kategori_pembayaran" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Nomor Pembayaran <small>(jika TF)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="number" id="number">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Sync Metode Pembayaran Id </br><small>(ID metode pembayaran tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="motode_pembayaran_id" id="motode_pembayaran_id" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                    <input type="checkbox" name="is_active" id="is_active" onclick="mycheckedEdit()">
                    <input type="hidden" id="data_checked" name="data_checked">
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" id="batal">Batal</a>
                    <button class="btn btn-primary" type="button" id="update">Update</button>
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
        url     : "pages/master/action-pembayaran/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{

                var select_gunung = document.getElementById('gunung_select');
                $.each(json.data.list_gunung, function (key_gunung, value_gunung) {
                    var opt_gunung = document.createElement('option');
                    opt_gunung.value = value_gunung.id;
                    opt_gunung.innerHTML = value_gunung.nama;
                    if (value_gunung.id === json.data.detail.tb_gunung_id){
                        opt_gunung.selected = true;
                    }
                    select_gunung.appendChild(opt_gunung);
                })

                var select_pos = document.getElementById('pos_select');
                $.each(json.data.list_pos, function (key_pos, value_pos) {
                    var opt_pos = document.createElement('option');
                    opt_pos.value = value_pos.id;
                    opt_pos.innerHTML = value_pos.nama;
                    if (value_pos.id === json.data.detail.tb_pos_pendakian_id){
                        opt_pos.selected = true;
                    }
                    select_pos.appendChild(opt_pos);
                })

                $.each(json.data.list_kategori, function (key_det, value_det) {
                    select_kategori = document.getElementById('kategori_pembayaran');
                    var opt_kategori = document.createElement('option');
                    opt_kategori.value = value_det.id;
                    opt_kategori.innerHTML = value_det.nama;
                    if (value_det.id == json.data.detail.kategori){
                        opt_kategori.selected = true;
                    }
                    select_kategori.appendChild(opt_kategori);
                })

                document.getElementById("nama").value = json.data.detail.name;
                document.getElementById("kategori_pembayaran").value = json.data.detail.kategori;
                document.getElementById("number").value = json.data.detail.number;
                document.getElementById("motode_pembayaran_id").value = json.data.detail.motode_pembayaran_id;

                document.getElementById("data_checked").value = json.data.detail.valuechecked;
                if(json.data.detail.is_active == 1){
                    $("#is_active").prop("checked", true);
                }else{
                    $("#is_active").prop("checked", false);
                }


                $("#gunung_select").change(function(){
                    var gunung_id = $("#gunung_select").val();
                    $.ajax({
                        type: 'POST',
                        url: "../core/pos.php",
                        data: {gunung_id: gunung_id},
                        cache: false,
                        success: function(msg){
                            $("#pos_select").html(msg);
                        }
                    });
                });
            }
        }
    });

    function mycheckedEdit() {
        var checkBox = document.getElementById("is_active");
        if (checkBox.checked == true){
            document.getElementById("data_checked").value = "checked";
            checkBox.checked = true
        } else {
            document.getElementById("data_checked").value = "non_checked";
            checkBox.checked = false
        }
    }

    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/master/pembayaran.php');
    });

    $('#update').click(function () {
        var id                  = code_id;
        var nama                = $("#nama").val();
        var kategori_pembayaran = $('#kategori_pembayaran').val();
        var number              = $('#number').val();
        var motode_pembayaran_id= $('#motode_pembayaran_id').val();
        var data_checked        = $('#data_checked').val();
        var gunung_select= $('#gunung_select').val();
        var pos_select= $('#pos_select').val();

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pembayaran/action.php?action=update",
            data    : {
                id: id,
                nama: nama,
                kategori_pembayaran: kategori_pembayaran,
                number: number,
                motode_pembayaran_id: motode_pembayaran_id,
                gunung_select: gunung_select,
                pos_select: pos_select,
                data_checked: data_checked
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/pembayaran.php');
                }
            }
        });
        return false;
    });
</script>
