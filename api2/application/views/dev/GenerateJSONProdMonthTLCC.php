<title>Json</title>
<?php
//header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");
$dbconn = pg_connect("host=10.15.3.63 port=5432 dbname=pisdb user=pis password=semengresik");

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

$sql_rkap = pg_query($dbconn, "SELECT
	bulan,
	tahun,
	clinker,
	cement
FROM
	rkap
WHERE
	company = '6000'
AND tahun = '" . $tahun . "'");

while ($rowID = pg_fetch_array($sql_rkap)) {
    $bln = $rowID['bulan'];
    $panjang = strlen($bln);
    if ($panjang == 1) {
        $blnku = '0' . $bln;
    } else {
        $blnku = $bln;
    }
    $thn = $rowID['tahun'];
    $month = $thn . '-' . $blnku;
    $rkap_cement = $rowID['cement'];
    $rkap_clinker = $rowID['clinker'];
    
    $rkap[$month] = array(
        "rkap_cement" => $rkap_cement,
        "rkap_clinker" => $rkap_clinker
    );
}

$query = pg_query($dbconn, "SELECT
	month_date,
	rm1_prod,
	kl1_prod,
	fmmp_prod,
	fmgp_prod
FROM
	plg_tlcc_month
ORDER BY
	month_date");

while ($rowID = pg_fetch_array($query)) {
    $month = $rowID['month_date'];
    
    $rm1 = $rowID['rm1_prod'];
    
    $kl1 = $rowID['kl1_prod'];
    
    $fm_mp = $rowID['fmmp_prod'];
    $fm_gp = $rowID['fmgp_prod'];
    
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