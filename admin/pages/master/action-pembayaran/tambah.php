<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Tambah Metode Pembayaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Metode Pembayaran</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-4 control-label">Gunung</label>
                <div class="col-sm-8">
                    <select class="form-control" name="gunung_select" id="gunung_select" required>
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Pos Pendakian: </label>
                <div class="col-sm-8">
                    <select class="form-control" name="pos_select" id="pos_select" required>
                        <option value="">- Pilih -</option>
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
                        <option disabled selected> Pilih </option>
                        <option value="VA">Virtual Account</option>
                        <option value="QRIS">Qris</option>
                        <option value="TF">Transfer</option>
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
                <label class="col-sm-4 control-label">Sync Metode Pembayaran Id </br><small>(harus sama dengan ID metode pembayaran tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="motode_pembayaran_id" id="motode_pembayaran_id">
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
                    <button class="btn btn-primary" type="button" id="simpan">Simpan</button>
                </div>
            </div>
    </div>
</div>

<script>
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

    $('#simpan').click(function () {
        var nama                = $("#nama").val();
        var kategori_pembayaran = $('#kategori_pembayaran').val();
        var number              = $('#number').val();
        var motode_pembayaran_id= $('#motode_pembayaran_id').val();
        var data_checked        = $('#data_checked').val();

        var gunung_select= $('#gunung_select').val();
        var pos_select= $('#pos_select').val();
        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pembayaran/action.php?action=store",
            data    : {
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

    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "../core/gunung.php",
            cache: false,
            success: function(msg){
                $("#gunung_select").html(msg);
            }
        });
    });

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
</script>
