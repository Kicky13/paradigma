<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class rfc_management extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_rfc_mng');
    }
 
    public function get_datarfc()
    {
    	//$comp           = $_GET['company'];
        $comp 			= (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp           = str_replace(",","','",$comp);
       
        //$date           = $_GET['date'];
        $date 			= (empty($_GET['date']) ? date('Ymd') : $_GET['date']);
        // echo $date;
        // $strdate		= str_replace(".","-",$date)."-20";
        // $newdate 		= strtotime('-1 month' , strtotime ($strdate)) ;
        // $date_lmonth 	= date( 'Y.m' , $newdate);
        $date_lyear     = (intval(substr($date, 0, 4)) - 1).substr($date,4);
        // $temp           = $this->date_between($date);
        // $temp_lyear     = $this->date_between($date_lyear);
        if ($comp!='smi') {
            # code...
            $comp_now 	= $this->paramCompany($comp, $date);
            $comp_ly 	  = $this->paramCompany($comp, $date_lyear);
        }
    	# code...
        $dateprevupto   = substr($date, 0, 4).'0101';
        // echo $dateprevupto;
        // echo $date;
        // echo $comp_now;
        
      $data_rfcm        = array();
    	$data_rfcm        = $this->m_rfc_mng->get_tabeldata($comp_now, $date);
      $data_rfcm_upto   = array();
      $data_rfcm_upto   = $this->m_rfc_mng->get_tabeldataup($comp_now, $date, $dateprevupto);


    	$data1 			= array();
      $data1['Bulan Ini']['TOTAL'] = (float) $data_rfcm->TOTAL_PIUTANG;
    	$data1['Bulan Ini']['Belum Jatuh Tempo'] = (float) $data_rfcm->AKAN_TEMPO;
    	$data1['Bulan Ini']['Tempo 1 Sampai 30'] = (float) $data_rfcm->TEMPO1_30;
    	$data1['Bulan Ini']['Tempo 31 Sampai 60'] = (float) $data_rfcm->TEMPO31_60;
    	$data1['Bulan Ini']['Tempo 61 Sampai 120'] = (float) $data_rfcm->TEMPO61_120;
    	$data1['Bulan Ini']['Tempo 121 Sampai 360'] = (float) $data_rfcm->TEMPO121_360;
    	$data1['Bulan Ini']['Tempo 361 Sampai 720'] = (float) $data_rfcm->TEMPO361_720;
    	$data1['Bulan Ini']['Tempo 721 Sampai 999'] = (float) $data_rfcm->TEMPO721_999;
    	$data1['Bulan Ini']['Tempo Lebih 999'] = (float) $data_rfcm->TEMPO999;
      $data1['Bulan Ini']['TOTAL PIUTANG'] = (float) $data_rfcm->AKAN_TEMPO + (float) $data_rfcm->TEMPO1_30 + (float) $data_rfcm->TEMPO31_60 + (float) $data_rfcm->TEMPO61_120 + (float) $data_rfcm->TEMPO121_360 + (float) $data_rfcm->TEMPO361_720 + (float) $data_rfcm->TEMPO721_999 + (float) $data_rfcm->TEMPO999;


      $data1['Up To Bulan Ini']['TOTAL'] = (float) $data_rfcm_upto->TOTAL_PIUTANG;
      $data1['Up To Bulan Ini']['Belum Jatuh Tempo'] = (float) $data_rfcm_upto->AKAN_TEMPO;
      $data1['Up To Bulan Ini']['Tempo 1 Sampai 30'] = (float) $data_rfcm_upto->TEMPO1_30;
      $data1['Up To Bulan Ini']['Tempo 31 Sampai 60'] = (float) $data_rfcm_upto->TEMPO31_60;
      $data1['Up To Bulan Ini']['Tempo 61 Sampai 120'] = (float) $data_rfcm_upto->TEMPO61_120;
      $data1['Up To Bulan Ini']['Tempo 121 Sampai 360'] = (float) $data_rfcm_upto->TEMPO121_360;
      $data1['Up To Bulan Ini']['Tempo 361 Sampai 720'] = (float) $data_rfcm_upto->TEMPO361_720;
      $data1['Up To Bulan Ini']['Tempo 721 Sampai 999'] = (float) $data_rfcm_upto->TEMPO721_999;
      $data1['Up To Bulan Ini']['Tempo Lebih 999'] = (float) $data_rfcm_upto->TEMPO999;
      $data1['Up To Bulan Ini']['TOTAL PIUTANG'] = (float) $data_rfcm->AKAN_TEMPO + (float) $data_rfcm->TEMPO1_30 + (float) $data_rfcm->TEMPO31_60 + (float) $data_rfcm->TEMPO61_120 + (float) $data_rfcm->TEMPO121_360 + (float) $data_rfcm->TEMPO361_720 + (float) $data_rfcm->TEMPO721_999 + (float) $data_rfcm->TEMPO999;
    	

      // $data['RFCM -> BUKRS : '.$comp] = array($data1);
      echo json_encode($data1);
    }

    private function division($a, $b) 
    {   
        if ($a == '' || empty($a) || $a == null){
            $a = 0;
        }    
        if($b == 0){
            return 0;
        }else{
                try {
                        $tmp = floatval($a)/floatval($b);  
                    } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }
                return $tmp;
              }
    }  



    function paramCompany($com, $year){
        $year = (int) $year;
        $paramCompany = "5000', '3000', '4000', '6000";

          if ($year>2016) {
                $paramCompany = "5000', '3000', '4000', '6000";
                if ($com!='' && $com!='SMI' && $com!='smi') {
                      $paramCompany = "$com";
                          if ($com == '7000') {
                              # code...
                              $paramCompany = "5000";
                          }
                }
          }else if ($year<=2016) {
                # code...
                $paramCompany = "7000','2000', '3000', '4000', '6000";
                if ($com!='' && $com!='SMI' && $com!='smi') {
                        $paramCompany = "$com";
                        if ($com == '7000') {
                        # code...
                        $paramCompany = "$com', '2000";
                        }
                }
        }
        // echo $paramCompany;
        return $paramCompany;
    }  

   function date_between($date){
            $datestr = explode(".",$date);
            $period = array();
              for ($x=1;$x<=intval($datestr[1]);$x++){
                  $tmp = '0'.$x;
                  array_push($period, "'".(intval($datestr[0])).'.'.substr($tmp,-2)."'");    
              } 
        return implode($period,",");
   }

}
