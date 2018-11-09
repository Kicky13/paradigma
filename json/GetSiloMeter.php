<?php
header("Access-Control-Allow-Origin:*");
$myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={"tags":[{"name":"Silo_09_Meter","props":[{"name":"Value"}]},{"name":"Silo_10_Meter","props":[{"name":"Value"}]},{"name":"Silo_11_Meter","props":[{"name":"Value"}]},{"name":"Silo_12_Meter","props":[{"name":"Value"}]},{"name":"Silo_13_Meter","props":[{"name":"Value"}]},{"name":"Silo_14_Meter","props":[{"name":"Value"}]},{"name":"Silo_15_Meter","props":[{"name":"Value"}]},{"name":"Silo_16_Meter","props":[{"name":"Value"}]}],"status":"OK","message":"","token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"}&_=1469589103720';
print file_get_contents($myUrl);
?>