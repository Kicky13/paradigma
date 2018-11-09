<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header("Access-Control-Allow-Origin: *");

class finance_cost extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_finance_cost');
    }

    public function get_company() {
        $data = $this->m_finance_cost->get_company();
        echo json_encode($data);
    }
        
    public function dataarray($data){
            $nilai=array();
            $i=0;
            foreach($data as $d){
                    $nilai[$i]=$d['JUMLAH'];
                    $i++;
            }
            return $nilai;
    }

    public function data_trend(){
        $year           = isset($_GET['year']) ? $_GET['year'] : null;
        $month          = isset($_GET['month']) ? $_GET['month'] : null;
        $comp           = isset($_GET['comp']) ? $_GET['comp'] : null; 
        $comp           = str_replace(",","','",$comp);
        $date           = $year.'.'.$month;
        $date_last      = ((float)$year-1).'.'.$month;

        // print_r($this->get_data_trend($year, $month, $comp, $date, $date_last));exit;
        // $this=>get_data_trend($year, $month, $comp, $date, $date_last);

        $viewMonth=array();

        $selmonth = $month;
        $nl='0';
        for($i=$selmonth+1;$i<=12;$i++){
            if($i>9){
                $nl='';
            }
            $viewMonth[] = array('year'=>($year-1), 'month'=>$i, 'date'=>($year-1).'.'.$nl.$i, 'date_last'=>($year-2).'.'.$nl.$i);
        }
        $nl='0';
        for($i=1;$i<=$selmonth;$i++){
            if($i>9){
                $nl='';
            }
            $viewMonth[] = array('year'=>$year, 'month'=>$i, 'date'=>$year.'.'.$nl.$i, 'date_last'=>($year-1).'.'.$nl.$i);
        }

        $resultx=array();
        foreach($viewMonth as $months => $value){
            $resultx[] = $this->get_data_trend($value['year'], $value['month'], $comp, $value['date'], $value['date_last']);
        }
        echo json_encode($resultx);
    }
    public function get_data_trend($year, $month, $comp, $date, $date_last){

        $clinker        = array();
        $cement         = array();
        $plant = "''"; $plant2 = "''";
        if($comp == '2000'){
            $plant      = "'2301','2302','2303','2304','2305','2390'";
            $plant2     = "'2301','2302','2303','2304','2305','2390'";
        }else if($comp == '3000'){
            $plant      = "'3301','3302','3303','3304','3309'";
            $plant2     = "'3301','3302','3303','3304','3309'";
        }else if($comp == '4000'){
            $plant      = "'4301','4302','4303'";
            $plant2     = "'4301','4302','4303'";
        }else if($comp == '7000'){
            $plant      = "'7302','7303','7304','7305'";
            $plant2     = "'7301','7302','7303','7304','7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'2301','2302','2303','2304','2305','2390','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','7301','7302','7303','7304','7305'";
        }else if($comp == 'Consolidation'){
            $plant      = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7301','7302','7303','7304','7305'";
            $comp       = "2000','3000','4000','5000','7000";
        }else if($comp == '5000'){
            $plant      = "'5302','5303','5304','5305'";
            $plant2     = "'5301','5302','5303','5304','5305'";
        }
        
        //OLAH DATE TO BETWEEN========================================================
        $temp           = $this->date_between($date);
        $type           = $this->m_finance_cost->cek_company($comp)->PARENTH2;
        $bawah          = $this->m_finance_cost->bawah($comp, $date, $date_last, $temp[0], $temp[1], $type);
        $data2          = $this->set_data_b($bawah);
        
        $datta          = $this->m_finance_cost->atas("'$date'","'$date_last'",$temp[0],$temp[1],$comp, $plant2);
        $nilai          = $this->dataarray($datta);
        $clinker[0]     = $nilai[0];
        $clinker[1]     = $nilai[3];
        $clinker[2]     = $nilai[6];
        $clinker[3]     = $this->division($clinker[1], $clinker[0]);
        $clinker[4]     = $this->division($clinker[1], $clinker[2]);
        $clinker[5]     = $nilai[9];
        $clinker[6]     = $nilai[12];
        $clinker[7]     = $nilai[15];
        $clinker[8]     = $this->division($clinker[6], $clinker[5]);
        $clinker[9]     = $this->division($clinker[6], $clinker[7]);
        $cement[0]      = $nilai[1];
        $cement[1]      = $nilai[4];
        $cement[2]      = $nilai[7];
        $cement[3]      = $this->division($cement[1], $cement[0]);
        $cement[4]      = $this->division($cement[1], $cement[2]);
        $cement[5]      = $nilai[10];
        $cement[6]      = $nilai[13];
        $cement[7]      = $nilai[16];
        $cement[8]      = $this->division($cement[6], $cement[5]);
        $cement[9]      = $this->division($cement[6], $cement[7]);
        $sales[0]       = $nilai[2];
        $sales[1]       = $nilai[5];
        $sales[2]       = $nilai[8];
        $sales[3]       = $this->division($sales[1], $sales[0]);
        $sales[4]       = $this->division($sales[1], $sales[2]);
        $sales[5]       = $nilai[11];
        $sales[6]       = $nilai[14];
        $sales[7]       = $nilai[17];
        $sales[8]       = $this->division($sales[6], $sales[5]);
        $sales[9]       = $this->division($sales[6], $sales[7]);
        //=======================================================================================================
        $index  = $data2[0]['index'];
        $index2 = 0;
        //SET AMOUNT PER TONAGE==================================================================================
        $total_cogm    = array();
        $total_cogs    = array();
        $total_adm     = array();
        $total_sls     = array();
        $total_exp     = array();
        $total_exp[0]  = 0; $total_exp[1]  = 0; $total_exp[2]  = 0; $total_exp[3]  = 0; $total_exp[4]  = 0; $total_exp[5]  = 0;
        $total_cogm[0] = 0; $total_cogm[1] = 0; $total_cogm[2] = 0; $total_cogm[3] = 0; $total_cogm[4] = 0; $total_cogm[5] = 0;
        $total_cogs[0] = 0; $total_cogs[1] = 0; $total_cogs[2] = 0; $total_cogs[3] = 0; $total_cogs[4] = 0; $total_cogs[5] = 0;
        $total_adm[0]  = 0; $total_adm[1]  = 0; $total_adm[2]  = 0; $total_adm[3]  = 0; $total_adm[4]  = 0; $total_adm[5]  = 0;
        $total_sls[0]  = 0; $total_sls[1]  = 0; $total_sls[2]  = 0; $total_sls[3]  = 0; $total_sls[4]  = 0; $total_sls[5]  = 0;
        
        foreach ($bawah as $key => $value) {
            $key = $key + $index;
            $data2[$key]['GL_ACCOUNT']     = $value->DESC_INDO;
            if($value->DESC_INDO == "<b>Harga Pokok Penjualan</b>"){
                $data2[$key]['BUD1']       = "";
                $data2[$key]['ACT1']       = "";
            }else{
                if($value->COST_GROUP == "HPP" || $value->COST_GROUP == "HPP2"){
                    $pembagi = $cement;
                }else{
                    $pembagi = $sales;
                }
                $bud1   = $this->division_np($value->BUD1, $pembagi[0]);
                $act1   = $this->division_np($value->ACT1, $pembagi[1]);
                $data2[$key]['BUD1']       = $this->num_format($bud1);
                $data2[$key]['ACT1']       = $this->num_format($act1);
            }
            
            
            //GET NILAI TOTAL===============================================================================================
            if($value->COST_GROUP == "HPP")         { $total_cogm = $this->set_total($total_cogm, $value, $cement); }
            else if($value->COST_GROUP == "HPP2")   { $total_cogs = $this->set_total($total_cogs, $value, $cement); }
            $index2 = $index2 + $key;
        }
        
        //SET TOTAL======================================================================================================
        //echopre($bawah); exit;

        foreach($bawah as $key => $value){
            $key = $key + $index;
            if($value->COST_GROUP == "TOTAL_COGM"){
                $data2[$key] = $this->tampil_total($data2[$key], $total_cogm);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogm[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_COGS"){
                $data2[$key]['BUD1']       = $this->num_format($total_cogm[0]+$total_cogs[0]);
                $data2[$key]['ACT1']       = $this->num_format($total_cogm[1]+$total_cogs[1]);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogs[$i];
                }
            }
        }
        $index2++;
        // $this->session->set_userdata("data_cost_report", json_encode($dataa));
        return $data2;
    }




    public function get_data(){

        $year           = isset($_GET['year']) ? $_GET['year'] : null;
        $month          = isset($_GET['month']) ? $_GET['month'] : null;
        $comp           = isset($_GET['comp']) ? $_GET['comp'] : null; 
        $comp           = str_replace(",","','",$comp);
        $date           = $year.'.'.$month;
        $date_last      = ((float)$year-1).'.'.$month;

        // print_r($date_last);exit;
        
        //GET DATA PRODUCTION====================================================================
        $clinker        = array();
        $cement         = array();
        $plant = "''"; $plant2 = "''";
        if($comp == '2000'){
            $plant      = "'2301','2302','2303','2304','2305','2390'";
            $plant2     = "'2301','2302','2303','2304','2305','2390'";
        }else if($comp == '3000'){
            $plant      = "'3301','3302','3303','3304','3309'";
            $plant2     = "'3301','3302','3303','3304','3309'";
        }else if($comp == '4000'){
            $plant      = "'4301','4302','4303'";
            $plant2     = "'4301','4302','4303'";
        }else if($comp == '7000'){
            $plant      = "'7302','7303','7304','7305'";
            $plant2     = "'7301','7302','7303','7304','7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'2301','2302','2303','2304','2305','2390','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','7301','7302','7303','7304','7305'";
        }else if($comp == 'Consolidation'){
            $plant      = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7301','7302','7303','7304','7305'";
            $comp       = "2000','3000','4000','5000','7000";
        }else if($comp == '5000'){
            $plant      = "'5302','5303','5304','5305'";
            $plant2     = "'5301','5302','5303','5304','5305'";
        }
        
        //OLAH DATE TO BETWEEN========================================================
        $temp           = $this->date_between($date);
        $type           = $this->m_finance_cost->cek_company($comp)->PARENTH2;
        $bawah          = $this->m_finance_cost->bawah($comp, $date, $date_last, $temp[0], $temp[1], $type);
        $data2          = $this->set_data_b($bawah);
        
        $datta          = $this->m_finance_cost->atas("'$date'","'$date_last'",$temp[0],$temp[1],$comp, $plant2);
        $nilai          = $this->dataarray($datta);
        $clinker[0]     = $nilai[0];
        $clinker[1]     = $nilai[3];
        $clinker[2]     = $nilai[6];
        $clinker[3]     = $this->division($clinker[1], $clinker[0]);
        $clinker[4]     = $this->division($clinker[1], $clinker[2]);
        $clinker[5]     = $nilai[9];
        $clinker[6]     = $nilai[12];
        $clinker[7]     = $nilai[15];
        $clinker[8]     = $this->division($clinker[6], $clinker[5]);
        $clinker[9]     = $this->division($clinker[6], $clinker[7]);
        $cement[0]      = $nilai[1];
        $cement[1]      = $nilai[4];
        $cement[2]      = $nilai[7];
        $cement[3]      = $this->division($cement[1], $cement[0]);
        $cement[4]      = $this->division($cement[1], $cement[2]);
        $cement[5]      = $nilai[10];
        $cement[6]      = $nilai[13];
        $cement[7]      = $nilai[16];
        $cement[8]      = $this->division($cement[6], $cement[5]);
        $cement[9]      = $this->division($cement[6], $cement[7]);
        $sales[0]       = $nilai[2];
        $sales[1]       = $nilai[5];
        $sales[2]       = $nilai[8];
        $sales[3]       = $this->division($sales[1], $sales[0]);
        $sales[4]       = $this->division($sales[1], $sales[2]);
        $sales[5]       = $nilai[11];
        $sales[6]       = $nilai[14];
        $sales[7]       = $nilai[17];
        $sales[8]       = $this->division($sales[6], $sales[5]);
        $sales[9]       = $this->division($sales[6], $sales[7]);
        //=======================================================================================================
        $index  = $data2[0]['index'];
        $index2 = 0;
        //SET AMOUNT PER TONAGE==================================================================================
        $total_cogm    = array();
        $total_cogs    = array();
        $total_adm     = array();
        $total_sls     = array();
        $total_exp     = array();
        $total_exp[0]  = 0; $total_exp[1]  = 0; $total_exp[2]  = 0; $total_exp[3]  = 0; $total_exp[4]  = 0; $total_exp[5]  = 0;
        $total_cogm[0] = 0; $total_cogm[1] = 0; $total_cogm[2] = 0; $total_cogm[3] = 0; $total_cogm[4] = 0; $total_cogm[5] = 0;
        $total_cogs[0] = 0; $total_cogs[1] = 0; $total_cogs[2] = 0; $total_cogs[3] = 0; $total_cogs[4] = 0; $total_cogs[5] = 0;
        $total_adm[0]  = 0; $total_adm[1]  = 0; $total_adm[2]  = 0; $total_adm[3]  = 0; $total_adm[4]  = 0; $total_adm[5]  = 0;
        $total_sls[0]  = 0; $total_sls[1]  = 0; $total_sls[2]  = 0; $total_sls[3]  = 0; $total_sls[4]  = 0; $total_sls[5]  = 0;
        
        foreach ($bawah as $key => $value) {
            $key = $key + $index;
            $data2[$key]['GL_ACCOUNT']     = $value->DESC_INDO;
            if($value->DESC_INDO == "<b>Harga Pokok Penjualan</b>" || $value->DESC_INDO == "<b>Umum & Administrasi</b>" || $value->DESC_INDO == "<b>Pengeluaran Penjualan & Pemasaran:</b>" || $value->DESC_INDO == ""){
                $data2[$key]['BUD1']       = "";
                $data2[$key]['ACT1']       = "";
                $data2[$key]['ACT11']      = "";
                $data2[$key]['PERSEN1']    = "";
                $data2[$key]['PERSEN11']   = "";
                $data2[$key]['BUD2']       = "";
                $data2[$key]['ACT2']       = "";
                $data2[$key]['ACT22']      = "";
                $data2[$key]['PERSEN2']    = "";
                $data2[$key]['PERSEN22']   = "";
            }else{
                if($value->COST_GROUP == "HPP" || $value->COST_GROUP == "HPP2"){
                    $pembagi = $cement;
                }else{
                    $pembagi = $sales;
                }
                $bud1   = $this->division_np($value->BUD1, $pembagi[0]);
                $act1   = $this->division_np($value->ACT1, $pembagi[1]);
                $act11  = $this->division_np($value->ACT11, $pembagi[2]);
                $bud2   = $this->division_np($value->BUD2, $pembagi[3]);
                $act2   = $this->division_np($value->ACT2, $pembagi[4]);
                $act22  = $this->division_np($value->ACT22, $pembagi[5]);
                $data2[$key]['BUD1']       = $this->num_format($bud1);
                $data2[$key]['ACT1']       = $this->num_format($act1);
                $data2[$key]['ACT11']      = $this->num_format($act11);
                $data2[$key]['PERSEN1']    = $this->beban($this->division($act1, $bud1));
                $data2[$key]['PERSEN11']   = $this->beban($this->division($act1, $act11));
                $data2[$key]['BUD2']       = $this->num_format($bud2);
                $data2[$key]['ACT2']       = $this->num_format($act2);
                $data2[$key]['ACT22']      = $this->num_format($act22);
                $data2[$key]['PERSEN2']    = $this->beban($this->division($act2, $bud2));
                $data2[$key]['PERSEN22']   = $this->beban($this->division($act2, $act22));
            }
            
            
            //GET NILAI TOTAL===============================================================================================
            if($value->COST_GROUP == "HPP")         { $total_cogm = $this->set_total($total_cogm, $value, $cement); }
            else if($value->COST_GROUP == "HPP2")   { $total_cogs = $this->set_total($total_cogs, $value, $cement); }
            else if($value->COST_GROUP == "ADM")    { $total_adm  = $this->set_total($total_adm, $value, $sales); }
            else if($value->COST_GROUP == "SALES")  { $total_sls  = $this->set_total($total_sls, $value, $sales); }
            $index2 = $index2 + $key;
        }
        
        //SET TOTAL======================================================================================================
        //echopre($bawah); exit;
        foreach($bawah as $key => $value){
            $key = $key + $index;
            if($value->COST_GROUP == "TOTAL_COGM"){
                $data2[$key] = $this->tampil_total($data2[$key], $total_cogm);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogm[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_COGS"){
                $data2[$key]['BUD1']       = $this->num_format($total_cogm[0]+$total_cogs[0]);
                $data2[$key]['ACT1']       = $this->num_format($total_cogm[1]+$total_cogs[1]);
                $data2[$key]['ACT11']      = $this->num_format($total_cogm[2]+$total_cogs[2]);
                $data2[$key]['PERSEN1']    = $this->beban($this->division($total_cogm[1]+$total_cogs[1], $total_cogm[0]+$total_cogs[0]));
                $data2[$key]['PERSEN11']   = $this->beban($this->division($total_cogm[1]+$total_cogs[1], $total_cogm[2]+$total_cogs[2]));
                $data2[$key]['BUD2']       = $this->num_format($total_cogm[3]+$total_cogs[3]);
                $data2[$key]['ACT2']       = $this->num_format($total_cogm[4]+$total_cogs[4]);
                $data2[$key]['ACT22']      = $this->num_format($total_cogm[5]+$total_cogs[5]);
                $data2[$key]['PERSEN2']    = $this->beban($this->division($total_cogm[4]+$total_cogs[4], $total_cogm[3]+$total_cogs[3]));
                $data2[$key]['PERSEN22']   = $this->beban($this->division($total_cogm[4]+$total_cogs[4], $total_cogm[5]+$total_cogs[5]));
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogs[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_ADM"){
                $data2[$key] = $this->tampil_total($data2[$key], $total_adm);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_adm[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_SALES"){
                $data2[$key] = $this->tampil_total($data2[$key], $total_sls);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_sls[$i];
                }
            }
        }
        
        $index2++;
        //SET TOTAL EXPENSE===============================================================================================
        $data2[$index2]['GL_ACCOUNT'] = "<b>Total Expense</b>";
        $data2[$index2]['BUD1']       = $this->num_format($total_exp[0]);
        $data2[$index2]['ACT1']       = $this->num_format($total_exp[1]);
        $data2[$index2]['ACT11']      = $this->num_format($total_exp[2]);
        $data2[$index2]['PERSEN1']    = $this->beban($this->division($total_exp[1], $total_exp[0]));
        $data2[$index2]['PERSEN11']   = $this->beban($this->division($total_exp[1], $total_exp[2]));
        $data2[$index2]['BUD2']       = $this->num_format($total_exp[3]);
        $data2[$index2]['ACT2']       = $this->num_format($total_exp[4]);
        $data2[$index2]['ACT22']      = $this->num_format($total_exp[5]);
        $data2[$index2]['PERSEN2']    = $this->beban($this->division($total_exp[4], $total_exp[3]));
        $data2[$index2]['PERSEN22']   = $this->beban($this->division($total_exp[4], $total_exp[5]));

        //FORMAT RUPIAH
        $clinker        = $this->format_array($clinker, 9);
        $cement         = $this->format_array($cement, 9);
        $sales          = $this->format_array($sales, 9);
        
//        $data1          = array(array( "GL_ACCOUNT" => "<b><i><span class='change_lang_eng'>Production</span><span class='change_lang_ina hidden'>Produksi</span></i></b>"   ),
//                                array( "GL_ACCOUNT" => "<i><span class='change_lang_eng'>Clinker</span><span class='change_lang_ina hidden'>Klinker</span></i>",            "BUD1" => $clinker[0],  "ACT1" => $clinker[1],  "ACT11" => $clinker[2], "PERSEN1" => $this->biaya($clinker[3].'%'),   "PERSEN11" => $this->biaya($clinker[4].'%'),  "BUD2" => $clinker[5],  "ACT2" => $clinker[6],  "ACT22" => $clinker[7], "PERSEN2" => $this->biaya($clinker[8].'%'),   "PERSEN22" => $this->biaya($clinker[9].'%')),
//                                array( "GL_ACCOUNT" => "<i><span class='change_lang_eng'>Cement</span><span class='change_lang_ina hidden'>Semen</span></i>",             "BUD1" => $cement[0],   "ACT1" => $cement[1],   "ACT11" => $cement[2],  "PERSEN1" => $this->biaya($cement[3].'%'),    "PERSEN11" => $this->biaya($cement[4].'%'),   "BUD2" => $cement[5],   "ACT2" => $cement[6],   "ACT22" => $cement[7],  "PERSEN2" => $this->biaya($cement[8].'%'),    "PERSEN22" => $this->biaya($cement[9].'%')),
//                                array( "GL_ACCOUNT" => "<i><span class='change_lang_eng'>Sales Volume</span><span class='change_lang_ina hidden'>Volume Penjualan</span></i>",       "BUD1" => $sales[0],    "ACT1" => $sales[1],    "ACT11" => $sales[2],   "PERSEN1" => $this->biaya($sales[3].'%'),     "PERSEN11" => $this->biaya($sales[4].'%'),    "BUD2" => $sales[5],    "ACT2" => $sales[6],    "ACT22" => $sales[7],   "PERSEN2" => $this->biaya($sales[8].'%'),     "PERSEN22" => $this->biaya($sales[9].'%')),
//                                array( "GL_ACCOUNT" => ""                           ),
//                          );
        
        $data1          = array(array( "GL_ACCOUNT" => "<b><i>Production</i></b>"   ),
                                array( "GL_ACCOUNT" => "<i>Clinker</i>",            "BUD1" => $clinker[0],  "ACT1" => $clinker[1],  "ACT11" => $clinker[2], "PERSEN1" => $this->biaya($clinker[3].'%'),   "PERSEN11" => $this->biaya($clinker[4].'%'),  "BUD2" => $clinker[5],  "ACT2" => $clinker[6],  "ACT22" => $clinker[7], "PERSEN2" => $this->biaya($clinker[8].'%'),   "PERSEN22" => $this->biaya($clinker[9].'%')),
                                array( "GL_ACCOUNT" => "<i>Cement</i>",             "BUD1" => $cement[0],   "ACT1" => $cement[1],   "ACT11" => $cement[2],  "PERSEN1" => $this->biaya($cement[3].'%'),    "PERSEN11" => $this->biaya($cement[4].'%'),   "BUD2" => $cement[5],   "ACT2" => $cement[6],   "ACT22" => $cement[7],  "PERSEN2" => $this->biaya($cement[8].'%'),    "PERSEN22" => $this->biaya($cement[9].'%')),
                                array( "GL_ACCOUNT" => "<i>Sales Volume</i>",       "BUD1" => $sales[0],    "ACT1" => $sales[1],    "ACT11" => $sales[2],   "PERSEN1" => $this->biaya($sales[3].'%'),     "PERSEN11" => $this->biaya($sales[4].'%'),    "BUD2" => $sales[5],    "ACT2" => $sales[6],    "ACT22" => $sales[7],   "PERSEN2" => $this->biaya($sales[8].'%'),     "PERSEN22" => $this->biaya($sales[9].'%')),
                                array( "GL_ACCOUNT" => ""                           ),
                          );
        
        $dataa['rows'] = array_merge($data1, $data2);
        $this->session->set_userdata("data_cost_report", json_encode($dataa));
        echo json_encode($dataa);
    }
    public function set_data_b($data){
        $index         = 0;
        $return        = array();
        $total_cogm    = array();
        $total_cogs    = array();
        $total_adm     = array();
        $total_sls     = array();
        $total_exp     = array();
        $total_exp[0]  = 0; $total_exp[1]  = 0; $total_exp[2]  = 0; $total_exp[3]  = 0; $total_exp[4]  = 0; $total_exp[5]  = 0;
        $total_cogm[0] = 0; $total_cogm[1] = 0; $total_cogm[2] = 0; $total_cogm[3] = 0; $total_cogm[4] = 0; $total_cogm[5] = 0;
        $total_cogs[0] = 0; $total_cogs[1] = 0; $total_cogs[2] = 0; $total_cogs[3] = 0; $total_cogs[4] = 0; $total_cogs[5] = 0;
        $total_adm[0]  = 0; $total_adm[1]  = 0; $total_adm[2]  = 0; $total_adm[3]  = 0; $total_adm[4]  = 0; $total_adm[5]  = 0;
        $total_sls[0]  = 0; $total_sls[1]  = 0; $total_sls[2]  = 0; $total_sls[3]  = 0; $total_sls[4]  = 0; $total_sls[5]  = 0;
        
        foreach ($data as $key => $value) {
            
            $return[$key]['GL_ACCOUNT']     = $value->DESC_INDO;
            
            if($value->DESC_INDO == "<b>Harga Pokok Penjualan</b>" || $value->DESC_INDO == "<b>Umum & Administrasi</b>" || $value->DESC_INDO == "<b>Pengeluaran Penjualan & Pemasaran:</b>" || $value->DESC_INDO == ""){
                $return[$key]['BUD1']       = "";
                $return[$key]['ACT1']       = "";
                $return[$key]['ACT11']      = "";
                $return[$key]['PERSEN1']    = "";
                $return[$key]['PERSEN11']   = "";
                $return[$key]['BUD2']       = "";
                $return[$key]['ACT2']       = "";
                $return[$key]['ACT22']      = "";
                $return[$key]['PERSEN2']    = "";
                $return[$key]['PERSEN22']   = "";
            }else{
                $return[$key]['BUD1']       = $this->num_format($value->BUD1);
                $return[$key]['ACT1']       = $this->num_format($value->ACT1);
                $return[$key]['ACT11']      = $this->num_format($value->ACT11);
                $return[$key]['PERSEN1']    = $this->beban($this->division($value->ACT1, $value->BUD1));
                $return[$key]['PERSEN11']   = $this->beban($this->division($value->ACT1, $value->ACT11));
                $return[$key]['BUD2']       = $this->num_format($value->BUD2);
                $return[$key]['ACT2']       = $this->num_format($value->ACT2);
                $return[$key]['ACT22']      = $this->num_format($value->ACT22);
                $return[$key]['PERSEN2']    = $this->beban($this->division($value->ACT2, $value->BUD2));
                $return[$key]['PERSEN22']   = $this->beban($this->division($value->ACT2, $value->ACT22));
            }
            
            //GET NILAI TOTAL===============================================================================================
            if($value->COST_GROUP == "HPP")         { $total_cogm = $this->set_total2($total_cogm, $value); }
            else if($value->COST_GROUP == "HPP2")   { $total_cogs = $this->set_total2($total_cogs, $value); }
            else if($value->COST_GROUP == "ADM")    { $total_adm  = $this->set_total2($total_adm, $value); }
            else if($value->COST_GROUP == "SALES")  { $total_sls  = $this->set_total2($total_sls, $value); }
            
            $index++;
        }
        //SET TOTAL======================================================================================================
        foreach($data as $key => $value){
            if($value->COST_GROUP == "TOTAL_COGM"){
                $return[$key] = $this->tampil_total($return[$key], $total_cogm);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogm[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_COGS"){
                $return[$key]['BUD1']       = $this->num_format($total_cogm[0]+$total_cogs[0]);
                $return[$key]['ACT1']       = $this->num_format($total_cogm[1]+$total_cogs[1]);
                $return[$key]['ACT11']      = $this->num_format($total_cogm[2]+$total_cogs[2]);
                $return[$key]['PERSEN1']    = $this->beban($this->division($total_cogm[1]+$total_cogs[1], $total_cogm[0]+$total_cogs[0]));
                $return[$key]['PERSEN11']   = $this->beban($this->division($total_cogm[1]+$total_cogs[1], $total_cogm[2]+$total_cogs[2]));
                $return[$key]['BUD2']       = $this->num_format($total_cogm[3]+$total_cogs[3]);
                $return[$key]['ACT2']       = $this->num_format($total_cogm[4]+$total_cogs[4]);
                $return[$key]['ACT22']      = $this->num_format($total_cogm[5]+$total_cogs[5]);
                $return[$key]['PERSEN2']    = $this->beban($this->division($total_cogm[4]+$total_cogs[4], $total_cogm[3]+$total_cogs[3]));
                $return[$key]['PERSEN22']   = $this->beban($this->division($total_cogm[4]+$total_cogs[4], $total_cogm[5]+$total_cogs[5]));
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_cogs[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_ADM"){
                $return[$key] = $this->tampil_total($return[$key], $total_adm);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_adm[$i];
                }
            }else if($value->COST_GROUP == "TOTAL_SALES"){
                $return[$key] = $this->tampil_total($return[$key], $total_sls);
                for($i=0; $i<=5; $i++){
                    $total_exp[$i] = $total_exp[$i] + $total_sls[$i];
                }
            }
        }
        $index++;
        //SET TOTAL EXPENSE===============================================================================================
        $return[$index]['GL_ACCOUNT'] = "<b>Total Expense</b>";
        $return[$index]['BUD1']       = $this->num_format($total_exp[0]);
        $return[$index]['ACT1']       = $this->num_format($total_exp[1]);
        $return[$index]['ACT11']      = $this->num_format($total_exp[2]);
        $return[$index]['PERSEN1']    = $this->beban($this->division($total_exp[1], $total_exp[0]));
        $return[$index]['PERSEN11']   = $this->beban($this->division($total_exp[1], $total_exp[2]));
        $return[$index]['BUD2']       = $this->num_format($total_exp[3]);
        $return[$index]['ACT2']       = $this->num_format($total_exp[4]);
        $return[$index]['ACT22']      = $this->num_format($total_exp[5]);
        $return[$index]['PERSEN2']    = $this->beban($this->division($total_exp[4], $total_exp[3]));
        $return[$index]['PERSEN22']   = $this->beban($this->division($total_exp[4], $total_exp[5]));
        
        $index++;
        $return[$index]['GL_ACCOUNT'] = "";
        $index++;
        $return[$index]['GL_ACCOUNT'] = "<b><i>Amount Per Tonage</b></i>";
        $index++;
        $return[0]['index'] = $index;
        return $return;
    }
    public function tampil_total($return, $total){
        $return['BUD1']       = $this->num_format($total[0]);
        $return['ACT1']       = $this->num_format($total[1]);
        $return['ACT11']      = $this->num_format($total[2]);
        $return['PERSEN1']    = $this->beban($this->division($total[1], $total[0]));
        $return['PERSEN11']   = $this->beban($this->division($total[1], $total[2]));
        $return['BUD2']       = $this->num_format($total[3]);
        $return['ACT2']       = $this->num_format($total[4]);
        $return['ACT22']      = $this->num_format($total[5]);
        $return['PERSEN2']    = $this->beban($this->division($total[4], $total[3]));
        $return['PERSEN22']   = $this->beban($this->division($total[4], $total[5]));
        return $return;
    }
    public function set_total($total, $value, $pembagi){
        $total[0] = $total[0] + $this->division_np($value->BUD1, $pembagi[0]);
        $total[1] = $total[1] + $this->division_np($value->ACT1, $pembagi[1]);
        $total[2] = $total[2] + $this->division_np($value->ACT11, $pembagi[2]);
        $total[3] = $total[3] + $this->division_np($value->BUD2, $pembagi[5]);
        $total[4] = $total[4] + $this->division_np($value->ACT2, $pembagi[6]);
        $total[5] = $total[5] + $this->division_np($value->ACT22, $pembagi[7]);
        
        return $total;
    }
    public function set_total2($total, $value){
        $total[0] = $total[0] + $value->BUD1;
        $total[1] = $total[1] + $value->ACT1;
        $total[2] = $total[2] + $value->ACT11;
        $total[3] = $total[3] + $value->BUD2;
        $total[4] = $total[4] + $value->ACT2;
        $total[5] = $total[5] + $value->ACT22;
        
        return $total;
    }
    public function biaya($data){
		if($data<100){
			$data_r = "<font color='red'>".$data."</font>";
		}else{
			$data_r = "<font color='blue'>".$data."</font>";
		}
		return $data_r;
	}
	public function beban($data){
		if($data>=100){
			$data_r = "<font color='red'>".$data."</font>";
		}else{
			$data_r = "<font color='blue'>".$data."</font>";
		}
		return $data_r;
	}
    //EXPORT EXCEL
    public function export_excel($date_now, $comp){
        
        //MENGAMBIL BULAN=============================================================================
        $month          = substr($date_now, -2);
        $last_month     = $month - 1;
        $last_month     = "0$last_month";
        $last_month     = substr($last_month, -2);

        //MENGAMBIL TAHUN==============================================================================
        $year           = substr($date_now, 0, 4);
        
        //MENDEKLARASIKAN BULAN TERAKHIR TAHUN SEBELUMNYA=============================================
        $last_year      = $year - 1;
        
        $data       = json_decode($this->session->userdata('data_cost_report'))->rows;
        
        $bottom     = "style='border-bottom:1px solid black;'";
        $right      = "style='border-right:1px solid black;'";
        $align      = "align='right'";
        $border     = "style='border:1px solid black;'";
        $awal_td    = "<td width='500px'></td>";
        $blue       = "style='color:blue'";
        $date_now2  = date("F Y", strtotime("$year-$month"));
        $table_cost1 = "";
        for($i = 0; $i < count($data); $i++){
            if($data[$i]->GL_ACCOUNT == "" || $data[$i]->GL_ACCOUNT == "<b><i>Production</i></b>"
                    || $data[$i]->GL_ACCOUNT == "<b>Harga Pokok Penjualan</b>" && $i == 0
                    || $data[$i]->GL_ACCOUNT == "<b>Umum & Administrasi</b>"
                    || $data[$i]->GL_ACCOUNT == "<b>Pengeluaran Penjualan & Pemasaran</b>"
                    || $data[$i]->GL_ACCOUNT == "<b><i>Amount Per Tonage</b></i>"){
                $gl_account     = $data[$i]->GL_ACCOUNT;
                $table_cost1    = "$table_cost1<tr><td $right>$gl_account</td></tr>";
            }else{
                $gl_account     = $data[$i]->GL_ACCOUNT;
                $bud1           = $data[$i]->BUD1;
                $act1           = $data[$i]->ACT1;
                $act11          = $data[$i]->ACT11;
                $persen1        = $data[$i]->PERSEN1;
                $persen11       = $data[$i]->PERSEN11;
                $bud2           = $data[$i]->BUD2;
                $act2           = $data[$i]->ACT2;
                $act22          = $data[$i]->ACT22;
                $persen2        = $data[$i]->PERSEN2;
                $persen22       = $data[$i]->PERSEN22;
                if($data[$i]->GL_ACCOUNT == "<b>Total Expense</b>" || $data[$i]->GL_ACCOUNT == "<b>Total Pengeluaran Penjualan & Pemasaran:</b>"){
                    $table_cost1    = "$table_cost1<tr $bottom><td $right>$gl_account</td><td $align>$bud1</td><td $align>$act1</td><td $align>$act11</td><td $align>$persen1</td><td $align>$persen11</td>
                                                    <td $align>$bud2</td><td $align>$act2</td><td $align>$act22</td><td $align>$persen2</td><td $align>$persen22</td>
                                                    </tr>";
                }else{
                    $table_cost1    = "$table_cost1<tr><td $right>$gl_account</td><td $align>$bud1</td><td $align>$act1</td><td $align>$act11</td><td $align>$persen1</td><td $align>$persen11</td>
                                                    <td $align>$bud2</td><td $align>$act2</td><td $align>$act22</td><td $align>$persen2</td><td $align>$persen22</td>
                                                    </tr>";
                }
            }
            
        }
        
        /*if ($comp == "2000") {
            $img = "si.png";
        } elseif ($comp == "3000") {
            $img = "semen_padang.png";
        } elseif ($comp == "4000") {
            $img = "semen_tonasa.png";
        } elseif ($comp == "5000") {
            $img = "semen_gresik.png";
        } elseif ($comp == "7000") {
            $img = "si.png";
        } else {
            $img = "si.png";
        }*/
        if($comp == "Consolidation"){
			$img= "asset/easyui/themes/all_group.png";
			$tinggi = 30;
		}else{
			$logo_comp = $this->m_finance_cost->get_logo('LOGO', $comp);
			$img = $logo_comp[0]['LOGO'];
			$tinggi=60;
		}
        $table_cost = "
            <table border='1' $border>
                <tr><th rowspan='3'>Keterangan</th> <th colspan='5'>BULAN INI</th>  <th colspan='5'>S/D BULAN INI</th></tr>
                <tr>                                <th rowspan='2'>RKAP $year</th> <th rowspan='2' $blue>REAL $year</th>  <th rowspan='2'>REAL $last_year</th>    <th colspan='2'>%</th>  <th rowspan='2'>RKAP $year</th>    <th rowspan='2' $blue>REAL $year</th>      <th rowspan='2'>REAL $last_year</th>    <th colspan='2' align='center'>%</th></tr>
                <tr>                                                                                                                                               <th> (2:1) </th><th> (2:3) </th>                                                                                                              <th> (4:5) </th><th> (5:6) </th></tr>
            </table>
            <table $border>
                <colgroup><col><col><col $blue><col><col><col><col><col $blue></colgroup>
                $table_cost1
            </table>";
        
        $download = "<table>
        <tr><table border='1'>
                <tr height='60'><td><center><img src='http:".  base_url()."$img' height='$tinggi'></center></td>
                    <td colspan='11'><center><b>LAPORAN PERBANDINGAN BIAYA KONSOLIDASI <br/> $date_now2</b></center></td>
                    <td></td>
                </tr>
            </table>
        </tr>
        <tr><td>
        <table $border><tr>$awal_td</tr><tr>$awal_td</tr>
                <tr>$awal_td<td>
                $table_cost
            </td>$awal_td</tr>
            <tr>$awal_td</tr><tr>$awal_td</tr>
                </td></tr>
            </table>";
            
            error_reporting(0);
            header("Content-type: application/vnd-ms-excel"); 
            header("Content-Disposition: attachment; filename=Cost_Report_date_$year-$month.xls");
            echo $download;
    }
    
    function division($a, $b) {         
	$c=0;
        if($b == 0){
          return "0%";
        }else{
           $d = ($a/$b)*100; 
           $c = round($d) . '%';
           return $c;
        }
    }
    function division_np($a, $b) {         
	$c=0;
        if($b == 0){
          return "0";
        }else{
          $c = $a/$b; 
          return $c;
        }
    }
    function date_between($date){
        $temp       = '';
        $data       = array();
        $bts        = substr($date, -2);
        $year       = substr($date, 0, 4);
        $year_lalu  = $year-1;
        for ($i = 1; $i <= $bts; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bts) {
                $tmbhn = ",";
            }else{
                $tmbhn = "";
            }
            $date_between = "$temp '$year.$month' $tmbhn";
            $temp = $date_between;
        }
        $data[0]    = $temp;
        $data[1]    = str_replace($year, $year_lalu, $temp);
        return $data;
    }
    public function format_array($data, $batas){
        for($i = 0; $i <= $batas; $i++){
            if($data[$i] != ""){
                $data[$i] = $this->num_format((int)$data[$i]);
            } 
        }
        return $data;
    }


    public function get_detail() {

        $company = isset($_GET['comp']) ? $_GET['comp'] : null;
        $category = isset($_GET['cat']) ? $_GET['cat'] : null;
        $time = isset($_GET['time']) ? $_GET['time'] : null;
        $year = substr($time, 0, 4);
        $month = substr($time, -2);

        if (date("Y.m") == "$year.$month") {
            $day = date('d');
            if ($day <= 15) {
                if ($month > 1) {
                    $month = $month - 1;
                    $month = substr("0$month", -2);
                } else {
                    $month = 12;
                    $year = $year - 1;
                }
            }
        }

        $index = isset($_GET['index']) ? $_GET['index'] : null;
        $group = isset($_GET['group']) ? $_GET['group'] : null;
        $account = isset($_GET['account']) ? $_GET['account'] : null;
        $cek =  isset($_GET['cek']) ? $_GET['cek'] : null;
        $nomor = substr('0' . $index, -2);

        IF ($company == "2000','7000" || $company == "5000','7000") {
            $company = explode("','", $company);
            $name[0] = $category . '_' . $company[0] . '_D';
            $name[1] = $category . '_' . $company[1] . '_D';
            $data['rows'] = $this->m_finance_cost->detail_gabungan("$year.$month", "$year.$month", 'NOT', $name, $nomor);
            echo json_encode($data);
        } ELSE {
            if ($cek == 'GCEMENT') {
                $name = $category . '_' . $company . '_D';
                $data['rows'] = $this->m_finance_cost->detail_coststructure("$year.$month", "$year.$month", 'NOT', $name, $nomor);
                echo json_encode($data);
            } else {
                $data['rows'] = $this->m_finance_cost->detail_coststructure_subsidiary("$year.$month", "$year.$month", $nomor, $group, $account, $company, $category);
                echo json_encode($data);
            }
        }
    }

    public function get_detail_nc() {
        $company = isset($_GET['comp']) ? $_GET['comp'] : null;
        $category = isset($_GET['cat']) ? $_GET['cat'] : null;
        $time = isset($_GET['time']) ? $_GET['time'] : null;
        $year = substr($time, 0, 4);
        $month = substr($time, -2);

        if (date("Y.m") == "$year.$month") {
            $day = date('d');
            if ($day <= 15) {
                if ($month > 1) {
                    $month = $month - 1;
                    $month = substr("0$month", -2);
                } else {
                    $month = 12;
                    $year = $year - 1;
                }
            }
        }

        $index = isset($_GET['index']) ? $_GET['index'] : null;
        $nomor = substr('0' . $index, -2);

        IF ($company == "2000','7000" || $company == "5000','7000") {
            $company = explode("','", $company);
            $name[0] = $category . '_' . $company[0] . '_D';
            $name[1] = $category . '_' . $company[1] . '_D';
            $data['rows'] = $this->m_finance_cost->detail_gabungan("$year.$month", "$year.$month", '', $name, $nomor);
            echo json_encode($data);
        } ELSE {
            $name = $category . '_' . $company . '_D';
            $data['rows'] = $this->m_finance_cost->detail_coststructure("$year.$month", "$year.$month", '', $name, $nomor);
            echo json_encode($data);
        }
    }

    function num_format($dt) {
        return number_format($dt, 0, '.', '');
    }


    
}

