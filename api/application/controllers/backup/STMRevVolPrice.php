<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class STMRevVolPrice extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default5',true);
		$orgv = 7000;

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

if (!empty($_GET['company'])) {
    switch ($_GET['company']) {
        case 1 :
            $comp = "3000";
            break;
        case 2 :
            $comp = "4000";
            break;
        case 3 :
            $comp = "6000";
            break;
        case 4 :
            $comp = "7000";
            break;
        default :
            $comp = "7000";
    }
} else {
    $comp = "7000";
}

$sql = $db->query("SELECT
	rkap.bln,
	rkap_volume,
	rkap_revenue,
	rkap_harga,
	NVL (real_volume, 0) AS real_volume,
	NVL (real_revenue, 0) AS real_revenue,
	NVL (real_harga, 0) AS real_harga,
	NVL (VOLUME, 0) AS last_volume,
	NVL (revenue, 0) AS last_revenue,
	NVL (harga, 0) AS last_harga
FROM
	(
		SELECT
			bln,
			SUM (quantum) AS rkap_volume,
			SUM (revenue) AS rkap_revenue,
			SUM (revenue) / SUM (quantum) AS rkap_harga
		FROM
			sap_t_rencana_sales_type
		WHERE
			co = '$comp'
		AND thn = '$tahun'
		GROUP BY
			bln
	) rkap
LEFT JOIN (
	SELECT
		bln,
		SUM (VOLUME) AS real_volume,
		SUM (revenue) AS real_revenue,
		SUM (revenue) / SUM (VOLUME) AS real_harga
	FROM
		sap_t_shipment_acc
	WHERE
		thn = '$tahun'
	AND vkorg = '$comp'
	AND LENGTH (TRIM(bln)) = 2
	GROUP BY
		bln
	UNION
		SELECT
			A .bln,
			NVL (VOLUME, 0) AS real_volume,
			NVL (revenue, 0) AS real_revenue,
			NVL (
				CASE
				WHEN VOLUME <> 0 THEN
					revenue / VOLUME
				ELSE
					0
				END,
				0
			) AS real_harga
		FROM
			(
				SELECT
					TO_CHAR (tgl_cmplt, 'mm') AS bln,
					SUM (kwantumx) AS VOLUME
				FROM
					zreport_rpt_real
				WHERE
					TO_CHAR (tgl_cmplt, 'yyyymm') BETWEEN (
						SELECT
							thn || TRIM (TO_CHAR(bln, '09')) AS bln
						FROM
							(
								SELECT
									$tahun AS thn,
									MAX (bln) + 1 AS bln
								FROM
									sap_t_shipment_acc
								WHERE
									thn = $tahun
								AND vkorg = '$comp'
								AND LENGTH (TRIM(bln)) = 2
							)
					)
				AND '$tahun$bulan'
				AND (
					plant <> '2490'
					OR plant <> '7490'
				)
				AND (
					(
						order_type <> 'ZNL'
						AND (
							item_no LIKE '121-301%'
							AND item_no <> '121-301-0240'
						)
					)
					OR (
						item_no LIKE '121-302%'
						AND order_type <> 'ZNL'
					)
				)
				AND com = '$comp'
				GROUP BY
					TO_CHAR (tgl_cmplt, 'mm')
			) A
		LEFT JOIN (
			SELECT
				TO_CHAR (A .budat, 'mm') AS bln,
				SUM (
					NVL (A .net, 0) - NVL (A .netwr, 0)
				) AS revenue
			FROM
				ZREPORT_REAL_PENJUALAN A
			WHERE
				TO_CHAR (A .budat, 'yyyymm') BETWEEN (
					SELECT
						thn || TRIM (TO_CHAR(bln, '09')) AS bln
					FROM
						(
							SELECT
								$tahun AS thn,
								MAX (bln) + 1 AS bln
							FROM
								sap_t_shipment_acc
							WHERE
								thn = $tahun
							AND vkorg = '$comp'
							AND LENGTH (TRIM(bln)) = 2
						)
				)
			AND '$tahun$bulan'
			AND A .vkorg = '$comp'
			and (
				(A .MATNR like '121-301%' and A .MATNR <> '121-301-0240') or
				 (A .MATNR like '121-302%' and A .MATNR <> '121-302-0100')
			)
			and A .lfart<>'ZNL' and A .lfart <>'ZLFE' and A .add01<>'S11LO'
			and A .NETWR is not null
			GROUP BY
				TO_CHAR (A .budat, 'mm')
		) b ON A .bln = b.bln
) rl ON rkap.bln = rl.bln
LEFT JOIN (
	SELECT
		bln,
		SUM (VOLUME) AS VOLUME,
		SUM (revenue) AS revenue,
		SUM (revenue) / SUM (VOLUME) AS harga
	FROM
		sap_t_shipment_acc
	WHERE
		thn = $tahun_min1
	AND vkorg = '$comp'
	AND LENGTH (TRIM(bln)) = 2
	GROUP BY
		bln
) ly ON rkap.bln = ly.bln
ORDER BY
	rkap.bln");

foreach ($sql->result_array() as $rowID) {

    $bulan = $rowID['BLN'];
    $rkap_volume = $rowID['RKAP_VOLUME'];
    $rkap_revenue = $rowID['RKAP_REVENUE'];
    $rkap_harga = $rowID['RKAP_HARGA'];

    $real_volume = $rowID['REAL_VOLUME'];
    $real_revenue = $rowID['REAL_REVENUE'];
    $real_harga = $rowID['REAL_HARGA'];

    $last_volume = $rowID['LAST_VOLUME'];
    $last_revenue = $rowID['LAST_REVENUE'];
    $last_harga = $rowID['LAST_HARGA'];

    $stm_data[$bulan] = array(
        'rkap_volume' => number_format($rkap_volume,2,".",""),
        'rkap_revenue' => number_format($rkap_revenue,2,".",""),
        'rkap_harga' => number_format($rkap_harga,2,".",""),
        'real_volume' => number_format($real_volume,2,".",""),
        'real_revenue' => number_format($real_revenue,2,".",""),
        'real_harga' => number_format($real_harga,2,".",""),
        'last_volume' => number_format($last_volume,2,".",""),
        'last_revenue' => number_format($last_revenue,2,".",""),
        'last_harga' => number_format($last_harga,2,".","")
    );
}

echo '{"7000":' . json_encode($stm_data) . '}';
	}

}

/* End of file STMRevVolPrice.php */
/* Location: ./application/controllers/STMRevVolPrice.php */