<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class F_performance extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mf_performance');
        //$this->load->helper('text');
    }

    function index(){
    }
    
    function performance(){
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

      $resebi = $this->mf_performance->mget_ebitda($param);
      $resvol = $this->mf_performance->mget_volume($param);
      $resbruto = $this->mf_performance->mget_bruto($param);
      $rescost = $this->mf_performance->mget_cost($param);
      $resrev = $this->mf_performance->mget_revenue($param);

      $real_price = $this->division($resbruto->BRUTO_ACTUAL,$resvol->VOL_ACTUAL);
      $real_price_prev = $this->division($resbruto->BRUTO_ACTUAL_LYEAR,$resvol->VOL_ACTUAL_LYEAR);
      $rkap_price = $this->division($resbruto->BRUTO_TARGET,$resvol->VOL_TARGET); 
      $persen_price = $this->division($real_price,$rkap_price);
      $variance_price = $real_price - $rkap_price;
      $yonyear_price = $this->division($real_price - $real_price_prev,$real_price_prev)*100;
      $real_price_up = $this->division($resbruto->BRUTO_ACTUAL_UP,$resvol->VOL_ACTUAL_UP);
      $real_price_prev_up = $this->division($resbruto->BRUTO_ACTUAL_LYEAR_UP,$resvol->VOL_ACTUAL_LYEAR_UP);
      $rkap_price_up = $this->division($resbruto->BRUTO_TARGET_UP,$resvol->VOL_TARGET_UP);
      $persen_price_up = $this->division($real_price_up,$rkap_price_up);
      $variance_price_up = $real_price_up - $rkap_price_up;
      $yonyear_price_up = $this->division($real_price_up - $real_price_prev_up,$real_price_prev_up)*100;    

       echo json_encode(
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
                     "real_vol"=>floatval($resvol->VOL_ACTUAL),
                     "real_vol_prev"=>floatval($resvol->VOL_ACTUAL_LYEAR),
                     "persen_vol"=>floatval($this->division($resvol->VOL_ACTUAL,$resvol->VOL_TARGET)),
                     "variance_vol"=>floatval($resvol->VOL_ACTUAL) - floatval($resvol->VOL_TARGET),
                     "rkap_vol"=>floatval($resvol->VOL_TARGET),
                     "yonyear_vol"=>($this->division(floatval($resvol->VOL_ACTUAL) - floatval($resvol->VOL_ACTUAL_LYEAR),floatval($resvol->VOL_ACTUAL_LYEAR))*100),
                     "real_vol_up"=>floatval($resvol->VOL_ACTUAL_UP),
                     "real_vol_prev_up"=>floatval($resvol->VOL_ACTUAL_LYEAR_UP),
                     "persen_vol_up"=>floatval($this->division($resvol->VOL_ACTUAL_UP,$resvol->VOL_TARGET_UP)),
                     "variance_vol_up"=>floatval($resvol->VOL_ACTUAL_UP) - floatval($resvol->VOL_TARGET_UP),
                     "rkap_vol_up"=>floatval($resvol->VOL_TARGET_UP),
                     "yonyear_vol_up"=>($this->division(floatval($resvol->VOL_ACTUAL_UP) - floatval($resvol->VOL_ACTUAL_LYEAR_UP),floatval($resvol->VOL_ACTUAL_LYEAR_UP))*100),
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
                     "real_cost"=>floatval($rescost->COST_ACTUAL),
                     "real_cost_prev"=>floatval($rescost->COST_ACTUAL_LYEAR),
                     "persen_cost"=>floatval($this->division($rescost->COST_ACTUAL,$rescost->COST_TARGET)),
                     "variance_cost"=>floatval($rescost->COST_ACTUAL) - floatval($rescost->COST_TARGET),
                     "rkap_cost"=>floatval($rescost->COST_TARGET),
                     "yonyear_cost"=>($this->division(floatval($rescost->COST_ACTUAL) - floatval($rescost->COST_ACTUAL_LYEAR),floatval($rescost->COST_ACTUAL_LYEAR))*100),
                     "real_cost_up"=>floatval($rescost->COST_ACTUAL_UP),
                     "real_cost_prev_up"=>floatval($rescost->COST_ACTUAL_LYEAR_UP),
                     "persen_cost_up"=>floatval($this->division($rescost->COST_ACTUAL_UP,$rescost->COST_TARGET_UP)),
                     "variance_cost_up"=>floatval($rescost->COST_ACTUAL_UP) - floatval($rescost->COST_TARGET_UP),
                     "rkap_cost_up"=>floatval($rescost->COST_TARGET_UP),
                     "yonyear_cost_up"=>($this->division(floatval($rescost->COST_ACTUAL_UP) - floatval($rescost->COST_ACTUAL_LYEAR_UP),floatval($rescost->COST_ACTUAL_LYEAR_UP))*100),
                     "real_rev"=>floatval($resrev->LABA_BRUTO_ACTUAL),
                     "rkap_rev"=>floatval($resrev->LABA_BRUTO_TARGET),
                     "real_net"=>floatval($resrev->LABA_NETTO_ACTUAL),
                     "rkap_net"=>floatval($resrev->LABA_NETTO_TARGET),
                     "real_rev_up"=>floatval($resrev->LABA_BRUTO_ACTUAL_UP),
                     "rkap_rev_up"=>floatval($resrev->LABA_BRUTO_TARGET_UP),
                     "real_net_up"=>floatval($resrev->LABA_NETTO_ACTUAL_UP),
                     "rkap_net_up"=>floatval($resrev->LABA_NETTO_TARGET_UP)
                   )
               );
    }

    function trends(){
     $filter['company'] = (empty($_GET['company']) ? 'ALL' : $_GET['company']);
     $paramCompany = $filter['company'];
     $data = array();
     $param=array("company"=>trim($paramCompany));
     $rev = (array) $this->mf_performance->mget_trend_volume($param);
     $res = (array) $this->mf_performance->mget_trend_labarugi($param);
     $year = date('Y');    
     //var_dump(isset($rev[11])); 
     for ($x=1;$x<=12;$x++){
      $bln = substr('0'.$x,-2);
      $penjualan = 0;
      $ebitda = 0;
      $bruto = 0;
      $netto = 0;
      if (isset($rev[$x-1])){
       if (($rev[$x-1]->PERIODE) == ($year.'.'.$bln)){
        $penjualan = $rev[$x-1]->PENJUALAN;
       }
      }
      if (isset($res[$x-1])){
       if (($res[$x-1]->PERIODE) == ($year.'.'.$bln)){
        if ($x-1 > 0){
         $ebitda = ($res[$x-1]->EBITDA) - ($res[$x-2]->EBITDA);
         $bruto = ($res[$x-1]->BRUTO) - ($res[$x-2]->BRUTO);
         $netto = ($res[$x-1]->NETTO) - ($res[$x-2]->NETTO);
        }else{
         $ebitda = $res[$x-1]->EBITDA;
         $bruto = $res[$x-1]->BRUTO;
         $netto = $res[$x-1]->NETTO;
        }
       }
      }
      $data[$year.'.'.$bln] = array("penjualan"=>floatval($penjualan),"ebitda"=>floatval($ebitda),"bruto"=>floatval($bruto),"netto"=>floatval($netto));
     }
     // foreach ($res as $val){
     //  $data[$val->PERIODE] = array("penjualan"=>0,"ebitda"=>$val->EBITDA,"bruto"=>$val->BRUTO,"netto"=>$val->NETTO);   
     // }
     echo json_encode($data);
    }
    
    private function division($a, $b) {   
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

    public function gets_data($time, $comp, $GL_ACCOUNT, $CATEGORY) {
        return $get = $this->mf_performance->get_dt($time, $comp, $GL_ACCOUNT, $CATEGORY);
    }

    public function gets_elim($time, $comp, $GL_ACCOUNT, $INTERCO, $COSTCENTER) {
        $elim = $this->mf_performance->elim($time, $comp, $GL_ACCOUNT, $INTERCO, $COSTCENTER);
        $data[2] = $elim->ACT;
        $data[3] = $elim->ACT_LALU;
        $data[5] = $elim->ACT1;
        $data[6] = $elim->ACT_LALU1;
        return $data;
    }

    public function elim_nilai($time) {
        $elim_semen_2_34 = $this->mf_performance->elim_sales("$time", "'3000', '4000'", "121_000000");
        $elim_semen_2_72 = $this->mf_performance->elim_sales("$time", "'7000', '2000'", "121_000000");
        $elim_terak_2_34 = $this->mf_performance->elim_sales("$time", "'3000', '4000'", "200");
        $elim_terak_2_72 = $this->mf_performance->elim_sales("$time", "'7000', '2000'", "200");
        $nilai = $elim_semen_2_34 + $elim_semen_2_72 + $elim_terak_2_34 + $elim_terak_2_72;
        return $nilai;
    }

    public function gets_elim_sales($time) {
        $month = substr($time, -2);
        $month_lalu = $month - 1;
        $month_lalu = "0$month_lalu";
        $month_lalu = substr($month_lalu, -2);

        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        //pengurangan elim dari sales
        $temp = "";
        for ($i = 1; $i <= $month; $i++) {
            $m = "0$i";
            $m = substr($m, -2);
            if ($i != $month) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$m' $tmbhn";
            $temp = $time_between;
        }
        $time_between1 = str_replace($year, $year_lalu, $temp);

        $elim_semen_terak[5] = $this->elim_nilai("'$time'");
        $elim_semen_terak[6] = $this->elim_nilai("'$year_lalu.$month'");
        $elim_semen_terak_bln_lalu = $this->elim_nilai("'$year.$month_lalu'");
        $elim_semen_terak_bln_lalu1 = $this->elim_nilai("'$year_lalu.$month_lalu'");

        $elim_semen_terak[2] = $elim_semen_terak[5] - $elim_semen_terak_bln_lalu;
        $elim_semen_terak[3] = $elim_semen_terak[6] - $elim_semen_terak_bln_lalu1;
        return $elim_semen_terak;
    }
    
    public function showing($time, $comp, $GL_ACCOUNT) {
        //pengurangan bulan dan tahun sblm di elim
        $month = substr($time, -2);
        $month_lalu = $month - 1;
        $month_lalu = "0$month_lalu";
        $month_lalu = substr($month_lalu, -2);

        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
//        echo $comp;exit;
        if ($comp == "SI") {
            if ($GL_ACCOUNT == "PL_HPB") {
                $elim_semen_terak_7000 = $this->gets_elim("$time", "7000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_3000', 'I_4000'", "NO_CC");
                $elim_semen_terak_3000 = $this->gets_elim("$time", "3000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_7000', 'I_4000'", "NO_CC");
                $elim_semen_terak_4000 = $this->gets_elim("$time", "4000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_7000', 'I_3000'", "NO_CC");
                //ambil nilai elim semen dan terak dari sales
                $elim_semen_terak_sales = $this->gets_elim_sales($time);

                $elim_act2 = $elim_semen_terak_3000[2] + $elim_semen_terak_4000[2] + $elim_semen_terak_7000[2] - $elim_semen_terak_sales[2];
                $elim_act3 = $elim_semen_terak_3000[3] + $elim_semen_terak_4000[3] + $elim_semen_terak_7000[3] - $elim_semen_terak_sales[3];
                $elim_act5 = $elim_semen_terak_3000[5] + $elim_semen_terak_4000[5] + $elim_semen_terak_7000[5] - $elim_semen_terak_sales[5];
                $elim_act6 = $elim_semen_terak_3000[6] + $elim_semen_terak_4000[6] + $elim_semen_terak_7000[6] - $elim_semen_terak_sales[6];
            } elseif ($GL_ACCOUNT == "PL_OA") {
                $total_oa = $this->gets_elim("$time", "", "LIKE '681%'", "", "CC4");
                $elim_act2 = $total_oa[2] * -1;
                $elim_act3 = $total_oa[3] * -1;
                $elim_act5 = $total_oa[5] * -1;
                $elim_act6 = $total_oa[6] * -1;
            } elseif ($GL_ACCOUNT == "PL_BPP") {
                $jual1 = $this->gets_elim("$time", "", "LIKE '4111%'", "", "");
                $jual2 = $this->gets_elim("$time", "", "LIKE '4112%'", "", "");
                $oa_7000 = $this->gets_elim("$time", "7000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_3000', 'I_4000'", "NO_CC");
                $oa_3000 = $this->gets_elim("$time", "3000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_7000', 'I_4000'", "NO_CC");
                $oa_4000 = $this->gets_elim("$time", "4000", "IN ('PL_EOAI', 'PL_EOAT')", "'I_7000', 'I_3000'", "NO_CC");
                $elim_act2 = ($jual1[2] + $jual2[2] + ($oa_3000[2] + $oa_4000[2] + $oa_7000[2])) * -1;
                $elim_act3 = ($jual1[3] + $jual2[3] + ($oa_3000[3] + $oa_4000[3] + $oa_7000[3])) * -1;
                $elim_act5 = ($jual1[5] + $jual2[5] + ($oa_3000[5] + $oa_4000[5] + $oa_7000[5])) * -1;
                $elim_act6 = ($jual1[6] + $jual2[6] + ($oa_3000[6] + $oa_4000[6] + $oa_7000[6])) * -1;
            } elseif ($GL_ACCOUNT == "PL_BUA") {
                $bbn_adm = $this->gets_elim("$time", "", "LIKE '6%'", "", "CC5");
                $pengurangan_bbn_adm = $this->gets_elim("$time", "", "LIKE '615%'", "", "CC5");
                $elim_act2 = ($bbn_adm[2] - $pengurangan_bbn_adm[2]) * -1;
                $elim_act3 = ($bbn_adm[3] - $pengurangan_bbn_adm[3]) * -1;
                $elim_act5 = ($bbn_adm[5] - $pengurangan_bbn_adm[5]) * -1;
                $elim_act6 = ($bbn_adm[6] - $pengurangan_bbn_adm[6]) * -1;
            } elseif ($GL_ACCOUNT == "PL_BPE") {
                $bbn_adm = $this->gets_elim("$time", "", "LIKE '6%'", "", "CC4");
                $oa = $this->gets_elim("$time", "", "LIKE '615%'", "", "CC4");
                $elim_act2 = ($bbn_adm[2] - $oa[2]) * -1;
                $elim_act3 = ($bbn_adm[3] - $oa[3]) * -1;
                $elim_act5 = ($bbn_adm[5] - $oa[5]) * -1;
                $elim_act6 = ($bbn_adm[6] - $oa[6]) * -1;
            } elseif ($GL_ACCOUNT == "PL_E") { // ebitda
                $depreciation1 = $this->gets_elim("$time", "", "LIKE '661%'", "", "");
                $depreciation2 = $this->gets_elim("$time", "", "LIKE '662%'", "", "");
                $depreciation3 = $this->gets_elim("$time", "", "LIKE '663%'", "", "");
                $elim_act2 = $depreciation1[2] + $depreciation2[2] + $depreciation3[2];
                $elim_act3 = $depreciation1[3] + $depreciation2[3] + $depreciation3[3];
                $elim_act5 = $depreciation1[5] + $depreciation2[5] + $depreciation3[5];
                $elim_act6 = $depreciation1[6] + $depreciation2[6] + $depreciation3[6];
            } elseif ($GL_ACCOUNT == "PL_BP") {
                $bbn_pkk_jual = $this->gets_elim("$time", "", "LIKE '715%'", "", "");
                $elim_act2 = $bbn_pkk_jual[2] * -1;
                $elim_act3 = $bbn_pkk_jual[3] * -1;
                $elim_act5 = $bbn_pkk_jual[5] * -1;
                $elim_act6 = $bbn_pkk_jual[6] * -1;
            } elseif ($GL_ACCOUNT == "PL_LRSK") {
                $bbn_pkk_jual = $this->gets_elim("$time", "", "LIKE '716%'", "", "");
                $elim_act2 = $bbn_pkk_jual[2] * -1;
                $elim_act3 = $bbn_pkk_jual[3] * -1;
                $elim_act5 = $bbn_pkk_jual[5] * -1;
                $elim_act6 = $bbn_pkk_jual[6] * -1;
                //PL_PLL
            } else {
                $bbn_pkk_jual1 = $this->gets_elim("$time", "", "LIKE '7%'", "", "");
                $bbn_pkk_jual2 = $this->gets_elim("$time", "", "LIKE '715%'", "", "");
                $bbn_pkk_jual3 = $this->gets_elim("$time", "", "LIKE '716%'", "", "");
                $elim_act2 = ($bbn_pkk_jual1[2] + ($bbn_pkk_jual2[2] * -1) + ($bbn_pkk_jual3[2] * -1)) * -1;
                $elim_act3 = ($bbn_pkk_jual1[3] + ($bbn_pkk_jual2[3] * -1) + ($bbn_pkk_jual3[3] * -1)) * -1;
                $elim_act5 = ($bbn_pkk_jual1[5] + ($bbn_pkk_jual2[5] * -1) + ($bbn_pkk_jual3[5] * -1)) * -1;
                $elim_act6 = ($bbn_pkk_jual1[6] + ($bbn_pkk_jual2[6] * -1) + ($bbn_pkk_jual3[6] * -1)) * -1;
            }
        } else {
            $elim_act2 = 0;
            $elim_act3 = 0;
            $elim_act5 = 0;
            $elim_act6 = 0;
        }
        $a_p[0] = $this->gets_data("'$year.$month_lalu'", $comp, $GL_ACCOUNT, "BUD");
        //4. bud setelah ditambah elim
        $a_p[5] = $this->gets_data("'$year.$month'", $comp, $GL_ACCOUNT, "BUD");
        //1. bud dikurangi bulan lalu ditambah elim
        $a_p[1] = $a_p[5] - $a_p[0];

        $a_p[99] = $this->gets_data("'$year.$month_lalu'", $comp, $GL_ACCOUNT, "ACT");
//        print_r($a_p);exit;
        $a_p[60] = $this->gets_data("'$year.$month'", $comp, $GL_ACCOUNT, "ACT");
        //2. act dikurangi bulan lalu ditambah elim
        $a_p[2] = $a_p[60] - $a_p[99] + $elim_act2; // ebitda perbulan
        //5. act setelah ditambah elim
        $a_p[6] = $a_p[60] + $elim_act5;
        print_r($a_p);exit;

        $a_p[98] = $this->gets_data("'$year_lalu.$month_lalu'", $comp, $GL_ACCOUNT, "ACT");
        $a_p[70] = $this->gets_data("'$year_lalu.$month'", $comp, $GL_ACCOUNT, "ACT");

        //3. act tahun lalu dikurangi bulan lalu  ditambah elim
        $a_p[3] = $a_p[70] - $a_p[98] + $elim_act3;
        //6. act tahun lalu setelah ditambah elim
        $a_p[7] = $a_p[70] + $elim_act6;
        //2:3
        if ($a_p[3] == 0) {
            $a_p[4] = 0;
        } else {
            $a_p[4] = ($a_p[2] / $a_p[3]) * 100;
        }
        //5:6
        if ($a_p[7] == 0) {
            $a_p[8] = 0;
        } else {
            $a_p[8] = ($a_p[6] / $a_p[7]) * 100;
        }
        //2:1
        if ($a_p[1] == 0) {
            $a_p[9] = 0;
        } else {
            $a_p[9] = ($a_p[2] / $a_p[1]) * 100;
        }
        //5:4
        if ($a_p[5] == 0) {
            $a_p[10] = 0;
        } else {
            $a_p[10] = ($a_p[6] / $a_p[5]) * 100;
        }
        return $a_p;
    }

    public function gift($time, $comp, $GL_ACCOUNT) {
        $h1 = $this->showing($time, $comp, $GL_ACCOUNT);
        $s1 = ', "val1":" ' . number_format($h1[1], 0, ',', '.');
        for ($n = 2; $n <= 10; $n++) {
            //jika data persentase
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
                if ($h1[$n] == 0) {
                    $nilai = '';
                } else {
                    $nilai = number_format($h1[$n], 2, ',', '.') . '%';
                }
            } else {
                $nilai = number_format($h1[$n], 0, ',', '.');
            }
            $sh1 = $s1 . '", "val' . $n . '":" ' . $nilai;

            $s1 = $sh1;
        }
        $h1[0] = $sh1;
        return $h1;
    }

    public function gift_plus($pertama, $kedua) {
        $h3[1] = $pertama[1] + $kedua[1];
        $s3 = ', "val1":" ' . number_format($h3[1], 0, ',', '.');
        for ($n = 2; $n <= 10; $n++) {
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
                $h3[$n] = $pertama[$n] + $kedua[$n];
                if ($h3[$n] == 0) {
                    $nilai = '';
                } else {
                    $nilai = number_format($h3[$n], 2, ',', '.') . '%';
                }
            } else {
                $h3[$n] = $pertama[$n] + $kedua[$n];
                $nilai = number_format($h3[$n], 0, ',', '.');
            }
            $sh3 = $s3 . '", "val' . $n . '":" ' . $nilai;

            $s3 = $sh3;
        }
        $h3[0] = $sh3;
        return $h3;
    }

    public function gift_per($pertama, $kedua) {
        if ($pertama[1] == 0 or $kedua[2] == 0) {
            $h6[1] = 0;
            $s6 = ', "val1":" ';
        } else {
            $h6[1] = ($pertama[1] / $kedua[1]) * 100;
            $s6 = ', "val1":" ' . number_format($h6[1], 2, ',', '.') . '%';
        }
        for ($n = 2; $n <= 10; $n++) {
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
                $h6[$n] = 0;
                $show = '';
            } else {
                if ($pertama[$n] == 0 or $kedua[$n] == 0) {
                    $h6[$n] = 0;
                    $show = '';
                } else {
                    $h6[$n] = ($pertama[$n] / $kedua[$n]) * 100;
                    $show = number_format($h6[$n], 2, ',', '.') . '%';
                }
            }
            $sh6 = $s6 . '", "val' . $n . '":" ' . $show;
            $s6 = $sh6;
        }
        $h6[0] = $sh6;
        return $h6;
    }

    public function gift_c($pertama, $kedua) {
        if ($pertama[1] == 0 or $kedua[2] == 0) {
            $h6[1] = 0;
            $s6 = ', "val1":" ';
        } else {
            $h6[1] = ($pertama[1] / $kedua[1]) * 100;
            $s6 = ', "val1":" ' . number_format($h6[1], 2, ',', '.');
        }
        for ($n = 2; $n <= 10; $n++) {
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
//                val4 = val2/val3
//                val8 = val6/val7
//                val9 = val2/val1
//                val10 = val6/val5,
                if ($n == 4 or $n == 8) {
                    //jika nilai penyebut ==0
                    if ($h6[$n - 2] == 0 or $h6[$n - 1] == 0) {
                        $h6[$n] = 0;
                    } else {
                        $h6[$n] = $h6[$n - 2] / $h6[$n - 1];
                    }
                } elseif ($n == 9) {
                    //jika nilai penyebut ==0
                    if ($h6[2] == 0 or $h6[1] == 0) {
                        $h6[$n] = 0;
                    } else {
                        $h6[$n] = $h6[2] / $h6[1];
                    }
                } else {
                    //jika nilai penyebut ==0
                    if ($h6[6] == 0 or $h6[5] == 0) {
                        $h6[$n] = 0;
                    } else {
                        $h6[$n] = $h6[6] / $h6[5];
                    }
                }
                if ($h6[$n] == 0) {
                    $show = "";
                } else {
                    $show = number_format($h6[$n], 2, ',', '.') . "%";
                }
            } else {
                if ($pertama[$n] == 0 or $kedua[$n] == 0) {
                    $h6[$n] = 0;
                    $show = '';
                } else {
                    $h6[$n] = ($pertama[$n] / $kedua[$n]) * 100;
                    $show = number_format($h6[$n], 2, ',', '.');
                }
            }
            $sh6 = $s6 . '", "val' . $n . '":" ' . $show;
            $s6 = $sh6;
        }
        $h6[0] = $sh6;
        return $h6;
    }

    public function show() {
        $time = isset($_POST['time']) ? $_POST['time'] : '2016.05';
        $comp = isset($_POST['comp']) ? $_POST['comp'] : 7000;

        $month = substr($time, -2);
        $month_lalu = $month - 1;
        $month_lalu = "0$month_lalu";
        $month_lalu = substr($month_lalu, -2);

        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
/*
        //penjualan 
        $h0 = $this->gift($time, $comp, "PL_VLP");

        //1 ===
        $h1 = $this->gift($time, $comp, "PL_HPB");
        //2 ===
        $h2 = $this->gift($time, $comp, "PL_OA");
        //4 ===
        $h4 = $this->gift($time, $comp, "PL_BPP");
        //7 ===
        $h7 = $this->gift($time, $comp, "PL_BUA");
        //8 ===
        $h8 = $this->gift($time, $comp, "PL_BPE"); */
        //12 ===
        $h12 = $this->gift($time, $comp, "PL_E");
        print_r($h12); exit;
        //14 ===
        $h14 = $this->gift($time, $comp, "PL_BP");
        //15 ===
        $h15 = $this->gift($time, $comp, "PL_LRSK");
        //16 ===
        $h16 = $this->gift($time, $comp, "PL_PLL");

        //3 ===
        $h3 = $this->gift_plus($h1, $h2);
        //5 ===
        $h5 = $this->gift_plus($h3, $h4);
        //9 ===
        $h9 = $this->gift_plus($h7, $h8);
        //10 ====
        $p = 10;
        $h10[1] = $h5[1] + $h7[1] + $h8[1];
        $s10 = ', "val1":" ' . number_format($h10[1], 0, ',', '.');
        for ($n = 2; $n <= 10; $n++) {
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
                $h10[$n] = $h5[$n] + $h7[$n] + $h8[$n];
                if ($h10[$n] == 0) {
                    $nilai = '';
                } else {
                    $nilai = number_format($h10[$n], 2, ',', '.') . '%';
                }
            } else {
                $h10[$n] = $h5[$n] + $h7[$n] + $h8[$n];
                $nilai = number_format($h10[$n], 0, ',', '.');
            }
            $sh10 = $s10 . '", "val' . $n . '":" ' . $nilai;

            $s10 = $sh10;
        }
        //17 ====
        $p = 17;
        $h17[1] = $h10[1] + $h14[1] + $h15[1] + $h16[1];
        $s17 = ', "val1":" ' . number_format($h17[1], 0, ',', '.');
        for ($n = 2; $n <= 10; $n++) {
            $h17[$n] = $h10[$n] + $h14[$n] + $h15[$n] + $h16[$n];
            if ($n == 4 or $n == 8 or $n == 9 or $n == 10) {
                if ($h17[$n] == 0) {
                    $nilai = '';
                } else {
                    $nilai = number_format($h17[$n], 2, ',', '.') . '%';
                }
            } else {
                $nilai = number_format($h17[$n], 0, ',', '.');
            }

            $sh17 = $s17 . '", "val' . $n . '":" ' . $nilai;

            $s17 = $sh17;
        }

        //6 ===
        $h6 = $this->gift_per($h5, $h3);
        //11 ===
        $h11 = $this->gift_per($h10, $h3);
        //13 ===
        $h13 = $this->gift_per($h12, $h3);
        //18 ===
        $h18 = $this->gift_per($h17, $h3);

        //c1 === 
        $h19 = $this->gift_c($h1, $h0);
        //c2 === 
        $h20 = $this->gift_c($h2, $h0);
        //c3 === 
        $h21 = $this->gift_c($h3, $h0);
        //c4 === 
        $h22 = $this->gift_c($h4, $h0);
        //c5 === 
        $h23 = $this->gift_c($h5, $h0);
        //c6 === 
        $h24 = $this->gift_c($h7, $h0);
        //c7 === 
        $h25 = $this->gift_c($h8, $h0);
        //c8 === 
        $h26 = $this->gift_c($h9, $h0);
        //c9 === 
        $h27 = $this->gift_c($h10, $h0);
        //c10
        $h28 = $this->gift_c($h12, $h0);
        //c11
        $h29 = $this->gift_c($h14, $h0);
        //c12
        $h30 = $this->gift_c($h15, $h0);
        //c13
        $h31 = $this->gift_c($h16, $h0);
        //c14
        $h32 = $this->gift_c($h17, $h0);

        $s0 = ', "val1":"", "val2":"", "val3":" ", "val4":" ", "val5":" ", "val6":" ", "val7":" ", "val8":" "';

        $ini = '{"total":28,"rows":[
                                {"desc":" <b>A. VOLUME</b> "' . $s0 . '},
				{"desc":" &nbsp;1. Penjualan"' . $h0[0] . '%"},
				{"desc":" <b>B. LABA/RUGI TOTAL</b> "' . $s0 . '},
				{"desc":" &nbsp;1. Hasil Penjualan Bruto"' . $h1[0] . '%"},
				{"desc":" &nbsp;2. Ongkos Angkut"' . $h2[0] . '%"},
                                {"desc":" &nbsp;3. Hasil Penjualan"' . $h3[0] . '%"},
                                {"desc":" &nbsp;4. Beban Pokok Penjualan"' . $h4[0] . '%"},
                                {"desc":" &nbsp;5. Laba Kotor"' . $h5[0] . '%"},
                                {"desc":" &nbsp;6. Margin Laba Kotor"' . $h6[0] . '"},
                                {"desc":" &nbsp;7. Beban Umum & Administrasi"' . $h7[0] . '%"},
                                {"desc":" &nbsp;8. Beban Penjualan/Pemesanan"' . $h8[0] . '%"},
                                {"desc":" &nbsp;9. Total Beban"' . $h9[0] . '%"},
                                {"desc":" &nbsp;10. Laba Usaha"' . $sh10 . '%"},
                                {"desc":" &nbsp;11. Margin Laba Usaha"' . $h11[0] . '"},
                                {"desc":" &nbsp;12. EBITDA"' . $h12[0] . '%"},
                                {"desc":" &nbsp;13. Margin EBITDA"' . $h13[0] . '"},
                                {"desc":" &nbsp;14. Bunga Pinjaman"' . $h14[0] . '%"},
				{"desc":" &nbsp;15. Laba(Rugi) Selisih Kurs"' . $h15[0] . '%"},
				{"desc":" &nbsp;16. Pendapatan Lain-lain"' . $h16[0] . '%"},
                                {"desc":" &nbsp;17. Laba Sebelum Pajak"' . $sh17 . '%"},
				{"desc":" &nbsp;18. Margin Laba Sebelum Pajak"' . $h18[0] . '"},
                                {"desc":" <b>C. LABA/RUGI PER TON (RP 1)</b> "' . $s0 . '},
                      		{"desc":" &nbsp;1. Hasil Penjualan Bruto"' . $h19[0] . '"},
                                {"desc":" &nbsp;2. Ongkos Angkut"' . $h20[0] . '"},
                                {"desc":" &nbsp;3. Hasil Penjualan"' . $h21[0] . '"},
                                {"desc":" &nbsp;4. Beban Pokok Penjualan"' . $h22[0] . '"},
                                {"desc":" &nbsp;5. Laba Kotor"' . $h23[0] . '"},
                                {"desc":" &nbsp;6. Beban Umum & Administrasi"' . $h24[0] . '"},
                                {"desc":" &nbsp;7. Beban Penjualan/Pemasaran"' . $h25[0] . '"},
                                {"desc":" &nbsp;8. Total Beban"' . $h26[0] . '"},
                                {"desc":" &nbsp;9. Laba Usaha"' . $h27[0] . '"},
                                {"desc":" &nbsp;10. EBITDA"' . $h28[0] . '"},
                                {"desc":" &nbsp;11. Bunga Pinjaman"' . $h29[0] . '"},
				{"desc":" &nbsp;12. Laba(Rugi) Selisih Kurs"' . $h30[0] . '"},
				{"desc":" &nbsp;13. Pendapatan Lain-lain"' . $h31[0] . '"},
                                {"desc":" &nbsp;14. Laba Sebelum Pajak"' . $h32[0] . '"}
	]}';
        echo $ini;
    }
  public function performance_5()  {
      $hasil = $this->mf_performance->mgetperformance_5();
      $data=array();
      foreach ($hasil as $value)
      {
        
        $data= array("KEY_ID"=>$value->KEY_ID,
        "KODE"=>$value->KODE,"FISCAL_YEAR_PERIOD"=>$value->FISCAL_YEAR_PERIOD,"ACT"=>$value->ACT, "ACTYEARBEFORE"=>$value->ACTYEARBEFORE);
        echo json_encode($data);
      }
      
      
  }
  
public function get_priceyear()
{
	$hasil = $this ->mf_performance->m_getpriceyear();
	$data=array();
	foreach ($hasil as $value)
	{
		$data[]=array("FISCAL_YEAR_PERIOD"=>$value->FISCAL_YEAR_PERIOD,
		"HARGACT"=>$value->HRGA,"HARGALAST"=>$value->HRGALAST,"HARGATARGET"=>$value->HRGATARGET);
	}
	echo json_encode($data);
	
}
public function get_priceyear_st()
{
	$hasil = $this ->mf_performance->m_getpriceyear_st();
	$data=array();
	foreach ($hasil as $value)
	{
		$data[]=array("FISCAL_YEAR_PERIOD"=>$value->FISCAL_YEAR_PERIOD,
		"HARGACT"=>$value->HRGA,"HARGALAST"=>$value->HRGALAST,"HARGATARGET"=>$value->HRGATARGET);
	}
	echo json_encode($data);
	
}

public function get_priceyear_sp()
{
	$hasil = $this ->mf_performance->m_getpriceyear_sp();
	$data=array();
	foreach ($hasil as $value)
	{
		$data[]=array("FISCAL_YEAR_PERIOD"=>$value->FISCAL_YEAR_PERIOD,
		"HARGACT"=>$value->HRGA,"HARGALAST"=>$value->HRGALAST,"HARGATARGET"=>$value->HRGATARGET);
	}
	echo json_encode($data);
	
}

public function get_priceyear_tlcc()
{
	$hasil = $this ->mf_performance->m_getpriceyear_tlcc();
	$data=array();
	foreach ($hasil as $value)
	{
		$data[]=array("FISCAL_YEAR_PERIOD"=>$value->FISCAL_YEAR_PERIOD,
		"HARGACT"=>$value->HRGA,"HARGALAST"=>$value->HRGALAST,"HARGATARGET"=>$value->HRGATARGET);
	}
	echo json_encode($data);
	
}
  

}



