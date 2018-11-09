<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class c_clinker extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_clinker');
    }
 public function exchange(){
	$totalkurs = 0;
	
	for ($i= 1, $i<=31, $i++) {
            
			if($i<10){
				$i='0'.$i;
			}
			# code...
            $data['TUBAN I']['201609'.$i] = array(
                'c3s' => 0
            );
			$data['TUBAN II']['201609'.$i] = array(
                'c3s' => 0
            );
	}        
	$result_exchange    = $this->m_clinker->exchange(); 
	//$i = 1;
	foreach ($result_exchange as $key => $value) {
		if($value->PLANT == 'TUBAN I'){
			$data['TUBAN I'][$value->TANGGAL] = array(
			//'tanggal' => $value->TANGGAL,
			//'company' => $value->COMPANY,
			'c3s' => $value->C3S
			);
		}else{
			$data['TUBAN II'][$value->TANGGAL] = array(
			//'tanggal' => $value->TANGGAL,
			//'company' => $value->COMPANY,
			'c3s' => $value->C3S
			);
		}
	//$tanggal = $value->TANGGAL;
	//$data[$i] = array(
	//'tanggal' => $tanggal,
	//'company' => $value->COMPANY,
	//'plant' => $value->PLANT,
	//'c3s' => $value->C3S
	//);
	//$i++;
	}	
	echo json_encode($data);
	//echo json_encode($result_exchange);
    
}
public function exchange_usd(){
	
	$result_exchange_usd = $this->m_exchange_rate->exchange_usd();
	echo json_encode($result_exchange_usd);
}
}