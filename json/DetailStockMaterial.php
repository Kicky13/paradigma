<?php
header('Access-Control-Allow-Origin: *');

$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';
$dataget = $_GET['DATA'];
$datagets = $_GET['DATAS'];

if ($datagets == 0) {
    $sql = " SELECT WERKS, MATNR, MBWBEST, WBWBEST FROM TB_N_INV where WERKS LIKE '{$dataget}%' AND WERKS LIKE '_7%' AND ROWNUM <=10";    
}
else{
    $sql = " SELECT WERKS, MATNR, MBWBEST, WBWBEST FROM TB_N_INV where (WERKS LIKE '{$dataget}%' OR WERKS LIKE '{$datagets}%') AND WERKS LIKE '_7%' AND ROWNUM <=10";
}

$conn = oci_connect($user, $pass,$_ora_sco);
$queryOracle = oci_parse($conn,$sql);
oci_execute($queryOracle);
$total_array = array();
while ($rowID=oci_fetch_array($queryOracle)){
	$total_array[]=array("WERKS"=>$rowID['WERKS'],
                          "MATNR"=>$rowID['MATNR'],
                          "MBWBEST"=>$rowID['MBWBEST'],
                          "WBWBEST"=>$rowID['WBWBEST']);
}

echo json_encode($total_array);


?>
