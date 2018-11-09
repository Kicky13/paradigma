<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedFM34 extends CI_Controller {

	public function index()
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

/* End of file FeedFM34.php */
/* Location: ./application/controllers/FeedFM34.php */