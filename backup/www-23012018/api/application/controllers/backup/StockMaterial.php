<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockMaterial extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default',true);
		$sql = $db->query("SELECT tb1.com, SUM (tb1.mbwbest)/1000000  total_quant,sum(wbwbest)/1000000  tot_sum
    FROM (SELECT SUBSTR (werks, 0, 1) com,
                 matnr,
                 basme,
                 hwaer,
                 mbwbest,
                 wbwbest
            FROM tb_n_inv) tb1
   WHERE tb1.com <> 'A'
GROUP BY tb1.com");
foreach ($sql->result_array() as $rowID) {
	$total_array['s'.$rowID['COM']]=array(
						  "TOTAL_QUANT"=>$rowID['TOTAL_QUANT'],
						  "TOT_SUM"=>$rowID['TOT_SUM']);
}

echo json_encode($total_array);
	}

}

/* End of file StockMaterial.php */
/* Location: ./application/controllers/StockMaterial.php */