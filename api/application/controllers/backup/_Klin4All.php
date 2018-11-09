<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _Klin4All extends CI_Controller {

	public function index()
	{
		$db2=$this->load->database('default2',true);
		$sql=$db2->get('kiln4_all');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$KL4_BearAmp =  number_format($row['KL4_BearAmp'],2);
		$KL4_MotorAmp =  number_format($row['KL4_MotorAmp'],2);
		$KL4_OpsAmpIdF1 =  number_format($row['KL4_OpsAmpIdF1'],2);
		$KL4_OpsAmpIdF2 =  number_format($row['KL4_OpsAmpIdF2'],2);
		$KL4_OpsDampIdF1 =  number_format($row['KL4_OpsDampIdF1'],2);
		$KL4_OpsDampIdF2 =  number_format($row['KL4_OpsDampIdF2'],2);
		$KL4_OpsExTemp11 =  number_format($row['KL4_OpsExTemp11'],2);
		$KL4_OpsExTemp12 =  number_format($row['KL4_OpsExTemp12'],2);
		$KL4_OpsExTemp21 =  number_format($row['KL4_OpsExTemp21'],2);
		$KL4_OpsExTemp22 =  number_format($row['KL4_OpsExTemp22'],2);
		$KL4_OpsSpeedIdF1 =  number_format($row['KL4_OpsSpeedIdF1'],2);
		$KL4_OpsSpeedIdF2 =  number_format($row['KL4_OpsSpeedIdF2'],2);
		$KL4_OpsVib1IdF1 =  number_format($row['KL4_OpsVib1IdF1'],2);
		$KL4_OpsVib1IdF2 =  number_format($row['KL4_OpsVib1IdF2'],2);
		$KL4_OpsVib2IdF1 =  number_format($row['KL4_OpsVib2IdF1'],2);
		$KL4_OpsVib2IdF2 =  number_format($row['KL4_OpsVib2IdF2'],2);
	   
		$myJson['Acc_KL4'][$minutes] = array(
					'KL4_BearAmp' => $KL4_BearAmp,
					'KL4_MotorAmp' => $KL4_MotorAmp,
					'KL4_OpsAmpIdF1' => $KL4_OpsAmpIdF1,
					'KL4_OpsAmpIdF2' => $KL4_OpsAmpIdF2,
					'KL4_OpsDampIdF1' => $KL4_OpsDampIdF1,
					'KL4_OpsDampIdF2' => $KL4_OpsDampIdF2,
					'KL4_OpsExTemp11' => $KL4_OpsExTemp11,
					'KL4_OpsExTemp12' => $KL4_OpsExTemp12,
					'KL4_OpsExTemp21' => $KL4_OpsExTemp21,
					'KL4_OpsExTemp22' => $KL4_OpsExTemp22,
					'KL4_OpsSpeedIdF1' => $KL4_OpsSpeedIdF1,
					'KL4_OpsSpeedIdF2' => $KL4_OpsSpeedIdF2,
					'KL4_OpsVib1IdF1' => $KL4_OpsVib1IdF1,
					'KL4_OpsVib1IdF2' => $KL4_OpsVib1IdF2,
					'KL4_OpsVib2IdF1' => $KL4_OpsVib2IdF1,
					'KL4_OpsVib2IdF2' => $KL4_OpsVib2IdF2
	   );
   }

   echo '{"7000":'.json_encode($myJson).'}';
	}

}

/* End of file _Klin4All.php */
/* Location: ./application/controllers/_Klin4All.php */