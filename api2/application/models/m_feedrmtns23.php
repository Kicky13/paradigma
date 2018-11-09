<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedrmtns23 extends CI_Model {

	public function get_feedrmtns23()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('SELECT DateTime, TNS2_RM1, TNS3_RM1 FROM logfeedtuban.feed_tonasa23');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$RM2_Feed =  number_format($row['TNS2_RM1'],2);
		$RM3_Feed =  number_format($row['TNS3_RM1'],2);
		
		$text2 = 'rm2';
		$text3 = 'rm3';
		
	   $toProd['Feed_RM'][$minutes] = array(
					$text2 => $RM2_Feed,
					$text3 => $RM3_Feed
	   );
   }
   
   echo '{"4000":'.json_encode($toProd).'}';
	}

}

/* End of file m_feedrmtns23.php */
/* Location: ./application/models/m_feedrmtns23.php */