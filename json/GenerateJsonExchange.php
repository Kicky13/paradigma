<?php
///error_reporting(1);
header('Access-Control-Allow-Origin: *');
$user = "par4digma";
$pass = "S3menGres1k";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.146)(PORT = 1521))) (CONNECT_DATA = (SID = PAR4DIGMA)(SERVER = DEDICATED)))';
$conn = oci_connect($user, $pass,$_ora_sco);

$companys = array('sg' => '7000','sp' => '3000', 'tlcc' => '6000', 'st' => '4000');
echo $companys;
//$companygr = array('sg' => '7','sp' => '3', 'tlcc' => '6', 'st' => '4'); 
/*$year = date('Y'); //20161121//yyyymmdd
echo $year;
$month = array(
	'jan' => 1,
	'feb' => 2,
	'mar' => 3,
	'apr' => 4,
	'mei' => 5,
	'jun' => 6,
	'jul' => 7,
	'agu' => 8,
	'sep' => 9,
	'okt' => 10,
	'nov' => 11,
	'des' => 12
	);
$com = $company[0];
// $opco = array();
$tmp = array();

//company
//7000 - 3000 - 7000

$sql = "select DISTINCT
man,
fcurr,
tcurr,
GDATU,
sum(TO_BINARY_FLOAT(UKURS)) VALKURS
from 
EXCHANGE_RATE
WHERE
SUBSTR(GDATU, 7, 4) = '2017'
GROUP BY
MAN,
FCURR,
GDATU,
TCURR
ORDER BY
GDATU ASC");

	while ($rowID=mysql_fetch_array($sql)){
		$idJson[$rowID['man']][$rowID['gdatu']] = array(
										'MAN' => $rowID['man'],
										'FCURR'  => $rowID['fcurr'],
										'TCURR' => $rowID['tcurr'],
										'GDATU'  => $rowID['gdatu'],
										'VALKURS' => $rowID['valkurs']
										);
	}
	echo json_encode($idJson);*/
?>