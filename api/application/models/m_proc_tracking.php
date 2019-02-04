<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class m_proc_tracking extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getData($month, $year)
    {
        $data = array();
        $companies = array(
            '7000',
            '3000',
            '5000',
            '4000',
            '6000'
        );
        foreach ($companies as $company){
            $datacomp = $this->getDataPerCompany($month, $year, $company);
            $data['comp'.$company] = array(
                'company' => $company,
                'data' => $datacomp
            );
        }
        return $data;
    }

    function getDataPerCompany($month, $year, $comp)
    {
        $date = $year.$month;

        if ($comp == '7000') {
            $prbar = "'ZEX1', 'ZST1', 'ZST4', 'ZSK1', 'ZSK2', 'ZIV1', 'ZIVK'";
            $prjas = "'ZPM1', 'ZPMK', 'ZSV1'";
            $pobar = "'ZG01', 'ZG02', 'ZG03', 'ZG04', 'ZG05', 'ZG10', 'ZK01', 'ZK02', 'ZK03', 'ZK04', 'ZK05', 'ZK10'";
            $pobah = "'ZK06', 'ZG08', 'ZG09', 'ZG14', 'ZK06', 'ZK08', 'ZK09', 'ZK14'";
            $pojas = "'ZG07', 'ZK07'";
            $doctypepr = "'ZIV1', 'ZIVK'";
            $doctypepo = "'ZG05'";
        } else if ($comp == '3000') {
            $prbar = "'ZEX2', 'ZKOP', 'ZST2', 'ZPM2', 'ZIV2'";
            $prjas = "'ZSV2'";
            $pobar = "'ZP01', 'ZP02', 'ZP03', 'ZP04', 'ZP05', 'ZP10', 'ZP11', 'ZP12'";
            $pobah = "'ZP06', 'ZP08', 'ZP09'";
            $pojas = "'ZP07'";
            $doctypepr = "'ZIV2'";
            $doctypepo = "'ZP05'";
        } else if ($comp == '4000') {
            $prbar = "'ZST3', 'ZIV3";
            $prjas = "'ZSV3', 'ZPM3', 'ZIV4'";
            $pobar = "'ZT01', 'ZT02', 'ZT03', 'ZT04', 'ZT05', 'ZT10', 'ZT12'";
            $pobah = "'ZT06', 'ZT08', 'ZT09', 'ZT13'";
            $pojas = "'ZT07'";
            $doctypepr = "'ZIV3', 'ZIV4'";
            $doctypepo = "'ZG05'";
        } else if ($comp == '5000') {
            $prbar = "'ZSO1', 'ZSO2', 'ZIVO'";
            $prjas = "'ZPMO'";
            $pobar = "'ZO01', 'ZO02', 'ZO03', 'ZO04', 'ZO05'";
            $pobah = "'ZO06', 'ZO08', 'ZO09', 'ZO14'";
            $pojas = "'ZO07'";
            $doctypepr = "'ZIVO'";
            $doctypepo = "'ZO05'";
        } else if ($comp == '6000') {
            $prbar = "";
            $prjas = "";
            $pobar = "'ZV01', 'ZV02', 'ZV03', 'ZV05'";
            $pobah = "'ZV08', 'ZV09'";
            $pojas = "'ZV07'";
            $doctypepr = "'ZIV9'";
            $doctypepo = "'ZV05'";
        }

        $result['total_pr'] = $this->get_total_pr($date, $comp);
        $result['total_pr_rel'] = $this->get_total_pr($date, $comp);
        $result['total_rfq'] = $this->get_total_rfq($date, $comp);
        $result['total_po'] = $this->get_total_po($date, $comp);
        $result['total_gr'] = $this->get_total_gr($date, $comp);


        $result['total_pr_detail'] = $this->get_total_pr_detail($date, $pobah, $prbar, $prjas);
        $result['total_pr_rel_detail'] = $this->get_total_pr_rel_detail($date, $pobah, $prbar, $prjas);
        $result['total_rfq_detail'] = $this->get_total_rfq_detail($date, $pobah, $pobar, $pojas);
        $result['total_po_detail'] = $this->get_total_po_detail($date, $pobah, $pobar, $pojas);
        $result['total_gr_detail'] = $this->get_total_gr_detail($date, $pobah, $pobar, $pojas);

        $trend_pr_barang = $this->get_trend_pr($year, $prbar);
        $trend_pr_jasa = $this->get_trend_pr($year, $prjas);

        $result['trend_pr']['barang'] = $this->settrend($trend_pr_barang, $year);
        $result['trend_pr']['jasa'] = $this->settrend($trend_pr_jasa, $year);

        $trend_pr_rel_barang = $this->get_trend_pr_rel($year, $prbar);
        $trend_pr_rel_jasa = $this->get_trend_pr_rel($year, $prjas);

        $result['trend_pr_rel']['barang'] = $this->settrend($trend_pr_rel_barang, $year);
        $result['trend_pr_rel']['jasa'] = $this->settrend($trend_pr_rel_jasa, $year);

        $trend_rfq_bahan = $this->get_trend_rfq($year, $pobah);
        $trend_rfq_barang = $this->get_trend_rfq($year, $pobar);
        $trend_rfq_jasa = $this->get_trend_rfq($year, $pojas);

        $result['trend_rfq']['bahan'] = $this->settrend($trend_rfq_bahan, $year);
        $result['trend_rfq']['barang'] = $this->settrend($trend_rfq_barang, $year);
        $result['trend_rfq']['jasa'] = $this->settrend($trend_rfq_jasa, $year);

        $trend_po_bahan = $this->get_trend_po($year, $pobah);
        $trend_po_barang = $this->get_trend_po($year, $pobar);
        $trend_po_jasa = $this->get_trend_po($year, $pojas);

        $result['trend_po']['bahan'] = $this->settrend($trend_po_bahan, $year);
        $result['trend_po']['barang'] = $this->settrend($trend_po_barang, $year);
        $result['trend_po']['jasa'] = $this->settrend($trend_po_jasa, $year);

        $trend_gr_bahan = $this->get_trend_gr($year, $pobah);
        $trend_gr_barang = $this->get_trend_gr($year, $pobar);
        $trend_gr_jasa = $this->get_trend_gr($year, $pojas);

        $result['trend_gr']['bahan'] = $this->settrend($trend_gr_bahan, $year);
        $result['trend_gr']['barang'] = $this->settrend($trend_gr_barang, $year);
        $result['trend_gr']['jasa'] = $this->settrend($trend_gr_jasa, $year);

        return $result;
    }

    function settrend($data, $year) {
        $bln = 1;
        $newtrend = array();
        foreach($data as $value => $k){
            $mnt = (int)subStr($k->MONTH, 4,2);
            if($bln!=$mnt){
                for($i=0;$i<($mnt-$bln);$i++){
                    $ddata = new stdClass();
                    $ddata->MONTH = $year.$i;
                    $ddata->TOTAL = "0";
                    $ddata->VAL = "0";
                    $newtrend[] = $ddata;
                }
            }else{
                $newtrend[] = $k;
            }
            $bln++;
        }
        for($i=$bln ;$i<=12;$i++){
            $ddata = new stdClass();
            $ddata->MONTH = $year.$i;
            $ddata->TOTAL = "0";
            $ddata->VAL = "0";
            $newtrend[] = $ddata;
        }
        return $newtrend;
    }

    function get_total_pr($seldate, $comp){
        $plant = substr($comp,0, 1);
        $sql = "SELECT Count(*) As total_pr, SUM(PREIS) AS total_value FROM TB_EBAN_TRACKING WHERE WERKS LIKE '$plant%' AND BADAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_total_pr_detail($seldate, $pobah, $pobar, $pojas){
        $sql = "SELECT
                    A.total_pr_bahan,
                    A.total_value_bahan,
                    B.total_pr_barang,
                    B.total_value_barang,
                    C.total_pr_jasa,
                    C.total_value_jasa
                FROM(
                    SELECT 'a' as BD, total_pr_bahan, total_value_bahan FROM (
                        SELECT
                                Count( * ) AS total_pr_bahan,
                                SUM(PREIS) AS total_value_bahan 
                        FROM 
                                TB_EBAN_TRACKING
                        WHERE
                                BADAT LIKE '$seldate%' 
                                AND BSART IN ($pobah)
                    )
                ) A
                INNER JOIN (
                        SELECT 'a' as BD, total_pr_barang, total_value_barang FROM (
                            SELECT
                                    Count( * ) AS total_pr_barang,
                                    SUM(PREIS) AS total_value_barang 
                            FROM 
                                    TB_EBAN_TRACKING
                            WHERE
                                    BADAT LIKE '$seldate%' 
                                    AND BSART IN ($pobar)
                        )
                ) B ON B.BD=A.BD
                INNER JOIN (
                        SELECT 'a' as BD, total_pr_jasa, total_value_jasa FROM (
                            SELECT
                                    Count( * ) AS total_pr_jasa,
                                    SUM(PREIS) AS total_value_jasa 
                            FROM 
                                    TB_EBAN_TRACKING
                            WHERE
                                    BADAT LIKE '$seldate%' 
                                    AND BSART IN ($pojas)
                        )
                ) C ON C.BD=B.BD";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_trend_pr($year, $type){
        $sql = "SELECT
                    SUBSTR(BADAT, 0, 6 ) AS month,
                    Count( * ) AS total,
                    SUM(PREIS) AS val 
                FROM 
                    TB_EBAN_TRACKING
                WHERE
                    BADAT LIKE '$year%' 
                    AND BSART IN ($type)
                GROUP BY
                    SUBSTR(BADAT, 0, 6 )
                ORDER BY
                    month";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_total_pr_rel($seldate, $comp){
        $plant = substr($comp, 0, 1);
        $sql = "SELECT COUNT(*) AS total_pr_rel, SUM(PREIS) AS total_value FROM TB_EBAN_TRACKING A INNER JOIN TB_PR_APPROVE B ON A.BANFN=B.BANFN WHERE WERKS LIKE '$plant%' AND BADAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_total_pr_rel_detail($seldate, $pobah, $pobar, $pojas){
        $sql = "SELECT
                    A.total_pr_bahan,
                    A.total_value_bahan,
                    B.total_pr_barang,
                    B.total_value_barang,
                    C.total_pr_jasa,
                    C.total_value_jasa
                FROM(
                    SELECT 'a' as BD, total_pr_bahan, total_value_bahan FROM (
                        SELECT
                                Count( * ) AS total_pr_bahan,
                                SUM(PREIS) AS total_value_bahan 
                        FROM 
                                TB_EBAN_TRACKING D INNER JOIN TB_PR_APPROVE E ON D.BANFN=E.BANFN
                        WHERE
                                BADAT LIKE '$seldate%' 
                                AND BSART IN ($pobah)
                    )
                ) A
                INNER JOIN (
                        SELECT 'a' as BD, total_pr_barang, total_value_barang FROM (
                            SELECT
                                Count( * ) AS total_pr_barang,
                                SUM(PREIS) AS total_value_barang 
                            FROM 
                                TB_EBAN_TRACKING D INNER JOIN TB_PR_APPROVE E ON D.BANFN=E.BANFN
                            WHERE
                                BADAT LIKE '$seldate%' 
                                AND BSART IN ($pobar)
                        )
                ) B ON B.BD=A.BD
                INNER JOIN (
                        SELECT 'a' as BD, total_pr_jasa, total_value_jasa FROM (
                            SELECT
                                Count( * ) AS total_pr_jasa,
                                SUM(PREIS) AS total_value_jasa 
                            FROM 
                                TB_EBAN_TRACKING D INNER JOIN TB_PR_APPROVE E ON D.BANFN=E.BANFN
                            WHERE
                                BADAT LIKE '$seldate%' 
                                AND BSART IN ($pojas)
                        )
                ) C ON C.BD=B.BD";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_trend_pr_rel($year, $type){
        $sql = "SELECT
                    SUBSTR(BADAT, 0, 6 ) AS month,
                    Count( * ) AS total,
                    SUM(PREIS) AS val 
                FROM 
                    TB_EBAN_TRACKING A INNER JOIN TB_PR_APPROVE B ON A.BANFN=B.BANFN
                WHERE
                    BADAT LIKE '$year%' 
                    AND BSART IN ($type)
                GROUP BY
                    SUBSTR(BADAT, 0, 6 )
                ORDER BY
                    month";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_total_rfq($seldate, $comp){
        $sql = "SELECT Count(*) As total_rfq FROM TB_STR_RFQ WHERE BEDAT LIKE '$seldate%' AND BUKRS IN ('$comp')";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_total_rfq_detail($seldate, $pobah, $pobar, $pojas){
        $sql = "SELECT
		A.total_rfq_bahan,
		B.total_rfq_barang,
		C.total_rfq_jasa
        FROM(
            SELECT 'a' as BD, total_rfq_bahan FROM (
                SELECT
                    Count( * ) AS total_rfq_bahan
                FROM 
                    TB_STR_RFQ
                WHERE
                    BEDAT LIKE '$seldate%' 
                    AND BSART IN ($pobah)
            )
        ) A
        INNER JOIN (
            SELECT 'a' as BD, total_rfq_barang FROM (
                SELECT
                    Count( * ) AS total_rfq_barang
                FROM 
                    TB_STR_RFQ
                WHERE
                    BEDAT LIKE '$seldate%' 
                    AND BSART IN ($pobar)
            )
        ) B ON B.BD=A.BD
        INNER JOIN (
            SELECT 'a' as BD, total_rfq_jasa FROM (
                SELECT
                    Count( * ) AS total_rfq_jasa
                FROM 
                    TB_STR_RFQ
                WHERE
                    BEDAT LIKE '$seldate%' 
                AND BSART IN ($pojas)
            )
        ) C ON C.BD=B.BD";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_trend_rfq($year, $type){
        $sql = "SELECT
                    SUBSTR(BEDAT, 0, 6 ) AS month,
                    Count( * ) AS total
                FROM 
                    TB_STR_RFQ
                WHERE
                    BEDAT LIKE '$year%' 
                    AND BSART IN ($type)
                GROUP BY
                    SUBSTR(BEDAT, 0, 6 )
                ORDER BY
                    month";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_total_po($seldate, $comp){
        $sql = "SELECT Count(*) As total_po, SUM(NETWR) AS total_value FROM TB_STR_PO WHERE BEDAT LIKE '$seldate%' AND BUKRS IN ('$comp')";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_total_po_detail($seldate, $pobah, $pobar, $pojas){
        $sql = "SELECT
                    A.total_po_bahan,
                    A.total_value_bahan,
                    B.total_po_barang,
                    B.total_value_barang,
                    C.total_po_jasa,
                    C.total_value_jasa
                FROM(
                    SELECT 'a' as BD, total_po_bahan, total_value_bahan FROM (
                        SELECT
                            Count( * ) AS total_po_bahan,
                            SUM(NETWR) AS total_value_bahan 
                        FROM 
                            TB_STR_PO
                        WHERE
                            BEDAT LIKE '$seldate%' 
                            AND BSART IN ($pobah)
                    )
                ) A
                INNER JOIN (
                    SELECT 'a' as BD, total_po_barang, total_value_barang FROM (
                        SELECT
                            Count( * ) AS total_po_barang,
                            SUM(NETWR) AS total_value_barang 
                        FROM 
                            TB_STR_PO
                        WHERE
                            BEDAT LIKE '$seldate%' 
                            AND BSART IN ($pobar)
                    )
                ) B ON B.BD=A.BD
                INNER JOIN (
                    SELECT 'a' as BD, total_po_jasa, total_value_jasa FROM (
                        SELECT
                            Count( * ) AS total_po_jasa,
                            SUM(NETWR) AS total_value_jasa 
                        FROM 
                            TB_STR_PO
                        WHERE
                            BEDAT LIKE '$seldate%' 
                            AND BSART IN ($pojas)
                    )
                ) C ON C.BD=B.BD";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_trend_po($year, $type){
        $sql = "SELECT
                    SUBSTR(BEDAT, 0, 6 ) AS month,
                    Count( * ) AS total,
                    SUM(NETWR) AS val 
                FROM 
                    TB_STR_PO
                WHERE
                    BEDAT LIKE '$year%' 
                    AND BSART IN ($type)
                GROUP BY
                    SUBSTR(BEDAT, 0, 6 )
                ORDER BY
                    month";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_total_gr($seldate, $comp){
        $plant = substr($comp, 0, 1);
        $sql = "SELECT Count(*) As total_gr, SUM(DMBTR) AS total_value FROM TB_MKPF_MSEG WHERE WERKS LIKE '$plant%' AND BUDAT LIKE '$seldate%'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_total_gr_detail($seldate, $pobah, $pobar, $pojas){
        $sql = "SELECT
                    A.total_gr_bahan,
                    A.total_value_bahan,
                    B.total_gr_barang,
                    B.total_value_barang,
                    C.total_gr_jasa,
                    C.total_value_jasa
                FROM(
                    SELECT 'a' as BD, total_gr_bahan, total_value_bahan FROM (
                        SELECT
                            Count( * ) AS total_gr_bahan,
                            SUM(DMBTR) AS total_value_bahan 
                        FROM 
                            TB_MKPF_MSEG INNER JOIN TB_STR_PO ON TB_STR_PO.MATNR=TB_MKPF_MSEG.MATNR
                        WHERE
                            TB_MKPF_MSEG.BUDAT LIKE '$seldate%' 
                            AND TB_STR_PO.BSART IN ($pobah)
                    )
                ) A
                INNER JOIN (
                    SELECT 'a' as BD, total_gr_barang, total_value_barang FROM (
                        SELECT
                            Count( * ) AS total_gr_barang,
                            SUM(DMBTR) AS total_value_barang 
                        FROM 
                            TB_MKPF_MSEG INNER JOIN TB_STR_PO ON TB_STR_PO.MATNR=TB_MKPF_MSEG.MATNR
                        WHERE
                            TB_MKPF_MSEG.BUDAT LIKE '$seldate%' 
                            AND TB_STR_PO.BSART IN ($pobar)
                    )
                ) B ON B.BD=A.BD
                INNER JOIN (
                    SELECT 'a' as BD, total_gr_jasa, total_value_jasa FROM (
                        SELECT  
                            Count( * ) AS total_gr_jasa,
                            SUM(DMBTR) AS total_value_jasa 
                        FROM 
                            TB_MKPF_MSEG INNER JOIN TB_STR_PO ON TB_STR_PO.MATNR=TB_MKPF_MSEG.MATNR
                        WHERE
                            TB_MKPF_MSEG.BUDAT LIKE '$seldate%' 
                            AND TB_STR_PO.BSART IN ($pojas)
                    )
                ) C ON C.BD=B.BD";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function get_trend_gr($year, $type){
        $sql = "SELECT
                    SUBSTR(TB_MKPF_MSEG.BUDAT, 0, 6 ) AS month,
                    Count(*) AS total,
                    SUM(DMBTR) AS val 
                FROM
                    TB_MKPF_MSEG INNER JOIN TB_STR_PO ON TB_STR_PO.MATNR=TB_MKPF_MSEG.MATNR
                WHERE
                    TB_MKPF_MSEG.BUDAT LIKE '$year%'
                    AND TB_STR_PO.BSART IN ($type)
                GROUP BY
                    SUBSTR(TB_MKPF_MSEG.BUDAT, 0, 6 )
                ORDER BY
                    month";
        $result = $this->db->query($sql);
        return $result->result();
    }
}