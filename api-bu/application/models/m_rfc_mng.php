<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_rfc_mng extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function nampil_text(){
    //     echo "string";
    }

  
    public function get_tabeldata($comp,$date){

    	IF($comp == "smi"){
            $data = $this->db->query("SELECT 
										SUM(NVL(TOTAL, 0)) AS TOTAL_PIUTANG,
										SUM(NVL(FUTURE, 0)) AS AKAN_TEMPO,
										SUM(NVL(DUE1_30, 0)) AS TEMPO1_30,
										SUM(NVL(DUE31_60, 0))AS TEMPO31_60,
										SUM(NVL(DUE61_120, 0)) AS TEMPO61_120,
										SUM(NVL(DUE121_360, 0)) AS TEMPO121_360,
										SUM(NVL(DUE361_720, 0)) AS TEMPO361_720,
										SUM(NVL(DUE721_999, 0)) AS TEMPO721_999,
										SUM(NVL(DUE_999, 0))AS TEMPO999,
										SUM(NVL(AGING_MAX, 0))AS USIA
									FROM 
										ZCSD_AR_AGING
									WHERE DATUM IN ('$date')");
        }else{
            $data = $this->db->query("SELECT 
										SUM(NVL(TOTAL, 0)) AS TOTAL_PIUTANG,
										SUM(NVL(FUTURE, 0)) AS AKAN_TEMPO,
										SUM(NVL(DUE1_30, 0)) AS TEMPO1_30,
										SUM(NVL(DUE31_60, 0))AS TEMPO31_60,
										SUM(NVL(DUE61_120, 0)) AS TEMPO61_120,
										SUM(NVL(DUE121_360, 0)) AS TEMPO121_360,
										SUM(NVL(DUE361_720, 0)) AS TEMPO361_720,
										SUM(NVL(DUE721_999, 0)) AS TEMPO721_999,
										SUM(NVL(DUE_999, 0))AS TEMPO999,
										SUM(NVL(AGING_MAX, 0))AS USIA
									FROM 
										ZCSD_AR_AGING
									WHERE DATUM IN ('$date')
									AND BUKRS IN ('$comp')");
        }
        return $data->row();
	}   

	public function get_tabeldataup($comp,$date,$dateprev){

    	IF($comp == "smi"){
            $data = $this->db->query("SELECT 
										SUM(NVL(TOTAL, 0)) AS TOTAL_PIUTANG,
										SUM(NVL(FUTURE, 0)) AS AKAN_TEMPO,
										SUM(NVL(DUE1_30, 0)) AS TEMPO1_30,
										SUM(NVL(DUE31_60, 0))AS TEMPO31_60,
										SUM(NVL(DUE61_120, 0)) AS TEMPO61_120,
										SUM(NVL(DUE121_360, 0)) AS TEMPO121_360,
										SUM(NVL(DUE361_720, 0)) AS TEMPO361_720,
										SUM(NVL(DUE721_999, 0)) AS TEMPO721_999,
										SUM(NVL(DUE_999, 0))AS TEMPO999,
										SUM(NVL(AGING_MAX, 0))AS USIA
									FROM 
										ZCSD_AR_AGING
									WHERE DATUM BETWEEN ('$dateprev') AND ('$date')");
        }else{
            $data = $this->db->query("SELECT 
										SUM(NVL(TOTAL, 0)) AS TOTAL_PIUTANG,
										SUM(NVL(FUTURE, 0)) AS AKAN_TEMPO,
										SUM(NVL(DUE1_30, 0)) AS TEMPO1_30,
										SUM(NVL(DUE31_60, 0))AS TEMPO31_60,
										SUM(NVL(DUE61_120, 0)) AS TEMPO61_120,
										SUM(NVL(DUE121_360, 0)) AS TEMPO121_360,
										SUM(NVL(DUE361_720, 0)) AS TEMPO361_720,
										SUM(NVL(DUE721_999, 0)) AS TEMPO721_999,
										SUM(NVL(DUE_999, 0))AS TEMPO999,
										SUM(NVL(AGING_MAX, 0))AS USIA
									FROM 
										ZCSD_AR_AGING
									WHERE BUKRS IN ('$comp') AND DATUM BETWEEN ('$dateprev') AND ('$date')");
        }
        return $data->row();
	}        


}
