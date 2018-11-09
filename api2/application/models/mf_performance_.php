<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class mf_performance extends CI_Model {
 
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

    
  function mget_ebitda_selected($param){
     $result = $this->db->query("select sum(tb1.total * tb1.pembilang) total,tb1.CATEGORY,tb1.tahun    from (
        SELECT SUM (AMOUNT) AS TOTAL,
               FISCAL_YEAR_PERIOD,
              CASE
                   FISCAL_YEAR_PERIOD -- diambil yang terbesar
                 WHEN '{$param['now']}' THEN 1
                  ELSE -1
               END
                          as pembilang,CATEGORY,substr(FISCAL_YEAR_PERIOD,0,4) tahun
                  FROM CONSOLIDATION
                 WHERE     AUDITTRAIL = 'PL_CONS'
                       AND CATEGORY in( 'ACT','BUD')
                       AND COSTCENTER_COMPONENT = 'NO_CC'
                       AND DOCUMENT_TYPE = 'NO_DOC'
                       AND FLOW = 'CLOSING'
                       AND GL_ACCOUNT = 'PL_E'
                       AND COMPANY IN ('{$param['company']}')
                       AND CURRENCY = 'LC'
                       AND SCOPE = 'NON_GROUP'
                       AND FISCAL_YEAR_PERIOD IN ('{$param['yesterday']}', '{$param['now']}')
              GROUP BY FISCAL_YEAR_PERIOD, FISCAL_YEAR_PERIOD,CATEGORY,FISCAL_YEAR_PERIOD
              ) tb1
			  
			  group by CATEGORY,tahun
			  ");
      return $result->result();       
     
  }
  
 function mget_ebitda_upto($param){
     $result = $this->db->query(""
             . "  SELECT sum(amount) total,FISCAL_YEAR_PERIOD,CATEGORY
                FROM CONSOLIDATION
               WHERE     AUDITTRAIL = 'PL_CONS'
                     AND CATEGORY in ('ACT','BUD')
                     AND COSTCENTER_COMPONENT = 'NO_CC'
                     AND DOCUMENT_TYPE = 'NO_DOC'
                     AND FLOW = 'CLOSING'
                     AND GL_ACCOUNT = 'PL_E'
                     AND COMPANY IN ('{$param['company']}')
                     AND INTERCO = 'I_NONE'
                     AND CURRENCY = 'LC'
                     AND SCOPE = 'NON_GROUP'
                     AND POSTING_DATE IS NULL
                     AND FISCAL_YEAR_PERIOD = '{$param['now']}'
                         group by FISCAL_YEAR_PERIOD,CATEGORY");
     return $result->result();
 }
  
  function mget_ebitda($param){
   $paramCompany = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "";
   }else{
       $paramCompany = "AND COMPANY = '{$param['company']}'";
   }   
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
            NVL(EBIT_T.TOTAL,0) ebit_target, NVL(EBIT_A.TOTAL,0) ebit_actual, NVL(EBIT_ALY.TOTAL,0) ebit_actual_lyear,
            NVL(EBIT_TUP.TOTAL,0) ebit_target_up, NVL(EBIT_AUP.TOTAL,0) ebit_actual_up, NVL(EBIT_AUPLY.TOTAL,0) ebit_actual_lyear_up
           FROM
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'BUD'
               AND FISCAL_YEAR_PERIOD in ('{$param['now']}')
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_t,
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'ACT'
               AND FISCAL_YEAR_PERIOD in ('{$param['now']}')
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_a,
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'ACT'
               AND FISCAL_YEAR_PERIOD in ('{$param['last_year']}')
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_aly,
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'BUD'
               AND FISCAL_YEAR_PERIOD in (".implode($period,",").")
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_tup,
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'ACT'
               AND FISCAL_YEAR_PERIOD in (".implode($period,",").")
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_aup,
             (
               SELECT
                 SUM (amount) total
               FROM
                 CONSOLIDATION
               WHERE
                 CATEGORY = 'ACT'
               AND FISCAL_YEAR_PERIOD in (".implode($period_yes,",").")
               AND GL_ACCOUNT = 'PL_E'
               AND CURRENCY = 'LC'
               {$paramCompany}
             ) ebit_auply";
   $result = $this->db->query($sql);
   return $result->row();       
  }

  function mget_volume($param){
   $paramCompany = "";
   $paramacc = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
       $paramacc = "S.GL_ACCOUNT in ('GSV_7000','PSV_7000','GSV_6000','PSV_6000','GSV_4000','PSV_4000','GSV_3000','PSV_3000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
       $paramacc = "S.GL_ACCOUNT in ('GSV_{$param['company']}','PSV_{$param['company']}')";
   }    
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
            NVL(VOL_T.TOTAL,0) vol_target, NVL(VOL_A.TOTAL,0) vol_actual, NVL(VOL_ALY.TOTAL,0) vol_actual_lyear,
            NVL(VOL_TUP.TOTAL,0) vol_target_up, NVL(VOL_AUP.TOTAL,0) vol_actual_up, NVL(VOL_ALYUP.TOTAL,0) vol_actual_lyear_up
           FROM
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'BUD'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN ('{$param['now']}') START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_t,
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'ACT'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN ('{$param['now']}') START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_a,
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'ACT'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN ('{$param['last_year']}') START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_aly,
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'BUD'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN (".implode($period,",").") START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_tup,
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'ACT'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN (".implode($period,",").") START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_aup,
             (
               SELECT
                 SUM (AMOUNT) total
               FROM
                 M_MATERIAL MM
               LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
               WHERE
                {$paramacc}
               AND S.DISTRIBUTION_CHANNEL IN ('10', '20', '30', '40', '50')
               AND S. CATEGORY = 'ACT'
               AND S.CURRENCY = 'LC'
               AND S.FISCAL_YEAR_PERIOD IN (".implode($period_yes,",").") START WITH PARENTH2 IN ('200', '121_000000') CONNECT BY PRIOR MM.MATERIAL = PARENTH2
             ) vol_alyup";
   $result = $this->db->query($sql);
   return $result->row();       
  } 

  function mget_bruto($param){
   $paramCompany = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
   } 
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
   $sql = "select 
            NVL(BT.BRUTO,0) bruto_target, NVL(BA.BRUTO,0) bruto_actual, NVL(BALY.BRUTO,0) bruto_actual_lyear,
            NVL(BTUP.BRUTO,0) bruto_target_up, NVL(BAUP.BRUTO,0) bruto_actual_up, NVL(BALYUP.BRUTO,0) bruto_actual_lyear_up
           from 
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bt,
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) ba,
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['last_year']}' AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) baly,
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) btup,
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) baup,
            (select sum(AMOUNT) as bruto 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period_yes,",").") AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) balyup";
   $result = $this->db->query($sql);
   return $result->row();       
  }

  function mget_cost($param){
   $paramCompany = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY is not null";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
   } 
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
   $sql = "select 
            NVL(BU_T.BEBAN+BP_T.BEBAN,0) cost_target, NVL(BU_A.BEBAN+BP_A.BEBAN,0) cost_actual, NVL(BU_ALY.BEBAN+BP_ALY.BEBAN,0) cost_actual_lyear,
            NVL(BU_TUP.BEBAN+BP_TUP.BEBAN,0) cost_target_up, NVL(BU_AUP.BEBAN+BP_AUP.BEBAN,0) cost_actual_up, NVL(BU_ALYUP.BEBAN+BP_ALYUP.BEBAN,0) cost_actual_lyear_up
           from 
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_t,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_t,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_a,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_a,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['last_year']}' AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_aly,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['last_year']}' AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_aly,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_tup,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_tup,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_aup,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_aup,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period_yes,",").") AND
             GL_ACCOUNT = 'PL_BUA' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bu_alyup,
            (select sum(AMOUNT) as beban 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period_yes,",").") AND
             GL_ACCOUNT = 'PL_BPE' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) bp_alyup";
   $result = $this->db->query($sql);
   return $result->row();       
  }   

  function mget_revenue($param){
   $paramCompany = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
   }   
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
   $sql = "select 
            NVL(LBT.LABA,0) laba_bruto_target, NVL(LBA.LABA,0) laba_bruto_actual,
            NVL(LBTUP.LABA,0) laba_bruto_target_up, NVL(LBAUP.LABA,0) laba_bruto_actual_up,
            NVL(LNT.LABA,0) laba_netto_target, NVL(LNA.LABA,0) laba_netto_actual,
            NVL(LNTUP.LABA,0) laba_netto_target_up, NVL(LNAUP.LABA,0) laba_netto_actual_up
           from 
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lbt,
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lba,
            (select sum(AMOUNT) as laba
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lbtup,
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPB' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lbaup,
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPN' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lnt,
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD = '{$param['now']}' AND
             GL_ACCOUNT = 'PL_HPN' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lna,
            (select sum(AMOUNT) as laba
             from CONSOLIDATION 
             where CATEGORY = 'BUD' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPN' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lntup,
            (select sum(AMOUNT) as laba 
             from CONSOLIDATION 
             where CATEGORY = 'ACT' AND
             FISCAL_YEAR_PERIOD in (".implode($period,",").") AND
             GL_ACCOUNT = 'PL_HPN' AND 
             CURRENCY = 'LC' AND 
             {$paramCompany}) lnaup";
   $result = $this->db->query($sql);
   return $result->row();       
  }

  function mget_trend($param){
   $paramCompany = "";
   $paramAcc = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
       $paramAcc = "GL_ACCOUNT in ('GSV_7000','PSV_7000','GSV_6000','PSV_6000','GSV_4000','PSV_4000','GSV_3000','PSV_3000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
       $paramAcc = "GL_ACCOUNT in ('GSV_{$param['company']}','PSV_{$param['company']}')";
   }   
   $sql = "select 
            NVL(SA.PERIODE,0) periode, NVL(SA.PENJUALAN,0) sales, NVL(EB.LABA,0) ebitda, NVL(BR.LABA,0) bruto, NVL(NE.LABA,0) netto
           from 
            (select sum(amount) as penjualan, FISCAL_YEAR_PERIOD as periode from sales
            where company = '7000' and 
            GL_ACCOUNT in ('GSV_7000','PSV_7000') AND
            category = 'ACT' AND
            DISTRIBUTION_CHANNEL in ('10','20','30','40','50') and
            CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '2016'
            group by FISCAL_YEAR_PERIOD
            order by FISCAL_YEAR_PERIOD asc) sa LEFT JOIN
            (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                       from CONSOLIDATION 
                       where        
                       CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '2016' AND 
                       GL_ACCOUNT = 'PL_E' AND 
                       CURRENCY = 'LC' AND 
                       COMPANY in ('7000')
                       group by FISCAL_YEAR_PERIOD
                       order by FISCAL_YEAR_PERIOD asc) eb ON sa.PERIODE = EB.PERIODE LEFT JOIN 
            (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                       from CONSOLIDATION 
                       where        
                       CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '2016' AND 
                       GL_ACCOUNT = 'PL_HPB' AND 
                       CURRENCY = 'LC' AND 
                       COMPANY in ('7000')
                       group by FISCAL_YEAR_PERIOD
                       order by FISCAL_YEAR_PERIOD asc) br ON EB.PERIODE = BR.PERIODE LEFT JOIN
            (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                       from CONSOLIDATION 
                       where        
                       CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '2016' AND 
                       GL_ACCOUNT = 'PL_HPN' AND 
                       CURRENCY = 'LC' AND 
                       COMPANY in ('7000')
                       group by FISCAL_YEAR_PERIOD
                       order by FISCAL_YEAR_PERIOD asc) ne ON EB.PERIODE = NE.PERIODE";
   $result = $this->db->query($sql);
   return $result->result();      
  }

  function mget_trend_volume($param){
   $paramCompany = "";
   $paramAcc = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
       $paramAcc = "GL_ACCOUNT in ('GSV_7000','PSV_7000','GSV_6000','PSV_6000','GSV_4000','PSV_4000','GSV_3000','PSV_3000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
       $paramAcc = "GL_ACCOUNT in ('GSV_{$param['company']}','PSV_{$param['company']}')";
   }   
   $sql = "select FISCAL_YEAR_PERIOD periode, sum(amount) penjualan from sales
           where 
           {$paramCompany} and 
           {$paramAcc} AND
           CATEGORY = 'ACT' AND
           DISTRIBUTION_CHANNEL in ('10','20','30','40','50') and
           CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '".date('Y')."'
           group by FISCAL_YEAR_PERIOD
           order by FISCAL_YEAR_PERIOD asc";
   $result = $this->db->query($sql);
   return $result->result();      
  }

  function mget_trend_labarugi($param){
   $paramCompany = "";
   if($param['company'] == 'ALL'){
       $paramCompany = "COMPANY in ('7000','6000','3000','4000')";
   }else{
       $paramCompany = "COMPANY = '{$param['company']}'";
   }   
   $sql = "select 
            NVL(EB.PERIODE,0) periode, NVL(EB.LABA,0) ebitda, NVL(BR.LABA,0) bruto, NVL(NE.LABA,0) netto
           from 
           (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                      from CONSOLIDATION 
                      where        
                      CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '".date('Y')."' AND
                      CATEGORY = 'ACT' AND 
                      GL_ACCOUNT = 'PL_E' AND 
                      CURRENCY = 'LC' AND 
                      {$paramCompany}
                      group by FISCAL_YEAR_PERIOD
                      order by FISCAL_YEAR_PERIOD asc) eb LEFT JOIN 
           (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                      from CONSOLIDATION 
                      where        
                      CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '".date('Y')."' AND 
                      CATEGORY = 'ACT' AND
                      GL_ACCOUNT = 'PL_HPB' AND 
                      CURRENCY = 'LC' AND 
                      {$paramCompany}
                      group by FISCAL_YEAR_PERIOD
                      order by FISCAL_YEAR_PERIOD asc) br ON EB.PERIODE = BR.PERIODE LEFT JOIN
           (select SUM(AMOUNT) as laba, FISCAL_YEAR_PERIOD as periode
                      from CONSOLIDATION 
                      where        
                      CAST(FISCAL_YEAR_PERIOD AS varchar(4)) = '".date('Y')."' AND 
                      CATEGORY = 'ACT' AND
                      GL_ACCOUNT = 'PL_HPN' AND 
                      CURRENCY = 'LC' AND 
                      {$paramCompany}
                      group by FISCAL_YEAR_PERIOD
                      order by FISCAL_YEAR_PERIOD asc) ne ON EB.PERIODE = NE.PERIODE";
   $result = $this->db->query($sql);
   return $result->result();      
  }

  function mgetperformance_5()
 {    
  $param_act='2016.01,2016.02,2016.03';
  $param_act_b='2015.12,2016.01,2016.02';
  $param_act_banding='2015.01,2015.02,2015.03';
  $param_act_banding_b='2014.12,2015.01,2015.02';
  $company='7000';
  
   $result = $this->db->query("SELECT
  O.KEY_ID,
  O.KODE,
  O.FISCAL_YEAR_PERIOD,
  O.ACT,
  P .ACT AS ACTYEARBEFORE
FROM
  (
    SELECT
      *
    FROM
      (
        SELECT
          X.KEY_ID,
          X.KODE,
          X.FISCAL_YEAR_PERIOD,
          TOTAL5 - COALESCE (
            CASE
            WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
              0
            ELSE
              Y.TOTALBEFORE
            END,
            0
          ) AS ACT
        FROM
          (
            SELECT
              ROWNUM AS KEY_ID,
              A .*
            FROM
              (
                SELECT
                  'EBITDA' kode,
                  FISCAL_YEAR_PERIOD,
                  TO_CHAR (
                    (
                      ADD_MONTHS (
                        TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                        - 1
                      )
                    ),
                    'YYYY.MM'
                  ) pengurang,
                  SUM (AMOUNT) AS total5
                FROM
                  CONSOLIDATION
                WHERE
                  GL_ACCOUNT = 'PL_E'
                AND COMPANY ={$company}
                AND FISCAL_YEAR_PERIOD IN ({$param_act})
                AND CATEGORY = 'ACT'
                GROUP BY
                  FISCAL_YEAR_PERIOD
                ORDER BY
                  FISCAL_YEAR_PERIOD
              ) A
          ) X
        LEFT JOIN (
          SELECT
            ROWNUM AS KEY_ID,
            B.*
          FROM
            (
              SELECT
                'PL_E' kode,
                FISCAL_YEAR_PERIOD,
                SUM (AMOUNT) AS totalBEFORE
              FROM
                CONSOLIDATION
              WHERE
                GL_ACCOUNT = 'PL_E'
              AND COMPANY ={$company}
              AND FISCAL_YEAR_PERIOD IN ({$param_act_b})
              AND CATEGORY = 'ACT'
              GROUP BY
                FISCAL_YEAR_PERIOD
              ORDER BY
                FISCAL_YEAR_PERIOD
            ) B
        ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
        ORDER BY
          X.KEY_ID
      ) P
    UNION ALL
      SELECT
        *
      FROM
        (
          SELECT
            X.KEY_ID,
            X.KODE,
            X.FISCAL_YEAR_PERIOD,
            TOTAL5 - COALESCE (
              CASE
              WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                0
              ELSE
                Y.TOTALBEFORE
              END,
              0
            ) AS ACT
          FROM
            (
              SELECT
                ROWNUM AS KEY_ID,
                A .*
              FROM
                (
                  SELECT
                    'HASIL_PENJUALAN' kode,
                    FISCAL_YEAR_PERIOD,
                    TO_CHAR (
                      (
                        ADD_MONTHS (
                          TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                          - 1
                        )
                      ),
                      'YYYY.MM'
                    ) pengurang,
                    SUM (AMOUNT) AS total5
                  FROM
                    CONSOLIDATION
                  WHERE
                    GL_ACCOUNT = 'PL_HPN'
                  AND COMPANY ={$company}
                  AND FISCAL_YEAR_PERIOD IN ({$param_act})
                  AND CATEGORY = 'ACT'
                  GROUP BY
                    FISCAL_YEAR_PERIOD
                  ORDER BY
                    FISCAL_YEAR_PERIOD
                ) A
            ) X
          LEFT JOIN (
            SELECT
              ROWNUM AS KEY_ID,
              B.*
            FROM
              (
                SELECT
                  'PL_HPN' kode,
                  FISCAL_YEAR_PERIOD,
                  SUM (AMOUNT) AS totalBEFORE
                FROM
                  CONSOLIDATION
                WHERE
                  GL_ACCOUNT = 'PL_HPN'
                AND COMPANY ={$company}
                AND FISCAL_YEAR_PERIOD IN ({$param_act_b})
                AND CATEGORY = 'ACT'
                GROUP BY
                  FISCAL_YEAR_PERIOD
                ORDER BY
                  FISCAL_YEAR_PERIOD
              ) B
          ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
          ORDER BY
            X.KEY_ID
        ) X
      UNION ALL
        SELECT
          *
        FROM
          (
            SELECT
              X.KEY_ID,
              X.KODE,
              X.FISCAL_YEAR_PERIOD,
              TOTAL5 - COALESCE (
                CASE
                WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                  0
                ELSE
                  Y.TOTALBEFORE
                END,
                0
              ) AS ACT
            FROM
              (
                SELECT
                  ROWNUM AS KEY_ID,
                  A .*
                FROM
                  (
                    SELECT
                      'LABA_KOTOR' kode,
                      FISCAL_YEAR_PERIOD,
                      TO_CHAR (
                        (
                          ADD_MONTHS (
                            TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                            - 1
                          )
                        ),
                        'YYYY.MM'
                      ) pengurang,
                      SUM (AMOUNT) AS total5
                    FROM
                      CONSOLIDATION
                    WHERE
                      GL_ACCOUNT = 'PL_LK'
                    AND COMPANY ={$company}
                    AND FISCAL_YEAR_PERIOD IN ({$param_act})
                    AND CATEGORY = 'ACT'
                    GROUP BY
                      FISCAL_YEAR_PERIOD
                    ORDER BY
                      FISCAL_YEAR_PERIOD
                  ) A
              ) X
            LEFT JOIN (
              SELECT
                ROWNUM AS KEY_ID,
                B.*
              FROM
                (
                  SELECT
                    'PL_LK' kode,
                    FISCAL_YEAR_PERIOD,
                    SUM (AMOUNT) AS totalBEFORE
                  FROM
                    CONSOLIDATION
                  WHERE
                    GL_ACCOUNT = 'PL_LK'
                  AND COMPANY ={$company}
                  AND FISCAL_YEAR_PERIOD IN ({$param_act_b})
                  AND CATEGORY = 'ACT'
                  GROUP BY
                    FISCAL_YEAR_PERIOD
                  ORDER BY
                    FISCAL_YEAR_PERIOD
                ) B
            ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
            ORDER BY
              X.KEY_ID
          ) Y
        UNION ALL
          SELECT
            *
          FROM
            (
              SELECT
                X.KEY_ID,
                X.KODE,
                X.FISCAL_YEAR_PERIOD,
                TOTAL5 - COALESCE (
                  CASE
                  WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                    0
                  ELSE
                    Y.TOTALBEFORE
                  END,
                  0
                ) AS ACT
              FROM
                (
                  SELECT
                    ROWNUM AS KEY_ID,
                    A .*
                  FROM
                    (
                      SELECT
                        'EBT' kode,
                        FISCAL_YEAR_PERIOD,
                        TO_CHAR (
                          (
                            ADD_MONTHS (
                              TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                              - 1
                            )
                          ),
                          'YYYY.MM'
                        ) pengurang,
                        SUM (AMOUNT) AS total5
                      FROM
                        CONSOLIDATION
                      WHERE
                        GL_ACCOUNT = 'PL_LU'
                      AND COMPANY ={$company}
                      AND FISCAL_YEAR_PERIOD IN ({$param_act})
                      AND CATEGORY = 'ACT'
                      GROUP BY
                        FISCAL_YEAR_PERIOD
                      ORDER BY
                        FISCAL_YEAR_PERIOD
                    ) A
                ) X
              LEFT JOIN (
                SELECT
                  ROWNUM AS KEY_ID,
                  B.*
                FROM
                  (
                    SELECT
                      'PL_LU' kode,
                      FISCAL_YEAR_PERIOD,
                      SUM (AMOUNT) AS totalBEFORE
                    FROM
                      CONSOLIDATION
                    WHERE
                      GL_ACCOUNT = 'PL_LU'
                    AND COMPANY ={$company}
                    AND FISCAL_YEAR_PERIOD IN ({$param_act_b})
                    AND CATEGORY = 'ACT'
                    GROUP BY
                      FISCAL_YEAR_PERIOD
                    ORDER BY
                      FISCAL_YEAR_PERIOD
                  ) B
              ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
              ORDER BY
                X.KEY_ID
            ) Z
          UNION ALL
            SELECT
              *
            FROM
              (
                SELECT
                  X.KEY_ID,
                  X.KODE,
                  X.FISCAL_YEAR_PERIOD,
                  TOTAL5 - COALESCE (
                    CASE
                    WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                      0
                    ELSE
                      Y.TOTALBEFORE
                    END,
                    0
                  ) AS ACT
                FROM
                  (
                    SELECT
                      ROWNUM AS KEY_ID,
                      A .*
                    FROM
                      (
                        SELECT
                          'EAT' kode,
                          FISCAL_YEAR_PERIOD,
                          TO_CHAR (
                            (
                              ADD_MONTHS (
                                TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                                - 1
                              )
                            ),
                            'YYYY.MM'
                          ) pengurang,
                          SUM (AMOUNT) AS total5
                        FROM
                          CONSOLIDATION
                        WHERE
                          GL_ACCOUNT = 'PL_LU'
                        AND COMPANY ={$company}
                        AND FISCAL_YEAR_PERIOD IN ({$param_act})
                        AND CATEGORY = 'ACT'
                        GROUP BY
                          FISCAL_YEAR_PERIOD
                        ORDER BY
                          FISCAL_YEAR_PERIOD
                      ) A
                  ) X
                LEFT JOIN (
                  SELECT
                    ROWNUM AS KEY_ID,
                    B.*
                  FROM
                    (
                      SELECT
                        'PL_LU' kode,
                        FISCAL_YEAR_PERIOD,
                        SUM (AMOUNT) AS totalBEFORE
                      FROM
                        CONSOLIDATION
                      WHERE
                        GL_ACCOUNT = 'PL_LU'
                      AND COMPANY ={$company}
                      AND FISCAL_YEAR_PERIOD IN ({$param_act_b})
                      AND CATEGORY = 'ACT'
                      GROUP BY
                        FISCAL_YEAR_PERIOD
                      ORDER BY
                        FISCAL_YEAR_PERIOD
                    ) B
                ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
                ORDER BY
                  X.KEY_ID
              ) Q
  ) O
INNER JOIN (
  SELECT
    *
  FROM
    (
      SELECT
        X.KEY_ID,
        X.KODE,
        X.FISCAL_YEAR_PERIOD,
        TOTAL5 - COALESCE (
          CASE
          WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
            0
          ELSE
            Y.TOTALBEFORE
          END,
          0
        ) AS ACT
      FROM
        (
          SELECT
            ROWNUM AS KEY_ID,
            A .*
          FROM
            (
              SELECT
                'EBITDA' kode,
                FISCAL_YEAR_PERIOD,
                TO_CHAR (
                  (
                    ADD_MONTHS (
                      TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                      - 1
                    )
                  ),
                  'YYYY.MM'
                ) pengurang,
                SUM (AMOUNT) AS total5
              FROM
                CONSOLIDATION
              WHERE
                GL_ACCOUNT = 'PL_E'
              AND COMPANY ={$company}
              AND FISCAL_YEAR_PERIOD IN ({$param_act_banding})
              AND CATEGORY = 'ACT'
              GROUP BY
                FISCAL_YEAR_PERIOD
              ORDER BY
                FISCAL_YEAR_PERIOD
            ) A
        ) X
      LEFT JOIN (
        SELECT
          ROWNUM AS KEY_ID,
          B.*
        FROM
          (
            SELECT
              'PL_E' kode,
              FISCAL_YEAR_PERIOD,
              SUM (AMOUNT) AS totalBEFORE
            FROM
              CONSOLIDATION
            WHERE
              GL_ACCOUNT = 'PL_E'
            AND COMPANY ={$company}
            AND FISCAL_YEAR_PERIOD IN ({$param_act_banding_b})
            AND CATEGORY = 'ACT'
            GROUP BY
              FISCAL_YEAR_PERIOD
            ORDER BY
              FISCAL_YEAR_PERIOD
          ) B
      ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
      ORDER BY
        X.KEY_ID
    ) P
  UNION ALL
    SELECT
      *
    FROM
      (
        SELECT
          X.KEY_ID,
          X.KODE,
          X.FISCAL_YEAR_PERIOD,
          TOTAL5 - COALESCE (
            CASE
            WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
              0
            ELSE
              Y.TOTALBEFORE
            END,
            0
          ) AS ACT
        FROM
          (
            SELECT
              ROWNUM AS KEY_ID,
              A .*
            FROM
              (
                SELECT
                  'HASIL_PENJUALAN' kode,
                  FISCAL_YEAR_PERIOD,
                  TO_CHAR (
                    (
                      ADD_MONTHS (
                        TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                        - 1
                      )
                    ),
                    'YYYY.MM'
                  ) pengurang,
                  SUM (AMOUNT) AS total5
                FROM
                  CONSOLIDATION
                WHERE
                  GL_ACCOUNT = 'PL_HPN'
                AND COMPANY ={$company}
                AND FISCAL_YEAR_PERIOD IN ({$param_act_banding})
                AND CATEGORY = 'ACT'
                GROUP BY
                  FISCAL_YEAR_PERIOD
                ORDER BY
                  FISCAL_YEAR_PERIOD
              ) A
          ) X
        LEFT JOIN (
          SELECT
            ROWNUM AS KEY_ID,
            B.*
          FROM
            (
              SELECT
                'PL_HPN' kode,
                FISCAL_YEAR_PERIOD,
                SUM (AMOUNT) AS totalBEFORE
              FROM
                CONSOLIDATION
              WHERE
                GL_ACCOUNT = 'PL_HPN'
              AND COMPANY ={$company}
              AND FISCAL_YEAR_PERIOD IN ({$param_act_banding_b})
              AND CATEGORY = 'ACT'
              GROUP BY
                FISCAL_YEAR_PERIOD
              ORDER BY
                FISCAL_YEAR_PERIOD
            ) B
        ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
        ORDER BY
          X.KEY_ID
      ) X
    UNION ALL
      SELECT
        *
      FROM
        (
          SELECT
            X.KEY_ID,
            X.KODE,
            X.FISCAL_YEAR_PERIOD,
            TOTAL5 - COALESCE (
              CASE
              WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                0
              ELSE
                Y.TOTALBEFORE
              END,
              0
            ) AS ACT
          FROM
            (
              SELECT
                ROWNUM AS KEY_ID,
                A .*
              FROM
                (
                  SELECT
                    'LABA_KOTOR' kode,
                    FISCAL_YEAR_PERIOD,
                    TO_CHAR (
                      (
                        ADD_MONTHS (
                          TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                          - 1
                        )
                      ),
                      'YYYY.MM'
                    ) pengurang,
                    SUM (AMOUNT) AS total5
                  FROM
                    CONSOLIDATION
                  WHERE
                    GL_ACCOUNT = 'PL_LK'
                  AND COMPANY ={$company}
                  AND FISCAL_YEAR_PERIOD IN ({$param_act_banding})
                  AND CATEGORY = 'ACT'
                  GROUP BY
                    FISCAL_YEAR_PERIOD
                  ORDER BY
                    FISCAL_YEAR_PERIOD
                ) A
            ) X
          LEFT JOIN (
            SELECT
              ROWNUM AS KEY_ID,
              B.*
            FROM
              (
                SELECT
                  'PL_LK' kode,
                  FISCAL_YEAR_PERIOD,
                  SUM (AMOUNT) AS totalBEFORE
                FROM
                  CONSOLIDATION
                WHERE
                  GL_ACCOUNT = 'PL_LK'
                AND COMPANY ={$company}
                AND FISCAL_YEAR_PERIOD IN ({$param_act_banding_b})
                AND CATEGORY = 'ACT'
                GROUP BY
                  FISCAL_YEAR_PERIOD
                ORDER BY
                  FISCAL_YEAR_PERIOD
              ) B
          ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
          ORDER BY
            X.KEY_ID
        ) Y
      UNION ALL
        SELECT
          *
        FROM
          (
            SELECT
              X.KEY_ID,
              X.KODE,
              X.FISCAL_YEAR_PERIOD,
              TOTAL5 - COALESCE (
                CASE
                WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                  0
                ELSE
                  Y.TOTALBEFORE
                END,
                0
              ) AS ACT
            FROM
              (
                SELECT
                  ROWNUM AS KEY_ID,
                  A .*
                FROM
                  (
                    SELECT
                      'EBT' kode,
                      FISCAL_YEAR_PERIOD,
                      TO_CHAR (
                        (
                          ADD_MONTHS (
                            TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                            - 1
                          )
                        ),
                        'YYYY.MM'
                      ) pengurang,
                      SUM (AMOUNT) AS total5
                    FROM
                      CONSOLIDATION
                    WHERE
                      GL_ACCOUNT = 'PL_LU'
                    AND COMPANY ={$company}
                    AND FISCAL_YEAR_PERIOD IN ({$param_act_banding})
                    AND CATEGORY = 'ACT'
                    GROUP BY
                      FISCAL_YEAR_PERIOD
                    ORDER BY
                      FISCAL_YEAR_PERIOD
                  ) A
              ) X
            LEFT JOIN (
              SELECT
                ROWNUM AS KEY_ID,
                B.*
              FROM
                (
                  SELECT
                    'PL_LU' kode,
                    FISCAL_YEAR_PERIOD,
                    SUM (AMOUNT) AS totalBEFORE
                  FROM
                    CONSOLIDATION
                  WHERE
                    GL_ACCOUNT = 'PL_LU'
                  AND COMPANY ={$company}
                  AND FISCAL_YEAR_PERIOD IN ({$param_act_banding_b})
                  AND CATEGORY = 'ACT'
                  GROUP BY
                    FISCAL_YEAR_PERIOD
                  ORDER BY
                    FISCAL_YEAR_PERIOD
                ) B
            ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
            ORDER BY
              X.KEY_ID
          ) Z
        UNION ALL
          SELECT
            *
          FROM
            (
              SELECT
                X.KEY_ID,
                X.KODE,
                X.FISCAL_YEAR_PERIOD,
                TOTAL5 - COALESCE (
                  CASE
                  WHEN SUBSTR (X.FISCAL_YEAR_PERIOD, 6, 2) = '01' THEN
                    0
                  ELSE
                    Y.TOTALBEFORE
                  END,
                  0
                ) AS ACT
              FROM
                (
                  SELECT
                    ROWNUM AS KEY_ID,
                    A .*
                  FROM
                    (
                      SELECT
                        'EAT' kode,
                        FISCAL_YEAR_PERIOD,
                        TO_CHAR (
                          (
                            ADD_MONTHS (
                              TO_DATE (FISCAL_YEAR_PERIOD, 'YY.MM'),
                              - 1
                            )
                          ),
                          'YYYY.MM'
                        ) pengurang,
                        SUM (AMOUNT) AS total5
                      FROM
                        CONSOLIDATION
                      WHERE
                        GL_ACCOUNT = 'PL_LU'
                      AND COMPANY ={$company}
                      AND FISCAL_YEAR_PERIOD IN ({$param_act_banding})
                      AND CATEGORY = 'ACT'
                      GROUP BY
                        FISCAL_YEAR_PERIOD
                      ORDER BY
                        FISCAL_YEAR_PERIOD
                    ) A
                ) X
              LEFT JOIN (
                SELECT
                  ROWNUM AS KEY_ID,
                  B.*
                FROM
                  (
                    SELECT
                      'PL_LU' kode,
                      FISCAL_YEAR_PERIOD,
                      SUM (AMOUNT) AS totalBEFORE
                    FROM
                      CONSOLIDATION
                    WHERE
                      GL_ACCOUNT = 'PL_LU'
                    AND COMPANY ={$company}
                    AND FISCAL_YEAR_PERIOD IN ({$param_act_banding_b})
                    AND CATEGORY = 'ACT'
                    GROUP BY
                      FISCAL_YEAR_PERIOD
                    ORDER BY
                      FISCAL_YEAR_PERIOD
                  ) B
              ) Y ON X.PENGURANG = Y.FISCAL_YEAR_PERIOD
              ORDER BY
                X.KEY_ID
            ) Q
) P ON O.KEY_ID = P .KEY_ID
AND O.KODE = P .KODE
");
return $result->result();

 }
 function m_getpriceyear()
 {
	 date_default_timezone_set('UTC'); 
	 $year_now = date("Y");
	 $year_last= date("Y")-1;
	 
	 $year_last2=date("Y")-2;
	 
	 $param1 ="{$year_now}.01,2016.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11,{$year_now}.12";
	 $param2 ="{$year_last}.12,{$year_now}.01,{$year_now}.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11";
	 
	 $param3 = "{$year_last}.01,2016.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11,{$year_last}.12";
	 
	 $param4 = "{$year_last2}.12,{$year_last}.01,{$year_last}.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11";
	 
	 
	 $sql="SELECT A.*,COALESCE(B.HRGA,0)HRGALAST,COALESCE(C.HRGA,0) HRGATARGET FROM (SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_7000','PSV_7000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD)A
LEFT JOIN
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param3}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param4}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_7000','PSV_7000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param3})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )B ON A.FISCAL_YEAR_PERIOD=B.FISCAL_YEAR_PERIOD 
LEFT JOIN 
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.BUD,COALESCE((Q.BUD/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS BUD FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='7000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_7000','PSV_7000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'BUD'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )C
ON A.FISCAL_YEAR_PERIOD=C.FISCAL_YEAR_PERIOD ORDER BY A.FISCAL_YEAR_PERIOD ASC";
	$result=$this->db->query($sql);
	return $result->result();
 }
 
 function m_getpriceyear_st()
 {
	date_default_timezone_set('UTC'); 
	 $year_now = date("Y");
	 $year_last= date("Y")-1;
	 
	 $year_last2=date("Y")-2;
	 
	 $param1 ="{$year_now}.01,2016.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11,{$year_now}.12";
	 $param2 ="{$year_last}.12,{$year_now}.01,{$year_now}.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11";
	 
	 $param3 = "{$year_last}.01,2016.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11,{$year_last}.12";
	 
	 $param4 = "{$year_last2}.12,{$year_last}.01,{$year_last}.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11";
	 
	 
	 $sql="SELECT A.*,COALESCE(B.HRGA,0)HRGALAST,COALESCE(C.HRGA,0) HRGATARGET FROM (SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_3000','PSV_3000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD)A
LEFT JOIN
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param3}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param4}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_3000','PSV_3000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param3})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )B ON A.FISCAL_YEAR_PERIOD=B.FISCAL_YEAR_PERIOD 
LEFT JOIN 
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.BUD,COALESCE((Q.BUD/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS BUD FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='3000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_3000','PSV_3000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'BUD'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )C
ON A.FISCAL_YEAR_PERIOD=C.FISCAL_YEAR_PERIOD ORDER BY A.FISCAL_YEAR_PERIOD ASC"; 
	 
	$result=$this->db->query($sql);
	return $result->result();
 }
 
 function m_getpriceyear_sp()
 {
	 
	date_default_timezone_set('UTC'); 
	 $year_now = date("Y");
	 $year_last= date("Y")-1;
	 
	 $year_last2=date("Y")-2;
	 
	 $param1 ="{$year_now}.01,2016.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11,{$year_now}.12";
	 $param2 ="{$year_last}.12,{$year_now}.01,{$year_now}.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11";
	 
	 $param3 = "{$year_last}.01,2016.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11,{$year_last}.12";
	 
	 $param4 = "{$year_last2}.12,{$year_last}.01,{$year_last}.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11";
	 
	 
	 $sql="SELECT A.*,COALESCE(B.HRGA,0)HRGALAST,COALESCE(C.HRGA,0) HRGATARGET FROM (SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_4000','PSV_4000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD)A
LEFT JOIN
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param3}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param4}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_4000','PSV_4000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param3})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )B ON A.FISCAL_YEAR_PERIOD=B.FISCAL_YEAR_PERIOD 
LEFT JOIN 
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.BUD,COALESCE((Q.BUD/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS BUD FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='4000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_4000','PSV_4000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'BUD'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )C
ON A.FISCAL_YEAR_PERIOD=C.FISCAL_YEAR_PERIOD ORDER BY A.FISCAL_YEAR_PERIOD ASC";
 
	$result=$this->db->query($sql);
	return $result->result();
 }
 
 function m_getpriceyear_tlcc()
 {
	 
	date_default_timezone_set('UTC'); 
	 $year_now = date("Y");
	 $year_last= date("Y")-1;
	 
	 $year_last2=date("Y")-2;
	 
	 $param1 ="{$year_now}.01,2016.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11,{$year_now}.12";
	 $param2 ="{$year_last}.12,{$year_now}.01,{$year_now}.02,{$year_now}.03,{$year_now}.04,{$year_now}.05,{$year_now}.06,{$year_now}.07,{$year_now}.08,{$year_now}.09,{$year_now}.10,{$year_now}.11";
	 
	 $param3 = "{$year_last}.01,2016.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11,{$year_last}.12";
	 
	 $param4 = "{$year_last2}.12,{$year_last}.01,{$year_last}.02,{$year_last}.03,{$year_last}.04,{$year_last}.05,{$year_last}.06,{$year_last}.07,{$year_last}.08,{$year_last}.09,{$year_last}.10,{$year_last}.11";
	 
	 
	 $sql="SELECT A.*,COALESCE(B.HRGA,0)HRGALAST,COALESCE(C.HRGA,0) HRGATARGET FROM (SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_6000','PSV_6000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD)A
LEFT JOIN
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.ACT,COALESCE((Q.ACT/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS ACT FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param3}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param4}) AND CATEGORY='ACT' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_6000','PSV_6000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'ACT'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param3})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )B ON A.FISCAL_YEAR_PERIOD=B.FISCAL_YEAR_PERIOD 
LEFT JOIN 
(SELECT Q.FISCAL_YEAR_PERIOD,COALESCE(R.AMOUNT,0) AMOUNT,Q.BUD,COALESCE((Q.BUD/R.AMOUNT),0) AS HRGA
 FROM (SELECT * FROM (SELECT X.KEY_ID,X.KODE,X.FISCAL_YEAR_PERIOD,TOTAL5 - COALESCE(CASE WHEN SUBSTR(X.FISCAL_YEAR_PERIOD,6,2) ='01' 
THEN 0 ELSE Y.TOTALBEFORE END,0) AS BUD FROM (SELECT ROWNUM AS KEY_ID,A.* FROM 
(select 'PL_HPB' kode,FISCAL_YEAR_PERIOD,TO_CHAR((ADD_MONTHS(TO_DATE(FISCAL_YEAR_PERIOD,'YY.MM'), -1)),'YYYY.MM')pengurang ,SUM(AMOUNT) as total5 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param1}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)A) X
LEFT JOIN
(SELECT ROWNUM AS KEY_ID,B.* FROM (select 'PL_HPB' kode,FISCAL_YEAR_PERIOD ,SUM(AMOUNT) as totalBEFORE 
from CONSOLIDATION where GL_ACCOUNT='PL_HPB' 
AND COMPANY='6000' 
AND FISCAL_YEAR_PERIOD IN ({$param2}) AND CATEGORY='BUD' 
GROUP BY FISCAL_YEAR_PERIOD  ORDER BY FISCAL_YEAR_PERIOD)B)Y ON X.PENGURANG=Y.FISCAL_YEAR_PERIOD ORDER BY X.KEY_ID)P)Q
left JOIN 
(SELECT '01' AS NOMER,'PENJUALAN' as NAMA, FISCAL_YEAR_PERIOD, SUM(AMOUNT) as AMOUNT FROM (
SELECT CONNECT_BY_ROOT MM.MATERIAL AS ACCOUNT1, AMOUNT, DISTRIBUTION_CHANNEL, S.FISCAL_YEAR_PERIOD
FROM M_MATERIAL MM
LEFT JOIN SALES S ON S.MATERIAL = MM.MATERIAL
WHERE S.GL_ACCOUNT IN ('GSV_6000','PSV_6000','GSV_2000','PSV_2000')
AND S.DISTRIBUTION_CHANNEL IN ('10','20','30','40','50')
AND S.CATEGORY = 'BUD'
AND S.CURRENCY = 'LC'
AND S.FISCAL_YEAR_PERIOD IN ({$param1})
START WITH PARENTH2 IN ('200','121_000000')
CONNECT BY PRIOR MM.MATERIAL = PARENTH2)
GROUP BY FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD ASC)R ON Q.FISCAL_YEAR_PERIOD=R.FISCAL_YEAR_PERIOD ORDER BY FISCAL_YEAR_PERIOD )C
ON A.FISCAL_YEAR_PERIOD=C.FISCAL_YEAR_PERIOD ORDER BY A.FISCAL_YEAR_PERIOD ASC"; 
	$result=$this->db->query($sql);
	return $result->result();
 }
 
 
  
}

