<?php
header('Access-Control-Allow-Origin: *');
$user     = "DEVSD";
$pass     = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);


if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = date('m');
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = date('Y');
}

$bulan1=$bulan-1;
if($bulan1==0){
	$bulan2=12;
	$tahun1=$tahun-1;
}else{
	$bulan2=$bulan1;
	$tahun1=$tahun;
}

$cari= "SELECT COUNT(*) AS TOTAL FROM KINERJA_SAHAM WHERE TAHUN =$tahun AND BULAN=$bulan";

$queryOracle1 = oci_parse($conn, $cari); 
$rowID1=oci_execute($queryOracle1);
$rowID1 = oci_fetch_array($queryOracle1);
if($rowID1['TOTAL']>0){

$sql = "SELECT * FROM KINERJA_SAHAM WHERE TAHUN =$tahun AND BULAN=$bulan";

$queryOracle = oci_parse($conn, $sql); 
oci_execute($queryOracle);
$pc_data3 = null;
if (oci_fetch_array($queryOracle) != False){
while ($rowID = oci_fetch_array($queryOracle)) {
    
    $tgl = $rowID['TGL'];
	$company = $rowID['COMPANY'];
	$nilai_saham = $rowID['NILAI_SAHAM'];
	
	$pc_data3[$company][$tgl]=array(
			'company'=>$company,
			'tgl'=>$tgl,
			'nilai_saham'=>$nilai_saham
			);
}
}
echo json_encode($pc_data3);
}else{
	$sql = "SELECT * FROM KINERJA_SAHAM WHERE TAHUN =$tahun1 AND BULAN=$bulan2";

$queryOracle = oci_parse($conn, $sql); 
oci_execute($queryOracle);
$pc_data3 = null;
if (oci_fetch_array($queryOracle) != False){
while ($rowID = oci_fetch_array($queryOracle)) {
    
    $tgl = $rowID['TGL'];
	$company = $rowID['COMPANY'];
	$nilai_saham = $rowID['NILAI_SAHAM'];
	
	$pc_data3[$company][$tgl]=array(
			'company'=>$company,
			'tgl'=>$tgl,
			'nilai_saham'=>$nilai_saham
			);
}
}
echo json_encode($pc_data3);
}

?>