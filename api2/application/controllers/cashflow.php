<?php
// error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class cashflow extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cashflow');
    }
 
    
    public function get_data_casplow()
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
        echo "/nComp : ".$comp;
        echo "Date A : ".$date_a;
        echo "/nDate : ".$date;
        echo "/nLast Year : ".$date_lyear;
        echo "/nTemp : ".$temp;
        echo "/nComp Sekarang : ".$comp_now;
        echo "/nComp Lalu : ".$comp_ly;

//Operating
        $data_operating             = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '1 AND 7', '8', 'selected');
        $target_data_operating      = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '1 AND 7', '8', 'selected');
        $data_operating_lyear       = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '1 AND 7', '8','selected');
        $data_operating_up          = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '1 AND 7', '8','upto');
        $target_data_operating_up   = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '1 AND 7', '8','upto');
        $data_operating_lyear_up    = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '1 AND 7', '8','upto');

        $tmp_data_operating = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_target_data_operating = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_lyear = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_target_data_operating_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_lyear_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);

        foreach ($data_operating as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating[$ind] = $x['JML']; 
        }
        foreach ($target_data_operating as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_operating[$ind] = $x['JML']; 
        }
        foreach ($data_operating_lyear as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_lyear[$ind] = $x['JML']; 
        }
        foreach ($data_operating_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_up[$ind] = $x['JML']; 
        }
        foreach ($target_data_operating_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_operating_up[$ind] = $x['JML']; 
        }
        foreach ($data_operating_lyear_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_lyear_up[$ind] = $x['JML']; 
        }

        // $data1 = array();
        $total_temp_data_operating = array();
        $data1['OP_ACT_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating['01'];
        $data1['OP_ACT_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating['02'];
        $data1['OP_ACT_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating['03'];
        $data1['OP_ACT_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating['06'];
        $data1['OP_ACT_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating['07'];
        $data1['OP_ACT_Bulan_Ini']['Total'] = (float) $tmp_data_operating['01'] + (float) $tmp_data_operating['02'] + (float) $tmp_data_operating['03'] + (float) $tmp_data_operating['06'] + (float) $tmp_data_operating['07'];

        $total_tmp_data_operating_up = array();
        $data1['OP_ACT_Up_to_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_up['01'];
        $data1['OP_ACT_Up_to_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_up['02'];
        $data1['OP_ACT_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_up['03'];
        $data1['OP_ACT_Up_to_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_up['06'];
        $data1['OP_ACT_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_up['07'];
        $data1['OP_ACT_Up_to_Bulan_Ini']['Total'] = (float) $tmp_data_operating_up['01'] + (float) $tmp_data_operating_up['02'] + (float) $tmp_data_operating_up['03'] + (float) $tmp_data_operating_up['06'] + (float) $tmp_data_operating_up['07'];

        $total_tmp_target_data_operating = array();
        $data1['OP_BUD_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_target_data_operating['01'];
        $data1['OP_BUD_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_target_data_operating['02'];
        $data1['OP_BUD_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_target_data_operating['03'];
        $data1['OP_BUD_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_target_data_operating['06'];
        $data1['OP_BUD_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_target_data_operating['07'];
        $data1['OP_BUD_Bulan_Ini']['Total'] = (float) $tmp_target_data_operating['01'] + (float) $tmp_target_data_operating['02'] + (float) $tmp_target_data_operating['03'] + (float) $tmp_target_data_operating['06'] + (float) $tmp_target_data_operating['07'];

        $total_tmp_target_data_operating_up = array();
        $data1['OP_BUD_Up_to_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_target_data_operating_up['01'];
        $data1['OP_BUD_Up_to_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_target_data_operating_up['02'];
        $data1['OP_BUD_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_target_data_operating_up['03'];
        $data1['OP_BUD_Up_to_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_target_data_operating_up['06'];
        $data1['OP_BUD_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_target_data_operating_up['07'];
        $data1['OP_BUD_Up_to_Bulan_Ini']['Total'] = (float) $tmp_target_data_operating_up['01'] + (float) $tmp_target_data_operating_up['02'] + (float) $tmp_target_data_operating_up['03'] + (float) $tmp_target_data_operating_up['06'] + (float) $tmp_target_data_operating_up['07'];

        $total_tmp_data_operating_lyear = array();
        $data1['OP_ACT_Bulan_Ini_1Year']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_lyear['01'];
        $data1['OP_ACT_Bulan_Ini_1Year']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_lyear['02'];
        $data1['OP_ACT_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_lyear['03'];
        $data1['OP_ACT_Bulan_Ini_1Year']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_lyear['06'];
        $data1['OP_ACT_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_lyear['07'];
        $data1['OP_ACT_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_operating_lyear['01'] + (float) $tmp_data_operating_lyear['02'] + (float) $tmp_data_operating_lyear['03'] + (float) $tmp_data_operating_lyear['06'] + (float) $tmp_data_operating_lyear['07'];

        $total_tmp_data_operating_lyear_up = array();
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_lyear_up['01'];
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_lyear_up['02'];
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_lyear_up['03'];
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_lyear_up['06'];
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_lyear_up['07'];
        $data1['OP_ACT_Up_to_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_operating_lyear_up['01'] + (float) $tmp_data_operating_lyear_up['02'] + (float) $tmp_data_operating_lyear_up['03'] + (float) $tmp_data_operating_lyear_up['06'] + (float) $tmp_data_operating_lyear_up['07'];

//Investing
        $data_investing             = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '11 AND 14', '15', 'selected');
        $target_data_investing      = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '11 AND 14', '15', 'selected');
        $data_investing_lyear       = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '11 AND 14', '15','selected');
        $data_investing_up          = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '11 AND 14', '15','upto');
        $target_data_investing_up   = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '11 AND 14', '15','upto');
        $data_investing_lyear_up    = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '11 AND 14', '15','upto');

        $tmp_data_investing = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_target_data_investing = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_lyear = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_target_data_investing_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_lyear_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
     
        foreach ($data_investing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing[$ind] = $x['JML']; 
        }
        foreach ($target_data_investing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_investing[$ind] = $x['JML']; 
        }
        foreach ($data_investing_lyear as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_lyear[$ind] = $x['JML']; 
        }
        foreach ($data_investing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_up[$ind] = $x['JML']; 
        }
        foreach ($target_data_investing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_investing_up[$ind] = $x['JML']; 
        }
        foreach ($data_investing_lyear_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_lyear_up[$ind] = $x['JML']; 
        }

        // $data1 = array();
        $total_temp_data_investing = array();
        $data1['Inv_ACT_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_data_investing['11'];
        $data1['Inv_ACT_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_data_investing['00'];
        $data1['Inv_ACT_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_data_investing['00'];
        $data1['Inv_ACT_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing['00'];
        $data1['Inv_ACT_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing['00'];
        $data1['Inv_ACT_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing['00'];
        $data1['Inv_ACT_Bulan_Ini']['Total'] = (float) $tmp_data_investing['11'] + (float) $tmp_data_investing['00'];
        
        $total_temp_data_investing_up = array();
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_data_investing_up['11'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_data_investing_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_data_investing_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini']['Total'] = (float) $tmp_data_investing_up['11'] + (float) $tmp_data_investing_up['00'];
        
        $total_temp_target_data_investing = array();
        $data1['Inv_BUD_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_target_data_investing['11'];
        $data1['Inv_BUD_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_target_data_investing['00'];
        $data1['Inv_BUD_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_target_data_investing['00'];
        $data1['Inv_BUD_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_target_data_investing['00'];
        $data1['Inv_BUD_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_target_data_investing['00'];
        $data1['Inv_BUD_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_target_data_investing['00'];
        $data1['Inv_BUD_Bulan_Ini']['Total'] = (float) $tmp_target_data_investing['11'] + (float) $tmp_target_data_investing['00'];
        
        $total_temp_target_data_investing_up = array();
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_target_data_investing_up['11'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_target_data_investing_up['00'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_target_data_investing_up['00'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_target_data_investing_up['00'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_target_data_investing_up['00'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_target_data_investing_up['00'];
        $data1['Inv_BUD_Up_to_Bulan_Ini']['Total'] = (float) $tmp_target_data_investing_up['11'] + (float) $tmp_target_data_investing_up['00'];
        
        $total_temp_data_investing_lyear = array();
        $data1['Inv_ACT_Bulan_Ini_1Year']['Pembelian aset tetap']                            = (float) $tmp_data_investing_lyear['11'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Penjualan aset tetap']                            = (float) $tmp_data_investing_lyear['00'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Investasi pada anak']                             = (float) $tmp_data_investing_lyear['00'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_lyear['00'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_lyear['00'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_lyear['00'];
        $data1['Inv_ACT_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_investing_lyear['11'] + (float) $tmp_data_investing_lyear['00'];
        
        $total_temp_data_investing_lyear_up = array();
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Pembelian aset tetap']                            = (float) $tmp_data_investing_lyear_up['11'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Penjualan aset tetap']                            = (float) $tmp_data_investing_lyear_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Investasi pada anak']                             = (float) $tmp_data_investing_lyear_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_lyear_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_lyear_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_lyear_up['00'];
        $data1['Inv_ACT_Up_to_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_investing_lyear_up['11'] + (float) $tmp_data_investing_lyear_up['00'];

        
        
// //Financing
//         $data_financing            = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '16 AND 20', '21', 'selected');
//         $target_data_financing     = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '16 AND 20', '21', 'selected');
//         $data_financing_lyear      = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '16 AND 20', '12','selected');
//         $data_financing_up         = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '16 AND 20', '21','upto');
//         $target_data_financing_up  = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '16 AND 20', '21','upto');
//         $data_financing_lyear_up   = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '6 AND 20', '21','upto');

//         echo $data_financing;
//         echo $target_data_financing;
//         echo $data_financing_lyear;
//         echo $data_financing_up;
//         echo $target_data_financing_up;
//         echo $data_financing_lyear_up;

//         $tmp_data_financing = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);
//         $tmp_target_data_financing = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);
//         $tmp_data_financing_lyear = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);
//         $tmp_data_financing_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);
//         $tmp_target_data_financing_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);
//         $tmp_data_financing_lyear_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0);

//         foreach ($data_financing as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_data_financing[$ind] = $x['JML']; 
//         }
//         foreach ($target_data_financing as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_target_data_financing[$ind] = $x['JML']; 
//         }
//         foreach ($data_financing_lyear as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_data_financing_lyear[$ind] = $x['JML']; 
//         }
//         foreach ($data_financing_up as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_data_financing_up[$ind] = $x['JML']; 
//         }
//         foreach ($target_data_financing_up as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_target_data_financing_up[$ind] = $x['JML']; 
//         }
//         foreach ($data_financing_lyear_up as $x){
//          $nol = '0'.$x['NOMOR'];
//          $ind = substr($nol,-2);   
//          $tmp_data_financing_lyear_up[$ind] = $x['JML'];
//         }

//         // $total_temp_data_financing = array();
//         $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_data_financing['16'];
//         $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_data_financing['18'];
//         $data1['Fnc_ACT_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing['17'];
//         $data1['Fnc_ACT_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_data_financing['19'];
//         $data1['Fnc_ACT_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing['20'];
//         $data1['Fnc_ACT_Bulan_Ini']['Total'] = (float) $tmp_data_financing['16'] + (float) $tmp_data_financing['17'] + (float) $tmp_data_financing['18'] + (float) $tmp_data_financing['19'] + (float) $tmp_data_financing['20'] + (float) $tmp_data_financing['20'];
        
//         // $total_temp_data_financing_up = array();
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_up['16'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_data_financing_up['18'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_up['17'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_data_financing_up['19'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini']['Total'] = (float) $tmp_data_financing_up['16'] + (float) $tmp_data_financing_up['17'] + (float) $tmp_data_financing_up['18'] + (float) $tmp_data_financing_up['19'] + (float) $tmp_data_financing_up['20'] + (float) $tmp_data_financing_up['20'];
        
//         // $total_temp_target_data_financing = array();
//         $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_target_data_financing['16'];
//         $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_target_data_financing['18'];
//         $data1['Fnc_BUD_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_target_data_financing['17'];
//         $data1['Fnc_BUD_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_target_data_financing['19'];
//         $data1['Fnc_BUD_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_target_data_financing['20'];
//         $data1['Fnc_BUD_Bulan_Ini']['Total'] = (float) $tmp_target_data_financing['16'] + (float) $tmp_target_data_financing['17'] + (float) $tmp_target_data_financing['18'] + (float) $tmp_target_data_financing['19'] + (float) $tmp_target_data_financing['20'] + (float) $tmp_target_data_financing['20'];
        
//         // $total_temp_target_data_financing_up = array();
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_target_data_financing_up['16'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_target_data_financing_up['18'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_target_data_financing_up['17'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_target_data_financing_up['19'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_target_data_financing_up['20'];
//         $data1['Fnc_BUD_Up_to_Bulan_Ini']['Total'] = (float) $tmp_target_data_financing_up['16'] + (float) $tmp_target_data_financing_up['17'] + (float) $tmp_target_data_financing_up['18'] + (float) $tmp_target_data_financing_up['19'] + (float) $tmp_target_data_financing_up['20'] + (float) $tmp_target_data_financing_up['20'];
        
//         // $total_temp_data_financing_lyear = array();
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_lyear['16'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Penarikan hutang bank']                             = (float) $tmp_data_financing_lyear['18'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran obligasi']                               = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_lyear['17'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Pembayaran dividen']                                = (float) $tmp_data_financing_lyear['19'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Penerimaan dividen']                                = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_lyear['20'];
//         $data1['Fnc_ACT_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_financing_lyear['16'] + (float) $tmp_data_financing_lyear['17'] + (float) $tmp_data_financing_lyear['18'] + (float) $tmp_data_financing_lyear['19'] + (float) $tmp_data_financing_lyear['20'] + (float) $tmp_data_financing_lyear['20'];
        
//         // $total_temp_data_financing_lyear_up = array();
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_lyear_up['16'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Penarikan hutang bank']                             = (float) $tmp_data_financing_lyear_up['18'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran obligasi']                               = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_lyear_up['17'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Pembayaran dividen']                                = (float) $tmp_data_financing_lyear_up['19'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Penerimaan dividen']                                = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_lyear_up['20'];
//         $data1['Fnc_ACT_Up_to_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_financing_lyear_up['16'] + (float) $tmp_data_financing_lyear_up['17'] + (float) $tmp_data_financing_lyear_up['18'] + (float) $tmp_data_financing_lyear_up['19'] + (float) $tmp_data_financing_lyear_up['20'] + (float) $tmp_data_financing_lyear_up['20'];

        echo json_encode($data1);
 
    }
    
    public function get_data_cashflow(){
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp     
              = str_replace(",","','",$comp);
       
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
            echo "string";
        }

        $date_a = substr($date, 0, 4).'.01';
        echo "/nComp : ".$comp;
        echo "Date A : ".$date_a;
        echo "/nDate : ".$date;
        echo "/nLast Year : ".$date_lyear;
        echo "/nTemp : ".$temp;
        echo "/nComp Sekarang : ".$comp_now;
        echo "/nComp Lalu : ".$comp_ly;



//Operating
        $data_operating             = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '1 AND 7', '8', 'selected');
        $target_data_operating      = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '1 AND 7', '8', 'selected');
        $data_operating_lyear       = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '1 AND 7', '8','selected');
        $data_operating_up          = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '1 AND 7', '8','upto');
        $target_data_operating_up   = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '1 AND 7', '8','upto');
        $data_operating_lyear_up    = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '1 AND 7', '8','upto');

        $tmp_data_operating = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_target_data_operating = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_lyear = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_target_data_operating_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);
        $tmp_data_operating_lyear_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0);

        foreach ($data_operating as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating[$ind] = $x['JML']; 
        }
        foreach ($target_data_operating as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_operating[$ind] = $x['JML']; 
        }
        foreach ($data_operating_lyear as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_lyear[$ind] = $x['JML']; 
        }
        foreach ($data_operating_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_up[$ind] = $x['JML']; 
        }
        foreach ($target_data_operating_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_operating_up[$ind] = $x['JML']; 
        }
        foreach ($data_operating_lyear_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_operating_lyear_up[$ind] = $x['JML']; 
        }

        $data1 = array();
        $total_temp_data_operating = array();
        $data1['ACT_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating['01'];
        $data1['ACT_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating['02'];
        $data1['ACT_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating['03'];
        $data1['ACT_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating['06'];
        $data1['ACT_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating['07'];
        $data1['ACT_Bulan_Ini']['Total'] = (float) $tmp_data_operating['01'] + (float) $tmp_data_operating['02'] + (float) $tmp_data_operating['03'] + (float) $tmp_data_operating['06'] + (float) $tmp_data_operating['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_data_operating,$tmp_data_operating[$no]);
        // }

        $total_tmp_data_operating_up = array();
        $data1['ACT_Up_to_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_up['01'];
        $data1['ACT_Up_to_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_up['02'];
        $data1['ACT_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_up['03'];
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_up['06'];
        $data1['ACT_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_up['07'];
        $data1['ACT_Up_to_Bulan_Ini']['Total'] = (float) $tmp_data_operating_up['01'] + (float) $tmp_data_operating_up['02'] + (float) $tmp_data_operating_up['03'] + (float) $tmp_data_operating_up['06'] + (float) $tmp_data_operating_up['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_data_operating_up,$tmp_data_operating_up[$no]);
        // }

        $total_tmp_target_data_operating = array();
        $data1['BUD_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_target_data_operating['01'];
        $data1['BUD_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_target_data_operating['02'];
        $data1['BUD_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_target_data_operating['03'];
        $data1['BUD_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_target_data_operating['06'];
        $data1['BUD_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_target_data_operating['07'];
        $data1['BUD_Bulan_Ini']['Total'] = (float) $tmp_target_data_operating['01'] + (float) $tmp_target_data_operating['02'] + (float) $tmp_target_data_operating['03'] + (float) $tmp_target_data_operating['06'] + (float) $tmp_target_data_operating['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_target_data_operating,$tmp_target_data_operating[$no]);
        // }

        $total_tmp_target_data_operating_up = array();
        $data1['BUD_Up_to_Bulan_Ini']['Penerimaan kas dari pelanggan']               = (float) $tmp_target_data_operating_up['01'];
        $data1['BUD_Up_to_Bulan_Ini']['Pengeluaran kas kepada pemasok']              = (float) $tmp_target_data_operating_up['02'];
        $data1['BUD_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_target_data_operating_up['03'];
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran pajak penghasilan']                = (float) $tmp_target_data_operating_up['06'];
        $data1['BUD_Up_to_Bulan_Ini']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_target_data_operating_up['07'];
        $data1['BUD_Up_to_Bulan_Ini']['Total'] = (float) $tmp_target_data_operating_up['01'] + (float) $tmp_target_data_operating_up['02'] + (float) $tmp_target_data_operating_up['03'] + (float) $tmp_target_data_operating_up['06'] + (float) $tmp_target_data_operating_up['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_target_data_operating_up,$tmp_target_data_operating_up[$no]);
        // }

        $total_tmp_data_operating_lyear = array();
        $data1['ACT_Bulan_Ini_1Year']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_lyear['01'];
        $data1['ACT_Bulan_Ini_1Year']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_lyear['02'];
        $data1['ACT_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_lyear['03'];
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_lyear['06'];
        $data1['ACT_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_lyear['07'];
        $data1['ACT_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_operating_lyear['01'] + (float) $tmp_data_operating_lyear['02'] + (float) $tmp_data_operating_lyear['03'] + (float) $tmp_data_operating_lyear['06'] + (float) $tmp_data_operating_lyear['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_data_operating_lyear,$tmp_data_operating_lyear[$no]);
        // }

        $total_tmp_data_operating_lyear_up = array();
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Penerimaan kas dari pelanggan']               = (float) $tmp_data_operating_lyear_up['01'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pengeluaran kas kepada pemasok']              = (float) $tmp_data_operating_lyear_up['02'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi']  = (float) $tmp_data_operating_lyear_up['03'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran pajak penghasilan']                = (float) $tmp_data_operating_lyear_up['06'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kas yang dihasilkan dari aktivitas operasi - bersih']  = (float) $tmp_data_operating_lyear_up['07'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Total'] = (float) $tmp_data_operating_lyear_up['01'] + (float) $tmp_data_operating_lyear_up['02'] + (float) $tmp_data_operating_lyear_up['03'] + (float) $tmp_data_operating_lyear_up['06'] + (float) $tmp_data_operating_lyear_up['07'];
        // for ($x=1;$x<=5;$x++){
        //  $no = '0'.$x;
        //  array_push($total_tmp_data_operating_lyear_up,$tmp_data_operating_lyear_up[$no]);
        // }

        $data['Operating'] = array($data1);

//Investing
        $data_investing             = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '11 AND 14', '15', 'selected');
        $target_data_investing      = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '11 AND 14', '15', 'selected');
        $data_investing_lyear       = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '11 AND 14', '15','selected');
        $data_investing_up          = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '11 AND 14', '15','upto');
        $target_data_investing_up   = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '11 AND 14', '15','upto');
        $data_investing_lyear_up    = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '11 AND 14', '15','upto');

        $tmp_data_investing = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_target_data_investing = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_lyear = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_target_data_investing_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);
        $tmp_data_investing_lyear_up = array('00'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0);



       
        foreach ($data_investing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing[$ind] = $x['JML']; 
        }
        foreach ($target_data_investing as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_investing[$ind] = $x['JML']; 
        }
        foreach ($data_investing_lyear as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_lyear[$ind] = $x['JML']; 
        }
        foreach ($data_investing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_up[$ind] = $x['JML']; 
        }
        foreach ($target_data_investing_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_target_data_investing_up[$ind] = $x['JML']; 
        }
        foreach ($data_investing_lyear_up as $x){
         $nol = '0'.$x['NOMOR'];
         $ind = substr($nol,-2);   
         $tmp_data_investing_lyear_up[$ind] = $x['JML']; 
        }


        $data1 = array();
        $total_temp_data_investing = array();
        $data1['ACT_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_data_investing['11'];
        $data1['ACT_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_data_investing['00'];
        $data1['ACT_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_data_investing['00'];
        $data1['ACT_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing['00'];
        $data1['ACT_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing['00'];
        $data1['ACT_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_investing,$temp_data_investing[$no]);
        // }

        $total_temp_data_investing_up = array();
        $data1['ACT_Up_to_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_data_investing_up['11'];
        $data1['ACT_Up_to_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_data_investing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_data_investing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_up['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_investing_up,$temp_data_investing_up[$no]);
        // }

        $total_temp_target_data_investing = array();
        $data1['BUD_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_target_data_investing['11'];
        $data1['BUD_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_target_data_investing['00'];
        $data1['BUD_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_target_data_investing['00'];
        $data1['BUD_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_target_data_investing['00'];
        $data1['BUD_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_target_data_investing['00'];
        $data1['BUD_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_target_data_investing['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_target_data_investing,$temp_target_data_investing[$no]);
        // }

        $total_temp_target_data_investing_up = array();
        $data1['BUD_Up_to_Bulan_Ini']['Pembelian aset tetap']                            = (float) $tmp_target_data_investing_up['11'];
        $data1['BUD_Up_to_Bulan_Ini']['Penjualan aset tetap']                            = (float) $tmp_target_data_investing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Investasi pada anak']                             = (float) $tmp_target_data_investing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_target_data_investing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Penurunan beban ditangguhkan']                    = (float) $tmp_target_data_investing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_target_data_investing_up['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_target_data_investing_up,$temp_target_data_investing_up[$no]);
        // }

        $total_temp_data_investing_lyear = array();
        $data1['ACT_Bulan_Ini_1Year']['Pembelian aset tetap']                            = (float) $tmp_data_investing_lyear['11'];
        $data1['ACT_Bulan_Ini_1Year']['Penjualan aset tetap']                            = (float) $tmp_data_investing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Investasi pada anak']                             = (float) $tmp_data_investing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_lyear['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_investing_lyear,$temp_data_investing_lyear[$no]);
        // }

        $total_temp_data_investing_lyear_up = array();
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembelian aset tetap']                            = (float) $tmp_data_investing_lyear_up['11'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Penjualan aset tetap']                            = (float) $tmp_data_investing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Investasi pada anak']                             = (float) $tmp_data_investing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Investasi pada surat berharga jangka pendek']     = (float) $tmp_data_investing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Penurunan beban ditangguhkan']                    = (float) $tmp_data_investing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']  = (float) $tmp_data_investing_lyear_up['00'];
        // for ($x=6;$x<=11;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_investing_lyear_up,$temp_data_investing_lyear_up[$no]);
        // }

        $data['Investing'] = array($data1);

//Financing
        $data_financing            = $this->m_cashflow->get_tabeldata($comp_now, $date, 'ACT', '16 AND 120', '121', 'selected');
        $target_data_financing     = $this->m_cashflow->get_tabeldata($comp_now, $date, 'BUD', '16 AND 120', '121', 'selected');
        $data_financing_lyear      = $this->m_cashflow->get_tabeldata($comp_ly, $date_lyear, 'ACT', '16 AND 120', '121','selected');
        $data_financing_up         = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'ACT', '16 AND 120', '121','upto');
        $target_data_financing_up  = $this->m_cashflow->get_tabeldata($comp_now, $temp, 'BUD', '16 AND 120', '121','upto');
        $data_financing_lyear_up   = $this->m_cashflow->get_tabeldata($comp_ly, $temp_lyear, 'ACT', '16 AND 120', '121','upto');

        $tmp_data_financing = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);
        $tmp_target_data_financing = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);
        $tmp_data_financing_lyear = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);
        $tmp_data_financing_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);
        $tmp_target_data_financing_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);
        $tmp_data_financing_lyear_up = array('16'=>0,'17'=>0,'18'=>0,'19'=>0,'102'=>0);

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

        $data1 = array();
        $total_temp_data_financing = array();
        $data1['ACT_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_data_financing['16'];
        $data1['ACT_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing['00'];
        $data1['ACT_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_data_financing['18'];
        $data1['ACT_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_data_financing['00'];
        $data1['ACT_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing['17'];
        $data1['ACT_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_data_financing['19'];
        $data1['ACT_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_data_financing['102'];
        $data1['ACT_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing['00'];
        $data1['ACT_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_data_financing['00'];
        $data1['ACT_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing['00'];
        // // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_financing,$temp_data_financing[$no]);
        // }

        $total_temp_data_financing_up = array();
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_up['16'];
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_data_financing_up['18'];
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_data_financing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_up['17'];
        $data1['ACT_Up_to_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_data_financing_up['19'];
        $data1['ACT_Up_to_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_data_financing_up['102'];
        $data1['ACT_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_up['00'];
        $data1['ACT_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_up['00'];
        // // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_financing_up,$temp_data_financing_up[$no]);
        // }

        $total_temp_target_data_financing = array();
        $data1['BUD_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_target_data_financing['16'];
        $data1['BUD_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_target_data_financing['00'];
        $data1['BUD_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_target_data_financing['18'];
        $data1['BUD_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_target_data_financing['00'];
        $data1['BUD_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_target_data_financing['17'];
        $data1['BUD_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_target_data_financing['19'];
        $data1['BUD_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_target_data_financing['102'];
        $data1['BUD_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_target_data_financing['00'];
        $data1['BUD_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_target_data_financing['00'];
        $data1['BUD_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_target_data_financing['00'];
        // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_target_data_financing,$temp_target_data_financing[$no]);
        // }

        $total_temp_target_data_financing_up = array();
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran hutang bank']                            = (float) $tmp_target_data_financing_up['16'];
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_target_data_financing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Penarikan hutang bank']                             = (float) $tmp_target_data_financing_up['18'];
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran obligasi']                               = (float) $tmp_target_data_financing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_target_data_financing_up['17'];
        $data1['BUD_Up_to_Bulan_Ini']['Pembayaran dividen']                                = (float) $tmp_target_data_financing_up['19'];
        $data1['BUD_Up_to_Bulan_Ini']['Penerimaan dividen']                                = (float) $tmp_target_data_financing_up['102'];
        $data1['BUD_Up_to_Bulan_Ini']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_target_data_financing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Kenaikan kas bersih']                               = (float) $tmp_target_data_financing_up['00'];
        $data1['BUD_Up_to_Bulan_Ini']['Kas dan setara kas awal periode']                   = (float) $tmp_target_data_financing_up['00'];
        // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_target_data_financing_up,$temp_target_data_financing_up[$no]);
        // }

        $total_temp_data_financing_lyear = array();
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_lyear['16'];
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Penarikan hutang bank']                             = (float) $tmp_data_financing_lyear['18'];
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran obligasi']                               = (float) $tmp_data_financing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_lyear['17'];
        $data1['ACT_Bulan_Ini_1Year']['Pembayaran dividen']                                = (float) $tmp_data_financing_lyear['19'];
        $data1['ACT_Bulan_Ini_1Year']['Penerimaan dividen']                                = (float) $tmp_data_financing_lyear['102'];
        $data1['ACT_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_lyear['00'];
        $data1['ACT_Bulan_Ini_1Year']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_lyear['00'];
        // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_financing_lyear,$temp_data_financing_lyear[$no]);
        // }

        $total_temp_data_financing_lyear_up = array();
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang bank']                            = (float) $tmp_data_financing_lyear_up['16'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang pemerintah RI']                   = (float) $tmp_data_financing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Penarikan hutang bank']                             = (float) $tmp_data_financing_lyear_up['18'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran obligasi']                               = (float) $tmp_data_financing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran hutang sewa pembiayaan']                 = (float) $tmp_data_financing_lyear_up['17'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Pembayaran dividen']                                = (float) $tmp_data_financing_lyear_up['19'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Penerimaan dividen']                                = (float) $tmp_data_financing_lyear_up['102'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kas bersih digunakan untuk aktivitas investasi']    = (float) $tmp_data_financing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kenaikan kas bersih']                               = (float) $tmp_data_financing_lyear_up['00'];
        $data1['ACT_Up_to_Bulan_Ini_1Year']['Kas dan setara kas awal periode']                   = (float) $tmp_data_financing_lyear_up['00'];
        // for ($x=12;$x<=21;$x++){
        //  $no = '0'.$x;
        //  array_push($total_temp_data_financing_lyear_up,$temp_data_financing_lyear_up[$no]);
        // }
               
        $data['Financing'] = array($data1);

//       // $data = array($data1);
//       // $lihatdata = $this->m_cashflow->get_tabeldata('smi','selected');
//       //echo "string";
        echo json_encode($data);
        }
        // echo json_encode($data);
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
