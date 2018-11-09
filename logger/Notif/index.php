<?php
date_default_timezone_set("Asia/Jakarta");
error_reporting(0);
include "conn1.php";
echo "================\n";
echo "| Alert Notif |\n";
echo "================\n";
$sql = mysql_query("select id_rekap,id_mesin,status,tanggal 
					from t_rekap1 
					where status_tampil = 1");
while($row = mysql_fetch_array($sql))
{
	$idr = $row[0];
	$idm = $row[1];
	$sts = $row[2];
	$tgl = $row[3];
	
	$sql1 = mysql_query("select nama from m_workcenter where id_mesin = $idm");
	$row1 = mysql_fetch_array($sql1);
	$mesin= $row1[0];
	if($sts == 0)
	{$status = "OFF";}
	else
	{$status = "ON";}
	
	if($mesin != 'Unknown')
	{
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);
		$pesan 	= "$mesin $status pada tanggal $tgl";
		$pesan1 = urlencode($pesan);
		$chatid = "-227606812";  												//	Alert DB
		// $token 	= "330608345:AAHt5ui-OjdaBUXJoeA8BE4GUTlDPHkzVDk"; 			// 	Sinichi BOT
		$token 	= "369990072:AAHACjGu1krrbJJNB9Q21kw989VUELiagYo"; 				// 	SMIGBOT
		$url 	= "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan1";
		$json 	= file_get_contents($url, false, stream_context_create($arrContextOptions));
		$update = mysql_query("update t_rekap1 set status_tampil = 2, interval_waktu = '$pesan1' where id_rekap = $idr");
		echo "
			$idr. $pesan \n
		";
		sleep(1);
	}	
}
?>