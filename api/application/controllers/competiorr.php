<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class competiorr extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_competitor_tu');
    }
 
    public function get_data(){
        $result_perusahaan = $this->m_competitor_tu->getDataSemua();

		    // foreach ($result_perusahaan as $key => $value) {
		    //   $data = array(
	     //     'kode_perusahaan' => $value->KODE_PERUSAHAAN,
	     //     'nama_perusahaan' => $value->NAMA_PERUSAHAAN,
	     //     'fasilitas' => $value->FASILITAS,
	     //     'nama_fasilitas' => $value->NAMA_FASILITAS
	     //   );
	     // }
		$i = 1;
        $return[$i] = array();
        
        foreach ($result_perusahaan as $key=>$value){
            $return[$i] = array(
              "kode_perusahaan"=>$value['KODE_PERUSAHAAN'],
              "nama_perusahaan"=>$value['NAMA_PERUSAHAAN'],
              "fasilitas"=>$value['FASILITAS'],
              "nama_fasilitas"=>$value['NAMA_FASILITAS']
            );
			$i++;
        }
        echo json_encode($return);
    }

}
