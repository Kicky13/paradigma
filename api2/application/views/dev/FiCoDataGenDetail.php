<?php
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
$sql = "SELECT
	bukrs,
	datum,
	SUM (ap) AS ap,
	SUM (ar) AS ar
FROM
	zcfi_cf_ap_ar
GROUP BY
	bukrs,
	datum
ORDER BY bukrs ASC";

$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
			
			$company = $rowID['BUKRS'];
			$date_time = $rowID['DATUM'];
			//$h_day = $rowID['VERZN'];
			$amount_ap = $rowID['AP'];
			$amount_ar = $rowID['AR'];
			
			$text["s".$company]= array(
						"company"=> $company,
						"date_time" => $date_time,
						//"day"=> $h_day,
						"acc_pay"=> $amount_ap,
						"acc_rec"=>$amount_ar);
		}
		echo json_encode($text);
?>