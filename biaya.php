<section class="py-lg-5 mt-4">
  <div class="container">
    <div class="row">
      <div class="card">
        <div class="row">
          <div class="col-lg-8">
            <div class="card-body">
              <h3 class="text-dark"><?php echo ($_POST['tjn'] == 'arjuno' ? 'Gunung Arjuno Welirang' : 'Gunung Pundak' )?></h3>
              <h6 class="text-dark ">Tanggal : <?php echo date('d/m/Y', strtotime($_POST['tglnaik'])).' - '. date('d/m/Y', strtotime($_POST['tglturun'])) ?></h6>
              <h6 class="text-dark ">Sisa Kuota : <?php echo ($_POST['tjn'] == 'arjuno' ? $kuota['kuota']-($arjuno1['jml']+$arjuno2['jml']) : $kuota['kuota']-($pundak1['jml']+$pundak2['jml']) ) ?></h6>
                <label class="form-label mt-4">Rincian biaya :</label>
                <ul>
                    <?php
                    $startDate 	= strtotime($_POST['tglnaik']);
                    $endDate 		= strtotime($_POST['tglturun']);
                    $totalbayar = 0;

                    for ($i = $startDate; $i <= $endDate; $i += (86400)) {
                      ?>
                        <li>Tanggal
                            <?php
                                $date = new DateTime(date('Y-m-d', $i));
                                if ($_POST['tjn'] == 'arjuno') {
                                    if ($date->format('N') >= 6) {
                                        $ket 		= 'Hari Libur';
                                        $tarif 	= 15000;
                                    }
                                    elseif(
                                        date('d-m-Y', $i) == '07-04-2023' ||
                                        date('d-m-Y', $i) == '19-04-2023' ||
                                        date('d-m-Y', $i) == '20-04-2023' ||
                                        date('d-m-Y', $i) == '21-04-2023' ||
                                        date('d-m-Y', $i) == '22-04-2023' ||
                                        date('d-m-Y', $i) == '23-04-2023' ||
                                        date('d-m-Y', $i) == '24-04-2023' ||
                                        date('d-m-Y', $i) == '25-04-2023' ||
                                        date('d-m-Y', $i) == '01-05-2023' ||
                                        date('d-m-Y', $i) == '18-05-2023' ||
                                        date('d-m-Y', $i) == '01-06-2023' ||
                                        date('d-m-Y', $i) == '02-06-2023' ||
                                        date('d-m-Y', $i) == '04-06-2023' ||
                                        date('d-m-Y', $i) == '29-06-2023' ||
                                        date('d-m-Y', $i) == '19-07-2023' ||
                                        date('d-m-Y', $i) == '17-08-2023' ||
                                        date('d-m-Y', $i) == '28-09-2023' ||
                                        date('d-m-Y', $i) == '25-12-2023' ||
                                        date('d-m-Y', $i) == '26-12-2023'
                                    ){
                                        $ket 		= 'Hari Libur Nasional';
                                        $tarif 	= 15000;
                                    }
                                    else {
                                        $ket 		= 'Hari Kerja';
                                        $tarif 	= 10000;
                                    }
                                }
                                else{
                                    if ($date->format('N') >= 6) {
                                        $ket 		= 'Hari Libur';
                                        $tarif 	= 10000;
                                    }
                                    else {
                                        $ket 		= 'Hari Kerja';
                                        $tarif 	= 10000;
                                    }
                                }
                                echo date('d/m/Y', $i).' <small>('.$ket.')</small>';
                            ?>
                            <table class="table table-bordered" style="margin-top: 0.5rem">
                                <tr>
                                    <td>WNI :</td>
                                    <td><?php echo $_POST['wni'].' x '.number_format($tarif,0,",",".") ?></td>
                                    <td><?php echo 'Rp. '.number_format($_POST['wni']*$tarif,0,",",".") ?></td>
                                </tr>
                                <tr>
                                    <td>WNA :</td>
                                    <td><?php echo $_POST['wna'] .' x 200.000'?></td>
                                    <td><?php echo 'Rp. '.number_format($_POST['wna']*200000,0,",",".") ?></td>
                                </tr>
                            </table>
                        </li>
                    <?php
                        $totalbayar += ($_POST['wni']*$tarif)+($_POST['wna']*200000);
                    }
                ?>
                </ul>
            </div>
          </div>
          <div class="col-lg-4 my-auto">
              <h6 class="mt-sm-4 mt-0 mb-0">Total Tagihan Pembayaran</h6>
              <h1 class="mt-0">
                <small>Rp. </small><?php echo number_format($totalbayar,0,",",".") ?>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>