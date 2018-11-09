<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class stockmaterial extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('m_stockmaterial');
        //$this->load->helper('text');
    }

public function index(){

}
public function get_data_po(){
		
	$hasil = $this->m_stockmaterial->get_data_po();
	foreach ($hasil->result_array() as $rowID) {
		$POVAL=$rowID['POVAL'];
		$POQTY=$rowID['POQTY'];
		

		$data[]=array(	'POVAL'=>$POVAL,
						'POQTY'=>$POQTY,
						);
	}

	echo json_encode($data);
	}
	public function get_data_rkap(){
	$hasil = $this->m_stockmaterial->get_data_rkap();
	foreach ($hasil->result_array() as $rowID) {
		$rkapVAL=$rowID['RKAPVAL'];
		$rkapQTY=$rowID['RKAPQTY'];
		

		$data[]=array(	'RKAPVAL'=>$RKAPVAL,
						'RKAPQTY'=>$RKAPQTY,
						);
	}

	echo json_encode($data);
	
	}
	public function get_data_gr(){
	$hasil = $this->m_stockmaterial->get_data_gr();
	foreach ($hasil->result_array() as $rowID) {
		$GRVAL=$rowID['GRVAL'];
		$GRQTY=$rowID['GRQTY'];
		

		$data[]=array(	'GRVAL'=>$GRVAL,
						'GRQTY'=>$GRQTY,
						);
	}

	echo json_encode($data);
	
	}
 }