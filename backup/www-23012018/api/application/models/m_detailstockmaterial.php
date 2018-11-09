<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detailstockmaterial extends CI_Model {

	public function get_detailstockmaterial()
	{
		$dataget = $_GET['DATA'];
		$datagets = $_GET['DATAS'];
		$db=$this->load->database('default',true);
		if ($datagets == 0) {
    $sql =$db->query(" SELECT WERKS, MATNR, MBWBEST, WBWBEST FROM TB_N_INV where WERKS LIKE '{$dataget}%' AND WERKS LIKE '_7%' AND ROWNUM <=10");    
}
else{
    $sql = $db->query("SELECT WERKS, MATNR, MBWBEST, WBWBEST FROM TB_N_INV where (WERKS LIKE '{$dataget}%' OR WERKS LIKE '{$datagets}%') AND WERKS LIKE '_7%' AND ROWNUM <=10");
}
	foreach ($sql->result_array() as $rowID) {
		$total_array[]=array("WERKS"=>$rowID['WERKS'],
                          "MATNR"=>$rowID['MATNR'],
                          "MBWBEST"=>$rowID['MBWBEST'],
                          "WBWBEST"=>$rowID['WBWBEST']);
}

echo json_encode($total_array);
	}

}

/* End of file m_detailstockmaterial.php */
/* Location: ./application/models/m_detailstockmaterial.php */