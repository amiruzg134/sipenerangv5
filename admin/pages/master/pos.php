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
        Pos Perizinan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Pos Perizinan</li>
    </ol>
</section>

<div class="box">
    <button id="sync-pos" class="btn-sync" style="float: right; margin: 10px;">
        <span class="btn-text">Sinkronisasi</span>
        <span class="spinner"></span>
    </button>

    <div class="box-body">
        <table id="table_pos" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Gunung Pendakian</th>
                <th>Pos Pendakian</th>
                <th>Minimal Order</th>
                <th>Maksimal Order</th>
                <th>H-Pemesanan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tb_pos_pendakian");
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['pp_id'];
                $id_gunung = $row['tb_gunung_id'];
                $sql_gunung = mysqli_query($conn, "SELECT * FROM tb_gunung WHERE id='$id_gunung'");
                $gunung     = mysqli_fetch_array($sql_gunung);
                if(!empty($gunung)){
                    $nama_gunung = $gunung['nama'];
                }else{
                    $nama_gunung = "-";
                }
                ?>
                <tr>
                    <td><?php echo $nama_gunung; ?></td>
                    <td><?php echo $row['pp_nama']; ?></td>
                    <td><?php echo $row['min_pesan']; ?></td>
                    <td><?php echo $row['max_pesan']; ?></td>
                    <td><?php echo $row['can_booking_before_day']; ?></td>
                    <td><?php
                        if($row['is_active'] == 1){
                            echo "Aktif";
                        }else{
                            echo "Non Aktif";
                        }
                        ?></td>
                    <td>
                        <a class="btn btn-info button_menu" id="edit-pos" data-id="<?php echo $row['pp_id']; ?>">
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
        $('#table_pos').DataTable();

        $('.button_menu').click(function(){
            var menu = $(this).attr('id');
            var data_id = $(this).data('id');
            if(menu === "tambah-pos"){
                $('#data_konten').load('pages/master/action-pos/tambah.php');
            }else if(menu === "edit-pos"){
                window.history.replaceState(null, null, "?id="+data_id);
                $('#data_konten').load('pages/master/action-pos/edit.php');
            }
        });
    });


    $('#sync-pos').click(function () {
        var button = $(this);
        button.addClass('loading');
        button.prop('disabled', true);

        $.ajax({
            type    : "POST",
            url     : "pages/master/action-pos/action.php?action=sync",
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.error){
                    alert(json.message);
                }else{
                    alert(json.message);
                    window.history.replaceState(null, null, "?");
                    $('#data_konten').load('pages/master/pos.php');
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


