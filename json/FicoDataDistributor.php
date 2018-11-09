<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);
$tgl=date('Ymd');
$sql_dist = "SELECT
	BUKRS,
	CUST,
	AP,
	AR,
	VERZN,
	HWAER,
	NAME1,
	DATUM
FROM
	ZCFI_CF_AP_AR_CUST
WHERE
	AP = 0
AND VERZN IN (
	'1',
	'2',
	'3',
	'7'
)
AND BUKRS IN ('2000','3000','4000','5000','6000','7000')  AND DATUM='".$tgl."'
ORDER BY TO_NUMBER(AR) DESC
";

$query_dist = oci_parse($conn, $sql_dist);
oci_execute($query_dist);

while ($rowID = oci_fetch_array($query_dist)) {

    $company = $rowID['BUKRS'];
    $distributor = $rowID['CUST'];
    $distributor_name = $rowID['NAME1'];
    $date_time = $rowID['DATUM'];
    $h_day = $rowID['VERZN'];
    $amount_ap = $rowID['AP'];
    $amount_ar = $rowID['AR'];

    $dist[$h_day][$distributor] = array(
        "company" => $company,
        "vendor_code" => $distributor,
        "vendor_name" => $distributor_name,
        "date_time" => $date_time,
        "day" => $h_day,
        "acc_pay" => $amount_ap,
        "acc_rec" => $amount_ar);
}

echo '{"7000":'.json_encode($dist).'}';
?>