<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cost_report extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }
    
    public function get_data($comp, $date){
        
        $data = $this->db->query("SELECT GL_ACCOUNT FROM FINANCIAL
                                WHERE COMPANY IN ('$comp')
                                AND FISCAL_YEAR_PERIOD = '$date'
                                AND AUDITTRAIL = 'CSTRU'
                                ORDER BY CSTR_NO ");
        return $data->result();
    }
    public function get_data_cat($comp, $date, $cat){
        if($comp == "smi"){
            $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM FINANCIAL
                                WHERE FISCAL_YEAR_PERIOD IN ($date)
                                AND AUDITTRAIL = 'CSTRU'
                                AND CATEGORY = '$cat'
                                GROUP BY GL_ACCOUNT, CSTR_NO
				ORDER BY CSTR_NO");
        }else{
            $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM FINANCIAL
                                WHERE COMPANY IN ('$comp')
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND AUDITTRAIL = 'CSTRU'
                                AND CATEGORY = '$cat'
                                GROUP BY GL_ACCOUNT, CSTR_NO
                                ORDER BY CSTR_NO ");
        }
        
        return $data->result();
    }
    
    public function get_data_desc($comp, $date, $cat, $type){
        if($comp == "smi"){
         if ($type == '1'){
            $data = $this->db->query("select JUMLAH AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($date) and category = 'ACT'");
         }else{
            $data = $this->db->query("select sum(JUMLAH) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($date) and category = 'ACT' and COMPANY IN ('$comp')");
         }
        }else{
          if ($type == '2'){
            $data = $this->db->query("select JUMLAH AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($date) and category = 'ACT' and COMPANY IN ('$comp')");
          }else{
            $data = $this->db->query("select sum(JUMLAH) AS AMOUNT from MV_COSTSTRUCTURE where FISCAL_YEAR_PERIOD IN ($date) and category = 'ACT' and COMPANY IN ('$comp')");
          }   
        }
        return $data->result();
    }

     public function get_clinker($comp, $date, $cat, $plant){
         IF($comp == "smi"){
             $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND MATERIAL IN ('121_200_0010', '121_200_0040', '121_200_0020')");
         }ELSE{
             $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
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
            $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND MATERIAL IN ('121_302_0060', '121_301_0060', '121_302_0019', '121_302_0110', '121_302_0040', '121_302_0030', '121_302_0020', '121_302_0010')");
        }else{
            $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
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
            $data = $this->db->query("SELECT SUM(AMOUNT) as AMOUNT FROM (
                                       SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL
                                          FROM M_MATERIAL MM
                                            LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
                                            WHERE S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
                                            AND S.CATEGORY = '$cat'
                                            AND S.CURRENCY = 'LC'
                                            AND FISCAL_YEAR_PERIOD IN ($date)
                                            START WITH PARENTH2 IN ('200','121_000000')
                                            CONNECT BY PRIOR MM.MATERIAL = PARENTH2)");
        }else{
            $comp = explode("','", $comp);
            if(count($comp) == 1){
                $comp = "'PSV_$comp[0]','GSV_$comp[0]'";
            }else{
                $comp = "'PSV_$comp[0]','GSV_$comp[0]','PSV_$comp[1]','GSV_$comp[1]'";
            }

            $data = $this->db->query("SELECT SUM(AMOUNT) as AMOUNT FROM (
                                       SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL
                                          FROM M_MATERIAL MM
                                            LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
                                            WHERE S.GL_ACCOUNT IN ($comp)
                                            AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
                                            AND S.CATEGORY = '$cat'
                                            AND S.CURRENCY = 'LC'
                                            AND FISCAL_YEAR_PERIOD IN ($date)
                                            START WITH PARENTH2 IN ('200','121_000000')
                                            CONNECT BY PRIOR MM.MATERIAL = PARENTH2)");
        }
        
        return $data->row();
    }


}

/* End of file m_cost_report.php */
/* Location: ./application/models/m_cost_report.php */