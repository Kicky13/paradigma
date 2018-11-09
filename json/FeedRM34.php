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
   
   $sql = 'select DateTime, RM3_Feed, RM4FFeed from feed_tuban34';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$RM3_Feed =  number_format($row['RM3_Feed'],2);
		$RM4_Feed =  number_format($row['RM4FFeed'],2);
		
		$text3 = 'rm3';
		$text4 = 'rm4';
		
	    $toProd['Feed_RM'][$minutes] = array(
					$text3 => $RM3_Feed,
					$text4 => $RM4_Feed
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
?>