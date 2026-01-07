<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Update Konfigurasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> System</a></li>
        <li class="active">Konfigurasi</li>
    </ol>
</section>

<div class="box">
    <small style="color: red; margin: 10px;">Peringatan: perubahan konfigurasi ini dapat mempengaruhi sistem yang berjalan, pastikan sebelum melakukan perubahan konfigurasi sudah di uji.</small>
    <div class="box-body">
        <form method="POST" class="form-horizontal" style="margin-top: 30px;">
            <div class="form-group"><label class="col-sm-2 control-label" id="name_konfigurasi">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="value_konfigurasi" id="value_konfigurasi">
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
        url     : "pages/konfigurasi/action-konfigurasi/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                console.log(json);
                document.getElementById("name_konfigurasi").innerText = json.data.name_konfigurasi;
                document.getElementById("value_konfigurasi").value = json.data.value_konfigurasi;
            }
        }
    });

    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/konfigurasi/konfigurasi.php');
    });

    $('#update').click(function () {
        var id              = code_id;
        var value_konfigurasi     = $('#value_konfigurasi').val();

        $.ajax({
            type    : "POST",
            url     : "pages/konfigurasi/action-konfigurasi/action.php?action=update",
            data    : {
                id: id,
                value_konfigurasi: value_konfigurasi
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/konfigurasi/konfigurasi.php');
                }
            }
        });
        return false;
    });
</script>
