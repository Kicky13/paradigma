<?php
header("Access-Control-Allow-Origin: *");
$user = "par4digma";
$pass = "S3m3n6resik";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = sggdata3.semenindonesia.com)(PORT = 1521))) (CONNECT_DATA = (SID = sgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    exit();
}



	if ($_POST['username']) {
		$user = $_POST['username'];
		$pass = $_POST['password'];

		$sql = "select * from PAR4_USERLIST WHERE USERNAME = '$user'";



		//$ldap_server = "ldap://smig.corp";
		$ldap_server = "10.15.3.120";
		$auth_user = $user;
		$domain = "@smig.corp";
		$auth_pass = $pass;
		
		$connect=@ldap_connect($ldap_server);
		$result['status'] = 'false';
		if (!($bind=@ldap_bind($connect,$auth_user.$domain,$auth_pass))) {
		  $result['status'] = 'false';
		}else{

			$user = strtolower($user);
			$sql = "select * from PAR4_USERLIST A JOIN PAR4_USERROLE B ON A.USERNAME = B.USERNAME WHERE A.USERNAME = '$user'";
			$queryOracle = oci_parse($conn,$sql);
			oci_execute($queryOracle);
			$fetch = oci_fetch_assoc($queryOracle);

			if ($fetch) {
				# code...
				$result['status'] = 'true';
				$result['data'] = $fetch;
				$oracle="UPDATE PAR4_USERLIST SET ACTIVE_PAR='1', VISIT_PAR=VISIT_PAR+1 WHERE USERNAME = '$user'";
				$queryOracle2 = oci_parse($conn,$oracle);
				oci_execute($queryOracle2);
			}else{
				$result['status'] = 'false';

			}
			//echo 'true';
		}
		echo json_encode($result);
	}

/* End of file ldapLoginApi.php */
/* Location: ./application/controllers/ldapLoginApi.php */