<?php
require 'vendor/autoload.php';
include 'config/connection.php';
include 'config/env.php';
include 'config/ektensi.php';
include 'config.php';
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/temp-mpdf']);
ob_start();

$sqlPendaki = mysqli_query($conn, "SELECT pendaki.*, mountain.nama AS gunung, indonesia_provinces.name AS province, 
    indonesia_cities.name AS citie, indonesia_districts.name AS district, indonesia_villages.name AS village, 
    pos.pp_nama AS jalur, pendaki.trx_pendakian_id AS trx_id FROM tb_pendakian pendaki
        LEFT JOIN tb_gunung mountain ON pendaki.tb_gunung_id=mountain.id  
        LEFT JOIN tb_anggota_pendakian anggota ON pendaki.pd_id=anggota.ap_pendakian 
        LEFT JOIN tb_kontak_darurat emergency ON pendaki.pd_id=emergency.kd_pendakian 
        LEFT JOIN indonesia_provinces ON pendaki.pd_provinsi=indonesia_provinces.code 
        LEFT JOIN indonesia_cities ON pendaki.pd_kabupaten=indonesia_cities.code 
        LEFT JOIN indonesia_districts ON pendaki.pd_kecamatan=indonesia_districts.code 
        LEFT JOIN indonesia_villages ON pendaki.pd_desa=indonesia_villages.code 
        LEFT JOIN tb_pos_pendakian pos ON pendaki.pd_pos_pendakian=pos.pp_id 
    WHERE pd_id = '$_GET[id]' ");
$rowPendaki = mysqli_fetch_array($sqlPendaki);

$sqlEmergency   = mysqli_query($conn, "SELECT * FROM tb_kontak_darurat WHERE kd_pendakian = '$rowPendaki[pd_id]'");

$sqlAnggota = mysqli_query($conn, "SELECT * FROM tb_anggota_pendakian WHERE ap_pendakian ='$rowPendaki[pd_id]'");

$trx_id = $rowPendaki['trx_id'];
$codeContents ="id: $trx_id\nstatus: group";
?>
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 2px 3px;
            border-style: solid;
            border-width: 0px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg th {
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            padding: 0;
            border-style: solid;
            border-width: 0px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg .tg-xeyn {
            font-weight: bold;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-2c25 {
            font-weight: bold;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-puex {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: center
        }

        .tg .tg-lj5e {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-rv8m {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: center
        }

        .tg .tg-vlyc {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif !important;
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        .list tr td {
            padding: 0px !important;
        }

        .ta {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .ta td {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .ta th {
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            padding: 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .ta .tg-hgcj {
            font-weight: bold;
            text-align: center
        }

        .ta .tg-0lax {
            text-align: left;
            vertical-align: top;
            text-transform: capitalize;
        }

        .tb {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tb td {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 0;
            border-style: solid;
            border-width: 0;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tb th {
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            padding: 0;
            border-style: solid;
            border-width: 0;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tb .tg-s6z2 {
            text-align: center
        }

        .tb .tg-baqh {
            text-align: center;
            vertical-align: top
        }

        .tb .tg-hgcj {
            font-weight: bold;
            text-align: center
        }

        .page_break { page-break-before: always; }

        .centered{
            text-align: center;
        }
        .m-0{
            margin: 0;
            font-size: 13px;
        }
    </style>

    <table class="tg" style="undefined;table-layout: fixed; width: 720px">
        <tr>
            <td class="centered" style="text-align: right;">
                <img style="height: 120px;" src="assets/img/logo_jawa_timur.png">
            </td>
            <td class="centered" colspan="2" style="width: 700px">
                <h3 class="m-0 text-indent">PEMERINTAH PROVINSI JAWA TIMUR</h3>
                <h3 class="m-0 text-indent">DINAS KEHUTANAN</h3>
                <h3 class="m-0 text-indent">UPT TAMAN HUTAN RAYA (TAHURA) RADEN SOERJO</h3>
                <h3 class="m-0 text-indent" style="font-weight: normal;">Jl. Simpang Panji Suroso Kav. 144, Telp. 0341-483254</h3>
                <h3 class="m-0 text-indent">MALANG</h3>
            </td>
            <td style="width: 100px">
                <img class="img-qrcode" src="https://image-charts.com/chart?cht=qr&chl=<?php echo $codeContents ?>&chs=75x75&choe=UTF-8&icqrf=00000000"/>
                <p><center><strong>PIN <?php echo base64_decode($rowPendaki['code']); ?></strong></center></p>
            </td>
        </tr>
        <tr>
            <td class="tg-lj5e" colspan="4">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="tg-xeyn" colspan="4"><h3>SURAT IZIN KHUSUS PENDAKIAN GUNUNG DI KAWASAN TAHURA RADEN SOERJO</h3></td>
        </tr>
        <tr>
            <td class="tg-lj5e" colspan="4">Nomor Registrasi : <?php echo $rowPendaki['pd_nomor'] ?> Tanggal <?php echo date('d/m/Y', strtotime($rowPendaki['pd_tanggal_registrasi'])) ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px" class="tg-lj5e" colspan="4">Nomor Karcis : .......................s/d...........................</td>
        </tr>
        <tr>
            <td style="width: 10px" class="tg-vlyc" colspan="4">Berdasarkan :
                <span style="padding-left: 25px"> 1. Pasal 31 Undang-Undang Nomor 5 Tahun 1990 tentang Konservasi Sumber Daya Alam Hayati dan Ekosistemnya;</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 100px; padding-bottom: 5px" class="tg-vlyc" colspan="4">2. Peraturan Daerah Provinsi Jawa Timur Nomor 2 Tahun 2013 tentang Pengelolaan Taman Hutan Raya Raden Soerjo.</td>
        </tr>
        <tr>
            <td style="padding-bottom: 5px" class="tg-vlyc" colspan="4">Memberikan izin kepada :</td>
        </tr>
        <tr>
            <td colspan="4">
                <table class="list">
                    <tr>
                        <td class="tg-2c25" width="70px">Nama Ketua </td>
                        <td width="10px">:</td>
                        <td class="tg-vlyc" style="width: 300px"><?php echo $rowPendaki['pd_nama_ketua'] ?></td>
                    </tr>
                    <tr>
                        <td class="tg-2c25">Nomor Identitas </td>
                        <td>:</td>
                        <td class="tg-vlyc"><?php echo $rowPendaki['pd_no_ktp'] ?></td>
                    </tr>
                    <tr>
                        <td class="tg-2c25">Tempat, Tanggal Lahir </td>
                        <td>:</td>
                        <td class="tg-vlyc"><?php echo $rowPendaki['pd_tempat_lahir'].', '.tgl_indo($rowPendaki['pd_tgl_lahir']);?></td>
                    </tr>
                    <tr>
                        <td class="tg-2c25">Kebangsaan </td>
                        <td>:</td>
                        <td class="tg-vlyc" style="padding-right: 20px;"><?php echo $rowPendaki['pd_kewarganegaraan'] ?></td>
                    </tr>
                    <tr>
                        <td class="tg-2c25">Alamat Lengkap </td>
                        <td>:</td>
                        <td class="tg-vlyc"><?php echo $rowPendaki['pd_alamat'].', '.$rowPendaki['village'].', '.$rowPendaki['district'].', '.$rowPendaki['citie'].', '.$rowPendaki['province']?></td>
                    </tr>
                    <tr>
                        <td class="tg-2c25">Personel (beserta ketua) </td>
                        <td>:</td>
                        <td class="tg-vlyc"><?php echo mysqli_num_rows($sqlAnggota)+1; ?> Orang</td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php
        $diff   = abs(strtotime($rowPendaki['tgl_naik']) - strtotime($rowPendaki['tgl_turun']));
        $years  = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        if ( date('d/m/Y', strtotime($rowPendaki['tgl_naik']))  ==  date('d/m/Y', strtotime($rowPendaki['tgl_turun'])) ) {
            $hari = 1;
        }
        else{
            $hari = $days + 1;
        }
        ?>

        <tr>
            <td style="padding: 5px 3px" class="tg-vlyc" colspan="4">Memasuki Kawasan Tahura Raden Soerjo untuk melakukan pendakian <strong> <?php echo strtoupper($rowPendaki['gunung'])." via ".$rowPendaki['jalur']?></strong> mulai tanggal <?php echo date('d/m/Y', strtotime($rowPendaki['tgl_naik'])).' s/d '.date('d/m/Y', strtotime($rowPendaki['tgl_turun'])).' selama '. $hari; ?> hari, dengan ketentuan sebagai berikut :</td>
        </tr>

        <tr>
            <td colspan="4">
                <table class="list">
                    <tr>
                        <td class="tg-vlyc">1.</td>
                        <td class="tg-vlyc">Pendaki usia kurang dari 17 tahun harus menyerahkan surat izin dari orangtua/wali dilampiri fotocopy KTP orangtua/wali;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">2.</td>
                        <td class="tg-vlyc">Ketua rombongan wajib menyerahkan kartu identitas (KTP/SIM/KTM/Kartu Pelajar) yang masih berlaku kepada Petugas di Pos Perizinan Pendakian;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">3.</td>
                        <td class="tg-vlyc">Pendaki wajib mengisi daftar/list perlengkapan yang dibawa sebagaimana blanko isian terlampir;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">4.</td>
                        <td class="tg-vlyc">Mematuhi dan membayar Retribusi Masuk Kawasan Tahura Raden Soerjo dan Asuransi sejumlah personil sesuai peraturan perundangundangan yang berlaku dan pastikan Bukti Retribusi/Karcis adalah berkas eSimaksi yang dikeluarkan oleh UPT Tahura Raden Soerjo dan Karcis Asuransi oleh PT. ASURANSI JIWA SYARIAH AMANAHJIWA GIRI ARTHA sesuai dengan jumlah personil serta menyimpan bukti tersebut;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">5.</td>
                        <td class="tg-vlyc">Pada saat melakukan pendakian agar berjalan secara berkelompok, tidak memisahkan diri dari kelompok/ rombongan; berjalan sesuai jalur yang telah ditetapkan dan dilarang untuk membuat/memotong jalur;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">6.</td>
                        <td class="tg-vlyc">Dilarang melakukan tindakan yang mengakibatkan kerusakan flora/fauna, melakukan coretan-coretan/ vandalisme pada benda-benda, pohon, bebatuan dan atau bangunan di dalam kawasan;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">7.</td>
                        <td class="tg-vlyc">Dilarang memaksakan diri untuk melanjutkan perjalanan jika situasi dan kondisi tidak memungkinkan (kesehatan, cuaca, keamanan dll);</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">8.</td>
                        <td class="tg-vlyc">Dilarang melanggar norma-norma susila, nilai-nilai adat-istiadat masyarakat setempat;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">9.</td>
                        <td class="tg-vlyc">Dilarang membawa, menggunakan minuman keras dan obat-obatan terlarang (narkoba);</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">10.</td>
                        <td class="tg-vlyc">Dilarang membuang sampah sembarangan dan bawalah sampah anda turun kembali (bungkus/kaleng bekas makanan, botol/kaleng bekas minuman dan sejenisnya) serta wajib menjaga kebersihan dan keamanan kawasan;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">11.</td>
                        <td class="tg-vlyc">Menjaga keselamatan kelompok dan sesama pengunjung/pendaki;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">12.</td>
                        <td class="tg-vlyc">Turut berpartisipasi dalam upaya Pencegahan, Pengendalian dan Penanggulangan Bencana Alam, dan memastikan bahwa tempat yang ditinggalkan tidak terdapat api/bara api;</td>
                    </tr>
                    <tr>
                        <td class="tg-vlyc">13.</td>
                        <td class="tg-vlyc">Segala bentuk pelanggaran yang menyalahi peraturan akan dikenakan Sanksi sesuai peraturan perundang-undangan yang berlaku.</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding: 5px 0 50px 3px" class="tg-vlyc" colspan="4">Demikian Surat Izin ini diberikan untuk dilaksanakan dan dipatuhi dengan penuh tanggung jawab</td>
        </tr>
        <tr>
            <td style="padding-bottom: 50px" class="tg-lj5e" colspan="2"><span style="font-weight:bold">Penerima/Pemegang Surat Izin</span></td>
            <td class="tg-lj5e" colspan="2"><span style="font-weight:bold">Petugas Pos Pendakian .................</span></td>
        </tr>
        <tr>
            <td class="tg-lj5e" colspan="2"></td>
            <td class="tg-lj5e" colspan="2"></td>
        </tr>
        <tr>
            <td class="tg-lj5e" colspan="2">..........................</td>
            <td class="tg-lj5e" colspan="2">.............................</td>
        </tr>
        <tr>
            <td class="tg-lj5e" colspan="2"></td>
        </tr>
    </table>

    <div class="page_break">
        <table class="tg">
            <tr>
                <td class="tg-2c25">Lampiran</td>
                <td class="tg-2c25">:</td>
                <td class="tg-2c25">Surat Izin Khusus Pendakian Gunung Di Kawasan Tahura Raden Soerjo</td>
                <td rowspan="4" style="vertical-align: top">
                    <!-- barcode -->
                </td>
            </tr>
            <tr>
                <td class="tg-2c25">No. Registrasi</td>
                <td class="tg-2c25">:</td>
                <td class="tg-2c25"><?php echo $rowPendaki['pd_nomor']; ?></td>
            </tr>
        </table>

        <h5 style="margin: 10px 0;">I. DAFTAR NAMA PENDAKI</h5>
        <table class="ta">
            <tr>
                <th class="tg-hgcj" style="width: 20px;">No</th>
                <th class="tg-hgcj" style="width: 200px">Nama</th>
                <th class="tg-hgcj" style="width: 120px">No Identitas</th>
                <th class="tg-hgcj" style="width: 100px">No. Telepon</th>
                <th class="tg-hgcj" style="width: 50px">Kewarganegaraan</th>
                <th class="tg-hgcj" style="width: 10px">L/P</th>
            </tr>
            <tr>
                <td class="tg-0lax" style="text-align: center;">1.</td>
                <td class="tg-0lax"><?php echo $rowPendaki['pd_nama_ketua'] ?></td>
                <td class="tg-0lax"><?php echo $rowPendaki['pd_no_ktp'] ?></td>
                <td class="tg-0lax"><?php echo $rowPendaki['pd_no_hp'] ?></td>
                <td class="tg-0lax" style="text-align: center;"><?php echo $rowPendaki['pd_kewarganegaraan'] ?></td>
                <td class="tg-0lax" style="text-align: center;"><?php echo $rowPendaki['pd_jenis_kelamin'] ?></td>
            </tr>

            <?php
            $no = 2;
            while ($anggota = mysqli_fetch_array($sqlAnggota)) { ?>
                <tr>
                    <td class="tg-0lax" style="text-align: center;"><?php echo $no; ?>.</td>
                    <td class="tg-0lax" style="width: 260px"><?php echo $anggota['ap_nama']; ?></td>
                    <td class="tg-0lax"><?php echo $anggota['ap_no_ktp']; ?></td>
                    <td class="tg-0lax"><?php echo $anggota['ap_no_telp']; ?></td>
                    <td class="tg-0lax" style="text-align: center;"><?php echo $anggota['ap_kewarganegaraan']; ?></td>
                    <td class="tg-0lax" style="text-align: center;"><?php echo $anggota['ap_kelamin']; ?></td>
                </tr>
                <?php
                $no++; }
            ?>
        </table>

        <h5 style="margin-bottom: 5px">II. KONTAK YANG DAPAT DIHUBUNGI KETIKA KEADAAN DARURAT</h5>
        <table class="ta">
            <tr>
                <th class="tg-hgcj" style="width: 225px">Nama</th>
                <th class="tg-hgcj" style="width: 100px">No. Telepon</th>
                <th class="tg-hgcj" style="width: 80px">Hubungan</th>
            </tr>
            <?php
            while ($kontak = mysqli_fetch_array($sqlEmergency)) { ?>
                <tr>
                    <td class="tg-0lax"><?php echo $kontak['kd_nama']; ?></td>
                    <td class="tg-0lax"><?php echo $kontak['kd_no_telp']; ?></td>
                    <td class="tg-0lax"><?php echo $kontak['kd_hubungan']; ?></td>
                </tr>
            <?php }
            ?>
        </table>

        <table class="tb" style="undefined;table-layout: fixed; width: 720px; margin-top: 40px ">
            <colgroup>
                <col style="width: 360px">
                <col style="width: 360px">
            </colgroup>
            <tr>
                <th class="tg-hgcj">Telah dicek oleh :</th>
                <th class="tg-hgcj">Tanggal <?php echo date('d/m/Y', strtotime($rowPendaki['tgl_naik'])) ?></th>
            </tr>
            <tr>
                <td class="tg-baqh" style="padding-bottom: 60px">Petugas Pos Pendakian</td>
                <td class="tg-baqh">Penerima/Pemegang Surat Izin</td>
            </tr>
            <tr>
                <td class="tg-s6z2"></td>
                <td class="tg-s6z2"></td>
            </tr>
            <tr>
                <td class="tg-baqh">...................</td>
                <td class="tg-baqh">.......................</td>
            </tr>
        </table>

        <table class="list tg" style="margin-top: 40px">
            <tr>
                <td colspan="2" class="tg-vlyc">Catatan:</td>
            </tr>
            <tr>
                <td class="tg-vlyc">1. </td>
                <td class="tg-vlyc">Pendaki wajib melaporkan diri saat naik dan ketika turun di pos pendakian resmi Tahura Raden Soerjo</td>
            </tr>
            <tr>
                <td class="tg-vlyc">2. </td>
                <td class="tg-vlyc">Membawa pulang semua sampah selama berada dikawasan gunung Arjuno Welirang</td>
            </tr>
            <tr>
                <td class="tg-vlyc">3. </td>
                <td class="tg-vlyc">Wajib membawa tanda pengenal asli</td>
            </tr>
        </table>
    </div>


<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>