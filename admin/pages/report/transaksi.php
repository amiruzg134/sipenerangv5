<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Transaksi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Transaksi</li>
    </ol>
</section>

<div class="box">
    <form action="" method="post">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-2">
                    <small class="control-label">Status Data:</small>
                    <select class="form-control" name="filter_status_data" id="filter_status_data">
                        <option value="1">New</option>
                        <option value="0">Old</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <small class="control-label">Status Transaksi:</small>
                    <select class="form-control" name="filter_status_transaksi" id="filter_status_transaksi">
                        <option value="all">Semua Transaksi</option>
                        <option value="paid">Dibayar</option>
                        <option value="unpaid">Menunggu Pembayaran</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <div class="form-group" id="date_filter">
                        <div class="col-sm-12">
                            <small class="control-label">Tanggal:</small>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control" name="filter_start_date" id="filter_start_date" required/>
                                <span class="input-group-addon">s/d</span>
                                <input type="text" class="form-control" name="filter_end_date" id="filter_end_date" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2">
                    <small class="control-label">&nbsp;</small>
                    <div class="form-group">
                        <button class="btn btn-success" id="filter_transaksi" type="button">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="box-body">
        <table id="table_transaksi" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Kode Registrasi</th>
                <th>Nama</th>
                <th>Tanggal Naik</th>
                <th>Tanggal Turun</th>
                <th>Tanggal Trx</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
        var table = $('#table_transaksi').DataTable({
            'retrieve': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "ajax": {
                'url': 'pages/report/action-transaksi/action.php?action=list',
                'data': function(data){
                    var status_data         = $('#filter_status_data').val();
                    var status_transaksi    = $('#filter_status_transaksi').val();
                    var filter_start_date   = $('#filter_start_date').val();
                    var filter_end_date     = $('#filter_end_date').val();

                    data.status_data        = status_data;
                    data.status_transaksi   = status_transaksi;
                    data.filter_start_date  = filter_start_date;
                    data.filter_end_date    = filter_end_date;
                    data.filter_end_date    = filter_end_date;
                },
            },
            'columns': [
                { data: 'pd_nomor' },
                { data: 'pd_nama_ketua' },
                { data: 'tgl_naik' },
                { data: 'tgl_turun' },
                { data: 'pd_tanggal_registrasi' },
                { data: 'biaya' },
                { data: 'status' },
                { data: 'action' },
            ]
        });
        table.draw();


    $('#filter_transaksi').click(function () {
        var validate_start_date = $('#start_date').val();
        var validate_end_date   = $('#end_date').val();
        if ((validate_start_date === "" || validate_start_date == null)  && (validate_end_date === "" || validate_end_date == null)){
                var table = $('#table_transaksi').DataTable({
                    'retrieve': true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "ajax": {
                        'url': 'pages/report/action-transaksi/action.php?action=list',
                        'data': function(data){
                            var status_data = $('#filter_status_data').val();
                            var status_transaksi = $('#filter_status_transaksi').val();
                            var filter_start_date = $('#filter_start_date').val();
                            var filter_end_date   = $('#filter_end_date').val();
                            data.status_data = status_data;
                            data.status_transaksi = status_transaksi;
                            data.filter_start_date     = filter_start_date;
                            data.filter_end_date       = filter_end_date;
                        },
                    },
                    'columns': [
                        { data: 'pd_nomor' },
                        { data: 'pd_nama_ketua' },
                        { data: 'tgl_naik' },
                        { data: 'tgl_turun' },
                        { data: 'pd_tanggal_registrasi' },
                        { data: 'biaya' },
                        { data: 'status' },
                        { data: 'action' },
                    ]
                });
                table.draw();
        }else {
            if (validate_start_date === "" || validate_start_date == null) {
                alert("Masukan tanggal Awal");
                return false;
            } else {
                if (validate_end_date === "" || validate_end_date == null) {
                    alert("Masukan tanggal Akhir");
                    return false;
                }else{
                    $(document).ready(function () {
                        var table = $('#table_transaksi').DataTable({
                            'retrieve': true,
                            'processing': true,
                            'serverSide': true,
                            'serverMethod': 'post',
                            "ajax": {
                                'url': 'pages/report/action-transaksi/action.php?action=list',
                                'data': function(data){
                                    var status_transaksi = $('#filter_status_transaksi').val();
                                    var start_date = $('#filter_start_date').val();
                                    var end_date   = $('#filter_end_date').val();

                                    data.status_transaksi = status_transaksi;
                                    data.start_date     = start_date;
                                    data.end_date       = end_date;
                                },
                            },
                            'columns': [
                                { data: 'pd_nomor' },
                                { data: 'pd_nama_ketua' },
                                { data: 'tgl_naik' },
                                { data: 'tgl_turun' },
                                { data: 'pd_tanggal_registrasi' },
                                { data: 'biaya' },
                                { data: 'status' },
                                { data: 'action' },
                            ]
                        });
                        table.draw();
                    });
                }

            }
        }
    });


    $('#table_transaksi tbody').on('click', '.button_menu', function () {
        var menu = $(this).attr('id');
        var data_id = $(this).data('id');
        if(menu === "detail-kelola-transaksi"){
            window.history.replaceState(null, null, "?id="+data_id);
            $('#data_konten').load('pages/report/action-transaksi/detail.php');
        }
    });


    $('#date_filter .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
</script>


