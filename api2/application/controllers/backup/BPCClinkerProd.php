<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BPCClinkerProd extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default3',true);
		$sql=$db->query("SELECT DISTINCT
							production.plant,
							m_plant.description,
							production.amount,
							production.fiscal_year_period,
							production.material
						FROM
							production
						INNER JOIN m_plant ON production.plant = m_plant.plant
						WHERE
							production. CATEGORY = 'ACT'
						AND MATERIAL IN (
							'121_200_0010',
							'121_200_0040',
							'121_200_0020'
						)
						ORDER BY
							production.fiscal_year_period");
		foreach ($sql->result_array() as $rowID) {
			$PLANT = $rowID['PLANT'];
		$DESCRIPTION = $rowID['DESCRIPTION'];
		$AMOUNT = $rowID['AMOUNT'];
		$FISCAL_YEAR_PERIOD = $rowID['FISCAL_YEAR_PERIOD'];
		$MATERIAL = $rowID['MATERIAL'];
		
		$json[$FISCAL_YEAR_PERIOD][$PLANT] =  array(
			'plant code' => $PLANT,
			'plant desc' => $DESCRIPTION,
			'tipe' => $MATERIAL,
			'amount' => $AMOUNT
		);
	}

echo '({"message":"","status":"OK","tags":'.json_encode($json).',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';
	}

}

/* End of file BPCClinkerProd.php */
/* Location: ./application/controllers/BPCClinkerProd.php */