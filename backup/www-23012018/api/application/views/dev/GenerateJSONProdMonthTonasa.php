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
            $company = 4000;
    }
} else {
    $company = 4000;
}

$sql_rkap = pg_query($dbconn, "SELECT
	bulan,
	tahun,
	clinker,
	cement
FROM
	rkap
WHERE
	company = '4000'
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
	rm2_prod,
	rm3_prod,
	rm41_prod,
	rm42_prod,
	rm51_prod,
	kl2_prod,
	kl3_prod,
	kl4_prod,
	kl5_prod,
	fm2_prod,
	fm3_prod,
	fm41_prod,
	fm42_prod,
	fm51_prod,
	fm52_prod
FROM
	plg_st_month
ORDER BY
	month_date");

while ($rowID = pg_fetch_array($query)) {
    $month = $rowID['month_date'];
    
    $rm2 = $rowID['rm2_prod'];
    $rm3 = $rowID['rm3_prod'];
    $rm4 = $rowID['rm41_prod'] + $rowID['rm42_prod'];
    $rm5 = $rowID['rm51_prod'];
    
    $kl2 = $rowID['kl2_prod'];
    $kl3 = $rowID['kl3_prod'];
    $kl4 = $rowID['kl4_prod'];
    $kl5 = $rowID['kl5_prod'];
    
    $fm_tns2 = $rowID['fm2_prod'];
    $fm_tns3 = $rowID['fm3_prod'];
    $fm_tns4 = $rowID['fm41_prod'] + $rowID['fm42_prod'];
    $fm_tns5 = $rowID['fm51_prod'] + $rowID['fm52_prod'];
    
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