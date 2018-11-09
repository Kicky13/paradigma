<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedCM34 extends CI_Controller {

	public function index()
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

/* End of file FeedCM34.php */
/* Location: ./application/controllers/FeedCM34.php */