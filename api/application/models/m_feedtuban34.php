<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedtuban34 extends CI_Model {

public function get_feedtuban34()
	{
		$db2=$this->load->database('default2',TRUE);
			$sql=$db2->get('feed_tuban34');
			foreach ($sql->result_array() as $row) {
				$minutes = substr($row['DateTime'], 11, 5);
		
		$FM5_Feed =  number_format($row['FM5_Feed'],2);
		$FM6_Feed =  number_format($row['FM6_Feed'],2);
		$FM7_Feed =  number_format($row['FM7_Feed'],2);
		$FM8_Feed =  number_format($row['FM8_Feed'],2);
		$KL3_EP =  number_format($row['KL3_EP'],2);
		$KL3_Feed =  number_format($row['KL3_Feed'],2);
		$KL4_EP =  number_format($row['KL4_EP'],2);
		$KL4_Feed =  number_format($row['KL4_Feed'],2);
		$RM3_EP =  number_format($row['RM3_EP'],2);
		$RM3_Feed =  number_format($row['RM3_Feed'],2);
		$RM4_EP =  number_format($row['RM4_EP'],2);
		$RM4_Feed =  number_format($row['RM4FFeed'],2);
		$CM3_Product =  number_format($row['CM3_Product'],2);
		$CM4_Product =  number_format($row['CM4_Product'],2);
	   
		$myJson[$minutes] = array(
					'FM5_Feed' => $FM5_Feed,
					'FM6_Feed' => $FM6_Feed,
					'FM7_Feed' => $FM7_Feed,
					'FM8_Feed' => $FM8_Feed,
					'KL3_EP' => $KL3_EP,
					'KL3_Feed' => $KL3_Feed,
					'KL4_EP' => $KL4_EP,
					'KL4_Feed' => $KL4_Feed,
					'RM3_EP' => $RM3_EP,
					'RM3_Feed' => $RM3_Feed,
					'RM4_EP' => $RM4_EP,
					'RM4_Feed' => $RM4_Feed,
					'CM3_Product' => $CM3_Product,
					'CM4_Product' => $CM4_Product
	   );
			}
			 echo '{"7000":'.json_encode($myJson).'}';
	}	

}

/* End of file m_feedtuban34.php */
/* Location: ./application/models/m_feedtuban34.php */