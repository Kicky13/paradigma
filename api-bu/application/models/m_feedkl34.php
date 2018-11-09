<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedkl34 extends CI_Model {

	public function get_feedkl34()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('select DateTime, KL3_Feed, KL4_Feed from feed_tuban34');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$KL3_Feed =  number_format($row['KL3_Feed'],2);
		$KL4_Feed =  number_format($row['KL4_Feed'],2);
		
		$text3 = 'kl3';
		$text4 = 'kl4';
		
	   $toProd['Feed_Kiln'][$minutes] = array(
					$text3 => $KL3_Feed,
					$text4 => $KL4_Feed
	   );
   }
   
   echo '{"7000":'.json_encode($toProd).'}';
	}

}

/* End of file m_feedkl34.php */
/* Location: ./application/models/m_feedkl34.php */