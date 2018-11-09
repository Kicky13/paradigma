<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_material_usage extends CI_Model {

    public function get_coal_usage() {
        header('Access-Control-Allow-Origin:*');
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (strlen($bulan) < 2) {
            $month = '0' . $bulan;
        } else {
            $month = $bulan;
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = '7000';
        }

        $db = $this->load->database('default7', true);
        $query = $db->query("SELECT
                                    TO_NUMBER (TO_CHAR(BUDAT, 'DD')) AS ID,
                                    BUDAT,
                                    MAX (MATNR) AS MATNR,
                                    MAX (MAKTX) AS MAKTX,
                                    MAX (MJAHR) AS MJAHR,
                                    MAX (BUKRS) AS BUKRS,
                                    MAX (WERKS) AS WERKS,
                                    MAX (LGORT) AS LGORT,
                                    SUM (DMBTR) AS DMBTR,
                                    SUM (MENGE) AS MENGE
                            FROM
                                    MATERIAL_USAGE
                            WHERE
                                    MATNR IN (
                                            '112-100-0022',
                                            '112-100-0010',
                                            '112-100-0010',
                                            '109-000008',
                                            '112-100-0009',
                                            '112-100-0009',
                                            '112-100-0011',
                                            '112-100-0012',
                                            '112-100-0014',
                                            '112-100-0013',
                                            '109-000003',
                                            '109-000002',
                                            '109-000004',
                                            '109-000006',
                                            '109-000007',
                                            '109-000001',
                                            '109-000005',
                                            '112-100-0021',
                                            '112-100-0023'
                                    )
                            AND BUKRS = $company
                            AND TO_CHAR (BUDAT, 'YYYY-MM') = '$tahun-$month'
                            GROUP BY
                                    BUDAT
                            ORDER BY
                                    BUDAT");

        foreach ($query->result_array() as $rowID) {
            $ID = $rowID['ID'];
            $BUDAT = $rowID['BUDAT'];
            $MATNR = $rowID['MATNR'];
            $MAKTX = $rowID['MAKTX'];
            $MJAHR = $rowID['MJAHR'];
            $BUKRS = $rowID['BUKRS'];
            $WERKS = $rowID['WERKS'];
            $LGORT = $rowID['LGORT'];
            $DMBTR = $rowID['DMBTR'];
            $MENGE = $rowID['MENGE'];

            if (!empty($ID)) {
                $note[$ID] = array(
                    'BUDAT' => $BUDAT,
                    'MATNR' => $MATNR,
                    'MAKTX' => $MAKTX,
                    'MJAHR' => $MJAHR,
                    'BUKRS' => $BUKRS,
                    'WERKS' => $WERKS,
                    'LGORT' => $LGORT,
                    'DMBTR' => $DMBTR,
                    'MENGE' => $MENGE
                );
            } else {
                $note[1] = array(
                    'BUDAT' => 0,
                    'MATNR' => 0,
                    'MAKTX' => 0,
                    'MJAHR' => 0,
                    'BUKRS' => 0,
                    'WERKS' => 0,
                    'LGORT' => 0,
                    'DMBTR' => 0,
                    'MENGE' => 0
                );
            }
        }

        echo '{"data":' . json_encode($note) . '}';
    }

    public function get_kraft_usage() {
        header('Access-Control-Allow-Origin:*');
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (strlen($bulan) < 2) {
            $month = '0' . $bulan;
        } else {
            $month = $bulan;
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = '7000';
        }

        $db = $this->load->database('default7', true);
        $query = $db->query("SELECT
                                    TO_NUMBER (TO_CHAR(BUDAT, 'DD')) AS ID,
                                    BUDAT,
                                    MAX (MATNR) AS MATNR,
                                    MAX (MAKTX) AS MAKTX,
                                    MAX (MJAHR) AS MJAHR,
                                    MAX (BUKRS) AS BUKRS,
                                    MAX (WERKS) AS WERKS,
                                    MAX (LGORT) AS LGORT,
                                    SUM (DMBTR) AS DMBTR,
                                    SUM (MENGE) AS MENGE
                            FROM
                                    MATERIAL_USAGE
                            WHERE
                                    MATNR IN (
                                            '102-100-0004',
                                            '102-100-0010',
                                            '102-100-2011',
                                            '102-200-0080',
                                            '102-400-0250',
                                            '102-100-2001',
                                            '102-100-2003',
                                            '102-100-2013',
                                            '102-100-2014',
                                            '102-100-2017',
                                            '102-100-2019',
                                            '102-100-2022',
                                            '102-100-2023',
                                            '102-100-2024',
                                            '102-400-0230',
                                            '102-300-0210',
                                            '102-200-0120',
                                            '102-300-0240',
                                            '102-100-2002',
                                            '102-100-2005',
                                            '102-100-2007',
                                            '102-100-2008',
                                            '102-100-2009',
                                            '102-100-2010',
                                            '102-100-2012',
                                            '102-100-2015',
                                            '102-100-2016',
                                            '102-100-0005',
                                            '102-300-0200',
                                            '107-200010',
                                            '102-100-2004',
                                            '102-100-2006',
                                            '102-100-2020',
                                            '102-100-2021',
                                            '102-200-0170',
                                            '102-300-0250',
                                            '102-100-0013',
                                            '102-200-0110',
                                            '102-300-0230',
                                            '107-000009',
                                            '107-000027',
                                            '107-000028',
                                            '107-000029',
                                            '102-300-0220',
                                            '102-100-0002',
                                            '102-100-0003',
                                            '102-100-0025',
                                            '102-100-0030',
                                            '102-100-0040',
                                            '102-400-0260',
                                            '102-100-0001',
                                            '102-200-0100',
                                            '102-200-0130',
                                            '102-200-0150',
                                            '102-200-0160',
                                            '102-400-0220',
                                            '102-400-0240'
                                    )
                            AND BUKRS = $company
                            AND TO_CHAR (BUDAT, 'YYYY-MM') = '$tahun-$month'
                            GROUP BY
                                    BUDAT
                            ORDER BY
                                    BUDAT");

        foreach ($query->result_array() as $rowID) {
            $ID = $rowID['ID'];
            $BUDAT = $rowID['BUDAT'];
            $MATNR = $rowID['MATNR'];
            $MAKTX = $rowID['MAKTX'];
            $MJAHR = $rowID['MJAHR'];
            $BUKRS = $rowID['BUKRS'];
            $WERKS = $rowID['WERKS'];
            $LGORT = $rowID['LGORT'];
            $DMBTR = $rowID['DMBTR'];
            $MENGE = $rowID['MENGE'];

            if (!empty($ID)) {
                $note[$ID] = array(
                    'BUDAT' => $BUDAT,
                    'MATNR' => $MATNR,
                    'MAKTX' => $MAKTX,
                    'MJAHR' => $MJAHR,
                    'BUKRS' => $BUKRS,
                    'WERKS' => $WERKS,
                    'LGORT' => $LGORT,
                    'DMBTR' => $DMBTR,
                    'MENGE' => $MENGE
                );
            } else {
                $note[1] = array(
                    'BUDAT' => 0,
                    'MATNR' => 0,
                    'MAKTX' => 0,
                    'MJAHR' => 0,
                    'BUKRS' => 0,
                    'WERKS' => 0,
                    'LGORT' => 0,
                    'DMBTR' => 0,
                    'MENGE' => 0
                );
            }
        }

        echo '{"data":' . json_encode($note) . '}';
    }

}
