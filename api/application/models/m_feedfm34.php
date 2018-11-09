<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedfm34 extends CI_Model {

	public function get_feedfm34()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('select DateTime, FM5_Feed, FM6_Feed, FM7_Feed, FM8_Feed from feed_tuban34');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$FM5_Feed =  number_format($row['FM5_Feed'],2);
		$FM6_Feed =  number_format($row['FM6_Feed'],2);
		$FM7_Feed =  number_format($row['FM7_Feed'],2);
		$FM8_Feed =  number_format($row['FM8_Feed'],2);
		
		$text5 = 'fm5';
		$text6 = 'fm6';
		$text7 = 'fm7';
		$text8 = 'fm8';
		
	    $toProd['Feed_FM'][$minutes] = array(
					$text5 => $FM5_Feed,
					$text6 => $FM6_Feed,
					$text7 => $FM7_Feed,
					$text8 => $FM8_Feed
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
	}

}

/* End of file m_feedfm34.php */
/* Location: ./application/models/m_feedfm34.php */