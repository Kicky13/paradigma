<?php
header("Access-Control-Allow-Origin:*");
$myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags[]=$N12.W1W03_05M1.CV&tags[]=$N21.R2M03M1.CV&tags[]=$T_4R1.M03M1_M2.CV&tags[]=$T_4R2.M03M1.CV&tags[]=$T_5R1.M03M1.CV&tags[]=$T_5R2.M03M1.CV&tags[]=$N12.W1W03_05M1.CV&tags[]=$N22.W2W03_05M1.CV&tags[]=$T_4W1.W03_W05.CV&tags[]=$T_5W1.W03M1.CV&tags[]=$N12.K1M03M1.CV&tags[]=$N22.K2M03M1.CV&tags[]=$T_4K2.M03M1.CV&tags[]=$T_4K3.M03M1_FC.CV&tags[]=$T_5K1.M03M1.CV&tags[]=$N13.Z1M03M1.CV&tags[]=$N23.Z2M03M1.CV&tags[]=$T_4Z2.M03M1.CV&tags[]=$T_4Z2.M03M1.CV&tags[]=$T_5Z1.M03M1.CV&tags[]=$T_5Z2.M03M1.CV';
print file_get_contents($myGetURLPadang);
?>