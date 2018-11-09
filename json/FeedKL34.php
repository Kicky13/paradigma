<title>Json</title>
<?php
header('Access-Control-Allow-Origin: *');

$servername = "10.15.3.146";
$username = "par4digma";
$password = "S3menGres1k";
$dbname = "logfeedtuban";
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'select DateTime, KL3_Feed, KL4_Feed from feed_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		//$minutes = str_replace(':','_',substr($row['DateTime'], 11, 5));
		$minutes = substr($row['DateTime'], 11, 5);
		
		$KL3_Feed =  number_format($row['KL3_Feed'],2);
		$KL4_Feed =  number_format($row['KL4_Feed'],2);
		
		$text3 = 'kl3';
		$text4 = 'kl4';
		
	   $toProd['Feed_Kiln'][$minutes] = array(
					$text3 => $KL3_Feed,
					$text4 => $KL4_Feed
	   );
   }
   
   echo '{"7000":'.json_encode($toProd).'}';
?>