<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedfmtns23 extends CI_Model {

public function get_feedfmtns23()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('SELECT DateTime, TNS2_FM1, TNS3_FM1 FROM logfeedtuban.feed_tonasa23');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$FM2_Feed =  number_format($row['TNS2_FM1'],2);
		$FM3_Feed =  number_format($row['TNS3_FM1'],2);
		
		$text2 = 'fm2';
		$text3 = 'fm3';
		
	   $toProd['Feed_FM'][$minutes] = array(
					$text2 => $FM2_Feed,
					$text3 => $FM3_Feed
	   );
   }
   
   echo '{"4000":'.json_encode($toProd).'}';
	}
	

}

/* End of file m_feedfmtns23.php */
/* Location: ./application/models/m_feedfmtns23.php */