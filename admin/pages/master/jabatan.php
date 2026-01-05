<?php
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
?>

<section class="content-header" style="margin-bottom: 10px">
    <h1>
        Jabatan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li class="active">Jabatan</li>
    </ol>
</section>

<div class="box">
    <div class="box-header" style="float: right;">
        <a class="btn btn-info button_menu_tambah" id="tambah-jabatan">Tambah</a>
    </div>

    <div class="box-body">
        <table id="table_jabatan" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Kode Jabatan</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM jabatan");
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['id_jabatan'];
                ?>
                <tr>
                    <td><?php echo $row['nomor_jabatan'] ?></td>
                    <td><?php echo $row['nama_jabatan'] ?></td>
                    <td>
                        <a class="btn btn-info button_menu" id="edit-jabatan" data-id="<?php echo $row['id_jabatan']; ?>">
                            <i class="fa fa-paste"></i> Ubah
                        </a>
                        <a class="btn btn-danger button_delete" data-id="<?php echo $row['id_jabatan']; ?>">
                            <i class="fa fa-warning"></i> <span class="bold">Hapus</span>
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
            if(menu === "tambah-jabatan"){
                $('#data_konten').load('pages/master/action-jabatan/tambah.php');
            }else if(menu === "edit-jabatan"){
                window.history.replaceState(null, null, "?id="+data_id);
                $('#data_konten').load('pages/master/action-jabatan/edit.php');
            }
        });

        $('.button_menu_tambah').click(function(){
            var menu = $(this).attr('id');
            if(menu === "tambah-jabatan"){
                $('#data_konten').load('pages/master/action-jabatan/tambah.php');
            }
        });

        $('#table_jabatan tbody').on('click', '.button_delete', function () {
            var result = confirm("Apakah kamu ingin menghapus data ini?");
            if (result) {
                var id = $(this).data('id');
                $.ajax({
                    type    : "POST",
                    url     : "pages/master/action-jabatan/action.php?action=delete",
                    data    : {
                        id: id
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
            }
        });
    });
</script>


