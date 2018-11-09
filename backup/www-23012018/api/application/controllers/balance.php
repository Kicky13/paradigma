<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class balance extends CI_Controller {

    protected $list;

    function __construct() {
        parent::__construct();
        $this->load->model('m_balance','',true);
    }
    
    function index(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $company = "('7000','3000','6000','4000')";
      if ($com!='') {
         
         $company = "('$com')";
          if ($com == '7000') {
            # code...
            $company = "('$com', '2000')";
          }
      }

     



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


      //KAS DAN SETARA KAS===============================================================================
      $kas_now       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $now_date);
      $kas_last       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $last_date);
      $kas_past       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $past_date);
      
      //BANK YANG DIBATASI PENGGUNANYA==========================================================================
      $bank_now      = $this->m_balance->get_value_gl('1119', $company, $category, $now_date);
      $bank_last      = $this->m_balance->get_value_gl('1119', $company, $category, $last_date);
      $bank_past      = $this->m_balance->get_value_gl('1119', $company, $category, $past_date);
      
      //INVESTASI JANGKA PENDEK===================================================================================
      $invest_now    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $now_date);
      $invest_last    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $last_date);
      $invest_past    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $past_date);
      
      //PIUTANG USAHA - BERSIH ====================================================================================
      $p_bersih_now  = $this->m_balance->get_value_gl('114', $company, $category, $now_date);
      $p_bersih_last  = $this->m_balance->get_value_gl('114', $company, $category, $last_date);
      $p_bersih_past  = $this->m_balance->get_value_gl('114', $company, $category, $past_date);
      
      //PIUTANG LAIN - LAIN =======================================================================================
      $p_lain_last = 0;
      $p_lain_past = 0;
      if($company == '3000' || $company == '4000'){
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001');
      }else{
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001','11910001');
      }
      $p_lain_now    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $now_date);
      $p_lain_last    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $last_date);
      $p_lain_past    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $past_date);
      
      //PERSEDIAAN BERSIH==========================================================================================
      $pers_b_now    = $this->m_balance->get_value_gl('116', $company, $category, $now_date);
      $pers_b_last    = $this->m_balance->get_value_gl('116', $company, $category, $last_date);
      $pers_b_past    = $this->m_balance->get_value_gl('116', $company, $category, $past_date);
      
      //ASET LANCAR LAINNYA========================================================================================
      if($company == '3000' || $company == '4000'){
          $aset_lain_now     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $now_date);
          $aset_lain_last     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $last_date);
          $aset_lain_past     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $past_date);
      }else{

          $aset_lain_now     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $now_date);
          $aset_lain_last     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $last_date);
          $aset_lain_past     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $past_date);
      }

      
      //PAJAK DIBAYAR DIMUKA=======================================================================================
      $pdd_now       = $this->m_balance->get_value_gl('117', $company, $category, $now_date);
      $pdd_last       = $this->m_balance->get_value_gl('117', $company, $category, $last_date);
      $pdd_past       = $this->m_balance->get_value_gl('117', $company, $category, $past_date);
      
      //JUMLAH ASET LANCAR=========================================================================================
            $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;

      $jal_last       = $kas_last + $bank_last + $invest_last + $p_bersih_last + $p_lain_last + $pers_b_last + $aset_lain_last + $pdd_last;

      // echo "jal $jal_last       = kas $kas_last + bank $bank_last +inves $invest_last + p berish $p_bersih_last + plain $p_lain_last + pers_b $pers_b_last + aset lain $aset_lain_last + pdd $pdd_last;";
      $jal_past       = $kas_past + $bank_past + $invest_past + $p_bersih_past + $p_lain_past + $pers_b_past + $aset_lain_past + $pdd_past;
      
      //ASET PAJAK TANGGUHAN======================================================================================
      $apt_now       = $this->m_balance->get_value_gl('131', $company, $category, $now_date);
      $apt_last       = $this->m_balance->get_value_gl('131', $company, $category, $last_date);
      $apt_past       = $this->m_balance->get_value_gl('131', $company, $category, $past_date);
      
      //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
      $ipea_now1     = $this->m_balance->get_value_gl('141', $company, $category, $now_date);
      $ipea_now2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $now_date);
      $ipea_now      = $ipea_now1 - $ipea_now2;

      $ipea_last1     = $this->m_balance->get_value_gl('141', $company, $category, $last_date);
      $ipea_last2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $last_date);
      $ipea_last      = $ipea_last1 - $ipea_last2;
      
      $ipea_past1     = $this->m_balance->get_value_gl('141', $company, $category, $past_date);
      $ipea_past2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $past_date);
      $ipea_past      = $ipea_past1 - $ipea_past2;
      
      //PROPERTI INVESTASI=======================================================================================
      $pi_now        = $this->m_balance->get_value_gl('151', $company, $category, $now_date);
      $pi_last        = $this->m_balance->get_value_gl('151', $company, $category, $last_date);
      $pi_past        = $this->m_balance->get_value_gl('151', $company, $category, $past_date);
      
      //TANAH====================================================================================================
      $tanah_now     = $this->m_balance->get_value_gl('1611', $company, $category, $now_date);
      $tanah_last     = $this->m_balance->get_value_gl('1611', $company, $category, $last_date);
      $tanah_past     = $this->m_balance->get_value_gl('1611', $company, $category, $past_date);
      
      //BANGUNAN=================================================================================================
      $bangunan_now  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $now_date);
      $bangunan_last  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $last_date);
      $bangunan_past  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $past_date);
      
      //MESIN DAN PERALATAN======================================================================================
      $mesin_now     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $now_date);
      $mesin_last     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $last_date);
      $mesin_past     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $past_date);
      
      //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
      $alat2_now     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $now_date);
      $alat2_last     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $last_date);
      $alat2_past     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $past_date);
      
      //PERLENGKAPAN=================================================================================================
      $perl_now      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $now_date);
      $perl_last      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $last_date);
      $perl_past      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $past_date);
      
      //TOTAL 1=================================================================================================
      $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;

      $total_last1    = $tanah_last + $bangunan_last + $mesin_last + $alat2_last + $perl_last;
      $total_past1    = $tanah_past + $bangunan_past + $mesin_past + $alat2_past + $perl_past;
      
      //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
      $akum_now      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $now_date);
      $akum_last      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $last_date);
      $akum_past      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $past_date);
      
      //TOTAL 2=================================================================================================
      $total_now2    = $total_now1 + $akum_now;
      $total_last2    = $total_last1 + $akum_last;
      $total_past2    = $total_past1 + $akum_past;
      
      //PEKERJAAN DALAM PELAKSANAAN=============================================================================
      $pdp_now       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $now_date);
      $pdp_last       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $last_date);
      $pdp_past       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $past_date);
      
      //TOTAL ASET TETAP========================================================================================
      $total_at_now  = $total_now2 + $pdp_now;
      $total_at_last  = $total_last2 + $pdp_last;
      $total_at_past  = $total_past2 + $pdp_past;
      
      //UANG MUKA PROYEK========================================================================================
      $ump_now       = $this->m_balance->get_value_gl('185', $company, $category, $now_date);
      $ump_last       = $this->m_balance->get_value_gl('185', $company, $category, $last_date);
      $ump_past       = $this->m_balance->get_value_gl('185', $company, $category, $past_date);
      
      //BEBAN TANGGUHAN - BERSIH=================================================================================
      $btb_now       = $this->m_balance->get_value_gl('181', $company, $category, $now_date);
      $btb_last       = $this->m_balance->get_value_gl('181', $company, $category, $last_date);
      $btb_past       = $this->m_balance->get_value_gl('181', $company, $category, $past_date);
      
      //ASET TAK BERWUJUD=======================================================================================
      $atb_now       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $now_date);
      $atb_last       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $last_date);
      $atb_past       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $past_date);
      
      //ASET TIDAK LANCAR LAINNYA===============================================================================
      $atll_now      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $now_date);
      $atll_last      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $last_date);
      $atll_past      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $past_date);
      
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
        // 'kas' => "$kas_now",
        // 'bank'=> "$bank_now",
        // 'invest' => "$invest_now",
        // 'p_bersih' => "$p_bersih_now",
        // 'p_lain' => "$p_lain_now",
        // 'pers_b' => "$pers_b_now",
        // 'aset_lain' => "$aset_lain_now",
        // 'pdd' => "$pdd_now",
        // 'jal' => "$jal_now", //jumlah aset lancar
        // 'apt' => "$apt_now",
        // 'ipea'=> "$ipea_now",
        // 'pi' => "$pi_now",
        // 'tanah' => "$tanah_now",
        // 'bangunan' => "$bangunan_now",
        // 'mesin' => "$mesin_now",
        // 'alat2' => "$alat2_now",
        // 'perl' => "$perl_now",
        // 'total1' => "$total_now1",
        // 'akum' => "$akum_now",
        // 'total2' => "$total_now2",
        // 'pdp' => "$pdp_now",
        // 'total_at' => "$total_at_now",
        // 'ump' => "$ump_now",
        // 'btb' => "$btb_now",
        // 'atb' => "$atb_now",
        // 'atll' => "$atll_now",
        // 'total_atl' => "$total_atl_now",
        'jmlh_aset' => "$jmlh_aset_now"
      );
     $last = array(
      // 'kas' => "$kas_last",
      // 'bank'=> "$bank_last",
      // 'invest' => "$invest_last",
      // 'p_bersih' => "$p_bersih_last",
      // 'p_lain' => "$p_lain_last",
      // 'pers_b' => "$pers_b_last",
      // 'aset_lain' => "$aset_lain_last",
      // 'pdd' => "$pdd_last",
      // 'jal' => "$jal_last", //jumlah aset lancar
      // 'apt' => "$apt_last",
      // 'ipea'=> "$ipea_last",
      // 'pi' => "$pi_last",
      // 'tanah' => "$tanah_last",
      // 'bangunan' => "$bangunan_last",
      // 'mesin' => "$mesin_last",
      // 'alat2' => "$alat2_last",
      // 'perl' => "$perl_last",
      // 'total1' => "$total_last1",
      // 'akum' => "$akum_last",
      // 'total2' => "$total_last2",
      // 'pdp' => "$pdp_last",
      // 'total_at' => "$total_at_last",
      // 'ump' => "$ump_last",
      // 'btb' => "$btb_last",
      // 'atb' => "$atb_last",
      // 'atll' => "$atll_last",
      // 'total_atl' => "$total_atl_last",
      'jmlh_aset' => "$jmlh_aset_last"
      );
     $past = array(
        // 'kas' => "$kas_past",
        // 'bank'=> "$bank_past",
        // 'invest' => "$invest_past",
        // 'p_bersih' => "$p_bersih_past",
        // 'p_lain' => "$p_lain_past",
        // 'pers_b' => "$pers_b_past",
        // 'aset_lain' => "$aset_lain_past",
        // 'pdd' => "$pdd_past",
        // 'jal' => "$jal_past",
        // 'apt' => "$apt_past",
        // 'ipea'=> "$ipea_past",
        // 'pi' => "$pi_past",
        // 'tanah' => "$tanah_past",
        // 'bangunan' => "$bangunan_past",
        // 'mesin' => "$mesin_past",
        // 'alat2' => "$alat2_past",
        // 'perl' => "$perl_past",
        // 'total1' => "$total_past1",
        // 'akum' => "$akum_past",
        // 'total2' => "$total_past2",
        // 'pdp' => "$pdp_past",
        // 'total_at' => "$total_at_past",
        // 'ump' => "$ump_past",
        // 'btb' => "$btb_past",
        // 'atb' => "$atb_past",
        // 'atll' => "$atll_past",
        // 'total_atl' => "$total_atl_past",
        'jmlh_aset' => "$jmlh_aset_past"
      );
      $asset['now'] = $now;
      $asset['last'] = $last;
      $asset['past'] = $past;
        //====================================
      //TABEL SEBELAH KANAN==================
      //liability
        //PINJAMAN JANGKA PENDEK===================================================================================
        $pjp_now       = $this->m_balance->get_value_gl('211', $company, $category, $now_date);
        $pjp_last       = $this->m_balance->get_value_gl('211', $company, $category, $last_date);
        $pjp_past       = $this->m_balance->get_value_gl('211', $company, $category, $past_date);

        //UTANG USAHA==============================================================================================
        $uu_now        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $now_date))*-1;
        $uu_last        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $last_date))*-1;
        $uu_past        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $past_date))*-1;

        //UTANG LAIN - LAIN==========================================================================================
        $pll_now       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
        $pll_last       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
        $pll_past       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

        //BEBAN AKRUAL============================================================================================
        $ba_now        = ($this->m_balance->get_value_gl('216', $company, $category, $now_date))*-1;
        $ba_last        = ($this->m_balance->get_value_gl('216', $company, $category, $last_date))*-1;
        $ba_past        = ($this->m_balance->get_value_gl('216', $company, $category, $past_date))*-1;

        //UTANG PAJAK============================================================================================
        $up_now        = ($this->m_balance->get_value_gl('215', $company, $category, $now_date))*-1;
        $up_last        = ($this->m_balance->get_value_gl('215', $company, $category, $last_date))*-1;
        $up_past        = ($this->m_balance->get_value_gl('215', $company, $category, $past_date))*-1;

        //UTANG DEVIDEN==========================================================================================
        $ud_now        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
        $ud_last        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
        $ud_past        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

        //PINJAMAN BANK============================================================================================
        $pb_now        = ($this->m_balance->get_value_gl('2171', $company, $category, $now_date))*-1;
        $pb_last        = ($this->m_balance->get_value_gl('2171', $company, $category, $last_date))*-1;
        $pb_past        = ($this->m_balance->get_value_gl('2171', $company, $category, $past_date))*-1;

        //PINJAMAN PEMERINTAH RI============================================================================================
        $ppri_now      = ($this->m_balance->get_value_gl('2172', $company, $category, $now_date))*-1;
        $ppri_last      = ($this->m_balance->get_value_gl('2172', $company, $category, $last_date))*-1;
        $ppri_past      = ($this->m_balance->get_value_gl('2172', $company, $category, $past_date))*-1;

        //UTANG BUNGA DAN DENDA==============================================================================================
        $ubdd_now      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
        $ubdd_last      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
        $ubdd_past      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp_now        = ($this->m_balance->get_value_gl('2176', $company, $category, $now_date))*-1;
        $sp_last        = ($this->m_balance->get_value_gl('2176', $company, $category, $last_date))*-1;
        $sp_past        = ($this->m_balance->get_value_gl('2176', $company, $category, $past_date))*-1;

        //JUMLAH LIABILITAS JANGKA PENDEK==========================================================================
        $jljp_now      = $pjp_now + $uu_now + $pll_now + $ba_now + $up_now + $ud_now + $pb_now + $ppri_now + $ubdd_now + $sp_now;
        $jljp_last      = $pjp_last + $uu_last + $pll_last + $ba_last + $up_last + $ud_last + $pb_last + $ppri_last + $ubdd_last + $sp_last;
        $jljp_past      = $pjp_past + $uu_past + $pll_past + $ba_past + $up_past + $ud_past + $pb_past + $ppri_past + $ubdd_past + $sp_past;

        //LIABILITAS PAJAK TANGGUHAN============================================================================================
        $lpt_now       = ($this->m_balance->get_value_gl('23', $company, $category, $now_date))*-1;
        $lpt_last       = ($this->m_balance->get_value_gl('23', $company, $category, $last_date))*-1;
        $lpt_past       = ($this->m_balance->get_value_gl('23', $company, $category, $past_date))*-1;

        //LIABILITAS IMBALAN KERJA JANGKA PANJANG==========================================================================================
        $likjp_now     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $now_date))*-1;
        $likjp_last     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $last_date))*-1;
        $likjp_past     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $past_date))*-1;

        //PINJAMAN BANK 2============================================================================================
        $pb2_now       = ($this->m_balance->get_value_gl('251', $company, $category, $now_date))*-1;
        $pb2_last       = ($this->m_balance->get_value_gl('251', $company, $category, $last_date))*-1;
        $pb2_past       = ($this->m_balance->get_value_gl('251', $company, $category, $past_date))*-1;

        //PINJAMAN PEMERINTAH RI 2============================================================================================
        $ppri2_now     = ($this->m_balance->get_value_gl('252', $company, $category, $now_date))*-1;
        $ppri2_last     = ($this->m_balance->get_value_gl('252', $company, $category, $last_date))*-1;
        $ppri2_past     = ($this->m_balance->get_value_gl('252', $company, $category, $past_date))*-1;

        //UTANG BUNGA DAN DENDA============================================================================================
        $ubdd2_now     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
        $ubdd2_last     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
        $ubdd2_past     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp2_now       = ($this->m_balance->get_value_gl('256', $company, $category, $now_date))*-1;
        $sp2_last       = ($this->m_balance->get_value_gl('256', $company, $category, $last_date))*-1;
        $sp2_past       = ($this->m_balance->get_value_gl('256', $company, $category, $past_date))*-1;

        //PROVISI JANGKA PANJANG==============================================================================================
        $pjp2_now      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $now_date))*-1;
        $pjp2_last      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $last_date))*-1;
        $pjp2_past      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $past_date))*-1;

        //LIABILITAS JANGKA PANJANG LAINNYA=====================================================================================
        $ljpl_now1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $now_date))*-1;
        $ljpl_last1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $last_date))*-1;
        $ljpl_past1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $past_date))*-1;
        $gl_1_now      = ($this->m_balance->get_value_gl('25900004', $company, $category, $now_date))*-1;
        $gl_1_last      = ($this->m_balance->get_value_gl('25900004', $company, $category, $last_date))*-1;
        $gl_1_past      = ($this->m_balance->get_value_gl('25900004', $company, $category, $past_date))*-1;

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
            // 'pjp' => "$pjp_now",
            // 'ba' => "$ba_now",
            //     "up"=> "$up_now",
            //     "pb"=> "$pb_now",
            //     "ppri"=> "$ppri_now",
            //     "sp"=> "$sp_now",
            //     "uu"=> "$uu_now",
            //     "ubdd"=> "$ubdd_now",
            //     "pll"=> "$pll_now",
            //     "ud"=> "$ud_now",
            //     "total_pendek"=> "$jljp_now",
            //     "lpt"=> "$lpt_now",
            //     "pb2"=> "$pb2_now",
            //     "ppri2"=> "$ppri2_now",
            //     "sp2"=> "$sp2_now",
            //     "gl_1"=> "$gl_1_now",
            //     "pjp2"=> "$pjp2_now",
            //     "ubdd2"=> "$ubdd2_now",
            //     "ljp1"=> "$ljpl_now",
            //     "likjp"=> "$likjp_now",
            //     "total_panjang"=> "$ljpl_now",
                "total_liabilitas"=> "$liabilitas_now"
          );
        $liability_last = array(
            // 'pjp' => "$pjp_last",
            // 'ba' => "$ba_last",
            //     "up"=> "$up_last",
            //     "pb"=> "$pb_last",
            //     "ppri"=> "$ppri_last",
            //     "sp"=> "$sp_last",
            //     "uu"=> "$uu_last",
            //     "ubdd"=> "$ubdd_last",
            //     "pll"=> "$pll_last",
            //     "ud"=> "$ud_last",
            //     "total_pendek"=> "$jljp_last",
            //     "lpt"=> "$lpt_last",
            //     "pb2"=> "$pb2_last",
            //     "ppri2"=> "$ppri2_last",
            //     "sp2"=> "$sp2_last",
            //     "gl_1"=> "$gl_1_last",
            //     "pjp2"=> "$pjp2_last",
            //     "ubdd2"=> "$ubdd2_last",
            //     "ljp1"=> "$ljpl_last",
            //     "likjp"=> "$likjp_last",
            //     "total_panjang"=> "$ljpl_last",
                "total_liabilitas"=> "$liabilitas_last"
          );
         $liability_past = array(
            // 'pjp' => "$pjp_past",
            // 'ba' => "$ba_past",
            //     "up"=> "$up_past",
            //     "pb"=> "$pb_past",
            //     "ppri"=> "$ppri_past",
            //     "sp"=> "$sp_past",
            //     "uu"=> "$uu_past",
            //     "ubdd"=> "$ubdd_past",
            //     "pll"=> "$pll_past",
            //     "ud"=> "$ud_past",
            //     "total_pendek"=> "$jljp_past",
            //     "lpt"=> "$lpt_past",
            //     "pb2"=> "$pb2_past",
            //     "ppri2"=> "$ppri2_past",
            //     "sp2"=> "$sp2_past",
            //     "gl_1"=> "$gl_1_past",
            //     "pjp2"=> "$pjp2_past",
            //     "ubdd2"=> "$ubdd2_past",
            //     "ljp1"=> "$ljpl_past",
            //     "likjp"=> "$likjp_past",
            //     "total_panjang"=> "$ljpl_past",
                "total_liabilitas"=> "$liabilitas_past"
          );
         $liability['now'] = $liability_now;
         $liability['last'] = $liability_last;
         $liability['past'] = $liability_past;
      ////-===============
      //equitas
      //
            //MODAL SAHAM============================================================================================
            $ms_now        = ($this->m_balance->get_value_gl('31', $company, $category, $now_date))*-1;
            $ms_last        = ($this->m_balance->get_value_gl('31', $company, $category, $last_date))*-1;
            $ms_past        = ($this->m_balance->get_value_gl('31', $company, $category, $past_date))*-1;
            
            //TAMBAHAN MODAL DISETOR===================================================================================
            $tmd_now       = ($this->m_balance->get_value_gl('32', $company, $category, $now_date))*-1;
            $tmd_last       = ($this->m_balance->get_value_gl('32', $company, $category, $last_date))*-1;
            $tmd_past       = ($this->m_balance->get_value_gl('32', $company, $category, $past_date))*-1;
            
            //PENDAPATAN KOMPREHENSIF LAINNYA==========================================================================
            $pkl_now       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $now_date))*-1;
            $pkl_last       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $last_date))*-1;
            $pkl_past       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $past_date))*-1;
            
            //SALDO LABA==========================================================================================
            $sl_now        = ($this->m_balance->get_value_gl('3411', $company, $category, $now_date))*-1;
            $sl_last        = ($this->m_balance->get_value_gl('3411', $company, $category, $last_date))*-1;
            $sl_past        = ($this->m_balance->get_value_gl('3411', $company, $category, $past_date))*-1;
            
            //KEPENTINGAN NON PENGENDALI==========================================================================================
            $knp_now       = ($this->m_balance->get_value_gl('37', $company, $category, $now_date))*-1;
            $knp_last       = ($this->m_balance->get_value_gl('37', $company, $category, $last_date))*-1;
            $knp_past       = ($this->m_balance->get_value_gl('37', $company, $category, $past_date))*-1;
            
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
              //  "ms"=> "$ms_now",
              // "tmd"=> "$tmd_now",
              // "sl"=> "$sl_now",
              // "knp"=> "$knp_now",
              // "pkl"=> "$pkl_now",
              "total"=> "$ekuitas_now"
              );
            $equity_last = array(
              //  "ms"=> "$ms_last",
              // "tmd"=> "$tmd_last",
              // "sl"=> "$sl_last",
              // "knp"=> "$knp_last",
              // "pkl"=> "$pkl_last",
              "total"=> "$ekuitas_last"
              );
             $equity_past = array(
              //  "ms"=> "$ms_past",
              // "tmd"=> "$tmd_past",
              // "sl"=> "$sl_past",
              // "knp"=> "$knp_past",
              // "pkl"=> "$pkl_past",
              "total"=> "$ekuitas_past"
              );

             $ekuitas['now'] = $equity_now;
             $ekuitas['last'] = $equity_last;
             $ekuitas['past'] = $equity_past;
      ///==============================================================
            //Short Term Finance Position
              //CURRENT RATIO
            $ratio_result = $this->m_balance->ratio($company, $now_date);
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
                $tier = 0;
              //   DEBT EQUITY RATIO
                $debt_equ_rat =  round($total_dta)/100 - round($total_dta);
          
            // POSITION OF BUSINESS ASSET
              //   INVENTORY TURNOVER (DAYS)
                  // $inven_t = (($pers_b_last + $pers_b_now)/2)/cogs*365/12
                  $inven_t = 0;
              //   RECIEVEABLE TURNOVER (DAYS)
                  // ((Piutang_usaha_bersih Bulan Lalu + Piutang_usaha_bersih Bulan Ini)/2) / (- Penjualan * 1.1025) * 30)

                  // $recieve_t = (($p_bersih_last + $p_bersih_now)/2)/ 
                  $recieve_t = 0;
            // POSITION OF RESULT POSITION
              //   R O A 
                  // ( Laba sebelum pajak * 12) / Jumlah  Aset * 100
                  $roa = 0;
                  $roa = round(($this->division($ratio_result['LABA_SEBELUM_PAJAK'],$jmlh_aset_now))*100,2);
              //   R O E 
                  // ( Laba sebelum pajak * 12) / Total Ekuitas * 100
                  $roe = 0;
                  $roe = round(($this->division($ratio_result['LABA_SEBELUM_PAJAK'],$ekuitas_now))*100,2);
              //   COST RATIO '
                  // ( Beban pokok + Beban usaha ) / -Penjualan * 100
                  $cost_rat = 0;
              //   EBITDA MARGIN 
                  // ( Margin EBITDA * 100 )
                  $ebitda_margin = round($ratio_result['MARGIN_EBITDA'],2);
              //   INTEREST COVERAGE RATIO 
                  // ( EBITDA / Beban Keuangan ) * -1
                  $int_cov_rat = 0;

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

    function dt(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $company = "('7000','3000','6000','4000')";
      if ($com!='') {
        
         $company = "('$com')";
          if ($com == '7000') {
            # code...
            $company = "('$com', '2000')";
          }
      }
      // echo $company;
     



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
      $ratio = array();


      //KAS DAN SETARA KAS===============================================================================
      $kas_now       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $now_date);
      $kas_last       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $last_date);
      // $kas_past       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $past_date);
      
      //BANK YANG DIBATASI PENGGUNANYA==========================================================================
      $bank_now      = $this->m_balance->get_value_gl('1119', $company, $category, $now_date);
      $bank_last      = $this->m_balance->get_value_gl('1119', $company, $category, $last_date);
      // $bank_past      = $this->m_balance->get_value_gl('1119', $company, $category, $past_date);
      
      //INVESTASI JANGKA PENDEK===================================================================================
      $invest_now    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $now_date);
      $invest_last    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $last_date);
      // $invest_past    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $past_date);
      
      //PIUTANG USAHA - BERSIH ====================================================================================
      $p_bersih_now  = $this->m_balance->get_value_gl('114', $company, $category, $now_date);
      $p_bersih_last  = $this->m_balance->get_value_gl('114', $company, $category, $last_date);
      // $p_bersih_past  = $this->m_balance->get_value_gl('114', $company, $category, $past_date);
      
      //PIUTANG LAIN - LAIN =======================================================================================
      $p_lain_last = 0;
      $p_lain_past = 0;
      if($company == '3000' || $company == '4000'){
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001');
      }else{
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001','11910001');
      }
      $p_lain_now    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $now_date);
      $p_lain_last    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $last_date);
      // $p_lain_past    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $past_date);
      
      //PERSEDIAAN BERSIH==========================================================================================
      $pers_b_now    = $this->m_balance->get_value_gl('116', $company, $category, $now_date);
      $pers_b_last    = $this->m_balance->get_value_gl('116', $company, $category, $last_date);
      // $pers_b_past    = $this->m_balance->get_value_gl('116', $company, $category, $past_date);
      
      //ASET LANCAR LAINNYA========================================================================================
      if($company == '3000' || $company == '4000'){
          $aset_lain_now     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $now_date);
          $aset_lain_last     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $last_date);
          // $aset_lain_past     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $past_date);
      }else{

          $aset_lain_now     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $now_date);
          $aset_lain_last     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $last_date);
          // $aset_lain_past     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $past_date);
      }

      
      //PAJAK DIBAYAR DIMUKA=======================================================================================
      $pdd_now       = $this->m_balance->get_value_gl('117', $company, $category, $now_date);
      $pdd_last       = $this->m_balance->get_value_gl('117', $company, $category, $last_date);
      // $pdd_past       = $this->m_balance->get_value_gl('117', $company, $category, $past_date);
      
      //JUMLAH ASET LANCAR=========================================================================================
            $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;

      $jal_last       = $kas_last + $bank_last + $invest_last + $p_bersih_last + $p_lain_last + $pers_b_last + $aset_lain_last + $pdd_last;

      // echo "jal $jal_last       = kas $kas_last + bank $bank_last +inves $invest_last + p berish $p_bersih_last + plain $p_lain_last + pers_b $pers_b_last + aset lain $aset_lain_last + pdd $pdd_last;";
      // $jal_past       = $kas_past + $bank_past + $invest_past + $p_bersih_past + $p_lain_past + $pers_b_past + $aset_lain_past + $pdd_past;
      
      //ASET PAJAK TANGGUHAN======================================================================================
      $apt_now       = $this->m_balance->get_value_gl('131', $company, $category, $now_date);
      $apt_last       = $this->m_balance->get_value_gl('131', $company, $category, $last_date);
      // $apt_past       = $this->m_balance->get_value_gl('131', $company, $category, $past_date);
      
      //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
      $ipea_now1     = $this->m_balance->get_value_gl('141', $company, $category, $now_date);
      $ipea_now2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $now_date);
      $ipea_now      = $ipea_now1 - $ipea_now2;

      $ipea_last1     = $this->m_balance->get_value_gl('141', $company, $category, $last_date);
      $ipea_last2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $last_date);
      $ipea_last      = $ipea_last1 - $ipea_last2;
      
      // $ipea_past1     = $this->m_balance->get_value_gl('141', $company, $category, $past_date);
      // $ipea_past2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $past_date);
      // $ipea_past      = $ipea_past1 - $ipea_past2;
      
      //PROPERTI INVESTASI=======================================================================================
      $pi_now        = $this->m_balance->get_value_gl('151', $company, $category, $now_date);
      $pi_last        = $this->m_balance->get_value_gl('151', $company, $category, $last_date);
      // $pi_past        = $this->m_balance->get_value_gl('151', $company, $category, $past_date);
      
      //TANAH====================================================================================================
      $tanah_now     = $this->m_balance->get_value_gl('1611', $company, $category, $now_date);
      $tanah_last     = $this->m_balance->get_value_gl('1611', $company, $category, $last_date);
      // $tanah_past     = $this->m_balance->get_value_gl('1611', $company, $category, $past_date);
      
      //BANGUNAN=================================================================================================
      $bangunan_now  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $now_date);
      $bangunan_last  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $last_date);
      // $bangunan_past  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $past_date);
      
      //MESIN DAN PERALATAN======================================================================================
      $mesin_now     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $now_date);
      $mesin_last     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $last_date);
      // $mesin_past     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $past_date);
      
      //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
      $alat2_now     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $now_date);
      $alat2_last     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $last_date);
      // $alat2_past     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $past_date);
      
      //PERLENGKAPAN=================================================================================================
      $perl_now      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $now_date);
      $perl_last      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $last_date);
      // $perl_past      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $past_date);
      
      //TOTAL 1=================================================================================================
      $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;

      $total_last1    = $tanah_last + $bangunan_last + $mesin_last + $alat2_last + $perl_last;
      // $total_past1    = $tanah_past + $bangunan_past + $mesin_past + $alat2_past + $perl_past;
      
      //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
      $akum_now      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $now_date);
      $akum_last      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $last_date);
      // $akum_past      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $past_date);
      
      //TOTAL 2=================================================================================================
      $total_now2    = $total_now1 + $akum_now;
      $total_last2    = $total_last1 + $akum_last;
      // $total_past2    = $total_past1 + $akum_past;
      
      //PEKERJAAN DALAM PELAKSANAAN=============================================================================
      $pdp_now       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $now_date);
      $pdp_last       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $last_date);
      // $pdp_past       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $past_date);
      
      //TOTAL ASET TETAP========================================================================================
      $total_at_now  = $total_now2 + $pdp_now;
      $total_at_last  = $total_last2 + $pdp_last;
      // $total_at_past  = $total_past2 + $pdp_past;
      
      //UANG MUKA PROYEK========================================================================================
      $ump_now       = $this->m_balance->get_value_gl('185', $company, $category, $now_date);
      $ump_last       = $this->m_balance->get_value_gl('185', $company, $category, $last_date);
      // $ump_past       = $this->m_balance->get_value_gl('185', $company, $category, $past_date);
      
      //BEBAN TANGGUHAN - BERSIH=================================================================================
      $btb_now       = $this->m_balance->get_value_gl('181', $company, $category, $now_date);
      $btb_last       = $this->m_balance->get_value_gl('181', $company, $category, $last_date);
      // $btb_past       = $this->m_balance->get_value_gl('181', $company, $category, $past_date);
      
      //ASET TAK BERWUJUD=======================================================================================
      $atb_now       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $now_date);
      $atb_last       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $last_date);
      // $atb_past       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $past_date);
      
      //ASET TIDAK LANCAR LAINNYA===============================================================================
      $atll_now      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $now_date);
      $atll_last      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $last_date);
      // $atll_past      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $past_date);
      
      //JUMLAH ASET TIDAK LANCAR========================================================================================
      $total_atl_now = $apt_now + $ipea_now + $pi_now + $total_at_now + $ump_now + $btb_now + $atb_now + $atll_now;
      $total_atl_last = $apt_last + $ipea_last + $pi_last + $total_at_last + $ump_last + $btb_last + $atb_last + $atll_last;
      // $total_atl_past = $apt_past + $ipea_past + $pi_past + $total_at_past + $ump_past + $btb_past + $atb_past + $atll_past;
      // 
      //JUMLAH ASET=====================================================================================================
      $jmlh_aset_now = $total_atl_now + $jal_now;
      $jmlh_aset_last = $total_atl_last + $jal_last;
      // $jmlh_aset_past = $total_atl_past + $jal_past;

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
        // 'kas' => "$kas_past",
        // 'bank'=> "$bank_past",
        // 'invest' => "$invest_past",
        // 'p_bersih' => "$p_bersih_past",
        // 'p_lain' => "$p_lain_past",
        // 'pers_b' => "$pers_b_past",
        // 'aset_lain' => "$aset_lain_past",
        // 'pdd' => "$pdd_past",
        // 'jal' => "$jal_past",
        // 'apt' => "$apt_past",
        // 'ipea'=> "$ipea_past",
        // 'pi' => "$pi_past",
        // 'tanah' => "$tanah_past",
        // 'bangunan' => "$bangunan_past",
        // 'mesin' => "$mesin_past",
        // 'alat2' => "$alat2_past",
        // 'perl' => "$perl_past",
        // 'total1' => "$total_past1",
        // 'akum' => "$akum_past",
        // 'total2' => "$total_past2",
        // 'pdp' => "$pdp_past",
        // 'total_at' => "$total_at_past",
        // 'ump' => "$ump_past",
        // 'btb' => "$btb_past",
        // 'atb' => "$atb_past",
        // 'atll' => "$atll_past",
        // 'total_atl' => "$total_atl_past",
        // 'jmlh_aset' => "$jmlh_aset_past"
    );
    $asset['now'] = $now;
    $asset['last'] = $last;
    // $asset['past'] = $past;
      //====================================
      //TABEL SEBELAH KANAN==================
      //liability
        //PINJAMAN JANGKA PENDEK===================================================================================
        $pjp_now       = $this->m_balance->get_value_gl('211', $company, $category, $now_date);
        $pjp_last       = $this->m_balance->get_value_gl('211', $company, $category, $last_date);
        // $pjp_past       = $this->m_balance->get_value_gl('211', $company, $category, $past_date);

        //UTANG USAHA==============================================================================================
        $uu_now        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $now_date))*-1;
        $uu_last        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $last_date))*-1;
        // $uu_past        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $past_date))*-1;

        //UTANG LAIN - LAIN==========================================================================================
        $pll_now       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
        $pll_last       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
        // $pll_past       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

        //BEBAN AKRUAL============================================================================================
        $ba_now        = ($this->m_balance->get_value_gl('216', $company, $category, $now_date))*-1;
        $ba_last        = ($this->m_balance->get_value_gl('216', $company, $category, $last_date))*-1;
        // $ba_past        = ($this->m_balance->get_value_gl('216', $company, $category, $past_date))*-1;

        //UTANG PAJAK============================================================================================
        $up_now        = ($this->m_balance->get_value_gl('215', $company, $category, $now_date))*-1;
        $up_last        = ($this->m_balance->get_value_gl('215', $company, $category, $last_date))*-1;
        // $up_past        = ($this->m_balance->get_value_gl('215', $company, $category, $past_date))*-1;

        //UTANG DEVIDEN==========================================================================================
        $ud_now        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
        $ud_last        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
        // $ud_past        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

        //PINJAMAN BANK============================================================================================
        $pb_now        = ($this->m_balance->get_value_gl('2171', $company, $category, $now_date))*-1;
        $pb_last        = ($this->m_balance->get_value_gl('2171', $company, $category, $last_date))*-1;
        // $pb_past        = ($this->m_balance->get_value_gl('2171', $company, $category, $past_date))*-1;

        //PINJAMAN PEMERINTAH RI============================================================================================
        $ppri_now      = ($this->m_balance->get_value_gl('2172', $company, $category, $now_date))*-1;
        $ppri_last      = ($this->m_balance->get_value_gl('2172', $company, $category, $last_date))*-1;
        // $ppri_past      = ($this->m_balance->get_value_gl('2172', $company, $category, $past_date))*-1;

        //UTANG BUNGA DAN DENDA==============================================================================================
        $ubdd_now      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
        $ubdd_last      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
        // $ubdd_past      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp_now        = ($this->m_balance->get_value_gl('2176', $company, $category, $now_date))*-1;
        $sp_last        = ($this->m_balance->get_value_gl('2176', $company, $category, $last_date))*-1;
        // $sp_past        = ($this->m_balance->get_value_gl('2176', $company, $category, $past_date))*-1;

        //JUMLAH LIABILITAS JANGKA PENDEK==========================================================================
        $jljp_now      = $pjp_now + $uu_now + $pll_now + $ba_now + $up_now + $ud_now + $pb_now + $ppri_now + $ubdd_now + $sp_now;
        $jljp_last      = $pjp_last + $uu_last + $pll_last + $ba_last + $up_last + $ud_last + $pb_last + $ppri_last + $ubdd_last + $sp_last;
        // $jljp_past      = $pjp_past + $uu_past + $pll_past + $ba_past + $up_past + $ud_past + $pb_past + $ppri_past + $ubdd_past + $sp_past;

        //LIABILITAS PAJAK TANGGUHAN============================================================================================
        $lpt_now       = ($this->m_balance->get_value_gl('23', $company, $category, $now_date))*-1;
        $lpt_last       = ($this->m_balance->get_value_gl('23', $company, $category, $last_date))*-1;
        // $lpt_past       = ($this->m_balance->get_value_gl('23', $company, $category, $past_date))*-1;

        //LIABILITAS IMBALAN KERJA JANGKA PANJANG==========================================================================================
        $likjp_now     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $now_date))*-1;
        $likjp_last     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $last_date))*-1;
        // $likjp_past     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $past_date))*-1;

        //PINJAMAN BANK 2============================================================================================
        $pb2_now       = ($this->m_balance->get_value_gl('251', $company, $category, $now_date))*-1;
        $pb2_last       = ($this->m_balance->get_value_gl('251', $company, $category, $last_date))*-1;
        // $pb2_past       = ($this->m_balance->get_value_gl('251', $company, $category, $past_date))*-1;

        //PINJAMAN PEMERINTAH RI 2============================================================================================
        $ppri2_now     = ($this->m_balance->get_value_gl('252', $company, $category, $now_date))*-1;
        $ppri2_last     = ($this->m_balance->get_value_gl('252', $company, $category, $last_date))*-1;
        // $ppri2_past     = ($this->m_balance->get_value_gl('252', $company, $category, $past_date))*-1;

        //UTANG BUNGA DAN DENDA============================================================================================
        $ubdd2_now     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
        $ubdd2_last     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
        // $ubdd2_past     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

        //SEWA PEMBIAYAAN============================================================================================
        $sp2_now       = ($this->m_balance->get_value_gl('256', $company, $category, $now_date))*-1;
        $sp2_last       = ($this->m_balance->get_value_gl('256', $company, $category, $last_date))*-1;
        // $sp2_past       = ($this->m_balance->get_value_gl('256', $company, $category, $past_date))*-1;

        //PROVISI JANGKA PANJANG==============================================================================================
        $pjp2_now      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $now_date))*-1;
        $pjp2_last      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $last_date))*-1;
        // $pjp2_past      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $past_date))*-1;

        //LIABILITAS JANGKA PANJANG LAINNYA=====================================================================================
        $ljpl_now1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $now_date))*-1;
        $ljpl_last1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $last_date))*-1;
        // $ljpl_past1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $past_date))*-1;
        $gl_1_now      = ($this->m_balance->get_value_gl('25900004', $company, $category, $now_date))*-1;
        $gl_1_last      = ($this->m_balance->get_value_gl('25900004', $company, $category, $last_date))*-1;
        // $gl_1_past      = ($this->m_balance->get_value_gl('25900004', $company, $category, $past_date))*-1;

        $ljpl_now      = $ljpl_now1 - $pjp2_now - $likjp_now - $gl_1_now;
        // echo "$ljpl_now      = $ljpl_now1 - $pjp2_now - $likjp_now - $gl_1_now;";
        $ljpl_last      = $ljpl_last1 - $pjp2_last - $likjp_last - $gl_1_last;
        // $ljpl_past      = $ljpl_past1 - $pjp2_past - $likjp_past - $gl_1_past;

        //JUMLAH LIABILITAS JANGKA PANJANG=====================================================================================================
        $jmlh_ljp_now  = $lpt_now + $likjp_now + $pb2_now + $ppri2_now + $ubdd2_now + $sp2_now + $pjp2_now + $ljpl_now;

        // echo "$jmlh_ljp_now  = $lpt_now + $likjp_now + $pb2_now + $ppri2_now + $ubdd2_now + $sp2_now + $pjp2_now + $ljpl_now;
        // ";
        $jmlh_ljp_last  = $lpt_last + $likjp_last + $pb2_last + $ppri2_last + $ubdd2_last + $sp2_last + $pjp2_last + $ljpl_last;
        // $jmlh_ljp_past  = $lpt_past + $likjp_past + $pb2_past + $ppri2_past + $ubdd2_past + $sp2_past + $pjp2_past + $ljpl_past;

        //JUMLAH LIABILITAS=====================================================================================================
        $liabilitas_now    = $jljp_now + $jmlh_ljp_now;
        $liabilitas_last    = $jljp_last + $jmlh_ljp_last;
        // $liabilitas_past    = $jljp_past + $jmlh_ljp_past;

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
            // 'pjp' => "$pjp_past",
            // 'ba' => "$ba_past",
            //     "up"=> "$up_past",
            //     "pb"=> "$pb_past",
            //     "ppri"=> "$ppri_past",
            //     "sp"=> "$sp_past",
            //     "uu"=> "$uu_past",
            //     "ubdd"=> "$ubdd_past",
            //     "pll"=> "$pll_past",
            //     "ud"=> "$ud_past",
            //     "total_pendek"=> "$jljp_past",
            //     "lpt"=> "$lpt_past",
            //     "pb2"=> "$pb2_past",
            //     "ppri2"=> "$ppri2_past",
            //     "sp2"=> "$sp2_past",
            //     "gl_1"=> "$gl_1_past",
            //     "pjp2"=> "$pjp2_past",
            //     "ubdd2"=> "$ubdd2_past",
            //     "ljp1"=> "$ljpl_past",
            //     "likjp"=> "$likjp_past",
            //     "total_panjang"=> "$ljpl_past",
                // "total_liabilitas"=> "$liabilitas_past"
          );
         $liability['now'] = $liability_now;
         $liability['last'] = $liability_last;
         // $liability['past'] = $liability_past;
      ////-===============
      //equitas
      //
            //MODAL SAHAM============================================================================================
            $ms_now        = ($this->m_balance->get_value_gl('31', $company, $category, $now_date))*-1;
            $ms_last        = ($this->m_balance->get_value_gl('31', $company, $category, $last_date))*-1;
            // $ms_past        = ($this->m_balance->get_value_gl('31', $company, $category, $past_date))*-1;
            
            //TAMBAHAN MODAL DISETOR===================================================================================
            $tmd_now       = ($this->m_balance->get_value_gl('32', $company, $category, $now_date))*-1;
            $tmd_last       = ($this->m_balance->get_value_gl('32', $company, $category, $last_date))*-1;
            // $tmd_past       = ($this->m_balance->get_value_gl('32', $company, $category, $past_date))*-1;
            
            //PENDAPATAN KOMPREHENSIF LAINNYA==========================================================================
            $pkl_now       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $now_date))*-1;
            $pkl_last       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $last_date))*-1;
            // $pkl_past       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $past_date))*-1;
            
            //SALDO LABA==========================================================================================
            $sl_now        = ($this->m_balance->get_value_gl('3411', $company, $category, $now_date))*-1;
            $sl_last        = ($this->m_balance->get_value_gl('3411', $company, $category, $last_date))*-1;
            // $sl_past        = ($this->m_balance->get_value_gl('3411', $company, $category, $past_date))*-1;
            
            //KEPENTINGAN NON PENGENDALI==========================================================================================
            $knp_now       = ($this->m_balance->get_value_gl('37', $company, $category, $now_date))*-1;
            $knp_last       = ($this->m_balance->get_value_gl('37', $company, $category, $last_date))*-1;
            // $knp_past       = ($this->m_balance->get_value_gl('37', $company, $category, $past_date))*-1;
            
            //JUMLAH EKUITAS=====================================================================================================
            $ekuitas_now   = $ms_now + $tmd_now + $pkl_now + $sl_now + $knp_now;
            $ekuitas_last   = $ms_last + $tmd_last + $pkl_last + $sl_last + $knp_last;
            // $ekuitas_past   = $ms_past + $tmd_past + $pkl_past + $sl_past + $knp_past;
            
            //JUMLAH LIABILITAS DAN EKUITAS=====================================================================================================
            $jlde_now      = $liabilitas_now + $ekuitas_now;
            $jlde_last      = $liabilitas_last + $ekuitas_last;
            // $jlde_past      = $liabilitas_past + $ekuitas_past;

            $total_equity_liability['now'] = $jlde_now;
            $total_equity_liability['last'] = $jlde_last;
            // $total_equity_liability['past'] = $jlde_past;
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
              //  "ms"=> "$ms_past",
              // "tmd"=> "$tmd_past",
              // "sl"=> "$sl_past",
              // "knp"=> "$knp_past",
              // "pkl"=> "$pkl_past",
              // "total"=> "$ekuitas_past"
              );

             $ekuitas['now'] = $equity_now;
             $ekuitas['last'] = $equity_last;
             // $ekuitas['past'] = $equity_past;

      ///==============================================================
            //Short Term Finance Position
              //CURRENT RATIO
            $ratio_result = $this->m_balance->ratio($company, $now_date);
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
                $tier = 0;
              //   DEBT EQUITY RATIO
                $debt_equ_rat =  round($total_dta)/100 - round($total_dta);
          
            // POSITION OF BUSINESS ASSET
              //   INVENTORY TURNOVER (DAYS)
                  // $inven_t = (($pers_b_last + $pers_b_now)/2)/cogs*365/12
                  $inven_t = 0;
              //   RECIEVEABLE TURNOVER (DAYS)
                  // ((Piutang_usaha_bersih Bulan Lalu + Piutang_usaha_bersih Bulan Ini)/2) / (- Penjualan * 1.1025) * 30)

                  // $recieve_t = (($p_bersih_last + $p_bersih_now)/2)/ 
                  $recieve_t = 0;
            // POSITION OF RESULT POSITION
              //   R O A 
                  // ( Laba sebelum pajak * 12) / Jumlah  Aset * 100
                  $roa = 0;
                  $roa = round(($this->division($ratio_result['LABA_SEBELUM_PAJAK'],$jmlh_aset_now))*100,2);
              //   R O E 
                  // ( Laba sebelum pajak * 12) / Total Ekuitas * 100
                  $roe = 0;
                  $roe = round(($this->division($ratio_result['LABA_SEBELUM_PAJAK'],$ekuitas_now))*100,2);
              //   COST RATIO '
                  // ( Beban pokok + Beban usaha ) / -Penjualan * 100
                  $cost_rat = 0;
              //   EBITDA MARGIN 
                  // ( Margin EBITDA * 100 )
                  $ebitda_margin = round($ratio_result['MARGIN_EBITDA'],2);
              //   INTEREST COVERAGE RATIO 
                  // ( EBITDA / Beban Keuangan ) * -1
                  $int_cov_rat = 0;

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

    function company_balance(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $company = "('7000','3000','6000','4000')";
      // if ($com!='') {
      //    $company = "('$com')";
      // }

      $arrayCom = array('7000', '4000', '3000', '6000');



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

      foreach ($arrayCom as $key) {
        # code...
        
          $company = "('$key')";
          




          //KAS DAN SETARA KAS===============================================================================
          $kas_now       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $now_date);
          // $kas_last       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $last_date);
          // $kas_past       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $past_date);
          
          //BANK YANG DIBATASI PENGGUNANYA==========================================================================
          $bank_now      = $this->m_balance->get_value_gl('1119', $company, $category, $now_date);
          // $bank_last      = $this->m_balance->get_value_gl('1119', $company, $category, $last_date);
          // $bank_past      = $this->m_balance->get_value_gl('1119', $company, $category, $past_date);
          
          //INVESTASI JANGKA PENDEK===================================================================================
          $invest_now    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $now_date);
          // $invest_last    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $last_date);
          // $invest_past    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $past_date);
          
          //PIUTANG USAHA - BERSIH ====================================================================================
          $p_bersih_now  = $this->m_balance->get_value_gl('114', $company, $category, $now_date);
          // $p_bersih_last  = $this->m_balance->get_value_gl('114', $company, $category, $last_date);
          // $p_bersih_past  = $this->m_balance->get_value_gl('114', $company, $category, $past_date);
          
          //PIUTANG LAIN - LAIN =======================================================================================
          $p_lain_last = 0;
          $p_lain_past = 0;
          if($company == '3000' || $company == '4000'){
              $temp_gl    = array('11510001','11510003','11510098','11510099','11590001');
          }else{
              $temp_gl    = array('11510001','11510003','11510098','11510099','11590001','11910001');
          }
          $p_lain_now    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $now_date);
          // $p_lain_last    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $last_date);
          // $p_lain_past    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $past_date);
          
          //PERSEDIAAN BERSIH==========================================================================================
          $pers_b_now    = $this->m_balance->get_value_gl('116', $company, $category, $now_date);
          // $pers_b_last    = $this->m_balance->get_value_gl('116', $company, $category, $last_date);
          // $pers_b_past    = $this->m_balance->get_value_gl('116', $company, $category, $past_date);
          
          //ASET LANCAR LAINNYA========================================================================================
          if($company == '3000' || $company == '4000'){
              $aset_lain_now     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $now_date);
              // $aset_lain_last     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $last_date);
              // $aset_lain_past     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $past_date);
          }else{

              $aset_lain_now     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $now_date);
              // $aset_lain_last     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $last_date);
              // $aset_lain_past     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $past_date);
          }

          
          //PAJAK DIBAYAR DIMUKA=======================================================================================
          $pdd_now       = $this->m_balance->get_value_gl('117', $company, $category, $now_date);
          // $pdd_last       = $this->m_balance->get_value_gl('117', $company, $category, $last_date);
          // $pdd_past       = $this->m_balance->get_value_gl('117', $company, $category, $past_date);
          
          //JUMLAH ASET LANCAR=========================================================================================
                $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;

          // $jal_last       = $kas_last + $bank_last + $invest_last + $p_bersih_last + $p_lain_last + $pers_b_last + $aset_lain_last + $pdd_last;

          // echo "jal $jal_last       = kas $kas_last + bank $bank_last +inves $invest_last + p berish $p_bersih_last + plain $p_lain_last + pers_b $pers_b_last + aset lain $aset_lain_last + pdd $pdd_last;";
          // $jal_past       = $kas_past + $bank_past + $invest_past + $p_bersih_past + $p_lain_past + $pers_b_past + $aset_lain_past + $pdd_past;
          
          //ASET PAJAK TANGGUHAN======================================================================================
          $apt_now       = $this->m_balance->get_value_gl('131', $company, $category, $now_date);
          // $apt_last       = $this->m_balance->get_value_gl('131', $company, $category, $last_date);
          // $apt_past       = $this->m_balance->get_value_gl('131', $company, $category, $past_date);
          
          //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
          $ipea_now1     = $this->m_balance->get_value_gl('141', $company, $category, $now_date);
          $ipea_now2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $now_date);
          $ipea_now      = $ipea_now1 - $ipea_now2;

          // $ipea_last1     = $this->m_balance->get_value_gl('141', $company, $category, $last_date);
          // $ipea_last2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $last_date);
          // $ipea_last      = $ipea_last1 - $ipea_last2;
          
          // $ipea_past1     = $this->m_balance->get_value_gl('141', $company, $category, $past_date);
          // $ipea_past2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $past_date);
          // $ipea_past      = $ipea_past1 - $ipea_past2;
          
          //PROPERTI INVESTASI=======================================================================================
          $pi_now        = $this->m_balance->get_value_gl('151', $company, $category, $now_date);
          // $pi_last        = $this->m_balance->get_value_gl('151', $company, $category, $last_date);
          // $pi_past        = $this->m_balance->get_value_gl('151', $company, $category, $past_date);
          
          //TANAH====================================================================================================
          $tanah_now     = $this->m_balance->get_value_gl('1611', $company, $category, $now_date);
          // $tanah_last     = $this->m_balance->get_value_gl('1611', $company, $category, $last_date);
          // $tanah_past     = $this->m_balance->get_value_gl('1611', $company, $category, $past_date);
          
          //BANGUNAN=================================================================================================
          $bangunan_now  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $now_date);
          // $bangunan_last  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $last_date);
          // $bangunan_past  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $past_date);
          
          //MESIN DAN PERALATAN======================================================================================
          $mesin_now     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $now_date);
          // $mesin_last     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $last_date);
          // $mesin_past     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $past_date);
          
          //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
          $alat2_now     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $now_date);
          // $alat2_last     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $last_date);
          // $alat2_past     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $past_date);
          
          //PERLENGKAPAN=================================================================================================
          $perl_now      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $now_date);
          // $perl_last      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $last_date);
          // $perl_past      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $past_date);
          
          //TOTAL 1=================================================================================================
          $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;

          // $total_last1    = $tanah_last + $bangunan_last + $mesin_last + $alat2_last + $perl_last;
          // $total_past1    = $tanah_past + $bangunan_past + $mesin_past + $alat2_past + $perl_past;
          
          //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
          $akum_now      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $now_date);
          // $akum_last      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $last_date);
          // $akum_past      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $past_date);
          
          //TOTAL 2=================================================================================================
          $total_now2    = $total_now1 + $akum_now;
          // $total_last2    = $total_last1 + $akum_last;
          // $total_past2    = $total_past1 + $akum_past;
          
          //PEKERJAAN DALAM PELAKSANAAN=============================================================================
          $pdp_now       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $now_date);
          // $pdp_last       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $last_date);
          // $pdp_past       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $past_date);
          
          //TOTAL ASET TETAP========================================================================================
          $total_at_now  = $total_now2 + $pdp_now;
          // $total_at_last  = $total_last2 + $pdp_last;
          // $total_at_past  = $total_past2 + $pdp_past;
          
          //UANG MUKA PROYEK========================================================================================
          $ump_now       = $this->m_balance->get_value_gl('185', $company, $category, $now_date);
          // $ump_last       = $this->m_balance->get_value_gl('185', $company, $category, $last_date);
          // $ump_past       = $this->m_balance->get_value_gl('185', $company, $category, $past_date);
          
          //BEBAN TANGGUHAN - BERSIH=================================================================================
          $btb_now       = $this->m_balance->get_value_gl('181', $company, $category, $now_date);
          // $btb_last       = $this->m_balance->get_value_gl('181', $company, $category, $last_date);
          // $btb_past       = $this->m_balance->get_value_gl('181', $company, $category, $past_date);
          
          //ASET TAK BERWUJUD=======================================================================================
          $atb_now       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $now_date);
          // $atb_last       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $last_date);
          // $atb_past       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $past_date);
          
          //ASET TIDAK LANCAR LAINNYA===============================================================================
          $atll_now      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $now_date);
          // $atll_last      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $last_date);
          // $atll_past      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $past_date);
          
          //JUMLAH ASET TIDAK LANCAR========================================================================================
          $total_atl_now = $apt_now + $ipea_now + $pi_now + $total_at_now + $ump_now + $btb_now + $atb_now + $atll_now;
          // $total_atl_last = $apt_last + $ipea_last + $pi_last + $total_at_last + $ump_last + $btb_last + $atb_last + $atll_last;
          // $total_atl_past = $apt_past + $ipea_past + $pi_past + $total_at_past + $ump_past + $btb_past + $atb_past + $atll_past;
          
          //JUMLAH ASET=====================================================================================================
          $jmlh_aset_now = $total_atl_now + $jal_now;
          // $jmlh_aset_last = $total_atl_last + $jal_last;
          // $jmlh_aset_past = $total_atl_past + $jal_past;

        //last=================================================
        $now[$key] = array(
            // 'kas' => "$kas_now",
            // 'bank'=> "$bank_now",
            // 'invest' => "$invest_now",
            // 'p_bersih' => "$p_bersih_now",
            // 'p_lain' => "$p_lain_now",
            // 'pers_b' => "$pers_b_now",
            // 'aset_lain' => "$aset_lain_now",
            // 'pdd' => "$pdd_now",
            // 'jal' => "$jal_now", //jumlah aset lancar
            // 'apt' => "$apt_now",
            // 'ipea'=> "$ipea_now",
            // 'pi' => "$pi_now",
            // 'tanah' => "$tanah_now",
            // 'bangunan' => "$bangunan_now",
            // 'mesin' => "$mesin_now",
            // 'alat2' => "$alat2_now",
            // 'perl' => "$perl_now",
            // 'total1' => "$total_now1",
            // 'akum' => "$akum_now",
            // 'total2' => "$total_now2",
            // 'pdp' => "$pdp_now",
            // 'total_at' => "$total_at_now",
            // 'ump' => "$ump_now",
            // 'btb' => "$btb_now",
            // 'atb' => "$atb_now",
            // 'atll' => "$atll_now",
            // 'total_atl' => "$total_atl_now",
            'jmlh_aset' => "$jmlh_aset_now"
          );
        $last = array(
          // 'kas' => "$kas_last",
          // 'bank'=> "$bank_last",
          // 'invest' => "$invest_last",
          // 'p_bersih' => "$p_bersih_last",
          // 'p_lain' => "$p_lain_last",
          // 'pers_b' => "$pers_b_last",
          // 'aset_lain' => "$aset_lain_last",
          // 'pdd' => "$pdd_last",
          // 'jal' => "$jal_last", //jumlah aset lancar
          // 'apt' => "$apt_last",
          // 'ipea'=> "$ipea_last",
          // 'pi' => "$pi_last",
          // 'tanah' => "$tanah_last",
          // 'bangunan' => "$bangunan_last",
          // 'mesin' => "$mesin_last",
          // 'alat2' => "$alat2_last",
          // 'perl' => "$perl_last",
          // 'total1' => "$total_last1",
          // 'akum' => "$akum_last",
          // 'total2' => "$total_last2",
          // 'pdp' => "$pdp_last",
          // 'total_at' => "$total_at_last",
          // 'ump' => "$ump_last",
          // 'btb' => "$btb_last",
          // 'atb' => "$atb_last",
          // 'atll' => "$atll_last",
          // 'total_atl' => "$total_atl_last",
          // 'jmlh_aset' => "$jmlh_aset_last"
        );
         $past = array(
            // 'kas' => "$kas_past",
            // 'bank'=> "$bank_past",
            // 'invest' => "$invest_past",
            // 'p_bersih' => "$p_bersih_past",
            // 'p_lain' => "$p_lain_past",
            // 'pers_b' => "$pers_b_past",
            // 'aset_lain' => "$aset_lain_past",
            // 'pdd' => "$pdd_past",
            // 'jal' => "$jal_past",
            // 'apt' => "$apt_past",
            // 'ipea'=> "$ipea_past",
            // 'pi' => "$pi_past",
            // 'tanah' => "$tanah_past",
            // 'bangunan' => "$bangunan_past",
            // 'mesin' => "$mesin_past",
            // 'alat2' => "$alat2_past",
            // 'perl' => "$perl_past",
            // 'total1' => "$total_past1",
            // 'akum' => "$akum_past",
            // 'total2' => "$total_past2",
            // 'pdp' => "$pdp_past",
            // 'total_at' => "$total_at_past",
            // 'ump' => "$ump_past",
            // 'btb' => "$btb_past",
            // 'atb' => "$atb_past",
            // 'atll' => "$atll_past",
            // 'total_atl' => "$total_atl_past",
            // 'jmlh_aset' => "$jmlh_aset_past"
        );
        $asset['now'] = $now;
        // $asset['last'] = $last;
        // $asset['past'] = $past;
          //====================================
          //TABEL SEBELAH KANAN==================
          //liability
            //PINJAMAN JANGKA PENDEK===================================================================================
            $pjp_now       = $this->m_balance->get_value_gl('211', $company, $category, $now_date);
            // $pjp_last       = $this->m_balance->get_value_gl('211', $company, $category, $last_date);
            // $pjp_past       = $this->m_balance->get_value_gl('211', $company, $category, $past_date);

            //UTANG USAHA==============================================================================================
            $uu_now        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $now_date))*-1;
            // $uu_last        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $last_date))*-1;
            // $uu_past        = ($this->m_balance->plus_like_gl('212', '213', $company, $category, $past_date))*-1;

            //UTANG LAIN - LAIN==========================================================================================
            $pll_now       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
            // $pll_last       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
            // $pll_past       = ($this->m_balance->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

            //BEBAN AKRUAL============================================================================================
            $ba_now        = ($this->m_balance->get_value_gl('216', $company, $category, $now_date))*-1;
            // $ba_last        = ($this->m_balance->get_value_gl('216', $company, $category, $last_date))*-1;
            // $ba_past        = ($this->m_balance->get_value_gl('216', $company, $category, $past_date))*-1;

            //UTANG PAJAK============================================================================================
            $up_now        = ($this->m_balance->get_value_gl('215', $company, $category, $now_date))*-1;
            // $up_last        = ($this->m_balance->get_value_gl('215', $company, $category, $last_date))*-1;
            // $up_past        = ($this->m_balance->get_value_gl('215', $company, $category, $past_date))*-1;

            //UTANG DEVIDEN==========================================================================================
            $ud_now        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $now_date))*-1;
            // $ud_last        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
            // $ud_past        = ($this->m_balance->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

            //PINJAMAN BANK============================================================================================
            $pb_now        = ($this->m_balance->get_value_gl('2171', $company, $category, $now_date))*-1;
            // $pb_last        = ($this->m_balance->get_value_gl('2171', $company, $category, $last_date))*-1;
            // $pb_past        = ($this->m_balance->get_value_gl('2171', $company, $category, $past_date))*-1;

            //PINJAMAN PEMERINTAH RI============================================================================================
            $ppri_now      = ($this->m_balance->get_value_gl('2172', $company, $category, $now_date))*-1;
            // $ppri_last      = ($this->m_balance->get_value_gl('2172', $company, $category, $last_date))*-1;
            // $ppri_past      = ($this->m_balance->get_value_gl('2172', $company, $category, $past_date))*-1;

            //UTANG BUNGA DAN DENDA==============================================================================================
            $ubdd_now      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
            // $ubdd_last      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
            // $ubdd_past      = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

            //SEWA PEMBIAYAAN============================================================================================
            $sp_now        = ($this->m_balance->get_value_gl('2176', $company, $category, $now_date))*-1;
            // $sp_last        = ($this->m_balance->get_value_gl('2176', $company, $category, $last_date))*-1;
            // $sp_past        = ($this->m_balance->get_value_gl('2176', $company, $category, $past_date))*-1;

            //JUMLAH LIABILITAS JANGKA PENDEK==========================================================================
            $jljp_now      = $pjp_now + $uu_now + $pll_now + $ba_now + $up_now + $ud_now + $pb_now + $ppri_now + $ubdd_now + $sp_now;
            // $jljp_last      = $pjp_last + $uu_last + $pll_last + $ba_last + $up_last + $ud_last + $pb_last + $ppri_last + $ubdd_last + $sp_last;
            // $jljp_past      = $pjp_past + $uu_past + $pll_past + $ba_past + $up_past + $ud_past + $pb_past + $ppri_past + $ubdd_past + $sp_past;

            //LIABILITAS PAJAK TANGGUHAN============================================================================================
            $lpt_now       = ($this->m_balance->get_value_gl('23', $company, $category, $now_date))*-1;
            // $lpt_last       = ($this->m_balance->get_value_gl('23', $company, $category, $last_date))*-1;
            // $lpt_past       = ($this->m_balance->get_value_gl('23', $company, $category, $past_date))*-1;

            //LIABILITAS IMBALAN KERJA JANGKA PANJANG==========================================================================================
            $likjp_now     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $now_date))*-1;
            // $likjp_last     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $last_date))*-1;
            // $likjp_past     = ($this->m_balance->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $past_date))*-1;

            //PINJAMAN BANK 2============================================================================================
            $pb2_now       = ($this->m_balance->get_value_gl('251', $company, $category, $now_date))*-1;
            // $pb2_last       = ($this->m_balance->get_value_gl('251', $company, $category, $last_date))*-1;
            // $pb2_past       = ($this->m_balance->get_value_gl('251', $company, $category, $past_date))*-1;

            //PINJAMAN PEMERINTAH RI 2============================================================================================
            $ppri2_now     = ($this->m_balance->get_value_gl('252', $company, $category, $now_date))*-1;
            // $ppri2_last     = ($this->m_balance->get_value_gl('252', $company, $category, $last_date))*-1;
            // $ppri2_past     = ($this->m_balance->get_value_gl('252', $company, $category, $past_date))*-1;

            //UTANG BUNGA DAN DENDA============================================================================================
            $ubdd2_now     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $now_date))*-1;
            // $ubdd2_last     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
            // $ubdd2_past     = ($this->m_balance->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

            //SEWA PEMBIAYAAN============================================================================================
            $sp2_now       = ($this->m_balance->get_value_gl('256', $company, $category, $now_date))*-1;
            // $sp2_last       = ($this->m_balance->get_value_gl('256', $company, $category, $last_date))*-1;
            // $sp2_past       = ($this->m_balance->get_value_gl('256', $company, $category, $past_date))*-1;

            //PROVISI JANGKA PANJANG==============================================================================================
            $pjp2_now      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $now_date))*-1;
            // $pjp2_last      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $last_date))*-1;
            // $pjp2_past      = ($this->m_balance->plus_like_gl('25900005', '25900009', $company, $category, $past_date))*-1;

            //LIABILITAS JANGKA PANJANG LAINNYA=====================================================================================
            $ljpl_now1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $now_date))*-1;
            // $ljpl_last1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $last_date))*-1;
            // $ljpl_past1     = ($this->m_balance->plus_like_gl3('253', '254', '259', $company, $category, $past_date))*-1;
            $gl_1_now      = ($this->m_balance->get_value_gl('25900004', $company, $category, $now_date))*-1;
            // $gl_1_last      = ($this->m_balance->get_value_gl('25900004', $company, $category, $last_date))*-1;
            // $gl_1_past      = ($this->m_balance->get_value_gl('25900004', $company, $category, $past_date))*-1;

            $ljpl_now      = $ljpl_now1 - $pjp2_now - $likjp_now - $gl_1_now;
            // $ljpl_last      = $ljpl_last1 - $pjp2_last - $likjp_last - $gl_1_last;
            // $ljpl_past      = $ljpl_past1 - $pjp2_past - $likjp_past - $gl_1_past;

            //JUMLAH LIABILITAS JANGKA PANJANG=====================================================================================================
            $jmlh_ljp_now  = $lpt_now + $likjp_now + $pb2_now + $ppri2_now + $ubdd2_now + $sp2_now + $pjp2_now + $ljpl_now;
            // $jmlh_ljp_last  = $lpt_last + $likjp_last + $pb2_last + $ppri2_last + $ubdd2_last + $sp2_last + $pjp2_last + $ljpl_last;
            // $jmlh_ljp_past  = $lpt_past + $likjp_past + $pb2_past + $ppri2_past + $ubdd2_past + $sp2_past + $pjp2_past + $ljpl_past;

            //JUMLAH LIABILITAS=====================================================================================================
            $liabilitas_now    = $jljp_now + $jmlh_ljp_now;
            // $liabilitas_last    = $jljp_last + $jmlh_ljp_last;
            // $liabilitas_past    = $jljp_past + $jmlh_ljp_past;

        $liability_now[$key] = array(
                // 'pjp' => "$pjp_now",
                // 'ba' => "$ba_now",
                //     "up"=> "$up_now",
                //     "pb"=> "$pb_now",
                //     "ppri"=> "$ppri_now",
                //     "sp"=> "$sp_now",
                //     "uu"=> "$uu_now",
                //     "ubdd"=> "$ubdd_now",
                //     "pll"=> "$pll_now",
                //     "ud"=> "$ud_now",
                //     "total_pendek"=> "$jljp_now",
                //     "lpt"=> "$lpt_now",
                //     "pb2"=> "$pb2_now",
                //     "ppri2"=> "$ppri2_now",
                //     "sp2"=> "$sp2_now",
                //     "gl_1"=> "$gl_1_now",
                //     "pjp2"=> "$pjp2_now",
                //     "ubdd2"=> "$ubdd2_now",
                //     "ljp1"=> "$ljpl_now",
                //     "likjp"=> "$likjp_now",
                //     "total_panjang"=> "$ljpl_now",
                    "total_liabilitas"=> "$liabilitas_now"
              );
            $liability_last = array(
                // 'pjp' => "$pjp_last",
                // 'ba' => "$ba_last",
                //     "up"=> "$up_last",
                //     "pb"=> "$pb_last",
                //     "ppri"=> "$ppri_last",
                //     "sp"=> "$sp_last",
                //     "uu"=> "$uu_last",
                //     "ubdd"=> "$ubdd_last",
                //     "pll"=> "$pll_last",
                //     "ud"=> "$ud_last",
                //     "total_pendek"=> "$jljp_last",
                //     "lpt"=> "$lpt_last",
                //     "pb2"=> "$pb2_last",
                //     "ppri2"=> "$ppri2_last",
                //     "sp2"=> "$sp2_last",
                //     "gl_1"=> "$gl_1_last",
                //     "pjp2"=> "$pjp2_last",
                //     "ubdd2"=> "$ubdd2_last",
                //     "ljp1"=> "$ljpl_last",
                //     "likjp"=> "$likjp_last",
                //     "total_panjang"=> "$ljpl_last",
                    // "total_liabilitas"=> "$liabilitas_last"
              );
             $liability_past = array(
                // 'pjp' => "$pjp_past",
                // 'ba' => "$ba_past",
                //     "up"=> "$up_past",
                //     "pb"=> "$pb_past",
                //     "ppri"=> "$ppri_past",
                //     "sp"=> "$sp_past",
                //     "uu"=> "$uu_past",
                //     "ubdd"=> "$ubdd_past",
                //     "pll"=> "$pll_past",
                //     "ud"=> "$ud_past",
                //     "total_pendek"=> "$jljp_past",
                //     "lpt"=> "$lpt_past",
                //     "pb2"=> "$pb2_past",
                //     "ppri2"=> "$ppri2_past",
                //     "sp2"=> "$sp2_past",
                //     "gl_1"=> "$gl_1_past",
                //     "pjp2"=> "$pjp2_past",
                //     "ubdd2"=> "$ubdd2_past",
                //     "ljp1"=> "$ljpl_past",
                //     "likjp"=> "$likjp_past",
                //     "total_panjang"=> "$ljpl_past",
                    // "total_liabilitas"=> "$liabilitas_past"
              );
             $liability['now'] = $liability_now;
             // $liability['last'] = $liability_last;
             // $liability['past'] = $liability_past;
          ////-===============
          //equitas
          //
                //MODAL SAHAM============================================================================================
                $ms_now        = ($this->m_balance->get_value_gl('31', $company, $category, $now_date))*-1;
                // $ms_last        = ($this->m_balance->get_value_gl('31', $company, $category, $last_date))*-1;
                // $ms_past        = ($this->m_balance->get_value_gl('31', $company, $category, $past_date))*-1;
                
                //TAMBAHAN MODAL DISETOR===================================================================================
                $tmd_now       = ($this->m_balance->get_value_gl('32', $company, $category, $now_date))*-1;
                // $tmd_last       = ($this->m_balance->get_value_gl('32', $company, $category, $last_date))*-1;
                // $tmd_past       = ($this->m_balance->get_value_gl('32', $company, $category, $past_date))*-1;
                
                //PENDAPATAN KOMPREHENSIF LAINNYA==========================================================================
                $pkl_now       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $now_date))*-1;
                // $pkl_last       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $last_date))*-1;
                // $pkl_past       = ($this->m_balance->plus_like_gl3('390', '331', '332', $company, $category, $past_date))*-1;
                
                //SALDO LABA==========================================================================================
                $sl_now        = ($this->m_balance->get_value_gl('3411', $company, $category, $now_date))*-1;
                // $sl_last        = ($this->m_balance->get_value_gl('3411', $company, $category, $last_date))*-1;
                // $sl_past        = ($this->m_balance->get_value_gl('3411', $company, $category, $past_date))*-1;
                
                //KEPENTINGAN NON PENGENDALI==========================================================================================
                $knp_now       = ($this->m_balance->get_value_gl('37', $company, $category, $now_date))*-1;
                // $knp_last       = ($this->m_balance->get_value_gl('37', $company, $category, $last_date))*-1;
                // $knp_past       = ($this->m_balance->get_value_gl('37', $company, $category, $past_date))*-1;
                
                //JUMLAH EKUITAS=====================================================================================================
                $ekuitas_now   = $ms_now + $tmd_now + $pkl_now + $sl_now + $knp_now;
                // $ekuitas_last   = $ms_last + $tmd_last + $pkl_last + $sl_last + $knp_last;
                // $ekuitas_past   = $ms_past + $tmd_past + $pkl_past + $sl_past + $knp_past;
                
                //JUMLAH LIABILITAS DAN EKUITAS=====================================================================================================
                $jlde_now      = $liabilitas_now + $ekuitas_now;
                // $jlde_last      = $liabilitas_last + $ekuitas_last;
                // $jlde_past      = $liabilitas_past + $ekuitas_past;

                $total_equity_liability['now'] = $jlde_now;
                // $total_equity_liability['last'] = $jlde_last;
                // $total_equity_liability['past'] = $jlde_past;
                $equity_now[$key] = array(
                  //  "ms"=> "$ms_now",
                  // "tmd"=> "$tmd_now",
                  // "sl"=> "$sl_now",
                  // "knp"=> "$knp_now",
                  // "pkl"=> "$pkl_now",
                  "total"=> "$ekuitas_now"
                  );
                $equity_last = array(
                  //  "ms"=> "$ms_last",
                  // "tmd"=> "$tmd_last",
                  // "sl"=> "$sl_last",
                  // "knp"=> "$knp_last",
                  // "pkl"=> "$pkl_last",
                  // "total"=> "$ekuitas_last"
                  );
                 $equity_past = array(
                  //  "ms"=> "$ms_past",
                  // "tmd"=> "$tmd_past",
                  // "sl"=> "$sl_past",
                  // "knp"=> "$knp_past",
                  // "pkl"=> "$pkl_past",
                  // "total"=> "$ekuitas_past"
                  );

                 $ekuitas['now'] = $equity_now;
                 // $ekuitas['last'] = $equity_last;
                 // $ekuitas['past'] = $equity_past;
      }



      $test = array();
      $test['equity'] = $ekuitas;
      $test['liability'] = $liability;
      // $test['total_liability_equity'] = $total_equity_liability;
      $test['asset'] = $asset;

      echo json_encode($test);


     

      // echo "$com -> $date_now -> $date_last -> $date_past";
    }

    function monthly(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? 'SMI' : $_GET['company']);
      $paramCompany = "('7000','3000','6000','4000')";
      if ($com!='SMI') {
         $paramCompany = "('$com')";

         if ($com == '7000') {
            # code...
            $paramCompany = "('$com', '2000')";
          }
      }

      

      $last_year = $year-1;
      $month = (int) $month;
      $asset = array();

      $past_date = "$last_year.12";

      $asset[$com][$past_date] = $this->asset_monthly($past_date, $paramCompany);

      for ($i=1; $i <= $month; $i++) { 
        # code...

        $selected = substr(('0'.$i), -2);
        $date_now = "$year.$selected";
        $asset[$com][$date_now] = $this->asset_monthly($date_now, $paramCompany);
        
      }

      echo json_encode($asset);

    }

    function asset_monthly($now_date, $company){
      $category = 'ACT';

      //KAS DAN SETARA KAS===============================================================================
      $kas_now       = $this->m_balance->min_like_gl('111', '1119', $company, $category, $now_date);
      
      //BANK YANG DIBATASI PENGGUNANYA==========================================================================
      $bank_now      = $this->m_balance->get_value_gl('1119', $company, $category, $now_date);
      
      //INVESTASI JANGKA PENDEK===================================================================================
      $invest_now    = $this->m_balance->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $now_date);
      
      //PIUTANG USAHA - BERSIH ====================================================================================
      $p_bersih_now  = $this->m_balance->get_value_gl('114', $company, $category, $now_date);
      
      //PIUTANG LAIN - LAIN =======================================================================================
      $p_lain_last = 0;
      $p_lain_past = 0;
      if($company == '3000' || $company == '4000'){
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001');
      }else{
          $temp_gl    = array('11510001','11510003','11510098','11510099','11590001','11910001');
      }
      $p_lain_now    = $this->m_balance->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $now_date);
      
      //PERSEDIAAN BERSIH==========================================================================================
      $pers_b_now    = $this->m_balance->get_value_gl('116', $company, $category, $now_date);
      
      //ASET LANCAR LAINNYA========================================================================================
      if($company == '3000' || $company == '4000'){
          $aset_lain_now     = $this->m_balance->plus_like_gl3('118', '1210', '11910001', $company, $category, $now_date);
      }else{

          $aset_lain_now     = $this->m_balance->plus_like_gl('118', '1210', $company, $category, $now_date);
      }

      
      //PAJAK DIBAYAR DIMUKA=======================================================================================
      $pdd_now       = $this->m_balance->get_value_gl('117', $company, $category, $now_date);
      
      //JUMLAH ASET LANCAR=========================================================================================
      $jal_now       = $kas_now + $bank_now + $invest_now + $p_bersih_now + $p_lain_now + $pers_b_now + $aset_lain_now + $pdd_now;

      //ASET PAJAK TANGGUHAN======================================================================================
      $apt_now       = $this->m_balance->get_value_gl('131', $company, $category, $now_date);
      
      //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
      $ipea_now1     = $this->m_balance->get_value_gl('141', $company, $category, $now_date);
      $ipea_now2     = $this->m_balance->plus_like_gl('14120003', '14120005', $company, $category, $now_date);
      $ipea_now      = $ipea_now1 - $ipea_now2;

      //PROPERTI INVESTASI=======================================================================================
      $pi_now        = $this->m_balance->get_value_gl('151', $company, $category, $now_date);
      //TANAH====================================================================================================
      $tanah_now     = $this->m_balance->get_value_gl('1611', $company, $category, $now_date);
      //BANGUNAN=================================================================================================
      $bangunan_now  = $this->m_balance->plus_like_gl('1612', '16210001', $company, $category, $now_date);
      //MESIN DAN PERALATAN======================================================================================
      $mesin_now     = $this->m_balance->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $now_date);
      //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
      $alat2_now     = $this->m_balance->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $now_date);
      //PERLENGKAPAN=================================================================================================
      $perl_now      = $this->m_balance->plus_like_gl('1615', '16210005', $company, $category, $now_date);
      //TOTAL 1=================================================================================================
      $total_now1    = $tanah_now + $bangunan_now + $mesin_now + $alat2_now + $perl_now;
      
      //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
      $akum_now      = $this->m_balance->plus_like_gl('163', '164', $company, $category, $now_date);
      //TOTAL 2=================================================================================================
      $total_now2    = $total_now1 + $akum_now;
      //PEKERJAAN DALAM PELAKSANAAN=============================================================================
      $pdp_now       = $this->m_balance->plus_like_gl('169', '1617', $company, $category, $now_date);
      //TOTAL ASET TETAP========================================================================================
      $total_at_now  = $total_now2 + $pdp_now;
      //UANG MUKA PROYEK========================================================================================
      $ump_now       = $this->m_balance->get_value_gl('185', $company, $category, $now_date);
      //BEBAN TANGGUHAN - BERSIH=================================================================================
      $btb_now       = $this->m_balance->get_value_gl('181', $company, $category, $now_date);
      //ASET TAK BERWUJUD=======================================================================================
      $atb_now       = $this->m_balance->plus_like_gl('171', '172', $company, $category, $now_date);
      //ASET TIDAK LANCAR LAINNYA===============================================================================
      $atll_now      = $this->m_balance->plus_like_gl4('182', '183', '184', '189', $company, $category, $now_date);
      //JUMLAH ASET TIDAK LANCAR========================================================================================
      $total_atl_now = $apt_now + $ipea_now + $pi_now + $total_at_now + $ump_now + $btb_now + $atb_now + $atll_now;
      //JUMLAH ASET=====================================================================================================
      $jmlh_aset_now = $total_atl_now + $jal_now;


    return $jmlh_aset_now;
    }


    function s(){
        $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $com = (empty($_GET['company']) ? 'SMI' : $_GET['company']);
        $paramCompany = "('7000','3000','6000','4000')";
        if ($com!='SMI') {
           $paramCompany = "('$com')";
        }
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

        $result = $this->m_balance->get_allBy($now_date, $last_date, $past_date, $paramCompany);

        echo json_encode($result);
        foreach ($result as $key => $value) {
          # code...
          // echo "$key -> $value <br>";
        }

    }

    function division($value1, $value2){
        if ($value2==0) {
          return null;
        }
        return ( (float) $value1 / (float) $value2 );
    }

    function test(){
        $kas_now       = $this->m_balance->getOneQuery();

        echo "$kas_now";
    }

    function test_ratio(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? 'SMI' : $_GET['company']);
      $paramCompany = "('7000','3000','6000','4000')";
      if ($com!='SMI') {
         $paramCompany = "('$com')";

         if ($com == '7000') {
            # code...
            $paramCompany = "('$com', '2000')";
          }
      }
        $now_date = "$year.$month";
      $now      = $this->m_balance->ratio($paramCompany, $now_date);

        echo json_encode($now);
    }
    
    
}