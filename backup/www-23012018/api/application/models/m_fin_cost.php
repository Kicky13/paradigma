<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_fin_cost extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }
	public function get_clinker($comp, $date, $cat, $plant){
		 IF($comp == "smi"){
			 $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
								WHERE CATEGORY = '$cat'
								AND PLANT IN ($plant)
								AND FISCAL_YEAR_PERIOD IN ($date)
								AND GL_ACCOUNT = 'PRD_QTY'
								AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020')");
		 }ELSE{
			 $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
								WHERE CATEGORY = '$cat'
								AND PLANT IN ($plant)
								AND FISCAL_YEAR_PERIOD IN ($date)
								AND GL_ACCOUNT = 'PRD_QTY'
								AND COMPANY IN ('$comp')
								AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020')");
		 }

	return $data->row();
	}
	
	public function get_clinker_sub($comp, $date, $cat, $plant){
		$data = $this->db->query("SELECT
		a.PLANT,
		(
			SELECT SUM(b.AMOUNT)  AS JML
			FROM
				PRODUCTION b
			WHERE
				CATEGORY = '$cat'
			AND b.PLANT = a.PLANT
			AND b.FISCAL_YEAR_PERIOD IN ($date)
			AND b.GL_ACCOUNT = 'PRD_QTY'
			AND b.COMPANY IN ('$comp')
			AND b.MATERIAL IN (
				 '121-200-0010',
					'121-200-0040',
					'121-200-0020'
			)
		) AS JML 
		FROM
			PRODUCTION a
		WHERE
			a.CATEGORY = '$cat'
		AND a.PLANT IN ($plant)
		AND a.FISCAL_YEAR_PERIOD IN ($date)
		AND a.GL_ACCOUNT = 'PRD_QTY'
		AND a.COMPANY IN ('$comp')
		AND a.MATERIAL IN (
				 '121-200-0010',
				'121-200-0040',
				'121-200-0020'
		)
		GROUP BY a.PLANT
		ORDER BY a .PLANT
		");
	
		$datax = array();
		$dataxx = array();
		foreach( $data->result_array() as $key => $val){
			$datax[$val['PLANT']] = $val['JML'];
		}
		$n_plant=explode("','",substr($plant,1,strlen($plant)-2));
		for($i=0;$i<count($n_plant);$i++){
			if(!isset($datax[$n_plant[$i]])){
				$dataxx[]=array("PLANT"=>$n_plant[$i],"JML"=>0);
			}else{
				$dataxx[]=array("PLANT"=>$n_plant[$i],"JML"=>$datax[$n_plant[$i]]);
			}
		}
		return $dataxx;
	}
	
    public function get_cement($comp, $date, $cat, $plant){
        IF($comp == "smi"){
            $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010')");
        }else{
            $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND COMPANY IN ('$comp')
                                AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010')");
        }
        
        return $data->row();
    }
	
    public function get_cement_sub($comp, $date, $cat, $plant){
        $data = $this->db->query("SELECT
		a.PLANT,
		(
			SELECT SUM(b.AMOUNT)  AS JML
			FROM
				PRODUCTION b
			WHERE
				CATEGORY = '$cat'
			AND b.PLANT = a.PLANT
			AND b.FISCAL_YEAR_PERIOD IN ($date)
			AND b.GL_ACCOUNT = 'PRD_QTY'
			AND b.COMPANY IN ('$comp')
			AND b.MATERIAL IN (
				'121-302-0060',
				 '121-301-0060',
				 '121-302-0019',
				 '121-302-0110',
				 '121-302-0040',
				 '121-302-0030',
				 '121-302-0020',
				 '121-302-0010'
			)
		) AS JML 
		FROM
			PRODUCTION a
		WHERE
			a.CATEGORY = '$cat'
		AND a.PLANT IN ($plant)
		AND a.FISCAL_YEAR_PERIOD IN ($date)
		AND a.GL_ACCOUNT = 'PRD_QTY'
		AND a.COMPANY IN ('$comp')
		AND a.MATERIAL IN (
			'121-302-0060',
				 '121-301-0060',
				 '121-302-0019',
				 '121-302-0110',
				 '121-302-0040',
				 '121-302-0030',
				 '121-302-0020',
				 '121-302-0010'
		)
		GROUP BY a.PLANT
		ORDER BY a .PLANT
		");
		$datax = array();
		$dataxx = array();
		foreach( $data->result_array() as $key => $val){
			$datax[$val['PLANT']] = $val['JML'];
		}
		$n_plant=explode("','",substr($plant,1,strlen($plant)-2));
		for($i=0;$i<count($n_plant);$i++){
			if(!isset($datax[$n_plant[$i]])){
				$dataxx[]=array("PLANT"=>$n_plant[$i],"JML"=>0);
			}else{
				$dataxx[]=array("PLANT"=>$n_plant[$i],"JML"=>$datax[$n_plant[$i]]);
			}
		}
		return $dataxx;
    }


    public function get_comparison($time) {
        $temp = "";
        $bln = substr($time, -2);
        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        for ($i = 1; $i <= $bln; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bln) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$month' $tmbhn";
            $temp = $time_between;
        }
        $time_between_lalu = str_replace($year, $year_lalu, $time_between);
        $sub_qry = "(select SUM(AMOUNT) from PRODUCTION where GL_ACCOUNT = 'PRD_QTY' AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010') AND CATEGORY =";
        $q = $this->db->query("SELECT MP.PLANT,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as BUD,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as ACT,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$year_lalu.$bln') as ACT_LALU,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as BUD1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as ACT1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between_lalu)) as ACT_LALU1
        FROM M_PLANT MP 
        WHERE PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7301','7302','7303','7304','7305')");
        $qry = $q->result();
        $dt[] = "";
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;

            $dt['BUD'][$plant] = $sh->BUD;
            $dt['ACT'][$plant] = $sh->ACT;
            $dt['ACT_LALU'][$plant] = $sh->ACT_LALU;
            $dt['BUD1'][$plant] = $sh->BUD1;
            $dt['ACT1'][$plant] = $sh->ACT1;
            $dt['ACT_LALU1'][$plant] = $sh->ACT_LALU1;
        }
        return $dt;
    }


    public function get_comparison_klinker($time){
        $temp = "";
        $bln = substr($time, -2);
        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        for ($i = 1; $i <= $bln; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bln) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$month' $tmbhn";
            $temp = $time_between;
        }
        $time_between_lalu = str_replace($year, $year_lalu, $time_between);
        $sub_qry = "(select SUM(AMOUNT) from PRODUCTION where GL_ACCOUNT = 'PRD_QTY' AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020') AND CATEGORY =";
        $q = $this->db->query("SELECT MP.PLANT,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as BUD,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as ACT,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$year_lalu.$bln') as ACT_LALU,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as BUD1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as ACT1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between_lalu)) as ACT_LALU1
        FROM M_PLANT MP 
        WHERE PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','7301','7302','7303','7304','7305')");
//        echo $this->db->last_query();exit;
        $qry = $q->result();
        $dt[] = "";
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;

            $dt['BUD'][$plant] = $sh->BUD;
            $dt['ACT'][$plant] = $sh->ACT;
            $dt['ACT_LALU'][$plant] = $sh->ACT_LALU;
            $dt['BUD1'][$plant] = $sh->BUD1;
            $dt['ACT1'][$plant] = $sh->ACT1;
            $dt['ACT_LALU1'][$plant] = $sh->ACT_LALU1;
        }
        return $dt;
    }
}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */