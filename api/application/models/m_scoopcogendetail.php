<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_scoopcogendetail extends CI_Model {

	public function get_scoopcogendetail()
	{
		$db=$this->load->database('default5',true);
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
	$company = 0;
}
$sql = $db->query("SELECT BULAN,
	SUM (target_rkap) AS RKAP,
	SUM (realto) AS RIIL
FROM
	ZREPORT_RPTREAL_RESUM
WHERE
COM = ".$company."
AND tahun = ".$tahun."
GROUP BY BULAN
ORDER BY BULAN");

	foreach ($sql->result_array() as $rowID) {
		
			//$company = $rowID['BULAN'];		
			$target_val = $rowID['RKAP'];
			$real_val = $rowID['RIIL'];
			
			$text["s".$rowID['BULAN']]= array(
						"target"=> $target_val,
						"real"=>$real_val);
		}
		echo json_encode($text);
	}

}

/* End of file m_scoopcogendetail.php */
/* Location: ./application/models/m_scoopcogendetail.php */