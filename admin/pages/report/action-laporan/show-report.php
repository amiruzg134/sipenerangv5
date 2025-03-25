<?php
if ($_GET['jenis_laporan'] == 'pendaki') {
    include 'laporan_pendaki.php';
} elseif ($_GET['jenis_laporan'] == 'keuangan') {
    include 'laporan_keuangan.php';
} elseif ($_GET['jenis_laporan'] == 'denda') {
    include 'laporan_denda.php';
} elseif ($_GET['jenis_laporan'] == 'asuransi') {
    include 'laporan_asuransi.php';
} elseif ($_GET['jenis_laporan'] == 'ringkas') {
    include 'laporan_ringkas.php';
}
