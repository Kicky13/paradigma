<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stmrevvolprice4000 extends CI_Model {

	public function get_stmrevvolprice4000()
	{
		$db=$this->load->database('default5',true);
		$comp = "3000";

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

$tahun_min1 = $tahun - 1;

for ($i = 1; $i <= date('m'); $i++) {
    $bulan = sprintf("%02d", $i);
    
    $sql_vol = $db->query("SELECT
	SUM (kwantumx) AS kwantum
FROM
	(
		SELECT
			SUM (kwantumx) AS kwantumx
		FROM
			zreport_rpt_real_st
		WHERE
			order_type NOT LIKE 'ZN%'
		AND com = '4000'
		AND TO_CHAR (tgl_spj, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
		AND plant <> '4403'
		UNION
			SELECT
				SUM (ton) AS kwantumx
			FROM
				zreport_ongkosangkut_mod
			WHERE
				TO_CHAR (wadat_ist, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
			AND lfart NOT LIKE 'ZN%'
			AND vkorg = '4000'
			AND WERKS = '4403')");

    foreach ($sql_vol->result_array() as $rowID) {
        $vol = $rowID['KWANTUM'];
    }
    
    $sql_rev = $db->query("SELECT
	SUM (NET) AS NET
FROM
	(
		SELECT
			SUM (net) AS net
		FROM
			zreport_real_penjualan
		WHERE
			TO_CHAR (BUDAT, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
		AND lfart NOT LIKE 'ZN%'
		AND vkorg = '4000'
		AND WERKS <> '4403'
		UNION
			SELECT
				SUM (net) AS net
			FROM
				zreport_ongkosangkut_mod
			WHERE
				TO_CHAR (wadat_ist, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
			AND lfart NOT LIKE 'ZN%'
			AND vkorg = '4000'
			AND WERKS = '4403'
	)");

    foreach ($sql_rev->result_array() as $rowID) {
        $rev = $rowID['NET'];
    }

    $sql_pri = $db->query("SELECT
	SUM (net) / SUM (vol) AS hasil
FROM
	(
		SELECT
			SUM (net) AS net,
			SUM (ntgew) AS vol
		FROM
			zreport_real_penjualan
		WHERE
			TO_CHAR (BUDAT, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
		AND lfart NOT LIKE 'ZN%'
		AND vkorg = '4000'
		AND WERKS <> '4403'
		UNION
			SELECT
				SUM (net) AS net,
				SUM (ton) AS vol
			FROM
				zreport_ongkosangkut_mod
			WHERE
				TO_CHAR (wadat_ist, 'mm/yyyy') = '" . $bulan . "/" . $tahun . "'
			AND lfart NOT LIKE 'ZN%'
			AND vkorg = '4000'
			AND WERKS = '4403'
	)");

    foreach ($sql_pri->result_array() as $rowID) {
        $pri = $rowID['HASIL'];
    }
    
    $prod[$i] = array(
        "volume" => $vol,
        "revenue" => $rev,
        "price" => $pri
    );
}

echo '{"4000":' . json_encode($prod) . '}';
	}

}

/* End of file m_stmrevvolprice4000.php */
/* Location: ./application/models/m_stmrevvolprice4000.php */