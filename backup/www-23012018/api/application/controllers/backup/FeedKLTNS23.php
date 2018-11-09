<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedKLTNS23 extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('SELECT DateTime, TNS2_KL1, TNS3_KL1 FROM logfeedtuban.feed_tonasa23');
		foreach ($sql->result_array() as $row) {
			$minutes = substr($row['DateTime'], 11, 5);
		
		$KL2_Feed =  number_format($row['TNS2_KL1'],2);
		$KL3_Feed =  number_format($row['TNS3_KL1'],2);
		
		$text2 = 'kl2';
		$text3 = 'kl3';
		
	   $toProd['Feed_KL'][$minutes] = array(
					$text2 => $KL2_Feed,
					$text3 => $KL3_Feed
	   );
   }
   
   echo '{"4000":'.json_encode($toProd).'}';
	}

}

/* End of file FeedKLTNS23.php */
/* Location: ./application/controllers/FeedKLTNS23.php */