<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed'); 

class cashflow_liquidity extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('m_cfliquidity');
    }
	
	public function get_saldo(){
        $comp = isset($_GET['comp']) ? $_GET['comp'] : '7000';
        $month = (empty($_GET['month']) ? date('m') : $_GET['month']);
        $year = (empty($_GET['year']) ? date('Y') : $_GET['year']);

        $tgl=array();
        for($d=1; $d<=31; $d++){
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $tgl[]=date('Ymd', $time);
        }
        $stts = 'closed';
        $return = array();
        if($comp == "ALL"){
            $company = array(array('COMPANY' => '2000', 'DESCRIPTION' =>'PT Semen Indonesia (Persero) Tbk'), array('COMPANY' => '3000', 'DESCRIPTION' =>'PT Semen Padang'), array('COMPANY' => '4000', 'DESCRIPTION' =>'PT Semen Tonasa'), array('COMPANY' => '5000', 'DESCRIPTION' =>'PT Semen Gresik'), array('COMPANY' => '7000', 'DESCRIPTION' =>'KSO SG - SI'), array('COMPANY' => '6000', 'DESCRIPTION' =>'Thang Long Cement Company'), array('COMPANY' => '8000', 'DESCRIPTION' =>'PT Semen Indonesia Aceh'), array('COMPANY' => '9000', 'DESCRIPTION' =>'PT Semen Indonesia Kupang'));
            $data = $this->m_cfliquidity->get_data_all($company, $tgl);
        } else{
            $data = $this->m_cfliquidity->get_data($comp, $tgl);
        }
        
        foreach ($data as $key => $value) {
            foreach ($tgl as $key2 => $value2) {
                $val = number_format($value[$value2], 0, '', '');
                // if($value[$value2] < 0){
                //     $val = str_replace('-','(',$val).')';
                // }
                $return[$key]['VALUE'][] = $val;
            }
            
            $return[$key]["ID"] = $value['ID'];
            $return[$key]["JENIS"] = $value['JENIS'];
            $return[$key]["state"] = $stts;
        }

        echo json_encode($return);

	}

    public function get_kurs(){
        $tgl = (empty($_GET['date']) ? date('Y.m') : $_GET['date']);
        $data = $this->m_cfliquidity->get_kurs($tgl); 
        foreach ($data as $key => $value) {
            $return[$value->CURRENCY][$value->TANGGAL] = array('KURS' => $value->KURS);
        }
        foreach($return as $key => $value){
            $datesebelum = 0;
            $kurssebelum = 0;
            foreach($value as $key2 => $value2){
                $datadate =  (int) date('j',strtotime($key2));
                $dataYM =  date('Ym',strtotime($key2));
                if($datadate>1){
                    if($datadate-1!=$datesebelum){
                        for($i=$datadate-1;$i>$datesebelum;$i--){
                            $datex = ($i<=9)? "0".$i : $i;
                            $return[$key][$dataYM.$datex] = array('KURS' => $kurssebelum);
                        }
                    }
                }
                $datesebelum = $datadate;
                $kurssebelum = $value2['KURS'];
            }
        }
        echo json_encode($return);
    }

}

/* End of file cashflow_liquidity.php */
/* Location: ./application/controllers/cashflow_liquidity.php */