<?php
function division($a, $b) {   
 if ($a == '' || empty($a) || $a == null){
  $a = 0;
 }    
 if($b == 0){
  return 0;
 }else{
   try {
    $tmp = floatval($a)/floatval($b);  
   } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
   }
  return $tmp;
 }
}    
function date_between($date){
 $datestr = explode(".",$date);
 $period = array();
 for ($x=1;$x<=intval($datestr[1]);$x++){
  $tmp = '0'.$x;
  array_push($period, "'".(intval($datestr[0])).'.'.substr($tmp,-2)."'");    
 } 
 return implode($period,",");
}

$user = "smigapp";
$pass = "smigapp123";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.144)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = pdbsi)(SERVER = DEDICATED)))';

$filter['date'] = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
$filter['company'] = (empty($_GET['company']) ? 'smi' : $_GET['company']);
$date_lmonth = date('Y-m-d', strtotime('first day of last month'));
$date_lyear      = (intval(substr($filter['date'], 0, 4)) - 1).substr($filter['date'],4);
$temp           = date_between($filter['date']);
$temp_lyear     = date_between($date_lyear);
if($filter['company'] == '2000'){
 $company = " and COMPANY in ('2000')"; 
 $company_acc = "S.GL_ACCOUNT in ('PSV_2000','GSV_2000') and ";
 $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
 $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390'";
}else if($filter['company'] == '3000'){
 $company = " and COMPANY in ('3000')"; 
 $company_acc = "S.GL_ACCOUNT in ('PSV_3000','GSV_3000') and ";
 $plant      = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
 $plant2     = "'P_3301','P_3302','P_3303','P_3304','P_3309'";
}else if($filter['company'] == '4000'){
 $company = " and COMPANY in ('4000')"; 
 $company_acc = "S.GL_ACCOUNT in ('PSV_4000','GSV_4000') and ";
 $plant      = "'P_4301','P_4302','P_4303'";
 $plant2     = "'P_4301','P_4302','P_4303'";
}else if($filter['company'] == '7000'){
 $company = " and COMPANY in ('7000')"; 
 $company_acc = "S.GL_ACCOUNT in ('PSV_7000','GSV_7000') and ";
 $plant      = "'P_7302','P_7303','P_7304','P_7305'";
 $plant2     = "'P_7301','P_7302','P_7303','P_7304','P_7305'";
}else if($filter['company'] == "2000','7000"){
 $company = " and COMPANY in ('2000',7000')";
 $company_acc = "S.GL_ACCOUNT in ('PSV_2000','GSV_2000','PSV_7000','GSV_7000') and ";
 $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7302','P_7303','P_7304','P_7305'";
 $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_7301','P_7302','P_7303','P_7304','P_7305'";
}else if($filter['company'] == 'smi'){
 $company = "";
 $company_acc = "";
 $plant      = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7302','P_7303','P_7304','P_7305'";
 $plant2     = "'P_2301','P_2302','P_2303','P_2304','P_2305','P_2390','P_3301','P_3302','P_3303','P_3304','P_3309','P_4301','P_4302','P_4303','P_7301','P_7302','P_7303','P_7304','P_7305'";
}else if($filter['company'] == '5000'){
 $company = " and COMPANY in ('5000')";
 $company_acc = "S.GL_ACCOUNT in ('PSV_5000','GSV_5000') and ";
 $plant      = "'P_5302','P_5303','P_5304','P_5305'";
 $plant2     = "'P_5301','P_5302','P_5303','P_5304','P_5305'";
}

$conn = oci_connect($user, $pass, $_ora_sco);
$tmp_clinker = array('selected'=>0,'lastmonth'=>0);
$tmp_cement = array('selected'=>0,'lastmonth'=>0);
$tmp_salesvol = array('selected'=>0,'lastmonth'=>0);
$tmp_data = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);
$tmp_rkap_data = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);
$tmp_data_lyear = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);
$tmp_data_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);
$tmp_rkap_data_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);
$tmp_data_lyear_up = array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,'08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'29'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0);

$sql = "select NVL(SUM(AMOUNT),0) AS AMOUNT from PRODUCTION where CATEGORY = 'ACT' and PLANT IN ($plant) and FISCAL_YEAR_PERIOD IN ({$filter['date']}) and GL_ACCOUNT = 'PRD_QTY' and MATERIAL IN ('121_200_0010', '121_200_0040', '121_200_0020')".$company;
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_clinker['selected'] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);

