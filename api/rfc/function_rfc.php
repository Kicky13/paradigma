<?php
ob_start();
session_start();
#############################################################################
#			All RFC Function Call			#
#############################################################################

function GetNotifiType(){
	require_once("saprfc.php");	
	require_once("koneksi.php");
	################### RFC Name ####################
	$saprfc_id = "Z_ZCPH_RFC_SHGETNOTIFTYPE";
	################### RFC Name ####################
	
	// Create saprfc-instance
	$sap = new saprfc(array(
						"logindata"=>array(
							"ASHOST"=>$saplogin_ashost		//host
							,"SYSNR"=>$saplogin_sysnr		// system number
							,"CLIENT"=>$saplogin_client		// client
							,"USER"=>$saplogin_user			// user
							,"PASSWD"=>$saplogin_passwd		// password
							)
						,"show_errors"=>false				// let class printout errors
						,"debug"=>false));					// detailed debugging information

	$parse_array = array();
	$parse_array[] = array("TABLE","T_NOTIF",array());

	#Panggil RFC
	$hasil=$sap->callFunction($saprfc_id,$parse_array);					
	$nodes = array();

	// Call successfull?
	if ($sap->getStatus() == SAPRFC_OK) {
		return $hasil["T_NOTIF"];		
	}else { 
		echo $sap->getStatusText()."</p>";
	}

	// Logoff/Close saprfc-connection 
	//$sap->logoff();
}

