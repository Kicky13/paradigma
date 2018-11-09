<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SDRKAP_RealDaily extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default5',true);
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
//$sql = "select tb6.*, tb5.RKAP_JADI from 
//(select com as co,substr(ITEM_NO,0,7) as items,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(KWANTUMX) as real
//		from zreport_rpt_real 
//		where
//		to_char(TGL_CMPLT,'YYYYMMDD') LIKE '.$tahun$bulan.%' AND 
//		((ORDER_TYPE<> 'ZNL' and(ITEM_NO like '121-301%' and item_no <> '121-301-0240')) or (ITEM_NO like '121-302%' and order_type <>'ZNL'))
//		group by com,to_char(TGL_CMPLT,'YYYYMMDD') ,substr(ITEM_NO,0,7)) tb6
//
//LEFT JOIN
//(SELECT TB4.co,TB4.tipe,TB3.budat,(tb4.RKAP*tb3.RKAP_H) as RKAP_JADI
//FROM
//(SELECT CO,TIPE,THN,BLN,sum(quantum) as  RKAP 
//from SAP_T_RENCANA_SALES_TYPE
//where co='.$company.' and thn='.$tahun.' and bln='.$bulan.'
//GROUP BY CO,TIPE,THN,BLN)tb4
//LEFT JOIN (
//(select tb1.*,tb2.porsi_total, (tb1.porsi/tb2.porsi_total) as RKAP_H 
//from
//(SELECT vkorg,tipe,budat,porsi
//from ZREPORT_PORSI_SALES_REGION
//where vkorg='.$company.' and budat like '.$tahun$bulan.%' and region=5) tb1
//LEFT JOIN (
//(SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
//from ZREPORT_PORSI_SALES_REGION
//where vkorg='.$company.' and budat like '.$tahun$bulan.%' and region=5
//GROUP BY vkorg,region,tipe) tb2
//) on (tb1.tipe=tb2.tipe )
//ORDER BY tb1.budat asc)tb3)
//on (TB4.TIPE=TB3.tipe)
//ORDER BY budat) tb5 on TB6.ITEMS = TB5.TIPE and TB5.BUDAT = TB6.TANGGAL
//order by TB6.TANGGAL";

