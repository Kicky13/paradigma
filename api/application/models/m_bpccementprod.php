<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bpccementprod extends CI_Model {

	public function get_bpccementprod()
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
							'121_302_0060',
							'121_301_0060',
							'121_302_0019',
							'121_302_0110',
							'121_302_0040',
							'121_302_0030',
							'121_302_0020',
							'121_302_0010'
						) ORDER BY production.fiscal_year_period");
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

/* End of file m_bpccementprod.php */
/* Location: ./application/models/m_bpccementprod.php */