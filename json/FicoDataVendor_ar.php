<?php
header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);
$tgl=date('Ymd');
$sql_vend = "SELECT
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
WHERE VERZN IN (
	'0'
)
AND AP > 0
AND BUKRS IN ('2000','3000','4000','5000','6000','7000') AND DATUM='".$tgl."'
ORDER BY TO_NUMBER(AP) DESC
";

$query_vend = oci_parse($conn, $sql_vend);
oci_execute($query_vend);

while ($rowID = oci_fetch_array($query_vend)) {
    if (!empty($rowID)) {
        $company = $rowID['BUKRS'];
        $vendor = $rowID['CUST'];
        $vendor_name = $rowID['NAME1'];
        $date_time = $rowID['DATUM'];
        $h_day = $rowID['VERZN'];
        $amount_ap = $rowID['AP'];
        $amount_ar = $rowID['AR'];

        $vend[$h_day][$vendor] = array(
            "company" => $company,
            "vendor_code" => $vendor,
            "vendor_name" => $vendor_name,
            "date_time" => $date_time,
            "day" => $h_day,
            "acc_pay" => $amount_ap,
            "acc_rec" => $amount_ar);
    } else {
        $vend['0']['7000'] = array(
            "company" => 0,
            "vendor_code" => 0,
            "vendor_name" => 0,
            "date_time" => 0,
            "day" => 0,
            "acc_pay" => 0,
            "acc_rec" => 0);
    }
}

echo '{"7000":'.json_encode($vend).'}';
?>