<title>Json</title>
<?php
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

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

$conn = oci_connect($user, $pass, $_ora_sco);

$sql_rkap = "SELECT
	CO,
	THN,
	BLN,
    case when sum(quantum)=0 then 0
    else sum(revenue)
    end AS RKAP
FROM
	SAP_T_RENCANA_SALES_TYPE
WHERE
	co = '" . $company . "'
AND thn = '" . $tahun . "'
AND bln = '" . $bulan . "'
GROUP BY
	CO,
	THN,
	BLN";

$queryOracle2 = oci_parse($conn, $sql_rkap);
oci_execute($queryOracle2);
while ($rowID = oci_fetch_array($queryOracle2)) {
    $rkap = $rowID['RKAP'];
}


$sql = "
select * from (select tbkkl.co,tbmlll.budat,sum(tbkkl.revenue * (tbmlll.porsi/tbmlll.porsitot)) as rkap_revenu from(
SELECT CO,THN,BLN,SUM (rkap_rev) AS Revenue from(
select tbm.CO, tbm.THN, BLN,
case  
   when sum(tbm.quantum)=0 then 0
   else sum(tbm.revenue)
end rkap_rev
FROM
SAP_T_RENCANA_SALES_TYPE tbm
WHERE thn = '".$tahun."'
AND bln = '".$bulan."' 
GROUP BY CO, THN, BLN
)
GROUP BY CO, THN, BLN
)tbkkl left join(
    select tbmpo.*,tbmposum.porsitot from(
    select vkorg,budat,sum(porsi) as porsi
    from zreport_porsi_sales_region
    where region = 5
    and budat like '".$tahun.$bulan."%'
    group by vkorg,budat
    )tbmpo left join  (
    select vkorg,sum(porsi) as porsitot
    from zreport_porsi_sales_region
    where region = 5
    and budat like '".$tahun.$bulan."%'
    group by vkorg
    )tbmposum on(tbmpo.vkorg=tbmposum.vkorg)
    order by tbmpo.vkorg,tbmpo.budat
)tbmlll on(tbkkl.co=tbmlll.vkorg)
group by tbkkl.co,tbmlll.budat
order by tbkkl.co,tbmlll.budat asc ) a

left join (
select vkorg,to_char(budat,'yyyymmdd') as dateday,nvl(sum(net-netwr),0) as rev_real
from zreport_real_penjualan a
where
to_char(budat,'yyyymm')='".$tahun.$bulan."'
and (
    (MATNR like '121-301%' and MATNR <> '121-301-0240') or
     (MATNR like '121-302%' and MATNR <> '121-302-0100')
)
and lfart<>'ZNL' and lfart <>'ZLFE' and add01<>'S11LO'
and NETWR is not null
group by vkorg,to_char(budat,'yyyymmdd') ) b on a.co = b.vkorg and a.budat= b.dateday
where a.co = '".$company."'";

$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {

//    $company = $rowID['CO'];
//    $tgl = $rowID['TGL'];
//    $bulan = $rowID['BULAN'];
//    $tahun = $rowID['TAHUN'];
//    $tanggal = $tahun.$bulan.$tgl;
//    $real_val = $rowID['REV_REAL'];
//    $rkap_val = $rowID['REVENUE_JADI'];
    
    $company = $rowID['CO'];
    $tgl = $rowID['DATEDAY'];
//    $bulan = $rowID['BULAN'];
//    $tahun = $rowID['TAHUN'];
//    $tanggal = $tahun.$bulan.$tgl;
    $real_val = $rowID['REV_REAL'];
    $rkap_val = $rowID['RKAP_REVENU'];


    $text[$tgl] = array(
        "tanggal" => $tgl,
        "real" => $real_val,
        "rkap" => $rkap_val
    );
}

echo '{"rkap":"' . $rkap . '","' . $company . '":' . json_encode($text) . '}';
?>