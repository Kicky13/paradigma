<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateRKAPTahun extends CI_Controller {

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
	$query = $db->query("SELECT
	company,
	SUM (CAST(clinker AS NUMERIC)) AS klinker,
	SUM (CAST(cement AS NUMERIC)) AS semen
FROM
	rkap ".$myCompany."
And tahun=".date('Y')."
GROUP BY
	company ");
	foreach ($query->result_array() as $rowID) {
		$idJson["s".$rowID['company']] = array('company' => $rowID['company'],
										  'clinker'  => $rowID['klinker'],
										  'cement' => $rowID['semen']
											);
	}
	
	echo json_encode($idJson);
	}

}

/* End of file GenerateRKAPTahun.php */
/* Location: ./application/controllers/GenerateRKAPTahun.php */