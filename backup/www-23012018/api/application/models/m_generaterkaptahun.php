<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generaterkaptahun extends CI_Model {

	public function get_generaterkaptahun()
	{
		$db=$this->load->database('default4',true);
		if(!empty($_GET['company'])){
		switch($_GET['company']){
			case 1 :
				$myCompany = " company= '3000' And";
				break;
			case 2 :
				$myCompany = "company= '4000' And";
				break;
			case 3 :
				$myCompany = " company= '6000' And";
				break;
			case 4 :
				$myCompany = " company= '7000' And";
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
	rkap where ".$myCompany."
 tahun=".date('Y')."
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

/* End of file m_generaterkaptahun.php */
/* Location: ./application/models/m_generaterkaptahun.php */