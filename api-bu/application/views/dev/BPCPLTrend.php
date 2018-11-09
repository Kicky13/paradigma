<title>Json</title>

<?php
$companys = array('sg' => '7000', 'sp' => '3000', 'st' => '4000', 'tlcc' => '6000');

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

$bulan_before = $bulan - 1;

//======================================= CURRENT MONTH ==================================//
function penjualan($company, $tahun, $myBulan) {
    $user = "devsi";
    $pass = "SelaluJaya6102";
    $_ora_db_pm_dev = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.145)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = smig_dev.semenindonesia.com)(SERVER = DEDICATED)))';
    $conn = oci_connect($user, $pass, $_ora_db_pm_dev);

    $sql = "SELECT
            SUM (AMOUNT) AS HASIL
    FROM
            CONSOLIDATION
    WHERE
            AUDITTRAIL = 'PL_CONS'
    AND CATEGORY = 'ACT'
    AND COSTCENTER_COMPONENT = 'NO_CC'
    AND DOCUMENT_TYPE = 'NO_DOC'
    AND FLOW = 'CLOSING'
    AND GL_ACCOUNT = 'PL_VLP'
    AND COMPANY = '$company' 
    AND INTERCO = 'I_NONE'
    AND CURRENCY = 'LC'
    AND SCOPE = 'NON_GROUP'
    AND FISCAL_YEAR_PERIOD = '$tahun.$myBulan'"; //AND FISCAL_YEAR_PERIOD = '$tahun.$myBulan'"; -- AND COMPANY = '$company'

    $queryOracle = oci_parse($conn, $sql);
    oci_execute($queryOracle);
    while ($rowID = oci_fetch_array($queryOracle)) {

        $penjualan = $rowID['HASIL'];

//        $text["finance"][$h_day] = array(
//            "company" => $company,
//            "date_time" => $date_time,
//            "day" => $h_day,
//            "acc_pay" => $amount_ap,
//            "acc_rec" => $amount_ar);
    }
}

echo json_encode($penjualan);
?>