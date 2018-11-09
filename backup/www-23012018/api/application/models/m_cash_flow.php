<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_cash_flow extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function nampil_text(){
    //     echo "string";
    }

  
    public function get_tabeldata($comp, $date, $datea, $cat, $limit, $periode){
        
        if($comp == "smi" && $periode == "selected"){
         $data = $this->db->query("SELECT
									SUM (NVL(AMOUNT, 0)) AS JML
									FROM
									MV_CASH_FLOW
									WHERE
									CATEGORY = '$cat'
									AND NO BETWEEN $limit
									AND FISCAL_YEAR_PERIOD IN ('$date')");
        }elseif($comp != "smi" && $periode == "selected"){
         $data = $this->db->query("SELECT
									SUM (NVL(AMOUNT, 0)) AS JML
									FROM
									MV_CASH_FLOW
									WHERE
									CATEGORY = '$cat'
									AND COMPANY IN ('$comp')
									AND NO BETWEEN $limit
									AND FISCAL_YEAR_PERIOD IN ('$date')");
        }elseif($comp == "smi" && $periode == "upto"){
         $data = $this->db->query("SELECT
									SUM (NVL(AMOUNT, 0)) AS JML
									FROM
									MV_CASH_FLOW
									WHERE
									CATEGORY = '$cat'
									AND NO BETWEEN $limit
									AND FISCAL_YEAR_PERIOD BETWEEN ('$datea') AND ('$date')");
        }elseif($comp != "smi" && $periode == "upto"){
         $data = $this->db->query("SELECT 
         							SUM (NVL(AMOUNT, 0)) AS JML
									FROM
									MV_CASH_FLOW
									WHERE
									CATEGORY = '$cat'
									AND COMPANY IN ('$comp')
									AND NO BETWEEN $limit
									AND FISCAL_YEAR_PERIOD BETWEEN ('$datea') AND ('$date')");         
        }
        return $data->row();
	}        

}