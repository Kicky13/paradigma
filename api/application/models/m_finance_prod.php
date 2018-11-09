<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class m_finance_prod extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function get_performance_cement($year, $category) {
        $thn_skrg = date('Y');
        $bln_skrg = date("j");
        $hari_skrg = date("d");
        $pivot = "'$year.01' AS M1,
                      '$year.02' AS M2,
                      '$year.03' AS M3,
                      '$year.04' AS M4,
                      '$year.05' AS M5,
                      '$year.06' AS M6,
                      '$year.07' AS M7,
                      '$year.08' AS M8,
                      '$year.09' AS M9,
                      '$year.10' AS M10,
                      '$year.11' AS M11,
                      '$year.12' AS M12";
        if ($thn_skrg == $year && $hari_skrg < 16) {
            if ($bln_skrg == 1) {
                $year_min = $year -1;
                $pivot = "'$year_min.12' AS M1,
                          '$year.02' AS M2,
                          '$year.03' AS M3,
                          '$year.04' AS M4,
                          '$year.05' AS M5,
                          '$year.06' AS M6,
                          '$year.07' AS M7,
                          '$year.08' AS M8,
                          '$year.09' AS M9,
                          '$year.10' AS M10,
                          '$year.11' AS M11,
                          '$year.12' AS M12";
            }else{
                $pivot = null;
                $pivot_tmp = null;
                for ($i = 1; $i <= 12; $i++) {
                    $bln = $i;
                    if ($bln_skrg==$bln) {
                        $bln = $bln -1;
                    }
                    $bln = substr("0$bln", -2);
                    $pivot = $pivot_tmp."'$year.$bln' AS M$i,";
                    $pivot_tmp = $pivot;
                }
                $pivot = substr($pivot, 0, -1);
            }
        } 
        $q = $this->db->query("( SELECT * FROM (
            SELECT
                            FISCAL_YEAR_PERIOD, PLANT, AMOUNT
            FROM
                            PRODUCTION
            WHERE
                CATEGORY = '$category'
            AND PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7301','7302','7303','7304','7305', '7308')
            AND GL_ACCOUNT = 'PRD_QTY'
            AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020','121-302-0010')
        ) PIVOT (
            SUM (AMOUNT) 
                        FOR FISCAL_YEAR_PERIOD IN (
                            $pivot
                        )
        )
        )");
        $qry = $q->result();
        $dt[] = '';
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;
            for ($i = 1; $i <= 12; $i++) {
                $dt[$i][$plant] = $sh->{"M$i"};
            }
        }
        return $dt;
    }

    public function get_comparison_cement($time) {
        $temp = "";
        $bln = substr($time, -2);
        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        for ($i = 1; $i <= $bln; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bln) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$month' $tmbhn";
            $temp = $time_between;
        }
        $time_between_lalu = str_replace($year, $year_lalu, $time_between);
        $sub_qry = "(select SUM(AMOUNT) from PRODUCTION where GL_ACCOUNT = 'PRD_QTY' AND MATERIAL IN ('121-302-0060', '121-301-0060', '121-302-0019', '121-302-0110', '121-302-0040', '121-302-0030', '121-302-0020', '121-302-0010') AND CATEGORY =";
        $q = $this->db->query("SELECT MP.PLANT,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as BUD,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as ACT,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$year_lalu.$bln') as ACT_LALU,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as BUD1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as ACT1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between_lalu)) as ACT_LALU1
        FROM M_PLANT MP 
        WHERE PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7301','7302','7303','7304','7305','7308')");
        $qry = $q->result();
        $dt[] = "";
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;

            $dt['BUD'][$plant] = $sh->BUD;
            $dt['ACT'][$plant] = $sh->ACT;
            $dt['ACT_LALU'][$plant] = $sh->ACT_LALU;
            $dt['BUD1'][$plant] = $sh->BUD1;
            $dt['ACT1'][$plant] = $sh->ACT1;
            $dt['ACT_LALU1'][$plant] = $sh->ACT_LALU1;
        }
        return $dt;
    }


    public function get_performance_clinker($year, $category) {
        $thn_skrg = date('Y');
        $bln_skrg = date("j");
        $hari_skrg = date("d");
        $pivot = "'$year.01' AS M1,
                      '$year.02' AS M2,
                      '$year.03' AS M3,
                      '$year.04' AS M4,
                      '$year.05' AS M5,
                      '$year.06' AS M6,
                      '$year.07' AS M7,
                      '$year.08' AS M8,
                      '$year.09' AS M9,
                      '$year.10' AS M10,
                      '$year.11' AS M11,
                      '$year.12' AS M12";
        if ($thn_skrg == $year && $hari_skrg < 16) {
            if ($bln_skrg == 1) {
                $year_min = $year -1;
                $pivot = "'$year_min.12' AS M1,
                          '$year.02' AS M2,
                          '$year.03' AS M3,
                          '$year.04' AS M4,
                          '$year.05' AS M5,
                          '$year.06' AS M6,
                          '$year.07' AS M7,
                          '$year.08' AS M8,
                          '$year.09' AS M9,
                          '$year.10' AS M10,
                          '$year.11' AS M11,
                          '$year.12' AS M12";
            }else{
                $pivot = null;
                $pivot_tmp = null;
                for ($i = 1; $i <= 12; $i++) {
                    $bln = $i;
                    if ($bln_skrg==$bln) {
                        $bln = $bln -1;
                    }
                    $bln = substr("0$bln", -2);
                    $pivot = $pivot_tmp."'$year.$bln' AS M$i,";
                    $pivot_tmp = $pivot;
                }
                $pivot = substr($pivot, 0, -1);
            }
        }
        $q = $this->db->query("(SELECT * FROM (
            SELECT
                            FISCAL_YEAR_PERIOD, PLANT, AMOUNT
            FROM
                            PRODUCTION
            WHERE
                CATEGORY = '$category'
            AND PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7301','7302','7303','7304','7305','7308')
            AND GL_ACCOUNT = 'PRD_QTY'
            AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020')
        ) PIVOT (
            SUM (AMOUNT) 
                        FOR FISCAL_YEAR_PERIOD IN ($pivot)
        )
        )");
        $qry = $q->result();
        $dt[] = "";
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;
            for ($i = 1; $i <= 12; $i++) {
                $dt[$i][$plant] = $sh->{"M$i"};
            }
        }
        return $dt;
    }

    public function get_comparison_clinker($time) {
        $temp = "";
        $bln = substr($time, -2);
        $year = substr($time, 0, 4);
        $year_lalu = $year - 1;
        for ($i = 1; $i <= $bln; $i++) {
            $month = "0$i";
            $month = substr($month, -2);
            if ($i != $bln) {
                $tmbhn = ",";
            } else {
                $tmbhn = "";
            }
            $time_between = "$temp '$year.$month' $tmbhn";
            $temp = $time_between;
        }
        $time_between_lalu = str_replace($year, $year_lalu, $time_between);
        $sub_qry = "(select SUM(AMOUNT) from PRODUCTION where GL_ACCOUNT = 'PRD_QTY' AND MATERIAL IN ('121-200-0010', '121-200-0040', '121-200-0020') AND CATEGORY =";
        $q = $this->db->query("SELECT MP.PLANT,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as BUD,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$time' ) as ACT,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD = '$year_lalu.$bln') as ACT_LALU,
            $sub_qry 'BUD' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as BUD1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between)) as ACT1,
            $sub_qry 'ACT' AND PLANT = MP.PLANT AND FISCAL_YEAR_PERIOD IN ($time_between_lalu)) as ACT_LALU1
        FROM M_PLANT MP 
        WHERE PLANT IN ('2301', '2302','2303','2304','2305','2390','3301','3302','3303','3304','3309','4301','4302','4303','5301','5390','5391','7301','7302','7303','7304','7305','7308')");
//        echo $this->db->last_query();exit;
        $qry = $q->result();
        $dt[] = "";
        foreach ($qry as $sh) {
            $plant = $sh->PLANT;

            $dt['BUD'][$plant] = $sh->BUD;
            $dt['ACT'][$plant] = $sh->ACT;
            $dt['ACT_LALU'][$plant] = $sh->ACT_LALU;
            $dt['BUD1'][$plant] = $sh->BUD1;
            $dt['ACT1'][$plant] = $sh->ACT1;
            $dt['ACT_LALU1'][$plant] = $sh->ACT_LALU1;
        }
        return $dt;
    }

}

?>
