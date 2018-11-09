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

$sql_rkap = "SELECT TAHUN, BULAN, CEMENT, CLINKER FROM PIS_RKAP_TOTAL WHERE COMPANY = 6000 AND TAHUN = '" . $tahun . "'";
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
	KL1_PROD,
	FMMP_PROD,
	FMHCM_PROD
FROM
	PIS_TLCC_PRODMONTH
ORDER BY
	MONTH_PROD";

$query = oci_parse($conn, $sql);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $month = $rowID['MONTH_PROD'];
    
    $rm1 = $rowID['RM1_PROD'];
    
    $kl1 = $rowID['KL1_PROD'];
    
    $fm_mp = $rowID['FMMP_PROD'];
    $fm_gp = $rowID['FMHCM_PROD'];
    
    $to_prod[$month] = array (
        "rm1" => $rm1,
        
        "kl1" => $kl1,
        
        "fm_mp" => $fm_mp,
        "fm_gp" => $fm_gp
    );
}

$myJSON = array(
    "rkap" => $rkap,
    "prod" => $to_prod
);
echo '{"7000":'.json_encode($myJSON).'}';
?>