<?php
require '../../../vendor/autoload.php';
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
use Carbon\Carbon;
?>
<style>
    .btn_show {
        color: #0d8adc;
    }
    hr {
        margin: 0px;
    }
    .collapsible_css {
        cursor: pointer;
    }

    .collapsible_css:hover {
        color: #41dc0d;
    }

    .collapsible_css:after {
        content: '\002B';
        color: white;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .content_css {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background-color: #f1f1f1;
    }
</style>

<!---->
<!--<button class="collapsible_css">Open Collapsible</button>-->
<!--<div class="content_css">-->
<!--    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--</div>-->

<!--<p>Collapsible Set:</p>-->
<!--<button class="collapsible_css">Open Section 1</button>-->
<!--<div class="content_css">-->
<!--    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--</div>-->

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> RINCIAN PENDAKI PADA <?php echo Carbon::now()->format('d-m-Y'); ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr class="tengah">
                        <th>Pos Pendakian</th>
                        <th>Jumlah Pendaki</th>
                        <th>WNI</th>
                        <th>WNA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $date_now = Carbon::now()->format('Y-m-d');
                    $sql = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian");
                    while ($row = mysqli_fetch_array($sql)) { ?>
                        <td><?php echo $row['pp_nama']; ?></td>
                        <td class="tengah">
                            <?php
                            $tot   = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_pendakian WHERE pd_pos_pendakian = '$row[pp_id]' AND is_region_new=1 AND pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            $total = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_pendakian trx JOIN tb_anggota_pendakian det ON trx.pd_id=det.ap_pendakian WHERE trx.pd_pos_pendakian='$row[pp_id]' AND trx.is_region_new=1 AND trx.pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            echo $tot['jml']+$total['jml'].' Orang';
                            ?>
                        </td>
                        <td class="tengah">
                            <?php
                            $wni = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_pendakian WHERE pd_pos_pendakian='$row[pp_id]' AND pd_kewarganegaraan='WNI' AND is_region_new=1 AND pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            $wniang = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_anggota_pendakian det JOIN tb_pendakian trx ON det.ap_pendakian=trx.pd_id WHERE trx.pd_pos_pendakian = '$row[pp_id]' AND det.ap_kewarganegaraan = 'WNI' AND trx.is_region_new=1 AND trx.pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            echo $wni['jml']+$wniang['jml'].' Orang';
                            ?>
                        </td>
                        <td class="tengah">
                            <?php
                            $wna = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_pendakian WHERE pd_pos_pendakian = '$row[pp_id]' AND pd_kewarganegaraan = 'WNA' AND is_region_new=1 AND pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            $wnaang = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as jml FROM tb_anggota_pendakian det JOIN tb_pendakian trx ON det.ap_pendakian=trx.pd_id WHERE trx.pd_pos_pendakian = '$row[pp_id]' AND det.ap_kewarganegaraan = 'WNA' AND trx.is_region_new=1 AND trx.pd_tgl_naik IS NOT NULL AND DATE(pd_tgl_naik)='$date_now'"));
                            echo $wna['jml']+$wnaang['jml'].' Orang';
                            ?>
                        </td>
                        </tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> LAPORAN TIKET TERJUAL</h3>
            </div>
            <div class="box-body">
                <form method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">BULAN:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="bulan_select" id="bulan_select">
                                <?php
                                $bulan = [
                                    [
                                        "code"  => 1,
                                        "bulan" => "Januari",
                                    ],
                                    [
                                        "code"  => 2,
                                        "bulan" => "Februari",
                                    ],
                                    [
                                        "code"  => 3,
                                        "bulan" => "Maret",
                                    ],
                                    [
                                        "code"  => 4,
                                        "bulan" => "April",
                                    ],
                                    [
                                        "code"  => 5,
                                        "bulan" => "Mei",
                                    ],
                                    [
                                        "code"  => 6,
                                        "bulan" => "Juni",
                                    ],
                                    [
                                        "code"  => 7,
                                        "bulan" => "Juli",
                                    ],
                                    [
                                        "code"  => 8,
                                        "bulan" => "Agustus",
                                    ],
                                    [
                                        "code"  => 9,
                                        "bulan" => "September",
                                    ],
                                    [
                                        "code"  => 10,
                                        "bulan" => "Oktober",
                                    ],
                                    [
                                        "code"  => 11,
                                        "bulan" => "November",
                                    ],
                                    [
                                        "code"  => 12,
                                        "bulan" => "Desember",
                                    ],
                                ];
                                $current_month = date('m');
                                $get_bulan     = $_GET['bulan'];
                                foreach ($bulan as $item) {
                                    $set_code = $item['code'];
                                    $set_bulan = $item['bulan'];
                                    if(intval($current_month) == $set_code){
                                        echo "<option value='$set_code' selected>$set_bulan</option>";
                                    }else{
                                        echo "<option value='$set_code'>$set_bulan</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                <div id="list_pos_order">
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var bulan_select = $('#bulan_select').val();
    $.ajax({
        type: 'POST',
        url: "pages/dashboard/action.php?action=pos_perbulan",
        data: {bulan_select: bulan_select},
        cache: false,
        success: function(response){
            $('#list_pos_order').html("");
            var json = $.parseJSON(response);
            var div_format = "";
            $.each(json.data, function (key, value) {
                div_format += "<div class='box-body'><strong>"+value.pos+"</strong><span class='collapsible_css btn_show' style='float: right;'>Show data</span>\
                <div class='content_css'>\
                <div class='box box-solid collapsed-box'>\
                <table class='table table-hover'>\
                <thead>\
                <tr>\
                <caption>View data: "+value.pos+"</caption>\
                <th>Tanggal</th>\
                <th>Order</th>\
                </tr>\
                </thead>\
                <tbody>";
                $.each(value.detail, function (keydet, det) {
                    div_format += "<tr><td>"+det.date+"</td>\
                    <td><strong>"+det.total+"</strong> Pesanan <i class='fa fa-level-up'></i></td>";
                });
                div_format += "</tbody></table></div></div></div><hr>";
            });
            $('#list_pos_order').html(div_format);

            var coll = document.getElementsByClassName("collapsible_css");
            var i;

            for (i = 0; i < coll.length; i++) {
                var btnaction = coll[i];
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.maxHeight){
                        content.style.maxHeight = null;
                        this.textContent = 'Show data';
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                        this.textContent = 'Hidden data';
                    }
                });
            }
        }
    });

    $('#bulan_select').on('change', function() {
        var bulan_select = this.value;
        $.ajax({
            type: 'POST',
            url: "pages/dashboard/action.php?action=pos_perbulan",
            data: {bulan_select: bulan_select},
            cache: false,
            success: function(response){
                $('#list_pos_order').html("");
                var json = $.parseJSON(response);
                var div_format = "";
                $.each(json.data, function (key, value) {
                    div_format += "<div class='box-body'><strong>"+value.pos+"</strong><span class='collapsible_css btn_show' style='float: right;'>Show data</span>\
                    <div class='content_css'>\
                    <div class='box box-solid collapsed-box'>\
                    <table class='table table-hover'>\
                    <thead>\
                    <tr>\
                    <caption>View data: "+value.pos+"</caption>\
                    <th>Tanggal</th>\
                    <th>Order</th>\
                    </tr>\
                    </thead>\
                    <tbody>";
                    $.each(value.detail, function (keydet, det) {
                        div_format += "<tr><td>"+det.date+"</td>\
                        <td><strong>"+det.total+"</strong> Pesanan <i class='fa fa-level-up'></i></td>";
                    });
                    div_format += "</tbody></table></div></div></div><hr>";
                });
                $('#list_pos_order').html(div_format);

                var coll = document.getElementsByClassName("collapsible_css");
                var i;

                for (i = 0; i < coll.length; i++) {
                    var btnaction = coll[i];
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.maxHeight){
                            content.style.maxHeight = null;
                            this.textContent = 'Show data';
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                            this.textContent = 'Hidden data';
                        }
                    });
                }
            }
        });
    });

</script>