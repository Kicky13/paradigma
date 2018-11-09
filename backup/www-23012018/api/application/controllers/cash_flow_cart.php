<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class cash_flow_cart extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cash_flow_cart');
    }
 
    public function get_data_cfcart()
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
      	$data1 			= array();

		$data_cash_r   = array();
		$data_cash_t   = array();
		$data_cash_rl   = array();

      	for($i=1; $i <= $month; $i++){
      		$bulan 			= '0'.$i;
      		$nbulan 		= substr($bulan,-2);
      		$tgl			= $year.'.'.$nbulan;
      		$data_cash_t  	= $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'BUD', '1 AND 120');
      		$data1['Target'][$tgl]               = (float) $data_cash_t->JML;
      	}

      	for($i=1; $i <= $month; $i++){
      		$bulan 			= '0'.$i;
      		$nbulan 		= substr($bulan,-2);
      		$tgl 			= $year.'.'.$nbulan;
      		$data_cash_r  	= $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
      		$data1['Actual'][$tgl]               = (float) $data_cash_r->JML;
      	}

      	for($i=1; $i <= $month; $i++){
      		$bulan 			= '0'.$i;
      		$nbulan 		= substr($bulan,-2);
      		$tgl 			= $last_year.'.'.$nbulan;

      		$data1['Actually'][$tgl]               = (float) 0;
      		
      		// $data_cash_t  	= $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
      		// if ($data_cash_rl->JML == '' || empty($data_cash_rl->JML) || $data_cash_rl->JML == null){
        //     	$data1['Actually'][$tgl]               = (float) 0;
        // 	}else{
        // 		$data1['Actually'][$tgl]               = (float) $data_cash_rl->JML;
        // 	}
      		
      	}
      	// echo $date;
      	// echo $datea;
      	// echo $dateprev;
      	// echo $dateprevly;
  
      echo json_encode($data1);
    }



    public function get_data_ofcart()
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
       //     $last_month = '12';
       //     $year_of_last_year =  $year_of_last_month -1;
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
        $data1      = array();

    $data_cash_r   = array();
    $data_cash_t   = array();
    $data_cash_rl   = array();

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_t    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'BUD', '1 AND 7');
          $data1['Target'][$tgl]               = (float) $data_cash_t->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_r    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 7');
          $data1['Actual'][$tgl]               = (float) $data_cash_r->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $last_year.'.'.$nbulan;

          $data1['Actually'][$tgl]               = (float) 0;
          
          // $data_cash_t   = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
          // if ($data_cash_rl->JML == '' || empty($data_cash_rl->JML) || $data_cash_rl->JML == null){
        //      $data1['Actually'][$tgl]               = (float) 0;
        //  }else{
        //    $data1['Actually'][$tgl]               = (float) $data_cash_rl->JML;
        //  }
          
        }
        // echo $date;
        // echo $datea;
        // echo $dateprev;
        // echo $dateprevly;
  
      echo json_encode($data1);
    }

    public function get_data_ifcart()
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
       //     $last_month = '12';
       //     $year_of_last_year =  $year_of_last_month -1;
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
        $data1      = array();

    $data_cash_r   = array();
    $data_cash_t   = array();
    $data_cash_rl   = array();

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_t    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'BUD', '11 AND 15');
          $data1['Target'][$tgl]               = (float) $data_cash_t->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_r    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 15');
          $data1['Actual'][$tgl]               = (float) $data_cash_r->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $last_year.'.'.$nbulan;

          $data1['Actually'][$tgl]               = (float) 0;
          
          // $data_cash_t   = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
          // if ($data_cash_rl->JML == '' || empty($data_cash_rl->JML) || $data_cash_rl->JML == null){
        //      $data1['Actually'][$tgl]               = (float) 0;
        //  }else{
        //    $data1['Actually'][$tgl]               = (float) $data_cash_rl->JML;
        //  }
          
        }
        // echo $date;
        // echo $datea;
        // echo $dateprev;
        // echo $dateprevly;
  
      echo json_encode($data1);
    }

    public function get_data_ffcart()
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
       //     $last_month = '12';
       //     $year_of_last_year =  $year_of_last_month -1;
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
        $data1      = array();

    $data_cash_r   = array();
    $data_cash_t   = array();
    $data_cash_rl   = array();

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_t    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'BUD', '16 AND 120');
          $data1['Target'][$tgl]               = (float) $data_cash_t->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_r    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '16 AND 120');
          $data1['Actual'][$tgl]               = (float) $data_cash_r->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $last_year.'.'.$nbulan;

          $data1['Actually'][$tgl]               = (float) 0;
          
          // $data_cash_t   = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
          // if ($data_cash_rl->JML == '' || empty($data_cash_rl->JML) || $data_cash_rl->JML == null){
        //      $data1['Actually'][$tgl]               = (float) 0;
        //  }else{
        //    $data1['Actually'][$tgl]               = (float) $data_cash_rl->JML;
        //  }
          
        }
        // echo $date;
        // echo $datea;
        // echo $dateprev;
        // echo $dateprevly;
  
      echo json_encode($data1);
    }

    public function get_data_oprcart()
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
       //     $last_month = '12';
       //     $year_of_last_year =  $year_of_last_month -1;
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
        $data1      = array();

    $data_cash_i  = array();
    $data_cash_e   = array();
    $data_cash_c   = array();

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_i    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 2');
          $data1['Income'][$tgl]               = (float) $data_cash_i->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_e    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '6 AND 7');
          $data1['Expense'][$tgl]               = (float) $data_cash_e->JML;
        }

        for($i=1; $i <= $month; $i++){
          $bulan      = '0'.$i;
          $nbulan     = substr($bulan,-2);
          $tgl      = $year.'.'.$nbulan;
          $data_cash_c    = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 7');
          $data1['COH'][$tgl]               = (float) $data_cash_c->JML;
          
          // $data_cash_t   = $this->m_cash_flow_cart->get_tabeldata($company, $tgl, 'ACT', '1 AND 120');
          // if ($data_cash_rl->JML == '' || empty($data_cash_rl->JML) || $data_cash_rl->JML == null){
        //      $data1['Actually'][$tgl]               = (float) 0;
        //  }else{
        //    $data1['Actually'][$tgl]               = (float) $data_cash_rl->JML;
        //  }
          
        }
        // echo $date;
        // echo $datea;
        // echo $dateprev;
        // echo $dateprevly;
  
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
