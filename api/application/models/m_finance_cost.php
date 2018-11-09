<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class m_finance_cost extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }
    public function get_company() {
        $where = null;
        if ($_SESSION['status'] != 'ADMIN') {
            $where_s1 = null;
            $where_s2 = null;
            $comp = array_filter(explode(",", $_SESSION['company_hris'] . "," . $_SESSION['company_bpc']));
            $tmp = null;
            foreach ($comp as $k => $v) {
                $cmp = $tmp . "'$v',";
                $tmp = $cmp;
                if ($v == "7000") {
                    $where_s1 = "'2000,7000',";
                    $where_s2 = "'5000,7000',";
                } elseif ($v == "2000") {
                    $where_s1 = "'2000,7000',";
                } elseif ($v == "5000") {
                    $where_s2 = "'5000,7000',";
                }
            }
            $comp_all = substr($cmp . $where_s1 . $where_s2, 0, -1);
            $where = "WHERE COMPANY IN ($comp_all)";
        }
        return $this->db->query("SELECT COMPANY, DESCRIPTION FROM (
                                        SELECT '2000,7000' AS COMPANY, '2000 & 7000' AS DESCRIPTION, 'GCEMENT2' AS PARENTH2 FROM dual
                                    UNION
                                        SELECT '5000,7000' AS COMPANY, '5000 & 7000' AS DESCRIPTION, 'GCEMENT2' AS PARENTH2 FROM dual
                                    UNION
                                        SELECT COMPANY, DESCRIPTION, PARENTH2
                                        FROM M_COMPANY
                                        WHERE INTERCO IS NOT NULL
                                            AND COMPANY <> 'GCEMENT'
                                            AND COMPANY <> 'NO_ENTITY'
                                    )
                                    $where
                                    ORDER BY PARENTH2, COMPANY")->result();
    }
    public function cek_company($comp){
        $data = $this->db->query("SELECT PARENTH2 FROM M_COMPANY
                                WHERE COMPANY IN ('$comp')");
        return $data->row();
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
        $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM FINANCIAL
                                WHERE COMPANY IN ('$comp')
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND AUDITTRAIL = 'CSTRU'
                                AND CATEGORY = '$cat'
                                GROUP BY GL_ACCOUNT, CSTR_NO
                                ORDER BY CSTR_NO ");
        
        return $data->result();
    }
    
     public function get_clinker($comp, $date, $cat, $plant){
        $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND COMPANY IN ('$comp')
                                AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020')");
        
        return $data->row();
    }
    public function get_cement($comp, $date, $cat, $plant){
        $data = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM PRODUCTION
                                WHERE CATEGORY = '$cat'
                                AND PLANT IN ($plant)
                                AND FISCAL_YEAR_PERIOD IN ($date)
                                AND GL_ACCOUNT = 'PRD_QTY'
                                AND COMPANY IN ('$comp')
                                AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010')");
        
        return $data->row();
    }
    public function get_sales($comp, $date, $cat){
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
                                        START WITH PARENTH2 IN ('200','121-000000')
                                        CONNECT BY PRIOR MM.MATERIAL = PARENTH2)");
        
        return $data->row();
    }
    public function atas($date,$date_last,$date_sd,$date_sd_last,$company, $plant){
	$comp = explode("','", $company);
        if(count($comp) == 1){
            $comp = "'PSV_$comp[0]','GSV_$comp[0]'";
        }else{
            $comp = "'PSV_$comp[0]','GSV_$comp[0]','PSV_$comp[1]','GSV_$comp[1]'";
        }
		$query=$this->db->query("SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date) AND PLANT IN($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date) AND DIS = 'SALES'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date) AND PLANT IN ($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date) AND DIS = 'SALES'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_last) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_last) AND PLANT IN ($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date_last) AND DIS = 'SALES'
						---------SAMPAI-DENGAN-----------------------------------------------SAMPAI-DENGAN-----------------------------------------------SAMPAI-DENGAN-----------------------------------------------SAMPAI-DENGAN
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd) AND PLANT IN ($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_BUD WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date_sd) AND DIS = 'SALES'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd) AND PLANT IN ($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date_sd) AND DIS = 'SALES'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd_last) AND PLANT IN ($plant) AND DIS = 'CLINKER'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ('$company') AND FISCAL_YEAR_PERIOD IN ($date_sd_last) AND PLANT IN ($plant) AND DIS = 'SEMEN'
						UNION ALL
						SELECT (CASE WHEN SUM(AMOUNT) IS NULL THEN 0 ELSE SUM(AMOUNT) END) AS JUMLAH FROM MV_COST_REPORT_ATAS_ACT WHERE COMPANY IN ($comp) AND FISCAL_YEAR_PERIOD IN ($date_sd_last) AND DIS = 'SALES'");
		return $query->result_array();
	}
        public function bawah($company, $date, $date_last, $date_sd, $date_last_sd, $type){
//            if($type == "GCEMENT"){
//                $pembanding = "ON MCT.GL_ACCOUNT = NI.GL_ACCOUNT";
//            }else{
//                $pembanding = "ON MCT.COST_GROUP || '_' || MCT.GL_ACCOUNT2 = NI.GL_ACCOUNT";
//            }
            
		$query=$this->db->query("SELECT DESC_ENGLISH, DESC_INDO,
                    NVL(BUD1,0) AS BUD1,
                    NVL(ACT1,0) AS ACT1,
                    NVL(ACT11,0) AS ACT11,
                    NVL(BUD2,0) AS BUD2,
                    NVL(ACT2,0) AS ACT2,
                    NVL(ACT22,0) AS ACT22,
                    COST_GROUP FROM (
                SELECT MCT.DESC_ENGLISH, MCT.DESC_INDO, NI.JUMLAH, NI.DIS, MCT.URUTAN, MCT.COST_GROUP FROM M_COSTSTRUCTURE MCT
                LEFT JOIN
                (
                SELECT GL_ACCOUNT, JUMLAH, DIS FROM(
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'BUD' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ('$date')
                        AND CATEGORY = 'BUD'
                        GROUP BY GL_ACCOUNT, CSTR_NO

                        UNION ALL
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ('$date')
                        AND CATEGORY = 'ACT'
                        GROUP BY GL_ACCOUNT, CSTR_NO

                        UNION ALL
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_LAST' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ('$date_last')
                        AND CATEGORY = 'ACT'
                        GROUP BY GL_ACCOUNT, CSTR_NO

                        UNION ALL
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'BUD_SD' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ( $date_sd )
                        AND CATEGORY = 'BUD'
                        GROUP BY GL_ACCOUNT, CSTR_NO

                        UNION ALL
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_SD' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ( $date_sd )
                        AND CATEGORY = 'ACT'
                        GROUP BY GL_ACCOUNT, CSTR_NO

                        UNION ALL
                        SELECT GL_ACCOUNT, SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_LAST_SD' AS DIS
                        FROM MV_COST_REPORT_BAWAH
                        WHERE COMPANY IN ('$company')
                        AND FISCAL_YEAR_PERIOD IN ( $date_last_sd )
                        AND CATEGORY = 'ACT'
                        GROUP BY GL_ACCOUNT, CSTR_NO
                    )
                ) NI
                ON MCT.COST_GROUP || '_' || MCT.GL_ACCOUNT2 = NI.GL_ACCOUNT
                WHERE MCT.COMPANY IN ('ALL','$company')
                )
                PIVOT (
                        SUM(JUMLAH) FOR (DIS) IN
                                        (
                                                'BUD' AS BUD1,
                                                'ACT' AS ACT1,
                                                'ACT_LAST' AS ACT11,
                                                'BUD_SD' AS BUD2,
                                                'ACT_SD' AS ACT2,
                                                'ACT_LAST_SD' AS ACT22
                                        )
                        )
                ORDER BY URUTAN");
		return $query->result();
	}
//	public function bawah($company, $date, $date_last, $date_sd, $date_last_sd){
//		$query=$this->db->query("SELECT JUMLAH, DIS FROM(
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'BUD' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date)
//						AND CATEGORY = 'BUD'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//						
//						UNION ALL
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date)
//						AND CATEGORY = 'ACT'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//						
//						UNION ALL
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_LAST' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date_last)
//						AND CATEGORY = 'ACT'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//
//						UNION ALL
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'BUD_SD' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date_sd)
//						AND CATEGORY = 'BUD'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//						
//						UNION ALL
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_SD' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date_sd)
//						AND CATEGORY = 'ACT'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//						
//						UNION ALL
//						SELECT SUM(AMOUNT) AS JUMLAH, CSTR_NO, 'ACT_LAST_SD' AS DIS
//						FROM MV_COST_REPORT_BAWAH
//						WHERE COMPANY IN ('".$company."')
//						AND FISCAL_YEAR_PERIOD IN ($date_last_sd)
//						AND CATEGORY = 'ACT'
//						GROUP BY GL_ACCOUNT, CSTR_NO
//					)
//					ORDER BY CSTR_NO");
//		return $query->result();
//	}
    public function get_total_min_marketing($company, $category, $time){
        $this->db->select('SUM(AMOUNT) as JUMLAH');
        $this->db->from('FINANCIAL FN');
        $this->db->join('M_COSTCENTER MC', 'FN.COSTCENTER = MC.COST_CENTER');
        $this->db->join('M_GL_ACCOUNT MG', 'FN.GL_ACCOUNT = MG.GL_ACCOUNT');
        $this->db->join('M_DOCUMENT_TYPE MDT', 'FN.DOCUMENT_TYPE = MDT.DOC_TYPE');
        $this->db->join('M_INTERCO MI', 'FN.INTERCO = MI.INTERCO');
        $this->db->join('M_PROFIT_CENTER MPC', 'FN.PROFIT_CENTER = MPC.PROFIT_CENTER');
        $this->db->where('FN.AUDITTRAIL', 'SAP_ECC');
        $this->db->where('FN.FISCAL_YEAR_PERIOD', $time);
        $this->db->where_in('FN.COMPANY', $company);
        $this->db->where('MDT.FI', 'Y');
        $this->db->where('MG.OA', 'Y');
        $this->db->where('MI.PARENTH1', 'TOT_INTERCO');
        $this->db->where('MPC.C1', 'Y');
        $this->db->where('FN.CATEGORY', $category);
        $this->db->where_in('MC.COST_CENTER', array('7204201000', '2105201000'));
        $data = $this->db->get();
        return $data->row();
    }
    public function get_logo ($select, $comp){
        if($comp == "20007000" || $comp = "50007000"){
            $comp = "2000";
        }
        $query = $this->db->query("SELECT $select FROM M_COMPANY WHERE COMPANY = '$comp'");
        return $query->result_array();
    }


    public function detail_gabungan($time, $time2, $status, $name_mv, $no){
        $data = $this->db->query("SELECT COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2, TO_CHAR(SUM(NILAI),'999,999,999,999,999') AS NILAI FROM (
                                    SELECT COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2, SUM(JUMLAH) AS NILAI FROM MV_COSTSTRUCTURE_$name_mv[0]
                                                                        WHERE FISCAL_YEAR_PERIOD BETWEEN '$time' AND '$time2'
                                                                        AND COSTCENTER $status LIKE 'NC%'
                                                                        AND NOMOR = '$no'
                                                                        GROUP BY COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2
                                    UNION
                                    SELECT COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2, SUM(JUMLAH) AS NILAI FROM MV_COSTSTRUCTURE_$name_mv[1]
                                                                        WHERE FISCAL_YEAR_PERIOD BETWEEN '$time' AND '$time2'
                                                                        AND COSTCENTER $status LIKE 'NC%'
                                                                        AND NOMOR = '$no'
                                                                        GROUP BY COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2
                                    )
                                    GROUP BY COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2
                                    ORDER BY COSTCENTER, GL_ACCOUNT");
        return $data->result();
    }
    
    public function detail_coststructure($time, $time2, $status, $name_mv, $no){
        $data = $this->db->query("SELECT COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2, TO_CHAR(SUM(JUMLAH),'999,999,999,999,999') AS NILAI FROM MV_COSTSTRUCTURE_$name_mv
                                    WHERE FISCAL_YEAR_PERIOD BETWEEN '$time' AND '$time2'
                                    AND COSTCENTER $status LIKE 'NC%'
                                    AND NOMOR = '$no'
                                    GROUP BY COSTCENTER, DESCRIPTION1, GL_ACCOUNT, DESCRIPTION2
                                    ORDER BY COSTCENTER, GL_ACCOUNT");
        return $data->result();
    }
    
    public function detail_coststructure_subsidiary($time, $time2, $no, $group, $account, $company, $category){
        if($company == 'G200' || $company == 'G500'){
            if($group == '1'){
                $groupo_in = "'1','12','13','123'";
            }else if($group == '2'){
                $groupo_in = "'2','12','23','123'";
            }else{
                $groupo_in = "'3','13','23','123'";
            }
            $data = $this->db->query("SELECT
                                            COSTCENTER,
                                            DESCRIPTION AS DESCRIPTION1,
                                            GL_ACCOUNT,
                                            DESCRIPTION2,
                                            TO_CHAR (
                                                SUM (AMOUNT),
                                                '999,999,999,999,999'
                                            ) AS NILAI
                                    FROM
                                            MV_COSTSTRUCTURE_SUB
                                    WHERE
                                            FISCAL_YEAR_PERIOD BETWEEN '$time'
                                    AND '$time2'
                                    AND COST_GROUP_C = '$group'
                                    AND COST_GROUP IN ($groupo_in)
                                    AND STRUCTURE = '$account'
                                    AND COMPANY = '$company'
                                    AND CATEGORY = '$category'
                                    GROUP BY
                                            COSTCENTER,
                                            DESCRIPTION,
                                            GL_ACCOUNT,
                                            DESCRIPTION2
                                    ORDER BY
                                            COSTCENTER, GL_ACCOUNT");
        }ELSE{
            $data = $this->db->query("SELECT GL_ACCOUNT,
                                            DESCRIPTION2,
                                            TO_CHAR ( SUM (AMOUNT), '999,999,999,999,999' ) AS NILAI
                                    FROM MV_COSTSTRUCTURE_SUB
                                    WHERE FISCAL_YEAR_PERIOD BETWEEN '$time' AND '$time2'
                                    AND COST_GROUP = '$group'
                                    AND STRUCTURE = '$account'
                                    AND COMPANY = '$company'
                                    AND CATEGORY = '$category'
                                    GROUP BY GL_ACCOUNT, DESCRIPTION2
                                    ORDER BY GL_ACCOUNT");
        }
        return $data->result();
    }
    




}

?>