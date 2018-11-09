<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_cost_structure extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }
  
    public function get_data_desc($comp, $date, $cat, $limit, $total, $periode){
        if($comp == "smi" && $periode == "selected"){
         $data = $this->db->query(
           "(select CSTR_NO, NVL(AMOUNT,0) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and CSTR_NO between $limit)
             UNION ALL
            (select $total, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and CSTR_NO between $limit)"
         );
        }elseif($comp != "smi" && $periode == "selected"){
         $data = $this->db->query(
           "(select CSTR_NO, NVL (SUM(AMOUNT), 0) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and COMPANY IN ('$comp') and CSTR_NO between $limit GROUP BY CSTR_NO)
             UNION ALL
            (select $total, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and COMPANY IN ('$comp') and CSTR_NO between $limit) "
         );
        }elseif($comp == "smi" && $periode == "upto"){
         $data = $this->db->query(
           "(select CSTR_NO, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and CSTR_NO between $limit group by CSTR_NO)
             UNION ALL
            (select $total, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and CSTR_NO between $limit)"
         );
        }elseif($comp != "smi" && $periode == "upto"){
         $data = $this->db->query(
           "(select CSTR_NO, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and COMPANY IN ('$comp') and CSTR_NO between $limit group by CSTR_NO)
             UNION ALL
            (select $total, SUM(NVL(AMOUNT,0)) AS JML from MV_COST_REPORT_BAWAH where FISCAL_YEAR_PERIOD IN ({$date}) and category = '$cat' and COMPANY IN ('$comp') and CSTR_NO between $limit)"
         );         
        }
        return $data->result();
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
    public function get_sales($comp, $date, $cat){
        
        if($comp == "smi"){
            $data = $this->db->query("select sum(tot) AMOUNT from mv_sales_volume where fiscal_year_period in ($date) and category = '$cat' and DISTRIBUTION_CHANNEL in ('10','20','30','40','50')");
        }else{
            $comp = explode("','", $comp);
            if(count($comp) == 1){
                $comp = "'PSV_$comp[0]','GSV_$comp[0]'";
            }else{
                $comp = "'PSV_$comp[0]','GSV_$comp[0]','PSV_$comp[1]','GSV_$comp[1]'";
            }
            $data = $this->db->query("select sum(tot) AMOUNT from mv_sales_volume where fiscal_year_period in ($date) and category = '$cat' and GL_ACCOUNT in ($comp) and DISTRIBUTION_CHANNEL in ('10','20','30','40','50')");
        }
        return $data->row();
    }


}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */