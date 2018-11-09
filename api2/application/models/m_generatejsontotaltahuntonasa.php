<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_generatejsontotaltahuntonasa extends CI_Model {

	public function get_generatejsontotaltahuntonasa()
	{
		$db=$this->load->database('default4',true);
		if(!empty($_GET['bulan'])){
$bulan = $_GET['bulan'];
	}else{$bulan = date('m');}
if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}else{$tahun = date('Y');}
	
if(!empty($_GET['bulan']) and !empty($_GET['tahun'])){
$wherea = "where opdate BETWEEN to_date('".$_GET['tahun']."-".$_GET['bulan']."-01','YYYY-MM-DD') AND to_date('".$_GET['tahun']."-".$_GET['bulan']."-31','YYYY-MM-DD')";

}else{
$wherea ="";
}
if(!empty($_GET['plant'])){
	switch($_GET['plant']){
		case 1 :
			$wPlant = "where pabrik= 'Tonasa 1'";
			break;
		case 2 :
			$wPlant = "where pabrik= 'Tonasa 2'";
			break;
		case 3 :
			$wPlant = "where pabrik= 'Tonasa 3'";
			break;
		case 4 :
			$wPlant = "where pabrik= 'Tonasa 4'";
			break	;
		default :
		$wPlant = "";
		}
}else{
	$wPlant = "";
}

$query = $db->query("select opdate,rate,prod,runhours,text,tagid,pabrik from v_plg_st_report $wherea order by opdate asc");

	foreach ($query->result_array() as $rowID) {
		$idJson [$rowID['tagid']] = array('tagid' => $rowID['tagid'],
										  'name'  => $rowID['text'],
										  'pabrik' => $rowID['pabrik']
											);
		if($rowID['text'] == 'Feed Raw Mill'){
		$rawMill['rm'][] = $rowID['prod'];}
		
		if($rowID['text'] == 'Feed Kiln'){
		$kilnMill['kl'][] = $rowID['prod'];}

		if($rowID['tagid'] == 'Tonasa 2/3.FM1_TNS2_Feed' || 
			$rowID['tagid'] == 'Tonasa 2/3.FM1_TNS3_Feed' ||
			$rowID['tagid'] == 'Tonasa 4.FM1_TNS4_Feed' ||
			$rowID['tagid'] == 'Tonasa 4.FM2_TNS4_Feed' ||
			$rowID['tagid'] == 'Tonasa 5.FM1_TNS5_Feed' ||
			$rowID['tagid'] == 'Tonasa 5.FM2_TNS5_Feed'){
		$finishMill['fm'][] = $rowID['prod'];}
	}
	$data = array('pabrik'=> 'Tonasa',
					'rawmill'=> number_format(array_sum($rawMill['rm']),0,",",""),
					'kiln'=> number_format(array_sum($kilnMill['kl']),0,",",""),
					'finishmill'=> number_format(array_sum($finishMill['fm']),0,",","")				
				 );

echo json_encode($data);
	}

}

/* End of file m_generatejsontotaltahuntonasa.php */
/* Location: ./application/models/m_generatejsontotaltahuntonasa.php */