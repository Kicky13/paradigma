<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FicoDataDistributor extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default',true);
		$sql=$db->query("SELECT
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
							AP = 0
						AND VERZN IN (
							'1',
							'2',
							'3',
							'7'
						)
						AND BUKRS IN ('2000','3000','4000','5000','6000','7000')  
						ORDER BY TO_NUMBER(AR) DESC
						");
		foreach ($sql->result_array() as $rowID) {
			 $company = $rowID['BUKRS'];
			    $distributor = $rowID['CUST'];
			    $distributor_name = $rowID['NAME1'];
			    $date_time = $rowID['DATUM'];
			    $h_day = $rowID['VERZN'];
			    $amount_ap = $rowID['AP'];
			    $amount_ar = $rowID['AR'];

			    $dist[$h_day][$distributor] = array(
			        "company" => $company,
			        "vendor_code" => $distributor,
			        "vendor_name" => $distributor_name,
			        "date_time" => $date_time,
			        "day" => $h_day,
			        "acc_pay" => $amount_ap,
			        "acc_rec" => $amount_ar);
			}

echo '{"7000":'.json_encode($dist).'}';

	}

}

/* End of file FicoDataDistributor.php */
/* Location: ./application/controllers/FicoDataDistributor.php */