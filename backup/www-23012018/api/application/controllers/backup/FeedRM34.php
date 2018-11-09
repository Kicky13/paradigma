<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedRM34 extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default2',true);
		$sql=$db->query('select DateTime, RM3_Feed, RM4FFeed from feed_tuban34');
		foreach ($sql->result_array() as $row) {
			//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$RM3_Feed =  number_format($row['RM3_Feed'],2);
		$RM4_Feed =  number_format($row['RM4FFeed'],2);
		
		$text3 = 'rm3';
		$text4 = 'rm4';
		
	    $toProd['Feed_RM'][$minutes] = array(
					$text3 => $RM3_Feed,
					$text4 => $RM4_Feed
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
	}

}

/* End of file FeedRM34.php */
/* Location: ./application/controllers/FeedRM34.php */