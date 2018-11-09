<?php
/*	1 MINOR 1 (0JAM)
 *  2 MINOR 2 (3JAM)
 *  3 MAYOR 1 (9JAM)
 *  4 MAYOR 2 (10JAM DST)
 * */

 
#define('APP_PATH','/usr/share/nginx/html/qmonline/');
#require_once(APP_PATH."application/config/database.php");

$db = oci_connect('qmuser','qmp4sswD','//10.15.5.101/devsgg');


$s = "select a.*, floor(24 * (SYSDATE - a.TANGGAL) ) as DD from M_INCIDENT a where a.ID_SOLUTION is NULL order by a.ID_INCIDENT asc"; #echo $s."\n";
$s = oci_parse($db,$s);
$x = oci_execute($s);
while($r = oci_fetch_object($s)){
	print_r($r);
	$ID_JABATAN = NULL;
	if($r->ID_INCIDENT_TYPE == 1){
		if($r->DD == 0){
			$ID_JABATAN = 1;
		}
		if($r->DD == 3){
			$ID_JABATAN = "1,2";
		}
	}
	if($r->ID_INCIDENT_TYPE == 2){
		if($r->DD == 3){
			$ID_JABATAN = "1,2";
		}
	}
	if($r->ID_INCIDENT_TYPE == 3){
		if($r->DD == 6){
			$ID_JABATAN = "1,2,3";
		}
	}
	if($r->ID_INCIDENT_TYPE == 4){
		$ID_JABATAN = "1,2,3,4";
	}
	
	if($r->DD >= 4){
		$ID_JABATAN = "1,2,3,4";
		$r->ID_INCIDENT_TYPE = 3;
	}
	
	IF($ID_JABATAN){
		//PEJABAT
		$ps = "select * from M_OPCO where ID_AREA='".$r->ID_AREA."' and ID_JABATAN in (".$ID_JABATAN.")"; #echo $ps."\n";
		$ps = oci_parse($db,$ps);
		$px = oci_execute($ps);
		while($pr = oci_fetch_object($ps)){
			$to = $pr->EMAIL;
			$subject = $r->SUBJECT;
			$txt = "".$r->SUBJECT."\n".$r->DESCRIPTION."";
			$headers = "From: qm@semenindonesia.com" . "\r\n";

			echo "send mail to $to ".((mail($to,$subject,$txt,$headers))?"ok":"fail")."\n";

			$en = "insert into T_NOTIFIKASI (ID_NOTIFIKASI, ID_OPCO, ID_INCIDENT, ID_JABATAN, TANGGAL) 
				   values(SEQ_ID_NOTIFIKASI.NEXTVAL, '".$pr->ID_OPCO."', '".$r->ID_INCIDENT_TYPE."', '".$pr->ID_JABATAN."', SYSDATE)"; #echo $en."\n";
			$en = oci_parse($db, $en);
			$ex = oci_execute($en);
		}
		
		//update
		if($r->ID_INCIDENT_TYPE <= 3){
			$NEW_ID_INCIDENT = $r->ID_INCIDENT_TYPE+1;
			$us = "update M_INCIDENT set ID_INCIDENT_TYPE=".$NEW_ID_INCIDENT." WHERE ID_INCIDENT=".$r->ID_INCIDENT.""; #echo $us."\n";
			$us = oci_parse($db,$us);
			$ux = oci_execute($us);
		}
	}
}
