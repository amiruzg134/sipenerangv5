<?php
session_start();
$uuid = $_SESSION['uuid'];
?>
<div class="content">
    <input type="hidden" id="uuid" value="<?php echo $uuid; ?>">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <span id="total_transaksi">0</span>
                    </h3>
                    <p>
                        Total Transaksi
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-info-circle"></i>
                </div>
                <a class="button_menu small-box-footer" id="transaksi">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i> <span>Transaksi</span>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <span id="total_transaksi_berhasil">0</span>
                    </h3>
                    <p>
                        Transaksi Sukses
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a class="button_menu small-box-footer" id="transaksi">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i> <span>Transaksi</span>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <span id="total_transaksi_menunggu">0</span>
                    </h3>
                    <p>
                        Transaksi Menunggu
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <a class="button_menu small-box-footer" id="transaksi">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i> <span>Transaksi</span>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <span id="total_transaksi_kadaluwarsa">0</span>
                    </h3>
                    <p>
                        Transaksi Kadaluwarsa
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-remove"></i>
                </div>
                <a class="button_menu small-box-footer" id="transaksi">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i> <span>Transaksi</span>
                </a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
</div>

<script>
    $(document).ready(function(){
        var uuid = $('#uuid').val();
        $.ajax({
            type: 'POST',
            url: "pages/action-dashboard.php",
            data: {uuid: uuid},
            cache: false,
            success: function(response){
                var json = $.parseJSON(response);

                document.getElementById("total_transaksi").textContent= json.data.total_transaksi;
                document.getElementById("total_transaksi_berhasil").textContent= json.data.total_sukses;
                document.getElementById("total_transaksi_menunggu").textContent= json.data.total_menunggu;
                document.getElementById("total_transaksi_kadaluwarsa").textContent= json.data.total_kadaluwarsa;
            }
        });


        $('.button_menu').click(function(){
            var menu = $(this).attr('id');
            if(menu === "transaksi"){
                $('#data_konten').load('pages/transaksi.php');
            }
        });

    });
</script>