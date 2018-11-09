<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_cashflow extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function nampil_text(){
    //     echo "string";
    }

  
    public function get_tabeldata($comp, $date, $cat, $limit, $total, $periode){
        
        if($comp == "smi" && $periode == "selected"){
         $data = $this->db->query(
           "(SELECT
				TO_NUMBER(NO, 999) AS NOMOR,
				NVL (AMOUNT, 0) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND NO BETWEEN $limit
			)
			UNION ALL
			(
			SELECT
				TO_NUMBER($total, 999) AS NOMOR,
				SUM (NVL(AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND NO BETWEEN $limit)"
         );
        }elseif($comp != "smi" && $periode == "selected"){
         $data = $this->db->query(
           "(SELECT
				TO_NUMBER(NO, 999) AS NOMOR,
				NVL(SUM(AMOUNT), 0) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND COMPANY IN ('$comp')
				AND NO BETWEEN $limit
			GROUP BY NO
			)
			UNION ALL
			(
			SELECT
				TO_NUMBER($total, 999) AS NOMOR,
				SUM (NVL(AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND COMPANY IN ('$comp')
				AND NO BETWEEN $limit)"
         );
        }elseif($comp == "smi" && $periode == "upto"){
         $data = $this->db->query(
           "(SELECT
				TO_NUMBER(NO, 999) AS NOMOR,
				SUM(NVL (AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND NO BETWEEN $limit
				GROUP BY NO
			)
			UNION ALL
			(
			SELECT
				TO_NUMBER($total, 999) AS NOMOR,
				SUM (NVL(AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND NO BETWEEN $limit)"
         );
        }elseif($comp != "smi" && $periode == "upto"){
         $data = $this->db->query(
           "(SELECT
				TO_NUMBER(NO, 999) AS NOMOR,
				SUM(NVL (AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND COMPANY IN ('$comp')
				AND NO BETWEEN $limit
				GROUP BY NO
			)
			UNION ALL
			(
			SELECT
				TO_NUMBER($total, 999) AS NOMOR,
				SUM (NVL(AMOUNT, 0)) AS JML
			FROM
				MV_CASH_FLOW
			WHERE
				FISCAL_YEAR_PERIOD IN ({$date})
				AND CATEGORY = '$cat'
				AND COMPANY IN ('$comp')
				AND NO BETWEEN $limit)"
         );         
        }
        return $data->result_array();
	}        

    public function get_dataoperation($comp, $date, $cat, $kode){
    	$sql =  "(SELECT AMOUNT 
				FROM MV_CASH_FLOW
				WHERE NO = '$kode'
				AND COMPANY IN ('$comp')
				AND FISCAL_YEAR_PERIOD IN ('$date') 
				AND CATEGORY = '$cat')"     ;

    	$data = $this->db->query(
           	$sql
			);
   
    	$result = $data->result_array();
  		
  		return $result;

    }

    public function get_dataoperationupto($comp, $date, $datea, $cat, $kode){
    	$sql =  "(SELECT AMOUNT 
				FROM MV_CASH_FLOW
				WHERE NO = '$kode'
				AND COMPANY IN ('$comp')
				AND FISCAL_YEAR_PERIOD BETWEEN ('$date') AND ('$datea')
				AND CATEGORY = '$cat')"     ;

    	$data = $this->db->query(
           	$sql
			);
   
    	$result = $data->row_array();
  		
  		return $result;

    }

    public function get_dataoperation_old($comp, $date, $cat, $kode){
        
    		$data = $this->db->query(
            "(SELECT AMOUNT 
				FROM MV_CASH_FLOW
				WHERE NO = '$kode'
				AND COMPANY IN ('&comp')
				AND FISCAL_YEAR_PERIOD IN ('$date') 
				AND CATEGORY = '$cat')"     
			);

        return $data->result_array();
    }

}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */