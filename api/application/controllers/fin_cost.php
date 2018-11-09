<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class fin_cost extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('m_fin_cost');
    }
	
	public function get_data_mview(){
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp = str_replace(",","','",$comp);
		
        $date = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
        $strdate=str_replace(".","-",$date)."-20";
        $newdate = strtotime('-1 month' , strtotime ($strdate)) ;
        $date_lmonth = date( 'Y.m' , $newdate);
        $date_lyear      = (intval(substr($date, 0, 4)) - 1).substr($date,4);
        $temp           = $this->date_between($date);
        $temp_lyear     = $this->date_between($date_lyear);
		
        $year = (empty($_GET['year']) ? date('Y') : $_GET['year']);
		
        $clinker        = array();
        $cement         = array();
		
        if($comp == '2000'){
            $plant      = "'2301','2302','2303','2304','2305','2390'";
            $plant2     = "'2301','2302','2303','2304','2305','2390'";
        }else if($comp == '3000'){
            $plant      = "'3301','3302','3303','3304','3309'";
            $plant2     = "'3301','3302','3303','3304','3309'";
        }else if($comp == '4000'){
            $plant      = "'4301','4302','4303'";
            $plant2     = "'4301','4302','4303'";
        }else if($comp == '7000'){
            $plant      = "'7302','7303','7304','7305'";
            $plant2     = "'7301','7302','7303','7304','7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'2301','2302','2303','2304','2305','2390','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','7301','7302','7303','7304','7305'";
        }else if($comp == 'smi'){
            $plant      = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7301','7302','7303','7304','7305'";
        }else if($comp == '5000'){
            $plant      = "'5301','5390','5391'";
            $plant2      = "'5301','5390','5391'";
        }
		
        $comp_now = $comp;
        $comp_ly = $comp;
		
        $data1 = array();
		
        //ACTUAL
        $clinker1       = $this->m_fin_cost->get_clinker($comp_now, $date, 'ACT', $plant);
        $clinker2       = $this->m_fin_cost->get_clinker($comp_now, $date_lmonth, 'ACT', $plant);
        $clinker3       = $this->m_fin_cost->get_clinker($comp_now, $date_lyear, 'ACT', $plant);
        $clinker1sub    = $this->m_fin_cost->get_clinker_sub($comp_now, $date, 'ACT', $plant);
        $clinker2sub    = $this->m_fin_cost->get_clinker_sub($comp_now, $date_lmonth, 'ACT', $plant);
		
        $cement1       = $this->m_fin_cost->get_cement($comp_now, $date, 'ACT', $plant2);
        $cement2       = $this->m_fin_cost->get_cement($comp_now, $date_lmonth, 'ACT', $plant2);
        $cement3       = $this->m_fin_cost->get_cement($comp_now, $date_lyear, 'ACT', $plant2);
        $cement1sub    = $this->m_fin_cost->get_cement_sub($comp_now, $date, 'ACT', $plant2);
        $cement2sub    = $this->m_fin_cost->get_cement_sub($comp_now, $date_lmonth, 'ACT', $plant2);
		
        //BUDGET
        $bud_clinker1       = $this->m_fin_cost->get_clinker($comp_now, $date, 'BUD', $plant);
        $bud_clinker2       = $this->m_fin_cost->get_clinker($comp_now, $date_lmonth, 'BUD', $plant);
        $bud_clinker1sub    = $this->m_fin_cost->get_clinker_sub($comp_now, $date, 'BUD', $plant);
        $bud_clinker2sub    = $this->m_fin_cost->get_clinker_sub($comp_now, $date_lmonth, 'BUD', $plant);
		
        $bud_cement1       = $this->m_fin_cost->get_cement($comp_now, $date, 'BUD', $plant2);
        $bud_cement2       = $this->m_fin_cost->get_cement($comp_now, $date_lmonth, 'BUD', $plant2);
        $bud_cement1sub    = $this->m_fin_cost->get_cement_sub($comp_now, $date, 'BUD', $plant2);
        $bud_cement2sub    = $this->m_fin_cost->get_cement_sub($comp_now, $date_lmonth, 'BUD', $plant2);
		
		$subvalcement1 = array();
		$subvalcement2 = array();
		$i = 0; foreach($cement1sub as $row){
			$subvalcement1[$i]['PLANT'] = $row['PLANT'];
			$subvalcement1[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		$i = 0; foreach($cement2sub as $row){
			$subvalcement2[$i]['PLANT'] = $row['PLANT'];
			$subvalcement2[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		
		$subvalbudcement1 = array();
		$subvalbudcement2 = array();
		$i = 0; foreach($bud_cement1sub as $row){
			$subvalbudcement1[$i]['PLANT'] = $row['PLANT'];
			$subvalbudcement1[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		$i = 0; foreach($bud_cement2sub as $row){
			$subvalbudcement2[$i]['PLANT'] = $row['PLANT'];
			$subvalbudcement2[$i]['JML'] = (float) $row['JML'];
			$i++;
		}		
		
		$subvalclinker1 = array();
		$subvalclinker2 = array();
		$i = 0; foreach($clinker1sub as $row){
			$subvalclinker1[$i]['PLANT'] = $row['PLANT'];
			$subvalclinker1[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		$i = 0; foreach($clinker2sub as $row){
			$subvalclinker2[$i]['PLANT'] = $row['PLANT'];
			$subvalclinker2[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		
		$subvalbudclinker1 = array();
		$subvalbudclinker2 = array();
		$i = 0; foreach($bud_clinker1sub as $row){
			$subvalbudclinker1[$i]['PLANT'] = $row['PLANT'];
			$subvalbudclinker1[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		$i = 0; foreach($bud_clinker2sub as $row){
			$subvalbudclinker2[$i]['PLANT'] = $row['PLANT'];
			$subvalbudclinker2[$i]['JML'] = (float) $row['JML'];
			$i++;
		}
		
		$data1['act_bulan_ini']['clinker']       = (float) $clinker1->JML;
		$data1['act_bulan_ini']['opcosubclinker']       = $subvalclinker1;
		
        $data1['act_bulan_ini']['cement']        = (float) $cement1->JML;
		$data1['act_bulan_ini']['opcosubcement']       = $subvalcement1;
		
        $data1['act_bulan_lalu']['clinker']      = (float) $clinker2->JML;
        $data1['act_bulan_lalu']['opcosubclinker']      = $subvalclinker2;

        $data1['act_tahun_lalu']['clinker']      = (float) $clinker3->JML;

        $data1['act_bulan_lalu']['cement']        = (float) $cement2->JML;
		$data1['act_bulan_lalu']['opcosubcement']       = $subvalcement2;
		
        $data1['act_tahun_lalu']['cement']      = (float) $cement3->JML;
        
        $data1['rkap_bulan_ini']['clinker']       = (float) $bud_clinker1->JML;
		$data1['rkap_bulan_ini']['opcosubclinker']       = $subvalbudclinker1;
		
        $data1['rkap_bulan_ini']['cement']       = (float) $bud_cement1->JML;
        $data1['rkap_bulan_ini']['opcosubcement']       = $subvalbudcement1;
		
        $data1['rkap_bulan_lalu']['clinker']      = (float) $bud_clinker2->JML;
		$data1['rkap_bulan_lalu']['opcosubclinker']       = $subvalbudclinker2;
		
        $data1['rkap_bulan_lalu']['cement']      = (float) $bud_cement2->JML;
		$data1['rkap_bulan_lalu']['opcosubcement']       = $subvalbudcement2;
		
        $data['s'.$comp] = array($data1);
		print_r(json_encode($data));
	}
	
	public function get_data_mperform(){
		
        $comp = (empty($_GET['company']) ? 'smi' : $_GET['company']);
        $comp = str_replace(",","','",$comp);
		
        $year = (empty($_GET['year']) ? date('Y') : $_GET['year']);
		
        $clinker        = array();
        $cement         = array();
		
        $data1 = array();
		
        
        if($comp == '2000'){
            $plant      = "'2301','2302','2303','2304','2305','2390'";
            $plant2     = "'2301','2302','2303','2304','2305','2390'";
        }else if($comp == '3000'){
            $plant      = "'3301','3302','3303','3304','3309'";
            $plant2     = "'3301','3302','3303','3304','3309'";
        }else if($comp == '4000'){
            $plant      = "'4301','4302','4303'";
            $plant2     = "'4301','4302','4303'";
        }else if($comp == '7000'){
            $plant      = "'7302','7303','7304','7305'";
            $plant2     = "'7301','7302','7303','7304','7305'";
        }else if($comp == "2000','7000"){
            $plant      = "'2301','2302','2303','2304','2305','2390','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','7301','7302','7303','7304','7305'";
        }else if($comp == 'smi'){
            $plant      = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7302','7303','7304','7305'";
            $plant2     = "'2301','2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7301','7302','7303','7304','7305'";
        }else if($comp == '5000'){
            $plant      = "'5302','5303','5304','5305'";
            $plant2     = "'5301','5302','5303','5304','5305'";
        }
		
				
		//PERFORMANCE
		for($dm=1;$dm<13;$dm++){
			$dmx=($dm<10)?"0".$dm:$dm;
			$perform_clinker = $this->m_fin_cost->get_clinker($comp, $year.".".$dmx, 'ACT', $plant);
			$perform_cement = $this->m_fin_cost->get_cement($comp, $year.".".$dmx, 'ACT', $plant2);
			
			$perform_clinker_sub = $this->m_fin_cost->get_clinker_sub($comp, $year.".".$dmx, 'ACT', $plant);
			$perform_cement_sub = $this->m_fin_cost->get_cement_sub($comp, $year.".".$dmx, 'ACT', $plant2);
			
			$data1['act_tahun_ini'][$dm]['clinker'] = (float) $perform_clinker->JML;
			$data1['act_tahun_ini'][$dm]['cement'] = (float) $perform_cement->JML;
			
			$perform_subvalclinker1 = array();
			$perform_subvalcement1 = array();
			$i = 0; foreach($perform_clinker_sub as $row){
				$perform_subvalclinker1[$i]['PLANT'] = $row['PLANT'];
				$perform_subvalclinker1[$i]['JML'] = (float) $row['JML'];
				$i++;
			}
			$i = 0; foreach($perform_cement_sub as $row){
				$perform_subvalcement1[$i]['PLANT'] = $row['PLANT'];
				$perform_subvalcement1[$i]['JML'] = (float) $row['JML'];
				$i++;
			}
			
			$data1['act_tahun_ini'][$dm]['opcosubclinker'] = $perform_subvalclinker1;
			$data1['act_tahun_ini'][$dm]['opcosubcement'] = $perform_subvalcement1;
		}
		
		$data['s'.$comp] = array($data1);
		print_r(json_encode($data));
	}
	
	function date_between($date){
		$datestr = explode(".",$date);
		$period = array();
		for ($x=1;$x<=intval($datestr[1]);$x++){
			$tmp = '0'.$x;
			array_push($period, "'".(intval($datestr[0])).'.'.substr($tmp,-2)."'");    
		} 
		return implode($period,",");
	}
}

/* End of file fin_cost.php */
/* Location: ./application/controllers/fin_cost.php */