<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Update Kuota
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Jabatan</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-2 control-label">Gunung</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="gunung_select" id="gunung_select" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Pos Pendakian: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="pos_select" id="pos_select" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="date" id="date" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Kuota</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="stock" id="stock">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Kuota Tersedia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="stock_available" id="stock_available">
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

            <div class="form-group">
                <label class="col-sm-2 control-label" >Status</label>
                <div class="col-sm-10">
                    <input type="checkbox" name="is_active" id="is_active" onclick="mycheckedEdit()">
                    <input type="hidden" id="data_checked" name="data_checked">
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
        url     : "pages/master/action-kuota/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                document.getElementById("gunung_select").value = json.data.gunung;
                document.getElementById("pos_select").value = json.data.pos;
                document.getElementById("date").value = json.data.date;
                document.getElementById("stock").value = json.data.stock;
                document.getElementById("stock_available").value = json.data.stock_available;
                document.getElementById("weekday_wni").value = json.data.price_weekday_wni;
                document.getElementById("weekday_wna").value = json.data.price_weekday_wna;
                document.getElementById("weekend_wni").value = json.data.price_weekend_wni;
                document.getElementById("weekend_wna").value = json.data.price_weekend_wna;

                document.getElementById("data_checked").value = json.data.valuechecked;
                if(json.data.is_active == 1){
                    $("#is_active").prop("checked", true);
                }else{
                    $("#is_active").prop("checked", false);
                }
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
        $('#data_konten').load('pages/master/kuota.php');
    });

    $('#update').click(function () {
        var id                  = code_id;
        var stock               = $('#stock').val();
        var stock_available     = $('#stock_available').val();
        var price_weekday_wni   = $('#weekday_wni').val();
        var price_weekday_wna   = $('#weekday_wna').val();
        var price_weekend_wni   = $('#weekend_wni').val();
        var price_weekend_wna   = $('#weekend_wna').val();
        var data_checked        =  $('#data_checked').val();
        $.ajax({
            type    : "POST",
            url     : "pages/master/action-kuota/action.php?action=update",
            data    : {
                id: id,
                stock: stock,
                stock_available: stock_available,
                price_weekday_wni: price_weekday_wni,
                price_weekday_wna: price_weekday_wna,
                price_weekend_wni: price_weekend_wni,
                price_weekend_wna: price_weekend_wna,
                data_checked: data_checked
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
</script>
