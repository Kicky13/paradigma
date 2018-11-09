<?php
/*
 * 1. check new insiden (1menitan). insiden ditentukan berdasarkan data terakhir ---> ID_PRODUCTION_HOURLY, PER AREA, PER KOMPONEN
 * 2. verify unsolved insiden (1menitan)
 * 3. kirim notifikasi
 * */
define('APP_PATH','/home/arca/htdocs/QMOnline/');
require_once(APP_PATH."application/config/database.php");

$db = oci_connect('qm427','qm','//localhost/xe');

$h = date("H");

if($h == 0){
	$inh = "22,23,0";
}
elseif($h == 1){
	$inh = "23,0,1";
}
elseif($h == 2){
	$inh = "0,1,2";
}
else{
	$s = $h-3;
	$inh = "";
	for($i=$s;$i<=$h;$i++){
		$inh .= $i.",";
	}
	$inh = substr($inh,0,-1);
}


$s = "
select * from (
  select r.*, ROWNUM rnum from (
		select * from T_PRODUCTION_HOURLY a, D_PRODUCTION_HOURLY b
		WHERE a.ID_PRODUCTION_HOURLY=b.ID_PRODUCTION_HOURLY
		order by DATE_DATA desc, JAM desc
  ) r where rownum <= 3
) where rnum >= 0

";

$p = oci_parse($db,$s);
$x = oci_execute($p);
while($r = oci_fetch_object($x)){
	//cek standard: C_RANGE_NCQR area+idcomponent
	$cs = "select * from c_range_ncqr where ID_AREA='".$r->ID_AREA."' and ID_COMPONENT='".$r->ID_COMPONENT."' ";
	$cp = oci_parse($db,$cs);
	$cx = oci_execute($cp);
	$cr = oci_fetch_object($cx);
	
	if($r->
}
