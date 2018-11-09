<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class cashflow_fnc extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cashflow');
    }
 
    
    public function get_data_casplow_fnc()
    {
        // echo "string";
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
        if ($comp!='smi') {
            # code...
            $comp_now = $this->paramCompany($comp, $date);
            $comp_ly = $this->paramCompany($comp, $date_lyear);
            // echo "string";
        }

        $date_a = substr($date, 0, 4).'.01';
        
//Financing
        $data_financing             = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '1 AND 10', '11', 'selected');
        $target_data_financing      = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '1 AND 10', '11', 'selected');
        $data_financing_lyear       = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '1 AND 10', '11','selected');
        $data_financing_up          = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '1 AND 10', '11','upto');
        $target_data_financing_up   = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '1 AND 10', '11','upto');
        $data_financing_lyear_up    = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '1 AND 10', '11','upto');

        $tmp_data_financing = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);
        $tmp_target_data_financing = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);
        $tmp_data_financing_lyear = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);
        $tmp_data_financing_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);
        $tmp_target_data_financing_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);
        $tmp_data_financing_lyear_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0);

        foreach ($data_financing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_financing[$ind] = $x['JML']; 
        }
        foreach ($target_data_financing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_financing[$ind] = $x['JML']; 
        }
        foreach ($data_financing_lyear as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_financing_lyear[$ind] = $x['JML']; 
        }
        foreach ($data_financing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_financing_up[$ind] = $x['JML']; 
        }
        foreach ($target_data_financing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_financing_up[$ind] = $x['JML']; 
        }
        foreach ($data_financing_lyear_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_financing_lyear_up[$ind] = $x['JML']; 
        }

        // $data1 = array();
        $total_temp_data_financing = array();
        $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang bank']               				= (float) $tmp_data_financing['01'];
        $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang pemerintah RI']              		= (float) $tmp_data_financing['02'];
        $data1['Fnc_ACT_Bulan_Ini']['Penarikan hutang bank']  							= (float) $tmp_data_financing['03'];
        $data1['Fnc_ACT_Bulan_Ini']['Pembayaran obligasi']                				= (float) $tmp_data_financing['04'];
        $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']  				= (float) $tmp_data_financing['05'];
        $data1['Fnc_ACT_Bulan_Ini']['Pembayaran dividen']               					= (float) $tmp_data_financing['06'];
        $data1['Fnc_ACT_Bulan_Ini']['Penerimaan dividen']              					= (float) $tmp_data_financing['07'];
        $data1['Fnc_ACT_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  	= (float) $tmp_data_financing['08'];
        $data1['Fnc_ACT_Bulan_Ini']['Kenaikan kas bersih']                				= (float) $tmp_data_financing['09'];
        $data1['Fnc_ACT_Bulan_Ini']['Kas dan setara kas awal periode']  					= (float) $tmp_data_financing['10'];
        $data1['Fnc_ACT_Bulan_Ini']['Total'] = (float) $tmp_data_financing['01'] + (float) $tmp_data_financing['02'] + (float) $tmp_data_financing['03'] + (float) $tmp_data_financing['04'] + (float) $tmp_data_financing['05'] + (float) $tmp_data_financing['06'] + (float) $tmp_data_financing['07'] + (float) $tmp_data_financing['08'] + (float) $tmp_data_financing['09'] + (float) $tmp_data_financing['10'];

        $total_tmp_data_financing_up = array();
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang bank']                      = (float) $tmp_data_financing_up['01'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']             = (float) $tmp_data_financing_up['02'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Penarikan hutang bank']                       = (float) $tmp_data_financing_up['03'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran obligasi']                         = (float) $tmp_data_financing_up['04'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']           = (float) $tmp_data_financing_up['05'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran dividen']                          = (float) $tmp_data_financing_up['06'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Penerimaan dividen']                          = (float) $tmp_data_financing_up['07'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_financing_up['08'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kenaikan kas bersih']                         = (float) $tmp_data_financing_up['09'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']             = (float) $tmp_data_financing_up['10'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini']['Total'] = (float) $tmp_data_financing_up['01'] + (float) $tmp_data_financing_up['02'] + (float) $tmp_data_financing_up['03'] + (float) $tmp_data_financing_up['04'] + (float) $tmp_data_financing_up['05'] + (float) $tmp_data_financing_up['06'] + (float) $tmp_data_financing_up['07'] + (float) $tmp_data_financing_up['08'] + (float) $tmp_data_financing_up['09'] + (float) $tmp_data_financing_up['10'];

        $total_tmp_target_data_financing = array();
        $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_target_data_financing['01'];
        $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_target_data_financing['02'];
        $data1['Fnc_BUD_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_target_data_financing['03'];
        $data1['Fnc_BUD_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_target_data_financing['04'];
        $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_target_data_financing['05'];
        $data1['Fnc_BUD_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_target_data_financing['06'];
        $data1['Fnc_BUD_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_target_data_financing['07'];
        $data1['Fnc_BUD_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_target_data_financing['08'];
        $data1['Fnc_BUD_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_target_data_financing['09'];
        $data1['Fnc_BUD_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_target_data_financing['10'];
        $data1['Fnc_BUD_Bulan_Ini']['Total'] = (float) $tmp_target_data_financing['01'] + (float) $tmp_target_data_financing['02'] + (float) $tmp_target_data_financing['03'] + (float) $tmp_target_data_financing['04'] + (float) $tmp_target_data_financing['05'] + (float) $tmp_target_data_financing['06'] + (float) $tmp_target_data_financing['07'] + (float) $tmp_target_data_financing['08'] + (float) $tmp_target_data_financing['09'] + (float) $tmp_target_data_financing['10'];

        $total_tmp_target_data_financing_up = array();
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang bank']                      = (float) $tmp_target_data_financing_up['01'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']             = (float) $tmp_target_data_financing_up['02'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Penarikan hutang bank']                       = (float) $tmp_target_data_financing_up['03'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran obligasi']                         = (float) $tmp_target_data_financing_up['04'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']           = (float) $tmp_target_data_financing_up['05'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran dividen']                          = (float) $tmp_target_data_financing_up['06'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Penerimaan dividen']                          = (float) $tmp_target_data_financing_up['07'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_target_data_financing_up['08'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kenaikan kas bersih']                         = (float) $tmp_target_data_financing_up['09'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']             = (float) $tmp_target_data_financing_up['10'];
        $data1['Fnc_BUD_Up_to_Bulan_Ini']['Total'] = (float) $tmp_target_data_financing_up['01'] + (float) $tmp_target_data_financing_up['02'] + (float) $tmp_target_data_financing_up['03'] + (float) $tmp_target_data_financing_up['04'] + (float) $tmp_target_data_financing_up['05'] + (float) $tmp_target_data_financing_up['06'] + (float) $tmp_target_data_financing_up['07'] + (float) $tmp_target_data_financing_up['08'] + (float) $tmp_target_data_financing_up['09'] + (float) $tmp_target_data_financing_up['10'];

        $total_tmp_data_financing_lyear = array();
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang bank']                      = (float) $tmp_data_financing_lyear['01'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']             = (float) $tmp_data_financing_lyear['02'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Penarikan hutang bank']                       = (float) $tmp_data_financing_lyear['03'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran obligasi']                         = (float) $tmp_data_financing_lyear['04'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']           = (float) $tmp_data_financing_lyear['05'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran dividen']                          = (float) $tmp_data_financing_lyear['06'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Penerimaan dividen']                          = (float) $tmp_data_financing_lyear['07'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_financing_lyear['08'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Kenaikan kas bersih']                         = (float) $tmp_data_financing_lyear['09'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Kas dan setara kas awal periode']             = (float) $tmp_data_financing_lyear['10'];
        $data1['Fnc_ACT_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_financing_lyear['01'] + (float) $tmp_data_financing_lyear['02'] + (float) $tmp_data_financing_lyear['03'] + (float) $tmp_data_financing_lyear['04'] + (float) $tmp_data_financing_lyear['05'] + (float) $tmp_data_financing_lyear['06'] + (float) $tmp_data_financing_lyear['07'] + (float) $tmp_data_financing_lyear['08'] + (float) $tmp_data_financing_lyear['09'] + (float) $tmp_data_financing_lyear['10'];

        $total_tmp_data_financing_lyear_up = array();
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang bank']                = (float) $tmp_data_financing_lyear_up['01'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']       = (float) $tmp_data_financing_lyear_up['02'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Penarikan hutang bank']                 = (float) $tmp_data_financing_lyear_up['03'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran obligasi']                   = (float) $tmp_data_financing_lyear_up['04'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']     = (float) $tmp_data_financing_lyear_up['05'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran dividen']                    = (float) $tmp_data_financing_lyear_up['06'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Penerimaan dividen']                    = (float) $tmp_data_financing_lyear_up['07'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_financing_lyear_up['08'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kenaikan kas bersih']                   = (float) $tmp_data_financing_lyear_up['09'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kas dan setara kas awal periode']       = (float) $tmp_data_financing_lyear_up['10'];
        $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_financing_lyear_up['01'] + (float) $tmp_data_financing_lyear_up['02'] + (float) $tmp_data_financing_lyear_up['03'] + (float) $tmp_data_financing_lyear_up['04'] + (float) $tmp_data_financing_lyear_up['05'] + (float) $tmp_data_financing_lyear_up['06'] + (float) $tmp_data_financing_lyear_up['07'] + (float) $tmp_data_financing_lyear_up['08'] + (float) $tmp_data_financing_lyear_up['09'] + (float) $tmp_data_financing_lyear_up['10'];

        echo json_encode($data1);
 
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
