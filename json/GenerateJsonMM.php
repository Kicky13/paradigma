<?php
///error_reporting(1);
header('Access-Control-Allow-Origin: *');
$user = "qviewadmin";
$pass = "gadjahmada2011";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);

$companys = array('sg' => '7000','sp' => '3000', 'tlcc' => '6000');

$year = date('Y'); //20161121//yyyymmdd
// echo $date;
// $date = '2015'



// $year = substr($date, 0, 4); //get years ex: 2016
// $year = '2016';
// $month = substr($date, -2);
$month = array(
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
$com = $company[0];
// $opco = array();
$tmp = array();

//company
//7000 - 3000 - 7000
foreach ($companys as $keyCompany => $company) {
	// echo " company $company ";
	$monthly = array();
	foreach ($month  as $keyMonth => $value){
		// echo "tahun $year - $value <br>";
			$sql = "SELECT
	SUM(PO.BRTWR)POVAL,
	SUM(PO.KTMNG)POQTY,
	SUM(RKAP.VAL)RKAPVAL,
	SUM(RKAP.QTY)RKAPQTY,
SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'S' THEN
			GR.DMBTR
		END
	)-SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'H' THEN
			GR.DMBTR
		END
	) GRVAL,
	SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'S' THEN
			GR.MENGE
		END
	)-SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'H' THEN
			GR.MENGE
		END
	) GRQTY

	FROM
	TB_N_MATSGG B
JOIN TB_STR_KONTRAK PO ON B.MATNUM = PO.MATNR
LEFT JOIN TB_N_RKAPSGG RKAP ON B.GRP = RKAP.GRP
LEFT JOIN TB_MKPF_MSEG GR ON B.MATNUM = GR.MATNR
WHERE
PO.BUKRS = '$company'
and RKAP.YRS = '2016'
AND RKAP.MTH = '$value'
AND RKAP.GRP = 'G_COAL'
and rownum <='100000'
";

		$conn = oci_connect($user, $pass,$_ora_sco);
		$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		$total_array = array();
		$row=oci_fetch_array($queryOracle);

		$monthly[$keyMonth] = $row;
	}

	$tmp[$keyCompany] = $monthly;
	// array_push($opco, $tmp[$company]);

}
$year = date('Y'); //20161121//yyyymmdd
$company2 = 'st'; //st
//company 4000
$monthly = array(
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
	'des' => 12);
foreach ($monthly  as $keyMonth => $value){
	// echo "tahun $year - $value <br>";
	$sql = "SELECT
	SUM(PO.BRTWR)POVAL,
	SUM(PO.KTMNG)POQTY,
	SUM(RKAP.VAL)RKAPVAL,
	SUM(RKAP.QTY)RKAPQTY,
SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'S' THEN
			GR.DMBTR
		END
	)-SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'H' THEN
			GR.DMBTR
		END
	) GRVAL,
	SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'S' THEN
			GR.MENGE
		END
	)-SUM(
		CASE
		WHEN GR.BLART = 'WE'
		AND GR.SHKZG = 'H' THEN
			GR.MENGE
		END
	) GRQTY

	FROM
	TB_N_MATSGG B
JOIN TB_STR_KONTRAK PO ON B.MATNUM = PO.MATNR
LEFT JOIN TB_N_RKAPSGG RKAP ON B.GRP = RKAP.GRP
LEFT JOIN TB_MKPF_MSEG GR ON B.MATNUM = GR.MATNR
WHERE
PO.BUKRS = '$company2'
AND RKAP.YRS = '2016'
AND RKAP.MTH = '$value'
AND RKAP.GRP = 'G_COAL'
AND SUBSTR(PO.BEDAT, 0, 4) = '2016'
AND ROWNUM <='100000'";

	// echo "$sql";

	oci_execute($queryOracle);
	$total_array = array();
	$row=oci_fetch_array($queryOracle);

	$monthly[$keyMonth] = $row;
}

$tmp['st'] = $monthly;
// array_push($opco, $tmp['4000']);
//echo $sql;

// echo 'result'.$rowID['poval'].'-'.$rowID['poqty'];
echo json_encode($tmp);
// echo json_encode($opco);


?>
