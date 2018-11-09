<?php
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
	$query = pg_query($dbconn,"select bulan,tahun, coalesce(clinker ,'0') as clinker,coalesce(cement ,'0') as cement from rkap $myCompany And tahun=".date('Y'));
	
	while ($rowID=pg_fetch_array($query)){
		$idJson["s".$rowID['bulan']] = array('bulan' => $rowID['bulan'],
										  'clinker'  => $rowID['clinker'],
										  'cement' => $rowID['cement']
											);
	}
	
	echo json_encode($idJson);
?>