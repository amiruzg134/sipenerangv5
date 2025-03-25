<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Tambah Gunung
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Gunung</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-4 control-label">Gunung Pendakian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama_gunung" id="nama_gunung">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Maksimal Hari</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="max_date" id="max_date">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                    <input type="checkbox" name="is_active" id="is_active" onclick="mycheckedEdit()">
                    <input type="hidden" id="data_checked" name="data_checked">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Sync Mountain Id </br><small>(harus sama dengan ID gunung tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="mountain_id" id="mountain_id">
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
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var code_id = urlParams.get('id')
    $.ajax({
        type    : "POST",
        url     : "pages/master/action-gunung/action.php?action=store",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                console.log(json);
                document.getElementById("max_date").value = json.data.max_date;
                document.getElementById("nama_gunung").value = json.data.nama;
                document.getElementById("mountain_id").value = json.data.mountain_id;

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
        $('#data_konten').load('pages/master/gunung.php');
    });

    $('#simpan').click(function () {
        var nama_gunung     = $('#nama_gunung').val();
        var mountain_id     = $('#mountain_id').val();
        var max_date        = $('#max_date').val();
        var data_checked    =  $('#data_checked').val();

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-gunung/action.php?action=store",
            data    : {
                nama_gunung: nama_gunung,
                mountain_id: mountain_id,
                max_date: max_date,
                data_checked: data_checked
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/gunung.php');
                }
            }
        });
        return false;
    });
</script>
