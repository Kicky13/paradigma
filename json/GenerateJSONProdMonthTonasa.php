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

$sql_rkap = "SELECT TAHUN, BULAN, CEMENT, CLINKER FROM PIS_RKAP_TOTAL WHERE COMPANY = 4000 AND TAHUN = '" . $tahun . "'";
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
	RM2_PROD,
	RM3_PROD,
	RM41_PROD,
	RM41_JOP,
	RM42_PROD,
	RM5_PROD,
	KL2_PROD,
	KL3_PROD,
	KL4_PROD,
	KL5_PROD,
	FM2_PROD,
	FM3_PROD,
	FM41_PROD,
	FM42_PROD,
	FM51_PROD,
	FM52_PROD
FROM
	PIS_ST_PRODMONTH
ORDER BY
	MONTH_PROD";

$query = oci_parse($conn, $sql);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $month = $rowID['MONTH_PROD'];
    
    $rm2 = $rowID['RM2_PROD'];
    $rm3 = $rowID['RM3_PROD'];
    $rm4 = $rowID['RM41_PROD'] + $rowID['RM42_PROD'];
    $rm5 = $rowID['RM5_PROD'];
    
    $kl2 = $rowID['KL2_PROD'];
    $kl3 = $rowID['KL3_PROD'];
    $kl4 = $rowID['KL4_PROD'];
    $kl5 = $rowID['KL5_PROD'];
    
    $fm_tns2 = $rowID['FM2_PROD'];
    $fm_tns3 = $rowID['FM3_PROD'];
    $fm_tns4 = $rowID['FM41_PROD'] + $rowID['FM42_PROD'];
    $fm_tns5 = $rowID['FM51_PROD'] + $rowID['FM52_PROD'];
    
    $to_prod[$month] = array (
        "rm2" => number_format($rm2,2,".",""),
        "rm3" => number_format($rm3,2,".",""),
        "rm4" => number_format($rm4,2,".",""),
        "rm5" => number_format($rm5,2,".",""),
        
        "kl2" => number_format($kl2,2,".",""),
        "kl3" => number_format($kl3,2,".",""),
        "kl4" => number_format($kl4,2,".",""),
        "kl5" => number_format($kl5,2,".",""),
        
        "fm_tns2" => number_format($fm_tns2,2,".",""),
        "fm_tns3" => number_format($fm_tns3,2,".",""),
        "fm_tns4" => number_format($fm_tns4,2,".",""),
        "fm_tns5" => number_format($fm_tns5,2,".","")
    );
}

$myJSON = array(
    "rkap" => $rkap,
    "prod" => $to_prod
);
echo '{"7000":'.json_encode($myJSON).'}';
?>