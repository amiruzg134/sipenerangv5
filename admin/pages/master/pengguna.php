<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<style>
    .btn-sync {
        position: relative;
        padding: 10px 20px;
        border: none;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        overflow: hidden;
        transition: padding-right 0.3s;
    }

    .btn-sync.loading {
        padding-right: 40px;
    }

    .spinner {
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-left-color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 15px;
        top: 30%;
        display: none;
    }

    .btn-sync.loading .spinner {
        display: block;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Kelola Pengguna
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Pengguna</li>
    </ol>
</section>

<div class="box">
    <div class="box-header">
        <a class="btn btn-info button_menu_tambah" id="tambah-kelola-pengguna">Tambah</a>
    </div>

    <button id="sync-user" class="btn-sync" style="float: right; margin: 10px;">
        <span class="btn-text">Sinkronisasi</span>
        <span class="spinner"></span>
    </button>

    <div class="box-body">
        <table id="table_pengguna" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM user");
            while ($row = mysqli_fetch_array($sql)) {
                $nam_jabatan = null;
                $jabatan_id = $row['id_jabatan'];
                if (!empty($jabatan_id)){
                    $rowJabatan     = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM jabatan WHERE  id_jabatan= '$jabatan_id' "));
                    $nam_jabatan    = $rowJabatan['nama_jabatan'];
                }
                ?>
                <tr>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nip']; ?></td>
                    <td><?php echo $nam_jabatan; ?></td>
                    <td>
                        <a class="btn btn-info button_menu" id="edit-kelola-pengguna" data-id="<?php echo $row['user_id']; ?>">
                            <i class="fa fa-paste"></i> Ubah
                        </a>
                    </td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#table_pengguna').DataTable();
    });


    $('.button_menu_tambah').click(function(){
        var menu = $(this).attr('id');
        if(menu === "tambah-kelola-pengguna"){
            $('#data_konten').load('pages/master/action-pengguna/tambah.php');
        }
    });

    $('#table_pengguna tbody').on('click', '.button_menu', function () {
        var menu = $(this).attr('id');
        var data_id = $(this).data('id');
        if(menu === "tambah-kelola-pengguna"){
            $('#data_konten').load('pages/master/action-pengguna/tambah.php');
        }else if(menu === "edit-kelola-pengguna"){
            window.history.replaceState(null, null, "?id="+data_id);
            $('#data_konten').load('pages/master/action-pengguna/edit.php');
        }
    });

    $('#sync-user').click(function () {
        var button = $(this);
        button.addClass('loading');
        button.prop('disabled', true);

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pengguna/action.php?action=sync",
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/pengguna.php');
                }
            },
            complete: function() {
                button.removeClass('loading');
                button.prop('disabled', false);
            },
            error: function() {
                alert("Terjadi kesalahan saat sinkronisasi.");
                button.removeClass('loading');
                button.prop('disabled', false);
            }
        });
        return false;
    });
</script>


