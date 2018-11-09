<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");

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

if (!empty($_GET['bulan']) and ! empty($_GET['tahun'])) {
    $where = "WHERE MONTH_PROD LIKE '" . $tahun . "-" . $bulan . "'";
} else {
    $where = "";
}

$sql = "SELECT
                SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) AS finishmill
        FROM
                PIS_SG_PRODMONTH $where";

$query = oci_parse($conn, $sql);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $rm = number_format($rowID['RAWMILL'],2,".","");
    $kl = number_format($rowID['KILN'],2,".","");
    $fm = number_format($rowID['FINISHMILL'],2,".","");
}
$data = array('pabrik' => 'Tuban',
    'rawmill' => $rm,
    'kiln' => $kl,
    'finishmill' => $fm
);

echo json_encode($data);
?>