<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MarketShareRKAP extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default5',true);
		if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}
else{$tahun = date('Y');}
$sql = $db->query("SELECT
	NAMA_PERUSAHAAN,
	NM_PROV_1,
	QTY
FROM
	ZREPORT_MS_RKAPMS
INNER JOIN M_PROVINSI ON ZREPORT_MS_RKAPMS.PROPINSI = M_PROVINSI.KD_PROV
WHERE THN = ".$tahun."
ORDER BY  NAMA_PERUSAHAAN");
	
	foreach ($sql->result_array() as $rowID) {
				
			$nama = $rowID['NAMA_PERUSAHAAN'];
			$prov = $rowID['NM_PROV_1'];
			$qty_real = $rowID['QTY'];
			
			$text[$prov]= array(
						"qty"=> $qty_real						
			);
			
			$mine[$nama][$prov]= array(
						"data"=> $qty_real						
			);
		}
		echo json_encode($mine);
	}

}

/* End of file MarketShareRKAP.php */
/* Location: ./application/controllers/MarketShareRKAP.php */