$sql = "select NVL(SUM(AMOUNT),0) AS AMOUNT from PRODUCTION where CATEGORY = 'ACT' and PLANT IN ($plant) and FISCAL_YEAR_PERIOD IN ({$date_lmonth}) and GL_ACCOUNT = 'PRD_QTY' and MATERIAL IN ('121_200_0010', '121_200_0040', '121_200_0020')".$company;
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_clinker['lastmonth'] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);

$sql = "select NVL(SUM(AMOUNT),0) AS AMOUNT from PRODUCTION where CATEGORY = 'ACT' and PLANT IN ($plant) and FISCAL_YEAR_PERIOD IN ({$filter['date']}) and GL_ACCOUNT = 'PRD_QTY' and MATERIAL IN ('121_302_0060', '121_301_0060', '121_302_0019', '121_302_0110', '121_302_0040', '121_302_0030', '121_302_0020', '121_302_0010')".$company;
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_cement['selected'] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);

$sql = "select NVL(SUM(AMOUNT),0) AS AMOUNT from PRODUCTION where CATEGORY = 'ACT' and PLANT IN ($plant) and FISCAL_YEAR_PERIOD IN ({$date_lmonth}) and GL_ACCOUNT = 'PRD_QTY' and MATERIAL IN ('121_302_0060', '121_301_0060', '121_302_0019', '121_302_0110', '121_302_0040', '121_302_0030', '121_302_0020', '121_302_0010')".$company;
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_cement['lastmonth'] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);

// $sql = "select NVL(SUM(AMOUNT),0) as AMOUNT FROM (select CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL FROM M_MATERIAL MM LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL WHERE ".$company_acc."S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') AND S.CATEGORY = 'ACT' AND S.CURRENCY = 'LC' AND FISCAL_YEAR_PERIOD IN ('{$filter['date']}') START WITH PARENTH2 IN ('200','121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2)";
// $queryOracle = oci_parse($conn, $sql);
// oci_execute($queryOracle);
// while ($rowID = oci_fetch_array($queryOracle)) {
//  $tmp_salesvol['selected'] = $rowID['AMOUNT']; 
// }
// oci_free_statement($queryOracle);

// $sql = "select NVL(SUM(AMOUNT),0) as AMOUNT FROM (select CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL FROM M_MATERIAL MM LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL WHERE ".$company_acc."S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') AND S.CATEGORY = 'ACT' AND S.CURRENCY = 'LC' AND FISCAL_YEAR_PERIOD IN ('{$date_lmonth}') START WITH PARENTH2 IN ('200','121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2)";
// $queryOracle = oci_parse($conn, $sql);
// oci_execute($queryOracle);
// while ($rowID = oci_fetch_array($queryOracle)) {
//  $tmp_salesvol['lastmonth'] = $rowID['AMOUNT']; 
// }
// oci_free_statement($queryOracle);

$sql = "select NOMOR, NVL(JUMLAH,0) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ('{$filter['date']}') and category = 'ACT' and COMPANY IN ('{$filter['company']}')";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_data[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);
$sql = "select NOMOR, NVL(JUMLAH,0) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ('{$filter['date']}') and category = 'BUD' and COMPANY IN ('{$filter['company']}')";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_rkap_data[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);
$sql = "select NOMOR, SUM(NVL(JUMLAH,0)) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($date_lyear) and category = 'ACT' and COMPANY IN ('{$filter['company']}') group by nomor";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_data_lyear[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);
$sql = "select NOMOR, SUM(NVL(JUMLAH,0)) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($temp) and category = 'ACT' and COMPANY IN ('{$filter['company']}') group by nomor";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_data_up[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);
$sql = "select NOMOR, SUM(NVL(JUMLAH,0)) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($temp) and category = 'BUD' and COMPANY IN ('{$filter['company']}') group by nomor";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_rkap_data_up[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}
oci_free_statement($queryOracle);
$sql = "select NOMOR, SUM(NVL(JUMLAH,0)) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($temp_lyear) and category = 'ACT' and COMPANY IN ('{$filter['company']}') group by nomor";
$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
while ($rowID = oci_fetch_array($queryOracle)) {
 $tmp_data_lyear_up[$rowID['NOMOR']] = $rowID['AMOUNT']; 
}

