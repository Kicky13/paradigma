<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

class cash_position extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('m_cashposition');
    }

    public function get_data()
    {

        $comp = isset($_GET['comp']) ? $_GET['comp'] : '7000';
        $year = (empty($_GET['year']) ? date('Y') : $_GET['year']);
        $month = (empty($_GET['month']) ? date('m') : $_GET['month']);
        $maxDays = date('t', strtotime(''.$year.'-'.$month."-01 00:00:00"));
        $currentDayOfMonth = date('j');

        $date = array();
        if($year == date('Y') && $month == date('m')){
             $maxDays = $currentDayOfMonth;
        }
        for($i=1;$i<$maxDays+1;$i++){
            if($i<=9){
               $day = '0'.$i; 
            }else{
               $day = $i;  
            }
          $date[] = "$year$month$day"; 
        }

        $cur = isset($_GET['cur']) ? $_GET['cur'] : 'IDR';
        $pos = isset($_POST['id']) ? explode('-', $_POST['id']) : FALSE;
        
        $coh=array();
        $id=0;

        rsort($date);
        foreach($date as $k => $v) {
            if($comp=='1000'){
                $sum = $this->m_cashposition->get_sum_data_all($v, $cur);
                
                $coh[$k]['date'] = date('d F Y', strtotime($v));
                $coh[$k]['cashonhand'] = $this->parser_amount($sum, $cur);
            }else{
                $sum = $this->m_cashposition->get_sum_data($v, $comp, $cur);
                
                $coh[$k]['date'] = date('d F Y', strtotime($v));
                $coh[$k]['cashonhand'] = $this->parser_amount($sum, $cur);
                $coh[$k]['detail'] = $this->get_detail($v, $comp, $cur);
            }
        }
        echo json_encode($coh);
    }
    
    private function get_detail($day, $comp, $cur)
    {
        $lcoh=array();
        foreach(array('SALDO AWAL', 'CASH OUT', 'RECEIPT') as $k => $v) {

            if($k==0) $count = $this->m_cashposition->get_sum_data($day, $comp, $cur, $v, FALSE, TRUE);
            else $count = $this->m_cashposition->get_detail_data($day, $comp, $cur, $v, TRUE);
            
            $lcoh[$k]['title'] = $v;
            $lcoh[$k]['value'] = $this->parser_amount($this->m_cashposition->get_sum_data($day, $comp, $cur, $v), $cur);
        }
        return $lcoh;
    }

    public function parser_amount ($dt, $cur)
    {
        $ret = substr($dt, 0,1) == '-' ? '-'.number_format(substr($dt,1), '0', ',', '').'' : number_format($dt, '0', ',', '');
        return $ret;
    }
    
}

?>