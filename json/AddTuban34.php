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
   
   $sql = 'SELECT * FROM addtbn34;';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$CM4_MP =  number_format($row['CM4_MP'],2);
		$RM3_MP =  number_format($row['RM3_MP'],2);
		$RM4_MP =  number_format($row['RM4_MP'],2);
		$KL3_SP =  number_format($row['KL3_SP'],2);
		$KL4_SP =  number_format($row['KL4_SP'],2);
		$KL3_TQ =  number_format($row['KL3_Tq'],2);
		$KL4_TQ =  number_format($row['KL4_Tq'],2);
		
		$FM5_MP =  number_format($row['FM5_MP'],2);
		$FM6_MP =  number_format($row['FM6_MP'],2);
		$FM7_MP =  number_format($row['FM7_MP'],2);
		$FM8_MP =  number_format($row['FM8_MP'],2);
		
	    $toProd['Additional'][$minutes] = array(
					"cm4_mp" => $CM4_MP,
					"rm3_mp" => $RM3_MP,
					"rm4_mp" => $RM4_MP,
					"kl3_sp" => $KL3_SP,
					"kl4_sp" => $KL4_SP,
					"kl3_tq" => $KL3_TQ,
					"kl4_tq" => $KL4_TQ,
					"fm5_mp" => $FM5_MP,
					"fm6_mp" => $FM6_MP,
					"fm7_mp" => $FM7_MP,
					"fm8_mp" => $FM8_MP
	   );
   }

   echo '{"7000":'.json_encode($toProd).'}';
?>