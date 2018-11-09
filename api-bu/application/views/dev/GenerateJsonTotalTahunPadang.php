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
			$wPlant = "where pabrik= 'Indarung 2'";
			break;
		case 2 :
			$wPlant = "where pabrik= 'Indarung 3'";
			break;
		case 3 :
			$wPlant = "where pabrik= 'Indarung 4'";
			break;
		case 4 :
			$wPlant = "where pabrik= 'Indarung 5'";
			break	;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

$query = pg_query($dbconn,"select opdate,rate,prod,runhours,text,tagid,pabrik from v_plg_sp_report $wherea order by opdate asc");


	while ($rowID=pg_fetch_array($query)){
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		if($rowID['text'] == 'Feed Raw Mill'){
		$rawMill['rm'][] = $rowID['prod'];}
		
		if($rowID['text'] == 'Feed Kiln'){
		$kilnMill['kl'][] = $rowID['prod'];}

		if($rowID['tagid'] == 'PIS.4Z1_FEED' || 
			$rowID['tagid'] == 'PIS.5Z1_FEED' ||
			$rowID['tagid'] == 'PIS.4Z2_FEED' ||
			$rowID['tagid'] == 'PIS.5Z2_FEED' ||
			$rowID['tagid'] == 'N13.Z1_MV_TOTAL' ||
			$rowID['tagid'] == 'N23.Z2_MV_TOTAL'){
		$finishMill['fm'][] = $rowID['prod'];}
	}
	$data = array('pabrik'=> 'Indarung',
					'rawmill'=> number_format(array_sum($rawMill['rm']),0,",",""),
					'kiln'=> number_format(array_sum($kilnMill['kl']),0,",",""),
					'finishmill'=> number_format(array_sum($finishMill['fm']),0,",","")				
				 );
echo json_encode($data);

?>