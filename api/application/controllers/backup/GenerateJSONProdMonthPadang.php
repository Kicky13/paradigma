<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateJSONProdMonthPadang extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default4',true);
			if (!empty($_GET['bulan'])) {
			    $bulan = $_GET['bulan'];
			} else {
			    $bulan = date('m');
			}

			if (!empty($_GET['tahun'])) {
			    $tahun = $_GET['tahun'];
			} else {
			    $tahun = date('Y');
			}

			if (!empty($_GET['company'])) {
			    switch ($_GET['company']) {
			        case 1 :
			            $company = 3000;
			            break;
			        case 2 :
			            $company = 4000;
			            break;
			        case 3 :
			            $company = 5000;
			            break;
			        case 4 :
			            $company = 6000;
			            break;
			        case 5 :
			            $company = 7000;
			            break;
			        default :
			            $company = 7000;
			    }
			} else {
			    $company = 7000;
			}

			$sql_rkap = $db->query("SELECT
				bulan,
				tahun,
				clinker,
				cement
			FROM
				rkap
			WHERE
				company = '3000'
			AND tahun = '" . $tahun . "'");

			foreach ($sql_rkap->result_array() as $rowID) {
			    $bln = $rowID['bulan'];
			    $panjang = strlen($bln);
			    if ($panjang == 1) {
			        $blnku = '0' . $bln;
			    } else {
			        $blnku = $bln;
			    }
			    $thn = $rowID['tahun'];
			    $month = $thn . '-' . $blnku;
			    $rkap_cement = $rowID['cement'];
			    $rkap_clinker = $rowID['clinker'];
			    
			    $rkap[$month] = array(
			        "rkap_cement" => $rkap_cement,
			        "rkap_clinker" => $rkap_clinker
			    );
			}

			$query = $db->query("SELECT
				month_date,
				rm2_prod,
				rm3_prod,
				rm41_prod,
				rm42_prod,
				rm51_prod,
				rm52_prod,
				kl2_prod,
				kl3_prod,
				kl4_prod,
				kl5_prod,
				fm2_prod,
				fm3_prod,
				fm41_prod,
				fm42_prod,
				fm51_prod,
				fm52_prod
			FROM
				plg_sp_month
			ORDER BY
				month_date");

			foreach ($query->result_array() as $rowID) {
				
			    $month = $rowID['month_date'];
			    
			    $rm2 = $rowID['rm2_prod'];
			    $rm3 = $rowID['rm3_prod'];
			    $rm4 = $rowID['rm41_prod'] + $rowID['rm42_prod'];
			    $rm5 = $rowID['rm51_prod'] + $rowID['rm52_prod'];
			    
			    $kl2 = $rowID['kl2_prod'];
			    $kl3 = $rowID['kl3_prod'];
			    $kl4 = $rowID['kl4_prod'];
			    $kl5 = $rowID['kl5_prod'];
			    
			    $fm_ind2 = $rowID['fm2_prod'];
			    $fm_ind3 = $rowID['fm3_prod'];
			    $fm_ind4 = $rowID['fm41_prod'] + $rowID['fm42_prod'];
			    $fm_ind5 = $rowID['fm51_prod'] + $rowID['fm52_prod'];
			    
			    $to_prod[$month] = array (
			        "rm2" => number_format($rm2,2,".",""),
			        "rm3" => number_format($rm3,2,".",""),
			        "rm4" => number_format($rm4,2,".",""),
			        "rm5" => number_format($rm5,2,".",""),
			        
			        "kl2" => number_format($kl2,2,".",""),
			        "kl3" => number_format($kl3,2,".",""),
			        "kl4" => number_format($kl4,2,".",""),
			        "kl5" => number_format($kl5,2,".",""),
			        
			        "fm_ind2" => number_format($fm_ind2,2,".",""),
			        "fm_ind3" => number_format($fm_ind3,2,".",""),
			        "fm_ind4" => number_format($fm_ind4,2,".",""),
			        "fm_ind5" => number_format($fm_ind5,2,".","")
			    );
			}

			$myJSON = array(
			    "rkap" => $rkap,
			    "prod" => $to_prod
			);
			echo '{"7000":'.json_encode($myJSON).'}';
	}

}

/* End of file GenerateJSONProdMonthPadang.php */
/* Location: ./application/controllers/GenerateJSONProdMonthPadang.php */