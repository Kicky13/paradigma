<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedcm34 extends CI_Model {

	public function get_feedcm34()
	{
		$db=$this->load->database('default2',true);
		$sql = $db->query('select DateTime, CM3_Product, CM4_Product from feed_tuban34');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$CM3_Feed =  number_format($row['CM3_Product'],2);
		$CM4_Feed =  number_format($row['CM4_Product'],2);
		
		$text3 = 'cm3';
		$text4 = 'cm4';
		
	    $toProd['Feed_CM'][$minutes] = array(
					$text3 => $CM3_Feed,
					$text4 => $CM4_Feed
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
	}

}

/* End of file m_feedcm34.php */
/* Location: ./application/models/m_feedcm34.php */