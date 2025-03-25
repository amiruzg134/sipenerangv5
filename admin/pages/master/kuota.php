<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Kelola Kuota
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Tiket Kuota</li>
    </ol>
</section>

<div class="box">
    <div class="box-header" style="float: right;">
        <a class="btn btn-info button_menu_tambah" id="tambah-kelola-kuota">Tambah</a>
    </div>

    <form action="" method="post">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-2">
                    <select class="form-control" name="gunung_select" id="gunung_select"></select>
                </div>
                <div class="col-xs-2">
                    <select class="form-control" name="pos_select" id="pos_select"></select>
                </div>
                <div class="col-xs-2">
                    <select class="form-control" name="tahun_select" id="tahun_select">
                        <?php
                        $tahun = [
                            [
                                "tahun" => "2024",
                            ],
                            [
                                "tahun" => "2025",
                            ],
                            [
                                "tahun" => "2026",
                            ],
                            [
                                "tahun" => "2027",
                            ],
                        ];
                        $current_year = date('Y');
                        $get_tahun     = $_GET['tahun'];
                        foreach ($tahun as $item) {
                            $set_tahun = $item['tahun'];
                            if(!empty($get_tahun)){
                                if($get_tahun == $set_tahun){
                                    echo "<option value='$set_tahun' selected>$set_tahun</option>";
                                }else{
                                    echo "<option value='$set_tahun'>$set_tahun</option>";
                                }
                            }else{
                                if($current_year == $set_tahun){
                                    echo "<option value='$set_tahun' selected>$set_tahun</option>";
                                }else{
                                    echo "<option value='$set_tahun'>$set_tahun</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-2">
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
                <div class="col-xs-2">
                    <button class="btn btn-success" id="filter_kuota" type="button">Filter</button>
                </div>
            </div>
        </div>
    </form>

    <div class="box-body">
        <table id="table_kuota" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Tanggal</th>
                <th width="200px">Pos Pendakian</th>
                <th>Kuota</th>
                <th>Tersedia</th>
                <th>Weekday WNI</th>
                <th style="color: #c17f2a;">Weekday WNA</th>
                <th>Weekend WNI</th>
                <th style="color: #c17f2a;">Weekend WNA</th>
                <th style="color: #c17f2a;">Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#filter_kuota').click(function () {
        var gunung_select   = $("#gunung_select option:selected").val();
        var pos_select      = $('#pos_select option:selected').val();
        var tahun_select    = $('#tahun_select option:selected').val();
        var bulan_select    = $('#bulan_select option:selected').val();

        if (gunung_select == null || gunung_select === "" || pos_select == null || pos_select === "" || tahun_select == null || bulan_select == null){
            alert("isi semua filter untuk melihat data");
            return false;
        }{
            $(document).ready(function () {
                var table = $('#table_kuota').DataTable({
                    'retrieve': true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "ajax": {
                        'url': 'pages/master/action-kuota/action.php?action=list&gunung_select=' + gunung_select + '&pos_select=' + pos_select + '&tahun_select=' + tahun_select + '&bulan_select=' + bulan_select,
                        'data': function(data){
                            // Read values
                            var gunung_select = $('#gunung_select').val();
                            var pos_select = $('#pos_select').val();
                            var tahun_select = $('#tahun_select').val();
                            var bulan_select = $('#bulan_select').val();

                            // Append to data
                            data.gunung_select = gunung_select;
                            data.pos_select = pos_select;
                            data.tahun_select = tahun_select;
                            data.bulan_select = bulan_select;
                        },
                    },
                    'columns': [
                        {data: 'date'},
                        {data: 'pos'},
                        {data: 'stock'},
                        {data: 'stock_available'},
                        {data: 'price_weekday_wni'},
                        {data: 'price_weekday_wna'},
                        {data: 'price_weekend_wni'},
                        {data: 'price_weekend_wna'},
                        {data: 'is_active'},
                        {data: 'action'},
                    ]
                });
                table.draw();
            });
        }
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


    $('.button_menu_tambah').click(function(){
        var menu = $(this).attr('id');
        if(menu === "tambah-kelola-kuota"){
            $('#data_konten').load('pages/master/action-kuota/tambah.php');
        }
    });

    $('#table_kuota tbody').on('click', '.button_menu', function () {
        var menu = $(this).attr('id');
        var data_id = $(this).data('id');
        if(menu === "tambah-kelola-kuota"){
            $('#data_konten').load('pages/master/action-kuota/tambah.php');
        }else if(menu === "edit-kelola-kuota"){
            window.history.replaceState(null, null, "?id="+data_id);
            $('#data_konten').load('pages/master/action-kuota/edit.php');
        }
    });
</script>


