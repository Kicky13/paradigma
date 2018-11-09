<title>Json</title>
<?php
// header("Access-Control-Allow-Origin:*");
$user = "MSADMIN";
$pass = "nGUmBEsiwal4N";
$_ora_db_pm_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))) (CONNECT_DATA = (SID = PMT)(SERVER = DEDICATED)))';
        
$conn = oci_connect($user, $pass,$_ora_db_pm_dev);

 $queryOracle = oci_parse($conn,"SELECT
	TBH. SORT,
	TBH.PNTIDC,
	TBH.PLANTC,
	TBH.TEXT,
	TBX.PNTTEXT,
	TBX.VALUEDEFAULT,
	TBX.ONRLT,
	SYSDATE AS NOW,
	HourTOCHAR ((SYSDATE - TBX.ONRLT) * 24) AS SEL
FROM
	(
		SELECT
			TB1.*, TB2.*
		FROM
			(
				SELECT
					SORT,
					PNTID AS PNTIDC,
					LOCATION AS PLANTC,
					TEXT
				FROM
					TEXT_CONFIG
				WHERE
					FLAG = 1 AND LOCATION IN (1, 2) AND TEXT LIKE '%Cement Silo%'
				GROUP BY
					PNTID,
					SORT,
					LOCATION,
					TEXT
			) tb1
		LEFT JOIN (
			SELECT
				PNTID AS PNTIDM,
				TO_CHAR (
					MAX (ONRLT),
					'YYYYMMDD HH24:MI:SS'
				) AS TIMESET,
				PLANT AS PLANTM
			FROM
				PLG_EVENT_NEW
			GROUP BY
				PNTID,
				PLANT
		) tb2 ON (
			tb1.PNTIDC = tb2.PNTIDM
			AND tb1.PLANTC = tb2.PLANTM
		)
	) TBH
LEFT JOIN PLG_EVENT_NEW TBX ON TBH.PNTIDM = TBX.PNTID
AND TBH.TIMESET = TO_CHAR (
	TBX.ONRLT,
	'YYYYMMDD HH24:MI:SS'
)
AND TBH.PLANTM = TBX.PLANT");
	oci_execute($queryOracle);
	while ($rowID=oci_fetch_array($queryOracle)){
	if($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready"){
		$valueData = "False";
	}else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " "){
		$valueData = "True";
	}else{
		$valueData = $rowID['VALUEDEFAULT'];
	}
		$text[$rowID['PNTIDC']] []= array(
						"datatype"=>"string",
						"name"=> "Value",
						"quality"=> "true",
						"val"=>$valueData);
		$go[]=array( 
						"name"=>$rowID['PNTIDC'],
						"props"=>$text[$rowID['PNTIDC']]);
	}

echo '({"message":"","status":"OK","tags":'.json_encode($go).',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';

?>