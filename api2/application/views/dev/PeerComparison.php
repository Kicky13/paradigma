<title>Json</title>

<?php
$user     = "DEVSD";
$pass     = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);

/*if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = date('m');
}
if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = date('Y');
}

$tahun_min1 = $tahun - 1;

if (!empty($_GET['company'])) {
    switch ($_GET['company']) {
        case 1:
            $comp = "3000";
            break;
        case 2:
            $comp = "4000";
            break;
        case 3:
            $comp = "6000";
            break;
        case 4:
            $comp = "7000";
            break;
        default:
            $comp = "7000";
    }
} else {
    $comp = "7000";
}*/

if (!empty($_GET['tipe'])) {
    $type = $_GET['tipe'];
} else {
    $type = 0;
}

$sql = "SELECT * FROM PEER_COMPARISON1 WHERE TYPE = '$type' ORDER BY ID	ASC";

$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
    
    $id = $rowID['ID'];
	$desc = $rowID['DESCRIPTION'];
	
	$h_smgr = $rowID['H_SMGR'];
	$h1_smgr = $rowID['H1_SMGR'];
	$chg_smgr = $rowID['CHG_SMGR'];
	
	$h_smcb = $rowID['H_INTP'];
	$h1_smcb = $rowID['H1_INTP'];
	$chg_smcb = $rowID['CHG_INTP'];
	
	$h_intp = $rowID['H_SMCB'];
	$h1_intp = $rowID['H1_SMCB'];
	$chg_intp = $rowID['CHG_SMCB'];
	
	$semester = $rowID['SEMESTER'];
	$tahun = $rowID['TAHUN'];
	$tipe = $rowID['TYPE'];
    
    $pc_data[$id] = array(
		'description' =>  $desc,
		'h_smgr' =>  $h_smgr,
		'h1_smgr' =>  $h1_smgr,
		'chg_smgr' =>  $chg_smgr,
		
		'h_smcb' =>  $h_smcb,
		'h1_smcb' =>  $h1_smcb,
		'chg_smcb' =>  $chg_smcb,
		
		'h_intp' =>  $h_intp,
		'h1_intp' =>  $h1_intp,
		'chg_intp' =>  $chg_intp,
		
		'semester' =>  $semester
	);
}

echo '{"7000":' . json_encode($pc_data) . '}';
?>