$data1 = array();
$data1['bulan_ini']['clinker']       = $tmp_clinker['selected'];
$data1['bulan_ini']['cement']        = $tmp_cement['selected'];
$data1['bulan_ini']['sales']         = 0;
$data1['bulan_lalu']['clinker']      = $tmp_clinker['lastmonth'];
$data1['bulan_lalu']['cement']       = $tmp_cement['lastmonth'];
$data1['bulan_lalu']['sales']        = 0;
$data['s'.$filter['company']] = array($data1);

$data1 = array();
$total_tmp_data = array();
$data1['bulan_ini']['Raw Material']                          = (float) $tmp_data['01'];
$data1['bulan_ini']['Supporting Material']                   = (float) $tmp_data['02'];
$data1['bulan_ini']['Fuel']                                  = (float) $tmp_data['03'];
$data1['bulan_ini']['Electricity']                           = (float) $tmp_data['04'];
$data1['bulan_ini']['Labor']                                 = (float) $tmp_data['05'];
$data1['bulan_ini']['Maintenance']                           = (float) $tmp_data['06'];
$data1['bulan_ini']['Depl. Deprec. and Amortization']        = (float) $tmp_data['07'];
$data1['bulan_ini']['General & Adminitration']               = (float) $tmp_data['08'];
$data1['bulan_ini']['Taxes and Insurance']                   = (float) $tmp_data['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_data,$tmp_data[$no]);
}
$data1['bulan_ini']['Total']                                 = (float) array_sum($total_tmp_data);

$total_tmp_rkap_data = array();
$data1['rkap_bulan_ini']['Raw Material']                     = (float) $tmp_rkap_data['01'];
$data1['rkap_bulan_ini']['Supporting Material']              = (float) $tmp_rkap_data['02'];
$data1['rkap_bulan_ini']['Fuel']                             = (float) $tmp_rkap_data['03'];
$data1['rkap_bulan_ini']['Electricity']                      = (float) $tmp_rkap_data['04'];
$data1['rkap_bulan_ini']['Labor']                            = (float) $tmp_rkap_data['05'];
$data1['rkap_bulan_ini']['Maintenance']                      = (float) $tmp_rkap_data['06'];
$data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']   = (float) $tmp_rkap_data['07'];
$data1['rkap_bulan_ini']['General & Adminitration']          = (float) $tmp_rkap_data['08'];
$data1['rkap_bulan_ini']['Taxes and Insurance']              = (float) $tmp_rkap_data['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_rkap_data,$tmp_rkap_data[$no]);
}
$data1['rkap_bulan_ini']['Total']                            = (float) array_sum($total_tmp_rkap_data);

$total_tmp_data_lyear = array();
$data1['bulan_ini_lyear']['Raw Material']                    = (float) $tmp_data_lyear['01'];
$data1['bulan_ini_lyear']['Supporting Material']             = (float) $tmp_data_lyear['02'];
$data1['bulan_ini_lyear']['Fuel']                            = (float) $tmp_data_lyear['03'];
$data1['bulan_ini_lyear']['Electricity']                     = (float) $tmp_data_lyear['04'];
$data1['bulan_ini_lyear']['Labor']                           = (float) $tmp_data_lyear['05'];
$data1['bulan_ini_lyear']['Maintenance']                     = (float) $tmp_data_lyear['06'];
$data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']  = (float) $tmp_data_lyear['07'];
$data1['bulan_ini_lyear']['General & Adminitration']         = (float) $tmp_data_lyear['08'];
$data1['bulan_ini_lyear']['Taxes and Insurance']             = (float) $tmp_data_lyear['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_data_lyear,$tmp_data_lyear[$no]);
}
$data1['bulan_ini_lyear']['Total']                           = (float) array_sum($total_tmp_data_lyear);

$total_tmp_data_up = array();
$data1['up_bulan_ini']['Raw Material']                       = (float) $tmp_data_up['01'];
$data1['up_bulan_ini']['Supporting Material']                = (float) $tmp_data_up['02'];
$data1['up_bulan_ini']['Fuel']                               = (float) $tmp_data_up['03'];
$data1['up_bulan_ini']['Electricity']                        = (float) $tmp_data_up['04'];
$data1['up_bulan_ini']['Labor']                              = (float) $tmp_data_up['05'];
$data1['up_bulan_ini']['Maintenance']                        = (float) $tmp_data_up['06'];
$data1['up_bulan_ini']['Depl. Deprec. and Amortization']     = (float) $tmp_data_up['07'];
$data1['up_bulan_ini']['General & Adminitration']            = (float) $tmp_data_up['08'];
$data1['up_bulan_ini']['Taxes and Insurance']                = (float) $tmp_data_up['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_data_up,$tmp_data_up[$no]);
}
$data1['up_bulan_ini']['Total']                              = (float) array_sum($total_tmp_data_up);

