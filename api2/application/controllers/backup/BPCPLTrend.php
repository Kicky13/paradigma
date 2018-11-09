<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BPCPLTrend extends CI_Controller {

	public function index()
	{
		$companys = array('sg' => '7000', 'sp' => '3000', 'st' => '4000', 'tlcc' => '6000');

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

			$bulan_before = $bulan - 1;

			$this->penjualan($companys, $tahun, $bulan);
			
	}

	public function penjualan($company, $tahun, $myBulan) {
		$db=$this->load->database('default3',true);
		$sql = $db->query("SELECT
		            SUM (AMOUNT) AS HASIL
		    FROM
		            CONSOLIDATION
		    WHERE
		            AUDITTRAIL = 'PL_CONS'
		    AND CATEGORY = 'ACT'
		    AND COSTCENTER_COMPONENT = 'NO_CC'
		    AND DOCUMENT_TYPE = 'NO_DOC'
		    AND FLOW = 'CLOSING'
		    AND GL_ACCOUNT = 'PL_VLP'
		    AND COMPANY = '$company' 
		    AND INTERCO = 'I_NONE'
		    AND CURRENCY = 'LC'
		    AND SCOPE = 'NON_GROUP'
		    AND FISCAL_YEAR_PERIOD = '$tahun.$myBulan'");
		    foreach ($sql->result_array() as $rowID) {

		        $penjualan = $rowID['HASIL'];

		//        $text["finance"][$h_day] = array(
		//            "company" => $company,
		//            "date_time" => $date_time,
		//            "day" => $h_day,
		//            "acc_pay" => $amount_ap,
		//            "acc_rec" => $amount_ar);
		    }
		    echo json_encode($penjualan);
	}

}

/* End of file BPCPLTrend.php */
/* Location: ./application/controllers/BPCPLTrend.php */