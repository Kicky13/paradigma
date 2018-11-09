<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _CMTuban34 extends CI_Controller {
		
		public function index()
		{
			$db2=$this->load->database('default2',TRUE);
			$sql=$db2->query("select * from coalmill_tuban34");	
			foreach ($sql->result_array() as $row) {
				$minutes = substr($row['DateTime'], 11, 5);
		
				$cm3_amp =  number_format($row['CM3_MotAmp'],2);
				$cm3_temp =  number_format($row['CM3_MotBearTemp'],2);
				$cm3_vib =  number_format($row['CM3_MotVib'],2);
				$cm4_amp =  number_format($row['CM4_MotAmp'],2);
				$cm4_temp =  number_format($row['CM4_MotBearTemp'],2);
				$cm4_vib =  number_format($row['CM4_MotVib'],2);
			   
				$myJson['Acc_CM'][$minutes] = array(
							'CM3_MotAmp' => $cm3_amp,
							'CM3_MotBearTemp' => $cm3_temp,
							'CM3_MotVib' => $cm3_vib,
							'CM4_MotAmp' => $cm4_amp,
							'CM4_MotBearTemp' => $cm4_temp,
							'CM4_MotVib' => $cm4_vib
	   );
			}
			echo '{"7000":'.json_encode($myJson).'}';
		}

}

/* End of file _CMTuban34.php */
/* Location: ./application/controllers/_CMTuban34.php */