$total_tmp_rkap_data_up = array();
$data1['rkap_up_bulan_ini']['Raw Material']                     = (float) $tmp_rkap_data_up['01'];
$data1['rkap_up_bulan_ini']['Supporting Material']              = (float) $tmp_rkap_data_up['02'];
$data1['rkap_up_bulan_ini']['Fuel']                             = (float) $tmp_rkap_data_up['03'];
$data1['rkap_up_bulan_ini']['Electricity']                      = (float) $tmp_rkap_data_up['04'];
$data1['rkap_up_bulan_ini']['Labor']                            = (float) $tmp_rkap_data_up['05'];
$data1['rkap_up_bulan_ini']['Maintenance']                      = (float) $tmp_rkap_data_up['06'];
$data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']   = (float) $tmp_rkap_data_up['07'];
$data1['rkap_up_bulan_ini']['General & Adminitration']          = (float) $tmp_rkap_data_up['08'];
$data1['rkap_up_bulan_ini']['Taxes and Insurance']              = (float) $tmp_rkap_data_up['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_rkap_data_up,$tmp_rkap_data_up[$no]);
}
$data1['rkap_up_bulan_ini']['Total']                            = (float) array_sum($total_tmp_rkap_data_up);

$total_tmp_data_lyear_up = array();
$data1['up_bulan_ini_lyear']['Raw Material']                    = (float) $tmp_data_lyear_up['01'];
$data1['up_bulan_ini_lyear']['Supporting Material']             = (float) $tmp_data_lyear_up['02'];
$data1['up_bulan_ini_lyear']['Fuel']                            = (float) $tmp_data_lyear_up['03'];
$data1['up_bulan_ini_lyear']['Electricity']                     = (float) $tmp_data_lyear_up['04'];
$data1['up_bulan_ini_lyear']['Labor']                           = (float) $tmp_data_lyear_up['05'];
$data1['up_bulan_ini_lyear']['Maintenance']                     = (float) $tmp_data_lyear_up['06'];
$data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']  = (float) $tmp_data_lyear_up['07'];
$data1['up_bulan_ini_lyear']['General & Adminitration']         = (float) $tmp_data_lyear_up['08'];
$data1['up_bulan_ini_lyear']['Taxes and Insurance']             = (float) $tmp_data_lyear_up['09'];
for ($x=1;$x<=9;$x++){
 $no = '0'.$x;
 array_push($total_tmp_data_lyear_up,$tmp_data_lyear_up[$no]);
}
$data1['up_bulan_ini_lyear']['Total']                           = (float) array_sum($total_tmp_data_lyear_up);
$data['production_cost'] = array($data1);

$data1 = array();
$total_tmp_data = array();
$data1['bulan_ini']['Packaging']                  = (float) $tmp_data['11'];
$data1['bulan_ini']['Distribution']               = (float) $tmp_data['12'];
$data1['bulan_ini']['Variance Stok']              = (float) $tmp_data['13'];
$data1['bulan_ini']['WIP (Purchasing)']           = (float) $tmp_data['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_data,$tmp_data[$no]);
}
$data1['bulan_ini']['Total']                      = (float) array_sum($total_tmp_data);

$total_tmp_rkap_data = array();
$data1['rkap_bulan_ini']['Packaging']             = (float) $tmp_rkap_data['11'];
$data1['rkap_bulan_ini']['Distribution']          = (float) $tmp_rkap_data['12'];
$data1['rkap_bulan_ini']['Variance Stok']         = (float) $tmp_rkap_data['13'];
$data1['rkap_bulan_ini']['WIP (Purchasing)']      = (float) $tmp_rkap_data['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_rkap_data,$tmp_rkap_data[$no]);
}
$data1['rkap_bulan_ini']['Total']                 = (float) array_sum($total_tmp_rkap_data);

