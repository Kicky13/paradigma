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
   
   $sql = 'select * from kiln3_all';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		//$mydate = date_create($row['DateTime']);
		//$minutes = date_format($mydate,'H:i:s');
		$minutes = substr($row['DateTime'], 11, 5);
		
		$KL3_BearTemp =  number_format($row['KL3_BearTemp'],2);
		$KL3_KilnAmp =  number_format($row['KL3_KilnAmp'],2);
		$KL3_OpsDampIdF1 =  number_format($row['KL3_OpsDampIdF1'],2);
		$KL3_OpsDampIdF2 =  number_format($row['KL3_OpsDampIdF2'],2);
		$KL3_OpsExTemp1 =  number_format($row['KL3_OpsExTemp1'],2);
		$KL3_OpsExTemp2 =  number_format($row['KL3_OpsExTemp2'],2);
		$KL3_OpsPowerIdF11 =  number_format($row['KL3_OpsPowerIdF11'],2);
		$KL3_OpsPowerIdF21 =  number_format($row['KL3_OpsPowerIdF21'],2);
		$KL3_OpsSpeedIdF12 =  number_format($row['KL3_OpsSpeedIdF12'],2);
		$KL3_OpsSpeedIdF22 =  number_format($row['KL3_OpsSpeedIdF22'],2);
		$KL3_OpsVib1IdF11 =  number_format($row['KL3_OpsVib1IdF11'],2);
		$KL3_OpsVib1IdF21 =  number_format($row['KL3_OpsVib1IdF21'],2);
		$KL3_OpsVib2IdF12 =  number_format($row['KL3_OpsVib2IdF12'],2);
		$KL3_OpsVib2IdF22 =  number_format($row['KL3_OpsVib2IdF22'],2);
	   
		$myJson['Acc_KL3'][$minutes] = array(
					'KL3_BearTemp' => $KL3_BearTemp,
					'KL3_KilnAmp' => $KL3_KilnAmp,
					'KL3_OpsDampIdF1' => $KL3_OpsDampIdF1,
					'KL3_OpsDampIdF2' => $KL3_OpsDampIdF2,
					'KL3_OpsExTemp1' => $KL3_OpsExTemp1,
					'KL3_OpsExTemp2' => $KL3_OpsExTemp2,
					'KL3_OpsPowerIdF11' => $KL3_OpsPowerIdF11,
					'KL3_OpsPowerIdF21' => $KL3_OpsPowerIdF21,
					'KL3_OpsSpeedIdF12' => $KL3_OpsSpeedIdF12,
					'KL3_OpsSpeedIdF22' => $KL3_OpsSpeedIdF22,
					'KL3_OpsVib1IdF11' => $KL3_OpsVib1IdF11,
					'KL3_OpsVib1IdF21' => $KL3_OpsVib1IdF21,
					'KL3_OpsVib2IdF12' => $KL3_OpsVib2IdF12,
					'KL3_OpsVib2IdF22' => $KL3_OpsVib2IdF22
	   );
   }

   echo '{"7000":'.json_encode($myJson).'}';
?>