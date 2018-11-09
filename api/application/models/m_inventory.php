<?php
class m_inventory extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function get_total_po($seldate, $comp){
        $sql = "SELECT Count(*) As total_po FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BUKRS IN ('$comp')";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_total_pr($seldate, $plant){
        $comp = substr($plant, 0, 1);
        $sql = "SELECT Count(*) As total_pr FROM TB_EBAN_TRACKING WHERE WERKS LIKE '$comp%' AND BADAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_total_poval($seldate, $comp){
        $sql = "SELECT SUM(BRTWR) As total_poval FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BUKRS IN ('$comp')";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_total_pobar($seldate, $pobar){
        $sql = "SELECT SUM(BRTWR) As total_pobar FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BSART IN ($pobar)";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_total_pojas($seldate, $pobah){
        $sql = "SELECT SUM(BRTWR) As total_pojas FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BSART IN ($pobah)";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_total_pobah($seldate, $pojas){
        $sql = "SELECT SUM(BRTWR) As total_pobah FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BSART IN ($pojas)";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_invest_pr($seldate, $doctype){
        $sql = "SELECT COUNT(*) AS TOTAL_INVEST_PR FROM TB_EBAN_TRACKING INNER JOIN TB_PR_APPROVE ON TB_EBAN_TRACKING.BANFN=TB_PR_APPROVE.BANFN WHERE BSART IN ($doctype) AND BADAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_invest_po($seldate, $doctype){
        $sql = "SELECT COUNT(*) AS TOTAL_INVEST_PO FROM TB_STR_PO INNER JOIN TB_PO_APPROVE ON TB_STR_PO.EBELN=TB_PO_APPROVE.EBELN WHERE BSART IN ($doctype) AND BEDAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_trend_po($year, $comp){
        $sql = "SELECT
                    SUBSTR(BEDAT, 0, 6 ) AS MONTH,
                    COUNT(*) AS TOTAL_PO,
                    SUM(MENGE) AS TOTAL_ITEM
                FROM
                    TB_STR_PO C
                    INNER JOIN TB_PO_APPROVE D ON C.EBELN = D.EBELN
                WHERE
                    BEDAT LIKE '$year%' 
                    AND BUKRS IN ('$comp')
                GROUP BY
                    SUBSTR( BEDAT, 0, 6 )
                ORDER BY
                    MONTH";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    // public function get_trend_po($year, $comp){
    //     $sql = "SELECT 
    //                 F.MONTH,
    //                 F.TOTAL_PO,
    //                 B.TOTAL_ITEM
    //             FROM   
    //             (
    //                 SELECT
    //                     SUBSTR( A.BEDAT, 0, 6 ) AS MONTH,
    //                     COUNT( * ) AS TOTAL_PO
    //                 FROM
    //                     TB_STR_PO A 
    //                 WHERE
    //                     A.BEDAT LIKE '$year%' 
    //                     AND A.BUKRS IN ( '$comp' ) 
    //                 GROUP BY
    //                     SUBSTR( A.BEDAT, 0, 6 )
    //                 ORDER BY
    //                     MONTH
    //             ) F 
    //             LEFT JOIN (
    //                 SELECT
    //                     SUBSTR( C.BEDAT, 0, 6 ) AS MONTH,
    //                     SUM(C.MENGE) AS TOTAL_ITEM
    //                 FROM
    //                     TB_STR_PO C
    //                     INNER JOIN TB_PO_APPROVE D ON C.EBELN = D.EBELN
    //                 WHERE
    //                     C.BEDAT LIKE '$year%' 
    //                     AND C.BUKRS IN ( '$comp' )
    //                 GROUP BY
    //                     SUBSTR( C.BEDAT, 0, 6 )
    //                 ORDER BY
    //                     MONTH
    //             ) B ON (F.MONTH=B.MONTH)";
    //     $result = $this->db->query($sql);
    //     return $result->result();
    // }

    public function get_trend_invest($year, $doctypepr, $doctypepo){
        $sql = "SELECT 
                    F.MONTH,
                    F.TOTAL_PR,
                    B.TOTAL_PO
                FROM   
                (
                    SELECT
                        SUBSTR( A.BADAT, 0, 6 ) AS MONTH,
                        COUNT(*) AS TOTAL_PR
                    FROM
                        TB_EBAN_TRACKING A
                        INNER JOIN TB_PR_APPROVE E ON A.BANFN = E.BANFN
                    WHERE
                        A.BADAT LIKE '$year%' 
                        AND A.BSART IN ($doctypepr)
                    GROUP BY
                        SUBSTR( A.BADAT, 0, 6 )
                    ORDER BY
                        MONTH
                ) F 
                LEFT JOIN (
                    SELECT
                        SUBSTR( C.BEDAT, 0, 6 ) AS MONTH,
                        COUNT(*) AS TOTAL_PO
                    FROM
                        TB_STR_PO C
                        INNER JOIN TB_PO_APPROVE D ON C.EBELN = D.EBELN
                    WHERE
                        C.BEDAT LIKE '$year%' 
                        AND C.BSART IN ($doctypepo)
                    GROUP BY
                        SUBSTR( C.BEDAT, 0, 6 )
                    ORDER BY
                        MONTH
                ) B ON (F.MONTH=B.MONTH)";
        $result = $this->db->query($sql);
        return $result->result();
    }
}
 