<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");

$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");
	if(!empty($_GET['bulan'])){
$bulan = $_GET['bulan'];
	}else{$bulan = date('m');}
if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}else{$tahun = date('Y');}
	
if(!empty($_GET['bulan']) and !empty($_GET['tahun'])){
$wherea = "where opdate BETWEEN to_date('".$_GET['tahun']."-".$_GET['bulan']."-01','YYYY-MM-DD') AND to_date('".$_GET['tahun']."-".$_GET['bulan']."-31','YYYY-MM-DD')";

}else{
$wherea ="";
}
if(!empty($_GET['plant'])){
	switch($_GET['plant']){
		case 1 :
			$wPlant = "where pabrik= 'Tuban 1'";
			break;
		case 2 :
			$wPlant = "where pabrik= 'Tuban 2'";
			break;
		case 3 :
			$wPlant = "where pabrik= 'Tuban 3'";
			break;
		case 4 :
			$wPlant = "where pabrik= 'Tuban 4'";
			break	;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

$query = pg_query($dbconn,"select opdate,rate,prod,runhours,text,tagid,pabrik from v_plg_report $wherea order by opdate asc");


	while ($rowID=pg_fetch_array($query)){
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		if($rowID['text'] == 'Feed Raw Mill'){
		$rawMill['rm'][] = $rowID['prod'];}
		
		if($rowID['text'] == 'Feed kiln'){
		$kilnMill['kl'][] = $rowID['prod'];}

		if($rowID['tagid'] == '15780' || 
			$rowID['tagid'] == '1225' ||
			$rowID['tagid'] == '6798' ||
			$rowID['tagid'] == '3977' ||
			$rowID['tagid'] == '15788' ||
			$rowID['tagid'] == '4691' ||
			$rowID['tagid'] == '1141' ||
			$rowID['tagid'] == '3543' ||
			$rowID['tagid'] == '90000'||
			$rowID['tagid'] == '90010'||
			$rowID['tagid'] == '90020'||
			$rowID['tagid'] == '90030'){
		$finishMill['fm'][] = $rowID['prod'];}
	}
	$data = array('pabrik'=> 'Tuban',
					'rawmill'=> number_format(array_sum($rawMill['rm']),0,",",""),
					'kiln'=> number_format(array_sum($kilnMill['kl']),0,",",""),
					'finishmill'=> number_format(array_sum($finishMill['fm']),0,",","")				
				 );
	/*foreach($idJson as $alpha){
		$runHours_x[$alpha['tagid']] = 
			array( "plant" => $alpha['pabrik'],
				   "name" => $alpha['name'],
				   "tagid" => $alpha['tagid'],
				   "runhours" => array_sum($runHours [$alpha['tagid']]),
				   "rundays" => number_format(array_sum($runHours [$alpha['tagid']]) / 24,0),
				   "produksi" =>number_format(array_sum($prod [$alpha['tagid']]),1,",",".")
	
				   
				);	
		
	}*/
echo json_encode($data);

?>