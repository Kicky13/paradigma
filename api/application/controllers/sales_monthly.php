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

      // $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

        // $par = array("year"=>"2016");
        // $result = $this->msales->mget_smig($param);
      	$result = $this->msales->mget_smig_bulanan($param);
        $return = array();
        $return['last_update'] = $this->last_update();
        foreach ($result as $value){
            $arrTemp[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL
            );
        }
        $return['data'] = $arrTemp;

      echo json_encode($return);
    }

    function get_smig_bulanan(){

      // $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

        // $par = array("year"=>"2016");
        $result = $this->msales->mget_smig_bulanan($param);
        $return = array();
        foreach ($result as $value){
            $arrTemp[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              "rkap_revenue"=>$value->REVRKAP,
              "rkap_harga"=>$value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL
            );
        }
      $return['data'] = $arrTemp;
      $return['last_update'] = $this->last_update();
      echo json_encode($return);
    }

    function last_update(){
      $result = $this->msales->get_last_update();
      // $formataed = date($result['LAST_UPDATE']);
      // $formataed = date_format($result['LAST_UPDATE'], "d/m/Y H:i:s");
      return $result->LAST_UPDATE;
      // return $result;
    }
    
    /*
        dijakan 1 disini saja
     */
    function get_monthly_s_opco(){
        //ada parameter company
        // tahun
        
        
    }
    
    
    function sales_3000(){
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '3000';
        // $par=array("year"=>"2016","com"=>"3000");
        // $result = $this->msales->get_data($param);
        $result = $this->msales->get_data_new($param);
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
         $out['data']['3000'] = $return;
        $out['last_update'] = $this->last_update();

        echo json_encode($out);
		// echo json_encode(array("3000"=>$return, 'last_update' => $this->last_update()));
    }
    
    
    function sales_4000(){
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '4000';
        // $par=array("year"=>"2016","com"=>"4000");
        // $result = $this->msales->get_data($param);
        $result = $this->msales->get_data_new($param);
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
        $out['data']['4000'] = $return;
        $out['last_update'] = $this->last_update();

        echo json_encode($out);
      // echo json_encode(array("4000"=>$return, 'last_update' => $this->last_update()));
    }

    function sales_5000(){
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '5000';
        // $par=array("year"=>"2016","com"=>"4000");
        // $result = $this->msales->get_data($param);
        $result = $this->msales->get_data_new($param);
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
        $out['data']['5000'] = $return;
        $out['last_update'] = $this->last_update();

        echo json_encode($out);
      // echo json_encode(array("4000"=>$return, 'last_update' => $this->last_update()));
    }

    function sales_7000(){
        $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '7000';
        // $par=array("year"=>"2016","com"=>"7000");
        // $result = $this->msales->get_data($param);
        $target_volume = 0;
        $real_volume = 0;
        $target_revenue = 0;
        $real_revenue = 0;
        $target_price = 0;
        $real_price = 0;
        
        $result = $this->msales->get_data_new($param);
        $return_data = array();
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
            $real_volume    = $real_volume + (double)$value->TREALTO;
            $target_volume  = $target_volume + (double)$value->TRKAP;
            $target_revenue = $target_revenue + (double)$value->REVRKAP;
            $real_revenue   = $real_revenue + (double)$value->REVREAL;
            $target_price   = $target_price + (double)$value->PRRKAP;
            $real_price     = $real_price + (double)$value->PRREAL;
        }
        $return_data['rkap_volume'] = (float) $target_volume;
        $return_data['rkap_revenue'] = (float) $target_revenue;
        $return_data['rkap_harga'] = (float) $target_price;
        $return_data['real_volume'] = (float) $real_volume;
        $return_data['real_revenue'] = (float) $real_revenue;
        $return_data['real_harga'] = (float) $real_price;
        $return_data['last_volume'] = (float) 0;
        $return_data['last_revenue'] = (float) 0;
        $return_data['last_harga'] = (float) 0;
        
      // echo json_encode($return_data);
        $out['data']['7000'] = $return;
        $out['last_update'] = $this->last_update();

        echo json_encode($out);
        // echo json_encode(array("7000"=>$return, 'last_update' => $this->last_update()));
        // echo json_encode(array("7000"=>$return));

    }
    
    function sales_7000_new(){
        $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '7000';
        // $par=array("year"=>"2016","com"=>"7000");
        // $result = $this->msales->get_data($param);
        $target_volume = 0;
        $real_volume = 0;
        $target_revenue = 0;
        $real_revenue = 0;
        $target_price = 0;
        $real_price = 0;
        
        $result = $this->msales->get_data_new($param);
        $return_data = array();
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
            $real_volume    = $real_volume + (double)$value->TREALTO;
            $target_volume  = $target_volume + (double)$value->TRKAP;
            $target_revenue = $target_revenue + (double)$value->REVRKAP;
            $real_revenue   = $real_revenue + (double)$value->REVREAL;
            $target_price   = $target_price + (double)$value->PRRKAP;
            $real_price     = $real_price + (double)$value->PRREAL;
        }
        $return_data['rkap_volume'] = (float) $target_volume;
        $return_data['rkap_revenue'] = (float) $target_revenue;
        $return_data['rkap_harga'] = (float) $target_price;
        $return_data['real_volume'] = (float) $real_volume;
        $return_data['real_revenue'] = (float) $real_revenue;
        $return_data['real_harga'] = (float) $real_price;
        $return_data['last_volume'] = (float) 0;
        $return_data['last_revenue'] = (float) 0;
        $return_data['last_harga'] = (float) 0;
        
      echo json_encode($return_data);

    }
    
    function sales_6000(){
        // untuk TLCC RKAP sementara disamakan dengan ralisasi
      $param['year'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['com'] = '6000';
        // $par=array("year"=>"2016","com"=>"6000");
        // $result = $this->msales->get_data($param);
        $result = $this->msales->get_data_new($param);
        $return = array();
        foreach ($result as $key=>$value){
            $return[$value->BULAN] = array(
              "rkap_volume"=>$value->TRKAP,
              // "rkap_revenue"=>($value->REVRKAP == 0) ? $value->REVREAL : $value->REVRKAP ,
              "rkap_revenue"=>$value->REVRKAP == 0,
              "rkap_harga"=>($value->PRRKAP == 0) ? $value->PRREAL : $value->PRRKAP,
              "real_volume"=> $value->TREALTO,
              "real_revenue"=> $value->REVREAL,
              "real_harga"=> $value->PRREAL,
              "last_volume"=> 0,
              "last_revenue"=> 0,
              "last_harga"=> 0
            );
        }
        $out['data']['6000'] = $return;
        $out['last_update'] = $this->last_update();

        echo json_encode($out);
      // echo json_encode(array("6000"=>$return, 'last_update' => $this->last_update()));
    }
    
    
}