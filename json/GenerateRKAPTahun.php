<?php
header('Access-Control-Allow-Origin: *');
	$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");
	
	if(!empty($_GET['company'])){
		switch($_GET['company']){
			case 1 :
				$myCompany = "where company= '3000'";
				break;
			case 2 :
				$myCompany = "where company= '4000'";
				break;
			case 3 :
				$myCompany = "where company= '6000'";
				break;
			case 4 :
				$myCompany = "where company= '7000'";
				break	;
			default :
			$myCompany = "";
			}
	}else{
		$myCompany = "";
	}
	$query = pg_query($dbconn,"SELECT
	company,
	SUM (CAST(clinker AS NUMERIC)) AS klinker,
	SUM (CAST(cement AS NUMERIC)) AS semen
FROM
	rkap ".$myCompany."
And tahun=".date('Y')."
GROUP BY
	company ");
	
	while ($rowID=pg_fetch_array($query)){
		$idJson["s".$rowID['company']] = array('company' => $rowID['company'],
										  'clinker'  => $rowID['klinker'],
										  'cement' => $rowID['semen']
											);
	}
	
	echo json_encode($idJson);
?>