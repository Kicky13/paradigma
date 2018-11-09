<?php
header("Access-Control-Allow-Origin:*");
$myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags%5B%5D=%24N12.W1_SPARE1.CV&tags%5B%5D=%24N22.W2W01X3.CV&tags%5B%5D=%24T_4J1.P11X1_2.CV&tags%5B%5D=%24T_4J2.P11X1_2.CV&tags%5B%5D=%24T_5J1.P01N3A02.CV';
print file_get_contents($myGetURLPadang);
?>