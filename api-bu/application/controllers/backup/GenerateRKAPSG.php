<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateRKAPSG extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default4',true);
		if(!empty($_GET['company'])){
		switch($_GET['company']){
			case 1 :
				$myCompany = "where company= '3000'";
				break;
			case 2 :
				$myCompany = "where company= '4000'";
				break;
			case 3 :
				$myCompany = "where company= '6000'";
				break;
			case 4 :
				$myCompany = "where company= '7000'";
				break	;
			default :
			$myCompany = "";
			}
	}else{
		$myCompany = "";
	}
	$query = $db->query("select bulan,tahun, coalesce(clinker ,'0') as clinker,coalesce(cement ,'0') as cement from rkap $myCompany And tahun=".date('Y'));
	foreach ($query->result_array() as $rowID) {
		$idJson["s".$rowID['bulan']] = array('bulan' => $rowID['bulan'],
										  'clinker'  => $rowID['clinker'],
										  'cement' => $rowID['cement']
											);
	}
	
	echo json_encode($idJson);
	}

}

/* End of file GenerateRKAPSG.php */
/* Location: ./application/controllers/GenerateRKAPSG.php */