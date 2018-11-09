<?php
header('Access-Control-Allow-Origin: *');
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';
$sql = "  SELECT tb1.com, SUM (tb1.mbwbest)/1000000  total_quant,sum(wbwbest)/1000000  tot_sum
    FROM (SELECT SUBSTR (werks, 0, 1) com,
                 matnr,
                 basme,
                 hwaer,
                 mbwbest,
                 wbwbest
            FROM tb_n_inv) tb1
   WHERE tb1.com <> 'A'
GROUP BY tb1.com";
$conn = oci_connect($user, $pass,$_ora_sco);
$queryOracle = oci_parse($conn,$sql);
oci_execute($queryOracle);
$total_array = array();
while ($rowID=oci_fetch_array($queryOracle)){
	$total_array['s'.$rowID['COM']]=array(
						  "TOTAL_QUANT"=>$rowID['TOTAL_QUANT'],
						  "TOT_SUM"=>$rowID['TOT_SUM']);
}

echo json_encode($total_array);


?>
