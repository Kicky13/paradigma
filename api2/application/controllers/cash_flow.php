<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class cash_flow extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cash_flow');
    }
 
    public function get_data_cashflow()
    {
    	$month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      	$year = (empty($_GET['tahun']) ? date('2016') : $_GET['tahun']);
      	$com = (empty($_GET['company']) ? 'smi' : $_GET['company']);
      	$company = $com;

      	// echo $year;
      	// echo $month;
      
      	$last_year = $year-1;
      	$year_of_last_year = $year-2;
      	// $last_month = substr(('0'.($month-1)), -2);

      	// if ($last_month=='00') {
       //    	$last_month = '12';
       //    	$year_of_last_year =  $year_of_last_month -1;
      	// }

      	// $past_date = "$last_year.12";
      	// $now_date = "$year.$month";
      	// $last_date = "$year_of_last_month.$last_month";

      	// $year = (int) $year;
      	// $last_year = (int) $last_year;
      	// $year_of_last_month = (int) $year_of_last_month;

      	$date = $year.'.'.$month;
      	$datea = $year.'.01';
      	$dateprev = $last_year.'.'.$month;
      	$dateprevly = $last_year.'.01';

      	// echo $date;
      	// echo $datea;
      	// echo $dateprev;
      	// echo $dateprevly;
      	
      	$data_cash_rbi        = array();
      	// $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
      	$data_cash_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 120', 'selected');
      	$data_cash_tbi        = array();
      	$data_cash_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 120', 'selected');
      	$data_cash_rlbi       = array();
      	$data_cash_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 120', 'selected');
      	$data_cash_rbi_up        = array();
      	$data_cash_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 120', 'upto');
      	$data_cash_tbi_up        = array();
      	$data_cash_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 120', 'upto');
      	$data_cash_rlbi_up       = array();
      	$data_cash_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 120', 'upto');
      	
    	$temp_real = (float) $data_cash_rbi->JML / 1000000000;
    	$temp_terget = (float) $data_cash_tbi->JML / 1000000000;
    	$temp_real_lalu = (float) $data_cash_rlbi->JML / 1000000000;

    	$data1 			= array();
      	$data1['Cash']['Real Ini'] = $temp_real;
      	$data1['Cash']['Target Ini'] = $temp_terget;
      	$data1['Cash']['Real Lalu Ini'] = $temp_real_lalu;
      	if($temp_real == 0 || $temp_terget == 0 || $temp_real_lalu == 0){
      		$data1['Cash']['Persen'] = 0;
      		$data1['Cash']['Yoy'] = 0;
      	}else{
      		$data1['Cash']['Persen'] = abs(($temp_real / $temp_terget) * 100);
      		$data1['Cash']['Yoy'] = abs((($temp_real-$temp_real_lalu) / $temp_real_lalu) * 100);
      	}
      	
      	$temp_real_up = (float) $data_cash_rbi_up->JML / 1000000000;
    	$temp_terget_up = (float) $data_cash_tbi_up->JML / 1000000000;
    	$temp_real_lalu_up = (float) $data_cash_rlbi_up->JML / 1000000000;

      	$data1['Cash']['Real Up To'] = $temp_real_up;
      	$data1['Cash']['Target Up To'] = $temp_terget_up;
      	$data1['Cash']['Real Lalu Up To'] = $temp_real_lalu_up;
      	if($temp_real_up == 0 || $temp_terget_up == 0 || $temp_real_lalu_up == 0){
      		$data1['Cash']['Persenupto'] = 0;
      		$data1['Cash']['Yoyupto'] = 0;
      	}else{
      		$data1['Cash']['Persenupto'] = abs(($temp_real_up / $temp_terget_up) * 100);
      		$data1['Cash']['Yoyupto'] = abs((($temp_real_up-$temp_real_lalu_up) / $temp_real_lalu_up) * 100);
      	}

      	$data_oprt_rbi        = array();
      	// $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
      	$data_oprt_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 7', 'selected');
      	$data_oprt_tbi        = array();
      	$data_oprt_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 7', 'selected');
      	$data_oprt_rlbi       = array();
      	$data_oprt_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 7', 'selected');
      	$data_oprt_rbi_up        = array();
      	$data_oprt_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 7', 'upto');
      	$data_oprt_tbi_up        = array();
      	$data_oprt_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 7', 'upto');
      	$data_oprt_rlbi_up       = array();
      	$data_oprt_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 7', 'upto');

      	$temp_opreal = (float) $data_oprt_rbi->JML / 1000000000;
    	$temp_opterget = (float) $data_oprt_tbi->JML / 1000000000;
    	$temp_opreal_lalu = (float) $data_oprt_rlbi->JML / 1000000000;
      	$data1['Oprt']['Real Ini'] = $temp_opreal;
      	$data1['Oprt']['Target Ini'] = $temp_opterget;
      	$data1['Oprt']['Real Lalu Ini'] = $temp_opreal_lalu;
      	if($temp_opreal == 0 || $temp_opterget == 0 || $temp_opreal_lalu == 0){
      		$data1['Oprt']['Persen'] = 0;
      		$data1['Oprt']['Yoy'] = 0;
      	}else{
      		$data1['Oprt']['Persen'] = abs(($temp_opreal_up / $temp_opterget_up) * 100);
      		$data1['Oprt']['Yoy'] = abs((($temp_opreal_up-$temp_opreal_lalu_up) / $temp_opreal_lalu_up) * 100);
      	}

      	$temp_opreal_up = (float) $data_oprt_rbi_up->JML / 1000000000;
    	$temp_opterget_up = (float) $data_oprt_tbi_up->JML / 1000000000;
    	$temp_opreal_lalu_up = (float) $data_oprt_rlbi_up->JML / 1000000000;
      	$data1['Oprt']['Real Up To'] = $temp_opreal_up;
      	$data1['Oprt']['Target Up To'] = $temp_opterget_up;
      	$data1['Oprt']['Real Lalu Up To'] = $temp_opreal_lalu_up;
      	if($temp_opreal_up == 0 || $temp_opterget_up == 0 || $temp_opreal_lalu_up == 0){
      		$data1['Oprt']['Persenupto'] = 0;
      		$data1['Oprt']['Yoyupto'] = 0;
      	}else{
      		$data1['Oprt']['Persenupto'] = abs(($temp_opreal_up / $temp_opterget_up) * 100);
      		$data1['Oprt']['Yoyupto'] = abs((($temp_opreal_up-$temp_opreal_lalu_up) / $temp_opreal_lalu_up) * 100);
      	}
// ==========================================================================================================================
        $data_rcpt_rbi        = array();
        // $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
        $data_rcpt_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 2', 'selected');
        $data_rcpt_tbi        = array();
        $data_rcpt_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 2', 'selected');
        $data_rcpt_rlbi       = array();
        $data_rcpt_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 2', 'selected');
        $data_rcpt_rbi_up        = array();
        $data_rcpt_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '1 AND 2', 'upto');
        $data_rcpt_tbi_up        = array();
        $data_rcpt_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '1 AND 2', 'upto');
        $data_rcpt_rlbi_up       = array();
        $data_rcpt_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '1 AND 2', 'upto');

      $temp_rcptreal = (float) $data_rcpt_rbi->JML / 1000000000;
      $temp_rcptterget = (float) $data_rcpt_tbi->JML / 1000000000;
      $temp_rcptreal_lalu = (float) $data_rcpt_rlbi->JML / 1000000000;
        $data1['Rcpt']['Real Ini'] = $temp_rcptreal;
        $data1['Rcpt']['Target Ini'] = $temp_rcptterget;
        $data1['Rcpt']['Real Lalu Ini'] = $temp_rcptreal_lalu;
        if($temp_rcptreal == 0 || $temp_rcptterget == 0 || $temp_rcptreal_lalu == 0){
          $data1['Rcpt']['Persen'] = 0;
          $data1['Rcpt']['Yoy'] = 0;
        }else{
          $data1['Rcpt']['Persen'] = abs(($temp_rcptreal_up / $temp_rcptterget_up) * 100);
          $data1['Rcpt']['Yoy'] = abs((($temp_rcptreal_up-$temp_rcptreal_lalu_up) / $temp_rcptreal_lalu_up) * 100);
        }

        $temp_rcptreal_up = (float) $data_rcpt_rbi_up->JML / 1000000000;
      $temp_rcptterget_up = (float) $data_rcpt_tbi_up->JML / 1000000000;
      $temp_rcptreal_lalu_up = (float) $data_rcpt_rlbi_up->JML / 1000000000;
        $data1['Rcpt']['Real Up To'] = $temp_rcptreal_up;
        $data1['Rcpt']['Target Up To'] = $temp_rcptterget_up;
        $data1['Rcpt']['Real Lalu Up To'] = $temp_rcptreal_lalu_up;
        if($temp_rcptreal_up == 0 || $temp_rcptterget_up == 0 || $temp_rcptreal_lalu_up == 0){
          $data1['Rcpt']['Persenupto'] = 0;
          $data1['Rcpt']['Yoyupto'] = 0;
        }else{
          $data1['Rcpt']['Persenupto'] = abs(($temp_rcptreal_up / $temp_rcptterget_up) * 100);
          $data1['Rcpt']['Yoyupto'] = abs((($temp_rcptreal_up-$temp_rcptreal_lalu_up) / $temp_rcptreal_lalu_up) * 100);
        }


        $data_dishb_rbi        = array();
        // $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
        $data_dishb_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '6 AND 7', 'selected');
        $data_dishb_tbi        = array();
        $data_dishb_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '6 AND 7', 'selected');
        $data_dishb_rlbi       = array();
        $data_dishb_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '6 AND 7', 'selected');
        $data_dishb_rbi_up        = array();
        $data_dishb_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '6 AND 7', 'upto');
        $data_dishb_tbi_up        = array();
        $data_dishb_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '6 AND 7', 'upto');
        $data_dishb_rlbi_up       = array();
        $data_dishb_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '6 AND 7', 'upto');

      $temp_dishbreal = (float) $data_dishb_rbi->JML / 1000000000;
      $temp_dishbterget = (float) $data_dishb_tbi->JML / 1000000000;
      $temp_dishbreal_lalu = (float) $data_dishb_rlbi->JML / 1000000000;
        $data1['Dishb']['Real Ini'] = $temp_dishbreal;
        $data1['Dishb']['Target Ini'] = $temp_dishbterget;
        $data1['Dishb']['Real Lalu Ini'] = $temp_dishbreal_lalu;
        if($temp_dishbreal == 0 || $temp_dishbterget == 0 || $temp_dishbreal_lalu == 0){
          $data1['Dishb']['Persen'] = 0;
          $data1['Dishb']['Yoy'] = 0;
        }else{
          $data1['Dishb']['Persen'] = abs(($temp_dishbreal_up / $temp_dishbterget_up) * 100);
          $data1['Dishb']['Yoy'] = abs((($temp_dishbreal_up-$temp_dishbreal_lalu_up) / $temp_dishbreal_lalu_up) * 100);
        }

        $temp_dishbreal_up = (float) $data_dishb_rbi_up->JML / 1000000000;
      $temp_dishbterget_up = (float) $data_dishb_tbi_up->JML / 1000000000;
      $temp_dishbreal_lalu_up = (float) $data_dishb_rlbi_up->JML / 1000000000;
        $data1['Dishb']['Real Up To'] = $temp_dishbreal_up;
        $data1['Dishb']['Target Up To'] = $temp_dishbterget_up;
        $data1['Dishb']['Real Lalu Up To'] = $temp_dishbreal_lalu_up;
        if($temp_dishbreal_up == 0 || $temp_dishbterget_up == 0 || $temp_dishbreal_lalu_up == 0){
          $data1['Dishb']['Persenupto'] = 0;
          $data1['Dishb']['Yoyupto'] = 0;
        }else{
          $data1['Dishb']['Persenupto'] = abs(($temp_dishbreal_up / $temp_dishbterget_up) * 100);
          $data1['Dishb']['Yoyupto'] = abs((($temp_dishbreal_up-$temp_dishbreal_lalu_up) / $temp_dishbreal_lalu_up) * 100);
        }



