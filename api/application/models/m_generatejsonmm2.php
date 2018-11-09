<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generatejsonmm2 extends CI_Model {

	public function get_generatejsonmm2()
	{
			$opco = 'st';//$_GET['i'];
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
	$tmp['sg'] = $this->opco($opco, $company, $year, $months);

	$company = '3000';
	$tmp['sp'] = $this->opco($opco, $company, $year, $months);

	$company = '4000';
	$tmp['st'] = opco2($opco, $company, $year, $months);

	$company = '6000';
	$tmp['tlcc'] = $this->opco($opco, $company, $year, $months);

}elseif ($opco == 'sg') {

	$company = '7000';
	$tmp[$opco] = $this->opco($opco, $company, $year, $months);

}elseif ($opco == 'sp') {

	$company = '3000';
	$tmp[$opco] = $this->opco($opco,$company, $year, $months);

}elseif ($opco == 'tlcc') {

	$company = '6000';
	$tmp[$opco] = $this->opco($opco,$company, $year, $months);

}elseif ($opco == 'st') {

	$company = '4000';
	$tmp[$opco] = $this->opco2($opco,$company, $year, $months);

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
	// 	$rkap = rkaptable($company, $year, $month);
	// 	$po = potable($company, $year, $month);
	// 	$gr = grtable($company, $year, $month);
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


// $row = potable('7000', $year, '11');
// echo json_encode($row);
// echo json_encode($opco);
// 
	}

	public function opco($opco,$company, $year, $months)
	{
		$monthly = array();
		foreach ($months as $keyMonth => $month) {
		# code...
		# 
		$rkap = $this->rkaptable($company, $year, $month);
		$po = $this->potable($company, $year, $month);
		//$gr = $this->grtable($company, $year, $month);
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

	public function opco2($opco,$company, $year, $months)
{
	$monthly = array();
	foreach ($months as $keyMonth => $month) {
		# code...
		# 
		$rkap = $this->rkap2table($company, $year, $month);
		$po = $this->po2table($company, $year, $month);
		//$gr = $this->grtable($company, $year, $month);
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

public function potable($company, $year, $month){
	$db=$this->load->database('default',true);
	$sql = $db->query("SELECT DISTINCT
		--BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, MENGE
		SUM(BRTWR) AS POVAL,
		SUM(MENGE) AS POQTY
		FROM TB_STR_PO
		WHERE 
			BUKRS = '$company' AND BEDAT LIKE '$year$month%'
		");
	foreach ($sql->result_array() as $row) {}

	return $row;
}

public function po2table($company, $year, $month){
	$db=$this->load->database('default',true);
	$sql = $db->query("SELECT 
				-- BUKRS, MATNR,SUBSTR(BEDAT, 0, 4) AS YRS,SUBSTR(BEDAT, 5, 2) AS MTH, BEDAT, BRTWR, KTMNG
				SUM(BRTWR) AS POVAL,
				SUM(KTMNG) AS POQTY
			FROM TB_STR_KONTRAK 
			WHERE BUKRS = '$company' AND BEDAT LIKE '$year$month%'
	");
	foreach ($sql->result_array() as $row) {}

	return $row;
}

public function rkaptable($company, $year, $month){
	$db=$this->load->database('default',true);
	$sql = $db->query("SELECT 
		--GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
				SUM(VAL) AS RKAPVAL,
				SUM(QTY) AS RKAPQTY
		FROM TB_N_RKAPSGG RKAP
		WHERE
				RKAP.COM = '$company' AND RKAP.YRS = '$year' AND RKAP.MTH = '$month'
		");
	foreach ($sql->result_array() as $row) {}

	return $row;
}

public function rkap2table($company, $year, $month){
	$db=$this->load->database('default',true);
	$sql = $db->query("SELECT 
		--GRP, COM AS BUKRS, YRS, MTH, VAL, QTY 
				SUM(VAL) AS RKAPVAL,
				SUM(QTY) AS RKAPQTY
		FROM TB_N_RKAPSGG RKAP
		WHERE
			RKAP.GRP = 'G_COAL' AND	RKAP.COM = '$company' AND RKAP.YRS = '$year' AND RKAP.MTH = '$month'");
	foreach ($sql->result_array() as $row) {}

	return $row;
}

public function grtable($company, $year, $month){
	$db=$this->load->database('default',true);
	$company = substr($company, 0,1);
	$sql = $db->query("SELECT 
					--CONCAT(SUBSTR(WERKS, 0,1), '000') AS BUKRS, MATNR, MJAHR,SUBSTR(BUDAT, 5, 2) AS MTH, BUDAT, DMBTR,  MENGE 
					SUM(DMBTR) AS GRVAL,
					SUM(MENGE) AS GRQTY
					FROM TB_MKPF_MSEG
					WHERE 
						MJAHR = $year 
					AND WERKS LIKE '$company%'
					AND BUDAT LIKE '$year$month%'
	");
	foreach ($sql->result_array() as $row) {}

	return $row;
}

}

/* End of file m_generatejsonmm2.php */
/* Location: ./application/models/m_generatejsonmm2.php */