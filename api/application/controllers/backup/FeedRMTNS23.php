<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedRMTNS23 extends CI_Controller {

	public function index()
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

/* End of file FeedRMTNS23.php */
/* Location: ./application/controllers/FeedRMTNS23.php */