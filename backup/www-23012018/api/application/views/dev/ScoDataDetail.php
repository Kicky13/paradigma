<?php
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
$filter = $_GET['COM'];
//$sql = "select * from ZREPORT_RPTREAL_RESUM where COM = {$filter} ";
//$sql = "select * from ZREPORT_RPTREAL_RESUM inner join M_PROVINSI ON M_PROVINSI.KD_PROV = ZREPORT_RPTREAL_RESUM.PROPINSI WHERE ZREPORT_RPTREAL_RESUM.COM = {$filter}";
$sql = "select NM_PROV_1, PROPINSI, 
SUM(ZREPORT_RPTREAL_RESUM.TARGET_RKAP) AS TARGET_RKAP, 
SUM(ZREPORT_RPTREAL_RESUM.REALTO) as REALTO
from ZREPORT_RPTREAL_RESUM, M_PROVINSI
WHERE ZREPORT_RPTREAL_RESUM.COM = {$filter} AND ZREPORT_RPTREAL_RESUM.PROPINSI = M_PROVINSI.KD_PROV 
GROUP BY PROPINSI, NM_PROV_1"; 
$queryOracle = oci_parse($conn,$sql);
oci_execute($queryOracle);
$total_array = array();
while ($rowID=oci_fetch_array($queryOracle)){
	$total_array[]=array("PROPINSI"=>$rowID['PROPINSI'],
"TARGET_RKAP"=>$rowID['TARGET_RKAP'],
"REALTO"=>$rowID['REALTO'],
"NM_PROV_1"=>$rowID['NM_PROV_1']);
}

echo json_encode($total_array);


?>