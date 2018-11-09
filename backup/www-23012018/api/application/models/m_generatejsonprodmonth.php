<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generatejsonprodmonth extends CI_Model {

	public function get_generatejsonprodmonth()
	{
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

		$db=$this->load->database('default4',true);

		$sql_rkap = $db->query("SELECT
							bulan,
							tahun,
							clinker,
							cement
						FROM
							rkap
						WHERE
							company = '7000'
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
							rm2_prod,
							rm3_prod,
							rm4_prod,
							kl1_prod,
							kl2_prod,
							kl3_prod,
							kl4_prod,
							fm1_prod,
							fm2_prod,
							fm3_prod,
							fm4_prod,
							fm5_prod,
							fm6_prod,
							fm7_prod,
							fm8_prod,
							fm9_prod,
							fma_prod,
							fmb_prod,
							fmc_prod
						FROM
							plg_sg_month
						ORDER BY
							month_date");

						foreach ($query->result_array() as $rowID) {
						
						    $month = $rowID['month_date'];
						    
						    $rm1 = $rowID['rm1_prod'];
						    $rm2 = $rowID['rm2_prod'];
						    $rm3 = $rowID['rm3_prod'];
						    $rm4 = $rowID['rm4_prod'];
						    
						    $kl1 = $rowID['kl1_prod'];
						    $kl2 = $rowID['kl2_prod'];
						    $kl3 = $rowID['kl3_prod'];
						    $kl4 = $rowID['kl4_prod'];
						    
						    $fm_tb1 = $rowID['fm1_prod'] + $rowID['fm2_prod'] + $rowID['fm9_prod'];
						    $fm_tb2 = $rowID['fm3_prod'] + $rowID['fm4_prod'];
						    $fm_tb3 = $rowID['fm5_prod'] + $rowID['fm6_prod'];
						    $fm_tb4 = $rowID['fm7_prod'] + $rowID['fm8_prod'];
						    $fm_grs = $rowID['fma_prod'] + $rowID['fmb_prod'] + $rowID['fmc_prod'];
						    
						    $to_prod[$month] = array (
						        "rm1" => number_format($rm1,2,".",""),
						        "rm2" => number_format($rm2,2,".",""),
						        "rm3" => number_format($rm3,2,".",""),
						        "rm4" => number_format($rm4,2,".",""),
						        
						        "kl1" => number_format($kl1,2,".",""),
						        "kl2" => number_format($kl2,2,".",""),
						        "kl3" => number_format($kl3,2,".",""),
						        "kl4" => number_format($kl4,2,".",""),
						        
						        "fm_tb1" => number_format($fm_tb1,2,".",""),
						        "fm_tb2" => number_format($fm_tb2,2,".",""),
						        "fm_tb3" => number_format($fm_tb3,2,".",""),
						        "fm_tb4" => number_format($fm_tb4,2,".",""),
						        "fm_grs" => number_format($fm_grs,2,".","")
						    );
						}

						$myJSON = array(
						    "rkap" => $rkap,
						    "prod" => $to_prod
						);
						echo '{"7000":'.json_encode($myJSON).'}';
	}

}

/* End of file m_generatejsonprodmonth.php */
/* Location: ./application/models/m_generatejsonprodmonth.php */