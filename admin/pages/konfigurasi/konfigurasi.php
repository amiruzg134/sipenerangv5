<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Konfigurasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> System</a></li>
        <li class="active">Konfigurasi</li>
    </ol>
</section>

<div class="box">
    <div class="box-header" style="float: right;">
        <a class="btn btn-info info" id="info">Info</a>
    </div>

    <div class="box-body">
        <small style="color: red;">Peringatan: perubahan konfigurasi ini dapat mempengaruhi sistem yang berjalan, pastikan sebelum melakukan perubahan konfigurasi sudah di uji.</small>
        <table id="table_jabatan" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM tb_config");
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['id'];
                ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['value'] ?></td>
                    <td>
                        <a class="btn btn-info button_menu" id="edit-konfigurasi" data-id="<?php echo $row['id']; ?>">
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
        $('#table_jabatan').DataTable();
        $('#table_jabatan tbody').on('click', '.button_menu', function () {
            var menu = $(this).attr('id');
            var data_id = $(this).data('id');
            if(menu === "edit-konfigurasi"){
                window.history.replaceState(null, null, "?id="+data_id);
                $('#data_konten').load('pages/konfigurasi/action-konfigurasi/edit.php');
            }
        });

        $('.info').click(function(){
            window.history.replaceState(null, null, "?id=information");
            $('#data_konten').load('pages/konfigurasi/action-konfigurasi/info.php');
        });
    });
</script>


