<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class m_finance_sales extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    function get_dt_actual_rev($dt) {
        foreach ($dt as $k => $v) {
            if ($k == 'FISCAL_YEAR_PERIOD') {
                if (count($v) == 1) {
                    $this->db->where($k, $v[0]);
                } else {
                    $this->db->where("$k BETWEEN " . $v[0] . " AND " . $v[1]);
                }
            } else {
                $this->db->where($k, $v);
            }
        }

        $ret = $this->db
                ->select('SUM(AMOUNT) AS AMOUNT')
                ->from('MW_KPP')
                ->get()
                ->result_array();

        return $ret[0]['AMOUNT'] ? $ret[0]['AMOUNT'] : 0;
    }

    function get_dt_budgeting_rev($dt) {
        foreach ($dt as $k => $v) {
            if ($k == 'MATERIAL') {
                if ($v == 'SEMEN') {
                    $this->db->where_in('MATERIAL', array('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010'));
                } elseif ($v == 'TERAK') {
                    $this->db->where_in('MATERIAL', array('121-200-0010', '121-200-0040', '121-200-0020'));
                }
            } elseif ($k == 'YEAR') {
                if (count($v) == 1) {
                    $mon = intval(substr($v[0], 5, 2));
                    $this->db->select("SUM(PRC$mon) as PRC$mon")->where($k, intval(substr($v[0], 0, 4)));
                } else {
                    for ($x = intval(substr($v[0], 5, 2)); $x <= intval(substr($v[1], 5, 2)); $x++)
                        $sum[] = "SUM(PRC$x) AS PRC$x";
                    $this->db->select(implode(', ', $sum))->where($k, intval(substr($v[0], 0, 4)));
                }
            } else {
                $this->db->where($k, $v);
            }
        }

        $ret = $this->db
                ->from('SALES_PLAN')
                ->get()
                ->result_array();

        return $ret[0];
    }

    function get_dt_actual_vol($dt)
    {
        foreach($dt as $k => $v) {
            if($k == 'FISCAL_YEAR_PERIOD') {
                if(count($v)==1) {
                    $this->db->where($k, $v[0]);
                } else {
                    $this->db->where("$k BETWEEN ".$v[0]." AND ".$v[1]);
                }
            } else {
                $this->db->where($k, $v);
            }
        }
        
        $ret = $this->db
        ->select('SUM(AMOUNT) AS AMOUNT')
        ->from('MW_KPV')
        ->get()
        ->result_array();
        
        return $ret[0]['AMOUNT'] ? $ret[0]['AMOUNT'] : 0;
    }
    
    function get_dt_budgeting_vol ($dt)
    {
        foreach($dt as $k => $v) {
            if($k=='MATERIAL') {
                if($v=='SEMEN') {
                    $this->db->where_in('MATERIAL', array('121-302-0060','121-301-0060','121-302-0019','121-302-0110','121-302-0040','121-302-0030','121-302-0020','121-302-0010'));
                } elseif($v=='TERAK') {
                    $this->db->where_in('MATERIAL', array('121-200-0010','121-200-0040','121-200-0020'));
                }
            } elseif($k=='YEAR') {
                if(count($v)==1) {
                    $mon=intval(substr($v[0],5,2));
                    $this->db->select("SUM(VOL$mon) as VOL$mon")->where($k, intval(substr($v[0],0,4)));
                } else {
                    for($x=intval(substr($v[0],5,2)) ; $x<=intval(substr($v[1],5,2)) ; $x++) $sum[] = "SUM(VOL$x) AS VOL$x";
                    $this->db->select(implode(', ', $sum))->where($k, intval(substr($v[0],0,4)));
                }
            } else {
                $this->db->where($k, $v);
            }
        }
        
        $ret = $this->db
        ->from('SALES_PLAN')
        ->get()
        ->result_array();
        
        return $ret[0];
    }
    function get_company_desc($comp) {
        $ret = $this->db
                ->select('DESCRIPTION')
                ->from('M_COMPANY')
                ->where('COMPANY', $comp)
                ->get()
                ->result_array();

        return isset($ret[0]) ? $ret[0]['DESCRIPTION'] : false;
    }

}
