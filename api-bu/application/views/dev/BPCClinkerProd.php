<title>Json</title>

<?php
$user = "devsi";
$pass = "SelaluJaya6102";
$_ora_db_pm_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.145)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = smig_dev.semenindonesia.com)(SERVER = DEDICATED)))';
        
$conn = oci_connect($user, $pass,$_ora_db_pm_dev);

 $queryOracle = oci_parse($conn,"SELECT DISTINCT
	production.plant,
	m_plant.description,
	production.amount,
	production.fiscal_year_period,
	production.material
FROM
	production
INNER JOIN m_plant ON production.plant = m_plant.plant
WHERE
	production. CATEGORY = 'ACT'
AND MATERIAL IN (
	'121_200_0010',
	'121_200_0040',
	'121_200_0020'
)
ORDER BY
	production.fiscal_year_period");
	oci_execute($queryOracle);
	while ($rowID = oci_fetch_array($queryOracle)){
		$PLANT = $rowID['PLANT'];
		$DESCRIPTION = $rowID['DESCRIPTION'];
		$AMOUNT = $rowID['AMOUNT'];
		$FISCAL_YEAR_PERIOD = $rowID['FISCAL_YEAR_PERIOD'];
		$MATERIAL = $rowID['MATERIAL'];
		
		$json[$FISCAL_YEAR_PERIOD][$PLANT] =  array(
			'plant code' => $PLANT,
			'plant desc' => $DESCRIPTION,
			'tipe' => $MATERIAL,
			'amount' => $AMOUNT
		);
	}

echo '({"message":"","status":"OK","tags":'.json_encode($json).',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';

?>