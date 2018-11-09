<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class balance_report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_balancemv','',true);
        $this->load->model('m_balance','',true);
        $this->load->model('m_cost_structure');
    }

    function index(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $company = $com;
      
    
      $last_year = $year-1;
      $year_of_last_month = $year;
      $last_month = substr(('0'.($month-1)), -2);

      if ($last_month=='00') {
          $last_month = '12';
           $year_of_last_month =  $year_of_last_month -1;
      }

      $past_date = "$last_year.12";
      $now_date = "$year.$month";
      $last_date = "$year_of_last_month.$last_month";

      $category = 'ACT';

      $asset = array();
      $liability = array();
      $ekuitas = array();

      $year = (int) $year;
      $last_year = (int) $last_year;
      $year_of_last_month = (int) $year_of_last_month;

     
         
      $company_now = $this->paramCompany($com, $year);
      $company_last = $this->paramCompany($com, $year_of_last_month);
      $company_past = $this->paramCompany($com, $last_year);

      // echo $company_now;
      // echo $company_last;
      // echo $company_past;
       
      $data_now = $this->m_balancemv->get_balance($company_now, $category, $now_date);

      $data_last = $this->m_balancemv->get_balance($company_last, $category, $last_date);
      $data_past = $this->m_balancemv->get_balance($company_past, $category, $past_date);

      $result_now = array();
      foreach ($data_now as $tag) {
   
          $result_now[$tag['DIS']] = $tag['JUMLAH'];
     
      }
      $result_last = array();
      foreach ($data_last as $tag) {
   
          $result_last[$tag['DIS']] = $tag['JUMLAH'];
     
      }
      $result_past = array();
      foreach ($data_past as $tag) {
   
          $result_past[$tag['DIS']] = $tag['JUMLAH'];
     
      }
      


      //KAS DAN SETARA KAS===============================================================================
      $kas_now       = $this->define('KAS DAN SETARA KAS', $result_now);
      $kas_last       = $this->define('KAS DAN SETARA KAS', $result_last);
      $kas_past       = $this->define('KAS DAN SETARA KAS', $result_past);
      
      //BANK YANG DIBATASI PENGGUNANYA==========================================================================
      $bank_now      = $this->define('BANK YANG DIBATASI PENGGUNANYA', $result_now);
      $bank_last      = $this->define('BANK YANG DIBATASI PENGGUNANYA', $result_last);
      $bank_past      = $this->define('BANK YANG DIBATASI PENGGUNANYA', $result_past);
      
      //INVESTASI JANGKA PENDEK===================================================================================
      $invest_now    = $this->define( 'INVESTASI JANGKA PENDEK', $result_now);
      $invest_last    = $this->define( 'INVESTASI JANGKA PENDEK', $result_last);
      $invest_past    = $this->define( 'INVESTASI JANGKA PENDEK', $result_past);
      
      //PIUTANG USAHA - BERSIH ====================================================================================
      $p_bersih_now  = $this->define('PIUTANG USAHA USAHA - BERSIH', $result_now);
      $p_bersih_last  = $this->define('PIUTANG USAHA USAHA - BERSIH', $result_last);
      $p_bersih_past  = $this->define('PIUTANG USAHA USAHA - BERSIH', $result_past);
      
      //PIUTANG LAIN - LAIN =======================================================================================
      $p_lain_last = 0;
      $p_lain_past = 0;
      if($company == '3000' || $company == '4000'){
          $temp_gl    = 'PIUTANG LAIN - LAIN 3000/4000';
      }else{
          $temp_gl    = 'PIUTANG LAIN - LAIN ELSE';
      }
      $p_lain_now    = $this->define($temp_gl, $result_now);
      $p_lain_last    = $this->define($temp_gl, $result_last);
      $p_lain_past    = $this->define($temp_gl, $result_past);
      
      //PERSEDIAAN BERSIH==========================================================================================
      $pers_b_now    = $this->define('PERSEDIAAN BERSIH', $result_now);
      $pers_b_last    = $this->define('PERSEDIAAN BERSIH', $result_last);
      $pers_b_past    = $this->define('PERSEDIAAN BERSIH', $result_past);
      
      //ASET LANCAR LAINNYA========================================================================================
      if($company == '3000' || $company == '4000'){
          $aset_lain_now     = $this->define('ASET LANCAR LAINNYA 3000/4000', $result_now);
          $aset_lain_last     = $this->define('ASET LANCAR LAINNYA 3000/4000', $result_last);
          $aset_lain_past     = $this->define('ASET LANCAR LAINNYA 3000/4000', $result_past);
      }else{

          $aset_lain_now     = $this->define('ASET LANCAR LAINNYA ELSE', $result_now);
          $aset_lain_last     = $this->define('ASET LANCAR LAINNYA ELSE', $result_last);
          $aset_lain_past     = $this->define('ASET LANCAR LAINNYA ELSE', $result_past);
      }

      
      //PAJAK DIBAYAR DIMUKA=======================================================================================
      $pdd_now       = $this->define('PAJAK DIBAYAR DIMUKA', $result_now);
      $pdd_last       = $this->define('PAJAK DIBAYAR DIMUKA', $result_last);
      $pdd_past       = $this->define('PAJAK DIBAYAR DIMUKA', $result_past);
      
      //JUMLAH ASET LANCAR=========================================================================================
            $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;

      $jal_last       = $kas_last + $bank_last + $invest_last + $p_bersih_last + $p_lain_last + $pers_b_last + $aset_lain_last + $pdd_last;

      // echo "jal $jal_last       = kas $kas_last + bank $bank_last +inves $invest_last + p berish $p_bersih_last + plain $p_lain_last + pers_b $pers_b_last + aset lain $aset_lain_last + pdd $pdd_last;";
      $jal_past       = $kas_past + $bank_past + $invest_past + $p_bersih_past + $p_lain_past + $pers_b_past + $aset_lain_past + $pdd_past;
      
      //ASET PAJAK TANGGUHAN======================================================================================
      $apt_now       = $this->define('ASET PAJAK TANGGUHAN', $result_now);
      $apt_last       = $this->define('ASET PAJAK TANGGUHAN', $result_last);
      $apt_past       = $this->define('ASET PAJAK TANGGUHAN', $result_past);
      
      //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
      $ipea_now1     = $this->define( 'IPEA1', $result_now);
      $ipea_now2     = $this->define('IPEA2', $result_now);
      $ipea_now      = $ipea_now1 - $ipea_now2;

      $ipea_last1     = $this->define( 'IPEA1', $result_last);
      $ipea_last2     = $this->define('IPEA2', $result_last);
      $ipea_last      = $ipea_last1 - $ipea_last2;
      
      $ipea_past1     = $this->define( 'IPEA1', $result_past);
      $ipea_past2     = $this->define('IPEA2', $result_past);
      $ipea_past      = $ipea_past1 - $ipea_past2;
      
      //PROPERTI INVESTASI=======================================================================================
      $pi_now        = $this->define('PROPERTI INVESTASI', $result_now);
      $pi_last        = $this->define('PROPERTI INVESTASI', $result_last);
      $pi_past        = $this->define('PROPERTI INVESTASI', $result_past);
      
      //TANAH====================================================================================================
      $tanah_now     = $this->define('TANAH', $result_now);
      $tanah_last     = $this->define('TANAH', $result_last);
      $tanah_past     = $this->define('TANAH', $result_past);
      
      //BANGUNAN=================================================================================================
      if($company == "3000"){
        $bangunan_now  = $this->define('BANGUNAN 3000', $result_now);
        $bangunan_last  = $this->define('BANGUNAN 3000', $result_last);
        $bangunan_past  = $this->define('BANGUNAN 3000', $result_past);
      }else{
        $bangunan_now  = $this->define('BANGUNAN ELSE', $result_now);
        $bangunan_last  = $this->define('BANGUNAN ELSE', $result_last);
        $bangunan_past  = $this->define('BANGUNAN ELSE', $result_past);
      }
     
      
      //MESIN DAN PERALATAN======================================================================================
      if ($company == '3000') {
        $mesin_now     = $this->define('MESIN DAN PERALATAN 3000', $result_now);
        $mesin_last     = $this->define('MESIN DAN PERALATAN 3000', $result_last);
        $mesin_past     = $this->define('MESIN DAN PERALATAN 3000', $result_past);
      } else {
         $mesin_now     = $this->define('MESIN DAN PERALATAN ELSE', $result_now);
        $mesin_last     = $this->define('MESIN DAN PERALATAN ELSE', $result_last);
        $mesin_past     = $this->define('MESIN DAN PERALATAN ELSE', $result_past);
      }
      
      //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
      if ($company == '3000') {
        $alat2_now     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN 3000', $result_now);
        $alat2_last     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN 3000', $result_last);
        $alat2_past     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN 3000', $result_past);
      }else {
        $alat2_now     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN ELSE', $result_now);
        $alat2_last     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN ELSE', $result_last);
        $alat2_past     = $this->define('ALAT - ALAT BERAT DAN KENDARAAN ELSE', $result_past);
      }
     
      
      //PERLENGKAPAN=================================================================================================
       if ($company == '3000') {
          $perl_now      = $this->define('PERLENGKAPAN 3000', $result_now);
          $perl_last      = $this->define('PERLENGKAPAN 3000', $result_last);
          $perl_past      = $this->define('PERLENGKAPAN 3000', $result_past);
       } else {
          $perl_now      = $this->define('PERLENGKAPAN ELSE', $result_now);
          $perl_last      = $this->define('PERLENGKAPAN ELSE', $result_last);
          $perl_past      = $this->define('PERLENGKAPAN ELSE', $result_past);
       }
      
      //TOTAL 1=================================================================================================
      $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;

      $total_last1    = $tanah_last + $bangunan_last + $mesin_last + $alat2_last + $perl_last;
      $total_past1    = $tanah_past + $bangunan_past + $mesin_past + $alat2_past + $perl_past;

       if ($company == '3000') {
          //ASSET LEASING=====================================================================================
          $al_now      = $this->define('ASET LEASING', $result_now);
          $al_last      = $this->define('ASET LEASING', $result_last);
          $al_past      = $this->define('ASET LEASING', $result_past);

          //SARANA DAN PRASARANA==============================================================================
          $sdp_now      = $this->define('SARANA DAN PRASARANA', $result_now);
          $sdp_last      = $this->define('SARANA DAN PRASARANA', $result_last);
          $sdp_past      = $this->define('SARANA DAN PRASARANA', $result_past);
          //SECURITY PART==============================================================================
          $sp_now      = $this->define('SECURITY PART', $result_now);
          $sp_last      = $this->define('SECURITY PART', $result_last);
          $sp_past      = $this->define('SECURITY PART', $result_past);


          $total_now1    += ($al_now + $sdp_now + $sp_now) ;
          $total_last1    += ($al_last + $sdp_last + $sp_last) ;
          $total_past1    += ($al_past + $sdp_past + $sp_past) ;

       } 
      
      //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
      $akum_now      = $this->define('AKUMULASI PENYUSUTAN DAN DEPLESI', $result_now);
      $akum_last      = $this->define('AKUMULASI PENYUSUTAN DAN DEPLESI', $result_last);
      $akum_past      = $this->define('AKUMULASI PENYUSUTAN DAN DEPLESI', $result_past);
      
      //TOTAL 2=================================================================================================
      $total_now2    = $total_now1 + $akum_now;
      $total_last2    = $total_last1 + $akum_last;
      $total_past2    = $total_past1 + $akum_past;
      
      //PEKERJAAN DALAM PELAKSANAAN=============================================================================
      $pdp_now       = $this->define('PEKERJAAN DALAM PELAKSANAAN', $result_now);
      $pdp_last       = $this->define('PEKERJAAN DALAM PELAKSANAAN', $result_last);
      $pdp_past       = $this->define('PEKERJAAN DALAM PELAKSANAAN', $result_past);
      
      //TOTAL ASET TETAP========================================================================================
      $total_at_now  = $total_now2 + $pdp_now;
      $total_at_last  = $total_last2 + $pdp_last;
      $total_at_past  = $total_past2 + $pdp_past;
      
      //UANG MUKA PROYEK========================================================================================
      $ump_now       = $this->define('UANG MUKA PROYEK', $result_now);
      $ump_last       = $this->define('UANG MUKA PROYEK', $result_last);
      $ump_past       = $this->define('UANG MUKA PROYEK', $result_past);
      
      //BEBAN TANGGUHAN - BERSIH=================================================================================
      $btb_now       = $this->define('BEBAN TANGGUHAN - BERSIH', $result_now);
      $btb_last       = $this->define('BEBAN TANGGUHAN - BERSIH', $result_last);
      $btb_past       = $this->define('BEBAN TANGGUHAN - BERSIH', $result_past);
      
      //ASET TAK BERWUJUD=======================================================================================
      $atb_now       = $this->define('ASET TAK BERWUJUD', $result_now);
      $atb_last       = $this->define('ASET TAK BERWUJUD', $result_last);
      $atb_past       = $this->define('ASET TAK BERWUJUD', $result_past);
      
      //ASET TIDAK LANCAR LAINNYA===============================================================================
      $atll_now      = $this->define('ASET TIDAK LANCAR LAINNYA', $result_now);
      $atll_last      = $this->define('ASET TIDAK LANCAR LAINNYA', $result_last);
      $atll_past      = $this->define('ASET TIDAK LANCAR LAINNYA', $result_past);
      
      //JUMLAH ASET TIDAK LANCAR========================================================================================
      $total_atl_now = $apt_now + $ipea_now + $pi_now + $total_at_now + $ump_now + $btb_now + $atb_now + $atll_now;
      $total_atl_last = $apt_last + $ipea_last + $pi_last + $total_at_last + $ump_last + $btb_last + $atb_last + $atll_last;
      $total_atl_past = $apt_past + $ipea_past + $pi_past + $total_at_past + $ump_past + $btb_past + $atb_past + $atll_past;
      
      //JUMLAH ASET=====================================================================================================
      $jmlh_aset_now = $total_atl_now + $jal_now;
      $jmlh_aset_last = $total_atl_last + $jal_last;
      $jmlh_aset_past = $total_atl_past + $jal_past;

      //last=================================================
      $now = array(
        'kas' => "$kas_now",
        'bank'=> "$bank_now",
        'invest' => "$invest_now",
        'p_bersih' => "$p_bersih_now",
        'p_lain' => "$p_lain_now",
        'pers_b' => "$pers_b_now",
        'aset_lain' => "$aset_lain_now",
        'pdd' => "$pdd_now",
        'jal' => "$jal_now", //jumlah aset lancar
        'apt' => "$apt_now",
        'ipea'=> "$ipea_now",
        'pi' => "$pi_now",
        'tanah' => "$tanah_now",
        'bangunan' => "$bangunan_now",
        'mesin' => "$mesin_now",
        'alat2' => "$alat2_now",
        'perl' => "$perl_now",
        'total1' => "$total_now1",
        'akum' => "$akum_now",
        'total2' => "$total_now2",
        'pdp' => "$pdp_now",
        'total_at' => "$total_at_now",
        'ump' => "$ump_now",
        'btb' => "$btb_now",
        'atb' => "$atb_now",
        'atll' => "$atll_now",
        'total_atl' => "$total_atl_now",
        'jmlh_aset' => "$jmlh_aset_now"
      );
     $last = array(
      'kas' => "$kas_last",
      'bank'=> "$bank_last",
      'invest' => "$invest_last",
      'p_bersih' => "$p_bersih_last",
      'p_lain' => "$p_lain_last",
      'pers_b' => "$pers_b_last",
      'aset_lain' => "$aset_lain_last",
      'pdd' => "$pdd_last",
      'jal' => "$jal_last", //jumlah aset lancar
      'apt' => "$apt_last",
      'ipea'=> "$ipea_last",
      'pi' => "$pi_last",
      'tanah' => "$tanah_last",
      'bangunan' => "$bangunan_last",
      'mesin' => "$mesin_last",
      'alat2' => "$alat2_last",
      'perl' => "$perl_last",
      'total1' => "$total_last1",
      'akum' => "$akum_last",
      'total2' => "$total_last2",
      'pdp' => "$pdp_last",
      'total_at' => "$total_at_last",
      'ump' => "$ump_last",
      'btb' => "$btb_last",
      'atb' => "$atb_last",
      'atll' => "$atll_last",
      'total_atl' => "$total_atl_last",
      'jmlh_aset' => "$jmlh_aset_last"
      );
     $past = array(
        'kas' => "$kas_past",
        'bank'=> "$bank_past",
        'invest' => "$invest_past",
        'p_bersih' => "$p_bersih_past",
        'p_lain' => "$p_lain_past",
        'pers_b' => "$pers_b_past",
        'aset_lain' => "$aset_lain_past",
        'pdd' => "$pdd_past",
        'jal' => "$jal_past",
        'apt' => "$apt_past",
        'ipea'=> "$ipea_past",
        'pi' => "$pi_past",
        'tanah' => "$tanah_past",
        'bangunan' => "$bangunan_past",
        'mesin' => "$mesin_past",
        'alat2' => "$alat2_past",
        'perl' => "$perl_past",
        'total1' => "$total_past1",
        'akum' => "$akum_past",
        'total2' => "$total_past2",
        'pdp' => "$pdp_past",
        'total_at' => "$total_at_past",
        'ump' => "$ump_past",
        'btb' => "$btb_past",
        'atb' => "$atb_past",
        'atll' => "$atll_past",
        'total_atl' => "$total_atl_past",
        'jmlh_aset' => "$jmlh_aset_past"
      );

      if ($company == 3000) {
        # code..
          $now['al'] = "$al_now";
          $now['sdp']= "$sdp_now";
          $now['sp'] = "$sp_now";
          $last['al'] = "$al_last";
          $last['sdp']= "$sdp_last";
          $last['sp'] = "$sp_last";
          $past['al'] = "$al_past";
          $past['sdp']= "$sdp_past";
          $past['sp'] = "$sp_past";
      }
      $asset['now'] = $now;
      $asset['last'] = $last;
      $asset['past'] = $past;
        //====================================
      //TABEL SEBELAH KANAN==================
      //liability
        //PINJAMAN JANGKA PENDEK===================================================================================
        $pjp_now       = $this->define('PINJAMAN JANGKA PENDEK', $result_now);
        $pjp_last       = $this->define('PINJAMAN JANGKA PENDEK', $result_last);
        $pjp_past       = $this->define('PINJAMAN JANGKA PENDEK', $result_past);

        //UTANG USAHA==============================================================================================
        $uu_now        = ($this->define('UTANG USAHA', $result_now))*-1;
        $uu_last        = ($this->define('UTANG USAHA', $result_last))*-1;
        $uu_past        = ($this->define('UTANG USAHA', $result_past))*-1;

        //UTANG LAIN - LAIN==========================================================================================
        $pll_now       = ($this->define('UTANG LAIN LAIN', $result_now))*-1;
        $pll_last       = ($this->define('UTANG LAIN LAIN', $result_last))*-1;
        $pll_past       = ($this->define('UTANG LAIN LAIN', $result_past))*-1;

        //BEBAN AKRUAL============================================================================================
        $ba_now        = ($this->define('BEBAN AKRUAL', $result_now))*-1;
        $ba_last        = ($this->define('BEBAN AKRUAL', $result_last))*-1;
        $ba_past        = ($this->define('BEBAN AKRUAL', $result_past))*-1;

        //UTANG PAJAK============================================================================================
        $up_now        = ($this->define('UTANG PAJAK', $result_now))*-1;
        $up_last        = ($this->define('UTANG PAJAK', $result_last))*-1;
        $up_past        = ($this->define('UTANG PAJAK', $result_past))*-1;

        //UTANG DEVIDEN==========================================================================================
        $ud_now        = ($this->define('UTANG DEVIDEN', $result_now))*-1;
        $ud_last        = ($this->define('UTANG DEVIDEN', $result_last))*-1;
        $ud_past        = ($this->define('UTANG DEVIDEN', $result_past))*-1;

        //PINJAMAN BANK============================================================================================
        $pb_now        = ($this->define('PINJAMAN BANK', $result_now))*-1;
        $pb_last        = ($this->define('PINJAMAN BANK', $result_last))*-1;
        $pb_past        = ($this->define('PINJAMAN BANK', $result_past))*-1;

        //PINJAMAN PEMERINTAH RI============================================================================================
        $ppri_now      = ($this->define('PINJAMAN PEMERINTAH RI', $result_now))*-1;
        $ppri_last      = ($this->define('PINJAMAN PEMERINTAH RI', $result_last))*-1;
        $ppri_past      = ($this->define('PINJAMAN PEMERINTAH RI', $result_past))*-1;

        //UTANG BUNGA DAN DENDA==============================================================================================
        $ubdd_now      = ($this->define('UTANG BUNGA DAN DENDA', $result_now))*-1;
        $ubdd_last      = ($this->define('UTANG BUNGA DAN DENDA', $result_last))*-1;
        $ubdd_past      = ($this->define('UTANG BUNGA DAN DENDA', $result_past))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp_now        = ($this->define('SEWA PEMBIAYAAN', $result_now))*-1;
        $sp_last        = ($this->define('SEWA PEMBIAYAAN', $result_last))*-1;
        $sp_past        = ($this->define('SEWA PEMBIAYAAN', $result_past))*-1;

        //JUMLAH LIABILITAS JANGKA PENDEK==========================================================================
        $jljp_now      = $pjp_now + $uu_now + $pll_now + $ba_now + $up_now + $ud_now + $pb_now + $ppri_now + $ubdd_now + $sp_now;
        $jljp_last      = $pjp_last + $uu_last + $pll_last + $ba_last + $up_last + $ud_last + $pb_last + $ppri_last + $ubdd_last + $sp_last;
        $jljp_past      = $pjp_past + $uu_past + $pll_past + $ba_past + $up_past + $ud_past + $pb_past + $ppri_past + $ubdd_past + $sp_past;

        //LIABILITAS PAJAK TANGGUHAN============================================================================================
        $lpt_now       = ($this->define('LIABILITAS PAJAK TANGGUHAN', $result_now))*-1;
        $lpt_last       = ($this->define('LIABILITAS PAJAK TANGGUHAN', $result_last))*-1;
        $lpt_past       = ($this->define('LIABILITAS PAJAK TANGGUHAN', $result_past))*-1;

        //LIABILITAS IMBALAN KERJA JANGKA PANJANG==========================================================================================
        $likjp_now     = ($this->define('LIABILITAS IMBALAN KERJA JANGKA PANJANG', $result_now))*-1;
        $likjp_last     = ($this->define('LIABILITAS IMBALAN KERJA JANGKA PANJANG', $result_last))*-1;
        $likjp_past     = ($this->define('LIABILITAS IMBALAN KERJA JANGKA PANJANG', $result_past))*-1;

        //PINJAMAN BANK 2============================================================================================
        $pb2_now       = ($this->define('PINJAMAN BANK 2', $result_now))*-1;
        $pb2_last       = ($this->define('PINJAMAN BANK 2', $result_last))*-1;
        $pb2_past       = ($this->define('PINJAMAN BANK 2', $result_past))*-1;

        //PINJAMAN PEMERINTAH RI 2============================================================================================
        $ppri2_now     = ($this->define('PINJAMAN PEMERINTAH RI 2', $result_now))*-1;
        $ppri2_last     = ($this->define('PINJAMAN PEMERINTAH RI 2', $result_last))*-1;
        $ppri2_past     = ($this->define('PINJAMAN PEMERINTAH RI 2', $result_past))*-1;

        //UTANG BUNGA DAN DENDA============================================================================================
        $ubdd2_now     = ($this->define('UTANG BUNGA DAN DENDA', $result_now))*-1;
        $ubdd2_last     = ($this->define('UTANG BUNGA DAN DENDA', $result_last))*-1;
        $ubdd2_past     = ($this->define('UTANG BUNGA DAN DENDA', $result_past))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp2_now       = ($this->define('SEWA PEMBIAYAAN 2', $result_now))*-1;
        $sp2_last       = ($this->define('SEWA PEMBIAYAAN 2', $result_last))*-1;
        $sp2_past       = ($this->define('SEWA PEMBIAYAAN 2', $result_past))*-1;

        //PROVISI JANGKA PANJANG==============================================================================================
        $pjp2_now      = ($this->define('PROVINSI JANGKA PANJANG', $result_now))*-1;
        $pjp2_last      = ($this->define('PROVINSI JANGKA PANJANG', $result_last))*-1;
        $pjp2_past      = ($this->define('PROVINSI JANGKA PANJANG', $result_past))*-1;

        //LIABILITAS JANGKA PANJANG LAINNYA=====================================================================================
        $ljpl_now1     = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(1)', $result_now))*-1;
        $ljpl_last1     = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(1)', $result_last))*-1;
        $ljpl_past1     = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(1)', $result_past))*-1;
        $gl_1_now      = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(2)', $result_now))*-1;
        $gl_1_last      = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(2)', $result_last))*-1;
        $gl_1_past      = ($this->define('LIABILITAS JANGKA PANJANG LAINNYA(2)', $result_past))*-1;

        $ljpl_now      = $ljpl_now1 - $pjp2_now - $likjp_now - $gl_1_now;
        $ljpl_last      = $ljpl_last1 - $pjp2_last - $likjp_last - $gl_1_last;
        $ljpl_past      = $ljpl_past1 - $pjp2_past - $likjp_past - $gl_1_past;

        //JUMLAH LIABILITAS JANGKA PANJANG=====================================================================================================
        $jmlh_ljp_now  = $lpt_now + $likjp_now + $pb2_now + $ppri2_now + $ubdd2_now + $sp2_now + $pjp2_now + $ljpl_now;
        $jmlh_ljp_last  = $lpt_last + $likjp_last + $pb2_last + $ppri2_last + $ubdd2_last + $sp2_last + $pjp2_last + $ljpl_last;
        $jmlh_ljp_past  = $lpt_past + $likjp_past + $pb2_past + $ppri2_past + $ubdd2_past + $sp2_past + $pjp2_past + $ljpl_past;

        //JUMLAH LIABILITAS=====================================================================================================
        $liabilitas_now    = $jljp_now + $jmlh_ljp_now;
        $liabilitas_last    = $jljp_last + $jmlh_ljp_last;
        $liabilitas_past    = $jljp_past + $jmlh_ljp_past;

        $liability_now = array(
            'pjp' => "$pjp_now",
            'ba' => "$ba_now",
                "up"=> "$up_now",
                "pb"=> "$pb_now",
                "ppri"=> "$ppri_now",
                "sp"=> "$sp_now",
                "uu"=> "$uu_now",
                "ubdd"=> "$ubdd_now",
                "pll"=> "$pll_now",
                "ud"=> "$ud_now",
                "total_pendek"=> "$jljp_now",
                "lpt"=> "$lpt_now",
                "pb2"=> "$pb2_now",
                "ppri2"=> "$ppri2_now",
                "sp2"=> "$sp2_now",
                "gl_1"=> "$gl_1_now",
                "pjp2"=> "$pjp2_now",
                "ubdd2"=> "$ubdd2_now",
                "ljp1"=> "$ljpl_now",
                "likjp"=> "$likjp_now",
                "total_panjang"=> "$ljpl_now",
                "total_liabilitas"=> "$liabilitas_now"
          );
        $liability_last = array(
            'pjp' => "$pjp_last",
            'ba' => "$ba_last",
                "up"=> "$up_last",
                "pb"=> "$pb_last",
                "ppri"=> "$ppri_last",
                "sp"=> "$sp_last",
                "uu"=> "$uu_last",
                "ubdd"=> "$ubdd_last",
                "pll"=> "$pll_last",
                "ud"=> "$ud_last",
                "total_pendek"=> "$jljp_last",
                "lpt"=> "$lpt_last",
                "pb2"=> "$pb2_last",
                "ppri2"=> "$ppri2_last",
                "sp2"=> "$sp2_last",
                "gl_1"=> "$gl_1_last",
                "pjp2"=> "$pjp2_last",
                "ubdd2"=> "$ubdd2_last",
                "ljp1"=> "$ljpl_last",
                "likjp"=> "$likjp_last",
                "total_panjang"=> "$ljpl_last",
                "total_liabilitas"=> "$liabilitas_last"
          );
         $liability_past = array(
            'pjp' => "$pjp_past",
            'ba' => "$ba_past",
                "up"=> "$up_past",
                "pb"=> "$pb_past",
                "ppri"=> "$ppri_past",
                "sp"=> "$sp_past",
                "uu"=> "$uu_past",
                "ubdd"=> "$ubdd_past",
                "pll"=> "$pll_past",
                "ud"=> "$ud_past",
                "total_pendek"=> "$jljp_past",
                "lpt"=> "$lpt_past",
                "pb2"=> "$pb2_past",
                "ppri2"=> "$ppri2_past",
                "sp2"=> "$sp2_past",
                "gl_1"=> "$gl_1_past",
                "pjp2"=> "$pjp2_past",
                "ubdd2"=> "$ubdd2_past",
                "ljp1"=> "$ljpl_past",
                "likjp"=> "$likjp_past",
                "total_panjang"=> "$ljpl_past",
                "total_liabilitas"=> "$liabilitas_past"
          );
         $liability['now'] = $liability_now;
         $liability['last'] = $liability_last;
         $liability['past'] = $liability_past;
      ////-===============
      //equitas
      //
                  //MODAL SAHAM============================================================================================
            $ms_now        = ($this->define('MODAL SAHAM', $result_now))*-1;
            $ms_last        = ($this->define('MODAL SAHAM', $result_last))*-1;
            $ms_past        = ($this->define('MODAL SAHAM', $result_past))*-1;
            
            //TAMBAHAN MODAL DISETOR===================================================================================
            $tmd_now       = ($this->define('TAMBAHAN MODAL DISETOR', $result_now))*-1;
            $tmd_last       = ($this->define('TAMBAHAN MODAL DISETOR', $result_last))*-1;
            $tmd_past       = ($this->define('TAMBAHAN MODAL DISETOR', $result_past))*-1;
            
            //PENDAPATAN KOMPREHENSIF LAINNYA==========================================================================
            $pkl_now       = ($this->define('PENDAPATAN KOMPREHENSIF LAINNYA', $result_now))*-1;
            $pkl_last       = ($this->define('PENDAPATAN KOMPREHENSIF LAINNYA', $result_last))*-1;
            $pkl_past       = ($this->define('PENDAPATAN KOMPREHENSIF LAINNYA', $result_past))*-1;
            
            //SALDO LABA==========================================================================================
            $sl_now        = ($this->define('SALDO LABA', $result_now))*-1;
            $sl_last        = ($this->define('SALDO LABA', $result_last))*-1;
            $sl_past        = ($this->define('SALDO LABA', $result_past))*-1;
            
            //KEPENTINGAN NON PENGENDALI==========================================================================================
            $knp_now       = ($this->define('KEPENTINGAN NON PENGENDALI', $result_now))*-1;
            $knp_last       = ($this->define('KEPENTINGAN NON PENGENDALI', $result_last))*-1;
            $knp_past       = ($this->define('KEPENTINGAN NON PENGENDALI', $result_past))*-1;
            //JUMLAH EKUITAS=====================================================================================================
            $ekuitas_now   = $ms_now + $tmd_now + $pkl_now + $sl_now + $knp_now;
            $ekuitas_last   = $ms_last + $tmd_last + $pkl_last + $sl_last + $knp_last;
            $ekuitas_past   = $ms_past + $tmd_past + $pkl_past + $sl_past + $knp_past;
            
            //JUMLAH LIABILITAS DAN EKUITAS=====================================================================================================
            $jlde_now      = $liabilitas_now + $ekuitas_now;
            $jlde_last      = $liabilitas_last + $ekuitas_last;
            $jlde_past      = $liabilitas_past + $ekuitas_past;

            $total_equity_liability['now'] = $jlde_now;
            $total_equity_liability['last'] = $jlde_last;
            $total_equity_liability['past'] = $jlde_past;
            $equity_now = array(
               "ms"=> "$ms_now",
              "tmd"=> "$tmd_now",
              "sl"=> "$sl_now",
              "knp"=> "$knp_now",
              "pkl"=> "$pkl_now",
              "total"=> "$ekuitas_now"
              );
            $equity_last = array(
               "ms"=> "$ms_last",
              "tmd"=> "$tmd_last",
              "sl"=> "$sl_last",
              "knp"=> "$knp_last",
              "pkl"=> "$pkl_last",
              "total"=> "$ekuitas_last"
              );
             $equity_past = array(
               "ms"=> "$ms_past",
              "tmd"=> "$tmd_past",
              "sl"=> "$sl_past",
              "knp"=> "$knp_past",
              "pkl"=> "$pkl_past",
              "total"=> "$ekuitas_past"
              );

             $ekuitas['now'] = $equity_now;
             $ekuitas['last'] = $equity_last;
             $ekuitas['past'] = $equity_past;
      ///==============================================================
      ///
            //Short Term Finance Position
              //CURRENT RATIO
            // $ratio_result = $this->m_balance->ratio($company_now, $now_date);
            // 
            // $ratio_data = $this->m_balancemv->get_ratio($company_now, $year, $month);
            $array = $this->ratio($month, $year, $com);
            // foreach ($ratio_data as $key) {
            //   # code...
            //   $part = explode('_', $key['TITLE']);
            //   $tag = $part[1].'VAL';
            //   $array[$tag]=$key['JUMLAH'];
              
            // }
            //"   ((HPBVAL + OAVAL + BPPVAL)+BUAVAL+BPEVAL) + LRSKVAL + PLLVAL + BPVAL AS LABA_SEBELUM_PAJAK"
            $laba_sblm_pj = $array['LABA_SEBELUM_PAJAK'];
             // (HPBVAL + OAVAL + BPPVAL)+BUAVAL+BPEVAL AS LABA_USAHA,
            $laba_usaha = $array['LABA_USAHA'] ;

            $ebitda = $array['EBITDA'] - $laba_usaha;

             // (EBITDAVAL /(HPBVAL + OAVAL)) * 100 AS MARGIN_EBITDA
            $ebitda_margin = $array['EBITDA_MARGIN']*100;

            $cogs = $this->valcogs($month, $year, $com);


              // $curr_rat = ($jal_now/$jljp_now)*100;
             $curr_rat = $this->division($jal_now,$jljp_now)*100;
              // QUICK RATIO
              // $quick_rat = ($jal_now/$pers_b_now)*100;
              $quick_rat = $this->division($jal_now,$pers_b_now)*100;
              // CASH RATIO
              $cash_rat = $this->division($kas_now,$jljp_now)*100;
            // STRUCTURE OF CURRENT ASSET
              // CASH AND CASH EQUIVALENT
              $cash_equ = $this->division($kas_now,$jal_now)*100;
              // SHORT TERM INVESTMENT
              $st_invest = $this->division($invest_now,$jal_now)*100;
              //  TRADE ACCOUNT RECIEVEABLE
              $trade_acc = $this->division($p_bersih_now ,$jal_now)*100;
              //  INVEBTORY
              $inventori = $this->division($pers_b_now,$jal_now)*100;
              //  OTHER ASSET
              $other_asset = $this->division(($p_lain_now+$aset_lain_now+$pdd_now+$bank_now),$jal_now)*100;
            // LONG TERM FINANCIAL POSTITION 
              //   TOTAL DEBT TO equity
              //BAGIAN LANCAR ATAS LIABILITAS JANGKA PANJANG
              $bagian_lancar = ($pb_now+$ppri_now+$ubdd_now+$sp_now);
            // ((Pinjaman jangka pendek + Pinjaman bank + Utang bunga dan denda + Sewa pembiayaan) +
            //   (Pinjaman bank + Bagian lancar atas libilitas jangka panjang__Sewa Pembiayaan)/ (total ekuitas ) Ekuitas yang dapat diatribusikan kepada pemilik entitas induk *100)
                $total_dte = ($this->division(($pjp_now+$pb_now+$ubdd_now+$sp_now)+($pb_now+$bagian_lancar), $ekuitas_now) )*100;
              //   TOTAL DEBT TO TOTAL ASSET 
              // ((Pinjaman jangka pendek + Pinjaman bank + Utang bunga dan denda + Sewa pembiayaan) +(Pinjaman bank + Bagian lancar atas libilitas jangka panjang__Sewa Pembiayaan)/ Jumlah Aset*100)
                $total_dta = ($this->division(($pjp_now+$pb_now+$ubdd_now+$sp_now)+($pb_now+$bagian_lancar), $jmlh_aset_now) )*100;
              //   TANGIBLE ASSETS DEBT COVERAGE
              // (Bagian lancar atas libilitas jangka panjang__Sewa pembiayaan) +(Pinjaman bank + Sewa Pembiayaan)/ Jumlah  aset *100)
                $tadc = ($this->division(($bagian_lancar + ($pb_now+$sp_now)),$jmlh_aset_now) )*100;
              //   TIME INTEREST EARNED RATIO
              // Beban keuangan / LABA USAHA * 100 ?
                $tier = ($this->division($array['BP'], $laba_usaha))*100;
              //   DEBT EQUITY RATIO
                $debt_equ_rat =  round($total_dta)/100 - round($total_dta);
          
            // POSITION OF BUSINESS ASSET
              //   INVENTORY TURNOVER (DAYS)
                  $inven_t = 0;
                  $inven_t = round($this->division((($pers_b_last + $pers_b_now)/2), $cogs)*365/12);

              //   RECIEVEABLE TURNOVER (DAYS)
                  // ((Piutang_usaha_bersih Bulan Lalu + Piutang_usaha_bersih Bulan Ini)/2) / (- Penjualan * 1.1025) * 30)

                  $recieve_t = round($this->division( ( ($p_bersih_last + $p_bersih_now) /2), (-$array['VLP']*11205) ) *30); 
                  // $recieve_t = round($this->division( ( ($p_bersih_last + $p_bersih_now) /2), (-$array['VLP']*1.1205) ) *30, 2); 
                  // $recieve_t = 0;
            // POSITION OF RESULT POSITION
              //   R O A 
                  // ( Laba sebelum pajak * 12) / Jumlah  Aset * 100
                  $roa = 0;
                  $roa = round(($this->division($laba_sblm_pj,$jmlh_aset_now))*100,2);
              //   R O E 
                  // ( Laba sebelum pajak * 12) / Total Ekuitas * 100
                  $roe = 0;
                  $roe = round(($this->division($laba_sblm_pj,$ekuitas_now))*100,2);
              //   COST RATIO '
                  // ( Beban pokok + Beban usaha ) / -Penjualan * 100
                  $cost_rat = 0;
                  $cost_rat = round($this->division( ($array['BPP']+$array['BU']) , -$array['VLP']) * 100, 2);
              //   EBITDA MARGIN 
                  // ( Margin EBITDA * 100 )
                  $ebitda_margin = round($ebitda_margin,2);
              //   INTEREST COVERAGE RATIO 
                  // ( EBITDA / Beban Keuangan ) * -1
                  $int_cov_rat = round(($this->division($ebitda, $array['BP']) * -1), 2);

                  $ratio['1'] = array(
                        'curr_rat' => "$curr_rat",
                        'quick_rat' => "$quick_rat",
                        'cash_rat' => "$cash_rat"
                      ); 
                  $ratio['2'] = array(
                        'cash_equ' => "$cash_equ",
                        'st_invest' => "$st_invest",
                        'trade_acc' => "$trade_acc",
                        'inventori' => "$inventori",
                        'other_asset' => "$other_asset"
                      ); 
                  $ratio['3'] = array(
                    'total_dte' => "$total_dte",
                    'total_dta' => "$total_dta",
                    'tadc' => "$tadc",
                    'tier' => "$tier",
                    'debt_equ_rat' => "$debt_equ_rat"
                  );

                  $ratio['4'] = array(
                    'inven_t' => "$inven_t",
                    'recieve_t' => "$recieve_t"
                   
                  );
                  $ratio['5'] = array(
                    'roa' => "$roa",
                    'roe' => "$roe",
                    'cost_rat' => "$cost_rat",
                    'ebitda_margin' => "$ebitda_margin",
                    'int_cov_rat' => "$int_cov_rat"
                  );




      $test = array();
      $test['equity'] = $ekuitas;
      $test['liability'] = $liability;
      $test['total_liability_equity'] = $total_equity_liability;
      $test['asset'] = $asset;
      $test['ratio'] = $ratio;

      echo json_encode($test);


     

      // echo "$com -> $date_now -> $date_last -> $date_past";
    }

    function monthly(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? 'SMI' : $_GET['company']);
      $paramCompany = "('7000','3000','6000','4000')";
      // if ($com!='SMI') {
      //    $paramCompany = "('$com')";

      //    if ($com == '7000') {
      //       # code...
      //       $paramCompany = "('$com', '2000')";
      //     }
      // }

     
      
      $date_now = "$year.$month";
      $last_year = $year-1;
      $month = (int) $month;
      $past_date = "$last_year.12";
      $category = 'ACT';

      $asset = array();
      $array= array();
      $array_past= array();


      $paramCompany = $this->paramCompany($com, $past_date);
    
      $data_past = $this->m_balancemv->get_balance($paramCompany, $category, $past_date);
      //data past
      foreach ($data_past as $key => $value) {
        # code...
        $array_past[$value['DIS']][$past_date] = $value['JUMLAH'];
      }
      $asset[$com][$past_date] = $this->asset_monthly($array_past, $past_date, $com);

      $paramCompany = $this->paramCompany($com, $date_now);
      // data from firts month until now
      $data = $this->m_balancemv->get_monthly($past_date, $date_now, $paramCompany, $category);
      foreach ($data as $key => $value) {
        # code...
        # 
        $tanggal = date_format(date_create($value['TANGGAL']), 'Y.m');
        $array[$value['DIS']][$tanggal] = $value['JUMLAH'];
      }
      
      for ($i=1; $i <= $month; $i++) { 
        # code...

        $selected = substr(('0'.$i), -2);
        $date = "$year.$selected";
        
        $asset[$com][$date] = $this->asset_monthly($array, $date, $com);
        
      }

      echo json_encode($asset);

    }
   function asset_monthly($result, $date, $company){

      
      $category = 'ACT';
      // $data = $this->m_balancemv->get_balance($date, $category, $company);


     //KAS DAN SETARA KAS===============================================================================
      $kas_now       = $this->define2('KAS DAN SETARA KAS', $result, $date);
      
      //BANK YANG DIBATASI PENGGUNANYA==========================================================================
      $bank_now      = $this->define2('BANK YANG DIBATASI PENGGUNANYA', $result, $date);
      
      //INVESTASI JANGKA PENDEK===================================================================================
      $invest_now    = $this->define2( 'INVESTASI JANGKA PENDEK', $result, $date);
      
      //PIUTANG USAHA - BERSIH ====================================================================================
      $p_bersih_now  = $this->define2('PIUTANG USAHA USAHA - BERSIH', $result, $date);
      
      //PIUTANG LAIN - LAIN =======================================================================================
      if($company == '3000' || $company == '4000'){
          $temp_gl    = 'PIUTANG LAIN - LAIN 3000/4000';
      }else{
          $temp_gl    = 'PIUTANG LAIN - LAIN ELSE';
      }
      $p_lain_now    = $this->define2($temp_gl, $result, $date);
      
      //PERSEDIAAN BERSIH==========================================================================================
      $pers_b_now    = $this->define2('PERSEDIAAN BERSIH', $result, $date);
      
      //ASET LANCAR LAINNYA========================================================================================
      if($company == '3000' || $company == '4000'){
          $aset_lain_now     = $this->define2('ASET LANCAR LAINNYA 3000/4000', $result, $date);
      }else{

          $aset_lain_now     = $this->define2('ASET LANCAR LAINNYA ELSE', $result, $date);
      }

      
      //PAJAK DIBAYAR DIMUKA=======================================================================================
      $pdd_now       = $this->define2('PAJAK DIBAYAR DIMUKA', $result, $date);
      
      //JUMLAH ASET LANCAR=========================================================================================
            $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;


      
      //ASET PAJAK TANGGUHAN======================================================================================
      $apt_now       = $this->define2('ASET PAJAK TANGGUHAN', $result, $date);
      
      //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
      $ipea_now1     = $this->define2( 'IPEA1', $result, $date);
      $ipea_now2     = $this->define2('IPEA2', $result, $date);
      $ipea_now      = $ipea_now1 - $ipea_now2;

      
      
      //PROPERTI INVESTASI=======================================================================================
      $pi_now        = $this->define2('PROPERTI INVESTASI', $result, $date);
      
      //TANAH====================================================================================================
      $tanah_now     = $this->define2('TANAH', $result, $date);
      
      //BANGUNAN=================================================================================================
      if($company == '3000'){
        $bangunan_now  = $this->define2('BANGUNAN 3000', $result, $date);
      }else{
        $bangunan_now  = $this->define2('BANGUNAN ELSE', $result, $date);
      }
     
      
      //MESIN DAN PERALATAN======================================================================================
      if ($company == '3000') {
        $mesin_now     = $this->define2('MESIN DAN PERALATAN 3000', $result, $date);
      } else {
         $mesin_now     = $this->define2('MESIN DAN PERALATAN ELSE', $result, $date);
      }
      
      //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
      if ($company == '3000') {
        $alat2_now     = $this->define2('ALAT - ALAT BERAT DAN KENDARAAN 3000', $result, $date);
      }else {
        $alat2_now     = $this->define2('ALAT - ALAT BERAT DAN KENDARAAN ELSE', $result, $date);
      }
     
      
      //PERLENGKAPAN=================================================================================================
       if ($company == '3000') {
          $perl_now      = $this->define2('PERLENGKAPAN 3000', $result, $date);
       } else {
          $perl_now      = $this->define2('PERLENGKAPAN ELSE', $result, $date);
       }
      
      //TOTAL 1=================================================================================================
      $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;

      
      //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
      $akum_now      = $this->define2('AKUMULASI PENYUSUTAN DAN DEPLESI', $result, $date);
      
      //TOTAL 2=================================================================================================
      $total_now2    = $total_now1 + $akum_now;
      
      //PEKERJAAN DALAM PELAKSANAAN=============================================================================
      $pdp_now       = $this->define2('PEKERJAAN DALAM PELAKSANAAN', $result, $date);
      
      //TOTAL ASET TETAP========================================================================================
      $total_at_now  = $total_now2 + $pdp_now;
      
      //UANG MUKA PROYEK========================================================================================
      $ump_now       = $this->define2('UANG MUKA PROYEK', $result, $date);
      
      //BEBAN TANGGUHAN - BERSIH=================================================================================
      $btb_now       = $this->define2('BEBAN TANGGUHAN - BERSIH', $result, $date);
      
      //ASET TAK BERWUJUD=======================================================================================
      $atb_now       = $this->define2('ASET TAK BERWUJUD', $result, $date);
      
      //ASET TIDAK LANCAR LAINNYA===============================================================================
      $atll_now      = $this->define2('ASET TIDAK LANCAR LAINNYA', $result, $date);
      
      //JUMLAH ASET TIDAK LANCAR========================================================================================
      $total_atl_now = $apt_now + $ipea_now + $pi_now + $total_at_now + $ump_now + $btb_now + $atb_now + $atll_now;
      
      //JUMLAH ASET=====================================================================================================
      $jmlh_aset_now = $total_atl_now + $jal_now;


      return $jmlh_aset_now;
    }

    function define($index, $result){

      if (isset($result[$index])) {
        # code...
        return $result[$index];
      }else{
        return 0;
      }

      // return 0;
    }
    function define2($index, $result, $date){

      if (isset($result[$index][$date])) {
        # code...
        return $result[$index][$date];
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
         $paramCompany = "('5000', '3000', '4000', '6000')";

        if ($year>2016) {

          $paramCompany = "('7000','2000', '5000', '3000', '4000', '6000')";

          if ($com!='' && $com!='SMI' && $com!='smi' && $com!=null) {
            $paramCompany = "('$com')";
            // if ($com == '7000') {
            //   # code...
            //   $paramCompany = "('5000')";
              
            // }
          }

        }else if ($year<=2016) {
          # code...
          $paramCompany = "('7000','2000', '3000', '4000', '6000')";
          if ($com!='' && $com!='SMI' && $com!='smi' && $com!=null) {
            $paramCompany = "('$com')";
            if ($com == '7000') {
              # code...
              $paramCompany = "('$com')";
              
            }
          }

        }
        // echo $paramCompany;
        return $paramCompany;
    }
    function division($value1, $value2){
        if ($value2==0) {
          return null;
        }
        return ( (float) $value1 / (float) $value2 );
    }

    // function ratio(){
    public function ratio($bulan = null, $tahun = null, $opco = '7000'){
      //   $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      // $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($bulan) ? date('m') : $bulan);
      $year = (empty($tahun) ? date('Y') : $tahun);
      $com = (empty($opco) ? '' : $opco);

      // echo "$bulan, $tahun, $opco";

      $date = "$year.$month";
       $temp           = $this->date_between($date);

      $last_year = $year-1;
      $year_of_last_month = $year;
      $last_month = substr(('0'.($month-1)), -2);

      if ($last_month=='00') {
          $last_month = '12';
           $year_of_last_month =  $year_of_last_month -1;
      }

      $past_date = "$last_year.12";
      $now_date = "$year.$month";
      $last_date = "$year_of_last_month.$last_month";

      $category = 'ACT';


      $company_now = $this->paramCompany($com, $now_date);
      $ratio_now = $this->m_balancemv->get_data_ratio($company_now, $category, $now_date);
      $array_now = array();
      foreach ($ratio_now as $key) {
        # code...
        
        $tag = $key['TITLE'];
        $array_now[$tag]=$key['JUMLAH'];
        
      }

      $company_last= $this->paramCompany($com, $last_date);

      $ratio_last = $this->m_balancemv->get_data_ratio($company_last, $category, $last_date);
      $array_last = array();
      foreach ($ratio_last as $key) {
        # code...
        
        $tag = $key['TITLE'];
        $array_last[$tag]=$key['JUMLAH'];
        
      }
      $array = array();

      $array['VLP'] = $this->define('PL_VLP', $array_now);
      $array['DEP'] = $this->define('PL_DEP', $array_now) - $this->define('PL_DEP', $array_last);

      $array['BPP'] = $this->define('PL_BPP', $array_now) - $this->define('PL_BPP', $array_last);
      $array['LRSK'] = $this->define('PL_LRSK', $array_now) - $this->define('PL_LRSK', $array_last);
      $array['PLL'] = $this->define('PL_PLL', $array_now) - $this->define('PL_PLL', $array_last);
      $array['BP'] = $this->define('PL_BP', $array_now) - $this->define('PL_BP', $array_last);
      $array['HPB'] = $this->define('PL_HPB', $array_now) - $this->define('PL_HPB', $array_last);


     

      if ($com==3000 || $com==4000) {
         $array['OA'] = $this->define('PL_OA', $array_now) - $this->define('PL_OA', $array_now);
         $array['BUA'] = $this->define('PL_BUA', $array_now) - $this->define('PL_BUA', $array_now);
         $array['BPE'] = $this->define('PL_BPE', $array_now) - $this->define('PL_BPE', $array_now);
      }else{

        $array['OA'] = $this->define('PL_OA', $array_now);
        $array['BUA'] = $this->define('PL_BUA', $array_now);
        $array['BPE'] = $this->define('PL_BPE', $array_now) - $this->define('PL_OA', $array_now);

      }

      $array['EBITDA'] = $array['DEP']+( $array['HPB']+$array['OA']+$array['BPP']+$array['BUA']+$array['BPE']);

      $array['BU'] = $array['BUA'] + $array['BPE'];

      $array['LABA_SEBELUM_PAJAK'] = ($array['HPB'] + $array['OA'] + $array['BPP']) + $array['LRSK'] + $array['PLL'] + $array['BP'];
             // (HPB + OA + BPP)+BUA+BPE AS LABA_USAHA,
      $array['LABA_USAHA'] = ($array['HPB'] + $array['OA'] + $array['BPP']) + $array['BUA'] + $array['BPE'] ;

      $array['HASIL_PENJUALAN'] = $array['HPB'] + $array['OA'];

      $array['EBITDA_MARGIN'] = $this->division($array['EBITDA'], $array['HASIL_PENJUALAN']);





      // $array['NOW'] = $array_now;
      // $array['last'] = $array_last;
      // echo json_encode($array);

     return $array;

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

   // function valcogs(){
    public function valcogs($bulan = null, $tahun = null, $opco= null){

      // $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      // $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      // $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($bulan) ? date('m') : $bulan);
      $year = (empty($tahun) ? date('Y') : $tahun);
      $com = (empty($opco) ? '' : $opco);

      $date = "$year.$month";
       $temp           = $this->date_between($date);


      $data_cogm_up        = $this->m_cost_structure->get_data_desc($com, $temp, 'ACT', '1 and 9', '10','upto');

      $data_cogs_up        = $this->m_cost_structure->get_data_desc($com, $temp, 'ACT', '10 and 13', '14','upto');
      $cogs= 0;
      foreach ($data_cogs_up as $key => $value) {
        # code...
        if ($value->CSTR_NO!=14) {
          # code...
          $cogs += $value->JML;
        }
        
      }

       foreach ($data_cogm_up as $key => $value) {
        # code...
        if ($value->CSTR_NO!=10) {
          # code...
          $cogs += $value->JML;
        }
        
      }

      return $cogs;
   }

    
}