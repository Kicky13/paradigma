<title>Json</title>
<?php
//header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
/*$sql = "SELECT
	bukrs,
	datum,
	regexp_replace(verzn, ' ', '') AS verzn,
	SUM (ap) AS ap,
	SUM (ar) AS ar
FROM
	zcfi_cf_ap_ar
WHERE VERZN NOT LIKE '%-%'
GROUP BY
	bukrs,
	verzn,
	datum
ORDER BY verzn ASC";

$sql = "SELECT
	bukrs,
	datum,
	REGEXP_REPLACE (VERZN, ' ', '') AS verzn,
	SUM (ap) AS ap,
	SUM (ar) AS ar
FROM
	zcfi_cf_ap_ar
WHERE
	VERZN NOT LIKE '%-%'
AND LENGTH (VERZN) <= 1
GROUP BY
	verzn,
	bukrs,
	datum
ORDER BY
	verzn ASC";*/
$sql = "SELECT
	bukrs,
	datum,
	REGEXP_REPLACE (VERZN, ' ', '') AS verzn,
	SUM (ap) AS ap,
	SUM (ar) AS ar
FROM
	zcfi_cf_ap_ar
WHERE VERZN IN ('7-','6-','5-','4-','3-','2-','1-','0','1','2','3','4','5','6','7')
AND BUKRS IN ('2000','3000','4000','5000','6000','7000')
GROUP BY
	verzn,
	bukrs,
	datum
ORDER BY
	verzn ASC";

$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
			
			$company = $rowID['BUKRS'];
			$date_time = $rowID['DATUM'];
			$h_day = $rowID['VERZN'];
			$amount_ap = $rowID['AP'];
			$amount_ar = $rowID['AR'];
			
			$text["finance"][$h_day]= array(
						"company"=> $company,
						"date_time" => $date_time,
						"day"=> $h_day,
						"acc_pay"=> $amount_ap,
						"acc_rec"=>$amount_ar);
		}
		echo '{"7000":'.json_encode($text).'}';
?>