<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Update Jabatan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Jabatan</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <form method="POST" class="form-horizontal">
            <div class="form-group"><label class="col-sm-2 control-label">Nama Jabatan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan">
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
        url     : "pages/master/action-jabatan/action.php?action=detail",
        data    : {
            code_id: code_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.error){
                alert(json.message);
            }else{
                console.log(json);
                document.getElementById("nama_jabatan").value = json.data.nama_jabatan;
            }
        }
    });

    $('#batal').click(function () {
        window.history.replaceState(null, null, "?");
        $('#data_konten').load('pages/master/jabatan.php');
    });

    $('#update').click(function () {
        var id              = code_id;
        var nama_jabatan     = $('#nama_jabatan').val();

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-jabatan/action.php?action=update",
            data    : {
                id: id,
                nama_jabatan: nama_jabatan
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/jabatan.php');
                }
            }
        });
        return false;
    });
</script>
