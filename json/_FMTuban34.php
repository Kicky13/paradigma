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
   
   $sql = 'select * from finishmill_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$fm7_amp =  number_format($row['FM7_MotAmp'],2);
		$fm7_temp =  number_format($row['FM7_MotBearTemp'],2);
		$fm7_vib =  number_format($row['FM7_MotVib'],2);
		$fm8_amp =  number_format($row['FM8_MotAmp'],2);
		$fm8_temp =  number_format($row['FM8_MotBearTemp'],2);
		$fm8_vib =  number_format($row['FM8_MotVib'],2);
	   
		$myJson['Acc_FM'][$minutes] = array(
					'FM7_MotAmp' => $fm7_amp,
					'FM7_MotBearTemp' => $fm7_temp,
					'FM7_MotVib' => $fm7_vib,
					'FM8_MotAmp' => $fm8_amp,
					'FM8_MotBearTemp' => $fm8_temp,
					'FM8_MotVib' => $fm8_vib
	   );
   }

   echo '{"7000":'.json_encode($myJson).'}';
?>