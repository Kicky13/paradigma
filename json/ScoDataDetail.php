<?php
header('Access-Control-Allow-Origin: *');
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
$filter = $_GET['COM'];
$year = ($_GET['tahun']==null)? date('Y'):$_GET['tahun'];
//$sql = "select * from ZREPORT_RPTREAL_RESUM where COM = {$filter} ";
//$sql = "select * from ZREPORT_RPTREAL_RESUM inner join M_PROVINSI ON M_PROVINSI.KD_PROV = ZREPORT_RPTREAL_RESUM.PROPINSI WHERE ZREPORT_RPTREAL_RESUM.COM = {$filter}";
// $sql = "SELECT
// 	NM_PROV_1,
// 	PROPINSI,
// 	SUM (
// 		ZREPORT_RPTREAL_RESUM.TARGET_RKAP
// 	) AS TARGET_RKAP,
// 	SUM (
// 		ZREPORT_RPTREAL_RESUM.REALTO
// 	) AS REALTO
// FROM
// 	ZREPORT_RPTREAL_RESUM,
// 	M_PROVINSI
// WHERE
// 	ZREPORT_RPTREAL_RESUM.COM = {$filter}
// AND ZREPORT_RPTREAL_RESUM.TAHUN = {$year}
// AND ZREPORT_RPTREAL_RESUM.PROPINSI = M_PROVINSI.KD_PROV
// GROUP BY
// 	PROPINSI,
// 	NM_PROV_1"; 

if($filter == 6000){
	$sql = "SELECT VKBUR_TXT AS NM_PROV_1, 
	VKBUR AS PROPINSI,
	SUM (
		0
	) AS TARGET_RKAP,
	SUM (
		TOTAL_QTY
	) AS REALTO 
	FROM MV_REVENUE 
	WHERE VKORG IN '{$filter}' AND TO_CHAR (budat, 'yyyy') = '{$year}'
	GROUP BY
	VKBUR_TXT,
	VKBUR ";
}else{
	$sql = "SELECT SALES_BULANAN.NM_PROV_1,
SALES_BULANAN.PROPINSI,
REV_BULANAN.TARGET_RKAP,
SALES_BULANAN.REALTO
FROM(
SELECT VKBUR_TXT AS NM_PROV_1, 
	VKBUR AS PROPINSI,
	SUM (
		0
	) AS TARGET_RKAP,
	SUM (
		TOTAL_QTY
	) AS REALTO 
FROM MV_REVENUE 
WHERE VKORG IN '{$filter}' AND TO_CHAR (budat, 'yyyy') = '{$year}'
GROUP BY
	VKBUR_TXT,
	VKBUR 
)SALES_BULANAN 
LEFT JOIN (
SELECT PROPINSI, NVL(SUM(TARGET_RKAP), 0) AS TARGET_RKAP
FROM zreport_rptreal_resum
WHERE COM = {$filter} AND TAHUN = {$year}
GROUP BY PROPINSI
)REV_BULANAN
ON SALES_BULANAN.PROPINSI = REV_BULANAN.PROPINSI";
}

// echo $sql;


$queryOracle = oci_parse($conn,$sql);
oci_execute($queryOracle);
$total_array = array();
while ($rowID=oci_fetch_array($queryOracle)){
	if ($rowID['TARGET_RKAP'] == null) {
		# code...
		$TARGET = 0;
	}else{
		$TARGET = $rowID['TARGET_RKAP'];
	}
	// echo "target :";
	// echo $TARGET;

	$total_array[]=array("PROPINSI"=>$rowID['PROPINSI'],"TARGET_RKAP"=>$TARGET,"REALTO"=>$rowID['REALTO'],"NM_PROV_1"=>$rowID['NM_PROV_1']);
}

echo json_encode($total_array);


?>