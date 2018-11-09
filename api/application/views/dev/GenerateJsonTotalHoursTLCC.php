<title>Json</title>
<?php
//header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");

if(!empty($_GET['plant'])){
	switch($_GET['plant']){
		case 1 :
			$wPlant = "where pabrik= 'TLCC 1'";
			break;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

$query = pg_query($dbconn,"select opdate,rate,prod,runhours,text,tagid,pabrik from v_plg_tlcc_report $wPlant order by opdate asc");


	while ($rowID=pg_fetch_array($query)){
		$runHours [$rowID['tagid']][] = $rowID['runhours'];
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		$prod[$rowID['tagid']][] = $rowID['prod'];
	}
	
	foreach($idJson as $alpha){
		$runHours_x[$alpha['tagid']] = 
			array( "plant" => $alpha['pabrik'],
				   "name" => $alpha['name'],
				   "tagid" => $alpha['tagid'],
				   "runhours" => number_format(array_sum($runHours [$alpha['tagid']]),0),
				   "rundays" => number_format(array_sum($runHours [$alpha['tagid']]) / 24,0),
				   "produksi" =>number_format(array_sum($prod [$alpha['tagid']]),1,",",".")
	
				   
				);	
		
	}
echo json_encode($runHours_x);

?>