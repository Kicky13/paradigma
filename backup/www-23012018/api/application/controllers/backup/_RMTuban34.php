<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _RMTuban34 extends CI_Controller {

	public function index()
	{
		$db2=$this->load->database('default2',true);
		$sql=$db2->get('rawmill_tuban34');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$RM3_amp =  number_format($row['RM3_MotAmp'],2);
		$RM3_temp =  number_format($row['RM3_MotBearTemp'],2);
		$RM3_vib =  number_format($row['RM3_MotVib'],2);
		$RM4_amp =  number_format($row['RM4_MotAmp'],2);
		$RM4_temp =  number_format($row['RM4_MotBearTemp'],2);
		$RM4_vib =  number_format($row['RM4_MotVib'],2);
	   
		$myJson['Acc_RM'][$minutes] = array(
					'RM3_MotAmp' => $RM3_amp,
					'RM3_MotBearTemp' => $RM3_temp,
					'RM3_MotVib' => $RM3_vib,
					'RM4_MotAmp' => $RM4_amp,
					'RM4_MotBearTemp' => $RM4_temp,
					'RM4_MotVib' => $RM4_vib
	   );
   }
   echo '{"7000":'.json_encode($myJson).'}';
	}

}

/* End of file _RMTuban34.php */
/* Location: ./application/controllers/_RMTuban34.php */