$sql_rkap = $db->query("SELECT
			CO,
			-- TIPE,
			THN,
			BLN,
			SUM (quantum) AS RKAP
		FROM
			SAP_T_RENCANA_SALES_TYPE
		WHERE
			co = '" . $company . "'
		AND thn = '" . $tahun . "'
		AND bln = '" . $bulan . "'
		GROUP BY
			CO,
			-- TIPE,
			THN,
			BLN");
//$sql_rkap = "SELECT
//	tb1.*, tb2.rev_real,
//	(tb2.rev_real / tb1.revenue) * 100 AS persn
//FROM
//	(
//		SELECT
//			CO,
//			THN,
//			BLN,
//			SUM (rkap_rev) AS Revenue
//		FROM
//			(
//				SELECT
//					tbm.CO,
//					tbm.THN,
//					BLN,
//					CASE
//				WHEN SUM (tbm.quantum) = 0 THEN
//					0
//				ELSE
//					SUM (tbm.revenue)
//				END rkap_rev
//				FROM
//					SAP_T_RENCANA_SALES_TYPE tbm
//				WHERE
//					thn = '" . $tahun ."'
//				AND CO = ".$company."
//				AND bln = '".$bulan."'
//				AND prov <> '1092'
//				AND prov <> '0001'
//				GROUP BY
//					CO,
//					THN,
//					BLN
//			)
//		GROUP BY
//			CO,
//			THN,
//			BLN
//	) tb1
//LEFT JOIN (
//	SELECT
//		vkorg,
//		NVL (
//			SUM (net - netwr) / SUM (NTGEW),
//			0
//		) AS rev_real
//	FROM
//		zreport_real_penjualan A
//	WHERE
//		TO_CHAR (budat, 'yyyymm') = '".$tahun.$bulan."'
//	AND (
//		(
//			MATNR LIKE '121-301%'
//			AND MATNR <> '121-301-0240'
//		)
//		OR (
//			MATNR LIKE '121-302%'
//			AND MATNR <> '121-302-0100'
//		)
//	)
//	AND lfart <> 'ZNL'
//	AND lfart <> 'ZLFE'
//	AND add01 <> 'S11LO'
//	AND VKBUR != '1092'
//	AND VKBUR != '0001'
//	AND NETWR IS NOT NULL
//	GROUP BY
//		vkorg
//) tb2 ON (tb1.CO = tb2.VKORG)";

foreach ($sql_rkap->result_array() as $rowID) {
//    if ($tipe == '121-301') {
//        $myType = 'curah';
//    } else if ($tipe == '121-302') {
//        $myType = 'zak';
//    }
    $rkap = $rowID['RKAP'];
}
$sql = $db->query("select tb6.*, tb5.RKAP_JADI from 
(select com as co,substr(ITEM_NO,0,7) as items,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(KWANTUMX) as real
		from zreport_rpt_real 
		where
		to_char(TGL_CMPLT,'YYYYMMDD') LIKE '".$tahun.$bulan."%' AND 
		((ORDER_TYPE<> 'ZNL' and(ITEM_NO like '121-301%' and item_no <> '121-301-0240')) or (ITEM_NO like '121-302%' and order_type <>'ZNL'))
		group by com,to_char(TGL_CMPLT,'YYYYMMDD') ,substr(ITEM_NO,0,7)) tb6

LEFT JOIN
(SELECT TB4.co,TB4.tipe,TB3.budat,(tb4.RKAP*tb3.RKAP_H) as RKAP_JADI
FROM
(SELECT CO,TIPE,THN,BLN,sum(quantum) as  RKAP 
from SAP_T_RENCANA_SALES_TYPE
where co='".$company."' and thn='".$tahun."' and bln='".$bulan."'
GROUP BY CO,TIPE,THN,BLN)tb4
LEFT JOIN (
(select tb1.*,tb2.porsi_total, (tb1.porsi/tb2.porsi_total) as RKAP_H 
from
(SELECT vkorg,tipe,budat,porsi
from ZREPORT_PORSI_SALES_REGION
where vkorg='".$company."' and budat like '".$tahun.$bulan."%' and region=5) tb1
LEFT JOIN (
(SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
from ZREPORT_PORSI_SALES_REGION
where vkorg='".$company."' and budat like '".$tahun.$bulan."%' and region=5
GROUP BY vkorg,region,tipe) tb2
) on (tb1.tipe=tb2.tipe )
ORDER BY tb1.budat asc)tb3)
on (TB4.TIPE=TB3.tipe)
ORDER BY budat) tb5 on TB6.ITEMS = TB5.TIPE and TB5.BUDAT = TB6.TANGGAL
order by TB6.TANGGAL");

foreach ($sql->result_array() as $rowID) {

    $company = $rowID['CO'];
    $tanggal = $rowID['TANGGAL'];
    $tipe = $rowID['ITEMS'];
    $real_val = $rowID['REAL'];
    $rkap_val = $rowID['RKAP_JADI'];

    if ($tipe == '121-301') {
        $myType = 'curah';
    } else if ($tipe == '121-302') {
        $myType = 'zak';
    }
    $text[$myType][$tanggal] = array(
        "tipe" => $tipe,
        "tanggal" => $tanggal,
        "real" => number_format($real_val,2,".",""),
        "rkap" => number_format($rkap_val,2,".","")
    );
}

echo '{"rkap":"' . $rkap . '","' . $company . '":' . json_encode($text) . '}';
	}

}

/* End of file SDRKAP_RealDaily.php */
/* Location: ./application/controllers/SDRKAP_RealDaily.php */