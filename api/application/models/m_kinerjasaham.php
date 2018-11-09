<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kinerjasaham extends CI_Model {

	public function get_kinerjasaham()
	{
		$db=$this->load->database('default5',true);
	if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = 1;
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = 2016;
}


$sql = $db->query("SELECT * FROM KINERJA_SAHAM WHERE TAHUN =$tahun AND BULAN=$bulan");

foreach ($sql->result_array() as $rowID) {
    
    $tgl = $rowID['TGL'];
	$company = $rowID['COMPANY'];
	$nilai_saham = $rowID['NILAI_SAHAM'];
	
	$pc_data3[$company][$tgl]=array(
			'company'=>$company,
			'tgl'=>$tgl,
			'nilai_saham'=>$nilai_saham,
			);
}
echo json_encode($pc_data3);
	}

}

/* End of file m_kinerja_saham.php */
/* Location: ./application/models/m_kinerja_saham.php */