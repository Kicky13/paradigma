<?php
header('Access-Control-Allow-Origin: *');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Sales_daily extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
       $this->load->model('msales_daily','',true);
       $totalrkap=0;
       $totalrkap2=0;
       $toalReal=0; 
       $tempData= array();
       $finalREsult = array();
       $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
       $param['tahun'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
       $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

       $result_rkap = $this->msales_daily->get_rkap_data($param);
       $result  = $this->msales_daily->get_data($param);
       foreach ($result as $key=>$value){
           $tempData[$value->COM][] = $value;
           $toalReal = $toalReal + (double)$value->REALS;
           $totalrkap2 = $totalrkap2 +(double)$value->RKAP_JADI;
       }
       
       foreach ($tempData as $k=>$vl){
           // $finalREsult['rkap1'] = $totalrkap;
           $finalREsult['rkap'] = $result_rkap->RKAP;
           $finalREsult['actual'] = $toalReal;
           $com = $k;
           //loop sencond
           foreach ($vl as $vl2){
               if($vl2->TYPEM == '121-302'){
                   $finalREsult[$com]['curah']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
               "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
               "real"=> (double)$vl2->REALS,
               "rkap"=> (double)$vl2->RKAP_JADI
                   );
               }else{
                   $finalREsult[$com]['zak']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
                                      "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
               "real"=> (double)$vl2->REALS,
               "rkap"=> (double)$vl2->RKAP_JADI
                   );                   
               }
           }
       }
       
       echo json_encode($finalREsult);
    }

    function get_company(){
       $this->load->model('msales_daily','',true);
       $totalrkap=0;
       $totalrkap2=0;
       $toalReal=0; 
       $tempData= array();
       $finalREsult = array();
       $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
       $param['tahun'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
       $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

       $result_rkap = $this->msales_daily->get_rkap_data($param);

       $getRkap['RKAP'] = $result_rkap->RKAP;

       echo json_encode($getRkap);
    }
   
    
   
    
}