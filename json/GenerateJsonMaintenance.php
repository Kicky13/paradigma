<?php
header('Access-Control-Allow-Origin: *');
$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");
/*if(!empty($_GET['plant'])){
	switch($_GET['plant']){
		case 1 :
			$wPlant = "2000";
			break;
		case 2 :
			$wPlant = "3000";
			break;
		case 3 :
			$wPlant = "4000";
			break;
		case 4 :
			$wPlant = "5000";
			break	;
		case 5 :
			$wPlant = "6000";
			break;
		case 6 :
			$wPlant = "7000";
			break	;
		default :
		$wPlant = "7000";
		}
}else{
	$wPlant = "7000";
}

$query = pg_query($dbconn,"SELECT
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
WHERE
	opco = '".$wPlant."'
GROUP BY
	month_date
ORDER BY month_date");*/

$query = pg_query($dbconn,"SELECT
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
--WHERE month_date = '11'
GROUP BY
	opco,
	month_date
ORDER BY
	opco, month_date");

	while ($rowID=pg_fetch_array($query)){
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
?>