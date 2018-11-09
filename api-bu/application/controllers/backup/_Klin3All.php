<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _Klin3All extends CI_Controller {

	public function index()
	{
		$db2=$this->load->database('default2',true);
		$sql=$db2->get('kiln3_all');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$KL3_BearTemp =  number_format($row['KL3_BearTemp'],2);
		$KL3_KilnAmp =  number_format($row['KL3_KilnAmp'],2);
		$KL3_OpsDampIdF1 =  number_format($row['KL3_OpsDampIdF1'],2);
		$KL3_OpsDampIdF2 =  number_format($row['KL3_OpsDampIdF2'],2);
		$KL3_OpsExTemp1 =  number_format($row['KL3_OpsExTemp1'],2);
		$KL3_OpsExTemp2 =  number_format($row['KL3_OpsExTemp2'],2);
		$KL3_OpsPowerIdF11 =  number_format($row['KL3_OpsPowerIdF11'],2);
		$KL3_OpsPowerIdF21 =  number_format($row['KL3_OpsPowerIdF21'],2);
		$KL3_OpsSpeedIdF12 =  number_format($row['KL3_OpsSpeedIdF12'],2);
		$KL3_OpsSpeedIdF22 =  number_format($row['KL3_OpsSpeedIdF22'],2);
		$KL3_OpsVib1IdF11 =  number_format($row['KL3_OpsVib1IdF11'],2);
		$KL3_OpsVib1IdF21 =  number_format($row['KL3_OpsVib1IdF21'],2);
		$KL3_OpsVib2IdF12 =  number_format($row['KL3_OpsVib2IdF12'],2);
		$KL3_OpsVib2IdF22 =  number_format($row['KL3_OpsVib2IdF22'],2);
	   
		$myJson['Acc_KL3'][$minutes] = array(
					'KL3_BearTemp' => $KL3_BearTemp,
					'KL3_KilnAmp' => $KL3_KilnAmp,
					'KL3_OpsDampIdF1' => $KL3_OpsDampIdF1,
					'KL3_OpsDampIdF2' => $KL3_OpsDampIdF2,
					'KL3_OpsExTemp1' => $KL3_OpsExTemp1,
					'KL3_OpsExTemp2' => $KL3_OpsExTemp2,
					'KL3_OpsPowerIdF11' => $KL3_OpsPowerIdF11,
					'KL3_OpsPowerIdF21' => $KL3_OpsPowerIdF21,
					'KL3_OpsSpeedIdF12' => $KL3_OpsSpeedIdF12,
					'KL3_OpsSpeedIdF22' => $KL3_OpsSpeedIdF22,
					'KL3_OpsVib1IdF11' => $KL3_OpsVib1IdF11,
					'KL3_OpsVib1IdF21' => $KL3_OpsVib1IdF21,
					'KL3_OpsVib2IdF12' => $KL3_OpsVib2IdF12,
					'KL3_OpsVib2IdF22' => $KL3_OpsVib2IdF22
	   );
   }

   echo '{"7000":'.json_encode($myJson).'}';
	}

}

/* End of file _Klin3All.php */
/* Location: ./application/controllers/_Klin3All.php */