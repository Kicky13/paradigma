<?php 
error_reporting(0);
include "conn.php";
$url 	= "https://api.telegram.org/bot397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM/getUpdates";
$json 	= file_get_contents($url);
$data 	= json_decode($json,true);
$jum 	= count($data['result']);
// echo "$jum <hr/>";
echo "\n===============\n";
echo "Alert Register";
echo "\n===============\n";
for($i=0;$i<$jum;$i++) {
	$idchat	= $data['result'][$i]['update_id'];
	$text1 	= $data['result'][$i]['message']['text'];
	$text 	= strtoupper($text1);
	$chatid	= $data['result'][$i]['message']['chat']['id'];
	$user	= $data['result'][$i]['message']['from']['username'];

	$sql 	= mysql_query("select count(id_chat) from chat_update where id_chat = '$idchat'");
	$row 	= mysql_fetch_array($sql);
	$ada	= $row[0];
	
	if($ada != 1){ // berarti tidak ada chat ini di database
		$save_chat = mysql_query ("insert into chat_update(id_chat,user,chid,text)
									values('$idchat','$user','$chatid','$text')");
		echo "| $idchat Belum ada ($user|$text) | ";
		
		if($text == "REGISTER"){			// Jika keyword benar
			$sql1 = mysql_query("select count(id_member) from m_member where username = '$user'");	// cek username sudah di daftarkan admin belum
			$row1 = mysql_fetch_array($sql1);
			$unreg= $row1[0];
			
			$sql2 = mysql_query("select chat_id from m_member where username = '$user'");	// cek apakah sudah teregister
			$row2 = mysql_fetch_array($sql2);
			$reg  = $row2[0];	
			// echo "$unreg - $reg | ";
			if($unreg <= 0){				// Jika user belum ada di database
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Maaf anda belum terdaftar di sistem SMIG Group";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Maaf anda belum terdaftar di sistem SMIG Group";
			}
			elseif($reg == ""){														// Jika user terdaftar dan belum memiliki chat id
				$save = mysql_query("update m_member set chat_id = '$chatid' where username = '$user'");
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Selamat anda tergabung dalam Notifikasi Workcenter SMIG Group";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Selamat anda tergabung dalam Notifikasi Workcenter SMIG Group";
			}
			else{							// Jika user sudah terdaftar
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Anda sudah terdaftar di Notifikasi Workcenter SMIG Group";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Anda sudah terdaftar di Notifikasi Workcenter SMIG Group";
			}
		}
		else{								// Jika salah keyword
			$sql3 = mysql_query("select chat_id from m_member where username = '$user'");	// cek username sudah di daftarkan admin belum
			$row3 = mysql_fetch_array($sql3);
			$sudah= $row3[0];
			
			$sql4 = mysql_query("select count(id_member) from m_member where username = '$user'");	// cek username sudah di daftarkan admin belum
			$row4 = mysql_fetch_array($sql4);
			$unreg= $row4[0];
			if($sudah != ""){				// Jika salah keyword tetapi terdaftar di sistem
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Anda tidak perlu lagi chat dengan Robot Registrasi lagi";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Anda tidak perlu lagi chat dengan Robot Registrasi lagi";
			}
			elseif($unreg >= 1){				// Jika salah keyword tetapi terdaftar di sistem
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Mohon cek kembali keyword yang anda kirim apakah 'Register'";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Mohon cek kembali keyword yang anda kirim apakah 'Register' 1";
			}
			else{							// Jika salah keyword dan belum terdaftar dalam sistem
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$pesan = "Mohon cek kembali keyword yang anda kirim apakah 'Register'";
				$token = "397241488:AAH2tvn1lpaUAoS3h341DpWi_tVLduErmZM"; 			// REG SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatid&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
				echo "Maaf anda belum terdaftar di sistem SMIG Group 1";
			}
		}
		// sleep(1);
	}
	/* else{
		echo "$idchat Sudah ada ($user|$text)";
	} */
	// echo"<br/>";
}
echo "| \n===============\n";
sleep(90);
?>