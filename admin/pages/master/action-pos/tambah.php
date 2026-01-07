<?php
require_once ('../../../../config/connection.php');
require_once ('../../../../config/ektensi.php');
?>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Tambah Pos Perizinan
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
                        <option disabled selected> Pilih </option>
                        <?php
                        $sql_gunung = mysqli_query($conn, "SELECT * FROM tb_gunung");
                        while ($data_gunung=mysqli_fetch_array($sql_gunung)) {
                            if($row['tb_gunung_id'] == $data_gunung['id']){ ?>
                                <option value="<?=$data_gunung['id']?>" selected><?=$data_gunung['nama']?></option>
                            <?php }else{ ?>
                                <option value="<?=$data_gunung['id']?>"><?=$data_gunung['nama']?></option>
                            <?php }
                        }
                        ?>
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
                <label class="col-sm-4 control-label">Sync Mountain Gate Id </br><small>(harus sama dengan ID gunung tiketpendakian)</small></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="mountain_gate_id" id="mountain_gate_id">
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
        $('#data_konten').load('pages/master/pos.php');
    });

    $('#simpan').click(function () {
        var gunung_id           = $("#gunung_id").val();
        var pp_nama             = $('#pp_nama').val();
        var min_pesan           = $('#min_pesan').val();
        var max_pesan           = $('#max_pesan').val();
        var can_booking_before_day = $('#can_booking_before_day').val();
        var data_checked        = $('#data_checked').val();
        var mountain_gate_id    = $('#mountain_gate_id').val();

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pos/action.php?action=store",
            data    : {
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
