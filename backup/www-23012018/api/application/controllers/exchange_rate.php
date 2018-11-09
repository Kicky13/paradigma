<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class exchange_rate extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_exchange_rate');
    }
 public function exchange(){
	$totalkurs = 0;
 
	$result_exchange    = $this->m_exchange_rate->exchange(); 
	$i = 1;
	foreach ($result_exchange as $key => $value) {
	$totalkurs = (float) $value->VALKURS;
	$data[$i] = array(
	'totalkurs' => $totalkurs,
	'tanggal' => $value->GDATU,
	'man' => $value->MAN,
	'fcurr' => $value->FCURR,
	'tcurr' => $value->TCURR
	);
	$i++;
	}	
	echo json_encode($data);
	//echo json_encode($result_exchange);
    
}
public function exchange_usd(){
	
	$result_exchange_usd = $this->m_exchange_rate->exchange_usd();
	echo json_encode($result_exchange_usd);
}
}