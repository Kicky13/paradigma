<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class performance extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mf_performance_mv');
        $this->load->model('mf_performance');
        $this->load->model('m_cost_structure');
        //$this->load->helper('text');
    }
    function index(){
        $parameter = explode(".",(empty($_GET['bulan']) ? date('Y.m') : $_GET['bulan']));
        $filter['tahun'] = $parameter[0];
        $filter['bulan'] = $parameter[1];
        $filter['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);
        $paramCompany = $filter['company'];
        $param=array(
            "company"=>trim($paramCompany),
            "tahun"=>trim($filter['tahun']),
            "bulan"=>trim($filter['bulan']),
            "now"=>trim($filter['tahun'].'.'.$filter['bulan']),
            "yesterday"=>trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1)),
            "last_year"=>trim(($filter['tahun']-1).'.'.$filter['bulan']),
            "prev_month"=>trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1)),
            "last_year_prev_month"=>trim(($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1))
        );
       $paramPembanding = array(
           "company"=>$paramCompany,
           "now"=>($filter['tahun']-1).'.'.$filter['bulan'],
           "yesterday"=> ($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1)
       );

        $perf = $this->test($filter['bulan'], $filter['tahun'], $filter['company']);
       
        // $perf = $this->mf_performance->mget_volume($param);

        $real_price = $this->division($perf->BRUTO_ACTUAL,$perf->VOL_ACTUAL);
        $real_price_prev = $this->division($perf->BRUTO_ACTUAL_LYEAR,$perf->VOL_ACTUAL_LYEAR);
        $rkap_price = $this->division($perf->BRUTO_TARGET,$perf->VOL_TARGET); 
        $persen_price = $this->division($real_price,$rkap_price);
        $variance_price = $real_price - $rkap_price;
        $yonyear_price = $this->division($real_price - $real_price_prev,$real_price_prev)*100;
        $real_price_up = $this->division($perf->BRUTO_ACTUAL_UP,$perf->VOL_ACTUAL_UP);
        $real_price_prev_up = $this->division($perf->BRUTO_ACTUAL_LYEAR_UP,$perf->VOL_ACTUAL_LYEAR_UP);
        $rkap_price_up = $this->division($perf->BRUTO_TARGET_UP,$perf->VOL_TARGET_UP);
        $persen_price_up = $this->division($real_price_up,$rkap_price_up);
        $variance_price_up = $real_price_up - $rkap_price_up;
        $yonyear_price_up = $this->division($real_price_up - $real_price_prev_up,$real_price_prev_up)*100;    

         echo json_encode(
                 array(
                       "real_ebit"=>floatval($perf->EBIT_ACTUAL),
                       "real_ebit_prev"=>floatval($perf->EBIT_ACTUAL_LYEAR),
                       "persen_ebit"=>floatval($this->division($perf->EBIT_ACTUAL,$perf->EBIT_TARGET)),
                       "variance_ebit"=>floatval($perf->EBIT_ACTUAL) - floatval($perf->EBIT_TARGET),
                       "rkap_ebit"=>floatval($perf->EBIT_TARGET),
                       "yonyear_ebit"=>($this->division(floatval($perf->EBIT_ACTUAL) - floatval($perf->EBIT_ACTUAL_LYEAR),floatval($perf->EBIT_ACTUAL_LYEAR))*100),
                       "real_ebit_up"=>floatval($perf->EBIT_ACTUAL_UP),
                       "real_ebit_prev_up"=>floatval($perf->EBIT_ACTUAL_LYEAR_UP),
                       "persen_ebit_up"=>floatval($this->division($perf->EBIT_ACTUAL_UP,$perf->EBIT_TARGET_UP)*100),
                       "variance_ebit_up"=>floatval($perf->EBIT_ACTUAL_UP) - floatval($perf->EBIT_TARGET_UP),
                       "rkap_ebit_up"=>floatval($perf->EBIT_TARGET_UP),
                       "yonyear_ebit_up"=>($this->division(floatval($perf->EBIT_ACTUAL_UP) - floatval($perf->EBIT_ACTUAL_LYEAR_UP),floatval($perf->EBIT_ACTUAL_LYEAR_UP))*100),
                       "real_vol"=>floatval($perf->VOL_ACTUAL),
                       "real_vol_prev"=>floatval($perf->VOL_ACTUAL_LYEAR),
                       "persen_vol"=>floatval($this->division($perf->VOL_ACTUAL,$perf->VOL_TARGET)*100),
                       "variance_vol"=>floatval($perf->VOL_ACTUAL) - floatval($perf->VOL_TARGET),
                       "rkap_vol"=>floatval($perf->VOL_TARGET),
                       "yonyear_vol"=>($this->division(floatval($perf->VOL_ACTUAL) - floatval($perf->VOL_ACTUAL_LYEAR),floatval($perf->VOL_ACTUAL_LYEAR))*100),
                       "real_vol_up"=>floatval($perf->VOL_ACTUAL_UP),
                       "real_vol_prev_up"=>floatval($perf->VOL_ACTUAL_LYEAR_UP),
                       "persen_vol_up"=>floatval($this->division($perf->VOL_ACTUAL_UP,$perf->VOL_TARGET_UP)*100),
                       "variance_vol_up"=>floatval($perf->VOL_ACTUAL_UP) - floatval($perf->VOL_TARGET_UP),
                       "rkap_vol_up"=>floatval($perf->VOL_TARGET_UP),
                       "yonyear_vol_up"=>($this->division(floatval($perf->VOL_ACTUAL_UP) - floatval($perf->VOL_ACTUAL_LYEAR_UP),floatval($perf->VOL_ACTUAL_LYEAR_UP))*100),
                       "real_price"=>floatval($real_price),
                       "real_price_prev"=>floatval($real_price_prev),
                       "persen_price"=>floatval($persen_price),
                       "variance_price"=>floatval($variance_price),
                       "rkap_price"=>floatval($rkap_price),
                       "yonyear_price"=>($yonyear_price),
                       "real_price_up"=>floatval($real_price_up),
                       "real_price_prev_up"=>floatval($real_price_prev_up),
                       "persen_price_up"=>floatval($persen_price_up),
                       "variance_price_up"=>floatval($variance_price_up),
                       "rkap_price_up"=>floatval($rkap_price_up),
                       "yonyear_price_up"=>($yonyear_price_up),
                       "real_cost"=>floatval($perf->COST_ACTUAL),
                       "real_cost_prev"=>floatval($perf->COST_ACTUAL_LYEAR),
                       "persen_cost"=>floatval($this->division($perf->COST_ACTUAL,$perf->COST_TARGET)),
                       "variance_cost"=>floatval($perf->COST_ACTUAL) - floatval($perf->COST_TARGET),
                       "rkap_cost"=>floatval($perf->COST_TARGET),
                       "yonyear_cost"=>($this->division(floatval($perf->COST_ACTUAL) - floatval($perf->COST_ACTUAL_LYEAR),floatval($perf->COST_ACTUAL_LYEAR))*100),
                       "real_cost_up"=>floatval($perf->COST_ACTUAL_UP),
                       "real_cost_prev_up"=>floatval($perf->COST_ACTUAL_LYEAR_UP),
                       "persen_cost_up"=>floatval($this->division($perf->COST_ACTUAL_UP,$perf->COST_TARGET_UP)),
                       "variance_cost_up"=>floatval($perf->COST_ACTUAL_UP) - floatval($perf->COST_TARGET_UP),
                       "rkap_cost_up"=>floatval($perf->COST_TARGET_UP),
                       "yonyear_cost_up"=>($this->division(floatval($perf->COST_ACTUAL_UP) - floatval($perf->COST_ACTUAL_LYEAR_UP),floatval($perf->COST_ACTUAL_LYEAR_UP))*100),
                       "real_rev"=>floatval($perf->LABA_BRUTO_ACTUAL),
                       "rkap_rev"=>floatval($perf->LABA_BRUTO_TARGET),
                       "real_net"=>floatval($perf->LABA_NETTO_ACTUAL),
                       "rkap_net"=>floatval($perf->LABA_NETTO_TARGET),
                       "real_rev_up"=>floatval($perf->LABA_BRUTO_ACTUAL_UP),
                       "rkap_rev_up"=>floatval($perf->LABA_BRUTO_TARGET_UP),
                       "real_net_up"=>floatval($perf->LABA_NETTO_ACTUAL_UP),
                       "rkap_net_up"=>floatval($perf->LABA_NETTO_TARGET_UP)
                     )
                 );
    }
    function mix($chart=null){
        $parameter = explode(".",(empty($_GET['bulan']) ? date('Y.m') : $_GET['bulan']));
        $filter['tahun'] = $parameter[0];
        $filter['bulan'] = $parameter[1];
        $filter['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

        $date_now = trim($filter['tahun'].'.'.$filter['bulan']);
        $yesterday = trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1));
        $last_year = trim(($filter['tahun']-1).'.'.$filter['bulan']);
        $prev_month = trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1));
        $last_year_prev_month = trim(($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1));

        $paramCompany = $this->paramCompany($filter['company'], $date_now);
        $paramLast = $this->paramCompany($filter['company'], $last_year);
        // $paramCompany = $filter['company'];
        $param=array(
            "company"=>trim($paramCompany),
            "tahun"=>trim($filter['tahun']),
            "bulan"=>trim($filter['bulan']),
            "now"=> $date_now,
            "yesterday"=> $yesterday,
            "com_last_year" => $paramLast,
            "last_year"=> $last_year,
            "prev_month"=>$prev_month,
            "last_year_prev_month"=> $last_year_prev_month
        );

        $date_pembanding = ($filter['tahun']-1).'.'.$filter['bulan'];
        $yesterday_pembanding = ($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1);
       $paramPembanding = array(
           "company"=>$paramCompany,
           "now"=> $date_pembanding,
           "yesterday"=> $yesterday
       );

        if ($filter['company']=='ALL'||$filter['company']=='SMI'||$filter['company']=='smi') {
          # code...
          $result = $this->smi();

        }else{

            $perf = $this->test($filter['bulan'], $filter['tahun'], $filter['company']);
            $resbruto= $this->mf_performance_mv->mget_bruto($param);
            $resebi = $this->mf_performance_mv->mget_ebitda($param);
            $rescost = $this->mf_performance_mv->mget_cost($param);
            $resrev = $this->mf_performance_mv->mget_revenue($param);
        
            // $perf = $this->mf_performance->mget_volume($param);

            $real_price = $this->division($resbruto->BRUTO_ACTUAL,$perf->VOL_ACTUAL);
            $real_price_prev = $this->division($resbruto->BRUTO_ACTUAL_LYEAR,$perf->VOL_ACTUAL_LYEAR);
            $rkap_price = $this->division($resbruto->BRUTO_TARGET,$perf->VOL_TARGET); 
            $persen_price = $this->division($real_price,$rkap_price);
            $variance_price = $real_price - $rkap_price;
            $yonyear_price = $this->division($real_price - $real_price_prev,$real_price_prev)*100;
            $real_price_up = $this->division($resbruto->BRUTO_ACTUAL_UP,$perf->VOL_ACTUAL_UP);
            $real_price_prev_up = $this->division($resbruto->BRUTO_ACTUAL_LYEAR_UP,$perf->VOL_ACTUAL_LYEAR_UP);
            $rkap_price_up = $this->division($resbruto->BRUTO_TARGET_UP,$perf->VOL_TARGET_UP);
            $persen_price_up = $this->division($real_price_up,$rkap_price_up);
            $variance_price_up = $real_price_up - $rkap_price_up;
            $yonyear_price_up = $this->division($real_price_up - $real_price_prev_up,$real_price_prev_up)*100;    

            $result =
                     array(
                           "real_ebit"=>floatval($resebi->EBIT_ACTUAL),
                           "real_ebit_prev"=>floatval($resebi->EBIT_ACTUAL_LYEAR),
                           "persen_ebit"=>floatval($this->division($resebi->EBIT_ACTUAL,$resebi->EBIT_TARGET)*100),
                           "variance_ebit"=>floatval($resebi->EBIT_ACTUAL) - floatval($resebi->EBIT_TARGET),
                           "rkap_ebit"=>floatval($resebi->EBIT_TARGET),
                           "yonyear_ebit"=>($this->division(floatval($resebi->EBIT_ACTUAL) - floatval($resebi->EBIT_ACTUAL_LYEAR),floatval($resebi->EBIT_ACTUAL_LYEAR))*100),
                           "real_ebit_up"=>floatval($resebi->EBIT_ACTUAL_UP),
                           "real_ebit_prev_up"=>floatval($resebi->EBIT_ACTUAL_LYEAR_UP),
                           "persen_ebit_up"=>floatval($this->division($resebi->EBIT_ACTUAL_UP,$resebi->EBIT_TARGET_UP)*100),
                           "variance_ebit_up"=>floatval($resebi->EBIT_ACTUAL_UP) - floatval($resebi->EBIT_TARGET_UP),
                           "rkap_ebit_up"=>floatval($resebi->EBIT_TARGET_UP),
                           "yonyear_ebit_up"=>($this->division(floatval($resebi->EBIT_ACTUAL_UP) - floatval($resebi->EBIT_ACTUAL_LYEAR_UP),floatval($resebi->EBIT_ACTUAL_LYEAR_UP))*100),
                           "real_vol"=>floatval($perf->VOL_ACTUAL),
                           "real_vol_prev"=>floatval($perf->VOL_ACTUAL_LYEAR),
                           "persen_vol"=>floatval($this->division($perf->VOL_ACTUAL,$perf->VOL_TARGET)*100),
                           "variance_vol"=>floatval($perf->VOL_ACTUAL) - floatval($perf->VOL_TARGET),
                           "rkap_vol"=>floatval($perf->VOL_TARGET),
                           "yonyear_vol"=>($this->division(floatval($perf->VOL_ACTUAL) - floatval($perf->VOL_ACTUAL_LYEAR),floatval($perf->VOL_ACTUAL_LYEAR))*100),
                           "real_vol_up"=>floatval($perf->VOL_ACTUAL_UP),
                           "real_vol_prev_up"=>floatval($perf->VOL_ACTUAL_LYEAR_UP),
                           "persen_vol_up"=>floatval($this->division($perf->VOL_ACTUAL_UP,$perf->VOL_TARGET_UP)*100),
                           "variance_vol_up"=>floatval($perf->VOL_ACTUAL_UP) - floatval($perf->VOL_TARGET_UP),
                           "rkap_vol_up"=>floatval($perf->VOL_TARGET_UP),
                           "yonyear_vol_up"=>($this->division(floatval($perf->VOL_ACTUAL_UP) - floatval($perf->VOL_ACTUAL_LYEAR_UP),floatval($perf->VOL_ACTUAL_LYEAR_UP))*100),
                           "real_price"=>floatval($real_price),
                           "real_price_prev"=>floatval($real_price_prev),
                           "persen_price"=>floatval($persen_price),
                           "variance_price"=>floatval($variance_price),
                           "rkap_price"=>floatval($rkap_price),
                           "yonyear_price"=>($yonyear_price),
                           "real_price_up"=>floatval($real_price_up),
                           "real_price_prev_up"=>floatval($real_price_prev_up),
                           "persen_price_up"=>floatval($persen_price_up),
                           "variance_price_up"=>floatval($variance_price_up),
                           "rkap_price_up"=>floatval($rkap_price_up),
                           "yonyear_price_up"=>($yonyear_price_up),
                           "real_cost"=>floatval($perf->COST_ACTUAL),
                           "real_cost_prev"=>floatval($perf->COST_ACTUAL_LYEAR),
                           "persen_cost"=>floatval($this->division($perf->COST_ACTUAL,$perf->COST_TARGET)*100),
                           "variance_cost"=>floatval($perf->COST_ACTUAL) - floatval($perf->COST_TARGET),
                           "rkap_cost"=>floatval($perf->COST_TARGET),
                           "yonyear_cost"=>($this->division(floatval($perf->COST_ACTUAL) - floatval($perf->COST_ACTUAL_LYEAR),floatval($perf->COST_ACTUAL_LYEAR))*100),
                           "real_cost_up"=>floatval($perf->COST_ACTUAL_UP),
                           "real_cost_prev_up"=>floatval($perf->COST_ACTUAL_LYEAR_UP),
                           "persen_cost_up"=>floatval($this->division($perf->COST_ACTUAL_UP,$perf->COST_TARGET_UP)*100),
                           "variance_cost_up"=>floatval($perf->COST_ACTUAL_UP) - floatval($perf->COST_TARGET_UP),
                           "rkap_cost_up"=>floatval($perf->COST_TARGET_UP),
                           "yonyear_cost_up"=>($this->division(floatval($perf->COST_ACTUAL_UP) - floatval($perf->COST_ACTUAL_LYEAR_UP),floatval($perf->COST_ACTUAL_LYEAR_UP))*100),
                           "real_rev"=>floatval($resrev->LABA_BRUTO_ACTUAL),
                           "rkap_rev"=>floatval($resrev->LABA_BRUTO_TARGET),
                           "persen_rev" => floatval($this->division($resrev->LABA_BRUTO_ACTUAL,$resrev->LABA_BRUTO_TARGET)*100),
                           "real_net"=>floatval($resrev->LABA_NETTO_ACTUAL),
                           "rkap_net"=>floatval($resrev->LABA_NETTO_TARGET),
                           "persen_net" => floatval($this->division($resrev->LABA_NETTO_ACTUAL,$resrev->LABA_NETTO_TARGET)*100),
                           "real_rev_up"=>floatval($resrev->LABA_BRUTO_ACTUAL_UP),
                           "rkap_rev_up"=>floatval($resrev->LABA_BRUTO_TARGET_UP),
                           "persen_rev_up" => floatval($this->division($resrev->LABA_BRUTO_ACTUAL_UP,$resrev->LABA_BRUTO_TARGET_UP)*100),
                           "real_net_up"=>floatval($resrev->LABA_NETTO_ACTUAL_UP),
                           "rkap_net_up"=>floatval($resrev->LABA_NETTO_TARGET_UP),
                            "persen_net_up" => floatval($this->division($resrev->LABA_NETTO_ACTUAL_UP,$resrev->LABA_NETTO_TARGET_UP)*100)
                         );

            if ($chart!=null) {
              $monthly=$this->date_between($date_now);

              $part = explode(',', $monthly);
              foreach($part as $date){
                $act[str_replace("'", "", $date)] = $this->cogs_structure($filter['company'], 'ACT', $date);
                $bud[str_replace("'", "", $date)] = $this->cogs_structure($filter['company'], 'BUD', $date);

              }

              $result['chart']['actual'] = $act;
              $result['chart']['target'] = $bud;

              
            }
                     
        }

        echo json_encode($result);
    }
    function smi(){
        $parameter = explode(".",(empty($_GET['bulan']) ? date('Y.m') : $_GET['bulan']));
        $filter['tahun'] = $parameter[0];
        $filter['bulan'] = $parameter[1];
        // $filter['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);

        $date_now = trim($filter['tahun'].'.'.$filter['bulan']);
        $yesterday = trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1));
        $last_year = trim(($filter['tahun']-1).'.'.$filter['bulan']);
        $prev_month = trim($filter['tahun'].'.'.sprintf("%'.02d\n", $filter['bulan']-1));
        $last_year_prev_month = trim(($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1));

        $opco = array('7000', '4000', '3000', '6000');

        $real_price = 0;
        $real_price_prev = 0;
        $rkap_price = 0;
        $persen_price = 0;
        $variance_price = 0;
        $yonyear_price = 0;
        $real_price_up = 0;
        $real_price_prev_up = 0;
        $rkap_price_up = 0;
        $persen_price_up = 0;
        $variance_price_up = 0;
        $yonyear_price_up = 0;

        $temp = $this->performanceInit();

        foreach ($opco as $key) {
          # code...
            // echo "$key";

            $paramCompany = $this->paramCompany($key, $date_now);
            $paramLast = $this->paramCompany($key, $last_year);
            // $paramCompany = $key;
            $param=array(
                "company"=>trim($paramCompany),
                "tahun"=>trim($filter['tahun']),
                "bulan"=>trim($filter['bulan']),
                "now"=> $date_now,
                "yesterday"=> $yesterday,
                "com_last_year" => $paramLast,
                "last_year"=> $last_year,
                "prev_month"=>$prev_month,
                "last_year_prev_month"=> $last_year_prev_month
            );

            $date_pembanding = ($filter['tahun']-1).'.'.$filter['bulan'];
            $yesterday_pembanding = ($filter['tahun']-1).'.'.sprintf("%'.02d\n", $filter['bulan']-1);
             $paramPembanding = array(
                 "company"=>$paramCompany,
                 "now"=> $date_pembanding,
                 "yesterday"=> $yesterday
             );

            $perf = $this->test($filter['bulan'], $filter['tahun'], $key);
            $resbruto= $this->mf_performance_mv->mget_bruto($param);
            $resebi = $this->mf_performance_mv->mget_ebitda($param);
            $rescost = $this->mf_performance_mv->mget_cost($param);
            $resrev = $this->mf_performance_mv->mget_revenue($param);
        
            // $perf = $this->mf_performance->mget_volume($param);
            // 
            

            $real_price += $this->division($resbruto->BRUTO_ACTUAL,$perf->VOL_ACTUAL);
            $real_price_prev += $this->division($resbruto->BRUTO_ACTUAL_LYEAR,$perf->VOL_ACTUAL_LYEAR);
            $rkap_price += $this->division($resbruto->BRUTO_TARGET,$perf->VOL_TARGET); 
            $variance_price += $real_price - $rkap_price;
            $real_price_up += $this->division($resbruto->BRUTO_ACTUAL_UP,$perf->VOL_ACTUAL_UP);
            $real_price_prev_up += $this->division($resbruto->BRUTO_ACTUAL_LYEAR_UP,$perf->VOL_ACTUAL_LYEAR_UP);
            $rkap_price_up += $this->division($resbruto->BRUTO_TARGET_UP,$perf->VOL_TARGET_UP);
            $variance_price_up += $real_price_up - $rkap_price_up;


             $temp["real_ebit"]+=floatval($resebi->EBIT_ACTUAL);
             $temp["real_ebit_prev"]+=floatval($resebi->EBIT_ACTUAL_LYEAR);
             $temp["variance_ebit"]+=floatval($resebi->EBIT_ACTUAL) - floatval($resebi->EBIT_TARGET);
             $temp["rkap_ebit"]+=floatval($resebi->EBIT_TARGET);
             $temp["real_ebit_up"]+=floatval($resebi->EBIT_ACTUAL_UP);
             $temp["real_ebit_prev_up"]+=floatval($resebi->EBIT_ACTUAL_LYEAR_UP);
             $temp["variance_ebit_up"]+=floatval($resebi->EBIT_ACTUAL_UP) - floatval($resebi->EBIT_TARGET_UP);
             $temp["rkap_ebit_up"]+=floatval($resebi->EBIT_TARGET_UP);
             $temp["real_vol"]+=floatval($perf->VOL_ACTUAL);
             $temp["real_vol_prev"]+=floatval($perf->VOL_ACTUAL_LYEAR);
             $temp["variance_vol"]+=floatval($perf->VOL_ACTUAL) - floatval($perf->VOL_TARGET);
             $temp["rkap_vol"]+=floatval($perf->VOL_TARGET);
             $temp["real_vol_up"]+=floatval($perf->VOL_ACTUAL_UP);
             $temp["real_vol_prev_up"]+=floatval($perf->VOL_ACTUAL_LYEAR_UP);
             $temp["variance_vol_up"]+=floatval($perf->VOL_ACTUAL_UP) - floatval($perf->VOL_TARGET_UP);
             $temp["rkap_vol_up"]+=floatval($perf->VOL_TARGET_UP);
             $temp["real_price"]+=floatval($real_price);
             $temp["real_price_prev"]+=floatval($real_price_prev);
             $temp["variance_price"]+=floatval($variance_price);
             $temp["rkap_price"]+=floatval($rkap_price);
             $temp["real_price_up"]+=floatval($real_price_up);
             $temp["real_price_prev_up"]+=floatval($real_price_prev_up);
             $temp["variance_price_up"]+=floatval($variance_price_up);
             $temp["rkap_price_up"]+=floatval($rkap_price_up);
             $temp["real_cost"]+=floatval($perf->COST_ACTUAL);
             $temp["real_cost_prev"]+=floatval($perf->COST_ACTUAL_LYEAR);
             $temp["variance_cost"]+=floatval($perf->COST_ACTUAL) - floatval($perf->COST_TARGET);
             $temp["rkap_cost"]+=floatval($perf->COST_TARGET);
             $temp["real_cost_up"]+=floatval($perf->COST_ACTUAL_UP);
             $temp["real_cost_prev_up"]+=floatval($perf->COST_ACTUAL_LYEAR_UP);
             $temp["variance_cost_up"]+=floatval($perf->COST_ACTUAL_UP) - floatval($perf->COST_TARGET_UP);
             $temp["rkap_cost_up"]+=floatval($perf->COST_TARGET_UP);
             $temp["real_rev"]+=floatval($resrev->LABA_BRUTO_ACTUAL);
             $temp["rkap_rev"]+=floatval($resrev->LABA_BRUTO_TARGET);
             $temp["real_net"]+=floatval($resrev->LABA_NETTO_ACTUAL);
             $temp["rkap_net"]+=floatval($resrev->LABA_NETTO_TARGET);
             $temp["real_rev_up"]+=floatval($resrev->LABA_BRUTO_ACTUAL_UP);
             $temp["rkap_rev_up"]+=floatval($resrev->LABA_BRUTO_TARGET_UP);
             $temp["real_net_up"]+=floatval($resrev->LABA_NETTO_ACTUAL_UP);
             $temp["rkap_net_up"]+=floatval($resrev->LABA_NETTO_TARGET_UP);

          }

          $persen_price = $this->division($temp['real_price'],$temp['rkap_price']);
          $persen_price_up = $this->division($temp['real_price_up'],$temp['rkap_price_up']);
          $yonyear_price = $this->division($temp['real_price'] - $temp['real_price_prev'],$temp['real_price_prev'])*100;
          $yonyear_price_up = $this->division($temp['real_price_up'] - $temp['real_price_prev_up'],$temp['real_price_prev_up'])*100;    


           $temp["persen_ebit"]=floatval($this->division($temp['real_ebit'],$temp['rkap_ebit'])*100);
           $temp["yonyear_ebit"]=($this->division(floatval($temp['real_ebit']) - floatval($temp['real_ebit_prev']),floatval($temp['real_ebit_prev']))*100);
           $temp["persen_ebit_up"]=floatval($this->division($temp['real_ebit_up'],$temp['rkap_ebit_up'])*100);
           $temp["yonyear_ebit_up"]=($this->division(floatval($temp['real_ebit_up']) - floatval($temp['real_ebit_prev_up']),floatval($temp['real_ebit_prev_up']))*100);
           $temp["persen_vol"]=floatval($this->division($temp['real_vol'],$temp['rkap_vol'])*100);
           $temp["yonyear_vol"]=($this->division(floatval($temp['real_vol']) - floatval($temp['real_vol_prev']),floatval($temp['real_vol_prev']))*100);
           $temp["persen_vol_up"]=floatval($this->division($temp['real_vol_up'],$temp['rkap_vol_up'])*100);
           $temp["yonyear_vol_up"]=($this->division(floatval($temp['real_vol_up']) - floatval($temp['real_vol_prev_up']),floatval($temp['real_vol_prev_up']))*100);
           $temp["persen_price"]=floatval($persen_price);
           $temp["yonyear_price"]=($yonyear_price);
           $temp["persen_price_up"]=floatval($persen_price_up);
           $temp["yonyear_price_up"]=($yonyear_price_up);
           $temp["persen_cost"]=floatval($this->division($temp['real_cost'],$temp['rkap_cost'])*100);
           $temp["yonyear_cost"]=($this->division(floatval($temp['real_cost']) - floatval($temp['real_cost_prev']),floatval($temp['real_cost_prev']))*100);
           $temp["persen_cost_up"]=floatval($this->division($temp['real_cost_up'],$temp['rkap_cost_up'])*100);
           $temp["yonyear_cost_up"]=($this->division(floatval($temp['real_cost_up']) - floatval($temp['real_cost_prev_up']),floatval($temp['real_cost_prev_up']))*100);
           $temp["persen_rev"] = floatval($this->division($temp['real_rev'],$temp['rkap_rev'])*100);
           $temp["persen_net"] = floatval($this->division($temp['real_net'],$temp['rkap_net'])*100);
           $temp["persen_rev_up"] = floatval($this->division($temp['real_rev_up'],$temp['rkap_rev_up'])*100);
           $temp["persen_net_up"] = floatval($this->division($temp['real_net_up'],$temp['rkap_net_up'])*100);


          return $temp;
                  
    }

     //function ratio(){
    public function test($bulan = null, $tahun = null, $opco = '7000'){
      //   $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      // $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($bulan) ? date('m') : $bulan);
      $year = (empty($tahun) ? date('Y') : $tahun);
      $com = (empty($opco) ? '' : $opco);
      $last_year = ($year-1);
      $date = "$year.$month";

      $target = $this->get_data($month, $year, $com, 'BUD');
      $actual = $this->get_data($month, $year, $com, 'ACT');
      $actual_last_year = $this->get_data($month, $last_year, $com, 'ACT');
      $target_upto = $this->get_upto($month, $year, $com, 'BUD');
      $actual_upto = $this->get_upto($month, $year, $com, 'ACT');
      $actual_ly_upto = $this->get_upto($month, $last_year, $com, 'ACT');

      $ebitda_target = $target['DEP']+( $target['HPB']+$target['OA']+$target['BPP']+$target['BUA']+$target['BPE']);
      $ebitda_actual = $actual['DEP']+( $actual['HPB']+$actual['OA']+$actual['BPP']+$actual['BUA']+$actual['BPE']);
      $ebitda_actual_last_year = $actual_last_year['DEP']+( $actual_last_year['HPB']+$actual_last_year['OA']+$actual_last_year['BPP']+$actual_last_year['BUA']+$actual_last_year['BPE']);

      $ebitda_target_upto = $target_upto['DEP']+( $target_upto['HPB']+$target_upto['OA']+$target_upto['BPP']+$target_upto['BUA']+$target_upto['BPE']);

      $ebitda_actual_upto = $actual_upto['DEP']+( $actual_upto['HPB']+$actual_upto['OA']+$actual_upto['BPP']+$actual_upto['BUA']+$actual_upto['BPE']);

      $ebitda_actual_ly_upto = $actual_ly_upto['DEP']+( $actual_ly_upto['HPB']+$actual_ly_upto['OA']+$actual_ly_upto['BPP']+$actual_ly_upto['BUA']+$actual_ly_upto['BPE']);
      
      //EBITDA
      $array['EBIT_TARGET'] = $ebitda_target;
      $array['EBIT_ACTUAL'] = $ebitda_actual;
      $array['EBIT_ACTUAL_LYEAR'] = $ebitda_actual_last_year;
      $array['EBIT_TARGET_UP'] = $ebitda_target_upto;
      $array['EBIT_ACTUAL_UP'] = $ebitda_actual_upto;
      $array['EBIT_ACTUAL_LYEAR_UP'] = $ebitda_actual_ly_upto;


      //BRUTO
      $array['BRUTO_ACTUAL'] = $actual['HPB'];
      $array['BRUTO_TARGET'] = $target['HPB'];
      $array['BRUTO_ACTUAL_LYEAR'] = $actual_last_year['HPB'];
      $array['BRUTO_ACTUAL_UP'] = $actual_upto['HPB'];
      $array['BRUTO_TARGET_UP'] = $target_upto['HPB'];
      $array['BRUTO_ACTUAL_LYEAR_UP'] = $actual_ly_upto['HPB'];

      //VOLUME
      $array['VOL_ACTUAL'] = $actual['VLP'];
      $array['VOL_TARGET'] = $target['VLP'];
      $array['VOL_ACTUAL_LYEAR'] = $actual_last_year['VLP'];
      $array['VOL_ACTUAL_UP'] = $actual_upto['VLP'];
      $array['VOL_TARGET_UP'] = $target_upto['VLP'];
      $array['VOL_ACTUAL_LYEAR_UP'] = $actual_ly_upto['VLP'];

      //COST
      $date_last = "$last_year.$month";
      $array['COST_ACTUAL'] = $this->get_cost('selected', 'ACT',$opco, $date);
      $array['COST_TARGET'] = $this->get_cost('selected', 'BUD',$opco, $date);
      $array['COST_ACTUAL_LYEAR'] = $this->get_cost('selected', 'ACT',$opco, $date_last);
      $array['COST_ACTUAL_UP'] = $this->get_cost('upto', 'ACT',$opco, $date);
      $array['COST_TARGET_UP'] = $this->get_cost('upto', 'BUD',$opco, $date);
      $array['COST_ACTUAL_LYEAR_UP'] = $this->get_cost('upto', 'ACT',$opco, $date_last);


      //revenue
      $array['LABA_BRUTO_ACTUAL'] = $actual['HPB'];
      $array['LABA_BRUTO_TARGET'] = $target['HPB'];
      $array['LABA_BRUTO_ACTUAL_LYEAR'] = $actual_last_year['HPB'];
      $array['LABA_BRUTO_ACTUAL_UP'] = $actual_upto['HPB'];
      $array['LABA_BRUTO_TARGET_UP'] = $target_upto['HPB'];
      $array['LABA_BRUTO_ACTUAL_LYEAR_UP'] = $actual_ly_upto['HPB'];
       //NETTO
      $array['LABA_NETTO_ACTUAL'] = $actual['HPB'] + $actual['OA'];
      $array['LABA_NETTO_TARGET'] = $target['HPB'] + $target['OA'];
      $array['LABA_NETTO_ACTUAL_LYEAR'] = $actual_last_year['HPB'] + $actual_last_year['OA'];
      $array['LABA_NETTO_ACTUAL_UP'] = $actual_upto['HPB'] + $actual_upto['OA'];
      $array['LABA_NETTO_TARGET_UP'] = $target_upto['HPB'] + $target_upto['OA'];
      $array['LABA_NETTO_ACTUAL_LYEAR_UP'] = $actual_ly_upto['HPB'] + $actual_ly_upto['OA'];


      // echo json_encode($array);
      $obj = (object) $array;

      return $obj;

     

    }

    function trends(){

        $parameter = explode(".",(empty($_GET['bulan']) ? date('Y.m') : $_GET['bulan']));
        $filter['tahun'] = $parameter[0];
        $filter['bulan'] = $parameter[1];
        $date = $filter['tahun'].".".$filter['bulan'];
        $filter['company'] = (empty($_GET['company']) ? 'smi' : $_GET['company']);

        $dateBetween = $this->date_between($date);

        $dateEx = explode(",", $dateBetween);

        $tmpArr = array();

        foreach ($dateEx as $key) {
          # code...
          $key = str_replace("'", "", $key);
          $parDate = explode('.', $key);
          $bulan = $parDate[1];
          $tahun = $parDate[0];

          $result = $this->data_trends($bulan, $tahun, $filter['company']);
          $tmpArr[$key]['penjualan'] = $result->VOL;
          $tmpArr[$key]['ebitda'] = $result->EBIT;
          $tmpArr[$key]['bruto'] = $result->BRUTO;
          $tmpArr[$key]['netto'] = $result->NETTO;

        }

        echo json_encode($tmpArr);



    }

    public function data_trends($bulan = null, $tahun = null, $opco = '7000'){
      //   $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      // $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($bulan) ? date('m') : $bulan);
      $year = (empty($tahun) ? date('Y') : $tahun);
      $com = (empty($opco) ? '' : $opco);
      $last_year = ($year-1);
      $date = "$year.$month";

      $actual = $this->get_data($month, $year, $com, 'ACT');

      $ebitda_actual = $actual['DEP']+( $actual['HPB']+$actual['OA']+$actual['BPP']+$actual['BUA']+$actual['BPE']);



      
      //EBITDA
      $array['EBIT'] = $ebitda_actual;


      //BRUTO
      $array['BRUTO'] = $actual['HPB'];

      //VOLUME
      $array['VOL'] = $actual['VLP'];

      //COST
      //revenue
       //NETTO
      $array['NETTO'] = $actual['HPB'] + $actual['OA'];


      // echo json_encode($array);
      $obj =(object) $array;

      return $obj;

     

    }

    function get_cost($type = null, $category = null, $com = null, $date = null){

        // $com = "7000','2000";
        // $bua = (float)"-118710388160";
        $com_param = $this->paramCompany2($com, $date);
        $cogs = $this->m_cost_structure->get_data_desc($com_param, $date, $category, '10 and 13', '14',$type);
        $cogm   = $this->m_cost_structure->get_data_desc($com_param, $date, $category, '1 and 9', '10',$type);
        $gae        = $this->m_cost_structure->get_data_desc($com_param, $date, $category, '14 and 21', '22',$type);

        $tmp_data_cogm = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);

        $tmp_data_cogs = array('10'=>0,'11'=>0,'12'=>0,'13'=>0, '14'=>0);

        $tmp_data_gae = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0, '22'=>0);

        foreach ($cogs as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);  
         $tmp_data_cogs[$ind] = $x->JML; 
        }
        foreach ($cogm as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm[$ind] = $x->JML; 
        }
        foreach ($gae as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_gae[$ind] = $x->JML; 
        }

        // echo json_encode($tmp_data_cogm);
        // echo json_encode($tmp_data_cogs);

        $deplesi = (float) $tmp_data_cogm['07'];
        $deplesi_gae = (float) $tmp_data_gae['19'];
        $data_cogm = (float) $tmp_data_cogm['10'];
        $data_gae = (float) $tmp_data_gae['22'];
        $data_cogs = (float) $tmp_data_cogs['14'];
        // $realcogs = $data_cogm + $data_cogs;

        $total_cogs = ( $data_cogs-$deplesi )+$data_cogm;
        $total_opex = $data_gae - $deplesi_gae;
        $cost = $total_cogs + $total_opex;

        // echo "  $realcogs = $data_cogm + $data_cogs<br>
        //         $opex = ($data_cogm-$deplesi)+$data_cogs <br>
        //         $val_cogs = $bua-$deplesi <br>
        //         $cost = $val_cogs + $opex <br>";

        return $cost;

        // $tmp['cogs'] = $cogs; 
        // $tmp['cogm'] = $cogm; 
        // echo json_encode($tmp);

    }

    function cogs_structure($com = null, $category = null, $date = null){

        $com_param = $this->paramCompany2($com, $date);
        $cogs = $this->m_cost_structure->get_data_desc($com_param, $date, $category, '10 and 13', '14','selected');
        $cogm   = $this->m_cost_structure->get_data_desc($com_param, $date, $category, '1 and 9', '10','selected');

        $tmp_data_cogm = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);

        $tmp_data_cogs = array('10'=>0,'11'=>0,'12'=>0,'13'=>0, '14'=>0);

        foreach ($cogs as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);  
         $tmp_data_cogs[$ind] = $x->JML; 
        }
        foreach ($cogm as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm[$ind] = $x->JML; 
        }

        return ((float)$tmp_data_cogs['14']+(float)$tmp_data_cogm['10']);

    }

    // public function get_data($month , $year , $com , $category ){
    public function get_data($month = null, $year = null, $com = null, $category = null){


      $date = "$year.$month";
      // echo "$date";
      $last_year = $year-1;
      $year_of_last_month = $year;
      $last_month = substr(('0'.($month-1)), -2);
      $last_date = "$year_of_last_month.$last_month";

      // if ($last_month=='00') {
      //       $last_month = '12';
      //       $year_of_last_month =  $year_of_last_month -1;
      //       $last_date = "$year_of_last_month.$last_month";
      //       echo $last_date;

      // }
      // echo "$date = $last_date";
      $past_date = "$last_year.12";
      $now_date = "$year.$month";


      $company = $this->paramCompany($com, $now_date);
      $result = $this->mf_performance_mv->get_labarugi2($company, $now_date,$last_date, $category);
      // echo json_encode($result);
      $array_ = array();
      $array_['REAL'] = array();
      $array_['UPTO'] = array();
      foreach ($result as $key) {
        # code...
        
        $tag = $key['TITLE'];
        $array_['REAL'][$tag]=$key['REAL'];
        $array_['UPTO'][$tag]=$key['UPTO'];
        
      }
     
      $array['VLP'] = $this->define('PL_VLP', $array_['UPTO']);
      $array['DEP'] = $this->define('PL_DEP', $array_['REAL']) ;

      $array['BPP'] = $this->define('PL_BPP', $array_['REAL']) ;
      $array['LRSK'] = $this->define('PL_LRSK', $array_['REAL']) ;
      $array['PLL'] = $this->define('PL_PLL', $array_['REAL']) ;
      $array['BP'] = $this->define('PL_BP', $array_['REAL']) ;
      $array['HPB'] = $this->define('PL_HPB', $array_['REAL']) ;

      if ($com==3000 || $com==4000) {
         $array['OA'] = $this->define('PL_OA', $array_['REAL']) ;
         $array['BUA'] = $this->define('PL_BUA', $array_['REAL']) ;
         $array['BPE'] = $this->define('PL_BPE', $array_['REAL']) ;
      }else{

        $array['OA'] = $this->define('PL_OA', $array_['UPTO']);
        $array['BUA'] = $this->define('PL_BUA', $array_['UPTO']);
        $array['BPE'] = $this->define('PL_BPE', $array_['UPTO']) - $this->define('PL_OA', $array_['UPTO']);

      }

        return $array;
        // echo json_encode($array);
    }

    public function get_upto($month , $year , $com , $category ){
    // public function get_upto($month = null, $year = null, $com = null, $category = null){
      // $temp           = $this->date_between($date);

      $now_date = "$year.$month";
    
      $start_date = "$year.01";
     
      $company = $this->paramCompany($com, $now_date);
      $result = $this->mf_performance_mv->get_data_upto($com, $company, $now_date, $start_date, $category);
      // echo json_encode($result);
      $array_ = array();
      foreach ($result as $key) {
        # code...
        
        $tag = $key['TITLE'];
        $array_[$tag]=$key['VAL'];
      }
     
      $array['VLP'] = $this->define('PL_VLP', $array_);
      $array['DEP'] = $this->define('PL_DEP', $array_) ;

      $array['BPP'] = $this->define('PL_BPP', $array_) ;
      $array['LRSK'] = $this->define('PL_LRSK', $array_) ;
      $array['PLL'] = $this->define('PL_PLL', $array_) ;
      $array['BP'] = $this->define('PL_BP', $array_) ;
      $array['HPB'] = $this->define('PL_HPB', $array_) ;

      if ($com==3000 || $com==4000) {
         $array['OA'] = $this->define('PL_OA', $array_) ;
         $array['BUA'] = $this->define('PL_BUA', $array_) ;
         $array['BPE'] = $this->define('PL_BPE', $array_) ;
      }else{

        $array['OA'] = $this->define('PL_OA', $array_);
        $array['BUA'] = $this->define('PL_BUA', $array_);
        $array['BPE'] = $this->define('PL_BPE', $array_) - $this->define('PL_OA', $array_);

      }
      // echo json_encode($array);
        return $array;

    }

    function define($index, $result){

      if (isset($result[$index])) {
        # code...
        return floatval($result[$index]);
      }else{
        return 0;
      }

      // return 0;
    }
    function define2($index, $result, $date){

      if (isset($result[$index][$date])) {
        # code...
        return floatval($result[$index][$date]);
      }else{
        return 0;
      }

      // return 0;
    }

    function paramCompany($com, $year){
        $year = (int) $year;
        // $paramCompany = "('5000', '3000', '4000', '6000')";

        // if ($year>2016) {

        //   $paramCompany = "('5000', '3000', '4000', '6000')";

        //   if ($com!='' && $com!='SMI' && $com!='smi') {
        //     $paramCompany = "('$com')";
        //     if ($com == '7000') {
        //       # code...
        //       $paramCompany = "('5000')";
              
        //     }
        //   }
        $paramCompany = "('7000','2000', '3000', '4000', '6000')";

        if ($year>2016) {

          $paramCompany = "('5000', '7000','2000', '3000', '4000', '6000')";

          if ($com!='' && $com!='SMI' && $com!='smi') {
            $paramCompany = "('$com')";
            // if ($com == '7000') {
            //   # code...
            //   $paramCompany = "('5000')";
              
            // }
          }

        }else if ($year<=2016) {
          # code...
          $paramCompany = "('7000','2000', '3000', '4000', '6000')";
          if ($com!='' && $com!='SMI' && $com!='smi') {
            $paramCompany = "('$com')";
            // if ($com == '7000') {
            //   # code...
            //   $paramCompany = "('$com', '2000')";
              
            // }
          }

        }
        // echo $paramCompany."<br>";
        return $paramCompany;
    }
    function paramCompany2($com, $year){
        $year = (int) $year;
        // $paramCompany = "5000', '3000', '4000', '6000";

        // if ($year>2016) {

        //   $paramCompany = "5000', '3000', '4000', '6000";

        //   if ($com!='' && $com!='SMI' && $com!='smi') {
        //     $paramCompany = "$com";
        //     if ($com == '7000') {
        //       # code...
        //       $paramCompany = "5000";
              
        //     }
        //   }
        $paramCompany = "7000','2000', '3000', '4000', '6000";

        if ($year>2016) {

          $paramCompany = "7000','2000', '3000', '4000', '6000";

          if ($com!='' && $com!='SMI' && $com!='smi') {
            $paramCompany = "$com";
            // if ($com == '7000') {
            //   # code...
            //   $paramCompany = "5000";
              
            // }
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
        // echo $paramCompany."<br>";
        return $paramCompany;
    }
    function division($value1, $value2){
        if ($value2==0) {
          return null;
        }
        return ( (float) $value1 / (float) $value2 );
    }   

    private function performanceInit(){

      $array =  array(
                       "real_ebit"=> 0,
                       "real_ebit_prev"=> 0,
                       "persen_ebit"=> 0,
                       "variance_ebit"=> 0,
                       "rkap_ebit"=> 0,
                       "yonyear_ebit"=> 0,
                       "real_ebit_up"=> 0,
                       "real_ebit_prev_up"=> 0,
                       "persen_ebit_up"=> 0,
                       "variance_ebit_up"=> 0,
                       "rkap_ebit_up"=> 0,
                       "yonyear_ebit_up"=> 0,
                       "real_vol"=> 0,
                       "real_vol_prev"=> 0,
                       "persen_vol"=> 0,
                       "variance_vol"=> 0,
                       "rkap_vol"=> 0,
                       "yonyear_vol"=> 0,
                       "real_vol_up"=> 0,
                       "real_vol_prev_up"=> 0,
                       "persen_vol_up"=> 0,
                       "variance_vol_up"=> 0,
                       "rkap_vol_up"=> 0,
                       "yonyear_vol_up"=> 0,
                       "real_price"=> 0,
                       "real_price_prev"=> 0,
                       "persen_price"=> 0,
                       "variance_price"=> 0,
                       "rkap_price"=> 0,
                       "yonyear_price"=> 0,
                       "real_price_up"=> 0,
                       "real_price_prev_up"=> 0,
                       "persen_price_up"=> 0,
                       "variance_price_up"=> 0,
                       "rkap_price_up"=> 0,
                       "yonyear_price_up"=> 0,
                       "real_cost"=> 0,
                       "real_cost_prev"=> 0,
                       "persen_cost"=> 0,
                       "variance_cost"=> 0,
                       "rkap_cost"=> 0,
                       "yonyear_cost"=> 0,
                       "real_cost_up"=> 0,
                       "real_cost_prev_up"=> 0,
                       "persen_cost_up"=> 0,
                       "variance_cost_up"=> 0,
                       "rkap_cost_up"=> 0,
                       "yonyear_cost_up"=> 0,
                       "real_rev"=> 0,
                       "rkap_rev"=> 0,
                       "real_net"=> 0,
                       "rkap_net"=> 0,
                       "real_rev_up"=> 0,
                       "rkap_rev_up"=> 0,
                       "real_net_up"=> 0,
                       "rkap_net_up"=> 0
                     );

      return $array;

    }

    function date_between($date){
      $datestr = explode(".",$date);
      $period = array();
      for ($x=1;$x<=intval($datestr[1]);$x++){
       $temp = '0'.$x;
       array_push($period, "'".(intval($datestr[0])).'.'.substr($temp,-2)."'");    
      } 
      return implode($period,",");
     }
     function date_between2($date){
      $datestr = explode(".",$date);
      $period = array();
      for ($x=1;$x<=intval($datestr[1]);$x++){
       $temp = '0'.$x;
       array_push($period, (intval($datestr[0])).'-'.substr($temp,-2));    
      } 
      return implode($period,",");
     }


}



