<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Laporan
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Report</li>
        <li class="active">Pdf</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="GET" class="form-horizontal" action="pages/report/action-laporan/show-report.php" target="_blank">

            <div class="form-group">
                <label class="col-sm-2 control-label">Jenis Laporan: </label>
                <div class="col-sm-10">
                    <select class="form-control" name="jenis_laporan" id="jenis_laporan" required>
                        <option value="">- Pilih -</option>
                        <option value="ringkas">Laporan Ringkas</option>
                        <option value="pendaki">Daftar Pendaki</option>
                        <option value="keuangan">Daftar Keuangan</option>
                        <option value="denda">Daftar Denda</option>
                        <option value="asuransi">Daftar Asuransi</option>
                    </select>
                </div>
            </div>

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

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button class="btn btn-primary" type="submit" id="proses">Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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
