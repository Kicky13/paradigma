<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_scodatadetail extends CI_Model {

	public function get_scodatadetail()
	{
		$db=$this->load->database('default5',true);
		$filter = $_GET['COM'];
//$sql = "select * from ZREPORT_RPTREAL_RESUM where COM = {$filter} ";
//$sql = "select * from ZREPORT_RPTREAL_RESUM inner join M_PROVINSI ON M_PROVINSI.KD_PROV = ZREPORT_RPTREAL_RESUM.PROPINSI WHERE ZREPORT_RPTREAL_RESUM.COM = {$filter}";
$sql = $db->query("select NM_PROV_1, PROPINSI, 
SUM(ZREPORT_RPTREAL_RESUM.TARGET_RKAP) AS TARGET_RKAP, 
SUM(ZREPORT_RPTREAL_RESUM.REALTO) as REALTO
from ZREPORT_RPTREAL_RESUM, M_PROVINSI
WHERE ZREPORT_RPTREAL_RESUM.COM = {$filter} AND ZREPORT_RPTREAL_RESUM.PROPINSI = M_PROVINSI.KD_PROV 
GROUP BY PROPINSI, NM_PROV_1"); 
$total_array = array();
foreach ($sql as $rowID) {
	$total_array[]=array("PROPINSI"=>$rowID['PROPINSI'],
"TARGET_RKAP"=>$rowID['TARGET_RKAP'],
"REALTO"=>$rowID['REALTO'],
"NM_PROV_1"=>$rowID['NM_PROV_1']);
}

echo json_encode($total_array);
	}

}

/* End of file m_scodatadetail.php */
/* Location: ./application/models/m_scodatadetail.php */