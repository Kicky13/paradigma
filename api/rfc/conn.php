<?php
///development
	$saplogin_ashost = "10.15.5.25";
	$saplogin_sysnr  = "00";
	$saplogin_client = "030";
	$saplogin_user   = "zamrony";
	$saplogin_passwd = "pendamelanku";

	function getMysqlStr($text){
		$hasil = trim($text);
		$hasil = mysql_real_escape_string($hasil);
		return $hasil;
	}


?>