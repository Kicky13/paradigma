<?php
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);

$opco = $_GET['i'];
// $companys = array('sg' => '7000','sp' => '3000', 'tlcc' => '6000');
// $companys = array('sg' => '7000');
$year = date('Y');
$months = array(
	'jan' => 1,
	'feb' => 2,
	'mar' => 3,
	'apr' => 4,
	'mei' => 5,
	'jun' => 6,
	'jul' => 7,
	'agu' => 8,
	'sep' => 9,
	'okt' => 10,
	'nov' => 11,
	'des' => 12
	);
// $date = date('Ymd'); //20161121//yyyymmdd
// echo $date;
// $date = '2015'
$tmp = array();
if ($opco == 'all') {

	$company = '7000';
	$tmp['sg'] = opco($opco, $company, $year, $months, $conn);

	$company = '3000';
	$tmp['sp'] = opco($opco, $company, $year, $months, $conn);

	$company = '4000';
	$tmp['st'] = opco2($opco, $company, $year, $months, $conn);

	$company = '6000';
	$tmp['tlcc'] = opco($opco, $company, $year, $months, $conn);

}elseif ($opco == 'sg') {

	$company = '7000';
	$tmp[$opco] = opco($opco, $company, $year, $months, $conn);

}elseif ($opco == 'sp') {

	$company = '3000';
	$tmp[$opco] = opco($opco,$company, $year, $months, $conn);

}elseif ($opco == 'tlcc') {

	$company = '6000';
	$tmp[$opco] = opco($opco,$company, $year, $months, $conn);

}elseif ($opco == 'st') {

	$company = '4000';
	$tmp[$opco] = opco2($opco,$company, $year, $months, $conn);

}

echo json_encode($tmp);

// $year = substr($date, 0, 4); //get years ex: 2016

// $month = substr($date, -2);

// $com = $company[0];
// $opco = array();


//company
//7000 - 3000 - 7000
// foreach ($companys as $keyCompany => $company) {
	# code...
	// $monthly = array();
	// foreach ($months as $keyMonth => $month) {
	// 	# code...
	// 	# 
	// 	$rkap = rkaptable($company, $year, $month, $conn);
	// 	$po = potable($company, $year, $month, $conn);
	// 	$gr = grtable($company, $year, $month, $conn);
	// 	$tmpMonth = array(
	// 		'RKAPVAL' => $rkap['RKAPVAL'],
	// 		// 'RKAPQTY' => $rkap['RKAPQTY']
	// 		'POVAL' => $po['POVAL'],
	// 		'GRVAL' => $gr['GRVAL']
			
			
	// 		);
	// 	$monthly[$keyMonth] = $tmpMonth;
	// }

	// $tmp[$opco] = $monthly;
// }
// array_push($opco, $tmp['4000']);
//echo $sql;

// echo 'result'.$rowID['poval'].'-'.$rowID['poqty'];


// $row = potable('7000', $year, '11', $conn);
// echo json_encode($row);
// echo json_encode($opco);
// 
function opco($opco,$company, $year, $months, $conn)
{
	$monthly = array();
	foreach ($months as $keyMonth => $month) {
		# code...
		# 
		$rkap = rkaptable($company, $year, $month, $conn);
		$po = potable($company, $year, $month, $conn);
		// $gr = grtable($company, $year, $month, $conn);
		$tmpMonth = array(
			'RKAPVAL' => $rkap['RKAPVAL'],
			// 'RKAPQTY' => $rkap['RKAPQTY']
			'POVAL' => $po['POVAL'],
			'GRVAL' => $gr['GRVAL']
			
			
			);
		$monthly[$keyMonth] = $tmpMonth;
	}

	return $monthly;

}
function opco2($opco,$company, $year, $months, $conn)
{
	$monthly = array();
	foreach ($months as $keyMonth => $month) {
		# code...
		# 
		$rkap = rkap2table($company, $year, $month, $conn);
		$po = po2table($company, $year, $month, $conn);
		// $gr = grtable($company, $year, $month, $conn);
		$tmpMonth = array(
			'RKAPVAL' => $rkap['RKAPVAL'],
			// 'RKAPQTY' => $rkap['RKAPQTY']
			'POVAL' => $po['POVAL'],
			'GRVAL' => $gr['GRVAL']
			
			
			);
		$monthly[$keyMonth] = $tmpMonth;
	}
	return $monthly;
	// $tmp[$opco] = $monthly;

	// echo json_encode($tmp);
}
function potable($company, $year, $month, $conn){
	$sql = "SELECT DISTINCT
		--BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, MENGE
		SUM(BRTWR) AS POVAL,
		SUM(MENGE) AS POQTY
		FROM TB_STR_PO
		WHERE 
			BUKRS = '$company' AND BEDAT LIKE '$year$month%'
		";
	$queryOracle = oci_parse($conn,$sql);
	oci_execute($queryOracle);
	$row=oci_fetch_array($queryOracle);

	return $row;
}
function po2table($company, $year, $month, $conn){
	$sql = "SELECT 
				-- BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, KTMNG
				SUM(BRTWR) AS POVAL,
				SUM(KTMNG) AS POQTY
			FROM TB_STR_KONTRAK 
			WHERE BUKRS = '$company' AND BEDAT LIKE '$year$month%'
	";
	$queryOracle = oci_parse($conn,$sql);
	oci_execute($queryOracle);
	$row=oci_fetch_array($queryOracle);

	return $row;
}
function rkaptable($company, $year, $month, $conn){
	$sql = "SELECT 
		--GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
				SUM(VAL) AS RKAPVAL,
				SUM(QTY) AS RKAPQTY
		FROM TB_N_RKAPSGG RKAP
		WHERE
				RKAP.COM = '$company' AND RKAP.YRS = '$year' AND RKAP.MTH = '$month'
		";
	$queryOracle = oci_parse($conn,$sql);
	oci_execute($queryOracle);
	$row=oci_fetch_array($queryOracle);

	return $row;
}
function rkap2table($company, $year, $month, $conn){
	$sql = "SELECT 
		--GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
				SUM(VAL) AS RKAPVAL,
				SUM(QTY) AS RKAPQTY
		FROM TB_N_RKAPSGG RKAP
		WHERE
			RKAP.GRP = 'G_COAL' AND	RKAP.COM = '$company' AND RKAP.YRS = '$year' AND RKAP.MTH = '$month'";
	$queryOracle = oci_parse($conn,$sql);
	oci_execute($queryOracle);
	$row=oci_fetch_array($queryOracle);

	return $row;
}

function grtable($company, $year, $month, $conn){
	$company = substr($company, 0,1);
	$sql = "SELECT 
					--CONCAT(SUBSTR(WERKS, 0,1), '000') AS BUKRS, MATNR, MJAHR,SUBSTR(BUDAT, 5, 2) AS MTH, BUDAT, DMBTR,  MENGE 
					SUM(DMBTR) AS GRVAL,
					SUM(MENGE) AS GRQTY
					FROM TB_MKPF_MSEG
					WHERE 
						MJAHR = $year 
					AND WERKS LIKE '$company%'
					AND BUDAT LIKE '$year$month%'
	";
	$queryOracle = oci_parse($conn,$sql);
	oci_execute($queryOracle);
	$row=oci_fetch_array($queryOracle);

	return $row;
}
?>
