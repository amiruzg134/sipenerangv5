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
        Gunung
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Gunung</li>
    </ol>
</section>

<div class="box">
    <button id="sync-gunung" class="btn-sync" style="float: right; margin: 10px;">
        <span class="btn-text">Sinkronisasi</span>
        <span class="spinner"></span>
    </button>


    <div class="box-body">
        <table id="table_gunung" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Gunung Pendakian</th>
                <th>Maksimal Hari</th>
                <th>Aktif</th>
                <th>User Verifikasi</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM tb_gunung");
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['id'];
                ?>
                <tr>
                    <td><?php echo $row['nama'] ?></td>
                    <td><?php echo $row['max_date'] ?> Hari</td>
                    <td>
                        <?php
                        if($row['is_active'] == 1){
                            echo "Aktif";
                        }else{
                            echo "Non Aktif";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($row['is_verified_user'] == 1){
                            echo "Aktif";
                        }else{
                            echo "Non Aktif";
                        }
                        ?>
                    </td>
                    <td>
                    <a class="btn btn-info button_menu" id="edit-gunung" data-id="<?php echo $row['id']; ?>">
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
        $('#table_gunung').DataTable();
        $('.button_menu').click(function(){
            var menu = $(this).attr('id');
            var data_id = $(this).data('id');
            if(menu === "tambah-gunung"){
                $('#data_konten').load('pages/master/action-gunung/tambah.php');
            }else if(menu === "edit-gunung"){
                window.history.replaceState(null, null, "?id="+data_id);
                $('#data_konten').load('pages/master/action-gunung/edit.php');
            }
        });

        $('#sync-gunung').click(function () {
            var button = $(this);
            button.addClass('loading');
            button.prop('disabled', true);

            $.ajax({
                type    : "POST",
                url     : "pages/master/action-gunung/action.php?action=sync",
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.error){
                        alert(json.message);
                    }else{
                        alert(json.message);
                        window.history.replaceState(null, null, "?");
                        $('#data_konten').load('pages/master/gunung.php');
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
    });
</script>


