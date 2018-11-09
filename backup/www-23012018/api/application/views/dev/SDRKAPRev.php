<title>Json</title>
<?php
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

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

$conn = oci_connect($user, $pass, $_ora_sco);

//$sql_rkap = "SELECT
//	CO,
//	-- TIPE,
//	THN,
//	BLN,
//	SUM (revenue) AS RKAP
//FROM
//	SAP_T_RENCANA_SALES_TYPE
//WHERE
//	co = '" . $company . "'
//AND thn = '" . $tahun . "'
//AND bln = '" . $bulan . "'
//GROUP BY
//	CO,
//	-- TIPE,
//	THN,
//	BLN";
// $sql_rkap = "SELECT
// 	tb1.*, tb2.rev_real,
// 	(tb2.rev_real / tb1.revenue) * 100 AS persn
// FROM
// 	(
// 		SELECT
// 			CO,
// 			THN,
// 			BLN,
// 			SUM (rkap_rev) AS Revenue
// 		FROM
// 			(
// 				SELECT
// 					tbm.CO,
// 					tbm.THN,
// 					BLN,
// 					CASE
// 				WHEN SUM (tbm.quantum) = 0 THEN
// 					0
// 				ELSE
// 					SUM (tbm.revenue)
// 				END rkap_rev
// 				FROM
// 					SAP_T_RENCANA_SALES_TYPE tbm
// 				WHERE
// 					thn = '" . $tahun . "'
// 				AND CO = " . $company . "
// 				AND bln = '" . $bulan . "'
// 				AND prov <> '1092'
// 				AND prov <> '0001'
// 				GROUP BY
// 					CO,
// 					THN,
// 					BLN
// 			)
// 		GROUP BY
// 			CO,
// 			THN,
// 			BLN
// 	) tb1
// LEFT JOIN (
// 	SELECT
// 		vkorg,
// 		NVL (
// 			SUM (net - netwr) / SUM (NTGEW),
// 			0
// 		) AS rev_real
// 	FROM
// 		zreport_real_penjualan A
// 	WHERE
// 		TO_CHAR (budat, 'yyyymm') = '" . $tahun.$bulan."'
// 	AND (
// 		(
// 			MATNR LIKE '121-301%'
// 			AND MATNR <> '121-301-0240'
// 		)
// 		OR (
// 			MATNR LIKE '121-302%'
// 			AND MATNR <> '121-302-0100'
// 		)
// 	)
// 	AND lfart <> 'ZNL'
// 	AND lfart <> 'ZLFE'
// 	AND add01 <> 'S11LO'
// 	AND VKBUR != '1092'
// 	AND VKBUR != '0001'
// 	AND NETWR IS NOT NULL
// 	GROUP BY
// 		vkorg
// ) tb2 ON (tb1.CO = tb2.VKORG)";

$sql_rkap = "select tbkkl.co,tbmlll.budat,sum(tbkkl.revenue * (tbmlll.porsi/tbmlll.porsitot)) as rkap_revenu from(SELECT CO,THN,BLN,SUM (rkap_rev) AS Revenue from(select tbm.CO, tbm.THN, BLN,case when sum(tbm.quantum)=0 then 0 else sum(tbm.revenue) end rkap_rev FROM SAP_T_RENCANA_SALES_TYPE tbm WHERE thn = '" . $tahun . "' AND bln = '" . $bulan . "' and prov<>'1092' and prov<>'0001' GROUP BY CO, THN, BLN) GROUP BY CO, THN, BLN)tbkkl left join(select tbmpo.*,tbmposum.porsitot from(select vkorg,budat,sum(porsi) as porsi from zreport_porsi_sales_region where region = 5 and budat like '" .$tahun.$bulan."%' group by vkorg,budat)tbmpo left join  (select vkorg,sum(porsi) as porsitot from zreport_porsi_sales_region where region = 5 and budat like '" .$tahun.$bulan."%' group by vkorg)tbmposum on(tbmpo.vkorg=tbmposum.vkorg) order by tbmpo.vkorg,tbmpo.budat)tbmlll on(tbkkl.co=tbmlll.vkorg) group by tbkkl.co,tbmlll.budat order by tbkkl.co,tbmlll.budat asc";

