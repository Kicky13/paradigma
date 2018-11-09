<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LdapLoginApi extends CI_Controller {

	public function index()
	{
	if ($_POST['username']) {
	$user = $_POST['username'];
	$pass = $_POST['password'];

	//$ldap_server = "ldap://smig.corp";
	$ldap_server = "10.15.3.121";
	$auth_user = $user;
	$domain = "@smig.corp";
	$auth_pass = $pass;

	$connect=@ldap_connect($ldap_server);

	if (!($bind=@ldap_bind($connect,$auth_user.$domain,$auth_pass))) {
	  die ("false");
	}else{
		echo 'true';
	}
	}
}

}

/* End of file ldapLoginApi.php */
/* Location: ./application/controllers/ldapLoginApi.php */