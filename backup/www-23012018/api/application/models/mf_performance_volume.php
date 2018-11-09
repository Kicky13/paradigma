<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class mf_performance_volume extends CI_Model {
 
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function get_dt($time, $comp, $GL_ACCOUNT, $CATEGORY) {
        if ($comp == 'SI') {
            $cm = "";
        } else {
            $cm = "COMPANY  IN ($comp) AND";
        }
        $this->db->select("SUM(AMOUNT) AS TOTAL");
        $this->db->from("CONSOLIDATION");
        $where = "AUDITTRAIL = 'PL_CONS' AND
                CATEGORY = '$CATEGORY' AND
                COSTCENTER_COMPONENT = 'NO_CC' AND
                DOCUMENT_TYPE = 'NO_DOC' AND
                FLOW = 'CLOSING' AND
                GL_ACCOUNT = '$GL_ACCOUNT' AND
                $cm
		CURRENCY = 'LC' AND
                SCOPE = 'NON_GROUP' AND
                FISCAL_YEAR_PERIOD IN ($time)";
        $this->db->where($where);
        return $this->db->get()->row()->TOTAL;
    }

    //ELIMNASI -> ELIM new
    public function elim($time, $comp, $GL_ACCOUNT, $INTERCO, $COSTCENTER) {
        $temp = "";
        $bts = substr($time, -2);
        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        for ($i = 1; $i <= $bts; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bts) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$month' $tmbhn";
            $temp = $time_between;
        }
        //jadikan tahun menjadi tahan lalu
        $time_between1 = str_replace($year, $year_lalu, $temp);
        if ($COSTCENTER == "") {
            $cc = "";
        } else {
            $cc = "COSTCENTER_COMPONENT = '$COSTCENTER' AND";
        }
        if ($comp == "") {
            $compy = "";
        } else {
            $compy = "COMPANY  IN ($comp) AND";
        }
        if ($INTERCO == "") {
            $inter = "";
        } else {
            $inter = "INTERCO IN ($INTERCO) AND";
        }
        $where = "C.AUDITTRAIL = M.AUDITTRAIL AND
                M.PARENTH1 = 'ADJUSTMENT' AND 
                CATEGORY = 'ACT' AND
                $cc
                DOCUMENT_TYPE = 'NO_DOC' AND
                FLOW = 'CLOSING' AND
                GL_ACCOUNT $GL_ACCOUNT AND
                $compy
                $inter
		CURRENCY = 'IDR' AND
                SCOPE = 'S_GCEMENT' AND";
        $sql = "SELECT
            (SELECT SUM(AMOUNT) from CONSOLIDATION C, M_AUDITTRAIL M  where $where FISCAL_YEAR_PERIOD IN ('$time')) as ACT,
            (SELECT SUM(AMOUNT) from CONSOLIDATION C, M_AUDITTRAIL M  where $where FISCAL_YEAR_PERIOD IN ('$year_lalu.$month')) as ACT_LALU,
            (SELECT SUM(AMOUNT) from CONSOLIDATION C, M_AUDITTRAIL M  where $where FISCAL_YEAR_PERIOD IN ($time_between)) as ACT1,
            (SELECT SUM(AMOUNT) from CONSOLIDATION C, M_AUDITTRAIL M  where $where FISCAL_YEAR_PERIOD IN ($time_between1)) as ACT_LALU1
        FROM CONSOLIDATION where ROWNUM <= 1";
        return $sql;exit;
        $dt = $this->db->query($sql);
        return $dt->row();
    }

    public function elim_sales($time, $comp, $material_parent) {
        if ($comp == "'3000', '4000'") {
            $dc = "40";
        }else{
            $dc = "20";
        }
        $sql = "SELECT SUM(AMOUNT) AS TOTAL 
            FROM M_MATERIAL M LEFT JOIN SALES S ON
            S.MATERIAL = M.MATERIAL WHERE
            S.CATEGORY = 'ACT' AND 
            S.COMPANY IN ($comp) AND 
            S.DISTRIBUTION_CHANNEL = '$dc' AND 
            S.GL_ACCOUNT = 'REV_U_BR' AND 
            S.FISCAL_YEAR_PERIOD IN ($time)
        START WITH M.PARENTH2 = '$material_parent' 
        CONNECT BY PRIOR M.MATERIAL = M.PARENTH2";
        $dt = $this->db->query($sql);
        return $dt->row()->TOTAL;
//        return $this->db->get()->row()->TOTAL;
    }

    
  function mget_ebitda($param){
     $result = $this->db->query("select sum(tb1.total * tb1.pembilang) total from (
        SELECT SUM (AMOUNT) AS TOTAL,
               FISCAL_YEAR_PERIOD,
              CASE
                   FISCAL_YEAR_PERIOD -- diambil yang terbesar
                 WHEN '{$param['now']}' THEN 1
                  ELSE -1
               END
                          as pembilang
                  FROM CONSOLIDATION
                 WHERE     AUDITTRAIL = 'PL_CONS'
                       AND CATEGORY = 'ACT'
                       AND COSTCENTER_COMPONENT = 'NO_CC'
                       AND DOCUMENT_TYPE = 'NO_DOC'
                       AND FLOW = 'CLOSING'
                       AND GL_ACCOUNT = 'PL_E'
                       AND COMPANY IN ({$param['company']})
                       AND CURRENCY = 'LC'
                       AND SCOPE = 'NON_GROUP'
                       AND FISCAL_YEAR_PERIOD IN ('{$param['yesterday']}', '{$param['now']}')
              GROUP BY FISCAL_YEAR_PERIOD, FISCAL_YEAR_PERIOD
              ) tb1");
      return $result->row();       
     
  }

  function mget_volume($param){
   $period = array();
   $period_yes = array(); 
   $now = substr($param['now'],5);  
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".date('Y').'.'.$x."'";
    if ($x < 10){
     $formated = "'".date('Y').'.0'.$x."'";
    }
    array_push($period, $formated);    
   } 
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".(date('Y')-1).'.'.$x."'";
    if ($x < 10){
     $formated = "'".(date('Y')-1).'.0'.$x."'";
    }
    array_push($period_yes, $formated);    
   }   
   $sql = "SELECT
            (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'ACT' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN ('{$param['now']}')) as total_real,
            (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'BUD' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN ('{$param['now']}')) as total_rkap,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'ACT' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN ('{$param['yesterday']}')) as total_real_prev,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'BUD' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN ('{$param['yesterday']}')) as total_rkap_prev,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'ACT' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as total_real_upto,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'BUD' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as total_rkap_upto,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'ACT' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as total_real_prev_upto,
             (SELECT NVL(SUM(AMOUNT),0)
                                  FROM SALES
                                  WHERE CATEGORY = 'BUD' 
                                  AND GL_ACCOUNT IN ('GSV_{$param['company']}', 'PSV_{$param['company']}') 
                                  AND DISTRIBUTION_CHANNEL IN ('10','20','30','40','50') 
                                  AND FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as total_rkap_prev_upto 
        FROM CONSOLIDATION where ROWNUM <= 1";

   $result = $this->db->query($sql);
   return $result->row();       
  } 

  function mget_price($param){
   $period = array();
   $period_yes = array(); 
   $now = substr($param['now'],5);  
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".date('Y').'.'.$x."'";
    if ($x < 10){
     $formated = "'".date('Y').'.0'.$x."'";
    }
    array_push($period, $formated);    
   } 
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".(date('Y')-1).'.'.$x."'";
    if ($x < 10){
     $formated = "'".(date('Y')-1).'.0'.$x."'";
    }
    array_push($period_yes, $formated);    
   }   
   
   $sql = "SELECT
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['now']}') as total_real_bruto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['now']}') as total_rkap_bruto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as total_real_bruto_prev,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as total_rkap_bruto_prev,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as total_real_bruto_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as total_rkap_bruto_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as total_real_bruto_prev_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '411%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as total_rkap_bruto_prev_upto,
            (SELECT SUM(AMOUNT)*-1
                        FROM FINANCIAL FN, M_COSTCENTER MC, M_GL_ACCOUNT MG, M_COMPANY ME 
                        WHERE 
                         FN.COSTCENTER = MC.COST_CENTER 
                         AND FN.GL_ACCOUNT = MG.GL_ACCOUNT 
                         AND FN.COMPANY = ME.COMPANY 
                         AND MC.PARENTH2 = 'H2_SLS_DIST_VOSMIG' 
                         AND MG.FS_STRUCTURE = 'CEG11' 
                         AND FN.AUDITTRAIL = 'SAP_ECC' 
                         AND FN.FISCAL_YEAR_PERIOD IN ('2016.05') 
                         AND ME.COMPANY IN ('{$param['company']}')) as total_angkut
            
        FROM CONSOLIDATION where ROWNUM <= 1";
   $result = $this->db->query($sql);
   return $result->row();       
  }

  function mget_cost($param){
   $period = array();
   $period_yes = array(); 
   $now = substr($param['now'],5);  
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".date('Y').'.'.$x."'";
    if ($x < 10){
     $formated = "'".date('Y').'.0'.$x."'";
    }
    array_push($period, $formated);    
   } 
   for ($x=1;$x<=intval($now);$x++){
    $formated = "'".(date('Y')-1).'.'.$x."'";
    if ($x < 10){
     $formated = "'".(date('Y')-1).'.0'.$x."'";
    }
    array_push($period_yes, $formated);    
   }
   $sql = "SELECT
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['now']}') as pokok_real,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['now']}') as umum_real,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                    FISCAL_YEAR_PERIOD = '{$param['now']}') as pokok_rkap,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['now']}') as umum_rkap,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as pokok_real_prev,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as umum_real_prev,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as pokok_rkap_prev,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD = '{$param['yesterday']}') as umum_rkap_prev, 
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as pokok_real_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as umum_real_upto, 
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as pokok_rkap_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period,",").")) as umum_rkap_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as pokok_real_prev_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'ACT' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as umum_real_prev_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5', 'CC4', 'CC3', 'CC2', 'CC1', 'NO_CC') AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '5%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as pokok_rkap_prev_upto,
            (SELECT SUM(AMOUNT)*-1
                           FROM CONSOLIDATION 
                           WHERE
                               AUDITTRAIL = 'INPUT' AND
                               CATEGORY = 'BUD' AND
                               COSTCENTER_COMPONENT IN ('CC5') AND
                               DOCUMENT_TYPE != 'NO_DOC' AND
                               FLOW = 'CLOSING' AND
                               GL_ACCOUNT LIKE '6%' AND
                               COMPANY IN ('{$param['company']}') AND
                               CURRENCY = 'LC' AND
                               SCOPE = 'NON_GROUP' AND 
                               FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").")) as umum_rkap_prev_upto  
        FROM CONSOLIDATION where ROWNUM <= 1";
   $result = $this->db->query($sql);
   return $result->row();       
  }    

}

