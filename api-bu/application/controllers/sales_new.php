<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class sales_new extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('msales_new','',true);
    }
    
    function get_smig_thisday(){
        $yearmonth = date('Ym');
        $result = $this->msales_new->get_detail_thisday();
        $result_check = $this->msales_new->checking_clinker_thisday();

        // if ($result_check->KODE_MATERIAL == NULL) {
        //   # code...
        //   $clinker_stat = 0;
        // }else{
        //   $clinker_stat = 1;
        // }
        
        // echo $result_check;

        $clinker_stat = $this->checking($result_check);

        $return = array();
        if ($clinker_stat == 0) {
              # code...
                $return["Clinker"] = array(
                "volume"=>0,
                "revenue"=>0,
                "harga"=>0,
                "trev"=>0
              );
            }
        
        foreach ($result as $key=>$value){
            
            $return[$value->NAMA_MATERIAL] = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>0
            );
        }


        $result_peropco = $this->msales_new->get_detail_thisday_peropco();
        $result_rkaprev = $this->msales_new->get_rkaprev_thisday_peropco($yearmonth);
        
        // foreach ($result_rkaprev as $key=>$value){
        //     // $rkaprev.$value->VKORG = $value->RKAP_REVENUE;
        //     echo '$rkaprev'.$value->VKORG;
        // }

        foreach ($result_peropco as $key=>$value1){
          // foreach ($result_rkaprev as $key=>$value2){
            // if ($value1->COMPANY == $value2->VKORG) {
              $return[$value1->COMPANY] = array(
                  "volume"=>$value1->VOLUME,
                  "revenue"=>$value1->REVENUE,
                  "harga"=>$value1->PRICE
                  // "trev"=>$value2->RKAP_REVENUE
              );
              # code...
            // }
          // }
        }


        echo json_encode($return);
        
    }

    function get_smig_uptothisday(){
      $result = $this->msales_new->get_detail_upthisday();
        $result_check = $this->msales_new->checking_clinker_upthisday();
        if ($result_check == NULL) {
          # code...
          $clinker_stat = 0;
        }else{
          $clinker_stat = 1;
        }
        
        $return = array();
        if ($clinker_stat == 0) {
              # code...
                $return["Clinker"] = array(
                "volume"=>0,
                "revenue"=>0,
                "harga"=>0,
                "trev"=>0
              );
            }
        
        foreach ($result as $key=>$value){
            
            $return[$value->NAMA_MATERIAL] = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>$value->TARGET_REV
            );
        }


        $result_peropco = $this->msales_new->get_detail_upthisday_peropco();
        foreach ($result_peropco as $key=>$value){
            $return[$value->COMPANY] = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>$value->TARGET_REV
            );
        }


        echo json_encode($return);

    }

    function get_smig_uptothismonth(){
       $result = $this->msales_new->get_detail_upthismonth();
        $result_check = $this->msales_new->checking_clinker_upthismonth();
        if ($result_check->KODE_MATERIAL == NULL) {
          # code...
          $clinker_stat = 0;
        }else{
          $clinker_stat = 1;
        }
        
        $return = array();
        if ($clinker_stat == 0) {
              # code...
                $return["Clinker"] = array(
                "volume"=>0,
                "revenue"=>0,
                "harga"=>0,
                "trev"=>0
              );
            }
        
        foreach ($result as $key=>$value){
            
            $return[$value->NAMA_MATERIAL] = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>$value->TARGET_REV
            );
        }


        $result_peropco = $this->msales_new->get_detail_upthismonth_peropco();
        foreach ($result_peropco as $key=>$value){
            $return[$value->COMPANY] = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>$value->TARGET_REV
            );
        }


        echo json_encode($return);

    }

    function checking($data){
      if ($data == '' || empty($data) || $data == null) {
          # code...
          $clink_stat = 0;
        }else{
          $clink_stat = 1;
        }

      return $clink_stat;
    }

    function get_data_tbl_province(){
        $datetype = (empty($_GET['datetype']) ? 'yyyymmdd' : $_GET['datetype']);
        $com = (empty($_GET['company']) ? 'smi' : $_GET['company']);

        $result_data = $this->msales_new->get_data_tabel_province($com,$datetype);

        echo json_encode($result_data);

        // foreach ($result_data as $key=>$value){
        //     $return[$value->PROVINCE] = array(
        //       "VOLUME"=>$value->VOLUME,
        //       "PRICE"=>$value->PRICE,
        //       "REVENUE"=>$value->REVENUE
        //     );
        // }
        // echo json_encode($return);    
    }

    function get_data_rev_vol_price(){
        $datetype = (empty($_GET['datetype']) ? 'yyyymmdd' : $_GET['datetype']);
        $com = (empty($_GET['company']) ? 'smi' : $_GET['company']);

        $result_data = $this->msales_new->get_data_detail($com,$datetype);

        // echo json_encode($result_data);

        if ($datetype == 'yyyymmdd') {
            $value_rkap = 0;
        } else if ($datetype == 'yyyymm'){
          $result_rkap = $this->msales_new->get_data_detail_rkapblnini($com);
          foreach ($result_rkap as $key=>$value){
            $value_rkap = $value->TARGET_RKAP;
          }
          // $value_rkap = 1;
        } else{
          $result_rkap = $this->msales_new->get_data_detail_rkapupblnini($com);
          foreach ($result_rkap as $key=>$value){
            $value_rkap = $value->TARGET_RKAP;
          }
          // $value_rkap = 2;
        }

        // echo $value_rkap;

        $return = array();
        
        foreach ($result_data as $key=>$value){
            $return = array(
              "volume"=>$value->VOLUME,
              "revenue"=>$value->REVENUE,
              "harga"=>$value->PRICE,
              "trev"=>$value_rkap
            );
        }

        echo json_encode($return);    
    }
 
}