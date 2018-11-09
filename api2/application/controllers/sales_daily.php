<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Sales_daily extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('msales_daily','',true);
    }
    
    function index(){
       $this->load->model('msales_daily','',true);
       $totalrkap=0;
       $totalrkap2=0;
       $toalReal=0; 
       $total_vol_Real=0;
       $tempData= array();
       $finalREsult = array();
       $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
       $param['tahun'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
       $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);
       $paramCompany = $param['company'];

       $result_rkap = $this->msales_daily->get_rkap_data($param);
       //$result  = $this->msales_daily->get_data($param);
       $result =  $this->msales_daily->get_data_resum($param);
       $resultvoldetail =  $this->msales_daily->get_data_resum_daily($param); 
       
       // foreach ($result as $key=>$value){
       //      $tempData[$paramCompany][] = $value;
       //     $toalReal = $toalReal + (double)$value->REALS;
       //     $totalrkap2 = $totalrkap2 +(double)$value->RKAP_JADI;
       // }

       foreach ($resultvoldetail as $key=>$value){
            $tempData[$paramCompany][] = $value;
       }


      $vol_result =  $this->msales_daily->get_vol_data($param);

       foreach ($vol_result as $key=>$value){
           $total_vol_Real = $total_vol_Real + (double)$value->REALS;      
       }

       $totalactual_zak = 0;
       $totalactual_curah = 0;
       
       // foreach ($tempData as $k=>$vl){
       //     // $finalREsult['rkap1'] = $totalrkap;
       //     $finalREsult['rkap'] = $result_rkap->RKAP;
       //     $finalREsult['actual'] = $total_vol_Real;
       //     $com = $k;
       //     //loop sencond
       //     foreach ($vl as $vl2){
       //         if($vl2->TYPEM == '121-302'){
       //             $finalREsult[$paramCompany]['curah']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
       //         "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
       //         "real"=> (double)$vl2->REALS,
       //         "rkap"=> (double)$vl2->RKAP_JADI
       //             );
       //         }else{
       //             $finalREsult[$paramCompany]['zak']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
       //                                "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
       //         "real"=> (double)$vl2->REALS,
       //         "rkap"=> (double)$vl2->RKAP_JADI
       //             );                   
       //         }
       //     }
       // }

       foreach ($tempData as $k=>$vl){
           // $finalREsult['rkap1'] = $totalrkap;
           $finalREsult['rkap'] = $result_rkap->RKAP;
           $finalREsult['actual'] = $total_vol_Real;
           $com = $k;
           //loop sencond
           foreach ($vl as $vl2){
               if($vl2->TYPEM == '121-302'){
                   $finalREsult[$paramCompany]['curah']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
               "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
               "real"=> (double)$vl2->REALS
                   );
               }else{
                   $finalREsult[$paramCompany]['zak']["{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}"]= array(
                                      "tanggal"=>"{$vl2->TAHUN}{$vl2->BULAN}{$vl2->TGL}", 
               "real"=> (double)$vl2->REALS
                   );                   
               }
           }
       }

       $finalREsult['last_update'] = $this->last_update();

       echo json_encode($finalREsult);
    }

    function revenue(){
        $totalreal = 0;
        $param['bulan'] = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $param['tahun'] = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $param['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);
        $tagCompany = $param['company'];
        $result = $this->msales_daily->get_data_rev($param);
        $result_rkap = $this->msales_daily->get_rkap_data($param);


        
        foreach ($result as $key => $value) {
          $totalreal += (double) $value->REV_REAL;
          // $company = $value->VKORG;
          $date = $value->DATEDAY;
          $data[$tagCompany][$date] = array(
                // 'company' => $company,
                'tanggal' => $date,
                'real' => $value->REV_REAL,
                'rkap' => $value->RKAP_REVENU

            );
        }

        $data['rkap'] = $result_rkap->REV_RKAP;
        $data['actual'] = (string) $totalreal;
        
        $data['last_update'] = $this->last_update();

        echo json_encode($data);
    }
    function last_update(){
      $result = $this->msales_daily->get_last_update();
      // $formataed = date($result['LAST_UPDATE']);
      // $formataed = date_format($result['LAST_UPDATE'], "d/m/Y H:i:s");
      return $result->LAST_UPDATE;
      // return $result;
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