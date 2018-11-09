<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _FMTuban34 extends CI_Controller {

	public function index()
	{
		$db2=$this->load->database('default2',true);
		$sql=$db2->get('finishmill_tuban34');
		foreach ($sql->result_array() as $row) {
		$minutes = substr($row['DateTime'], 11, 5);
		
		$fm7_amp =  number_format($row['FM7_MotAmp'],2);
		$fm7_temp =  number_format($row['FM7_MotBearTemp'],2);
		$fm7_vib =  number_format($row['FM7_MotVib'],2);
		$fm8_amp =  number_format($row['FM8_MotAmp'],2);
		$fm8_temp =  number_format($row['FM8_MotBearTemp'],2);
		$fm8_vib =  number_format($row['FM8_MotVib'],2);
	   
		$myJson['Acc_FM'][$minutes] = array(
					'FM7_MotAmp' => $fm7_amp,
					'FM7_MotBearTemp' => $fm7_temp,
					'FM7_MotVib' => $fm7_vib,
					'FM8_MotAmp' => $fm8_amp,
					'FM8_MotBearTemp' => $fm8_temp,
					'FM8_MotVib' => $fm8_vib
	   );
   }

   echo '{"7000":'.json_encode($myJson).'}';
  }

}

/* End of file _FMTuban34.php */
/* Location: ./application/controllers/_FMTuban34.php */