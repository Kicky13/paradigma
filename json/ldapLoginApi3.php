<?php
$user = "par4digma";
$pass = "S3m3n6resik";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = sggdata3.semenindonesia.com)(PORT = 1521))) (CONNECT_DATA = (SID = sgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    exit();
}
	if ($_GET['username']) {
		$user = $_GET['username'];
		$pass = $_GET['password'];
		$sql = "select * from PAR4_USERLIST WHERE USERNAME = '$user'";

		$user = strtolower($user);
		$sql = "select * from PAR4_USERLIST A JOIN PAR4_USERROLE B ON A.USERNAME = B.USERNAME WHERE A.USERNAME = '$user'";
		$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		$fetch = oci_fetch_assoc($queryOracle);

		if ($fetch) {
			# code...
			$result['status'] = 'true';
			$result['data'] = $fetch;
		}else{
			$result['status'] = 'false';

		}
			
		echo json_encode($result);
	}

/* End of file ldapLoginApi.php */
/* Location: ./application/controllers/ldapLoginApi.php */