<?php
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}
else{$tahun = date('Y');}

$conn = oci_connect($user, $pass,$_ora_sco);
$sql = "SELECT
	NAMA_PERUSAHAAN,
	NM_PROV_1,
	QTY
FROM
	ZREPORT_MS_RKAPMS
INNER JOIN M_PROVINSI ON ZREPORT_MS_RKAPMS.PROPINSI = M_PROVINSI.KD_PROV
WHERE THN = ".$tahun."
ORDER BY  NAMA_PERUSAHAAN";

$queryOracle = oci_parse($conn,$sql);  
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
				
			$nama = $rowID['NAMA_PERUSAHAAN'];
			$prov = $rowID['NM_PROV_1'];
			$qty_real = $rowID['QTY'];
			
			$text[$prov]= array(
						"qty"=> $qty_real						
			);
			
			$mine[$nama][$prov]= array(
						"data"=> $qty_real						
			);
		}
		echo json_encode($mine);
?>