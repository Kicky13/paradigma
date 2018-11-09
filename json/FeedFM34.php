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
   
   $sql = 'select DateTime, FM5_Feed, FM6_Feed, FM7_Feed, FM8_Feed from feed_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$FM5_Feed =  number_format($row['FM5_Feed'],2);
		$FM6_Feed =  number_format($row['FM6_Feed'],2);
		$FM7_Feed =  number_format($row['FM7_Feed'],2);
		$FM8_Feed =  number_format($row['FM8_Feed'],2);
		
		$text5 = 'fm5';
		$text6 = 'fm6';
		$text7 = 'fm7';
		$text8 = 'fm8';
		
	    $toProd['Feed_FM'][$minutes] = array(
					$text5 => $FM5_Feed,
					$text6 => $FM6_Feed,
					$text7 => $FM7_Feed,
					$text8 => $FM8_Feed
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
?>