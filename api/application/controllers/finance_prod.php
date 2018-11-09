<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header("Access-Control-Allow-Origin: *");


class finance_prod extends CI_Controller { 

    public function __construct() {
        parent::__construct();
        $this->load->model('m_finance_prod');
    }

    public function get_dt($plant, $get) {
        $dt[1] = $get['BUD'][$plant];
        $dt[2] = $get['ACT'][$plant];
        $dt[3] = $get['ACT_LALU'][$plant];
        $dt[6] = $get['BUD1'][$plant];
        $dt[7] = $get['ACT1'][$plant];
        $dt[8] = $get['ACT_LALU1'][$plant];

        // 2/1
        if ($dt[1] == 0 or $dt[1] == null) {
            $dt[4] = "";
        } else {
            $dt[4] = ($dt[2] / $dt[1]) * 100;
        }
        // 2/3
        if ($dt[3] == 0 or $dt[3] == null) {
            $dt[5] = "";
        } else {
            $dt[5] = ($dt[2] / $dt[3]) * 100;
        }
        // 7/6
        if ($dt[6] == 0 or $dt[6] == null) {
            $dt[9] = "";
        } else {
            $dt[9] = ($dt[7] / $dt[6]) * 100;
        }
        // 7/8
        if ($dt[8] == 0 or $dt[8] == null) {
            $dt[10] = "";
        } else {
            $dt[10] = ($dt[7] / $dt[8]) * 100;
        }
        $dt[0] = "";
        $dt[99] = "";
        for ($i = 1; $i <= 10; $i++) {
            $sh_2301 = $dt[0] . ',"val' . $i . '":"' . number_format((int)$dt[$i], 2, '.', ',') . '"';
            $dt[0] = $sh_2301;
            $dw_2301 = $dt[99] . "<td>" . number_format((int)$dt[$i], 2, '.', ',') . "</td>";
            $dt[99] = $dw_2301;
        }
        return $dt;
    }
    public function get_plus($dt1, $dt2, $dt3, $dt4, $dt5, $dt6){
        $dt[1] = $dt1[1]+$dt2[1]+$dt3[1]+$dt4[1]+$dt5[1]+$dt6[1];
        $dt[2] = $dt1[2]+$dt2[2]+$dt3[2]+$dt4[2]+$dt5[2]+$dt6[2];
        $dt[3] = $dt1[3]+$dt2[3]+$dt3[3]+$dt4[3]+$dt5[3]+$dt6[3];
        $dt[6] = $dt1[6]+$dt2[6]+$dt3[6]+$dt4[6]+$dt5[6]+$dt6[6];
        $dt[7] = $dt1[7]+$dt2[7]+$dt3[7]+$dt4[7]+$dt5[7]+$dt6[7];
        $dt[8] = $dt1[8]+$dt2[8]+$dt3[8]+$dt4[8]+$dt5[8]+$dt6[8];

        // 2/1
        if ($dt[1] == 0 or $dt[1] == null) {
            $dt[4] = "";
        } else {
            $dt[4] = ($dt[2] / $dt[1]) * 100;
        }
        // 2/3
        if ($dt[3] == 0 or $dt[3] == null) {
            $dt[5] = "";
        } else {
            $dt[5] = ($dt[2] / $dt[3]) * 100;
        }
        // 7/6
        if ($dt[6] == 0 or $dt[6] == null) {
            $dt[9] = "";
        } else {
            $dt[9] = ($dt[7] / $dt[6]) * 100;
        }
        // 7/8
        if ($dt[8] == 0 or $dt[8] == null) {
            $dt[10] = "";
        } else {
            $dt[10] = ($dt[7] / $dt[8]) * 100;
        }
        $dt[0] = "";
        $dt[99] = "";
        for ($i = 1; $i <= 10; $i++) {
            $sh_2301 = $dt[0] . ',"val' . $i . '":"' . number_format((int)$dt[$i], 2, '.', ',') . '"';
            $dt[0] = $sh_2301;
            $dw_2301 = $dt[99] . "<td>" . number_format((int)$dt[$i], 2, '.', ',') . "</td>";
            $dt[99] = $dw_2301;
        }
        return $dt;
    }