############################# Notification ##################################
#############################################################################
#						GET NOTIFICATION LIST								#
# os : Outstanding															#
# pp : Postponed															#
# ip : in process															#
# c  : completed															#
# v1 : Notification Type First Range, v2 : Notification Type Second Range	#
#						Example Call Function	:							#
# GetNotifiList(1,1,1,1,'07','');	/  GetNotifiList(1,1,1,1,'01','02');	#
#############################################################################
function GetNotifiList($os, $pp, $ip, $c, $val1, $val2, $v1, $v2, $dateStart, $dateEnd,$plan1, $plan2, $plantSection, $plantSection2){
	
	# RFC Name
	$saprfc_id = "Z_ZCPH_RFC_NOTIFGETLIST";
	#echo "os = ".$os." pp = ".$pp." ip = ".$ip." c = ".$c." v1 = ".$v1." v2 = ".$v2." val1 = ".$val1." val2 = ".$val2;

	require_once("rfc/saprfc.php");	
	require_once("rfc/koneksi.php");
	require_once("include/setting.php");
	// Create saprfc-instance
	
	$sap = new saprfc(array(
						"logindata"=>array(
							"ASHOST"=>$saplogin_ashost		//host
							,"SYSNR"=>$saplogin_sysnr		// system number
							,"CLIENT"=>$saplogin_client		// client
							,"USER"=>$saplogin_user			// user
							,"PASSWD"=>$saplogin_passwd		// password
							)
						,"show_errors"=>false				// let class printout errors
						,"debug"=>false));					// detailed debugging information

	$t_qmart_sel = array();
	################### Parameter ###################	
	if($v1!='' && $v2!=''){
		$t_qmart_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$v1,"HIGH"=>$v2);	//kondisi 2
	}
	else if($v1!=''){		
		$t_qmart_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$v1);				//kondisi 1, kondisi 3 kosong semua
	}

	$t_qmnum_sel = array();
	################### Parameter ###################	
	if($val1!='' && $val2!=''){
		$t_qmnum_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$val1,"HIGH"=>$val2);	//kondisi 2
	}
	else if($val1!=''){		
		$t_qmnum_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$val1);				//kondisi 1, kondisi 3 kosong semua
	}
	#################################################

	$t_qmdat_sel = array();
	################### Parameter ###################	
	if($dateStart!='' && $dateEnd!=''){
		$t_qmdat_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>I_Format_Tanggal($dateStart),"HIGH"=>I_Format_Tanggal($dateEnd));	//kondisi 2
	}
	else if($dateStart!=''){		
		$t_qmdat_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>I_Format_Tanggal($dateStart));				//kondisi 1, kondisi 3 kosong semua
	}
	else if($dateEnd!=''){		
		$t_qmdat_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>"","HIGH"=>I_Format_Tanggal($dateEnd));				//kondisi 1, kondisi 3 kosong semua
	}

	$T_INGRP = array();
	################### Parameter ###################	
	if($plan1!='' && $plan2!=''){
		$T_INGRP[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$plan1,"HIGH"=>$plan2);	//kondisi 2
	}
	else if($plan1!='' && $plan2==''){		
		$T_INGRP[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$plan1);				//kondisi 1, kondisi 3 kosong semua
	}

	$T_BEBER = array();
	################### Parameter ###################	
	if($plantSection!='' && $plantSection2!=''){
		$T_BEBER[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$plantSection,"HIGH"=>$plantSection2);	//kondisi 2
	}
	else if($plantSection!='' && $plantSection2==''){		
		$T_BEBER[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$plantSection);				//kondisi 1, kondisi 3 kosong semua
	}
	#################################################


	$parse_array = array();
	$parse_array[] = array("TABLE","T_QMART",$t_qmart_sel);
	$parse_array[] = array("TABLE","T_QMNUM",$t_qmnum_sel);
	$parse_array[] = array("TABLE","T_QMDAT",$t_qmdat_sel);
	$parse_array[] = array("TABLE","T_INGRP",$T_INGRP);
	$parse_array[] = array("TABLE","T_BEBER",$T_BEBER);
	
	#checklist optional
	if($os==1){	$parse_array[] = array("IMPORT","I_OSNO","X"); }
	if($pp==1){	$parse_array[] = array("IMPORT","I_NOPO","X"); }	
	if($ip==1){	$parse_array[] = array("IMPORT","I_NOPR","X"); }
	if($c==1 ){	$parse_array[] = array("IMPORT","I_NOCO","X"); }

	#$parse_array[] = array("IMPORT","I_OSNO","X");

	$parse_array[] = array("TABLE","T_RESULT",array());

	#Panggil RFC
	$hasil=$sap->callFunction($saprfc_id,$parse_array);					

	// Call successfull?
	if ($sap->getStatus() == SAPRFC_OK) {
			#echo $sap->getStatusText();	//message status call rfc	
			return $hasil["T_RESULT"];
	}else { 
		echo $sap->getStatusText()."</p>";
	}	
	// Logoff/Close saprfc-connection 
	//$sap->logoff();	
}