$total_tmp_data_lyear = array();
$data1['bulan_ini_lyear']['Packaging']            = (float) $tmp_data_lyear['11'];
$data1['bulan_ini_lyear']['Distribution']         = (float) $tmp_data_lyear['12'];
$data1['bulan_ini_lyear']['Variance Stok']        = (float) $tmp_data_lyear['13'];
$data1['bulan_ini_lyear']['WIP (Purchasing)']     = (float) $tmp_data_lyear['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_data_lyear,$tmp_data_lyear[$no]);
}
$data1['bulan_ini_lyear']['Total']                = (float) array_sum($total_tmp_data_lyear);

$total_tmp_data_up = array();
$data1['up_bulan_ini']['Packaging']               = (float) $tmp_data_up['11'];
$data1['up_bulan_ini']['Distribution']            = (float) $tmp_data_up['12'];
$data1['up_bulan_ini']['Variance Stok']           = (float) $tmp_data_up['13'];
$data1['up_bulan_ini']['WIP (Purchasing)']        = (float) $tmp_data_up['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_data_up,$tmp_data_up[$no]);
}
$data1['up_bulan_ini']['Total']                   = (float) array_sum($total_tmp_data_up);

$total_tmp_rkap_data_up = array();
$data1['rkap_up_bulan_ini']['Packaging']          = (float) $tmp_rkap_data_up['11'];
$data1['rkap_up_bulan_ini']['Distribution']       = (float) $tmp_rkap_data_up['12'];
$data1['rkap_up_bulan_ini']['Variance Stok']      = (float) $tmp_rkap_data_up['13'];
$data1['rkap_up_bulan_ini']['WIP (Purchasing)']   = (float) $tmp_rkap_data_up['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_rkap_data_up,$tmp_rkap_data_up[$no]);
}
$data1['rkap_up_bulan_ini']['Total']              = (float) array_sum($total_tmp_rkap_data_up);

$total_tmp_data_lyear_up = array();
$data1['up_bulan_ini_lyear']['Packaging']         = (float) $tmp_data_lyear_up['11'];
$data1['up_bulan_ini_lyear']['Distribution']      = (float) $tmp_data_lyear_up['12'];
$data1['up_bulan_ini_lyear']['Variance Stok']     = (float) $tmp_data_lyear_up['13'];
$data1['up_bulan_ini_lyear']['WIP (Purchasing)']  = (float) $tmp_data_lyear_up['14'];
for ($x=1;$x<=14;$x++){
 $no = substr('0'.$x,-2);
 array_push($total_tmp_data_lyear_up,$tmp_data_lyear_up[$no]);
}
$data1['up_bulan_ini_lyear']['Total']             = (float) array_sum($total_tmp_data_lyear_up);
$data['good_of_sold'] = array($data1);

