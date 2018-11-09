<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

class inventory extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('m_inventory');
    }

    public function get_data()
    {
        $comp = isset($_GET['comp']) ? $_GET['comp'] : '7000';
        $year = (empty($_GET['year']) ? date('Y') : $_GET['year']);
        $month = (empty($_GET['month']) ? date('m') : $_GET['month']);
        $date = $year.$month;
        
        if($comp=='7000'){
            $pobar = "'ZG01', 'ZG02', 'ZG03', 'ZG04', 'ZG05', 'ZG10', 'ZK01', 'ZK02', 'ZK03', 'ZK04', 'ZK05', 'ZK10'";
            $pobah = "'ZK06', 'ZG08', 'ZG09', 'ZG14', 'ZK06', 'ZK08', 'ZK09', 'ZK14'";
            $pojas = "'ZG07', 'ZK07'";
            $doctypepr = "'ZIV1', 'ZIVK'";
            $doctypepo = "'ZG05'";
        }else if($comp=='3000'){
            $pobar = "'ZP01', 'ZP02', 'ZP03', 'ZP04', 'ZP05', 'ZP10', 'ZP11', 'ZP12'";
            $pobah = "'ZP06', 'ZP08', 'ZP09'";
            $pojas = "'ZP07'";
            $doctypepr = "'ZIV2'";
            $doctypepo = "'ZP05'";
        }else if($comp=='4000'){
            $pobar = "'ZT01', 'ZT02', 'ZT03', 'ZT04', 'ZT05', 'ZT10', 'ZT12'";
            $pobah = "'ZT06', 'ZT08', 'ZT09', 'ZT13'";
            $pojas = "'ZT07'";
            $doctypepr = "'ZIV3', 'ZIV4'";
            $doctypepo = "'ZG05'";
        }else if($comp=='5000'){
            $pobar = "'ZO01', 'ZO02', 'ZO03', 'ZO04', 'ZO05'";
            $pobah = "'ZO06', 'ZO08', 'ZO09', 'ZO14'";
            $pojas = "'ZO07'";
            $doctypepr = "'ZIVO'";
            $doctypepo = "'ZO05'";
        }else if($comp=='6000'){
            $pobar = "'ZV01', 'ZV02', 'ZV03', 'ZV05'";
            $pobah = "'ZV08', 'ZV09'";
            $pojas = "'ZV07'";
            $doctypepr = "'ZIV9'";
            $doctypepo = "'ZV05'";
        }

        $result['total_po'] = $this->m_inventory->get_total_po($date, $comp);
        $result['total_pr'] = $this->m_inventory->get_total_pr($date, $comp);
        $result['total_po_value'] = $this->m_inventory->get_total_poval($date, $comp);
        $result['total_po_barang'] = $this->m_inventory->get_total_pobar($date, $pobar);
        $result['total_po_bahan'] = $this->m_inventory->get_total_pobah($date, $pobah);
        $result['total_po_jasa'] = $this->m_inventory->get_total_pojas($date, $pojas);
        $result['total_invest_pr'] = $this->m_inventory->get_invest_pr($date, $doctypepr);
        $result['total_invest_po'] = $this->m_inventory->get_invest_po($date, $doctypepo);
        $trendpo = $this->m_inventory->get_trend_po($year, $comp);
        $trendpo_prev = $this->m_inventory->get_trend_po($year-1, $comp);
        $result['trend_po'] = $this->settrendpo($trendpo, $year);
        $result['trend_po_prev'] = $this->settrendpo($trendpo_prev, $year-1);
        $trendinvest = $this->m_inventory->get_trend_invest($year, $doctypepr, $doctypepo);
        $trendinvest_prev = $this->m_inventory->get_trend_invest($year-1, $doctypepr, $doctypepo);
        $result['trend_invest'] = $this->settrendinvest($trendinvest, $year);
        $result['trend_invest_prev'] = $this->settrendinvest($trendinvest_prev, $year);

        echo json_encode($result); 
    }

    function settrendpo($data, $year) {
        $blnpo = 1;
        $newtrendpo = array();
        foreach($data as $value => $k){
            $mnt = (int)subStr($k->MONTH, 4,2);
            if($blnpo!=$mnt){
                for($i=0;$i<($mnt-$blnpo);$i++){
                    $ddata = new stdClass();
                    $ddata->MONTH = $year.$i;
                    $ddata->TOTAL_PO = "0";
                    $ddata->TOTAL_ITEM = "0";
                    $newtrendpo[] = $ddata;                               
                } 
            }else{
                $newtrendpo[] = $k;
            }
            $blnpo++;
        }
        for($i=$blnpo;$i<=12;$i++){
            $ddata = new stdClass();
            $ddata->MONTH = $year.$i;
            $ddata->TOTAL_PO = "0";
            $ddata->TOTAL_ITEM = "0";
            $newtrendpo[] = $ddata;                               
        } 
        return $newtrendpo;
    }

    function settrendinvest($data, $year) {
        $blnpo = 1;
        $newtrendpo = array();
        foreach($data as $value => $k){
            $mnt = (int)subStr($k->MONTH, 4,2);
            if($blnpo!=$mnt){
                for($i=0;$i<($mnt-$blnpo);$i++){
                    $ddata = new stdClass();
                    $ddata->MONTH = $year.$i;
                    $ddata->TOTAL_PR = "0";
                    $ddata->TOTAL_PO = "0";
                    $newtrendpo[] = $ddata;                               
                } 
            }else{
                $newtrendpo[] = $k;
            }
            $blnpo++;
        }
        for($i=$blnpo;$i<=12;$i++){
            $ddata = new stdClass();
            $ddata->MONTH = $year.$i;
            $ddata->TOTAL_PR = "0";
            $ddata->TOTAL_PO = "0";
            $newtrendpo[] = $ddata;                               
        } 
        return $newtrendpo;
    }
}

?>