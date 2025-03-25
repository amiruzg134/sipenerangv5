<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Edit Pos Perizinan
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
                <label class="col-sm-4 control-label">Gunung Pendakian</label>
                <div class="col-sm-8">
                    <select name="gunung_id" id="gunung_id" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Pos Pendakian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="pp_nama" id="pp_nama">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Minimal Order</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="min_pesan" id="min_pesan">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Maksimal Order</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="max_pesan" id="max_pesan">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">H-Pemesanan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="can_booking_before_day" id="can_booking_before_day">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Sync Mountain Gate Id </br><small>(ID Pos tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="mountain_gate_id" id="mountain_gate_id" readonly>
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
        url     : "pages/master/action-pos/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                $.each(json.data.gunung, function (key_det, value_det) {
                    select_gunung = document.getElementById('gunung_id');
                    var opt_gunung = document.createElement('option');
                    opt_gunung.value = value_det.id;
                    opt_gunung.innerHTML = value_det.nama;
                    if (value_det.id == json.data.detail.tb_gunung_id){
                        opt_gunung.selected = true;
                    }
                    select_gunung.appendChild(opt_gunung);
                })
                console.log(json.data.detail);
                document.getElementById("pp_nama").value = json.data.detail.pp_nama;
                document.getElementById("min_pesan").value = json.data.detail.min_pesan;
                document.getElementById("max_pesan").value = json.data.detail.max_pesan;
                document.getElementById("can_booking_before_day").value = json.data.detail.can_booking_before_day;
                document.getElementById("mountain_gate_id").value = json.data.detail.mountain_gate_id;

                document.getElementById("data_checked").value = json.data.detail.valuechecked;
                if(json.data.detail.is_active == 1){
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
        $('#data_konten').load('pages/master/pos.php');
    });

    $('#update').click(function () {
        var id                  = code_id;
        var gunung_id           = $("#gunung_id").val();
        var pp_nama             = $('#pp_nama').val();
        var min_pesan           = $('#min_pesan').val();
        var max_pesan           = $('#max_pesan').val();
        var can_booking_before_day = $('#can_booking_before_day').val();
        var data_checked        = $('#data_checked').val();
        var mountain_gate_id    = $('#mountain_gate_id').val();

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pos/action.php?action=update",
            data    : {
                id: id,
                gunung_id: gunung_id,
                pp_nama: pp_nama,
                min_pesan: min_pesan,
                max_pesan: max_pesan,
                can_booking_before_day: can_booking_before_day,
                data_checked: data_checked,
                mountain_gate_id: mountain_gate_id
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/pos.php');
                }
            }
        });
        return false;
    });
</script>
