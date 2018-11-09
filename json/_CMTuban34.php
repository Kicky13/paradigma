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
   
   $sql = 'select * from coalmill_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']); 
		$minutes = substr($row['DateTime'], 11, 5);
		
		$cm3_amp =  number_format($row['CM3_MotAmp'],2);
		$cm3_temp =  number_format($row['CM3_MotBearTemp'],2);
		$cm3_vib =  number_format($row['CM3_MotVib'],2);
		$cm4_amp =  number_format($row['CM4_MotAmp'],2);
		$cm4_temp =  number_format($row['CM4_MotBearTemp'],2);
		$cm4_vib =  number_format($row['CM4_MotVib'],2);
	   
		$myJson['Acc_CM'][$minutes] = array(
					'CM3_MotAmp' => $cm3_amp,
					'CM3_MotBearTemp' => $cm3_temp,
					'CM3_MotVib' => $cm3_vib,
					'CM4_MotAmp' => $cm4_amp,
					'CM4_MotBearTemp' => $cm4_temp,
					'CM4_MotVib' => $cm4_vib
	   );
   }
   echo '{"7000":'.json_encode($myJson).'}';
?>