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
			$wPlant = "where pabrik= 'TLCC 1'";
			break;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

$query = pg_query($dbconn,"select opdate,rate,prod,runhours,text,tagid,pabrik from v_plg_tlcc_report $wherea order by opdate asc");


	while ($rowID=pg_fetch_array($query)){
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		if($rowID['text'] == 'Feed Raw Mill'){
		$rawMill['rm'][] = $rowID['prod'];}
		
		if($rowID['text'] == 'Feed Kiln'){
		$kilnMill['kl'][] = $rowID['prod'];}

		if($rowID['tagid'] == 'TLCC.FMMP' || 
			$rowID['tagid'] == 'TLCC.FM_HCM'){
		$finishMill['fm'][] = $rowID['prod'];}
	}
	$data = array('pabrik'=> 'TLCC',
					'rawmill'=> number_format(array_sum($rawMill['rm']),0,",",""),
					'kiln'=> number_format(array_sum($kilnMill['kl']),0,",",""),
					'finishmill'=> number_format(array_sum($finishMill['fm']),0,",","")				
				 );
echo json_encode($data);

?>