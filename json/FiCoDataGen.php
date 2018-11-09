<?php
header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
$tgl=date('Ymd');
	$sql = "SELECT
	BUKRS,
	SUM(AP) AS AP,
	SUM(AR) AS AR,
	VERZN
	FROM
	V_ZCFI_CF_AP_AR
	GROUP BY VERZN,BUKRS";
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

$sql_saldo_awal = "SELECT SUM(BALANCE) AS BALANCE,COMPANY,FIS_PERIOD from ZCFI_SALDO where FIS_PERIOD = '".$bulan."' and FISC_YEAR ='".$tahun."' GROUP BY COMPANY,FIS_PERIOD";

$query_saldo = oci_parse($conn, $sql_saldo_awal);
oci_execute($query_saldo);
while ($rowID = oci_fetch_array($query_saldo)) {
	$comp=$rowID['COMPANY'];
    $last_balance = $rowID['BALANCE'];

    $last[$comp]=array('last_balance'=>$last_balance);
}

$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
			
			$company = $rowID['BUKRS'];
//			$date_time = $rowID['DATUM'];
			$h_day = $rowID['VERZN'];
			$amount_ap = $rowID['AP'];
			$amount_ar = $rowID['AR'];
			
			$text[$company][$h_day]= array(
						"company"=> $company,
//						"date_time" => $date_time,
						"day"=> $h_day,
						"acc_pay"=> $amount_ap,
						"acc_rec"=>$amount_ar);
		}
		
		$mine['7000'] = array (
		"last" => $last,
		"finance" => $text
		);
		//echo '{"7000":'.json_encode($text).'}';
		echo json_encode($mine);
?>