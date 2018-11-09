<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class fin_sales extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('m_fin_sales');
    }
	
	public function get_data_salesvp(){
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
        
		$data1 = array();
		
		if($comp == '3000'){
            $comp_now = 'SP';
        }else if($comp == '4000'){
            $comp_now = 'ST';
		}else if($comp == 'smi'){
            $comp_now = 'SI';
		}else if($comp == 'smii'){
            $comp_now = 'SII';
		}else if($comp == '3000i'){
            $comp_now = 'SPI';
		}else if($comp == '4000i'){
            $comp_now = 'STI';
		}
		
        $datacement1       = $this->m_fin_sales->get_vol_perform($comp_now, $date, 'PENJUALAN', 'SEMEN');
        $dataterak1       = $this->m_fin_sales->get_vol_perform($comp_now, $date, 'PENJUALAN', 'TERAK');
		
        $datacement2       = $this->m_fin_sales->get_vol_perform($comp_now, $date, 'EKS', 'SEMEN');
        $dataterak2       = $this->m_fin_sales->get_vol_perform($comp_now, $date, 'EKS', 'TERAK');
		
		$data1['Domestic']['act_bulan_ini']['cement']       = (float) $datacement1->JML;
		$data1['Domestic']['act_bulan_ini']['terak']       = (float) $dataterak1->JML;
		$total1 = $data1['Domestic']['act_bulan_ini']['cement']+$data1['Domestic']['act_bulan_ini']['terak'];
		$data1['Domestic']['act_bulan_ini']['total']       = (float) $total1;
		
		$data1['Export']['act_bulan_ini']['cement']       = (float) $datacement2->JML;
		$data1['Export']['act_bulan_ini']['terak']       = (float) $dataterak2->JML;
		$total2 = $data1['Export']['act_bulan_ini']['cement']+$data1['Export']['act_bulan_ini']['terak'];
		$data1['Export']['act_bulan_ini']['total']       = (float) $total2;
		
        $data['s'.$comp] = array($data1);
		print_r(json_encode($data));
	}
	
	public function get_data_salesrp(){
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
        
		$data1 = array();
		
		if($comp == '3000'){
            $comp_now = 'SP';
        }else if($comp == '4000'){
            $comp_now = 'ST';
		}else if($comp == 'smi'){
            $comp_now = 'SI';
		}else if($comp == 'smii'){
            $comp_now = 'SII';
		}else if($comp == '3000i'){
            $comp_now = 'SPI';
		}else if($comp == '4000i'){
            $comp_now = 'STI';
		}
		
        $datacement1       = $this->m_fin_sales->get_rev_perform($comp_now, $date, 'PENJUALAN', 'SEMEN');
        $dataterak1       = $this->m_fin_sales->get_rev_perform($comp_now, $date, 'PENJUALAN', 'TERAK');
		
        $datacement2       = $this->m_fin_sales->get_rev_perform($comp_now, $date, 'EKS', 'SEMEN');
        $dataterak2       = $this->m_fin_sales->get_rev_perform($comp_now, $date, 'EKS', 'TERAK');
		
		$data1['Domestic']['act_bulan_ini']['cement']       = (float) $datacement1->JML;
		$data1['Domestic']['act_bulan_ini']['terak']       = (float) $dataterak1->JML;
		$total1 = $data1['Domestic']['act_bulan_ini']['cement']+$data1['Domestic']['act_bulan_ini']['terak'];
		$data1['Domestic']['act_bulan_ini']['total']       = (float) $total1;
		
		$data1['Export']['act_bulan_ini']['cement']       = (float) $datacement2->JML;
		$data1['Export']['act_bulan_ini']['terak']       = (float) $dataterak2->JML;
		$total2 = $data1['Export']['act_bulan_ini']['cement']+$data1['Export']['act_bulan_ini']['terak'];
		$data1['Export']['act_bulan_ini']['total']       = (float) $total2;
		
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