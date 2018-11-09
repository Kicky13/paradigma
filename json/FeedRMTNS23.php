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
   
   $sql = 'SELECT DateTime, TNS2_RM1, TNS3_RM1 FROM logfeedtuban.feed_tonasa23';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		$minutes = substr($row['DateTime'], 11, 5);
		
		$RM2_Feed =  number_format($row['TNS2_RM1'],2);
		$RM3_Feed =  number_format($row['TNS3_RM1'],2);
		
		$text2 = 'rm2';
		$text3 = 'rm3';
		
	   $toProd['Feed_RM'][$minutes] = array(
					$text2 => $RM2_Feed,
					$text3 => $RM3_Feed
	   );
   }
   $toProd = 'null';
   echo '{"4000":'.json_encode($toProd).'}';
?>