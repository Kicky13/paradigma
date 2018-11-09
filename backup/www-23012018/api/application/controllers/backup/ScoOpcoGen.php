<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScoOpcoGen extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default5',true);
		if(!empty($_GET['bulan'])){
$bulan = $_GET['bulan'];
	}else{$bulan = date('m');}

if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}else{$tahun = date('Y');}

if(!empty($_GET['company'])){
	switch($_GET['company']){
		case 1 :
			$company = 3000;
			break;
		case 2 :
			$company = 4000;
			break;
		case 3 :
			$company = 5000;
			break;
		case 4 :
			$company = 6000;
			break	;
		case 5 :
			$company = 7000;
			break	;
		default :
		$company = "";
		}
}else{
	$company = "";
}
$sql = $db->query("SELECT COM,
	SUM (target_rkap) AS RKAP,
	SUM (realto) AS RIIL
FROM
	ZREPORT_RPTREAL_RESUM
WHERE
tahun = ".$tahun."
AND bulan = ".$bulan."
GROUP BY COM");

		foreach ($sql->result_array() as $rowID) {
		
			$company = $rowID['COM'];		
			$target_val = $rowID['RKAP'];
			$real_val = $rowID['RIIL'];
			
			$text["s".$rowID['COM']]= array(
						"target"=> $target_val,
						"real"=>$real_val);
		}
		echo json_encode($text);
	}

}

/* End of file ScoOpcoGen.php */
/* Location: ./application/controllers/ScoOpcoGen.php */