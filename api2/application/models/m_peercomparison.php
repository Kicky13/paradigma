<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peercomparison extends CI_Model {

	public function get_peercomparison()
	{
		$db=$this->load->database('default5',true);
		if (!empty($_GET['tipe'])) {
    $type = $_GET['tipe'];
} else {
    $type = 0;
}

$sql = $db->query("SELECT * FROM PEER_COMPARISON1 WHERE TYPE = '$type' ORDER BY ID	ASC");

foreach ($sql->result_array() as $rowID) {
    
    $id = $rowID['ID'];
	$desc = $rowID['DESCRIPTION'];
	
	$h_smgr = $rowID['H_SMGR'];
	$h1_smgr = $rowID['H1_SMGR'];
	$chg_smgr = $rowID['CHG_SMGR'];
	
	$h_smcb = $rowID['H_INTP'];
	$h1_smcb = $rowID['H1_INTP'];
	$chg_smcb = $rowID['CHG_INTP'];
	
	$h_intp = $rowID['H_SMCB'];
	$h1_intp = $rowID['H1_SMCB'];
	$chg_intp = $rowID['CHG_SMCB'];
	
	$semester = $rowID['SEMESTER'];
	$tahun = $rowID['TAHUN'];
	$tipe = $rowID['TYPE'];
    
    $pc_data[$id] = array(
		'description' =>  $desc,
		'h_smgr' =>  $h_smgr,
		'h1_smgr' =>  $h1_smgr,
		'chg_smgr' =>  $chg_smgr,
		
		'h_smcb' =>  $h_smcb,
		'h1_smcb' =>  $h1_smcb,
		'chg_smcb' =>  $chg_smcb,
		
		'h_intp' =>  $h_intp,
		'h1_intp' =>  $h1_intp,
		'chg_intp' =>  $chg_intp,
		
		'semester' =>  $semester
	);
}

echo '{"7000":' . json_encode($pc_data) . '}';
	}

}

/* End of file m_peercomparison.php */
/* Location: ./application/models/m_peercomparison.php */