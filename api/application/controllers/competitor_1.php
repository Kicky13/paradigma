<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class C_coalstock extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_competitors');
    }
function getdataPerusahaan(){
		$result_perusahaan = $this->m_competitor->getDataSemua();
		$i = 1;
		foreach ($result_perusahaan as $key => $value) {
		$data[$i] = array(
	'kode_perusahaan' => $value->KODE_PERUSAHAAN,
	'nama_perusahaan' => $value->NAMA_PERUSAHAAN,
	'fasilitas' => $value->FASILITAS,
	'nama_fasilitas' => $value->NAMA_FASILITAS
	);
	$i++;
	}	
	echo json_encode($data);
	}
}