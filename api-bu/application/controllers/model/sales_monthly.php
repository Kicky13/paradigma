<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Sales_monthly extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('msales','',true);
    }
    
    function get_smig(){
        $par = array("year"=>"2016");
        $result = $this->msales->mget_smig($par);
        $return = array();
        foreach ($result as $value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL
            );
        }
        
      echo json_encode($return);
    }
    
    /*
        dijakan 1 disini saja
     */
    function get_monthly_s_opco(){
        //ada parameter company
        // tahun
        
        
    }
    
    
    function sales_3000(){
        $par=array("year"=>"2016","com"=>"3000");
        $result = $this->msales->get_data($par);
        $return = array();
        foreach ($result as $key=>$value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL,
              "last_volume"=> 0,
              "last_revenue"=> 0,
              "last_harga"=> 0
            );
	}
		echo json_encode(array("3000"=>$return));
    }
    
    
    function sales_4000(){
        $par=array("year"=>"2016","com"=>"4000");
        $result = $this->msales->get_data($par);
        $return = array();
        foreach ($result as $key=>$value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL,
              "last_volume"=> 0,
              "last_revenue"=> 0,
              "last_harga"=> 0
            );
        }
        
      echo json_encode(array("4000"=>$return));
    }
    
    function sales_7000(){
        $par=array("year"=>"2016","com"=>"7000");
        $result = $this->msales->get_data($par);
        $return = array();
        foreach ($result as $key=>$value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL,
              "last_volume"=> 0,
              "last_revenue"=> 0,
              "last_harga"=> 0
            );
        }
        
      echo json_encode(array("7000"=>$return));

    }
    
    function sales_6000(){
        // untuk TLCC RKAP sementara disamakan dengan ralisasi
        $par=array("year"=>"2016","com"=>"6000");
        $result = $this->msales->get_data($par);
        $return = array();
        foreach ($result as $key=>$value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>($value->REVRKAP == 0) ? $value->REVREAL : $value->REVRKAP ,
              "rkap_harga"=>($value->PRRKAP == 0) ? $value->PRREAL : $value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL,
              "last_volume"=> 0,
              "last_revenue"=> 0,
              "last_harga"=> 0
            );
        }
        
      echo json_encode(array("6000"=>$return));
    }
    
    
}