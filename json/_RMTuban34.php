<title>Json</title>
<?php
header("Access-Control-Allow-Origin:*");
//header("Content-Type:application/json;charset=UTF-8");

$servername = "10.15.3.146";
$username = "par4digma";
$password = "S3menGres1k";
$dbname = "logfeedtuban";
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'select * from rawmill_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']); 
		$minutes = substr($row['DateTime'], 11, 5);
		
		$RM3_amp =  number_format($row['RM3_MotAmp'],2);
		$RM3_temp =  number_format($row['RM3_MotBearTemp'],2);
		$RM3_vib =  number_format($row['RM3_MotVib'],2);
		$RM4_amp =  number_format($row['RM4_MotAmp'],2);
		$RM4_temp =  number_format($row['RM4_MotBearTemp'],2);
		$RM4_vib =  number_format($row['RM4_MotVib'],2);
	   
		$myJson['Acc_RM'][$minutes] = array(
					'RM3_MotAmp' => $RM3_amp,
					'RM3_MotBearTemp' => $RM3_temp,
					'RM3_MotVib' => $RM3_vib,
					'RM4_MotAmp' => $RM4_amp,
					'RM4_MotBearTemp' => $RM4_temp,
					'RM4_MotVib' => $RM4_vib
	   );
   }
   echo '{"7000":'.json_encode($myJson).'}';
?>