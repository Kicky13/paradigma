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

$sql = "SELECT * FROM V_PIS_TLCC_PLANT WHERE TO_CHAR(OPDATE, 'YYYY-MM') = '" . $tahun . "-" . $bulan . "' ORDER BY OPDATE ASC";

$query = oci_parse($conn, $sql);
oci_execute($query);
while ($rowID = oci_fetch_array($query)) {
    $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
    $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
        'name' => $rowID['TEXT'],
        'pabrik' => $rowID['PABRIK']
    );

    $seqTgl = date('d', strtotime($rowID['OPDATE']));
    if ($seqTgl != 0 or ! empty($seqTgl)) {
        $prod[$rowID['TAGID']][$seqTgl] = array(
            'rate' => number_format($rowID['RATE'], 0, ",", "."),
            'prod' => number_format($rowID['PROD'], 0, ",", "."));
    }
    $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
}
foreach ($idJson as $alpha) {
    $runHours_x[$alpha['tagid']] = array("plant" => $alpha['pabrik'],
        "name" => $alpha['name'],
        "tagid" => $alpha['tagid'],
        "runhours" => array_sum($runHours [$alpha['tagid']]),
        "tproduksi" => array_sum($toprod[$alpha['tagid']]),
        "produksi" => $prod[$alpha['tagid']],
    );
}
echo json_encode($runHours_x);
?>