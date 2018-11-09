<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Msales extends CI_Model {
    private $_myTable = "ZREPORT_RPTREAL_RESUM";
    private $db ;     
    function get_data($param){
        $this->db=$this->load->database('default5',true);
        $result = $this->db->query("SELECT com,tahun,bulan,
                SUM (target_rkap) TRKAP,
                SUM (realto)    TREALTO,
                SUM (revenu_real) REVREAL,
                SUM (revenu_rkap) REVRKAP,
                SUM (price_real) PRREAL,
                SUM (price_rkap) PRRKAP
           FROM zreport_rptreal_resum
          WHERe com = '{$param['com']}' AND tahun = '{$param['year']}'  and tipe != '121-200'
       GROUP BY com,tahun,bulan
       order by bulan");
      return $result->result();
    }

    function get_last_update(){
        $this->db=$this->load->database('default5',true);

        $sql ="SELECT
                  TO_CHAR (
                    MAX (LAST_UPDATE),
                    'DD/MM/YYYY HH:Mi:ss'
                  ) AS LAST_UPDATE
                FROM
                  ZREPORT_RPTREAL_RESUM
                 ";
          $result = $this->db->query($sql);
      
      return $result->row();
    }
    

    function get_data_new($param){
        $this->db=$this->load->database('default5',true);
        $result = $this->db->query("SELECT TB_DATA.COM, TB_DATA.TAHUN,
                                          TB_DATA.BULAN,
                                          TB_DATA.trkap,
                                          VOL_BULANAN.trealto,
                                          TB_DATA.revreal,
                                          TB_DATA.revrkap,
                                          TB_DATA.prreal,
                                          TB_DATA.prrkap
                                    FROM(SELECT SALES_BULANAN.COM, SALES_BULANAN.TAHUN,
                                          SALES_BULANAN.BULAN,
                                          SALES_BULANAN.trkap,
                                          SALES_BULANAN.trealto,
                                          REV_BULANAN.revreal,
                                          SALES_BULANAN.revrkap,
                                          SALES_BULANAN.prreal,
                                          SALES_BULANAN.prrkap
                                    FROM(
                                          SELECT COM, 
                                          tahun,
                                          bulan,
                                          SUM (target_rkap) trkap,
                                          SUM (realto)    trealto,
                                          SUM (revenu_real) revreal,
                                          SUM (revenu_rkap) revrkap,
                                          SUM (price_real) prreal,
                                          SUM (price_rkap) prrkap
                                          FROM zreport_rptreal_resum
                                          WHERE   tahun = '{$param['year']}' and com in '{$param['com']}' and tipe != '121-200' 
                                          GROUP BY  tahun, bulan, com
                                          ORDER BY bulan
                                          )SALES_BULANAN 
                                    LEFT JOIN (
                                    SELECT COM, TAHUN,
                                          BULAN,
                                          SUM(REV_REAL) AS revreal
                                    FROM(
                                          SELECT VKORG AS COM, TO_CHAR (budat, 'yyyy') AS TAHUN,
                                          TO_CHAR (budat, 'mm') AS BULAN,
                                          SUM(REVENUE) AS REV_REAL 
                                          FROM MV_REVENUE 
                                          WHERE TO_CHAR (budat, 'yyyy') = '{$param['year']}' and VKORG in '{$param['com']}' GROUP BY BUDAT,VKORG ORDER BY BUDAT ASC
                                          ) GROUP BY COM, TAHUN, BULAN ORDER BY BULAN ASC
                                          )REV_BULANAN
                                    ON SALES_BULANAN.TAHUN = REV_BULANAN.TAHUN 
                                    AND SALES_BULANAN.BULAN = REV_BULANAN.BULAN
																		AND SALES_BULANAN.COM = REV_BULANAN.COM)TB_DATA
                                    LEFT JOIN (
                                          SELECT COM, TAHUN,
                                          BULAN,
                                          SUM(VOL_REAL) AS trealto
                                    FROM(
                                          SELECT VKORG AS COM, TO_CHAR (budat, 'yyyy') AS TAHUN,
                                          TO_CHAR (budat, 'mm') AS BULAN,
                                          SUM(TOTAL_QTY) AS VOL_REAL 
                                          FROM MV_REVENUE 
                                          WHERE TO_CHAR (budat, 'yyyy') = '{$param['year']}' and VKORG in '{$param['com']}' 
																					GROUP BY BUDAT,VKORG ORDER BY BUDAT ASC
                                          ) GROUP BY COM, TAHUN, BULAN ORDER BY BULAN ASC
                                    )VOL_BULANAN 
                                    ON TB_DATA.TAHUN = VOL_BULANAN.TAHUN 
                                    AND TB_DATA.BULAN = VOL_BULANAN.BULAN
																		AND TB_DATA.COM = VOL_BULANAN.COM
");
      return $result->result();
    }

    function mget_smig($param){
        $this->db = $this->load->database('default5',true);
        $result = $this->db->query("SELECT 
                            tahun,
                            bulan,
                            SUM (target_rkap) trkap,
                            SUM (realto)    trealto,
                            SUM (revenu_real) revreal,
                            SUM (revenu_rkap) revrkap,
                            SUM (price_real) prreal,
                            SUM (price_rkap) prrkap
                       FROM zreport_rptreal_resum
                      WHERE   tahun = '{$param['year']}' and com in ('7000','3000','4000','6000','5000') and tipe != '121-200' 
                   GROUP BY  tahun, bulan
                   ORDER BY bulan");
    
        return $result->result();
    }

    function mget_smig_bulanan($param){
        $this->db = $this->load->database('default5',true);
        $result = $this->db->query("SELECT TB_DATA.TAHUN,
                                          TB_DATA.BULAN,
                                          TB_DATA.trkap,
                                          VOL_BULANAN.trealto,
                                          TB_DATA.revreal,
                                          TB_DATA.revrkap,
                                          TB_DATA.prreal,
                                          TB_DATA.prrkap
                                    FROM(SELECT SALES_BULANAN.TAHUN,
                                          SALES_BULANAN.BULAN,
                                          SALES_BULANAN.trkap,
                                          SALES_BULANAN.trealto,
                                          REV_BULANAN.revreal,
                                          SALES_BULANAN.revrkap,
                                          SALES_BULANAN.prreal,
                                          SALES_BULANAN.prrkap
                                    FROM(
                                          SELECT 
                                          tahun,
                                          bulan,
                                          SUM (target_rkap) trkap,
                                          SUM (realto)    trealto,
                                          SUM (revenu_real) revreal,
                                          SUM (revenu_rkap) revrkap,
                                          SUM (price_real) prreal,
                                          SUM (price_rkap) prrkap
                                          FROM zreport_rptreal_resum
                                          WHERE   tahun = '{$param['year']}' and com in ('7000','3000','4000','6000', '5000') and tipe != '121-200' 
                                          GROUP BY  tahun, bulan
                                          ORDER BY bulan
                                          )SALES_BULANAN 
                                    LEFT JOIN (
                                    SELECT TAHUN,
                                          BULAN,
                                          SUM(REV_REAL) AS revreal
                                    FROM(
                                          SELECT TO_CHAR (budat, 'yyyy') AS TAHUN,
                                          TO_CHAR (budat, 'mm') AS BULAN,
                                          SUM(REVENUE) AS REV_REAL 
                                          FROM MV_REVENUE 
                                          WHERE TO_CHAR (budat, 'yyyy') = '{$param['year']}' GROUP BY BUDAT ORDER BY BUDAT ASC
                                          ) GROUP BY TAHUN, BULAN ORDER BY BULAN ASC
                                          )REV_BULANAN
                                    ON SALES_BULANAN.TAHUN = REV_BULANAN.TAHUN 
                                    AND SALES_BULANAN.BULAN = REV_BULANAN.BULAN)TB_DATA
                                    LEFT JOIN (
                                          SELECT TAHUN,
                                          BULAN,
                                          SUM(VOL_REAL) AS trealto
                                    FROM(
                                          SELECT TO_CHAR (budat, 'yyyy') AS TAHUN,
                                          TO_CHAR (budat, 'mm') AS BULAN,
                                          SUM(TOTAL_QTY) AS VOL_REAL 
                                          FROM MV_REVENUE 
                                          WHERE TO_CHAR (budat, 'yyyy') = '{$param['year']}' GROUP BY BUDAT ORDER BY BUDAT ASC
                                          ) GROUP BY TAHUN, BULAN ORDER BY BULAN ASC
                                    )VOL_BULANAN 
                                    ON TB_DATA.TAHUN = VOL_BULANAN.TAHUN 
                                    AND TB_DATA.BULAN = VOL_BULANAN.BULAN");
    
        return $result->result();
    }    
    
}