<title>Json</title>
<?php
// header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$user = "mso";
$pass = "s3mengres1k";
$oramso = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.122)(PORT = 1521))) (CONNECT_DATA = (SID = pmdb)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $oramso);

if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = date('m');
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = date('Y');
}

if (!empty($_GET['company'])) {
    switch ($_GET['company']) {
        case 1 :
            $company = 3000;
            break;
        case 2 :
            $company = 4000;
            break;
        case 3 :
            $company = 5000;
            break;
        case 4 :
            $company = 6000;
            break;
        case 5 :
            $company = 7000;
            break;
        default :
            $company = 7000;
    }
} else {
    $company = 7000;
}

$sql_rkap = "SELECT TAHUN, BULAN, CEMENT, CLINKER FROM PIS_RKAP_TOTAL WHERE COMPANY = 7000 AND TAHUN = '" . $tahun . "'";
$query = oci_parse($conn, $sql_rkap);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $bln = $rowID['BULAN'];
    $panjang = strlen($bln);
    if ($panjang == 1) {
        $blnku = '0' . $bln;
    } else {
        $blnku = $bln;
    }
    $thn = $rowID['TAHUN'];
    $month = $thn . '-' . $blnku;
    $rkap_cement = $rowID['CEMENT'];
    $rkap_clinker = $rowID['CLINKER'];
    
    $rkap[$month] = array(
        "rkap_cement" => $rkap_cement,
        "rkap_clinker" => $rkap_clinker
    );
}

$sql = "SELECT
	MONTH_PROD,
	RM1_PROD,
	RM2_PROD,
	RM3_PROD,
	RM4_PROD,
	KL1_PROD,
	KL2_PROD,
	KL3_PROD,
	KL4_PROD,
	FM1_PROD,
	FM2_PROD,
	FM3_PROD,
	FM4_PROD,
	FM5_PROD,
	FM6_PROD,
	FM7_PROD,
	FM8_PROD,
	FM9_PROD,
	FMA_PROD,
	FMB_PROD,
	FMC_PROD
FROM
	PIS_SG_PRODMONTH
ORDER BY
	MONTH_PROD";

$query = oci_parse($conn, $sql);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $month = $rowID['MONTH_PROD'];
    
    $rm1 = $rowID['RM1_PROD'];
    $rm2 = $rowID['RM2_PROD'];
    $rm3 = $rowID['RM3_PROD'];
    $rm4 = $rowID['RM4_PROD'];
    
    $kl1 = $rowID['KL1_PROD'];
    $kl2 = $rowID['KL2_PROD'];
    $kl3 = $rowID['KL3_PROD'];
    $kl4 = $rowID['KL4_PROD'];
    
    $fm_tb1 = $rowID['FM1_PROD'] + $rowID['FM2_PROD'] + $rowID['FM9_PROD'];
    $fm_tb2 = $rowID['FM3_PROD'] + $rowID['FM4_PROD'];
    $fm_tb3 = $rowID['FM5_PROD'] + $rowID['FM6_PROD'];
    $fm_tb4 = $rowID['FM7_PROD'] + $rowID['FM8_PROD'];
    $fm_grs = $rowID['FMA_PROD'] + $rowID['FMB_PROD'] + $rowID['FMC_PROD'];
    
    $to_prod[$month] = array (
        "rm1" => number_format($rm1,2,".",""),
        "rm2" => number_format($rm2,2,".",""),
        "rm3" => number_format($rm3,2,".",""),
        "rm4" => number_format($rm4,2,".",""),
        
        "kl1" => number_format($kl1,2,".",""),
        "kl2" => number_format($kl2,2,".",""),
        "kl3" => number_format($kl3,2,".",""),
        "kl4" => number_format($kl4,2,".",""),
        
        "fm_tb1" => number_format($fm_tb1,2,".",""),
        "fm_tb2" => number_format($fm_tb2,2,".",""),
        "fm_tb3" => number_format($fm_tb3,2,".",""),
        "fm_tb4" => number_format($fm_tb4,2,".",""),
        "fm_grs" => number_format($fm_grs,2,".","")
    );
}

$myJSON = array(
    "rkap" => $rkap,
    "prod" => $to_prod
);
echo '{"7000":'.json_encode($myJSON).'}';

?>