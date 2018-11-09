<?php
/*	1 MINOR 1 (0JAM)
 *  2 MINOR 2 (3JAM)
 *  3 MAYOR 1 (9JAM)
 *  4 MAYOR 2 (10JAM DST)
 * */
 
#define('APP_PATH','/home/arca/htdocs/QMOnline/');
#require_once(APP_PATH."application/config/database.php");

$db = oci_connect('mso','s3mengres1k','//10.15.5.122/pmdb'); #var_dump($db); exit;

$dev = oci_connect("qmuser","qmp4sswD","//10.15.5.101/devsgg");

$s = "select ID_USER, ID_GROUPMENU, ID_MENU, ACTION, URL, IP_ADDRESS, to_char(WAKTU,'DD-MM-YYYY') as WAKTU from access_log where to_char(WAKTU,'MM-YYYY')='08-2017'";
$s = oci_parse($dev,$s);
$sx = oci_execute($s);
while($r = oci_fetch_object($s)){
	$u = "INSERT INTO access_log (ID_USER, ID_GROUPMENU, ID_MENU, ACTION, URL, IP_ADDRESS, WAKTU) VALUES(
			'".$r->ID_USER."','".$r->ID_GROUPMENU."','".$r->ID_MENU."','".$r->ACTION."','".$r->URL."','".$r->IP_ADDRESS."',to_date('".$r->WAKTU."','DD-MM-YYYY'))"; ECHO $u."\r\n";
	$u = oci_parse($db,$u);
	$x = oci_execute($u);
	
}
