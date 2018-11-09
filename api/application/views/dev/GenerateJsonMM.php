<?php
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
			$sql = " SELECT DISTINCT
		--PO.BUKRS,
		--RKAP.BUKRS,
		--RKAP.YRS,
		--PO.YRS,
		--PO.BRTWR,
		--PO.MENGE,
		--RKAP.VAL,
		--RKAP.QTY,
		--PO.MTH,
		--RKAP.MTH,
		--GR.MTH
		SUM(PO.BRTWR) as poval,
		SUM(PO.MENGE) as poqty,
		SUM(GR.DMBTR) as grval,
		SUM(GR.MENGE) as grqty,
		SUM(TO_NUMBER(RKAP.VAL, '999999999999.999999999999')) AS rkapval,
		SUM(TO_NUMBER(RKAP.QTY, '999999999999.999999999999')) AS rkapqty
		FROM
			(SELECT 
					BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, MENGE
				FROM TB_STR_PO 
				
			) PO
			INNER JOIN
			(SELECT 
						GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
					FROM TB_N_RKAPSGG
				) RKAP
			ON
				RKAP.BUKRS = PO.BUKRS AND RKAP.YRS = PO.YRS AND RKAP.MTH = PO.MTH 
			INNER JOIN
			(SELECT 
				CONCAT(SUBSTR(WERKS, 0,1), '000') AS BUKRS, MATNR, MJAHR,SUBSTR(BUDAT, 5, 2) AS MTH, BUDAT, DMBTR,  MENGE 
				FROM TB_MKPF_MSEG) GR
			ON 
				GR.BUKRS = RKAP.BUKRS AND GR.MJAHR = RKAP.YRS AND GR.MTH = RKAP.MTH
		WHERE 
				GR.BUKRS = '$company'
				AND RKAP.YRS = '$year'
				AND RKAP.MTH = '$value'
				 AND	ROWNUM <=100000";


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
$company2 = 'st'; //st
//company 4000
$monthly = array();
foreach ($month  as $keyMonth => $value){
	// echo "tahun $year - $value <br>";
	$sql = " SELECT DISTINCT
		--PO.BUKRS,
		--RKAP.BUKRS,
		--RKAP.YRS,
		--PO.YRS,
		--PO.BRTWR,
		--PO.MENGE,
		--RKAP.VAL,
		--RKAP.QTY,
		--PO.MTH,
		--RKAP.MTH,
		--GR.MTH
		SUM(PO.BRTWR) as poval,
		SUM(PO.MENGE) as poqty,
		SUM(GR.DMBTR) as grval,
		SUM(GR.MENGE) as grqty,
		SUM(TO_NUMBER(RKAP.VAL, '999999999999.999999999999')) AS rkapval,
		SUM(TO_NUMBER(RKAP.QTY, '999999999999.999999999999')) AS rkapqty
		FROM
			(SELECT 
					BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, KTMNG
				FROM TB_STR_KONTRAK 
				
			) PO
			INNER JOIN
			(SELECT 
						GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
					FROM TB_N_RKAPSGG WHERE GRP = 'G_COAL'
				) RKAP
			ON
				RKAP.BUKRS = PO.BUKRS AND RKAP.YRS = PO.YRS AND RKAP.MTH = PO.MTH 
			INNER JOIN
			(SELECT 
				CONCAT(SUBSTR(WERKS, 0,1), '000') AS BUKRS, MATNR, MJAHR,SUBSTR(BUDAT, 5, 2) AS MTH, BUDAT, DMBTR,  MENGE 
				FROM TB_MKPF_MSEG) GR
			ON 
				GR.BUKRS = RKAP.BUKRS AND GR.MJAHR = RKAP.YRS AND GR.MTH = RKAP.MTH
		WHERE 
				GR.BUKRS = '$company2'
				AND RKAP.YRS = '$year'
				AND RKAP.MTH = '$value'
				 AND	ROWNUM <=100000";

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
