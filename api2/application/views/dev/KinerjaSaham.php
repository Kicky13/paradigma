<?php
$user     = "DEVSD";
$pass     = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);


if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = 1;
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = 2016;
}


$sql = "SELECT * FROM KINERJA_SAHAM WHERE TAHUN =$tahun AND BULAN=$bulan";

$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
    
    $tgl = $rowID['TGL'];
	$company = $rowID['COMPANY'];
	$nilai_saham = $rowID['NILAI_SAHAM'];
	
	$pc_data3[$company][$tgl]=array(
			'company'=>$company,
			'tgl'=>$tgl,
			'nilai_saham'=>$nilai_saham,
			);
}
echo json_encode($pc_data3);
?>