    public function show_cement() {
        for ($i = 1; $i <= 12; $i++) {
            $dt0[$i] = 0;
        }
        $time = isset($_GET['time']) ? $_GET['time'] : NULL;
        $get = $this->m_finance_prod->get_comparison_cement($time);

        $dt_2301 = $this->get_dt("2301", $get);
        $dt_2302 = $this->get_dt("2302", $get);
        $dt_2303 = $this->get_dt("2303", $get);
        $dt_2304 = $this->get_dt("2304", $get);
        $dt_2305 = $this->get_dt("2305", $get);
        $dt_2390 = $this->get_dt("2390", $get);
        $dt_2_tot = $this->get_plus($dt_2301, $dt_2302, $dt_2303, $dt_2304, $dt_2305, $dt_2390);
        
        $dt_3301 = $this->get_dt("3301", $get);
        $dt_3302 = $this->get_dt("3302", $get);
        $dt_3303 = $this->get_dt("3303", $get);
        $dt_3304 = $this->get_dt("3304", $get);
        $dt_3309 = $this->get_dt("3309", $get);
        $dt_3_tot = $this->get_plus($dt_3301, $dt_3302, $dt_3303, $dt_3304, $dt_3309, $dt0);
        
        $dt_4301 = $this->get_dt("4301", $get);
        $dt_4302 = $this->get_dt("4302", $get);
        $dt_4303 = $this->get_dt("4303", $get);
        $dt_4_tot = $this->get_plus($dt_4301, $dt_4302, $dt_4303, $dt0, $dt0, $dt0);
        
        $dt_5301 = $this->get_dt("5301", $get);
        $dt_5390 = $this->get_dt("5390", $get);
        $dt_5391 = $this->get_dt("5391", $get);
        $dt_5_tot = $this->get_plus($dt_5301, $dt_5390, $dt_5391, $dt0, $dt0, $dt0);
        
        $dt_7301 = $this->get_dt("7301", $get);
        $dt_7302 = $this->get_dt("7302", $get);
        $dt_7303 = $this->get_dt("7303", $get);
        $dt_7304 = $this->get_dt("7304", $get);
        $dt_7305 = $this->get_dt("7305", $get);
        $dt_7308 = $this->get_dt("7308", $get);
        $dt_7_tot = $this->get_plus($dt_7301, $dt_7302, $dt_7303, $dt_7304, $dt_7305, $dt_7308, $dt0);
        $dt_tot = $this->get_plus($dt_2_tot, $dt_3_tot, $dt_4_tot, $dt_5_tot, $dt_7_tot, $dt0);
        $tampil = '{"total_cement":40,"rows":[
            {"desc":"&nbsp;&nbsp;2301 - Plant Gresik"' . $dt_2301[0] . '},
            {"desc":"&nbsp;&nbsp;2302 - Plant Tuban I"' . $dt_2302[0] . '},
            {"desc":"&nbsp;&nbsp;2303 - Plant Tuban II"' . $dt_2303[0] . '},
            {"desc":"&nbsp;&nbsp;2304 - Plant Tuban III"' . $dt_2304[0] . '},
            {"desc":"&nbsp;&nbsp;2305 - Plant Tuban IV"' . $dt_2305[0] . '},
            {"desc":"&nbsp;&nbsp;2390 - Plant Tuban IV Com DONOTUSE"' . $dt_2390[0] . '},
            {"desc":"Total Semen Indonesia"' . $dt_2_tot[0] . '},
            {"desc":"&nbsp;&nbsp;3301 - Plant Indarung I"' . $dt_3301[0] . '},
            {"desc":"&nbsp;&nbsp;3302 - Plant Indarung II/III"' . $dt_3302[0] . '},
            {"desc":"&nbsp;&nbsp;3303 - Plant Indarung IV"' . $dt_3303[0] . '},
            {"desc":"&nbsp;&nbsp;3304 - Plant Indarung V"' . $dt_3304[0] . '},
            {"desc":"&nbsp;&nbsp;3309 - Plant Cement Mill Dumai "' . $dt_3309[0] . '},
            {"desc":"Total Semen Padang"' . $dt_3_tot[0] . '},
            {"desc":"&nbsp;&nbsp;4301 - Plant Tonasa II & III"' . $dt_4301[0] . '},
            {"desc":"&nbsp;&nbsp;4302 - Plant Tonasa IV"' . $dt_4302[0] . '},
            {"desc":"&nbsp;&nbsp;4303 - Plant Tonasa V"' . $dt_4303[0] . '},
            {"desc":"Total Semen Tonasa"' . $dt_4_tot[0] . '},
            {"desc":"&nbsp;&nbsp;5301 - Plant Rembang"' . $dt_5301[0] . '},
            {"desc":"&nbsp;&nbsp;5390 - Plant Rembang Comissioning"' . $dt_5390[0] . '},
            {"desc":"&nbsp;&nbsp;5391 - Plant Pabrik Rembang"' . $dt_5391[0] . '},
            {"desc":"Total Semen Gresik"' . $dt_5_tot[0] . '},
            {"desc":"&nbsp;&nbsp;7301 - Plant Gresik"' . $dt_7301[0] . '},
            {"desc":"&nbsp;&nbsp;7302 - Plant Tuban I"' . $dt_7302[0] . '},
            {"desc":"&nbsp;&nbsp;7303 - Plant Tuban II"' . $dt_7303[0] . '},
            {"desc":"&nbsp;&nbsp;7304 - Plant Tuban III"' . $dt_7304[0] . '},
            {"desc":"&nbsp;&nbsp;7305 - Plant Tuban IV"' . $dt_7305[0] . '},
            {"desc":"&nbsp;&nbsp;7308 - Plant Cigading (SG)"' . $dt_7308[0] . '},
            {"desc":"Total VO Semen Indonesia"' . $dt_7_tot[0] . '},
            {"desc":"Total Group"' . $dt_tot[0] . '}
        ]}';
        echo $tampil;
    }

    public function show_clinker() {
        for ($i = 1; $i <= 12; $i++) {
            $dt0[$i] = 0;
        }
        $time = isset($_GET['time']) ? $_GET['time'] : NULL;
        $get = $this->m_finance_prod->get_comparison_clinker($time);

         $dt_2301 = $this->get_dt("2301", $get);
        $dt_2302 = $this->get_dt("2302", $get);
        $dt_2303 = $this->get_dt("2303", $get);
        $dt_2304 = $this->get_dt("2304", $get);
        $dt_2305 = $this->get_dt("2305", $get);
        $dt_2390 = $this->get_dt("2390", $get);
        $dt_2_tot = $this->get_plus($dt_2301, $dt_2302, $dt_2303, $dt_2304, $dt_2305, $dt_2390);
        
        $dt_3301 = $this->get_dt("3301", $get);
        $dt_3302 = $this->get_dt("3302", $get);
        $dt_3303 = $this->get_dt("3303", $get);
        $dt_3304 = $this->get_dt("3304", $get);
        $dt_3309 = $this->get_dt("3309", $get);
        $dt_3_tot = $this->get_plus($dt_3301, $dt_3302, $dt_3303, $dt_3304, $dt_3309, $dt0);
        
        $dt_4301 = $this->get_dt("4301", $get);
        $dt_4302 = $this->get_dt("4302", $get);
        $dt_4303 = $this->get_dt("4303", $get);
        $dt_4_tot = $this->get_plus($dt_4301, $dt_4302, $dt_4303, $dt0, $dt0, $dt0);
        
        $dt_5301 = $this->get_dt("5301", $get);
        $dt_5390 = $this->get_dt("5390", $get);
        $dt_5391 = $this->get_dt("5391", $get);
        $dt_5_tot = $this->get_plus($dt_5301, $dt_5390, $dt_5391, $dt0, $dt0, $dt0);
        
        $dt_7302 = $this->get_dt("7302", $get);
        $dt_7303 = $this->get_dt("7303", $get);
        $dt_7304 = $this->get_dt("7304", $get);
        $dt_7305 = $this->get_dt("7305", $get);
        $dt_7308 = $this->get_dt("7308", $get);
        $dt_7_tot = $this->get_plus($dt0, $dt_7302, $dt_7303, $dt_7304, $dt_7305, $dt_7308, $dt0);
        $dt_tot = $this->get_plus($dt_2_tot, $dt_3_tot, $dt_4_tot, $dt_5_tot, $dt_7_tot, $dt0);
        $tampil = '{"total_clinker":40,"rows":[
            {"desc":"&nbsp;&nbsp;2301 - Plant Gresik"' . $dt_2301[0] . '},
            {"desc":"&nbsp;&nbsp;2302 - Plant Tuban I"' . $dt_2302[0] . '},
            {"desc":"&nbsp;&nbsp;2303 - Plant Tuban II"' . $dt_2303[0] . '},
            {"desc":"&nbsp;&nbsp;2304 - Plant Tuban III"' . $dt_2304[0] . '},
            {"desc":"&nbsp;&nbsp;2305 - Plant Tuban IV"' . $dt_2305[0] . '},
            {"desc":"&nbsp;&nbsp;2390 - Plant Tuban IV Com DONOTUSE"' . $dt_2390[0] . '},
            {"desc":"Total Semen Indonesia"' . $dt_2_tot[0] . '},
            {"desc":"&nbsp;&nbsp;3301 - Plant Indarung I"' . $dt_3301[0] . '},
            {"desc":"&nbsp;&nbsp;3302 - Plant Indarung II/III"' . $dt_3302[0] . '},
            {"desc":"&nbsp;&nbsp;3303 - Plant Indarung IV"' . $dt_3303[0] . '},
            {"desc":"&nbsp;&nbsp;3304 - Plant Indarung V"' . $dt_3304[0] . '},
            {"desc":"&nbsp;&nbsp;3309 - Plant Cement Mill Dumai "' . $dt_3309[0] . '},
            {"desc":"Total Semen Padang"' . $dt_3_tot[0] . '},
            {"desc":"&nbsp;&nbsp;4301 - Plant Tonasa II & III"' . $dt_4301[0] . '},
            {"desc":"&nbsp;&nbsp;4302 - Plant Tonasa IV"' . $dt_4302[0] . '},
            {"desc":"&nbsp;&nbsp;4303 - Plant Tonasa V"' . $dt_4303[0] . '},
            {"desc":"Total Semen Tonasa"' . $dt_4_tot[0] . '},
            {"desc":"&nbsp;&nbsp;5301 - Plant Rembang"' . $dt_5301[0] . '},
            {"desc":"&nbsp;&nbsp;5390 - Plant Rembang Comissioning"' . $dt_5390[0] . '},
            {"desc":"&nbsp;&nbsp;5391 - Plant Pabrik Rembang"' . $dt_5391[0] . '},
            {"desc":"Total Semen Gresik"' . $dt_5_tot[0] . '},
            {"desc":"&nbsp;&nbsp;7302 - Plant Tuban I"' . $dt_7302[0] . '},
            {"desc":"&nbsp;&nbsp;7303 - Plant Tuban II"' . $dt_7303[0] . '},
            {"desc":"&nbsp;&nbsp;7304 - Plant Tuban III"' . $dt_7304[0] . '},
            {"desc":"&nbsp;&nbsp;7305 - Plant Tuban IV"' . $dt_7305[0] . '},
            {"desc":"&nbsp;&nbsp;7308 - Plant Cigading (SG)"' . $dt_7308[0] . '},
            {"desc":"Total VO Semen Indonesia"' . $dt_7_tot[0] . '},
            {"desc":"Total Group"' . $dt_tot[0] . '}
        ]}';
        echo $tampil;
    }


    public function get_dt_perform($plant, $get) {
        for ($i = 1; $i <= 12; $i++) {
            $dt[$i] = isset($get[$i][$plant])?$get[$i][$plant]:0;
        }
        
        $dt[0] = "";
        $dt[99] = "";
        for ($i = 1; $i <= 12; $i++) {
            $sh_2301 = $dt[0] . ',"val' . $i . '":"' . number_format($dt[$i], 2, '.', '') . '"';
            $dt[0] = $sh_2301;
            $dw_2301 = $dt[99] . "<td>" . number_format($dt[$i], 0, '.', '') . "</td>";
            $dt[99] = $dw_2301;
        }
        $dt[13] = array_sum($dt);
        $dt[0] = $dt[0] . ',"val13":"' . number_format($dt[13], 0, '.', '') . '"';
        $dt[99] = $dt[99] . "<td>" . number_format($dt[13], 0, '.', '') . "</td>";
        return $dt;
    }
    
    public function get_plus_perform($dt1, $dt2, $dt3, $dt4, $dt5, $dt6){
        for ($i = 1; $i <= 13; $i++) {
            $dt[$i] = $dt1[$i]+$dt2[$i]+$dt3[$i]+$dt4[$i]+$dt5[$i]+$dt6[$i];
        }

        $dt[0] = "";
        $dt[99] = "";
        for ($i = 1; $i <= 13; $i++) {
            $sh_2301 = $dt[0] . ',"val' . $i . '":"' . number_format($dt[$i], 0, '.', '') . '"';
            $dt[0] = $sh_2301;
            $dw_2301 = $dt[99] . "<td>" . number_format($dt[$i], 0, '.', '') . "</td>";
            $dt[99] = $dw_2301;
        }
        return $dt;
    }

    public function show_perform_cement() {
        for ($i = 1; $i <= 13; $i++) {
            $dt0[$i] = 0;
        }
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $cate = "ACT";
        $get = $this->m_finance_prod->get_performance_cement($year, $cate);

        $dt_2301 = $this->get_dt_perform("2301", $get);
        $dt_2302 = $this->get_dt_perform("2302", $get);
        $dt_2303 = $this->get_dt_perform("2303", $get);
        $dt_2304 = $this->get_dt_perform("2304", $get);
        $dt_2305 = $this->get_dt_perform("2305", $get);
        $dt_2390 = $this->get_dt_perform("2390", $get);
        $dt_2_tot = $this->get_plus_perform($dt_2301, $dt_2302, $dt_2303, $dt_2304, $dt_2305, $dt_2390);
        
        $dt_3301 = $this->get_dt_perform("3301", $get);
        $dt_3302 = $this->get_dt_perform("3302", $get);
        $dt_3303 = $this->get_dt_perform("3303", $get);
        $dt_3304 = $this->get_dt_perform("3304", $get);
        $dt_3309 = $this->get_dt_perform("3309", $get);
        $dt_3_tot = $this->get_plus_perform($dt_3301, $dt_3302, $dt_3303, $dt_3304, $dt_3309, $dt0);
        
        $dt_4301 = $this->get_dt_perform("4301", $get);
        $dt_4302 = $this->get_dt_perform("4302", $get);
        $dt_4303 = $this->get_dt_perform("4303", $get);
        $dt_4_tot = $this->get_plus_perform($dt_4301, $dt_4302, $dt_4303, $dt0, $dt0, $dt0);
        
        $dt_5301 = $this->get_dt_perform("5301", $get);
        $dt_5390 = $this->get_dt_perform("5390", $get);
        $dt_5391 = $this->get_dt_perform("5391", $get);
        $dt_5_tot = $this->get_plus_perform($dt_5301, $dt_5390, $dt_5391, $dt0, $dt0, $dt0);
        
        $dt_7301 = $this->get_dt_perform("7301", $get);
        $dt_7302 = $this->get_dt_perform("7302", $get);
        $dt_7303 = $this->get_dt_perform("7303", $get);
        $dt_7304 = $this->get_dt_perform("7304", $get);
        $dt_7305 = $this->get_dt_perform("7305", $get);
        $dt_7308 = $this->get_dt_perform("7308", $get);
        $dt_7_tot = $this->get_plus_perform($dt_7301, $dt_7302, $dt_7303, $dt_7304, $dt_7305, $dt_7308, $dt0);
        $dt_tot = $this->get_plus_perform($dt_2_tot, $dt_3_tot, $dt_4_tot, $dt_5_tot, $dt_7_tot, $dt0);
        $tampil = '{"total_cement":40,"rows":[
            {"desc":"&nbsp;&nbsp;2301 - Plant Gresik"' . $dt_2301[0] . '},
            {"desc":"&nbsp;&nbsp;2302 - Plant Tuban I"' . $dt_2302[0] . '},
            {"desc":"&nbsp;&nbsp;2303 - Plant Tuban II"' . $dt_2303[0] . '},
            {"desc":"&nbsp;&nbsp;2304 - Plant Tuban III"' . $dt_2304[0] . '},
            {"desc":"&nbsp;&nbsp;2305 - Plant Tuban IV"' . $dt_2305[0] . '},
            {"desc":"&nbsp;&nbsp;2390 - Plant Tuban IV Com DONOTUSE"' . $dt_2390[0] . '},
            {"desc":"Total Semen Indonesia"' . $dt_2_tot[0] . '},
            {"desc":"&nbsp;&nbsp;3301 - Plant Indarung I"' . $dt_3301[0] . '},
            {"desc":"&nbsp;&nbsp;3302 - Plant Indarung II/III"' . $dt_3302[0] . '},
            {"desc":"&nbsp;&nbsp;3303 - Plant Indarung IV"' . $dt_3303[0] . '},
            {"desc":"&nbsp;&nbsp;3304 - Plant Indarung V"' . $dt_3304[0] . '},
            {"desc":"&nbsp;&nbsp;3309 - Plant Cement Mill Dumai "' . $dt_3309[0] . '},
            {"desc":"Total Semen Padang"' . $dt_3_tot[0] . '},
            {"desc":"&nbsp;&nbsp;4301 - Plant Tonasa II & III"' . $dt_4301[0] . '},
            {"desc":"&nbsp;&nbsp;4302 - Plant Tonasa IV"' . $dt_4302[0] . '},
            {"desc":"&nbsp;&nbsp;4303 - Plant Tonasa V"' . $dt_4303[0] . '},
            {"desc":"Total Semen Tonasa"' . $dt_4_tot[0] . '},
            {"desc":"&nbsp;&nbsp;5301 - Plant Rembang"' . $dt_5301[0] . '},
            {"desc":"&nbsp;&nbsp;5390 - Plant Rembang Comissioning"' . $dt_5390[0] . '},
            {"desc":"&nbsp;&nbsp;5391 - Plant Pabrik Rembang"' . $dt_5391[0] . '},
            {"desc":"Total Semen Gresik"' . $dt_5_tot[0] . '},
            {"desc":"&nbsp;&nbsp;7301 - Plant Gresik"' . $dt_7301[0] . '},
            {"desc":"&nbsp;&nbsp;7302 - Plant Tuban I"' . $dt_7302[0] . '},
            {"desc":"&nbsp;&nbsp;7303 - Plant Tuban II"' . $dt_7303[0] . '},
            {"desc":"&nbsp;&nbsp;7304 - Plant Tuban III"' . $dt_7304[0] . '},
            {"desc":"&nbsp;&nbsp;7305 - Plant Tuban IV"' . $dt_7305[0] . '},
            {"desc":"&nbsp;&nbsp;7308 - Plant Cigading (SG)"' . $dt_7308[0] . '},
            {"desc":"Total VO Semen Indonesia"' . $dt_7_tot[0] . '},
            {"desc":"Total Group"' . $dt_tot[0] . '}
        ]}';
        echo $tampil;
    }
    public function show_perform_clinker() {
        for ($i = 1; $i <= 13; $i++) {
            $dt0[$i] = 0;
        }
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $cate = "ACT";
        $get = $this->m_finance_prod->get_performance_clinker($year, $cate);

        $dt_2301 = $this->get_dt_perform("2301", $get);
        $dt_2302 = $this->get_dt_perform("2302", $get);
        $dt_2303 = $this->get_dt_perform("2303", $get);
        $dt_2304 = $this->get_dt_perform("2304", $get);
        $dt_2305 = $this->get_dt_perform("2305", $get);
        $dt_2390 = $this->get_dt_perform("2390", $get);
        $dt_2_tot = $this->get_plus_perform($dt_2301, $dt_2302, $dt_2303, $dt_2304, $dt_2305, $dt_2390);
        
        $dt_3301 = $this->get_dt_perform("3301", $get);
        $dt_3302 = $this->get_dt_perform("3302", $get);
        $dt_3303 = $this->get_dt_perform("3303", $get);
        $dt_3304 = $this->get_dt_perform("3304", $get);
        $dt_3309 = $this->get_dt_perform("3309", $get);
        $dt_3_tot = $this->get_plus_perform($dt_3301, $dt_3302, $dt_3303, $dt_3304, $dt_3309, $dt0);
        
        $dt_4301 = $this->get_dt_perform("4301", $get);
        $dt_4302 = $this->get_dt_perform("4302", $get);
        $dt_4303 = $this->get_dt_perform("4303", $get);
        $dt_4_tot = $this->get_plus_perform($dt_4301, $dt_4302, $dt_4303, $dt0, $dt0, $dt0);
        
        $dt_5301 = $this->get_dt_perform("5301", $get);
        $dt_5390 = $this->get_dt_perform("5390", $get);
        $dt_5391 = $this->get_dt_perform("5391", $get);
        $dt_5_tot = $this->get_plus_perform($dt_5301, $dt_5390, $dt_5391, $dt0, $dt0, $dt0);
        
        $dt_7301 = $this->get_dt_perform("7301", $get);
        $dt_7302 = $this->get_dt_perform("7302", $get);
        $dt_7303 = $this->get_dt_perform("7303", $get);
        $dt_7304 = $this->get_dt_perform("7304", $get);
        $dt_7305 = $this->get_dt_perform("7305", $get);
        $dt_7308 = $this->get_dt_perform("7308", $get);
        $dt_7_tot = $this->get_plus_perform($dt_7301, $dt_7302, $dt_7303, $dt_7304, $dt_7305, $dt_7308, $dt0);
        $dt_tot = $this->get_plus_perform($dt_2_tot, $dt_3_tot, $dt_4_tot, $dt_5_tot, $dt_7_tot, $dt0);
        $tampil = '{"total_clinker":40,"rows":[
            {"desc":"&nbsp;&nbsp;2301 - Plant Gresik"' . $dt_2301[0] . '},
            {"desc":"&nbsp;&nbsp;2302 - Plant Tuban I"' . $dt_2302[0] . '},
            {"desc":"&nbsp;&nbsp;2303 - Plant Tuban II"' . $dt_2303[0] . '},
            {"desc":"&nbsp;&nbsp;2304 - Plant Tuban III"' . $dt_2304[0] . '},
            {"desc":"&nbsp;&nbsp;2305 - Plant Tuban IV"' . $dt_2305[0] . '},
            {"desc":"&nbsp;&nbsp;2390 - Plant Tuban IV Com DONOTUSE"' . $dt_2390[0] . '},
            {"desc":"Total Semen Indonesia"' . $dt_2_tot[0] . '},
            {"desc":"&nbsp;&nbsp;3301 - Plant Indarung I"' . $dt_3301[0] . '},
            {"desc":"&nbsp;&nbsp;3302 - Plant Indarung II/III"' . $dt_3302[0] . '},
            {"desc":"&nbsp;&nbsp;3303 - Plant Indarung IV"' . $dt_3303[0] . '},
            {"desc":"&nbsp;&nbsp;3304 - Plant Indarung V"' . $dt_3304[0] . '},
            {"desc":"&nbsp;&nbsp;3309 - Plant Cement Mill Dumai "' . $dt_3309[0] . '},
            {"desc":"Total Semen Padang"' . $dt_3_tot[0] . '},
            {"desc":"&nbsp;&nbsp;4301 - Plant Tonasa II & III"' . $dt_4301[0] . '},
            {"desc":"&nbsp;&nbsp;4302 - Plant Tonasa IV"' . $dt_4302[0] . '},
            {"desc":"&nbsp;&nbsp;4303 - Plant Tonasa V"' . $dt_4303[0] . '},
            {"desc":"Total Semen Tonasa"' . $dt_4_tot[0] . '},
            {"desc":"&nbsp;&nbsp;5301 - Plant Rembang"' . $dt_5301[0] . '},
            {"desc":"&nbsp;&nbsp;5390 - Plant Rembang Comissioning"' . $dt_5390[0] . '},
            {"desc":"&nbsp;&nbsp;5391 - Plant Pabrik Rembang"' . $dt_5391[0] . '},
            {"desc":"Total Semen Gresik"' . $dt_5_tot[0] . '},
            {"desc":"&nbsp;&nbsp;7301 - Plant Gresik"' . $dt_7301[0] . '},
            {"desc":"&nbsp;&nbsp;7302 - Plant Tuban I"' . $dt_7302[0] . '},
            {"desc":"&nbsp;&nbsp;7303 - Plant Tuban II"' . $dt_7303[0] . '},
            {"desc":"&nbsp;&nbsp;7304 - Plant Tuban III"' . $dt_7304[0] . '},
            {"desc":"&nbsp;&nbsp;7305 - Plant Tuban IV"' . $dt_7305[0] . '},
            {"desc":"&nbsp;&nbsp;7308 - Plant Cigading (SG)"' . $dt_7308[0] . '},
            {"desc":"Total VO Semen Indonesia"' . $dt_7_tot[0] . '},
            {"desc":"Total Group"' . $dt_tot[0] . '}
        ]}';
        echo $tampil;
    }
}