function GetOrderList($os, $ip, $cp, $hs, $order, $order2, $otp, $otp2, $orderStart, $orderEnd){
	
	$saprfc_id = "Z_ZCPH_RFC_ORDERGETLIST";

	require_once("rfc/saprfc.php");	
	require_once("rfc/koneksi.php");
	require_once("include/setting.php");
	// Create saprfc-instance
	
	$sap = new saprfc(array(
						"logindata"=>array(
							"ASHOST"=>$saplogin_ashost		//host
							,"SYSNR"=>$saplogin_sysnr		// system number
							,"CLIENT"=>$saplogin_client		// client
							,"USER"=>$saplogin_user			// user
							,"PASSWD"=>$saplogin_passwd		// password
							)
						,"show_errors"=>false				// let class printout errors
						,"debug"=>false));					// detailed debugging information

	$t_aufnr_sel = array();
	################### Parameter ###################	
	if($order!='' && $order2!=''){
		$t_aufnr_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$order,"HIGH"=>$order2);	//kondisi 2
	}
	else if($order!=''){		
		$t_aufnr_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$order);				//kondisi 1, kondisi 3 kosong semua
	}

	$t_aufart_sel = array();
	if($otp!='' && $otp2!=''){
		$t_aufart_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$otp,"HIGH"=>$otp2);	//kondisi 2
	}
	else if($otp!=''){		
		$t_aufart_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>$otp);				//kondisi 1, kondisi 3 kosong semua
	}

	$t_erdat_sel = array();
	if($orderStart!='' && $orderEnd!=''){
		$t_erdat_sel[] = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>I_Format_Tanggal($orderStart),"HIGH"=>I_Format_Tanggal($orderEnd));
	}
	else if($orderStart!=''){		
		$t_erdat_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>I_Format_Tanggal($orderStart));
	}
	else if($orderEnd!=''){		
		$t_erdat_sel[] = array("SIGN"=>"I","OPTION"=>"EQ","LOW"=>"","HIGH"=>I_Format_Tanggal($orderEnd));
	}

	$parse_array = array();
	$parse_array[] = array("TABLE","T_AUFNR",$t_aufnr_sel);
	$parse_array[] = array("TABLE","T_AUFART",$t_aufart_sel);
	$parse_array[] = array("TABLE","T_ERDAT",$t_erdat_sel);
	
	if($os==1){	$parse_array[] = array("IMPORT","I_OSNO","X"); }
	if($ip==1){	$parse_array[] = array("IMPORT","I_NOPR","X"); }	
	if($cp==1){	$parse_array[] = array("IMPORT","I_NOCO","X"); }
	if($hs==1){	$parse_array[] = array("IMPORT","I_NOHS","X"); }

	$parse_array[] = array("TABLE","T_OBJECT_TAB",array());

	$hasil=$sap->callFunction($saprfc_id,$parse_array);					

	if ($sap->getStatus() == SAPRFC_OK) {
			return $hasil["T_OBJECT_TAB"];
	}else { 
		echo $sap->getStatusText()."</p>";
	}	
}

function GetNotifiDetail($val){
	require_once("saprfc.php");	
	require_once("koneksi.php");
	################### RFC Name ####################
	$saprfc_id = "Z_ZCPH_RFC_NOTIFGETDATA";
	################### RFC Name ####################
	
	// Create saprfc-instance
	$sap = new saprfc(array(
						"logindata"=>array(
							"ASHOST"=>$saplogin_ashost		//host
							,"SYSNR"=>$saplogin_sysnr		// system number
							,"CLIENT"=>$saplogin_client		// client
							,"USER"=>$saplogin_user			// user
							,"PASSWD"=>$saplogin_passwd		// password
							)
						,"show_errors"=>false				// let class printout errors
						,"debug"=>false));					// detailed debugging information

	$parse_array = array();
	$parse_array[] = array("IMPORT","I_NUMBER",$val);

	$parse_array[] = array("EXPORT","O_NOTIFHEADER_EXPORT",array());
	$parse_array[] = array("EXPORT","O_STTXT",array());
	$parse_array[] = array("EXPORT","O_USTXT",array());

	$parse_array[] = array("TABLE","T_RETURN",array());

	#Panggil RFC
	$hasil=$sap->callFunction($saprfc_id,$parse_array);					

	// Call successfull?
	if ($sap->getStatus() == SAPRFC_OK) {
		echo $sap->getStatusText()."<br>";	//message status call rfc
			#echo "Mlebu coy<br>";
		foreach ($hasil["T_RETURN"] as $tData) {
			if ($tData['TYPE']=='S') {
				#echo"sempak";
				echo "<table>";
				foreach ($hasil["O_NOTIFHEADER_EXPORT"] as $data) {
					echo"
						<tr>					
							<td>".$data['NOTIF_NO']."</td>
							<td>".$data['NOTIF_TYPE']."</td>					
							<td>".$data['SHORT_TEXT']."</td>					
							<td>".$data['ORDERID']."</td>					
						</tr>";
				}
				echo "</table>";
			} else {
				echo $tData['MESSAGE']."<br>";
			}
		}
	}else { 
		echo $sap->getStatusText()."</p>";
	}	
}

?>