$queryOracle2 = oci_parse($conn, $sql_rkap);
oci_execute($queryOracle2);
while ($rowID = oci_fetch_array($queryOracle2)) {
    $rkap = $rowID['REVENUE'];
}

//$sql = "SELECT CO AS COMPANY, items AS TYPE, TANGGAL, REV_REAL as REVENUE, REVENUE_JADI AS RKAP FROM (
//select tb6.*, tb5.REVENUE_JADI from 
//(select com as co,substr(ITEM_NO,0,7) as items,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(harga) as rev_real
//		from zreport_rpt_real 
//		where
//		to_char(TGL_CMPLT,'YYYYMMDD') LIKE '" . $tahun . $bulan . "%' AND 
//		((ORDER_TYPE<> 'ZNL' and(ITEM_NO like '121-301%' and item_no <> '121-301-0240')) or (ITEM_NO like '121-302%' and order_type <>'ZNL'))
//		group by com,to_char(TGL_CMPLT,'YYYYMMDD') ,substr(ITEM_NO,0,7)) tb6
//
//LEFT JOIN
//(SELECT TB4.co,TB4.tipe,TB3.budat,(tb4.Revenue*tb3.RKAP_H) as Revenue_JADI
//FROM
//(SELECT CO,TIPE,THN,BLN,sum(revenue) as  Revenue 
//from SAP_T_RENCANA_SALES_TYPE
//where co='" . $company . "' and thn='" . $tahun . "' and bln='" . $bulan . "'
//GROUP BY CO,TIPE,THN,BLN)tb4
//LEFT JOIN (
//(select tb1.*,tb2.porsi_total, (tb1.porsi/tb2.porsi_total) as RKAP_H 
//from
//(SELECT vkorg,tipe,budat,porsi
//from ZREPORT_PORSI_SALES_REGION
//where vkorg='" . $company . "' and budat like '" . $tahun . $bulan . "%' and region=5) tb1
//LEFT JOIN (
//(SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
//from ZREPORT_PORSI_SALES_REGION
//where vkorg='" . $company . "' and budat like '" . $tahun . $bulan . "%' and region=5
//GROUP BY vkorg,region,tipe) tb2
//) on (tb1.tipe=tb2.tipe )
//ORDER BY tb1.budat asc)tb3)
//on (TB4.TIPE=TB3.tipe)
//ORDER BY budat) tb5 on TB6.ITEMS = TB5.TIPE and TB5.BUDAT = TB6.TANGGAL
//)
//ORDER BY TANGGAL";
// $sql = "(
// 	SELECT
// 		TBREAL.*, TBREV.REVENUE_JADI
// 	FROM
// 		(
// 			SELECT
// 				*
// 			FROM
// 				(
// 					SELECT
// 						co,
// 						SUBSTR (tanggal, 0, 4) AS tahun,
// 						SUBSTR (tanggal, 5, 2) AS bulan,
// 						SUBSTR (tanggal, 7, 2) AS tgl,
// 						rev_real
// 					FROM
// 						(
// 							SELECT
// 								com AS co,
// 								TO_CHAR (TGL_CMPLT, 'YYYYMMDD') AS tanggal,
// 								SUM (harga) AS rev_real
// 							FROM
// 								zreport_rpt_real
// 							WHERE
// 								TO_CHAR (TGL_CMPLT, 'YYYYMMDD') LIKE '" . $tahun . $bulan . "%'
// 							AND (
// 								(
// 									ORDER_TYPE <> 'ZNL'
// 									AND (
// 										ITEM_NO LIKE '121-301%'
// 										AND item_no <> '121-301-0240'
// 									)
// 								)
// 								OR (
// 									ITEM_NO LIKE '121-302%'
// 									AND order_type <> 'ZNL'
// 								)
// 							)
// 							GROUP BY
// 								com,
// 								TO_CHAR (TGL_CMPLT, 'YYYYMMDD')
// 						)
// 				)
// 		) TBREAL
// 	LEFT JOIN --RENCANA REV PERHARI
// 	(
// 		SELECT
// 			TB4.co,
// 			TB4.thn,
// 			TB4.bln,
// 			TB3.TANGGAL,
// 			(tb4.Revenue * tb3.RKAP_H * 10) AS Revenue_JADI
// 		FROM
// 			(
// 				SELECT
// 					CO,
// 					THN,
// 					BLN,
// 					SUM (revenue) AS Revenue
// 				FROM
// 					SAP_T_RENCANA_SALES_TYPE
// 				WHERE
// 					co = '".$company."'
// 				AND thn = '".$tahun."'
// 				AND bln = '".$bulan."'
// 				GROUP BY
// 					CO,
// 					THN,
// 					BLN
// 			) TB4
// 		LEFT JOIN (
// 			SELECT
// 				vkorg,
// 				SUBSTR (budat, 0, 4) AS tahun,
// 				SUBSTR (budat, 5, 2) AS bulan,
// 				SUBSTR (budat, 7, 2) AS tanggal,
// 				porsi,
// 				porsi_total,
// 				SUM (rkap_1) AS rkap_h
// 			FROM
// 				(
// 					SELECT
// 						tb1.*, tb2.porsi_total,
// 						(tb1.porsi / tb2.porsi_total) AS RKAP_1
// 					FROM
// 						(
// 							SELECT
// 								vkorg,
// 								tipe,
// 								budat,
// 								porsi
// 							FROM
// 								ZREPORT_PORSI_SALES_REGION
// 							WHERE
// 								vkorg = '".$company."'
// 							AND budat LIKE '" . $tahun . $bulan . "%'
// 							AND region = 5
// 						) TB1
// 					LEFT JOIN (
// 						(
// 							SELECT
// 								vkorg,
// 								region,
// 								tipe,
// 								SUM (porsi) AS porsi_total
// 							FROM
// 								ZREPORT_PORSI_SALES_REGION
// 							WHERE
// 								vkorg = '".$company."'
// 							AND budat LIKE '" . $tahun . $bulan . "%'
// 							AND region = 5
// 							GROUP BY
// 								vkorg,
// 								region,
// 								tipe
// 						) TB2
// 					) ON (tb1.tipe = tb2.tipe)
// 					ORDER BY
// 						tb1.budat ASC
// 				)
// 			GROUP BY
// 				vkorg,
// 				budat,
// 				porsi,
// 				porsi_total
// 			ORDER BY
// 				BUDAT
// 		) TB3 ON tb4.thn = tb3.tahun
// 		AND tb4.bln = tb3.bulan
// 	) TBREV ON TBREAL.tahun = TBREV.thn
// 	AND TBREAL.bulan = TBREV.BLN
// 	AND TBREAL.tgl = TBREV.TANGGAL
// )";
$sql = "select vkorg,to_char(budat,'yyyymmdd') as dateday,nvl(sum(net-netwr)/sum(NTGEW),0) as rev_real from zreport_real_penjualan a where to_char(budat,'yyyymm') ='" .$tahun.$bulan."' and ((MATNR like '121-301%' and MATNR <> '121-301-0240') or (MATNR like '121-302%' and MATNR <> '121-302-0100')) and lfart<>'ZNL' and lfart <>'ZLFE' and add01<>'S11LO' and VKBUR!='1092' and VKBUR!='0001' and NETWR is not null group by vkorg,to_char(budat,'yyyymmdd')";

$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {

    $company = $rowID['CO'];
    $tgl = $rowID['TGL'];
    $bulan = $rowID['BULAN'];
    $tahun = $rowID['TAHUN'];
    $tanggal = $tahun.$bulan.$tgl;
    $real_val = $rowID['REV_REAL'];
    $rkap_val = $rowID['REVENUE_JADI'];

    $text[$tanggal] = array(
        "tanggal" => $tanggal,
        "real" => $real_val,
        "rkap" => $rkap_val
    );
}

echo '{"rkap":"' . $rkap . '","' . $company . '":' . json_encode($text) . '}';
?>