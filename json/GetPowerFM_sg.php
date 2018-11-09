<?php
header("Access-Control-Allow-Origin:*");

if (ISSET($_GET['s']) && $_GET['s'] == 'fm7'){
 $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Ampere%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Bearing_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Vibration%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
}else if (ISSET($_GET['s']) && $_GET['s'] == 'fm8'){
 $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Motor_Ampere%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Motor_Bearing_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Motor_Vibration%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
}
print file_get_contents($myUrl);
?>