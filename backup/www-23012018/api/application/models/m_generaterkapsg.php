<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generaterkapsg extends CI_Model {

	public function get_generaterkapsg()
	{
		$db=$this->load->database('default4',true);
		if(!empty($_GET['company'])){
		switch($_GET['company']){
			case 1 :
				$myCompany = " company= '3000' and ";
				break;
			case 2 :
				$myCompany = "company= '4000' and ";
				break;
			case 3 :
				$myCompany = " company= '6000' and";
				break;
			case 4 :
				$myCompany = " company= '7000' and";
				break	;
			default :
			$myCompany = "";
			}
	}else{
		$myCompany = "";
	}
	$query = $db->query("select bulan,tahun, coalesce(clinker ,'0') as clinker,coalesce(cement ,'0') as cement from rkap where $myCompany tahun=".date('Y'));
	foreach ($query->result_array() as $rowID) {
		$idJson["s".$rowID['bulan']] = array('bulan' => $rowID['bulan'],
										  'clinker'  => $rowID['clinker'],
										  'cement' => $rowID['cement']
											);
	}
	
	echo json_encode($idJson);
	}

}

/* End of file m_generaterkapsg.php */
/* Location: ./application/models/m_generaterkapsg.php */