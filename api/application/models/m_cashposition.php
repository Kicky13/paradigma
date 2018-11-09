<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class m_cashposition extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

	public function get_sum_data_all($date, $cur) {

        $all = $cur == 'ALL' ? TRUE : FALSE;

        $w1 = $all ? '' : "RWCUR = 'IDR' AND";
        $w2 = $all ? '' : "WHERE WAERS = 'IDR'";

        $ret = $this->db->query("

			SELECT NVL(SUM(SUM), 0) AS SUM FROM (
				SELECT
					NVL(HSL*100,0) AS SUM
				FROM
					M_BANK
				LEFT JOIN
				(
					SELECT RBUKRS, RACCT, SUM(HSL) AS HSL
					FROM POSISI_KEUANGAN
					WHERE
					$w1
					BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					GROUP BY RACCT, RBUKRS
				) ON HKONT = SUBSTR(RACCT,3) AND BUKRS = RBUKRS
				$w2
			)

		")->result_array();

        return $ret[0]['SUM'];
        // echoq($this)

        ;
    }
    
	public function get_sum_data ($date, $comp, $cur, $detail=FALSE, $select=FALSE, $count=FALSE)
	{
		if($comp=='1000'){
			$comp="('7000','2000','3000','4000','5000','6000')";
		}else if($comp=='7000' || $comp=='2000'){
			$comp="('7000','2000')";
		}else{
			$comp="('$comp')";
		}
        if($select) $sel = '*';
        elseif($count) $sel = 'COUNT(*) AS SUM';
        else $sel = 'NVL(SUM(SUM), 0) AS SUM';
        
        $where='';
        if($detail) {
            if($detail == 'SALDO AWAL') {
                $where .= "AND BUDAT <= TO_DATE('".date('Y-m-d', strtotime('-1 days', strtotime($date)))." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') ";
            } else {
                if($detail == 'CASH OUT') $where .= "AND DRCRK = 'H' ";
                elseif($detail == 'RECEIPT') $where .= "AND DRCRK = 'S' ";
                $where .= "AND BUDAT BETWEEN TO_DATE('".date('Y-m-d', strtotime($date))." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('".date('Y-m-d', strtotime($date))." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') ";
            }
        } else {
            $where .= "AND BUDAT <= TO_DATE('".date('Y-m-d', strtotime($date))." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') ";
        }
        
		$ret = $this->db->query("
			SELECT $sel FROM (
				SELECT HKONT AS REK, TEXT1, NVL(HSL*100,0) AS SUM, RWCUR
				FROM M_BANK
				LEFT JOIN (
					SELECT RACCT, RBUKRS, SUM(HSL) AS HSL, RWCUR
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN $comp
					AND RWCUR = '$cur'
					$where
					GROUP BY RACCT, RBUKRS, RWCUR
				) ON HKONT = SUBSTR(RACCT,3)
				WHERE BUKRS IN $comp
				AND WAERS = '$cur'
			) WHERE SUM != 0
			ORDER BY SUM DESC
		")->result_array();
		
		return $select ? $ret : $ret[0]['SUM'];
	}
	
	public function get_detail_data($date, $comp, $cur, $detail, $count=FALSE)
	{

		if($comp=='7000' || $comp=='2000'){
			$comp="('7000','2000')";
		}else{
			$comp="('$comp')";
		}
		if($count) $sel = 'COUNT(*) AS JML';
		else $sel = '*';
		
		if($detail == 'CASH OUT') {
			$drcrk = "AND DRCRK = 'H'";
			$groupby = 'LIFNR';
			$groupby_desc = 'N_VEN';
		} elseif($detail == 'RECEIPT') {
			$drcrk = "AND DRCRK = 'S'";
			$groupby = 'KUNNR';
			$groupby_desc = 'N_CUS';
		} else {
			$groupby = $groupby_desc = $drcrk = '';
		}
		
		$ret = $this->db->query("
			
			SELECT $sel FROM( 
				SELECT RBUKRS, RWCUR, $groupby AS REK, $groupby_desc AS TEXT1, SUM(HSL)*100 AS SUM
				FROM POSISI_KEUANGAN
				WHERE RBUKRS = '5000'
				AND RWCUR = 'IDR'
				$drcrk
				AND BUDAT BETWEEN TO_DATE('".date('Y-m-d', strtotime($date))." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('".date('Y-m-d', strtotime($date))." 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				GROUP BY RBUKRS, RWCUR, $groupby, $groupby_desc
			) ORDER BY SUM DESC
			
		")->result_array();
		//echoq($this);
		return $count ? $ret[0]['JML'] : $ret;
	}
	
	public function get_more_detail_data ($date, $comp, $cur, $detail, $more_detail, $count=FALSE)
	{

		if($comp=='7000' || $comp=='2000'){
			$comp="('7000','2000')";
		}else{
			$comp="('$comp')";
		}
		if($count)$this->db->select('COUNT(*) AS JML');
		else $this->db->select('DOCNR, RWCUR, SGTXT, (HSL*100) AS SUM');
		
		if($detail == 'CASH OUT') {
			$this->db->where('DRCRK', 'H');
			if($more_detail) $this->db->where('LIFNR', $more_detail);
			else $this->db->where('LIFNR IS NULL');
		} elseif($detail == 'RECEIPT') {
			$this->db->where('DRCRK', 'S');
			if($more_detail) $this->db->where('KUNNR', $more_detail);
			else $this->db->where('KUNNR IS NULL');
		}
		
		$ret = $this->db
		->from('POSISI_KEUANGAN')
		->where('RBUKRS IN $comp')
		->where('RWCUR', $cur)
		->where("BUDAT BETWEEN TO_DATE('".date('Y-m-d', strtotime($date))."', 'YYYY-MM-DD') AND TO_DATE('".date('Y-m-d', strtotime($date))."', 'YYYY-MM-DD')")
		->get()
		->result_array();
		
		return $count ? $ret[0]['JML'] : $ret;
	}
    
}
