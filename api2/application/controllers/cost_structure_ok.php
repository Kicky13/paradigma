<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class cost_structure extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cost_structure');
    }
 
    public function get_data_mview()
    {
        //$comp           = $_GET['company'];
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp           = str_replace(",","','",$comp);
        //$date           = $_GET['date'];
        $date = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
        $strdate=str_replace(".","-",$date)."-20";
        $newdate = strtotime('-1 month' , strtotime ($strdate)) ;
        $date_lmonth = date( 'Y.m' , $newdate);
        $date_lyear      = (intval(substr($date, 0, 4)) - 1).substr($date,4);
        $temp           = $this->date_between($date);
        $temp_lyear     = $this->date_between($date_lyear);

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
        $clinker1       = $this->m_cost_structure->get_clinker($comp, $date, 'ACT', $plant);
        $clinker2       = $this->m_cost_structure->get_clinker($comp, $date_lmonth, 'ACT', $plant);

        $cement1        = $this->m_cost_structure->get_cement($comp, $date, 'ACT', $plant2);
        $cement2        = $this->m_cost_structure->get_cement($comp, $date_lmonth, 'ACT', $plant2);

        $sales1         = $this->m_cost_structure->get_sales($comp, $date, 'ACT');
        $sales2         = $this->m_cost_structure->get_sales($comp, $date_lmonth, 'ACT');

        $data1 = array();
        $data1['bulan_ini']['clinker']       = 0;//(float) $clinker1->AMOUNT;
        $data1['bulan_ini']['cement']        = 0;//(float) $cement1->AMOUNT;
        $data1['bulan_ini']['sales']         = 0;//(float) $sales1->AMOUNT;

        $data1['bulan_lalu']['clinker']      = 0;//(float) $clinker2->AMOUNT;
        $data1['bulan_lalu']['cement']       = 0;//(float) $cement2->AMOUNT;
        $data1['bulan_lalu']['sales']        = 0;//(float) $sales2->AMOUNT;
        $data['s'.$comp] = array($data1);

        // cogm material view
        $data_cogm        = $this->m_cost_structure->get_data_desc($comp, $date, 'ACT', '1 and 9', '10', 'selected');
        $rkap_data_cogm   = $this->m_cost_structure->get_data_desc($comp, $date, 'BUD', '1 and 9', '10','selected');
        $data_cogm_lyear   = $this->m_cost_structure->get_data_desc($comp, $date_lyear, 'ACT', '1 and 9', '10','selected');
        $data_cogm_up        = $this->m_cost_structure->get_data_desc($comp, $temp, 'ACT', '1 and 9', '10','upto');
        $rkap_data_cogm_up   = $this->m_cost_structure->get_data_desc($comp, $temp, 'BUD', '1 and 9', '10','upto');
        $data_cogm_lyear_up   = $this->m_cost_structure->get_data_desc($comp, $temp_lyear, 'ACT', '1 and 9', '10','upto');

        $tmp_data_cogm = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);
        $tmp_rkap_data_cogm = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);
        $tmp_data_cogm_lyear = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);
        $tmp_data_cogm_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);
        $tmp_rkap_data_cogm_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);
        $tmp_data_cogm_lyear_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0);

        foreach ($data_cogm as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm[$ind] = $x->JML; 
        }
        foreach ($rkap_data_cogm as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_cogm[$ind] = $x->JML; 
        }
        foreach ($data_cogm_lyear as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm_lyear[$ind] = $x->JML; 
        }
        foreach ($data_cogm_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm_up[$ind] = $x->JML; 
        }
        foreach ($rkap_data_cogm_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_cogm_up[$ind] = $x->JML; 
        }
        foreach ($data_cogm_lyear_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogm_lyear_up[$ind] = $x->JML; 
        }
        
        $data1 = array();
        $data1['bulan_ini']['Raw Material']                          = (float) $tmp_data_cogm['01'];
        $data1['bulan_ini']['Supporting Material']                   = (float) $tmp_data_cogm['02'];
        $data1['bulan_ini']['Fuel']                                  = (float) $tmp_data_cogm['03'];
        $data1['bulan_ini']['Electricity']                           = (float) $tmp_data_cogm['04'];
        $data1['bulan_ini']['Labor']                                 = (float) $tmp_data_cogm['05'];
        $data1['bulan_ini']['Maintenance']                           = (float) $tmp_data_cogm['06'];
        $data1['bulan_ini']['Depl. Deprec. and Amortization']        = (float) $tmp_data_cogm['07'];
        $data1['bulan_ini']['General & Adminitration']               = (float) $tmp_data_cogm['08'];
        $data1['bulan_ini']['Taxes and Insurance']                   = (float) $tmp_data_cogm['09'];
        $data1['bulan_ini']['Total']                                 = (float) $tmp_data_cogm['10'];

        $data1['rkap_bulan_ini']['Raw Material']                     = (float) $tmp_rkap_data_cogm['01'];
        $data1['rkap_bulan_ini']['Supporting Material']              = (float) $tmp_rkap_data_cogm['02'];
        $data1['rkap_bulan_ini']['Fuel']                             = (float) $tmp_rkap_data_cogm['03'];
        $data1['rkap_bulan_ini']['Electricity']                      = (float) $tmp_rkap_data_cogm['04'];
        $data1['rkap_bulan_ini']['Labor']                            = (float) $tmp_rkap_data_cogm['05'];
        $data1['rkap_bulan_ini']['Maintenance']                      = (float) $tmp_rkap_data_cogm['06'];
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']   = (float) $tmp_rkap_data_cogm['07'];
        $data1['rkap_bulan_ini']['General & Adminitration']          = (float) $tmp_rkap_data_cogm['08'];
        $data1['rkap_bulan_ini']['Taxes and Insurance']              = (float) $tmp_rkap_data_cogm['09'];
        $data1['rkap_bulan_ini']['Total']                            = (float) $tmp_rkap_data_cogm['10'];
        $data1['bulan_ini']['Percent']                               = $this->division($data1['bulan_ini']['Total'],$data1['rkap_bulan_ini']['Total'])*100;

        $data1['bulan_ini_lyear']['Raw Material']                    = (float) $tmp_data_cogm_lyear['01'];
        $data1['bulan_ini_lyear']['Supporting Material']             = (float) $tmp_data_cogm_lyear['02'];
        $data1['bulan_ini_lyear']['Fuel']                            = (float) $tmp_data_cogm_lyear['03'];
        $data1['bulan_ini_lyear']['Electricity']                     = (float) $tmp_data_cogm_lyear['04'];
        $data1['bulan_ini_lyear']['Labor']                           = (float) $tmp_data_cogm_lyear['05'];
        $data1['bulan_ini_lyear']['Maintenance']                     = (float) $tmp_data_cogm_lyear['06'];
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']  = (float) $tmp_data_cogm_lyear['07'];
        $data1['bulan_ini_lyear']['General & Adminitration']         = (float) $tmp_data_cogm_lyear['08'];
        $data1['bulan_ini_lyear']['Taxes and Insurance']             = (float) $tmp_data_cogm_lyear['09'];
        $data1['bulan_ini_lyear']['Total']                           = (float) $tmp_data_cogm_lyear['10'];
        $data1['bulan_ini']['Yoy']                                   = $this->division((float) $tmp_data_cogm['10'] - (float) $tmp_data_cogm_lyear['10'],(float) $tmp_data_cogm_lyear['10'])*100;

        $data1['up_bulan_ini']['Raw Material']                       = (float) $tmp_data_cogm_up['01'];
        $data1['up_bulan_ini']['Supporting Material']                = (float) $tmp_data_cogm_up['02'];
        $data1['up_bulan_ini']['Fuel']                               = (float) $tmp_data_cogm_up['03'];
        $data1['up_bulan_ini']['Electricity']                        = (float) $tmp_data_cogm_up['04'];
        $data1['up_bulan_ini']['Labor']                              = (float) $tmp_data_cogm_up['05'];
        $data1['up_bulan_ini']['Maintenance']                        = (float) $tmp_data_cogm_up['06'];
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']     = (float) $tmp_data_cogm_up['07'];
        $data1['up_bulan_ini']['General & Adminitration']            = (float) $tmp_data_cogm_up['08'];
        $data1['up_bulan_ini']['Taxes and Insurance']                = (float) $tmp_data_cogm_up['09'];
        $data1['up_bulan_ini']['Total']                              = (float) $tmp_data_cogm_up['10'];

        $data1['rkap_up_bulan_ini']['Raw Material']                     = (float) $tmp_rkap_data_cogm_up['01'];
        $data1['rkap_up_bulan_ini']['Supporting Material']              = (float) $tmp_rkap_data_cogm_up['02'];
        $data1['rkap_up_bulan_ini']['Fuel']                             = (float) $tmp_rkap_data_cogm_up['03'];
        $data1['rkap_up_bulan_ini']['Electricity']                      = (float) $tmp_rkap_data_cogm_up['04'];
        $data1['rkap_up_bulan_ini']['Labor']                            = (float) $tmp_rkap_data_cogm_up['05'];
        $data1['rkap_up_bulan_ini']['Maintenance']                      = (float) $tmp_rkap_data_cogm_up['06'];
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']   = (float) $tmp_rkap_data_cogm_up['07'];
        $data1['rkap_up_bulan_ini']['General & Adminitration']          = (float) $tmp_rkap_data_cogm_up['08'];
        $data1['rkap_up_bulan_ini']['Taxes and Insurance']              = (float) $tmp_rkap_data_cogm_up['09'];
        $data1['rkap_up_bulan_ini']['Total']                            = (float) $tmp_rkap_data_cogm_up['10'];
        $data1['up_bulan_ini']['Percent']                               = $this->division($data1['up_bulan_ini']['Total'],$data1['rkap_up_bulan_ini']['Total'])*100;

        $data1['up_bulan_ini_lyear']['Raw Material']                    = (float) $tmp_data_cogm_lyear_up['01'];
        $data1['up_bulan_ini_lyear']['Supporting Material']             = (float) $tmp_data_cogm_lyear_up['02'];
        $data1['up_bulan_ini_lyear']['Fuel']                            = (float) $tmp_data_cogm_lyear_up['03'];
        $data1['up_bulan_ini_lyear']['Electricity']                     = (float) $tmp_data_cogm_lyear_up['04'];
        $data1['up_bulan_ini_lyear']['Labor']                           = (float) $tmp_data_cogm_lyear_up['05'];
        $data1['up_bulan_ini_lyear']['Maintenance']                     = (float) $tmp_data_cogm_lyear_up['06'];
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']  = (float) $tmp_data_cogm_lyear_up['07'];
        $data1['up_bulan_ini_lyear']['General & Adminitration']         = (float) $tmp_data_cogm_lyear_up['08'];
        $data1['up_bulan_ini_lyear']['Taxes and Insurance']             = (float) $tmp_data_cogm_lyear_up['09'];
        $data1['up_bulan_ini_lyear']['Total']                           = (float) $tmp_data_cogm_lyear_up['10'];
        $data1['up_bulan_ini']['Yoy']                                   = $this->division((float) $tmp_data_cogm_up['10'] - (float) $tmp_data_cogm_lyear_up['10'],(float) $tmp_data_cogm_lyear_up['10'])*100;
        $data['production_cost'] = array($data1);

        // cogs material view
        $data_cogs        = $this->m_cost_structure->get_data_desc($comp, $date, 'ACT', '10 and 13', '14','selected');
        $rkap_data_cogs   = $this->m_cost_structure->get_data_desc($comp, $date, 'BUD', '10 and 13', '14','selected');
        $data_cogs_lyear   = $this->m_cost_structure->get_data_desc($comp, $date_lyear, 'ACT', '10 and 13', '14','selected');
        $data_cogs_up        = $this->m_cost_structure->get_data_desc($comp, $temp, 'ACT', '10 and 13', '14','upto');
        $rkap_data_cogs_up   = $this->m_cost_structure->get_data_desc($comp, $temp, 'BUD', '10 and 13', '14','upto');
        $data_cogs_lyear_up   = $this->m_cost_structure->get_data_desc($comp, $temp_lyear, 'ACT', '10 and 13', '14','upto');

        $tmp_data_cogs = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);
        $tmp_rkap_data_cogs = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);
        $tmp_data_cogs_lyear = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);
        $tmp_data_cogs_up = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);
        $tmp_rkap_data_cogs_up = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);
        $tmp_data_cogs_lyear_up = array('10'=>0,'11'=>0,'12'=>0,'13'=>0);

        foreach ($data_cogs as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogs[$ind] = $x->JML; 
        }
        foreach ($rkap_data_cogs as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_cogs[$ind] = $x->JML; 
        }
        foreach ($data_cogs_lyear as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogs_lyear[$ind] = $x->JML; 
        }
        foreach ($data_cogs_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogs_up[$ind] = $x->JML; 
        }
        foreach ($rkap_data_cogs_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_cogs_up[$ind] = $x->JML; 
        }
        foreach ($data_cogs_lyear_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_cogs_lyear_up[$ind] = $x->JML; 
        }
        
        $data1 = array();
        $data1['bulan_ini']['Packaging']                  = (float) $tmp_data_cogs['10'];
        $data1['bulan_ini']['Distribution']               = (float) $tmp_data_cogs['11'];
        $data1['bulan_ini']['Variance Stok']              = (float) $tmp_data_cogs['12'];
        $data1['bulan_ini']['WIP (Purchasing)']           = (float) $tmp_data_cogs['13'];
        $data1['bulan_ini']['Total']                      = (float) $tmp_data_cogm['10']+ (float) $tmp_data_cogs['15'];

        $data1['rkap_bulan_ini']['Packaging']             = (float) $tmp_rkap_data_cogs['10'];
        $data1['rkap_bulan_ini']['Distribution']          = (float) $tmp_rkap_data_cogs['11'];
        $data1['rkap_bulan_ini']['Variance Stok']         = (float) $tmp_rkap_data_cogs['12'];
        $data1['rkap_bulan_ini']['WIP (Purchasing)']      = (float) $tmp_rkap_data_cogs['13'];
        $data1['rkap_bulan_ini']['Total']                 = (float) $tmp_rkap_data_cogm['10']+ (float) $tmp_rkap_data_cogs['15'];
        $data1['bulan_ini']['Percent']                    = $this->division($data1['bulan_ini']['Total'],$data1['rkap_bulan_ini']['Total'])*100;

        $data1['bulan_ini_lyear']['Packaging']            = (float) $tmp_data_cogs_lyear['10'];
        $data1['bulan_ini_lyear']['Distribution']         = (float) $tmp_data_cogs_lyear['11'];
        $data1['bulan_ini_lyear']['Variance Stok']        = (float) $tmp_data_cogs_lyear['12'];
        $data1['bulan_ini_lyear']['WIP (Purchasing)']     = (float) $tmp_data_cogs_lyear['13'];
        $data1['bulan_ini_lyear']['Total']                = (float) $tmp_data_cogm_lyear['10']+ (float) $tmp_data_cogs_lyear['15'];
        $data1['bulan_ini']['Yoy']                        = $this->division((float) $data1['bulan_ini']['Total'] - (float) $data1['bulan_ini_lyear']['Total'],(float) $data1['bulan_ini_lyear']['Total'])*100;

        $data1['up_bulan_ini']['Packaging']               = (float) $tmp_data_cogs_up['10'];
        $data1['up_bulan_ini']['Distribution']            = (float) $tmp_data_cogs_up['11'];
        $data1['up_bulan_ini']['Variance Stok']           = (float) $tmp_data_cogs_up['12'];
        $data1['up_bulan_ini']['WIP (Purchasing)']        = (float) $tmp_data_cogs_up['13'];
        $data1['up_bulan_ini']['Total']                   = (float) $tmp_data_cogm_up['10']+ (float) $tmp_data_cogs_up['15'];

        $data1['rkap_up_bulan_ini']['Packaging']          = (float) $tmp_rkap_data_cogs_up['10'];
        $data1['rkap_up_bulan_ini']['Distribution']       = (float) $tmp_rkap_data_cogs_up['11'];
        $data1['rkap_up_bulan_ini']['Variance Stok']      = (float) $tmp_rkap_data_cogs_up['12'];
        $data1['rkap_up_bulan_ini']['WIP (Purchasing)']   = (float) $tmp_rkap_data_cogs_up['13'];
        $data1['rkap_up_bulan_ini']['Total']              = (float) $tmp_rkap_data_cogm_up['10']+ (float) $tmp_rkap_data_cogs_up['15'];
        $data1['up_bulan_ini']['Percent']                 = $this->division($data1['up_bulan_ini']['Total'],$data1['rkap_up_bulan_ini']['Total'])*100;

        $data1['up_bulan_ini_lyear']['Packaging']         = (float) $tmp_data_cogs_lyear_up['10'];
        $data1['up_bulan_ini_lyear']['Distribution']      = (float) $tmp_data_cogs_lyear_up['11'];
        $data1['up_bulan_ini_lyear']['Variance Stok']     = (float) $tmp_data_cogs_lyear_up['12'];
        $data1['up_bulan_ini_lyear']['WIP (Purchasing)']  = (float) $tmp_data_cogs_lyear_up['13'];
        $data1['up_bulan_ini_lyear']['Total']             = (float) $tmp_data_cogm_lyear_up['10']+ (float) $tmp_data_cogs_lyear_up['15'];
        $data1['up_bulan_ini']['Yoy']                     = $this->division((float) $data1['up_bulan_ini']['Total'] - (float) $data1['up_bulan_ini_lyear']['Total'],(float) $data1['up_bulan_ini_lyear']['Total'])*100;
        $data['good_of_sold'] = array($data1);

        // gae material view
        $data_gae        = $this->m_cost_structure->get_data_desc($comp, $date, 'ACT', '14 and 21', '22','selected');
        $rkap_data_gae   = $this->m_cost_structure->get_data_desc($comp, $date, 'BUD', '14 and 21', '22','selected');
        $data_gae_lyear   = $this->m_cost_structure->get_data_desc($comp, $date_lyear, 'ACT', '14 and 21', '22','selected');
        $data_gae_up        = $this->m_cost_structure->get_data_desc($comp, $temp, 'ACT', '14 and 21', '22','upto');
        $rkap_data_gae_up   = $this->m_cost_structure->get_data_desc($comp, $temp, 'BUD', '14 and 21', '22','upto');
        $data_gae_lyear_up   = $this->m_cost_structure->get_data_desc($comp, $temp_lyear, 'ACT', '14 and 21', '22','upto');

        $tmp_data_gae = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);
        $tmp_rkap_data_gae = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);
        $tmp_data_gae_lyear = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);
        $tmp_data_gae_up = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);
        $tmp_rkap_data_gae_up = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);
        $tmp_data_gae_lyear_up = array('14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0);

        foreach ($data_gae as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_gae[$ind] = $x->JML; 
        }
        foreach ($rkap_data_gae as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_gae[$ind] = $x->JML; 
        }
        foreach ($data_gae_lyear as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_gae_lyear[$ind] = $x->JML; 
        }
        foreach ($data_gae_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_gae_up[$ind] = $x->JML; 
        }
        foreach ($rkap_data_gae_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_gae_up[$ind] = $x->JML; 
        }
        foreach ($data_gae_lyear_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_gae_lyear_up[$ind] = $x->JML; 
        }
        
        $data1 = array();
        $data1['bulan_ini']['Supporting Material']                      = (float) $tmp_data_gae['14'];
        $data1['bulan_ini']['Fuel']                                     = (float) $tmp_data_gae['15'];
        $data1['bulan_ini']['Electricity']                              = (float) $tmp_data_gae['16'];
        $data1['bulan_ini']['Labor']                                    = (float) $tmp_data_gae['17'];
        $data1['bulan_ini']['Maintenance']                              = (float) $tmp_data_gae['18'];
        $data1['bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_gae['19'];
        $data1['bulan_ini']['General & Administration']                 = (float) $tmp_data_gae['20']; 
        $data1['bulan_ini']['Taxes and insurance']                      = (float) $tmp_data_gae['21'];
        $data1['bulan_ini']['Total']                                    = (float) $tmp_data_gae['22'];

        $data1['rkap_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_gae['14'];
        $data1['rkap_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_gae['15'];
        $data1['rkap_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_gae['16'];
        $data1['rkap_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_gae['17'];
        $data1['rkap_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_gae['18'];
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_gae['19'];
        $data1['rkap_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_gae['20']; 
        $data1['rkap_bulan_ini']['Taxes and insurance']                 = (float) $tmp_rkap_data_gae['21'];
        $data1['rkap_bulan_ini']['Total']                               = (float) $tmp_rkap_data_gae['22'];
        $data1['bulan_ini']['Percent']                                  = $this->division($data1['bulan_ini']['Total'],$data1['rkap_bulan_ini']['Total'])*100;

        $data1['bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_gae_lyear['14'];
        $data1['bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_gae_lyear['15'];
        $data1['bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_gae_lyear['16'];
        $data1['bulan_ini_lyear']['Labor']                              = (float) $tmp_data_gae_lyear['17'];
        $data1['bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_gae_lyear['18'];
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_gae_lyear['19'];
        $data1['bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_gae_lyear['20']; 
        $data1['bulan_ini_lyear']['Taxes and insurance']                = (float) $tmp_data_gae_lyear['21'];
        $data1['bulan_ini_lyear']['Total']                              = (float) $tmp_data_gae_lyear['22'];
        $data1['bulan_ini']['Yoy']                                      = $this->division((float) $data1['bulan_ini']['Total'] - (float) $data1['bulan_ini_lyear']['Total'],(float) $data1['bulan_ini_lyear']['Total'])*100;

        $data1['up_bulan_ini']['Supporting Material']                      = (float) $tmp_data_gae_up['14'];
        $data1['up_bulan_ini']['Fuel']                                     = (float) $tmp_data_gae_up['15'];
        $data1['up_bulan_ini']['Electricity']                              = (float) $tmp_data_gae_up['16'];
        $data1['up_bulan_ini']['Labor']                                    = (float) $tmp_data_gae_up['17'];
        $data1['up_bulan_ini']['Maintenance']                              = (float) $tmp_data_gae_up['18'];
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_gae_up['19'];
        $data1['up_bulan_ini']['General & Administration']                 = (float) $tmp_data_gae_up['20']; 
        $data1['up_bulan_ini']['Taxes and insurance']                      = (float) $tmp_data_gae_up['21'];
        $data1['up_bulan_ini']['Total']                                    = (float) $tmp_data_gae_up['22'];

        $data1['rkap_up_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_gae_up['14'];
        $data1['rkap_up_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_gae_up['15'];
        $data1['rkap_up_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_gae_up['16'];
        $data1['rkap_up_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_gae_up['17'];
        $data1['rkap_up_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_gae_up['18'];
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_gae_up['19'];
        $data1['rkap_up_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_gae_up['20']; 
        $data1['rkap_up_bulan_ini']['Taxes and insurance']                 = (float) $tmp_rkap_data_gae_up['21'];
        $data1['rkap_up_bulan_ini']['Total']                               = (float) $tmp_rkap_data_gae_up['22'];
        $data1['up_bulan_ini']['Percent']                               = $this->division($data1['up_bulan_ini']['Total'],$data1['rkap_up_bulan_ini']['Total'])*100;

        $data1['up_bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_gae_lyear_up['14'];
        $data1['up_bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_gae_lyear_up['15'];
        $data1['up_bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_gae_lyear_up['16'];
        $data1['up_bulan_ini_lyear']['Labor']                              = (float) $tmp_data_gae_lyear_up['17'];
        $data1['up_bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_gae_lyear_up['18'];
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_gae_lyear_up['19'];
        $data1['up_bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_gae_lyear_up['20']; 
        $data1['up_bulan_ini_lyear']['Taxes and insurance']                = (float) $tmp_data_gae_lyear_up['21'];
        $data1['up_bulan_ini_lyear']['Total']                              = (float) $tmp_data_gae_lyear_up['22'];
        $data1['up_bulan_ini']['Yoy']                                      = $this->division((float) $data1['up_bulan_ini']['Total'] - (float) $data1['up_bulan_ini_lyear']['Total'],(float) $data1['up_bulan_ini_lyear']['Total'])*100;
        $data['general_administration'] = array($data1);        

        // sales material view
        $data_sales        = $this->m_cost_structure->get_data_desc($comp, $date, 'ACT', '22 and 29', '30','selected');
        $rkap_data_sales   = $this->m_cost_structure->get_data_desc($comp, $date, 'BUD', '22 and 29', '30','selected');
        $data_sales_lyear   = $this->m_cost_structure->get_data_desc($comp, $date_lyear, 'ACT', '22 and 29', '30','selected');
        $data_sales_up        = $this->m_cost_structure->get_data_desc($comp, $temp, 'ACT', '22 and 29', '30','upto');
        $rkap_data_sales_up   = $this->m_cost_structure->get_data_desc($comp, $temp, 'BUD', '22 and 29', '30','upto');
        $data_sales_lyear_up   = $this->m_cost_structure->get_data_desc($comp, $temp_lyear, 'ACT', '22 and 29', '30','upto');

        $tmp_data_sales = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);
        $tmp_rkap_data_sales = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);
        $tmp_data_sales_lyear = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);
        $tmp_data_sales_up = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);
        $tmp_rkap_data_sales_up = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);
        $tmp_data_sales_lyear_up = array('22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'28'=>0,'29'=>0);

        foreach ($data_sales as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_sales[$ind] = $x->JML; 
        }
        foreach ($rkap_data_sales as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_sales[$ind] = $x->JML; 
        }
        foreach ($data_sales_lyear as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_sales_lyear[$ind] = $x->JML; 
        }
        foreach ($data_sales_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_sales_up[$ind] = $x->JML; 
        }
        foreach ($rkap_data_sales_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_rkap_data_sales_up[$ind] = $x->JML; 
        }
        foreach ($data_sales_lyear_up as $x){
         $nol = '0'.$x->CSTR_NO;
         $ind = substr($nol,-2);   
         $tmp_data_sales_lyear_up[$ind] = $x->JML; 
        }
        
        $data1 = array();
        $data1['bulan_ini']['Supporting Material']                      = (float) $tmp_data_sales['22'];
        $data1['bulan_ini']['Fuel']                                     = (float) $tmp_data_sales['23'];
        $data1['bulan_ini']['Electricity']                              = (float) $tmp_data_sales['24'];
        $data1['bulan_ini']['Labor']                                    = (float) $tmp_data_sales['25'];
        $data1['bulan_ini']['Maintenance']                              = (float) $tmp_data_sales['26'];
        $data1['bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_sales['27'];
        $data1['bulan_ini']['General & Administration']                 = (float) $tmp_data_sales['28']; 
        $data1['bulan_ini']['Marketing & Distribution']                 = (float) $tmp_data_sales['29'];
        $data1['bulan_ini']['Total']                                    = (float) $tmp_data_sales['30'];

        $data1['rkap_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_sales['22'];
        $data1['rkap_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_sales['23'];
        $data1['rkap_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_sales['24'];
        $data1['rkap_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_sales['25'];
        $data1['rkap_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_sales['26'];
        $data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_sales['27'];
        $data1['rkap_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_sales['28']; 
        $data1['rkap_bulan_ini']['Marketing & Distribution']            = (float) $tmp_rkap_data_sales['29'];
        $data1['rkap_bulan_ini']['Total']                               = (float) $tmp_rkap_data_sales['30'];
        $data1['bulan_ini']['Percent']                                  = $this->division($data1['bulan_ini']['Total'],$data1['rkap_bulan_ini']['Total'])*100;

        $data1['bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_sales_lyear['22'];
        $data1['bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_sales_lyear['23'];
        $data1['bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_sales_lyear['24'];
        $data1['bulan_ini_lyear']['Labor']                              = (float) $tmp_data_sales_lyear['25'];
        $data1['bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_sales_lyear['26'];
        $data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_sales_lyear['27'];
        $data1['bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_sales_lyear['28']; 
        $data1['bulan_ini_lyear']['Marketing & Distribution']           = (float) $tmp_data_sales_lyear['29'];
        $data1['bulan_ini_lyear']['Total']                              = (float) $tmp_data_sales_lyear['30'];
        $data1['bulan_ini']['Yoy']                                      = $this->division((float) $data1['bulan_ini']['Total'] - (float) $data1['bulan_ini_lyear']['Total'],(float) $data1['bulan_ini_lyear']['Total'])*100;

        $data1['up_bulan_ini']['Supporting Material']                      = (float) $tmp_data_sales_up['22'];
        $data1['up_bulan_ini']['Fuel']                                     = (float) $tmp_data_sales_up['23'];
        $data1['up_bulan_ini']['Electricity']                              = (float) $tmp_data_sales_up['24'];
        $data1['up_bulan_ini']['Labor']                                    = (float) $tmp_data_sales_up['25'];
        $data1['up_bulan_ini']['Maintenance']                              = (float) $tmp_data_sales_up['26'];
        $data1['up_bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_sales_up['27'];
        $data1['up_bulan_ini']['General & Administration']                 = (float) $tmp_data_sales_up['28']; 
        $data1['up_bulan_ini']['Marketing & Distribution']                 = (float) $tmp_data_sales_up['29'];
        $data1['up_bulan_ini']['Total']                                    = (float) $tmp_data_sales_up['30'];

        $data1['rkap_up_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_sales_up['22'];
        $data1['rkap_up_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_sales_up['23'];
        $data1['rkap_up_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_sales_up['24'];
        $data1['rkap_up_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_sales_up['25'];
        $data1['rkap_up_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_sales_up['26'];
        $data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_sales_up['27'];
        $data1['rkap_up_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_sales_up['28']; 
        $data1['rkap_up_bulan_ini']['Marketing & Distribution']            = (float) $tmp_rkap_data_sales_up['29'];
        $data1['rkap_up_bulan_ini']['Total']                               = (float) $tmp_rkap_data_sales_up['30'];
        $data1['up_bulan_ini']['Percent']                                  = $this->division($data1['up_bulan_ini']['Total'],$data1['rkap_up_bulan_ini']['Total'])*100;
 
        $data1['up_bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_sales_lyear_up['22'];
        $data1['up_bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_sales_lyear_up['23'];
        $data1['up_bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_sales_lyear_up['24'];
        $data1['up_bulan_ini_lyear']['Labor']                              = (float) $tmp_data_sales_lyear_up['25'];
        $data1['up_bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_sales_lyear_up['26'];
        $data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_sales_lyear_up['27'];
        $data1['up_bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_sales_lyear_up['28']; 
        $data1['up_bulan_ini_lyear']['Marketing & Distribution']           = (float) $tmp_data_sales_lyear_up['29'];
        $data1['up_bulan_ini_lyear']['Total']                              = (float) $tmp_data_sales_lyear_up['30'];
        $data1['up_bulan_ini']['Yoy']                                      = $this->division((float) $data1['up_bulan_ini']['Total'] - (float) $data1['up_bulan_ini_lyear']['Total'],(float) $data1['up_bulan_ini_lyear']['Total'])*100;
        $data['selling_marketing'] = array($data1);        
        //$data1['production_cost']       = array($this->set_data(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        // $data1['good_of_sold']       = array($this->set_data_sold(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        // $data1['general_admininstration']       = array($this->set_data_general(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        // $data1['selling_marketing']       = array($this->set_data_marketing(0, $data_prod,$rkap_data_prod,$data_prod_lastyear,$data_prod1,$rkap_data_prod1,$data_prod1_lastyear));
        echo json_encode($data);
    }
    //selling & marketing

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

/* End of file cost_structure.php */
/* Location: ./application/controllers/cost_structure.php */