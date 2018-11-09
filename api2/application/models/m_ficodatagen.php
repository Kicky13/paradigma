<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ficodatagen extends CI_Model {

	public function get_ficodatagen()
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
		$db=$this->load->database('default',true);
		$sql_saldo_awal=$db->query("SELECT balance from ZCFI_SALDO where FIS_PERIOD = " . $bulan . " and FISC_YEAR = '" . $tahun . "' ");
		foreach ($sql_saldo_awal->result_array() as $rowID) {
			$last_balance = $rowID['BALANCE'];
}

				$sql = $db->query("SELECT
					bukrs,
					datum,
					REGEXP_REPLACE (VERZN, ' ', '') AS verzn,
					SUM (ap) AS ap,
					SUM (ar) AS ar
				FROM
					zcfi_cf_ap_ar
				WHERE VERZN IN ('7-','6-','5-','4-','3-','2-','1-','0','1','2','3','4','5','6','7')
				AND BUKRS IN ('2000','3000','4000','5000','6000','7000')
				GROUP BY
					verzn,
					bukrs,
					datum
				ORDER BY
					verzn ASC");
				foreach ($sql->result_array() as $rowID) {
					$company = $rowID['BUKRS'];
					    $date_time = $rowID['DATUM'];
					    $h_day = $rowID['VERZN'];
					    $amount_ap = $rowID['AP'];
					    $amount_ar = $rowID['AR'];

					    $text["finance"][$h_day] = array(
					        "company" => $company,
					        "date_time" => $date_time,
					        "day" => $h_day,
					        "acc_pay" => $amount_ap,
					        "acc_rec" => $amount_ar,
					    );
					}
					$text['last'] = $last_balance;

					echo '{"7000":' . json_encode($text) . ',"last":"'.$last_balance.'"}';
	}

}

/* End of file m_ficodatagen.php */
/* Location: ./application/models/m_ficodatagen.php */