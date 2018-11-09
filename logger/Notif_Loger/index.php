<?php
error_reporting(0);
include "conn1.php";
header("Content-Type: application/json; charset=UTF-8");
    Class getApi{
        private $url;
        private static $path="C:\\xampp\\htdocs\\Notif_Loger\\";
        function __construct($url) {
           $this->url=$url;
        }

        function getData(){
            $json = file_get_contents($this->url);
            $json =  substr($json, 1, strlen($json));
            $json =  substr($json, 0, -2);
            return $json;
        }

        function getDataPadang(){
            $json = file_get_contents($this->url);
            return $json;
        }
        
        function getStatusNonPadang($data){
            $datajson = json_decode($data);
            foreach ($datajson->tags as $mesin) {
                foreach ($mesin->props as $value) {
                    if (isset($value->val)){
                        $isi    = $value->val; 
                        $name   = $mesin->name; 
                            if (strtoupper($value->val)=="TRUE" || $value->val>=1){
                                if (strpos(strtoupper($name), 'MOTOR')!== false){
                                    echo "<img src ='https://s8.postimg.org/lwya21jkl/SISISTIKOM_ON.png' width = '20px' height = '20px'>   $name : $isi <br/>";
                                    $this->sendtelegramSukses($name);
                                }
                            }else{
                                if (strpos(strtoupper($name), 'MOTOR')!== false){
                                    echo "<img src = 'https://s24.postimg.org/iv65zyo5h/SISISTIKOM_OFF.png' width = '20px' height = '20px'>   $name : $isi <br/>";
                                    $this->sendtelegramGagal($name);
                                }
                            }
                    }else{
                    }
                 } 
            }
        }

        function getStatusPadang($data){
            $datajson = json_decode($data);
            $arr_mesin  = array();
            $arr_value  = array();
            foreach ($datajson->descriptions as $mesin) {
                foreach ($mesin as $value) {
                    array_push($arr_value,$value);
                } 
            }
            foreach ($datajson->values as $nama) {
                array_push($arr_mesin,$nama);
            }
            for($i=1; $i<count($arr_value); $i++)
            {
                $status = $arr_mesin[$i];
                if ($status == 1 || $status == 32768)
                {
                    echo "$i. <img src = 'https://s8.postimg.org/lwya21jkl/SISISTIKOM_ON.png' width = '20px' height = '20px'> --> ".$arr_mesin[$i]." -> ".$arr_value[$i];
                    echo "<br>";
                }
                else
                {
                    echo "$i. <img src = 'https://s24.postimg.org/iv65zyo5h/SISISTIKOM_OFF.png' width = '20px' height = '20px'> --> ".$arr_mesin[$i]." -> ".$arr_value[$i];
                    echo "<br>";
                }
            }
        }
		
		// Group Alert DB		==> -249537580
		// Group Alert CSV		==> -232695820
		// Bot Sinichi			==> 330608345:AAHt5ui-OjdaBUXJoeA8BE4GUTlDPHkzVDk
		// Chat Id  Sinichibot	==> 330608345
		// Chat Id Ramzi		==> 290475536
		// SMIGBOT				==> 369990072:AAHACjGu1krrbJJNB9Q21kw989VUELiagYo
		// Chat Id SMIGBOT		==> 369990072
		
        /* function sendtelegramSukses($mesinname){				// Alert ON
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );
				$pesan = urlencode($mesinname);
				
				$chatgrouptesting = "-232695820";  									//	Alert CSV
				$token = "369990072:AAHACjGu1krrbJJNB9Q21kw989VUELiagYo"; 			// 	SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatgrouptesting&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
            return $json;
        }

        function sendtelegramGagal($mesinname){			// Alert OFF
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );
			$pesan = urlencode($mesinname);
			
				$chatgrouptesting = "-232695820";  									//	Alert CSV
				$token = "369990072:AAHACjGu1krrbJJNB9Q21kw989VUELiagYo"; 			// 	SMIG BOT
				$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatgrouptesting&parse_mode=HTML&text=$pesan";
				$json = file_get_contents($url, false, stream_context_create($arrContextOptions));							

            return $json;
        } */

        function getarrayvalue($data){
            $temp = array();
            $datajson = json_decode($data);
            foreach ($datajson->tags as $mesin) 
            {
                foreach ($mesin->props as $value) 
                {
                    if (isset($value->val))
                    {   
                        array_push($temp, $mesin->name.",".$value->val);
                    }
                }
            }
            return $temp;
        }

        function cekperubahan($data,$kota){			
		$now = date("Y-m-d H:i:s"); 													// Jam Saat ini
		if($kota == "tuban1")
		{$id_opco = 1;}
		elseif($kota == "tuban2")
		{$id_opco = 2;}
		elseif($kota == "tonasa")
		{$id_opco = 3;}
		else // TLC
		{$id_opco = 4;}
		$datajson = json_decode($data);
		$no=1;
            foreach ($datajson->tags as $mesin) {
                foreach ($mesin->props as $value) {
                // echo $value->quality."\n";
                if ($value->quality=="1" || $value->quality=="true" || $value->quality==true){
                    // =========================================================== ISI FILE CSV
                    $in     = str_replace(",", ".", $value->val); //ambil value
                    $name   = $mesin->name; //ambil nama mesin
                    $qual	= $value->quality;
					
					// ============================
					// 		Buat nama Workcenter						Sukses
					// ============================
					if (strtoupper($kota)=="TUBAN1")
					{
						$workcenter = $this->pesanTuban1($name);
					}
					elseif (strtoupper($kota)=="TUBAN2")
					{   
						if ($this->pesanTuban2($name,$no)=="FALSE")
						{
						}
						else
						{
							$workcenter = $this->pesanTuban2($name,$no);    
						}
					}
					elseif (strtoupper($kota)=="TLC")
					{
						$workcenter = $this->pesanTLC($name);
					}
					elseif (strtoupper($kota)=="TONASA")
					{
						$workcenter = $this->pesanTonasa($name);
					}
					// ============================
					// 		Buat nama Workcenter
					// ============================
                    // if ($in >= 1 || $in == "True" || $in == "Run")		// 05-04-2017 Pak Asep, Pak Indra, Pak Bambang, Pak Ilmanza
                    if ($in == "True" || $in == "Run")
                    {
                        $sts1 = 1;
						$notif_baru = "$workcenter On";
                    }
                    else            
                    {
                        $sts1 = 0;
						$notif_baru = "$workcenter Off";
						
						$filer= file(self::$path."MTBF\\".$no."_".$kota.".csv");
						$jmlr = count($filer);

						$word	= explode(",", $filer[($jmlr-2)]);
						$frek2	= "$word[7]";
						if($frek2 == "")
						{$frek2 = 0;}
						$frek3	= $frek2+1;
                    }
					
					// ===============================
					// 		Insert into Workcenter						Sukses
					// ===============================
					$sql1 = mysql_query("select id_mesin from m_workcenter where nama_real = '$name'");
					$row1 = mysql_fetch_array($sql1);
					if($row1[0] >= 1)
					{
						$idm = $row1[0];
					}
					else
					{
						$save1 = mysql_query("insert into m_workcenter(id_mesin,id_opco,id_plant,nama,nama_real,status)
																values(null,$id_opco,null,'$workcenter','$name',1)");
						$sql2 = mysql_query("select id_mesin from m_workcenter where nama_real = '$name'");
						$row2 = mysql_fetch_array($sql2);
						$idm = $row2[0];
						// echo "insert into m_workcenter(id_mesin,id_opco,id_plant,nama,nama_real,status)
												// values(null,$id_opco,null,'$workcenter','$name',1) \n";
					}
					// ===============================
					// 		Insert into Workcenter
					// ===============================
					
                    $fileq = file(self::$path."FILE_CSVTESTING\\".$no."_".$kota.".csv");
                    $file = array_reverse($fileq);
                    $r = 1;
                    foreach($file as $f){
                        $kata       = explode(",", $f);
                        $sts3       = "$kata[3]";
                        if($r <= 1){
                            $sts2 = $sts3;
                        }
                        else
                        {}
                    $r++;
                    }
					
					// =========================================================
					// 					Proses  Inti
					// =========================================================
					if($sts1 == $sts2)
                    {$sts_tampilkan = 0;}
                    else
                    {
						// =========================================================
						// 					Hitung Interval On-Off
						// =========================================================
							$fileq = file(self::$path."MTBF\\".$no."_".$kota.".csv");
							$file = array_reverse($fileq);
							$r = 1;
							foreach($file as $f){
								$kata		= explode(",", $f);
								$log_ends	= "$kata[5]";
								$pos		= "$kata[3]";	// Statusnya nyala atau mati..?
								if($r == 1){
									$log_end = $log_ends;
									if($pos == 1)
									{$posisi = "On";}
									else
									{$posisi = "Off";}
								}
								else
								{}
							$r++;
							}
							$format_status 	= date("H:i:s d-m-Y"); 								// Format tanggal untuk Telegram

							$dua	= substr($log_end, 1, 10);
							$tiga	= substr($log_end, 11, 9);
							$pecah 	= explode("-", $dua);
							$log_end= $pecah[2]."-".$pecah[1]."-".$pecah[0]." $tiga";		// Tanggal Akhir

							$awal  = date_create($now);
							$akhir = date_create($log_end); // waktu sekarang
							$diff  = date_diff( $awal, $akhir );
							
							if($diff->h >= 1)
							{
								$format_interval = $diff->h . ' jam '. $diff->i . ' menit ';
								$format_interval1 = $diff->h . ' hours '. $diff->i . ' minutes ';
							}
							else
							{
								$format_interval = $diff->i . ' menit ';
								$format_interval1 = $diff->i . ' minutes ';
							}
							
							if (strtoupper($kota)=="TUBAN2"){								//  Tuban12
								if ($this->pesanTuban2($name)=="FALSE")
								{}
								else
								{
									if ($sts1 == 1)										// Jadi On
										{
											$pesan1 = "$notif_baru jam $format_status setelah stop selama $format_interval \nFrekuensi ke-$frek_on";
											$result = $this->sendtelegramSukses($pesan1);
										}
									elseif ($sts1 == 0)									// Jadi Off
										{
											$pesan1 = "$notif_baru jam $format_status setelah beroperasi selama $format_interval \nFrekuensi ke-$frek_off";
											$result = $this->sendtelegramGagal($pesan1);
										}
										
										/* $json = json_decode($result[0]);	//	Isi Repon JSON berhasil terkirim atau tidak
										$gagal = $result[1];				//  Isi URI
										if ($json->ok==1)
										{$status_terkirim = 1;}
										else
										{$status_terkirim = 0;} */
								}
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
									$sts_tampilkan 	= 1;
									$sql 	= mysql_query("insert into t_rekap1(id_rekap,id_api,id_mesin,status,status_tampil,tanggal,interval_waktu) 
																		values(null,$id_opco,$idm,$sts1,$sts_tampilkan,'$now','$format_interval')");
									echo "$workcenter ==> $notif_baru($qual)";
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
							}
							else{															//Selain Tuban12
								if (strpos(strtoupper($name), "MOTOR")!==false)
								{
									if ($sts1 == 1)
										{
											$pesan1 = "$notif_baru jam $format_status setelah stop selama $format_interval \nFrekuensi ke-$frek_on";
											if ($kota=='Tlc')
											{$pesan1 = "$notif_baru at $format_status after stopped for $format_interval1 \nFrequency after-$frek_on";}		//  TLCC
											$result = $this->sendtelegramSukses($pesan1);
										}
									elseif ($sts1 == 0)
										{
											$pesan1 = "$notif_baru jam $format_status setelah beroperasi selama $format_interval \nFrekuensi Ke-$frek_off";
											if ($kota=='Tlc')
											{$pesan1 = "$notif_baru at $format_status after operated for $format_interval1 \nFrequency after off-$frek_off time(s)";}
											$result = $this->sendtelegramGagal($pesan1);
										}
								}
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
									$sts_tampilkan 	= 1;
									$sql 	= mysql_query("insert into t_rekap1(id_rekap,id_api,id_mesin,status,status_tampil,tanggal,interval_waktu) 
																		values(null,$id_opco,$idm,$sts1,$sts_tampilkan,'$now','$format_interval')");
									echo "$workcenter ==> $notif_baru($qual)";
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
							}
					}
					if($sts_tampilkan == 0)
					{$tuing = "On";}
					else
					{$tuing = "Off";}
					echo "\n$workcenter -> $tuing\n";
					// =========================================================
					// 					Proses  Inti
					// =========================================================
					
					$data   = array($no,$in,$name,$sts1,$sts_tampilkan,$now);
                    $fp     = fopen(self::$path."FILE_CSVTESTING\\".$no."_".$kota.".csv", "a+");
                    $tulis  = fputcsv($fp, $data);
                    fclose($fp);
                    // =========================================================== PANGGIL FILE CSV
                }
                $no++;
                } 
            }
        }

        function cekperubahanPadang($data,$kota){
		$now = date("Y-m-d H:i:s"); 													// Jam Saat ini
		$id_opco = 5;
		$arrPadang = array('Raw Mill Indarung 2',
						'Raw Mill Indarung 3',
						'Raw Mill #1 Indarung 4',
						'Raw Mill #2 Indarung 4',
						'Raw Mill #1 Indarung 5',
						'Raw Mill #2 Indarung 5',                            
						'Kiln Indarung 2',
						'Kiln Indarung 3',
						'Kiln Indarung 4',
						'Kiln Indarung 5',                            
						'Coal Mill Indarung 2',
						'Coal Mill Indarung 3',
						'Coal Mill #1 Indarung 4',
						'Coal Mill #2 Indarung 4',
						'Coal Mill Indarung 5',                            
						'Finish Mill Indarung 2',
						'Finish Mill Indarung 3',
						'Finish Mill #1 Indarung 4',
						'Finish Mill #2 Indarung 4',
						'Finish Mill #1 Indarung 5',
						'Finish Mill #2 Indarung 5');            
            $datajson = json_decode($data);
            $arr_mesin  = array();
            $arr_value  = array();
            $arr_key    = array();
            $arr_quality    = array();
            $no=1;
            foreach ($datajson->descriptions as $mesin) {
                foreach ($mesin as $key=>$value) {
                    array_push($arr_mesin,$value);
                    array_push($arr_key,$key);
                } 
            }
            
            foreach ($datajson->qualities as $quality) {
                 foreach ($quality as $q) {
                    array_push($arr_quality,$q);
                } 
                
            }

            foreach ($datajson->values as $nama) {
                array_push($arr_value,$nama);
            }
			
            for($i=0; $i<count($arr_value); $i++)
				{
                // echo "Quality : ".$arr_quality[$i]."\n";
                    if ($arr_quality[$i]=="GOOD"){
                        $in     = $arr_value[$i];
                        $name   = $arr_mesin[$i];
                        $keys   = $arr_key[$i];
						$workcenter	= $arrPadang[$i];

                        if ($in == 1 || $in==32768)
                        {$sts1 = 1;
						$notif_baru = "On";}
                        else        
                        {
							$sts1 = 0;
							$notif_baru = "Off";
							
							$filer= file(self::$path."MTBF\\".$no."_".$kota.".csv");
							$jmlr = count($filer);

							$word	= explode(",", $filer[($jmlr-2)]);
							$frek2	= "$word[7]";
							if($frek2 == "")
							{$frek2 = 0;}
							$frek3	= $frek2+1;
						}
						
						// ===============================
						// 		Insert into Workcenter						Sukses
						// ===============================
						$sql1 = mysql_query("select id_mesin from m_workcenter where nama_real = '$keys'");
						$row1 = mysql_fetch_array($sql1);
						if($row1[0] >= 1)
						{
							$idm = $row1[0];
						}
						else
						{
							$save1 = mysql_query("insert into m_workcenter(id_mesin,id_opco,id_plant,nama,nama_real,status)
																	values(null,$id_opco,null,'$workcenter','$keys',1)");
							$sql2 = mysql_query("select id_mesin from m_workcenter where nama_real = '$keys'");
							$row2 = mysql_fetch_array($sql2);
							$idm = $row2[0];
							// echo "insert into m_workcenter(id_mesin,id_opco,id_plant,nama,nama_real,status)
													// values(null,$id_opco,null,'$workcenter','$name',1) \n";
						}
						// ===============================
						// 		Insert into Workcenter
						// ===============================
						
                        $fileq = file(self::$path."FILE_CSVTESTING\\".$no."_".$kota.".csv");
                        $file = array_reverse($fileq);
                        $r = 1;
                        foreach($file as $f){
                            $kata       = explode(",", $f);
                            $sts3       = "$kata[3]";
                            if($r <= 1){
                                $sts2 = $sts3;
                            }
                            else
                            {}
                        $r++;
                        }
                        
						// =========================================================
						// 					Proses  Inti
						// =========================================================
                        if($sts1 == $sts2)
                        {$sts_tampilkan = 0;}
                        else
						{
							// =========================================================
							// 					Hitung Interval On-Off
							// =========================================================
								$fileq = file(self::$path."MTBF\\".$no."_".$kota.".csv");
								$file = array_reverse($fileq);
								$r = 1;
								foreach($file as $f){
									$kata		= explode(",", $f);
									$log_ends	= "$kata[5]";
									$pos		= "$kata[3]";
									if($r == 1){
										$log_end = $log_ends;
										if($pos == 1)
										{$posisi = "On";}
										else
										{$posisi = "Off";}
									}
									else
									{}
								$r++;
								}
								$format_status 	= date("H:i:s d-m-Y");										// Buat format waktu untuk telegram
								
								$dua	= substr($log_end, 1, 10);
								$tiga	= substr($log_end, 11, 9);
								$pecah 	= explode("-", $dua);
								$log_end= $pecah[2]."-".$pecah[1]."-".$pecah[0]." $tiga";		// Tanggal Akhir

								$awal  = date_create($now); // waktu sekarang
								$akhir = date_create($log_end); // Waktu terakhir di CSV
								$diff  = date_diff( $awal, $akhir );

								if($diff->h >= 1)
								{
									$format_interval = $diff->h . ' jam '. $diff->i . ' menit';
								}
								else
								{
									$format_interval = $diff->i . ' menit';
								}
							
								if($sts1 == 0)				// Maksudnya untuk frekuensinya
								{
									$format_interval = "$format_interval";
									$sts_tampilkan = 1;
									$data   = array($no,$in,$name,$sts1,$sts_tampilkan,$now,$format_interval,$frek3);
									$fp     = fopen(self::$path."MTBF\\".$no."_".$kota.".csv", "a+");
									$tulis  = fputcsv($fp, $data);
									fclose($fp);
								}
								else						// Maksudnya untuk frekuensinya
								{
									$format_interval = "$format_interval";
									$sts_tampilkan = 1;
									$data   = array($no,$in,$name,$sts1,$sts_tampilkan,$now,$format_interval);
									$fp     = fopen(self::$path."MTBF\\".$no."_".$kota.".csv", "a+");
									$tulis  = fputcsv($fp, $data);
									fclose($fp);
								}
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
								$sts_tampilkan 	= 1;
								$sql 	= mysql_query("insert into t_rekap1(id_rekap,id_api,id_mesin,status,status_tampil,tanggal,interval_waktu) 
																	values(null,$id_opco,$idm,$sts1,$sts_tampilkan,'$now','$format_interval')");
								echo "$workcenter ==> $notif_baru";
								// =========================================================
								// 						Simpan Perubahan
								// =========================================================
						}
						// =========================================================
						// 					Proses  Inti
						// =========================================================						

                        $data   = array($no,$in,$name,$sts1,$sts_tampilkan,$now);
                        $fp     = fopen(self::$path."FILE_CSVTESTING\\".$no."_".$kota.".csv", "a+");
                        $tulis  = fputcsv($fp, $data);
                        fclose($fp);
                        // =========================================================== ISI FILE CSV
						
						

                        // =========================================================== PANGGIL FILE CSV
                        $filew = file(self::$path."FILE_CSVTESTING\\".$no."_".$kota.".csv");
                        $filex = file(self::$path."MTBF\\".$no."_".$kota.".csv");
                        $jmla = count($filew);
                        $jmlb = count($filex);
                        $kata = explode(",", $filew[($jmla-2)]);
                        $csv_in     = "$kata[1]"; 
                        $csv_name   = "$kata[2]";
                        $csv_baru   = "$kata[3]";
                        $csv_tampil = "$kata[4]";
                        $time 		= "$kata[5]";
                        
                        $kata2 = explode(",", $filew[($jmla-1)]);                    
                        $csv_in2        = "$kata2[1]";
                        $csv_name2      = "$kata2[2]";
                        $csv_baru2      = "$kata2[3]";
                        $csv_tampil2    = "$kata2[4]";
                        $time2          = "$kata2[5]";

                            if ($csv_baru!=$csv_baru2){
                                if ($csv_baru2==1){
                                    $pesan 	= $arrPadang[$i];
									$pesan1 = "$pesan $notif_baru jam $format_status setelah stop selama $format_interval";
                                    $this->sendtelegramSukses($pesan1);        
                                    $pesan1 = "Padang : ".$arrPadang[$i]." status GANTI";
                                    // echo $pesan1."ON\n";
                                }else{
                                    $pesan 	= $arrPadang[$i];
									$pesan1 = "$pesan $notif_baru jam $format_status setelah beroperasi selama $format_interval \nFrekuensi Ke-$frek3";
                                    $this->sendtelegramGagal($pesan1);        
                                    $pesan1 = $arrPadang[$i]." status GANTI ";
                                    // echo $pesan1."OFF\n";
                                }
                            }
                        // =========================================================== PANGGIL FILE CSV
                    if($sts_tampilkan == 0)
					{$tuing = "On";}
					else
					{$tuing = "Off";}
					echo "\n$workcenter -> $tuing\n";
                    $no++;
                    }
                }
        }

        function unlinkfile(){
            date_default_timezone_set("Asia/Jakarta");
            //$jam = date("d-m-Y H:i:s");
			$jam = date("H:i:s");
            $destroy = "09:00:00";
            if($jam == $destroy)
            {
                // echo "<h1>($jam):($destroy) </h1>Saatnya Unlink <hr>";
                $dir = "FILE_CSVTESTING";
                foreach(scandir($dir) as $file) {
                    if ('.' === $file || '..' === $file) continue;
                    if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
                    else unlink("$dir/$file");
                }
            }
            else
            {
                // echo "<h1>($jam):($destroy) </h1>Jangan Unlink <hr>";
            }
        }

        function strReplaceAssoc(array $replace, $subject) {
            return str_replace(array_keys($replace), array_values($replace), $subject);
        }

        function pesanTLC($kalimat){
            $replace = array(
                    '"' => '',
                    '_' => ' ',
                    '-' => '',
                    'False' => '',
                    'True' => '',
                    '2/3.' => '',
                    '.' => '',
                    'Tonasa' => '',
                    'CM' => 'Coal Mill ',
                    'FM1' => 'Finish Mill MP ',
                    'FM2' => 'Finish Mill HCM ',
                    'KL' => 'Kiln ',
                    'RM' => 'Raw Mill ',
                    'TNS' => 'Tonasa ',
                    'TLCC' => 'Thang Long'
                    );
                $word       = explode(".", $kalimat);
                $perWord    = explode("_", $word[1]);
                $namamesin = $this->strReplaceAssoc($replace,$perWord[0]);
                $namamesin = str_replace("1", "", $namamesin);
                $kalimat2 = $namamesin.$this->strReplaceAssoc($replace,$word[0]);
                return $kalimat2;
        }

        function pesanTonasa($kalimat){
            $replace = array(
                    '"' => '',
                    '_' => ' ',
                    '-' => '',
                    'Motor' => '',
                    'MOTOR' => '',
                    'Feed' => '',
                    'False' => '',
                    'True' => '',
                    '2/3.' => '',
                    'Tonasa' => '',
                    'Emisi' => '',
                    'CM' => ' Coal Mill ',
                    'FM' => ' Finish Mill ',
                    'KL' => ' Kiln ',
                    'RM' => ' Raw Mill ',
                    'TNS' => 'Tonasa ',
                    );
                $word       = explode(".", $kalimat);
                $perWord    = explode("_", $word[1]);
                $nomer = substr($perWord[0], -1);
                $kota = $this->strReplaceAssoc($replace,$perWord[1]);

                if ($kota=='Tonasa 4' || $kota=='Tonasa 5')
                {
                    if (is_numeric($nomer))
                    {
                        $nomer = "#".$nomer." ";
                        $mesin = substr($perWord[0], 0,strlen($perWord[0])-1);
                    }else
                    {
                        $nomer = "";
                        $mesin = $perWord[0];
                    }
                    
                    $namamesin = $this->strReplaceAssoc($replace,$mesin);   

                }else{
                    if (is_numeric($nomer))
                    {
                        $mesin = substr($perWord[0], 0,strlen($perWord[0])-1);
                    }else{
                        $mesin = $perWord[0];   
                    }

                    $nomer="";
                    $namamesin = $this->strReplaceAssoc($replace,$mesin);   
                }

                $kalimat2 = $namamesin.$nomer.$kota."";
                // END Edited By Imam ===========================================
                return $kalimat2;
        }

        function pesanTuban1($kalimat){
            $replace = array(
                    '"' => '',
                    '_' => ' ',
                    '-' => '',
                    'Motor' => '',
                    'MOTOR' => '',
                    'Feed' => '',
                    'False' => '',
                    'True' => '',
                    '2/3.' => '',
                    'Tonasa' => '',
                    'Emisi' => '',
                    'CM' => ' Coal Mill ',
                    'FM' => ' Finish Mill ',
                    'KL' => ' Kiln ',
                    'RM' => ' Raw Mill ',
                    'Tuban' => 'Tuban '
                    );
                if (strpos($kalimat,"Accessories")!==false){
                }else{
                    $word       = $kalimat;
                    $perWord    = explode("_", $word);
                    $nomer = substr($perWord[0], -1);
                    $mesin = substr($perWord[0], 0,strlen($perWord[0])-1);
                    $namamesin = $this->strReplaceAssoc($replace,$mesin);
                    $kota="Tuban $nomer";
                    if (strpos($namamesin, "Kiln")!==FALSE){
                        $namamesin = str_replace("1", "", $namamesin);
                    }    
                }
                if (strpos($namamesin, "Finish Mill")!==false){
                    switch ($nomer) {
                        case '1':
                            $kota= 'Tuban 1';
                            break;
                        case '2':
                            $kota= 'Tuban 1';
                            break;                        
                        case '3':
                            $kota= 'Tuban 2';
                            break;
                        case '4':
                            $kota= 'Tuban 2';
                            break;
                        case '5':
                            $kota= 'Tuban 3';
                            break;
                        case '6':
                            $kota= 'Tuban 3';
                            break;
                        case '7':
                            $kota= 'Tuban 4';
                            break;
                        case '8':
                            $kota= 'Tuban 4';
                            break;
                    }

                    $kalimat2 = $namamesin." #".$nomer." ".$kota." ";    
                }else{
                    $kalimat2 = $namamesin." ".$kota." ";                           
                }
                $kalimat2 = preg_replace("/ {2,}/", " ", $kalimat2);
                return $kalimat2;
        }

        function pesanTuban2($pesan,$i){
            $arrMesinTuban12 = array(
                "1055" => "KILN Tuban 1",
                "4090" => "KILN Tuban 2",
                "750" => "Raw Mill Tuban 1",
                "3213" => "Raw Mill Tuban 2",
                "510" => "Coal Mill Tuban 1",
                "536" => "Coal Mill Tuban 2",
                "1193" => "Finish Mill #1 Tuban 1" ,
                "4478" => "HRC FM#1 Tuban 1", 
                "1275" => "Finish Mill #2 Tuban 1",
                "4586" => "HRC FM#2 Tuban 1",
                "4807" => "Finish Mill #3 Tuban 2",
                "4731" => "HRC FM#3 Tuban 2",
                "4991" => "Finish Mill #4 Tuban 2",
                "4917" => "HRC FM#4 Tuban 2",
                "8691" => "New Vertical Mill Tuban 1" ,
                "8009" => "Atox Mill Tuban 1" 
                );
            if ($this->cekArrayTuban2($arrMesinTuban12,$pesan)){
                return $arrMesinTuban12[$pesan]." ";
            }else{
                return "FALSE_".$i;
            }
            
        }

        function cekArrayTuban2($array,$cari){
            return array_key_exists($cari, $array);
        }

}

echo "Process is running........\n";
echo "===============<br/>\n";
echo "TUBAN 12 Api1<br/>\n";
echo "===============<br/>\n";
$tuban1 = new getApi("http://par4digma.semenindonesia.com/api/index.php/plant_tuban/get_statefeed");
$tuban1->unlinkfile();
$data = $tuban1->getData();
$tuban1->cekperubahan($data,'tuban1');

echo "===============<br/>\n";
echo "TUBAN 34 Api1<br/>\n";
echo "===============<br/>\n";
$tuban2 = new getApi("http://par4digma.semenindonesia.com/api/index.php/plant_tuban/get_statefeedtb12");
$tuban2->unlinkfile();
$data = $tuban2->getData();
$tuban2->cekperubahan($data,'tuban2');

echo "===============<br/>\n";
echo "TONASA Api1<br/>\n";
echo "===============<br/>\n";
$tonasa = new getApi("http://par4digma.semenindonesia.com/api/index.php/plant_tonasa/get_statefeed");
$tonasa->unlinkfile();
$data = $tonasa->getData();
$tonasa->cekperubahan($data,'tonasa');

echo "===============<br/>\n";
echo "TLCC Api1<br/>\n";
echo "===============<br/>\n";
$tlc = new getApi("http://par4digma.semenindonesia.com/api/index.php/plant_tlcc/get_statefeed");
$tlc->unlinkfile();
$data = $tlc->getData();
$tlc->cekperubahan($data,'Tlc');

echo "===============<br/>\n";
echo "PADANG Api1<br/>\n";
echo "===============<br/>\n";
$padang = new getApi("http://par4digma.semenindonesia.com/api/index.php/plant_padang/get_state");
$padang->unlinkfile();
$data = $padang->getDataPadang();
$padang->cekperubahanPadang($data,'Padang');
sleep(1);
?>