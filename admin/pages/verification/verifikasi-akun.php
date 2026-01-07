<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Akun Verifikasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Verification</a></li>
        <li class="active">Account</li>
    </ol>
</section>

<div class="box">
    <form action="" method="post">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-2">
                    <small class="control-label">Status Verifikasi:</small>
                    <select class="form-control" name="status_verifikai_akun" id="status_verifikai_akun">
                        <option value="all">Semua Status</option>
                        <option value="2">Pengajuan</option>
                        <option value="3">Terverifikasi</option>
                        <option value="4">Ditolak</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <small class="control-label">&nbsp;</small>
                    <div class="form-group">
                        <button class="btn btn-success" id="filter_verifikasi_akun" type="button">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="box-body">
        <table id="table_verifikasi_akun" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Email</th>
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
        var table = $('#table_verifikasi_akun').DataTable({
            'retrieve': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "ajax": {
                'url': 'pages/verification/action-verifikasi-akun/action.php?action=list',
                'data': function(data){
                    data.status_verifikai_akun = $('#status_verifikai_akun').val();
                },
            },
            'columns': [
                { data: 'email' },
                { data: 'status_code' },
                { data: 'action' },
            ]
        });
        table.draw();


    $('#filter_verifikasi_akun').click(function () {
        var status_verifikai_akun = $('#status_verifikai_akun').val();
        var table = $('#table_verifikasi_akun').DataTable({
            'retrieve': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "ajax": {
                'url': 'pages/report/action-transaksi/action.php?action=list',
                'data': function(data){
                    data.status_verifikai_akun = status_verifikai_akun;
                },
            },
            'columns': [
                { data: 'email' },
                { data: 'status' },
                { data: 'action' },
            ]
        });
        table.draw();
    });


    $('#table_verifikasi_akun tbody').on('click', '.button_menu', function () {
        var menu = $(this).attr('id');
        var data_id = $(this).data('id');
        if(menu === "detail-kelola-verifikasi-akun"){
            window.history.replaceState(null, null, "?id="+data_id);
            $('#data_konten').load('pages/verification/action-verifikasi-akun/detail.php');
        }
    });
</script>


