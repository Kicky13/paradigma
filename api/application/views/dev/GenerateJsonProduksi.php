<title>Json</title>
<?php
//header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");

//$myQuery = pg_query($dbconn, "SELECT date_prod from plg_sg_plant ORDER BY date_prod DESC LIMIT 1");
//$data = pg_fetch_array($myQuery);
//$seqTgl = date('d',strtotime($data['date_prod']));
//$seqBln = date('m',strtotime($data['date_prod']));
//echo $seqTgl;
//echo $seqBln;

	if(!empty($_GET['bulan'])){
$bulan = $_GET['bulan'];
	}else{$bulan = date('m');}
//	$bulan = $seqBln;
if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}else{$tahun = date('Y');}

if(!empty($_GET['plant'])){
	switch($_GET['plant']){
		case 1 :
			$wPlant = "and pabrik= 'Tuban 1'";
			break;
		case 2 :
			$wPlant = "and pabrik= 'Tuban 2'";
			break;
		case 3 :
			$wPlant = "and pabrik= 'Tuban 3'";
			break;
		case 4 :
			$wPlant = "and pabrik= 'Tuban 4'";
			break	;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

// echo "select * from v_plg_report where opdate BETWEEN to_date('".$tahun."-".$bulan."-01','YYYY-MM-DD') AND to_date('".$tahun."'-'".$bulan."'-31','YYYY-MM-DD')";exit;
$query = pg_query($dbconn,"select * from v_plg_report where opdate BETWEEN to_date('".$tahun."-".$bulan."-01','YYYY-MM-DD') AND to_date('".$tahun."-".$bulan."-31','YYYY-MM-DD') $wPlant order by opdate asc");
// $row = pg_fetch_all($query);
// echo "<pre>";
// print_r($row);
// echo "</pre>";

	while ($rowID=pg_fetch_array($query)){
		$runHours [$rowID['tagid']][] = $rowID['runhours'];
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		
		$seqTgl = date('d',strtotime($rowID['opdate']));
		if($seqTgl !=0 or !empty($seqTgl)){
		$prod[$rowID['tagid']][$seqTgl] = array('rate'=>number_format($rowID['rate'],0,",","."),'prod'=>number_format($rowID['prod'],0,",","."));}
		$toprod[$rowID['tagid']][] = number_format($rowID['prod'],0,",",".");
	}
	
	foreach($idJson as $alpha){
		$runHours_x[$alpha['tagid']] = 
			array( "plant" => $alpha['pabrik'],
				   "name" => $alpha['name'],
				   "tagid" => $alpha['tagid'],
				   "runhours" => array_sum($runHours [$alpha['tagid']]),
				   "tproduksi" => array_sum($toprod[$alpha['tagid']]),
				   "produksi" => $prod[$alpha['tagid']],
				   
				);	
		
	}
echo json_encode($runHours_x);

?>