// ==========================================================================================================================

      	$data_invs_rbi        = array();
      	// $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
      	$data_invs_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '11 AND 15', 'selected');
      	$data_invs_tbi        = array();
      	$data_invs_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '11 AND 15', 'selected');
      	$data_invs_rlbi       = array();
      	$data_invs_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '11 AND 15', 'selected');
      	$data_invs_rbi_up        = array();
      	$data_invs_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '11 AND 15', 'upto');
      	$data_invs_tbi_up        = array();
      	$data_invs_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '11 AND 15', 'upto');
      	$data_invs_rlbi_up       = array();
      	$data_invs_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '11 AND 15', 'upto');

      	$temp_invreal = (float) $data_invs_rbi->JML / 1000000000;
    	$temp_invterget = (float) $data_invs_tbi->JML / 1000000000;
    	$temp_invreal_lalu = (float) $data_invs_rlbi->JML / 1000000000;
      	$data1['Invs']['Real Ini'] = $temp_invreal;
      	$data1['Invs']['Target Ini'] = $temp_invterget;
      	$data1['Invs']['Real Lalu Ini'] = $temp_invreal_lalu;
      	if($temp_invreal == 0 || $temp_invterget == 0 || $temp_invreal_lalu == 0){
      		$data1['Invs']['Persen'] = 0;
      		$data1['Invs']['Yoy'] = 0;
      	}else{
      		$data1['Invs']['Persen'] = abs(($temp_invreal / $temp_invterget) * 100);
      		$data1['Invs']['Yoy'] = abs((($temp_invreal-$temp_invreal_lalu) / $temp_invreal_lalu) * 100);
      	}

      	$temp_invreal_up = (float) $data_invs_rbi_up->JML / 1000000000;
    	$temp_invterget_up = (float) $data_invs_tbi_up->JML / 1000000000;
    	$temp_invreal_lalu_up = (float) $data_invs_rlbi_up->JML / 1000000000;
      	$data1['Invs']['Real Up To'] = $temp_invreal_up;
      	$data1['Invs']['Target Up To'] = $temp_invterget_up;
      	$data1['Invs']['Real Lalu Up To'] = $temp_invreal_lalu_up;
      	if($temp_invreal_up == 0 || $temp_invterget_up == 0 || $temp_invreal_lalu_up == 0){
      		$data1['Invs']['Persenupto'] = 0;
      		$data1['Invs']['Yoyupto'] = 0;
      	}else{
      		$data1['Invs']['Persenupto'] = abs(($temp_invreal_up / $temp_invterget_up) * 100);
      		$data1['Invs']['Yoyupto'] = abs((($temp_invreal_up-$temp_invreal_lalu_up) / $temp_invreal_lalu_up) * 100);
      	}

      	$data_fnc_rbi        = array();
      	// $data_cash_rbi        = $this->m_cash_flow->get_tabeldata($comp, $date, $datea, $cat, $limit, $periode);
      	$data_fnc_rbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '16 AND 120', 'selected');
      	$data_fnc_tbi        = array();
      	$data_fnc_tbi        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '16 AND 120', 'selected');
      	$data_fnc_rlbi       = array();
      	$data_fnc_rlbi       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '16 AND 120', 'selected');
      	$data_fnc_rbi_up        = array();
      	$data_fnc_rbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'ACT', '16 AND 120', 'upto');
      	$data_fnc_tbi_up        = array();
      	$data_fnc_tbi_up        = $this->m_cash_flow->get_tabeldata($company, $date, $datea, 'BUD', '16 AND 120', 'upto');
      	$data_fnc_rlbi_up       = array();
      	$data_fnc_rlbi_up       = $this->m_cash_flow->get_tabeldata($company, $dateprev, $dateprevly, 'ACT', '16 AND 120', 'upto');    	
    	

      	$temp_fncreal = (float) $data_fnc_rbi->JML / 1000000000;
    	$temp_fncterget = (float) $data_fnc_tbi->JML / 1000000000;
    	$temp_fncreal_lalu = (float) $data_fnc_rlbi->JML / 1000000000;
      	$data1['Fnc']['Real Ini'] = $temp_fncreal;
      	$data1['Fnc']['Target Ini'] = $temp_fncterget;
      	$data1['Fnc']['Real Lalu Ini'] = $temp_fncreal_lalu;
      	if($temp_fncreal == 0 || $temp_fncterget == 0 || $temp_fncreal_lalu == 0){
      		$data1['Fnc']['Persen'] = 0;
      		$data1['Fnc']['Yoy'] = 0;
      	}else{
      		$data1['Fnc']['Persen'] = abs(($temp_fncreal / $temp_fncterget) * 100);
      		$data1['Fnc']['Yoy'] = abs((($temp_fncreal-$temp_fncreal_lalu) / $temp_fncreal_lalu) * 100);
      	}

      	$temp_fncreal_up = (float) $data_fnc_rbi_up->JML / 1000000000;
    	$temp_fncterget_up = (float) $data_fnc_tbi_up->JML / 1000000000;
    	$temp_fncreal_lalu_up = (float) $data_fnc_rlbi_up->JML / 1000000000;
      	$data1['Fnc']['Real Up To'] = $temp_fncreal_up;
      	$data1['Fnc']['Target Up To'] = $temp_fncterget_up;
      	$data1['Fnc']['Real Lalu Up To'] = $temp_fncreal_lalu_up;
      	if($temp_fncreal_up == 0 || $temp_fncterget_up == 0 || $temp_fncreal_lalu_up == 0){
      		$data1['Fnc']['Persenupto'] = 0;
      		$data1['Fnc']['Yoyupto'] = 0;
      	}else{
      		$data1['Fnc']['Persenupto'] = abs(($temp_fncreal_up / $temp_fncterget_up) * 100);
      		$data1['Fnc']['Yoyupto'] = abs((($temp_fncreal_up-$temp_fncreal_lalu_up) / $temp_fncreal_lalu_up) * 100);
      	}
      	
      
    	

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
