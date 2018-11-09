<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class m_cash_projection extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function last_update_cp($comp) {
        $ret = $this->db->query("SELECT TO_CHAR(MAX(LAST_UPDATE), 'DD-MON-YYYY HH24:MI:SS') AS LAST_UPDATE FROM POSISI_KEUANGAN
                                WHERE RBUKRS = '$comp'");
        return $ret->result();
    }

    public function dwn($post) {
        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp = $post['comp'];
        $filter = "";
        if ($comp == 'KSO') {
            $comp = "7000','7KSO";
            $filter = " AND B.BUKRS = 'KSO' ";
        } else if ($comp == 'BU-SI') {
            $comp = "2000','7000";
            $filter = " AND B.BUKRS = 'BU-SI' ";
        }
        $ret = $this->db->query("SELECT * FROM
                (
                    SELECT
			TO_CHAR (BUDAT, 'DD MONTH YYYY') AS TGL,
			HKONT,
			TEXT1,
			DRCRK,
			HSL
                    FROM
			POSISI_KEUANGAN A
                        LEFT JOIN M_BANK B ON A .RACCT = '00' || B.HKONT $filter
                    WHERE
			RBUKRS IN ('$comp')
                        AND RWCUR = 'IDR'
                        AND WAERS = 'IDR'
                        AND BUDAT BETWEEN TO_DATE (
                            '" . $post['st_date'] . " 00:00:00',
                            'YYYY-MM-DD HH24:MI:SS'
                        )
                        AND TO_DATE (
                            '" . $post['en_date'] . " 23:00:00',
                            'YYYY-MM-DD HH24:MI:SS'
                        )
                ) PIVOT (
                        SUM (HSL) FOR DRCRK IN ('H' AS DBT, 'S' AS KRD)
                )
                ORDER BY TGL, HKONT");
        return $ret->result();
    }

    public function dwn_proj($comp, $start_date, $end_date) {
        //PENAMBAHAN KELOMPOK COMPANY BARU
        $filter = "";
        if ($comp == 'KSO') {
            $comp = "7000','7KSO";
            $filter = " AND B.BUKRS = 'KSO' ";
        } else if ($comp == 'BU-SI') {
            $comp = "2000','7000";
            $filter = " AND B.BUKRS = 'BU-SI' ";
        }
        $ret = $this->db->query("SELECT * FROM
                (
                    SELECT
			TO_CHAR (BUDAT, 'DD MONTH YYYY') AS TGL,
			HKONT,
			TEXT1,
			DRCRK,
			HSL
                    FROM
			POSISI_KEUANGAN A
                        LEFT JOIN M_BANK B ON A .RACCT = '00' || B.HKONT $filter
                    WHERE
			RBUKRS IN ('$comp')
                        AND RWCUR = 'IDR'
                        AND WAERS = 'IDR'
                        AND BUDAT BETWEEN TO_DATE (
                            '" . $start_date . " 00:00:00',
                            'YYYY-MM-DD HH24:MI:SS'
                        )
                        AND TO_DATE (
                            '" . $end_date . " 23:00:00',
                            'YYYY-MM-DD HH24:MI:SS'
                        )
                ) PIVOT (
                        SUM (HSL) FOR DRCRK IN ('H' AS DBT, 'S' AS KRD)
                )
                ORDER BY TGL, HKONT");
        return $ret->result();
    }

    public function get_grand_total($date, $com, $cur) {
        $comp2 = $comp3 = $comp_ori = $com;
        if ($com == 'KSO') {
            $com = "7000','7KSO";
            $comp_ori = '7KSO';
            $comp2 = "7000','7KSO";
            $comp3 = "7000','7KSO";
        } else if ($com == 'BU-SI') {
            $com = "2000','7000";
            $comp_ori = 'BU-SI';
            $comp2 = '7000';
            $comp3 = ' ';
        }

        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }

        $ret = $this->db->query("

			SELECT NVL(SUM(AMOUNT),0) AS AMOUNT, NVL(SUM(AMOUNT2),0) AS AMOUNT2 FROM (

				SELECT NVL(SUM(HSL)*100,0) AS AMOUNT, NVL(SUM(HSL2),0) AS AMOUNT2
				FROM M_BANK
				LEFT JOIN (
					SELECT RACCT, RBUKRS, SUM(HSL) AS HSL
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$com')
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					AND RWCUR = '$cur'
					GROUP BY RACCT, RBUKRS
				) ON HKONT = SUBSTR(RACCT,3)
                                LEFT JOIN (
                                    SELECT GL_ACCOUNT, COMPANY, SUM(AMOUNT) AS HSL2
                                    FROM POSISI_KEUANGAN_FINANCE
                                    WHERE COMPANY IN ('$com')
                                    AND RWCUR = '$cur'
                                    AND BUDAT = '$date'
                                    GROUP BY GL_ACCOUNT, COMPANY
                                ) ON HKONT = GL_ACCOUNT
				WHERE BUKRS IN ('$comp_ori')
				AND WAERS = '$cur'

				UNION ALL
				SELECT NVL(SUM(DMBTR)*100, 0) AS AMOUNT, NVL(SUM(DMBTR)*100, 0) AS AMOUNT2 FROM (
					SELECT A.BUKRS, A.WAERS, A.DATECOL, A.LIFNR, A.BELNR, -(A.DMBTR) AS DMBTR, CASE WHEN B.DEFAULT_DUE_DATE IS NOT NULL THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END AS DEFAULT_DUE_DATE
					FROM ZCFI3015 A
					LEFT JOIN ZCFI3015_COMPARE B
					ON A.BUKRS = B.BUKRS
					AND A.BELNR = B.BELNR
					WHERE A.BUKRS IN ('$comp2')
					AND A.WAERS = '$cur'
					AND A.DEFAULT_DUE_DATE $operator '$date'
					OR A.BUKRS IN ('$comp2')
					AND A.WAERS = '$cur'
					AND B.DEFAULT_DUE_DATE <= '$date'
				) WHERE BUKRS IN ('$comp2')
				AND WAERS = '$cur'
				AND DEFAULT_DUE_DATE $operator '$date'

				UNION ALL
				SELECT NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT2
				FROM \"ZCFI0015\"
				WHERE COMPANY IN ('$comp3')
				AND CURRENCY_KEY = '$cur'
				AND NET_DUE_DATE $operator '$date'
			)

		")->result_array();

        return $ret[0];
        echoq($this);
    }

    public function get_grand_total_holding($date, $com, $cur) {
        echo $com;
        exit;
        $comp2 = $comp3 = $comp_ori = $com;
        if ($com == 'KSO') {
            $com = "7000','7KSO";
            $comp_ori = '7KSO';
            $comp2 = "7000','7KSO";
            $comp3 = "7000','7KSO";
        } else if ($com == 'BU-SI') {
            $com = "2000','7000";
            $comp_ori = 'BU-SI';
            $comp2 = '7000';
            $comp3 = ' ';
        }

        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }

        $ret = $this->db->query("

			SELECT NVL(SUM(AMOUNT),0) AS AMOUNT, NVL(SUM(AMOUNT2),0) AS AMOUNT2 FROM (

				SELECT NVL(SUM(HSL)*100,0) AS AMOUNT, NVL(SUM(HSL2),0) AS AMOUNT2
				FROM M_BANK
				LEFT JOIN (
					SELECT RACCT, RBUKRS, SUM(HSL) AS HSL
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$com')
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					AND RWCUR = '$cur'
					GROUP BY RACCT, RBUKRS
				) ON HKONT = SUBSTR(RACCT,3)
                                LEFT JOIN (
                                    SELECT GL_ACCOUNT, COMPANY, SUM(AMOUNT) AS HSL2
                                    FROM POSISI_KEUANGAN_FINANCE
                                    WHERE COMPANY IN ('$com')
                                    AND RWCUR = '$cur'
                                    AND BUDAT = '$date'
                                    GROUP BY GL_ACCOUNT, COMPANY
                                ) ON HKONT = GL_ACCOUNT
				WHERE BUKRS IN ('$comp_ori')
				AND WAERS = '$cur'

				UNION ALL
				SELECT NVL(SUM(DMBTR)*100, 0) AS AMOUNT, NVL(SUM(DMBTR)*100, 0) AS AMOUNT2 FROM (
					SELECT A.BUKRS, A.WAERS, A.DATECOL, A.LIFNR, A.BELNR, -(A.DMBTR) AS DMBTR, CASE WHEN B.DEFAULT_DUE_DATE IS NOT NULL THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END AS DEFAULT_DUE_DATE
					FROM ZCFI3015 A
					LEFT JOIN ZCFI3015_COMPARE B
					ON A.BUKRS = B.BUKRS
					AND A.BELNR = B.BELNR
					WHERE A.BUKRS IN ('$comp2')
					AND A.WAERS = '$cur'
					AND A.DEFAULT_DUE_DATE $operator '$date'
					OR A.BUKRS IN ('$comp2')
					AND A.WAERS = '$cur'
					AND B.DEFAULT_DUE_DATE <= '$date'
				) WHERE BUKRS IN ('$comp2')
				AND WAERS = '$cur'
				AND DEFAULT_DUE_DATE $operator '$date'

				UNION ALL
				SELECT NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT2
				FROM \"ZCFI0015\"
				WHERE COMPANY IN ('$comp3')
				AND CURRENCY_KEY = '$cur'
				AND NET_DUE_DATE $operator '$date'
			)

		")->result_array();

        return $ret[0];
        echoq($this);
    }

    public function get_grand_total_all($date, $com) {
        $comp2 = $comp3 = $comp_ori = $com;
        if ($com == 'KSO') {
            $com = "7000','7KSO";
            $comp_ori = '7KSO';
            $comp2 = "7000','7KSO";
            $comp3 = "7000','7KSO";
        } else if ($com == 'BU-SI') {
            $com = "2000','7000";
            $comp_ori = 'BU-SI';
            $comp2 = '7000';
            $comp3 = '';
        }

        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }

        $ret = $this->db->query("

			SELECT NVL(SUM(AMOUNT),0) AS AMOUNT, NVL(SUM(AMOUNT2),0) AS AMOUNT2 FROM (

				SELECT NVL(HSL*100,0) AS AMOUNT, NVL(HSL2,0) AS AMOUNT2
				FROM M_BANK
				LEFT JOIN (
					SELECT RACCT, SUM(HSL) AS HSL
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$com')
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					GROUP BY RACCT
				) ON HKONT = SUBSTR(RACCT,3)
                                LEFT JOIN (
                                    SELECT GL_ACCOUNT, SUM(AMOUNT) AS HSL2
                                    FROM POSISI_KEUANGAN_FINANCE
                                    WHERE COMPANY IN ('$com')
                                    AND BUDAT = '$date'
                                    GROUP BY GL_ACCOUNT
                                ) ON HKONT = GL_ACCOUNT
				WHERE BUKRS IN ('$comp_ori')

				UNION ALL
				SELECT NVL(SUM(DMBTR)*100, 0) AS AMOUNT, NVL(SUM(DMBTR)*100, 0) AS AMOUNT2 FROM (
					SELECT A.BUKRS, A.WAERS, A.DATECOL, A.LIFNR, A.BELNR, -(A.DMBTR) AS DMBTR, CASE WHEN B.DEFAULT_DUE_DATE IS NOT NULL THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END AS DEFAULT_DUE_DATE
					FROM ZCFI3015 A
					LEFT JOIN ZCFI3015_COMPARE B
					ON A.BUKRS = B.BUKRS
					AND A.BELNR = B.BELNR
					WHERE A.BUKRS IN ('$comp2')
					AND A.DEFAULT_DUE_DATE $operator '$date'
					OR A.BUKRS IN ('$comp2')
					AND B.DEFAULT_DUE_DATE $operator '$date'
				) WHERE BUKRS IN ('$comp2')
				AND DEFAULT_DUE_DATE <= '$date'

				UNION ALL
				SELECT NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT2
				FROM \"ZCFI0015\"
				WHERE COMPANY IN ('$comp3')
				AND NET_DUE_DATE $operator '$date'
			)

		")->result_array();

        return $ret[0];
        echoq($this);
    }

    public function get_grand_total_all_holding($date, $com) {
        $comp2 = $comp3 = $comp_ori = $com;
        if ($com == 'KSO') {
            $com = "7000','7KSO";
            $comp_ori = '7KSO';
            $comp2 = "7000','7KSO";
            $comp3 = "7000','7KSO";
        } else if ($com == 'BU-SI') {
            $com = "2000','7000";
            $comp_ori = 'BU-SI';
            $comp2 = '7000';
            $comp3 = '';
        } else if ($com == '1000') {
            $com = "2000','3000','4000','5000','7000";
            $comp_ori = "2000','3000','4000','5000','7000";
            $comp2 = "2000','3000','4000','5000','7000";
            $comp3 = "2000','3000','4000','5000','7000";
        }

        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }

        $ret = $this->db->query("

			SELECT COMPANY, NVL(SUM(AMOUNT),0) AS AMOUNT, NVL(SUM(AMOUNT2),0) AS AMOUNT2 FROM (

				SELECT BUKRS AS COMPANY, NVL(SUM(HSL)*100,0) AS AMOUNT, NVL(SUM(HSL2),0) AS AMOUNT2
				FROM M_BANK
				LEFT JOIN (
					SELECT RBUKRS, RACCT, SUM(HSL) AS HSL
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$com')
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					GROUP BY RACCT, RBUKRS
				) ON HKONT = SUBSTR(RACCT,3) AND BUKRS = RBUKRS
                                LEFT JOIN (
                                    SELECT COMPANY, GL_ACCOUNT, SUM(AMOUNT) AS HSL2
                                    FROM POSISI_KEUANGAN_FINANCE
                                    WHERE COMPANY IN ('$com')
                                    AND BUDAT =
                                    (
                                        SELECT MAX(BUDAT) FROM POSISI_KEUANGAN_FINANCE
                                        WHERE BUDAT <= '$date'
                                    )
                                    GROUP BY GL_ACCOUNT, COMPANY
                                ) ON HKONT = GL_ACCOUNT AND BUKRS = COMPANY
				WHERE BUKRS IN ('$comp_ori')
                                GROUP BY BUKRS

				UNION ALL
				SELECT BUKRS AS COMPANY, NVL(SUM(DMBTR)*100, 0) AS AMOUNT, NVL(SUM(DMBTR)*100, 0) AS AMOUNT2 FROM (
					SELECT A.BUKRS, A.WAERS, A.DATECOL, A.LIFNR, A.BELNR, -(A.DMBTR) AS DMBTR, CASE WHEN B.DEFAULT_DUE_DATE IS NOT NULL THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END AS DEFAULT_DUE_DATE
					FROM ZCFI3015 A
					LEFT JOIN ZCFI3015_COMPARE B
					ON A.BUKRS = B.BUKRS
					AND A.BELNR = B.BELNR
					WHERE A.BUKRS IN ('$comp2')
					AND A.DEFAULT_DUE_DATE $operator '$date'
					OR A.BUKRS IN ('$comp2')
					AND B.DEFAULT_DUE_DATE $operator '$date'
				) WHERE BUKRS IN ('$comp2')
				AND DEFAULT_DUE_DATE <= '$date'
                                GROUP BY BUKRS

				UNION ALL
				SELECT COMPANY, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT2
				FROM \"ZCFI0015\"
				WHERE COMPANY IN ('$comp3')
				AND NET_DUE_DATE $operator '$date'
                                GROUP BY COMPANY
			)
                        GROUP BY COMPANY
                        ORDER BY COMPANY

		")->result_array();

        return $ret;
        echoq($this);
    }

    public function get_data_bank($dt) {
        $this->db->select('DISTINCT(RACCT), MB.TEXT1');

        if ($dt['COM'] != 'ALL')
            $this->db->where('RBUKRS', $dt['COM']);

        return $this->db
                        ->from('POSISI_KEUANGAN PK')
                        ->join("M_BANK MB", "PK.RACCT = '00' || MB.HKONT")
                        ->where('RWCUR', $dt['CUR'])
                        ->get()
                        ->result_array()

        ;
    }

    public function get_data_bank2($dt, $distinct = FALSE) {
        $stt = date('Y-m-d 00:00:00', strtotime($dt['STT']));
        $end = date('Y-m-d 23:59:59', strtotime($dt['END']));

        if ($distinct)
            $this->db->select('DISTINCT(RACCT)');
        elseif (!$distinct && !empty($dt['BANK']))
            $this->db->where_in('RACCT', $dt['BANK']);

        if ($dt['COM'] != 'ALL')
            $this->db->where('RBUKRS', $dt['COM']);

        $this->db
                ->from('POSISI_KEUANGAN')
                ->where("BUDAT BETWEEN TO_DATE('$stt', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$end', 'YYYY-MM-DD HH24:MI:SS')")
                ->where_in('BLART', array('DZ', 'SB', 'KZ', 'SAWAL', 'SAKIR'))
                ->where('RWCUR', $dt['CUR'])
                ->get()
                ->result_array();
        echo $this->db->last_query();
        exit

        ;
    }

    public function get_data_bank_v2($dt) {
        $stt = date('Y-m-d 00:00:00', strtotime($dt['STT']));
        $end = date('Y-m-d 23:59:59', strtotime($dt['END']));

        if (!empty($dt['BANK']))
            $this->db->where_in('RACCT', $dt['BANK']);

        if ($dt['COM'] != 'ALL')
            $this->db->where('RBUKRS', $dt['COM']);

        return $this->db
                        ->select('BUDAT, RACCT, BLART, SUM(HSL) AS AMOUNT')
                        ->from('POSISI_KEUANGAN')
                        ->where("BUDAT BETWEEN TO_DATE('$stt', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$end', 'YYYY-MM-DD HH24:MI:SS')")
                        ->where_in('BLART', array('DZ', 'SB', 'KZ', 'SAWAL', 'SAKIR'))
                        ->where('RWCUR', $dt['CUR'])
                        ->group_by(array('BUDAT', 'RACCT', 'BLART'))
                        ->get()
                        ->result_array()

        ;
    }

    public function get_sum_hsl_bank_t1($comp, $date, $cur) {
        $ret = $this->db->query("

			SELECT
				NVL(SUM(HSL)*100,0) AS SUM
			FROM
				M_BANK
			LEFT JOIN
			(
				SELECT RACCT, RBUKRS, SUM(HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS = '$comp'
				AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RWCUR = '$cur'
				GROUP BY RACCT, RBUKRS
			) ON HKONT = SUBSTR(RACCT,3)
			WHERE BUKRS = '$comp'
			ORDER BY HKONT

		")->result_array();

        return $ret[0]['SUM'];
        echoq($this)

        ;
    }

    public function get_sum_hsl_bank_t2($date, $comp, $cur, $sum = FALSE, $count = FALSE, $sum_finance = FALSE, $type = "", $group = "") {
        $all = $cur == 'ALL' ? TRUE : FALSE;

        if ($sum)
            $select = 'NVL(SUM(SUM), 0) AS SUM';
        if ($sum_finance)
            $select = 'NVL(SUM(SUM_FINANCE), 0) AS SUM';
        elseif ($count)
            $select = 'COUNT(*) AS SUM';
        else
            $select = '*';

        #DO NOT GROUPBY WITH RWCUR IF ALL
        $w_cur = $all ? "" : "AND RWCUR = '$cur'";
        $w_cur1 = $all ? "" : "AND WAERS = '$cur'";
        $w_cur2 = $all ? "" : ", RWCUR";
        $w_cur3 = $all ? ", 'IDR' AS RWCUR" : "";
        $w_cur4 = $all ? "GROUP BY HKONT, TEXT1, HSL, AMOUNT" : "";
        $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0) AS SUM, NVL(AMOUNT,0)";

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $filter_group = "";
        $comp2 = $comp;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
            $comp = "7KSO";
            if ($group == "") {
                $item = "GROUP_BANK AS REK, '' AS TEXT1, NVL(SUM(HSL)*100,0) AS SUM, NVL(SUM(AMOUNT),0)";
                $w_cur4 = "GROUP BY GROUP_BANK$w_cur2";
            } else {
                $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0) AS SUM, NVL(AMOUNT,0)";
                $w_cur4 = "GROUP BY HKONT, TEXT1, HSL$w_cur2";
                $filter_group = "AND GROUP_BANK = '$group'";
            }
        } else if ($comp2 == 'BU-SI') {
            $comp2 = "2000','7000";
        }

        //FILTER BY TIPE
        IF ($type == "GIRO") {
            $filter_type = "AND TYPE_BANK = 'GIRO'";
        } ELSE IF ($type == "DEPO") {
            $filter_type = "AND TYPE_BANK = 'DEPOSITO'";
        } ELSE {
            $filter_type = "";
        }

        $ret = $this->db->query("
            SELECT $select FROM (
                SELECT
                    $item AS SUM_FINANCE$w_cur3
                FROM
                    M_BANK
                LEFT JOIN
                (
                    SELECT RACCT, SUM(HSL) AS HSL$w_cur2
                    FROM POSISI_KEUANGAN
                    WHERE RBUKRS IN ('$comp2')
                    $w_cur
                    AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                    GROUP BY RACCT$w_cur2
                ) ON HKONT = SUBSTR(RACCT,3)
                                LEFT JOIN (
                                    SELECT
                                        GL_ACCOUNT,
                                        SUM (AMOUNT) AS AMOUNT$w_cur2
                                    FROM
                                        POSISI_KEUANGAN_FINANCE
                                    WHERE
                                        COMPANY IN ('$comp2')
                                    $w_cur
                                    AND BUDAT =
                                    (
                                        SELECT MAX(BUDAT) FROM POSISI_KEUANGAN_FINANCE
                                        WHERE BUDAT <= '$date'
                                    )
                                    GROUP BY GL_ACCOUNT$w_cur2
                                ) ON HKONT = GL_ACCOUNT
                WHERE BUKRS = '$comp'
                                $filter_type
                                $filter_group
                $w_cur1
                $w_cur4
            )
            WHERE SUM != 0
            ORDER BY SUM DESC
        ")->result_array();

        return $sum || $count || $sum_finance ? $ret[0]['SUM'] : $ret;
        echoq($this);
    }

    public function get_sum_hsl_bank_t2_holding($date, $comp, $cur, $sum = FALSE, $count = FALSE, $sum_finance = FALSE, $type = "", $group = "") {
        $all = $cur == 'ALL' ? TRUE : FALSE;

        if ($sum)
            $select = 'NVL(SUM(SUM), 0) AS SUM';
        if ($sum_finance)
            $select = 'NVL(SUM(SUM_FINANCE), 0) AS SUM';
        elseif ($count)
            $select = 'COUNT(*) AS SUM';
        else
            $select = '*';

        #DO NOT GROUPBY WITH RWCUR IF ALL
        $w_cur = $all ? "" : "AND RWCUR = '$cur'";
        $w_cur1 = $all ? "" : "AND WAERS = '$cur'";
        $w_cur2 = $all ? "" : ", RWCUR";
        $w_cur3 = $all ? ", 'IDR' AS RWCUR" : "";
        $w_cur4 = $all ? "GROUP BY BUKRS, HKONT, TEXT1, HSL, AMOUNT" : "";
        $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0) AS SUM, NVL(AMOUNT,0)";

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $filter_group = "";
        $comp2 = $comp;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
            $comp = "7KSO";
            if ($group == "") {
                $item = "GROUP_BANK AS REK, '' AS TEXT1, NVL(SUM(HSL)*100,0) AS SUM, NVL(SUM(AMOUNT),0)";
                $w_cur4 = "GROUP BY BUKRS, GROUP_BANK$w_cur2";
            } else {
                $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0) AS SUM, NVL(AMOUNT,0)";
                $w_cur4 = "GROUP BY BUKRS, HKONT, TEXT1, HSL$w_cur2";
                $filter_group = "AND GROUP_BANK = '$group'";
            }
        } else if ($comp2 == 'BU-SI') {
            $comp2 = "2000','7000";
        } else if ($comp == "1000") {
            $comp = "2000','3000','4000','5000','7000";
            $comp2 = "2000','3000','4000','5000','7000";
        }

        //FILTER BY TIPE
        IF ($type == "GIRO") {
            $filter_type = "AND TYPE_BANK = 'GIRO'";
        } ELSE IF ($type == "DEPO") {
            $filter_type = "AND TYPE_BANK = 'DEPOSITO'";
        } ELSE {
            $filter_type = "";
        }

        $ret = $this->db->query("
			SELECT $select FROM (
				SELECT
					BUKRS AS COMPANY, $item AS SUM_FINANCE$w_cur2$w_cur3
				FROM
					M_BANK
				LEFT JOIN
				(
					SELECT RBUKRS, RACCT, SUM(HSL) AS HSL$w_cur2
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$comp2')
					$w_cur
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					GROUP BY RBUKRS, RACCT$w_cur2
				) ON HKONT = SUBSTR(RACCT,3) AND BUKRS = RBUKRS
                                LEFT JOIN (
                                    SELECT
                                        COMPANY,
                                        GL_ACCOUNT,
                                        SUM (AMOUNT) AS AMOUNT$w_cur2
                                    FROM
                                        POSISI_KEUANGAN_FINANCE
                                    WHERE
                                        COMPANY IN ('$comp2')
                                    $w_cur
                                    AND BUDAT = '$date'
                                    GROUP BY COMPANY, GL_ACCOUNT$w_cur2
                                ) ON HKONT = GL_ACCOUNT AND BUKRS = COMPANY
				WHERE BUKRS IN ('$comp')
                                $filter_type
                                $filter_group
				$w_cur1
				$w_cur4
			)
			WHERE SUM != 0
			ORDER BY COMPANY, SUM DESC
		")->result_array();

        return $sum || $count || $sum_finance ? $ret : $ret;
        echoq($this);
    }

    public function get_sum_tipe_bank_t2($date, $comp, $cur, $type = "", $group = "", $hkont = "") {
        $all = $cur == 'ALL' ? TRUE : FALSE;

        #DO NOT GROUPBY WITH RWCUR IF ALL
        $w_cur = $all ? "" : "AND RWCUR = '$cur'";
        $w_cur1 = $all ? "" : "AND WAERS = '$cur'";
        $w_cur2 = $all ? "" : ", RWCUR";
        $w_cur3 = $all ? ", 'IDR' AS RWCUR" : "";
        $w_cur4 = $all ? "GROUP BY HKONT, TEXT1, HSL" : "";
        $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0)";

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $filter_hkont = "";
        $comp2 = $comp;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
            $comp = "7KSO";
            if ($hkont == "") {
                $item = "GROUP_BANK, NVL(SUM(HSL)*100,0)";
                $w_cur4 = "GROUP BY GROUP_BANK$w_cur2";
            } else {
                $item = "HKONT AS REK, TEXT1, NVL(HSL*100,0)";
                $w_cur4 = "GROUP BY HKONT, TEXT1, HSL$w_cur2";
                $filter_hkont = "AND HKONT = '$hkont'";
            }
        }

        //FILTER BY TIPE
        IF ($type == "GIRO") {
            $filter_type = "AND TYPE_BANK = 'GIRO'";
        } ELSE IF ($type == "DEPO") {
            $filter_type = "AND TYPE_BANK = 'DEPOSITO'";
        } ELSE {
            $filter_type = "";
        }

        //GROUP TIPE BANK
        $filter_group = "";
        IF ($group != "") {
            $filter_group = "AND GROUP_BANK = '$group'";
        }

        $ret = $this->db->query("
			SELECT NVL(SUM(SUM), 0) AS SUM FROM (
				SELECT
					$item AS SUM$w_cur2$w_cur3
				FROM
					M_BANK
				LEFT JOIN
				(
					SELECT RACCT, SUM(HSL) AS HSL$w_cur2
					FROM POSISI_KEUANGAN
					WHERE RBUKRS IN ('$comp2')
					$w_cur
					AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
					GROUP BY RACCT$w_cur2
				) ON HKONT = SUBSTR(RACCT,3)
				WHERE BUKRS = '$comp'
                                $filter_type
                                $filter_group
                                $filter_hkont
				$w_cur1
				$w_cur4
			)
			WHERE SUM != 0
			ORDER BY SUM DESC
		")->result_array();

        return $ret[0]['SUM'];
    }

    public function get_sum_hsl_bank_t3($date, $gl, $comp, $cur) {

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = $comp;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
        } else if ($comp2 == 'BU-SI') {
            $comp2 = "2000','7000";
        }

        return $this->db->query("

			SELECT AA.TEXT, SUM(NVL(BB.HSL*100,0)) AS SUM FROM (
				SELECT 'SALDO AWAL' AS TEXT FROM DUAL UNION ALL
				SELECT 'DEBIT' AS TEXT FROM DUAL UNION ALL
				SELECT 'KREDIT' AS TEXT FROM DUAL
			) AA LEFT JOIN (
				SELECT 'SALDO AWAL' AS TEXT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT <= TO_DATE ('" . date('Y-m-d', strtotime('-1 days', strtotime($date))) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				GROUP BY RACCT, RBUKRS

				UNION ALL
				SELECT 'DEBIT' AS TEXT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT BETWEEN TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				AND DRCRK = 'S'
				GROUP BY RACCT, RBUKRS

				UNION ALL
				SELECT 'KREDIT' AS TEXT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT BETWEEN TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				AND DRCRK = 'H'
				GROUP BY RACCT, RBUKRS
			) BB ON AA.TEXT = BB.TEXT
                        GROUP BY AA.TEXT

		")->result_array();
    }

    public function get_sum_hsl_bank_t3_kso($date, $gl, $comp, $cur, $jenis = "", $tipe = "") {

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = $comp;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
            $comp = '7KSO';
        }

        $ret = $this->db->query("

			SELECT NVL(SUM(BB.HSL)*100,0) AS SUM FROM (
				SELECT 'SALDO AWAL' AS TEXT FROM DUAL UNION ALL
				SELECT 'DEBIT' AS TEXT FROM DUAL UNION ALL
				SELECT 'KREDIT' AS TEXT FROM DUAL
			) AA LEFT JOIN (
                            SELECT AA.TEXT, AA.RACCT, BB.TYPE_BANK, SUM(AA.HSL) AS HSL FROM (
				SELECT 'SALDO AWAL' AS TEXT, RACCT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT <= TO_DATE ('" . date('Y-m-d', strtotime('-1 days', strtotime($date))) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				GROUP BY RACCT, RBUKRS

				UNION ALL
				SELECT 'DEBIT' AS TEXT, RACCT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT BETWEEN TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				AND DRCRK = 'S'
				GROUP BY RACCT, RBUKRS

				UNION ALL
				SELECT 'KREDIT' AS TEXT, RACCT, SUM (HSL) AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RWCUR = '$cur'
				AND BUDAT BETWEEN TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE ('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				AND RACCT = '00$gl'
				AND DRCRK = 'H'
				GROUP BY RACCT, RBUKRS
                            ) AA
                            JOIN M_BANK BB ON SUBSTR(AA.RACCT,3) = BB.HKONT
                            WHERE BB.BUKRS = '$comp'
                            GROUP BY AA.TEXT, AA.RACCT, BB.TYPE_BANK
			) BB ON AA.TEXT = BB.TEXT
                        WHERE AA.TEXT = '$jenis'
                        AND BB.TYPE_BANK = '$tipe'

		")->result_array();

        return $ret[0]['SUM'];
    }

    public function get_data_by_rek_group_cur_t3($com, $gl, $date, $count = FALSE) {
        if ($count)
            $sel = 'COUNT(*) AS JML';
        else
            $sel = '*';

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = $com;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
        } else if ($comp2 == 'BU-SI') {
            $comp2 = "2000','7000";
        }

        $ret = $this->db->query("

			SELECT $sel FROM (
				SELECT RWCUR, SUM(HSL)*100 AS HSL
				FROM POSISI_KEUANGAN
				WHERE RBUKRS IN ('$comp2')
				AND RACCT = '00$gl'
				AND BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
				GROUP BY RWCUR
				ORDER BY RWCUR
			)
                        WHERE HSL != 0

		")->result_array();
        return $count ? $ret[0]['JML'] : $ret;
    }

    public function get_data_by_bank_group_cur_t3($com, $group, $date, $count = FALSE, $racct = "") {
        if ($count)
            $sel = 'COUNT(*) AS JML';
        else
            $sel = '*';

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = $com;
        if ($comp2 == 'KSO') {
            $comp2 = "7000','7KSO";
        } else if ($comp2 == 'BU-SI') {
            $comp2 = "2000','7000";
        }

        $filter_racct = "";
        $select = "AA.RACCT";
        $group_by = "GROUP BY AA.RACCT
                    ORDER BY AA.RACCT";
        if ($racct != "") {
            $filter_racct = "AND BB.HKONT = '$racct'";
            $select = "AA.RWCUR";
            $group_by = "GROUP BY AA.RWCUR
                    ORDER BY AA.RWCUR";
        }

        $ret = $this->db->query("

			SELECT $sel FROM (
				SELECT $select, SUM(AA.HSL)*100 AS HSL
				FROM POSISI_KEUANGAN AA
                                JOIN M_BANK BB ON BB.HKONT = SUBSTR(AA.RACCT,3)
				WHERE AA.RBUKRS IN ('$comp2')
				AND BB.GROUP_BANK = '$group'
                                $filter_racct
				AND AA.BUDAT <= TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                $group_by
			)
                        WHERE HSL != 0

		")->result_array();
        return $count ? $ret[0]['JML'] : $ret;
    }

    public function get_sum_hsl_bank_t4($date, $com, $gl, $deb_kre, $cur, $count = FALSE) {
        if ($deb_kre == 'DEBIT')
            $drcrk = 'S';
        elseif ($deb_kre == 'KREDIT')
            $drcrk = 'H';
        else
            $drcrk = '';

        if ($count)
            $this->db->select('COUNT(*) AS COUNT');
        else
            $this->db->select('DOCNR, (HSL*100) AS HSL, TSL, SGTXT');

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = array($com);
        if ($com == 'KSO') {
            $comp2 = array("7000", "7KSO");
        } else if ($com == 'BU-SI') {
            $comp2 = array("2000", "7000");
        }

        $ret = $this->db
                ->from('POSISI_KEUANGAN')
                ->where("BUDAT BETWEEN TO_DATE('" . date('Y-m-d', strtotime($date)) . " 00:00:00', 'YYYY-MM-DD HH24:MI:SS')AND TO_DATE('" . date('Y-m-d', strtotime($date)) . " 23:59:59', 'YYYY-MM-DD HH24:MI:SS')")
                ->where_in('RBUKRS', $comp2)
                ->where('RWCUR', $cur)
                ->where('RACCT', '00' . $gl)
                ->where('DRCRK', $drcrk)
                ->order_by('HSL DESC')
                ->get()
                ->result_array();

        return $count ? $ret[0]['COUNT'] : $ret

        ;
    }

    public function get_sum_hsl_bank_t4_kso($date, $com, $gl, $deb_kre, $cur, $bank_tipe = "", $docnr) {
        if ($deb_kre == 'DEBIT')
            $drcrk = 'S';
        elseif ($deb_kre == 'KREDIT')
            $drcrk = 'H';
        else
            $drcrk = '';

        //PENAMBAHAN KELOMPOK COMPANY BARU
        $comp2 = $com;
        if ($com == 'KSO') {
            $comp2 = "7000', '7KSO";
        } else if ($com == 'BU-SI') {
            $comp2 = "2000', '7000";
        }

        $filter_tipe = "";
        $filter_cur = "";
        if ($bank_tipe != '') {
            $filter_tipe = "AND BB.TYPE_BANK = '$bank_tipe'";
        }

        if ($cur != "ALL") {
            $filter_cur = "AND AA.RWCUR = '$cur'";
        }

        $ret = $this->db->query("SELECT
                    (AA.HSL * 100) AS HSL
                FROM
                    POSISI_KEUANGAN AA
                    JOIN M_BANK BB ON SUBSTR(AA.RACCT,3) = BB.HKONT
                    AND BB.BUKRS = '7KSO'
                WHERE
                    AA.BUDAT BETWEEN TO_DATE (
                        '" . date('Y-m-d', strtotime($date)) . " 00:00:00',
                        'YYYY-MM-DD HH24:MI:SS'
                    )
                AND TO_DATE (
                    '" . date('Y-m-d', strtotime($date)) . " 23:59:59',
                    'YYYY-MM-DD HH24:MI:SS'
                )
                AND AA.RBUKRS IN ('$comp2')
                $filter_cur
                AND AA.RACCT = '00$gl'
                AND AA.DRCRK = '$drcrk'
                AND AA.DOCNR = '$docnr'
                $filter_tipe
                ORDER BY
                        AA.HSL DESC")->result_array();

        $value = 0;
        IF (ISSET($ret[0]['HSL'])) {
            $value = $ret[0]['HSL'];
        }

        return $value;
    }

    public function get_count_bank($comp) {
        $ret = $this->db
                ->select('COUNT(*) AS SUM')
                ->from('M_BANK')
                ->where('BUKRS', $comp)
                ->get()
                ->result_array();

        return $ret[0]['SUM']

        ;
    }

    public function get_data_hutang($com, $cur, $date, $sum = FALSE, $count = FALSE) {
        /*
          if($sum) $this->db->select('-NVL(SUM(DMBTR)*100, 0) AS SUM');
          elseif($count) $this->db->select('COUNT(*) AS SUM');
          else $this->db->select('DATECOL, DEFAULT_DUE_DATE, LIFNR, BELNR, -(DMBTR) AS DMBTR');

          $ret = $this->db
          ->from('ZCFI3015')
          ->where('BUKRS', $com)
          ->where('WAERS', $cur)
          ->where('DEFAULT_DUE_DATE <=', $date)
          ->order_by('DEFAULT_DUE_DATE')
          ->get()
          ->result_array();

          return $sum || $count ? $ret[0]['SUM'] : $ret;
         */

        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }

        if ($sum) {
            $select = 'NVL(SUM(DMBTR)*100, 0) AS SUM';
            $order = '';
        } elseif ($count) {
            $select = 'COUNT(*) AS SUM';
            $order = '';
        } else {
            $select = '*';
            $order = 'ORDER BY DEFAULT_DUE_DATE';
        }

        if ($com == 'KSO') {
            $com = "7000', '7KSO";
        } else if ($com == 'BU-SI') {
            $com = "7000";
        }

        $w_cur = $cur != 'ALL' ? "AND A.WAERS = '$cur'" : "";
        $w2_cur = $cur != 'ALL' ? "AND WAERS = '$cur'" : "";

        $ret = $this->db->query("
			SELECT $select FROM (
				SELECT
					A.BUKRS,
					A.WAERS,
					A.DATECOL,
					CASE
						WHEN B.DEFAULT_DUE_DATE IS NOT NULL
						THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END
						AS DEFAULT_DUE_DATE,
					A.LIFNR,
					A.BELNR, -(A.DMBTR) AS DMBTR,
                                        A.TBAYAR
				FROM
					ZCFI3015 A
				LEFT JOIN
					ZCFI3015_COMPARE B
				ON A.BUKRS = B.BUKRS
				AND A.BELNR = B.BELNR

				WHERE A.BUKRS IN ('$com')
				$w_cur
				AND A.DEFAULT_DUE_DATE $operator '$date'

				OR A.BUKRS IN ('$com')
				$w_cur
				AND B.DEFAULT_DUE_DATE $operator '$date'

				$order
			) WHERE BUKRS IN ('$com')
				$w2_cur
				AND DEFAULT_DUE_DATE $operator '$date'
				ORDER BY DMBTR
		")->result_array();
        //echo $this->db->last_query()."\n\n";
        return $sum || $count ? $ret[0]['SUM'] : $ret

        ;
    }

    public function get_data_payment($dt, $sum = FALSE) {
        $stt = date('Ymd', strtotime("-30 days", strtotime($dt['STT'])));
        $end = date('Ymd', strtotime("-30 days", strtotime($dt['END'])));

        if ($sum)
            $this->db->select('DATECOL, DEFAULT_DUE_DATE, SUM(DMBTR) AS AMOUNT')->group_by(array('DATECOL', 'DEFAULT_DUE_DATE'))->order_by('DATECOL');
        else
            $this->db->select('DATECOL, BELNR, BIL_NO, LIFNR AS NUMBER, NAME1 AS DESC, DMBTR AS AMOUNT, DEFAULT_DUE_DATE');

        if ($dt['COM'] != 'ALL')
            $this->db->where('BUKRS', $dt['COM']);

        return $this->db
                        ->from('ZCFI3015')
                        ->where("DATECOL BETWEEN $stt AND $end")
                        ->where('WAERS', $dt['CUR'])
                        ->get()
                        ->result_array()

        ;
    }

    public function get_data_piutang($com, $cur, $date, $sum = FALSE, $count = FALSE) {
        $tgl_now = date("Ymd");
        if ($tgl_now == $date) {
            $operator = "<=";
        } else {
            $operator = "=";
        }
        if ($sum)
            $this->db->select('SUM(AMOUNT_LCL_2) AS SUM');
        elseif ($count)
            $this->db->select('COUNT(*) AS SUM');
        else
            $this->db->select('ACCOUNTING_DOCUMENT_NUMBER, ITEM_TEXT, AMOUNT_LCL_2, CURRENCY_KEY, NET_DUE_DATE');

        if ($cur != 'ALL')
            $this->db->where('CURRENCY_KEY', $cur);

        $param_com = array($com);
        if ($com == 'KSO') {
            $param_com = array('7000', '7KSO');
        }
        $ret = $this->db
                ->from('ZCFI0015')
                ->where_in('COMPANY', $param_com)
                ->where("NET_DUE_DATE $operator '$date'")
                ->order_by('AMOUNT_LCL_2 DESC')
                ->get()
                ->result_array();

        return $sum || $count ? $ret[0]['SUM'] : $ret;
    }

    public function get_data_receive($dt, $sum = FALSE) {
        $stt = $dt['STT'];
        $end = $dt['END'];

        if ($dt['COM'] != 'ALL')
            $this->db->where('COMPANY', $dt['COM']);

        if ($sum)
            $this->db->select('NET_DUE_DATE, NVL(SUM(AMOUNT_LCL_2),0) AS AMOUNT')->group_by('NET_DUE_DATE')->order_by('NET_DUE_DATE');
        else
            $this->db->select('NET_DUE_DATE, ACCOUNTING_DOCUMENT_NUMBER AS NUMBER, ITEM_TEXT AS DESC, AMOUNT_LCL_2 AS AMOUNT');

        return $this->db
                        ->from('ZCFI0015')
                        ->where("NET_DUE_DATE BETWEEN $stt AND $end")
                        ->where('CURRENCY_KEY', $dt['CUR'])
                        ->get()
                        ->result_array()

        ;
    }

    public function get_company() {
        return $this->db->query('SELECT DISTINCT CURR FROM ( SELECT DISTINCT WAERS AS CURR FROM ZCFI3015 UNION ALL SELECT DISTINCT CURRENCY_KEY AS CURR  FROM ZCFI0015 UNION ALL SELECT DISTINCT RWCUR AS CURR  FROM POSISI_KEUANGAN ) ')->result_array()

        ;
    }

    public function get_company_real($detail = FALSE, $holding = FALSE) {

        if ($detail)
            $this->db->where('COMPANY', $detail);

        if (!$holding)
            $this->db->where('COMPANY!=', '1000');

        $parent = array('GCEMENT', 'GCEMENT2');
        return $this->db
                        ->select('COMPANY, DESCRIPTION')
                        ->from('M_COMPANY')
                        ->where_in('PARENTH2', $parent)
                        ->order_by('COMPANY')
                        ->get()
                        ->result_array();
        echoq($this)

        ;
    }

    public function get_company2() {
        $where = null;
        if ($_SESSION['status'] != 'ADMIN') {
            $comp = array_filter(explode(",", $_SESSION['company_hris'] . "," . $_SESSION['company_bpc']));
            $tmp = null;
            foreach ($comp as $k => $v) {
                $cmp = $tmp . "'$v',";
                $tmp = $cmp;
            }
            $comp_all = substr($cmp, 0, -1);
            $where = "AND COMPANY IN ($comp_all)";
        }
        return $this->db->query("SELECT COMPANY, DESCRIPTION FROM M_COMPANY
                                    WHERE PARENTH2 = 'GCEMENT'
                                $where
                                ORDER BY COMPANY")->result();
    }

    public function get_desc_vendor($lifnr) {
        $ret = $this->db
                ->select('NAME1')
                ->from('M_VENDOR')
                ->where('LIFNR', intval($lifnr))
                ->get()
                ->result_array();

        return $ret ? $ret[0]['NAME1'] : '-'

        ;
    }

    public function get_info_bank($dt) {
        $ret = $this->db
                ->select('TEXT1')
                ->from('M_BANK')
                ->where('HKONT', $dt)
                ->get()
                ->result_array();

        return isset($ret[0]['TEXT1']) ? $ret[0]['TEXT1'] : FALSE

        ;
    }

    public function get_exc_rate($fcurr, $tcurr, $date) {
        $ret = $this->db->query("
		SELECT UKURS, GDATU FROM (
			SELECT *
			FROM M_EXCHANGE_RATE
			WHERE FCURR = '$fcurr'
			AND TCURR = '$tcurr'
			AND GDATU <= '$date'
			ORDER BY GDATU DESC
		) WHERE ROWNUM = 1
		")->result_array();

        return $ret[0];
    }

    public function get_bank($comp, $curr, $start_date, $end_date) {

        if ($comp == 'KSO') {
            $comp = "7000', '7KSO";
        } else if ($comp == 'BU-SI') {
            $comp = "7000";
        }

        $filter_cur = $filter_cur2 = "";
        if ($curr != "ALL") {
            $filter_cur = "AND RWCUR = '$curr'";
            $filter_cur2 = "AND WAERS = '$curr'";
        } else {
            $curr = 'IDR';
        }

        $date = $this->dateRange($start_date, $end_date);

        $query = "";
        foreach ($date as $v) {
            $query = $query . " SELECT * FROM (
                        SELECT
                            '$v' AS TANGGAL,
                            HKONT AS REK,
                            TEXT1,
                            NVL (HSL * 100, 0) AS SUM,
                            '$curr' AS RWCUR
                        FROM
                            M_BANK
                        LEFT JOIN (
                            SELECT
                                RACCT,
                                SUM (HSL) AS HSL
                            FROM
                                POSISI_KEUANGAN
                            WHERE
                                RBUKRS IN ('$comp')
                            AND BUDAT <= TO_DATE (
                                '$v 23:59:59',
                                'YYYYMMDD HH24:MI:SS'
                            )
                            $filter_cur
                            GROUP BY
                                RACCT
                        ) ON HKONT = SUBSTR (RACCT, 3)
                        WHERE
                            BUKRS = '$comp'
                        $filter_cur2
                        GROUP BY
                            HKONT,
                            TEXT1,
                            HSL )
                    WHERE SUM != 0
                    UNION ALL";
        }
        $query = rtrim($query, "UNION ALL");

        return $this->db->query("SELECT * FROM ($query) ORDER BY TANGGAL, SUM DESC")->result();
    }

    public function get_hutang($comp, $curr, $start_date, $end_date) {
        $query = "";
        $tgl_now = date("Ymd");
        $w2_cur = $curr != 'ALL' ? "AND WAERS = '$curr'" : "";
        if ($comp == 'KSO') {
            $comp = "7000', '7KSO";
        } else if ($comp == 'BU-SI') {
            $comp = "7000";
        }

        $date = $this->dateRange($start_date, $end_date);

        foreach ($date as $v) {

            if ($tgl_now == $v) {
                $operator = "<=";
            } else {
                $operator = "=";
            }

            $query = $query . "SELECT * FROM (
				SELECT
					A.BUKRS,
                                        AA.NAME1,
					A.WAERS,
					A.DATECOL,
					CASE
						WHEN B.DEFAULT_DUE_DATE IS NOT NULL
						THEN B.DEFAULT_DUE_DATE ELSE A.DEFAULT_DUE_DATE END
						AS DEFAULT_DUE_DATE,
					A.LIFNR,
					A.BELNR, (-(A.DMBTR)*100) AS DMBTR
				FROM
					ZCFI3015 A
				LEFT JOIN
					ZCFI3015_COMPARE B
				ON A.BUKRS = B.BUKRS
				AND A.BELNR = B.BELNR
                                LEFT JOIN M_VENDOR AA
                                ON A.LIFNR = TO_NUMBER(AA.LIFNR)
                                AND A.BUKRS = AA.BUKRS
				WHERE A.BUKRS IN ('$comp')

				AND A.DEFAULT_DUE_DATE $operator '$v'

				OR A.BUKRS IN ('$comp')

				AND B.DEFAULT_DUE_DATE $operator '$v'
			) WHERE BUKRS IN ('$comp')
                                $w2_cur
				AND DEFAULT_DUE_DATE $operator '$v'
				UNION ALL ";
        }

        $query2 = rtrim($query, "UNION ALL ");

        return $this->db->query("SELECT * FROM ($query2) ORDER BY DEFAULT_DUE_DATE, DMBTR DESC")->result();
    }

    public function get_piutang($comp, $curr, $start_date, $end_date) {
        $query = "";
        $tgl_now = date("Ymd");
        $w2_cur = $curr != 'ALL' ? "AND WAERS = '$curr'" : "";
        if ($comp == 'KSO') {
            $comp = "7000', '7KSO";
        } else if ($comp == 'BU-SI') {
            $comp = "7000";
        }

        $date = $this->dateRange($start_date, $end_date);

        foreach ($date as $v) {

            if ($tgl_now == $v) {
                $operator = "<=";
            } else {
                $operator = "=";
            }

            $query = $query . "SELECT
                                    A.DOCUMENT_DATE,
                                    A.NET_DUE_DATE,
                                    A.ACCOUNTING_DOCUMENT_NUMBER,
                                    A.ITEM_TEXT,
                                    A.AMOUNT_LCL_2,
                                    A.CURRENCY_KEY
                                FROM
                                    ZCFI0015 A
				WHERE A.COMPANY IN ('$comp')
				AND A.NET_DUE_DATE $operator '$v'
				UNION ALL ";
        }

        $query2 = rtrim($query, "UNION ALL ");

        return $this->db->query("SELECT * FROM ($query2) ORDER BY AMOUNT_LCL_2 DESC")->result();
    }

    public function get_holiday($date) {
        $temp = "";
        foreach ($date as $key => $value) {
            $value2 = substr_replace(substr_replace($value, '-', 4, 0), '-', 7, 0);
            $temp = $temp . "'" . $value2 . "',";
        }
        $tanggal = rtrim($temp, ",");
        $ret = $this->db->query("
          SELECT TANGGAL FROM M_HOLIDAY WHERE TANGGAL IN ($tanggal)
          ")->result_array();

        return $ret;
    }

    function dateRange($first, $last, $step = '+1 day', $format = 'Ymd') {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    function cek_exist($data) {
        $query = "SELECT COUNT(*) AS CEK FROM POSISI_KEUANGAN_FINANCE "
                . "WHERE COMPANY = '" . $data['COMPANY'] . "' "
                . "AND GL_ACCOUNT = '" . $data['GL_ACCOUNT'] . "' "
                . "AND BUDAT = '" . $data['BUDAT'] . "' "
                . "AND RWCUR = '" . $data['RWCUR'] . "' ";

        $ret = $this->db->query($query)->result_array();

        return $ret[0]['CEK'];
    }

    public function insert_bank_finance($dt) {
        $insert = $this->db->set('CREATE_DATE', 'SYSDATE', false)
                ->set('LAST_UPDATE', 'SYSDATE', false)
                ->insert('POSISI_KEUANGAN_FINANCE', $dt);

        return $insert ? TRUE : FALSE;
    }

    public function update_bank_finance($dt, $cond) {

        $update = $this->db->set('LAST_UPDATE', 'SYSDATE', false)
                ->update('POSISI_KEUANGAN_FINANCE', $dt, $cond);

        return $update ? TRUE : FALSE;
    }

}
