<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateJSONProdMonthTLCC extends CI_Controller {

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
				company = '6000'
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
				rm1_prod,
				kl1_prod,
				fmmp_prod,
				fmgp_prod
			FROM
				plg_tlcc_month
			ORDER BY
				month_date");

			foreach ($query->result_array() as $rowID) {
			    $month = $rowID['month_date'];
			    
			    $rm1 = $rowID['rm1_prod'];
			    
			    $kl1 = $rowID['kl1_prod'];
			    
			    $fm_mp = $rowID['fmmp_prod'];
			    $fm_gp = $rowID['fmgp_prod'];
			    
			    $to_prod[$month] = array (
			        "rm1" => $rm1,
			        
			        "kl1" => $kl1,
			        
			        "fm_mp" => $fm_mp,
			        "fm_gp" => $fm_gp
			    );
			}

			$myJSON = array(
			    "rkap" => $rkap,
			    "prod" => $to_prod
			);
			echo '{"7000":'.json_encode($myJSON).'}';
	}

}

/* End of file GenerateJSONProdMonthTLCC.php */
/* Location: ./application/controllers/GenerateJSONProdMonthTLCC.php */