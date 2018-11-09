<?php
  
  header('Access-Control-Allow-Origin: *');
  error_reporting(0);

  $ora_user_sd_dev = "MSADMIN";
  $ora_pasw_sd_dev = "nGUmBEsiwal4N";
  $ora_db_sd_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))) (CONNECT_DATA = (SID = PMT)(SERVER = DEDICATED)))';

  function getConnOraDB($username,$password,$database){
	$conn = @oci_connect($username, $password, $database );
	if (!$conn)
		return false;
	else
	return $conn;
   }
  $conn = getConnOraDB($ora_user_sd_dev, $ora_pasw_sd_dev, $ora_db_sd_dev);

  include_once ("rfc/sapclasses/sap.php");
  $sap = new SAPConnection();
  $sap->Connect('rfc/sapclasses/logon_data.conf'); //PROD
  // $sap->Connect('rfc/sapclasses/logon_datadev.conf'); // Developer
  if ($sap->GetStatus() == SAPRFC_OK)// SAP OPEN
	$sap->Open();
  if ($sap->GetStatus() != SAPRFC_OK) {
	$sap->PrintStatus();
	exit;
  }
  $opco = isset($_GET['company']) ? $_GET['company'] : "1000";
  $fce = $sap->NewFunction('ZCFI_PIUTANG');  
  if ($fce == TRUE) {

  	$fce->LR_BUKRS->row['SIGN'] = "I";
	if($opco=="1000"){
		$fce->LR_BUKRS->row['OPTION'] = "BT";
		$fce->LR_BUKRS->row['LOW'] = "2000";
		$fce->LR_BUKRS->row['HIGH'] = "7000";
	}else{
		$fce->LR_BUKRS->row['OPTION'] = "EQ";
		$fce->LR_BUKRS->row['LOW'] = $opco;
	}
	$fce->LR_BUKRS->append($fce->LR_BUKRS->row);

	$fce->Call();
	if ($fce->GetStatus() == SAPRFC_OK) {
	  $fce->T_BAYAR->Reset();
	   while ($fce->T_BAYAR->Next()) {
	   $sapPrint[] = ($fce->T_BAYAR->row);
			 if($fce->T_BAYAR->row['FLAG'] == 'X'){
				$PLAG [$fce->T_BAYAR->row['VKBUR']]= ($fce->T_BAYAR->row);
			  }
	  }
	  $fce->T_PIUTANG->Reset();
	  while ($fce->T_PIUTANG->Next()) {
	   $sapPrint_2[] = ($fce->T_PIUTANG->row);
	  }
	  $fce->T_PIUTANG_2->Reset();
	  while ($fce->T_PIUTANG_2->Next()) {
	   $sapPrint_3[] = ($fce->T_PIUTANG_2->row);
	  }
	  $fce->T_PIUTANG_3->Reset();
	  while ($fce->T_PIUTANG_3->Next()) {
	   $sapPrint_4[] = ($fce->T_PIUTANG_3->row);
	  }
	  
	}
	$fce->Close();
  }
  $fce2 = $sap->NewFunction('ZCFI_DISPLAY_AR_AGING');  
  if ($fce2 == TRUE) {
  	$fce2->LR_BUKRS->row['SIGN'] = "I";
	if($opco=="1000"){
		$fce2->LR_BUKRS->row['OPTION'] = "BT";
		$fce2->LR_BUKRS->row['LOW'] = "2000";
		$fce2->LR_BUKRS->row['HIGH'] = "7000";
	}else{
		$fce2->LR_BUKRS->row['OPTION'] = "EQ";
		$fce2->LR_BUKRS->row['LOW'] = $opco;
	}
	$fce2->LR_BUKRS->append($fce2->LR_BUKRS->row);

	$fce2->Call();

	if ($fce2->GetStatus() == 0) {

	  $fce2->T_DATA->Reset();
	   while ($fce2->T_DATA->Next()) {
	   $sapPrint_5[] = ($fce2->T_DATA->row);
	  }

	}
	$fce2->Close();
	$sap->Close();
  }
  if($sapPrint_3){
	  foreach($sapPrint_3 as $row){
		  $TOT_PIUTANG_JT['TOTALBESAR'] += $row['TOT_PIUTANG_JT'] ;
	  }
  }
  if($sapPrint_4){
	  foreach($sapPrint_4 as $row){
		  $TOT_PIUTANG_JT['TOTALALL'] += $row['TOT_PIUTANG_JT'] ;
	  }
  }
  $compid=array();
  if($sapPrint_2){
	  foreach($sapPrint_2 as $row)
	  { 
		$LAST_TRANSACTION["DATE"] = $row['INSERT_DATE'] ;
		$LAST_TRANSACTION["TIME"] = $row['INSERT_TIME'] ;
	  	if(!in_array($row['VKBUR'], $compid)){
	  		$compid[] += $row['VKBUR'];
	  	}
		$perPT [$row['VKBUR']] []= $row; 
		$TOT_PIUTANG["TOTAL"] += $row['TOT_PIUTANG'] ;
		$TOT_PIUTANG_JT["TOTAL"] += $row['TOT_PIUTANG_JT'] ;
		$TOT_PIUTANG[$row['VKBUR']] += $row['TOT_PIUTANG'] ;
		$TOT_JAMINAN[$row['VKBUR']] += $row['TOT_JAMINAN'] ;
		$TOT_PIUTANG_JT[$row['VKBUR']] += $row['TOT_PIUTANG_JT'] ;
                // $TOT_PIUTANG_JT['TOTALBESAR'] += $row['TOT_PIUTANG_JT'] ;
	  }
	  $time = strtotime($LAST_TRANSACTION["DATE"].$LAST_TRANSACTION["TIME"]);
	  $lastUpdate = date('d-m-Y H:i:s',$time);
  }
  if($sapPrint){
    foreach( $sapPrint as $bottom){
      if($bottom['TOT_PIUTANG'] != 0){
     	$toba['bayar'] += $bottom['TOT_PIUTANG'];
      }
    }
  }
  $detaildue5 = $detaildue10 = $detaildue15 = $detaildue20 = $detaildue25 = $detaildue30 = $detaildue60 = $detaildue180 = $detaildue356 = $detailduexxx = array();
	if($sapPrint_5){
	    foreach( $sapPrint_5 as $tabledata){
			$DUE5 += $tabledata['DUE5'];
	    	if($tabledata['DUE5']!=0){
	    		$detaildue5[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE5']));
	    	}
			$DUE10 += $tabledata['DUE10'];
	    	if($tabledata['DUE10']!=0){
	    		$detaildue10[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE10']));
	    	}
			$DUE15 += $tabledata['DUE15'];
	    	if($tabledata['DUE15']!=0){
	    		$detaildue15[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE15']));
	    	}
			$DUE20 += $tabledata['DUE20'];
	    	if($tabledata['DUE20']!=0){
	    		$detaildue20[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE20']));
	    	}
			$DUE25 += $tabledata['DUE25'];
	    	if($tabledata['DUE25']!=0){
	    		$detaildue25[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE25']));
	    	}
			$DUE30 += $tabledata['DUE30'];
	    	if($tabledata['DUE30']!=0){
	    		$detaildue30[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE30']));
	    	}
			$DUE60 += $tabledata['DUE60'];
	    	if($tabledata['DUE60']!=0){
	    		$detaildue60[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE60']));
	    	}
			$DUE180 += $tabledata['DUE180'];
	    	if($tabledata['DUE180']!=0){
	    		$detaildue180[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE180']));
	    	}
			$DUE356 += $tabledata['DUE356'];
	    	if($tabledata['DUE356']!=0){
	    		$detaildue356[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUE356']));
	    	}
			$DUEXXX += $tabledata['DUEXXX'];
	    	if($tabledata['DUEXXX']!=0){
	    		$detaildueXXX[] = array('Kode'=>number_format($tabledata['KUNNR']), 'Nama'=>$tabledata['NAME1'], 'Piutang'=>number_format($tabledata['DUEXXX']));
	    	}
	    }
    }

 //  $comp = "'".implode("','", $compid)."'";
 //  $lokasi = oci_parse($conn,"SELECT LOKASI_NAMA,LATITUDE,LONGTITUDE,SAP_CODE FROM INF_LOKASI where LATITUDE is not null and SAP_CODE in ($comp) order by LOKASI_ID asc");
 //  oci_execute($lokasi);
 //  while($row=oci_fetch_array($lokasi)){ 
	// $colect [] = array($row['LOKASI_NAMA'],$row['LATITUDE'],$row['LONGTITUDE'],$row['SAP_CODE'],$TOT_PIUTANG[$row['SAP_CODE']],$TOT_JAMINAN[$row['SAP_CODE']],$TOT_PIUTANG_JT[$row['SAP_CODE']],'B'.$PLAG[$row['SAP_CODE']]['FLAG'],$PLAG[$row['SAP_CODE']]['KUNNR']);
 //  }

  $data_print = array();
  $data_print['total_piutang'] = number_format($TOT_PIUTANG["TOTAL"],0,",",".");
  $data_print['total_piutang_jt'] = number_format($TOT_PIUTANG_JT['TOTALALL'],0,",",".");
  $data_print['total_piutang_jt_all'] = number_format($TOT_PIUTANG_JT['TOTALBESAR'],0,",",".");
  $data_print['total_bayar'] = number_format($toba['bayar'],0,",",".");

  $due = array();
  $due['DUE5'] = number_format($DUE5,0,",",".");
  $due['DTLDUE5'] = $detaildue5;
  $due['DUE10'] = number_format($DUE10,0,",",".");
  $due['DTLDUE10'] = $detaildue10;
  $due['DUE15'] = number_format($DUE15,0,",",".");
  $due['DTLDUE15'] = $detaildue15;
  $due['DUE20'] = number_format($DUE20,0,",",".");
  $due['DTLDUE20'] = $detaildue20;
  $due['DUE25'] = number_format($DUE25,0,",",".");
  $due['DTLDUE25'] = $detaildue25;
  $due['DUE30'] = number_format($DUE30,0,",",".");
  $due['DTLDUE30'] = $detaildue30;
  $due['DUE60'] = number_format($DUE60,0,",",".");
  $due['DTLDUE60'] = $detaildue60;
  $due['DUE180'] = number_format($DUE180,0,",",".");
  $due['DTLDUE180'] = $detaildue180;
  $due['DUE356'] = number_format($DUE356,0,",",".");
  $due['DTLDUE356'] = $detaildue356;
  $due['DUEXXX'] = number_format($DUEXXX,0,",",".");
  $due['DTLDUEXXX'] = $detaildueXXX;

  $data_print['due'] = $due;
  // $data_print['location'] = $colect;


  echo json_encode($data_print);


?>