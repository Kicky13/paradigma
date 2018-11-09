<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ficodatavendor extends CI_Model {

	public function get_ficodatavendor()
	{
		$db=$this->load->database('default',true);
		$sql_vend = $db->query("SELECT
					BUKRS,
					CUST,
					AP,
					AR,
					VERZN,
					HWAER,
					NAME1,
					DATUM
				FROM
					ZCFI_CF_AP_AR_CUST
				WHERE
					AR = 0
				AND VERZN IN (
					'1',
					'2',
					'3',
					'7'
				)
				AND BUKRS IN ('2000','3000','4000','5000','6000','7000')");
		foreach ($sql_vend->result_array() as $rowID) {
			if (!empty($rowID)) {
			        $company = $rowID['BUKRS'];
			        $vendor = $rowID['CUST'];
			        $vendor_name = $rowID['NAME1'];
			        $date_time = $rowID['DATUM'];
			        $h_day = $rowID['VERZN'];
			        $amount_ap = $rowID['AP'];
			        $amount_ar = $rowID['AR'];

			        $vend[$h_day][$vendor] = array(
			            "company" => $company,
			            "vendor_code" => $vendor,
			            "vendor_name" => $vendor_name,
			            "date_time" => $date_time,
			            "day" => $h_day,
			            "acc_pay" => $amount_ap,
			            "acc_rec" => $amount_ar);
			    } else {
			        $vend['0']['7000'] = array(
			            "company" => 0,
			            "vendor_code" => 0,
			            "vendor_name" => 0,
			            "date_time" => 0,
			            "day" => 0,
			            "acc_pay" => 0,
			            "acc_rec" => 0);
			    }
			}

			echo '{"7000":'.json_encode($vend).'}';
	}

}

/* End of file m_ficodatavendor.php */
/* Location: ./application/models/m_ficodatavendor.php */