<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_addtuban34 extends CI_Model {

	public function get_addtuban34()
	{
		$db2=$this->load->database('default2',true);
		$sql=$db2->get('addtbn34');
		foreach ($sql->result_array() as $row) {
			//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$CM4_MP =  number_format($row['CM4_MP'],2);
		$RM3_MP =  number_format($row['RM3_MP'],2);
		$RM4_MP =  number_format($row['RM4_MP'],2);
		$KL3_SP =  number_format($row['KL3_SP'],2);
		$KL4_SP =  number_format($row['KL4_SP'],2);
		
		$FM5_MP =  number_format($row['FM5_MP'],2);
		$FM6_MP =  number_format($row['FM6_MP'],2);
		$FM7_MP =  number_format($row['FM7_MP'],2);
		$FM8_MP =  number_format($row['FM8_MP'],2);
		
	    $toProd['Additional'][$minutes] = array(
					"cm4_mp" => $CM4_MP,
					"rm3_mp" => $RM3_MP,
					"rm4_mp" => $RM4_MP,
					"kl3_sp" => $KL3_SP,
					"kl4_sp" => $KL4_SP,
					"fm5_mp" => $FM5_MP,
					"fm6_mp" => $FM6_MP,
					"fm7_mp" => $FM7_MP,
					"fm8_mp" => $FM8_MP
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
	}

}

/* End of file m_addtuban34.php */
/* Location: ./application/models/m_addtuban34.php */