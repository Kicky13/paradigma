<?
ob_start();
session_start();

if($_SESSION['usrName']==''){
    echo "<script>parent.window.location.href='index.php'</script>";
}
	ini_set("date.timezone", "Asia/Jakarta");
	
	$conn = @mysql_connect ("10.15.5.71","sgg","sggroup") or die ("koneksi gagal");
	mysql_select_db ("pm_ext", $conn);
	//$conn2 = @mysql_connect ("10.15.5.71","sgg","sggroup") or die ("koneksi gagal");
	//mysql_select_db ("pm_order", $conn);

	DEFINE(const_tb_header, 'tb_header');
	DEFINE(const_tb_external, 'tb_external');
	DEFINE(const_tb_service, 'tb_service');
	DEFINE(const_tb_t_header, 't_header');
	DEFINE(const_tb_t_component, 't_component');
	DEFINE(const_tb_t_operation, 't_operation');
	DEFINE(const_tb_t_object_list, 't_object_list');
	DEFINE(const_tb_t_user_status, 't_user_status');
	DEFINE(const_tb_t_detail_pm03, 't_detail_pm03');

	function exec_sql($sql) {
		GLOBAL $conn;

		$q=mysql_query($sql, $conn);
		if ($q) {
			$rslt=$q;
		} else {
			$rslt=false;
		}
		return $rslt;
	}

	function get_rows_count($sql) {
		$n=0;
		$sql2=trim(str_ireplace('select', 'select SQL_CALC_FOUND_ROWS ', $sql));
		if(substr($sql2, strlen($sql2)-1, 1)==';') {
			$sql2=substr($sql2, 0, strlen($sql2)-2);
		}
		$sql2 .= ' limit 0;';
		$q=exec_sql($sql2);
		if ($q) {
			$q=exec_sql('select FOUND_ROWS() as n');
			if ($q) {
				if(mysql_num_rows($q)>0) {
					$row=mysql_fetch_array($q);
					$n=$row['n'];
				}
			}
		}

		return $n;
	}

	function get_field_value($key_field_name, $key_field_value, $field, $table) {
		$result='';
		if ($key_field_name<>'' && $key_field_value<>'' && $field<>'' && $table<>'') {
			$q=exec_sql("select ".$field." from ".$table." where ".$key_field_name."='".$key_field_value."' ");
			if ($q) {
				$row=mysql_fetch_array($q);
				$result=$row[$field];
			}
		}

		return $result;
	}

	function getMonth($bln)
	{
		if ($bln=="1" || $bln=="01"){ $bulan="JANUARI"; }
		else if ($bln=="2" || $bln=="02"){ $bulan="FEBRUARI"; }
		else if ($bln=="3" || $bln=="03"){ $bulan="MARET"; }
		else if ($bln=="4" || $bln=="04"){ $bulan="APRIL"; }
		else if ($bln=="5" || $bln=="05"){ $bulan="MEI"; }
		else if ($bln=="6" || $bln=="06"){ $bulan="JUNI"; }
		else if ($bln=="7" || $bln=="07"){ $bulan="JULI"; }
		else if ($bln=="8" || $bln=="08"){ $bulan="AGUSTUS"; }
		else if ($bln=="9" || $bln=="09"){ $bulan="SEPTEMBER"; }
		else if ($bln=="10"){ $bulan="OKTOBER"; }
		else if ($bln=="11"){ $bulan="NOPEMBER"; }
		else if ($bln=="12"){ $bulan="DESEMBER"; }

		return $bulan;
	}

	function getShortMonth($bln)
	{
		if ($bln=="1" || $bln=="01"){ $bulan="Jan"; }
		else if ($bln=="2" || $bln=="02"){ $bulan="Peb"; }
		else if ($bln=="3" || $bln=="03"){ $bulan="Mar"; }
		else if ($bln=="4" || $bln=="04"){ $bulan="Apr"; }
		else if ($bln=="5" || $bln=="05"){ $bulan="Mei"; }
		else if ($bln=="6" || $bln=="06"){ $bulan="Jun"; }
		else if ($bln=="7" || $bln=="07"){ $bulan="Jul"; }
		else if ($bln=="8" || $bln=="08"){ $bulan="Agus"; }
		else if ($bln=="9" || $bln=="09"){ $bulan="Sep"; }
		else if ($bln=="10"){ $bulan="Okt"; }
		else if ($bln=="11"){ $bulan="Nop"; }
		else if ($bln=="12"){ $bulan="Des"; }

		return $bulan;
	}

	function getDay($thn,$bln)
	{
		if ($bln=="1" || $bln=="01"){ $hari="31"; }
		else if ($bln=="2" || $bln=="02"){ if ($thn%4==0) {	$hari = "29";} else {$hari = "28";} }
		else if ($bln=="3" || $bln=="03"){ $hari="31"; }
		else if ($bln=="4" || $bln=="04"){ $hari="30"; }
		else if ($bln=="5" || $bln=="05"){ $hari="31"; }
		else if ($bln=="6" || $bln=="06"){ $hari="30"; }
		else if ($bln=="7" || $bln=="07"){ $hari="31"; }
		else if ($bln=="8" || $bln=="08"){ $hari="31"; }
		else if ($bln=="9" || $bln=="09"){ $hari="30"; }
		else if ($bln=="10"){ $hari="31"; }
		else if ($bln=="11"){ $hari="30"; }
		else if ($bln=="12"){ $hari="31"; }

		return $hari;
	}

	function getTypeNotification(){
		require_once("rfc/function_rfc.php");
		//$data = GetNotifiType();
			$html = "<table width='100%' cellpadding='3' cellspacing='0' border='1' style='border-collapse: collapse' bordercolor='#CCCCCC'>";
				$html .= "<tr height='30' class='data'>";
					$html .= "<td align='center' width='5'><strong>Type</strong></td>";
					$html .= "<td align='center'><strong>Notification</strong></td>";
				$html .= "</tr>";
				//foreach ($data as $dataList) {
					$html .= "<tr class='data'>";
						$html .= "<td align='center' width='20'>".$dataList['QMART']."</td>";
						$html .= "<td><a href='javascript:void(0);' onclick=\"call('".$dataList['QMART']."')\">".$data['QMARTX']."<a></td>";
					$html .= "</tr>";
				//}
			$html .= "</table>";
		return $html;
	}

	function O_Format_Waktu($a)
	{
				$dump11=substr($a,0,2);
				$dump12=substr($a,2,2);
				$dump13=substr($a,4,2);
				$dump2=array ($dump11,$dump12,$dump13);
				$c=implode(":",$dump2);
				return $c;
	}



	function O_Format_Tanggal($a)
	{
				$dump11=substr($a,0,4);
				$dump12=substr($a,4,2);
				$dump13=substr($a,6,2);
				$dump2=array ($dump13,$dump12,$dump11);
				$c=implode(".",$dump2);
				return $c;
	}


	function I_Format_Tanggal($a)
	{
				$dump11=substr($a,0,2);
				$dump12=substr($a,3,2);
				$dump13=substr($a,6,4);
				$dump2=array ($dump13,$dump12,$dump11);
				$c=implode("",$dump2);
				return $c;
	}

	function I_Format_Tanggal_1($a)
	{
				$dump11=substr($a,0,2);
				$dump12=substr($a,3,2);
				$dump13=substr($a,6,4);
				$dump2=array ($dump11,$dump12,$dump13);
				$c=implode("",$dump2);
				return $c;
	}

	function I_Format_Waktu($a)
	{
				$dump11=substr($a,0,2);
				$dump12=substr($a,3,2);
				$dump13=substr($a,6,2);
				$dump2=array ($dump11,$dump12,$dump13);
				$c=implode("",$dump2);
				return $c;
	}

	function I_Cek_Notif_No($a)
	{

		$length=strlen($a);

		Switch($length)
		{
		  Case "8":
			$import='0000'.$a;
			break;
			
		  Case "9":
			$import='000'.$a;
			break;
			
		  Case "10":
			$import='00'.$a;
			break;		
			
		  Case "11":
			$import='0'.$a;
			break;
			
		  Case "12":
			$import=$a;
			break;

		}
		return $import;
	}

	function compare($v1,$v2)
	{
	if ($v1===$v2)
	  {
	  return 0;
	  }
	if ($v1>$v2)
	  {
	  return 1;
	  }
	else
	  {
	  return -1;
	  }
	}

	function cekNomerOp($a)
	{
		$length=strlen($a);
		Switch($length) {
		  Case "1":
			$a= '00'.$a.'0';
			break;
		  Case "2":
			$a= '0'.$a.'0';
			break;
		  Case "3":
			$a= $a.'0';
			break;		
		}
		return $a;
	}

	function cekNomerUrut($a)
	{
		$length=strlen($a);
		Switch($length) {
		  Case "1":
			$import= '000'.$a;
			break;
		  Case "2":
			$import= '00'.$a;
			break;
		  Case "3":
			$import= '0'.$a;
			break;		
		}
		return $import;
	}

	function checkBox($a) {
		if($a==1){
			$import='X';
		} else {
			$import='';
		}
		return $import;
	}

	function checkEquipment($a) {
		$length=strlen($a);
		$result='';
		for($i=1;$i<=(18-$length);$i++) {
			$result = "0".$result;
		}

		return $result.''.$a;
	}

	function setFuncloc($val){
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_TPLNREXIT");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}else{
			$fce->I_INPUT=$val;
			$fce->Call();
			return $fce->I_OUTPUT;
		}
	}

	function getTitle($type) {
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_SHGETNOTIFTYPE");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce->Call();

		if ($fce->GetStatus() == SAPRFC_OK) {
			$fce->T_NOTIF->Reset();
		}

		while ($fce->T_NOTIF->Next()){
			if ($fce->T_NOTIF->row['QMART']==$type) {
				$title = $fce->T_NOTIF->row['QMARTX'];
			}
		}
		return $title;
	}

	function getSysStatus($notif) {
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_NOTIFGETDATA");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}

		$fce->I_NUMBER = I_Cek_Notif_No($notif);
		$fce->Call();
		if ($fce->GetStatus() == SAPRFC_OK) {
			$O_STTXT=$fce->O_STTXT;
			$message='';
			if ($O_STTXT=='ORAS' || $O_STTXT=='NOCO' || $O_STTXT=='ORAS NOCO' || $O_STTXT=='DLFL' || $O_STTXT=='DLFL NOCO' || $O_STTXT=='NOPR ORAS') {
				if ($O_STTXT=='ORAS' || $O_STTXT=='NOPR ORAS') {
					$message = "Order was already created for this notification";
				} else {
					$message = "PM notification already completed";
				}
				$status = 'false-'.$message;
			} else {
				$status = 'true-'.$message;
			}
		}

		return $status;
	}

	function getTitleOrder($type) {
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_SHGETORDERTYPE");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}
		$fce->I_AUTYP = '30';
		
		$fce->Call();

		if ($fce->GetStatus() == SAPRFC_OK) {
			$fce->T_AUART->Reset();
		}

		while ($fce->T_AUART->Next()){
			if ($fce->T_AUART->row['AUART']==strtoupper($type)) {
				$title = $fce->T_AUART->row['TXT'];
			}
		}
		return $title;
	}
	function cekOrderType($type) {
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_NOTIFGETDATA");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}

		$fce->I_NUMBER = I_Cek_Notif_No($notif);
		$fce->Call();
		if ($fce->GetStatus() == SAPRFC_OK) {
			$O_STTXT=$fce->O_STTXT;
			$message='';
			if ($O_STTXT=='ORAS' || $O_STTXT=='NOCO' || $O_STTXT=='ORAS NOCO' || $O_STTXT=='DLFL' || $O_STTXT=='DLFL NOCO' || $O_STTXT=='NOPR ORAS') {
				if ($O_STTXT=='ORAS' || $O_STTXT=='NOPR ORAS') {
					$message = "Order was already created for this notification";
				} else {
					$message = "PM notification already completed";
				}
				$status = 'false-'.$message;
			} else {
				$status = 'true-'.$message;
			}
		}

		return $status;
	}

	function setWBS($wbs) {
		include_once("sapfrc/sapclasses/sap.php");
		#include_once("rfc/koneksi.php");
		
		$sap = new SAPConnection();
		$sap->Connect("include/logon_data.conf");


		if ($sap->GetStatus() == SAPRFC_OK ) //$sap->Open ();
		   $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce = &$sap->NewFunction ("Z_ZCPH_RFC_WBSORDERCONV");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}
		
		$fce->INPUT=$wbs;
		$fce->FLAG="I";

		$fce->Call();

		if ($fce->GetStatus() == SAPRFC_OK) {
			$WBS_ELEM=$fce->OUTPUT;
		}

		return $WBS_ELEM;
	}

	function cekSession() {
		if($_SESSION['usrName']==''){
		  echo "<script>parent.location.reload();<script>";
		}
	}

?>