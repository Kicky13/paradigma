<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ficodatagendetail extends CI_Model {

	public function get_ficodatagendetail()
	{
		$db=$this->load->database('default',true);
		$sql = $db->query("SELECT
					bukrs,
					datum,
					SUM (ap) AS ap,
					SUM (ar) AS ar
				FROM
					zcfi_cf_ap_ar
				GROUP BY
					bukrs,
					datum
				ORDER BY bukrs ASC");

		foreach ($sql->result_array() as $rowID) {
			
			$company = $rowID['BUKRS'];
			$date_time = $rowID['DATUM'];
			//$h_day = $rowID['VERZN'];
			$amount_ap = $rowID['AP'];
			$amount_ar = $rowID['AR'];
			
			$text["s".$company]= array(
						"company"=> $company,
						"date_time" => $date_time,
						//"day"=> $h_day,
						"acc_pay"=> $amount_ap,
						"acc_rec"=>$amount_ar);
		}
		echo json_encode($text);
	}

}

/* End of file m_ficodatagendetail.php */
/* Location: ./application/models/m_ficodatagendetail.php */