$data1 = array();
$total_tmp_data = array();
$data1['bulan_ini']['Supporting Material']                      = (float) $tmp_data['18'];
$data1['bulan_ini']['Fuel']                                     = (float) $tmp_data['19'];
$data1['bulan_ini']['Electricity']                              = (float) $tmp_data['20'];
$data1['bulan_ini']['Labor']                                    = (float) $tmp_data['21'];
$data1['bulan_ini']['Maintenance']                              = (float) $tmp_data['22'];
$data1['bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data['23'];
$data1['bulan_ini']['General & Administration']                 = (float) $tmp_data['24']; 
$data1['bulan_ini']['Taxes and insurance']                      = (float) $tmp_data['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_data,$tmp_data[$no]);
}
$data1['bulan_ini']['Total']                                    = (float) array_sum($total_tmp_data);

$total_tmp_rkap_data = array();
$data1['rkap_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data['18'];
$data1['rkap_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data['19'];
$data1['rkap_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data['20'];
$data1['rkap_bulan_ini']['Labor']                               = (float) $tmp_rkap_data['21'];
$data1['rkap_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data['22'];
$data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data['23'];
$data1['rkap_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data['24']; 
$data1['rkap_bulan_ini']['Taxes and insurance']                 = (float) $tmp_rkap_data['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_rkap_data,$tmp_rkap_data[$no]);
}
$data1['rkap_bulan_ini']['Total']                               = (float) array_sum($tmp_rkap_data);

$total_tmp_data_lyear = array();
$data1['bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_lyear['18'];
$data1['bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_lyear['19'];
$data1['bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_lyear['20'];
$data1['bulan_ini_lyear']['Labor']                              = (float) $tmp_data_lyear['21'];
$data1['bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_lyear['22'];
$data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_lyear['23'];
$data1['bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_lyear['24']; 
$data1['bulan_ini_lyear']['Taxes and insurance']                = (float) $tmp_data_lyear['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_data_lyear,$tmp_data_lyear[$no]);
}
$data1['bulan_ini_lyear']['Total']                               = (float) array_sum($total_tmp_data_lyear);

$total_tmp_data_up = array();
$data1['up_bulan_ini']['Supporting Material']                      = (float) $tmp_data_up['18'];
$data1['up_bulan_ini']['Fuel']                                     = (float) $tmp_data_up['19'];
$data1['up_bulan_ini']['Electricity']                              = (float) $tmp_data_up['20'];
$data1['up_bulan_ini']['Labor']                                    = (float) $tmp_data_up['21'];
$data1['up_bulan_ini']['Maintenance']                              = (float) $tmp_data_up['22'];
$data1['up_bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_up['23'];
$data1['up_bulan_ini']['General & Administration']                 = (float) $tmp_data_up['24']; 
$data1['up_bulan_ini']['Taxes and insurance']                      = (float) $tmp_data_up['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_data_up,$tmp_data_up[$no]);
}
$data1['up_bulan_ini']['Total']                                    = (float) array_sum($total_tmp_data_up);

$total_tmp_rkap_data_up = array();
$data1['rkap_up_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_up['18'];
$data1['rkap_up_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_up['19'];
$data1['rkap_up_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_up['20'];
$data1['rkap_up_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_up['21'];
$data1['rkap_up_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_up['22'];
$data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_up['23'];
$data1['rkap_up_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_up['24']; 
$data1['rkap_up_bulan_ini']['Taxes and insurance']                 = (float) $tmp_rkap_data_up['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_rkap_data_up,$tmp_rkap_data_up[$no]);
}
$data1['rkap_up_bulan_ini']['Total']                               = (float) array_sum($total_tmp_rkap_data_up);

$total_tmp_data_lyear_up = array();
$data1['up_bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_lyear_up['18'];
$data1['up_bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_lyear_up['19'];
$data1['up_bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_lyear_up['20'];
$data1['up_bulan_ini_lyear']['Labor']                              = (float) $tmp_data_lyear_up['21'];
$data1['up_bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_lyear_up['22'];
$data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_lyear_up['23'];
$data1['up_bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_lyear_up['24']; 
$data1['up_bulan_ini_lyear']['Taxes and insurance']                = (float) $tmp_data_lyear_up['25'];
for ($x=18;$x<=25;$x++){
 $no = $x;
 array_push($total_tmp_data_lyear_up,$tmp_data_lyear_up[$no]);
}
$data1['up_bulan_ini_lyear']['Total']                               = (float) array_sum($total_tmp_data_lyear_up);
$data['general_administration'] = array($data1);        

$data1 = array();
$total_tmp_data = array();
$data1['bulan_ini']['Supporting Material']                      = (float) $tmp_data['29'];
$data1['bulan_ini']['Fuel']                                     = (float) $tmp_data['30'];
$data1['bulan_ini']['Electricity']                              = (float) $tmp_data['31'];
$data1['bulan_ini']['Labor']                                    = (float) $tmp_data['32'];
$data1['bulan_ini']['Maintenance']                              = (float) $tmp_data['33'];
$data1['bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data['34'];
$data1['bulan_ini']['General & Administration']                 = (float) $tmp_data['35']; 
$data1['bulan_ini']['Marketing & Distribution']                 = (float) $tmp_data['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_data,$tmp_data[$no]);
}
$data1['bulan_ini']['Total']                                    = (float) array_sum($total_tmp_data);

$total_tmp_rkap_data = array();
$data1['rkap_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data['29'];
$data1['rkap_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data['30'];
$data1['rkap_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data['31'];
$data1['rkap_bulan_ini']['Labor']                               = (float) $tmp_rkap_data['32'];
$data1['rkap_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data['33'];
$data1['rkap_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data['34'];
$data1['rkap_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data['35']; 
$data1['rkap_bulan_ini']['Marketing & Distribution']            = (float) $tmp_rkap_data['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_rkap_data,$tmp_rkap_data[$no]);
}
$data1['rkap_bulan_ini']['Total']                               = (float) array_sum($total_tmp_rkap_data);

$total_tmp_data_lyear = array();
$data1['bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_lyear['29'];
$data1['bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_lyear['30'];
$data1['bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_lyear['31'];
$data1['bulan_ini_lyear']['Labor']                              = (float) $tmp_data_lyear['32'];
$data1['bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_lyear['33'];
$data1['bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_lyear['34'];
$data1['bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_lyear['35']; 
$data1['bulan_ini_lyear']['Marketing & Distribution']           = (float) $tmp_data_lyear['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_data_lyear,$tmp_data_lyear[$no]);
}
$data1['bulan_ini_lyear']['Total']                              = (float) array_sum($total_tmp_data_lyear);

$total_tmp_data_up = array();
$data1['up_bulan_ini']['Supporting Material']                      = (float) $tmp_data_up['29'];
$data1['up_bulan_ini']['Fuel']                                     = (float) $tmp_data_up['30'];
$data1['up_bulan_ini']['Electricity']                              = (float) $tmp_data_up['31'];
$data1['up_bulan_ini']['Labor']                                    = (float) $tmp_data_up['32'];
$data1['up_bulan_ini']['Maintenance']                              = (float) $tmp_data_up['33'];
$data1['up_bulan_ini']['Depl. Deprec. and Amortization']           = (float) $tmp_data_up['34'];
$data1['up_bulan_ini']['General & Administration']                 = (float) $tmp_data_up['35']; 
$data1['up_bulan_ini']['Marketing & Distribution']                 = (float) $tmp_data_up['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_data_up,$tmp_data_up[$no]);
}
$data1['up_bulan_ini']['Total']                              = (float) array_sum($total_tmp_data_up);

$total_tmp_rkap_data_up = array();
$data1['rkap_up_bulan_ini']['Supporting Material']                 = (float) $tmp_rkap_data_up['29'];
$data1['rkap_up_bulan_ini']['Fuel']                                = (float) $tmp_rkap_data_up['30'];
$data1['rkap_up_bulan_ini']['Electricity']                         = (float) $tmp_rkap_data_up['31'];
$data1['rkap_up_bulan_ini']['Labor']                               = (float) $tmp_rkap_data_up['32'];
$data1['rkap_up_bulan_ini']['Maintenance']                         = (float) $tmp_rkap_data_up['33'];
$data1['rkap_up_bulan_ini']['Depl. Deprec. and Amortization']      = (float) $tmp_rkap_data_up['34'];
$data1['rkap_up_bulan_ini']['General & Administration']            = (float) $tmp_rkap_data_up['35']; 
$data1['rkap_up_bulan_ini']['Marketing & Distribution']            = (float) $tmp_rkap_data_up['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_rkap_data_up,$tmp_rkap_data_up[$no]);
}
$data1['rkap_up_bulan_ini']['Total']                              = (float) array_sum($total_tmp_rkap_data_up);

$total_tmp_data_lyear_up = array();
$data1['up_bulan_ini_lyear']['Supporting Material']                = (float) $tmp_data_lyear_up['29'];
$data1['up_bulan_ini_lyear']['Fuel']                               = (float) $tmp_data_lyear_up['30'];
$data1['up_bulan_ini_lyear']['Electricity']                        = (float) $tmp_data_lyear_up['31'];
$data1['up_bulan_ini_lyear']['Labor']                              = (float) $tmp_data_lyear_up['32'];
$data1['up_bulan_ini_lyear']['Maintenance']                        = (float) $tmp_data_lyear_up['33'];
$data1['up_bulan_ini_lyear']['Depl. Deprec. and Amortization']     = (float) $tmp_data_lyear_up['34'];
$data1['up_bulan_ini_lyear']['General & Administration']           = (float) $tmp_data_lyear_up['35']; 
$data1['up_bulan_ini_lyear']['Marketing & Distribution']           = (float) $tmp_data_lyear_up['36'];
for ($x=29;$x<=36;$x++){
 $no = $x;
 array_push($total_tmp_data_lyear_up,$tmp_data_lyear_up[$no]);
}
$data1['up_bulan_ini_lyear']['Total']                              = (float) array_sum($total_tmp_data_lyear_up);
$data['selling_marketing'] = array($data1);        

echo json_encode($data);
?>