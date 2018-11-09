<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_report extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cost_report');
    }

    public function get_data()
    {
        //$comp           = $_GET['company'];
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp           = str_replace(",","','",$comp);
        //$date           = $_GET['date'];
        $date = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
        //$date_last      = $_GET['etime2']
        $temp           = $this->date_between($date);

        $clinker        = array();
        $cement         = array();
        if($comp == '2000'){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
        }else if($comp == '3000'){
            $plant      = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
            $plant2     = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
        }else if($comp == '4000'){
            $plant      = "'P_4301','P_4302','P_4303'";
            $plant2     = "'P_4301','P_4302','P_4303'";
        }else if($comp == '7000'){
            $plant      = "'P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == 'smi'){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == '5000'){
            $plant      = "'P_5302','P_5303','P_5304','P_5305'";
            $plant2     = "'P_5301','P_5302','P_5303','P_5304','P_5305'";
        }
        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $clinker1       = 0;//$this->m_cost_report->get_clinker($comp, $temp[0], 'ACT', $plant);
        $clinker2       = $this->m_cost_report->get_clinker($comp, implode(',',$t), 'ACT', $plant);
        $clinker3       = $this->m_cost_report->get_clinker($comp, implode(',',$s), 'ACT', $plant);

        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $cement1        = $this->m_cost_report->get_cement($comp, $temp[0], 'ACT', $plant2);
        // $cement2        = $this->m_cost_report->get_cement($comp, $temp[1], 'ACT', $plant2);
        $cement2       = $this->m_cost_report->get_cement($comp, implode(',',$t), 'ACT', $plant2);
        $cement3       = $this->m_cost_report->get_cement($comp, implode(',',$s), 'ACT', $plant2);

        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $sales1         = $this->m_cost_report->get_sales($comp, $temp[0], 'ACT');
        //$sales2         = $this->m_cost_report->get_sales($comp, $temp[1], 'ACT');
        $sales2         = $this->m_cost_report->get_sales($comp, implode(',',$t), 'ACT');
        $sales3         = $this->m_cost_report->get_sales($comp, implode(',',$s), 'ACT');


        // $data['bulan_ini']['clinker']       = $this->cek_data_n($clinker1->AMOUNT) - $this->cek_data_n($clinker2->AMOUNT);
        // $data['bulan_ini']['cement']        = $this->cek_data_n($cement1->AMOUNT) - $this->cek_data_n($cement2->AMOUNT);
        // $data['bulan_ini']['sales']         = $this->cek_data_n($sales1->AMOUNT) - $this->cek_data_n($sales2->AMOUNT);

        // $data['bulan_lalu']['clinker']      = $this->cek_data_n($clinker2->AMOUNT) - $this->cek_data_n($clinker3->AMOUNT);
        // $data['bulan_lalu']['cement']       = $this->cek_data_n($cement2->AMOUNT) - $this->cek_data_n($cement3->AMOUNT);
        // $data['bulan_lalu']['sales']        = $this->cek_data_n($sales2->AMOUNT) - $this->cek_data_n($sales3->AMOUNT);

        $data['bulan_ini']['clinker']       = 0;
        $data['bulan_ini']['cement']        = 0;
        $data['bulan_ini']['sales']         = 0;
        $data['bulan_lalu']['clinker']      = 0;
        $data['bulan_lalu']['cement']       = 0;
        $data['bulan_lalu']['sales']        = 0;

        //production cost
        //$data_prod=array();
        //$data_prod=array();
        $data_prod        = $this->m_cost_report->get_data_cat($comp, "'$date'", 'ACT');
        $rkap_data_prod        = $this->m_cost_report->get_data_cat($comp, "'$date'", 'BUD');
        $data_prod1        = $this->m_cost_report->get_data_cat($comp, $temp[0], 'ACT');
        $rkap_data_prod1        = $this->m_cost_report->get_data_cat($comp, $temp[0], 'BUD');
        $lastyear_date = (intval(substr($date, 0, 4)) - 1).substr($date,4);
        $temply  = $this->date_between($lastyear_date);
        $data_prod_lastyear  = $this->m_cost_report->get_data_cat($comp, "'$lastyear_date'", 'ACT');
        $data_prod1_lastyear = $this->m_cost_report->get_data_cat($comp, $temply[0], 'ACT');
        //$data2=array();
       
        $data1['s'.$comp]=array($data);
        //$data1['s'.$comp]=array();
        $data1['production_cost']       = array($this->set_data(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['good_of_sold']       = array($this->set_data_sold(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['general_admininstration']       = array($this->set_data_general(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['selling_marketing']       = array($this->set_data_marketing(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        echo json_encode($data1);

    }
    
    public function get_data_mview()
    {
        //$comp           = $_GET['company'];
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp           = str_replace(",","','",$comp);
        //$date           = $_GET['date'];
        $date = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
        //$date_last      = $_GET['etime2']
        $temp           = $this->date_between($date);

        $clinker        = array();
        $cement         = array();
        if($comp == '2000'){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
        }else if($comp == '3000'){
            $plant      = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
            $plant2     = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
        }else if($comp == '4000'){
            $plant      = "'P_4301','P_4302','P_4303'";
            $plant2     = "'P_4301','P_4302','P_4303'";
        }else if($comp == '7000'){
            $plant      = "'P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == 'smi'){
            $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7302','P_7303','P_7304','P_7305'";
            $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7301','P_7302','P_7303','P_7304','P_7305'";
        }else if($comp == '5000'){
            $plant      = "'P_5302','P_5303','P_5304','P_5305'";
            $plant2     = "'P_5301','P_5302','P_5303','P_5304','P_5305'";
        }
        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $clinker1       = $this->m_cost_report->get_clinker($comp, $temp[0], 'ACT', $plant);
        $clinker2       = $this->m_cost_report->get_clinker($comp, implode(',',$t), 'ACT', $plant);
        $clinker3       = $this->m_cost_report->get_clinker($comp, implode(',',$s), 'ACT', $plant);

        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $cement1        = $this->m_cost_report->get_cement($comp, $temp[0], 'ACT', $plant2);
        $cement2       = $this->m_cost_report->get_cement($comp, implode(',',$t), 'ACT', $plant2);
        $cement3       = $this->m_cost_report->get_cement($comp, implode(',',$s), 'ACT', $plant2);

        $t = array();
        $s = array(); 
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-1;$x++){
         array_push($t, $tmp[$x]);
        }
        $tmp = explode(',',$temp[1]);
        for ($x=0;$x<count($tmp)-2;$x++){
         array_push($s, $tmp[$x]);
        }
        $sales1         = $this->m_cost_report->get_sales($comp, $temp[0], 'ACT');
        //$sales2         = $this->m_cost_report->get_sales($comp, $temp[1], 'ACT');
        $sales2         = $this->m_cost_report->get_sales($comp, implode(',',$t), 'ACT');
        $sales3         = $this->m_cost_report->get_sales($comp, implode(',',$s), 'ACT');


        $data['bulan_ini']['clinker']       = $this->cek_data_n($clinker1->AMOUNT) - $this->cek_data_n($clinker2->AMOUNT);
        $data['bulan_ini']['cement']        = $this->cek_data_n($cement1->AMOUNT) - $this->cek_data_n($cement2->AMOUNT);
        $data['bulan_ini']['sales']         = $this->cek_data_n($sales1->AMOUNT) - $this->cek_data_n($sales2->AMOUNT);

        $data['bulan_lalu']['clinker']      = $this->cek_data_n($clinker2->AMOUNT) - $this->cek_data_n($clinker3->AMOUNT);
        $data['bulan_lalu']['cement']       = $this->cek_data_n($cement2->AMOUNT) - $this->cek_data_n($cement3->AMOUNT);
        $data['bulan_lalu']['sales']        = $this->cek_data_n($sales2->AMOUNT) - $this->cek_data_n($sales3->AMOUNT);
        // production cost material view
        $data_prod        = $this->m_cost_report->get_data_desc($comp, "'$date'", 'ACT', 1);
        $rkap_data_prod        = $this->m_cost_report->get_data_desc($comp, "'$date'", 'BUD', 1);
        $data_prod1        = $this->m_cost_report->get_data_desc($comp, $temp[0], 'ACT', 1);
        $rkap_data_prod1        = $this->m_cost_report->get_data_desc($comp, $temp[0], 'BUD', 1);
        $lastyear_date = (intval(substr($date, 0, 4)) - 1).substr($date,4);
        $temply  = $this->date_between($lastyear_date);
        $data_prod_lastyear  = $this->m_cost_report->get_data_desc($comp, "'$lastyear_date'", 'ACT', 1);
        $data_prod1_lastyear = $this->m_cost_report->get_data_desc($comp, $temply[0], 'ACT', 1);

        $data1['s'.$comp]=array($data);
        $data1['production_cost']       = array($this->set_data(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['good_of_sold']       = array($this->set_data_sold(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['general_administration']       = array($this->set_data_general(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        $data1['selling_marketing']       = array($this->set_data_marketing(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        echo json_encode($data1);
    }
    //selling & marketing

    public function set_data_marketing($key, $data,$rkap_data,$data_lyear,$data_up,$rkap_data_up,$data_lyear_up)
    {
        $data1['bulan_ini']['Supporting Material']                = ($this->cek_null($data[21], $key));
        $data1['bulan_ini']['Fuel']                = ($this->cek_null($data[22], $key));
        $data1['bulan_ini']['Electricity']                = ($this->cek_null($data[23], $key));
        $data1['bulan_ini']['Labor']                = ($this->cek_null($data[24], $key));
        $data1['bulan_ini']['Maintenance']                = ($this->cek_null($data[25], $key));
        $data1['bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($data[26], $key));
        $data1['bulan_ini']['General & Administration']                = ($this->cek_null($data[27], $key));
        $data1['bulan_ini']['Taxes and insurance']                = ($this->cek_null($data[28], $key));
        $total_bulan_ini = 0;
        foreach ($data1['bulan_ini'] as $value){
         $total_bulan_ini += (float) $value; 
        }
        $data1['bulan_ini']['Total'] = $total_bulan_ini;

        $data1['rkap_bulan_ini']['Supporting Material']                = ($this->cek_null($rkap_data[21], $key));
        $data1['rkap_bulan_ini']['Fuel']                = ($this->cek_null($rkap_data[22], $key));
        $data1['rkap_bulan_ini']['Electricity']                = ($this->cek_null($rkap_data[23], $key));
        $data1['rkap_bulan_ini']['Labor']                = ($this->cek_null($rkap_data[24], $key));
        $data1['rkap_bulan_ini']['Maintenance']                = ($this->cek_null($rkap_data[25], $key));
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($rkap_data[26], $key));
        $data1['rkap_bulan_ini']['General & Administration']                = ($this->cek_null($rkap_data[27], $key));
        $data1['rkap_bulan_ini']['Taxes and insurance']                = ($this->cek_null($rkap_data[28], $key));
        $total_rkap_bulan_ini = 0;
        foreach ($data1['rkap_bulan_ini'] as $value){
         $total_rkap_bulan_ini += (float) $value; 
        }
        $data1['rkap_bulan_ini']['Total'] = $total_rkap_bulan_ini;

        $data1['bulan_ini_lyear']['Supporting Material']                = ($this->cek_null($data_lyear[21], $key));
        $data1['bulan_ini_lyear']['Fuel']                = ($this->cek_null($data_lyear[22], $key));
        $data1['bulan_ini_lyear']['Electricity']                = ($this->cek_null($data_lyear[23], $key));
        $data1['bulan_ini_lyear']['Labor']                = ($this->cek_null($data_lyear[24], $key));
        $data1['bulan_ini_lyear']['Maintenance']                = ($this->cek_null($data_lyear[25], $key));
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']                = ($this->cek_null($data_lyear[26], $key));
        $data1['bulan_ini_lyear']['General & Administration']                = ($this->cek_null($data_lyear[27], $key));
        $data1['bulan_ini_lyear']['Taxes and insurance']                = ($this->cek_null($data_lyear[28], $key));
        $total_bulan_ini_lyear = 0;
        foreach ($data1['bulan_ini_lyear'] as $value){
         $total_bulan_ini_lyear += (float) $value; 
        }
        $data1['bulan_ini_lyear']['Total'] = $total_bulan_ini_lyear;
        $data1['bulan_ini']['Yoy'] = $this->division($total_bulan_ini - $total_bulan_ini_lyear,$total_bulan_ini_lyear)*100;

        $data1['up_bulan_ini']['Supporting Material']                = ($this->cek_null($data_up[21], $key));
        $data1['up_bulan_ini']['Fuel']                = ($this->cek_null($data_up[22], $key));
        $data1['up_bulan_ini']['Electricity']                = ($this->cek_null($data_up[23], $key));
        $data1['up_bulan_ini']['Labor']                = ($this->cek_null($data_up[24], $key));
        $data1['up_bulan_ini']['Maintenance']                = ($this->cek_null($data_up[25], $key));
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($data[26], $key));
        $data1['up_bulan_ini']['General & Administration']                = ($this->cek_null($data_up[27], $key));
        $data1['up_bulan_ini']['Taxes and insurance']                = ($this->cek_null($data_up[28], $key));
        $total_up_bulan_ini = 0;
        foreach ($data1['up_bulan_ini'] as $value){
         $total_up_bulan_ini += (float) $value; 
        }
        $data1['up_bulan_ini']['Total'] = $total_up_bulan_ini;

        $data1['rkap_up_bulan_ini']['Supporting Material']                = ($this->cek_null($rkap_data_up[21], $key));
        $data1['rkap_up_bulan_ini']['Fuel']                = ($this->cek_null($rkap_data_up[22], $key));
        $data1['rkap_up_bulan_ini']['Electricity']                = ($this->cek_null($rkap_data_up[23], $key));
        $data1['rkap_up_bulan_ini']['Labor']                = ($this->cek_null($rkap_data_up[24], $key));
        $data1['rkap_up_bulan_ini']['Maintenance']                = ($this->cek_null($rkap_data_up[25], $key));
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($rkap_data_up[26], $key));
        $data1['rkap_up_bulan_ini']['General & Administration']                = ($this->cek_null($rkap_data_up[27], $key));
        $data1['rkap_up_bulan_ini']['Taxes and insurance']                = ($this->cek_null($rkap_data_up[28], $key));
        $total_rkap_up_bulan_ini = 0;
        foreach ($data1['rkap_up_bulan_ini'] as $value){
         $total_rkap_up_bulan_ini += (float) $value; 
        }
        $data1['rkap_up_bulan_ini']['Total'] = $total_rkap_up_bulan_ini;

        $data1['up_bulan_ini_lyear']['Supporting Material']                = ($this->cek_null($data_lyear_up[21], $key));
        $data1['up_bulan_ini_lyear']['Fuel']                = ($this->cek_null($data_lyear_up[22], $key));
        $data1['up_bulan_ini_lyear']['Electricity']                = ($this->cek_null($data_lyear_up[23], $key));
        $data1['up_bulan_ini_lyear']['Labor']                = ($this->cek_null($data_lyear_up[24], $key));
        $data1['up_bulan_ini_lyear']['Maintenance']                = ($this->cek_null($data_lyear_up[25], $key));
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']                = ($this->cek_null($data_lyear_up[26], $key));
        $data1['up_bulan_ini_lyear']['General & Administration']                = ($this->cek_null($data_lyear_up[27], $key));
        $data1['up_bulan_ini_lyear']['Taxes and insurance']                = ($this->cek_null($data_lyear_up[28], $key));
        $total_up_bulan_ini_lyear = 0;
        foreach ($data1['up_bulan_ini_lyear'] as $value){
         $total_up_bulan_ini_lyear += (float) $value; 
        }
        $data1['up_bulan_ini_lyear']['Total'] = $total_up_bulan_ini_lyear;
        $data1['up_bulan_ini']['Yoy'] = $this->division($total_up_bulan_ini - $total_up_bulan_ini_lyear,$total_up_bulan_ini_lyear)*100;
        return $data1;
    }

    //general& administration

    public function set_data_general($key, $data,$rkap_data,$data_lyear,$data_up,$rkap_data_up,$data_lyear_up)
    {
        $data1['bulan_ini']['Supporting Material']                = ($this->cek_null($data[13], $key));
        $data1['bulan_ini']['Fuel']                = ($this->cek_null($data[14], $key));
        $data1['bulan_ini']['Electricity']                = ($this->cek_null($data[15], $key));
        $data1['bulan_ini']['Labor']                = ($this->cek_null($data[16], $key));
        $data1['bulan_ini']['Maintenance']                = ($this->cek_null($data[17], $key));
        $data1['bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($data[18], $key));
        $data1['bulan_ini']['General & Administration']                = ($this->cek_null($data[19], $key));
        $data1['bulan_ini']['Taxes and insurance']                = ($this->cek_null($data[20], $key));
        $total_bulan_ini = 0;
        foreach ($data1['bulan_ini'] as $value){
         $total_bulan_ini += (float) $value; 
        }
        $data1['bulan_ini']['Total'] = $total_bulan_ini;

        $data1['rkap_bulan_ini']['Supporting Material']                = ($this->cek_null($rkap_data[13], $key));
        $data1['rkap_bulan_ini']['Fuel']                = ($this->cek_null($rkap_data[14], $key));
        $data1['rkap_bulan_ini']['Electricity']                = ($this->cek_null($rkap_data[15], $key));
        $data1['rkap_bulan_ini']['Labor']                = ($this->cek_null($rkap_data[16], $key));
        $data1['rkap_bulan_ini']['Maintenance']                = ($this->cek_null($rkap_data[17], $key));
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($rkap_data[18], $key));
        $data1['rkap_bulan_ini']['General & Administration']                = ($this->cek_null($rkap_data[19], $key));
        $data1['rkap_bulan_ini']['Taxes and insurance']                = ($this->cek_null($rkap_data[20], $key));
        $total_rkap_bulan_ini = 0;
        foreach ($data1['rkap_bulan_ini'] as $value){
         $total_rkap_bulan_ini += (float) $value; 
        }
        $data1['rkap_bulan_ini']['Total'] = $total_rkap_bulan_ini;

        $data1['bulan_ini_lyear']['Supporting Material']                = ($this->cek_null($data_lyear[13], $key));
        $data1['bulan_ini_lyear']['Fuel']                = ($this->cek_null($data_lyear[14], $key));
        $data1['bulan_ini_lyear']['Electricity']                = ($this->cek_null($data_lyear[15], $key));
        $data1['bulan_ini_lyear']['Labor']                = ($this->cek_null($data_lyear[16], $key));
        $data1['bulan_ini_lyear']['Maintenance']                = ($this->cek_null($data_lyear[17], $key));
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']                = ($this->cek_null($data_lyear[18], $key));
        $data1['bulan_ini_lyear']['General & Administration']                = ($this->cek_null($data_lyear[19], $key));
        $data1['bulan_ini_lyear']['Taxes and insurance']                = ($this->cek_null($data_lyear[20], $key));
        $total_bulan_ini_lyear = 0;
        foreach ($data1['bulan_ini_lyear'] as $value){
         $total_bulan_ini_lyear += (float) $value; 
        }
        $data1['bulan_ini_lyear']['Total'] = $total_bulan_ini_lyear;
        $data1['bulan_ini']['Yoy'] = $this->division($total_bulan_ini - $total_bulan_ini_lyear,$total_bulan_ini_lyear)*100;

        $data1['up_bulan_ini']['Supporting Material']                = ($this->cek_null($data_up[13], $key));
        $data1['up_bulan_ini']['Fuel']                = ($this->cek_null($data_up[14], $key));
        $data1['up_bulan_ini']['Electricity']                = ($this->cek_null($data_up[15], $key));
        $data1['up_bulan_ini']['Labor']                = ($this->cek_null($data_up[16], $key));
        $data1['up_bulan_ini']['Maintenance']                = ($this->cek_null($data_up[17], $key));
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($data[18], $key));
        $data1['up_bulan_ini']['General & Administration']                = ($this->cek_null($data_up[19], $key));
        $data1['up_bulan_ini']['Taxes and insurance']                = ($this->cek_null($data_up[20], $key));
        $total_up_bulan_ini = 0;
        foreach ($data1['up_bulan_ini'] as $value){
         $total_up_bulan_ini += (float) $value; 
        }
        $data1['up_bulan_ini']['Total'] = $total_up_bulan_ini;

        $data1['rkap_up_bulan_ini']['Supporting Material']                = ($this->cek_null($rkap_data_up[13], $key));
        $data1['rkap_up_bulan_ini']['Fuel']                = ($this->cek_null($rkap_data_up[14], $key));
        $data1['rkap_up_bulan_ini']['Electricity']                = ($this->cek_null($rkap_data_up[15], $key));
        $data1['rkap_up_bulan_ini']['Labor']                = ($this->cek_null($rkap_data_up[16], $key));
        $data1['rkap_up_bulan_ini']['Maintenance']                = ($this->cek_null($rkap_data_up[17], $key));
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']                = ($this->cek_null($rkap_data_up[18], $key));
        $data1['rkap_up_bulan_ini']['General & Administration']                = ($this->cek_null($rkap_data_up[19], $key));
        $data1['rkap_up_bulan_ini']['Taxes and insurance']                = ($this->cek_null($rkap_data_up[20], $key));
        $total_rkap_up_bulan_ini = 0;
        foreach ($data1['rkap_up_bulan_ini'] as $value){
         $total_rkap_up_bulan_ini += (float) $value; 
        }
        $data1['rkap_up_bulan_ini']['Total'] = $total_rkap_up_bulan_ini;

        $data1['up_bulan_ini_lyear']['Supporting Material']                = ($this->cek_null($data_lyear_up[13], $key));
        $data1['up_bulan_ini_lyear']['Fuel']                = ($this->cek_null($data_lyear_up[14], $key));
        $data1['up_bulan_ini_lyear']['Electricity']                = ($this->cek_null($data_lyear_up[15], $key));
        $data1['up_bulan_ini_lyear']['Labor']                = ($this->cek_null($data_lyear_up[16], $key));
        $data1['up_bulan_ini_lyear']['Maintenance']                = ($this->cek_null($data_lyear_up[17], $key));
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']                = ($this->cek_null($data_lyear_up[18], $key));
        $data1['up_bulan_ini_lyear']['General & Administration']                = ($this->cek_null($data_lyear_up[19], $key));
        $data1['up_bulan_ini_lyear']['Taxes and insurance']                = ($this->cek_null($data_lyear_up[20], $key));
        $total_up_bulan_ini_lyear = 0;
        foreach ($data1['up_bulan_ini_lyear'] as $value){
         $total_up_bulan_ini_lyear += (float) $value; 
        }
        $data1['up_bulan_ini_lyear']['Total'] = $total_up_bulan_ini_lyear;
        $data1['up_bulan_ini']['Yoy'] = $this->division($total_up_bulan_ini - $total_up_bulan_ini_lyear,$total_up_bulan_ini_lyear)*100;
        return $data1;
        
    }

    //good of sold
    public function set_data_sold($key, $data,$rkap_data,$data_lyear,$data_up,$rkap_data_up,$data_lyear_up)
    {
        $cogm = 0;
        for ($i=0;$i<9;$i++){
         $cogm += (float) $this->cek_null($data[$i], $key);
        }
        $data1['bulan_ini']['Packaging']                = ($this->cek_null($data[9], $key));
        $data1['bulan_ini']['Distribution']             = ($this->cek_null($data[10], $key));
        $data1['bulan_ini']['Variance Stok']            = ($this->cek_null($data[11], $key));
        $data1['bulan_ini']['WIP (Purchasing)']         = ($this->cek_null($data[12], $key));

        $total_bulan_ini = 0;
        foreach ($data1['bulan_ini'] as $value){
         $total_bulan_ini += (float) $value; 
        }
        $data1['bulan_ini']['Total'] = $cogm + $total_bulan_ini;

        $rkap_cogm = 0;
        for ($i=0;$i<9;$i++){
         $rkap_cogm += (float) $this->cek_null($rkap_data[$i], $key);
        }
        $data1['rkap_bulan_ini']['Packaging']                = ($this->cek_null($rkap_data[9], $key));
        $data1['rkap_bulan_ini']['Distribution']             = ($this->cek_null($rkap_data[10], $key));
        $data1['rkap_bulan_ini']['Variance Stok']            = ($this->cek_null($rkap_data[11], $key));
        $data1['rkap_bulan_ini']['WIP (Purchasing)']         = ($this->cek_null($rkap_data[12], $key));

        $total_rkap_bulan_ini = 0;
        foreach ($data1['rkap_bulan_ini'] as $value){
         $total_rkap_bulan_ini += (float) $value; 
        }
        $data1['rkap_bulan_ini']['Total'] = $rkap_cogm + $total_rkap_bulan_ini;

        $cogm_lyear = 0;
        for ($i=0;$i<9;$i++){
         $cogm_lyear += (float) $this->cek_null($data_lyear[$i], $key);
        }
        $data1['bulan_ini_lyear']['Packaging']                = ($this->cek_null($data_lyear[9], $key));
        $data1['bulan_ini_lyear']['Distribution']             = ($this->cek_null($data_lyear[10], $key));
        $data1['bulan_ini_lyear']['Variance Stok']            = ($this->cek_null($data_lyear[11], $key));
        $data1['bulan_ini_lyear']['WIP (Purchasing)']         = ($this->cek_null($data_lyear[12], $key));

        $total_bulan_ini_lyear = 0;
        foreach ($data1['bulan_ini_lyear'] as $value){
         $total_bulan_ini_lyear += (float) $value; 
        }
        $data1['bulan_ini_lyear']['Total'] = $cogm_lyear + $total_bulan_ini_lyear;
        $data1['bulan_ini']['Yoy'] = $this->division($total_bulan_ini - $total_bulan_ini_lyear,$total_bulan_ini_lyear)*100;

        $cogmup = 0;
        for ($i=0;$i<9;$i++){
         $cogmup += (float) $this->cek_null($data_up[$i], $key);
        }
        $data1['up_bulan_ini']['Packaging']                = ($this->cek_null($data_up[9], $key));
        $data1['up_bulan_ini']['Distribution']             = ($this->cek_null($data_up[10], $key));
        $data1['up_bulan_ini']['Variance Stok']            = ($this->cek_null($data_up[11], $key));
        $data1['up_bulan_ini']['WIP (Purchasing)']         = ($this->cek_null($data_up[12], $key));

        $total_up_bulan_ini = 0;
        foreach ($data1['up_bulan_ini'] as $value){
         $total_up_bulan_ini += (float) $value; 
        }
        $data1['up_bulan_ini']['Total'] = $cogmup + $total_up_bulan_ini;

        $rkap_up_cogm = 0;
        for ($i=0;$i<9;$i++){
         $rkap_up_cogm += (float) $this->cek_null($rkap_data_up[$i], $key);
        }
        $data1['rkap_up_bulan_ini']['Packaging']                = ($this->cek_null($rkap_data_up[9], $key));
        $data1['rkap_up_bulan_ini']['Distribution']             = ($this->cek_null($rkap_data_up[10], $key));
        $data1['rkap_up_bulan_ini']['Variance Stok']            = ($this->cek_null($rkap_data_up[11], $key));
        $data1['rkap_up_bulan_ini']['WIP (Purchasing)']         = ($this->cek_null($rkap_data_up[12], $key));

        $total_rkap_up_bulan_ini = 0;
        foreach ($data1['rkap_up_bulan_ini'] as $value){
         $total_rkap_up_bulan_ini += (float) $value; 
        }
        $data1['rkap_up_bulan_ini']['Total'] = $rkap_up_cogm + $total_rkap_up_bulan_ini;

        $cogm_lyear_up = 0;
        for ($i=0;$i<9;$i++){
         $cogm_lyear_up += (float) $this->cek_null($data_lyear_up[$i], $key);
        }
        $data1['up_bulan_ini_lyear']['Packaging']                = ($this->cek_null($data_lyear_up[9], $key));
        $data1['up_bulan_ini_lyear']['Distribution']             = ($this->cek_null($data_lyear_up[10], $key));
        $data1['up_bulan_ini_lyear']['Variance Stok']            = ($this->cek_null($data_lyear_up[11], $key));
        $data1['up_bulan_ini_lyear']['WIP (Purchasing)']         = ($this->cek_null($data_lyear_up[12], $key));

        $total_up_bulan_ini_lyear = 0;
        foreach ($data1['up_bulan_ini_lyear'] as $value){
         $total_up_bulan_ini_lyear += (float) $value; 
        }
        $data1['up_bulan_ini_lyear']['Total'] = $cogm_lyear_up + $total_up_bulan_ini_lyear;
        $data1['up_bulan_ini']['Yoy'] = $this->division($total_up_bulan_ini - $total_up_bulan_ini_lyear,$total_up_bulan_ini_lyear)*100;
        return $data1;
    }

    //prod cost
    public function set_data($key, $data,$rkap_data,$data_lyear,$data_up,$rkap_data_up,$data_lyear_up){
        $data1['bulan_ini']['Raw Material']                          = ($this->cek_null($data[0], $key));
        $data1['bulan_ini']['Supporting Material']                   = ($this->cek_null($data[1], $key));
        $data1['bulan_ini']['Fuel']                                  = ($this->cek_null($data[2], $key));
        $data1['bulan_ini']['Electricity']                           = ($this->cek_null($data[3], $key));
        $data1['bulan_ini']['Labor']                                 = ($this->cek_null($data[4], $key));
        $data1['bulan_ini']['Maintenance']                           = ($this->cek_null($data[5], $key));
        $data1['bulan_ini']['Depl. Deprec. and Amortization']        = ($this->cek_null($data[6], $key));
        $data1['bulan_ini']['General & Administration']               = ($this->cek_null($data[7], $key));
        $data1['bulan_ini']['Taxes and Insurance']                   = ($this->cek_null($data[8], $key));
        $total_bulan_ini = 0;
        foreach ($data1['bulan_ini'] as $value){
         $total_bulan_ini += (float) $value; 
        }
        $data1['bulan_ini']['Total'] = $total_bulan_ini;

        $data1['rkap_bulan_ini']['Raw Material']                          = ($this->cek_null($rkap_data[0], $key));
        $data1['rkap_bulan_ini']['Supporting Material']                   = ($this->cek_null($rkap_data[1], $key));
        $data1['rkap_bulan_ini']['Fuel']                                  = ($this->cek_null($rkap_data[2], $key));
        $data1['rkap_bulan_ini']['Electricity']                           = ($this->cek_null($rkap_data[3], $key));
        $data1['rkap_bulan_ini']['Labor']                                 = ($this->cek_null($rkap_data[4], $key));
        $data1['rkap_bulan_ini']['Maintenance']                           = ($this->cek_null($rkap_data[5], $key));
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']        = ($this->cek_null($rkap_data[6], $key));
        $data1['rkap_bulan_ini']['General & Administration']               = ($this->cek_null($rkap_data[7], $key));
        $data1['rkap_bulan_ini']['Taxes and Insurance']                   = ($this->cek_null($rkap_data[8], $key));
        $total_rkap_bulan_ini = 0;
        foreach ($data1['rkap_bulan_ini'] as $value){
         $total_rkap_bulan_ini += (float) $value; 
        }
        $data1['rkap_bulan_ini']['Total'] = $total_rkap_bulan_ini;

        $data1['bulan_ini_lyear']['Raw Material']                          = ($this->cek_null($data_lyear[0], $key));
        $data1['bulan_ini_lyear']['Supporting Material']                   = ($this->cek_null($data_lyear[1], $key));
        $data1['bulan_ini_lyear']['Fuel']                                  = ($this->cek_null($data_lyear[2], $key));
        $data1['bulan_ini_lyear']['Electricity']                           = ($this->cek_null($data_lyear[3], $key));
        $data1['bulan_ini_lyear']['Labor']                                 = ($this->cek_null($data_lyear[4], $key));
        $data1['bulan_ini_lyear']['Maintenance']                           = ($this->cek_null($data_lyear[5], $key));
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']        = ($this->cek_null($data_lyear[6], $key));
        $data1['bulan_ini_lyear']['General & Administration']               = ($this->cek_null($data_lyear[7], $key));
        $data1['bulan_ini_lyear']['Taxes and Insurance']                   = ($this->cek_null($data_lyear[8], $key));
        $total_bulan_ini_lyear = 0;
        foreach ($data1['bulan_ini_lyear'] as $value){
         $total_bulan_ini_lyear += (float) $value; 
        }
        $data1['bulan_ini_lyear']['Total'] = $total_bulan_ini_lyear;
        $data1['bulan_ini']['Yoy'] = $this->division($total_bulan_ini - $total_bulan_ini_lyear,$total_bulan_ini_lyear)*100;

        $data1['up_bulan_ini']['Raw Material']                          = ($this->cek_null($data_up[0], $key));
        $data1['up_bulan_ini']['Supporting Material']                   = ($this->cek_null($data_up[1], $key));
        $data1['up_bulan_ini']['Fuel']                                  = ($this->cek_null($data_up[2], $key));
        $data1['up_bulan_ini']['Electricity']                           = ($this->cek_null($data_up[3], $key));
        $data1['up_bulan_ini']['Labor']                                 = ($this->cek_null($data_up[4], $key));
        $data1['up_bulan_ini']['Maintenance']                           = ($this->cek_null($data_up[5], $key));
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']        = ($this->cek_null($data_up[6], $key));
        $data1['up_bulan_ini']['General & Administration']               = ($this->cek_null($data_up[7], $key));
        $data1['up_bulan_ini']['Taxes and Insurance']                   = ($this->cek_null($data_up[8], $key));
        $total_up_bulan_ini = 0;
        foreach ($data1['up_bulan_ini'] as $value){
         $total_up_bulan_ini += (float) $value; 
        }
        $data1['up_bulan_ini']['Total'] = $total_up_bulan_ini;

        $data1['rkap_up_bulan_ini']['Raw Material']                          = ($this->cek_null($rkap_data_up[0], $key));
        $data1['rkap_up_bulan_ini']['Supporting Material']                   = ($this->cek_null($rkap_data_up[1], $key));
        $data1['rkap_up_bulan_ini']['Fuel']                                  = ($this->cek_null($rkap_data_up[2], $key));
        $data1['rkap_up_bulan_ini']['Electricity']                           = ($this->cek_null($rkap_data_up[3], $key));
        $data1['rkap_up_bulan_ini']['Labor']                                 = ($this->cek_null($rkap_data_up[4], $key));
        $data1['rkap_up_bulan_ini']['Maintenance']                           = ($this->cek_null($rkap_data_up[5], $key));
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']        = ($this->cek_null($rkap_data_up[6], $key));
        $data1['rkap_up_bulan_ini']['General & Administration']               = ($this->cek_null($rkap_data_up[7], $key));
        $data1['rkap_up_bulan_ini']['Taxes and Insurance']                   = ($this->cek_null($rkap_data_up[8], $key));
        $total_rkap_up_bulan_ini = 0;
        foreach ($data1['rkap_up_bulan_ini'] as $value){
         $total_rkap_up_bulan_ini += (float) $value; 
        }
        $data1['rkap_up_bulan_ini']['Total'] = $total_rkap_up_bulan_ini;

        $data1['up_bulan_ini_lyear']['Raw Material']                          = ($this->cek_null($data_lyear_up[0], $key));
        $data1['up_bulan_ini_lyear']['Supporting Material']                   = ($this->cek_null($data_lyear_up[1], $key));
        $data1['up_bulan_ini_lyear']['Fuel']                                  = ($this->cek_null($data_lyear_up[2], $key));
        $data1['up_bulan_ini_lyear']['Electricity']                           = ($this->cek_null($data_lyear_up[3], $key));
        $data1['up_bulan_ini_lyear']['Labor']                                 = ($this->cek_null($data_lyear_up[4], $key));
        $data1['up_bulan_ini_lyear']['Maintenance']                           = ($this->cek_null($data_lyear_up[5], $key));
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']        = ($this->cek_null($data_lyear_up[6], $key));
        $data1['up_bulan_ini_lyear']['General & Administration']               = ($this->cek_null($data_lyear_up[7], $key));
        $data1['up_bulan_ini_lyear']['Taxes and Insurance']                   = ($this->cek_null($data_lyear_up[8], $key));
        $total_up_bulan_ini_lyear = 0;
        foreach ($data1['up_bulan_ini_lyear'] as $value){
         $total_up_bulan_ini_lyear += (float) $value; 
        }
        $data1['up_bulan_ini_lyear']['Total'] = $total_up_bulan_ini_lyear;
        $data1['up_bulan_ini']['Yoy'] = $this->division($total_up_bulan_ini - $total_up_bulan_ini_lyear,$total_up_bulan_ini_lyear)*100;
        return $data1;
    }

    // function division($a, $b) {         
    //     if($b == 0){
    //       return "";
    //     }else{
    //        return $a/$b; 
    //     }
    // }

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

    function cek_null($data, $key){
        if(isset($data->AMOUNT)){
            $cat = $data->AMOUNT;
        }else{
            $cat = 0;
        }
        return $cat;
    }

    function cek_data_n($data){
        if($data == null){
            $data = 0;
        }
        return $data;
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
            $month1 = $month-1;
            $month_lalu="0$month1";
            if ($i != $bts) {
                $tmbhn = ",";
            }else{
                $tmbhn = "";
            }
            $date_between = "$temp '$year.$month' $tmbhn";
            $temp = $date_between;
        }
        $data[0]    = $temp;
        $data[1]    = str_replace($month, $month_lalu, $temp);
        //$data[1]    = str_replace($year, $year_lalu, $temp);
        return $data;
    }

}

/* End of file cost_report.php */
/* Location: ./application/controllers/cost_report.php */