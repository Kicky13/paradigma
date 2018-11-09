<?php
$ldap['user'] = "afendi"; 
$ldap['pass'] = "Semenindonesia2015";				
$ldap['host'] = '10.15.3.121';
$ldap['port'] = 389;
$ldap['conn'] = ldap_connect($ldap['host'], $ldap['port']);
if(!$ldap['conn']){
	$this->notice->error("Can not connect to ldap server");
	unset($user);
	$user = NULL;
}
else{
	ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
	$ldap['bind'] = ldap_bind($ldap['conn'], $ldap['user'], $ldap['pass']);
	if(!$ldap['bind']){
		unset($user);
		$user = NULL;
	}
	else{
		echo "login success\n";
		print_r($ldap);
	}
	ldap_close($ldap['conn']);
}
?>
