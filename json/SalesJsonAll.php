<title>Json</title>
<?php

header('Access-Control-Allow-Origin: *');
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_sco);

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
if (isset($_GET['company'])){
 if (!empty($_GET['company'])) {
     switch ($_GET['company']) {
         case 3000 :
             $company = 3000;
             break;
         case 4000 :
             $company = 4000;
             break;
         case 5000 :
             $company = 5000;
             break;
         case 6000 :
             $company = 6000;
             break;
         case 7000 :
             $company = 7000;
             break;
         default :
             $company = 7000;
     }
 } else {
     $company = null;
 } 
}else{
  $company = null;  
}
$sql = '';

if ($company == null){
 $sql_rkap = "SELECT
            THN,
            BLN,
            SUM (quantum) AS RKAP
        FROM
            SAP_T_RENCANA_SALES_TYPE
        WHERE
            co IN ('4000','7000','3000','6000')
        AND thn = '" . $tahun . "'
        AND bln = '" . $bulan . "'
        GROUP BY
            THN,
            BLN";
             $sql = "select * from (select tbreal.*, tbrkap.rkap_jadi FROM
        (select * from 
        (select com,typem,substr(tanggal,0,4) as tahun,substr(tanggal,5,2) as bulan,substr(tanggal,7,2) as tgl , sum(reals) as reals FROM
        (select com, typem, tanggal, sum(real) as reals from (
        --semen gresik
        select com,typem, tanggal, sum(real) as real from(
            select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
            from zreport_rpt_real
            where        
            to_char(tgl_cmplt,'YYYYMM') like '".$tahun.$bulan."%'
            and ( (order_type <>'ZNL' and
            (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
            and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
            and sold_to like '0000000%'
            group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
            )
            group by com,typem,tanggal
        UNION
        --semen padang 
            select com, typem, tanggal, sum(real) as real from(
            select vkorg as com, substr(matnr,0,7) as typem,to_char(WADAT_IST,'yyyymmdd') as tanggal, sum(ton) as real
            from zreport_ongkosangkut_mod
            where                
            to_char(wadat_ist,'yyyymmdd') like '".$tahun.$bulan."%'
            and lfart <>'ZNL'
            and ((matnr like '121-301%' and matnr <> '121-301-0240'  ) or (matnr like '121-302%'))
            and vkorg = '3000'
            and kunag not in ('0000040084','0000040147','0000040272')
            group by vkorg,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
            )
            group by com,typem, tanggal
        union
        -- semen tonasa 
            select com,typem, tanggal, sum(real) as real from(
            select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
            from zreport_rpt_real_st
            where        
            to_char(tgl_cmplt,'YYYYMM') LIKE '".$tahun.$bulan."%'
            and ( (order_type <>'ZNL' and
            (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
            and order_type <>'ZNL') ) and com = '4000' and no_polisi <> 'S11LO'
            and sold_to like '000000%'
            and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
            and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
            and ORDER_TYPE<>'ZLFE'
            group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
            union
            select ti.COM,substr(item_no,0,7) as typem,to_char(TGL_DO,'YYYYMMDD') as tanggal,sum(ti.KWANTUMX) as real
            from ZREPORT_RPT_REAL_NON70_ST ti
            where ti.ITEM_NO LIKE '121-301%'
            and item_no <> '121-301-0240'
            and ti.COM='4000'
                and TI.TGL_DO LIKE '".$tahun.$bulan."%'
            and ti.ROUTE='ZR0001'
            and ti.STATUS in ('50')
            and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
            group by ti.COM,substr(item_no,0,7),to_char(TGL_DO,'YYYYMMDD')
            )group by COM,typem,tanggal
        UNION
        --tlcc
        select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
        from zreport_rpt_real_tlcc
        where 
        to_char(TGL_SPJ,'yyyymm')like '".$tahun.$bulan."%'
        and order_type <>'ZNL'
        and propinsi_to like '6%'
        and item_no like '121-3%'
        and com = '6000'
        group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
        UNION
        select VKORG as com,substr(matnr,0,7) as typem,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD
            where VKORG in ('7000','6000','3000','4000') and LFART='ZLR' and
            to_char(wadat_ist,'YYYYMM') like '".$tahun.$bulan."%'
            and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
            and kunag like '0000000%'
            and kunnr not like '000000%'
            and kunag not in ('0000040084','0000040147','0000040272','0000000888')  
            and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
            group by VKORG,vkbur,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd'))
        GROUP BY com, typem,tanggal)
        group by com, typem,substr(tanggal,0,4),substr(tanggal,5,2),substr(tanggal,7,2)))tbreal
        LEFT JOIN
        (SELECT TB4.com,TB4.TIPE,TB4.tahun,TB4.bulan,TB4.TANGGAL,((tb4.RKAP_H)*tb3.RKAP/100) as RKAP_JADI
        FROM
        (select tb1.com,TB1.TIPE,TB1.tahun,TB1.bulan,TB1.tanggal,TB1.PORSI,tb2.porsi_total, ((tb1.porsi/tb2.porsi_total)*100) as RKAP_H 
        from
        (select * from
        (SELECT vkorg as com,tipe,substr(budat,0,4) as tahun,substr(budat,5,2) as bulan,substr(budat,7,2) as tanggal,porsi
        from ZREPORT_PORSI_SALES_REGION
        where vkorg in ('7000','6000','3000','4000') and budat like '".$tahun.$bulan."%' and region=5)) tb1
        LEFT JOIN (
        (SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
        from ZREPORT_PORSI_SALES_REGION
        where vkorg in ('7000','6000','3000','4000') and budat like '".$tahun.$bulan."%' and region=5
        GROUP BY vkorg,region,tipe) tb2
        ) on (TB1.com=TB2.vkorg and tb1.tipe=tb2.tipe)
        )tb4
        LEFT JOIN (
        (SELECT COM,TIPE,TAHUN,BULAN,sum(target_rkap) as  RKAP 
        from ZREPORT_RPTREAL_RESUM
        where COM in ('7000','6000','3000','4000') and TAHUN='".$tahun."' and BULAN='".$bulan."' AND TIPE<>'121-200'
        GROUP BY COM,TIPE,TAHUN,BULAN)tb3)
        on (TB4.com = TB3.com and TB4.TIPE=TB3.tipe and TB4.TAHUN=TB3.TAHUN and TB4.bulan=TB3.BULAN))tbrkap
        on TBREAL.COM=TBRKAP.COM and TBREAL.TYPEM=TBRKAP.TIPE and TBREAL.tahun=TBRKAP.tahun and TBREAL.bulan=TBRKAP.BULAN and TBREAL.tgl=TBRKAP.TANGGAL)
        where COM in ('7000','6000','3000','4000')
";

}else{
 $sql_rkap = "SELECT
            CO,
            -- TIPE,
            THN,
            BLN,
            SUM (quantum) AS RKAP
        FROM
            SAP_T_RENCANA_SALES_TYPE
        WHERE
            co = '" . $company . "'
        AND thn = '" . $tahun . "'
        AND bln = '" . $bulan . "'
        GROUP BY
            CO,
            -- TIPE,
            THN,
            BLN";

$sql = "select * from (select tbreal.*, tbrkap.rkap_jadi FROM
        (select * from 
        (select com,typem,substr(tanggal,0,4) as tahun,substr(tanggal,5,2) as bulan,substr(tanggal,7,2) as tgl , sum(reals) as reals FROM
        (select com, typem, tanggal, sum(real) as reals from (
        --semen gresik
        select com,typem, tanggal, sum(real) as real from(
            select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
            from zreport_rpt_real
            where        
            to_char(tgl_cmplt,'YYYYMM') like '".$tahun.$bulan."%'
            and ( (order_type <>'ZNL' and
            (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
            and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
            and sold_to like '0000000%'
            group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
            )
            group by com,typem,tanggal
        UNION
        --semen padang 
            select com, typem, tanggal, sum(real) as real from(
            select vkorg as com, substr(matnr,0,7) as typem,to_char(WADAT_IST,'yyyymmdd') as tanggal, sum(ton) as real
            from zreport_ongkosangkut_mod
            where                
            to_char(wadat_ist,'yyyymmdd') like '".$tahun.$bulan."%'
            and lfart <>'ZNL'
            and ((matnr like '121-301%' and matnr <> '121-301-0240'  ) or (matnr like '121-302%'))
            and vkorg = '3000'
            and kunag not in ('0000040084','0000040147','0000040272')
            group by vkorg,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
            )
            group by com,typem, tanggal
        union
        -- semen tonasa 
            select com,typem, tanggal, sum(real) as real from(
            select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
            from zreport_rpt_real_st
            where        
            to_char(tgl_cmplt,'YYYYMM') LIKE '".$tahun.$bulan."%'
            and ( (order_type <>'ZNL' and
            (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
            and order_type <>'ZNL') ) and com = '4000' and no_polisi <> 'S11LO'
            and sold_to like '000000%'
            and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
            and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
            and ORDER_TYPE<>'ZLFE'
            group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
            union
            select ti.COM,substr(item_no,0,7) as typem,to_char(TGL_DO,'YYYYMMDD') as tanggal,sum(ti.KWANTUMX) as real
            from ZREPORT_RPT_REAL_NON70_ST ti
            where ti.ITEM_NO LIKE '121-301%'
            and item_no <> '121-301-0240'
            and ti.COM='4000'
                and TI.TGL_DO LIKE '".$tahun.$bulan."%'
            and ti.ROUTE='ZR0001'
            and ti.STATUS in ('50')
            and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
            group by ti.COM,substr(item_no,0,7),to_char(TGL_DO,'YYYYMMDD')
            )group by COM,typem,tanggal
        UNION
        --tlcc
        select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
        from zreport_rpt_real_tlcc
        where 
        to_char(TGL_SPJ,'yyyymm')like '".$tahun.$bulan."%'
        and order_type <>'ZNL'
        and propinsi_to like '6%'
        and item_no like '121-3%'
        and com = '6000'
        group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
        UNION
        select VKORG as com,substr(matnr,0,7) as typem,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD
            where VKORG in ('7000','6000','3000','4000') and LFART='ZLR' and
            to_char(wadat_ist,'YYYYMM') like '".$tahun.$bulan."%'
            and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
            and kunag like '0000000%'
            and kunnr not like '000000%'
            and kunag not in ('0000040084','0000040147','0000040272','0000000888')  
            and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
            group by VKORG,vkbur,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd'))
        GROUP BY com, typem,tanggal)
        group by com, typem,substr(tanggal,0,4),substr(tanggal,5,2),substr(tanggal,7,2)))tbreal
        LEFT JOIN
        (SELECT TB4.com,TB4.TIPE,TB4.tahun,TB4.bulan,TB4.TANGGAL,((tb4.RKAP_H)*tb3.RKAP/100) as RKAP_JADI
        FROM
        (select tb1.com,TB1.TIPE,TB1.tahun,TB1.bulan,TB1.tanggal,TB1.PORSI,tb2.porsi_total, ((tb1.porsi/tb2.porsi_total)*100) as RKAP_H 
        from
        (select * from
        (SELECT vkorg as com,tipe,substr(budat,0,4) as tahun,substr(budat,5,2) as bulan,substr(budat,7,2) as tanggal,porsi
        from ZREPORT_PORSI_SALES_REGION
        where vkorg in ('7000','6000','3000','4000') and budat like '".$tahun.$bulan."%' and region=5)) tb1
        LEFT JOIN (
        (SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
        from ZREPORT_PORSI_SALES_REGION
        where vkorg in ('7000','6000','3000','4000') and budat like '".$tahun.$bulan."%' and region=5
        GROUP BY vkorg,region,tipe) tb2
        ) on (TB1.com=TB2.vkorg and tb1.tipe=tb2.tipe)
        )tb4
        LEFT JOIN (
        (SELECT COM,TIPE,TAHUN,BULAN,sum(target_rkap) as  RKAP 
        from ZREPORT_RPTREAL_RESUM
        where COM in ('7000','6000','3000','4000') and TAHUN='".$tahun."' and BULAN='".$bulan."' AND TIPE<>'121-200'
        GROUP BY COM,TIPE,TAHUN,BULAN)tb3)
        on (TB4.com = TB3.com and TB4.TIPE=TB3.tipe and TB4.TAHUN=TB3.TAHUN and TB4.bulan=TB3.BULAN))tbrkap
        on TBREAL.COM=TBRKAP.COM and TBREAL.TYPEM=TBRKAP.TIPE and TBREAL.tahun=TBRKAP.tahun and TBREAL.bulan=TBRKAP.BULAN and TBREAL.tgl=TBRKAP.TANGGAL)
        WHERE COM = '".$company."'
";

}

$queryOracle2 = oci_parse($conn, $sql_rkap);
oci_execute($queryOracle2);
$total_rkap = 0;

while ($rowID = oci_fetch_array($queryOracle2)) {

    $total_rkap = $total_rkap + $rowID['RKAP'];
}

// echo $sql;
// $text ='';

$queryOracle = '';
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
$total_actual = 0;
// $text = array();
$row = '';
while ($row = oci_fetch_assoc($queryOracle)) {
    # code...

	// $real = '';
	// $rkap = '';
	// $date = '';
    $comp = 7000;
    $tipe = $row['TYPEM'];
    if ($tipe == '121-301') {
        $myType = 'zak';
    } else if ($tipe == '121-302') {
        $myType = 'curah';
    }

    $real = $row['REALS'];
    $rkap = $row['RKAP_JADI'];
    $tanggal = $row['TGL'];
    $bulan = $row['BULAN'];
    $tahun = $row['TAHUN'];
    $date = "$tahun$bulan$tanggal";
 //    // echo $date;
 //    echo $rkap;
    $total_actual = $total_actual + $real;

    $text[$myType][$date] = array(
            'tipe' => $tipe,
            'tanggal' => $date,
            'real' => $real,
            'rkap' => $rkap,

        );
     // $text[$myType][$date] = $row; 
    

        

}
// while ($rowID = oci_fetch_array($queryOracle)) {

//     $comp = 7000;
//     $tanggal = $rowID['TAHUN'].$rowID['BULAN'].$rowID['TGL'];
//     $tipe = $rowID['TYPEM'];
//     $real_val = $rowID['REALS'];
//     $rkap_val = $rowID['RKAP_JADI'];
//     // echo $rowID['RKAP_JADI']."-".$rkap_val."\n";
//     $total_actual = $total_actual + $real_val;

//     if ($tipe == '121-301') {
//         $myType = 'zak';
//     } else if ($tipe == '121-302') {
//         $myType = 'curah';
//     }
//     $text[$myType][$tanggal] = array(
//         "tipe" => $tipe,
//         "tanggal" => $tanggal,
//         "real" => number_format($real_val,2,".",""),
//         "rkap" => number_format($rkap_val,2,".",""),
      
//     );
  
// }
// echo json_encode($text);
// $myjson['rkap'] = $rkap;
// $myjson['actual'] = $total_actual;
// $myjson[$comp] = $text;
// echo json_encode($myjson);
echo '{"rkap":"' . $total_rkap . '", "actual":"'.$total_actual.'","' . $comp . '":' . json_encode($text) . '}';
?>