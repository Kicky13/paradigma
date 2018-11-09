<?php
header("Access-Control-Allow-Origin:*");
$myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags[]=$N23.P1L01Q1.CV&tags[]=$N23.P1L11Q1.CV&tags[]=$N23.P1L21Q1.CV&tags[]=$N23.P1L31Q1.CV&tags[]=$T_4Z1.P1L51.CV&tags[]=$T_4Z1.P1L61.CV&tags[]=$T_4Z1.P1L71.CV&tags[]=$T_4Z1.P1L81.CV&tags[]=$T_5Z1.L09N1L01.CV&tags[]=$T_5Z1.L11N1L01.CV&tags[]=$T_5Z2.L09N1L01.CV&tags[]=$T_5Z2.L11N1L01.CV';
print file_get_contents($myGetURLPadang);
?>