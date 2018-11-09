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
								AND MATERIAL IN ('121_200_0010', '121_200_0040', '121_200_0020')");
		 }ELSE{
			 $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
								WHERE CATEGORY = '$cat'
								AND PLANT IN ($plant)
								AND FISCAL_YEAR_PERIOD IN ($date)
								AND GL_ACCOUNT = 'PRD_QTY'
								AND COMPANY IN ('$comp')
								AND MATERIAL IN ('121_200_0010', '121_200_0040', '121_200_0020')");
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
				'121_200_0010',
				'121_200_0040',
				'121_200_0020'
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
			'121_200_0010',
			'121_200_0040',
			'121_200_0020'
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
                                AND MATERIAL IN ('121_302_0060', '121_301_0060', '121_302_0019', '121_302_0110', '121_302_0040', '121_302_0030', '121_302_0020', '121_302_0010')");
        }else{
            $data = $this->db->query("SELECT SUM(AMOUNT) AS JML FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND COMPANY IN ('$comp')
                                AND MATERIAL IN ('121_302_0060', '121_301_0060', '121_302_0019', '121_302_0110', '121_302_0040', '121_302_0030', '121_302_0020', '121_302_0010')");
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
				'121_302_0060',
				'121_301_0060',
				'121_302_0019',
				'121_302_0110',
				'121_302_0040',
				'121_302_0030',
				'121_302_0020',
				'121_302_0010'
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
			'121_302_0060',
			'121_301_0060',
			'121_302_0019',
			'121_302_0110',
			'121_302_0040',
			'121_302_0030',
			'121_302_0020',
			'121_302_0010'
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
}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */