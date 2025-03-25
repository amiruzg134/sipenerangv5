<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Tambah Tiket Kuota
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Master</li>
        <li class="active">Tiket Kuota</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-2 control-label">Gunung</label>
                <div class="col-sm-10">
                    <select class="form-control" name="gunung_select" id="gunung_select" required>
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Pos Pendakian: </label>
                <div class="col-sm-10">
                    <select class="form-control" name="pos_select" id="pos_select" required>
                        <option value="">- Pilih -</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="data_5">
                <label class="col-sm-2 col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start_date" id="start_date" value="<?php echo date('m/d/Y') ?>" />
                        <span class="input-group-addon">s/d</span>
                        <input type="text" class="input-sm form-control" name="end_date" id="end_date" value="<?php echo date('m/d/Y') ?>" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Kuota</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="stock" id="stock">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Harga Weekday WNI</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="weekday_wni" id="weekday_wni">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" style="color: #c17f2a;">Harga Weekday WNA</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="weekday_wna" id="weekday_wna">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Harga Weekend WNI</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="weekend_wni" id="weekend_wni">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" style="color: #c17f2a;">Harga Weekend WNA</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="weekend_wna" id="weekend_wna">
                </div>
            </div>


            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" id="batal">Batal</a>
                    <button class="btn btn-primary" type="button" id="simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/master/kuota.php');
    });

    $('#simpan').click(function () {
        var gunung = $('#gunung_select').val();
        var pos = $('#pos_select').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var kuota = $('#stock').val();
        var weekday_wni = $('#weekday_wni').val();
        var weekday_wna = $('#weekday_wna').val();
        var weekend_wni = $('#weekend_wni').val();
        var weekend_wna = $('#weekend_wna').val();
        $.ajax({
            type    : "POST",
            url     : "pages/master/action-kuota/action.php?action=store",
            data    : {
                gunung: gunung,
                pos: pos,
                start_date: start_date,
                end_date: end_date,
                kuota: kuota,
                weekday_wni: weekday_wni,
                weekday_wna: weekday_wna,
                weekend_wni: weekend_wni,
                weekend_wna: weekend_wna,
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/kuota.php');
                }
            }
        });
        return false;
    });

    $.ajax({
        type: 'POST',
        url: "../core/gunung.php",
        cache: false,
        success: function(msg){
            $("#gunung_select").html(msg);
        }
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


    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
</script>
