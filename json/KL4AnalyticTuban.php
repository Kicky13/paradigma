<?php
header("Access-Control-Allow-Origin:*");

$myGetURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={"tags":[{"name":"Tuban%203\/4%20Accessories.KL4_Hood_Draft","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.Cooler4_Speed","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Bearing_Temp","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Depth_Cooler","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.Coal_Mill4_Product","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Heat_Cons","props":[{"name":"Value"}]},{"name":"KL4_Tuban_Feed","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Speed_IdF1","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Amp_IdF1","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Vib1_IdF1","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Vib2_IdF1","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Damp_IdF1","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Speed_IdF2","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Amp_IdF2","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Vib1_IdF2","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Vib2_IdF2","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_Damp_IdF2","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_ExTemp11","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_ExTemp12","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_ExTemp21","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_Ops_ExTemp22","props":[{"name":"Value"}]},{"name":"Tuban%203\/4%20Accessories.KL4_CoalBurner_ILC","props":[{"name":"Value"}]}],"status":"OK","message":"","token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"}&_=1469589103720';

print file_get_contents($myGetURL);
?>