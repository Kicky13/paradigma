<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generatejsonmaintenance extends CI_Model {

	public function get_generatejsonmaintenance()
	{
		$db=$this->load->database('default4',true);
		$query = $db->query("SELECT
					opco,
					month_date,
					SUM (osno) AS OSNO,
					SUM (nopr) AS NOPR,
					SUM (nopr_nopt) AS NOPR_NOPT,
					SUM (nopr_nopt_oras) AS NOPR_NOPT_ORAS,
					SUM (nopr_oras) AS NOPR_ORAS,
					SUM (noco) AS NOCO,
					SUM (noco_nopr) AS NOCO_NOPR,
					SUM (noco_nopt_oras) AS NOCO_NOPT_ORAS,
					SUM (noco_oras) AS NOCO_ORAS,
					SUM (dlfl_noco) AS DLFL_NOCO,
					SUM (dlfl_noco_oras) AS DLFL_NOCO_ORAS
				FROM
					pm_notif_month
				GROUP BY
					opco,
					month_date
				ORDER BY
					opco, month_date");
		foreach ($query->result_array() as $rowID) {
			$idJson[$rowID['opco']][$rowID['month_date']] = array(
										'OSNO' => $rowID['osno'],
										'NOPR'  => $rowID['nopr'],
										'NOPR_NOPT' => $rowID['nopr_nopt'],
										'NOPR_NOPT_ORAS'  => $rowID['nopr_nopt_oras'],
										'NOPR_ORAS' => $rowID['nopr_oras'],
										'NOCO'  => $rowID['noco'],
										'NOCO_NOPR' => $rowID['noco_nopr'],
										'NOCO_NOPT_ORAS'  => $rowID['noco_nopt_oras'],
										'NOCO_ORAS' => $rowID['noco_oras'],
										'DLFL_NOCO'  => $rowID['dlfl_noco'],
										'DLFL_NOCO_ORAS' => $rowID['dlfl_noco_oras']
										);
	}
	echo json_encode($idJson);
	}

}

/* End of file m_generatejsonmaintenance.php */
/* Location: ./application/models/m_generatejsonmaintenance.php */