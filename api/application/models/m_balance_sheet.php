<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_balance_sheet extends CI_Model {

	public function get_balance_sheet()
	{
		// if ($_GET['company']) {
	$company = $_GET['company'];
// }else {
// 	$company = '7000';
// }


$date = array('past' => '2015.12','last' => '2016.05');

// if ($_GET['tahun']&&$_GET['bulan']) {
	$tahun = $_GET['tahun'];
	$bulan = $_GET['bulan'];
	$last_date = "$tahun.$bulan";
// }else{
// 	$last_date = $date['last'];
// }
$past_date = $date['past'];


// echo "$past_date - $last_date company $company";

// $company = '2000';
$category = 'ACT';

$asset = array();
$liability = array();
$ekuitas = array();

	//=======================================================
	//asset==================================================
	//========================================================
	
	

        //KAS DAN SETARA KAS===============================================================================
        $kas_last       = $this->min_like_gl('111', '1119', $company, $category, $last_date);
        $kas_past       = $this->min_like_gl('111', '1119', $company, $category, $past_date);
        
        //BANK YANG DIBATASI PENGGUNANYA==========================================================================
        $bank_last      = $this->get_value_gl('1119', $company, $category, $last_date);
        $bank_past      = $this->get_value_gl('1119', $company, $category, $past_date);
        
        //INVESTASI JANGKA PENDEK===================================================================================
        $invest_last    = $this->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $last_date);
        $invest_past    = $this->in_gl(array('11200000', '14210000', '14120003', '14120005'), $company, $category, $past_date);
        
        //PIUTANG USAHA - BERSIH ====================================================================================
        $p_bersih_last  = $this->get_value_gl('114', $company, $category, $last_date);
        $p_bersih_past  = $this->get_value_gl('114', $company, $category, $past_date);
        
        //PIUTANG LAIN - LAIN =======================================================================================
        $p_lain_last = 0;
        $p_lain_past = 0;
        if($company == '3000' || $company == '4000'){
            $temp_gl    = array('11510001','11510003','11510098','11510099','11590001');
        }else{
            $temp_gl    = array('11510001','11510003','11510098','11510099','11590001','11910001');
        }
        $p_lain_last    = $this->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $last_date);
        $p_lain_past    = $this->plus_gl5_in('1152', '1154', '1155', '1156', '1157', $temp_gl, $company, $category, $past_date);
        
        //PERSEDIAAN BERSIH==========================================================================================
        $pers_b_last    = $this->get_value_gl('116', $company, $category, $last_date);
        $pers_b_past    = $this->get_value_gl('116', $company, $category, $past_date);
        
        //ASET LANCAR LAINNYA========================================================================================
        if($company == '3000' || $company == '4000'){
            $aset_lain_last     = $this->plus_like_gl3('118', '1210', '11910001', $company, $category, $last_date);
            $aset_lain_past     = $this->plus_like_gl3('118', '1210', '11910001', $company, $category, $past_date);
        }else{

            $aset_lain_last     = $this->plus_like_gl('118', '1210', $company, $category, $last_date);
            $aset_lain_past     = $this->plus_like_gl('118', '1210', $company, $category, $past_date);
        }

        
        //PAJAK DIBAYAR DIMUKA=======================================================================================
        $pdd_last       = $this->get_value_gl('117', $company, $category, $last_date);
        $pdd_past       = $this->get_value_gl('117', $company, $category, $past_date);
        
        //JUMLAH ASET LANCAR=========================================================================================
        $jal_last       = $kas_last + $bank_last + $invest_last + $p_bersih_last + $p_lain_last + $pers_b_last + $aset_lain_last + $pdd_last;

        // echo "jal $jal_last       = kas $kas_last + bank $bank_last +inves $invest_last + p berish $p_bersih_last + plain $p_lain_last + pers_b $pers_b_last + aset lain $aset_lain_last + pdd $pdd_last;";
        $jal_past       = $kas_past + $bank_past + $invest_past + $p_bersih_past + $p_lain_past + $pers_b_past + $aset_lain_past + $pdd_past;
        
        //ASET PAJAK TANGGUHAN======================================================================================
        $apt_last       = $this->get_value_gl('131', $company, $category, $last_date);
        $apt_past       = $this->get_value_gl('131', $company, $category, $past_date);
        
        //INVESTASI PADA ENTITAS ASOSIASI===========================================================================
        
        $ipea_last1     = $this->get_value_gl('141', $company, $category, $last_date);
        $ipea_last2     = $this->plus_like_gl('14120003', '14120005', $company, $category, $last_date);
        $ipea_last      = $ipea_last1 - $ipea_last2;
        
        $ipea_past1     = $this->get_value_gl('141', $company, $category, $past_date);
        $ipea_past2     = $this->plus_like_gl('14120003', '14120005', $company, $category, $past_date);
        $ipea_past      = $ipea_past1 - $ipea_past2;
        
        //PROPERTI INVESTASI=======================================================================================
        $pi_last        = $this->get_value_gl('151', $company, $category, $last_date);
        $pi_past        = $this->get_value_gl('151', $company, $category, $past_date);
        
        //TANAH====================================================================================================
        $tanah_last     = $this->get_value_gl('1611', $company, $category, $last_date);
        $tanah_past     = $this->get_value_gl('1611', $company, $category, $past_date);
        
        //BANGUNAN=================================================================================================
        $bangunan_last  = $this->plus_like_gl('1612', '16210001', $company, $category, $last_date);
        $bangunan_past  = $this->plus_like_gl('1612', '16210001', $company, $category, $past_date);
        
        //MESIN DAN PERALATAN======================================================================================
        $mesin_last     = $this->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $last_date);
        $mesin_past     = $this->plus_like_gl4('1613', '16210002', '1622', '1623', $company, $category, $past_date);
        
        //ALAT - ALAT BERAT DAN KENDARAAN===========================================================================
        $alat2_last     = $this->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $last_date);
        $alat2_past     = $this->plus_like_gl4('1614', '16210003', '16210004', '16210006', $company, $category, $past_date);
        
        //PERLENGKAPAN=================================================================================================
        $perl_last      = $this->plus_like_gl('1615', '16210005', $company, $category, $last_date);
        $perl_past      = $this->plus_like_gl('1615', '16210005', $company, $category, $past_date);
        
        //TOTAL 1=================================================================================================
        $total_last1    = $tanah_last + $bangunan_last + $mesin_last + $alat2_last + $perl_last;
        $total_past1    = $tanah_past + $bangunan_past + $mesin_past + $alat2_past + $perl_past;
        
        //AKUMULASI PENYUSUTAN DAN DEPLESI========================================================================
        $akum_last      = $this->plus_like_gl('163', '164', $company, $category, $last_date);
        $akum_past      = $this->plus_like_gl('163', '164', $company, $category, $past_date);
        
        //TOTAL 2=================================================================================================
        $total_last2    = $total_last1 + $akum_last;
        $total_past2    = $total_past1 + $akum_past;
        
        //PEKERJAAN DALAM PELAKSANAAN=============================================================================
        $pdp_last       = $this->plus_like_gl('169', '1617', $company, $category, $last_date);
        $pdp_past       = $this->plus_like_gl('169', '1617', $company, $category, $past_date);
        
        //TOTAL ASET TETAP========================================================================================
        $total_at_last  = $total_last2 + $pdp_last;
        $total_at_past  = $total_past2 + $pdp_past;
        
        //UANG MUKA PROYEK========================================================================================
        $ump_last       = $this->get_value_gl('185', $company, $category, $last_date);
        $ump_past       = $this->get_value_gl('185', $company, $category, $past_date);
        
        //BEBAN TANGGUHAN - BERSIH=================================================================================
        $btb_last       = $this->get_value_gl('181', $company, $category, $last_date);
        $btb_past       = $this->get_value_gl('181', $company, $category, $past_date);
        
        //ASET TAK BERWUJUD=======================================================================================
        $atb_last       = $this->plus_like_gl('171', '172', $company, $category, $last_date);
        $atb_past       = $this->plus_like_gl('171', '172', $company, $category, $past_date);
        
        //ASET TIDAK LANCAR LAINNYA===============================================================================
        $atll_last      = $this->plus_like_gl4('182', '183', '184', '189', $company, $category, $last_date);
        $atll_past      = $this->plus_like_gl4('182', '183', '184', '189', $company, $category, $past_date);
        
        //JUMLAH ASET TIDAK LANCAR========================================================================================
        $total_atl_last = $apt_last + $ipea_last + $pi_last + $total_at_last + $ump_last + $btb_last + $atb_last + $atll_last;
        $total_atl_past = $apt_past + $ipea_past + $pi_past + $total_at_past + $ump_past + $btb_past + $atb_past + $atll_past;
        
        //JUMLAH ASET=====================================================================================================
        $jmlh_aset_last = $total_atl_last + $jal_last;
        $jmlh_aset_past = $total_atl_past + $jal_past;

	    //last=================================================
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

	   	$asset['last'] = $last;
	   	$asset['past'] = $past;
	//====================================
 	//TABEL SEBELAH KANAN==================
 	//liability
		//PINJAMAN JANGKA PENDEK===================================================================================
		$pjp_last       = $this->get_value_gl('211', $company, $category, $last_date);
		$pjp_past       = $this->get_value_gl('211', $company, $category, $past_date);

		//UTANG USAHA==============================================================================================
		$uu_last        = ($this->plus_like_gl('212', '213', $company, $category, $last_date))*-1;
		$uu_past        = ($this->plus_like_gl('212', '213', $company, $category, $past_date))*-1;

		//UTANG LAIN - LAIN==========================================================================================
		$pll_last       = ($this->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
		$pll_past       = ($this->min_like_gl_in('214', array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

		//BEBAN AKRUAL============================================================================================
		$ba_last        = ($this->get_value_gl('216', $company, $category, $last_date))*-1;
		$ba_past        = ($this->get_value_gl('216', $company, $category, $past_date))*-1;

		//UTANG PAJAK============================================================================================
		$up_last        = ($this->get_value_gl('215', $company, $category, $last_date))*-1;
		$up_past        = ($this->get_value_gl('215', $company, $category, $past_date))*-1;

		//UTANG DEVIDEN==========================================================================================
		$ud_last        = ($this->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $last_date))*-1;
		$ud_past        = ($this->in_gl(array('21421011', '21421012', '21421013', '21421014', '21421015', '21421016'), $company, $category, $past_date))*-1;

		//PINJAMAN BANK============================================================================================
		$pb_last        = ($this->get_value_gl('2171', $company, $category, $last_date))*-1;
		$pb_past        = ($this->get_value_gl('2171', $company, $category, $past_date))*-1;

		//PINJAMAN PEMERINTAH RI============================================================================================
		$ppri_last      = ($this->get_value_gl('2172', $company, $category, $last_date))*-1;
		$ppri_past      = ($this->get_value_gl('2172', $company, $category, $past_date))*-1;

		//UTANG BUNGA DAN DENDA==============================================================================================
		$ubdd_last      = ($this->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
		$ubdd_past      = ($this->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

		//SEWA PEMBIAYAAN============================================================================================
		$sp_last        = ($this->get_value_gl('2176', $company, $category, $last_date))*-1;
		$sp_past        = ($this->get_value_gl('2176', $company, $category, $past_date))*-1;

		//JUMLAH LIABILITAS JANGKA PENDEK==========================================================================
		$jljp_last      = $pjp_last + $uu_last + $pll_last + $ba_last + $up_last + $ud_last + $pb_last + $ppri_last + $ubdd_last + $sp_last;
		$jljp_past      = $pjp_past + $uu_past + $pll_past + $ba_past + $up_past + $ud_past + $pb_past + $ppri_past + $ubdd_past + $sp_past;

		//LIABILITAS PAJAK TANGGUHAN============================================================================================
		$lpt_last       = ($this->get_value_gl('23', $company, $category, $last_date))*-1;
		$lpt_past       = ($this->get_value_gl('23', $company, $category, $past_date))*-1;

		//LIABILITAS IMBALAN KERJA JANGKA PANJANG==========================================================================================
		$likjp_last     = ($this->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $last_date))*-1;
		$likjp_past     = ($this->plus_like_gl4('2542', '25900001', '25900002', '25900008', $company, $category, $past_date))*-1;

		//PINJAMAN BANK 2============================================================================================
		$pb2_last       = ($this->get_value_gl('251', $company, $category, $last_date))*-1;
		$pb2_past       = ($this->get_value_gl('251', $company, $category, $past_date))*-1;

		//PINJAMAN PEMERINTAH RI 2============================================================================================
		$ppri2_last     = ($this->get_value_gl('252', $company, $category, $last_date))*-1;
		$ppri2_past     = ($this->get_value_gl('252', $company, $category, $past_date))*-1;

		//UTANG BUNGA DAN DENDA============================================================================================
		$ubdd2_last     = ($this->plus_like_gl3('2173', '2174', '2175', $company, $category, $last_date))*-1;
		$ubdd2_past     = ($this->plus_like_gl3('2173', '2174', '2175', $company, $category, $past_date))*-1;

		//SEWA PEMBIAYAAN============================================================================================
		$sp2_last       = ($this->get_value_gl('256', $company, $category, $last_date))*-1;
		$sp2_past       = ($this->get_value_gl('256', $company, $category, $past_date))*-1;

		//PROVISI JANGKA PANJANG==============================================================================================
		$pjp2_last      = ($this->plus_like_gl('25900005', '25900009', $company, $category, $last_date))*-1;
		$pjp2_past      = ($this->plus_like_gl('25900005', '25900009', $company, $category, $past_date))*-1;

		//LIABILITAS JANGKA PANJANG LAINNYA=====================================================================================
		$ljpl_last1     = ($this->plus_like_gl3('253', '254', '259', $company, $category, $last_date))*-1;
		$ljpl_past1     = ($this->plus_like_gl3('253', '254', '259', $company, $category, $past_date))*-1;
		$gl_1_last      = ($this->get_value_gl('25900004', $company, $category, $last_date))*-1;
		$gl_1_past      = ($this->get_value_gl('25900004', $company, $category, $past_date))*-1;

		$ljpl_last      = $ljpl_last1 - $pjp2_last - $likjp_last - $gl_1_last;
		$ljpl_past      = $ljpl_past1 - $pjp2_past - $likjp_past - $gl_1_past;

		//JUMLAH LIABILITAS JANGKA PANJANG=====================================================================================================
		$jmlh_ljp_last  = $lpt_last + $likjp_last + $pb2_last + $ppri2_last + $ubdd2_last + $sp2_last + $pjp2_last + $ljpl_last;
		$jmlh_ljp_past  = $lpt_past + $likjp_past + $pb2_past + $ppri2_past + $ubdd2_past + $sp2_past + $pjp2_past + $ljpl_past;

		//JUMLAH LIABILITAS=====================================================================================================
		$liabilitas_last    = $jljp_last + $jmlh_ljp_last;
		$liabilitas_past    = $jljp_past + $jmlh_ljp_past;


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
		 $liability['last'] = $liability_last;
		 $liability['past'] = $liability_past;
	////-===============
	//equitas
	//
        //MODAL SAHAM============================================================================================
        $ms_last        = ($this->get_value_gl('31', $company, $category, $last_date))*-1;
        $ms_past        = ($this->get_value_gl('31', $company, $category, $past_date))*-1;
        
        //TAMBAHAN MODAL DISETOR===================================================================================
        $tmd_last       = ($this->get_value_gl('32', $company, $category, $last_date))*-1;
        $tmd_past       = ($this->get_value_gl('32', $company, $category, $past_date))*-1;
        
        //PENDAPATAN KOMPREHENSIF LAINNYA==========================================================================
        $pkl_last       = ($this->plus_like_gl3('390', '331', '332', $company, $category, $last_date))*-1;
        $pkl_past       = ($this->plus_like_gl3('390', '331', '332', $company, $category, $past_date))*-1;
        
        //SALDO LABA==========================================================================================
        $sl_last        = ($this->get_value_gl('3411', $company, $category, $last_date))*-1;
        $sl_past        = ($this->get_value_gl('3411', $company, $category, $past_date))*-1;
        
        //KEPENTINGAN NON PENGENDALI==========================================================================================
        $knp_last       = ($this->get_value_gl('37', $company, $category, $last_date))*-1;
        $knp_past       = ($this->get_value_gl('37', $company, $category, $past_date))*-1;
        
        //JUMLAH EKUITAS=====================================================================================================
        $ekuitas_last   = $ms_last + $tmd_last + $pkl_last + $sl_last + $knp_last;
        $ekuitas_past   = $ms_past + $tmd_past + $pkl_past + $sl_past + $knp_past;
        
        //JUMLAH LIABILITAS DAN EKUITAS=====================================================================================================
        $jlde_last      = $liabilitas_last + $ekuitas_last;
        $jlde_past      = $liabilitas_past + $ekuitas_past;

        $total_equity_liability['last'] = $jlde_last;
        $total_equity_liability['past'] = $jlde_past;

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

         $ekuitas['last'] = $equity_last;
         $ekuitas['past'] = $equity_past;

$test = array();
$test['equity'] = $ekuitas;
$test['liability'] = $liability;
$test['total_liability_equity'] = $total_equity_liability;
$test['asset'] = $asset;

echo json_encode($test);


// $test = $this->get_value_gl('31','2000', 'ACT', '2015.12');

// echo "results : " .$test.'<br>';

	}

	function get_value_gl($glaccount, $company, $category, $date){
		$db=$this->load->database('default3',true);
	$sql =$db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.CATEGORY = 'ACT'
	AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount%'
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	");
	 // echo "$sql <br> <br>";
	//$queryOracle = oci_parse($sql);

	// echo "queryOracle => $queryOracle ->";

	// echo $queryOracle['JUMLAH'];
	
	//$result = oci_execute($queryOracle);

	// echo "execute => $result ->";

	//$fetch = oci_fetch_array($queryOracle);
	foreach ($sql as $fetch) {
		# code...
	}
	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}
function plus_like_gl4($glaccount1, $glaccount2, $glaccount3,$glaccount4, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount4%'
	AND	CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND	CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");
	 // echo "$sql <br> <br>";
	// $queryOracle = oci_parse($sql);

	// // echo "queryOracle => $queryOracle ->";

	// // echo $queryOracle['JUMLAH'];
	
	// $result = oci_execute($queryOracle);

	// // echo "execute => $result ->";

	// $fetch = oci_fetch_array($queryOracle);
	foreach ($sql as $fetch) {
		# code...
	}
	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}

function plus_gl5_in($glaccount1, $glaccount2, $glaccount3,$glaccount4,$glaccount5,$glaccount6, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql =$db->query( "
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount4%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount5%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT IN ('$glaccount6[0]', '$glaccount6[1]', '$glaccount6[2]', '$glaccount6[3]', '$glaccount6[4]', '$glaccount6[5]')
	AND	CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND	CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");
	 // echo "$sql <br> <br>";
	//$queryOracle = oci_parse($sql);

	// echo "queryOracle => $queryOracle ->";

	// echo $queryOracle['JUMLAH'];
	
	//$result = oci_execute($queryOracle);

	// echo "execute => $result ->";

	//$fetch = oci_fetch_array($queryOracle);

	//echo "fetch => ".$fetch[0];
	foreach ($sql as $fetch) {
		# code...
	}

	return $fetch['JUMLAH'];

	}

function plus_like_gl3($glaccount1, $glaccount2, $glaccount3, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
			CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
        AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
	   AND	CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND	CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");

	
	 // echo "$sql <br> <br>";
	// $queryOracle = oci_parse($sql);

	// // echo "queryOracle => $queryOracle ->";

	// // echo $queryOracle['JUMLAH'];
	
	// $result = oci_execute($queryOracle);

	// // echo "execute => $result ->";

	// $fetch = oci_fetch_array($queryOracle);
	foreach ($sql->result_array() as $fetch) {
		# code...
	}
	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}
function plus_like_gl($glaccount1, $glaccount2, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
    AND CONSOLIDATION.COMPANY IN ('$company')
    AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
    AND CONSOLIDATION.CURRENCY = 'LC'
    AND CONSOLIDATION.FLOW = 'CLOSING'
    AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
    AND CONSOLIDATION.CATEGORY = 'ACT'
	OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
	   AND	CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND	CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");

	
	 // echo "$sql <br> <br>";
	// $queryOracle = oci_parse($sql);

	// // echo "queryOracle => $queryOracle ->";

	// // echo $queryOracle['JUMLAH'];
	
	// $result = oci_execute($queryOracle);

	// // echo "execute => $result ->";

	// $fetch = oci_fetch_array($queryOracle);
	foreach ($sql as $fetch) {
		# code...
	}

	return $fetch['JUMLAH'];

	}

function min_like_gl_in($glaccount1,$glaccount2, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
	AND CONSOLIDATION.GL_ACCOUNT NOT IN ('$glaccount2[0]', '$glaccount2[1]', '$glaccount2[2]', '$glaccount2[3]', '$glaccount2[4]', '$glaccount2[5]')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");
	 // echo "$sql <br> <br>";
	// $queryOracle = oci_parse($sql);

	// // echo "queryOracle => $queryOracle ->";

	// // echo $queryOracle['JUMLAH'];
	
	// $result = oci_execute($queryOracle);

	// // echo "execute => $result ->";

	// $fetch = oci_fetch_array($queryOracle);
	foreach ($sql->result_array() as $fetch) {
		# code...
	}

	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}
function in_gl($glaccount, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
		CONSOLIDATION.COMPANY IN ('$company')
	AND CONSOLIDATION.GL_ACCOUNT IN ('$glaccount[0]', '$glaccount[1]', '$glaccount[2]', '$glaccount[3]')
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	AND CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	");
	 // echo "$sql <br> <br>";
	//$queryOracle = oci_parse($sql);

	// echo "queryOracle => $queryOracle ->";

	// echo $queryOracle['JUMLAH'];
	
	//$result = oci_execute($queryOracle);

	// echo "execute => $result ->";

	//$fetch = oci_fetch_array($queryOracle);
	foreach ($sql as $fetch) {
		# code...
	}
	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}

function min_like_gl($glaccount1,$glaccount2, $company, $category, $date){
	$db=$this->load->database('default3',true);
	$sql = $db->query("
	SELECT
		SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
	FROM
		CONSOLIDATION
	WHERE
     CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
    AND CONSOLIDATION.GL_ACCOUNT NOT LIKE '$glaccount2%'
    AND CONSOLIDATION.COMPANY IN ('$company')
	AND	CONSOLIDATION.CURRENCY = 'LC'
	AND CONSOLIDATION.FLOW = 'CLOSING'
	AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
	AND CONSOLIDATION.CATEGORY = 'ACT'
	AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
	

	");
	 // echo "$sql <br> <br>";
	//$queryOracle = oci_parse($sql);

	// echo "queryOracle => $queryOracle ->";

	// echo $queryOracle['JUMLAH'];
	
	//$result = oci_execute($queryOracle);

	// echo "execute => $result ->";

	foreach ($sql->result_array() as $fetch) {
		# code...
	}

	//echo "fetch => ".$fetch[0];

	return $fetch['JUMLAH'];

	}

}

/* End of file m_balance_sheet.php */
/* Location: ./application/models/m_balance_sheet.php */